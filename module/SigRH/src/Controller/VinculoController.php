<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\VinculoForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Vinculo;

class VinculoController extends AbstractActionController
{
        /**
         * Object Manager
         */
         private $objectManager;
         
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências no controller
	 */
	public function __construct($entityManager, $objectManager)
	{
		$this->entityManager = $entityManager;
                $this->objectManager = $objectManager;
	}
	
        public function gridModalAction()
	{
                $repo = $this->entityManager->getRepository(Vinculo::class);
                $page = $this->params()->fromQuery('page', 1);
                $matricula = $this->params()->fromQuery('matricula',0);
                $search = $this->params()->fromPost();
                $search['matricula'] = $matricula;
                $paginator = $repo->getPaginator($page,$search);
            
                $view = new ViewModel([
                    'vinculos' => $paginator,
		]);
		return 	$view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromRoute('id', null);
                
                $serviceEmbraorc = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\Embraorc::class);
                $serviceAtividades = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\Atividades::class);
                
		//Cria o formulário
		$form = new VinculoForm($this->objectManager,$serviceEmbraorc);
		$listIdsAtivs = null;
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
                        $dataInicio = $this->params()->fromPost('dataInicio');
                        if ( !empty($dataInicio) ){
                            $dataInicioObj = \DateTime::createFromFormat('Y-m-d',$dataInicio);
                            if ( !empty($dataInicioObj )){
                                $listIdsAtivs=$serviceEmbraorc->getIdsAtividadesComMovimentosPorPeriodo($dataInicioObj->format('Y'));
                            }
                        }
                            
                        if ( empty($listIdsAtivs) )    
                            $listIdsAtivs=$serviceEmbraorc->getIdsAtividadesComMovimentosPorPeriodo(date('Y'));
                        
                        $listAtiv = [""=>"Selecione"] + $serviceAtividades->getListAtividadesParaCombo(0,null,$listIdsAtivs);
                        $form->get("atividade")->setOptions(array('value_options'=>$listAtiv));
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Vinculo::class);
                                $matricula = $this->params()->fromQuery('matricula');
                                $repo->incluir_ou_editar($data, $id, $matricula);
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			}
		} else {
                    $clonar = false;
                    if ( empty($id) ){
                        $id = $this->params()->fromQuery("clonar"); // carregar o formulario com o id passado no clonar
                        $clonar = true;
                    }
                    if ( !empty($id) ){
                        $repo = $this->entityManager->getRepository(Vinculo::class);
                        $row = $repo->find($id);
                        
                        
                        if ( !empty($row)){
                            
                            $dataInicioObj = $row->getDataInicio();
                            if ( !empty($dataInicioObj )){
                                $listIdsAtivs=  $serviceEmbraorc->getIdsAtividadesComMovimentosPorPeriodo($dataInicioObj->format('Y'));
                            }
                            
                            if ( empty($listIdsAtivs) )    
                                $listIdsAtivs=$serviceEmbraorc->getIdsAtividadesComMovimentosPorPeriodo(date('Y'));
                            $listAtiv = [""=>"Selecione"] + $serviceAtividades->getListAtividadesParaCombo(0,null,$listIdsAtivs);
                            $form->get("atividade")->setOptions(array('value_options'=>$listAtiv));
                            
                            $form->setData($row->toArray());
                            
                            $form->get("obrigatorio")->setValue($row->obrigatorio);
                            $form->get("nivel")->setValue($row->nivel->id);
                            $form->get("curso")->setValue($row->curso->id);
                            
//                            $form->get("nivel")->setValue($row->nivel->id);
                            
                            $form->get("tipoContrato")->setValue("$row->tipoContrato"); // setar o valor como string pois senão o valor 0 não é reconhecido
                            $form->get("instituicaoEnsino")->setValue($row->instituicaoEnsino->codInstituicao);
                            
                            if (null != $row->getModalidadeBolsa()) {
                                $form->get("modalidadeBolsa")->setValue($row->getModalidadeBolsa()->getId());
                            }
                            if (null != $row->getInstituicaoFomento()) {
                                $form->get("instituicaoFomento")->setValue($row->getInstituicaoFomento()->getCodInstituicao());
                            }
                            $form->get("orientador")->setValue($row->orientador->matricula);
                            $form->get("tipoVinculo")->setValue($row->tipoVinculo->id);
                            
                            if ( $clonar ){ // limpar alguns campos apos a clonagem
                                $form->get("dataInicio")->setValue("");
                            }
                        }
                        
                    }else {
                        $listIdsAtivs = $serviceEmbraorc->getIdsAtividadesComMovimentosPorPeriodo(date('Y'));
                        $listAtiv = [""=>"Selecione"] + $serviceAtividades->getListAtividadesParaCombo(0,null,$listIdsAtivs);
                        $form->get("atividade")->setOptions(array('value_options'=>$listAtiv));
                    }
                        
                }
                $view = new ViewModel([
				'form' => $form
		]);
		return $view->setTerminal(true);
	}
	
	public function deleteModalAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/vinculo');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
                        $id = (int) $request->getPost('id');
                        $matricula = $this->params()->fromQuery('matricula');
                        $repo = $this->entityManager->getRepository(Vinculo::class);
                        $repo->delete($id,$matricula);
			// Redireciona para a lista de registros cadastrados
                        $modelJson = new \Zend\View\Model\JsonModel();
                        return $modelJson->setVariable('success', 1);		}
                
                $repo = $this->entityManager->getRepository(Vinculo::class);
                $vinculo = $repo->find($id);
                
                $view = new ViewModel([
				'vinculo' => $vinculo,
		]);
		return 	$view->setTerminal(true);
                
	}
}

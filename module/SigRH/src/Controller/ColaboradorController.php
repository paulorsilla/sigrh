<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ColaboradorForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;

class ColaboradorController extends AbstractActionController
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
	
	public function indexAction()
	{
            /* Exemplo de acesso ao serviço 
                $service_atividade = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\Atividades::class);
                $list = $service_atividade->getListAtividades();
                \Zend\Debug\Debug::dump($list);
                die();
             * 
             */
                
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $page = $this->params()->fromQuery('page', 1);

                $search = $this->params()->fromQuery();

//                $search['tipoColaborador'] = 2;
//                $search['ativo'] = 'S';
                
//                $query = $this->params()->fromQuery("nome");
//                if ($query != "") {
//                    $search['query'] = $query;
//                }
                $paginator = $repo->getPaginator($page, $search);
		return new ViewModel([
				'colaboradores' => $paginator,
                                'page' => $page,
                                'nome' => $search['nome'],
                                'ativo' => $search['ativo']
		]);
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
                $page = $this->params()->fromRoute('page', null);
		
                //Cria o formulário
		$form = new ColaboradorForm($this->objectManager);
                $colaborador = new Colaborador();
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Colaborador::class);
                    $colaborador = $repo->find($id);
                }
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {

                    //Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Colaborador::class);
                                $repo->incluir_ou_editar($data, $id);
				return $this->redirect()->toRoute('sig-rh/colaborador', ['action' => 'index']);
			}
		} else {
                    if ( !empty($id)){
                        
                        if ( !empty($colaborador)){
                            $form->setData($colaborador->toArray());

                            $form->get("supervisor")->setValue((null != $colaborador->getSupervisor()) ? $colaborador->getSupervisor() : null);
                            $form->get("tipoColaborador")->setValue((null != $colaborador->getTipoColaborador()) ? $colaborador->getTipoColaborador() : null);
                            $form->get("natural_estado")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural()->getEstado() : null);
                            $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                            $form->get("endereco")->setValue((null != $colaborador->getEndereco()) ? $colaborador->getEndereco() : null);
                            $form->get("grupoSanguineo")->setValue((null != $colaborador->getGrupoSanguineo()) ? $colaborador->getGrupoSanguineo() : null);
                            $form->get("grauInstrucao")->setValue((null != $colaborador->getGrauInstrucao()) ? $colaborador->getGrauInstrucao() : null);
                            $form->get("corPele")->setValue((null != $colaborador->getCorPele()) ? $colaborador->getCorPele() : null);
                            $form->get("estadoCivil")->setValue((null != $colaborador->getEstadoCivil()) ? $colaborador->getEstadoCivil() : null);
                            $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                            $form->get("ctpsUf")->setValue((null != $colaborador->getCtpsUf()) ? $colaborador->getCtpsUf() : null);
                            $form->get("linhaOnibus")->setValue((null != $colaborador->getLinhaOnibus()) ? $colaborador->getLinhaOnibus() : null);

                            $endereco = $colaborador->getEndereco();
//                            \Doctrine\Common\Util\Debug::dump($endereco); die();
                            if ( !empty($endereco) ) { // COLOCAR TODOS OS CAMPOS
                                $form->get("cep")->setValue($endereco->getCep());
                                $form->get("endereco")->setValue($endereco->getEndereco());
                                $form->get("numero")->setValue($endereco->getNumero());
                                $form->get("complemento")->setValue($endereco->getComplemento());
                                $form->get("bairro")->setValue($endereco->getBairro());
                                if (null != $endereco->getCidade()) {
                                    $form->get("cidade")->setValue($endereco->getCidade()->getId());
                                    $form->get("estado")->setValue($endereco->getCidade()->getEstado()->getId());
                                }
                            }
                        }
                    }
                }
		return new ViewModel([
				'form' => $form,
                                'page' => $page,
                                'colaborador' => $colaborador
		]);
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/colaborador');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Colaborador::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/colaborador');
		}
                
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $colaborador = $repo->find($id);

                return new ViewModel([
				'colaborador' => $colaborador,
		]);
		
	}
}

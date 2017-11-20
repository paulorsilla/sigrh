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
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $search['tipoColaborador'] = 2;
                $search['ativo'] = 'S';
                $paginator = $repo->getPaginator($page, $search);
		return new ViewModel([
				'colaboradores' => $paginator,
                                'page' => $page
		]);
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
                $page = $this->params()->fromRoute('page', null);
                error_log("Pagina: ".$page );
		
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
				return $this->redirect()->toRoute('sig-rh/colaborador', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        
                        if ( !empty($colaborador)){
                            $form->setData($colaborador->toArray());
                            
                            if (null != $colaborador->getSupervisor()){
                                $form->get("supervisor")->setValue($colaborador->getSupervisor()->getMatricula());
                            }
                            $form->get("tipoColaborador")->setValue($colaborador->tipoColaborador->id);
                            if (null != $colaborador->getDataAdmissao()) {
                                $form->get("dataAdmissao")->setValue($colaborador->getDataAdmissao()->format('Y-m-d'));
                            }
                            if (null != $colaborador->getDataDesligamento()) {
                                $form->get("dataDesligamento")->setValue($colaborador->getDataDesligamento()->format('Y-m-d'));
                            }
                            if (null != $colaborador->getDataNascimento()) {
                                $form->get("dataNascimento")->setValue($colaborador->getDataNascimento()->format('Y-m-d'));
                            }
                            if (null != $colaborador->getRgDataEmissao()) {
                                $form->get("rgDataEmissao")->setValue($colaborador->getRgDataEmissao()->format('Y-m-d'));
                            }
                            if (null != $colaborador->getCtpsDataExpedicao()) {
                                $form->get("ctpsDataExpedicao")->setValue($colaborador->getCtpsDataExpedicao()->format('Y-m-d'));
                            }
                            if (null != $colaborador->getNatural()) {
                                $form->get("natural_estado")->setValue($colaborador->getNatural()->getEstado()->getId());
                            }
                            $form->get("natural")->setValue($colaborador->getNatural()->getId());
                            $form->get("endereco")->setValue($colaborador->endereco->id);
                            $form->get("grupoSanguineo")->setValue($colaborador->grupoSanguineo->id);
                            $form->get("grauInstrucao")->setValue($colaborador->grauInstrucao->id);
                            $form->get("corPele")->setValue($colaborador->corPele->id);
                            $form->get("estadoCivil")->setValue($colaborador->estadoCivil->id);
                            $form->get("natural")->setValue($colaborador->natural->id);
                            $form->get("ctpsUf")->setValue($colaborador->ctpsUf->id);
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

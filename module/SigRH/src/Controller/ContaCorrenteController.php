<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ContaCorrenteForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\ContaCorrente;
use SigRH\Entity\Colaborador;

class ContaCorrenteController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(ContaCorrente::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page,$search);
            
		return new ViewModel([
			'contasCorrente' => $paginator,
		]);	
	}
	
        public function gridModalAction()
	{
                $matricula = $this->params()->fromQuery('matricula',0);
                $colaborador = $this->entityManager->find(Colaborador::class, $matricula);
            
                $view = new ViewModel([
                        'contasCorrente' => $colaborador->getContasCorrente()
		]);
		return 	$view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new ContaCorrenteForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(ContaCorrente::class);
                                $matricula = $this->params()->fromQuery('matricula');
                                $repo->incluir_ou_editar($data, $id, $matricula);
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(ContaCorrente::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                            $form->get("banco")->setValue($row->banco->id);
                            
                        }
                    }
                }
                $view = new ViewModel([
				'form' => $form
		]);
		return $view->setTerminal(true);
	}
        
        public function deleteModalAction()
        {
		$id = (int) $this->params()->fromRoute('id', null);
                $matricula = $this->params()->fromQuery('matricula');
                
		if ($this->getRequest()->isPost()) {
                    $repo = $this->entityManager->getRepository(ContaCorrente::class);
                    $repo->delete($id, $matricula);
                    $modelJson = new \Zend\View\Model\JsonModel();
                    return $modelJson->setVariable('success', 1);
		}
                
                $repo = $this->entityManager->getRepository(ContaCorrente::class);
                $contaCorrente= $repo->find($id);

                $view = new ViewModel([
				'contaCorrente' => $contaCorrente,
		]);
                return $view->setTerminal(true);
        }
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
                    return $this->redirect()->toRoute('sig-rh/conta-corrente');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(ContaCorrente::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/conta-corrente');
		}
                
                $repo = $this->entityManager->getRepository(ContaCorrente::class);
                $contaCorrente= $repo->find($id);

                return new ViewModel([
				'contaCorrente' => $contaCorrente,
		]);
		
	}
}

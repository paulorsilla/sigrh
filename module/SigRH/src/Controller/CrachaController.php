<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\CrachaForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Cracha;

class CrachaController extends AbstractActionController
{
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências no controller
	 */
	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	public function indexAction()
	{
                $repo = $this->entityManager->getRepository(Cracha::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page,$search);
            
		return new ViewModel([
				'crachas' => $paginator,
		]);	
	}
        
        public function gridModalAction()
	{
                $repo = $this->entityManager->getRepository(Cracha::class);
                $page = $this->params()->fromQuery('page', 1);
                $colaborador = $this->params()->fromQuery('matricula',0);
                $search = $this->params()->fromPost();
                $search['matricula'] = $colaborador;
                $paginator = $repo->getPaginator($page,$search);
            
                $view = new ViewModel([
				'crachas' => $paginator,
		]);
		return 	$view->setTerminal(true);
	}
        
        
        public function grid2ModalAction()
	{
//                $repo = $this->entityManager->getRepository(Cracha::class);
//                $page = $this->params()->fromQuery('page', 1);
                $matricula = $this->params()->fromQuery('matricula', 0);
                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, $matricula);
//                $search = $this->params()->fromPost();
//                $search['matricula'] = $matricula;
//                $paginator = $repo->getPaginator($page,$search);
            
                $view = new ViewModel([
				'crachas' => $colaborador->getCrachas()
		]);
		return 	$view->setTerminal(true);
            
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new CrachaForm();
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Cracha::class);
                                $repo->incluir_ou_editar($data,$id);
				return $this->redirect()->toRoute('sig-rh/cracha', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Cracha::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                        }
                    }
                }
		return new ViewModel([
				'form' => $form
		]);
	}
//	
//	public function deleteAction()
//	{
//		$id = (int) $this->params()->fromRoute('id', 0);
//		if (!$id) {
//			return $this->redirect()->toRoute('sig-rh/cracha');
//		}
//		$request = $this->getRequest();
//			
//		if ($request->isPost()) {
//			$del = $request->getPost('del', 'Não');
//			if ($del == 'Sim') {
//				$id = (int) $request->getPost('id');
//				$repo = $this->entityManager->getRepository(Cracha::class);
//				$repo->delete($id);
//			}
//			// Redireciona para a lista de registros cadastrados
//			return $this->redirect()->toRoute('sig-rh/cracha');
//		}
//                
//                $repo = $this->entityManager->getRepository(Cracha::class);
//                $curso = $repo->find($id);
//
//                return new ViewModel([
//				'cracha' => $cracha,
//		]);
//	}
        
        
        /**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new CrachaForm();
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
                        
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Cracha::class);
                                $matricula = $this->params()->fromQuery('matricula');
                                $repo->incluir_ou_editar($data, $id, $matricula);
                                
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Cracha::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
//                            $form->get("ativo")->setValue("0");
                            $form->setData($row->toArray());
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
                    $repo = $this->entityManager->getRepository(Cracha::class);
                    $repo->delete($id, $matricula);
                    $modelJson = new \Zend\View\Model\JsonModel();
                    return $modelJson->setVariable('success', 1);
		}
                
                $repo = $this->entityManager->getRepository(Cracha::class);
                $cracha= $repo->find($id);

                $view = new ViewModel([
				'cracha' => $cracha,
		]);
                return $view->setTerminal(true);
        }
}

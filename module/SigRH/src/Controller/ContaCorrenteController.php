<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ContaCorrenteForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\ContaCorrente;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

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
                /*
		$queryBuilder = $this->entityManager->createQueryBuilder();
		$queryBuilder->select('b')
					->from(Banco::class, 'b')
					->orderBy('b.banco', 'ASC');
		$query = $queryBuilder->getQuery();
            
		$page = $this->params()->fromQuery('page', 1);
		
                
		$adapter = new DoctrineAdapter(new ORMPaginator($query, false));
		$paginator = new Paginator($adapter);
		$paginator->setDefaultItemCountPerPage(11);
		$paginator->setCurrentPageNumber($page);
		
                 * 
                 */
                $repo = $this->entityManager->getRepository(Banco::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page,$search);
            
		return new ViewModel([
				'bancos' => $paginator,
		]);	
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
                                /*
                                $banco = new Banco();
                                $banco->setBanco($data['banco']);
                                $banco->setCodigo($data['codigo']);
                    		$this->entityManager->persist($banco);
                		$this->entityManager->flush();
                                 * 
                                 */
                                $repo = $this->entityManager->getRepository(ContaCorrente::class);
                                $repo->incluir_ou_editar($data,$id);
                                // alterar para json
				return $this->redirect()->toRoute('sig-rh/banco', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(ContaCorrente::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                        }
                    }
                }
                $view = new ViewModel([
				'form' => $form
		]);
		return $view->setTerminal(true);
	}
	
//	public function editAction()
//	{
//		$form = new BancoForm();
//		$id = $this->params()->fromRoute('id', -1);
//		$saprofita = $this->entityManager->getRepository(Banco::class)->findOneById($id);
//		if ($saprofita == null) {
//			$this->getResponse()->setStatusCode(404);
//			return;
//		}
//		if ($this->getRequest()->isPost()) {
//			$data = $this->params()->fromPost();
//			$form->setData($data);
//			if($form->isValid()) {
//				$data = $form->getData();
//				$this->bancoManager->update($banco, $data);
//				return $this->redirect()->toRoute('application/banco');
//			}
//		} else {
//			$form->bind($banco);
//			$form->get('submit')->setAttribute('value', 'Editar');
//		}
//		return new ViewModel([
//				'form' => $form,
//				'banco' => $banco
//		]);
//	}
//	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/banco');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Banco::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/banco');
		}
                
                $repo = $this->entityManager->getRepository(Banco::class);
                $banco = $repo->find($id);

                return new ViewModel([
				'banco' => $banco,
		]);
		
	}
}

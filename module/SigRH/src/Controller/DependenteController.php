<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\DependenteForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Dependente;
//use SigRH\Entity\Colaborador;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

class DependenteController extends AbstractActionController
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
                $grauParentesco = [1 => "Cônjuge", 2 => "Filho(a)", 3 => "Irmã(o)", 4 => "Pai", 5 => "Mãe", 99 => "Outros"];

                $repo = $this->entityManager->getRepository(Dependente::class);
                $page = $this->params()->fromQuery('page', 1);
                $matricula = $this->params()->fromQuery('matricula',0);
                $search = $this->params()->fromPost();
                $search['matricula'] = $matricula;
                $paginator = $repo->getPaginator($page,$search);
            
                $view = new ViewModel([
				'dependentes' => $paginator,
                                'grauParentesco' => $grauParentesco
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
		$form = new DependenteForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Dependente::class);
                                $matricula = $this->params()->fromQuery('matricula');
                                $repo->incluir_ou_editar($data,$id,$matricula);
                                
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Dependente::class);
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
	
//	public function deleteAction()
//	{
//		$id = (int) $this->params()->fromRoute('id', 0);
//		if (!$id) {
//			return $this->redirect()->toRoute('sig-rh/contaCorrente');
//		}
//		$request = $this->getRequest();
//			
//		if ($request->isPost()) {
//			$del = $request->getPost('del', 'Não');
//			if ($del == 'Sim') {
//				$id = (int) $request->getPost('id');
//				$repo = $this->entityManager->getRepository(ContaCorrente::class);
//				$repo->delete($id);
//			}
//			// Redireciona para a lista de registros cadastrados
//			return $this->redirect()->toRoute('sig-rh/contaCorrente');
//		}
//                
//                $repo = $this->entityManager->getRepository(ContaCorrente::class);
//                $contaCorrente= $repo->find($id);
//
//                return new ViewModel([
//				'contaCorrente' => $contaCorrente,
//		]);
//		
//	}
}

<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use SigRH\Entity\Escala;

class EscalaController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(Escala::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page,$search);
            
		return new ViewModel([
				'escalas' => $paginator,
		]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
//                $id = $this->params()->fromRoute('id', null);
//		//Cria o formulário
//		$form = new LinhaOnibusForm();
//		
//		//Verifica se a requisição utiliza o método POST
//		if ($this->getRequest()->isPost()) {
//			
//			//Recebe os dados via POST
//			$data = $this->params()->fromPost();
//			
//			//Preenche o form com os dados recebidos e o valida
//			$form->setData($data);
//			if ($form->isValid()) {
//				$data = $form->getData();
//                                $repo = $this->entityManager->getRepository(LinhaOnibus::class);
//                                $repo->incluir_ou_editar($data,$id);
//				return $this->redirect()->toRoute('sig-rh/linha-onibus', ['action' => 'save']);
//			}
//		} else {
//                    if ( !empty($id)){
//                        $repo = $this->entityManager->getRepository(LinhaOnibus::class);
//                        $row = $repo->find($id);
//                        if ( !empty($row)){
//                            $form->setData($row->toArray());
//                        }
//                    }
//                }
//		return new ViewModel([
//				'form' => $form
//		]);
	}
	
	public function deleteAction()
	{
//		$id = (int) $this->params()->fromRoute('id', 0);
//		if (!$id) {
//			return $this->redirect()->toRoute('sig-rh/linha-onibus');
//		}
//		$request = $this->getRequest();
//			
//		if ($request->isPost()) {
//			$del = $request->getPost('del', 'Não');
//			if ($del == 'Sim') {
//				$id = (int) $request->getPost('id');
//				$repo = $this->entityManager->getRepository(LinhaOnibus::class);
//				$repo->delete($id);
//			}
//			// Redireciona para a lista de registros cadastrados
//			return $this->redirect()->toRoute('sig-rh/linha-onibus');
//		}
//                
//                $repo = $this->entityManager->getRepository(LinhaOnibus::class);
//                $linhaOnibus = $repo->find($id);
//
//                return new ViewModel([
//				'linhaOnibus' => $linhaOnibus,
//		]);
//		
	}
}

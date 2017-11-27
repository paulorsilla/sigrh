<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\TermoForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Termo;

class TermoController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(Termo::class);
                $page = $this->params()->fromQuery('page', 1);
                $matricula = $this->params()->fromQuery('matricula',0);
                $search = $this->params()->fromPost();
                $search['matricula'] = $matricula;
                $paginator = $repo->getPaginator($page,$search);
            
                $view = new ViewModel([
				'termos' => $paginator,
		]);
		return 	$view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromRoute('id', null);
                $service_atividade = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\Atividades::class);
		//Cria o formulário
		$form = new TermoForm($this->objectManager,$service_atividade);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Termo::class);
                                $estagio = $this->params()->fromQuery('estagio');
                                $repo->incluir_ou_editar($data,$id,$estagio);
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			}
                       // $msgs = $form->getMessages();
                        //\Zend\Debug\Debug::dump($msgs);
                        //die ();
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Termo::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
 
                            $form->get("modalidadeBolsa")->setValue($row->modalidadeBolsa->id);
                            $form->get("instituicao")->setValue($row->instituicao->codInstituicao);
                            $form->get("fundacao")->setValue($row->fundacao->codInstituicao);
                            $form->get("orientador")->setValue($row->orientador->matricula);
                            
                            
                            
                          
                        }
                    }
                }
                $view = new ViewModel([
				'form' => $form
		]);
		return $view->setTerminal(true);
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/termo');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Termo::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/termo');
		}
                
                $repo = $this->entityManager->getRepository(Termo::class);
                $termo= $repo->find($id);

                return new ViewModel([
				'termo' => $termo,
		]);
		
	}
}

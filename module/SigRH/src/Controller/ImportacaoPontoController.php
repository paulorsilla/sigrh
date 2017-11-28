<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Form\ImportacaoPontoForm;
use SigRH\Entity\ImportacaoPonto;

class ImportacaoPontoController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page,$search);
            
		return new ViewModel([
				'importacoesPonto' => $paginator,
		]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);

                //Cria o formulário
		$form = new ImportacaoPontoForm($this->entityManager);

                $user = $this->entityManager->getRepository(\User\Entity\User::class)->findOneByLogin($this->identity());
                $dataAtual = new \DateTime();
                
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
		
                    $post = array_merge($this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray());
                    $form->setData($post);

                    //Recebe os dados via POST
		    //$data = $this->params()->fromPost();
			
		    //Preenche o form com os dados recebidos e o valida
		    //$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                
                                $file = $this->params()->fromFiles('arquivo');
                                
                                $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\FileUpload::class);
                                $serviceImportacao->uploadPonto($file);
                                
                                error_log("USUARIO: ".$user->getNome());
                                
                                $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                                $repo->incluir_ou_editar($data, $user, $id);
				return $this->redirect()->toRoute('sig-rh/importacao-ponto', ['action' => 'save']);
			} else {
                            print_r($form->getMessages());
                            die();
                        }
		} else {
                    $form->get("usuario")->setValue($user);
//                    $form->get("dataImportacao")->setValue($dataAtual->format("Y-m-d"));
                    $form->get("dataServidor")->setValue($dataAtual->format("Y-m-d"));

                    if ( !empty($id)) {
                        $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
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
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/importacao-ponto');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(ImportacaoPonto::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/importacao-ponto');
		}
                
                $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                $importacaoPonto = $repo->find($id);

                return new ViewModel([
				'importacaoPonto' => $importacaoPonto,
		]);
		
	}
}

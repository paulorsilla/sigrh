<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ConvenioForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Convenio;

class ConvenioController extends AbstractActionController
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
                
                $lista_tipo = [1 => "Ensino", 2 => "Fomento"];
                $repo = $this->entityManager->getRepository(Convenio::class);
                return new ViewModel(array(
                        'lista_tipo' => $lista_tipo,
                        'search' => $this->params()->fromQuery("search"), //get no form eu uso -> fromQuery; post no form eu uso -> fromPost; 
                        'tipo' => $this->params()->fromQuery("tipo"), //get no form eu uso -> fromQuery; post no form eu uso -> fromPost; 
			'convenios' => $repo->getPaginator( //logica somente para paginator-- mostrar na grid...
                                $this->params()->fromQuery("page"),
                                array("search"=>$this->params()->fromQuery("search"),
                                      "tipo"=>$this->params()->fromQuery("tipo"),
                                      "data_ini"=>$this->params()->fromQuery("data_ini"),
                                      "data_fim"=>$this->params()->fromQuery("data_fim"),
                                    )
                                ),
                        //pra mostrar os dados na view...                  
                        "data_ini"=>$this->params()->fromQuery("data_ini"),
                        "data_fim"=>$this->params()->fromQuery("data_fim"),
		));

                
	}
        
        
        
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new ConvenioForm($this->entityManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Convenio::class);
                                $repo->incluir_ou_editar($data,$id);
				return $this->redirect()->toRoute('sig-rh/convenio', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Convenio::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                            $form->get("instituicao")->setValue($row->instituicao->codInstituicao);
                            
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
			return $this->redirect()->toRoute('sig-rh/convenio');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Convenio::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/convenio');
		}
                
                $repo = $this->entityManager->getRepository(Convenio::class);
                $convenio = $repo->find($id);

                return new ViewModel([
				'convenio' => $convenio,
		]);
		
	}
}

<?php

namespace SigRH\Controller;
use SigRH\Form\CidadeForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Cidade;


use Zend\Mvc\Controller\AbstractActionController;

class CidadeController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    
    public function __construct($entityManager, $objectManager)	{
		$this->entityManager = $entityManager;
                $this->objectManager = $objectManager;
	}
    
    
    public function indexAction() {
        $repo = $this->entityManager->getRepository(Cidade::class);
        $page = $this->params()->fromQuery('page', 1);
        $search = $this->params()->fromPost();
        $paginator = $repo->getPaginator($page,$search);

        return new ViewModel([
                        'cidades' => $paginator,
        ]);	
    }
    
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new CidadeForm($this->entityManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Cidade::class);
                                $repo->incluir_ou_editar($data,$id);
				return $this->redirect()->toRoute('sig-rh/cidade', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Cidade::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                            
                        $form->get("estado")->setValue($row->estado->id);
                            
                        }
                    }
                }
		return new ViewModel([
				'form' => $form
		]);
	}
    

    public function buscaCidadesAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
        
        if ($request->isPost()) {
            $uf = $this->params()->fromPost('uf');
            $estado = $this->entityManager->find(\SigRH\Entity\Estado::class, $uf);
            if ($estado) {
                $cidades = $this->entityManager->getRepository(\SigRH\Entity\Cidade::class)->findBy(['estado' => $estado], ['cidade' => 'ASC']);
                $cidadesJson = '[';
                
                foreach($cidades as $k => $cidade) {
                    $cidadesJson .= '{"id":'.$cidade->getId().', "cidade":"'.$cidade->getCidade().'"}';
                    if (null != $cidades[$k+1]) {
                        $cidadesJson.= ', ';
                    }
                }
                $cidadesJson .= ']';
                error_log($cidadesJson);

                $response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
                            'cidades' => $cidadesJson,
                            'response' => true)));
            }
        }
        return $response;
    }

}

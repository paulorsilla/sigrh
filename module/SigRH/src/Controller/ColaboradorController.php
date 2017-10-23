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
                $paginator = $repo->getPaginator($page,$search);
		return new ViewModel([
				'colaboradores' => $paginator,
		]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
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
//                            $form->bind($colaborador);
                            $form->setData($colaborador->toArray());
                            $form->get("cidade")->setValue($colaborador->cidade->id);
                            $form->get("endereco")->setValue($colaborador->endereco->id);
                            $form->get("grupoSanguineo")->setValue($colaborador->grupoSanguineo->id);
                            $form->get("grauInstrucao")->setValue($colaborador->grauInstrucao->id);
                            $form->get("corPele")->setValue($colaborador->corPele->id);
                            $form->get("estadoCivil")->setValue($colaborador->estadoCivil->id);
                            $form->get("natural")->setValue($colaborador->natural->id);
                            $form->get("ctpsUf")->setValue($colaborador->ctpsUf->id);
                            
//                            $form->get("dataNascimento")->setValue(\DateTime::createFromFormat ( "d/m/Y",$colaborador->dataNascimento));

//                            $form->get("dataNascimento")->setValue(\Admin\Model\Util::converteDataPhp($colaborador->dataNascimento));
                           
                        }
                    }
                }
		return new ViewModel([
				'form' => $form,
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

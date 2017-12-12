<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Horario;
use SigRH\Form\HorarioForm;


class HorarioController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(Horario::class);
                $page = $this->params()->fromQuery('page', 1);
                $matricula = $this->params()->fromQuery('matricula',0);
                $search = $this->params()->fromPost();
                $search['matricula'] = $matricula;
                $paginator = $repo->getPaginator($page,$search);
                $diasSemana = ['1' => 'Domingo', 
                                '2' => 'Segunda-feira',
                                '3' => 'Terça-feira',
                                '4' => 'Quarta-feira',
                                '5' => 'Quinta-feira',
                                '6' => 'Sexta-feira',
                                '7' => 'Sábado',
                    ];
                $view = new ViewModel([
				'horarios' => $paginator,
                                'diasSemana' => $diasSemana
		]);
		return 	$view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $matricula = $this->params()->fromQuery('matricula',null);
                if ( empty($matricula))
                    die('Matricula em branco');
                
                $repoColaborador = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
                
                $colaborador = $repoColaborador->find($matricula);
                if ( empty($colaborador) )
                    die('Matricula não encontrada');
                 
		//Cria o formulário
		$form = new HorarioForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Horario::class);
                                $matricula = $this->params()->fromQuery('matricula');
                                $repo->incluir_ou_editar($data,$colaborador);
                                // alterar para json
                                $modelJson = new \Zend\View\Model\JsonModel();
				return $modelJson->setVariable('success',1);
			} 
		} else {
                        $dados = array();
                        $campos=array(1=>"escalaDomingo",2=>"escalaSegunda",3=>"escalaTerca",4=>"escalaQuarta",5=>"escalaQuinta",6=>"escalaSexta",7=>"escalaSabado");
                        foreach ( $colaborador->horarios as $horario ) {
                            $dados[ $campos[ $horario->diaSemana ] ] = $horario->escala->id;
                        }
                       // var_dump($dados); die();
                        $form->setData($dados);
                    
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
                    $repo = $this->entityManager->getRepository(Horario::class);
                    $repo->delete($id, $matricula);
                    $modelJson = new \Zend\View\Model\JsonModel();
                    return $modelJson->setVariable('success', 1);
		}
                
                $repo = $this->entityManager->getRepository(Horario::class);
                $horario= $repo->find($id);

                $view = new ViewModel([
				'horario' => $horario,
		]);
                return $view->setTerminal(true);
        }
        
}

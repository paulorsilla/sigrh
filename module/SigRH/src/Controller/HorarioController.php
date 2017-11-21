<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Horario;

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
}

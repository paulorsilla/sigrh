<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Repository\Colaborador as ColaboradorRepo;

class OcorrenciaController extends AbstractActionController
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
	}
        
        public function gerarAction()
        {
            $repoColaborador = new ColaboradorRepo();
            
            //busca estagiarios de graduacao
            $colaboradores = $repoColaborador->findEstagiariosGraduacao();
        }
        
	
}

<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Instituicao;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class InstituicaoController extends AbstractActionController
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
            $queryBuilder = $this->entityManager->createQueryBuilder();
            $queryBuilder->select('i')
                                    ->from(Instituicao::class, 'i')
                                    ->where('i.desPfPj = :tipo')
                                    ->orderBy('i.desRazaoSocial', 'ASC')
                                    ->setParameter('tipo', "Pessoa Jurídica");
            
            $query = $queryBuilder->getQuery();

            $page = $this->params()->fromQuery('page', 1);


            $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(11);
            $paginator->setCurrentPageNumber($page);
            
            return new ViewModel([
                            'instituicoes' => $paginator,
            ]);	
            

	}
	
}

<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\BatidaPonto;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;


class BatidaPontoController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function indexAction() {
        $request = $this->getRequest();
        $paginator = null;
        if ($request->isGet()) {
            $matricula = $this->params()->fromQuery('matricula', null);
            $periodoMovimentacao = $this->params()->fromQuery('periodoMovimentacao');
            $page = $this->params()->fromQuery('page', 1);
            if ( ($matricula != "") && ($periodoMovimentacao != "")) {
                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, $matricula);
                $periodoAux = explode("/", $periodoMovimentacao);
                $mes = $periodoAux[0];
                $ano = $periodoAux[1];
                $dataInicio = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-01");
                $dataTermino = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-31");
                $query = $this->entityManager->getRepository(BatidaPonto::class)->findBatidaByMatricula($matricula, $dataInicio, $dataTermino);
                $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
                $paginator = new Paginator($adapter);
                $paginator->setDefaultItemCountPerPage(25);
                $paginator->setCurrentPageNumber($page);
            }
        }
        return new ViewModel([
            'colaborador' => $colaborador,
            'periodoMovimentacao' => $periodoMovimentacao,
            'batidasPonto' => $paginator
        ]);
    }

//    public function index1Action() {
//        $repo = $this->getEntityManager()->getRepository('Cadcli\Model\Cliente');
//        return new ViewModel(
//                array('search' => $this->params()->fromRoute("search"), 
//                      'clientes' => $repo->getPaginator($this->params()->fromRoute("page"), 
//                        array("search" => $this->params()->fromRoute("search")))));
//    }

}

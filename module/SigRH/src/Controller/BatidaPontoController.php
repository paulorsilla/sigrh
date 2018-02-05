<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\BatidaPonto;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Ocorrencia;
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
                
                $ocorrencias = $this->entityManager->getRepository(Ocorrencia::class)->findOcorrenciaByMatricula($colaborador->getMatricula(), $dataInicio, $dataTermino)->getResult();
                $registroOcorrencias = [];
                foreach($ocorrencias as $ocorrencia) {
                    $registroOcorrencias[$ocorrencia->getDataOcorrencia()->format("Ymd")] = $ocorrencia->getDescricao();
                }
                
            }
        }
        return new ViewModel([
            'colaborador' => $colaborador,
            'periodoMovimentacao' => $periodoMovimentacao,
            'batidasPonto' => $paginator,
            'dataPesquisaInicial' => $dataInicio,
            'registroOcorrencias' => $registroOcorrencias
        ]);
    }
    
    public function folhaPontoAction()
    {
            $request = $this->getRequest();
            $registros = null;
            $dataInicio = null;
            $colaboradores = null;

            if ($request->isGet()) { 
                $periodoReferencia = $this->params()->fromQuery('periodoReferencia');
                if($periodoReferencia != '') {
                    $dataAux = explode("/", $periodoReferencia);
                    if (count($dataAux) == 2) {
                        $mes = $dataAux[0];
                        $ano = $dataAux[1];
                        $dataInicio = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-01");
                        $dataTermino = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-31");
                    }
                    //busca estagiarios 
                    $repoColaborador = $this->entityManager->getRepository(Colaborador::class);
                    $colaboradores = $repoColaborador->getEstagiarios();
                    $registros = [];
                    foreach ($colaboradores as $colaborador) {
                            $batidasPonto = $this->entityManager->getRepository(BatidaPonto::class)->findBatidaByMatricula($colaborador->getMatricula(), $dataInicio, $dataTermino)->getResult();
                            $registros[$colaborador->getMatricula()] = $batidasPonto;
                    }
                    $this->layout ()->setTemplate ( "layout/layout-relatorio" )->setVariable ( "titulo_impressao", "Folha ponto" );
                }
            }
            return new ViewModel([
                'colaboradores' => $colaboradores,
                'registros' => $registros,
                'dataPesquisaInicial' => $dataInicio
            ]);
            
            
            
            
		
//		$this->layout ()->setTemplate ( "layout/layout-relatorio" )->setVariable ( "titulo_impressao", "Folha ponto" );
		
//		$view = new \Zend\View\Model\ViewModel ();
//		$view->setVariable ( 'instrumento', $instrumento );
		
//		// adiciona o arquivo instrumento-juridico-consulta ao head da página
//		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
//		$renderer->headScript ()->appendFile ( '/js/instrumento-juridico-consulta.js' );
//		$renderer->headScript ()->appendFile ( '/js/jquery.ui.widget.js' );
		
//		return $view;
            
            

    }

//    public function index1Action() {
//        $repo = $this->getEntityManager()->getRepository('Cadcli\Model\Cliente');
//        return new ViewModel(
//                array('search' => $this->params()->fromRoute("search"), 
//                      'clientes' => $repo->getPaginator($this->params()->fromRoute("page"), 
//                        array("search" => $this->params()->fromRoute("search")))));
//    }

}

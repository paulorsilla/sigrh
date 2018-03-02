<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;

//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;


class MovimentacaoPontoController extends AbstractActionController {

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
        if ($request->isGet()) {
            $matricula = $this->params()->fromQuery('matricula', null);
            $periodoMovimentacao = $this->params()->fromQuery('periodoMovimentacao');
            
            if ( ($matricula != "") && ($periodoMovimentacao != "")) {
                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, $matricula);
                $periodoAux = explode("/", $periodoMovimentacao);
                $referencia = $periodoAux[1].$periodoAux[0];
                $folhaPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'referencia' => $referencia]);
            }
        }
        return new ViewModel([
            'colaborador' => $colaborador,
            'periodoMovimentacao' => $periodoMovimentacao,
            'folhaPonto' => $folhaPonto,
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

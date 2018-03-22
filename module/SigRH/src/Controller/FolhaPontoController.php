<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\FolhaPonto;
use SigRH\Entity\RegistroHorario;
use SigRH\Entity\Ocorrencia;
use SigRH\Entity\Feriado;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class FolhaPontoController extends AbstractActionController
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
            $request = $this->getRequest();
            $paginator = null;
            $stringReferencia = null;
            $meses = ['1' => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            $search['referencia'] = null;

            if ($request->isGet()) {
                $referencia = $this->params()->fromQuery('referencia');
                $page = $this->params()->fromQuery('page', 1);
            
                if ($referencia != "") {
                    $periodoAux = explode("/", $referencia);
                    $search['referencia'] = $periodoAux[1].$periodoAux[0];
                    $stringReferencia = $meses[(int)$periodoAux[0]]."/".$periodoAux[1];

                    $repo = $this->entityManager->getRepository(FolhaPonto::class);
                    $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
                    $paginator = new Paginator($adapter);
                    $paginator->setDefaultItemCountPerPage(10);
                    $paginator->setCurrentPageNumber($page);
                }
            }
            return new ViewModel([
                    'folhasPonto' => $paginator,
                    'referencia' => $search['referencia'],
                    'stringReferencia' => $stringReferencia,
                    'page' => $page
            ]);	
	}
        
        public function processarAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $page = $this->params()->fromRoute('page');

            if ($id == '0') {
                //processa todas as folhas ponto do período de referência
                $folhasPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->getQuery(['referencia' => $referencia])->getQuery()->getResult();
            } else {
                //processa apenas a folha selecionada
                $folhasPonto[0] = $this->entityManager->find(\SigRH\Entity\FolhaPonto::class, $id);
            }
            
            $tolerancia = 10; //tempo de tolerancia de adiantamento ou atraso em minutos
            $repoRegistroHorario = $this->entityManager->getRepository(RegistroHorario::class);
            $repoOcorrencia = $this->entityManager->getRepository(Ocorrencia::class);
            
            foreach($folhasPonto as $folhaPonto) {
                $colaborador = $folhaPonto->getColaboradorMatricula();
                $vinculo = $colaborador->getVinculos()->last();
                $horarioFlexivel = $vinculo->getHorarioFlexivel();
                
                //remover
//                error_log("Processando a folha de: ".$colaborador->getNome());
                
                //movimentacao ponto
                foreach($folhaPonto->getMovimentacaoPonto() as $movimentacaoPonto) {
                    $dataPonto = \DateTime::createFromFormat("Ymd", $referencia.$movimentacaoPonto->getDiaPonto());
                    $dataPonto->setTime(0,0);
                    $diaSemana = $dataPonto->format("w");
                    $feriado = $this->entityManager->getRepository(Feriado::class)->findOneBy(['dataFeriado' => $dataPonto]);
                    $expediente = true;
                    if ($feriado) {
                        $expediente = $feriado->getExpediente();
                    }

                    //busca a escala do colaborador para a data
                    $escala = null;
                    foreach ($colaborador->getHorarios() as $horarioEscala) {
                        if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                            $escala = $horarioEscala->getEscala();
                            break;
                        }
                    }
                    
                    //cálculo da carga horária em minutos, com base na escala do dia
                    $cargaHorariaP1 = ((null != $escala) && (null != $escala->getSaida1()) && (null != $escala->getEntrada1())) ? $escala->getEntrada1()->diff($escala->getSaida1()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaP2 = ((null != $escala) && (null != $escala->getSaida2()) && (null != $escala->getEntrada2())) ? $escala->getEntrada2()->diff($escala->getSaida2()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaMinutos = (($cargaHorariaP1->h * 60) + $cargaHorariaP1->i) + (($cargaHorariaP2->h * 60) + $cargaHorariaP2->i);

                    //remover
//                    error_log("Dia: ".$movimentacaoPonto->getDiaPonto() ." -- carga horaria: ".floor($cargaHorariaMinutos/60).":".($cargaHorariaMinutos%60)." hs.");

                    if ($escala != null) {
                        $registrosEsperados = ["E1" => "", "S1" => ""];
                        $intervaloMinutos = ["E1" => null, "S1" => null];

                        if (null != $escala->getEntrada2()) {
                            $registrosEsperados = ["E2" => "", "S2" => ""];
                            $intervaloMinutos = ["E2" => null, "S2" => null];
                        }

                        //Marcação automática do intervalo
                        if ( (count($movimentacaoPonto->getRegistros()) == 2) && (null != $escala->getEntrada2())) {
                            $repoRegistroHorario->marcacao_intervalo($movimentacaoPonto, $escala);
                            $this->entityManager->refresh($movimentacaoPonto);
                        }
                    }
                    
                    $registrosEsperados = ["E1" => "", "S1" => ""];
                    $intervaloMinutos = ["E1" => null, "S1" => null];

                    if ( (null != $escala) && (null != $escala->getEntrada2()) ) {
                        $registrosEsperados = ["E2" => "", "S2" => ""];
                        $intervaloMinutos = ["E2" => null, "S2" => null];
                    }
                    if ( (count($movimentacaoPonto->getRegistros()) <= 1) && ($cargaHorariaMinutos != 0) && ($expediente) && (!$horarioFlexivel) ) {
                            $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Omissão de ponto.");
                    } else { 
                        //registros de ponto realizados na data 
                        foreach($movimentacaoPonto->getRegistros() as $k => $registro) {
                            $lancarOcorrencia = false;

                            //remover
//                            error_log("Registro: ".$registro->getHoraRegistro()->format("H:i"));

                            if(null != $escala) {
                                $intervaloE1 = $escala->getEntrada1()->diff($registro->getHoraRegistro());
                                $intervaloS1 = $escala->getSaida1()->diff($registro->getHoraRegistro());
                                $intervaloMinutos["E1"] = ($intervaloE1->h * 60) + $intervaloE1->i;
                                $intervaloMinutos["S1"] = ($intervaloS1->h * 60) + $intervaloS1->i;

                                if (null != $escala->getEntrada2())  {
                                    $intervaloE2 = $escala->getEntrada2()->diff($registro->getHoraRegistro());
                                    $intervaloS2 = $escala->getSaida2()->diff($registro->getHoraRegistro());
                                    $intervaloMinutos["E2"] = $intervaloE2->h * 60 + $intervaloE2->i;
                                    $intervaloMinutos["S2"] = $intervaloS2->h * 60 + $intervaloS2->i;
                                }

                                asort($intervaloMinutos);
                                $ajuste = key($intervaloMinutos);
                                if ( ($ajuste != "E1") && (!isset($registrosEsperados["E1"])) ) {
                                    $ajuste = "E1";
                                }
                                if ( ($k == 3) && ($ajuste != "S2")) {
                                    $ajuste = "S2";
                                }
                                $registrosEsperados[$ajuste] = $registro;

                                if ($ajuste == "E1") {
                                    if ($intervaloMinutos["E1"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        if ($intervaloE1->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Entrada (E1) antecipada fora da tolerância.";
                                            $saldoMinutos += $intervaloMinutos["E1"];
                                        } else {
                                            $descricaoOcorrencia = "-Entrada (E1) com atraso fora da tolerância.";
                                            $saldoMinutos -= $intervaloMinutos["E1"];
                                        }
                                    }
                                } else if ($ajuste == "S1") {
                                    if ($intervaloMinutos["S1"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        if ($intervaloS1->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Saída (S1) antecipada fora da tolerância.";
                                            $saldoMinutos -= $intervaloMinutos["S1"];
                                        } else {
                                            $descricaoOcorrencia = "-Saída (S1) com atraso fora tolerância.";
                                            $saldoMinutos += $intervaloMinutos["S1"];
                                        }
                                    }
                                } else if ($ajuste == "E2") {
                                    if ($intervaloMinutos["E2"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        if ($intervaloE2->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Entrada (E2) antecipada fora da tolerância.";
                                            $saldoMinutos += $intervaloMinutos["E2"];
                                        } else {
                                            $descricaoOcorrencia = "-Entrada (E2) com atraso fora da tolerância.";
                                            $saldoMinutos -= $intervaloMinutos["E2"];
                                        }
                                    }
                                } else if ($ajuste == "S2") {
                                    if ($intervaloMinutos["S2"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        if ($intervaloS2->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Saída (S2) antecipada fora da tolerância.";
                                            $saldoMinutos -= $intervaloMinutos["S2"];
                                        } else {
                                            $descricaoOcorrencia = "-Saída (S2) com atraso fora da tolerância.";
                                            $saldoMinutos += $intervaloMinutos["S2"];
                                        }
                                    }
                                }
                                if ( ($lancarOcorrencia) && (!$horarioFlexivel) ) {
                                    $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, $descricaoOcorrencia);
                                }
                            } else if (!$horarioFlexivel) {
                                    $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Registro em dia fora da escala.");
                            }
                        }
                    }
                    
                }
                //muda o status da folha para aguardando justificativas
                if(!$horarioFlexivel) {
                    $folhaPonto->setStatus(1);
                } else {
                //muda o status da folha para finalizada, caso o aluno possua horário flexível
                    $folhaPonto->setStatus(2);
                }
                $this->entityManager->persist($folhaPonto);
                $this->entityManager->flush();
                
            }
            return $this->redirect()->toUrl('/sig-rh/folha-ponto?referencia='.substr($referencia, 4, 2)."/".substr($referencia, 0, 4).'&page='.$page);
        }
        
        public function registrosAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $page = $this->params()->fromRoute('page');
            if ($id != '') {
                $folhaPonto = $this->entityManager->find(FolhaPonto::class, $id);
                $feriados = $this->entityManager->getRepository(\SigRH\Entity\Feriado::class)->getFeriadoReferencia($folhaPonto->getReferencia());
                $feriadosPeriodo = [];
                foreach($feriados as $feriado) {
                    $feriadosPeriodo[$feriado->getDataFeriado()->format('d')] = $feriado;
                }
            }
            return new ViewModel([
                'folhaPonto' => $folhaPonto,
                'feriadosPeriodo' => $feriadosPeriodo,
                'referencia' => $referencia,
                'page' => $page
            ]);

        }
}

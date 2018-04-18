<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\FolhaPonto;
use SigRH\Entity\RegistroHorario;
use SigRH\Entity\Ocorrencia;
use SigRH\Entity\Feriado;
use SigRH\Entity\Escala;

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
            $search['nome'] = null;

            if ($request->isGet()) {
                $referencia = $this->params()->fromQuery('referencia');
                $nome = $this->params()->fromQuery('nome');
                $page = $this->params()->fromQuery('page', 1);
            
                if ($referencia != "") {
                    $mes = null;
                    $ano = null;
                    if (strlen($referencia) == 7) {
                        $periodoAux = explode("/", $referencia);
                        $mes = (int) $periodoAux[0];
                        $ano = (int) $periodoAux[1];
                        $search['referencia'] = $periodoAux[1].$periodoAux[0];
                    } else {
                        $search['referencia'] = $referencia;
                        $mes = (int) substr($referencia, 4, 2);
                        $ano = (int) substr($referencia, 0, 4);
                    }
                    $stringReferencia = $meses[$mes]."/".$ano;
                    $search['nome'] = $nome;
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
                    'nome' => $search['nome'],
                    'stringReferencia' => $stringReferencia,
                    'page' => $page
            ]);	
	}
        
        public function processarAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $nome = $this->params()->fromRoute('nomePesquisa');
            $page = $this->params()->fromRoute('page');

            if ($id == '0') {
                //processa todas as folhas ponto do período de referência
                $folhasPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->getQuery(['referencia' => $referencia, 'processamentoGeral' => '1'])->getQuery()->getResult();
            } else {
                //processa apenas a folha selecionada
                $folhasPonto[0] = $this->entityManager->find(\SigRH\Entity\FolhaPonto::class, $id);
            }
            
            $tolerancia = 10; //tempo de tolerancia de adiantamento ou atraso em minutos
            $repoRegistroHorario = $this->entityManager->getRepository(RegistroHorario::class);
            $repoOcorrencia = $this->entityManager->getRepository(Ocorrencia::class);
            
            foreach($folhasPonto as $folhaPonto) {
                $colaborador = $folhaPonto->getColaboradorMatricula();
                error_log("Colaborador: ".$colaborador->getNome());
                $vinculo = $colaborador->getVinculos()->first();
                $horarioFlexivel = $vinculo->getHorarioFlexivel();
                
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
                    $escala = new \SigRH\Entity\Escala();
                    foreach ($colaborador->getHorarios() as $horarioEscala) {
                        if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                            $escala->setEntrada1($horarioEscala->getEscala()->getEntrada1());
                            $escala->setEntrada2($horarioEscala->getEscala()->getEntrada2());
                            $escala->setSaida1($horarioEscala->getEscala()->getSaida1());
                            $escala->setSaida2($horarioEscala->getEscala()->getSaida2());
                            break;
                        }
                    }
                    
                    //cálculo da carga horária em minutos, com base na escala do dia
                    $cargaHorariaP1 = ((null != $escala) && (null != $escala->getSaida1()) && (null != $escala->getEntrada1())) ? $escala->getEntrada1()->diff($escala->getSaida1()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaP2 = ((null != $escala) && (null != $escala->getSaida2()) && (null != $escala->getEntrada2())) ? $escala->getEntrada2()->diff($escala->getSaida2()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaMinutos = (($cargaHorariaP1->h * 60) + $cargaHorariaP1->i) + (($cargaHorariaP2->h * 60) + $cargaHorariaP2->i);

                    //Marcação automática do intervalo
                    if ( (null != $escala) && (count($movimentacaoPonto->getRegistros()) == 2) && (null != $escala->getEntrada2()) &&
                         ($movimentacaoPonto->getRegistros()->first()->getHoraRegistro() < $escala->getSaida1()) && 
                         ($movimentacaoPonto->getRegistros()->last()->getHoraRegistro()) > $escala->getEntrada2() ) {
                        $repoRegistroHorario->marcacao_intervalo($movimentacaoPonto, $escala);
                        $this->entityManager->refresh($movimentacaoPonto);
                    }
                    
                    $calcularMinutos = false;
                    $considerarMinutos = true;
                    $saldoMinutos = 0;

                    //ocorrencias (caso existam)
                    foreach($movimentacaoPonto->getOcorrencias() as $ocorrencia) {
                        if ( (null != $ocorrencia->getJustificativa1()) && (!$ocorrencia->getJustificativa1()->getConsiderarHoras())) {
                            $considerarMinutos = false;
                        }
                        if ( (null != $ocorrencia->getJustificativa2()) && (!$ocorrencia->getJustificativa2()->getConsiderarHoras())) {
                            $considerarMinutos = false;
                        }
                    }
                    
                    //localiza omissão de ponto
                    if ( (count($movimentacaoPonto->getRegistros()) <= 1) && ($cargaHorariaMinutos != 0) && ($expediente) && (!$horarioFlexivel) ) {
                            $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Omissão de ponto.");
                            $saldoMinutos = $considerarMinutos ?  (-1 * $cargaHorariaMinutos) : 0;
                    } else {
                        //verifica se houve registro fora da escala e cria uma 
                        //escala temporária para computar o período realizado
                        
                        if ( (null != $escala)  && (null == $escala->getEntrada2()) && (count($movimentacaoPonto->getRegistros()) >= 4) ) {
//                            error_log("Dia: ".$movimentacaoPonto->getDiaPonto());

                            $calcularIntervaloP1 = false;
                            $calcularIntervaloP2 = false;

                            //saída 1 até as 13:00hs configura escala normal no
                            //período matutino

                            error_log($movimentacaoPonto->getDiaPonto());
                            
                            $refEscala = \DateTime::createFromFormat("YmdHi", "197001011300");
                            $verificaTurno = $refEscala->diff($escala->getSaida1());
                            
                            
                            if ($verificaTurno->format("%R") == "-") {
                                //escala normal no periodo matutino 
                                
                                //cria novos valores para E2 e S2 
                                $escalaE2 = \DateTime::createFromFormat("YmdHi", "19700101".$escala->getSaida1()->format("Hi"));
                                $escalaE2->add(new \DateInterval('PT1H'));
                                $escalaS2 = \DateTime::createFromFormat("YmdHi", "19700101".$escalaE2->format("Hi"));
                                $escalaS2->add($cargaHorariaP1);
                                $escala->setEntrada2($escalaE2);
                                $escala->setSaida2($escalaS2);
                            } else {
                                //escala normal no período vespertino
                                
                                //cria uma escala temporária com novos valores 
                                //para E1 e S1, deslocando E1 para E2 e S1 para S2
                                
                                $escalaS1 = \DateTime::createFromFormat("YmdHi", "19700101".$escala->getEntrada1()->format("Hi"));
                                $escalaS1->sub(new \DateInterval('PT1H'));
                                $escalaE1 = \DateTime::createFromFormat("YmdHi", "19700101".$escalaS1->format("Hi"));
                                $escalaE1->sub($cargaHorariaP1);
                                $escala->setEntrada2($escala->getEntrada1());
                                $escala->setSaida2($escala->getSaida1());
                                $escala->setEntrada1($escalaE1);
                                $escala->setSaida1($escalaS1);
                            }
                            //dobra o valor da carga horaria para o dia
                            $cargaHorariaMinutos += $cargaHorariaMinutos;
                            $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Registro fora de escala.");
                            
                        }
                        $registrosEsperados = ["E1" => "", "S1" => ""];
                        $intervaloMinutos = ["E1" => null, "S1" => null];

                        if ( (null != $escala) && (null != $escala->getEntrada2()) ) {
                            $registrosEsperados = ["E2" => "", "S2" => ""];
                            $intervaloMinutos = ["E2" => null, "S2" => null];
                        }

                        //registros de ponto realizados na data 
                        foreach($movimentacaoPonto->getRegistros() as $k => $registro) {
                            $lancarOcorrencia = false;

                            if(null != $escala) {
                                if (null != $escala->getEntrada1()) { 
                                    $intervaloE1 = $escala->getEntrada1()->diff($registro->getHoraRegistro());
                                    $intervaloS1 = $escala->getSaida1()->diff($registro->getHoraRegistro());
                                    $intervaloMinutos["E1"] = ($intervaloE1->h * 60) + $intervaloE1->i;
                                    $intervaloMinutos["S1"] = ($intervaloS1->h * 60) + $intervaloS1->i;
                                }
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
                                if ( ($k == 2) && ($ajuste != "E2") && (isset($registrosEsperados["E2"]))) {
                                    $ajuste = "E2";
                                }

                                if ( ($k == 3) && ($ajuste != "S2") && (isset($registrosEsperados["S2"]))) {
                                    $ajuste = "S2";
                                }
                                $registrosEsperados[$ajuste] = $registro;
                                
                                if ($ajuste == "E1") {
                                    if ($intervaloMinutos["E1"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        $calcularIntervaloP1 = true;
                                        if ($intervaloE1->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Entrada (E1) antecipada fora da tolerância.";
                                        } else {
                                            $descricaoOcorrencia = "-Entrada (E1) com atraso fora da tolerância.";
                                        }
                                    }
                                } else if ($ajuste == "S1") {
                                    if ($intervaloMinutos["S1"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        $calcularIntervaloP1 = true;
                                        if ($intervaloS1->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Saída (S1) antecipada fora da tolerância.";
                                        } else {
                                            $descricaoOcorrencia = "-Saída (S1) com atraso fora da tolerância.";
                                        }
                                    }
                                } else if ($ajuste == "E2") {
                                    if ($intervaloMinutos["E2"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        $calcularIntervaloP2 = true;
                                        if ($intervaloE2->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Entrada (E2) antecipada fora da tolerância.";
                                        } else {
                                            $descricaoOcorrencia = "-Entrada (E2) com atraso fora da tolerância.";
                                        }
                                    }
                                } else if ($ajuste == "S2") {
                                    if ($intervaloMinutos["S2"] > $tolerancia) {
                                        $lancarOcorrencia = true;
                                        $calcularIntervaloP2 = true;
                                        if ($intervaloS2->format("%R") == "-") {
                                            $descricaoOcorrencia = "-Saída (S2) antecipada fora da tolerância.";
                                        } else {
                                            $descricaoOcorrencia = "-Saída (S2) com atraso fora da tolerância.";
                                        }
                                    }
                                }
                                if ( ($lancarOcorrencia) && (!$horarioFlexivel) ) {
                                    $calcularMinutos = true;
                                    $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, $descricaoOcorrencia);
                                }
                            } else if (!$horarioFlexivel) {
                                    $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Registro em dia fora da escala.");
                            }
                        }
                        if ($calcularMinutos) {
                            if ( (isset($registrosEsperados['E1'])) && ($registrosEsperados['E1'] != "") && (isset($registrosEsperados['S1'])) && ($registrosEsperados['S1'] != "") ) {
                                if($calcularIntervaloP1) {
                                    $intervaloP1 = $registrosEsperados['S1']->getHoraRegistro()->diff($registrosEsperados['E1']->getHoraRegistro());
                                    $saldoMinutos = ($intervaloP1->h * 60) + ($intervaloP1->i);
                                } else {
                                    $saldoMinutos = ($cargaHorariaP1->h * 60) + $cargaHorariaP1->i;
                                }
                            }
                            if ( (isset($registrosEsperados['E2'])) && ($registrosEsperados['E2'] != "") && (isset($registrosEsperados['S2'])) && ($registrosEsperados['S2'] != "") ) {
                                if($calcularIntervaloP2) {
                                    $intervalo2 = $registrosEsperados['S2']->getHoraRegistro()->diff($registrosEsperados['E2']->getHoraRegistro());
                                    $saldoMinutos += ($intervalo2->h * 60) + ($intervalo2->i);
                                } else {
                                    $saldoMinutos += ($cargaHorariaP2->h * 60) + $cargaHorariaP2->i;
                                }
                            }
 //                           $saldoMinutos = $considerarMinutos ?  (-1 * $cargaHorariaMinutos) : 0;
                        } else {
                            $saldoMinutos = $cargaHorariaMinutos;
                        }
                    }
                    //grava o saldo em minutos calculado para o dia
                    $movimentacaoPonto->setSaldoMinutos($saldoMinutos);
                    $this->entityManager->persist($movimentacaoPonto);
                }
                $this->entityManager->flush();
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
            return $this->redirect()->toUrl('/sig-rh/folha-ponto?nome='.$nome.'&referencia='.substr($referencia, 4, 2)."/".substr($referencia, 0, 4).'&page='.$page);
        }
        
        public function registrosAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $nome = $this->params()->fromRoute('nomePesquisa');
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
                'nome' => $nome,
                'page' => $page
            ]);

        }
}

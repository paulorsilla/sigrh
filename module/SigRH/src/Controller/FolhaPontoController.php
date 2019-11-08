<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\FolhaPonto;
use SigRH\Entity\RegistroHorario;
use SigRH\Entity\Ocorrencia;
use SigRH\Entity\Feriado;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Vinculo;
use SigRH\Entity\ConstantesMes;

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
            $search['orientador'] = null;
            $search['instituicaoFomento'] = null;
            $search['status'] = '';

            if ($request->isGet()) {
                $referencia = $this->params()->fromQuery('referencia');
                $status = $this->params()->fromQuery('status');
                $orientador = $this->params()->fromQuery('orientador');
                $nome = str_replace("_", " ", $this->params()->fromQuery('nome'));
                $instituicaoFomento = $this->params()->fromQuery('instituicaoFomento');
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
                    $search['orientador'] = $orientador;
                    $search['status'] = $status;
                    $search['instituicaoFomento'] = $instituicaoFomento;
                    $repo = $this->entityManager->getRepository(FolhaPonto::class);
                    $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
                    $paginator = new Paginator($adapter);
                    $paginator->setDefaultItemCountPerPage(10);
                    $paginator->setCurrentPageNumber($page);
                }
            }
            $repoVinculo = $this->entityManager->getRepository(Vinculo::class);

            return new ViewModel([
                'folhasPonto' => $paginator,
                'referencia' => $search['referencia'],
                'nome' => $search['nome'],
                'orientador' => $search['orientador'],
                'stringReferencia' => $stringReferencia,
                'status' => $search['status'],
                'instituicaoFomento' => $search['instituicaoFomento'],
                'page' => $page,
                'repoVinculo' => $repoVinculo
            ]);	
	}
        
        public function estudanteAction()
        {
            $meses = ['1' => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            $colaborador = null;
            if ($this->identity() != null) {
                $colaborador = $this->entityManager->getRepository(Colaborador::class)->findOneByLoginLocal($this->identity()['login']);
//               $colaborador = $this->entityManager->getRepository(Colaborador::class)->findOneByMatricula('502479');
            }
            
            $search['colaborador'] = $colaborador;
//            $page = $this->params()->fromQuery('page', 1);
            
            $repo = $this->entityManager->getRepository(FolhaPonto::class);
            $folhasPonto = $repo->getQuery($search)->getQuery()->getResult();

//            $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
//            $paginator = new Paginator($adapter);
//            $paginator->setDefaultItemCountPerPage(10);
//            $paginator->setCurrentPageNumber($page);
            
            return new ViewModel([
                'colaborador' => $colaborador,
                'meses' => $meses,
                'folhasPonto' => $folhasPonto
//                'folhasPonto' => $paginator
            ]);
        }
        
        public function processarAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $nome = $this->params()->fromRoute('nomePesquisa');
            $page = $this->params()->fromRoute('page');
            $restrito = $this->params()->fromRoute('restrito');

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
            $repoVinculo = $this->entityManager->getRepository(Vinculo::class);
            
            foreach($folhasPonto as $folhaPonto) {
                $colaborador = $folhaPonto->getColaboradorMatricula();

                //saldo mensal da folha 
                $saldoMinutosTotal = 0;
                $pendencias = false;

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

                    $vinculo = $repoVinculo->buscar_vinculo_por_referencia($colaborador->getMatricula(), $referencia, $dataPonto);
                    
                    if (null != $vinculo) {
                        $horarioFlexivel = $vinculo->getHorarioFlexivel();
                        
                        //busca a escala do colaborador para a data
                        $escala = new \SigRH\Entity\Escala();
                        $possuiEscala = false;
                        foreach ($vinculo->getHorarios() as $horarioEscala) {
                            if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                                $escala->setEntrada1($horarioEscala->getEscala()->getEntrada1());
                                $escala->setEntrada2($horarioEscala->getEscala()->getEntrada2());
                                $escala->setSaida1($horarioEscala->getEscala()->getSaida1());
                                $escala->setSaida2($horarioEscala->getEscala()->getSaida2());
                                $possuiEscala = true;
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
                        $considerarPeriodo = true;
                        $saldoMinutos = 0;

                        //ocorrencias (caso existam)
                        foreach($movimentacaoPonto->getOcorrencias() as $ocorrencia) {
                            if ( (null != $ocorrencia->getJustificativa1()) && (!$ocorrencia->getJustificativa1()->getConsiderarHoras())) {
                                $considerarPeriodo = false;
                            } else {
                                $calcularMinutos = true;
                            }
                            if ( (null != $ocorrencia->getJustificativa2()) && (!$ocorrencia->getJustificativa2()->getConsiderarHoras())) {
                                $considerarPeriodo = false;
                            } else {
                                $calcularMinutos = true;
                            }
                        }
                        
                        //Recesso Obrigatorio - verifica se a data em questão faz parte
                        //do período de recesso do estudante
                        $recesso = $this->entityManager->getRepository(\SigRH\Entity\RecessoObrigatorio::class)->getQuery(["dataPonto" => $dataPonto, "vinculo" => $vinculo])->getQuery()->getResult();
                        if ($recesso) {
                            $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Recesso obrigatório.", True);
                        }

                        //localiza omissão de ponto
                        if ( (count($movimentacaoPonto->getRegistros()) <= 1) && ($cargaHorariaMinutos != 0) && ($expediente) && (!$horarioFlexivel) && (!$recesso) ){
                            $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Omissão de ponto.");
                            $saldoMinutos = $considerarPeriodo ?  (-1 * $cargaHorariaMinutos) : 0;
                        } else {
                            $calcularIntervaloP1 = false;
                            $calcularIntervaloP2 = false;

                            //verifica se houve registro fora da escala e cria uma 
                            //escala temporária para computar o período realizado
                            if ( (null != $escala) && (null != $escala->getEntrada1()) && (null == $escala->getEntrada2()) && (count($movimentacaoPonto->getRegistros()) >= 4) ) {

                                //saída 1 até as 13:00hs configura escala normal no
                                //período matutino
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
                                $calcularIntervaloP1 = true;
                                $calcularIntervaloP2 = true;

                            }
                            $registrosEsperados = ["E1" => "", "S1" => ""];
                            $intervaloMinutos = ["E1" => null, "S1" => null];

                            if ( (null != $escala) && (null != $escala->getEntrada2()) ) {
                                $registrosEsperados = ["E2" => "", "S2" => ""];
                                $intervaloMinutos = ["E2" => null, "S2" => null];
                            }
                            $ocorrenciaDia = false;
                            error_log("DIA PONTO =>".$movimentacaoPonto->getDiaPonto());

                            //registros de ponto realizados na data 
                            foreach($movimentacaoPonto->getRegistros() as $k => $registro) {

                                $lancarOcorrencia = false;

//                                if(null != $escala) {
                                if($possuiEscala) {
                                    if (null != $escala->getEntrada1()) { 
                                        $intervaloE1 = $escala->getEntrada1()->diff($registro->getHoraRegistro());
                                        $intervaloS1 = $escala->getSaida1()->diff($registro->getHoraRegistro());
                                        $intervaloMinutos["E1"] = ($intervaloE1->h * 60) + $intervaloE1->i;
                                        $intervaloMinutos["S1"] = ($intervaloS1->h * 60) + $intervaloS1->i;
                                    }
                                    if (null != $escala->getEntrada2()) {
                                        $intervaloE2 = $escala->getEntrada2()->diff($registro->getHoraRegistro());
                                        $intervaloS2 = $escala->getSaida2()->diff($registro->getHoraRegistro());
                                        $intervaloMinutos["E2"] = $intervaloE2->h * 60 + $intervaloE2->i;
                                        $intervaloMinutos["S2"] = $intervaloS2->h * 60 + $intervaloS2->i;
                                    }
                                } else {
                                    $lancarOcorrencia = true;
                                    $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Registro em dia fora da escala.");
                                    $calcularIntervaloP1 = true;
                                    $calcularIntervaloP2 = true;
                                }

                                asort($intervaloMinutos);
                                $ajuste = key($intervaloMinutos);
                                if ( ($ajuste != "E1") && (!isset($registrosEsperados["E1"])) ) {
                                    $ajuste = "E1";
                                }
                                if ( ($k == 1) && (count($movimentacaoPonto->getRegistros()) == 2) && ($ajuste != "S1")) {
                                    $ajuste = "S1";
                                }
                                if ( ($k == 2) && ($ajuste != "E2") && (isset($registrosEsperados["E2"]))) {
                                    $ajuste = "E2";
                                }

                                if ( ($k == 3) && ($ajuste != "S2") && (isset($registrosEsperados["S2"]))) {
                                    $ajuste = "S2";
                                }

                                if ( ($ajuste == 'E1') && (isset($registrosEsperados['E1'])) && ($registrosEsperados['E1'] != "") ) {
                                    $ajuste = 'S1';
                                }

                                if ( ($k == 0) && $ajuste == 'S1') {
                                    $ajuste = "E1";
                                }

                                $registrosEsperados[$ajuste] = $registro;

                                if (!$horarioFlexivel) {
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
                                    if ( $lancarOcorrencia )  {
                                        $calcularMinutos = true;
                                        $ocorrenciaDia = true;
                                        error_log("ocorrencia dia ".$descricaoOcorrencia);
                                        $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, $descricaoOcorrencia);
                                    }
                                } else {
                                    $calcularMinutos = true;
                                    $calcularIntervaloP1 = true;
                                    $calcularIntervaloP2 = true;
                                    $repoOcorrencia->excluir($movimentacaoPonto);
                                }
                            }
                            
                            if (!$ocorrenciaDia) {
                                $repoOcorrencia->excluir($movimentacaoPonto);
                                error_log("limpando ocorrencias");
                            }
                            
                            if ( (null != $escala->getEntrada2()) && ($registrosEsperados["E2"] == "") && (!$horarioFlexivel) && ($expediente) && (!$recesso)) {
                                $calcularMinutos = true;
                                $repoOcorrencia->incluir_ou_editar($movimentacaoPonto, "-Omissão de ponto.");
                            }
                            
                            if ($calcularMinutos) {
                                if ( (isset($registrosEsperados['E1'])) && ($registrosEsperados['E1'] != "") && (isset($registrosEsperados['S1'])) && ($registrosEsperados['S1'] != "") ) {
                                    if($calcularIntervaloP1) {
                                        $intervaloP1 = $registrosEsperados['S1']->getHoraRegistro()->diff($registrosEsperados['E1']->getHoraRegistro());
                                        $saldoMinutos = ($intervaloP1->h * 60) + ($intervaloP1->i);
                                        $calcularIntervaloP2 = true;
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
                            } else if (!$horarioFlexivel && !$recesso && $expediente) {
                                $repoOcorrencia->excluir($movimentacaoPonto);
                                $saldoMinutos = $cargaHorariaMinutos;
                            } else {
                                $saldoMinutos = 0;
                            }
                        }
                        if ($saldoMinutos > 0) { //considerar apenas minutos realizados
                            $saldoMinutosTotal += $saldoMinutos;
                        }

                        //grava o saldo em minutos calculado para o dia
                        $movimentacaoPonto->setSaldoMinutos($saldoMinutos);
                        $this->entityManager->persist($movimentacaoPonto);
                        
                        //verifica se existem ocorrencias nao justificadas, ao fim do processamento do dia
                        if (!$pendencias) {
                            foreach($movimentacaoPonto->getOcorrencias() as $ocorrenciaAux) {
                                if ( (null == $ocorrenciaAux->getJustificativa1()) && (null == $ocorrenciaAux->getJustificativa2())) {
                                    $pendencias = true;
                                }
                            }
                        }
                    }
                    $this->entityManager->flush();
                    
                    //muda o status da folha para aguardando justificativas
                    if(!$horarioFlexivel && $pendencias) {
                        $folhaPonto->setStatus(1);
                    } else {
                    //muda o status da folha para finalizada, caso o aluno possua horário flexível ou não existam mais pendencias
                        $folhaPonto->setStatus(2);
                    }
                    $folhaPonto->setSaldoMinutos($saldoMinutosTotal);
                    $this->entityManager->persist($folhaPonto);
                    $this->entityManager->flush();
                }
            }
            if ($restrito) {
                return $this->redirect()->toUrl('/sig-rh/folha-ponto/estudante?page='.$page);
            } else {
                return $this->redirect()->toUrl('/sig-rh/folha-ponto?nome='.$nome.'&referencia='.substr($referencia, 4, 2)."/".substr($referencia, 0, 4).'&page='.$page);
            }
        }
        
        public function registrosAction()
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $nome = $this->params()->fromRoute('nomePesquisa');
            $page = $this->params()->fromRoute('page');
            $restrito = $this->params()->fromRoute('restrito');
            $constantesMes = $this->entityManager->find(ConstantesMes::class, $referencia);
            
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
                'page' => $page,
                'restrito' => $restrito,
                'constantesMes' =>$constantesMes
            ]);
        }
        
        public function impressaoAction() 
        {
            $id = $this->params()->fromRoute('id');
            $referencia = $this->params()->fromRoute('referencia');
            $usuario = null;
            if ($this->identity() != null) {
                $usuario = $this->entityManager->getRepository(Colaborador::class)->findOneByLoginLocal($this->identity()['login']);
            }

            if ($id == '0') {
                //imprime todas as folhas ponto do período de referência
                $folhasPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->getQuery(['referencia' => $referencia, 'processamentoGeral' => '1'])->getQuery()->getResult();
            } else {
                //imprime apenas a folha selecionada
                $folhasPonto[0] = $this->entityManager->find(\SigRH\Entity\FolhaPonto::class, $id);
            }
            $feriados = $this->entityManager->getRepository(\SigRH\Entity\Feriado::class)->getFeriadoReferencia($referencia);
            $feriadosPeriodo = [];
            foreach($feriados as $feriado) {
                $feriadosPeriodo[$feriado->getDataFeriado()->format('d')] = $feriado;
            }
            
            $repoVinculo = $this->entityManager->getRepository(Vinculo::class);
            $constantesMes = $this->entityManager->find(ConstantesMes::class, $referencia);
            $this->layout ()->setTemplate ( "layout/layout-relatorio" )->setVariable ( "titulo_impressao", "Folha ponto" );
            return new ViewModel([
                'folhasPonto' => $folhasPonto,
                'feriadosPeriodo' => $feriadosPeriodo,
                'repoVinculo' => $repoVinculo,
                'constantesMes' => $constantesMes,
                'usuario' => $usuario
            ]);
        }
        
        public function excluiduplicidadeAction() 
        {
//            $referencia = $this->params()->fromRoute('referencia');
            $referencia = "201808";

            $folhasPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->getQuery(['referencia' => $referencia, 'processamentoGeral' => '1'])->getQuery()->getResult();
            foreach ($folhasPonto as $folha) {
                foreach($folha->getMovimentacaoPonto() as $movimentacao) {
                    $registros = $movimentacao->getRegistros();
                    for($i = 0; $i < count($registros); $i++) {
                        for($j = $i+1; $j < count($registros); $j++) {
                            if ($registros[$i]->getHoraRegistro() == $registros[$j]->getHoraRegistro()) {
                                $this->entityManager->remove($registros[$i]);
                                break;
                            }
                        }
                    }
                }
            }
            $this->entityManager->flush();
            return $this->redirect()->toUrl('/sig-rh/folha-ponto');
        }
        
        public function excluireferenciaAction()
        {
            $referencia = "201912";
            $folhasPonto = $this->entityManager->getRepository(\SigRH\Entity\FolhaPonto::class)->getQuery(['referencia' => $referencia])->getQuery()->getResult();
            error_log("Processando ".count($folhasPonto)." folhas ponto");
            foreach ($folhasPonto as $folha) {
                foreach($folha->getMovimentacaoPonto() as $movimentacao) {
                    $registros = $movimentacao->getRegistros();
                    $ocorrencias = $movimentacao->getOcorrencias();
                    
                    foreach($registros as $registro) {
                        $this->entityManager->remove($registro);
                    }
                    $this->entityManager->flush();
                    
                    foreach($ocorrencias as $ocorrencia) {
                        $this->entityManager->remove($ocorrencia);
                    }
                    $this->entityManager->flush();
                    $this->entityManager->remove($movimentacao);
                }
                $this->entityManager->flush();
                $this->entityManager->remove($folha);
            }
            $this->entityManager->flush();

            error_log("fim");
        }
        
        public function justificativageralAction() 
        {
//            $referencia = $this->params()->fromRoute('referencia');
            $referencia = "201812";
            $dia = "14";
            $justificativaId = 12;
            $justificativa = $this->entityManager->find(\SigRH\Entity\Justificativa::class, $justificativaId);
            $movimentacoesPonto = $this->entityManager->getRepository(\SigRH\Entity\MovimentacaoPonto::class)->getQuery(['referencia' => $referencia, 'dia' => $dia])->getQuery()->getResult();
            
            foreach($movimentacoesPonto as $movimentacaoPonto) {
                foreach($movimentacaoPonto->getOcorrencias() as $ocorrencia) {
                    if($ocorrencia->getDescricao() != '-Recesso obrigatório.') {
                        error_log($justificativa->getDescricao());
                        $ocorrencia->setJustificativa1($justificativa);
                        $this->entityManager->persist($ocorrencia);
                    }
                }
            }
            $this->entityManager->flush();
            return $this->redirect()->toUrl('/sig-rh/folha-ponto');
        }
        
        public function ajustaregistrosAction() 
        {
//            $referencia = $this->params()->fromRoute('referencia');
            $matricula = "503629";
            $registros = $this->entityManager->getRepository(\SigRH\Entity\RegistroHorario::class)->getQuery(['matricula' => $matricula])->getQuery()->getResult();
            $horaCorte = \DateTime::createFromFormat( "H:i", "15:00");

            foreach($registros as $registro) {
                error_log($registro->getHoraRegistro()->format("H:i"));
                $registro->setHoraRegistro($horaCorte);
                $this->entityManager->persist($registro);
                $this->entityManager->flush();
            }
//            $this->entityManager->flush();
            return $this->redirect()->toUrl('/sig-rh/folha-ponto');
        }



        
}

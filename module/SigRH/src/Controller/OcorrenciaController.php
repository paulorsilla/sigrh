<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Ocorrencia;
use SigRH\Entity\BatidaPonto;

class OcorrenciaController extends AbstractActionController {

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
        
    }

    public function gerarAction() {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $dataInicio = $this->params()->fromQuery('dataInicio');
            $dataTermino = $this->params()->fromQuery('dataTermino');

            if (($dataInicio != "") && ($dataTermino != "")) {

                $dataPesquisaInicial = \DateTime::createFromFormat("Y-m-d", $dataInicio);
                $dataPesquisaFinal = \DateTime::createFromFormat("Y-m-d", $dataTermino);
                $dataPesquisaFinal->setTime(0, 0);
                $dataPesquisaFinal->setTime(0, 0);

                $repoColaborador = $this->entityManager->getRepository(Colaborador::class);

                //busca estagiarios de graduacao
                $colaboradores = $repoColaborador->getEstagiarios(true);

//                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, '503361');
                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, '503337');

//                    foreach($colaboradores as $colaborador) {
                $dataPesquisa = $dataPesquisaInicial;
                $tolerancia = 10; //tempo de tolerancia em minutos 

                error_log("COLABORADOR: " . $colaborador->getMatricula() . " - " . $colaborador->getNome());

                $repo = $this->entityManager->getRepository(Ocorrencia::class);
                $repoBatidaPonto = $this->entityManager->getRepository(BatidaPonto::class);

                while ((int) $dataPesquisa->format('Ymd') <= (int) $dataPesquisaFinal->format('Ymd')) {
                    $diaSemana = $dataPesquisa->format("w");

                    error_log("Data: " . $dataPesquisa->format("d-m-Y"));

                    //busca a escala de horarios do colaborador
                    $escala = null;
                    foreach ($colaborador->getHorarios() as $horarioEscala) {
                        if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                            $escala = $horarioEscala->getEscala();
                            break;
                        }
                    }
                    
                    $cargaHorariaP1 = ((null != $escala) && (null != $escala->getSaida1()) && (null != $escala->getEntrada1())) ? $escala->getEntrada1()->diff($escala->getSaida1()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaP2 = ((null != $escala) && (null != $escala->getSaida2()) && (null != $escala->getEntrada2())) ? $escala->getEntrada1()->diff($escala->getSaida2()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaMinutos = ($cargaHorariaP1->h * 60) + $cargaHorariaP1->i + ($cargaHorariaP2->h * 60) + $cargaHorariaP2->i;

                    //busca os registros na catraca para o dia em questão
//                    $batidaPonto = $this->entityManager->getRepository(\SigRH\Entity\BatidaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);
                    $batidaPonto = $repoBatidaPonto->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);
                    
                    if ($batidaPonto && $escala) {
                        if ( (count($batidaPonto->getHorarios()) == 2) && (null != $escala->getEntrada2())) {
                            $repoBatidaPonto->marcacao_intervalo($batidaPonto, $escala);
                        }
                        
                        $registrosEsperados = ["E1" => null, "S1" => null];
                        $intervaloMinutos = ["E1" => null, "S1" => null];
                        
                        if (null != $escala->getEntrada2()) {
                            $registrosEsperados = ["E2" => null, "S2" => null];
                            $intervaloMinutos = ["E2" => null, "S2" => null];
                        }
                        
                        foreach ($batidaPonto->getHorarios() as  $horario) {
                            $intervaloE1 = $escala->getEntrada1()->diff($horario->getHoraBatida());
                            $intervaloS1 = $escala->getSaida1()->diff($horario->getHoraBatida());

                            $intervaloMinutos["E1"] = ($intervaloE1->h * 60) + $intervaloE1->i;
                            $intervaloMinutos["S1"] = ($intervaloS1->h * 60) + $intervaloS1->i;

                            if(null != $escala->getEntrada2()) {
                                
                                $intervaloE2 = $escala->getEntrada2()->diff($horario->getHoraBatida());
                                $intervaloS2 = $escala->getSaida2()->diff($horario->getHoraBatida());
                            
                                $intervaloMinutos["E2"] = $intervaloE2->h * 60 + $intervaloE2->i;
                                $intervaloMinutos["S2"] = $intervaloS2->h * 60 + $intervaloS2->i;

                            }
                            
                            asort($intervaloMinutos);
                            $registro = key($intervaloMinutos);
                            if ( ($registro != "E1") && ($registrosEsperados["E1"] == null) ) {
                                $registro = "E1";
                            }
                            
                            $registrosEsperados[$registro] = $horario;
                            error_log($registro." => ".$registrosEsperados[$registro]->getHoraBatida()->format("H:i"));
                            
                            if($registro == "E1") {
                                if ($intervaloMinutos["E1"] > $tolerancia) {
                                    if ($intervaloE1->format("%R") == "-") {
                                        error_log("Entrada antecipada fora da tolerancia");
                                    } else {
                                        error_log("Entrada com atraso fora da tolerancia");
                                    }
                                }
                            } else if ($registro == "S1") {
                                if ($intervaloMinutos["S1"] > $tolerancia) {
                                    if ($intervaloS1->format("%R") == "-") {
                                        error_log("Saida antecipada fora da tolerancia");
                                    } else {
                                        error_log("Saida com atraso fora da tolerancia");
                                    }
                                }
                            } else if ($registro == "E2") {
                                if ($intervaloMinutos["E2"] > $tolerancia) {
                                    if ($intervaloE2->format("%R") == "-") {
                                        error_log("Entrada antecipada fora da tolerancia");
                                    } else {
                                        error_log("Entrada com atraso fora da tolerancia");
                                    }
                                }
                            } else if ($registro == "S2") {
                                if ($intervaloMinutos["S2"] > $tolerancia) {
                                    if ($intervaloS2->format("%R") == "-") {
                                        error_log("Saida antecipada fora da tolerancia");
                                    } else {
                                        error_log("Saida com atraso fora da tolerancia");
                                    }
                                }
                            }
                        }
                    } else if ($escala != null && $batidaPonto == null) {
                       // $repo->incluir_ou_editar($colaborador, $dataPesquisa, null, 'Omissão de ponto - dia todo.', null);
                    }
                    $dataPesquisa->add(new \DateInterval('P1D'));
                }

//                    }//foreach colaboradores
                return $this->redirect()->toRoute('sig-rh/ocorrencia', ['action' => 'index']);
            }
        }
        return new ViewModel();
    }

}

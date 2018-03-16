<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Ocorrencia;
use SigRH\Entity\BatidaPonto;
use SigRH\Form\OcorrenciaForm;

class OcorrenciaController extends AbstractActionController {
    
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
    public function indexAction() {
        
    }

    public function saveModalAction() {
        
        $id = $this->params()->fromRoute('id', null);
        
        //Cria o formulário
        $form = new OcorrenciaForm($this->objectManager);
        $movimentacaoPonto = null;
        $dataPonto = null;
        $escala = null;

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(Ocorrencia::class);
//                $repo->incluir_ou_editar($data, $id, $matricula);
                // alterar para json
                $modelJson = new \Zend\View\Model\JsonModel();
                return $modelJson->setVariable('success', 1);
            }
        } else {
            if (!empty($id)) {
                $repo = $this->entityManager->getRepository(Ocorrencia::class);
                $ocorrencia = $repo->find($id);
                if (!empty($ocorrencia)) {
                    $movimentacaoPonto = $ocorrencia->getMovimentacaoPonto();
                    $dataPonto = \DateTime::createFromFormat("Ymd", $movimentacaoPonto->getFolhaPonto()->getReferencia().$movimentacaoPonto->getDiaPonto());
                    
                    $diaSemana = $dataPonto->format("w");

                    //busca a escala de horarios do colaborador
                    $escala = null;
                    foreach ($movimentacaoPonto->getFolhaPonto()->getColaboradorMatricula()->getHorarios() as $horarioEscala) {
                        if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                            $escala = $horarioEscala->getEscala();
                            break;
                        }
                    }
                    
                    $form->setData($ocorrencia->toArray());
                    $form->get("descricao")->setValue($ocorrencia->getDescricao());
                    if (null != $ocorrencia->getJustificativa()) {
                        $form->get("justificativa")->setValue($ocorrencia->getJustificativa()->getId());
                    }
                    $registros = $movimentacaoPonto->getRegistros();
                    if(null != $registros) {
                        $form->get("entrada1")->setValue(null != $registros[0] ? $registros[0]->getHoraRegistro()->format("H:i") : "");
                        $form->get("saida1")->setValue(null != $registros[1] ? $registros[1]->getHoraRegistro()->format("H:i") : "");
                        $form->get("entrada2")->setValue(null != $registros[2] ? $registros[2]->getHoraRegistro()->format("H:i") : "");
                        $form->get("saida2")->setValue(null != $registros[3] ? $registros[3]->getHoraRegistro()->format("H:i") : "");
                    }
                }
            }
        }
        $view = new ViewModel([
            'form' => $form,
            'movimentacaoPonto' => $movimentacaoPonto,
            'dataPonto' => $dataPonto,
            'escala' => $escala
        ]);
        return $view->setTerminal(true);
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
                    $lancarOcorrencia = false;
                    $descricaoOcorrencia = "";
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
                    $cargaHorariaP2 = ((null != $escala) && (null != $escala->getSaida2()) && (null != $escala->getEntrada2())) ? $escala->getEntrada2()->diff($escala->getSaida2()) : \DateInterval::createFromDateString("0:0");
                    $cargaHorariaMinutos = (($cargaHorariaP1->h * 60) + $cargaHorariaP1->i) + (($cargaHorariaP2->h * 60) + $cargaHorariaP2->i);
                    $saldoMinutos = 0;

                    //busca os registros na catraca para o dia em questão
//                    $batidaPonto = $this->entityManager->getRepository(\SigRH\Entity\BatidaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);
                    $batidaPonto = $repoBatidaPonto->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);

                    if ($batidaPonto && $escala) {

                        if ((count($batidaPonto->getHorarios()) == 2) && (null != $escala->getEntrada2())) {
                            $repoBatidaPonto->marcacao_intervalo($batidaPonto, $escala);
                        }

                        $registrosEsperados = ["E1" => "", "S1" => ""];
                        $intervaloMinutos = ["E1" => null, "S1" => null];

                        if (null != $escala->getEntrada2()) {
                            $registrosEsperados = ["E2" => "", "S2" => ""];
                            $intervaloMinutos = ["E2" => null, "S2" => null];
                        }

                        foreach ($batidaPonto->getHorarios() as $k => $horario) {
                            $intervaloE1 = $escala->getEntrada1()->diff($horario->getHoraBatida());
                            $intervaloS1 = $escala->getSaida1()->diff($horario->getHoraBatida());
                            $intervaloMinutos["E1"] = ($intervaloE1->h * 60) + $intervaloE1->i;
                            $intervaloMinutos["S1"] = ($intervaloS1->h * 60) + $intervaloS1->i;

                            if (null != $escala->getEntrada2()) {
                                $intervaloE2 = $escala->getEntrada2()->diff($horario->getHoraBatida());
                                $intervaloS2 = $escala->getSaida2()->diff($horario->getHoraBatida());
                                $intervaloMinutos["E2"] = $intervaloE2->h * 60 + $intervaloE2->i;
                                $intervaloMinutos["S2"] = $intervaloS2->h * 60 + $intervaloS2->i;
                            }

                            asort($intervaloMinutos);
                            $registro = key($intervaloMinutos);
                            if (($registro != "E1") && ($registrosEsperados["E1"] == "")) {
                                $registro = "E1";
                            }
                            if (($k == 3) && ($registro != "S2")) {
                                $registro = "S2";
                            }

                            $registrosEsperados[$registro] = $horario;
                            error_log($registro . " => " . $registrosEsperados[$registro]->getHoraBatida()->format("H:i"));

                            if ($registro == "E1") {
                                if ($intervaloMinutos["E1"] > $tolerancia) {
                                    $lancarOcorrencia = true;
                                    if ($intervaloE1->format("%R") == "-") {
                                        $descricaoOcorrencia = "Entrada (E1) antecipada fora da tolerância.";
                                        $saldoMinutos += $intervaloMinutos["E1"];
                                    } else {
                                        $descricaoOcorrencia = "Entrada (E1) com atraso fora da tolerância.";
                                        $saldoMinutos -= $intervaloMinutos["E1"];
                                    }
                                }
                            } else if ($registro == "S1") {
                                if ($intervaloMinutos["S1"] > $tolerancia) {
                                    $lancarOcorrencia = true;
                                    if ($intervaloS1->format("%R") == "-") {
                                        $descricaoOcorrencia = "Saída (S1) antecipada fora da tolerância.";
                                        $saldoMinutos -= $intervaloMinutos["S1"];
                                    } else {
                                        $descricaoOcorrencia = "Saída (S1) com atraso fora tolerância.";
                                        $saldoMinutos += $intervaloMinutos["S1"];
                                    }
                                }
                            } else if ($registro == "E2") {
                                if ($intervaloMinutos["E2"] > $tolerancia) {
                                    $lancarOcorrencia = true;
                                    if ($intervaloE2->format("%R") == "-") {
                                        $descricaoOcorrencia = "Entrada (E2) antecipada fora da tolerância";
                                        $saldoMinutos += $intervaloMinutos["E2"];
                                    } else {
                                        $descricaoOcorrencia = "Entrada (E2) com atraso fora da tolerância.";
                                        $saldoMinutos -= $intervaloMinutos["E2"];
                                    }
                                }
                            } else if ($registro == "S2") {
                                if ($intervaloMinutos["S2"] > $tolerancia) {
                                    $lancarOcorrencia = true;
                                    if ($intervaloS2->format("%R") == "-") {
                                        $descricaoOcorrencia = "Saída (S2) antecipada fora da tolerância.";
                                        $saldoMinutos -= $intervaloMinutos["S2"];
                                    } else {
                                        $descricaoOcorrencia = "Saída (S2) com atraso fora da tolerância.";
                                        $saldoMinutos += $intervaloMinutos["S2"];
                                    }
                                }
                            }
                        }
                    } else if ($escala != null && $batidaPonto == null) {
//                        error_log("Omissao de ponto - dia todo");
                        $lancarOcorrencia = true;
                        $descricaoOcorrencia = "Omissão de ponto (dia todo).";
                        $saldoMinutos = $saldoMinutos - $cargaHorariaMinutos;
                    }
                    if ($lancarOcorrencia) {
                        $ocorrencia = $repo->findOneBy(['colaboradorMatricula' => $colaborador, 'dataOcorrencia' => $dataPesquisa]);
                        $repo->incluir_ou_editar($colaborador, $dataPesquisa, $batidaPonto, $descricaoOcorrencia, $ocorrencia, $saldoMinutos);
                        error_log("Saldo em minutos " . $saldoMinutos);
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

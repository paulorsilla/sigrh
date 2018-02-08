<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Ocorrencia;

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

                $colaborador = $this->entityManager->find(\SigRH\Entity\Colaborador::class, '503361');

//                    foreach($colaboradores as $colaborador) {
                $dataPesquisa = $dataPesquisaInicial;

                error_log("COLABORADOR: " . $colaborador->getMatricula() . " - " . $colaborador->getNome());

                $repo = $this->entityManager->getRepository(Ocorrencia::class);

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

                    //busca os registros na catraca para o dia em questão
                    $batidaPonto = $this->entityManager->getRepository(\SigRH\Entity\BatidaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);
                    if ($batidaPonto && $escala) {
                        foreach ($batidaPonto->getHorarios() as $k => $horario) {
                            
                            $intervaloE1 = $escala->getEntrada1()->diff($horario->getHoraBatida());
                            $intervaloS1 = $escala->getSaida1()->diff($horario->getHoraBatida());

                            $intervaloMinutosE1 = $intervaloE1->days * 24 * 60;
                            $intervaloMinutosE1 += $intervaloE1->h * 60;
                            $intervaloMinutosE1 += $intervaloE1->i;


                            $intervaloMinutosS1 = $intervaloS1->days * 24 * 60;
                            $intervaloMinutosS1 += $intervaloS1->h * 60;
                            $intervaloMinutosS1 += $intervaloS1->i;
                            
                            
//                            error_log("E1 --> ".$intervaloE1->format("%R%H%I"));
//                            error_log("S1 --> ".$intervaloS1->format("%R%H%I"));

                            if ( $intervaloMinutosE1 < $intervaloMinutosS1) {
                                error_log("Entrada 1 - Registrou: ".$horario->getHoraBatida()->format("H:i"). " Escala: ".$escala->getEntrada1()->format("H:i"). " Diferenca: ".$intervaloMinutosE1);
//                                if ((int) $intervaloE1->format("%R%H%I") < -5 ) {
//                                    error_log("Adiantamento fora da tolerancia");
//                                }
//                                else if ((int) $intervaloE1->format("%R%H%I") > 5 ) {
//                                    error_log("Atraso fora da tolerancia");
//                                }
                                
                            } else {
                                error_log("Saida 1 - Registrou: ".$horario->getHoraBatida()->format("H:i"). " Escala: ".$escala->getSaida1()->format("H:i"). "Diferenca: ".$intervaloMinutosS1);
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

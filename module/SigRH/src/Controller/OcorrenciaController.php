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

            if ( ($dataInicio != "") && ($dataTermino != "") ) {

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
                
                while ( (int) $dataPesquisa->format('Ymd') <= (int) $dataPesquisaFinal->format('Ymd')) {
                    $diaSemana = $dataPesquisa->format("w");
                    
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
                    if ($batidaPonto) {
                        foreach ($batidaPonto->getHorarios() as $k => $horario) {
                            error_log("Horario: " . $horario->getHoraBatida()->format("H:i"));
                        }
                    } else if ($escala != null) {
                        $repo->incluir_ou_editar($colaborador, $dataPesquisa, null, 'Omissão de ponto - dia todo.', null);
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

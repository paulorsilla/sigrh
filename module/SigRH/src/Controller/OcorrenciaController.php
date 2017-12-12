<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
class OcorrenciaController extends AbstractActionController
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
	}
        
        public function gerarAction()
        {
            $request = $this->getRequest();
            if ($request->isGet()) { 
                $dataPesquisaInicial = null;
                $periodoReferencia = $this->params()->fromQuery('periodoReferencia');
                $dataAux = explode("/", $periodoReferencia);
                $erros = [];
                if (count($dataAux) == 2) {
                    $mes = $dataAux[0];
                    $ano = $dataAux[1];
                    $dataPesquisaInicial = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-01");
                    $erros = \DateTime::getLastErrors();
                }
                
                if (($dataPesquisaInicial != null) && (empty($erros['warning_count']))) {
                    $repoColaborador = $this->entityManager->getRepository(Colaborador::class);
                    
                    //busca estagiarios de graduacao
                    $colaboradores = $repoColaborador->getEstagiarios(true);

                    $colaborador = $this->entityManager->find(SigRH\Entity\Colaborador::class, '503361');
//                    foreach($colaboradores as $colaborador) {
                        $dataPesquisa = \DateTime::createFromFormat("Y-m-d", $ano."-".$mes."-01");
                        
                        error_log("COLABORADOR: ".$colaborador->getMatricula()." - ".$colaborador->getNome());
                        
                        while($dataPesquisa->format("m") == $mes) {
                            $diaSemana = $dataPesquisa->format("w");
                            if ( ($diaSemana != 0 ) && ($diaSemana != 6) ) { //não verifica no final de semana (domingo e sábado)
                                error_log("DATA ".$dataPesquisa->format("d-m-Y"));
                                
                                //busca a escala de horarios do colaborador
                                $escala = null;
                                foreach($colaborador->getHorarios() as $horarioEscala) {
                                    if($horarioEscala->getDiaSemana() == $diaSemana+1) {
                                        $escala = $horarioEscala->getEscala();
                                        break;
                                    }
                                }

                                if (null != $escala) {
                                    //busca os registros na catraca para o dia em questão
                                    $batidaPonto = $this->entityManager->getRepository(\SigRH\Entity\BatidaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'dataBatida' => $dataPesquisa]);
                                    if ($batidaPonto) {
                                        foreach($batidaPonto->getHorarios() as $k => $horario) {
                                            error_log("Horario".$horario->getHoraBatida()->format("H:i"));
                                        }
                                    } else { 
                                        error_log("Omissao de ponto - dia todo.");
                                    }
                                        
                                }
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

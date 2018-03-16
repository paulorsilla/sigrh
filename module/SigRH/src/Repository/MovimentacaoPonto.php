<?php

namespace SigRH\Repository;

use SigRH\Entity\MovimentacaoPonto as MovimentacaoPontoEntity;
use SigRH\Entity\RegistroHorario as RegistroHorarioEntity;

class MovimentacaoPonto extends AbstractRepository {

//    public function getQuery($search = []) {
//
//    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($registrosPonto) {
        
        foreach($registrosPonto as $k => $value) {
            $matricula = substr($k, 0, 6);
            $ano = substr($k, 6, 4);
            $mes = substr($k, 10, 2);
            $dia = substr($k, 12, 2);
            
            $dataRegistro = \DateTime::createFromFormat( "Y-m-d", $ano."-".$mes."-".$dia);
            $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $matricula);
            if ($colaborador) {
                $vinculoAtual = $colaborador->getVinculos()->last();
                if($colaborador->getMatricula() == "503385") {
                    error_log($colaborador->getNome()." ".$vinculoAtual->getTipoVinculo()->getId());
                    
                }
                if  ( ($vinculoAtual) && (in_array($vinculoAtual->getTipoVinculo()->getId(), [2, 4, 6, 8]))) {
            
                    //verifica a existencia da folha para o colaborador no mes/ano referencia
                    //caso nao exista, cria a folha para o colaborador
                    $folhaPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\FolhaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'referencia' => $dataRegistro->format("Ym")]);
                    if (null == $folhaPonto) {
                        $status = 0;
                        if ($vinculoAtual->getTipoVinculo()->getId() == 4) {
                            $status = 10;
                        }
                        $folhaPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\FolhaPonto::class)->create($colaborador, $dataRegistro->format("Ym"), $status);
                    }

        //            //verifica a existencia de movimentacao para o colaborador no dia
        //            //caso nao exista, inicia a movimentacao
                    $movimentacaoPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\MovimentacaoPonto::class)->findOneBy(['folhaPonto' => $folhaPonto, 'diaPonto' => $dataRegistro->format('d')]);
                    if (null == $movimentacaoPonto ) {
                        $movimentacaoPonto = new MovimentacaoPontoEntity();
                        $movimentacaoPonto->setDiaPonto($dataRegistro->format("d"));
                        $movimentacaoPonto->setFolhaPonto($folhaPonto);
                        $this->getEntityManager()->persist($movimentacaoPonto);
                    }

                    $horarios = explode(";", $value);
                    foreach($horarios as $hora) {
                        $horaRegistro = \DateTime::createFromFormat( "H-i", $hora);
                        $registroHorario = new RegistroHorarioEntity();
                        $registroHorario->setHoraRegistro($horaRegistro);
                        $registroHorario->setMovimentacaoPonto($movimentacaoPonto);
                        $registroHorario->setTipo('C');
                        $this->getEntityManager()->persist($registroHorario);
                    }
                }
            }
        }
    }
    
//    
//    public function marcacao_intervalo($batidaPonto, $escala) {
//        $horaBatidaPontoS1 = new HoraBatidaPontoEntity();
//        $horaBatidaPontoS1->setBatidaPonto($batidaPonto);
//        $horaBatidaPontoS1->setHoraBatida($escala->getSaida1());
//        $horaBatidaPontoS1->setTipo("A");
//        $this->getEntityManager()->persist($horaBatidaPontoS1);
//
//        $horaBatidaPontoE2 = new HoraBatidaPontoEntity();
//        $horaBatidaPontoE2->setBatidaPonto($batidaPonto);
//        $horaBatidaPontoE2->setHoraBatida($escala->getEntrada2());
//        $horaBatidaPontoE2->setTipo("A");
//        $this->getEntityManager()->persist($horaBatidaPontoE2);
//        $this->getEntityManager()->flush();
//
//    }

}

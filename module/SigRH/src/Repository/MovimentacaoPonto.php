<?php

namespace SigRH\Repository;

use SigRH\Entity\MovimentacaoPonto as MovimentacaoPontoEntity;

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

//    public function incluir_ou_editar($batidasPonto, $importacaoPonto) {
//        foreach($batidasPonto as $k => $value) {
//            $matricula = substr($k, 0, 6);
//            $ano = substr($k, 6, 4);
//            $mes = substr($k, 10, 2);
//            $dia = substr($k, 12, 2);
//            $dataBatida = \DateTime::createFromFormat( "Y-m-d", $ano."-".$mes."-".$dia);
//            $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $matricula);
//            
//            $row = $this->findOneBy(['dataBatida' => $dataBatida, 'colaboradorMatricula' => $colaborador]);
//            if (!$row) {
//                $row = new BatidaPontoEntity();
//            }
//            
//            $row->setColaboradorMatricula($colaborador);
//            $row->setDataBatida($dataBatida);
//            $row->setImportacaoPonto($importacaoPonto);
//            $this->getEntityManager()->persist($row);
//
//            $horarios = explode(";", $value);
//            foreach($horarios as $hora) {
//                $horaBatida = \DateTime::createFromFormat( "H-i", $hora);
//                $horaBatidaPonto = new HoraBatidaPontoEntity();
//                $horaBatidaPonto->setHoraBatida($horaBatida);
//                $horaBatidaPonto->setBatidaPonto($row);
//                $this->getEntityManager()->persist($horaBatidaPonto);
//            }
//        }
//    }
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

<?php

namespace SigRH\Repository;

use SigRH\Entity\FolhaPonto as FolhaPontoEntity;
//use SigRH\Entity\HoraBatidaPonto as HoraBatidaPontoEntity;

class FolhaPonto extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('f')
                ->from(FolhaPontoEntity::class, 'f')
                ->orderby('f.referencia', 'ASC');
//        if (!empty($search['search'])) {
//            $qb->where('b.id like :busca');
//            $qb->setParameter("busca", '%' . $search['search'] . '%');
//        }
//        
        if (!empty($search['matricula'])) {
            $qb->where('f.colaboradorMatricula =  :matricula');
            $qb->setParameter("matricula",  $search['matricula'] );
        }
        return $qb;
    }
    
//    public function findBatidaByMatricula($matricula, $dataInicio, $dataTermino)
//    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        $qb->select('b')
//                ->from(BatidaPontoEntity::class, 'b')
//                ->where('b.colaboradorMatricula =  :matricula')
//                ->andWhere('b.dataBatida BETWEEN :dataInicio AND :dataTermino')
//                ->orderby('b.dataBatida', 'ASC')
//                ->setParameter('matricula',  $matricula)
//                ->setParameter('dataInicio', $dataInicio->format('Y-m-d'))
//                ->setParameter('dataTermino', $dataTermino->format('Y-m-d'));
//        return $qb->getQuery();//->getResult();
//    }

    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($data, $id) {
        
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

<?php

namespace SigRH\Repository;

use SigRH\Entity\BatidaPonto as BatidaPontoEntity;
use SigRH\Entity\HoraBatidaPonto as HoraBatidaPontoEntity;

class BatidaPonto extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
                ->from(BatidaPontoEntity::class, 'b')
                ->orderby('b.dataBatida', 'ASC');
        if (!empty($search['search'])) {
            $qb->where('b.id like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        
        if (!empty($search['matricula'])) {
            $qb->where('b.colaboradorMatricula =  :matricula');
            $qb->setParameter("matricula",  $search['matricula'] );
        }
        return $qb;
    }
    
    public function findBatidaByMatricula($matricula, $dataInicio, $dataTermino)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
                ->from(BatidaPontoEntity::class, 'b')
                ->where('b.colaboradorMatricula =  :matricula')
                ->andWhere('b.dataBatida BETWEEN :dataInicio AND :dataTermino')
                ->orderby('b.dataBatida', 'ASC')
                ->setParameter('matricula',  $matricula)
                ->setParameter('dataInicio', $dataInicio->format('Y-m-d'))
                ->setParameter('dataTermino', $dataTermino->format('Y-m-d'));
        return $qb->getQuery();//->getResult();
    }

    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

//    public function incluir_ou_editar($dados, $id = null) {
//        $row = null;
//        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
//            $row = $this->find($id); // busca o registro para poder alterar
//        }
//        $dataBatida = \DateTime::createFromFormat( "Y-m-d", $dados ['dataBatida']);
//        $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $dados['colaboradorMatricula']);
//
//        $row = $this->getEntityManager()->getRepository(\SigRH\Entity\BatidaPonto::class)->findOneBy(['dataBatida' => $dataBatida, 'colaboradorMatricula' => $colaborador]);
//        if (empty($row)) {
//            $row = new BatidaPontoEntity();
//        }
//
//        if ( !empty($dataBatida)  ) {
//                $row->setDataBatida($dataBatida);
//        }
//        unset($dados['dataBatida']);
//        
//        if($colaborador) {
//            $row->setColaboradorMatricula($colaborador);
//        }
//        unset($dados['colaboradorMatricula']);
//
//        $importacaoPonto = $this->getEntityManager()->find(\SigRH\Entity\ImportacaoPonto::class, $dados['importacaoPontoId']);
//        if ($importacaoPonto) {
//            $row->setImportacaoPonto($importacaoPonto);
//        }
//        unset($dados['importacaoPontoId']);
//
//        $horaBatida = \DateTime::createFromFormat( "H-i", $dados ['horaBatida']);
//        $horaBatidaPonto = new HoraBatidaPontoEntity();
//        $horaBatidaPonto->setHoraBatida($horaBatida);
//
//        $row->getHorarios()->add($horaBatidaPonto);
//        
////        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
//        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
//
//        $horaBatidaPonto->setBatidaPonto($row);
//        $this->getEntityManager()->persist($horaBatidaPonto);
////        $this->getEntityManager()->flush(); // Confirma a atualizacao
//        
//        return $row;
//    }
    
    public function incluir_ou_editar($batidasPonto, $importacaoPonto) {
        foreach($batidasPonto as $k => $value) {
            $matricula = substr($k, 0, 6);
            $ano = substr($k, 6, 4);
            $mes = substr($k, 10, 2);
            $dia = substr($k, 12, 2);
            $dataBatida = \DateTime::createFromFormat( "Y-m-d", $ano."-".$mes."-".$dia);
            $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $matricula);
            
            $row = $this->findOneBy(['dataBatida' => $dataBatida, 'colaboradorMatricula' => $colaborador]);
            if (!$row) {
                $row = new BatidaPontoEntity();
            }
            
            $row->setColaboradorMatricula($colaborador);
            $row->setDataBatida($dataBatida);
            $row->setImportacaoPonto($importacaoPonto);
            $this->getEntityManager()->persist($row);

            $horarios = explode(";", $value);
            foreach($horarios as $hora) {
                $horaBatida = \DateTime::createFromFormat( "H-i", $hora);
                $horaBatidaPonto = new HoraBatidaPontoEntity();
                $horaBatidaPonto->setHoraBatida($horaBatida);
                $horaBatidaPonto->setBatidaPonto($row);
                $this->getEntityManager()->persist($horaBatidaPonto);
            }
        }
    }
}

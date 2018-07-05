<?php

namespace SigRH\Repository;

use SigRH\Entity\FolhaPonto as FolhaPontoEntity;
use SigRH\Entity\MovimentacaoPonto as MovimentacaoPontoEntity;

class FolhaPonto extends AbstractRepository {

    public function getQuery($search = []) {
        
//        $dataAtual = \DateTime::createFromFormat("Ymd", date("Ymd"));
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('f')
                ->from(FolhaPontoEntity::class, 'f')
                ->join('f.colaboradorMatricula', 'c')
                ->join('c.vinculos', 'v')
//                ->where('v.dataDesligamento is NULL')
//                ->andWhere('v.dataTermino >= :dataAtual')
//                ->andWhere('v.tipoVinculo in (2, 4, 5, 6, 8)')
//                ->setParameter('dataAtual', $dataAtual->format("Ymd"))
                ->orderby('c.nome', 'ASC');
        if (!empty($search['referencia'])) {
            $qb->andWhere('f.referencia =  :referencia');
            $qb->setParameter("referencia", $search['referencia']);
        }
        if (!empty($search['nome'])) {
            $qb->andWhere('c.nome like :nome' );
            $qb->setParameter('nome', "%".$search['nome']."%");
        }
        if (!empty($search['orientador'])) {
            $qb->join('v.orientador', 'o');
            $qb->andWhere('o.nome like :orientador' );
            $qb->setParameter('orientador', "%".$search['orientador']."%");
        }
        if (!empty($search['instituicaoFomento'])) {
            $qb->join('v.instituicaoFomento', 'i');
            $qb->andWhere('i.desRazaoSocial like :instituicaoFomento' );
            $qb->setParameter('instituicaoFomento', "%".$search['instituicaoFomento']."%");
        }
        if ( (isset($search['status'])) && ($search['status'] != "")) {
            $qb->andWhere('f.status = :status' );
            $qb->setParameter('status', $search['status']);
        }
        if (!empty($search['processamentoGeral'])) {
            //durante o processamento geral, não inclui a folha dos treinandos
            $qb->andWhere('f.status not in (10)');
        }
        if (!empty($search['colaborador'])) {
            $qb->andWhere('f.colaboradorMatricula =:colaborador')
               ->setParameter('colaborador', $search['colaborador'])
               ->orderBy('f.referencia', 'DESC');
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
  
    public function create($colaborador, $referencia, $status) {
        $row = new FolhaPontoEntity();
        $row->setColaboradorMatricula($colaborador);
        $row->setReferencia($referencia);
        $row->setStatus($status);
        $row->setSaldoMinutos(0);
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
    
    public function complete($referencia) {
        $dataInicial = \DateTime::createFromFormat("Ymd", $referencia."01");
        $rows = $this->findBy(['referencia' => $referencia]);
        foreach($rows as $row) {
            $dataPesquisa = \DateTime::createFromFormat("Ymd", $dataInicial->format("Ymd"));
            while($dataInicial->format('m') == $dataPesquisa->format('m')) {
                $movimentacaoPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\MovimentacaoPonto::class)->findOneBy(['folhaPonto' => $row, 'diaPonto' => $dataPesquisa->format("d")]);
                if(null == $movimentacaoPonto) {
                    $movimentacaoPonto = new MovimentacaoPontoEntity();
                    $movimentacaoPonto->setFolhaPonto($row);
                    $movimentacaoPonto->setDiaPonto($dataPesquisa->format('d'));
                    $this->getEntityManager()->persist($movimentacaoPonto);
                }
                $dataPesquisa->add(new \DateInterval('P1D'));
            }
        }
        $this->getEntityManager()->flush();
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

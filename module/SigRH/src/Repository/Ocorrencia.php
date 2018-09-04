<?php

namespace SigRH\Repository;

use SigRH\Entity\Ocorrencia as OcorrenciaEntity;

class Ocorrencia extends AbstractRepository {

    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function findOcorrenciaByMatricula($matricula, $dataInicio, $dataTermino)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o')
                ->from(OcorrenciaEntity::class, 'o')
                ->where('o.colaboradorMatricula =  :matricula')
                ->andWhere('o.dataOcorrencia BETWEEN :dataInicio AND :dataTermino')
                ->orderby('o.dataOcorrencia', 'ASC')
                ->setParameter('matricula',  $matricula)
                ->setParameter('dataInicio', $dataInicio->format('Y-m-d'))
                ->setParameter('dataTermino', $dataTermino->format('Y-m-d'));
        return $qb->getQuery();//->getResult();
    }
    
    public function incluir_ou_editar($movimentacaoPonto, $descricao, $recesso=null) {
        $row = $this->findOneBy(['movimentacaoPonto' => $movimentacaoPonto]);
        if (!$row) {
            $row = new OcorrenciaEntity();
            $row->setMovimentacaoPonto($movimentacaoPonto);
        }
        if (null == $recesso) {
            $dataAtual = new \DateTime();
            $referencia = $movimentacaoPonto->getFolhaPonto()->getReferencia();
            $diaPonto = sprintf("%02d", $movimentacaoPonto->getDiaPonto());
            $dataPonto = $referencia.$diaPonto;
            
            if ( ($descricao == "-Omissão de ponto.") && ($dataPonto <= $dataAtual->format("Ymd")) ) { 
                $descricaoAux = $descricao;
                if(strpos($row->getDescricao(), $descricaoAux) === false) {
                    $descricao = $row->getDescricao()." ".$descricao;
                }
            }
        } else {
            $justificativa = $this->getEntityManager()->find(\SigRH\Entity\Justificativa::class, 11);
            $row->setJustificativa1($justificativa);
        }
        $row->setDescricao($descricao);
        $this->getEntityManager()->persist($row); // persiste o model no banco ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
    
    public function justificar($id, $data) {
        $row = $this->find($id);
        if ($row) {
            $justificativa1 = null;
            $justificativa2 = null;
            if (!empty($data['justificativa1'])) {
                $justificativa1 = $this->getEntityManager()->find(\SigRH\Entity\Justificativa::class, $data['justificativa1']);
            }
            if (!empty($data['justificativa2'])) {
                $justificativa2 = $this->getEntityManager()->find(\SigRH\Entity\Justificativa::class, $data['justificativa2']);
            }
            if (!empty($data['numeroCrachaVisitante'])) {
                $row->setNumeroCrachaVisitante($data['numeroCrachaVisitante']);
            }
            $row->setJustificativa1($justificativa1);
            $row->setJustificativa2($justificativa2);
            $this->getEntityManager()->persist($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function excluir($movimentacaoPonto) {
        $row = $this->findOneBy(['movimentacaoPonto' => $movimentacaoPonto]);
        if ( ($row) && (null == $row->getJustificativa1()) && (null == $row->getJustificativa2()) ) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }

    }

}

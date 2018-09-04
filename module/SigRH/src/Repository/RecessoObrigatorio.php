<?php

namespace SigRH\Repository;

use SigRH\Entity\RecessoObrigatorio as RecessoObrigatorioEntity;

class RecessoObrigatorio extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
           ->from(RecessoObrigatorioEntity::class, 'r');
        
        if ( !empty($search["dataPonto"]) ) {
            $qb->andWhere(":dataPonto BETWEEN r.dataInicio AND r.dataTermino")
                ->setParameter("dataPonto", $search["dataPonto"]->format("Ymd"));
        }
        if ( !empty($search["vinculo"]) ) {
            $qb->andWhere("r.vinculo = :vinculo")
                ->setParameter("vinculo", $search["vinculo"]);
        }
       return $qb;
    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $vinculo) {
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new RecessoObrigatorioEntity();
        }
        $dataInicio = null;
        $dataTermino = null;
        if (!empty($dados['dataInicio'])) {
            $dataInicio = \DateTime::createFromFormat("Y-m-d", $dados['dataInicio']);
        }
        if (!empty($dados['dataTermino'])) {
            $dataTermino = \DateTime::createFromFormat("Y-m-d", $dados['dataTermino']);
        }
        unset($dados['dataInicio']);
        unset($dados['dataTermino']);

        $row->setDataInicio($dataInicio);
        $row->setDataTermino($dataTermino);
        $row->setVinculo($vinculo);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }
}
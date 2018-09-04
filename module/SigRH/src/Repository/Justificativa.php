<?php

namespace SigRH\Repository;

use SigRH\Entity\Justificativa as JustificativaEntity;

class Justificativa extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('j')
                ->from(JustificativaEntity::class, 'j');
        if (!empty($search['listar'])) {
            $qb->where('j.listar = 1');
        }
        if (!empty($search['indicarHorario'])) {
            $qb->where('j.indicarHorario = 1');
        }
        if (!empty($search['indicarCracha'])) {
            $qb->where('j.indicarCracha = 1');
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
    
    public function incluir_ou_editar($dados,$id = null) {
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new JustificativaEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
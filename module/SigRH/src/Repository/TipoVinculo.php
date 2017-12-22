<?php

namespace SigRH\Repository;

use SigRH\Entity\TipoVinculo as TipoVinculoEntity;

class TipoVinculo extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
                ->from(TipoVinculoEntity::class, 't')
                ->orderby('t.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('t.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new TipoVinculoEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }
}
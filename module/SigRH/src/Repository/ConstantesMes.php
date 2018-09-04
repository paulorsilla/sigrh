<?php

namespace SigRH\Repository;

use SigRH\Entity\ConstantesMes as ConstantesMesEntity;

class ConstantesMes extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ConstantesMesEntity::class, 'c')
                ->orderby('c.referencia','ASC');
       return $qb;
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    public function incluir_ou_editar($dados){
        
        $row = null;
        $referencia = $dados['referencia'];
        if ( !empty($referencia)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($referencia); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new ConstantesMesEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
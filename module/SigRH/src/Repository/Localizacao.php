<?php

namespace SigRH\Repository;
use SigRH\Entity\Localizacao as LocalizacaoEntity;

class Localizacao extends AbstractRepository {

    public function getQuery($search = array()) {
        $combo = false;
        if ( (isset($search['combo'])) && ($search['combo'] == 1)) {
            $combo = true;
            unset($search['combo']);
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('l')
                ->from(LocalizacaoEntity::class, 'l');
        if ($combo) {
            return $qb->getQuery()->getResult();
        } else {
            return $qb->getQuery();
        }
    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados,$id = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new LocalizacaoEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
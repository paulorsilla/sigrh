<?php

namespace SigRH\Repository;

use SigRH\Entity\Cargo as CargoEntity;

class Cargo extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(CargoEntity::class, 'c')
                ->where('c.pce = 2012')
                ->orderby('c.descricao','ASC');
        if ( !empty($search['search'])){
            $qb->where('c.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        if (!empty($search['combo']) && $search['combo'] == 1) {
            return $qb->getQuery()->getResult();
        } else {
            return $qb->getQuery();
        }
    }
    
    public function getListParaCombo() {
        
        $array = array();
        // Usando a Query
        $list = $this->getQuery()->getResult();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"descricao"=>$row->descricao);
        }
        return $array;
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }

}
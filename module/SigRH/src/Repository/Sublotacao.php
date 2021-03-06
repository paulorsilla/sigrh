<?php

namespace SigRH\Repository;

use SigRH\Entity\Sublotacao as SublotacaoEntity;

class Sublotacao extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
                ->from(SublotacaoEntity::class, 's')
                ->orderby('s.descricao','ASC');
        if ( !empty($search['search'])){
            $qb->where('s.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        if ( !empty($search['ano'])){
            $qb->where('s.ano = :ano');
            $qb->setParameter("ano", $search['ano']);
        }
        
        if (!empty($search['combo']) && $search['combo'] == 1) {
            return $qb->getQuery()->getResult();
        } else {
            return $qb->getQuery();
        }
//       return $qb;

    }
    
    public function getListParaCombo() {
        
        $array = array();
        //$list = $this->findAll();
        // Trocamos o findall por findby para passar o segundo parametro referente a ordenação
        //$list = $this->findBy(array(),array('descricao'=>'ASC'));
        
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
    public function incluir_ou_editar($dados,$id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new SublotacaoEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
<?php

namespace SigRH\Repository;

use SigRH\Entity\Termo as TermoEntity;

class Termo extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
                ->from(TermoEntity::class, 't')
                ->orderby('t.aditivo','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('t.aditivo like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->aditivo);
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
    public function incluir_ou_editar($dados,$id = null,$estagio=null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new TermoEntity();
        }
        if ( !empty($estagio)) {
            $estagioObj = $this->getEntityManager()->find('SigRH\Entity\Estagio', $estagio);
            if ( empty($estagioObj) )
                throw new Exception('Estagio nao encontrado');
            $row->setEstagio($estagioObj);
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
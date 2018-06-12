<?php

namespace SigRH\Repository;

use SigRH\Entity\Escala as EscalaEntity;

class Escala extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EscalaEntity::class, 'e');
       return $qb;
       
    }
    
    public function getListParaCombo() {
        $array = [];
        $list = $this->getQuery()->getQuery()->getResult();
        foreach($list  as $row){
            $array[] = array("id"=>$row->getId(), "descricao" => $row->getEscalaComposta());
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
            $row = new EscalaEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
<?php

namespace SigRH\Repository;

use SigRH\Entity\Cracha as CrachaEntity;

class Cracha extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d')
                ->from(CrachaEntity::class, 'd');
        
        //inclui a pesquisa por matricula por meio de um join
        error_log("MATRICULA: ".$search['matricula']);
        //inclui a pesquisa por matricula por meio de um join
        if ( !empty($search['matricula'])){
            $qb->join("d.colaboradorMatricula",'c');
            $qb->where('c.matricula = :matricula');
            $qb->setParameter("matricula",$search['matricula']);
        }
        
        
        echo "DQL: ".$qb->getDQL();
        echo "<hr>";
        echo "SQL: ".$qb->getQuery()->getSQL();
        die();
       return $qb;
    }
    
//    public function getListParaCombo(){
//        
//        $array = array();
//        $list = $this->findAll();
//        foreach($list  as $row){
//            $array[] = array("id"=>$row->id,"nome"=>$row->descricao);
//        }
//        return $array;
//    }
//    
//    public function delete($id){
//        $row = $this->find($id);
//        if ($row) {
//                $this->getEntityManager()->remove($row);
//                $this->getEntityManager()->flush();
//        }
//    }
//    public function incluir_ou_editar($dados,$id = null){
//        
//        $row = null;
//        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
//            $row = $this->find($id); // busca o registro do campo para poder alterar
//        }    
//        if ( empty($row)) {
//            $row = new CursoEntity();
//        }
//        
//        
//        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
//        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
//        $this->getEntityManager()->flush(); // Confirma a atualizacao
//        
//        return $row;
//    }

}
<?php

namespace SigRH\Repository;

use SigRH\Entity\Horario as HorarioEntity;

class Horario extends AbstractRepository {

 public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
                ->from(HorarioEntity::class, 'h')
              ->orderby('h.diaSemana','ASC');
        //inclui a pesquisa por matricula por meio de um join
        if ( !empty($search['matricula'])){
            $qb->join("h.colaboradorMatricula",'c');
            $qb->where('c.matricula = :matricula');
            $qb->setParameter("matricula",$search['matricula']);
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
    public function incluir_ou_editar($dados,$id = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        
        if ( empty($row)) {
            $row = new HorarioEntity();
        }
        
//        //escala...
//        if ( !empty($dados['escala'] )) {
//            $escala = $this->getEntityManager()->find('SigRH\Entity\Escala', $dados['escala']); //busca as informações
//            $row->setNivel($escala);
//        }
//        unset($dados['escala']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
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
    public function incluir_ou_editar($dados,$colaborador){
        
        foreach( $colaborador->horarios as $horario ){
             $this->getEntityManager()->remove($horario);
        }
        $campos=array(1=>"escalaDomingo",2=>"escalaSegunda",3=>"escalaTerca",4=>"escalaQuarta",5=>"escalaQuinta",6=>"escalaSexta",7=>"escalaSabado");
        $repoEscala = $this->getEntityManager()->getRepository(\SigRH\Entity\Escala::class);
        foreach ( $campos as $diaSemana=>$escalaId){
            if ( !empty($dados[$escalaId])){
                $escalaObj = $repoEscala->find($dados[$escalaId]);
                if ( !empty($escalaObj)){
                    $horario = new HorarioEntity();
                    $horario->setColaboradorMatricula($colaborador);
                    $horario->setDiaSemana($diaSemana);
                    $horario->setEscala($escalaObj);
                    $this->getEntityManager()->persist($horario); // persiste o model no mando ( preparar o insert / update)
                }
            }
        }
        
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return true;
    }

}
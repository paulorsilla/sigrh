<?php

namespace SigRH\Repository;

use SigRH\Entity\Dependente as DependenteEntity;

class Dependente extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d')
                ->from(DependenteEntity::class, 'd')
                ->orderby('d.nome','ASC');
        
        if ( !empty($search['search'])){
            $qb->where(' d.nome like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        //inclui a pesquisa por matricula por meio de um join
        if ( !empty($search['matricula'])){
            $qb->join("d.colaboradorMatricula",'c');
            $qb->where('c.matricula = :matricula');
            $qb->setParameter("matricula",$search['matricula']);
        }
        
//        echo "DQL: ".$qb->getDQL();
//        echo "<hr>";
//        echo "SQL: ".$qb->getQuery()->getSQL();
//        die();
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->dataInicioEfetivo);
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
    public function incluir_ou_editar($dados, $id = null, $matricula=null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        
        if ( empty($row)) {
            $row = new DependenteEntity();
        }
        
        if ( !empty($matricula)) {
            $colaborador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $matricula);
            if ( empty($colaborador) )
                throw new Exception('Colaborador nao encontrado');
            $row->setColaboradorMatricula($colaborador);
        }
        
        $row->setDataNascimento(null);
        if ($dados ['dataNascimento'] != "") {					
            $dataNascimento = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataNascimento'] );
            if ( !empty($dataNascimento)  )
               $row->setDataNascimento($dataNascimento);
        }
        unset($dados['dataNascimento']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        //\Doctrine\Common\Util\Debug::dump($row);// nunca usar print_r para elemento doctrine
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
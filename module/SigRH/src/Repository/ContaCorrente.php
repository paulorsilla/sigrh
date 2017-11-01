<?php

namespace SigRH\Repository;

use SigRH\Entity\ContaCorrente as ContaCorrenteEntity;

class ContaCorrente extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ContaCorrenteEntity::class, 'c')
                ->orderby('c.contaCorrente','ASC');
        
        if ( !empty($search['search'])){
            $qb->where(' c.contaCorrente like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->contaCorrente);
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
    public function incluir_ou_editar($dados,$id = null,$matricula=null){

        if ( empty($matricula))
            throw new Exception('Matricula em branco');
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new ContaCorrenteEntity();
        }
        //banco...
        if ( !empty($dados['banco'] )) {
            $banco = $this->getEntityManager()->find('SigRH\Entity\Banco', $dados['banco']); //busca as informações
            $row->setBanco($banco);
        }
        unset($dados['banco']);
        
        /////gravação...
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao

        $colaborador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $matricula);
        if ( empty($colaborador) )
            throw new Exception('Colaborador nao encontrado');
        $colaborador->getContasCorrente()->add($row);
        $this->getEntityManager()->persist($colaborador);
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
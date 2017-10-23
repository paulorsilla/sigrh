<?php

namespace Admin\Repository;


class Usuario extends \Core\Repository\AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from('Admin\Model\Usuario', 'i')
                ->orderby('i.nome');
        if ( !empty($search['search'])){
            $qb->where('i.nome like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function excluir($id){
        $instituicao = $this->find($id);
        if ($instituicao) {
                $this->getEntityManager()->remove($instituicao);
                $this->getEntityManager()->flush();
        }
    }
//    public function incluir_ou_editar($dados,$id = null){
//        
//        $instituicao = null;
//        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
//            $instituicao = $this->find($id); // busca o registro do banco para poder alterar
//        }    
//        if ( empty($instituicao)) {
//            $instituicao = new \Fontes\Model\Instituicao();
//        }
//        
//        $instituicao->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
//        $this->getEntityManager()->persist($instituicao); // persiste o model no mando ( preparar o insert / update)
//        $this->getEntityManager()->flush(); // Confirma a atualizzacao
//    }

}
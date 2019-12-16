<?php

namespace SigRH\Repository;

use SigRH\Entity\AgenteIntegracao as AgenteIntegracaoEntity;

class AgenteIntegracao extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from(AgenteIntegracaoEntity::class, 'a')
                ->orderby('a.nome','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('a.nome like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
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
    public function incluir_ou_editar($dados, $id = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new AgenteIntegracaoEntity();
        }
        
        $vigencia = null;
        if (!empty($dados['vigencia'])) {
            $vigencia = \DateTime::createFromFormat("Y-m-d", $dados["vigencia"]);
        }
        unset($dados['vigencia']);
        $row->setVigencia($vigencia);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
<?php

namespace SigRH\Repository;

use SigRH\Entity\ImportacaoPonto as ImportacaoPontoEntity;

class ImportacaoPonto extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from(ImportacaoPontoEntity::class, 'i')
                ->orderby('i.id','ASC');
       return $qb;
    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($dados, $user, $id = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new ImportacaoPontoEntity();
        }

        if ($dados ['dataImportacao'] != "") {					
            $dataImportacao = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataImportacao'] );
            if ( !empty($dataImportacao) ) {
                $row->setDataImportacao($dataImportacao);
            }
        }
        unset($dados['dataImportacao']);
        unset($dados['usuario']);
        
        $row->setUsuario($user);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}
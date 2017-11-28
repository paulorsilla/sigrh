<?php

namespace SigRH\Repository;

use SigRH\Entity\BatidaPonto as BatidaPontoEntity;

class BatidaPonto extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
                ->from(BatidaPontoEntity::class, 'b')
                ->orderby('b.id', 'ASC');
        if (!empty($search['search'])) {
            $qb->where('b.id like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        return $qb;
    }

    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($dados, $id = null) {
        $row = null;
        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do convenio para poder alterar
        }
        if (empty($row)) {
            $row = new BatidaPontoEntity();
        }

        $dataBatida = \DateTime::createFromFormat( "Y-m-d", $dados ['dataBatida']);
        if ( !empty($dataBatida)  ) {
                $row->setDataBatida($dataBatida);
        }
        unset($dados['dataBatida']);
        
        $horaBatida = \DateTime::createFromFormat( "H-i", $dados ['horaBatida']);
        if ( !empty($horaBatida)  ) {
                $row->setHoraBatida($horaBatida);
        }
        unset($dados['horaBatida']);

        $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $dados['colaboradorMatricula']);
        if($colaborador) {
            $row->setColaboradorMatricula($colaborador);
        }
        unset($dados['colaboradorMatricula']);

        $importacaoPonto = $this->getEntityManager()->find(\SigRH\Entity\ImportacaoPonto::class, $dados['importacaoPontoId']);
        if ($importacaoPonto) {
            $row->setImportacaoPonto($importacaoPonto);
        }
        unset($dados['importacaoPontoId']);
        
        $row->setSequencia($dados['sequencia']);
        
//        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
//        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}

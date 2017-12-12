<?php

namespace SigRH\Repository;

use SigRH\Entity\Ocorrencia as OcorrenciaEntity;

class Ocorrencia extends AbstractRepository {

    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function findOcorrenciaByMatricula($matricula, $dataInicio, $dataTermino)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o')
                ->from(OcorrenciaEntity::class, 'o')
                ->where('o.colaboradorMatricula =  :matricula')
                ->andWhere('o.dataOcorrencia BETWEEN :dataInicio AND :dataTermino')
                ->orderby('o.dataOcorrencia', 'ASC')
                ->setParameter('matricula',  $matricula)
                ->setParameter('dataInicio', $dataInicio->format('Y-m-d'))
                ->setParameter('dataTermino', $dataTermino->format('Y-m-d'));
        return $qb->getQuery();//->getResult();
    }
    
    public function incluir_ou_editar($colaborador, $data, $batidaPonto = null, $descricao, $id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do campo para poder alterar
        }    
        if ( empty($row)) {
            $row = new OcorrenciaEntity();
        }
        $row->setColaboradorMatricula($colaborador);
        $row->setDataOcorrencia($data);
        $row->setDescricao($descricao);
//        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
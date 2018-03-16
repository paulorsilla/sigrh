<?php

namespace SigRH\Repository;

use SigRH\Entity\Feriado as FeriadoEntity;
use SigRH\Entity\TipoFeriado;

class Feriado extends AbstractRepository {

    public function getQuery($search = [] ) {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction("YEAR", \DoctrineExtensions\Query\Mysql\Year::class);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('f')
                ->from(FeriadoEntity::class, 'f')
                ->orderby('f.dataFeriado','ASC');
        if ( !empty($search['search'])){
            $qb->where('YEAR(f.dataFeriado) = :ano')
               ->setParameter('ano', $search['search']);
        }
       return $qb;
    }
    
    public function getFeriadoReferencia($referencia) {
        $ano = substr($referencia, 0, 4);
        $mes = substr($referencia, 4, 2);
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction("YEAR", \DoctrineExtensions\Query\Mysql\Year::class);
        $emConfig->addCustomDatetimeFunction("MONTH", \DoctrineExtensions\Query\Mysql\Month::class);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('f')
            ->from(FeriadoEntity::class, 'f')
            ->where('f.expediente = :false')
            ->andWhere('YEAR(f.dataFeriado) = :ano')
            ->andWhere('MONTH(f.dataFeriado) = :mes')
            ->setParameter('ano', $ano)
            ->setParameter('mes', $mes)
            ->setParameter('false', false)
            ->orderby('f.dataFeriado','ASC');
       return $qb->getQuery()->getResult();
        
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
        
        if ($dados['dataFeriado'] != '') {
            $dataFeriado = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataFeriado'] );
            $dataFeriado->setTime(0, 0);
            $row = $this->findOneBy(['dataFeriado' => $dataFeriado] );
        }
        
        if ( empty($row)) {
            $row = new FeriadoEntity();
        }
        
        //data do feriado
        if ( !empty($dataFeriado)  ) {
           $row->setDataFeriado($dataFeriado);
        }
        unset($dados['dataFeriado']);        

        //tipoFeriado
        if ( !empty($dados['tipoFeriado'] )) {
            $tipoFeriado = $this->getEntityManager()->find(TipoFeriado::class, $dados['tipoFeriado']); //busca as informações
            $row->setTipoFeriado($tipoFeriado);
        }
        unset($dados['tipoFeriado']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
<?php

namespace SigRH\Repository;
use SigRH\Entity\RegistroHorario as RegistroHorarioEntity;

class RegistroHorario extends AbstractRepository {
    
    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
                ->from(RegistroHorarioEntity::class, 'r');
        if (!empty($search['matricula'])) {
            $horaCorte = \DateTime::createFromFormat( "H:i", "15:00");

            $qb->innerJoin('r.movimentacaoPonto', 'm')
               ->innerJoin('m.folhaPonto', 'f')
               ->where('f.colaboradorMatricula = :matricula')
               ->andWhere('r.horaRegistro > :horaCorte')
               ->setParameter('matricula', $search['matricula'])
               ->setParameter('horaCorte', $horaCorte);
        }
       return $qb;

    }

    public function incluir_ou_editar($movimentacaoPonto, $hora) 
    {
        $horaRegistro = \DateTime::createFromFormat( "H:i", $hora);
        $row = $this->findOneBy(["horaRegistro" => $horaRegistro, "movimentacaoPonto" => $movimentacaoPonto]);
        if(!$row) {
            $row = new RegistroHorarioEntity();
            $row->setMovimentacaoPonto($movimentacaoPonto);
            $row->setHoraRegistro($horaRegistro);
            $row->setTipo('M');
            $this->getEntityManager()->persist($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function marcacao_intervalo($movimentacaoPonto, $escala) 
    {
        //saida 1
        $horaRegistroS1 = new RegistroHorarioEntity();
        $horaRegistroS1->setMovimentacaoPonto($movimentacaoPonto);
        $horaRegistroS1->setHoraRegistro($escala->getSaida1());
        $horaRegistroS1->setTipo("A");
        $this->getEntityManager()->persist($horaRegistroS1);
        $movimentacaoPonto->getRegistros()->add($horaRegistroS1);

        //entrada 2
        $horaRegistroE2 = new RegistroHorarioEntity();
        $horaRegistroE2->setMovimentacaoPonto($movimentacaoPonto);
        $horaRegistroE2->setHoraRegistro($escala->getEntrada2());
        $horaRegistroE2->setTipo("A");
        $this->getEntityManager()->persist($horaRegistroE2);
        $movimentacaoPonto->getRegistros()->add($horaRegistroE2);
        
        $this->getEntityManager()->flush();

    }
    
    public function delete($id)
    {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
}

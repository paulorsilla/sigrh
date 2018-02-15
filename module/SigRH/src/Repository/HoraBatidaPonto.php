<?php

namespace SigRH\Repository;

class HoraBatidaPonto extends AbstractRepository {

    public function getQuery($search = []) {
    }
    
    public function incluir_ou_editar($batidaPonto, $hora ) {
        $horaBatida = \DateTime::createFromFormat( "H-i", $hora);
        $horaBatidaPonto = new HoraBatidaPontoEntity();
        $horaBatidaPonto->setHoraBatida($horaBatida);
        $horaBatidaPonto->setBatidaPonto($batidaPonto);
        $this->getEntityManager()->persist($horaBatidaPonto);
    }

}

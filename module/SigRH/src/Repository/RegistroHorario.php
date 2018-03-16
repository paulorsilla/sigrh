<?php

namespace SigRH\Repository;
use SigRH\Entity\RegistroHorario as RegistroHorarioEntity;

class RegistroHorario extends AbstractRepository {

    public function incluir_ou_editar($movimentacaoPonto, $hora ) {
        $horaBatida = \DateTime::createFromFormat( "H-i", $hora);
        $registro = new RegistroHorarioEntity();
        $registro->setHoraRegistro($horaBatida);
        $registro->setMovimentacaoPonto($movimentacaoPonto);
        $this->getEntityManager()->persist($registro);
    }
    
    public function marcacao_intervalo($movimentacaoPonto, $escala) {
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
}

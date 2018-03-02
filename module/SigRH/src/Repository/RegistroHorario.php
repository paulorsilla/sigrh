<?php

namespace SigRH\Repository;

class RegistroHorario extends AbstractRepository {

    public function incluir_ou_editar($movimentacaoPonto, $hora ) {
        $horaBatida = \DateTime::createFromFormat( "H-i", $hora);
        $registro = new RegistroHorarioEntity();
        $registro->setHoraBatida($horaBatida);
        $registro->setMovimentacaoPonto($movimentacaoPonto);
        $this->getEntityManager()->persist($registro);
    }
}

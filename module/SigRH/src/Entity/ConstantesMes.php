<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ConstantesMes.
 * @ORM\Entity(repositoryClass="SigRH\Repository\ConstantesMes")
 * @ORM\Table(name="constantes_mes")
 */
class ConstantesMes extends AbstractEntity {	

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    */
   protected $referencia;

   /**
    * @ORM\Column(type="integer", name="ultimo_dia_importado")
    */
   protected $ultimoDiaImportado;

   /**
    * @ORM\Column(type="float", name="numero_dias_uteis")
    */
    protected $numeroDiasUteis;
    
    public function getReferencia() {
        return $this->referencia;
    }

    public function getUltimoDiaImportado() {
        return $this->ultimoDiaImportado;
    }

    public function getNumeroDiasUteis() {
        return $this->numeroDiasUteis;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function setUltimoDiaImportado($ultimoDiaImportado) {
        $this->ultimoDiaImportado = $ultimoDiaImportado;
    }

    public function setNumeroDiasUteis($numeroDiasUteis) {
        $this->numeroDiasUteis = $numeroDiasUteis;
    }
    
}
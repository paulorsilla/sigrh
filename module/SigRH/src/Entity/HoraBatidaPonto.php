<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe HoraBatidaPonto.
 * @ORM\Entity(repositoryClass="SigRH\Repository\HoraBatidaPonto")
 * @ORM\Table(name="hora_batida_ponto")
 */
class HoraBatidaPonto extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="hora", type="time")
     */
    protected $horaBatida;
    
    /**
     *
     * @ORM\Column(name="tipo", type="string")
     **/
    protected $tipo;
    
    /**
     * @ORM\ManyToOne(targetEntity="BatidaPonto", inversedBy="horarios")
     * @ORM\JoinColumn(name="batida_ponto_id", referencedColumnName="id")
     * */    
    protected $batidaPonto;
    
    public function getId() {
        return $this->id;
    }

    public function getHoraBatida() {
        return $this->horaBatida;
    }

    public function getBatidaPonto() {
        return $this->batidaPonto;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setHoraBatida($horaBatida) {
        $this->horaBatida = $horaBatida;
    }

    public function setBatidaPonto($batidaPonto) {
        $this->batidaPonto = $batidaPonto;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

}

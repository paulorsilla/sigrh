<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Horario.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Horario")
 * @ORM\Table(name="horario")
 */
class Horario extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */
    protected $colaboradorMatricula;
    
    /**
     * @ORM\ManyToOne(targetEntity="Escala")
     * @ORM\JoinColumn(name="escala_id", referencedColumnName="id")
     */
    protected $escala;
    
    /**
     * 
     * @ORM\column(name="dia_semana", type="integer")
     */
    protected $diaSemana;
    
    public function getId() {
        return $this->id;
    }

    public function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    public function getEscala() {
        return $this->escala;
    }
    
    public function getDiaSemana() {
        return $this->diaSemana;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    public function setEscala($escala) {
        $this->escala = $escala;
    }
    
    public function setDiaSemana($diaSemana) {
        $this->diaSemana = $diaSemana;
    }

}

<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Escala.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Escala")
 * @ORM\Table(name="escala")
 */

class Escala extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="entrada1", type="time")
     */
    protected $entrada1;

    /**
     * @ORM\Column(name="saida1", type="time")
     */
    protected $saida1;
    
    /**
     * @ORM\Column(name="entrada2", type="time")
     */
    protected $entrada2;
    
    /**
     * @ORM\Column(name="saida2", type="time")
     */
    protected $saida2;
    

    public function getId() {
        return $this->id;
    }

    public function getEntrada1() {
        return $this->entrada1;
    }

    public function getSaida1() {
        return $this->saida1;
    }

    public function getEntrada2() {
        return $this->entrada2;
    }

    public function getSaida2() {
        return $this->saida2;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEntrada1($entrada1) {
        $this->entrada1 = $entrada1;
    }

    public function setSaida1($saida1) {
        $this->saida1 = $saida1;
    }

    public function setEntrada2($entrada2) {
        $this->entrada2 = $entrada2;
    }

    public function setSaida2($saida2) {
        $this->saida2 = $saida2;
    }
}

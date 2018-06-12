<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Curso.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Cargo")
 * @ORM\Table(name="sigco.cargo")
 */
class Cargo extends AbstractEntity{	

    /**
    * @ORM\Id
    * @ORM\Column(type="integer");
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   /**
    * @ORM\Column(type="string")
    */
   protected $descricao;

   /**
    * @ORM\Column(type="integer")
    */
    protected $pce;
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getPce() {
        return $this->pce;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPce($pce) {
        $this->pce = $pce;
    }
    
}
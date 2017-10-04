<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe banco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Banco")
 * @ORM\Table(name="banco")
 */
class Banco extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="banco", type="string")
     */
    protected $banco;

    /**
     * @ORM\Column(name="codigo", type="integer")
     */
    protected $codigo;

    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    function getBanco() {
        return $this->banco;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
}

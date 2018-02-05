<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe endereco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Estado")
 * @ORM\Table(name="estado")
 */
class Estado extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="estado", type="string")
     */
    protected $estado;

    /**
     * @ORM\Column(name="sigla", type="string")
     */
    protected $sigla;


    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    function getEstado() {
        return $this->estado;
    }

    function getSigla() {
        return $this->sigla;
    }

            
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
 
    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }
    

}

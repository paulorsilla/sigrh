<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ModalidadeBolsa.
 * @ORM\Entity(repositoryClass="SigRH\Repository\ModalidadeBolsa")
 * @ORM\Table(name="modalidade_bolsa")
 */
class ModalidadeBolsa extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;


    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }
    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}

<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe GrupoSanguineo.
 * @ORM\Entity(repositoryClass="SigRH\Repository\GrupoSanguineo")
 * @ORM\Table(name="grupo_sanguineo")
 */
class GrupoSanguineo extends AbstractEntity{

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

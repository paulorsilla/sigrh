<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Curso.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Sublotacao")
 * @ORM\Table(name="sigco.sublotacao")
 */
class Sublotacao extends AbstractEntity{

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
     * @ORM\Column(name="sigla", type="string")
     */
    protected $sigla;
    
    /**
     * @ORM\Column(name="ano", type="integer")
     */
    protected $ano;

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
    
    function getSigla() {
        return $this->sigla;
    }

    function getAno() {
        return $this->ano;
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
    
    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }
}

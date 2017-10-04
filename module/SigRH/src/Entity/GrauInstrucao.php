<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe GrauInstrucao.
 * @ORM\Entity(repositoryClass="SigRH\Repository\GrauInstrucao")
 * @ORM\Table(name="grau_instrucao")
 */
class GrauInstrucao extends AbstractEntity{

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
     * @ORM\Column(name="ordem", type="integer")
     */
    protected $ordem;
    

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
    
    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    function getOrdem() {
        return $this->ordem;
    }

    function setOrdem($ordem) {
        $this->ordem = $ordem;
    }



}

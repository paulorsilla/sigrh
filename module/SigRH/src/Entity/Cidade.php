<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe endereco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Cidade")
 * @ORM\Table(name="cidade")
 */
class Cidade extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Estado")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     **/        
    protected $estado; //estado_id 
    
    /**
     * @ORM\Column(name="cidade", type="string")
     */
    protected $cidade;

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

    function getCidade() {
        return $this->cidade;
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

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }


    

}

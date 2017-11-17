<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe instituicao.
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SigRH\Repository\Instituicao")
 * @ORM\Table(name="nco.tb_inst")
 */

class Instituicao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="cod_instituicao")
     * @ORM\GeneratedValue
     */
    protected $codInstituicao;

    /**
     * @ORM\Column(name="des_razaosocial", type="string")
     */
    protected $desRazaoSocial;

    /**
     * @ORM\Column(name="nom_fantasia", type="string")
     */
    protected $nomFantasia;
    
     /**
     * @ORM\Column(name="des_pf_pj", type="string")
     */
    protected $desPfPj;


    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getCodInstituicao() {
        return $this->codInstituicao;
    }
     
    public function getDesRazaoSocial() {
        return $this->desRazaoSocial;
    }

    public function getNomFantasia() {
        return $this->nomFantasia;
    }

    public function getDesPfPj() {
        return $this->desPfPj;
    }
        
    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    
    public function setCodInstituicao($codInstituicao) {
        $this->codInstituicao = $codInstituicao;
    }

    public function setDesRazaoSocial($desRazaoSocial) {
        $this->desRazaoSocial = $desRazaoSocial;
    }

    public function setNomFantasia($nomFantasia) {
        $this->nomFantasia = $nomFantasia;
    }

    public function setDesPfPj($desPfPj) {
        $this->desPfPj = $desPfPj;
    }

}

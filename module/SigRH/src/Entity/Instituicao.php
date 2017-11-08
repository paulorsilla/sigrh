<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe instituicao.
 * @ORM\Entity
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
    function getCodInstituicao() {
        return $this->codInstituicao;
    }

    function getDesRazaoSocial() {
        return $this->desRazaoSocial;
    }

    function getNomFantasia() {
        return $this->nomFantasia;
    }

    function getDesPfPj() {
        return $this->desPfPj;
    }

        
    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    
    function setCodInstituicao($codInstituicao) {
        $this->codInstituicao = $codInstituicao;
    }

    function setDesRazaoSocial($desRazaoSocial) {
        $this->desRazaoSocial = $desRazaoSocial;
    }

    function setNomFantasia($nomFantasia) {
        $this->nomFantasia = $nomFantasia;
    }

    function setDesPfPj($desPfPj) {
        $this->desPfPj = $desPfPj;
    }


}

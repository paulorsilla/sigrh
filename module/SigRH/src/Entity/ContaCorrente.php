<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Conta Corrente.
 * @ORM\Entity(repositoryClass="SigRH\Repository\ContaCorrente")
 * @ORM\Table(name="conta_corrente")
 */
class ContaCorrente extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Banco")
     * @ORM\JoinColumn(name="banco_id", referencedColumnName="id")
     **/        
    protected $banco; //banco_id 
    /**
     * @ORM\Column(name="agencia", type="string")
     */
    protected $agencia;

    /**
     * @ORM\Column(name="conta_corrente", type="string")
     */
    protected $contaCorrente;
    
    /**
     * @ORM\Column(name="conjunta", type="boolean")
     */
    protected $conjunta;

    /**
     * @ORM\Column(name="nome_conjunta", type="string")
     */
    protected $nomeConjunta;
    
    /**
     * @ORM\Column(name="cpf_conjunta", type="string")
     */
    protected $cpfConjunta;

    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    function getBanco() {
        return $this->banco;
    }

    function getAgencia() {
        return $this->agencia;
    }

    function getContaCorrente() {
        return $this->contaCorrente;
    }

    function getConjunta() {
        return $this->conjunta;
    }

    function getNomeConjunta() {
        return $this->nomeConjunta;
    }

    function getCpfConjunta() {
        return $this->cpfConjunta;
    }
   
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    function setContaCorrente($contaCorrente) {
        $this->contaCorrente = $contaCorrente;
    }

    function setConjunta($conjunta) {
        $this->conjunta = $conjunta;
    }

    function setNomeConjunta($nomeConjunta) {
        $this->nomeConjunta = $nomeConjunta;
    }
    
    function setCpfConjunta($cpfConjunta) {
        $this->cpfConjunta = $cpfConjunta;
    }
}

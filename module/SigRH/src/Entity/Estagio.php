<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Estagio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Estagio")
 * @ORM\Table(name="estagio")
 */
class Estagio extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Nivel")
     * @ORM\JoinColumn(name="nivel_id", referencedColumnName="id")
     * */
    protected $nivel; //nivel_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Curso")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/        
    protected $curso; //curso_id 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\FonteSeguro")
     * @ORM\JoinColumn(name="fonte_seguro_id", referencedColumnName="id")
     **/        
    protected $fonteSeguro; //fonte_seguro_id 
    
    
     /**
     * @ORM\Column(name="ano_inicio", type="integer")
     */
    protected $anoInicio; //ano_inicio

    /**
     * @ORM\Column(name="ano_previsao_conclusao", type="integer")
     */
    protected $anoPrevisaoConclusao; //ano_previsao_conclusao

    /**
     * @ORM\Column(name="serie", type="string")
     */
    protected $serie;
    
      /**
     * @ORM\Column(name="data_inicio_efetivo", type="datetime")
     */
    protected $dataInicioEfetivo; //data_inicio_efetivo
    
    /**
     * @ORM\Column(name="seguro_apolice", type="string")
     */
    protected $seguroApolice; //seguro_apolice
    

    /**
     * @ORM\Column(name="seguro_seguradora", type="string")
     */
    protected $seguroSeguradora; //seguro_seguradora
    
     /**
     * @ORM\Column(name="seguro_mensalidade", type="string")
     */
    protected $seguroMensalidade; //seguro_mensalidade

     /**
     * @ORM\Column(name="seguro_capital", type="string")
     */
    protected $seguroCapital; //seguro_capital
  
    

    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
   
    function getNivel() {
        return $this->nivel;
    }
    
    function getFonteSeguro() {
        return $this->fonteSeguro;
    }


    function getSerie() {
        return $this->serie;
    }
    function getCurso() {
        return $this->curso;
    }

        function getAnoInicio() {
        return $this->anoInicio;
    }

    function getAnoPrevisaoConclusao() {
        return $this->anoPrevisaoConclusao;
    }

    function getDataInicioEfetivo() {
        return $this->dataInicioEfetivo;
    }
    function getSeguroApolice() {
        return $this->seguroApolice;
    }

    function getSeguroSeguradora() {
        return $this->seguroSeguradora;
    }

    function getSeguroMensalidade() {
        return $this->seguroMensalidade;
    }

    function getSeguroCapital() {
        return $this->seguroCapital;
    }


    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setAnoInicio($anoInicio) {
        $this->anoInicio = $anoInicio;
    }

    function setCurso($curso) {
        $this->curso = $curso;
    }

    function setFonteSeguro($fonteSeguro) {
        $this->fonteSeguro = $fonteSeguro;
    }

    
    function setAnoPrevisaoConclusao($anoPrevisaoConclusao) {
        $this->anoPrevisaoConclusao = $anoPrevisaoConclusao;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setDataInicioEfetivo($dataInicioEfetivo) {
        $this->dataInicioEfetivo = $dataInicioEfetivo;
    }

    function setSeguroApolice($seguroApolice) {
        $this->seguroApolice = $seguroApolice;
    }

    function setSeguroSeguradora($seguroSeguradora) {
        $this->seguroSeguradora = $seguroSeguradora;
    }

    function setSeguroMensalidade($seguroMensalidade) {
        $this->seguroMensalidade = $seguroMensalidade;
    }

    function setSeguroCapital($seguroCapital) {
        $this->seguroCapital = $seguroCapital;
    }


    
}

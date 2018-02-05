<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Instituicao")
     * @ORM\JoinColumn(name="instituicao_id", referencedColumnName="cod_instituicao")
     **/        
    protected $instituicao; 
    
     /**
     * @ORM\Column(name="inicio", type="string")
     */
    protected $inicio; 

    /**
     * @ORM\Column(name="previsao_conclusao", type="string")
     */
    protected $previsaoConclusao; //previsao_conclusao

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
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */
    protected $colaboradorMatricula; //colaborador_matricula
    
    /**
     * @ORM\Column(name="pre_contrato", type="integer")
     */
    protected $preContrato;

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Sublotacao")
     * @ORM\JoinColumn(name="sublotacao_id", referencedColumnName="id")
     **/      
    protected $sublotacao;
    
    /**
     * @ORM\OneToMany(targetEntity="Termo", mappedBy="estagio")
     */
    protected $termos;
    
    /**
     * @ORM\Column(name="obrigatorio", type="boolean")
     */
    protected $obrigatorio;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Instituicao")
     * @ORM\JoinColumn(name="lotacao_id", referencedColumnName="cod_instituicao")
     **/        
    protected $lotacao;
    
     /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Localizacao")
     * @ORM\JoinColumn(name="localizacao_id", referencedColumnName="id")
     **/        
    protected $localizacao; 
    
    public function __construct() {
        $this->termos = new ArrayCollection();
    }
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

    function getInicio() {
        return $this->inicio;
    }

    function getPrevisaoConclusao() {
        return $this->previsaoConclusao;
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

    function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    function getInstituicao() {
        return $this->instituicao;
    }
    
    public function getPreContrato() {
        return $this->preContrato;
    }
    
    public function getSublotacao() {
        return $this->sublotacao;
    }
    
    public function getTermos() {
        return $this->termos;
    }
    
    public function getObrigatorio() {
        return $this->obrigatorio;
    }
    
    public function getLotacao() {
        return $this->lotacao;
    }

    public function getLocalizacao() {
        return $this->localizacao;
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

    function setCurso($curso) {
        $this->curso = $curso;
    }

    function setFonteSeguro($fonteSeguro) {
        $this->fonteSeguro = $fonteSeguro;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setPrevisaoConclusao($previsaoConclusao) {
        $this->previsaoConclusao = $previsaoConclusao;
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

    function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }
    
    public function setPreContrato($preContrato) {
        $this->preContrato = $preContrato;
    }
    
    public function setSublotacao($sublotacao) {
        $this->sublotacao = $sublotacao;
    }
    
    public function setTermos($termos) {
        $this->termos = $termos;
    }
    
    public function setObrigatorio($obrigatorio) {
        $this->obrigatorio = $obrigatorio;
    }
    
    public function setLotacao($lotacao) {
        $this->lotacao = $lotacao;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

}

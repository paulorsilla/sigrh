<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Estagio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Vinculo")
 * @ORM\Table(name="vinculo")
 */
class Vinculo extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Colaborador", inversedBy="vinculos")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */
    protected $colaboradorMatricula; //colaborador_matricula
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoVinculo")
     * @ORM\JoinColumn(name="tipo_vinculo_id", referencedColumnName="id") 
     */
    protected $tipoVinculo; //tipo_vinculo_id
    
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
     * @ORM\JoinColumn(name="instituicao_ensino_id", referencedColumnName="cod_instituicao")
     **/        
    protected $instituicaoEnsino; 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Instituicao")
     * @ORM\JoinColumn(name="instituicao_fomento_id", referencedColumnName="cod_instituicao")
     **/        
    protected $instituicaoFomento; 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\ModalidadeBolsa")
     * @ORM\JoinColumn(name="modalidade_bolsa_id", referencedColumnName="id")
     **/        
    protected $modalidadeBolsa; //modalidade_bolsa_id 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Colaborador")
     * @ORM\JoinColumn(name="orientador_matricula", referencedColumnName="matricula")
     **/        
    protected $orientador; //orientador_matricula 
   
     /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Localizacao")
     * @ORM\JoinColumn(name="localizacao_id", referencedColumnName="id")
     **/        
    protected $localizacao; 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Sublotacao")
     * @ORM\JoinColumn(name="sublotacao_id", referencedColumnName="id")
     **/      
    protected $sublotacao;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Cargo")
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
     **/      
    protected $cargo;
    
    /**
     * @ORM\OneToMany(targetEntity="RecessoObrigatorio", mappedBy="vinculo")
     **/
    protected $recessos;
    
    /**
     * @ORM\Column(name="atividade_id", type="integer") 
     */
    protected $atividade; //atividade -> buscar via serviço

     /**
     * @ORM\Column(name="plano_acao", type="string")
     */
    protected $planoAcao; 
    
     /**
     * @ORM\Column(name="aditivo", type="integer")
     */
    protected $aditivo; 
    
     /**
     * @ORM\Column(name="tipo_aditivo", type="string")
     */
    protected $tipoAditivo; 
    
    /**
     * @ORM\Column(name="inicio", type="string")
     */
    protected $inicio; 

    /**
     * @ORM\Column(name="previsao_conclusao", type="string")
     */
    protected $previsaoConclusao; //previsao_conclusao

    /**
     * @ORM\Column(name="data_inicio_efetivo", type="datetime")
     */
    protected $dataInicioEfetivo; //data_inicio_efetivo
    
     /**
     * @ORM\Column(name="data_inicio", type="datetime")
     */
    protected $dataInicio; 
    
     /**
     * @ORM\Column(name="data_termino", type="datetime")
     */
    protected $dataTermino; 
    
     /**
     * @ORM\Column(name="data_desligamento", type="datetime")
     */
    protected $dataDesligamento; 
    
     /**
     * @ORM\Column(name="ch_semanal", type="integer")
     */
    protected $chSemanal; 
    
     /**
     * @ORM\Column(name="horario_flexivel", type="boolean")
     */
    protected $horarioFlexivel; 
    
     /**
     * @ORM\Column(name="processo", type="string")
     */
    protected $processo; 
    
     /**
     * @ORM\Column(name="valor_bolsa", type="decimal")
     */
    protected $valorBolsa; 
    
    /**
     * @ORM\Column(name="seguro_apolice", type="string")
     */
    protected $seguroApolice; //seguro_apolice

    /**
     * @ORM\Column(name="seguro_seguradora", type="string")
     */
    protected $seguroSeguradora; //seguro_seguradora
    
    /**
     * @ORM\Column(name="tipo_contrato", type="integer")
     */
    protected $tipoContrato;
    
    /**
     * @ORM\Column(name="obrigatorio", type="integer")
     */
    protected $obrigatorio;
    
    /**
     * @ORM\Column(name="dias_recesso", type="integer")
     */
    protected $diasRecesso;
    
    /**
     * @ORM\Column(name="observacoes", type="string")
     */
    protected $observacoes;
    
    /**
     * One Vinculo has Many horarios
     * @ORM\OneToMany(targetEntity="Horario", mappedBy="vinculo")
     **/
    protected $horarios;
    
    public function __construct() {
        $this->recessos = new ArrayCollection();
        $this->horarios = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    public function getTipoVinculo() {
        return $this->tipoVinculo;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function getFonteSeguro() {
        return $this->fonteSeguro;
    }

    public function getInstituicaoEnsino() {
        return $this->instituicaoEnsino;
    }

    public function getInstituicaoFomento() {
        return $this->instituicaoFomento;
    }

    public function getModalidadeBolsa() {
        return $this->modalidadeBolsa;
    }

    public function getOrientador() {
        return $this->orientador;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getSublotacao() {
        return $this->sublotacao;
    }

    public function getAtividade() {
        return $this->atividade;
    }
    
    public function getPlanoAcao() {
        return $this->planoAcao;
    }

    public function getAditivo() {
        return $this->aditivo;
    }

    public function getTipoAditivo() {
        return $this->tipoAditivo;
    }

    public function getInicio() {
        return $this->inicio;
    }

    public function getPrevisaoConclusao() {
        return $this->previsaoConclusao;
    }

    public function getDataInicioEfetivo() {
        return $this->dataInicioEfetivo;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getDataTermino() {
        return $this->dataTermino;
    }

    public function getDataDesligamento() {
        return $this->dataDesligamento;
    }

    public function getChSemanal() {
        return $this->chSemanal;
    }

    public function getHorarioFlexivel() {
        return $this->horarioFlexivel;
    }

    public function getProcesso() {
        return $this->processo;
    }

    public function getValorBolsa() {
        return $this->valorBolsa;
    }

    public function getSeguroApolice() {
        return $this->seguroApolice;
    }

    public function getSeguroSeguradora() {
        return $this->seguroSeguradora;
    }

    public function getTipoContrato() {
        return $this->tipoContrato;
    }

    public function getObrigatorio() {
        return $this->obrigatorio;
    }
    
    public function getDiasRecesso() {
        return $this->diasRecesso;
    }

    public function getObservacoes() {
        return $this->observacoes;
    }
    
    public function getRecessos() {
        return $this->recessos;
    }

    public function getCargo() {
        return $this->cargo;
    }
    
    public function getHorarios()
    {
        return $this->horarios;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    public function setTipoVinculo($tipoVinculo) {
        $this->tipoVinculo = $tipoVinculo;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function setFonteSeguro($fonteSeguro) {
        $this->fonteSeguro = $fonteSeguro;
    }

    public function setInstituicaoEnsino($instituicaoEnsino) {
        $this->instituicaoEnsino = $instituicaoEnsino;
    }

    public function setInstituicaoFomento($instituicaoFomento) {
        $this->instituicaoFomento = $instituicaoFomento;
    }

    public function setModalidadeBolsa($modalidadeBolsa) {
        $this->modalidadeBolsa = $modalidadeBolsa;
    }

    public function setOrientador($orientador) {
    if ( empty($orientador) )
        $this->orientador = null;
    else
        $this->orientador = $orientador;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setSublotacao($sublotacao) {
        $this->sublotacao = $sublotacao;
    }

    public function setAtividade($atividade) {
    if ( empty($atividade) )
        $this->atividade = null;
    else
        $this->atividade = $atividade;
    }

    public function setPlanoAcao($planoAcao) {
        $this->planoAcao = $planoAcao;
    }

    public function setAditivo($aditivo) {
        if ( empty($aditivo) )
            $this->aditivo = null;
        else
            $this->aditivo = $aditivo;
    }

    public function setTipoAditivo($tipoAditivo) {
    if ( empty($tipoAditivo) )
        $this->tipoAditivo = null;
    else
        $this->tipoAditivo = $tipoAditivo;
    }

    public function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    public function setPrevisaoConclusao($previsaoConclusao) {
        $this->previsaoConclusao = $previsaoConclusao;
    }

    public function setDataInicioEfetivo($dataInicioEfetivo) {
        $this->dataInicioEfetivo = $dataInicioEfetivo;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    public function setDataDesligamento($dataDesligamento) {
        $this->dataDesligamento = $dataDesligamento;
    }

    public function setChSemanal($chSemanal) { // TODA VEZ QUE O CAMPO FOR INTEGER, VALIDAR SE O CONTEUDO FOR '' E CONVERTE-LO PARA NULL
        if ( empty($chSemanal) ) 
            $this->chSemanal = null;
        else
            $this->chSemanal = $chSemanal;
    }

    public function setHorarioFlexivel($horarioFlexivel) {
        $this->horarioFlexivel = $horarioFlexivel;
    }

    public function setProcesso($processo) {
        $this->processo = $processo;
    }

    public function setValorBolsa($valorBolsa) {
        if ( empty($valorBolsa) ) {
            
            $this->valorBolsa = null;
        } else {
            $this->valorBolsa = $valorBolsa;
        }
    }
    
    public function setSeguroApolice($seguroApolice) {
        $this->seguroApolice = $seguroApolice;
    }

    public function setSeguroSeguradora($seguroSeguradora) {
        $this->seguroSeguradora = $seguroSeguradora;
    }

    public function setTipoContrato($tipoContrato) {
        $this->tipoContrato = $tipoContrato;
    }

    public function setObrigatorio($obrigatorio) {
        if ( $obrigatorio == "") {
            $this->obrigatorio = null;
        }
        else {
            $this->obrigatorio = $obrigatorio;
        }
    }
    
    public function setDiasRecesso($diasRecesso) {
        $this->diasRecesso = $diasRecesso;
    }

    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }
    
    public function setRecessos($recessos) {
        $this->recessos = $recessos;
    }
    
    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }
    
    public function setHorarios($horarios)
    {
        $this->horarios = $horarios;
    }

}

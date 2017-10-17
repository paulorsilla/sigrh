<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Estagio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Termo")
 * @ORM\Table(name="termo")
 */
class Termo extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\ModalidadeBolsa")
     * @ORM\JoinColumn(name="modalidade_bolsa_id", referencedColumnName="id")
     **/        
    protected $modalidadeBolsa; //modalidade_bolsa_id 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Colaborador")
     * @ORM\JoinColumn(name="orientador", referencedColumnName="id")
     **/        
    protected $orientador; //orientador 
    
    /**
     * @ORM\Column(name="instituicao_fomento", type="integer") 
     */
    protected $instituicao; //instituicao -> buscar via serviço
    
    /**
     * @ORM\Column(name="plano_acao", type="integer") 
     */
    protected $planoAcao; //plano_acao -> buscar via serviço
    
     /**
     * @ORM\Column(name="aditivo", type="string")
     */
    protected $aditivo; 
    
     /**
     * @ORM\Column(name="tipo_aditivo", type="string")
     */
    protected $tipoAditivo; 
    
     /**
     * @ORM\Column(name="data_inicio", type="string")
     */
    protected $dataInicio; 
    
     /**
     * @ORM\Column(name="data_termino", type="string")
     */
    protected $dataTermino; 
    
     /**
     * @ORM\Column(name="ch_semanal", type="string")
     */
    protected $chSemanal; 
    
     /**
     * @ORM\Column(name="horario_flexivel", type="string")
     */
    protected $horarioFlexivel; 
    
     /**
     * @ORM\Column(name="processo", type="string")
     */
    protected $processo; 
    
     /**
     * @ORM\Column(name="valor_bolsa", type="string")
     */
    protected $valorBolsa; 
    
    
    
    
    
    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    function getModalidadeBolsa() {
        return $this->modalidadeBolsa;
    }

    function getOrientador() {
        return $this->orientador;
    }

    function getInstituicao() {
        return $this->instituicao;
    }

    function getPlanoAcao() {
        return $this->planoAcao;
    }

    function getAditivo() {
        return $this->aditivo;
    }

    function getTipoAditivo() {
        return $this->tipoAditivo;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataTermino() {
        return $this->dataTermino;
    }

    function getChSemanal() {
        return $this->chSemanal;
    }

    function getHorarioFlexivel() {
        return $this->horarioFlexivel;
    }

    function getProcesso() {
        return $this->processo;
    }

    function getValorBolsa() {
        return $this->valorBolsa;
    }

    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }

    function setModalidadeBolsa($modalidadeBolsa) {
        $this->modalidadeBolsa = $modalidadeBolsa;
    }

    function setOrientador($orientador) {
        $this->orientador = $orientador;
    }

    function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }

    function setPlanoAcao($planoAcao) {
        $this->planoAcao = $planoAcao;
    }

    function setAditivo($aditivo) {
        $this->aditivo = $aditivo;
    }

    function setTipoAditivo($tipoAditivo) {
        $this->tipoAditivo = $tipoAditivo;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    function setChSemanal($chSemanal) {
        $this->chSemanal = $chSemanal;
    }

    function setHorarioFlexivel($horarioFlexivel) {
        $this->horarioFlexivel = $horarioFlexivel;
    }

    function setProcesso($processo) {
        $this->processo = $processo;
    }

    function setValorBolsa($valorBolsa) {
        $this->valorBolsa = $valorBolsa;
    }


    
}

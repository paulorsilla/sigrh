<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe convenio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Convenio")
 * @ORM\Table(name="convenio")
 */
class Convenio extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Instituicao")
     * @ORM\JoinColumn(name="instituicao_id", referencedColumnName="cod_instituicao")
     **/        
    protected $instituicao; //instituicao_id 
    

    /**
     * @ORM\Column(name="tipo", type="integer")
     */
    protected $tipo;

    /**
     * @ORM\Column(name="convenio_numero", type="string")
     */
    protected $convenioNumero;

    /**
     * @ORM\Column(name="convenio_inicio", type="datetime")
     */
    protected $convenioInicio;

    /**
     * @ORM\Column(name="convenio_termino", type="datetime")
     */
    protected $convenioTermino;
    
    /**
     * @ORM\Column(name="responsavel_nome", type="string")
     */
    protected $responsavelNome;
    
    /**
     * @ORM\Column(name="responsavel_cargo", type="string")
     */
    protected $responsavelCargo;
    
    /**
     * @ORM\Column(name="responsavel_rg_numero", type="string")
     */
    protected $responsavelRgNumero;
    
    
    /**
     * @ORM\Column(name="responsavel_cpf_numero", type="string")
     */
    protected $responsavelCpfNumero;
    
    /**
     * @ORM\Column(name="responsavel_rg_emissor", type="string")
     */
    protected $responsavelRgEmissor;

    /**
     * @ORM\Column(name="responsavel_rg_data_emissao", type="datetime") 
     */
    protected $responsavelRgDataEmissao;
    
    /**
     * @ORM\Column(name="responsavel_descricao_juridica", type="string")
     */
    protected $responsavelDescricaoJuridica;
    
    /**
     * @ORM\Column(name="descricao_juridica", type="string")
     */
    protected $descricaoJuridica;
    
    /**
     * @ORM\Column(name="observacoes", type="string")
     */
    protected $observacoes;
    
    
    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    function getInstituicao() {
        return $this->instituicao;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getConvenioNumero() {
        return $this->convenioNumero;
    }

    function getConvenioInicio() {
        return $this->convenioInicio;
    }

    function getConvenioTermino() {
        return $this->convenioTermino;
    }

    function getResponsavelNome() {
        return $this->responsavelNome;
    }

    function getResponsavelCargo() {
        return $this->responsavelCargo;
    }

    function getResponsavelCpfNumero() {
        return $this->responsavelCpfNumero;
    }
    
    function getResponsavelRgNumero() {
        return $this->responsavelRgNumero;
    }

        
    function getResponsavelRgEmissor() {
        return $this->responsavelRgEmissor;
    }

    function getResponsavelRgDataEmissao() {
        return $this->responsavelRgDataEmissao;
    }

        function getResponsavelDescricaoJuridica() {
        return $this->responsavelDescricaoJuridica;
    }

    function getDescricaoJuridica() {
        return $this->descricaoJuridica;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    
    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }

    function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setConvenioNumero($convenioNumero) {
        $this->convenioNumero = $convenioNumero;
    }

    function setConvenioInicio($convenioInicio) {
        $this->convenioInicio = $convenioInicio;
    }

    function setConvenioTermino($convenioTermino) {
        $this->convenioTermino = $convenioTermino;
    }

    function setResponsavelNome($responsavelNome) {
        $this->responsavelNome = $responsavelNome;
    }

    function setResponsavelCargo($responsavelCargo) {
        $this->responsavelCargo = $responsavelCargo;
    }

    function setResponsavelCpfNumero($responsavelCpfNumero) {
        $this->responsavelCpfNumero = $responsavelCpfNumero;
    }

    function setResponsavelRgNumero($responsavelRgNumero) {
        $this->responsavelRgNumero = $responsavelRgNumero;
    }

        
    function setResponsavelRgEmissor($responsavelRgEmissor) {
        $this->responsavelRgEmissor = $responsavelRgEmissor;
    }

    function setResponsavelRgDataEmissao($responsavelRgDataEmissao) {
        $this->responsavelRgDataEmissao = $responsavelRgDataEmissao;
    }

        function setResponsavelDescricaoJuridica($responsavelDescricaoJuridica) {
        $this->responsavelDescricaoJuridica = $responsavelDescricaoJuridica;
    }

    function setDescricaoJuridica($descricaoJuridica) {
        $this->descricaoJuridica = $descricaoJuridica;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    

}

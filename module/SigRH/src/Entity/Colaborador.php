<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Colaborador.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Colaborador")
 * @ORM\Table(name="colaborador")
 */
class Colaborador extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="matricula")
     */
    protected $matricula;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\TipoColaborador")
     * @ORM\JoinColumn(name="tipo_colaborador_id", referencedColumnName="id")
     **/        
    protected $tipoColaborador; //tipo_colaborador_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\LinhaOnibus")
     * @ORM\JoinColumn(name="linha_onibus_id", referencedColumnName="id")
     **/        
    protected $linhaOnibus; //linha_onibus_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Endereco")
     * @ORM\JoinColumn(name="endereco_id", referencedColumnName="id")
     **/        
    protected $endereco; //endereco_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\GrupoSanguineo")
     * @ORM\JoinColumn(name="grupo_sanguineo_id", referencedColumnName="id")
     **/        
    protected $grupoSanguineo; //grupo_sanguineo_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\GrauInstrucao")
     * @ORM\JoinColumn(name="grau_instrucao_id", referencedColumnName="id")
     **/        
    protected $grauInstrucao; //grau_instrucao_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\CorPele")
     * @ORM\JoinColumn(name="cor_pele_id", referencedColumnName="id")
     **/        
    protected $corPele; //cor_pele_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\EstadoCivil")
     * @ORM\JoinColumn(name="estado_civil_id", referencedColumnName="id")
     **/        
    protected $estadoCivil; //estado_civil_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Cidade")
     * @ORM\JoinColumn(name="natural", referencedColumnName="id")
     **/        
    protected $natural; //cidade_id
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Estado")
     * @ORM\JoinColumn(name="ctps_uf", referencedColumnName="id")
     **/        
    protected $ctps_uf; //ctps_uf
    

    /**    
     ** One colaborador has responsavel.
     * @ORM\OneToOne(targetEntity="Colaborador")     
     * @ORM\JoinColumn(name="responsavel", referencedColumnName="matricula")     
     **/
    private $responsavel;
    
    /**
     * @ORM\Column(name="nome", type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(name="apelido", type="string")
     */
    protected $apelido;
    
    /**
     * @ORM\Column(name="foto", type="string")
     */
    protected $foto;
    
    /**
     * @ORM\Column(name="data_admissao", type="datetime")
     */
    protected $data_admissao;

    /**
     * @ORM\Column(name="data_desligamento", type="datetime")
     */
    protected $data_desligamento;
    
    /**
     * @ORM\Column(name="data_nascimento", type="datetime")
     */
    protected $data_nascimento;
    
    /**
     * @ORM\Column(name="sexo", type="string")
     */
    protected $sexo;
    
    /**
     * @ORM\Column(name="nacionalidade", type="string")
     */
    protected $nacionalidade;

    /**
     * @ORM\Column(name="nome_pai", type="string")
     */
    protected $nome_pai;

    /**
     * @ORM\Column(name="nome_mae", type="string")
     */
    protected $nome_mae;
    
        /**
     * @ORM\Column(name="telefone_residencial", type="string")
     */
    protected $telefone_residencial;

        /**
     * @ORM\Column(name="telefone_celular", type="string")
     */
    protected $telefone_celular;

        /**
     * @ORM\Column(name="ramal", type="string")
     */
    protected $ramal;

        /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="login_sede", type="string")
     */
    protected $login_sede;

    /**
     * @ORM\Column(name="login_local", type="string")
     */
    protected $login_local;

    /**
     * @ORM\Column(name="email_corporativo", type="string")
     */
    protected $email_corporativo;

    /**
     * @ORM\Column(name="rg_numero", type="string")
     */
    protected $rg_numero;
    
    /**
     * @ORM\Column(name="rg_data_emissao", type="string")
     */
    protected $rg_data_emissao;
    
    /**
     * @ORM\Column(name="rg_orgao_expedidor", type="string")
     */
    protected $rg_orgao_expedidor;
    
    /**
     * @ORM\Column(name="cpf", type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(name="ctps_numero", type="string")
     */
    protected $ctps_numero;

    /**
     * @ORM\Column(name="ctps_serie", type="string")
     */
    protected $ctps_serie;

    /**
     * @ORM\Column(name="ctps_data_expedicao", type="string")
     */
    protected $ctps_data_expedicao;
    
    /**
     * @ORM\Column(name="pis", type="string")
     */
    protected $pis;

    
    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getTipoColaborador() {
        return $this->tipoColaborador;
    }

    function getLinhaOnibus() {
        return $this->linhaOnibus;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getGrupoSanguineo() {
        return $this->grupoSanguineo;
    }

    function getGrauInstrucao() {
        return $this->grauInstrucao;
    }

    function getCorPele() {
        return $this->corPele;
    }

    function getEstadoCivil() {
        return $this->estadoCivil;
    }

    function getNatural() {
        return $this->natural;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getNome() {
        return $this->nome;
    }

    function getApelido() {
        return $this->apelido;
    }


    function getFoto() {
        return $this->foto;
    }

    function getData_admissao() {
        return $this->data_admissao;
    }

    function getData_desligamento() {
        return $this->data_desligamento;
    }

    function getData_nascimento() {
        return $this->data_nascimento;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getNome_pai() {
        return $this->nome_pai;
    }

    function getNome_mae() {
        return $this->nome_mae;
    }

    function getTelefone_residencial() {
        return $this->telefone_residencial;
    }

    function getTelefone_celular() {
        return $this->telefone_celular;
    }

    function getRamal() {
        return $this->ramal;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogin_sede() {
        return $this->login_sede;
    }

    function getLogin_local() {
        return $this->login_local;
    }

    function getEmail_corporativo() {
        return $this->email_corporativo;
    }

    function getRg_numero() {
        return $this->rg_numero;
    }

    function getRg_data_emissao() {
        return $this->rg_data_emissao;
    }

    function getRg_orgao_expedidor() {
        return $this->rg_orgao_expedidor;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getCtps_numero() {
        return $this->ctps_numero;
    }

    function getCtps_serie() {
        return $this->ctps_serie;
    }

    function getCtps_data_expedicao() {
        return $this->ctps_data_expedicao;
    }

    function getCtps_uf() {
        return $this->ctps_uf;
    }

    function getPis() {
        return $this->pis;
    }

    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    function setTipoColaborador($tipoColaborador) {
        $this->tipoColaborador = $tipoColaborador;
    }

    function setLinhaOnibus($linhaOnibus) {
        $this->linhaOnibus = $linhaOnibus;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setGrupoSanguineo($grupoSanguineo) {
        $this->grupoSanguineo = $grupoSanguineo;
    }

    function setGrauInstrucao($grauInstrucao) {
        $this->grauInstrucao = $grauInstrucao;
    }

    function setCorPele($corPele) {
        $this->corPele = $corPele;
    }

    function setEstadoCivil($estadoCivil) {
        $this->estadoCivil = $estadoCivil;
    }

    function setNatural($natural) {
        $this->natural = $natural;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setApelido($apelido) {
        $this->apelido = $apelido;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setData_admissao($data_admissao) {
        $this->data_admissao = $data_admissao;
    }

    function setData_desligamento($data_desligamento) {
        $this->data_desligamento = $data_desligamento;
    }

    function setData_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setNome_pai($nome_pai) {
        $this->nome_pai = $nome_pai;
    }

    function setNome_mae($nome_mae) {
        $this->nome_mae = $nome_mae;
    }

    function setTelefone_residencial($telefone_residencial) {
        $this->telefone_residencial = $telefone_residencial;
    }

    function setTelefone_celular($telefone_celular) {
        $this->telefone_celular = $telefone_celular;
    }

    function setRamal($ramal) {
        $this->ramal = $ramal;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogin_sede($login_sede) {
        $this->login_sede = $login_sede;
    }

    function setLogin_local($login_local) {
        $this->login_local = $login_local;
    }

    function setEmail_corporativo($email_corporativo) {
        $this->email_corporativo = $email_corporativo;
    }

    function setRg_numero($rg_numero) {
        $this->rg_numero = $rg_numero;
    }

    function setRg_data_emissao($rg_data_emissao) {
        $this->rg_data_emissao = $rg_data_emissao;
    }

    function setRg_orgao_expedidor($rg_orgao_expedidor) {
        $this->rg_orgao_expedidor = $rg_orgao_expedidor;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setCtps_numero($ctps_numero) {
        $this->ctps_numero = $ctps_numero;
    }

    function setCtps_serie($ctps_serie) {
        $this->ctps_serie = $ctps_serie;
    }

    function setCtps_data_expedicao($ctps_data_expedicao) {
        $this->ctps_data_expedicao = $ctps_data_expedicao;
    }

    function setCtps_uf($ctps_uf) {
        $this->ctps_uf = $ctps_uf;
    }

    function setPis($pis) {
        $this->pis = $pis;
    }


    
}

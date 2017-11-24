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
     * @ORM\Column(name="matricula", type="string")
     */
    protected $matricula;

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\TipoColaborador")
     * @ORM\JoinColumn(name="tipo_colaborador_id", referencedColumnName="id")
     * */
    protected $tipoColaborador; //tipo_colaborador_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\LinhaOnibus")
     * @ORM\JoinColumn(name="linha_onibus_id", referencedColumnName="id")
     * */
    protected $linhaOnibus; //linha_onibus_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Endereco")
     * @ORM\JoinColumn(name="endereco_id", referencedColumnName="id")
     * */
    protected $endereco; //endereco_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\GrupoSanguineo")
     * @ORM\JoinColumn(name="grupo_sanguineo_id", referencedColumnName="id")
     * */
    protected $grupoSanguineo; //grupo_sanguineo_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\GrauInstrucao")
     * @ORM\JoinColumn(name="grau_instrucao_id", referencedColumnName="id")
     * */
    protected $grauInstrucao; //grau_instrucao_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\CorPele")
     * @ORM\JoinColumn(name="cor_pele_id", referencedColumnName="id")
     * */
    protected $corPele; //cor_pele_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\EstadoCivil")
     * @ORM\JoinColumn(name="estado_civil_id", referencedColumnName="id")
     * */
    protected $estadoCivil; //estado_civil_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Cidade")
     * @ORM\JoinColumn(name="natural_id", referencedColumnName="id")
     * */
    protected $natural; //cidade_id

    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Estado")
     * @ORM\JoinColumn(name="ctps_uf_id", referencedColumnName="id")
     * */
    protected $ctpsUf; //ctps_uf_id

    /**
     * * One colaborador has supervisor
     * @ORM\OneToOne(targetEntity="Colaborador")     
     * @ORM\JoinColumn(name="supervisor_id", referencedColumnName="matricula")     
     * */
    private $supervisor;
    
    /**
     * Many Colaboradores have Many Contas Corrente.
     * @ORM\ManyToMany(targetEntity="ContaCorrente")
     * @ORM\JoinTable(name="colaborador_conta_corrente",
     *      joinColumns={@ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="conta_corrente_id", referencedColumnName="id")}
     *      )
     */
    protected $contasCorrente;
    
    /**
     * One Colaborador has Many dependentes
     * @ORM\OneToMany(targetEntity="Dependente", mappedBy="colaboradorMatricula")
     */
    protected $dependentes;

    /**
     * One Colaborador has Many estagios
     * @ORM\OneToMany(targetEntity="Dependente", mappedBy="colaboradorMatricula")
     */
    protected $estagios;

    /**
     * One Colaborador has Many horarios
     * @ORM\OneToMany(targetEntity="Horario", mappedBy="colaboradorMatricula")
     */
    protected $horarios;
    
    /**
     * One Colaborador has Many crachas
     * @ORM\OneToMany(targetEntity="Cracha", mappedBy="colaboradorMatricula")
     */
    protected $crachas;
    
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
    protected $dataAdmissao;

    /**
     * @ORM\Column(name="data_desligamento", type="datetime")
     */
    protected $dataDesligamento;

    /**
     * @ORM\Column(name="data_nascimento", type="datetime")
     */
    protected $dataNascimento;

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
    protected $nomePai;

    /**
     * @ORM\Column(name="nome_mae", type="string")
     */
    protected $nomeMae;

    /**
     * @ORM\Column(name="telefone_residencial", type="string")
     */
    protected $telefoneResidencial;

    /**
     * @ORM\Column(name="telefone_celular", type="string")
     */
    protected $telefoneCelular;

    /**
     * @ORM\Column(name="ramal", type="string")
     */
    protected $ramal;

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="necessidade_especial", type="boolean")
     */
    protected $necessidadeEspecial;
    
    /**
     * @ORM\Column(name="login_sede", type="string")
     */
    protected $loginSede;

    /**
     * @ORM\Column(name="login_local", type="string")
     */
    protected $loginLocal;

    /**
     * @ORM\Column(name="email_corporativo", type="string")
     */
    protected $emailCorporativo;

    /**
     * @ORM\Column(name="rg_numero", type="string")
     */
    protected $rgNumero;

    /**
     * @ORM\Column(name="rg_data_emissao", type="datetime")
     */
    protected $rgDataEmissao;

    /**
     * @ORM\Column(name="rg_orgao_expedidor", type="string")
     */
    protected $rgOrgaoExpedidor;

    /**
     * @ORM\Column(name="cpf", type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(name="ctps_numero", type="string")
     */
    protected $ctpsNumero;

    /**
     * @ORM\Column(name="ctps_serie", type="string")
     */
    protected $ctpsSerie;

    /**
     * @ORM\Column(name="ctps_data_expedicao", type="datetime")
     */
    protected $ctpsDataExpedicao;

    /**
     * @ORM\Column(name="pis", type="string")
     */
    protected $pis;

    /*
     * Construtor da classe Colaborador
     */
    
    public function __construct() {
        $this->contasCorrente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->crachas = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    function getSupervisor() {
        return $this->supervisor;
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

    function getDataAdmissao() {
        return $this->dataAdmissao;
    }

    function getDataDesligamento() {
        return $this->dataDesligamento;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getNomePai() {
        return $this->nomePai;
    }

    function getNomeMae() {
        return $this->nomeMae;
    }

    function getTelefoneResidencial() {
        return $this->telefoneResidencial;
    }

    function getTelefoneCelular() {
        return $this->telefoneCelular;
    }

    function getRamal() {
        return $this->ramal;
    }

    function getEmail() {
        return $this->email;
    }

    function getLoginSede() {
        return $this->loginSede;
    }

    function getLoginLocal() {
        return $this->loginLocal;
    }

    function getEmailCorporativo() {
        return $this->emailCorporativo;
    }

    function getRgNumero() {
        return $this->rgNumero;
    }

    function getRgDataEmissao() {
        return $this->rgDataEmissao;
    }

    function getRgOrgaoExpedidor() {
        return $this->rgOrgaoExpedidor;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getCtpsNumero() {
        return $this->ctpsNumero;
    }

    function getCtpsSerie() {
        return $this->ctpsSerie;
    }

    function getCtpsDataExpedicao() {
        return $this->ctpsDataExpedicao;
    }

    function getCtpsUf() {
        return $this->ctpsUf;
    }

    function getPis() {
        return $this->pis;
    }
    
    function getContasCorrente() {
        return $this->contasCorrente;
    }

    function getNecessidadeEspecial() {
        return $this->necessidadeEspecial;
    }
    
    function getDependentes() {
        return $this->dependentes;
    }
    
    function getEstagios() {
        return $this->estagios;
    }

    public function getHorarios() {
        return $this->horarios;
    }
    
    public function getCrachas() {
        return $this->crachas;
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

    function setSupervisor($supervisor) {
        $this->supervisor = $supervisor;
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

    function setDataAdmissao($dataAdmissao) {
        $this->dataAdmissao = $dataAdmissao;
    }

    function setDataDesligamento($dataDesligamento) {
        $this->dataDesligamento = $dataDesligamento;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setNomePai($nomePai) {
        $this->nomePai = $nomePai;
    }

    function setNomeMae($nomeMae) {
        $this->nomeMae = $nomeMae;
    }

    function setTelefoneResidencial($telefoneResidencial) {
        $this->telefoneResidencial = $telefoneResidencial;
    }

    function setTelefoneCelular($telefoneCelular) {
        $this->telefoneCelular = $telefoneCelular;
    }

    function setRamal($ramal) {
        $this->ramal = $ramal;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogin_sede($loginSede) {
        $this->loginSede = $loginSede;
    }

    function setLoginLocal($loginLocal) {
        $this->loginLocal = $loginLocal;
    }

    function setEmailCorporativo($emailCorporativo) {
        $this->emailCorporativo = $emailCorporativo;
    }

    function setRgNumero($rgNumero) {
        $this->rgNumero = $rgNumero;
    }

    function setRgDataEmissao($rgDataEmissao) {
        $this->rgDataEmissao = $rgDataEmissao;
    }

    function setRgOrgaoExpedidor($rgOrgaoExpedidor) {
        $this->rgOrgaoExpedidor = $rgOrgaoExpedidor;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setCtpsNumero($ctpsNumero) {
        $this->ctpsNumero = $ctpsNumero;
    }

    function setCtpsSerie($ctpsSerie) {
        $this->ctpsSerie = $ctpsSerie;
    }

    function setCtpsDataExpedicao($ctpsDataExpedicao) {
        $this->ctpsDataExpedicao = $ctpsDataExpedicao;
    }

    function setCtps_uf($ctpsUf) {
        $this->ctpsUf = $ctpsUf;
    }

    function setPis($pis) {
        $this->pis = $pis;
    }
    
    function setCtpsUf($ctpsUf) {
        $this->ctpsUf = $ctpsUf;
    }

    function setContasCorrente($contasCorrente) {
        $this->contasCorrente = $contasCorrente;
    }

    function setNecessidadeEspecial($necessidadeEspecial) {
        $this->necessidadeEspecial = $necessidadeEspecial;
    }

    function setLoginSede($loginSede) {
        $this->loginSede = $loginSede;
    }
    
    function setDependentes($dependentes) {
        $this->dependentes = $dependentes;
    }
    
    function setEstagios($estagios) {
        $this->estagios = $estagios;
    }
    
    public function setCrachas($crachas) {
        $this->crachas = $crachas;
    }

}

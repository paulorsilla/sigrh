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
     * @ORM\Column(type="string", name="des_lideranca")
     */
    protected $lideranca;

    /**
     * @ORM\Column(type="string", name="des_endereco")
     */
    protected $endereco;

    /**
     * @ORM\Column(type="string", name="des_bairro")
     */
    protected $bairro;

    /**
     * @ORM\Column(type="string", name="des_fone1")
     */
    protected $telefone;

    /**
     * @ORM\Column(type="string", name="des_fone2")
     */
    protected $telefone2;

    /**
     * @ORM\Column(type="string", name="des_fone3")
     */
    protected $telefone3;

    /**
     * @ORM\Column(type="string", name="des_fax")
     */
    protected $fax;

    /**
     * @ORM\Column(type="string", name="des_cxpostal")
     */
    protected $caixaPostal;

    /**
     * @ORM\Column(type="string", name="des_cep")
     */
    protected $cep;

    /**
     * @ORM\Column(type="string", name="des_cidade")
     */
    protected $cidade;

    /**
     * @ORM\Column(type="string", name="des_uf")
     */
    protected $uf;

    /**
     * @ORM\Column(type="string", name="des_regiao")
     */
    protected $regiao;

    /**
     * @ORM\Column(type="string", name="des_cnpj_cpf")
     */
    protected $cnpj;

    /**
     * @ORM\Column(type="string", name="des_ins_estadual")
     */
    protected $inscricaoEstadual;

    /**
     * @ORM\Column(type="string", name="des_homepage")
     */
    protected $homepage;

    /**
     * @ORM\Column(type="string", name="des_email")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="des_tip_instituicao")
     */
    protected $tipoInstituicao;

    /**
     * @ORM\Column(type="string", name="des_ramo")
     */
    protected $ramo;

    /**
     * @ORM\Column(type="string", name="dat_atualiz")
     */
    protected $dataAtualizacao;

    /**
     * @ORM\Column(type="string", name="des_situacao")
     */
    protected $situacao;

    /**
     * @ORM\Column(type="string", name="des_obs_inst")
     */
    protected $observacao;

    /**
     * @ORM\Column(type="string", name="des_newsletter")
     */
    protected $recebeNewsletter;

    /**
     * @ORM\Column(type="string", name="des_pais")
     */
    protected $pais;

    /**
     * @ORM\Column(type="string", name="des_logomarca")
     */
    protected $logomarca;

    /**
     * @ORM\Column(type="string", name="des_ativo")
     */
    protected $ativo;

    /**
     * @ORM\Column(type="string", name="des_inadimplente")
     */
    protected $inadimplente;

    /**
     * @ORM\Column(type="string", name="des_senha")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string", name="dat_nascimento_fundacao")
     */
    protected $dataNascimentoFundacao;

    /**
     * @ORM\Column(type="string", name="des_estadocivil")
     */
    protected $estadoCivil;

    /**
     * @ORM\Column(type="string", name="des_sexo")
     */
    protected $sexo;

    /**
     * @ORM\Column(type="integer", name="info_embrapa")
     */
    protected $infoEmbrapa;

    /**
     * @ORM\Column(type="string", name="des_passaporte")
     */
    protected $passaporte;

    /**
     * @ORM\Column(type="datetime", name="dat_inclusao")
     */
    protected $dataInclusao;

    /**
     * @ORM\Column(type="string", name="des_inclusao")
     */
    protected $inclusao;

    /**
     * @ORM\Column(type="datetime", name="dat_alteracao")
     */
    protected $dataAlteracao;

    /**
     * @ORM\Column(type="string", name="des_alteracao")
     */
    protected $alteracao;

    /**
     * @ORM\Column(type="integer", name="profissao_formacao_id")
     */
    protected $formacao;

    /**
     * @ORM\Column(type="integer", name="profissao_profissao_id")
     */
    protected $profissao;

    /**
     * @ORM\Column(type="integer", name="cargo_id")
     */
    protected $cargo;

    /**
     * @ORM\Column(type="integer", name="subcategoria_id")
     */
    protected $subcategoria;

    /**
     * @ORM\Column(type="integer", name="categoria_id")
     */
    protected $categoria;

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

    public function getLideranca() {
        return $this->lideranca;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getTelefone2() {
        return $this->telefone2;
    }

    public function getTelefone3() {
        return $this->telefone3;
    }

    public function getFax() {
        return $this->fax;
    }

    public function getCaixaPostal() {
        return $this->caixaPostal;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getRegiao() {
        return $this->regiao;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getInscricaoEstadual() {
        return $this->inscricaoEstadual;
    }

    public function getHomepage() {
        return $this->homepage;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTipoInstituicao() {
        return $this->tipoInstituicao;
    }

    public function getRamo() {
        return $this->ramo;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getRecebeNewsletter() {
        return $this->recebeNewsletter;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getLogomarca() {
        return $this->logomarca;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getInadimplente() {
        return $this->inadimplente;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataNascimentoFundacao() {
        return $this->dataNascimentoFundacao;
    }

    public function getEstadoCivil() {
        return $this->estadoCivil;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getInfoEmbrapa() {
        return $this->infoEmbrapa;
    }

    public function getPassaporte() {
        return $this->passaporte;
    }

    public function getDataInclusao() {
        return $this->dataInclusao;
    }

    public function getInclusao() {
        return $this->inclusao;
    }

    public function getDataAlteracao() {
        return $this->dataAlteracao;
    }

    public function getAlteracao() {
        return $this->alteracao;
    }

    public function getFormacao() {
        return $this->formacao;
    }

    public function getProfissao() {
        return $this->profissao;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function getSubcategoria() {
        return $this->subcategoria;
    }

    public function getCategoria() {
        return $this->categoria;
    }

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

    public function setLideranca($lideranca) {
        $this->lideranca = $lideranca;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    public function setTelefone3($telefone3) {
        $this->telefone3 = $telefone3;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function setCaixaPostal($caixaPostal) {
        $this->caixaPostal = $caixaPostal;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function setRegiao($regiao) {
        $this->regiao = $regiao;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setInscricaoEstadual($inscricaoEstadual) {
        $this->inscricaoEstadual = $inscricaoEstadual;
    }

    public function setHomepage($homepage) {
        $this->homepage = $homepage;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTipoInstituicao($tipoInstituicao) {
        $this->tipoInstituicao = $tipoInstituicao;
    }

    public function setRamo($ramo) {
        $this->ramo = $ramo;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setRecebeNewsletter($recebeNewsletter) {
        $this->recebeNewsletter = $recebeNewsletter;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setLogomarca($logomarca) {
        $this->logomarca = $logomarca;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setInadimplente($inadimplente) {
        $this->inadimplente = $inadimplente;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setDataNascimentoFundacao($dataNascimentoFundacao) {
        $this->dataNascimentoFundacao = $dataNascimentoFundacao;
    }

    public function setEstadoCivil($estadoCivil) {
        $this->estadoCivil = $estadoCivil;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setInfoEmbrapa($infoEmbrapa) {
        $this->infoEmbrapa = $infoEmbrapa;
    }

    public function setPassaporte($passaporte) {
        $this->passaporte = $passaporte;
    }

    public function setDataInclusao($dataInclusao) {
        $this->dataInclusao = $dataInclusao;
    }

    public function setInclusao($inclusao) {
        $this->inclusao = $inclusao;
    }

    public function setDataAlteracao($dataAlteracao) {
        $this->dataAlteracao = $dataAlteracao;
    }

    public function setAlteracao($alteracao) {
        $this->alteracao = $alteracao;
    }

    public function setFormacao($formacao) {
        $this->formacao = $formacao;
    }

    public function setProfissao($profissao) {
        $this->profissao = $profissao;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function setSubcategoria($subcategoria) {
        $this->subcategoria = $subcategoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }
}

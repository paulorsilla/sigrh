<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe AgenteIntegracao.
 * @ORM\Entity(repositoryClass="SigRH\Repository\AgenteIntegracao")
 * @ORM\Table(name="agente_integracao")
 */
class AgenteIntegracao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="nome", type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(name="endereco", type="string")
     */
    protected $endereco;

    /**
     * @ORM\Column(name="contato", type="string")
     */
    protected $contato;

    /**
     * @ORM\Column(name="site", type="string")
     */
    protected $site;
    
    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;
    
        /**
     * @ORM\Column(name="apolice", type="string")
     */
    protected $apolice;
    
    /**
     * @ORM\Column(name="vigencia", type="datetime")
     */
    protected $vigencia;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getContato() {
        return $this->contato;
    }

    public function getSite() {
        return $this->site;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getApolice() {
        return $this->apolice;
    }

    public function getVigencia() {
        return $this->vigencia;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setContato($contato) {
        $this->contato = $contato;
    }

    public function setSite($site) {
        $this->site = $site;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setApolice($apolice) {
        $this->apolice = $apolice;
    }

    public function setVigencia($vigencia) {
        $this->vigencia = $vigencia;
    }


}

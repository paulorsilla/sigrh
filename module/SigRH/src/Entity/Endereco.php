<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe endereco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Endereco")
 * @ORM\Table(name="endereco")
 */
class Endereco extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Cidade")
     * @ORM\JoinColumn(name="cidade_id", referencedColumnName="id")
     **/        
    protected $cidade; //cidade_id

    /**
     * @ORM\Column(name="endereco", type="string")
     */
    protected $endereco;

    /**
     * @ORM\Column(name="numero", type="string")
     */
    protected $numero;
    
    /**
     * @ORM\Column(name="complemento", type="string")
     */
    protected $complemento;
    
    /**
     * @ORM\Column(name="bairro", type="string")
     */
    protected $bairro;

    /**
     * @ORM\Column(name="cep", type="string")
     */
    protected $cep;

    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    function getEndereco() {
        return $this->endereco;
    }

    function getNumero() {
        return $this->numero;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCep() {
        return $this->cep;
    }
    
    function getCidade() {
        return $this->cidade;
    }

        
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
 
    
    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

}

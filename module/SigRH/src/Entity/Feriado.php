<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Feriado.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Feriado")
 * @ORM\Table(name="feriado")
 */
class Feriado extends AbstractEntity{

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
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    /**
     * @ORM\Column(name="data_feriado", type="datetime")
     **/
    protected $dataFeriado;
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoFeriado")
     * @ORM\JoinColumn(name="tipo_feriado_id", referencedColumnName="id") 
     **/
    protected $tipoFeriado; //tipo_feriado_id
    
    /**
     * @ORM\Column(name="expediente", type="integer")
     **/
    protected $expediente;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getDataFeriado() {
        return $this->dataFeriado;
    }

    public function getTipoFeriado() {
        return $this->tipoFeriado;
    }

    public function getExpediente() {
        return $this->expediente;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setDataFeriado($dataFeriado) {
        $this->dataFeriado = $dataFeriado;
    }

    public function setTipoFeriado($tipoFeriado) {
        $this->tipoFeriado = $tipoFeriado;
    }

    public function setExpediente($expediente) {
        $this->expediente = $expediente;
    }

}

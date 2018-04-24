<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe RecessoObrigatorio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\RecessoObrigatorio")
 * @ORM\Table(name="recesso_obrigatorio")
 */
class RecessoObrigatorio extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="ano_referencia", type="integer")
     */
    protected $anoReferencia;

    /**
     * @ORM\Column(name="data_inicio", type="datetime")
     **/
    protected $dataInicio;

    /**
     * @ORM\Column(name="data_termino", type="datetime")
     **/
    protected $dataTermino;

    /**
     * @ORM\ManyToOne(targetEntity="Vinculo", inversedBy="recessos")
     * @ORM\JoinColumn(name="vinculo_id", referencedColumnName="id") 
     **/
    protected $vinculo;
    
    public function getId() {
        return $this->id;
    }

    public function getAnoReferencia() {
        return $this->anoReferencia;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getDataTermino() {
        return $this->dataTermino;
    }

    public function getVinculo() {
        return $this->vinculo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAnoReferencia($anoReferencia) {
        $this->anoReferencia = $anoReferencia;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    public function setVinculo($vinculo) {
        $this->vinculo = $vinculo;
    }

}

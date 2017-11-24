<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Crachá.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Cracha")
 * @ORM\Table(name="cracha")
 */
class Cracha extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */
    protected $colaboradorMatricula; //colaborador_matricula

    /**
     * @ORM\Column(name="numero_chip", type="integer")
     */
    protected $numeroChip;

    /**
     * @ORM\Column(name="data_inclusao", type="datetime")
     */
    protected $dataInclusao;
    
    /**
     * @ORM\Column(name="data_exclusao", type="datetime")
     */
    protected $dataExclusao;
    
    /**
     * @ORM\Column(name="ativo", type="boolean")
     */
    protected $ativo;
    
    /**
     * @ORM\Column(name="observacoes", type="string")
     */
    protected $observacoes;

    public function getId() {
        return $this->id;
    }

    public function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    public function getNumeroChip() {
        return $this->numeroChip;
    }

    public function getDataInclusao() {
        return $this->dataInclusao;
    }

    public function getDataExclusao() {
        return $this->dataExclusao;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getObservacoes() {
        return $this->observacoes;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    public function setNumeroChip($numeroChip) {
        $this->numeroChip = $numeroChip;
    }

    public function setDataInclusao($dataInclusao) {
        $this->dataInclusao = $dataInclusao;
    }

    public function setDataExclusao($dataExclusao) {
        $this->dataExclusao = $dataExclusao;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

}

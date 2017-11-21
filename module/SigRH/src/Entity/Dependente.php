<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Dependente.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Dependente")
 * @ORM\Table(name="dependente")
 */
class Dependente extends AbstractEntity{

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
     * @ORM\Column(name="nome", type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(name="grau_parentesco", type="integer")
     */
    protected $grauParentesco;
    
    /**
     * @ORM\Column(name="data_nascimento", type="datetime")
     */
    protected $dataNascimento;
    
    /**
     * @ORM\Column(name="ativo", type="boolean")
     */
    protected $ativo;
    
    /**
     * @ORM\Column(name="universitario", type="boolean")
     */
    protected $universitario;
    
    /**
     * @ORM\Column(name="salario_familia", type="boolean")
     */
    protected $salarioFamilia;
    
    /**
     * @ORM\Column(name="imposto_renda", type="boolean")
     */
    protected $impostoRenda;
    
    function getId() {
        return $this->id;
    }

    function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    function getNome() {
        return $this->nome;
    }

    function getGrauParentesco() {
        return $this->grauParentesco;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function getUniversitario() {
        return $this->universitario;
    }

    function getSalarioFamilia() {
        return $this->salarioFamilia;
    }

    function getImpostoRenda() {
        return $this->impostoRenda;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setGrauParentesco($grauParentesco) {
        $this->grauParentesco = $grauParentesco;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setUniversitario($universitario) {
        $this->universitario = $universitario;
    }

    function setSalarioFamilia($salarioFamilia) {
        $this->salarioFamilia = $salarioFamilia;
    }

    function setImpostoRenda($impostoRenda) {
        $this->impostoRenda = $impostoRenda;
    }
}

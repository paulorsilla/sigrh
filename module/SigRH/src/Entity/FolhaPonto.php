<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe FolhaPonto.
 * @ORM\Entity(repositoryClass="SigRH\Repository\FolhaPonto")
 * @ORM\Table(name="folha_ponto")
 */
class FolhaPonto extends AbstractEntity {

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
     * @ORM\Column(name="referencia", type="integer")
     **/
    protected $referencia; //AAAAMM
    
    /**
     * @ORM\Column(name="saldo_minutos", type="integer")
     **/
    protected $saldoMinutos;
    
    /**
     * @ORM\Column(name="status", type="integer")
     **/
    protected $status;
    
    public function getId() {
        return $this->id;
    }

    public function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    public function getReferencia() {
        return $this->referencia;
    }

    public function getSaldoMinutos() {
        return $this->saldoMinutos;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function setSaldoMinutos($saldoMinutos) {
        $this->saldoMinutos = $saldoMinutos;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}

<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe banco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\BatidaPonto")
 * @ORM\Table(name="batida_ponto")
 */
class BatidaPonto extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="data", type="date")
     */
    protected $dataBatida;
    
    /**
     * @ORM\Column(name="hora", type="time")
     */
    protected $horaBatida;
    
    /**
     * @ORM\Column(name="sequencia", type="integer")
     */
    protected $sequencia;

    /**
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */    
    protected $colaboradorMatricula;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImportacaoPonto")
     * @ORM\JoinColumn(name="importacao_ponto_id", referencedColumnName="id")
     * */    
    protected $importacaoPonto;
    
    public function getId() {
        return $this->id;
    }

    public function getDataBatida() {
        return $this->dataBatida;
    }

    public function getHoraBatida() {
        return $this->horaBatida;
    }

    public function getSequencia() {
        return $this->sequencia;
    }

    public function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }

    public function getImportacaoPonto() {
        return $this->importacaoPonto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDataBatida($dataBatida) {
        $this->dataBatida = $dataBatida;
    }

    public function setHoraBatida($horaBatida) {
        $this->horaBatida = $horaBatida;
    }

    public function setSequencia($sequencia) {
        $this->sequencia = $sequencia;
    }

    public function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }

    public function setImportacaoPonto($importacaoPonto) {
        $this->importacaoPonto = $importacaoPonto;
    }


    
}

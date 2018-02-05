<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */    
    protected $colaboradorMatricula;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImportacaoPonto")
     * @ORM\JoinColumn(name="importacao_ponto_id", referencedColumnName="id")
     * */    
    protected $importacaoPonto;
    
    /**
     * @ORM\OneToMany(targetEntity="HoraBatidaPonto", mappedBy="batidaPonto")
     * @ORM\OrderBy({"horaBatida" = "ASC"})
     * 
     */
    protected $horarios;
    
    public function __construct() {
        $this->horarios = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDataBatida() {
        return $this->dataBatida;
    }

    public function getHorarios() {
        return $this->horarios;
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

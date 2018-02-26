<?php

namespace SigRH\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Ocorrencia.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Ocorrencia")
 * @ORM\Table(name="ocorrencia")
 */
class Ocorrencia extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="data", type="date")
     */
    protected $dataOcorrencia; 
    
    /**
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="colaborador_matricula", referencedColumnName="matricula")
     * */
    protected $colaboradorMatricula; //colaborador_matricula
    
    /**
     * @ORM\ManyToOne(targetEntity="BatidaPonto")
     * @ORM\JoinColumn(name="batida_ponto_id", referencedColumnName="id")
     * */
    protected $batidaPonto;
 
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    /**
     * @ORM\Column(name="saldo_minutos", type="integer")
     **/
    protected $saldoMinutos;
    
    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    function getColaboradorMatricula() {
        return $this->colaboradorMatricula;
    }
    public function getDataOcorrencia() {
        return $this->dataOcorrencia;
    }
    public function getBatidaPonto() {
        return $this->batidaPonto;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
            
    public function getSaldoMinutos() {
        return $this->saldoMinutos;
    }
    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    function setColaboradorMatricula($colaboradorMatricula) {
        $this->colaboradorMatricula = $colaboradorMatricula;
    }
    public function setDataOcorrencia($dataOcorrencia) {
        $this->dataOcorrencia = $dataOcorrencia;
    }
    public function setBatidaPonto($batidaPonto) {
        $this->batidaPonto = $batidaPonto;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    public function setSaldoMinutos($saldoMinutos) {
        $this->saldoMinutos = $saldoMinutos;
    }


}

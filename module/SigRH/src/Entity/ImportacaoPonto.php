<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ImportacaoPonto.
 * @ORM\Entity(repositoryClass="SigRH\Repository\ImportacaoPonto")
 * @ORM\Table(name="importacao_ponto")
 */
class ImportacaoPonto extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="referencia", type="string")
     */
    protected $referencia;

    /**
     * @ORM\Column(name="data_importacao", type="datetime")
     */
    protected $dataImportacao;

    /**
     * @ORM\Column(name="log", type="string")
     */
    protected $log;
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;
    
    /**
     * Returns ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    public function getReferencia() {
        return $this->referencia;
    }

    public function getDataImportacao() {
        return $this->dataImportacao;
    }

    public function getLog() {
        return $this->log;
    }

    public function getUsuario() {
        return $this->usuario;
    }
    
    /**
     * Sets ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function setDataImportacao($dataImportacao) {
        $this->dataImportacao = $dataImportacao;
    }

    public function setLog($log) {
        $this->log = $log;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

}

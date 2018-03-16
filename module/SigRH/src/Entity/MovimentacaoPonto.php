<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe MovimentacaoPonto.
 * @ORM\Entity(repositoryClass="SigRH\Repository\MovimentacaoPonto")
 * @ORM\Table(name="movimentacao_ponto")
 */
class MovimentacaoPonto extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     **/
    protected $id;
    
    /**
     * @ORM\Column(name="dia_ponto", type="integer")
     **/
    protected $diaPonto;
    
    /**
     * @ORM\ManyToOne(targetEntity="FolhaPonto", inversedBy="movimentacaoPonto")
     * @ORM\JoinColumn(name="folha_ponto_id", referencedColumnName="id")
     **/
    protected $folhaPonto;
    
    /**
     * @ORM\OneToMany(targetEntity="RegistroHorario", mappedBy="movimentacaoPonto")
     * @ORM\OrderBy({"horaRegistro" = "ASC"})
     **/
    protected $registros;
    
    /**
     * @ORM\OneToMany(targetEntity="Ocorrencia", mappedBy="movimentacaoPonto")
     **/
    protected $ocorrencias;
    
    public function __construct() {
        $this->registros = new ArrayCollection();
        $this->ocorrencias = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDiaPonto() {
        return $this->diaPonto;
    }

    public function getRegistros() {
        return $this->registros;
    }

    public function getOcorrencias() {
        return $this->ocorrencias;
    }

    public function setDiaPonto($diaPonto) {
        $this->diaPonto = $diaPonto;
    }

    public function setRegistros($registros) {
        $this->registros = $registros;
    }

    public function setOcorrencias($ocorrencias) {
        $this->ocorrencias = $ocorrencias;
    }
    
    public function getFolhaPonto() {
        return $this->folhaPonto;
    }

    public function setFolhaPonto($folhaPonto) {
        $this->folhaPonto = $folhaPonto;
    }

}

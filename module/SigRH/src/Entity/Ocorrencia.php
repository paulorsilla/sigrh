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
     * @ORM\ManyToOne(targetEntity="MovimentacaoPonto")
     * @ORM\JoinColumn(name="movimentacao_ponto_id", referencedColumnName="id")
     * */
    protected $movimentacaoPonto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Justificativa")
     * @ORM\JoinColumn(name="justificativa1_id", referencedColumnName="id")
     **/
    protected $justificativa1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Justificativa")
     * @ORM\JoinColumn(name="justificativa2_id", referencedColumnName="id")
     **/
    protected $justificativa2;
 
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    public function getId() {
        return $this->id;
    }

    public function getMovimentacaoPonto() {
        return $this->movimentacaoPonto;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    
    public function getJustificativa1() {
        return $this->justificativa1;
    }

    public function getJustificativa2() {
        return $this->justificativa2;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setMovimentacaoPonto($movimentacaoPonto) {
        $this->movimentacaoPonto = $movimentacaoPonto;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function setJustificativa1($justificativa) {
        $this->justificativa1 = $justificativa;
    }
    
    public function setJustificativa2($justificativa) {
        $this->justificativa2 = $justificativa;
    }

}

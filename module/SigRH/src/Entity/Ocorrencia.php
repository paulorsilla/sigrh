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
     * @ORM\JoinColumn(name="justificativa_id", referencedColumnName="id")
     **/
    protected $justificativa;
 
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

    public function setId($id) {
        $this->id = $id;
    }

    public function setMovimentacaoPonto($movimentacaoPonto) {
        $this->movimentacaoPonto = $movimentacaoPonto;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}

<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe RegistroHorario.
 * @ORM\Entity(repositoryClass="SigRH\Repository\RegistroHorario")
 * @ORM\Table(name="registro_horario")
 */
class RegistroHorario extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="hora_registro", type="time")
     */
    protected $horaRegistro;
    
    /**
     *
     * @ORM\Column(name="tipo", type="string")
     **/
    protected $tipo;
    
    /**
     * @ORM\ManyToOne(targetEntity="MovimentacaoPonto", inversedBy="registros")
     * @ORM\JoinColumn(name="movimentacao_ponto_id", referencedColumnName="id")
     * */    
    protected $movimentacaoPonto;
    
    public function getId() {
        return $this->id;
    }

    public function getHoraRegistro() {
        return $this->horaRegistro;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getMovimentacaoPonto() {
        return $this->movimentacaoPonto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setHoraRegistro($horaRegistro) {
        $this->horaRegistro = $horaRegistro;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setMovimentacaoPonto($movimentacaoPonto) {
        $this->movimentacaoPonto = $movimentacaoPonto;
    }

}

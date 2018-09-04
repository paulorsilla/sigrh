<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Justificativa.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Justificativa")
 * @ORM\Table(name="justificativa")
 */

class Justificativa extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;

    /**
     * @ORM\Column(name="indicar_horario", type="boolean")
     **/
    protected $indicarHorario;
    
    /**
     *  @ORM\Column(name="considerar_horas", type="boolean")
     **/
    protected $considerarHoras;
    
    /**
     * @ORM\Column(name="listar", type="boolean")
     */
    protected $listar;
    
    /**
     * @ORM\Column(name="indicar_cracha", type="boolean")
     */
    protected $indicarCracha;
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getIndicarHorario() {
        return $this->indicarHorario;
    }

    public function getConsiderarHoras() {
        return $this->considerarHoras;
    }

    public function getListar() {
        return $this->listar;
    }

    public function getIndicarCracha() {
        return $this->indicarCracha;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIndicarHorario($indicarHorario) {
        $this->indicarHorario = $indicarHorario;
    }

    public function setConsiderarHoras($considerarHoras) {
        $this->considerarHoras = $considerarHoras;
    }
    
    public function setListar($listar) {
        $this->listar = $listar;
    }

    public function setIndicarCracha($indicarCracha) {
        $this->indicarCracha = $indicarCracha;
    }
    
}

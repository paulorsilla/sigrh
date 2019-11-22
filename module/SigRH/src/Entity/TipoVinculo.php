<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe TipoColaborador.
 * @ORM\Entity(repositoryClass="SigRH\Repository\TipoVinculo")
 * @ORM\Table(name="tipo_vinculo")
 */
class TipoVinculo extends AbstractEntity {

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
     * @ORM\Column(name="acesso_sistema", type="boolean")
     */
    protected $acessoSistema;

    /**
     * Returns user ID.
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    
    public function getAcessoSistema() {
        return $this->acessoSistema;
    }
    
    /**
     * Sets user ID.
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function setAcessoSistema($acessoSistema) {
        $this->acessoSistema = $acessoSistema;
    }
    
}

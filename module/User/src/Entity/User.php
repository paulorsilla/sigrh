<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="usuario")
 */
class User {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="login")
     */
    protected $login;
    
    /**
     * @ORM\Column(name="nome")
     */
    protected $nome;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\Column(name="ramal")
     */
    protected $ramal;
    
    /**
     * @ORM\Column(name="papel")
     */
    protected $papel;

        /**
     * Returns gets user.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    function getNome() {
        return $this->nome;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getPapel() {
        return $this->papel;
    }
    
    function getRamal() {
        return $this->ramal;
    }

    
    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }


    public function setLogin($login) {
        $this->login = $login;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPapel($papel) {
        $this->papel = $papel;
    }

    function setRamal($ramal) {
        $this->ramal = $ramal;
    }



}

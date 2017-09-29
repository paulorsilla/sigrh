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
	 * @ORM\Column(name="nome")
	 */
	protected $nome;
	
	/**
	 * @ORM\Column(name="login")
	 */
	protected $login;
	
	/**
	 * @ORM\Column(name="email")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(name="ramal")
	 */
	protected $ramal;
	
	/**
	 * Returns user ID.
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets user ID.
	 * 
	 * @param int $id        	
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Returns email.
	 * 
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Sets email.
	 * 
	 * @param string $email        	
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	public function getNome() {
		return $this->nome;
	}
	
	public function setNome($nome) {
		$this->nome = $nome;
	}
	
	public function getLogin() {
		return $this->login;
	}
	
	public function setLogin($login) {
		$this->login = $login;
	}
	
	public function getRamal() {
		return $this->ramal;
	}
	
	public function setRamal($ramal) {
		$this->ramal = $ramal;
	}
}




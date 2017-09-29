<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;

/**
 * This form is used to collect user's email, full name, password and status.
 * The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class UserForm extends Form {
	
	/**
	 * Entity manager.
	 * 
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager = null;
	
	/**
	 * Current user.
	 * 
	 * @var User\Entity\User
	 */
	private $user = null;
	
	/**
	 * Constructor.
	 */
	public function __construct($entityManager = null, $user = null) {
		// Define form name
		parent::__construct ( 'user-form' );
		
		// Set POST method for this form
		$this->setAttribute ( 'method', 'post' );
		
		// Save parameters for internal use.
		$this->entityManager = $entityManager;
		$this->user = $user;
		
		$this->addElements ();
		$this->addInputFilter ();
	}
	
	/**
	 * This method adds elements to form (input fields and submit button).
	 */
	protected function addElements() {
		// Add "email" field
		$this->add ( [ 
				'type' => 'text',
				'name' => 'email',
				'options' => [ 
						'label' => 'E-mail' 
				] 
		] );
		
		// Add "nome" field
		$this->add ( [ 
				'type' => 'text',
				'name' => 'nome',
				'options' => [ 
						'label' => 'Nome' 
				] 
		] );
		
		// Add "login" field
		$this->add ( [
				'type' => 'text',
				'name' => 'login',
				'options' => [
						'label' => 'Login'
				]
		] );
		
		// Add "ramal" field
		$this->add ( [
				'type' => 'text',
				'name' => 'ramal',
				'options' => [
						'label' => 'Ramal'
				]
		] );
		
		// Add the Submit button
		$this->add ( [ 
				'type' => 'submit',
				'name' => 'submit',
				'attributes' => [ 
						'value' => 'Salvar' 
				] 
		] );
	}
	
	/**
	 * This method creates input filter (used for form filtering/validation).
	 */
	private function addInputFilter() {
		// Create main input filter
		$inputFilter = new InputFilter ();
		$this->setInputFilter ( $inputFilter );
		
		// Add input for "email" field
		$inputFilter->add ( [ 
				'name' => 'email',
				'required' => true,
				'filters' => [ 
						[ 
								'name' => 'StringTrim' 
						] 
				],
				'validators' => [ 
						[ 
								'name' => 'StringLength',
								'options' => [ 
										'min' => 1,
										'max' => 128 
								] 
						],
						[ 
								'name' => 'EmailAddress',
								'options' => [ 
										'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
										'useMxCheck' => false 
								] 
						],
						[ 
								'name' => UserExistsValidator::class,
								'options' => [ 
										'entityManager' => $this->entityManager,
										'user' => $this->user 
								] 
						] 
				] 
		] );
		
		// Add input for "nome" field
		$inputFilter->add ( [ 
				'name' => 'nome',
				'required' => true,
				'filters' => [ 
						[ 
								'name' => 'StringTrim' 
						] 
				],
				'validators' => [ 
						[ 
								'name' => 'StringLength',
								'options' => [ 
										'min' => 1,
										'max' => 512 
								] 
						] 
				] 
		] );
		
		// Add input for "ramal" field
		$inputFilter->add ( [
				'name' => 'ramal',
				'required' => true,
				'filters' => [
						[
								'name' => 'StringTrim'
						]
				],
				'validators' => [
						[
								'name' => 'StringLength',
								'options' => [
										'min' => 1,
										'max' => 4
								]
						]
				]
		] );
		
		// Add input for "login" field
		$inputFilter->add ( [
				'name' => 'login',
				'required' => true,
				'filters' => [
						[
								'name' => 'StringTrim'
						]
				],
				'validators' => [
						[
								'name' => 'StringLength',
								'options' => [
										'min' => 1,
										'max' => 512
								]
						]
				]
		] );
		
	}
}
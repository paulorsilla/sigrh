<?php
namespace Admin\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade Usuario
*
* @category Admin
* @package Model
*
* @ORM\Entity
* @ORM\Entity(repositoryClass="Admin\Repository\Usuario")
* @ORM\Table(name="cti_usuario")
*/
class Usuario extends Entity
{
 
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $nome;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $login;
	
	/**
	* @ORM\Column(type="integer");
	*/
	protected $valido;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $funcao;
        
        /**
	* @ORM\Column(type="string")
	*/
	protected $email;

        /**
	* @ORM\Column(type="string")
	*/
	protected $ramal;
        
        /**
	* @ORM\Column(type="boolean")
	*/
	protected $usaldap;

        /**
	* @ORM\Column(type="string")
	*/
	protected $senha;
        
        /**
	* @ORM\Column(type="string")
	*/
	protected $matricula;
        

	/**
	* Configura os filtros dos campos da entidade
	*
	* @return Zend\InputFilter\InputFilter
	*/
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
		
			$inputFilter->add($factory->createInput(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'nome',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 50,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'login',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 35,
						),
					),
				),
                        )));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'valido',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'funcao',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 20,
						),
					),
				),
			)));
                        
                        $inputFilter->add($factory->createInput(array(
				'name' => 'email',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 60,
						),
					),
				),
			)));

                        $inputFilter->add($factory->createInput(array(
				'name' => 'ramal',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 0,
							'max' => 20,
						),
					),
				),
			)));

                        $inputFilter->add($factory->createInput(array(
				'name' => 'usaldap',
				'required' => false,
			)));
                        
                        $inputFilter->add($factory->createInput(array(
				'name' => 'senha',
				'required' => false,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 0,
							'max' => 100,
						),
					),
				),
			)));
                        
                        $inputFilter->add($factory->createInput(array(
				'name' => 'matricula',
				'required' => false,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 0,
							'max' => 20,
						),
					),
				),
			)));
                        

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
        
        public function getNome() 
        {
            return $this->nome;
        }
}

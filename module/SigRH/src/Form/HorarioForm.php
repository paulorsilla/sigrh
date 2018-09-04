<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de horarios
 */
class HorarioForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('horario-form');

        $this->objectManager = $objectManager;
        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

        public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }
    
    protected function addElements() {


        //Adiciona o campo "escala"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'escalaSegunda',
            'attributes' => [
                'id' => 'escala',
                'class' => 'form-control',
                'placeholder' => 'Escolha a escala aqui'
            ],
            'options' => [
                'label' => 'Escala',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Escala::class,
                'property'        => 'EscalaComposta',    
                'is_method'      => true, //utilizar este metodo pra campos compostos ou para utilizar a property como uma funcao...
                
                'display_empty_item' => true,
            ]
        ]);
        

        //Adiciona o campo "escala"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'escalaTerca',
            'attributes' => [
                'id' => 'escalaTerca',
                'class' => 'form-control',
                'placeholder' => 'Escolha a escala aqui'
            ],
            'options' => [
                'label' => 'Escala',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Escala::class,
                'property'        => 'EscalaComposta',    
                'is_method'      => true,    
                
                'display_empty_item' => true,
            ]
        ]);
        

        //Adiciona o campo "escala"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'escalaQuarta',
            'attributes' => [
                'id' => 'escalaQuarta',
                'class' => 'form-control',
                'placeholder' => 'Escolha a escala aqui'
            ],
            'options' => [
                'label' => 'Escala',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Escala::class,
                'property'        => 'EscalaComposta',    
                'is_method'      => true,   
                
                'display_empty_item' => true,
            ]
        ]);
        

        //Adiciona o campo "escala"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'escalaQuinta',
            'attributes' => [
                'id' => 'escalaQuinta',
                'class' => 'form-control',
                'placeholder' => 'Escolha a escala aqui'
            ],
            'options' => [
                'label' => 'Escala',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Escala::class,
                'property'        => 'EscalaComposta',    
                'is_method'      => true,   
                
                'display_empty_item' => true,
            ]
        ]);
        
        
        
        //Adiciona o campo "escala"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'escalaSexta',
            'attributes' => [
                'id' => 'escalaSexta',
                'class' => 'form-control',
                'placeholder' => 'Escolha a escala aqui'
            ],
            'options' => [
                'label' => 'Escala',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Escala::class,
                'property'        => 'EscalaComposta',    
                'is_method'      => true,   
                
                'display_empty_item' => true,
            ]
        ]);
        

    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add([
            'name' => 'escalaSegunda',
            'required' => false,
        ]);
        $inputFilter->add([
            'name' => 'escalaTerca',
            'required' => false,
        ]);
        $inputFilter->add([
            'name' => 'escalaQuarta',
            'required' => false,
        ]);
        $inputFilter->add([
            'name' => 'escalaQuinta',
            'required' => false,
        ]);
        $inputFilter->add([
            'name' => 'escalaSexta',
            'required' => false,
        ]);

//        $inputFilter->add([
//            'name' => 'diaSemana',
//            'required' => true,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 100
//                    ],
//                ],
//            ],
//        ]);
        
        
         
         
    }

}

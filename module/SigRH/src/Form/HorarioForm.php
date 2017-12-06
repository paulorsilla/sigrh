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
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'diaSemana',
            'attributes' => [
                'id' => 'diaSemana',
                'class' => 'form-control',
                'placeholder' => 'Digite o início aqui'
            ],
            'options' => [
                'label' => 'Dia da Semana'
            ],
        ]);
        
        //Adiciona o campo "escala"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'escala',
//            'attributes' => [
//                'id' => 'escala',
//                'class' => 'form-control',
//                'placeholder' => 'Escolha a escala aqui'
//            ],
//            'options' => [
//                'label' => 'Escala',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \SigRH\Entity\Escala::class,
//                'property' => 'entrada1',
//                'display_empty_item' => true,
//            ]
//        ]);
        

    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'diaSemana',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);
        
        
         
         
    }

}

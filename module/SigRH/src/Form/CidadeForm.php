<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de Cidades
 */
class CidadeForm extends Form {
    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('cidade-form');

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
        //Adiciona o campo "Cidade"
        $this->add([
            'type' => 'text',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Cidade'
            ],
        ]);
        
        
        //Adiciona o campo "estado"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'estado',
            'attributes' => [
                'id' => 'estado',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Estado',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Estado::class,
                'property' => 'estado',
                'display_empty_item' => true,
            ]
        ]);
        
        


        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'submitbutton',
            ]
        ]);
    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'cidade',
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
                        'min' => 2,
                        'max' => 200
                    ],
                ],
            ],
        ]);

    }

}

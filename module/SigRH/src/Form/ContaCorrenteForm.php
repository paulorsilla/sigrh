<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de conta corrente
 */
class ContaCorrenteForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('contaCorrente-form');

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
        
        //Adiciona o campo "banco"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'banco',
            'attributes' => [
                'id' => 'banco',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Banco',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Banco::class,
                'property' => 'banco',
                'display_empty_item' => true,
            ]
        ]);
        
        
        //Adiciona o campo "agencia"
        $this->add([
            'type' => 'text',
            'name' => 'agencia',
            'attributes' => [
                'id' => 'agencia',
                'class' => 'form-control',
                'placeholder' => 'Digite a agência aqui'
            ],
            'options' => [
                'label' => 'Agência'
            ],
        ]);
        
        //Adiciona o campo "conta_corrente"
        $this->add([
            'type' => 'text',
            'name' => 'contaCorrente',
            'attributes' => [
                'id' => 'contaCorrente',
                'class' => 'form-control',
                'placeholder' => 'Digite a conta corrente aqui'
            ],
            'options' => [
                'label' => 'Conta corrente'
            ],
        ]);
        
        //Adiciona o campo "conta conjunta"
        $this->add([
            'type' => 'select',
            'name' => 'conjunta',
            'attributes' => [
                'id' => 'conjunta',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Conta Conjunta',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);
        
        //Adiciona o campo "nome_conjunta"
        $this->add([
            'type' => 'text',
            'name' => 'nomeConjunta',
            'attributes' => [
                'id' => 'nomeConjunta',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome aqui'
            ],
            'options' => [
                'label' => 'Nome conta conjunta'
            ],
        ]);
        
        //Adiciona o campo "cpf_conjunta"
        $this->add([
            'type' => 'text',
            'name' => 'cpfConjunta',
            'attributes' => [
                'id' => 'cpfConjunta',
                'class' => 'form-control',
                'placeholder' => 'Digite o cpf aqui'
            ],
            'options' => [
                'label' => 'Cpf conta conjunta'
            ],
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
            'name' => 'agencia',
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
        
        $inputFilter->add([
            'name' => 'banco',
            'required' => true,
        ]);

        
         $inputFilter->add([
            'name' => 'contaCorrente',
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
         
         $inputFilter->add([
            'name' => 'conjunta',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'nomeConjunta',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 5,
                        'max' => 200
                    ],
                ],
            ],
        ]);
         
        $inputFilter->add([
            'name' => 'cpfConjunta',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 20
                    ],
                ],
            ],
        ]);


    }

}

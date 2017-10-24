<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de cor de pele
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
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'sequencia',
            'attributes' => [
                'id' => 'sequencia',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome do banco aqui'
            ],
            'options' => [
                'label' => 'Sequência'
            ],
        ]);
        
        //Adiciona o campo "banco"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'banco',
            'attributes' => [
                'id' => 'banco',
                'class' => 'form-control',
                'placeholder' => 'Digite o código do banco aqui'
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
                'id' => 'agencia'
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
                'id' => 'contaCorrente'
            ],
            'options' => [
                'label' => 'Conta corrente'
            ],
        ]);
        
        //Adiciona o campo "conjunta"
        $this->add([
            'type' => 'text',
            'name' => 'conjunta',
            'attributes' => [
                'id' => 'conjunta'
            ],
            'options' => [
                'label' => 'Conjunta'
            ],
        ]);
        
        //Adiciona o campo "nome_conjunta"
        $this->add([
            'type' => 'text',
            'name' => 'nomeConjunta',
            'attributes' => [
                'id' => 'nomeConjunta'
            ],
            'options' => [
                'label' => 'Nome conta conjunta'
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
            'name' => 'sequencia',
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
                        'max' => 200
                    ],
                ],
            ],
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
                        'min' => 2,
                        'max' => 200
                    ],
                ],
            ],
        ]);

    }

}

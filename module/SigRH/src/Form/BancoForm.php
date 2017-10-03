<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de Bancos
 */
class BancoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('banco-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "Banco"
        $this->add([
            'type' => 'text',
            'name' => 'banco',
            'attributes' => [
                'id' => 'banco'
            ],
            'options' => [
                'label' => 'Banco'
            ],
        ]);

        //Adiciona o campo "Código"
        $this->add([
            'type' => 'text',
            'name' => 'codigo',
            'attributes' => [
                'id' => 'codigo'
            ],
            'options' => [
                'label' => 'Código do banco'
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
            'name' => 'banco',
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
            'name' => 'codigo',
            'required' => true,
        ]);
    }

}

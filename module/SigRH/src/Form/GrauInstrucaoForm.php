<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de Grau de instrucao
 */
class GrauInstrucaoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('grauInstrucao-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "Descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao'
            ],
            'options' => [
                'label' => 'Descrição'
            ],
        ]);

        //Adiciona o campo "ordem" -> campo para ordenar o grau de instrução...
        $this->add([
            'type' => 'text',
            'name' => 'ordem',
            'attributes' => [
                'id' => 'ordem'
            ],
            'options' => [
                'label' => 'Ordem'
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
            'name' => 'descricao',
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
            'name' => 'ordem',
            'required' => true,
        ]);
    }

}

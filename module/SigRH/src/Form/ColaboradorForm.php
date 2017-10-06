<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de colaboradores
 */
class ColaboradorForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('colaborador-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "Matrícula"
        $this->add([
            'type' => 'text',
            'name' => 'matricula',
            'attributes' => [
                'id' => 'matricula'
            ],
            'options' => [
                'label' => 'Matrícula'
            ],
        ]);

        //Adiciona o campo "Nome"
        $this->add([
            'type' => 'text',
            'name' => 'nome',
            'attributes' => [
                'id' => 'nome'
            ],
            'options' => [
                'label' => 'Nome'
            ],
        ]);
        
        //Adiciona o campo "Apelido"
        $this->add([
            'type' => 'text',
            'name' => 'apelido',
            'attributes' => [
                'id' => 'apelido'
            ],
            'options' => [
                'label' => 'Apelido'
            ],
        ]);
        
        //Adiciona o campo "Observçoes"
        $this->add([
            'type' => 'text',
            'name' => 'observacoes',
            'attributes' => [
                'id' => 'observacoes'
            ],
            'options' => [
                'label' => 'Observações'
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
            'name' => 'matricula',
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
                        'max' => 6
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'nome',
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
            'name' => 'apelido',
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
                        'max' => 50
                    ],
                ],
            ],
        ]);

        
    }

}

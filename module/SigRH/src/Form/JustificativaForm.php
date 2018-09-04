<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de Justificativas
 */
class JustificativaForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('justificativa-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "Descrição"
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
        
        //Adiciona o campo "indicarHorario"
        $this->add([
            'type' => 'select',
            'name' => 'indicarHorario',
            'attributes' => [
                'id' => 'indicarHorario',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Indicar horário',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);

        //Adiciona o campo "considerarHoras"
        $this->add([
            'type' => 'select',
            'name' => 'considerarHoras',
            'attributes' => [
                'id' => 'considerarHoras',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Considerar horas',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);
        
        //Adiciona o campo "listar"
        $this->add([
            'type' => 'select',
            'name' => 'listar',
            'attributes' => [
                'id' => 'listar',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Listar para escolha',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);

        //Adiciona o campo "indicarCracha"
        $this->add([
            'type' => 'select',
            'name' => 'indicarCracha',
            'attributes' => [
                'id' => 'indicarCracha',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Indicar o crachá de visitante usado',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
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
                        'max' => 500
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'considerarHoras',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'indicarHorario',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'listar',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'indicarCracha',
            'required' => true,
        ]);

    }

}

<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de crachas
 */
class CrachaForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('cracha-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        //Adiciona o campo "numeroChip"
        $this->add([
            'type' => 'text',
            'name' => 'numeroChip',
            'attributes' => [
                'id' => 'numeroChip',
                'class' => 'form-control',
                'placeholder' => 'Número chip'
            ],
            'options' => [
                'label' => 'Número chip'
            ],
        ]);
        
        //Adiciona o campo "data_inclusao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataInclusao',
            'attributes' => [
                'id' => 'dataInclusao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data inclusão'
            ],
        ]);

        //Adiciona o campo "data_exclusao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataExclusao',
            'attributes' => [
                'id' => 'dataExclusao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data exclusão'
            ],
        ]);

        //Adiciona o campo "ativo"
        $this->add([
            'type' => 'select',
            'name' => 'ativo',
            'attributes' => [
                'id' => 'ativo',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Ativo',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);
        
        //Adiciona o campo "observacoes"
        $this->add([
            'type' => 'text',
            'name' => 'observacoes',
            'attributes' => [
                'id' => 'observacoes',
                'class' => 'form-control',
                'placeholder' => 'Digite as obsevarções aqui'
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
            'name' => 'numeroChip',
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

        $inputFilter->add([
            'name' => 'observacoes',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ]
        ]);
        
        //data_inclusao
        $inputFilter->add([
            'name' => 'dataInclusao',
            'required' => true,
        ]);

        //data_exclusao
        $inputFilter->add([
            'name' => 'dataExclusao',
            'required' => false,
        ]);

        //ativo
        $inputFilter->add([
            'name' => 'ativo',
            'required' => true,
        ]);
    }

}

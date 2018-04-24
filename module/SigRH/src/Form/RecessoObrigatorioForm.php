<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de recesso obrigatório
 */
class RecessoObrigatorioForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('recesso-obrigatorio-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "anoReferencia"
        $this->add([
            'type' => 'text',
            'name' => 'anoReferencia',
            'attributes' => [
                'id' => 'anoReferencia',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Ano de referência'
            ],
        ]);
        
        //Adiciona o campo "dataInicio"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataInicio',
            'attributes' => [
                'id' => 'dataInicio',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data de início'
            ],
        ]);
        
        //Adiciona o campo "dataTermino"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataTermino',
            'attributes' => [
                'id' => 'dataTermino',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data de término'
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
            'name' => 'anoReferencia',
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
                        'min' => 4,
                        'max' => 4
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'dataInicio',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'dataTermino',
            'required' => true,
        ]);

    }

}

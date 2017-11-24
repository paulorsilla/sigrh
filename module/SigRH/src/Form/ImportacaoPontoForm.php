<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro das importações do registro de ponto 
 * obtidos nas catracas de entrada da unidade
 */
class ImportacaoPontoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('importacaoPonto-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "referência"
        $this->add([
            'type' => 'text',
            'name' => 'referencia',
            'attributes' => [
                'id' => 'referencia',
                'class' => 'form-control',
                'placeholder' => 'Digite o mês/ano de referência aqui'

            ],
            'options' => [
                'label' => 'Referência (mês/ano)'
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

    }

}

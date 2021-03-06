<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de tipo de colaboradores
 */
class TipoVinculoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('tipoVinculo-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao'
            ],
            'options' => [
                'label' => 'Descricao'
            ],
        ]);
        
        //Adiciona o campo "acessoSistema"
        $this->add([
            'type' => 'select',
            'name' => 'acessoSistema',
            'attributes' => [
                'id' => 'acessoSistema',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Acesso ao sistema para emissão de folha ponto',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);
    }
}

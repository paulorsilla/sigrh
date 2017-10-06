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
        
        //Adiciona o campo "Observaçoes"
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
        
        
        ////////////campos do endereço.../////////////////////////////////////////////
        
        //Adiciona o campo "Endereço"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [
                'id' => 'endereco'
            ],
            'options' => [
                'label' => 'Endereço'
            ],
        ]);
        
        //Adiciona o campo "Número"
        $this->add([
            'type' => 'text',
            'name' => 'numero',
            'attributes' => [
                'id' => 'numero'
            ],
            'options' => [
                'label' => 'Número'
            ],
        ]);
        
        //Adiciona o campo "Complemento"
        $this->add([
            'type' => 'text',
            'name' => 'complemento',
            'attributes' => [
                'id' => 'complemento'
            ],
            'options' => [
                'label' => 'Complemento'
            ],
        ]);
        
        //Adiciona o campo "Bairro"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);
        
        //Adiciona o campo "Cep"
        $this->add([
            'type' => 'text',
            'name' => 'cep',
            'attributes' => [
                'id' => 'cep'
            ],
            'options' => [
                'label' => 'Cep'
            ],
        ]);
        
        //Adiciona o campo "Cidade" -->VERIFICAR
        $this->add([
            'type' => 'text',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade'
            ],
            'options' => [
                'label' => 'Cidade'
            ],
        ]);
        
        //Adiciona o campo "Bairro"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);
        

        ////////////campos da cidade.../////////////////////////////////////////////

        //Adiciona o campo "Cidade"
        $this->add([
            'type' => 'text',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade'
            ],
            'options' => [
                'label' => 'Cidade'
            ],
        ]);

        //Adiciona o campo "Estado" -->VERIFICAR
        $this->add([
            'type' => 'text',
            'name' => 'estado',
            'attributes' => [
                'id' => 'estado'
            ],
            'options' => [
                'label' => 'Estado'
            ],
        ]);

        ////////////campos do estado.../////////////////////////////////////////////

        //Adiciona o campo "Estado"
        $this->add([
            'type' => 'text',
            'name' => 'estado',
            'attributes' => [
                'id' => 'estado'
            ],
            'options' => [
                'label' => 'Estado'
            ],
        ]);

        //Adiciona o campo "Sigla"
        $this->add([
            'type' => 'text',
            'name' => 'sigla',
            'attributes' => [
                'id' => 'sigla'
            ],
            'options' => [
                'label' => 'Sigla'
            ],
        ]);


        ///////////////////////////////////////////////////////////////////////

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

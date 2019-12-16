<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de Bancos
 */
class AgenteIntegracaoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('agente-integracao-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        //Adiciona o campo "Nome"
        $this->add([
            'type' => 'text',
            'name' => 'nome',
            'attributes' => [
                'class'=> 'form-control',
                'placeholder' => 'Digite o nome aqui',
                'id' => 'nome'
            ],
            'options' => [
                'label' => 'Nome'
            ],
        ]);

        //Adiciona o campo "Endereço"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [               
                'class'=> 'form-control',
                'placeholder' => 'Digite o endereço aqui',
                'id' => 'endereco'
            ],
            'options' => [
                'label' => 'Endereço'
            ],
        ]);
       
        //Adiciona o campo "Contato"
        $this->add([
            'type' => 'text',
            'name' => 'contato',
            'attributes' => [                
                'class'=> 'form-control',
                'placeholder' => 'Digite o contato aqui',
                'id' => 'contato'
            ],
            'options' => [
                'label' => 'Contato'
            ],
        ]);
        
        //Adiciona o campo "Site"
        $this->add([
            'type' => 'text',
            'name' => 'site',
            'attributes' => [               
                'class'=> 'form-control',
                'placeholder' => 'Digite o site aqui',
                'id' => 'site'
            ],
            'options' => [
                'label' => 'Site'
            ],
        ]);
        
        //Adiciona o campo "Email"
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'attributes' => [              
                'class'=> 'form-control',
                'placeholder' => 'Digite o email aqui',
                'id' => 'email'
            ],
            'options' => [
                'label' => 'Email'
            ],
        ]);
        
                //Adiciona o campo "Apolice"
        $this->add([
            'type' => 'text',
            'name' => 'apolice',
            'attributes' => [      
                'class'=> 'form-control',
                'placeholder' => 'Digite a apolice aqui',
                'id' => 'apolice'
            ],
            'options' => [
                'label' => 'Apolice'
            ],
        ]);
        
        //Adiciona o campo "Vigencia"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'vigencia',
            'attributes' => [
                'id' => 'vigencia',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Vigencia'
            ],
        ]);
        
        

    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

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
            'name' => 'endereco',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);
                
        $inputFilter->add([
            'name' => 'contato',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);        
        
        $inputFilter->add([
            'name' => 'contato',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);
        
        $inputFilter->add([
            'name' => 'site',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);
        
        $inputFilter->add([
            'name' => 'email',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);
        
        $inputFilter->add([
            'name' => 'apolice',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        
        ]);
        
        $inputFilter->add([
            'name' => 'vigencia',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
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

}

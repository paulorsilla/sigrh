<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de feriado
 */
class FeriadoForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        
        //Determina o nome do formulário
        parent::__construct('feriado-form');

        $this->objectManager = $objectManager;
        
        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }
    protected function addElements() {
        
        //Adiciona o campo "dataFeriado"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataFeriado',
            'attributes' => [
                'id' => 'dataFeriado',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data'
            ],
        ]);
        
        //Adiciona o campo "tipoFeriado"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'tipoFeriado',
            'attributes' => [
                'id' => 'tipoFeriado',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Tipo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\TipoFeriado::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "nome"
        $this->add([
            'type' => 'text',
            'name' => 'nome',
            'attributes' => [
                'id' => 'nome',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome aqui'
            ],
            'options' => [
                'label' => 'Nome'
            ],
        ]);
        
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao',
                'class' => 'form-control',
                'placeholder' => 'Digite a descrição aqui'
            ],
            'options' => [
                'label' => 'Descrição'
            ],
        ]);
        
        //Adiciona o campo "expediente"
        $this->add([
            'type' => 'select',
            'name' => 'expediente',
            'attributes' => [
                'id' => 'expediente',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Expediente',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim",
                    "2" => "Apenas manhã",
                    "3" => "Apenas tarde"
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
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 200
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
                        'min' => 3,
                        'max' => 200
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'dataFeriado',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'tipoFeriado',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'expediente',
            'required' => true,
        ]);



    }

}

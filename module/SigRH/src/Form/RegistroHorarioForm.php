<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de nivel
 */
class RegistroHorarioForm extends Form {

    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('registro-horario-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        //Adiciona o campo "entrada"
        $this->add([
            'type' => 'time',
            'name' => 'entrada',
            'attributes' => [
                'id' => 'entrada',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Entrada',
                'format' => 'H:i'
            ],
        ]);
        
        //Adiciona o campo "saida"
        $this->add([
            'type' => 'time',
            'name' => 'saida',
            'attributes' => [
                'id' => 'saida',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Saída',
                'format' => 'H:i'
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
            'name' => 'entrada',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'saida',
            'required' => false,
        ]);
    }

}

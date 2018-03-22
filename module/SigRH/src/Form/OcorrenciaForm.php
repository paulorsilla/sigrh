<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de nivel
 */
class OcorrenciaForm extends Form {

    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('ocorrencia-form');

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
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao',
                'class' => 'form-control alert-danger',
                'readonly' => true
            ],
            'options' => [
                'label' => 'Descrição'
            ],
        ]);
        
        //Adiciona o campo "entrada1"
        $this->add([
            'type' => 'time',
            'name' => 'entrada1',
            'attributes' => [
                'id' => 'entrada1',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Entrada 1',
                'format' => 'H:i'
            ],
        ]);
        
        //Adiciona o campo "saida1"
        $this->add([
            'type' => 'time',
            'name' => 'saida1',
            'attributes' => [
                'id' => 'saida1',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Saída 1',
                'format' => 'H:i'
            ],
        ]);

        //Adiciona o campo "entrada2"
        $this->add([
            'type' => 'time',
            'name' => 'entrada2',
            'attributes' => [
                'id' => 'entrada2',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Entrada 2',
                'format' => 'H:i'
            ],
        ]);
        
        //Adiciona o campo "saida2"
        $this->add([
            'type' => 'time',
            'name' => 'saida2',
            'attributes' => [
                'id' => 'saida2',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Saída 2',
                'format' => 'H:i'
            ],
        ]);
       
        //Adiciona o campo "justificativa1"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'justificativa1',
            'attributes' => [
                'id' => 'justificativa1',
                'class' => 'form-control',
                'onChange' => 'exibicaoHorarios()'

            ],
            'options' => [
                'label' => 'Justificativa',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Justificativa::class,
                'property' => 'descricao',
                'display_empty_item' => true
            ]
        ]);

        //Adiciona o campo "justificativa2"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'justificativa2',
            'attributes' => [
                'id' => 'justificativa2',
                'class' => 'form-control',
                'onChange' => 'exibicaoHorarios()'

            ],
            'options' => [
                'label' => 'Justificativa',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Justificativa::class,
                'property' => 'descricao',
                'display_empty_item' => true
            ]
        ]);
        
        $this->add([
            'type' => 'hidden',
            'name' => 'indicarHorario',
            'attributes' => [
                'id' => 'indicarHorario',
            ],
            'options' => [
                'label' => 'indicar horário'
            ]
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
                        'min' => 2,
                        'max' => 200
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'justificativa1',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'justificativa2',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'entrada1',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'saida1',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'entrada2',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'saida2',
            'required' => false,
        ]);


    }

}

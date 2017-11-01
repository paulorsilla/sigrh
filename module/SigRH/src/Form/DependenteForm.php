<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Formulário utilizado para o cadastro de dependentes
 */
class DependenteForm extends Form {

    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('dependente-form');

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
        //Adiciona o campo "Nome"
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

        //Adiciona o campo "grau de parentesco"
        $this->add([
            'type' => 'select',
            'name' => 'grauParentesco',
            'attributes' => [
                'id' => 'grauParentesco',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Grau de parentesco',
                'value_options' => [
                    "" => "Selecione",
                    "1" => "Cônjuge",
                    "2" => "Filho(a)",
                    "3" => "Irmã(o)",
                    "4" => "Pai",
                    "5" => "Mãe",
                    "99" => "Outros"
                ]
            ],
        ]);
        
        //Adiciona o campo "data_nascimento"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataNascimento',
            'attributes' => [
                'id' => 'dataNascimento',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'd/m/Y',
                'label' => 'Data de nascimento'
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
                    "1" => "Sim",
                    "0" => "Não",
                ]
            ],
        ]);
        
        //Adiciona o campo "universitário"
        $this->add([
            'type' => 'select',
            'name' => 'universitario',
            'attributes' => [
                'id' => 'universitario',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Universitário',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim",
                ]
            ],
        ]);

        //Adiciona o campo "salario familia"
        $this->add([
            'type' => 'select',
            'name' => 'salarioFamilia',
            'attributes' => [
                'id' => 'salarioFamilia',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Salário família',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim",
                ]
            ],
        ]);

        //Adiciona o campo "Imposto de renda"
        $this->add([
            'type' => 'select',
            'name' => 'impostoRenda',
            'attributes' => [
                'id' => 'impostoRenda',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Imposto de Renda',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim",
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
                        'min' => 5,
                        'max' => 200
                    ],
                ],
            ],
        ]);
        
        //grauParentesco
        $inputFilter->add([
            'name' => 'grauParentesco',
            'required' => true,
        ]);
        
        //dataNascimento
        $inputFilter->add([
            'name' => 'dataNascimento',
            'required' => true,
        ]);
        
        //ativo
        $inputFilter->add([
            'name' => 'ativo',
            'required' => true,
        ]);
        
        //universitario
        $inputFilter->add([
            'name' => 'universitario',
            'required' => true,
        ]);

        //salarioFamilia
        $inputFilter->add([
            'name' => 'salarioFamilia',
            'required' => true,
        ]);

        //impostoRenda
        $inputFilter->add([
            'name' => 'impostoRenda',
            'required' => true,
        ]);
    }
}

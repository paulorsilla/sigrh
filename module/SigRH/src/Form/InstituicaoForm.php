<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de instituições
 */
class InstituicaoForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('instituicao-form');

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
    
        //Adiciona o campo "razao social"
        $this->add([
            'type' => 'text',
            'name' => 'desRazaoSocial',
            'attributes' => [
                'id' => 'desRazaoSocial',
                'class' => 'form-control',
                'placeholder' => 'Digite a razão social aqui'
            ],
            'options' => [
                'label' => 'Razão Social'
            ],
        ]);
        
        //Adiciona o campo "nome fantasia"
        $this->add([
            'type' => 'text',
            'name' => 'nomFantasia',
            'attributes' => [
                'id' => 'nomFantasia',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome fantasia aqui'
            ],
            'options' => [
                'label' => 'Nome Fantasia'
            ],
        ]);

        //Adiciona o campo "cnpj"
        $this->add([
            'type' => 'text',
            'name' => 'cnpj',
            'attributes' => [
                'id' => 'cnpj',
                'class' => 'form-control',
                'placeholder' => 'Digite o CNPJ aqui'
            ],
            'options' => [
                'label' => 'CNPJ'
            ],
        ]);

        //Adiciona o campo "inscrição estadual"
        $this->add([
            'type' => 'text',
            'name' => 'inscricaoEstadual',
            'attributes' => [
                'id' => 'inscricaoEstadual',
                'class' => 'form-control',
                'placeholder' => 'Digite a Inscrição Estadual aqui'
            ],
            'options' => [
                'label' => 'Inscrição Estadual'
            ],
        ]);

        //Adiciona o campo "inscrição estadual"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [
                'id' => 'endereco',
                'class' => 'form-control',
                'placeholder' => 'Digite o Endereço aqui'
            ],
            'options' => [
                'label' => 'Endereço'
            ],
        ]);
        
        //Adiciona o campo "inscrição estadual"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro',
                'class' => 'form-control',
                'placeholder' => 'Digite o Bairro aqui'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);
        
        //Adiciona o campo "caixa postal"
        $this->add([
            'type' => 'text',
            'name' => 'caixaPostal',
            'attributes' => [
                'id' => 'caixaPostal',
                'class' => 'form-control',
                'placeholder' => 'Digite a Caixa Postal aqui'
            ],
            'options' => [
                'label' => 'Caixa Postal'
            ],
        ]);

        //Adiciona o campo "cep"
        $this->add([
            'type' => 'text',
            'name' => 'cep',
            'attributes' => [
                'id' => 'cep',
                'class' => 'form-control',
                'placeholder' => 'Digite o CEP aqui'
            ],
            'options' => [
                'label' => 'CEP'
            ],
        ]);

        //Adiciona o campo "cidade"
        $this->add([
            'type' => 'text',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade',
                'class' => 'form-control',
                'placeholder' => 'Digite a Cidade aqui'
            ],
            'options' => [
                'label' => 'Cidade'
            ],
        ]);
        
        //Adiciona o campo "uf"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'uf',
            'attributes' => [
                'id' => 'uf',
                'class' => 'form-control',
                'required' => false,
            ],
            'options' => [
                'label' => 'UF',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Estado::class,
                'property' => 'sigla',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "país"
        $this->add([
            'type' => 'text',
            'name' => 'pais',
            'attributes' => [
                'id' => 'pais',
                'class' => 'form-control',
                'placeholder' => 'Digite o País aqui'
            ],
            'options' => [
                'label' => 'País'
            ],
        ]);

        //Adiciona o campo "telefone"
        $this->add([
            'type' => 'text',
            'name' => 'telefone',
            'attributes' => [
                'id' => 'telefone',
                'class' => 'form-control',
                'placeholder' => 'Digite o Telefone aqui'
            ],
            'options' => [
                'label' => 'País'
            ],
        ]);

        //Adiciona o campo "email"
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Digite o E-Mail aqui'
            ],
            'options' => [
                'label' => 'E-Mail'
            ],
        ]);
        
        //Adiciona o campo "homepage"
        $this->add([
            'type' => 'text',
            'name' => 'homepage',
            'attributes' => [
                'id' => 'homepage',
                'class' => 'form-control',
                'placeholder' => 'Digite a Homepage aqui'
            ],
            'options' => [
                'label' => 'Homepage'
            ],
        ]);
        
        //Adiciona o campo "telefone"
        $this->add([
            'type' => 'text',
            'name' => 'telefone',
            'attributes' => [
                'id' => 'telefone',
                'class' => 'form-control',
                'placeholder' => 'Digite o Telefone aqui'
            ],
            'options' => [
                'label' => 'Telefone'
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
            'name' => 'desRazaoSocial',
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
            'name' => 'nomFantasia',
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
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'cnpj',
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
                        'min' => 10,
                        'max' => 25
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'inscricaoEstadual',
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
                        'max' => 25
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
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'bairro',
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
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'cep',
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
                        'max' => 10
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'cidade',
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
                        'max' => 100
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'uf',
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
                        'max' => 2
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'caixaPostal',
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
                        'max' => 30
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pais',
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
                        'max' => 50
                    ],
                ],
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
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'homepage',
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
                        'max' => 100
                    ],
                ],
            ],
        ]);
    }
}

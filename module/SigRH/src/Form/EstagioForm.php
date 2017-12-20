<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de estagios
 */
class EstagioForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('estagio-form');

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
            'name' => 'inicio',
            'attributes' => [
                'id' => 'inicio',
                'class' => 'form-control',
                'placeholder' => 'Digite o início aqui'
            ],
            'options' => [
                'label' => 'Início'
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'previsaoConclusao',
            'attributes' => [
                'id' => 'previsaoConclusao',
                'class' => 'form-control',
                'placeholder' => 'Digite a previsão de conclusão aqui'
            ],
            'options' => [
                'label' => 'Previsão de conclusão'
            ],
        ]);

        //Adiciona o campo "nivel"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'nivel',
            'attributes' => [
                'id' => 'nivel',
                'class' => 'form-control',
                'placeholder' => 'Digite o nível aqui'
            ],
            'options' => [
                'label' => 'Nivel',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Nivel::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "curso"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'curso',
            'attributes' => [
                'id' => 'curso',
                'class' => 'form-control',
                'placeholder' => 'Digite o curso aqui'
            ],
            'options' => [
                'label' => 'Curso',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Curso::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "instituicao"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'instituicao',
            'attributes' => [
                'id' => 'instituicao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Instituição de ensino',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Instituicao::class,
                'property' => 'desRazaoSocial',
                
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 1
                        ]
                    ]
                ],
            ]
        ]);
        
        //Adiciona o campo "sublotacao"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'sublotacao',
            'attributes' => [
                'id' => 'sublotacao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sublotação',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Sublotacao::class,
                'property' => 'descricao',
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 1,
                            'ano' => '2011'
                        ]
                    ]
                ],
            ]
        ]);
        
        //Adiciona o campo "serie"
        $this->add([
            'type' => 'text',
            'name' => 'serie',
            'attributes' => [
                'id' => 'serie',
                'class' => 'form-control',
                'placeholder' => 'Digite a série aqui'
            ],
            'options' => [
                'label' => 'Série'
            ],
        ]);
       
        //Adiciona o campo "dataInicioEfetivo"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataInicioEfetivo',
            'attributes' => [
                'id' => 'dataInicioEfetivo',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Início efetivo'
            ],
        ]);
        
        //Adiciona o campo "fonteSeguro"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fonteSeguro',
            'attributes' => [
                'id' => 'fonteSeguro',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Fonte seguro',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\FonteSeguro::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "seguroApolice"
        $this->add([
            'type' => 'text',
            'name' => 'seguroApolice',
            'attributes' => [
                'id' => 'seguroApolice',
                'class' => 'form-control',
                'placeholder' => 'Digite a apólice aqui'
            ],
            'options' => [
                'label' => 'Apólice'
            ],
        ]);
        
        //Adiciona o campo "seguroSeguradora"
        $this->add([
            'type' => 'text',
            'name' => 'seguroSeguradora',
            'attributes' => [
                'id' => 'seguroSeguradora',
                'class' => 'form-control',
                'placeholder' => 'Digite a seguradora aqui'
            ],
            'options' => [
                'label' => 'Seguradora'
            ],
        ]);
        
        //Adiciona o campo "preContrato"
        $this->add([
            'type' => 'select',
            'name' => 'preContrato',
            'attributes' => [
                'id' => 'preContrato',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Pré-contrato',
                'value_options' => [
                    "" => "Selecione",
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);

        //Adiciona o campo "obrigatorio"
        $this->add([
            'type' => 'select',
            'name' => 'obrigatorio',
            'attributes' => [
                'id' => 'obrigatorio',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Obrigatório',
                'value_options' => [
                    "" => "Selecione",
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);
        
        //Adiciona o campo "lotacao"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'lotacao',
            'attributes' => [
                'id' => 'lotacao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Lotação',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Instituicao::class,
                'property' => 'desRazaoSocial',
                
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 1
                        ]
                    ]
                ],
            ]
        ]);
        
        //Adiciona o campo "localizacao"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'localizacao',
            'attributes' => [
                'id' => 'localizacao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Localização',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Localizacao::class,
                'property' => 'descricao',
                
                'find_method' => [
                    'name' => 'getQuery',
                        'params' => [
                        'search' => [
                            'combo' => 1
                        ]
                    ]

                ],
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
            'name' => 'inicio',
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
            'name' => 'previsaoConclusao',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);

         $inputFilter->add([
            'name' => 'nivel',
            'required' => true,
        ]);
       
         $inputFilter->add([
            'name' => 'curso',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'instituicao',
            'required' => false,
        ]);
         
         
         $inputFilter->add([
            'name' => 'serie',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);
         
         $inputFilter->add([
            'name' => 'dataInicioEfetivo',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);
   
         $inputFilter->add([
            'name' => 'fonteSeguro',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'seguroApolice',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);

         $inputFilter->add([
            'name' => 'seguroSeguradora',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);
         
        $inputFilter->add([
            'name' => 'preContrato',
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
            'name' => 'obrigatorio',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'lotacao',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'localizacao',
            'required' => true,
        ]);
    }
}

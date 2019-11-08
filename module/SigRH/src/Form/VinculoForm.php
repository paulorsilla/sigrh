<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de estagios
 */
class VinculoForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('vinculo-form');

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

        //Adiciona o campo "tipoVinculo"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'tipoVinculo',
            'attributes' => [
                'id' => 'tipoVinculo',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Tipo de vínculo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\TipoVinculo::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
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
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 1
                        ]
                    ]
                ],
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "instituicaoEnsino"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'instituicaoEnsino',
            'attributes' => [
                'id' => 'instituicaoEnsino',
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
                            'combo' => 2
                        ]
                    ]
                ],
            ]
        ]);
        
        //Adiciona o campo "instituicaoFomento"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'instituicaoFomento',
            'attributes' => [
                'id' => 'instituicaoFomento',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Instituição de fomento',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Instituicao::class,
                'property' => 'desRazaoSocial',
                
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 2
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
        
        //Adiciona o campo "cargo"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'cargo',
            'attributes' => [
                'id' => 'cargo',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Cargo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Cargo::class,
                'property' => 'descricao',
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 1,
                        ]
                    ]
                ],
            ]
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

        //Adiciona o campo "diasRecesso"
        $this->add([
            'type' => 'text',
            'name' => 'diasRecesso',
            'attributes' => [
                'id' => 'diasRecesso',
                'class' => 'form-control',
                'placeholder' => 'Digite o recesso aqui'
            ],
            'options' => [
                'label' => 'Recesso (dias)'
            ],
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
        
        //Adiciona o campo "tipoContrato"
        $this->add([
            'type' => 'select',
            'name' => 'tipoContrato',
            'attributes' => [
                'id' => 'preContrato',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Tipo de contrato',
                'value_options' => [
                    "" => "Selecione",
                    "0" => "Determinado",
                    "1" => "Indeterminado"
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
                'label' => 'Obrigatório (estágio)',
                'value_options' => [
                    "" => "Selecione",
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
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
        
        //Adiciona o campo "aditivo"
        $this->add([
            'type' => 'text',
            'name' => 'aditivo',
            'attributes' => [
                'id' => 'aditivo',
                'class' => 'form-control',
                'placeholder' => 'Digite o número do aditivo aqui'
            ],
            'options' => [
                'label' => 'Número do aditivo'
            ],
        ]);

         //Adiciona o campo "tipoAditivo"
        $this->add([
            'type' => 'select',
            'name' => 'tipoAditivo',
            'attributes' => [
                'id' => 'tipoAditivo',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Tipo do aditivo',
                'value_options' => [
                    "" => "Selecione",
                    "1" => "Remunerado",
                    "2" => "Prorrogação",
                    "3" => "Orientador",
                    "9" => "Outro",
                ]
            ],
        ]);
        
        //Adiciona o campo "dataInicio"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataInicio',
            'attributes' => [
                'id' => 'dataInicio',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Início da vigência'
            ],
        ]);
        
        //Adiciona o campo "dataTermino"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataTermino',
            'attributes' => [
                'id' => 'dataTermino',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Término da vigência'
            ],
        ]);
        
        //Adiciona o campo "dataDesligamento"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataDesligamento',
            'attributes' => [
                'id' => 'dataDesligamento',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Desligamento'
            ],
        ]);
        
        //Adiciona o campo "horarioFlexivel"
        $this->add([
            'type' => 'select',
            'name' => 'horarioFlexivel',
            'attributes' => [
                'id' => 'horarioFlexivel',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Horário flexível',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
            ],
        ]);
        
        //Adiciona o campo "Atividade"
        $this->add([
            'type' => 'select',
            'name' => 'atividade',
            'attributes' => [
                'id' => 'atividade',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Atividade',
            ],
        ]);
        
        //Adiciona o campo "chSemanal"
        $this->add([
            'type' => 'text',
            'name' => 'chSemanal',
            'attributes' => [
                'id' => 'chSemanal',
                'class' => 'form-control',
                'placeholder' => 'Digite a carga horária aqui'
            ],
            'options' => [
                'label' => 'C.H Semanal'
            ],
        ]);
        
        //Adiciona o campo "planoAcao"
        $this->add([
            'type' => 'text',
            'name' => 'planoAcao',
            'attributes' => [
                'id' => 'planoAcao',
                'class' => 'form-control',
                'placeholder' => 'Digite o plano de ação aqui'
            ],
            'options' => [
                'label' => 'Plano de ação'
            ],
        ]);
        
        
        $this->add([
            'type' => 'text',
            'name' => 'processo',
            'attributes' => [
                'id' => 'processo',
                'class' => 'form-control',
                'placeholder' => 'Digite o processo aqui'
            ],
            'options' => [
                'label' => 'Processo'
            ],
        ]);
        
        $this->add([
            'type' => 'text',
            'name' => 'valorBolsa',
            'attributes' => [
                'id' => 'valorBolsa',
                'class' => 'form-control',
                'placeholder' => 'Digite o valor da bolsa'
            ],
            'options' => [
                'label' => 'Valor da bolsa'
            ],
        ]);
        

        //Adiciona o campo "modalidadeBolsa"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'modalidadeBolsa',
            'attributes' => [
                'id' => 'modalidadeBolsa',
                'class' => 'form-control',
                'placeholder' => 'Digite a modalidade aqui'
            ],
            'options' => [
                'label' => 'Modalidade bolsa',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\ModalidadeBolsa::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "orientador"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'orientador',
            'attributes' => [
                'id' => 'orientador',
                'class' => 'form-control',
                'placeholder' => 'Digite o orientador aqui'
            ],
            'options' => [
                'label' => 'Orientador',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Colaborador::class,
                'property' => 'nome',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "observacoes"
        $this->add([
            'type' => 'text',
            'name' => 'observacoes',
            'attributes' => [
                'id' => 'observacoes',
                'class' => 'form-control',
                'placeholder' => 'Digite as observações aqui'
            ],
            'options' => [
                'label' => 'Observações'
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
            'name' => 'tipoVinculo',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'tipoContrato',
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
            'name' => 'tipoAditivo',
            'required' => false,
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
                        'min' => 0,
                        'max' => 200
                    ],
                ],
            ],
        ]);

         $inputFilter->add([
            'name' => 'dataDesligamento',
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
            'name' => 'nivel',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'curso',
            'required' => false,
        ]);
         
         
         $inputFilter->add([
            'name' => 'fonteSeguro',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'planoAcao',
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
            'name' => 'obrigatorio',
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
            'name' => 'instituicaoFomento',
            'required' => false,
        ]);

         $inputFilter->add([
            'name' => 'sublotacao',
            'required' => false,
        ]);
         
        $inputFilter->add([
            'name' => 'cargo',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'localizacao',
            'required' => false,
        ]);
        
         $inputFilter->add([
            'name' => 'atividade',
            'required' => false,
        ]);

         $inputFilter->add([
            'name' => 'instituicaoEnsino',
            'required' => false,
        ]);
         
         
         $inputFilter->add([
            'name' => 'modalidadeBolsa',
            'required' => false,
        ]);
         
         $inputFilter->add([
            'name' => 'orientador',
            'required' => false,
        ]);
        
         
        
        $inputFilter->add([
            'name' => 'inicio',
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
                        'min' => 0,
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
                        'min' => 0,
                        'max' => 200
                    ],
                ],
            ],
        ]);
        
         $inputFilter->add([
            'name' => 'previsaoConclusao',
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
            'name' => 'dataInicio',
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
                        'min' => 0,
                        'max' => 200
                    ],
                ],
            ],
        ]);
         
         $inputFilter->add([
            'name' => 'dataTermino',
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
            'name' => 'chSemanal',
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
            'name' => 'horarioFlexivel',
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
            'name' => 'processo',
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
            'name' => 'valorBolsa',
            'required' => false,
        ]);
         

        
        $inputFilter->add([
            'name' => 'aditivo',
            'required' => false,
        ]);

         $inputFilter->add([
            'name' => 'diasRecesso',
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
            'name' => 'observacoes',
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
                        'max' => 500
                    ],
                ],
            ],
        ]);


        
        
        
    }
}

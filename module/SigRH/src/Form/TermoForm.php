<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de estagios
 */
class TermoForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('termo-form');

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
        //Adiciona o campo "aditivo"
        $this->add([
            'type' => 'text',
            'name' => 'aditivo',
            'attributes' => [
                'id' => 'aditivo',
                'class' => 'form-control',
                'placeholder' => 'Digite o aditivo aqui'
            ],
            'options' => [
                'label' => 'Aditivo'
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'tipoAditivo',
            'attributes' => [
                'id' => 'tipoAditivo',
                'class' => 'form-control',
                'placeholder' => 'Digite o tipo aditivo aqui'
            ],
            'options' => [
                'label' => 'Tipo aditivo'
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
                'format' => 'd/m/Y',
                'label' => 'Início'
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
                'format' => 'd/m/Y',
                'label' => 'Término'
            ],
        ]);
        
        $this->add([
            'type' => 'text',
            'name' => 'chSemanal',
            'attributes' => [
                'id' => 'chSemanal',
                'class' => 'form-control',
                'placeholder' => 'Digite o tipo aditivo aqui'
            ],
            'options' => [
                'label' => 'C.H Semanal'
            ],
        ]);
        
        $this->add([
            'type' => 'text',
            'name' => 'horarioFlexivel',
            'attributes' => [
                'id' => 'horarioFlexivel',
                'class' => 'form-control',
                'placeholder' => 'Digite o horário flexível aqui'
            ],
            'options' => [
                'label' => 'Horário flexível'
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
        

//        //Adiciona o campo "nivel"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'nivel',
//            'attributes' => [
//                'id' => 'nivel',
//                'class' => 'form-control',
//                'placeholder' => 'Digite o nível aqui'
//            ],
//            'options' => [
//                'label' => 'Nivel',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \SigRH\Entity\Nivel::class,
//                'property' => 'descricao',
//                'display_empty_item' => true,
//            ]
//        ]);
//
//        //Adiciona o campo "curso"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'curso',
//            'attributes' => [
//                'id' => 'curso',
//                'class' => 'form-control',
//                'placeholder' => 'Digite o curso aqui'
//            ],
//            'options' => [
//                'label' => 'Curso',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \SigRH\Entity\Curso::class,
//                'property' => 'descricao',
//                'display_empty_item' => true,
//            ]
//        ]);
//        
//        //Adiciona o campo "instituicao"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'instituicao',
//            'attributes' => [
//                'id' => 'instituicao',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'label' => 'Instituição de ensino',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \SigRH\Entity\Instituicao::class,
//                'property' => 'desRazaoSocial',
//                
//                'find_method' => [
//                    'name' => 'getQuery',
//                    'params' => [
//                        'search' => [
//                            'combo' => 1
//                        ]
//                    ]
//                ],
//            ]
//        ]);
//        
//        //Adiciona o campo "sublotacao"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'sublotacao',
//            'attributes' => [
//                'id' => 'sublotacao',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'label' => 'Sublotação',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \SigRH\Entity\Sublotacao::class,
//                'property' => 'descricao',
//                'find_method' => [
//                    'name' => 'getQuery',
//                    'params' => [
//                        'search' => [
//                            'combo' => 1,
//                            'ano' => '2011'
//                        ]
//                    ]
//                ],
//            ]
//        ]);
        
        
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

//        $inputFilter->add([
//            'name' => 'inicio',
//            'required' => true,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 100
//                    ],
//                ],
//            ],
//        ]);
//        
//        
//         $inputFilter->add([
//            'name' => 'previsaoConclusao',
//            'required' => true,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 200
//                    ],
//                ],
//            ],
//        ]);
//
//         $inputFilter->add([
//            'name' => 'nivel',
//            'required' => true,
//        ]);
//       
//         $inputFilter->add([
//            'name' => 'curso',
//            'required' => true,
//        ]);
//         
//         $inputFilter->add([
//            'name' => 'instituicao',
//            'required' => false,
//        ]);
//         
//         
//         $inputFilter->add([
//            'name' => 'serie',
//            'required' => false,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 200
//                    ],
//                ],
//            ],
//        ]);
//         
//         $inputFilter->add([
//            'name' => 'dataInicioEfetivo',
//            'required' => false,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 200
//                    ],
//                ],
//            ],
//        ]);
//   
//         $inputFilter->add([
//            'name' => 'fonteSeguro',
//            'required' => true,
//        ]);
//         
//         $inputFilter->add([
//            'name' => 'seguroApolice',
//            'required' => false,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 200
//                    ],
//                ],
//            ],
//        ]);
//
//         $inputFilter->add([
//            'name' => 'seguroSeguradora',
//            'required' => false,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 1,
//                        'max' => 200
//                    ],
//                ],
//            ],
//        ]);
         
    }

}

<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro das importações do registro de ponto 
 * obtidos nas catracas de entrada da unidade
 */
class ImportacaoPontoForm extends Form {

    protected $objectManager;

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('importacaoPonto-form');
        
        $this->objectManager = $objectManager;
        
        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {

        //Adiciona o campo "dataServidor"
        $this->add([
            'type' => 'hidden',
            'name' => 'dataServidor',
            'attributes' => [
                'id' => 'dataServidor',
            ],
        ]);
        
        //Adiciona o campo "referência"
        $this->add([
            'type' => 'text',
            'name' => 'referencia',
            'attributes' => [
                'id' => 'referencia',
                'class' => 'form-control',
                'placeholder' => 'Digite o mês/ano de referência aqui'

            ],
            'options' => [
                'label' => 'Referência (mês/ano)'
            ],
        ]);
        
        //Adiciona o campo "usuario"
        $this->add([
            'type' => \DoctrineModule\Form\Element\ObjectSelect::class,
            'name' => 'usuario',
            'attributes' => [
                'id' => 'usuario',
                'class' => 'form-control',
                'disabled' => 'disabled'
                ],
            'options' => [
                'label' => 'Usuário',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \User\Entity\User::class,
                'property' => 'nome',
                'display_empty_item' => false,
            ]
        ]);
        
        //Adiciona o campo "dataImportação"
        $this->add([
            'type' => \Zend\Form\Element\Date::class,
            'name' => 'dataImportacao',
            'attributes' => [
                'id' => 'dataImportacao',
                'class' => 'form-control',
                'readonly' => 'readonly'
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data importação'
            ],
        ]);
        
        //Adiciona o campo "arquivo"
        $this->add([
            'type' => \Zend\Form\Element\File::class,
            'name' => 'arquivo',
            'attributes' => [
                'id' => 'arquivo',
            ],
            'options' => [
                'label' => 'Selecione o arquivo'
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
            'name' => 'referencia',
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
                        'min' => 7,
                        'max' => 7
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'dataImportacao',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'usuario',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'arquivo',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'type'     => \Zend\InputFilter\FileInput::class,
            'name'     => 'arquivo',  // Element's name.
            'required' => true,    // Whether the field is required.
            
            'filters'  => [        // Filters.
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],                
            'validators' => [      // Validators.
                [
                    'name' => '\Zend\Validator\File\UploadFile',
                ],
                [
                    'name' => '\Zend\Validator\File\Size',
                    'options' => [
                        'max' => '20MB',
                    ]
                ],
        ]        
    ]); 

    }

}

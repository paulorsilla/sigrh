<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de convenios
 */
class ConvenioForm extends Form {

    protected $objectManager;
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('convenio-form');

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
        //Adiciona o campo "tipo"
        $this->add([
            'type' => 'select',
            'name' => 'tipo',
            'attributes' => [
                'id' => 'tipo',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Tipo',
                'value_options' => [
                    "" => "Selecione",
                    "1" => "Ensino",
                    "2" => "Fomento"
                ]
            ],
        ]);

        //Adiciona o campo "convenioNumero"
        $this->add([
            'type' => 'text',
            'name' => 'convenioNumero',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'convenioNumero'
            ],
            'options' => [
                'label' => 'Número do convênio'
            ],
        ]);
        
        //Adiciona o campo "convenioInicio"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'convenioInicio',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'convenioInicio'
            ],
            'options' => [
                'format' => 'd/m/Y',
                'label' => 'Início do convênio'
            ],
        ]);
        
        //Adiciona o campo "convenioTermino"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'convenioTermino',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'convenioTermino'
            ],
            'options' => [
                'format' => 'd/m/Y',
                'label' => 'Término do convênio'
            ],
        ]);
        
        //Adiciona o campo "responsavelNome"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelNome',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelNome'
            ],
            'options' => [
                'label' => 'Nome do responsável'
            ],
        ]);
        
        //Adiciona o campo "responsavelCargo"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelCargo',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelCargo'
            ],
            'options' => [
                'label' => 'Cargo do responsável'
            ],
        ]);

        //Adiciona o campo "responsavelCpfNumero"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelCpfNumero',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelCpfNumero'
            ],
            'options' => [
                'label' => 'CPF do responsável'
            ],
        ]);

        //Adiciona o campo "responsavelRgNumero"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelRgNumero',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelRgNumero'
            ],
            'options' => [
                'label' => 'Número RG do responsável'
            ],
        ]);
        
        //Adiciona o campo "responsavelRgEmissor"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelRgEmissor',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelRgEmissor'
            ],
            'options' => [
                'label' => 'Emissor RG do responsável'
            ],
        ]);
        
        //Adiciona o campo "responsavelRgDataEmissao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'responsavelRgDataEmissao',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelRgDataEmissao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'd/m/Y',
                'label' => 'Data emissão RG do responsável'
            ],
        ]);
        
        
        //Adiciona o campo "responsavelDescricaoJuridica"
        $this->add([
            'type' => 'text',
            'name' => 'responsavelDescricaoJuridica',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'responsavelDescricaoJuridica'
            ],
            'options' => [
                'label' => 'Responsável descrição jurídica'
            ],
        ]);
        
        //Adiciona o campo "descricaoJuridica"
        $this->add([
            'type' => 'text',
            'name' => 'descricaoJuridica',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'descricaoJuridica'
            ],
            'options' => [
                'label' => 'Descrição jurídica'
            ],
        ]);
        
        //Adiciona o campo "observacoes"
        $this->add([
            'type' => 'text',
            'name' => 'observacoes',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'observacoes'
            ],
            'options' => [
                'label' => 'Observações'
            ],
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
                'label' => 'Instituição',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Instituicao::class,
                'property' => 'desRazaoSocial',
                'display_empty_item' => true,
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
            'name' => 'instituicao',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'tipo',
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
            'name' => 'convenioNumero',
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
            'name' => 'convenioInicio',
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
            'name' => 'convenioTermino',
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
            'name' => 'responsavelNome',
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
            'name' => 'responsavelCargo',
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
            'name' => 'responsavelCpfNumero',
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
            'name' => 'responsavelRgNumero',
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
            'name' => 'responsavelRgEmissor',
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
            'name' => 'responsavelRgDataEmissao',
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
            'name' => 'responsavelDescricaoJuridica',
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
            'name' => 'descricaoJuridica',
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
                        'max' => 200
                    ],
                ],
            ],
        ]);
        

    }

}

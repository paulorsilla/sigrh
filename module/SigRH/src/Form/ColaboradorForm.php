<?php

namespace SigRH\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Formulário utilizado para o cadastro de colaboradores
 */
class ColaboradorForm extends Form {
    
    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('colaborador-form');

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
        //Adiciona o campo "Matrícula"
        $this->add([
            'type' => 'text',
            'name' => 'matricula',
            'attributes' => [
                'id' => 'matricula'
            ],
            'options' => [
                'label' => 'Matrícula'
            ],
        ]);

        //Adiciona o campo "Nome"
        $this->add([
            'type' => 'text',
            'name' => 'nome',
            'attributes' => [
                'id' => 'nome'
            ],
            'options' => [
                'label' => 'Nome'
            ],
        ]);
        
        //Adiciona o campo "Apelido"
        $this->add([
            'type' => 'text',
            'name' => 'apelido',
            'attributes' => [
                'id' => 'apelido'
            ],
            'options' => [
                'label' => 'Apelido'
            ],
        ]);
        
        //Adiciona o campo "foto"
        $this->add([
            'type' => 'text',
            'name' => 'foto',
            'attributes' => [
                'id' => 'foto'
            ],
            'options' => [
                'label' => 'Foto'
            ],
        ]);
        
        //Adiciona o campo "data_admissao"
        $this->add([
            'type' => 'text',
            'name' => 'data_admissao',
            'attributes' => [
                'id' => 'data_admissao'
            ],
            'options' => [
                'label' => 'Data admissão'
            ],
        ]);
        
        //Adiciona o campo "data_desligamento"
        $this->add([
            'type' => 'text',
            'name' => 'data_desligamento',
            'attributes' => [
                'id' => 'data_desligamento'
            ],
            'options' => [
                'label' => 'Data desligamento'
            ],
        ]);
        
        //Adiciona o campo "sexo"
        $this->add([
            'type' => 'text',
            'name' => 'sexo',
            'attributes' => [
                'id' => 'sexo'
            ],
            'options' => [
                'label' => 'Sexo'
            ],
        ]);
        
        //Adiciona o campo "data_nascimento"
        $this->add([
            'type' => 'text',
            'name' => 'data_nascimento',
            'attributes' => [
                'id' => 'data_nascimento'
            ],
            'options' => [
                'label' => 'Data nascimento'
            ],
        ]);
        
        
        
        
        //Adiciona o campo "Observaçoes"
        $this->add([
            'type' => 'text',
            'name' => 'observacoes',
            'attributes' => [
                'id' => 'observacoes'
            ],
            'options' => [
                'label' => 'Observações'
            ],
        ]);
        
        
        ////////////campos do endereço.../////////////////////////////////////////////
        
        //Adiciona o campo "Endereço"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [
                'id' => 'endereco'
            ],
            'options' => [
                'label' => 'Endereço'
            ],
        ]);
        
        //Adiciona o campo "Número"
        $this->add([
            'type' => 'text',
            'name' => 'numero',
            'attributes' => [
                'id' => 'numero'
            ],
            'options' => [
                'label' => 'Número'
            ],
        ]);
        
        //Adiciona o campo "Complemento"
        $this->add([
            'type' => 'text',
            'name' => 'complemento',
            'attributes' => [
                'id' => 'complemento'
            ],
            'options' => [
                'label' => 'Complemento'
            ],
        ]);
        
        //Adiciona o campo "Bairro"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);
        
        //Adiciona o campo "Cep"
        $this->add([
            'type' => 'text',
            'name' => 'cep',
            'attributes' => [
                'id' => 'cep'
            ],
            'options' => [
                'label' => 'Cep'
            ],
        ]);
        
        //Adiciona o campo "cidade"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'cidade',
            'options' => [
                        'label' => 'Cidade',
                        'object_manager' => $this->getObjectManager(),
                        'target_class' => \SigRH\Entity\Cidade::class,
                        'property' => 'cidade',
                        'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "Bairro"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);
        
//        //Adiciona o campo "Estado"
        $this->add([
            'type' => 'text',
            'name' => 'estado',
            'attributes' => [
                'id' => 'estado'
            ],
            'options' => [
                'label' => 'Estado'
            ],
        ]);


        ///////////////////////////////////////////////////////////////////////

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
            'name' => 'matricula',
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
                        'max' => 6
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
                        'min' => 2,
                        'max' => 200
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'apelido',
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
                        'min' => 2,
                        'max' => 50
                    ],
                ],
            ],
        ]);

        
    }

}

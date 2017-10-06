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
        
        
        //Adiciona o campo "nacionalidade"
        $this->add([
            'type' => 'text',
            'name' => 'nacionalidade',
            'attributes' => [
                'id' => 'nacionalidade'
            ],
            'options' => [
                'label' => 'Nacionalidade'
            ],
        ]);
        
        //Adiciona o campo "nome_pai"
        $this->add([
            'type' => 'text',
            'name' => 'nome_pai',
            'attributes' => [
                'id' => 'nome_pai'
            ],
            'options' => [
                'label' => 'Nome pai'
            ],
        ]);
        
        //Adiciona o campo "nome_mae"
        $this->add([
            'type' => 'text',
            'name' => 'nome_mae',
            'attributes' => [
                'id' => 'nome_mae'
            ],
            'options' => [
                'label' => 'Nome mãe'
            ],
        ]);
        
        //Adiciona o campo "telefone_residencial"
        $this->add([
            'type' => 'text',
            'name' => 'telefone_residencial',
            'attributes' => [
                'id' => 'telefone_residencial'
            ],
            'options' => [
                'label' => 'Telefone residencial'
            ],
        ]);
        
        //Adiciona o campo "telefone_celular"
        $this->add([
            'type' => 'text',
            'name' => 'telefone_celular',
            'attributes' => [
                'id' => 'telefone_celular'
            ],
            'options' => [
                'label' => 'Telefone celular'
            ],
        ]);
        
        //Adiciona o campo "ramal"
        $this->add([
            'type' => 'text',
            'name' => 'ramal',
            'attributes' => [
                'id' => 'ramal'
            ],
            'options' => [
                'label' => 'Ramal'
            ],
        ]);
        
        //Adiciona o campo "email"
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                'id' => 'email'
            ],
            'options' => [
                'label' => 'Email'
            ],
        ]);
        
        //Adiciona o campo "login_sede"
        $this->add([
            'type' => 'text',
            'name' => 'login_sede',
            'attributes' => [
                'id' => 'login_sede'
            ],
            'options' => [
                'label' => 'Login sede'
            ],
        ]);
        
        //Adiciona o campo "login_local"
        $this->add([
            'type' => 'text',
            'name' => 'login_local',
            'attributes' => [
                'id' => 'login_local'
            ],
            'options' => [
                'label' => 'Login local'
            ],
        ]);
        
        //Adiciona o campo "email_corporativo"
        $this->add([
            'type' => 'text',
            'name' => 'email_corporativo',
            'attributes' => [
                'id' => 'email_corporativo'
            ],
            'options' => [
                'label' => 'Email corporativo'
            ],
        ]);
        
        //Adiciona o campo "rg_numero"
        $this->add([
            'type' => 'text',
            'name' => 'rg_numero',
            'attributes' => [
                'id' => 'rg_numero'
            ],
            'options' => [
                'label' => 'Número RG' 
            ],
        ]);
        
        //Adiciona o campo "rg_data_emissao"
        $this->add([
            'type' => 'text',
            'name' => 'rg_data_emissao',
            'attributes' => [
                'id' => 'rg_data_emissao'
            ],
            'options' => [
                'label' => 'Data emissão RG' 
            ],
        ]);
        
        //Adiciona o campo "rg_orgao_expedidor"
        $this->add([
            'type' => 'text',
            'name' => 'rg_orgao_expedidor',
            'attributes' => [
                'id' => 'rg_orgao_expedidor'
            ],
            'options' => [
                'label' => 'Órgão expediro RG' 
            ],
        ]);

        //Adiciona o campo "cpf"
        $this->add([
            'type' => 'text',
            'name' => 'cpf',
            'attributes' => [
                'id' => 'cpf'
            ],
            'options' => [
                'label' => 'CPF' 
            ],
        ]);
        
        //Adiciona o campo "ctps_numero"
        $this->add([
            'type' => 'text',
            'name' => 'ctps_numero',
            'attributes' => [
                'id' => 'ctps_numero'
            ],
            'options' => [
                'label' => 'Número CTPS' 
            ],
        ]);
        
        //Adiciona o campo "ctps_serie"
        $this->add([
            'type' => 'text',
            'name' => 'ctps_serie',
            'attributes' => [
                'id' => 'ctps_serie'
            ],
            'options' => [
                'label' => 'Número CTPS série' 
            ],
        ]);
        
        //Adiciona o campo "ctps_data_expedicao"
        $this->add([
            'type' => 'text',
            'name' => 'ctps_data_expedicao',
            'attributes' => [
                'id' => 'ctps_data_expedicao'
            ],
            'options' => [
                'label' => 'Data expedição CTPS' 
            ],
        ]);
        
        //Adiciona o campo "pis"
        $this->add([
            'type' => 'text',
            'name' => 'pis',
            'attributes' => [
                'id' => 'pis'
            ],
            'options' => [
                'label' => 'PIS' 
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

        //Adiciona o campo "estado"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'estado',
            'options' => [
                        'label' => 'Estado',
                        'object_manager' => $this->getObjectManager(),
                        'target_class' => \SigRH\Entity\Estado::class,
                        'property' => 'sigla',
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

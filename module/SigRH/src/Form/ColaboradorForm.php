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
                'id' => 'matricula',
                'class' => 'form-control',
                'placeholder' => 'Digite a matrícula aqui'
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
                'id' => 'nome',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome aqui'
            ],
            'options' => [
                'label' => 'Nome'
            ],
        ]);

        //Adiciona o campo "tipo colaborador"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'tipoColaborador',
            'attributes' => [
                'id' => 'tipoColaborador',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Tipo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\TipoColaborador::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "Apelido"
        $this->add([
            'type' => 'text',
            'name' => 'apelido',
            'attributes' => [
                'id' => 'apelido',
                'class' => 'form-control',
                'placeholder' => 'Digite o apelido aqui'
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
                'id' => 'foto',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Foto'
            ],
        ]);
        
        //Adiciona o campo "data_admissao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataAdmissao',
            'attributes' => [
                'id' => 'dataAdmissao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data admissão'
            ],
        ]);

        //Adiciona o campo "data_desligamento"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataDesligamento',
            'attributes' => [
                'id' => 'dataDesligamento',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data desligamento'
            ],
        ]);

        //Adiciona o campo "sexo"
        $this->add([
            'type' => 'select',
            'name' => 'sexo',
            'attributes' => [
                'id' => 'sexo',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Sexo',
                'value_options' => [
                    "" => "Selecione",
                    "F" => "Feminino",
                    "M" => "Masculino"
                ]
            ],
        ]);

        //Adiciona o campo "grupo sanguineo"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'grupoSanguineo',
            'attributes' => [
                'id' => 'grupoSanguineo',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Grupo Sanguineo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\GrupoSanguineo::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "cor da pele"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'corPele',
            'attributes' => [
                'id' => 'corPele',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Cor da Pele',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\CorPele::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
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
                'format' => 'Y-m-d',
                'label' => 'Data nascimento'
            ],
        ]);

        //Adiciona o campo "natural (cidade)"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'natural',
            'attributes' => [
                'id' => 'natural',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Natural (Cidade)',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Cidade::class,
                'property' => 'cidade',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "natural (estado)"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'natural_estado',
            'attributes' => [
                'id' => 'natural_estado',
                'class' => 'form-control',
                'required' => false,
            ],
            'options' => [
                'label' => 'Natural (Estado)',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Estado::class,
                'property' => 'sigla',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "nacionalidade"
        $this->add([
            'type' => 'text',
            'name' => 'nacionalidade',
            'attributes' => [
                'id' => 'nacionalidade',
                'class' => 'form-control',
                'placeholder' => 'Digite a nacionalidade aqui',
                'required' => false,
            ],
            'options' => [
                'label' => 'Nacionalidade'
            ],
        ]);
        
        //Adiciona o campo "estado civil"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'estadoCivil',
            'attributes' => [
                'id' => 'estadoCivil',
                'required' => false,
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Estado Civil',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\EstadoCivil::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "grau instrução"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'grauInstrucao',
            'attributes' => [
                'id' => 'grauInstrucao',
                'required' => false,
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Grau de Instrução',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\GrauInstrucao::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);

        //Adiciona o campo "nome_pai"
        $this->add([
            'type' => 'text',
            'name' => 'nomePai',
            'attributes' => [
                'id'    => 'nomePai',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome do pai'
            ],
            'options' => [
                'label' => 'Nome do pai'
            ],
        ]);

        //Adiciona o campo "nome_mae"
        $this->add([
            'type' => 'text',
            'name' => 'nomeMae',
            'attributes' => [
                'id' => 'nomeMae',
                'class' => 'form-control',
                'placeholder' => 'Digite o nome da mãe'
            ],
            'options' => [
                'label' => 'Nome da mãe'
            ],
        ]);

        //Adiciona o campo "telefone residencial"
        $this->add([
            'type' => 'text',
            'name' => 'telefoneResidencial',
            'attributes' => [
                'id' => 'telefoneResidencial',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Telefone residencial'
            ],
        ]);

        //Adiciona o campo "telefone celular"
        $this->add([
            'type' => 'text',
            'name' => 'telefoneCelular',
            'attributes' => [
                'id' => 'telefoneCelular',
                'class' => 'form-control',
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
                'id' => 'ramal',
                'class' => 'form-control',
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
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Digite o e-mail aqui',
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
                'id' => 'login_sede',
                'class' => 'form-control',
                'placeholder' => 'Digite o login da sede aqui',
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
                'id' => 'login_local',
                'class' => 'form-control',
                'placeholder' => 'Digite o login local aqui'
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
                'id' => 'email_corporativo',
                'class' => 'form-control',
                'placeholder' => 'Digite o e-mail corporativo aqui'
            ],
            'options' => [
                'label' => 'Email corporativo'
            ],
        ]);
        
        //Adiciona o campo "portador_necessidade_especial"
        $this->add([
            'type' => 'select',
            'name' => 'necessidadeEspecial',
            'attributes' => [
                'id' => 'necessidadeEspecial',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Portador de necessidades especiais',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim",
                ]
            ],
        ]);

        //Adiciona o campo "rg_numero"
        $this->add([
            'type' => 'text',
            'name' => 'rgNumero',
            'attributes' => [
                'id' => 'rgNumero',
                'class' => 'form-control',
                'placeholder' => 'Digite o número do RG aqui',
            ],
            'options' => [
                'label' => 'Número do RG'
            ],
        ]);

        //Adiciona o campo "rg_data_emissao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'rgDataEmissao',
            'attributes' => [
                'id' => 'rgDataEmissao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data de emissão'
            ],
        ]);
        
        

        //Adiciona o campo "rg_orgao_expedidor"
        $this->add([
            'type' => 'text',
            'name' => 'rgOrgaoExpedidor',
            'attributes' => [
                'id' => 'rgOrgaoExpedidor',
                'class' => 'form-control',
                'placeholder' => 'Digite o órgão expedidor aqui',
            ],
            'options' => [
                'label' => 'Órgão expedidor'
            ],
        ]);

        //Adiciona o campo "cpf"
        $this->add([
            'type' => 'text',
            'name' => 'cpf',
            'attributes' => [
                'id' => 'cpf',
                'class' => 'form-control',
                'placeholder' => 'Digite o número do CPF aqui',
            ],
            'options' => [
                'label' => 'Número do CPF'
            ],
        ]);

        //Adiciona o campo "ctps_numero"
        $this->add([
            'type' => 'text',
            'name' => 'ctpsNumero',
            'attributes' => [
                'id' => 'ctpsNumero',
                'class' => 'form-control',
                'placeholder' => 'Digite o número da CTPS aqui',
                'required' => false,
            ],
            'options' => [
                'label' => 'Número da CTPS'
            ],
        ]);

        //Adiciona o campo "ctps_serie"
        $this->add([
            'type' => 'text',
            'name' => 'ctpsSerie',
            'attributes' => [
                'id' => 'ctpsSerie',
                'class' => 'form-control',
                'placeholder' => 'Digite a Série da CTPS aqui',
            ],
            'options' => [
                'label' => 'Série'
            ],
        ]);
        
        //Adiciona o campo "ctps_uf"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'ctpsUf',
            'attributes' => [
                'id' => 'ctpsUf',
                'class' => 'form-control',
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

        //Adiciona o campo "ctps_data_expedicao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'ctpsDataExpedicao',
            'attributes' => [
                'id' => 'ctpsDataExpedicao',
                'class' => 'form-control',
                'required' => false,
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data expedição'
            ],
        ]);

        //Adiciona o campo "pis"
        $this->add([
            'type' => 'text',
            'name' => 'pis',
            'attributes' => [
                'id' => 'pis',
                'class' => 'form-control',
                'placeholder' => 'Digite o número do PIS aqui',

            ],
            'options' => [
                'label' => 'Número do PIS'
            ],
        ]);

        //Adiciona o campo "Observaçoes"
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
        
        //Adiciona o campo "loginSede"
        $this->add([
            'type' => 'text',
            'name' => 'loginSede',
            'attributes' => [
                'id' => 'loginSede',
                'class' => 'form-control',
                'placeholder' => 'Digite o login corporativo aqui'
            ],
            'options' => [
                'label' => 'Login corporativo (Embrapa Sede)'
            ],
        ]);

        //Adiciona o campo "loginLocal"
        $this->add([
            'type' => 'text',
            'name' => 'loginLocal',
            'attributes' => [
                'id' => 'loginLocal',
                'class' => 'form-control',
                'placeholder' => 'Digite o login local aqui'
            ],
            'options' => [
                'label' => 'Login local (Embrapa Soja)'
            ],
        ]);
        
        //Adiciona o campo "emailCorporativo"
        $this->add([
            'type' => 'text',
            'name' => 'emailCorporativo',
            'attributes' => [
                'id' => 'emailCorporativo',
                'class' => 'form-control',
                'placeholder' => 'Digite o e-mail corporativo aqui'
            ],
            'options' => [
                'label' => 'E-mail corporativo'
            ],
        ]);
        
        
        //Adiciona o campo "linhaOnibus"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'linhaOnibus',
            'attributes' => [
                'id' => 'linhaOnibus',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Linha de ônibus',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\LinhaOnibus::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        

        ////////////campos do endereço.../////////////////////////////////////////////
        //Adiciona o campo "Endereço"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [
                'id' => 'endereco',
                'class' => 'form-control',
                'placeholder' => 'Digite o endereço aqui'

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
                'id' => 'numero',
                'class' => 'form-control',
                'placeholder' => 'Digite o número aqui'
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
                'id' => 'complemento',
                'class' => 'form-control',
                'placeholder' => 'Digite o complemento aqui'
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
                'id' => 'bairro',
                'class' => 'form-control',
                'placeholder' => 'Digite o bairro aqui'
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
                'id' => 'cep',
                'class' => 'form-control',
                'placeholder' => 'Digite o cep aqui'
            ],
            'options' => [
                'label' => 'Cep'
            ],
        ]);

        //Adiciona o campo "cidade"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Cidade',
                'empty_option' => 'Selecione',
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
            'attributes' => [
                'id' => 'estado',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Estado',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Estado::class,
                'property' => 'sigla',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "supervisor"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'supervisor',
            'attributes' => [
                'id' => 'supervisor',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Supervisor',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \SigRH\Entity\Colaborador::class,
                'property' => 'nome',
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 2,
                            'tipoColaborador' => 1, //empregado
                            'ativo' => 'S'
                         ]
                    ]
                ],
                
                'display_empty_item' => true,
            ]
        ]);

//        //Adiciona o campo "Bairro"
//        $this->add([
//            'type' => 'text',
//            'name' => 'bairro',
//            'attributes' => [
//                'id' => 'bairro'
//            ],
//            'options' => [
//                'label' => 'Bairro'
//            ],
//        ]);

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

        ////////////////////////////pk//////////////////////////////////////////
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
        
        /////////////////////////fks///////////////////////////////////////////
        //responsavel_id
        $inputFilter->add([
            'name' => 'responsavel',
            'required' => false,
        ]);
        
        //natural_id
        $inputFilter->add([
            'name' => 'natural',
            'required' => false,
        ]);
        
        //natural_estado
        $inputFilter->add([
            'name' => 'natural_estado',
            'required' => false,
        ]);
        
        //sexo_id
        $inputFilter->add([
            'name' => 'sexo',
            'required' => false,
        ]);

        //grupo_sanguineo_id
        $inputFilter->add([
            'name' => 'grupoSanguineo',
            'required' => false,
        ]);

        //cor_pele_id
        $inputFilter->add([
            'name' => 'corPele',
            'required' => false,
        ]);

        //estado_civil_id
        $inputFilter->add([
            'name' => 'estadoCivil',
            'required' => false,
        ]);

        //grau_instrucao_id
        $inputFilter->add([
            'name' => 'grauInstrucao',
            'required' => false,
        ]);
        
        //estado_id
        $inputFilter->add([
            'name' => 'estado',
            'required' => false,
        ]);
        
        //cidade_id
        $inputFilter->add([
            'name' => 'cidade',
            'required' => false,
        ]);
        
        //ctps_uf_id
        $inputFilter->add([
            'name' => 'ctpsUf',
            'required' => false,
        ]);
        
        //ctps_data_expedicao
        $inputFilter->add([
            'name' => 'ctpsDataExpedicao',
            'required' => false,
        ]);
        
        //tipo_colaborador
        $inputFilter->add([
            'name' => 'tipoColaborador',
            'required' => false,
        ]);
        
        //linha_onibus
        $inputFilter->add([
            'name' => 'linhaOnibus',
            'required' => false,
        ]);
        
 //////////////////////////////////////////////////////////////////////////////       

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
                        'max' => 50
                    ],
                ],
            ],
        ]);
        
        //data_desligamento
        $inputFilter->add([
            'name' => 'dataDesligamento',
            'required' => false,
        ]);
        
        
    }

}

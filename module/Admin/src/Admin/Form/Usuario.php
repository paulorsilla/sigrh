<?php
namespace Admin\Form;
 
use Zend\Form\Form;
 
class Usuario extends Form

{
        private $_sm = null;
	public function __construct($sm)
	{
		parent::__construct('usuario');
                 $this->_sm = $sm;
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/admin/usuario/save');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
			'type' => 'hidden',
			),
		));
		$this->add(array(
			'name' => 'nome',
			'attributes' => array(
				'type' => 'text',
                                'required' => true,
                                'class' => 'form-control' //incluir
				),
			'options' => array(
			'label' => 'Nome',
			),
		));
		$this->add(array(
			'name' => 'login',
			'attributes' => array(
                                'required' => true,
				'type' => 'text',
                                'class' => 'form-control' //incluir
			),
			'options' => array(
				'label' => 'Login',
			),
		));
		
		$this->add(array(
			'name' => 'funcao',
                        'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
                            'required' => true,
                            'id' => 'funcao',
                            'class' => 'form-control', //incluir
                            'options' => array(
                                '' => '--- Escolha uma função ---',
                                'comum' => 'Comum',
                                'secretaria' => 'Secretária',
                                'admin' => 'Administrador do sistema',
                            ),
			),
			'options' => array(
				'label' => 'Função',
			),
		));
                
		$this->add(array(
			'name' => 'email',
			'attributes' => array(
                                'required' => true,
				'type' => 'text',
                                'class' => 'form-control', //incluir
			),
			'options' => array(
				'label' => 'E-mail',
			),
		));
                
                $this->add(array(
			'name' => 'ramal',
			'attributes' => array(
                                'required' => true,
				'type' => 'text',
                                'class' => 'form-control', //incluir
			),
			'options' => array(
				'label' => 'Ramal',
			),
		));

                $this->add(array(
			'name' => 'usaldap',
			'attributes' => array(
				'type' => 'Checkbox',
                                'value' => '1',
//                                'checked' => 'True',
	                        'class' => 'form-control', //incluir
		),
			'options' => array(
				'label' => 'Autenticar na base Ldap (usuário interno)',
			),
		));

                $this->add(array(
			'name' => 'senha',
			'attributes' => array(
				'type' => 'password',
//                                'disabled' => 'true',
                                'class' => 'form-control', //incluir
			),
			'options' => array(
				'label' => 'Senha (usuário externo)',
			),
		));
                
                $this->add(array(
                    'name'       => 'matricula',
                    'type'   => 'Select',
                    'attributes' => array(
                        'style' => 'width: 250px',
                        'required' => true,
                        'options' => $this->getListFuncCombo('-- Selecione um empregado --',true)
                    ),
                    'options'    => array(
                        'label'           => 'Matrícula',
                    )
                ));
                
               
                $this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Salvar',
				'id' => 'submitbutton',
                                'class' => 'btn btn-primary', //incluir
			),
		));
                
	}
        
       private function getListFuncCombo($padrao = '-- Selecione um funcionário',$somenteFunc = false) {
            $lista = $this->_sm->get('service_funcionario')->getListFuncionariosParaComboMatricula(0,$somenteFunc);
            
            return array(''=>$padrao)+$lista;
            
        }

}
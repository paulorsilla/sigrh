<?php

return [
    'acl' => array(
		'roles' => array(
                        'convidado' => null,
                        'comum' => 'convidado',
                        'usuario' => 'comum',
			'admin' => 'usuario',
		),
		'resources' => array(
                        'Application\Controller\Index.index',
                    
                        'SigRH\Controller\Banco.index',
                        'SigRH\Controller\Banco.save',
                        'SigRH\Controller\Banco.delete',
                    
                        'SigRH\Controller\BatidaPonto.index',
                        'SigRH\Controller\BatidaPonto.folhaPonto',
                    
                        'SigRH\Controller\Cidade.index',
                        'SigRH\Controller\Cidade.save',
                        'SigRH\Controller\Cidade.buscaCidades',
                    
                        'SigRH\Controller\Colaborador.index',
                        'SigRH\Controller\Colaborador.save',
                        'SigRH\Controller\Colaborador.delete',
                    
                        'SigRH\Controller\ContaCorrente.index',
                        'SigRH\Controller\ContaCorrente.gridModal',
                        'SigRH\Controller\ContaCorrente.saveModal',
                        'SigRH\Controller\ContaCorrente.deleteModal',
                    
                        'SigRH\Controller\Convenio.index',
                        'SigRH\Controller\Convenio.save',
                        'SigRH\Controller\Convenio.delete',
                    
                        'SigRH\Controller\CorPele.index',
                        'SigRH\Controller\CorPele.save',
                        'SigRH\Controller\CorPele.delete',
                    
                        'SigRH\Controller\Cracha.index',
                        'SigRH\Controller\Cracha.gridModal',
                        'SigRH\Controller\Cracha.saveModal',
//                        'SigRH\Controller\Cracha.deleteModal',
                    
                        'SigRH\Controller\Curso.index',
                        'SigRH\Controller\Curso.save',
                        'SigRH\Controller\Curso.delete',
                    
                        'SigRH\Controller\Dependente.gridModal',
                        'SigRH\Controller\Dependente.saveModal',
//                        'SigRH\Controller\Dependente.deleteModal',
                    
                        'SigRH\Controller\Escala.index',
                        'SigRH\Controller\Escala.save',
                        'SigRH\Controller\Escala.delete',
                    
                        'SigRH\Controller\EstadoCivil.index',
                        'SigRH\Controller\EstadoCivil.save',
                        'SigRH\Controller\EstadoCivil.delete', 
                    
                        'SigRH\Controller\FonteSeguro.index',
                        'SigRH\Controller\FonteSeguro.save',
                        'SigRH\Controller\FonteSeguro.delete', 
                    
                        'SigRH\Controller\GrauInstrucao.index',
                        'SigRH\Controller\GrauInstrucao.save',
                        'SigRH\Controller\GrauInstrucao.delete', 
                    
                        'SigRH\Controller\GrupoSanguineo.index',
                        'SigRH\Controller\GrupoSanguineo.save',
                        'SigRH\Controller\GrupoSanguineo.delete', 

                        'SigRH\Controller\Horario.gridModal',
                        'SigRH\Controller\Horario.saveModal',
                        'SigRH\Controller\Horario.deleteModal',

                        'SigRH\Controller\ImportacaoPonto.index',
                        'SigRH\Controller\ImportacaoPonto.save',
                        'SigRH\Controller\ImportacaoPonto.delete', 
                    
                        'SigRH\Controller\Instituicao.index',
                    
                        'SigRH\Controller\LinhaOnibus.index',
                        'SigRH\Controller\LinhaOnibus.save',
                        'SigRH\Controller\LinhaOnibus.delete', 
                    
                        'SigRH\Controller\Localizacao.index',
                        'SigRH\Controller\Localizacao.save',
                        'SigRH\Controller\Localizacao.delete', 
                    
                        'SigRH\Controller\ModalidadeBolsa.index',
                        'SigRH\Controller\ModalidadeBolsa.save',
                        'SigRH\Controller\ModalidadeBolsa.delete', 
                    
                        'SigRH\Controller\Nivel.index',
                        'SigRH\Controller\Nivel.save',
                        'SigRH\Controller\Nivel.delete', 
                    
                        'SigRH\Controller\Ocorrencia.index',
                        'SigRH\Controller\Ocorrencia.gerar',
                    
                        'SigRH\Controller\RelColaborador.index',
                        'SigRH\Controller\RelColaborador.gerarHtml',
                    
                        'SigRH\Controller\Sublotacao.index',
                        'SigRH\Controller\Sublotacao.save',
                        'SigRH\Controller\Sublotacao.delete', 
                     
                         
                        'SigRH\Controller\TipoColaborador.index',
                        'SigRH\Controller\TipoColaborador.save',
                        'SigRH\Controller\TipoColaborador.delete', 
                    
                        'SigRH\Controller\TipoVinculo.index',
                        'SigRH\Controller\TipoVinculo.save',
                    
                        'SigRH\Controller\Vinculo.index',
                        'SigRH\Controller\Vinculo.save',
                        'SigRH\Controller\Vinculo.delete', 
                    
                    
			'Admin\Controller\Index.save',
			'Admin\Controller\Index.delete',
			'Admin\Controller\Auth.index',
			'Admin\Controller\Auth.login',
			'Admin\Controller\Auth.logout',
			'Admin\Controller\Usuario.index',
			'Admin\Controller\Usuario.save',
			'Admin\Controller\Usuario.busca',
			'Admin\Controller\Usuario.delete',
			),
		'privilege' => array(
                        'convidado' => array(
				'allow' => array(
                                    'Application\Controller\Index.index',
                                    'Admin\Controller\Auth.index',
                                    'Admin\Controller\Auth.login',
                                    'Admin\Controller\Auth.logout',
                                    )
                            ),
			'usuario' => array(
				'allow' => array(
                                        'SigRH\Controller\Banco.index',
                                        'SigRH\Controller\Banco.save',

                                        'SigRH\Controller\Cidade.index',
                                        'SigRH\Controller\Cidade.save',
                                        'SigRH\Controller\Cidade.buscaCidades',

                                        'SigRH\Controller\Colaborador.index',
                                        'SigRH\Controller\Colaborador.save',

                                        'SigRH\Controller\ContaCorrente.index',
                                        'SigRH\Controller\ContaCorrente.gridModal',
                                        'SigRH\Controller\ContaCorrente.saveModal',

                                        'SigRH\Controller\Convenio.index',
                                        'SigRH\Controller\Convenio.save',

                                        'SigRH\Controller\CorPele.index',
                                        'SigRH\Controller\CorPele.save',

                                        'SigRH\Controller\Cracha.index',
                                        'SigRH\Controller\Cracha.gridModal',
                                        'SigRH\Controller\Cracha.saveModal',

                                        'SigRH\Controller\Curso.index',
                                        'SigRH\Controller\Curso.save',

                                        'SigRH\Controller\Dependente.gridModal',
                                        'SigRH\Controller\Dependente.saveModal',

                                        'SigRH\Controller\Escala.index',
                                        'SigRH\Controller\Escala.save',

                                        'SigRH\Controller\EstadoCivil.index',
                                        'SigRH\Controller\EstadoCivil.save',

                                        'SigRH\Controller\FonteSeguro.index',
                                        'SigRH\Controller\FonteSeguro.save',

                                        'SigRH\Controller\GrauInstrucao.index',
                                        'SigRH\Controller\GrauInstrucao.save',

                                        'SigRH\Controller\GrupoSanguineo.index',
                                        'SigRH\Controller\GrupoSanguineo.save',

                                        'SigRH\Controller\Horario.gridModal',
                                        'SigRH\Controller\Horario.saveModal',

                                        'SigRH\Controller\Instituicao.index',

                                        'SigRH\Controller\LinhaOnibus.index',
                                        'SigRH\Controller\LinhaOnibus.save',

                                        'SigRH\Controller\Localizacao.index',
                                        'SigRH\Controller\Localizacao.save',

                                        'SigRH\Controller\ModalidadeBolsa.index',
                                        'SigRH\Controller\ModalidadeBolsa.save',

                                        'SigRH\Controller\Nivel.index',
                                        'SigRH\Controller\Nivel.save',

                                        'SigRH\Controller\RelColaborador.index',
                                        'SigRH\Controller\RelColaborador.gerarHtml',

                                        'SigRH\Controller\Sublotacao.index',
                                        'SigRH\Controller\Sublotacao.save',


                                        'SigRH\Controller\TipoColaborador.index',
                                        'SigRH\Controller\TipoColaborador.save',

                                        'SigRH\Controller\TipoVinculo.index',
                                        'SigRH\Controller\TipoVinculo.save',

                                        'SigRH\Controller\Vinculo.index',
                                        'SigRH\Controller\Vinculo.save',
                                        
                                        
				)
			),
			'admin' => array(
				'allow' => array(
                                         //cadastro usuario...
                                        'Admin\Controller\Index.delete',
					'Admin\Controller\Usuario.index',
                 			'Admin\Controller\Usuario.busca',
					'Admin\Controller\Usuario.save',
					'Admin\Controller\Usuario.delete',
                                        //ponto ...
                                        'SigRH\Controller\BatidaPonto.index',
                                        'SigRH\Controller\BatidaPonto.folhaPonto',
                                        'SigRH\Controller\ImportacaoPonto.index',
                                        'SigRH\Controller\ImportacaoPonto.save',
                                        'SigRH\Controller\ImportacaoPonto.delete', 
                                        'SigRH\Controller\Ocorrencia.index',
                                        'SigRH\Controller\Ocorrencia.gerar',
                                         //excluir nos cadastros...
                                        'SigRH\Controller\Banco.delete',
                                        'SigRH\Controller\Colaborador.delete',
                                        'SigRH\Controller\ContaCorrente.deleteModal',
                                        'SigRH\Controller\Convenio.delete',
                                        'SigRH\Controller\CorPele.delete',
                                        'SigRH\Controller\Curso.delete',
                                        'SigRH\Controller\Escala.delete',
                                        'SigRH\Controller\EstadoCivil.delete', 
                                        'SigRH\Controller\FonteSeguro.delete', 
                                        'SigRH\Controller\GrauInstrucao.delete', 
                                        'SigRH\Controller\GrupoSanguineo.delete', 
                                        'SigRH\Controller\Horario.deleteModal',
                                        'SigRH\Controller\LinhaOnibus.delete', 
                                        'SigRH\Controller\Localizacao.delete', 
                                        'SigRH\Controller\ModalidadeBolsa.delete', 
                                        'SigRH\Controller\Nivel.delete', 
                                        'SigRH\Controller\Sublotacao.delete', 
                                        'SigRH\Controller\TipoColaborador.delete', 
                                        'SigRH\Controller\Vinculo.delete', 
                                    
                                    
				)
			),
			'comum' => array(
				'allow' => array(
                                        'SigRH\Controller\RelColaborador.index',
                                        'SigRH\Controller\RelColaborador.gerarHtml',
				)
			),
                    
		)
	)
    
];

<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SigRH;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            
            'sig-rh' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/sig-rh',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                
                'may_terminate' => true,
                'child_routes' => [
                    'banco' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/banco[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\BancoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
//                    'batida-ponto' => [
//                        'type' => Segment::class,
//                        'options' => [
//                            'route' => '/batida-ponto[/:action[/:id]]',
//                            'constraints' => [
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'id' => '[0-9]+'
//                            ],
//                            'defaults' => [
//                                'controller' => Controller\BatidaPontoController::class,
//                                'action' => 'index'
//                            ]
//                        ]
//                    ],
                    
                    'cidade' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/cidade[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CidadeController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'colaborador' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/colaborador[/:action[/:id][/:ativo][/:page]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ColaboradorController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'convenio' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/convenio[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ConvenioController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'conta-corrente' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/conta-corrente[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ContaCorrenteController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'cor-pele' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/cor-pele[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CorPeleController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'cracha' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/cracha[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CrachaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'curso' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/curso[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CursoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'dependente' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/dependente[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\DependenteController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'estado-civil' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/estado-civil[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\EstadoCivilController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
//                    'estagio' => [
//                        'type' => Segment::class,
//                        'options' => [
//                            'route' => '/estagio[/:action[/:id]]',
//                            'constraints' => [
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'id' => '[0-9]+'
//                            ],
//                            'defaults' => [
//                                'controller' => Controller\EstagioController::class,
//                                'action' => 'index'
//                            ]
//                        ]
//                    ],

                    'feriado' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/feriado[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\FeriadoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
//                    'vinculo' => [
//                        'type' => Segment::class,
//                        'options' => [
//                            'route' => '/vinculo[/:action[/:id]]',
//                            'constraints' => [
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'id' => '[0-9]+'
//                            ],
//                            'defaults' => [
//                                'controller' => Controller\VinculoController::class,
//                                'action' => 'index'
//                            ]
//                        ]
//                    ],
                    
                    'fonte-seguro' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/fonte-seguro[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\FonteSeguroController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'grau-instrucao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/grau-instrucao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\GrauInstrucaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'grupo-sanguineo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/grupo-sanguineo[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\GrupoSanguineoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'horario' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/horario[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\HorarioController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'importacao-ponto' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/importacao-ponto[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ImportacaoPontoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ], 
                    
                    'instituicao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/instituicao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\InstituicaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'linha-onibus' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/linha-onibus[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\LinhaOnibusController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'localizacao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/localizacao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\LocalizacaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'modalidade-bolsa' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modalidade-bolsa[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ModalidadeBolsaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'movimentacao-ponto' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/movimentacao-ponto[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MovimentacaoPontoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'nivel' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/nivel[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\NivelController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'ocorrencia' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/ocorrencia[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\OcorrenciaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],                    
                    
                    'rel-colaborador' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/rel-colaborador[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\RelColaboradorController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],                    
                    
                    'sublotacao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/sublotacao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\SublotacaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'tipo-colaborador' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/tipo-colaborador[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\TipoColaboradorController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'vinculo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/vinculo[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\VinculoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                ],
            ],
        ],
    ],
    
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\BancoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\CidadeController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ColaboradorController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ContaCorrenteController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ConvenioController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\CorPeleController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\CrachaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\CursoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\DependenteController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\EscalaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\EstadoCivilController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\FeriadoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\FonteSeguroController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\GrauInstrucaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\GrupoSanguineoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\HorarioController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\InstituicaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ImportacaoPontoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\LinhaOnibusController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\LocalizacaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ModalidadeBolsaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MovimentacaoPontoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\NivelController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\OcorrenciaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\RelColaboradorController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\SublotacaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\TipoColaboradorController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\VinculoController::class => Service\Factory\PadraoControllerFactory::class,
        ],
    ],
    
    'access_filter' => [ // Customizar as pemissoes de acesso
        
        /*
         *  1 => "Admin", 
            2 => "Usuario", 
            3 => "Comum", 
            4 => "Estudante", 
            5 => "Convidado"
         */
    'controllers' => [
            /* Cadastros Gerais */
            Controller\BancoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\CidadeController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\ColaboradorController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\ContaCorrenteController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],

            Controller\ConvenioController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\CorPeleController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\CrachaController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\CursoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\DependenteController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\EscalaController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\EstadoCivilController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
//            Controller\EstagioController::class => [
//                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
//                ['actions' => ['delete'], 'allow' => 1] // admin
//            ],
                    
            Controller\FeriadoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
        
            Controller\FonteSeguroController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\GrauInstrucaoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\GrupoSanguineoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\HorarioController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\InstituicaoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],

            Controller\LinhaOnibusController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\LocalizacaoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],

            Controller\ModalidadeBolsaController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\NivelController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\OcorrenciaController::class => [
                ['actions' => ['save'], 'allow' => 'admin'],
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\SublotacaoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
//            Controller\TermoController::class => [
//                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
//                ['actions' => ['delete'], 'allow' => 1] // admin
//            ],
            
            Controller\TipoColaboradorController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],
            
            Controller\VinculoController::class => [
                ['actions' => ['index','save'], 'allow' => array(1,2)],  // Admin e Usuario
                ['actions' => ['delete'], 'allow' => 1] // admin
            ],

            /* Relatorios */
            Controller\RelColaboradorController::class => [
                ['actions' => ['index','gerar-html','csv'], 'allow' => array(1,2,3,5)]
            ],
            
            /* ponto */
//            Controller\BatidaPontoController::class => [
//                ['actions' => ['index', 'folhaPonto'], 'allow' => 1]
//            ],
//            
            Controller\MovimentacaoPontoController::class => [
                ['actions' => ['index'], 'allow' => 1]
            ],
        
            Controller\ImportacaoPontoController::class => [
                ['actions' => ['index'], 'allow' => 1]
            ],

            Controller\OcorrenciaController::class => [
                ['actions' => ['gerar'], 'allow' => 1]
            ]
        ]
        
    ],
    
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    
    'service_manager' => [
        'factories' => [
            Service\Atividades::class => Service\Factory\AtividadesFactory::class,
            Service\Embraorc::class => Service\Factory\EmbraorcFactory::class,
            Service\FileUpload::class => Service\Factory\FileUploadFactory::class
        ]
    ],
    
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'sigrh/index/index' => __DIR__ . '/../view/sig-rh/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];

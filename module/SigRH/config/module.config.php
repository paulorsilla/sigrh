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
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
//            Controller\IndexController::class => InvokableFactory::class,
            Controller\IndexController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\BancoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\TipoColaboradorController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\LinhaOnibusController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\GrauInstrucaoController::class => Service\Factory\PadraoControllerFactory::class,
        ],
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
//                            Service\AmostraManager::class => Service\Factory\AmostraManagerFactory::class,
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
    ],
];

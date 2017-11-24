<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
                'service_manager' => [
                        'factories' => [
                            'adapter_cti' => function($serviceLocator) // adaptador para acesso ao banco de dados de projetos
                            {
                                    $config = $serviceLocator->get('Config');
                                    return new \Zend\Db\Adapter\Adapter($config['db_cti']);
                            }       

                        ]
                ],
		// Session configuration.
		'session_config' => [
				// Session cookie will expire in 1 day.
				'cookie_lifetime' => 60 * 60 * 24 * 1,
				// Session data will be stored on server maximum for 30 days.
				'gc_maxlifetime' => 60 * 60 * 24 * 30 
		],
		// Session manager configuration.
		'session_manager' => [
				// Session validators (used for security).
				'validators' => [ 
						RemoteAddr::class,
						HttpUserAgent::class 
				] 
		],
		// Session storage configuration.
		'session_storage' => [ 
				'type' => SessionArrayStorage::class 
		]
];

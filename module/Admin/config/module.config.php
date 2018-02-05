<?php 

namespace Admin;
 
// module/Admin/conﬁg/module.config.php:
return array(
	'controllers' => array( //add module controllers
		'invokables' => array(
			'Admin\Controller\Index' => 'Admin\Controller\IndexController',
			'Admin\Controller\Auth' => 'Admin\Controller\AuthController',
			'Admin\Controller\Usuario' => 'Admin\Controller\UsuarioController',
		),
	),
 
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/admin',
					'defaults' => array(
						'__NAMESPACE__' => 'Admin\Controller',
						'controller' => 'Index',
						'action' => 'index',
						'module' => 'admin'
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
							),
						),
						'child_routes' => array( //permite mandar dados pela url
							'wildcard' => array(
								'type' => 'Wildcard'
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array( //the module can have a specific layout
		// 'template_map' => array(
		// 'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
		// ),
		'template_path_stack' => array(
			'admin' => __DIR__ . '/../view',
		),
	),
	'service_manager' => array(
		'factories' => array(
			'Session' => function($sm) {
				return new \Zend\Session\Container('NCO');
			},
			'Admin\Service\Auth' => function($sm) {
				//$dbAdapter = $sm->get('DbAdapter');
				return new Service\Auth();
			},
			'Cache' => function($sm) {
				$config = $sm->get('Configuration');
				$cache = StorageFactory::factory(
				array(
					'adapter' => $config['cache']['adapter'],
					'plugins' => array(
						'exception_handler' => array('throw_exceptions' => false),
							'Serializer'
					),
				)
				);
 
				return $cache;
			},
			'Doctrine\ORM\EntityManager' => function($sm) {
				$config = $sm->get('Configuration');
				$doctrineConfig = new \Doctrine\ORM\Configuration();
				$cache = new $config['doctrine']['driver']['cache'];
				$doctrineConfig->setQueryCacheImpl($cache);
				$doctrineConfig->setProxyDir('/tmp');
				$doctrineConfig->setProxyNamespace('EntityProxy');
				$doctrineConfig->setAutoGenerateProxyClasses(true);
				$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
					new \Doctrine\Common\Annotations\AnnotationReader(),
					array($config['doctrine']['driver']['paths'])
				);
				$doctrineConfig->setMetadataDriverImpl($driver);
				$doctrineConfig->setMetadataCacheImpl($cache);
				\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
					getenv('PROJECT_ROOT'). '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
				);
				$em = \Doctrine\ORM\EntityManager::create(
					$config['doctrine']['connection'],
					$doctrineConfig
				);
				return $em;
		
			},
		)
	),
	'doctrine' => array(
		'driver' => array(
			'cache' => 'Doctrine\Common\Cache\ArrayCache',
			'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Model')
		),
	)
);
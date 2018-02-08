<?php

namespace Admin;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
		'Zend\Loader\ClassMapAutoloader' => array(
			__DIR__ . '/autoload_classmap.php',
		),
		'Zend\Loader\StandardAutoloader' => array(
			'namespaces' => array(
			__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
			),
		),
		);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	/**
	* Retorna a configuração do service manager do módulo
	* @return array
	*/
	public function getServiceConfig()
	{
		return array(
		'factories' => array(
		'Admin\Service\Auth' => function($sm) {
			$dbAdapter = $sm->get('DbAdapter');
			return new Service\Auth($dbAdapter);
		},
		),
		);
	}
	
	/**
	* Executada no bootstrap do módulo
	*
	* @param MvcEvent $e
	*/
	public function onBootstrap(\Zend\Mvc\MvcEvent $e)
	{
		/** @var \Zend\ModuleManager\ModuleManager $moduleManager */
		$moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
		/** @var \Zend\EventManager\SharedEventManager $sharedEvents */
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		
		//adiciona eventos ao módulo
		$sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
                
                $em = $e->getApplication()->getEventManager();
                $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR,[$this,'handleException']);
                $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR,[$this,'handleException']);
	}

        public function handleException(\Zend\Mvc\MvcEvent $event){
            
            $error = $event->getParam("exception");
            
            $event->getViewModel()->setVariable("exception", $error);
        }
        
	 /**
	* Verifica se precisa fazer a autorização do acesso
	* @param MvcEvent $event Evento
	* @return boolean
	*/
	public function mvcPreDispatch($event)
	{
            die('TEST2');
		$di = $event->getTarget()->getServiceLocator();
		$routeMatch = $event->getRouteMatch();
		$moduleName = $routeMatch->getParam('module');
		$controllerName = $routeMatch->getParam('controller');
		$actionName = $routeMatch->getParam('action');
		
		$authService = $di->get('Admin\Service\Auth');
                if (! $authService->authorize($moduleName, $controllerName, $actionName)) {
			throw new \Exception("Você não tem permissão para acessar este recurso. [ $moduleName : $controllerName : $actionName ]");
		}
		return true;
	}
}

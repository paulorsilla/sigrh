<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SigRH;

use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.2';

    public function onBootstrap(MvcEvent $event){
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach( 'Zend\Mvc\Controller\ActionController', 'dispatch', array( $this, 'mvcPreDispatch' ), 100 );
        $sharedEventManager->attach( 'Zend\Mvc\Controller\AbstractActionController', 'dispatch', array( $this, 'mvcPreDispatch' ), 100 );
        
        
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function mvcPreDispatch(MvcEvent $event){
        //die('Passou no PreDispatch');
        // validar se o acesso é permitido pela ACL configurada
        
    }
}

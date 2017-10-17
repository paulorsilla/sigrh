<?php
/**
 * @link      http://github.com/zendframework/zend-mvc-console for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\Console\Service;

use Interop\Container\ContainerInterface;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerManagerDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * Add a ControllerManager initializer to inject the console into AbstractConsoleController instances.
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param null|array $options
     * @return \Zend\Mvc\Controller\ControllerManager
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $controllers = $callback();
        $controllers->addInitializer([$this, 'injectConsole']);
        return $controllers;
    }

    /**
     * Add a ControllerManager initializer to inject the console into AbstractConsoleController instances. (v2)
     *
     * @param ServiceLocatorInterface $container
     * @param string $name
     * @param string $requestedName
     * @param callable $callback
     * @return \Zend\Mvc\Controller\ControllerManager
     */
    public function createDelegatorWithName(ServiceLocatorInterface $container, $name, $requestedName, $callback)
    {
        return $this($container, $requestedName, $callback);
    }

    /**
     * Initializer: inject a Console instance into AbstractConsoleController instances.
     *
     * @param ContainerInterface|mixed $first ContainerInterface under
     *     zend-servicemanager v3, instance to inspect under v2.
     * @param mixed|ServiceLocatorInterface $second Instance to inspect
     *     under zend-servicemanager v3, plugin manager under v3.
     * @return void
     */
    public function injectConsole($first, $second)
    {
        if ($first instanceof ContainerInterface) {
            // v3
            $container = $first;
            $controller = $second;
        } else {
            // For v2, we need to pull the parent service locator
            $container = $second->getServiceLocator() ?: $second;
            $controller = $first;
        }

        if (! $controller instanceof AbstractConsoleController) {
            return;
        }

        $controller->setConsole($container->get('Console'));
    }
}

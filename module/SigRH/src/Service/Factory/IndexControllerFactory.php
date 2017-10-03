<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SigRH\Controller\IndexController;

/**
 * Factory para instanciar IndexController
 */

class IndexControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$entityManager = $container->get('doctrine.entitymanager.orm_default');

		return new IndexController($entityManager);
	}
}
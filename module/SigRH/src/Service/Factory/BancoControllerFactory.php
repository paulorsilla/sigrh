<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SigRH\Controller\BancoController;

/**
 * Factory para instanciar IndexController
 */

class BancoControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
		return new BancoController($entityManager);
	}
}
<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory genérico para instanciar os Controllers que necessitam do entityManager
 */

class PadraoControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
		$objectManager = $container->get('Doctrine\ORM\EntityManager');
                
		return new  $requestedName($entityManager, $objectManager);
	}
}
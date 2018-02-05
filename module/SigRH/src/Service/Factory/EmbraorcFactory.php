<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory genérico para instanciar os Controllers que necessitam do entityManager
 */

class EmbraorcFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter_embraorc = $container->get('adapter_embraorc');
		return new \SigRH\Service\Embraorc($adapter_embraorc);
	}
}
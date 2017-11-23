<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory genérico para instanciar os Controllers que necessitam do entityManager
 */

class AtividadesFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter_cti = $container->get('adapter_cti');
		return new \SigRH\Service\Atividades($adapter_cti);
	}
}
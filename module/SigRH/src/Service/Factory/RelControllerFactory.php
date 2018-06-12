<?php

namespace SigRH\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\Renderer\RendererInterface;

/**
 * Factory genérico para instanciar os Controllers que necessitam do entityManager
 */

class RelControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
		//$objectManager = $container->get('Doctrine\ORM\EntityManager');
                $tcpdf = $container->get(\TCPDF::class);
                $renderer = $container->get(RendererInterface::class);
                
		return new  $requestedName($entityManager, $tcpdf, $renderer);
	}
}
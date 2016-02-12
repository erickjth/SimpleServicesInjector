<?php
declare(strict_types=1);

namespace SimpleServiceInjector;

use SimpleServiceInjector\Container\ContainerInterface;
use SimpleServiceInjector\ServicesInjector;

class ServicesProvider
{
	private $services;

	private $servicesInjector;

	public function __construct(ContainerInterface $container)
	{
		$this->services = $container;
		$this->servicesInjector = new ServicesInjector($container);
	}

	public function get(string $id)
	{
		return $this->services[$id];
	}

	public function injectServicesOn(string $className)
	{
		try
		{
			$reflector = new \ReflectionClass($className);

			$constructor = $reflector->getConstructor();

			$arguments = [];

			if ($constructor !== null)
			{
				$arguments = $this->servicesInjector->injectDependences($constructor);
			}

			return $reflector->newInstanceArgs($arguments);
		}
		catch (\Exception $e)
		{
			throw $e;
		}
	}
}
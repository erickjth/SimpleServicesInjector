<?php
declare(strict_types=1);

namespace SimpleServiceInjector;

use Interop\Container\ContainerInterface;

class ServicesInjector
{
	private $servicesChain;

	public function __construct(ContainerInterface $services)
	{
		$this->servicesChain = $services;
	}

	public function injectDependences(\ReflectionMethod $method, array $args = []) : array
	{
		$arguments = [];

		if ($method->getNumberOfParameters() > 0)
		{
			// Inject dependences
			foreach ($method->getParameters() as $parameter)
			{
				$key = $parameter->getPosition();

				if (isset($args[$parameter->getName()]) === true)
				{
					$arguments[$key] = $args[$parameter->getName()];
				}
				else if (isset($args[$key]) === true)
				{
					$arguments[$key] = $args[$key];
				}
				else if (
					$parameter->hasType() === true &&
					$parameter->getType()->isBuiltin() === false &&
					$this->servicesChain->has($parameter->getClass()->name) === true
				)
				{
					$arguments[$key] = $this->servicesChain->get($parameter->getClass()->name);
				}
				else if ($parameter->isDefaultValueAvailable())
				{
					if ($parameter->isDefaultValueConstant())
					{
						$arguments[$key] = $parameter->getDefaultValueConstantName();
					}
					else
					{
						$arguments[$key] = $parameter->getDefaultValue();
					}
				}
				else if ($parameter->isOptional())
				{
					$arguments[$key] = null;
				}
				else
				{
					throw new \Exception("Required parameter is needed. Parameter: '" . $parameter->getName() . "' instance of '" . $parameter->getClass()->name . "'");
				}
			}
		}

		return $arguments;
	}
}
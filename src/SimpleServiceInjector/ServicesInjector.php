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

	public function injectDependences(\ReflectionMethod $method, array $args = [], $byServiceKey = false) : array
	{
		$arguments = [];

		if ($method->getNumberOfParameters() > 0)
		{
			// Inject dependences
			foreach ($method->getParameters() as $parameter)
			{
				if ($byServiceKey === true)
				{
					$parameterNameAsSnake = strtolower(
						preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1",
						$parameter->getName())
					);
				}

				$key = $parameter->getPosition();

				// Add parameter if they are given as default arguments.
				if (isset($args[$parameter->getName()]) === true)
				{
					$arguments[$key] = $args[$parameter->getName()];
				}
				else if (isset($args[$key]) === true)
				{
					$arguments[$key] = $args[$key];
				}
				// Checking service by name in the container
				else if (
					$byServiceKey === true &&
					$this->servicesChain->has($parameterNameAsSnake) === true
				)
				{
					$value = $this->servicesChain->get($parameterNameAsSnake);
					$typeReturned = gettype($value) === 'object' ? get_class($value) : gettype($value);
					$typeExpected = (string) $parameter->getType();

					if ($parameter->hasType() === true && $value instanceof $typeExpected === false)
					{
						throw new Exception($parameterNameAsSnake . " expects a '" . $typeExpected  . "' type. Services has given a '" . $typeReturned . "' type");
					}

					$arguments[$key] = $value;
				}
				// Check service by parameter type
				else if (
					$parameter->hasType() === true &&
					$parameter->getType()->isBuiltin() === false &&
					$this->servicesChain->has($parameter->getClass()->name) === true
				)
				{
					$arguments[$key] = $this->servicesChain->get($parameter->getClass()->name);
				}
				else if ($parameter->isDefaultValueAvailable() === true)
				{
					if ($parameter->isDefaultValueConstant() === true)
					{
						$arguments[$key] = $parameter->getDefaultValueConstantName();
					}
					else
					{
						$arguments[$key] = $parameter->getDefaultValue();
					}
				}
				else if ($parameter->isOptional() === true)
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
<?php
declare(strict_types=1);

namespace SimpleServiceInjector\Container;

use SimpleServiceInjector\Container\ContainerInterface;
use SimpleServiceInjector\Builder\ArrayServiceBuilder;

class SimpleServiceContainer implements ContainerInterface, \ArrayAccess
{
	use ContainerArrayAccessTrait;

	private $servicesArray;

	public function __construct(ArrayServiceBuilder $servicesArray)
	{
		$this->servicesArray = $servicesArray;
	}

	public function get($id)
	{
		if (isset($this->servicesArray[$id]) === false)
		{
			throw new \Exception("The service with '$id' doesn't exist in the container.");
		}

		if (is_callable($this->servicesArray[$id]))
		{
			$closure = new \ReflectionFunction($this->servicesArray[$id]);
			return $closure->invoke($this);
		}

		return $this->servicesArray[$id];
	}

	public function has($id) : bool
	{
		return isset($this->servicesArray[$id]);
	}

	public function offsetSet($key, $value)
	{
		throw new Exception("offsetSet not supported!");
	}

	public function offsetGet($key)
	{
		return $this->get($key);
	}

	public function offsetExists($key)
	{
		return $this->has($key);
	}

	public function offsetUnset($key)
	{
		throw new Exception("offsetUnset not supported!");
	}
}
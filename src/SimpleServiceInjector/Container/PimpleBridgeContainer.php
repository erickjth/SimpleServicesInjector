<?php
declare(strict_types=1);

namespace SimpleServiceInjector\Container;

use Pimple\Container;
use SimpleServiceInjector\Container\ContainerInterface;
use SimpleServiceInjector\Builder\AliasBuilder;

class PimpleBridgeContainer implements ContainerInterface, \ArrayAccess
{
	use ContainerArrayAccessTrait;

	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->aliases();
	}

	private function aliases()
	{
		foreach ($this->container->keys() as $key)
		{
			$value = $this->container->raw($key);

			$id = AliasBuilder::getRealClassName($value);

			if (isset($this->container[$id]) === false)
			{
				$this->container[$id] = $value;
			}
		}
	}

	public function get($id)
	{
		return $this->container[$id];
	}

	public function has($id)
	{
		return isset($this->container[$id]) ? true : false;
	}
}
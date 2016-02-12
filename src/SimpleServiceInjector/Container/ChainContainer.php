<?php
namespace SimpleServiceInjector\Container;

use SimpleServiceInjector\Container\ContainerInterface;

class ChainContainer implements ContainerInterface, \ArrayAccess
{
	use ContainerArrayAccessTrait;

	private $containers;

	public function __construct(ContainerInterface ...$containers)
	{
		$this->containers = [];

		foreach ($containers as $key => $container)
		{
			$id = get_class($container);

			if ($this->has($id))
			{
				$id = $id + '_' + $key;
			}

			$this->set($id, $container);
		}
	}

	public function set($id, $value)
	{
		$this->containers[$id] = $value;
	}

	public function get($id)
	{
		foreach ($this->containers as $key => $container)
		{
			if ($container->has($id))
			{
				return $container->get($id);
			}
		}

		throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
	}

	public function has($id)
	{
		foreach ($this->containers as $key => $container)
		{
			if ($container->has($id))
			{
				return true;
			}
		}

		return false;
	}
}
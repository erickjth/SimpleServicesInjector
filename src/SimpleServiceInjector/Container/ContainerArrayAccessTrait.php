<?php

namespace SimpleServiceInjector\Container;

trait ContainerArrayAccessTrait
{
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
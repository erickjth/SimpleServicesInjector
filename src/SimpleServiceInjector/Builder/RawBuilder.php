<?php
declare(strict_types=1);

namespace SimpleServiceInjector\Builder;

class RawBuilder implements ArrayServiceBuilder
{
	protected $services;

	public function __construct(array $services = [])
	{
		$this->services = $services;
	}

	public function fromArray(array $services)
	{
		foreach ($services as $id => $value)
		{
			$this->add($id, $value);
		}
	}

	public function toArray() : array
	{
		return $this->services;
	}

	public function add(string $alias, $value, string $className = '', bool $override = true)
	{
		if (
			isset($this->services[$alias]) === true ||
			(
				empty($className) === false &&
				isset($this->services[$className]) === true
			) && $override === false
		)
		{
			throw new \Exception("There is a services with the same alias/class");
		}

		if (empty($className) === false && class_exists($className))
		{
			$this->services[$className] = $value; // To make Auto-wiring injection
		}

		$this->services[$alias] = $value; // Raw alias
	}

	public function delete(string $id)
	{
		unset($this->services[$id]);
	}

	public function offsetSet($key, $value)
	{
		$this->add($key, $value);
	}

	public function offsetGet($key)
	{
		return $this->services[$key] ?? null;
	}

	public function offsetExists($key) : bool
	{
		return isset($this->services[$key]) ? true : false;
	}

	public function offsetUnset($key)
	{
		$this->delete($key);
	}
}
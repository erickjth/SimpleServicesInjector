<?php
namespace SimpleServiceInjector\Builder;

interface ArrayServiceBuilder extends \ArrayAccess
{
	public function add(string $id, $value, string $className = '', bool $override = true);
	public function delete(string $id);

	public function toArray() : array;
	public function fromArray(array $services);
}
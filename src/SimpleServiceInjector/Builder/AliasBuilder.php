<?php
declare(strict_types=1);

namespace SimpleServiceInjector\Builder;

class AliasBuilder extends RawBuilder
{
	public function add(string $alias, $value, string $className = '', bool $override = true)
	{
		parent::add($alias, $value, $className, $override);

		if (empty($className) === true)
		{
			$className = self::getRealClassName($value);

			if ($className !== null)
			{
				$this->services[$className] = $value;
			}
		}
	}

	public static function getRealClassName($value)
	{
		if (!is_callable($value))
		{
			return null;
		}

		$closure = new \ReflectionFunction($value);

		if ($closure->hasReturnType() !== false)
		{
			$returnedType = $closure->getReturnType();

			if ($returnedType->isBuiltin() === false && class_exists((string)$returnedType))
			{
				return (string)$returnedType;
			}
		}

		return null;
	}
}
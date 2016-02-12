<?php
require_once __DIR__ . '/../vendor/autoload.php';

class Foo
{
	public function getName()
	{
		return "I am " . get_class($this) . "\n";
	}
}

class Bar
{
	private $foo;

	public function __construct(Foo $foo)
	{
		$this->foo = $foo;
	}

	public function __toString()
	{
		return (string)$this->foo->getName();
	}
}

class TestClass
{
	private $bar;

	public function __construct(Bar $bar)
	{
		$this->bar = $bar;
	}

	public function __toString()
	{
		return (string)$this->bar;
	}
}

$services = [
	'foo_services' => function ($services) : Foo
	{
		return new Foo();
	},
	'bar_services' => function ($services) : Bar
	{
		return new Bar($services['foo_services']);
	},
];
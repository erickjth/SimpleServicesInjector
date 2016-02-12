<?php
include_once 'bootstrap.php';

use Pimple\Container;
use SimpleServiceInjector\{ServicesProvider, Container\PimpleBridgeContainer};

$container = new Container($services);

try
{
	$pimpleBridgeContainer = new PimpleBridgeContainer($container);
	$servicesProvider = new ServicesProvider($pimpleBridgeContainer);
	$bar = $servicesProvider->make('Bar');
	echo $bar;
	$testObj = $servicesProvider->make('TestClass');
	echo $testObj;
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



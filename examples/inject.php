<?php
include_once 'bootstrap.php';

use SimpleServiceInjector\{ServicesProvider, Container\SimpleServiceContainer, Builder\AliasBuilder};

$servicesArray = new AliasBuilder();
$servicesArray->fromArray($services);
$container = new SimpleServiceContainer($servicesArray);

try
{
	$servicesProvider = new ServicesProvider($container);

	$bar = $servicesProvider->make('Bar');

	echo $bar;

	$testObj = $servicesProvider->make('TestClass');

	echo $testObj;
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



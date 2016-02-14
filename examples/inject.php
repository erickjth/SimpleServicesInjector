<?php
include_once 'bootstrap.php';

use SimpleServiceInjector\{ServicesProvider, Container\SimpleServiceContainer, Builder\AliasBuilder};

$servicesArray = new AliasBuilder();
$servicesArray->fromArray($services);
$container = new SimpleServiceContainer($servicesArray);

try
{
	$servicesProvider = new ServicesProvider($container);
	echo $servicesProvider->injectServicesOn('Bar');
	echo $servicesProvider->injectServicesOn('TestClass');
	// Test injected service by name
	var_dump($servicesProvider->injectServicesOn('TestClassB', [], true));
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



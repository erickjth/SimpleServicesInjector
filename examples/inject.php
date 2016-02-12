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
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



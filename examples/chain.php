<?php
include_once 'bootstrap.php';

use Pimple\Container;
use SimpleServiceInjector\{
	ServicesProvider,
	Builder\AliasBuilder,
	Container\SimpleServiceContainer,
	Container\PimpleBridgeContainer,
	Container\ChainContainer
};

$container = new Container($services);

$services2 = new AliasBuilder([
	'baz' => function() : string
	{
		return 'I am Baz';
	}
]);

$simpleServiceContainer = new SimpleServiceContainer($services2);
$pimpleBridgeContainer = new PimpleBridgeContainer($container);

try
{
	$chainContainer = new ChainContainer($simpleServiceContainer, $pimpleBridgeContainer);

	$servicesProvider = new ServicesProvider($chainContainer);

	echo $servicesProvider->injectServicesOn('Bar');
	echo $servicesProvider->injectServicesOn('TestClass');
	echo $servicesProvider->get('baz');
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



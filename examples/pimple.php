<?php
include_once 'bootstrap.php';

use Pimple\Container;
use SimpleServiceInjector\{ServicesProvider, Container\PimpleBridgeContainer};

$container = new Container($services);

try
{
	$pimpleBridgeContainer = new PimpleBridgeContainer($container);
	$servicesProvider = new ServicesProvider($pimpleBridgeContainer);
	echo $servicesProvider->injectServicesOn('Bar');
	echo $servicesProvider->injectServicesOn('TestClass');
}
catch (\Exception $e)
{
	echo $e->getMessage();
}



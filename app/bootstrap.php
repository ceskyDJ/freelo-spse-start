<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

/* @var $dateTimeFormat h4kuna\DateFilter\DateTimeFormat */
$dateTimeFormat = $container->getService('dateFilterExtension.dateTimeFormat');
$dateTimeFormat->setFormatsGroup('cs'); // TODO: Automatické určení jazyka
$dateTimeFormat->setDayMonthGroup('cs'); // TODO: Automatické určení jazyka

return $container;

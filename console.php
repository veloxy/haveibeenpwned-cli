#!/usr/bin/env php
<?php
use Sourcebox\HaveIBeenPwnedCLI\DependencyInjection\ReportServiceProviderPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Sourcebox\HaveIBeenPwnedCLI\Console\Application;

require __DIR__.'/vendor/autoload.php';

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/src/Resources/config/'));
$loader->load('services.yml');

$container->addCompilerPass(new ReportServiceProviderPass());
$container->compile();

$application = new Application();

foreach ($container->findTaggedServiceIds('console.command') as $taggedServiceId => $attributes) {
    $application->add($container->get($taggedServiceId));
}

$application->run();

<?php

namespace Sourcebox\HaveIBeenPwnedCLI\DependencyInjection;

use Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReportServiceProviderPass implements CompilerPassInterface
{
    const TAG = 'report_service.provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->get('sourcebox.report_service.provider');

        if (!$definition instanceof ReportServiceProvider) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds(self::TAG);

        foreach ($taggedServices as $taggedServiceId => $tags) {
            foreach ($tags as $attributes) {
                if (!array_key_exists('alias', $attributes) || !$attributes['alias']) {
                    continue;
                }

                $definition->addReportService($attributes['alias'], $container->get($taggedServiceId));
            }
        }
    }
}

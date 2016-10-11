<?php

namespace Sourcebox\HaveIBeenPwnedCLI\DependencyInjection;

use Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReportServiceProviderPass implements CompilerPassInterface
{
    const TAG = 'report_service.provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->get('sourcebox.report_service.provider');

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

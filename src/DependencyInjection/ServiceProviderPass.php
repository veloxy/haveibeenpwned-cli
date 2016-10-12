<?php

namespace Sourcebox\HaveIBeenPwnedCLI\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ServiceProviderPass
 * @package Sourcebox\HaveIBeenPwnedCLI\DependencyInjection
 */
class ServiceProviderPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $serviceProviderId;

    /**
     * @var string
     */
    private $tag;

    /**
     * ServiceProviderPass constructor.
     * @param string $serviceProviderId
     * @param string $tag
     */
    public function __construct($serviceProviderId, $tag)
    {
        $this->serviceProviderId = $serviceProviderId;
        $this->tag = $tag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->get($this->serviceProviderId);

        $taggedServices = $container->findTaggedServiceIds($this->tag);

        foreach ($taggedServices as $taggedServiceId => $tags) {
            foreach ($tags as $attributes) {
                if (!array_key_exists('alias', $attributes) || !$attributes['alias']) {
                    continue;
                }

                $definition->registerService($attributes['alias'], $container->get($taggedServiceId));
            }
        }
    }
}

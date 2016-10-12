<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

/**
 * Class ServiceProvider
 * @package Sourcebox\HaveIBeenPwnedCLI\Service
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param $alias
     * @param array $service
     */
    public function registerService($alias, $service)
    {
        $this->services[$alias] = $service;
    }

    /**
     * @param $alias
     * @return array
     * @throws \Exception
     */
    public function getServiceByAlias($alias)
    {
        if (array_key_exists($alias, $this->services)) {
            return $this->services[$alias];
        }

        throw new \Exception(sprintf('Service with alias "%s" not found', $alias));
    }

    /**
     * @return array
     */
    public function getServiceAliasList()
    {
        return array_keys($this->services);
    }
}

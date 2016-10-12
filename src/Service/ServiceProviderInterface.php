<?php
namespace Sourcebox\HaveIBeenPwnedCLI\Service;

/**
 * Class ServiceProvider
 * @package Sourcebox\HaveIBeenPwnedCLI\Service
 */
interface ServiceProviderInterface
{
    /**
     * @param $alias
     * @param $service
     */
    public function registerService($alias, $service);

    /**
     * @param string $alias
     * @return void
     */
    public function getServiceByAlias($alias);

    /**
     * @return array
     */
    public function getServiceAliasList();
}

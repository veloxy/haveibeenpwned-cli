<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Provider;

use Sourcebox\HaveIBeenPwnedCLI\Service\ReportServiceInterface;

class ReportServiceProvider
{
    /**
     * @var ReportServiceInterface[]
     */
    private $reportServices = [];

    /**
     * @param $alias
     * @param ReportServiceInterface $reportService
     */
    public function addReportService($alias, ReportServiceInterface $reportService)
    {
        $this->reportServices[$alias] = $reportService;
    }

    /**
     * @param $alias
     * @return ReportServiceInterface
     * @throws \Exception
     */
    public function getReportService($alias)
    {
        if (array_key_exists($alias, $this->reportServices)) {
            return $this->reportServices[$alias];
        }

        throw new \Exception(sprintf('Service with alias "%s" not found'), $alias);
    }

    public function getReportServiceAliasList()
    {
        return array_keys($this->reportServices);
    }
}

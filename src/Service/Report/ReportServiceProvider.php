<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Report;

class ReportServiceProvider
{
    /**
     * @var \Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface[]
     */
    private $reportServices = [];

    /**
     * @param $alias
     * @param \Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface $reportService
     */
    public function addReportService($alias, ReportServiceInterface $reportService)
    {
        $this->reportServices[$alias] = $reportService;
    }

    /**
     * @param $alias
     * @return \Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface
     * @throws \Exception
     */
    public function getReportService($alias)
    {
        if (array_key_exists($alias, $this->reportServices)) {
            return $this->reportServices[$alias];
        }

        throw new \Exception(sprintf('Service with alias "%s" not found'), $alias);
    }

    /**
     * @return array
     */
    public function getReportServiceAliasList()
    {
        return array_keys($this->reportServices);
    }
}

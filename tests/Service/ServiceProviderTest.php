<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface;

class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceProvider
     */
    private $reportServiceProvider;

    public function setUp()
    {
        $this->reportServiceProvider = new ServiceProvider();
    }

    public function testGetReportServiceProvider()
    {
        $serviceProvider = $this->createMock(ReportServiceInterface::class);
        $this->reportServiceProvider->registerService('test', $serviceProvider);

        $this->assertEquals($serviceProvider, $this->reportServiceProvider->getServiceByAlias('test'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Service with alias "nonexistingservicealias" not found
     */
    public function testGetReportServiceProviderException()
    {
        $this->reportServiceProvider->getServiceByAlias('nonexistingservicealias');
    }
}

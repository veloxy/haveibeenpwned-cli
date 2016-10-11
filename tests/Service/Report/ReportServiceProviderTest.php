<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Report;

class ReportServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReportServiceProvider
     */
    private $reportServiceProvider;

    public function setUp()
    {
        $this->reportServiceProvider = new ReportServiceProvider();
    }

    public function testGetReportServiceProvider()
    {
        $serviceProvider = $this->createMock(ReportServiceInterface::class);
        $this->reportServiceProvider->addReportService('test', $serviceProvider);

        $this->assertEquals($serviceProvider, $this->reportServiceProvider->getReportService('test'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Service with alias "nonexistingservicealias" not found
     */
    public function testGetReportServiceProviderException()
    {
        $this->reportServiceProvider->getReportService('nonexistingservicealias');
    }
}

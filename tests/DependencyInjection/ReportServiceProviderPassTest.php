<?php

namespace Sourcebox\HaveIBeenPwnedCLI\DependencyInjection;

use Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface;
use Sourcebox\HaveIBeenPwnedCLI\Service\ServiceProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReportServiceProviderPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceProviderPass
     */
    private $reportServiceProviderPass;

    public function setUp()
    {
        $this->reportServiceProviderPass = new ServiceProviderPass(
            'sourcebox.report_service.provider',
            'report_service.provider'
        );
    }

    public function testProcess()
    {
        $reportServiceProvider = new ServiceProvider();
        $reportService = $this->createMock(ReportServiceInterface::class);

        $container = new ContainerBuilder();
        $container->register('sourcebox.report_service.provider', $reportServiceProvider);
        $container->register('some_report_service', $reportService)
            ->addTag('report_service.provider', ['test' => 'ok', 'alias' => 'console']);
        $container->register('some_report_service_2', $reportService)
            ->addTag('report_service.provider', ['test' => 'ok']);

        $this->reportServiceProviderPass->process($container);

        $this->assertEquals(
            $reportService,
            $container->get('sourcebox.report_service.provider')->getServiceByAlias('console')
        );
    }
}

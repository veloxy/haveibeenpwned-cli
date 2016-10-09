<?php


namespace Sourcebox\HaveIBeenPwnedCLI\Console\Command;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Service\BreachDataFinderServiceInterface;
use Sourcebox\HaveIBeenPwnedCLI\Service\ReportServiceInterface;

class CsvCheckerCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBreachedAccountDataDataProvider()
    {
        $accountName = 'test';

        $expectedAccount = new Account();
        $expectedAccount->setAccountIdentifier($accountName);

        return [
            [null, [''], null],
            [$expectedAccount, [$accountName], $expectedAccount],
        ];
    }

    /**
     * @dataProvider testGetBreachedAccountDataDataProvider
     * @param null $methodReturnValue
     * @param array $methodArgs
     * @param null $expectedResult
     */
    public function testGetBreachedAccountData($methodReturnValue = null, $methodArgs = [], $expectedResult = null)
    {
        $breachDataFinder = $this->createMock(BreachDataFinderServiceInterface::class);
        $breachDataFinder->method('findBreachDataForAccountIdentifier')
            ->willReturn($methodReturnValue);

        $reportService = $this->createMock(ReportServiceInterface::class);

        $csvCheckerCommand = new CsvCheckerCommand($breachDataFinder, $reportService);

        $class = new \ReflectionClass($csvCheckerCommand);
        $method = $class->getMethod('getBreachedAccountData');
        $method->setAccessible(true);

        $this->assertEquals($expectedResult, $method->invokeArgs($csvCheckerCommand, $methodArgs));

        $breachDataFinder->method('findBreachDataForAccountIdentifier')
            ->willReturn($methodReturnValue);

        $this->assertEquals($expectedResult, $method->invokeArgs($csvCheckerCommand, $methodArgs));
    }

    public function testGetBreachedAccountDataException()
    {
        $breachDataFinder = $this->createMock(BreachDataFinderServiceInterface::class);
        $breachDataFinder->method('findBreachDataForAccountIdentifier')->willThrowException(new \Exception());

        $reportService = $this->createMock(ReportServiceInterface::class);
        $csvCheckerCommand = new CsvCheckerCommand($breachDataFinder, $reportService);

        $class = new \ReflectionClass($csvCheckerCommand);
        $method = $class->getMethod('getBreachedAccountData');
        $method->setAccessible(true);

        $this->assertEquals(null, $method->invokeArgs($csvCheckerCommand, ['13']));
    }
}

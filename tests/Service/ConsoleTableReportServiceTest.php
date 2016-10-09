<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;

class ConsoleTableReportServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsoleTableReportService
     */
    private $consoleTableReportService;

    /**
     * @var ConsoleOutput
     */
    private $consoleOutput;

    public function setUp()
    {
        $this->consoleOutput = new TestOutput();
        $this->consoleTableReportService = new ConsoleTableReportService($this->consoleOutput);
    }

    public function testReport()
    {
        $firstBreach = new Breach();
        $firstBreach->setTitle('BreachTitle 1')
            ->setBreachDate(new \DateTime('2010-01-01'))
            ->setName('BreadName 1');

        $breaches = [
            $firstBreach
        ];

        $account = new Account();
        $account->setAccountIdentifier('test');
        $account->setBreaches($breaches);

        $breachData = new BreachData();
        $breachData->addAccount($account);

        $expected = <<<TEXT
+---------+----------+-------------+-----------------------------+
| Account | Breached | Breach Date | Company                     |
+---------+----------+-------------+-----------------------------+
| test    | Yes      | 2010-01-01  | BreachTitle 1 (BreadName 1) |
+---------+----------+-------------+-----------------------------+

TEXT;

        $this->consoleTableReportService->report($breachData);

        $this->assertEquals($expected, $this->consoleOutput->output);
    }
}

class TestOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message.($newline ? "\n" : '');
    }
}

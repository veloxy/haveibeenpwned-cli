<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Report;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;
use Sourcebox\HaveIBeenPwnedCLI\Service\Report\ReportServiceInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleTableReportService implements ReportServiceInterface
{
    /**
     * @var ConsoleOutputInterface
     */
    private $consoleOutput;

    /**
     * ConsoleTableReportService constructor.
     * @param OutputInterface $consoleOutput
     */
    public function __construct(OutputInterface $consoleOutput)
    {
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * {@inheritdoc}
     */
    public function report(BreachData $data)
    {
        $table = new Table($this->consoleOutput);
        $table->setHeaders(['Account', 'Breached', 'Breach Date', 'Company']);

        $accounts = $data->getAccounts();
        foreach ($accounts as $key => $account) {
            $table->addRow($this->getAccountAsRow($account));

            if ($account !== end($accounts)) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();
    }

    /**
     * @param Account $account
     * @return array
     */
    private function getAccountAsRow(Account $account)
    {
        $row = [];

        $row[] = $account->getAccountIdentifier();
        $row[] = $account->hasBreaches() ? 'Yes' : 'No';

        $row[] = implode("\n", array_map(function (Breach $data) {
            $date = $data->getBreachDate();
            return $date->format('Y-m-d');
        }, $account->getBreaches()));

        $row[] = implode("\n", array_map(function (Breach $data) {
            return sprintf('%s (%s)', $data->getTitle(), $data->getName());
        }, $account->getBreaches()));

        return $row;
    }
}

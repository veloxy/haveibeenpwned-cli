<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleTableReportService implements ReportServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function report(BreachData $data)
    {
        $table = new Table(new ConsoleOutput());
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
            $date = $data->getBreachData();
            return $date->format('Y-m-d');
        }, $account->getBreaches()));

        $row[] = implode("\n", array_map(function (Breach $data) {
            return sprintf('%s (%s)', $data->getTitle(), $data->getName());
        }, $account->getBreaches()));

        return $row;
    }
}

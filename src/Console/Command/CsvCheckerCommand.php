<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console\Command;

use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use xsist10\HaveIBeenPwned\HaveIBeenPwned;

class CsvCheckerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('check:csv')
            ->setDescription('Checks https://haveibeenpwned.com\'s API using provided CSV of user names/emails')
            ->addArgument('csv', InputArgument::REQUIRED, 'Path to CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $haveIBeenPwned = new HaveIBeenPwned();
        $list = Reader::createFromPath($input->getArgument('csv'))->fetchAll();

        $rows = [];
        $alreadyChecked = [];

        $progress = new ProgressBar($output, count($list));
        $progress->start();

        foreach ($list as $item) {
            $accountIdentifier = reset($item);
            if (strlen($accountIdentifier) > 3 && !isset($alreadyChecked[$accountIdentifier])) {
                $rows[] = $this->getAccountBreaches($haveIBeenPwned, $accountIdentifier);
                $rows[] = new TableSeparator();
                $alreadyChecked[$accountIdentifier] = 1;
                usleep(1500000); // HaveIBeenPwned has a rate limit of 1500 milliseconds.
            }

            $progress->advance();
        }

        $progress->finish();
        $progress->clear();

        array_pop($rows); // Remove last TableSeparator
        $this->renderTable($output, $rows);
    }

    private function getAccountBreaches(HaveIBeenPwned $haveIBeenPwned, $accountIdentifier)
    {
        list ($dates, $domains) = $this->parseBreaches($haveIBeenPwned->checkAccount($accountIdentifier));

        return [
            $accountIdentifier,
            count($dates) ? 'Yes' : 'No',
            implode("\n", $dates),
            implode("\n", $domains),
        ];
    }

    private function parseBreaches($breaches)
    {
        $dates = $domains = [];
        foreach ($breaches as $breach) {
          $dates[] = $breach['BreachDate'];
          $domains[] = sprintf('%s (%s)', $breach['Title'], $breach['Domain']);
        }

        return array($dates, $domains);
    }

    private function renderTable(OutputInterface $output, Array $rows)
    {
        $table = new Table($output);
        $table->setHeaders(['Account', 'Breached', 'Breach Date', 'Company']);
        $table->setRows($rows);
        $table->render();
    }
}

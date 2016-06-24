<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console\Command;

use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use xsist10\HaveIBeenPwned\HaveIBeenPwned;

class CsvCheckerCommand extends Command
{
    protected function configure()
    {
        $this->setName('check:csv')
            ->setDescription('Checks https://haveibeenpwned.com\'s API using provided CSV of user names/emails')
            ->addArgument('csv', InputArgument::REQUIRED, 'CSV location');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('csv');
        $csv = Reader::createFromPath($file);

        $list = $csv->fetchAll();

        $table = new Table($output);
        $table->setHeaders(['Account', 'Breached', 'Breach Date', 'Company']);

        $rows = [];

        $progress = New ProgressBar($output, count($list));
        $progress->start();

        $alreadyChecked = [];

        foreach ($list as $item) {
            $progress->advance();
            $accountIdentifier = reset($item);

            if (strlen($accountIdentifier) > 3 && !in_array($accountIdentifier, $alreadyChecked)) {
                $progress->setMessage(sprintf('Checking "%s"', $accountIdentifier));

                $manager = new HaveIBeenPwned();
                $breaches = $manager->checkAccount($accountIdentifier);
                $breached = count($breaches);

                $row = [];

                $row[] = $accountIdentifier;
                $row[] = ($breached) ? 'Yes' : 'No';

                $breachDates = [];
                $breachCompanies = [];

                foreach ($breaches as $breach) {
                    $breachDates[] = $breach['BreachDate'];
                    $breachCompanies[] = sprintf('%s (%s)', $breach['Title'], $breach['Domain']);
                }

                $row[] = implode("\n", $breachDates);
                $row[] = implode("\n", $breachCompanies);

                $rows[] = $row;
            }

            $alreadyChecked[] = $accountIdentifier;
        }

        $table->setRows($rows);

        $progress->finish();
        
        $table->render();
    }
}
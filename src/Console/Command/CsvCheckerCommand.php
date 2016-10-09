<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console\Command;

use League\Csv\Reader;
use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;
use Sourcebox\HaveIBeenPwnedCLI\Service\BreachDataFinderServiceInterface;
use Sourcebox\HaveIBeenPwnedCLI\Service\ReportServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CsvCheckerCommand extends Command
{
    /**
     * @var ReportServiceInterface
     */
    private $reportService;

    /**
     * @var BreachDataFinderServiceInterface
     */
    private $breachDataFinderService;

    /**
     * CsvCheckerCommand constructor.
     * @param BreachDataFinderServiceInterface $breachDataFinderService
     * @param ReportServiceInterface $reportService
     */
    public function __construct(
        BreachDataFinderServiceInterface $breachDataFinderService,
        ReportServiceInterface $reportService
    ) {
        $this->breachDataFinderService = $breachDataFinderService;
        $this->reportService = $reportService;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check:csv')
            ->setDescription('Checks https://haveibeenpwned.com\'s API using provided CSV of user names/emails')
            ->addArgument('csv', InputArgument::REQUIRED, 'Path to CSV file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accountIdentifiers = Reader::createFromPath($input->getArgument('csv'))->fetchAll();

        $progress = new ProgressBar($output, count($accountIdentifiers));
        $progress->start();

        $breachData = new BreachData();
        $checked = [];

        foreach ($accountIdentifiers as $accountIdentifierRow) {
            $accountIdentifier = reset($accountIdentifierRow);

            if (array_key_exists($accountIdentifier, $checked)) {
                $progress->advance();
                return;
            }

            $account = $this->getBreachedAccountData($accountIdentifier);
            if ($account) {
                $breachData->addAccount($account);
            }

            usleep(1500000);

            $checked[$accountIdentifier] = true;
            $progress->advance();
        }

        $progress->finish();
        $progress->clear();

        $this->reportService->report($breachData);
    }

    /**
     * @param $accountIdentifier
     * @return \Sourcebox\HaveIBeenPwnedCLI\Model\Account|void
     */
    private function getBreachedAccountData($accountIdentifier)
    {
        try {
            $account = $this->breachDataFinderService->findBreachDataForAccountIdentifier($accountIdentifier);
        } catch (\Exception $e) {
            return;
        }

        return $account;
    }
}

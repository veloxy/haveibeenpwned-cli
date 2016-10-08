<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console\Command;

use League\Csv\Reader;
use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;
use Sourcebox\HaveIBeenPwnedCLI\Service\ReportServiceInterface;
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
    /**
     * @var ReportServiceInterface
     */
    private $reportService;

    /**
     * CsvCheckerCommand constructor.
     * @param ReportServiceInterface $reportService
     */
    public function __construct(ReportServiceInterface $reportService)
    {
        $this->reportService = $reportService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('check:csv')
            ->setDescription('Checks https://haveibeenpwned.com\'s API using provided CSV of user names/emails')
            ->addArgument('csv', InputArgument::REQUIRED, 'Path to CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = Reader::createFromPath($input->getArgument('csv'))->fetchAll();

        $rows = [];
        $alreadyChecked = [];

        $progress = new ProgressBar($output, count($list));
        $progress->start();

        $breachData = new BreachData();
        foreach ($list as $item) {
            $accountIdentifier = reset($item);
            if (strlen($accountIdentifier) > 3 && !isset($alreadyChecked[$accountIdentifier])) {
                $breachData->addAccount($this->getAccountBreachData($accountIdentifier));
                $alreadyChecked[$accountIdentifier] = 1;
                usleep(1500000); // HaveIBeenPwned has a rate limit of 1500 milliseconds.
            }

            $progress->advance();
        }

        $progress->finish();
        $progress->clear();

        $this->reportService->report($breachData);
    }

    private function getAccountBreachData($accountIdentifier)
    {
        $haveIBeenPwned = new HaveIBeenPwned();
        $account = new Account();
        $account->setAccountIdentifier($accountIdentifier);

        $breaches = $haveIBeenPwned->checkAccount($accountIdentifier);

        foreach ($breaches as $breach) {
            $accountBreach = new Breach();
            $accountBreach->setName($breach['Name'])
                ->setTitle($breach['Name'])
                ->setDescription($breach['Description'])
                ->setActive($breach['IsActive'])
                ->setVerified($breach['IsVerified'])
                ->setRetired($breach['IsRetired'])
                ->setAddedDate(new \DateTime($breach['AddedDate']))
                ->setBreachData(new \DateTime($breach['BreachDate']))
                ->setPwnCount($breach['PwnCount'])
                ->setSensitive($breach['IsSensitive']);

            $account->addBreach($accountBreach);
        }

        return $account;
    }
}

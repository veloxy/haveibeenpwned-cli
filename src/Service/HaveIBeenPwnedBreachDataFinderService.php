<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use xsist10\HaveIBeenPwned\HaveIBeenPwned;

class HaveIBeenPwnedBreachDataFinderService implements BreachDataFinderServiceInterface
{
    /**
     * @var HaveIBeenPwned
     */
    private $haveIBeenPwned;

    /**
     * HaveIBeenPwnedBreachDataFinderService constructor.
     * @param HaveIBeenPwned $haveIBeenPwned
     */
    public function __construct(HaveIBeenPwned $haveIBeenPwned)
    {
        $this->haveIBeenPwned = $haveIBeenPwned;
    }

    /**
     * @param string $identifier
     * @return Account|void
     * @throws \Exception
     */
    public function findBreachDataForAccountIdentifier($identifier)
    {
        if (!$identifier) {
            throw new \Exception('No account identifier given');
        }

        if (mb_strlen($identifier) <= 3) {
            throw new \Exception('Account identifier should be at least 3 characters long');
        }

        $rawBreachData = $this->haveIBeenPwned->checkAccount($identifier);

        $account = new Account();
        $account->setAccountIdentifier($identifier);

        if (!$rawBreachData) {
            return $account;
        }

        $account->setBreaches($this->getBreaches($rawBreachData));

        return $account;
    }

    /**
     * @param $data
     * @return Breach[]
     */
    private function getBreaches($data)
    {
        $breaches = [];

        foreach ($data as $breach) {
            $breaches[] = $this->getBreach($breach);
        }

        return $breaches;
    }

    /**
     * @param $breach
     * @return Breach
     */
    private function getBreach($breach)
    {
        $accountBreach = new Breach();
        $accountBreach->setName($breach['Name'])
            ->setTitle($breach['Title'])
            ->setDescription($breach['Description'])
            ->setActive($breach['IsActive'])
            ->setVerified($breach['IsVerified'])
            ->setRetired($breach['IsRetired'])
            ->setAddedDate(new \DateTime($breach['AddedDate']))
            ->setBreachData(new \DateTime($breach['BreachDate']))
            ->setPwnCount($breach['PwnCount'])
            ->setSensitive($breach['IsSensitive']);

        return $accountBreach;
    }
}
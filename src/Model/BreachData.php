<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Model;

class BreachData
{
    /**
     * @var Account[]
     */
    private $accounts;

    /**
     * @return Account[]
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param Account[] $accounts
     * @return BreachData
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * @param Account $account
     * @return $this
     */
    public function addAccount(Account $account)
    {
        $this->accounts[] = $account;

        return $this;
    }
}

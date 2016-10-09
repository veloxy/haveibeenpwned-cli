<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;

interface BreachDataFinderServiceInterface
{
    /**
     * @param string $identifier
     * @return Account
     */
    public function findBreachDataForAccountIdentifier($identifier);
}

<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Finder;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;

interface FinderServiceInterface
{
    /**
     * @param string $identifier
     * @return Account
     */
    public function findBreachDataForAccountIdentifier($identifier);
}

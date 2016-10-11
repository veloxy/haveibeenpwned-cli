<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Model;

/**
 * Class Account
 * @package Sourcebox\HaveIBeenPwnedCLI\Model
 */
class Account
{
    /**
     * @var string
     */
    private $accountIdentifier;

    /**
     * @var Breach[]
     */
    private $breaches = [];

    /**
     * @return string
     */
    public function getAccountIdentifier()
    {
        return $this->accountIdentifier;
    }

    /**
     * @param string $accountIdentifier
     * @return Account
     */
    public function setAccountIdentifier($accountIdentifier)
    {
        $this->accountIdentifier = $accountIdentifier;

        return $this;
    }

    /**
     * @return Breach[]
     */
    public function getBreaches()
    {
        return $this->breaches;
    }

    /**
     * @param Breach[] $breaches
     * @return $this
     */
    public function setBreaches($breaches)
    {
        $this->breaches = $breaches;

        return $this;
    }

    /**
     * @param Breach $accountBreach
     * @return $this
     */
    public function addBreach(Breach $accountBreach)
    {
        $this->breaches[] = $accountBreach;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasBreaches()
    {
        return count($this->breaches) > 0;
    }
}

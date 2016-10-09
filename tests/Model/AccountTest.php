<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Model;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccountIdentifier()
    {
        $account = new Account();
        $account->setAccountIdentifier('test');
        $this->assertEquals('test', $account->getAccountIdentifier());
    }

    public function testGetBreaches()
    {
        $breaches = [new Breach()];

        $account = new Account();
        $account->setBreaches($breaches);

        $this->assertEquals($breaches, $account->getBreaches());
    }

    public function testHasBreaches()
    {
        $breaches = [new Breach()];

        $account = new Account();
        $account->setBreaches($breaches);

        $this->assertEquals(true, $account->hasBreaches());
    }
}

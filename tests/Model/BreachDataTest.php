<?php


namespace Sourcebox\HaveIBeenPwnedCLI\Model;

class BreachDataTest extends \PHPUnit_Framework_TestCase
{
    public function testAccounts()
    {
        $accounts = [new Account()];
        $breachData = new BreachData();
        $breachData->setAccounts($accounts);

        $this->assertEquals($accounts, $breachData->getAccounts());

        $account = new Account();
        $breachData->addAccount($account);

        $this->assertContains($account, $breachData->getAccounts());
    }
}

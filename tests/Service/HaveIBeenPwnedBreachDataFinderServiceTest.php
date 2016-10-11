<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use Sourcebox\HaveIBeenPwnedCLI\Service\Finder\HaveIBeenPwnedFinderService;
use xsist10\HaveIBeenPwned\HaveIBeenPwned;

class HaveIBeenPwnedBreachDataFinderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HaveIBeenPwnedFinderService
     */
    private $haveIBeenPwnedBreachDataFinderService;

    public function setUp()
    {
        $haveIBeenPwnedMock = $this->createMock(HaveIBeenPwned::class);
        $haveIBeenPwnedMock->method('checkAccount')
            ->willReturn([
                [
                    'Name' => 'TestName',
                    'Title' => 'TestTitle',
                    'Description' => 'TestDescription',
                    'IsActive' => true,
                    'IsVerified' => true,
                    'IsRetired' => false,
                    'AddedDate' => '2016-10-01',
                    'BreachDate' => '2016-10-01',
                    'PwnCount' => 100,
                    'IsSensitive' => true,
                ],
            ]);

        $this->haveIBeenPwnedBreachDataFinderService = new HaveIBeenPwnedFinderService($haveIBeenPwnedMock);
    }

    public function testFindBreachDataForAccountIdentifier()
    {
        $breach = new Breach();
        $breach->setName('TestName')
            ->setTitle('TestTitle')
            ->setDescription('TestDescription')
            ->setActive(true)
            ->setVerified(true)
            ->setRetired(false)
            ->setAddedDate(new \DateTime('2016-10-01'))
            ->setBreachDate(new \DateTime('2016-10-01'))
            ->setPwnCount(100)
            ->setSensitive(true);

        $expected = new Account();
        $expected->setAccountIdentifier('dummy')
            ->addBreach($breach);

        $actual = $this->haveIBeenPwnedBreachDataFinderService->findBreachDataForAccountIdentifier('dummy');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No account identifier given
     */
    public function testFindBreachDataForAccountIdentifierThrowsNoAccountIDException()
    {
        $this->haveIBeenPwnedBreachDataFinderService->findBreachDataForAccountIdentifier('');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Account identifier should be at least 3 characters long
     */
    public function testFindBreachDataForAccountIdentifierThrowsAccountIDTooShortException()
    {
        $this->haveIBeenPwnedBreachDataFinderService->findBreachDataForAccountIdentifier('12');
    }

    public function testFindBreachDataForAccountIdentifierReturnsUnbreachedAccount()
    {
        $accountName = 'fake-account@fake-accounts.fake';

        $account = new Account();
        $account->setAccountIdentifier($accountName);

        $haveIBeenPwnedMock = $this->createMock(HaveIBeenPwned::class);
        $haveIBeenPwnedMock->method('checkAccount')
            ->willReturn([]);

        $haveIBeenPwnedBreachDataFinderService = new HaveIBeenPwnedFinderService($haveIBeenPwnedMock);
        $actual = $haveIBeenPwnedBreachDataFinderService->findBreachDataForAccountIdentifier($accountName);

        $this->assertEquals($account, $actual);
    }
}

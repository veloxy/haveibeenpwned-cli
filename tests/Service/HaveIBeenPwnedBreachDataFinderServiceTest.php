<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\Account;
use Sourcebox\HaveIBeenPwnedCLI\Model\Breach;
use xsist10\HaveIBeenPwned\HaveIBeenPwned;

class HaveIBeenPwnedBreachDataFinderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HaveIBeenPwnedBreachDataFinderService
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

        $this->haveIBeenPwnedBreachDataFinderService = new HaveIBeenPwnedBreachDataFinderService($haveIBeenPwnedMock);
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
            ->setBreachData(new \DateTime('2016-10-01'))
            ->setPwnCount(100)
            ->setSensitive(true);

        $expected = new Account();
        $expected->setAccountIdentifier('dummy')
            ->addBreach($breach);

        $actual = $this->haveIBeenPwnedBreachDataFinderService->findBreachDataForAccountIdentifier('dummy');
        $this->assertEquals($expected, $actual);
    }
}
<?php


namespace Sourcebox\HaveIBeenPwnedCLI\Model;

class BreachTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $title = 'test';
        $breach = new Breach();
        $breach->setTitle($title);

        return $this->assertEquals($title, $breach->getTitle());
    }

    public function testName()
    {
        $name = 'test';
        $breach = new Breach();
        $breach->setName($name);

        return $this->assertEquals($name, $breach->getName());
    }

    public function testDescription()
    {
        $description = 'This is a description';
        $breach = new Breach();
        $breach->setDescription($description);

        return $this->assertEquals($description, $breach->getDescription());
    }

    public function testPwnCount()
    {
        $pwnCount = 200;
        $breach = new Breach();
        $breach->setPwnCount($pwnCount);

        return $this->assertEquals($pwnCount, $breach->getPwnCount());
    }

    public function testAddedDate()
    {
        $date = new \DateTime('2016-10-01');
        $breach = new Breach();
        $breach->setAddedDate($date);

        return $this->assertEquals($date, $breach->getAddedDate());
    }

    public function testBreachDate()
    {
        $date = new \DateTime('2016-10-01');
        $breach = new Breach();
        $breach->setBreachDate($date);

        return $this->assertEquals($date, $breach->getBreachDate());
    }

    public function testVerified()
    {
        $expected = true;
        $breach = new Breach();
        $breach->setVerified($expected);

        return $this->assertEquals($expected, $breach->isVerified());
    }

    public function testSensitive()
    {
        $expected = true;
        $breach = new Breach();
        $breach->setSensitive($expected);

        return $this->assertEquals($expected, $breach->isSensitive());
    }

    public function testRetired()
    {
        $expected = true;
        $breach = new Breach();
        $breach->setRetired($expected);

        return $this->assertEquals($expected, $breach->isRetired());
    }

    public function testActive()
    {
        $expected = true;
        $breach = new Breach();
        $breach->setActive($expected);

        return $this->assertEquals($expected, $breach->isActive());
    }
}

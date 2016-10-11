<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Model;

/**
 * Class Breach
 * @package Sourcebox\HaveIBeenPwnedCLI\Model
 */
class Breach
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $breachDate;

    /**
     * @var \DateTime
     */
    private $addedDate;

    /**
     * @var int
     */
    private $pwnCount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $verified;

    /**
     * @var bool
     */
    private $sensitive;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var bool
     */
    private $retired;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Breach
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Breach
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBreachDate()
    {
        return $this->breachDate;
    }

    /**
     * @param \DateTime $breachDate
     * @return Breach
     */
    public function setBreachDate($breachDate)
    {
        $this->breachDate = $breachDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * @param \DateTime $addedDate
     * @return Breach
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getPwnCount()
    {
        return $this->pwnCount;
    }

    /**
     * @param int $pwnCount
     * @return Breach
     */
    public function setPwnCount($pwnCount)
    {
        $this->pwnCount = $pwnCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Breach
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param boolean $verified
     * @return Breach
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSensitive()
    {
        return $this->sensitive;
    }

    /**
     * @param boolean $sensitive
     * @return Breach
     */
    public function setSensitive($sensitive)
    {
        $this->sensitive = $sensitive;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return Breach
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRetired()
    {
        return $this->retired;
    }

    /**
     * @param boolean $retired
     * @return Breach
     */
    public function setRetired($retired)
    {
        $this->retired = $retired;

        return $this;
    }
}

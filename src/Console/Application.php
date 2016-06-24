<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console;

use Sourcebox\HaveIBeenPwnedCLI\Console\Command\CsvCheckerCommand;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    const NAME = 'HaveIBeenPwned CLI Checker';
    const VERSION = '1.0';

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);
        
        $csvCheckerCommand = new CsvCheckerCommand();
        $this->add($csvCheckerCommand);
    }
}
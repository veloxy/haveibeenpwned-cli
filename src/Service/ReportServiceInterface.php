<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service;

use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;

interface ReportServiceInterface
{
    public function report(BreachData $data);
}

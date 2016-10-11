<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Service\Report;

use Sourcebox\HaveIBeenPwnedCLI\Model\BreachData;

interface ReportServiceInterface
{
    public function report(BreachData $data);
}

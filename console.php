#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

ini_set("auto_detect_line_endings", '1');

$application = new Sourcebox\HaveIBeenPwnedCLI\Console\Application();
$application->run();
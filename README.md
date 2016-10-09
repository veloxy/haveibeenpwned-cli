# HaveIBeenPwned CLI Checker

[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![SensioLabs Insight][ico-sensio]][link-sensio]
[![StyleCI][ico-styleci]][link-styleci]

This is a CLI tool to check a csv of email addresses and usernames in https://haveibeenpwned.com

## Requirements

- PHP 5.6+
- Composer

## Installation

Clone the repository and run `composer install`

## Usage

Get a list of e-mails from somewhere, check example.csv for the correct format. In my case, I exported a list of e-mails from 1Password.

```
$ php console.php example.csv
+---------------------+----------+-------------+-----------------------------------------+
| Account             | Breached | Breach Date | Company                                 |
+---------------------+----------+-------------+-----------------------------------------+
| example@example.com | Yes      | 2015-03-01  | 000webhost (000webhost.com)             |
|                     |          | 2013-10-04  | Adobe (adobe.com)                       |
|                     |          | 2014-06-13  | ...                                     |
| test@example.com    | Yes      | 2015-03-01  | 000webhost (000webhost.com)             |
|                     |          | 2013-10-04  | Adobe (adobe.com)                       |
|                     |          | 2010-12-11  | ...                                     |
+---------------------+----------+-------------+-----------------------------------------+
| nonexstingaccount   | No       |             | ...                                     |
+---------------------+----------+-------------+-----------------------------------------+
```


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/veloxy/haveibeenpwned-cli/master.svg?style=flat-square
[ico-sensio]: https://img.shields.io/sensiolabs/i/d3fd9ce4-f451-48b4-89c4-d9cf47a28bdf.svg?maxAge=3600&style=flat-square
[ico-styleci]: https://styleci.io/repos/61910203/shield?branch=master

[link-travis]: https://travis-ci.org/veloxy/haveibeenpwned-cli
[link-sensio]: https://insight.sensiolabs.com/projects/d3fd9ce4-f451-48b4-89c4-d9cf47a28bdf
[link-styleci]: https://styleci.io/repos/61910203

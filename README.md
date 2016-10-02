# HaveIBeenPwned CLI Checker

This is a CLI tool to check a csv of email addresses and usernames in https://haveibeenpwned.com

It's sloppy code, I wanted to quickly check a bunch of emails - but putting this on github because it might be of use to someone else.

## Requirements

- PHP 7
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
|                     |          | 2014-06-13  | Domino's (pizza.dominos.be)             |
|                     |          | 2015-09-18  | Final Fantasy Shrine (ffshrine.org)     |
|                     |          | 2012-12-17  | Heroes of Newerth (heroesofnewerth.com) |
|                     |          | 2015-07-01  | iPmart (ipmart-forum.com)               |
|                     |          | 2016-02-29  | KM.RU (km.ru)                           |
|                     |          | 2016-01-01  | Lifeboat (lbsg.net)                     |
|                     |          | 2012-05-05  | LinkedIn (linkedin.com)                 |
|                     |          | 2015-10-22  | MPGH (mpgh.net)                         |
|                     |          | 2015-07-06  | myRepoSpace (myrepospace.com)           |
|                     |          | 2008-07-01  | MySpace (myspace.com)                   |
|                     |          | 2010-05-17  | Neteller (neteller.com)                 |
|                     |          | 2014-04-22  | NextGenUpdate (nextgenupdate.com)       |
|                     |          | 2013-07-22  | Nexus Mods (nexusmods.com)              |
|                     |          | 2014-08-08  | Pokemon Creed (pokemoncreed.net)        |
|                     |          | 2015-11-01  | R2Games (r2games.com)                   |
|                     |          | 2011-12-24  | Stratfor (stratfor.com)                 |
|                     |          | 2013-02-28  | tumblr (tumblr.com)                     |
|                     |          | 2012-01-01  | VK (vk.com)                             |
|                     |          | 2015-02-01  | Xbox-Scene (xboxscene.com)              |
|                     |          | 2013-11-07  | XSplit (xsplit.com)                     |
|                     |          | 2015-05-11  | Спрашивай.ру (sprashivai.ru)            |
| test@example.com    | Yes      | 2015-03-01  | 000webhost (000webhost.com)             |
|                     |          | 2013-10-04  | Adobe (adobe.com)                       |
|                     |          | 2010-12-11  | Gawker (gawker.com)                     |
|                     |          | 2012-12-17  | Heroes of Newerth (heroesofnewerth.com) |
|                     |          | 2016-01-01  | Lifeboat (lbsg.net)                     |
|                     |          | 2012-05-05  | LinkedIn (linkedin.com)                 |
|                     |          | 2015-10-22  | MPGH (mpgh.net)                         |
|                     |          | 2015-05-14  | mSpy (mspy.com)                         |
|                     |          | 2008-07-01  | MySpace (myspace.com)                   |
|                     |          | 2013-08-01  | OwnedCore (OwnedCore.com)               |
|                     |          | 2015-10-01  | Patreon (patreon.com)                   |
|                     |          | 2011-12-24  | Stratfor (stratfor.com)                 |
|                     |          | 2013-02-28  | tumblr (tumblr.com)                     |
|                     |          | 2015-11-03  | vBulletin (vbulletin.com)               |
|                     |          | 2012-01-01  | VK (vk.com)                             |
|                     |          | 2013-11-07  | XSplit (xsplit.com)                     |
|                     |          | 2012-07-11  | Yahoo (yahoo.com)                       |
+---------------------+----------+-------------+-----------------------------------------+
```

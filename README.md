TDTrac is a web based show budget and payroll hours tracker, built by a TD, for other TD's, 
freelance designers, and anyone else who finds it useful. TDTrac is completely free, released 
as open source.

## TDTrac Features:

 * Track as many show budgets as you wish
 * Budgets can be organized by vendor, category, or even amount spent
 * Track as many active or inactive employees as you wish
 * Configurable pay rate for budgeting purposes
 * Allow your employees to add thier own hours, while being notified on your next login
 * Optionally allow your employees to add budget expenses, or even view the current budget


### TDTracX

This is the new version of TDTrac, completely refactored in CakePHP3.

## LICENSE:

You may use this code, in part or in full, for any reason, in any circumstance without notifying
the author.  You may redistribute this code, in full or part, with any project you work on.  If 
you wish to charge for this code as part of your project, you may.  You may not sell this code 
without modification, but you may charge for installation or use of this code on your own server.
If you find this especially useful, or make a ton of money off this though, please drop me a line
as I would love to see what you have put together.  Also, if you use this code as a basis of a new
project, I would also like to see what you come up with.


### Installation

1.) Clone GIT repository into your hosting folder, and change into that directory.

2.) Run composer:

```
$ composer install
```

3.) Run initial migration (this creates the empty database):

```
$ ./bin/cake migrations migrate
```

4.) Run TDTracX installer (this creates the initial user, and sets up the datebase proceedures):

```
$ ./bin/cake tdtrac install
```

5.) Log in, change user e-mail, name, and password.


#### Lighttpd Redirects:

```
$HTTP["host"] =~ "demox\.tdtrac\.com" {
    server.document-root = "/full/path/to/TDTracX/webroot/"
    url.rewrite-if-not-file =(
        "^([^\?]*)(\?(.+))?$" => "/index.php?url=$1&$3"
    )
}
```

#### Improve performance?

```
$ php composer.phar dumpautoload -o
```

## The Demo

If you want to run your own version of the demo, you can run the shell script. (This is totally destructive to the PRODUCTION database - you have been warned.)

To run it, you will need to be able to read and understand the php file, located at:

```
$ ./bin/cake tdtrac demoreset
```

## Other Console Commands

$ ./bin/cake tdtrac [command]

 * adduser - Add's a user.
 * ban - Ban a user.
 * unban - Un-Ban a user.
 * resetpass - Reset a user password.

All of these things can be done in the app itself, however, if for some reason you don't wish to maintain an admin account of your own, you could use this. Also great if 
you forget your admin password.

## Periodic Emails

This module is buggy, at best.  Still a work in progress.

```
0 21 * * * /home/tdtrac/bin/cake tdtrac sendunpaid user@host 0 14 2015-12-06 
```

This will send every 2 weeks on sunday (at 9pm) - it's the currently due hours

```
0 1 * * * /home/tdtrac/bin/cake tdtrac sendremind 0 14 2015-12-06 
```

This will send every 2 weeks on sunday (at 1am) - it's a reminder for users to input their hours.

Basically, 
 * Arg#1 = Day of the week to send
 * Arg#2 - Period to send on.  14 days = 2 weeks
 * Arg#3 - A known "good" date to send on.



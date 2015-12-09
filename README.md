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

This is the new version of TDTrac, completely refactored in CakePHP3 - it doesn't even almost
run correctly yet.

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

3.) Run initial migration:

```
$ ./bin/cake migrations migrate
```

4.) Run TDTracX installer:

```
$ ./bin/cake tdtrac install
```

5.) Log in, change user e-mail, name, and password.


#### Lighttpd Redirects:

```
$HTTP["host"] =~ "demox\.tdtrac\.com" {
    server.document-root = "/home/tdtracx/webroot/"
    url.rewrite-once =(
        "/(favicon.ico)" => "/$1",
        "/(fonts|css|files|img|js|php)/(.*)" => "/$1/$2",
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

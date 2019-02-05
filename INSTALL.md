# TDTrac Install Instructions

First off, my appologies - this will likely be a little sparse.  It's still on the TODO.

1.) Download the file on the server of choice. Note: you almost positivly need shell access for 
this to work.  Sorry.

2.) Edit ./config/tdtracx.php-dist, saving it as ./config/tdtracx.php with your company details, 
timezone, and database connection. In theory, this is database agnostic, but I've only tested with
mySQL.

3.) make ./logs and ./tmp writable by your webserver

4.) run **./bin/cake migrations migrate** to create the database.

5.) run **./bin/cake tdtrac install** to finish the install

6.) Go to the instance in a webbrowser AND CHANGE THE DEFAULT PASSWORD, as it is "password" (assuming
you had the user created above.  Otherwise, checkout ./bin/cake tdtrac adduser)

7.) Using scheduled tasks?  Make sure you add it to cron.  Something like:

0 * * * * /usr/bin/sudo -u www-data /path/to/install/bin/cake tdtrac cron

(run it as your webserver user)

8.) Don't ever even try to use the demorest function of the shell.  It's ugly, and it will delete all
of your data. 

Any issues, please head to github: https://github.com/jtsage/TDTracX
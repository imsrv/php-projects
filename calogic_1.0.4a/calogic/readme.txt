INTRODUCTION
============

Thanks for using CaLogic Calendars.

If you have any problems, feel free to contact me. I will help you 
with anything I can.

Philip Boone
philip@calogic.de
or
philip@boone.at

Visit http://www.calogic.de/ for more information and an online Demo.

This is an Alpha Pre Release. So there are still some things to get done. 
See the TODO list later in this document. Although this is a Pre Release,
I will include an update with every release, so that those of you who are 
using a pre release will be able to update your installation, instead of 
having to start over.

Please make sure you have the latest version of CaLogic before installing.

Check the download page at http://sourceforge.net/projects/calogic/
for the latest version.


REQUIREMENTS
=============

A web server with PHP 4.1.1 or higher
PHP Compilation Options needed: 
--with-mysql  
--enable-safe-mode=no (may work with yes, I am not sure)
--enable-track-vars
--enable-bcmath 
--enable-mhash
--enable-trans-sid (if not used, must set $adsid = TRUE in config.php)
session.use_trans_sid = 1 (if not used, must set $adsid = TRUE in config.php)
gpc_order = GPC
register_globals = on (may work with off, but on is better)
magic_quotes_gpc = on (no longer mandatory, but it helps)

A MySQL 3.23.47 or higher Database

A Java enabled Browser (I have tested it with IE Explorer 5.5 and 6.0)

CaLogic may work with PHP and MySQL versions lower than those listed, 
but I doubt it.

If you are unsure if your installation of PHP is configured with 
the above required options use PHPINFO to find out. How do you 
use PHPINFO you ask?

Create a file, name it phpinfo.php and type only the following in it

<?php
phpinfo()
?>

save the file, upload it to your web, and enter the URL in your 
browser http://www.myweb/phpinfo.php for example You will get a nice 
page of information about the PHP installation on your server. 
If you don't get the list, you either don't have PHP on your server, 
or you didn't type the above 3 lines as-is.



FIRST TIME INSTALLATION INSTRUCTIONS
====================================

For instructions on updating a previous installation, 
read the Update.txt file.

STEP 1:
    Unpack the distributed zip file to your local computer.
    Since you are reading this, I assume you have unpacked the distributed
    zip file. Just make sure you unpack the zip preserving the directory
    structure.

STEP 2:
    Upload the file named chkcfg.php to your web, and run it in your browser.
    For example:
    http://www.yourdomain.com/calogic/chkcfg.php
    
    This small program will display various version information, and will tell you
    the root directory of your domain. This information is usefull in setting
    the path to the settings.php file, that must be set in the dbloader.php file.
    
    A few variables must be set in the config.php and dbloader.php files in the 
    include directory, and the settings.php file in the admin directory. 
    There are instructions in those files on how to set the variables you need. 
    There are only a few variables that have to be set.
 
    Because there is a lot of "Read me" information in these files, I have
    preceeded the actual line or lines that have to be set with:
    /*** SET VARIABLE HERE *****/

    If you plan on using reminders, then you must also set variables in the 
    remcfg.php file in the include directory. The file that checks for and 
    sends reminders is srxclr.php, and is located in the root directory of 
    calogic. Read the Readme_reminders.txt file for information on setting 
    up reminders.
    
    After setting the variables, upload the CaLogic directory structure to your web.

STEP 3:
   Point your browser to setup.php, located in the setup directory. For example
   http://www.yourdomain.com/calogic/setup/setup.php
   Fill out the form and click submit.

   After a few seconds, the form will re-appear, with the text:
   "You may now start CaLogic" at the bottom. The only button now
   available is "Start CaLogic". Click it, you should now be at the logon form.



The Setup is now finished.

I suggest removing the setup directory from your web.

IF THE SETUP PROCEDURE IS RUN AGAIN, THE TABLES WILL BE RECREATED AND ALL INFORMATION
IN THEM WILL BE LOST.


Setting up the Admin Account
============================

The First registered user will automatically become the Administrator.

On the logon screen, click "Register". Fill out the form and click submit.

Follow the instructions in the confirmation mail that gets sent to you.


That's basically it! You should have a Calendar now, set up ready to go.



TO DO LIST
==========

A good program is never finished.

None of the things on my TODO list, cause CaLogic not to work, or to 
"Hang" or any thing like that. Things I haven't done yet, or are not 
finished yet, simply aren't available in the program.
But because CaLogic is still in it's pre alpha phase, errors may happen. 
Please let me know if you run into any errors so that I can fix them.

Things I still need to do, or am currently working on:

There is a lot of hard coded English that still has to be added to the 
language table. Once this is done, I will translate it to German as well. 
So, although you as admin have the possibility to edit the language table, 
I wouldn't do it just yet.

IMPORTANT!!!!
If you do edit the Language table, be warned: there are some entries with 
PHP script in them. %index% for example. This code is used for inserting
variable values. If it is changed, then the text output may not be as 
expected.

An extensive Event Search routine has yet to be made.

I plan to also make a "Find Free Time" routine, which will be able to 
locate an unscheduled timeframe for an event.

The Subscriptions (also know as layers) functionality is not yet finished.

The Rights structure is not yet finished.

There is not yet a check for conflicting events while entering a new event.

The final documentation is not yet finished, nor the FAQ. Which will probably 
end up being one in the same. But basically this means you are on your own as 
far as the use of the calendar. But hey, if you need help, send me a mail, 
I will be glad to help. Besides, CaLogic is very easy to use.

I will be adding a "click thru" function, that will take the place of users
having to logon.

And a few other ods and ends that need not be mentioned.

That's about it for the TO DO List. Like I said, the program is almost 
finished.


Thanks and remember, CaLogic is still in development, so this is a great 
time for feature requests. hint hint.

And please send me all bug reports and or changes you may make or want,
so that others can benefit from them as well.

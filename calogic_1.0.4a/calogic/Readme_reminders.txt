CaLogic Reminders, A HOW TO GUIDE
=================================


The script that checks for, and sends reminders is srxclr.php, and is 
located in the root directory of CaLogic. 
Each reminder will only be sent one time. In the case of repeating
events, a reminder will be sent one time for each occurance of the event.

So if I have an event that occurs every Monday at 12:00, and have the 
reminder for the event setup to be sent 15 minutes prior to 
the event, then I would recieve a reminder every Monday at 11:45.

The reminder script will catch and send a reminder up to 2 days
after the event takes place, if the reminder had not been sent
for some reason.

You can rename srxclr.php and or relocate it if you want. 
If you relocate it, then you must set the relative paths to the 
included files at the beginning of the file to absolute full paths.
Examples are in the file. But in any case, the file must be 
accessable to a browser, unless you can call the PHP interpreter 
to parse the file.

If you password protect the reminders script file, use this URL
syntax to call the script:

http://user:password@yourdomain.com/calogic/srxclr.php

In order for reminders to work, this file must be run in a browser,
or called from a program that can "act" as a browser, or parsed 
with the PHP interpreter. Any of which must be done at regular intervals.

Because I am only familiar with the browser method, I will explain it here.



Setting up reminders depends first of all, on what web server you have,
and which operating system it runs on.

If you have a Unix / Linux web server, you can use a unix program called
cron, which is a scheduling program. cron is a program that will automatically
run a program at whatever intervals you set. You must check with your
provider to see if you are allowed to use cron. But cron alone, is not enuf.

You also have to have a program that will call the url of the reminders
script from a unix shell. I personally like wget. You can search the internet 
for "wget" and you will find all kinds of information about the program and 
how to get it.

Explaining everything about cron or wget is beyond the scope of this
document. Besides, there is plenty of info on the internet. and it's very
easy to find. But I will do my best to make it understandable for you.

If you have cron available, make sure you set it up to run at the intervals you
set the $rfrequency and $rinterval variables to in the remcfg.php file.

using cron is quite simple. you use the unix command crontab to create
a cron control file refered to as the crontab (or cron table).

cron then executes the commands in the crontab file at the specified intervals.

The crontab command options are as follows:

crontab -l (thats a small letter L)

display your cron tab.

crontab -r (thats a small letter R)

delete your crontab

crontab -e

edit your crontab


The format for the crontab entries is as follows:

remarks in the crontab are preceded with a pound sign #

each line of the crontab consists of 6 fields seperated with a single space.

Fields 1 thru 5 represent the date and time the command is to be executed.
Field 6 is the actual command.

Field 1  = MINUTE(0-59)
Field 2  = HOUR(0-23)
Field 3  = DAY OF MONTH(1-31)
Field 4  = MONTH OF YEAR(1-12)
Field 5  = DAY OF WEEK(0-6)  Note 0 = Sun

An astrix (*) in any one of the date time field positions means any.
So, for example:

* * * * * command

would execute the command every minute of every hour of every day 
of every month of every week

1 * * * * command
would execute the command when the minute = 1 of every hour 
of every day etc. So basicaly once an hour.

Each date time field can contain more than one value, seperated by commas.

So, to execute a command when the hour is full, and when the hour is at half,
you would enter:

0,30 * * * * command
Which means, when the minute = 0, or the minute = 30 of every hour etc.

To run a command every 5 minutes enter this:

0,5,10,15,20,25,30,35,40,45,50,55 * * * * command

I think you have got the idea.

An important point to remember is, the crontab must end with a linefeed.


Here is the crontab I use to run the reminders script on my web:

# lines that begin with a # are remarks
#
# Run CaLogic Reminder every 5 minutes 
#
# the following command should be entered on a single line in the cron tab.
0,5,10,15,20,25,30,35,40,45,50,55 * * * * wget -b -o calogic_wget_reminder_log.txt -O calogic_wget_reminder_result.html http://www.yourdomain.com/calogic/srxclr.php
#
# -b is a small letter B, and tells wget to run in background mode
# -o is a small letter O, and tells wget the name of the log file 
# to use, this is wget's log file
# -O is a capitol letter O, and tells wget where to write the output
# of the called URL, in the case of CaLogic, the output is:
# Reminders finished
# n mails sent (where n = the number of mails sent.


With this setup, I can ftp or telnet my web server, and check the contents
of the log and result files. This is the first place you should look if
reminders are not getting sent, or are not acting like you expect. If the log or
result file never show up, then have a look in your web server error logs,
it could be that the crontab is not formated properly.

The log and result files get overwritten with each call of the command.



The documentation for wget is at:
http://www.gnu.org/manual/wget/html_mono/wget.html


Here are a few links that explain how to use cron and crontab

http://www.aota.net/Script_Installation_Tips/cronhelp.php4
http://www.usats.com/learn/crontab.shtml
http://www.superscripts.com/tutorial/crontab.html
http://www.ualberta.ca/CNS/HELP/unix/crontab.1.html


The reminders scrip is pretty fast. It depends on how many events with reminders
you have. I suggest running the script a maximum of every 5 minutes, and a minimum
of once a day. Setting up a crontab to run any command too often can bog down your
server.


I will give you one more tip, that will help you find out if you have cron and wget
available on your web server:


first, you have to telnet to your server, then, at the command line type this:
(I will write it in capitol letters for readability, but you must use small leters):

CRONTAB -L

and hit enter.

if you get a response similar to "COMMAND NOT FOUND" then you have 
no cron programm available.

So, next type:

wget

and hit enter. if you get a response similar to "COMMAND NOT FOUND" then the 
wget program is not available to you.



So, for windows web server users:

wget is also available for the windows platform. but you will have to use
the dos command AT to do that which cron does for unix. I myself
have no experience with AT, but you will need it to run a dos batch. To
make the batch file, create a text file and call it reminders.bat and type
this in it (on one single line):

wget -b -o calogic_wget_reminder_log.txt -O calogic_wget_reminder_result.html http://www.yourdomain.com/calogic/srxclr.php


save it, and setup the AT command to run the batch as offten as you set the 
$rfrequency and $rinterval variables to in the remcfg.php file.

Of course you first have to download and install the wget program.


I wish you luck!


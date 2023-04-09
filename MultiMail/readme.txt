###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
# 452 Multi-MAIL  v1.6 BETA
#    This script is freeware and is released under the GPL
#    Copyright (C) 2000, 2001 452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://www.fsf.org/
###############################################################################
Welcome to the readme for the 452 Productions Internet Group Multi-MAIL v1.5. 
For reasons of convention and sanity, this document is broken up into a few 
sections.

1. Intro & required junk
2. Installation
3. Use
	3.1 - Normal use
	3.2 The POP ability
4. FAQ

1. Intro and required junk
So just what is this thing? 452 Multi-MAIL is a fully featured mailing list 
manager. Some of those features include Socket based e-mail connections enable 
the script to handle _much_ larger lists than other PHP mailers which use the 
mail () function. We have though, provided a fall back to the mail() function
in case you can't get the sockets to work. A MySQL backend keeps the rest of 
the script clicking along at high speed. Multiple lists can be created and 
users who sign up for more than one list will not receive duplicate mailings.
You can have an unlimited number of lists and have the option of sending html 
formatted mail. Users can add, remove, and change their mailings without your 
assistance. Due to the socket base of the script, users can manage 
subscriptions through e-mail, similar to listserv. You can allow other 
people access to the mailing list system and specify which lists they are 
allowed to send their messages to. You should be impressed. (Well....)

What do you need to make all this amazing magic happen?
A *nix webserver with apache
PHP 3.0.12+
MySQL should work on just about any version
A SMTP server (Mail server)
A POP server (Mail server, almost all SMTP servers support POP)

If you are running an earlier version you need 
to run old_conversion.php before running install. Then you'll need to run 
install.php, then add_addys.php with what old_conversion.php dumps out 
(If anything)

2. Installation
As you are reading this, we will assume that you figured out to unzip the 
package. Good, top marks for ingenuity. You should have found the following:

readme - This very document
mail_admin.php - The admin interface
mail.php - The user interface
front.php - a trimmed down version of mail.php
add_addys.php - a script to help transfer your list
archive.php - The past mailings browser
functions.php - The functions
config.inc.php - a blank file
login_failure.txt - a blank file
A dir named f - The SQL table structures and data that goes into the above 
mentioned blank files if you choose not to use the install script
install.php - The install script
default_lang.inc.php - Most of the strings all in one neat file for easy 
translation GPL.txt - The full text of the GPL if you really care what ESR 
has to say
old_conversion.php - Gets rid of the old stuff so you can install the new stuff

The 'f' dir also contains no_mail.php, a script to diagnose problems with the
sockets. If the script tells you that it sent the mail, but mail never arrives,
run this test script.

Don't be stupid and leave old_conversion.php on your webserver once done.
Delete it, if you don't need it don't upload it. It's a security hazard if
left on your server. Same for install.php

Upload all the files except readme and the files contained in the 'f' dir 
to your web server. We will be creative and call this server mydomain.com and
be even more creative and assume that you create a directory called 'mail' 
into which you place these scripts. Once the files have been uploaded 
execute the command 'chmod 666' (0666 or rw-rw-rw- depending on how you 
input that kind of stuff) for config.inc.php and 
login_failure.txt. All other files should be 'chmod 755'. (0755 or r-x-r-x-r-x)
Next, direct your web browser to the install script, 
http://www.mydomain.com/mail/install.php. Enter the appropriate data.

Database: The name of your database. If you have already created 
one for us to use put that name in, otherwise the script will try and 
create it, but support for that is sketchy at best, we suggest you 
already have one ready, contact your sysadmin for more info.

Database password: The password to access the aforementioned database

Database username: The user name to accompany the aforementioned password 
and database.

Database host: Where the aforementioned database is located. localhost 
should work for the vast majority of users.

Base: yourdomain.com or www.yourdomain.com or subdomain.mydomain.com
No http://anything

mail.php address: where mail.php is in respect to base.
/mail/mail.php is a good bet. If you put base and this together into
your browsers url bar, you should get the mail.php page
Ex: mail.php at http://www.mydomain.com/mail/mail.php
base = mydomain.com
mail.php address = /mail/mail.php

SMPT ID: This is what the smtp server knows your website as. This will
usually be mydomain.com, but you may have to use an IP address.

SMTP Server: A mail server that you are allowed to connect to, most likely 
mail.mydomain.com or mail.myhost.com. You can try mail.myisp.com but it will 
most likely not work, more on that later.

POP server: Most likely, same as SMTP server.

POP account: Your user name on the POP server, look under Outlook express 
account options.(*nix people should be ashamed if they don't know their account)
Something like myname@mydomain.com or myname. Your email address essentially.
This should be the same as admin e-mail below, if people want to remove 
themselves from your lists they can reply to this address. It may be best to
create a mailbox named list or something specifically for your lists.

POP Password: The password to access the above account, again under account 
props in outlook. (*nix people, again if you don't know your passwords, ack!
Turn in your kernel you traitors!)

Use POP: check if you want to use the pop stuff. If not checked, don't
worry about filling in the other stuff

Use standard mail command: the script will send mail using the mail()
command instead of the socket commands.

Default list: You'll have to wait until you create lists to fill this out, and 
it may not even appear on the page right now. This is your default list that 
front.php will sign people up for.

admin username: What you the admin will log into the system with

admin password: The password that will accompany the aforementioned 
username.

Mamil Admin e-mail: This is the e-mail that will send your messages regardless of 
which admin user sent them. This is also where replies to your mailings will go.
Should be same as POP account, but, _must_ be a full, valid e-mail. The POP 
may just be a username, this needs to be the full enchilada (me@mydomain.com)

At this point, we need to talk about SMTP anti-relay which our good friend 
Jarmaug was kind enough to educate us on. Spam is a big problem. One thing 
spam senders try to do is 'bounce' their messages off other people's mail 
servers to make it harder to block and trace. In response, many servers now 
have anti-relay. What this means is that if you have a website at mydomain.com 
and an isp at myisp.com you may not be able to send mail through mail.myisp.com 
EVEN IF you currently send mail from your mail program on your computer through 
your isp's mail server. This is because your website is not local. (If your 
isp hosts your web site, nevermind) So, if you don't already know what 
mailserver you are allowed to use ask your sysadmin. Another anti-relay 
situation is that most SMTP servers will not allow outgoing mail with a 
domain (@blah.com) that is not local. So you will probably not be able 
to send mail from mail.mydomain.com with an admin e-mail of 
me@otherdomain.com. On that same note, some overly retentive SMTP servers 
also check to make sure that you are sending the mail from a valid e-mail 
address. So random-made-up-alias@mydomain.com might not work. If this is 
the case then some aliases may not work. Long story short, we _strongly_ 
suggest that for your admin e-mail you choose a real, local e-mail address. 
Other wise you'll have to do all sorts of voodoo to get your message to send. 
Its SMTP's fault, not ours. Also, if you're going to be using the POP replies
for removal, we recommend a mailbox specifically for list management.

Mail admin alias: This is the nice pretty name that will appear in inboxes. 
It can be whatever you want it to.

E-mails per page: This is the general auto-cutting number used in a whole bunch 
of things from viewing archived mailings to manually editing e-mail addresses. 
We recommend twenty (20) but you can use 1, 4, 2000, 4million, anything, all 
depends on how long you want to wait to have certain pages load.

HTML header and footer: Absolute unix path to HTML (Or PHP) header and footer 
files to wrap around the interfaces. Your site template basically.
(ex: /www/mysite/header.php)

Press go.

Did it work?

The most common error at this point is:
Error creating database: Access denied for user: 'username@localhost' to 
database 'mail' 

This means that the database did not exist, but that you do not have 
permission to create databases. You will need to ask your sysadmin to 
create the database, then run the install.

If you get an error about tables already existing you already have a table 
named x. You need to drop it.

If you get an error about file identifiers and permissions, make sure that 
you chmod'd everything correctly.

The next page tells you of your success or failure in setting up the database 
and writing to various files. Technically at this point you are done. However, 
we _strongly_ recommend that you hit the ok button on this screen to send a 
test message to yourself. This will allow you to see if your socket connection 
works and if you are allowed to post to the SMTP server. It is also 
recommended that you use add_addys.php to add a least one e-mail address 
that is not local (Like you@hotmail/yahoo/excite.com or something) and test
to see if you can send the message to that address. As long as the SMTP 
server accepts the socket connection, you will NOT receive ANY error messages. 
This does not imply that your message was successfully sent. More on that in a 
bit.

Also think about hitting the notify of install link. All the info that it
submits is right there, nothing all that sensitive. If you don't hit it
we'll never know and the script won't prompt you once you finish install,
but, hey, you got this for free, the least you could do is tell us where
it's being used.

Now head on over to mail_admin.php and login with your username and password. 
From here, you should first create a list.  The name you give this list will 
be seen by people when they sign up, so something like 'General'
or 'Site News' would be appropriate. This name can have spaces in it.
The first list you create will be your default list. Give it a welcome message,
descriptor and footer.

Once you've added your lists you should go and configure the script by clicking 
the link on the main page to that effect.

If you have a previous mailing list that you want to transfer, head on over 
to add_addys.php. Simply paste your old mailing list into the box and select 
which list(s) these people should get. (That is not always an option, if you 
only have one list it defaults to that.) Press go and you will be notified 
of your success or failure.

If you got enough errors from the install script to sink the titanic, or you 
are a real propeller head and want to do a manual install, look in the folder 
named 'f'. Here you will find the SQL table structures and the outline of 
config.inc.php. Run the SQL docs to MySQL and edit the config file by hand. 
We will assume you know what you are doing if you choose this route.

Section 3: Use.

3.1 Normal stuff
The process goes something like this. A visitor to your site goes to mail.php 
(Or uses front.php which can be called with an include(); and will display 
a single form field for their address, they will be added to your default 
list. The process is the same no matter which script is called.) and enters 
their e-mail address, and if applicable, selects which lists to receive. 
They press go, their e-mail address is validated, and we check to make sure 
they are not already in the database. The user is then directed to their 
mailbox where a confirmation message is waiting. This makes sure that only 
valid e-mail address get on the list and that no one tampers with a users 
subscription. They click on the link in the message and are then added to 
the list(s) they requested. At any time they may visit mail.php and change 
their mailings or remove themselves form the list.

You (Or one of your sub-admins) then log into the admin interface. 
You as the super-admin have complete access. Your sub admins only have 
access to lists that you allow them to and can only send mail; they can't 
do any of the other house cleaning maintenance type stuff you are allowed 
to. An admin decides to send a message. They click send mail and fill in 
the fields and select which list(s) it will be sent to and press send. 
The script will report if it was able to make a socket connection. If it 
can then it sends the message. If you are not allowed to post (Write) to 
the SMTP server you specified, or if you have violated some anti-relay rule 
(See in the install procedure near the SMTP description) or if the script dies 
from a maximum time out/run time error, some or all of your messages may not be 
sent.

The rest of the admin console is pretty harmless. If a user has trouble 
deleting themselves you can manually remove them, you can take off anyone 
you don't want on the list, edit access privileges and remove other admins 
and delete past mailings. If you delete past mailings, they are only removed 
from your database. We can't go and erase them from other people's inboxes. 
(Not for lack of trying though) One note, the 'add/delete lists' and the
'view breakdown' links go to exactly the same place. It just makes sense.

Visitors to your site can then visit archive.php and browse through mailings 
by list.

3.2 POP stuff
By popular demand, (That's not what POP stands for, Post Office Protocol 3 if 
you were wondering) we've included the ability for people on your list to 
unsubscribe in two ways. First, as always, they can visit mail.php and change
subscriptions or remove themselves from lists. New in this release is the 
ability for people to reply to mailings you send out and remove themselves. 
To do this all they have to do is send an e-mail to what you listed as the 
mail admin  address with the subject of 'unsubscribe' or 'remove' case 
insensitive. The body of the e-mail doesn't do anything.

This is a new feature, so you have to manually activate it on the configure page
before it will work. Just click the little box. Then when you send a message,
the script will first check to see if any one wants to be removed, then send
the message. If it finds a message it can't deal with, it will alert you. 
It will then delete all messages that it could remove people for. It won't touch
messages with a subject other than 'unsubscribe' or 'remove'. If it runs into
a problem it will tell you, if you want to check without sending a message, 
click the check replies link on the main page.

The following functions are understood by the pop checker, case insensitive:

remove - completely removes a person from the mail list
unsubscribe - completely removes a person from the mail list
These two commands do the exact same thing, erase all traces of a person from 
your database

add list1, list2, listx - adds the supplied lists to a persons subscription
drop list1, list2, listx - removes the supplied lists from a persons 
subscription. 
These two commands allow uses to manage and change their subscriptions. The list 
arguments after the command should be the name of the list they want to 
subscribe. Spaces are allowed in list names, each list must be separated by a 
comma ','.

subscribe list1, list2, listx - adds a person to the mail list, and the 
supplied lists
This command is for new sign-ups who are not currently in your database. Should 
a person not in the database use the add command, they will be added to the 
database and then to the selected list. But, if a person already in the database
uses the 'subscribe' command, the script will instruct them to use the 'add' or 
'drop' command.

The commands must be in the subject of the e-mail. Don't put more than one 
command in the subject. For instance

add General news, Cool stuff, drop Daily News

Would not work as expected. Two separate e-mails would need to be sent:

#1: add General news, Cool stuff 
#2: drop Daily News

We hope to enable the ability to handle multiple commands in one letter soon.

This feature is still new, and we take no responsibility should some local star go 
super nova upon using it. In fact, just to ensure that we still have nine 
planets in the solar system at the end of the day, we recommend that you not 
use the pop option unless you really want  it. If we lose mars or Neptune, 
some people will be very upset, and, hey, you've been warned.

Section 4: FAQ

Getting some help.
The way this script seems to work is wonderful or not at all. Not a whole lot
in between. If you are having trouble feel free to visit
http://www.452productions.com/bbs/index.php and we'll see if we can help you.
We might not be able to, or it might take a while. We're busy folks. To
make things eaiser, before posting a question we ask two things.
For all questions: Please visit http://uptime.netcraft.com/up/graph/
and examine your web site. When you post in the support forum please
include the line:
The site Mysite.com is running Apache/1.3.14 (Unix) PHP/3.0.17 on Solaris
This for instance helped us figure out that the old login method didn't work
on PHP4 systems and we were able to fix the problem.

If you're a privacy freak, no we don't need to know yur site name, but we need 
the stuffafter the word 'running', some people may have longer lines with words
like mod_gzip/SSL, include it.

If you're having a problem with messages not being sent, run no_mail.php and
include the FULL output of no_mail.php with your post in the forum.

On with the FAQ.
 
I don't get any errors, but my messages are not being sent. What's wrong?

Something is wrong with the SMTP server and/or the script. Upload the script
no_mail.php from the f folder. This script will spit back a bunch of
codes which, if you know what they mean, you can deduce why your mail isn't 
getting sent. Other wise, take the out put to 
http://www.452productions.com/bbs/list.phpf=1 and post it in the support forum.
Sockets are great, faster and more reliable, once you get them working. They can
require a bit of coaxing and witchcraft before they decide to work with you. 
(Read, you might have to play with them some, they might bite, and the bark is 
pretty bad too. Might even have to talk with your sysadmin/host about logins or 
relays and such.)

I get a maximum time out/execution error. What's wrong?

The script could not send the message to everyone on your list fast enough 
and the server killed it. We want to know about it, but only if you are using 
the script with sockets enabled. (We know the mail() function times out.)
How many people did you have on your list? Send us an e-mail telling us. 
This is a common problem with php mailers using the mail() function which 
is very slow. By using sockets we have (In theory) speeded the operation up 
enough to allow you to send hundreds of thousands of emails. It also depends 
on server settings. But ever server will eventually kill this script if you 
have a very large number of addresses. (We're talking millions, but, it can 
vary widley based on your server and it's settings.) On average the mail() 
function can send about 5,000 emails before it gets killed. This script should 
be able to send at least 100,000. But, as we don't have 100k people on our list, 
we don't actually know and are just guessing. So if you DO get a timeout 
error we WANT to know. We're also working to speed up the list selection 
process, which should allow you to send even more messages.

Then again, there is a database problem on somesystems. We're working on that.

I don't know what SMTP server to use. Can I just pick a random domain and use 
theirs?

Ummm....no. You probably don't have access. Ask your host which SMTP server 
you can use. The vast majority of web hosts allow SMPT access. If not we can 
recommend a few good ones that do.

What with your spelling? Haven't you ever heard of a spell check?

It is a poor mind that can only imagine one way to spell a word. Good spelling 
is an etymological disease, consult your local linguist for medication.

This is so cool, I'm gonna use add_addys.php to sign up a bunch of people and 
spam them to the end of time.

Uhhhh..no. First off that wasn't a question, and this is the FAQ. (The Q means 
'questions' you see) Secondly, this isn't designed to send spam, so, it is very 
easy to trace messages sent with it right back to _your_ web server. Great way 
to get your host mad at you.

Limits/Problems?

Something is up with deleting emails through the admin page and some versions
of sendmail won't send the mail. Minor detail. Working on it. (Word on the 
street says it seems to be fixed, don't bet anything serious on that yet.)

The following situations are at the moment considered terminal. If you
encounter them durring the course of the script, you'll be unable to use the
script. We're working to fix these problems, but hey, we're only human.

You run no_mail.php and see the following:
...
503 Need MAIL before RCPT 
503 Need MAIL command 
500 Command unrecognized: "Subject: " 
...

Followed by more 'Command unrecongnized' things. You're outta luck.

Upon visiting mail_admin.php you receive:

Internal Server Error
The server encountered an internal error or misconfiguration and was unable to 
complete your request.
...

Those mean you're running versions of software that we don't currently support.
If you do get those messages, we still want to hear about it, every problem
that some one has gives us new information about how to fix these bugs. Post
in the forum with the versions that netcraft reports, and the no_mail output if
you've got mail problems.

There can only be one 'super-admin'. 
You can't attach files to messages. We plan to fix those as soon as possible, 
if you find something other than those, it's news to us and we want to know.

What's with 'notify 452 of the install' link?

Clicking the link will tell us the name, version, and location of the script 
you just installed. We'll then link to ya if it looks cool. It's not required,
and we have no way of knowing if you don't click. Of course, we could be 
building a super-secret list of people who will be rewarded for their loyalty 
and named heads of state under the new 452 world order, you'll never know.
You can also visit 452productions.com/users.php and manually fill in the
form. Either way, you'll be on the list, and if you suddenly find yourself
in control of a small country, you'll know who to thank.

Why is every thing so bland?

Did you _see_ our web page? Do you really want us trying to design
for a site layout that we've never seen? Use the header and footer
include options on the config page and thank the powers that we 
didn't try and make it look pretty.

Explain the world_domination() thing at the end of the script.

We are not at liberty to discuss that matter as it may compromise our 
agents in the field. (It's actually a general purpose info function
but we got bored looking at the word info, so we gave it a cooler name,
if you have _no_ clue what we're talking about - good. That's how it 
should be.)

That should pretty much do ya. If you still have questions, or found a bug, 
(And there's probably a ton of them) or have a suggestion (And there is a 
lot of room for improvement) don't hesitate to contact us. Other than that 
enjoy the script, we hope it's useful to you. (If not tell us how we could 
make it useful) Feel free to drop us a line at anytime, user feedback got
this script to the point where it is today, and userfeed back will continue
to imporve it.

Services Dept.
services@452productions.com
http://www.452productions.com
World Domination on a Global Scale (TM)

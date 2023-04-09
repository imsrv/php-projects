e-post v1.9 by ryan marshall of irealms.co.uk

***************************************************************

e-post is a simple in-site messaging system that enables users to send messages to other users on your site. You may send, reply to, or delete messages with ease. e-post was originally written for my masters project www.opensourcemanagement.com. You may see an example on www.irealms.co.uk/e-post.
The e-post zip file contains an index page complete with a modified version of authmain.zip enabling setup of e-post with minimum effort.

The layout and visual appearance has been kept simple to make customisation easier after installation.




Installation:

1)Insert the file e-post.sql into your mysql database




2)Fill in your database information in config.php, the script section you need to alter is shown below:

$db_conn = mysql_connect("Database host (often localhost)", "datbase user login", "database user password") or die("unable to connect to the database");
  mysql_select_db("database name", $db_conn) or die("unable to select the database");

If you wish to make use of the login system included then you need to enter an email address in config.php. You should enter this in the section for the variable $from.



Also the following must be changed in config.php:

$additional_headers2 - this is for the user preferences (new in v1.5)
$sitename - must be entered (also for preferences and new in v1.5)
$siteurl - must be entered (new in v1.6)




3)Once this is done you will be setup with 2 test users:

test/test
test2/test2

You may login as one of the above and send a message to the other. If you then login as the user you sent the message to you will see it in the inbox. A registration form is provided for simple user registration with a group field. Users will only be able to send and receive messages from people in the same group. 

Preferences:

Version 1.5 onwards has the option to send a mail to a user upon receipt of a new message. This currently is only sent for the first new message, comments exist in the e-new.php  on how to alter this to work for each message.

NOTE:
If you wish everyone to use the same group then you need to make some small changes to the register form.

Replace the following in register.php:

Group:<br />
<input type="text" name="group" size="50" style="font-size:10px;border:solid 1px;"><br />

with:

Group:<br />
<input type="hidden" name="group" value="test"><br />

Each time a user is created this will place them in group test. If you wish a different group to be used just change test in the above value field to whatever your group is called.


e-post can easily be integrated into your own site. The script is setup with includes in mind, that is all files are included into an index page. The areas you need to include are commented in the index.php file included with this script.


NOTES: From version 1.7 up you may send a mail to all in your group, if you wish to remove this option you will find a comment line in e-new.php telling you how to do this.

From version 1.8 a bad word filter is included, this can be found in config.php.

Version 1.9 includes a mod folder inside e/post which contains 2 files. These are different versions of e-new.php, one is the original version of e-new.php and the other a modded version. The modded file is for use if you prefer a text box for entering user names, useful if your groups have a lot of users. 

To change the e-new.php just follow these instructions : -

1) Remove the file e-new.php from inside the e-post folder.
2) Copy your chosen file from the mods folder into /e-post.
3) Rename the copied file e-new.php.

If you have any problems with this script or wish it to be installed, please email ryanmarshall@irealms.co.uk
====================================================================================

e-post file list:


index.php = index template file
config.php = config file
content.php = $page variables to be used in your index page
e-post.sql = sql database file
e-post_nav.php = navigation links for e-post
preferences.php = user preferences (new in v1.5, message notification)
friends.php = Friend list (new in v1.6)
users.php = user search, for friend list (new in v1.6)

main e-post files (in e-post/):

e-post.php = e-post inbox (main file)
e-new.php = file to send new messages
e-open.php = displays message when opened

Mod files (/epost/mods)

e-new(original).php
e-new(text box for users).php


login files:

authmain.php = main login script file
logout.php = logout file
changepass.php = change password file
forgot.php = forgotten password file
register.php = register form and script

images folder:

cp.gif = changepass button
login.gif = login button
send.gif = send password button
reg.gif = register button
env_closed.gif = unread message image
env_open.gif = read message image
mai_anm.gif = new message notification animation image
delete.gif = delete icon




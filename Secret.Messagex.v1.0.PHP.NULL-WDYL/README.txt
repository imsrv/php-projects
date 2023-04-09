#######################################################################
#                         Secret Messagex v1.0                        #
#            By Thomas Tsoi <admin@tecaweb.com> 2002-01-10            #
#         Copyright 2001 (c) Teca Web. All rights reserved.           #
#######################################################################
#                                                                     #
# Teca Web:                                                           #
#   http://www.tecaweb.com/                                           #
# Teca Scripts:                                                       #
#   http://www.teca-scripts.com/                                      #
# Support:                                                            #
#   http://www.teca-scripts.com/forum/                                #
#                                                                     #
# ################################################################### #
#                                                                     #
#        This is a commercial product and CANNOT be distributed       #
#                  without the author's authorization.                #
#                                                                     #
#######################################################################

TABLE OF CONTENTS
    1. Welcome
        1.1 About the script
        1.2 How it works
        1.3 System requirements
    2. Uploading Files
    3. Installation
    4. Customizing custom fields
    5. Customization
    6. Administration
    7. Parameters accepted in different pages
    8. Enquiries


1. Welcome

1.1 About the script
-------------------------------------------------
secretMessagex is a system developed to let your visitors send "secret
messages" to their crushes. Visitors can create their own accounts,
which allow them to check the incoming and outgoing secret messages.
Also, an admin script is provided, which allows the administrator edit
configurations, delete users, add/remove random ADs, send emails to
users and show user statistics.

1.2 How it works
-------------------------------------------------
- Dave likes Jane, but does not know whether Jane likes him too 
- So he sends a secret message to Jane telling her he likes her 
- Jane receives a secret message but do not know who sent it 
- She goes to secretMessagex.com and sends a secret message to her 
  crush too, and it turns out to be Dave 
- The system sends an email to both of them and tell them they've 
  GOT A MATCH! 

1.3 System requirements
-------------------------------------------------
secretMessages requires:
	PHP4
	PHP Session enabled
	MySQL 3.23 or higher

2. Uploading Files
-------------------------------------------------
Here is a list of files that came with Quirex.

    Directory  File                       Desc           

    <./>
             config.php          Config parameters
             install.php         Installation script
             login.php           User login page
             logout.php          User logout page
             install.pl          Installation script
             myaccount.php       MyAccount page
             newaccount.php      Script to create a new account
             register.php        New account registration form
             retrieve.php        Password retrieval form
             send.php            Message form
             sendmsg.php         Script to send secret message
             verify.php          Script to verify user email

             index.php           Links to different pages
             README.txt          This file

    <./admin>
                 index.php       Admin script

    <./images>
                 bottom.gif
                 logo.gif
                 transparent.gif

Upload all these files to a directory on your server.

3. Installation
-------------------------------------------------
Open config.php with your favourite text editor, enter your MySQL
hostname (leave it as "localhost" in most cases), username, password
and database name.

After that, run install.php, follow the steps indicated by the script.
(For more information on custom fields, please see point 4.)

After the installation, delete install.php for security reasons.

4. Customizing custom fields
-------------------------------------------------
By default, a new user registration takes 4 parameters, namely
username, password, name and email.

Custom fields are extra fields which you can ask the script to record
in the database. You can have as many as 6 custom fields.

To set custom fields, set them during the installation, or in the admin
script after installation.

A custom field must be "enabled" to use. If you check the "required"
box, the script will check if the user has entered that field during
the registration.

After enabling a custom field, you should create a form element named
the same as the custom field (field_1, field_2, field_3, field_4, 
field_5 or field_6).

You can view the statistics of these fields in the admin script.

5. Customization
-------------------------------------------------
You can edit the HTML parts of the PHP pages directly.

There are pages where you will want to link to:

Registration page:    register.php
Login page:           login.php
Logout page:          logout.php
MyAccount:            myaccount.php
Send secret messages: send.php
Password retrieval:   retrieve.php

For myaccount.php and send.php, if the user has not logged in, he will
be redirected to the login page automatically.

Warning: DO NOT link directly to other pages! 
(newaccount.php, sendmsg.php, etc.)

6. Administration
-------------------------------------------------
Access http://(where.you.installed.secretMessagex)/admin/index.php

This script is not password protected, use .htaccess to protect it if
necessary.

7. Parameters accepted in different pages
-------------------------------------------------
newaccount.php (accessed from register.php)
	username
	password
	name
	email
	field_1 (optional, see 4)
	field_2 (optional, see 4)
	field_3 (optional, see 4)
	field_4 (optional, see 4)
	field_5 (optional, see 4)
	field_6 (optional, see 4)

myaccount.php (accessed from login.php)
	username
	password

sendmsg.php (accessed from send.php)
	crush_name
	crush_email
	message
	
retrieve.php
	email

8. Enquiries
-------------------------------------------------
If you have any problems during the setup, please visit the support
forum of our website at:

    http://www.teca-scripts.com/forum/

Good Luck!

Thomas Tsoi

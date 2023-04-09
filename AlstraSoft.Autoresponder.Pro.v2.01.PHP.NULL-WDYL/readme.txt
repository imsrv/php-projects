                                      AlstraSoft Autoresponder Pro v2.01 Documentation

Server requirements for AlstraSoft Autoresponder Pro 
 
1.) Catch-all email
2.) POP3 access to email accounts
3.) MySQL (version 3.23 or higher)
4.) MYSQL database
5.) PHP (version 4.2.3 or higher)
6.) Crontab


Installation And Setup Instructions: 
 
1) Create a folder named "responder" on your web server and copy ALL files in that folder. Chmod 777 the folder, temp 
 
2) Create a new database and run the SQL file, autoresponder.sql (If your webhost has PHPMyAdmin, you can run the sql file 
there) 
 
3) Modify the MYSQL database information using the new database you have just created in the file include/globals.php 
 
4) Modify the mail account username/password (main email address for domain*) in the file robot/imap_globals.php. 
Note: For $MailHost, the variable is usually yoursite.com. If you are unsure of your mail server, please contact your host 
administrator
 
5) Open the 2 files: signin.tpl and signin_aff.tpl found in the folder templates/signin and edit the paypal email address

6) Add to cron job php responder/robot/check_deliver_broadcast_messages.php once at a minute
 
7) Add to cron job php responder/robot/check_deliver_followup_messages.php once at one day
 
8) Add to cron job php responder/robot/check_instant_messages.php once at a minute 
 
*This email address must have the ability to catch all emails received for that domain that have no address (catch all, 
default email address)

Running The Software:
Admin Login: http://www.yoursite.com/responder/admin Default username: admin, password: admin
Member Login: http://www.yoursite.com/responder/signin.php
Member Signup: http://www.yoursite.com/responder/signup.php


Version History
Version 2.01:
-Add in a password forget feature for members
-Able to import mailing list from a .txt file at /login/prospects_active.php.
(Example format: name,your@email.com for each line. Member can also specify the delimiter that separates name
and email for example ',' or '|')
-Able to edit member info (including upgrade their account type)at admin/members_list.php
-Add in a search function in admin/members_list.php so admin can search members by username OR email
-Add in a feature in the admin panel so admin can mass mail all members

Version 2.0:
-Enhance template editing
-Some minor bugs fix

Upgrade Instructions
- Replace all files except include/globals.php and robot/imap_globals.php


AlstraSoft, Copyright ? 2003
All rights reserved. 


LICENSE AGREEMENT
Do not run the AlstraSoft software on a site other than which they have been licensed for. Violation of this license 
agreement may void your right to receive support and subject you to legal action. You should carefully read the following 
terms and conditions before using this software. Unless you have a different license agreement signed by AlstraSoft, your 
use of this software indicates your acceptance of this license agreement and disclaimer of warranty. 


As a registered user, you may alter or modify the AlstraSoft as far as the HTML output is concerned. Further modification
of the script code requires written permission of the author (Just drop us a short note ). You cannot give anyone else 
permission to modify the AlstraSoft Software. You are strictly prohibited from distributing copies of this software 
without prior permission. You are specifically prohibited from charging, or requesting donations, for any copies, however 
made, and from distributing the software and/or documentation with other products (commercial or otherwise) without prior 
written permission! 

DISCLAIMER OF WARRANTY
This software, the information, code and/or executables as well as the accompanying files provided are provided "as is" 
without warranty of any kind, either expressed or implied, including but not limited to the implied warranties of 
merchantability and fitness for a particular purpose. In no event shall the author or seller be liable for any damages 
whatsoever including direct, indirect, incidental, consequential, loss of data, loss of business profits or special damages, 
even if the author or seller has been advised of the possibility of such damages. Good data processing procedure dictates 
that any program be thoroughly tested with non-critical data before relying on it. The user must assume the entire risk of 
using the program. 

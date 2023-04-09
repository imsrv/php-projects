PHPJayMail v1.0 ReadMe.txt
==========================

First of all, thanks for choosing my script!

Contents:
+ Installation
+ Implementation
+ General Info
+ Features
+ Usage Notes
+ Improvements/Ideas
+ Troubleshooting
+ Copyright Info
+ Contact Info


Installation
------------
First of all, execute the SQL statements
in sql.sql on a previously set-up MySQL 
Database. (Note the name of the database for
when we edit the config file in a minute.)

Now, edit config.php to your needs,
what to edit is explained within the file.

Once this is done, move the PHPJayMail folder
and its contents into one of your web 
directories. Make sure the web directory you
have put it in is correctly entered into
the config.php.

THATS IT! GO USE IT!


Implementation
--------------
You can point potential applicants for your
mailing list to addme.php, you can link to
it by using this URL:
www.yourdomain.com/PHPJayMail/addme.php.

You can also use this page yourself to add
people to your own mailing list.


General Info
------------
This script is coded in PHP. It is compatible
with PHP version 4 and above and MySQL version
4 and above. It was released on 26/08/2005 by
Jay Shields, from Jay-Designs.co.uk.


Features
--------
- User-friendly interface
- MySQL integration
- Secure login page
- Easy configuration
- Easy installation
- Flexible
- Template support
- Email support
- External recipient addition page


Usage Notes
-----------
Templates:
To use your own templates for the emails,
make a new directory in the templates folder
which is inside the PHPJayMail folder on
your web server.

Create a header.html and a footer.html, these
will be added to the top and bottom of your
newsletter body which you will send with
PHPJayMail. Put these 2 HTML files into your
newly created folder.

HTML email:
If a template is not selected, HTML email
will not be enabled. HTML email will only
be enabled once a template is selected.

To compensate for this, you can use the
BlankHTML template, this enables HTML
email to be sent without a real template
being used. (the header.html and
footer.html in the BlankHTML template
are COMPLETELY blank, so you would have to
use the <html> tags aswell.


Improvements/Ideas
------------------
Got any ideas for future versions of
PHPJayMail? Seen something in the script
which you don't particularly like?

Email me with any improvements or ideas
and I will do my best to get them into
the next verson of the script.


Troubleshooting
---------------
I do not provide any type of warranty with
this script, but, if you do come across any
bugs or problems with the script, feel free
to email me and I will try my best to help.


Copyright Info
--------------
Under no circumstances can any of this
script be redistibuted without my written
permission. The whole script and all the 
images are copyright Jay-Designs.co.uk 2005.

If you would like to make any improvements
to my script, please feel free. I would
also appreciate being sent a copy.

Please do not edit the main image header and
the copyright footer. Thanks.


Contact Info
------------
Name: Jay Shields
Web: www.jay-designs.co.uk
Email: jay@jay-designs.co.uk
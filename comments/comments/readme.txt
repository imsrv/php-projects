ScriptsMill Comments Script v1.0 ReadMe

Requirements:

-PHP 4
-MySql database: Create a Mysql database on your server (UNLESS you already have one!) to store the necessary tables.

Installation instructions:

1. Unpack the script files to a directory on your hard disk.

2. Upload all the script files to a directory on your server 
   eg: /comments

   Make sure you keep the exact file structure.

   Open install.php in your browser and follow the instructions.


To show the comments on a page copy and paste the following code:

If your site uses php:

<?php virtual("/comments/comments.php"); ?>

If your site uses SSI:

<!--#include virtual="/comments/comments.php" -->

If your site uses ASP:

<!--#include file="/comments/comments.php" -->


After install you can change any parameter of the script by editing "config.php" file. Also you can
create your own templates in "./templates" folder to customize appearance of the comments. If your
website is not in English you can create your own language file in "./lang" folder. Don't forget to
edit "config.php" in order to script uses your tempalte or language file. Please send me your
templates and language files to info@scriptsmill.com, I will include them to the packadge.

For support and new versions please visit http://www.scriptsmill.com

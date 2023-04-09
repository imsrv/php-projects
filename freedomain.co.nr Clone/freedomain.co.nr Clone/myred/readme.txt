This is the installation instruction for NO ONE .
Please read this text carefully to get a correct installation of the scripts.

REQUIREMENTS:

This software requires a running webserver (preferred apache) with php 4.1 installed (no version below 4.1 is supported!).
You also need 1 or more domains with wildcarded subdomains. If you are not sure what this means, ask you webspace provider about this.
The wildcards must point to the web root directory.
The software has been tested under Windows(tm) and Redhat(tm) Linux (both with apache as webserver).

1. INTRODUCTION

This set of scripts allows you to run a redirection service. Users may signup at your site to get a short and catchy domain name.
You as the webmaster may put advertisements on each redirected page.
Please keep the link back to my website http://www.NO ONE.com included in the template files.
If you remove the link back to NO ONE.com - to be honest: there's nothing I can do about that :-)
But I would be happy if you keep that link, so that other people also are able to download this software.
You may also present this link on any other web-accessible page of your website.

2. COMPLETE NEW INSTALLATION

This is the point to start if you never have used NO ONE Redirection before.
For Upgrade installation instructions (upgrade from release 1.2) please go to chapter 3 of this document.

Well, let's start.
Installation is done quick and quite easy. All you need initially to start is a text editor to change a few variables in one file,
and a ftp-program to load the scripts up on your server.
Now here are detailed installation instructions...

a. The list of files/directories that come along with this distribution ([...] is a directory)

.htaccess
index.php
	[myred]
	   admin.php
	   contact.php
	   dir.php
	   faq.php
	   features.php
	   latest.php
	   members.php
	   password.php
	   register.php
	   setup.php
	   stats.php
	   tell.php
	   terms.html (design this page like you want)
	   topsites.php
	   upgrade.php
	   whois.php
	   [img]
		bar.gif
	   [include]
		functions.php
		vars.php
		mysql.php
	   [language]
		all language files reside in here
	   [html]
		all template files in different directories

The following 2 files MUST be placed in your web root directory:
.htaccess
index.php

If you already have a file called "index.php" or "index.html" in your web root,
rename it (for example "index2.php" or better "home.php" or "home.html") and use this one.
You can still use the now called "index2.php"/"home.php"/"home.html" as your default startpage
(This can be done in the admin panel, more on that in "d.").

The directory "myred" also must be placed in your web root.
It must be accessible via your web browser by typing in "http://www.yourdomain.com/myred/".


b. Editing variables

Open the file "vars.php" (located in the directory "include") with your favourite text editor.
There are 3 to 4 variables you might have to change:

* $mysql_host is the name of the host the mysql-server is running on.
In most cases it is 'localhost' and there is no need to change it. If you are unsure about that, please ask your webspace provider.

* $mysql_username is the username to access the mysql-server.
If you are unsure about that, please ask your webspace provider.

* $mysql_passwd is the password to access the mysql-server.
If you are unsure about that, please ask your webspace provider.

* $mysql_dbase is the name of the database where the tables will be installed.
If you are unsure about that, please ask your webspace provider.

The other variables in this file are quite self explaining.

If you want to, you can also change all template files (*.html) in the "html/templatename"-directory to fit your needs.
You can do so with you favourite HTML editor, or with any text editor you prefer.

*********IMPORTANT*********: there are certain words like {text_125}, {reserved} or {stats} written in the templates.
These are tags which will be replaced by content while the scripts are running.
YOU HAVE TO KEEP THEM IN ORDER TO RUN THE SCRIPTS.

If you want to use other than the standard templates, just put the whole directory with the new template set into the "html" directory
(name the directory e.g. "newtemplate") and select it in the admin area (you can also select another template set during installation).

Don't forget to save the files after you made the changes.


c. Upload the scripts

Upload the myred-folder into the root directory of your webserver. All scripts must be accessible like http://www.yourdomain.com/myred/script.php
The files "index.php" and ".htaccess" must be placed directly into the web root (e.g. http://www.yourdomain.com/index.php).

It is important that you transfer the scripts in ASCII mode, and the image (bar.gif) in binary mode. Normally this should work automatically,
depending on the ftp-program you use. Otherwise manually switch to ASCII or binary (ask you ftp-program's documentation about that).
Also leave the directory names and structure as they are.


d. run "setup.php"

Open your web browser and call the script "setup.php" like this: http://www.yourdomain.com/myred/setup.php
You'll see a welcome page and your mySQL-data (the one you edited in "vars.php").
All other steps are self-explaining.
During step 3 you may eventually choose the former renamed "index2.php"/"home.php"/"home.html" as "Default startpage".
After finalizing setup, don't forget to delete the files "setup.php" and "upgrade.php" from your web server.
RENAMING IT IS NOT RECOMMENDED for security reasons.


3. UPGRADING FROM RELEASE 1.2

This chapter is only interesting for you, if you have a running release 1.2 installed and want to upgrade to release 1.4
If you do a complete new installation, you can leave this chapter 3 and go to chapter 4 (CONFIGURATION AND RUNNING).

The point’s a. and b. are the same as described in chapter 2 (COMPLETE NEW INSTALLATION).
IMPORTANT: MAKE A BACKUP COPY OF YOUR DATABASE BEFORE UPGRADING! ALSO MAKE SURE YOU KNOW YOUR ADMIN PASSWORD AND USERNAME.
Before uploading the new release, delete ALL files from the old installation from your web server (yes, you read right: no old file will be used any longer).
So, delete the "old" myred folder, and also the "old" index.php and the "old" .htaccess file.
If you have difficulties to delete the old .htaccess file (e.g. you can't see it in your ftp client because it is a hidden file),
Just put the new .htaccess file coming with this release into your web root directory (it should overwrite the old one).
Instead of "setup.php" you call "upgrade.php".
Upgrade.php tries (hopefully successful :-)) to upgrade your existing database to fit into the new database scheme.
You shouldn't get any error messages during upgrade.

4. CONFIGURATION AND RUNNING

After setup or upgrade, open admin.php like this: http://www.yourdomain.com/myred/admin.php
You'll be prompted for your username and password.
After filling them in and pressing the login button, you are in the main administration screen, and here you see different options to choose from.
What you should do first, is filling in the domain(s) you want to use for your redirection service (the domains your user can sign up to, at least one is required)
and the categories to categorise the user's webpage’s (otherwise no user can register).
When you do an upgrade of an old installation, you have to edit your categories (because of a new ad system) before anyone can register to your services.

Play around with all the options in the administration area, they should be self-explaining.

That's all. For questions, please use the message board at http://www.NO ONE.com.
Note that I try to, but that I am not obligated to support the scripts.

Many thanks to Arthur Khessin for the "forbidden words" idea, and to scooby for this corrected readme file.
I wish you best luck and success with your redirection service.
Thank you for using NO ONE Redirection!

5. TIPS

When you change the forbidden words or reserved names please make sure YOU DONT put -- on the last word else you might get a php error.

Example 1 : --hackz--warez--appz--sex--    this is incorrect
Example 2 : --hackz--warez--appz--sex       this is correct

Also take care when changing the templates as some html editors add extra information to the form control 

Example frontpage 2002 : will change this line from  <input type="checkbox" name="terms" style="border:none">

to

<input type="checkbox" name="terms" style="border:none" value="ON">

this will cause users an error and will not let let them register as it will say "You have to agree to the terms" over and over.


If you want to, you can add different languages to the scripts. Just translate english.php to your favourite language, save it as, lets say spanish.php,
and put it into the "myred/languages" directory on your webserver. In the admin area then set this language as default.


6. DISCLAIMER OF WARRANTY 

THIS SOFTWARE AND THE ACCOMPANYING FILES ARE SOLD "AS IS" AND WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
NO ONE is not liable for the content of any webpage redirected with NO ONE Redirection.
The user (you) must assume the entire risk of using the program.

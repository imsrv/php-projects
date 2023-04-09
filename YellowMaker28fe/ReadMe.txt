
########################################################################
#
# PROGRAM NAME : YellowMaker
# VERSION : 2.8 Free Edition
# LAST MODIFIED : August 27, 2002
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
#
#======================================================================= 
#
# COPYRIGHT NOTICE:
# (c) Copyright 2001-2002 YellowMaker.com. All Rights Reserved.
# This program cannot be sold or distributed without written permission 
# from YellowMaker.com. Customers cannot alter the "powered by" 
# notices throughout the scripts and web pages. These notices must 
# be clearly visible to the end users.
#
#======================================================================= 
#
# WARRANTY DISCLAIMER:
# THIS PROGRAM IS SOLD OR DISTRIBUTED IN THE HOPE THAT IT WILL BE
# USEFUL, BUT WITHOUT ANY WARRANTY; WITHOUT EVEN THE IMPLIED WARRANTY
# OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.
#
########################################################################
# ReadMe.txt
########################################################################

INSTALLATION GUIDE

(Important Note: Please read the following instructions completely.)


=================================================================================
STEP 1: SET THE LOCATION OF PERL INTERPRETER
=================================================================================

Where is the Perl interpreter on your web server?
Perl interpreter is usually located at "/usr/bin/perl" or "/usr/local/bin/perl"
on a web server. YellowMaker was configured "/usr/local/bin/perl" as default. 
If your web server's Perl interpreter is not located "/usr/local/bin/perl", you
muat change the first line of ".pl" files in "cgi-bin/yellowmaker/.." to reflect your
Perl interpreter's location, except the following files:-

1. cgi-lib.pl
2. config .pl
3. config2.pl
4. cookie.lib
5. message.pl
6. sub.pl
7. variable.pl

Default: #!/usr/local/bin/perl

TAKE NOTE:-
Be sure that you put "#!" in front of the path.


=================================================================================
STEP 2: UPLOAD THE YELLOWMAKER SCRIPTS TO YOUR WEB SERVER
=================================================================================

../cgi-bin/.htaccess
../cgi-bin/yellowmaker

Upload above ".htaccess" and folder "yellowmaker" in ASCII mode to your CGI directory 
(cgi-bin). If  your web server do not have a CGI directory, make a directory 
"cgi-bin" on your document root (the directory out of which you will serve your 
html files).

../non-cgi/yellowmaker/index.html
../non-cgi/yellowmaker

Upload above ".index.html" and folder "yellowmaker" to your document root (the directory 
out of which you will serve your html files) on your web server.

TAKE NOTE:-
1. Set "cgi-bin" folder to permission 755.
2. Set all other folders to permission 777.
3. Set all ".txt" files to permission 777.
4. Set "config.pl" and "config2.pl" to permission 777.
5. Set all other ".pl" files to permission 755. 
6. Upload ".htm", ".txt" and ".pl" in ASCII mode.
7. Upload ".gif" in BINARY mode.


=================================================================================
STEP 3: SET UP THE YELLOWMAKER
=================================================================================

Type in the following link on browser to access your Administrative Center:-
e.g. "http://your_domain_name/cgi-bin/yellowmaker/admin.pl"

Login the admin center with userid and password shown below:-
Administrator: yellowmaker
Password: yellowmaker

Choose the "2. System Configuration" option and set your configuration carefully
and completely.

That is all you need to set up the YellowMaker. 

If any errors appeared when you try to access above link to your Administrative 
Center, just try another two methods shown below.

-------------------
Method 1:
-------------------
Run the "setup.pl" file you just have upload to your CGI directory 
e.g. "http://your-domain-name/cgi-bin/yellowmaker/setup.pl"

Administrator: yellowmaker
Password: yellowmaker

Key in the above administrator's name and password to login.
Then follow the instructions on the setup page to complete your installation.
Important Note: Please change the administrator's name and password to secure
your administrative center.

-------------------
Method 2:
-------------------
Follow the instructions shown below and edit the "config.pl" file in your CGI 
directory before you upload it to your web server. You may overwrite this file 
in your web server if you have uploaded it to your web server. 

How to edit the file? Use Windows Notepad to open the file. Type in or change 
the value in "". Example: $yourname="value"; ----> $yourname="webmaster";  
Do not forget to put the ";" at the end of the values.

Edit "config.pl":-

$admin=""; 
--- Your name for admin use. 0-9, a-z and A-Z only. Default value is "yellowmaker".

$adminpwd="";
--- Your password for admin use. 0-9, a-z and A-Z only. Default value is "yellowmaker".

$url="";
--- Your web address / URL. Do not end with "/".
--- Incorrect if: $url="http://www.yourdomain.com/";
--- Example: $url="http://www.yourdomain.com";

$company="";
--- Your company name. 0-9, a-z and A-Z only.
--- Example: $company="ABC Corporation";

$website="";
--- Your web site's name, not a web address.
--- Example: $website="ABC Web"; 

$title="";
--- Your business directory's title. 
--- Example: $title="ABC Business Directory";

$slogan="";
--- Your slogan for this program.
--- Example: $slogan="Your Business Directory On The Web";

$copyright="";
--- Your copyright notice for this program.
--- Example: $copyright="© Copyright ABC Corporation 2001. All right reserved.";

$webmaster="";
--- Your e-mail address or your webmaster's e-mail address.
--- You must put a \ backslash before the domain name of e-mail address.
--- Example: $webmaster="webmaster\@abc.com";

$root="";
--- The directory out of which you will serve your documents.
--- Example: $root="/home/userid/htdocs";

$cgi="";
--- The top of the directory tree under which the CGI files are kept.
--- Example: $cgi="cgi-bin";

$sub="";
--- The sub-directory where the CGI files and all documents are located under 
--- Document Root. Default value is "yellowmaker". (e.g. public_html/yellowmaker, www/yellowmaker). Please 
--- use this default value. 
--- Example: $sub="yellowmaker";

$EmailFunction="";
--- Specify the type of method this program should send mail by.
--- Example: $EmailFunction="SendMail";

$SendMailLocation="";
--- Fill in the location of the sendmail program on your web server.
--- Example: $SendMailLocation="/usr/bin/sendmail"; 

TAKE NOTE:
Be sure to change the your name and password in Administrative Center to protect
your YellowMaker.


=================================================================================
STEP 4: REMOVE THE SETUP FILES
=================================================================================

Remove the "setup.pl", "setup2.pl" and "setup3.pl" files in CGI directory
after installation has been completed.

If you need to change any configurations after installation, you can login your 
Administrative Center:-
e.g. "http://your_domain_name/cgi-bin/yellowmaker/admin.pl"

Administrator: yellowmaker
Password: yellowmaker

NOTE: This option is not available in Free Edition.

Where is your business directory?
e.g. "http://your_domain_name/index.html"
e.g. "http://your_domain_name/cgi-bin/yellowmaker/index.pl"


=================================================================================
COMPLETED
=================================================================================
THANK YOU FOR USING YELLOWMAKER!
Please contact us at: support@yellowmaker.com if you have any enquiries about 
YellowMaker installation.
=================================================================================





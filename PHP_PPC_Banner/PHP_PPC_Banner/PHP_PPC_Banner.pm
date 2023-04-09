# ==================================================================
# Plugins::Banner - Auto Generated Program Module
#
#   Plugins::PHP_PPC_Banner
#   Author  : Andy Newby
#   Version : 1.1
#   Updated : Mon May  6 13:19:32 2002
#
# ==================================================================
#


package Plugins::PHP_PPC_Banner;

# ==================================================================

    use strict;
    use GT::Base;
    use GT::Plugins qw/STOP CONTINUE/;
    use Links qw/$CFG $IN $DB/;

# Inherit from base class for debug and error methods
    @Plugins::PHP_PPC_Banner::ISA = qw(GT::Base);

# Your code begins here! Good Luck!

# ADMIN MENU OPTIONS

# ===================================================================



sub Purchase {

# -------------------------------------------------------------------

# This subroutine will get called whenever the user clicks

# on 'Purchase' in the admin menu. Remember, you need to print

# your own content-type headers; you should use

#

   print $IN->header();

#

print qq|

<html>

<head>

<meta http-equiv="Content-Language" content="en-gb">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Ace PPC Banner Plugin &gt; FAQ</title>

</head>



<body>



<p align="center"><font face="Verdana" size="2"><b>Ace PPC (Pay Per Click)

Banner Script<br>

v1</b></font></p>

<p align="center"><font face="Verdana" size="2">Please send $50 to

<a href="mailto:webmaster\@ace-installer.com">webmaster\@ace-installer.com</a> via

email if you wish to use this plugin. </font></p>



<p align="center"><font face="Verdana" size="2">Remember, if people don't send

me any money, there is no incentive for me to write new plugins! <br>

I rely on you as much as you reply on me!</font></p>



</body>



</html>



|;



}

sub Readme {

# -------------------------------------------------------------------

# This subroutine will get called whenever the user clicks
# on 'Readme' in the admin menu. Remember, you need to print
# your own content-type headers; you should use
#
   print $IN->header();
#

print qq|



<html>



<head>

<meta http-equiv="Content-Language" content="en-gb">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>New Page 3</title>

</head>



<body>



<p align="center"><font face="Verdana" size="2"><b>Ace PPC (Pay Per Click)

Banner Script<br>

v1</b></font></p>

<p align="center"><font face="Verdana" size="2">First of all, please let me say

thank you for choosing our script. We hope it brings you lots of money and happy

advertisers. Please have a good read through of this manual first, before

attempting to install it. If you have any questions, please feel free to contact

us via the support forum (<a href="http://www.ace-installer.com/forum/">here</a>)

or email (<a href="http://www.ace-installer.com/support.php">here</a>).</font></p>

<p align="center"><font face="Verdana" size="2">&lt;&lt; <a href="#installing">

installing</a> &gt;&gt;&nbsp; &lt;&lt; <a href="#mysql">setting up mySQL</a> &gt;&gt;&nbsp; &lt;&lt;

<a href="#creating">creating advertisers</a> &gt;&gt;&nbsp; &lt;&lt; <a href="#advertisers">

advertiser statistics</a> &gt;&gt;<br>

&lt;&lt; <a href="#configuring">configuring the script</a> &gt;&gt;&nbsp; &lt;&lt;

<a href="#installing">including banners on your page</a> &gt;&gt; &lt;&lt; <a href="#tos">

TOS</a> &gt;&gt;</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="installing">

Installing</a></font></b></p>

<p align="center"><font face="Verdana" size="2">Simply follow the instructions

below to install Ace PPC Banner.</font></p>

<p align="center"><font face="Verdana" size="2">1) Upload all of the files to

the folder you want the scripts to be in. NOTE: Some servers wont let PHP script

run in the cgi-bin!</font></p>

<p align="center"><font face="Verdana" size="2">2) Now make sure that the

settings.inc.php file is CHMODed to 666 (UNIX only).</font></p>

<p align="center"><font face="Verdana" size="2">3) Then run install.php through

your web-browser, following the online instructions.</font></p>

<p align="center"><font face="Verdana" size="2">4) You should then be prompted

to goto admin.php, just follow the link.</font></p>

<p align="center"><font face="Verdana" size="2">5) Now simply enter your login

username/password that you just setup.</font></p>

<p align="center"><font face="Verdana" size="2">Everything else should be

explained below, or within the script on the appropriate pages.</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="mysql">Setting Up

MySQL</a></font></b></p>

<p align="center"><font face="Verdana" size="2">The most part of the SQL side of

this script is done by install.php. All you need to do is create a MySQL

database and add a username/password to it. Then run install.php (via the stages

above) and enter the MySQL information you have. If you are unsure of how to

create the database, your best resource is your hosts FAQ pages, or directly

emailing them about it.</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="creating">Creating

Advertisers</a></font></b></p>

<p align="center"><font face="Verdana" size="2">To create an advertiser first

log into admin.php. Then click on the very top link called 'Add Advertiser'. You

will then be given a load of boxes to complete. If you need help on any of the

field, just click on the [ help ] link next to it.</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="advertisers">

Advertiser Statistics</a></font></b></p>

<p align="center"><font face="Verdana" size="2">To let an advertiser view

his/her statistic, simply point them to your advertiser.php script. i.e

<a href="http://www.yoursite.com/banner/advertiser.php">

http://www.yoursite.com/banner/advertiser.php</a>. Their username is the email

address, and the password is what you set in the admin panel. In this version

they can see the impressions they have had, clicks made, credit left, and the

banners selected for their site.</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="including">Including</a></font></b></p>

<p align="center"><font face="Verdana" size="2">Adding a banner could not really

be much easier. You can use any of several methods. These are;</font></p>

<p align="center"><b><i><font face="Verdana" size="2" color="#FF0000">Links SQL

Call</font></i></b></p>

<p align="center"><font face="Verdana,Arial,Helvetica" size="2">Simply put &lt;%ppc_banner%&gt;

wherever you want the banner to appear.</font></p>

<p align="center"><b><i><font face="Verdana" color="#ff0000" size="2">PHP

Include</font></i></b></p>

<p align="center"><font face="Verdana" size="2">Simply put : &lt;?

include(&quot;/path/to/the/script/banner.php&quot;) ?&gt;. This will show the banner on a PHP

page.</font></p>

<p align="center"><b><i><font face="Verdana" color="#ff0000" size="2">IFRAME</font></i></b></p>

<p align="center"><font face="Verdana,Arial,Helvetica" color="black" size="2">

Put: </font></p>

<font FACE="Verdana" SIZE="2">

<p align="center">&lt;iframe src=&quot;</font><font face="Verdana,Arial,Helvetica" size="2">http://www.ace-clipart.com/directory/cgi/banner/banner.php</font><font FACE="Verdana" SIZE="2">&quot;

width=468 height=60 </font><font face="Verdana,Arial,Helvetica" size="2">

marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no</font><font FACE="Verdana" SIZE="2">&gt;&lt;/iframe&gt;<br>

&lt;ilayer src=&quot;</font><font face="Verdana,Arial,Helvetica" size="2">http://www.ace-clipart.com/directory/cgi/banner/banner.php</font><font FACE="Verdana" SIZE="2">&quot;

width=468 height=60&gt;&lt;/ilayer&gt;</p>

</font>

<p align="center"><font face="Verdana,Arial,Helvetica" size="2">Obviously you

need to change the URL within that code to reflect your site, and if using

banners smaller than 468x60 then also change width= and height=.</font></p>

<p align="center"><i><b>

<font face="Verdana,Arial,Helvetica" color="#ff0000" size="2">SSI</font></b></i></p>

<p align="center"><font face="Verdana,Arial,Helvetica" size="2">Some servers

will allow you to execute this script via SSI. Simply use something similar to

this to accomplish this (obviously change the path to the PHP script);</font></p>

<p align="center"><font face="Verdana,Arial,Helvetica" color="black" size="2">

&lt;!--#include virtual=&quot;/home/yoursite.com/public_html/cgi/banner/banner.php&quot; --&gt;</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana,Arial,Helvetica" size="2">

<a name="configuring">Configuring the settings</a></font></b></p>

<p align="center"><font face="Verdana,Arial,Helvetica" size="2">Editing the

settings for our script could not really be easier. All you need to do is log in

at admin.php with your current admin username/password (setup during the initial

install) and the click on the </font><font face="Arial" size="2">'Edit Settings'</font></p>

<p align="center"><font face="Verdana,Arial,Helvetica" size="2">You will then be

shown a selection of text boxes with values set in them. Simply edit these to

update your banner script settings in real time. Help is available for each item

by clicking on the 'help' link to the right of the description along each link.</font></p>

<p align="center">

--------------------------------------------------------------------</p>

<p align="center"><b><font face="Verdana" size="2"><a name="tos">TOS (Terms of

Service)</a></font></b></p>

<p align="center"><font face="Verdana" size="2">This script is provided 'as-is'

and Ace-Installer or any of its employees will not accept any responsibility if

any damages may occur on your website. This is in the form of lost time,

hardware failure, damaged files etc. If you do not agree to the above terms,

please delete this script and all related files from your computer and server,

and then get in touch with us for a refund. Please note, this refund can only

take place within 3 days of the purchase. </font></p>



</body>



</html>





|;



}

sub FAQ {

# -------------------------------------------------------------------

# This subroutine will get called whenever the user clicks

# on 'FAQ' in the admin menu. Remember, you need to print

# your own content-type headers; you should use
#
   print $IN->header();
#



print qq|



<html>



<head>

<meta http-equiv="Content-Language" content="en-gb">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Ace PPC Banner Plugin &gt; FAQ</title>

</head>



<body>



<p align="center"><font face="Verdana" size="2"><b>Ace PPC (Pay Per Click)

Banner Script<br>

v1</b></font></p>

<p align="center"><font face="Verdana" size="2">As questions are asked more

frequently, I'll add some FAQ's here ;)</font></p>



</body>



</html>



|;



}

#- send them to the admin panel...

sub Admin {

#------------------------------------------



my $url = "$CFG->{admin_root_url}/../banner/admin/admin.php";

print "Location: $url \n\n";

}



# Always end with a 1.
1;
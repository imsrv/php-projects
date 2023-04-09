// mAd - Advert Rotation Manager //

// Version 0.5                   //
// 30th January 2005             //

// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //


LICENCE
=======
* This program is provided under the agreement that it is used for the
  display of rotating image links on a website.
* It may be used to profit by using it as a tool to display advertisements.
* It must not be repackaged or provided under another name; displayed as being
  made by another person or group, or sold for profit.
* You must not remove the legal message on the index.php program file.
* You may remove the legal message in any pages where the skin can be edited
  using the index.php program file. You may not, however, use a different name
  for this script, or give the impression that it was created by yourself.
* You install this program at your own risk, and you agree not to hold Ian
  Bennett liable to any damage incurred by using it.
* Support is not provided, however there is a support forum at
  http://www.w00ty.com/forum where you can get help.
* You can edit the script to suit your own purposes, providing this does not
  break any of the other rules specified in the Licence.
* You can not provide an edited version of the program, and I ask that anyone
  who wishes to provide mAd on their Website not only contact me so I can
  inform them of new releases, but also not host the install pack(s) on their
  own site. Please link to http://www.w00ty.com/mad/latest.php instead.
* If you agree to the terms, then feel free to install and use mAd.


INTRO
=====
mAd is a web-based program for maintaining a number of adverts on a
website, when you want one image advert on the screen. Every time the page, or
pages, load, mAd will select an ad from the database, and show it along with
it linking to wherever you want it to.

mAd also keeps track of how many times each ad has been shown, and how many
times they've been clicked on by your site visitors. These figures are
freely available on a stats page, which you can edit to suit your own site
design.

Version 0.5 improves on advert inclusion by allowing the Webmaster to choose
between the PHP inclusion used in previous versions, or alternatively using
Javascript or inline frame solutions if the display page is not PHP-enabled.
mAd should now work on servers with register_globals disabled, and v0.5 also
includes a fix for a small bug which disabled the statistics page on servers
with short_open_tags disabled.

This automatic installer allows you to either install a new copy of mAd; or
to update an existing installation. If you are updating, the version you are
updating must be 0.4 - if you have an earlier version use the appropriate
install pack(s) to update to 0.4 before using this one.

A manual install pack is available as an alternative to using this pack. It
will install a new copy or update 0.4 to 0.5 as the automatic installer does.
It is available at http://www.w00ty.com/mad/mad_0_5_manual.zip.


REQUIREMENTS
============
To use mAd, you must first have webspace capable of parsing PHP (this script
was developed using versions 4.3.4, 4.3.9 and 4.3.10; but other versions
should work fine). You must also have a MySQL database to store ad data in.
This program uses one MySQL table.


INSTALLATION
============

Install mAd from scratch -
1: Create a folder in your webspace for mAd, and name it whatever you like.
2: You may be able to skip this step depending on the server's setup - Windows
   servers and some Unix servers do not require this -
   Make sure the CHMOD setting (sometimes called permission settings) of this
   folder is at one of these settings (different wordings of the same setting):
   755
   rwxr--r--
   Owner: read, write, execute; Group: read; World: read
3: Upload the install.php file into this folder.
4: Open your browser and go to the URL where the install.php file is.
5: Type the username and password you want to log into mAd with, into the first
   two text boxes. Your password will not be visible as you type it in.
6: In the second set of text boxes, insert the information you insert to use
   your MySQL database. The host name is usually "localhost" (the same server);
   the database is the name of the database you're using; and the username and
   password are the ones you use to log in to the database.
7: Once you are sure your information is correct, click the "Continue with
   installation" button.
8: A results page will appear telling you whether the installation was
   completed successfully. If not, check your settings and try again. If it
   continues to fail, you may have to use the manual installer instead.
9: Point your browser to the folder you uploaded the installer, where mAd
   should be installed, and log in.

Update to v0.5 from an earlier v0.4 installation -
1: Make sure the CHMOD setting (sometimes called permission settings) of the
   folder you installed mAd in is 755 (see above for other wordings). Again,
   you may be able to skip this step.
2: Upload the install.php file into the folder you installed mAd in.
3: Open your browser and go to the URL where the install.php file is.
4: Click the "Update from v0.4" link, then click the "Continue with update"
   button.
5: A results page will appear telling you whether the update was completed
   successfully.
6: Use mAd as usual.


USAGE
=====
Instructions on the usage of mAd are in the program itself.


REVISION LOG
============
0.1.1 (##/##/03): First version.

0.2 (##/##/03): Fixed:
                Security fix.

0.3 (18/12/03): Added:
                Skinning options
                Individual stats pages with password protection.
                Customisable stat values.

0.4 (16/04/04): Added:
                Option to use your own selection process in PHP before calling
                include.php.
                2 new selection methods; 3 to choose from.
                Support for inline frame ads and Shockwave Flash.
                Admin can now view public stats page while stats protection is
                switched on.

                Fixed:
                Improved security in statistics.
                Config file inclusion fix - if all pages worked in a previous 
                version there will be no difference.
                Statistics skin code "extra lines" bug fixed.
                Login now encrypted.
                Some code more effective.
                Edited program options editing process.
                Unclosed mAd status iframe fixed.
                Skin option text-areas thinner.

0.5 (30/01/05): Added:
                Option to use PHP, Javascript or inline frames to call
                include.php.

                Fixed:
                Short open tag in stats.php made full.
                Now works in register_globals-disabled environment.

                Updated:
                Legal area updated to show 2003-2005 copyright.


===================================
mAd copyright Ian Bennett 2003-2005
#!/usr/local/bin/perl

#####################################################################
# e-Classifieds(TM)
# Copyright © Hagen Software Inc. All rights reserved.
#
# By purchasing, installing, copying, downloading, accessing or otherwise
# using the SOFTWARE PRODUCT, or by viewing, copying, creating derivative
# works from, appropriating, or otherwise altering all or any part of its
# source code (including this notice), you agree to be bound by the terms
# of the EULA that accompanied this product, as amended from time to time
# by Hagen Software Inc.  The EULA can also be viewed online at
# "http://www.e-classifieds.net/support/license.html"
#####################################################################

# Name: autonotify.pl
# Version: 3.0
# Last Modified: 5-31-99 by Philip A. Hagen

# This program should be installed in the same directory that your main
# classifieds program (CLASSIFIEDS.CGI) is installed.
# Its permissions should be set to 755.

# This program is an addon to the Classified Ads program that automatically
# notifies users who have signed up for the Auto-Notify feature about new ads
# that match the search criteria that they previously specified.  To run
# automatically, this program requires access to Unix cron
# jobs.

# To run this program automatically as a Unix cron job, you should edit your
# Unix crontab file to run each of these scripts
# sometime late at night.  If you aren't sure how to edit your Unix crontab
# file, try typing "man crontab" and/or "man cron" from your Telnet prompt.
# Information is also available over the Internet, or you may want to ask
# your system administrator, as this can vary on different systems.

# The program also checks to make sure that it has not been run in the past
# 23 hours and 45 minutes or so.  That way, no one can accidentally (or
# intentionally) run this program and cause it to send multiple e-mail
# notices to your users.

# You need to edit one variable in this program, which is $path_to_classifieds_program
# variable below.  You need to edit this variable to list the full internal
# server path to the CLASSIFIEDS.CGI file on your server.  This is true for both
# Unix and Windows NT users.

# If you wish to run this program directly from your web browser, as opposed
# to through a Unix cron job or manually from a Telnet prompt, then you should
# change the $noheader variable below to "off", and you need to set the
# $form_data{'print_html_response'} variable below equal to "on".

$path_to_classifieds_program = "/usr/www/you/cgi-bin/classifieds/classifieds.cgi";

$noheader = "on";
$form_data{'print_html_response'} = "off";
$form_data{'autonotify_button'} = "on";

$path = $path_to_classifieds_program;
$path =~ s/\\\\/\\/g;
$path =~ s/\\/\//g;
$path =~ s/(\/)(\w*)(\.*)(\w+)$//g;

# $path = "/usr/www/users/you/cgi-bin/classifieds";

unless ($path =~ /\//) { 
print "Content-type: text/html\n\n";
print qq~<h1>Path Error</h1>~;
exit; }

require "$path_to_classifieds_program";

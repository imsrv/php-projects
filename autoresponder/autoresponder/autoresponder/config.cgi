#!/usr/bin/perl

##############################################################################
# Autoresponder Unlimited 2.0                                                #
# Copyright 2002 The 29th Floor Enterprise                                   #
# Last modified 09/01/2002                                                   #
# Authors: Tess Rupprecht                                                    #
# Available at http://www.autoresponderunlimited.com                         #
##############################################################################
# COPYRIGHT NOTICE                                                           #
# Copyright 2003 The 29th Floor Enterprise . All Rights Reserved.            #
#                                                                            #
# This script can be used as long as you don't change this                   #
# header or any of the parts that give me credit for writing this.           #
#                                                                            #
# By using this script you agree to indemnify me from any liability          #
# that might arise from its use.                                             #
#                                                                            #
# Redistributing\selling the code for this program without prior written     #
# consent is expressly forbidden.                                            #
#                                                                            #
# Use for any unauthorized purpose is expressly prohibited by law,           #
# and may result in severe civil and criminal penalties.                     #
# Violators will be prosecuted to the maximum extent possible.               #
#                                                                            #
#         YOU MAY NOT RESELL OR RELEASE THIS PROGRAM TO OTHERS               #
#                  IT IS FOR YOUR PERSONAL USE ONLY.                         #
#                                                                            #
##############################################################################

sub configure {

#################################################################
#                  CHANGE ONLY THESE VARIABLES:                 #
#################################################################

# Type the URL address of the ar.cgi. 
# Replace ONLY www.yourdomain.com to yourdomain or URL address.

$scriptpath="http://www.yourdomain.com/cgi-bin/autoresponder/ar.cgi";

$htmlpath="http://www.yourdomain.com/html";

$imgpath="http://www.yourdomain.com/html/img";


# Type the full path to your EMail program.
# If you're not sure of this, ask your server administrator

$mailprog="/usr/sbin/sendmail";

# Type your email address.  Make sure
# to place a \ in front of the @
# As an example:  admin\@autoresponderunlimited.com

$fromaddr="admin\@autoresponderunlimited.com";

# This is the file that will hold all of the email addresses and names
# of all of your autoresponders. Change it to something more secretive.

$mbase = "collect.txt";

# Type default name. If the system is unable to extract
# the prospect's name, it will print the Default Name.

$emptyuname="Friend";

# Enter the Admin password (case sensetive 8 chars max)

$password="password";


}
1;


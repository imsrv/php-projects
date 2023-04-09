#!/usr/bin/perl

############################################
##                                        ##
##        Account Manager User Signup     ##
##          by CGI Script Center          ##
##     (e-mail cgi@cgiscriptcenter.com)   ##
##                                        ##
##              version:  1.030           ##
##        last modified:  08/23/2000      ##
##        copyright (c) 1998 - 2000       ##
##                                        ##
##    latest version is available from    ##
##     http://www.cgiscriptcenter.com     ##
##                                        ##
############################################
#
# Copyright 1998 Elite Host.  All Rights Reserved.
#
# TERMS OF USE 
# 1. Account Manager is for licensed customers
# only. Customer may use Account Manager as many
# times as customer wishes, as long as customer owns or runs the web
# site that Account Manager is installed on.  Account
# Manager may not under any circumstances be sold
# or redistributed without the written consent of CGI Script Center and 
# its owner Diran Alemshah.
#
# 2. CGI Script Center, at its own discresion, will decide if any terms 
# of the this agreement have been violated by customer. Upon written e- 
# mailed notification to Customer of Terms of Use violations, CGI
# Script Center may revoke customer's license to use Account Manager.
# In that event, Customer agrees to any and all of the following:
#
# a) Customers found in violation of this agreement, found reselling or
# redistributing Account Manager, or making 
# Customers Members Area ID and password public to anyone in any 
# manner will forfeit their Members area password and all rights to 
# future versions of Account Manager.
# 
# b). Customer will no longer be licensed to run any version of 
# Account Manager. 
#
# Indemnification
# 1. Customer agrees that it shall defend, indemnify, save and hold
# CGI Script Center, Elite Web Design and marketing, and any
# persons affiliated with either company, harmless from any and all
# demands, liabilities, losses, costs and claims, including reasonable
# attorney's fees asserted against CGI Script Center, its agents, its
# customers, officers and employees, that may arise or result from any
# service provided or performed or agreed to be performed or any product 
# sold by customer, its agents, employees or assigns. Customer agrees to 
# defend, indemnify and hold harmless CGI Script Center, its # agents,  
# its cusomters, officers, and employes,against
# liabilities arising out of; a) any injury to person or property caused 
# by an products sold or  otherwise distributed in connection with CGI
# Script Center products; (b) any material supplied by customer
# infringing or allegedly infringing on the proprietary rights of a
# third party; c) copyright infringement and (d) any defective products 
# sold to customer from CGI Script Center products.
#
# This program may not be distributed in whole or part, freely, for pay, 
# or any other form of compensation.
#
##############################################################
# EDIT USER CONFIGURATIONS BELOW
##############################################################
# EDIT BELOW
#################################################################
## This is the only line in this script that requires editing.
## Enter the full directory path to your config.pl file between
## The quotation marks.
## Example: require "c:/full/directory/path/to/config.pl";

require "/full/directory/path/to/config.pl";

# Save the file and do the same for the other files.
##############################################################
# DO NOT EDIT BELOW THIS LINE
##############################################################

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
      $value =~ s/<!--(.|\n)*-->//g;
}

$version = "1.030";

$cgiurl = $ENV{'SCRIPT_NAME'};

if ($INPUT{'find'}) { &find; } ######### Will search for member info.
if ($INPUT{'process'}) { &sorder; } 
#elsif ($INPUT{'order'}) { &order; }
#elsif ($INPUT{'sorder'}) {&sorder; } 
else {&sorder;}############# IF no button was pressed, run just as 
exit;


sub sorder {

unless ($INPUT{'agree'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>You Must Agree.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">In order for us to process your request, you must check the box marked <B>"I agree to the above"</B> on our order form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


unless ($INPUT{'fname'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your First Name.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your first name</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'lname'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Last Name.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your last name</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'address'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Address.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your address</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'city'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your City.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your city</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'state'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your State.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your state</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


unless ($INPUT{'zip'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Zip Code.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your ZIP or Postal Code</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'country'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Country.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your Country</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}




unless ($INPUT{'phone'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Phone Number.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your phone number</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

$INPUT{'email'} =~ s/\s//g;

unless ($INPUT{'email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $INPUT{'email'} !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
        } else {
         $legalemail = 0;
        }


if ($legalemail !~ 1) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your E-Mail Address.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your E-mail address</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


unless ($INPUT{'payment'}) {
    print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Form of Payement.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your form of payment</B> in our service request form.  Check the circle for Credit Card or Check purchase.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

if (($INPUT{'acctlength'}) && ($INPUT{'acctlength'} =~ /choose one/i)) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Choice of Account Length.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to choose the <B>length of your account</B> in our service request form.  Select from our drop down box which account length you would like.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


if ($INPUT{'payment'} eq "cc") {
   if ($INPUT{'creditcards'} =~ /Choose One/) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Credit Card Choice.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your credit card choice</B> in our service request form.  Select from our drop down box which credit card you would like to use.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'nameoncard'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Name on Card.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>the name on your credit card</B> in our service request form.  Please enter the full name that appears on your cedit card.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

###### CC verifier 2 modified start

if($INPUT{'cardnumber'}) {

    &CC_Verify;

} else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter the Card Number.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>the number on your credit card</B> in our service request form.  It is not necessary to enter spaces between any numbers.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

####### CC verifier 2 modified end

unless ($INPUT{'exp'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter the Expiration Date.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>the expiration date on your credit card</B> in our service request form.  This should appear as MONTH/YEAR.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'billingaddress'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter the Billing Address.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>the billing address of your credit card</B> in our service request form.  This informatin is required by most credit card companies for online purchases.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'ccity'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your City.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your city</B> in our service request form.  This is required for most online credit card purchases.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

unless ($INPUT{'cstate'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your State.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your state</B> in our service request form.  This is required for most online credit card purchases.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


unless ($INPUT{'czip'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your Zip Code.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your ZIP or Postal Code</B> in our service request form. This is required for most online credit card purchases.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}




}

&add;

sub close {

open (FILE,"$memberinfo/email.txt"); #### Full path name from root.
@closing  = <FILE>;
close(FILE);

 open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 
 
    print MAIL "To: $INPUT{'email'}\n";
    print MAIL "From: $orgmail($orgname)\n";
    print MAIL "Subject: $sign_up_response\n";
    print MAIL "-" x 75 . "\n\n";
    
                            
    foreach $line(@closing) {
    $line =~ s/<FIRST_NAME>/$INPUT{'fname'}/g;
    $line =~s/<LAST_NAME>/$INPUT{'lname'}/g;
    $line =~ s/<USERNAME>/$INPUT{'username'}/g;
    $line =~s/<PASSWORD>/$INPUT{'pwd'}/g;
    $line =~s/<ORGNAME>/$orgname/g;
    $line =~s/<ORGMAIL>/$orgmail/g;
    }
                       
    foreach $line(@closing) {
    print MAIL "$line";
    }
    print MAIL"\n\n";
    close (MAIL);

      
 

              

#################################################################
## MAIL BACK TO ADMIN ###########################################
#################################################################

open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 
 
    print MAIL "To: $orgmail\n";
    print MAIL "From: $INPUT{'email'} ($INPUT{'fname'} $INPUT{'lname'})\n";
    print MAIL "Subject: Account Manager Form Response\n";
    print MAIL "-" x 75 . "\n\n";
    
    print MAIL "Customer Information\n";
    print MAIL "-" x 75 . "\n\n";
    print MAIL "Name: $INPUT{'fname'} $INPUT{'lname'}\n";
    print MAIL "Address: $INPUT{'address'}\n";
    print MAIL "Address2: $INPUT{'address2'}\n";
    print MAIL "City: $INPUT{'city'}\n";
    print MAIL "State: $INPUT{'state'}\n";
    print MAIL "Zip: $INPUT{'zip'}\n";
    print MAIL "Phone: $INPUT{'phone'}\n";
    print MAIL "Email: $INPUT{'email'}\n\n";
    

if ($INPUT{'payment'} eq "cc") {
$INPUT{'payment'} = "Credit Card";
}


    print MAIL "Payment Information\n";
    print MAIL "-" x 75 . "\n\n";
    print MAIL "Form of Payment: $INPUT{'payment'}\n";

if ($INPUT{'creditcards'}) {
    print MAIL "Credit Card: $INPUT{'creditcards'}\n";
}

if ($INPUT{'nameoncard'}) {
    print MAIL "Name on Card: $INPUT{'nameoncard'}\n";
}

if ($INPUT{'cardnumber'}) {
    print MAIL "Card Number: $INPUT{'cardnumber'}\n";
}

if ($INPUT{'exp'}) {
    print MAIL "Expiration: $INPUT{'exp'}\n";
}

if ($INPUT{'billingaddress'}) {
    print MAIL "Billing Address: $INPUT{'billingaddress'}\n";
}

if ($INPUT{'billingaddress2'}) {
    print MAIL "Billing Address2: $INPUT{'billingaddress2'}\n";
}

if ($INPUT{'city'}) {
    print MAIL "City: $INPUT{'ccity'}\n";
}

if ($INPUT{'state'}) {
    print MAIL "State: $INPUT{'cstate'}\n";
}

if ($INPUT{'zip'}) {
    print MAIL "Zip: $INPUT{'czip'}\n\n";
}



    print MAIL "Purchase Information\n";
    print MAIL "Account: $account_name\n";
    print MAIL "Account Setup: \$$setup\n";
    print MAIL "Account Monthly: \$$monthly\n";
    if ($INPUT{'acctlength'}) {
    print MAIL "Account Length: $INPUT{'acctlength'} days\n";
    }





    close (MAIL);

      
 


unless ($redirect) { 
        
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Success!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your $orgname account information has been sent to the site administrators.  You should receive a response shortly.  Thank you for your interest.</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail">$orgname Support</A> if you
need any further assistance.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER> 
</TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

print "Location: $redirect\n\n";
exit;


}

}

sub checkaddress {

$INPUT{'email'} =~ s/\s//g;

unless ($INPUT{'email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $INPUT{'email'} !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
        } else {
         $legalemail = 0;
        }


if ($legalemail !~ 1) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Please Enter Your E-Mail Address.</FONT></B></P></CENTER>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please don't forget to enter <B>your E-mail address</B> in our service request form.</FONT></P>
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further
assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname
maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}
}

sub find {

&checkaddress;

# Open member database, read info
open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
 close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
&parseemail;
# if ($edit_array[2] =~ /$INPUT{'email'}/i) {last; }

if ($edit_array[2] eq $email) {last; }

}

# unless ($edit_array[2] =~ /$INPUT{'email'}/i) {

unless ($edit_array[2] eq $email) {
print "Content-type: text/html\n\n";
&header;
print "<CENTER><BR><TABLE
BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Not Found!</FONT></B></P><P><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Your $orgname account information was not found in our database.  Please make sure that you used the same email address that you created your account with.</FONT></P><P><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please contact <A
HREF=\"mailto:$orgmail\">$orgname Support</A> for your account information.</FONT></P><HR
SIZE=\"1\"><CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
} 

print "Content-type: text/html\n\n";
&header;
print "<CENTER><BR><TABLE
BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Success!</FONT></B></P><P><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Your $orgname account information has been emailed to you at: $INPUT{'email'}.</FONT></P><P><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please contact <A
HREF=\"mailto:$orgmail\">$orgname Support</A> if you need any further assistance.</FONT></P><HR
SIZE=\"1\"><CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;

# Output a temporary file

open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 
    
    print MAIL "To: $edit_array[2]\n";
    print MAIL "From: $orgmail ($orgname Support)\n";
    # Check for Message Subject
    print MAIL "Subject: $orgname Account Information\n\n";
    #Date
    print MAIL "$date\n";
    

    print MAIL "-" x 75 . "\n\n";

    print MAIL "You requested your $orgname account information:\n\n";

    print MAIL "Your $orgname User ID is: $edit_array[0]\n";
    print MAIL "Your $orgname password is: $edit_array[1]\n\n";

    print MAIL "please contact $orgname support at: $orgmail\n";
    print MAIL "if you have any questions.\n\n";

    print MAIL "$orgname Support Team\n";    

    close (MAIL);
 

        
exit;

}

sub add {

unless ($INPUT{'username'}) {
print "Content-type: text/html\n\n";
&header;
print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
<FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account
Manager:</FONT><BR>Account Information Input Form</FONT><BR><BR>
<TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><B>Username
Error!  No Username</B></FONT><BR><BR><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please go back and a Username.</FONT></TD></TR><TR><TD COLSTART=\"1\"><HR SIZE=\"1\">
<CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER> </TD></TR></ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
    }

if ($INPUT{'username'} =~ /\s/) {
print "Content-type: text/html\n\n";
&header;
print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
<FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account
Manager:</FONT><BR>Account Information Input Form</FONT><BR><BR>
<TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" COLOR=\"$fontcolor\" FACE=\"verdana, arial, helvetica\"><B>Username
Error!  Username Contains a Space</B></FONT><BR><BR><FONT
SIZE=\"-1\" COLOR=\"$fontcolor\" FACE=\"verdana, arial, helvetica\">Please go back and enter a Username without spaces.  If you would like to use a multi-word Username, be sure to use an underscore ( _ ).</FONT></TD></TR><TR><TD COLSTART=\"1\"><HR SIZE=\"1\">
<CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER> </TD></TR></ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
    }

if ($INPUT{'username'} eq $INPUT{'pwd'}) {

print "Content-type: text/html\n\n";
&header;
print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
<FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account Manager:</FONT><BR>  Account Information Input Form</FONT><BR><BR>
<TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" COLOR=\"$fontcolor\" FACE=\"verdana, arial, helvetica\"><B>Password Error!  Same as Username</B></FONT><BR><BR><FONT
SIZE=\"-1\" COLOR=\"$fontcolor\" FACE=\"verdana, arial, helvetica\">You must chose a Password other than your Username, for security considerations.  Please return and enter another password.</FONT></TD></TR>

</ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
}

unless ($INPUT{'pwd'} eq $INPUT{'pwd2'} && $INPUT{'pwd'} && $INPUT{'pwd2'} ){

print "Content-type: text/html\n\n";
&header;
print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
<FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account
Manager:</FONT><BR>Account Information Input Form</FONT><BR><BR>
<TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><B>Password
Error!  Password Mismatch</B></FONT><BR><BR><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please go back and re-enter your
password choice.</FONT></TD></TR><TR><TD COLSTART=\"1\"><HR SIZE=\"1\">
<CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER> </TD></TR></ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
    } 


if (-e "$memberinfo/amdata.db") {

open (MEMBER, "<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(MEMBER, $LOCK_EX); #Locks the file
	}
@database_array = <MEMBER>;
 close (MEMBER);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
    
&parseusername2;

#    if ($edit_array[0] eq $INPUT{'username'}) {last; }

if (($edit_array[0]) && ($edit_array[0] eq $desiredname)) {last; }
    
}

$INPUT{'username'} =~ s/\W.*//;
# if ($edit_array[0] eq $INPUT{'username'}) {

if (($edit_array[0]) && ($edit_array[0] eq $desiredname)) {

print "Content-type: text/html\n\n";
&header;
print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
<FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account Manager:</FONT><BR>User Name Taken</FONT><BR><BR>
<TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><B>User Name Error!  User Name Taken</B></FONT><BR><BR><FONT
SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">The User Name you have selected is already in use by another user.  Please return and enter another user name.</FONT></TD></TR>
<TR><TD COLSTART=\"1\"><HR SIZE=\"1\">
<CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
</CENTER></TD></TR></ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
&footer;
exit;
}


# open (MEMBER, "<$memberinfo/amdata.db");
# if ($LOCK_EX){ 
#      flock(MEMBER, $LOCK_EX); #Locks the file
#	}
# @database_array = <MEMBER>;
# close (MEMBER);

# foreach $lines(@database_array) {
#           @edit_array = split(/\:/,$lines);
#    if ($edit_array[1] eq $INPUT{'pwd'}) {last; }
    
# }

# if ($edit_array[1] eq $INPUT{'pwd'}) {

# print "Content-type: text/html\n\n";
# &header;
# print "<CENTER><TABLE BORDER=\"0\" WIDTH=\"450\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
# ><TD ALIGN=\"CENTER\" COLSTART=\"1\">     
# <FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><FONT COLOR=\"#FF0000\">Account
# Manager:</FONT>  Account Information Input Form</FONT><BR><BR>
# <TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
# ALIGN=\"LEFT\" COLSTART=\"1\"><FONT SIZE=\"+1\" FACE=\"verdana, arial, helvetica\"><B>Password Error!  Password Taken</B></FONT><BR><BR><FONT
# SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">The password you have selected is already in use by another user.  Please return and enter another password.</FONT></TD></TR>
# <TR><TD COLSTART=\"1\"><HR SIZE=\"1\">
# <CENTER><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\"> $orgname is maintained with  <A
# HREF=\"http://cgi.elitehost.com\"><B>Account Manager $version</B></A></FONT>
# </CENTER></TD></TR></ROWS></TBODY></TABLE></TD></TR></ROWS></TBODY></TABLE></CENTER>";
# &footer;
# exit;
# }

}
&dupeaddress;
&dupeaddress2;
&usertemp;
# &dupepwd;
&temp;
exit;
}



sub ibill {
$found = 0;

open(WEB,"<$webfile");

if ($LOCK_EX){ 
      flock(WEB, $LOCK_EX); #Locks the file
	}
@web_array = <WEB>;
 close (WEB);


foreach $weblines(@web_array) {
chomp($weblines);


if ($weblines eq $INPUT{'ibillpincode'}) {
  open (WEB,">$webfile");
  $found = 1;
  if ($LOCK_EX){ 
      flock(WEB, $LOCK_EX); #Locks the file
	}

  foreach $weblines(@web_array) {
  chomp($weblines);
  
  if ($weblines ne $INPUT{'ibillpincode'}) {
  print WEB "$weblines\n";
  
  
    }
   } 
  close (WEB);
 } 
} 

unless ($found == 1) {

if ($Idenyurl) {
print "Location: $Idenyurl\n\n";
exit;
} else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR> <TABLE BORDER="0" WIDTH="400"><SQTBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN="CENTER" COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Account Manager</FONT> Status:<BR> Account Already in Use!</FONT></B></P></TD></TR><TR><TD COLSTART="1"><P><FONT SIZE="-1" FACE="verdana, arial, helvetica">It appears that this account has already been created, based on our records.</FONT></P> <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you feel that this information is in error, please contact <A HREF="mailto:$orgmail"><B>$orgname Support</B></A> if you need any further assistance.</FONT></P> <HR SIZE="1"> <CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with <A HREF="http://www.cgiscriptcenter.com/" TARGET="_blank">Account Manager $version</A></B></FONT> </CENTER></TD></TR></ROWS></SQTBODY></TABLE></CENTER>
EOF
&footer;
exit;
}
 }
}





sub usertemp {


opendir (DIR, "$memberinfo"); 
@file = grep { /.infotmp/} readdir(DIR);
foreach $lines(@file) {
 $lines =~ s/\W.*//;

&parseusername;

if ($lines eq $desiredname) {

# if ($lines =~ /$INPUT{'username'}\b/i) {
print "Content-type: text/html\n\n";
&header; 
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Username Taken!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Username: $INPUT{'username'} has already been reserved by someone awaiting membership</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please choose another Username.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
  exit;   
    
}
}
}

sub dupeaddress {
#print "Content-type: text/html\n\n";
open (EMAIL, "<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(EMAIL, $LOCK_EX); #Locks the file
	}
@database_array = <EMAIL>;
 close (EMAIL);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
&parseemail;

if ($edit_array[2] eq $email) {

# if ($edit_array[2] =~ /$INPUT{'email'}/i) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Address Taken!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The E-mail address: $INPUT{'email'} is already in our database. </FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail"><B>$orgname Support</B></A> if you
need any further assistance.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}
}
}

sub dupeaddress2 {


opendir (DIR, "$memberinfo");
close (DIR); 
@file = grep { /.infotmp/} readdir(DIR);
 foreach $lines(@file) {

       open (DAT, "<$memberinfo/$lines");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
             @approval = <DAT>;
                foreach $item(@approval) {
                    @edit_approval = split(/\:/,$item);
                  
&parseemail;                 

if ($edit_approval[2] eq $email) {last; }

# if ($edit_approval[2] =~ /$INPUT{'email'}/i) {last; }
}

if ($edit_approval[2] eq $email) {

# if ($edit_approval[2] =~ /$INPUT{'email'}/i) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Address Taken!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The E-mail address:
$INPUT{'email'} was found in use by someone awaiting membership.</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail"><B>$orgname Support</B></A> if you need any further
assistance.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname
maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
#close (DIR);
exit;

}
}
}

sub dupepwd {


opendir (DIR, "$memberinfo");
close (DIR); 
@file = grep { /.infotmp/} readdir(DIR);
 foreach $lines(@file) {

       open (DAT, "<$memberinfo/$lines");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
             @approval = <DAT>;
                foreach $item(@approval) {
                    @edit_approval = split(/\:/,$item);
                  
 if ($edit_approval[1] eq $INPUT{'pwd'}) {last; }
}

if ($edit_approval[1] eq $INPUT{'pwd'}) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Address Taken!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Password you chose has already been requested by a new prospective user.  Please choose another.</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail"><B>$orgname Support</B></A> if you need any further
assistance.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname
maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
#close (DIR);
exit;

}
}
}


######################################
# Create temp files for Admin approval
######################################

sub temp {

# First, seed the random number generator
	srand;

	# Then get a random # for which a file name can be created
	$randNum = int(rand(999999));

      

if (($INPUT{'accounts'} !=~ /choose one/i) && ($INPUT{'accounts'} eq one)) {

if ($IBILL) {
$webfile = $act1pincodes;
&ibill;
}

# print "Content-type: text/html\n\n";
# print "Accounts = $INPUT{'accounts'}<BR>";
# exit;

$account_name = $account_one; 
$setup = $setup_one;
$monthly = $monthly_one;
$length = $lengthone;
}

if (($INPUT{'accounts'} !=~ /choose one/i) && ($INPUT{'accounts'} eq two)) {

if ($IBILL) {
$webfile = $act2pincodes;
&ibill;
}
$account_name = $account_two; 
$setup = $setup_two;
$monthly = $monthly_two;
$length = $lengthtwo;
}

if (($INPUT{'accounts'} !=~ /choose one/i) && ($INPUT{'accounts'} eq three)) {

if ($IBILL) {
$webfile = $act3pincodes;
&ibill;
}
$account_name = $account_three; 
$setup = $setup_three;
$monthly = $monthly_three;
$length = $lengththree;
}




#$setup = $one_setup + $two_setup;
#$monthly = $one_monthly + $two_monthly;

$INPUT{'username'} =~ s/\W.*//;


$INPUT{'fname'} =~ s/\s+$//;
$INPUT{'lname'} =~ s/\s+$//;


$newline2 = join
("\:",$INPUT{'username'},$INPUT{'pwd'},$INPUT{'email'},$INPUT{'fname'},$INPUT{'lname'},$setup,$monthly,$INPUT{'payment'},$INPUT{'creditcards'},$INPUT{'nameoncard'},$INPUT{'cardnumber'},$INPUT{'exp'},$INPUT{'billingaddress'},$INPUT{'billingaddress2'},$INPUT{'city'},$INPUT{'state'},$INPUT{'zip'},$INPUT{'lbill'},$INPUT{'papplied'},$INPUT{'aapplied'},$INPUT{'tbalance'},$INPUT{'tnew'},$INPUT{'tcharges'},$INPUT{'nnew'},$INPUT{'linvoice'},$INPUT{'taxes'},$INPUT{'ccity'},$INPUT{'cstate'},$INPUT{'czip'},$length,$INPUT{'address'},$INPUT{'address2'},$INPUT{'phone'},$INPUT{'country'},$INPUT{'ibillpincode'},$INPUT{'ibilltransnumber'},$INPUT{'ibillrebill'},0);
$newline2 .= "\n";



open(TEMP2, ">$memberinfo/$INPUT{'username'}.infotmp") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(TEMP2, $LOCK_EX); #Locks the file
	}
print TEMP2 $newline2;
close (TEMP2);

       if ($instantaccess == 1) {

open (FILE, "<$memberinfo/$INPUT{'username'}.infotmp");
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
      @approved = <FILE>;
      close (FILE);
      foreach $item(@approved) {
             
         open(DATABASE, ">>$memberinfo/amdata.db") or print"unable to create access temp file";
         if ($LOCK_EX){ 
      flock(DATABASE, $LOCK_EX); #Locks the file
	}
         chomp($item);
         print DATABASE "$item\n";

           if ($htaccess == "1") {
           open (DAT2, "<$memberinfo/$INPUT{'username'}.infotmp");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	} 
           @second = <DAT2>;
           close (DAT2);
                foreach $item(@second) {
                @edit_second = split(/\:/,$item);
                chop ($edit_second[1]) if ($edit_second[1] =~ /\n$/);
		    $newpassword = crypt($edit_second[1], aa); 
                open(PASSWD, ">>$memaccess") or print"unable to create access temp file";
                print PASSWD "$edit_second[0]:$newpassword\n";
   }

close (PASSWD);


 }
close (DATABASE);
}

open (FILE, "<$memberinfo/$INPUT{'username'}.infotmp");
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
       @approved = <FILE>;
       close (FILE);
       foreach $item(@approved) {

             @edit_approved = split(/\:/,$item);      


## Create Customer Billing Statement

if ($payment == 1) {
open (STATEMENT, ">$memberinfo/$edit_approved[0]statement.txt");
if ($LOCK_EX){ 
      flock(STATEMENT, $LOCK_EX); #Locks the file
	}
print STATEMENT "Customer Billing Statement - Created: $date2\n";
print STATEMENT "For $edit_approved[3] $edit_approved[4]\n";
print STATEMENT "=" x 75 . "\n\n";
print STATEMENT "$date2\n";
print STATEMENT "USER ID:              $edit_approved[0]\n";
  if ($edit_approved[7] eq "cc") {
print STATEMENT "Billing Address:      $edit_approved[12]\n";
              if ($edit_approved[8]) {
print STATEMENT "Billing Address2:     $edit_approved[13]\n";
}
}
print STATEMENT "Setup Charge:         $edit_approved[5]\n";
print STATEMENT "Monthly Charge:       $edit_approved[6]\n\n";
print STATEMENT "=" x 75 . "\n\n";
}
       
close (STATEMENT);

#      $tempfile = "$tempdir/$edit_approved[2]";      
      
      open (FILE,"$memberinfo/approved.txt"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
 @approved_email_file  = <FILE>;
 close(FILE);

# Output a temporary file

    open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 

    print MAIL "To: $edit_approved[2]\n";
    print MAIL "From: $orgmail\n";
    # Check for Message Subject
    print MAIL "Subject: $approved_email_subject\n\n";
    #Date
    print MAIL "$date\n";
    

    print MAIL "-" x 75 . "\n\n";

    foreach $line(@approved_email_file) {
    $line =~ s/<FIRST_NAME>/$INPUT{'fname'}/g;
    $line =~s/<LAST_NAME>/$INPUT{'lname'}/g;
    $line =~ s/<USERNAME>/$INPUT{'username'}/g;
    $line =~s/<PASSWORD>/$INPUT{'pwd'}/g;
    $line =~s/<ORGNAME>/$orgname/g;
    $line =~s/<ORGMAIL>/$orgmail/g;
    }
                        
    foreach $line(@approved_email_file) {
    print MAIL "$line";
    }

    print MAIL"\n\n";
    close (MAIL);

 
        
        unlink ("$memberinfo/$lines");
        }
unlink ("$memberinfo/$INPUT{'username'}.infotmp");


}

if ($INPUT{$lines}) {
unlink ("$memberinfo/$lines");

}

#}

#}
&close;

exit;

}



######### CC verifier 3 Subroutine start
sub CC_Verify {

# print "Content-type: text/html\n\n";
# print "Validation running<BR>";

$cardnumber = $INPUT{'cardnumber'}; 

# print "$cardnumber<BR>";

# Remove any spaces or dashes in card number
$cardnumber =~ s/ //g;
$cardnumber =~ s/-//g;
$length = length($cardnumber);

# Make sure that only numbers exist
if (!($cardnumber =~ /^[0-9]*$/)) {
 &invalid_cc;
 }





# Verify correct length for each card type
if ($INPUT{'creditcards'} eq "visa") { &vlen; }
if ($INPUT{'creditcards'} eq "mastercard") { &mclen; }
if ($INPUT{'creditcards'} eq "amex") { &alen; }
if ($INPUT{'creditcards'} eq "novus") { &nlen; }

sub vlen {
    &invalid_cc unless (($length ==13) || ($length == 16));
}
sub mclen {
    &invalid_cc unless ($length == 16);    
}
sub alen {
    &invalid_cc unless ($length == 15);    
}
sub nlen {
    &invalid_cc unless ($length == 16);    
}

# Now Verify via Mod 10 for each one
if ($INPUT{'creditcards'} eq "visa") { &vver; }
if ($INPUT{'creditcards'} eq "mastercard") { &ver16; }
if ($INPUT{'creditcards'} eq "amex") { &ver15; }
if ($INPUT{'creditcards'} eq "novus") { &ver16; }

# pick one for Visa
sub vver {
	if ($length == 13) { &ver13; }
	if ($length == 16) { &ver16; }
}

# For 13 digit cards
sub ver13 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);

        $cc1a = $cc1 * 2;
        $cc3a = $cc3 * 2;
        $cc5a = $cc5 * 2;
        $cc7a = $cc7 * 2;
        $cc9a = $cc9 * 2;
        $cc11a = $cc11 * 2;

        if ($cc1a >= 10) {
            $cc1b = substr($cc1a,0,1);
            $cc1c = substr($cc1a,1,1);
            $cc1 = $cc1b+$cc1c;
        } else {
            $cc1 = $cc1a;
        }
        if ($cc3a >= 10) {
            $cc3b = substr($cc3a,0,1);
            $cc3c = substr($cc3a,1,1);
            $cc3 = $cc3b+$cc3c;
        } else {
            $cc3 = $cc3a;
        }
        if ($cc5a >= 10) {
            $cc5b = substr($cc5a,0,1);
            $cc5c = substr($cc5a,1,1);
            $cc5 = $cc5b+$cc5c;
        } else {
            $cc5 = $cc5a;
        }
        if ($cc7a >= 10) {
            $cc7b = substr($cc7a,0,1);
            $cc7c = substr($cc7a,1,1);
            $cc7 = $cc7b+$cc7c;
        } else {
            $cc7 = $cc7a;
        }
        if ($cc9a >= 10) {
            $cc9b = substr($cc9a,0,1);
            $cc9c = substr($cc9a,1,1);
            $cc9 = $cc9b+$cc9c;
        } else {
            $cc9 = $cc9a;
        }
        if ($cc11a >= 10) {
            $cc11b = substr($cc11a,0,1);
            $cc11c = substr($cc11a,1,1);
            $cc11 = $cc11b+$cc11c;
        } else {
            $cc11 = $cc11a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
	}

# For 16 digit cards
sub ver16 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);
        $cc13 = substr($cardnumber,13,1);
        $cc14 = substr($cardnumber,14,1);
        $cc15 = substr($cardnumber,15,1);

        $cc0a = $cc0 * 2;
        $cc2a = $cc2 * 2;
        $cc4a = $cc4 * 2;
        $cc6a = $cc6 * 2;
        $cc8a = $cc8 * 2;
        $cc10a = $cc10 * 2;
        $cc12a = $cc12 * 2;
        $cc14a = $cc14 * 2;

        if ($cc0a >= 10) {
            $cc0b = substr($cc0a,0,1);
            $cc0c = substr($cc0a,1,1);
            $cc0 = $cc0b+$cc0c;
        } else {
            $cc0 = $cc0a;
        }
        if ($cc2a >= 10) {
            $cc2b = substr($cc2a,0,1);
            $cc2c = substr($cc2a,1,1);
            $cc2 = $cc2b+$cc2c;
        } else {
            $cc2 = $cc2a;
        }
        if ($cc4a >= 10) {
            $cc4b = substr($cc4a,0,1);
            $cc4c = substr($cc4a,1,1);
            $cc4 = $cc4b+$cc4c;
        } else {
            $cc4 = $cc4a;
        }
        if ($cc6a >= 10) {
            $cc6b = substr($cc6a,0,1);
            $cc6c = substr($cc6a,1,1);
            $cc6 = $cc6b+$cc6c;
        } else {
            $cc6 = $cc6a;
        }
        if ($cc8a >= 10) {
            $cc8b = substr($cc8a,0,1);
            $cc8c = substr($cc8a,1,1);
            $cc8 = $cc8b+$cc8c;
        } else {
            $cc8 = $cc8a;
        }
        if ($cc10a >= 10) {
            $cc10b = substr($cc10a,0,1);
            $cc10c = substr($cc10a,1,1);
            $cc10 = $cc10b+$cc10c;
        } else {
            $cc10 = $cc10a;
        }
        if ($cc12a >= 10) {
            $cc12b = substr($cc12a,0,1);
            $cc12c = substr($cc12a,1,1);
            $cc12 = $cc12b+$cc12c;
        } else {
            $cc12 = $cc12a;
        }
        if ($cc14a >= 10) {
            $cc14b = substr($cc14a,0,1);
            $cc14c = substr($cc14a,1,1);
            $cc14 = $cc14b+$cc14c;
        } else {
            $cc14 = $cc14a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12+$cc13+$cc14+$cc15;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
    }


# For 15 digit (Amex) cards
sub ver15 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);
        $cc13 = substr($cardnumber,13,1);
        $cc14 = substr($cardnumber,14,1);

        $cc1a = $cc1 * 2;
        $cc3a = $cc3 * 2;
        $cc5a = $cc5 * 2;
        $cc7a = $cc7 * 2;
        $cc9a = $cc9 * 2;
        $cc11a = $cc11 * 2;
        $cc13a = $cc13 * 2;

        if ($cc1a >= 10) {
            $cc1b = substr($cc1a,0,1);
            $cc1c = substr($cc1a,1,1);
            $cc1 = $cc1b+$cc1c;
        } else {
            $cc1 = $cc1a;
        }
        if ($cc3a >= 10) {
            $cc3b = substr($cc3a,0,1);
            $cc3c = substr($cc3a,1,1);
            $cc3 = $cc3b+$cc3c;
        } else {
            $cc3 = $cc3a;
        }
        if ($cc5a >= 10) {
            $cc5b = substr($cc5a,0,1);
            $cc5c = substr($cc5a,1,1);
            $cc5 = $cc5b+$cc5c;
        } else {
            $cc5 = $cc5a;
        }
        if ($cc7a >= 10) {
            $cc7b = substr($cc7a,0,1);
            $cc7c = substr($cc7a,1,1);
            $cc7 = $cc7b+$cc7c;
        } else {
            $cc7 = $cc7a;
        }
        if ($cc9a >= 10) {
            $cc9b = substr($cc9a,0,1);
            $cc9c = substr($cc9a,1,1);
            $cc9 = $cc9b+$cc9c;
        } else {
            $cc9 = $cc9a;
        }
        if ($cc11a >= 10) {
            $cc11b = substr($cc11a,0,1);
            $cc11c = substr($cc11a,1,1);
            $cc11 = $cc11b+$cc11c;
        } else {
            $cc11 = $cc11a;
        }
        if ($cc13a >= 10) {
            $cc13b = substr($cc13a,0,1);
            $cc13c = substr($cc13a,1,1);
            $cc13 = $cc13b+$cc13c;
        } else {
            $cc13 = $cc13a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12+$cc13+$cc14;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
    }


}


#####
# This Section For Anything Past CC Validation
#####


sub invalid_cc {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR> <TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD COLSTART="1"><CENTER><P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Account Manager</FONT> Status:<BR>Card Number Does Not Pass Validaion.</FONT></B></P></CENTER> <P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">Please use your <B>Back</B> button and verify that the number you've entered is correct and contains no additional characters other than spaces or hyphens.</FONT></P> <P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">If you need further assistance, please contact <A HREF="mailto:$orgmail">$orgname Support</A>.</FONT></P> <CENTER><TABLE BORDER="0" WIDTH="400">
<TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD COLSTART="1"><HR SIZE="1"> <CENTER><FONT SIZE="-2" COLOR="$fontcolor" FACE="verdana, arial, helvetica">$orgname maintained with <B><A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> </CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;

}




#####

######### CC verifier 3 Subroutine end 




sub parseusername {
$desiredname = $INPUT{'username'};
$lines =~ tr/A-Z/a-z/;
$desiredname =~ tr/A-Z/a-z/;
}

sub parseusername2 {
$desiredname = $INPUT{'username'};
$edit_array[0] =~ tr/A-Z/a-z/;
$desiredname =~ tr/A-Z/a-z/;
}


sub parseemail {
$email = $INPUT{'email'};
$edit_array[2] =~ tr/A-Z/a-z/;
$email =~ tr/A-Z/a-z/;
}


sub header {
open (FILE,"<$header/header.txt"); #### Full path name from root. 
 @headerfile = <FILE>;
 close(FILE);
print "<HTML><HEAD><TITLE></TITLE></HEAD><BODY $bodyspec>\n";
foreach $line(@headerfile) {
print "$line";
  }
}


sub footer {
open (FILE,"<$footer/footer.txt"); #### Full path name from root. 
 @footerfile = <FILE>;
 close(FILE);
foreach $line(@footerfile) {
print "$line";
}
print "</BODY></HTML>";
}
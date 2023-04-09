#!/usr/bin/perl

############################################
##                                        ##
##      Account Manager Administration    ##
##          by CGI Script Center          ##
##       (e-mail cgi@elitehost.com)       ##
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
# COPYRIGHT NOTICE:
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
# defend, indemnify and hold harmless CGI Script Center, its 
# agents, its cusomters, officers, and employes,against
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
#########################################################################
# Version 1.02 Beta - 5/28/98
# Added an extra mailing routine to let the administration know
# when an account is delinquent.
#
# Addresses on UNIX Sendmail billings were reversed, causing mailings
# to be sent to the Administrator instead of customer.  Fixed.
#
# Version 1.021 Beta - 5/31/98
# Missed the switch of email and name on one of the mailing routines -
# the response to the Administrator from the new user signup.  This was
# producing multiple emails.  Fixed.
#
# I placed the path to the htpasswd file to the $memberinfo rather than
# the $memaccess directory in the UNIX version.  Still trying to figure
# out how I did that one.  Caused those with the htpasswd file in
# separate directories to not be able to change the passwords in the
# htpasswd file.  Fixed.
# 
# Version 1.022 Beta - 6/08/98
# "Denied" email text file not being read properly, thus not printing
# to the email text sent to those denied accounts.  Bug squashed.
#
# Version 1.023 Beta - 6/11/98
# Subject line in Account Finder email sent back to customer was
# not being filled in.  Bug fixed.
#
# Version 1.024 Beta - 6/18/98
# remote.pl file had an improper path to the htpasswd file
# if configured a certain way.  Fixe the path to work in all
# situations.
#
# Upgrades made this version:
# * Single page of configurations, for easy setup and upgrades
# * Auto Account Expiration added.  Accounts can be limted in
# time, and expire naturally.
# * Customer is notified a number of days in advance of expiration
# (admin determines number) that his/her account will be expiring
# and to contact admin to extend his her account.
# Still need a means of updating the account, should user choose
# to extend account, other than a manual edit.  Coming shortly.
# * Expired accounts are offloaded to a separate database, so
# as to keep the main database lean.
# * Nightly backups of both the membership database and the
# htpasswd file are made.
#
# Version 1.025 Beta - 6/20/98
# Bug found that was keeping the UNIX version users from looking
# up details, or approving more than one user at a time.  Bug found,
# interrogated, tortured, maimed, and shot.
#
# Version 1.026 Beta - 6/22/98
# Bug found in the "Awaiting Approval" members, when admin looked
# at the details of someone awaiting approval and chose "Approve"
# for the individual user, the program was approving everyone
# awaiting approval.  Separate subroutines were necessary to fix.
# Bug squashed.
#
# acctman.pl file was not properly logging the user Address and
# Phone to the database, for future use.  Added COUNTRY to the
# amform.htm file.
#
# Version 1.027 Beta - 7/09/98
# We overwrote the UNIX Mass Mailing routing in our last bug fix
# with our NT Mass Mailing routine.  Sorry.  :)
# Fixed.
#
# We removed the account lengths from the website form.  It was
# an oversight while creating the program, but customers were
# selecting the least expensive account and selecting the longest
# term.  Not good business.  You will find the account lengths
# no set in the config.pl file, which means you WILL need to change
# your config.pl file this time, if you use accounts with time limits.
#
# Version 1.028 Beta - 09/30/98
# We added IBILL Recurring and Non-Recurring Pincode interface
# options, to allow our users using IBILL to bill their customers
# with a real-time credit card system.  Although we have tested
# this method, we still do consider it a beta.  
#
# Version 1.029 - 05/22/2000
# Modification made to the redirection system for Authorizenet
# users, as the new 3.0 Authorizenet/ECX does not redirect as
# in version 2.5.  We've also made other upgrades which we can
# not document here for security purposes.
#
# Version 1.030 - 08/23/2000
# Security Update.  To maintain the security of your Administration
# access you must upgrade to version 1.030 (this version) if using
# a previous version of Account Manager.
#
################################################################
# EDIT BELOW
#################################################################
## This is the only line in this script that requires editing.
## Enter the full directory path to your config.pl file between
## The quotation marks.
## Example: require "/full/directory/path/to/config.pl";

require "/full/directory/path/to/config.pl";

# Save the file and do the same for the other files.
#########################################################
# DO NOT EDIT BELOW THIS LINE
#########################################################
#########################################################

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


$cgiurl = $ENV{'SCRIPT_NAME'};

# Define arrays for the day of the week and month of the year.           #
    @days   = ('Sunday','Monday','Tuesday','Wednesday',
	       'Thursday','Friday','Saturday');
    @months = ('January','February','March','April','May','June','July',
		 'August','September','October','November','December');

    # Get the current time and format the hour, minutes and seconds.  Add    #
    # 1900 to the year to get the full 4 digit year.                         #
    ($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
    $time = sprintf("%02d:%02d:%02d",$hour,$min,$sec);
    $year += 1900;

    # Format the date.                                                       #
    $date = "$days[$wday], $months[$mon] $mday, $year at $time";
    $date2 = "$days[$wday], $months[$mon] $mday, $year";
    $month = "$months[$mon]";





    $version = "1.030";

if ($INPUT{'awaiting'}) {&awaiting; }
elsif ($INPUT{'process'}) {&process; }
elsif ($INPUT{'deny'}) {&process; }
elsif ($INPUT{'indapprove'}) {&indapprove; }
elsif ($INPUT{'inddeny'}) {&inddeny; }
elsif ($INPUT{'active'}) {&active; }
elsif ($INPUT{'adelete'}) {&adelete; }
elsif ($INPUT{'processac'}) {&processac; }
elsif ($INPUT{'processch'}) {&processch; }
elsif ($INPUT{'update'}) {&update; }
elsif ($INPUT{'search'}) {&search; }
elsif ($INPUT{'ambill'}) {&ambill; }
elsif ($INPUT{'admin'}) {&admin; }
elsif ($INPUT{'admin2'}) {&admin2; }
elsif ($INPUT{'processsearch'}) {&processsearch; }
elsif ($INPUT{'areyousure'}) {&areyousure; }
elsif ($INPUT{'mmailform'}) {&mmailform; }
elsif ($INPUT{'mmail'}) {&mmail; }
elsif ($INPUT{'setpwd'}) {&setpwd; }
elsif ($INPUT{'passcheck'}) {&passcheck; }
elsif ($INPUT{'payhist'}) {&payhist; }
else {&admin; }#### Run the Administration panel


sub read {

#################################
# Users Awaiting Approval
#################################

opendir (DIR, "$memberinfo");
@file = grep { /.infotmp/} readdir(DIR);
close (DIR); 

$new_files = push(@file);

#################################
# Active Members
#################################

open (DAT, "<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
@active = <DAT>;
$count = 0;
foreach $lines(@active) {
          $count++;

} 
close (DAT);
}

sub admin {
$noheader = "0";
print "Content-type: text/html\n\n";
unless (-e "$passfile/password.txt") {

&setpassword;
}

&adminpass;
}

sub adminpass {


&header;
print<<EOF;
<FORM ACTION="$cgiurl" METHOD="POST">
<CENTER><BR>
<TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P ALIGN="CENTER"><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account Manager</FONT> Status:<BR>Admininstration Password</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Administration section is restricted to authorized individuals only.  Please enter the Administration password below.</FONT></P>
<CENTER><TABLE BORDER="0"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN="CENTER" COLSTART="1"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Password</B></FONT><BR><INPUT
TYPE="PASSWORD" NAME="pwd"></TD></TR><TR><TD ALIGN="CENTER" COLSTART="1"><BR><INPUT
TYPE="SUBMIT" NAME="passcheck" VALUE="  Enter Password  " ><INPUT
TYPE="RESET" NAME=""></TD></TR></ROWS></TBODY></TABLE></CENTER>
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1"></TD></TR><TR><TD ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$orgname
maintained with <A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}

sub passcheck {

open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);


		if ($INPUT{'pwd'}) {
			$newpassword = crypt($INPUT{'pwd'}, aa);
		}
		else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager$version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
		}
		unless ($newpassword eq $password) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
exit;
		}
&admin2;
}


sub admin2 {
&read;

print "Content-type: text/html\n\n";

&header;
print<<EOF; 
<CENTER><TABLE BORDER="1" WIDTH="450" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF
></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Main Menu</B></FONT></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><TABLE BORDER="1" WIDTH="450" CELLPADDING="5"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="  Search   " NAME="awaiting"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Add/Delete Awaiting Approval 
Accounts</B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="  Search   " NAME="active"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>View/Delete/Edit Active Users</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="  Search   " NAME="search"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Search by
Username/Password
EOF

if ($IBILL) {
print<<EOF;
/IBILL Subscription
EOF
}

print<<EOF;
</B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE=" Mail Bills " NAME="areyousure"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>E-mail all customer bills now</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1" BGCOLOR="#C0C0C0"><INPUT
TYPE="SUBMIT" VALUE="Mass Mail" NAME="mmailform"></TD><TD COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Mass Mail all users</B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
<CENTER><TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="450"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


sub awaiting {
&blindcheck;
&read;

opendir (DIR, "$memberinfo"); 
@file = grep { /.infotmp/} readdir(DIR);

print "Content-type: text/html\n\n";
&header;
print <<EOF;
<CENTER><TABLE BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF
></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Awaiting Approval</B></FONT></TD><TD
 VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF><COLDEF>
<COLDEF><COLDEF></COLDEFS><ROWS><TR><TD
ALIGN="CENTER" NOWRAP="NOWRAP" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Approve</B></FONT></TD><TD
ALIGN="CENTER" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Deny</B></FONT></TD><TD
ALIGN="CENTER" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="3"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Details</B></FONT></TD><TD
ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="4"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Name</B></FONT></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="5"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Username</B></FONT></TD></TR>
EOF
#$count="0";
foreach $lines(@file) {
#$Count++;
#	next if ($count <= $UsersPerPage);
#	last if ($count > $UsersPerPage);
open (DAT, "<$memberinfo/$lines");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
      @approval = <DAT>;
      close (DAT);
      close (DIR); 

        foreach $item(@approval) {
	
             @edit_approval = split(/\:/,$item);      
             print <<EOF;
<TR><TD
 VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1"><INPUT
TYPE="RADIO" NAME="$edit_approval[0].infotmp" VALUE="approve"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><INPUT
TYPE="RADIO" NAME="$edit_approval[0].infotmp" VALUE="deny"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT
TYPE="RADIO" NAME="$edit_approval[0].infotmp" VALUE="details"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="4"><A HREF="mailto:$edit_approval[2]"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_approval[3] $edit_approval[4]</FONT></A></TD>
<TD VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="5"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_approval[0]</FONT></TD></TR>
EOF

}

}
print<<EOF;
</ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="process" VALUE="   Process   "><INPUT TYPE="RESET" NAME=""></TD>
<TD ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Awaiting Approval</FONT></B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">Approve/Deny</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
<CENTER><TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

sub process {

#print "Content-type: text/html\n\n";
opendir (DIR, "$memberinfo"); 
@file = grep { /.infotmp/} readdir(DIR);
 foreach $lines(@file) {


     if ($INPUT{$lines} eq details) {
&read;
open (DAT, "<$memberinfo/$lines");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
      @array = <DAT>;
      close (DAT);
      close (DIR); 




foreach $item(@array) {
             @edit_array = split(/\:/,$item);      
#if ($INPUT{$edit_array[0]} eq update) {last; }
#if ($edit_array[0] eq $INPUT{'update'}) {last; }
}
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><TABLE BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF
></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Awaiting Approval</B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">User Details</FONT></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<INPUT TYPE="HIDDEN" NAME="marker" VALUE="$edit_array[0]"><CENTER>
<TABLE BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS>
<ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" HEIGHT="0" BGCOLOR="#C0C0C0" COLSTART="1"><B><FONT SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[3]</FONT> <FONT SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[4]</FONT></B></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>First Name</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[3]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Last Name</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[4]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Address</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[30]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Address2</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[31]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>City</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[14]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>State/Province</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[15]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Postal Code</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[16]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Country</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[33]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Telephone Number</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[32]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>E-mail Address</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[2]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Username</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[0]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Password</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[1]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Account Type</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[37]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Time Left on Account</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[29]</B></FONT></TD></TR>
EOF

if ($payment == 1) {

print<<EOF;
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Credit Card #:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[10]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Expiration:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[11]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Form of Payment:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[7]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Last Invoice #</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[24]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total of Last Invoice:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[17]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" COLOR="#FF0000" FACE="arial, helvetica"><B>Record payments here</B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Payments Applied:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[18]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" COLOR="#FF0000" FACE="arial, helvetica"><B>Record adjustments here</B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Adjustments Applied:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[19]</B></FONT></TD></TR>
EOF

$tbal = $edit_array[17]+ $edit_array[18]+ $edit_array[19];#tbal

print<<EOF;
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total Balance<BR>Before New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tbal</B></FONT></TD></TR>
EOF

$tnew = $edit_array[5] + $edit_array[6];#tncharges


print<<EOF;
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Current Setup Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[5]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Current Monthly Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[6]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tnew</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total Charges:</B></FONT></TD>
EOF

$tcharges = $tbal + $tnew;#tch
$tcharges2 = int (( $tcharges * 100 ) + .5 ) / 100;

print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tcharges2</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Taxes:</B></FONT></TD>
EOF

$nnew = $tcharges2 + $edit_array[25];#nnw


print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[25]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Net New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$nnew</B></FONT></TD>
EOF
}

print<<EOF;
</TR></ROWS></TBODY></TABLE>

</CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="indapprove" VALUE="Approve Account"><INPUT
TYPE="SUBMIT" NAME="inddeny" VALUE="Deny Account"></TD><TD
ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Awaiting Approval</FONT></B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">User Details</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF

#if ($payment == 1) {
#print<<EOF;
#<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" #WIDTH="500"><TBODY><COLDEFS><COLDEF
#><COLDEF></COLDEFS><ROWS><TR><TD
#VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" #COLSTART="1"><INPUT
#TYPE="SUBMIT" VALUE=" Payment History " NAME="payhist"></TD><TD
#VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" #COLSTART="2"><FONT
#SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">View User #Payment #History</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
#EOF
#}

print<<EOF;
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="admin2" VALUE="Main Menu Return"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu
Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
</FORM><CENTER><TABLE
BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


      if (($INPUT{$lines} eq deny) || ($INPUT{'deny'})) {
      open (DAT, "<$memberinfo/$lines");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
      @approval = <DAT>;
      close (DAT);
      close (DIR); 
        foreach $item(@approval) {
             @edit_approval = split(/\:/,$item);      

      #$tempfile = "$tempdir/$edit_approval[2]";      
      
      open (FILE,"$memberinfo/denied.txt"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @denied_email_file  = <FILE>;
 close(FILE);

# Output a temporary file

    open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program";
    
    print MAIL "To: $edit_approval[2]\n";
    print MAIL "From: $orgmail\n";
    print MAIL "Subject: $denied_email_subject\n";
    #Date
    print MAIL "$date\n";
    
    # Check for Message Subject
    print MAIL "-" x 75 . "\n\n";

    foreach $line(@denied_email_file) {
    $line =~ s/<FIRST_NAME>/$edit_approval[3]/g;
    $line =~s/<LAST_NAME>/$edit_approval[4]/g;
    $line =~ s/<USERNAME>/$edit_approval[0]/g;
    $line =~s/<PASSWORD>/$edit_approval[1]/g;
    $line =~s/<ORGNAME>/$orgname/g;
    $line =~s/<ORGMAIL>/$orgmail/g;
    }
                        
    foreach $line(@denied_email_file) {
    print MAIL "$line";
    }

    print MAIL"\n\n";
    close (MAIL);

 
       
        unlink ("$memberinfo/$lines");
        }
}

      if (($INPUT{$lines} eq approve) || ($INPUT{'approve'})) {
      open (FILE, "<$memberinfo/$lines");
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
           open (DAT2, "<$memberinfo/$lines");
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

open (FILE, "<$memberinfo/$lines");
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

      #$tempfile = "$tempdir/$edit_approved[2]";      
      
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
    $line =~ s/<FIRST_NAME>/$edit_approved[3]/g;
    $line =~s/<LAST_NAME>/$edit_approved[4]/g;
    $line =~ s/<USERNAME>/$edit_approved[0]/g;
    $line =~s/<PASSWORD>/$edit_approved[1]/g;
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
unlink ("$memberinfo/$lines");


}

if ($INPUT{$lines}) {
unlink ("$memberinfo/$lines");

}

}
{&read; &admin2; }#### 

}

sub indapprove {
&blindcheck;
      
open (FILE, "<$memberinfo/$INPUT{'marker'}.infotmp");
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
      @approved = <FILE>;
      close (FILE);

open(DATABASE, ">>$memberinfo/amdata.db") or print"unable to create access temp file";
         if ($LOCK_EX){ 
      flock(DATABASE, $LOCK_EX); #Locks the file
	}
         chomp @approved;
         print DATABASE "@approved\n";

if ($htaccess == "1") {
           
                foreach $item(@approved) {
                @edit_approved = split(/\:/,$item);
                chop ($edit_approved[1]) if ($edit_approved[1] =~ /\n$/);
		    $newpassword = crypt($edit_approved[1], aa); 
                open(PASSWD, ">>$memaccess") or print"unable to create access temp file";
                print PASSWD "$edit_approved[0]:$newpassword\n";
   }

close (PASSWD);


 }
close (DATABASE);

open (FILE, "<$memberinfo/$INPUT{'marker'}.infotmp");
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
       @approved = <FILE>;
       close (FILE);
       foreach $item(@approved) {
             @edit_approved = split(/\:/,$item);      


## Create Customer Billing Statement

if ($payment == 1) {
open (STATEMENT, ">$memberinfo/$INPUT{'marker'}statement.txt");
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

      #$tempfile = "$tempdir/$edit_approved[2]";      
      
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
    $line =~ s/<FIRST_NAME>/$edit_approved[3]/g;
    $line =~s/<LAST_NAME>/$edit_approved[4]/g;
    $line =~ s/<USERNAME>/$edit_approved[0]/g;
    $line =~s/<PASSWORD>/$edit_approved[1]/g;
    $line =~s/<ORGNAME>/$orgname/g;
    $line =~s/<ORGMAIL>/$orgmail/g;
    }
                        
    foreach $line(@approved_email_file) {
    print MAIL "$line";
    }

    print MAIL"\n\n";
    close (MAIL);

 
        

        #print "$memberinfo/$edit_approved[0].infotmp";
        #exit;
        unlink ("$memberinfo/$edit_approved[0].infotmp");
        }
unlink ("$memberinfo/$edit_approved[0].infotmp");

{&read; &admin2; }#### 
}

if ($INPUT{$lines}) {
unlink ("$memberinfo/$lines");

#}

#}


}


sub inddeny {
&blindcheck;
      open (DAT, "<$memberinfo/$INPUT{'marker'}.infotmp");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	} 
      @approval = <DAT>;
      close (DAT);
      close (DIR); 
        foreach $item(@approval) {
             @edit_approval = split(/\:/,$item);      

      #$tempfile = "$tempdir/$edit_approval[2]";      
      
      open (FILE,"$memberinfo/denied.txt"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @denied_email_file  = <FILE>;
 close(FILE);

# Output a temporary file

    open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program";
    
    print MAIL "To: $edit_approval[2]\n";
    print MAIL "From: $orgmail\n";
    print MAIL "Subject: $denied_email_subject\n";
    #Date
    print MAIL "$date\n";
    
    
    
    print MAIL "-" x 75 . "\n\n";

    foreach $line(@denied_email_file) {
    $line =~ s/<FIRST_NAME>/$edit_approval[3]/g;
    $line =~s/<LAST_NAME>/$edit_approval[4]/g;
    $line =~ s/<USERNAME>/$edit_approval[0]/g;
    $line =~s/<PASSWORD>/$edit_approval[1]/g;
    $line =~s/<ORGNAME>/$orgname/g;
    $line =~s/<ORGMAIL>/$orgmail/g;
    }
                        
    foreach $line(@denied_email_file) {
    print MAIL "$line";
    }

 
        unlink ("$memberinfo/$INPUT{'marker'}.infotmp");
        }

{&read; &admin2; }#### 
}

#########################################
# ACTIVE USERS ##########################
#########################################

sub active {
&read;
open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
 close (DAT);

print "Content-type: text/html\n\n";
&header;
print <<EOF;
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS>
<ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Active Users</B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF><COLDEF>
<COLDEF></COLDEFS><ROWS><TR><TD
ALIGN="CENTER" NOWRAP="NOWRAP" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Update</B></FONT></TD><TD
ALIGN="CENTER" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Delete</B></FONT></TD><TD
ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="3"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Name</B></FONT></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="4"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Username</B></FONT></TD></TR>
EOF

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
print<<EOF;
<TR><TD
 VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1"><INPUT
TYPE="RADIO" VALUE="$edit_array[0]" NAME="update"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><INPUT
TYPE="RADIO" VALUE="adelete" NAME="$edit_array[0]"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="3"><A HREF="mailto:$edit_array[2]"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[3] $edit_array[4]</FONT></A></TD>
<TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="4"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[0]</FONT></TD></TR>
EOF
   }


print<<EOF;
</ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="processac" VALUE="   Process   "><INPUT
TYPE="RESET" NAME=""></TD><TD
ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Active Users</FONT></B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
<CENTER><TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

sub processac {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

open (DAT, ">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);

if ($INPUT{$edit_array[0]} ne adelete) {
chomp($lines);
print DAT "$lines\n";
             
   }

}
close (DAT);
&destatement;
&htaccess;

sub destatement {
if ($payment == 1) {
if ($INPUT{$edit_array[0]} eq adelete) {
unlink("$memberinfo/$edit_array[0]statement.txt");
  }
 }
}

print "Content-type: text/html\n\n";
open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[0] eq $INPUT{'update'}) {last; }

}
&update;

}

sub htaccess {
if ($htaccess == "1") {
       open (DAT2, "<$memaccess"); 
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
             @database_array = <DAT2>;
             close (DAT2);

open (DAT2, ">$memaccess");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	} 
                foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
if ($INPUT{$edit_array[0]} ne adelete) {
chomp($lines);
print DAT2 "$lines\n";
}

}

}
close (DAT2);
unless ($INPUT{'update'}) {

&active;
exit;
}
}

sub update {
&read;

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}

 @database_array = <DAT>;
close (DAT);




#print "Content-type: text/html\n\n";

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
#if ($INPUT{$edit_array[0]} eq update) {last; }
if ($edit_array[0] eq $INPUT{'update'}) {last; }
}
&header;
print<<EOF;
<CENTER><TABLE BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF
></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager $version</FONT></B></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT SIZE="+1" FACE="verdana, arial, helvetica"><B>Active Users</B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD><TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting Approval: <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER> 
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<INPUT TYPE="HIDDEN" NAME="marker" VALUE="$edit_array[0]"><CENTER><TABLE BORDER="1" WIDTH="500">
<TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="+1" FACE="verdana, arial, helvetica"><B>User Edit</B></FONT></TD></TR></ROWS></TBODY></TABLE><BR>

<TABLE BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF><COLDEF
></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSPAN="3" HEIGHT="0" BGCOLOR="#C0C0C0" COLSTART="1"><B><FONT SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[3]</FONT> <FONT SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[4]</FONT></B></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>First Name</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[3]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="fname"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Last Name</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[4]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="lname"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Address</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[30]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="address"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Address2</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[31]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="address2"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>City</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[14]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="city"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>State/Province</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[15]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="state"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Postal Code</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[16]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="zip"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Country</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[33]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="country"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Telephone Number</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[32]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="phone"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>E-mail Address</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[2]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="email"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Username</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[0]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="username"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Password</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[1]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="password"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Account Type</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[37]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="account_name"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Time Left on Account</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[29]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="length"></TD></TR>
EOF

if ($payment == 1) {

print<<EOF;
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Credit Card #:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[10]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="cardnumber"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Expiration:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[11]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="exp"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Form of Payment:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[7]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="payment"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Last Invoice #</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$edit_array[24]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="lastinv"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total of Last Invoice:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[17]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="tlastinv"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" COLOR="#FF0000" FACE="arial, helvetica"><B>Record payments here</B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Payments Applied:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[18]</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="papplied"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" COLOR="#FF0000" FACE="arial, helvetica"><B>Record adjustments here</B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Adjustments Applied:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[19]</B></FONT></TD>
EOF

$tbal = $edit_array[17]+ $edit_array[18]+ $edit_array[19];#tbal

print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3"><INPUT TYPE="TEXT" SIZE="9" NAME="aapplied"></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total Balance<BR>Before New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tbal</B></FONT></TD>
EOF

$tnew = $edit_array[5] + $edit_array[6];#tncharges


print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="3" ROWSPAN="7"><TABLE BORDER="0" WIDTH="125">
<TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="1"><FONT SIZE="-2" FACE="arial, helvetica" COLOR="#FF0000"><B>These numbers reflect what your customer will see on his/her next statment.<BR><BR><FONT COLOR="#08007B">To recored a payment</FONT>, enter a negative amount (example: -19.95).<BR><BR><FONT COLOR="#08007B"> To record a purchase</FONT>, enter a positive amount (example: 19.95).<BR><BR><FONT COLOR="#08007B">DO NOT</FONT> use dollar signs.</B><BR><BR></FONT><B><FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://cgi.elitehost.com/acctman/owners/">Account Manager<BR>Online Assistance</A></FONT></B></TD></TR></ROWS></TBODY></TABLE></TD></TR><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Current Setup Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[5]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Current Monthly Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[6]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tnew</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Total Charges:</B></FONT></TD>
EOF

$tcharges = $tbal + $tnew;#tch
$tcharges2 = int (( $tcharges * 100 ) + .5 ) / 100;

print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$tcharges2</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Taxes:</B></FONT></TD>
EOF

$nnew = $tcharges2 + $edit_array[25];#nnw


print<<EOF;
<TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$edit_array[25]</B></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Net New Charges:</B></FONT></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" HEIGHT="36" COLSTART="2"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>\$$nnew</B></FONT></TD>
EOF
}

print<<EOF;
</TR></ROWS></TBODY></TABLE>

</CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT TYPE="SUBMIT" NAME="processch" VALUE="   Process   "><INPUT TYPE="RESET" NAME=""></TD><TD ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Active Users</FONT></B></FONT><BR><FONT SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF

if ($payment == 1) {
print<<EOF;
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT TYPE="SUBMIT" VALUE=" Payment History " NAME="payhist"></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">View User Payment History</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
}

print<<EOF;
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT TYPE="SUBMIT" NAME="admin2" VALUE="Main Menu Return"></TD><TD VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
<CENTER><TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with <A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;

}

sub processch {
&blindcheck;

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);
open (DAT2, ">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
            if ($edit_array[0] eq $INPUT{'marker'}) {
            
$edit_array[0] = $INPUT{'username'} if $INPUT{'username'};
$edit_array[1] = $INPUT{'password'} if $INPUT{'password'};
$edit_array[2] = $INPUT{'email'} if $INPUT{'email'};
$edit_array[3] = $INPUT{'fname'} if $INPUT{'fname'};
$edit_array[4] = $INPUT{'lname'} if $INPUT{'lname'};
$edit_array[7] = $INPUT{'payment'} if $INPUT{'payment'};
$edit_array[10] = $INPUT{'cardnumber'} if $INPUT{'cardnumber'};
$edit_array[11] = $INPUT{'exp'} if $INPUT{'exp'};
$edit_array[24] = $INPUT{'lastinv'} if $INPUT{'lastinv'};
$edit_array[17] = $INPUT{'tlastinv'} if $INPUT{'tlastinv'};
$edit_array[18] = $INPUT{'papplied'} if $INPUT{'papplied'};
$edit_array[19] = $INPUT{'aapplied'} if $INPUT{'aapplied'};
$edit_array[30] = $INPUT{'address'} if $INPUT{'address'};
$edit_array[31] = $INPUT{'address2'} if $INPUT{'address2'};
$edit_array[14] = $INPUT{'city'} if $INPUT{'city'};
$edit_array[15] = $INPUT{'state'} if $INPUT{'state'};
$edit_array[16] = $INPUT{'zip'} if $INPUT{'zip'};
$edit_array[33] = $INPUT{'country'} if $INPUT{'country'};
$edit_array[32] = $INPUT{'phone'} if $INPUT{'phone'};
$edit_array[37] = $INPUT{'account_name'} if $INPUT{'account_name'};
$edit_array[29] = $INPUT{'length'} if $INPUT{'length'};

}

$newline = join
("\:",@edit_array);

chomp($newline);
print DAT2 "$newline\n";
}


if ($htaccess == "1") {
if ($INPUT{'username'} || $INPUT{'password'}) {

       open (DAT3, "<$memaccess"); 
if ($LOCK_EX){ 
      flock(DAT3, $LOCK_EX); #Locks the file
	}
                @database_array = <DAT3>;          
                close (DAT3);

open (DAT3, ">$memaccess"); 
if ($LOCK_EX){ 
      flock(DAT3, $LOCK_EX); #Locks the file
	}
      
        foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
            if ($edit_array[0] eq $INPUT{'marker'}) {
$edit_array[0] = $INPUT{'username'} if $INPUT{'username'};

            if ($INPUT{'password'}) {
 
chop ($INPUT{'password'}) if ($INPUT{'password'} =~ /\n$/);
		$newpassword = crypt($INPUT{'password'}, aa);
    $edit_array[1] = $newpassword if $INPUT{'password'}
}
}

$newline3 = join
("\:",@edit_array);

chomp($newline3);
print DAT3 "$newline3\n";
}
close (DAT3);
}
}






close (DAT2);

#if ($INPUT{'papplied'} || $INPUT{'aapplied'}) {

open (STATEMENT, ">>$memberinfo/$INPUT{'marker'}statement.txt ");
if ($LOCK_EX){ 
      flock(STATEMENT, $LOCK_EX); #Locks the file
	}
print STATEMENT "$date2\n";
print STATEMENT "USER ID:             $INPUT{'marker'}\n";

print STATEMENT "Payments Applied:    $INPUT{'papplied'}\n";
print STATEMENT "Adjustments Applied: $INPUT{'aapplied'}\n";
######################## LEFT OFF HERE #########################
print STATEMENT "=" x 75 . "\n\n";
#}

close (STATEMENT);

&active;
exit;
}

sub search {
&blindcheck;
&read;
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS>
<ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Search for User</B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<HR SIZE="1" WIDTH="500"><CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS>
<ROWS><TR><TD WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><FONT
SIZE="-1" FACE="verdana, arial, helvetica"><B>Search by: </B></FONT> <SELECT
NAME="searchby"><OPTION VALUE="- Select One -">- Select One -</OPTION>
<OPTION
VALUE="Username">Username</OPTION>
<OPTION VALUE="fname">First Name</OPTION><OPTION
VALUE="lname">Last Name</OPTION>
EOF

if ($IBILL) {
print<<EOF;
<OPTION
VALUE="pincode">IBILL Subscription</OPTION>
EOF
}

print<<EOF;
</SELECT></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="2"><INPUT
TYPE="TEXT" SIZE="11" NAME="name"></TD></TR></ROWS></TBODY></TABLE></CENTER><HR
SIZE="1" WIDTH="500"><CENTER><BR><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS>
<COLDEF><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="processsearch" VALUE="   Process   "><INPUT
TYPE="RESET" NAME=""></TD><TD
ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Search for User</FONT></B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu
Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM><CENTER><TABLE
BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></BODY></HTML>
EOF
&footer;
exit;
}


sub processsearch {
&blindcheck;

if ($INPUT{'searchby'} eq Username) {

#print "Content-type: text/html\n\n";
open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[0] eq $INPUT{'name'}) {last; }

}

if ($edit_array[0] eq $INPUT{'name'}) {
&searchedit;
exit;
}else{
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Username Not Found!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Username: <B>$INPUT{'name'}</B> was not found in the database. </FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Check the cAsE
of the Username and try again.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;

} 
}

if ($INPUT{'searchby'} eq fname) {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[3] eq $INPUT{'name'}) {last; }

}

if ($edit_array[3] eq $INPUT{'name'}) {
&searchedit;
exit;
}else{
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  First Name Not Found!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The First Name: <B>$INPUT{'name'}</B> was not found in the database. </FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Check the cAsE
of the Username and try again.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
} 
}

if ($INPUT{'searchby'} eq lname) {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[4] eq $INPUT{'name'}) {last; }

}

if ($edit_array[4] eq $INPUT{'name'})  {
&searchedit;
exit;
}else{
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Last Name Not Found!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Last Name: <B>$INPUT{'name'}</B> was not found in the database. </FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Check the cAsE
of the Username and try again.</FONT></P>
<HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
} 
}

if ($INPUT{'searchby'} eq pincode) {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[36] eq $INPUT{'name'}) {last; }

}

if ($edit_array[36] eq $INPUT{'name'})  {
&searchedit;
exit;
}else{
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><BR>
<TABLE BORDER="0" WIDTH="450"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Subscription Number Not Found!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Subscription Number: <B>$INPUT{'name'}</B> was not found in the database. </FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Check the number
and try again.</FONT></P>
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

sub mmailform {
&blindcheck;
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><TABLE BORDER="0" WIDTH="400"><TBODY>
<COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Account Manager:</FONT> Mailing Form<BR><BR></FONT>
<TABLE BORDER="0"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="TOP" COLSTART="1"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Subject:</B></FONT></TD>
<TD VALIGN="TOP" COLSTART="2"><INPUT TYPE="TEXT" SIZE="40" NAME="mail_subject"></TD></TR></ROWS></TBODY></TABLE><TEXTAREA
NAME="message" ROWS="12" COLS="50" WRAP="Physical"></TEXTAREA><BR><INPUT
TYPE="SUBMIT" VALUE="    Send    " NAME="mmail"><INPUT TYPE="RESET" NAME="">

</TD></TR></ROWS></TBODY></TABLE></CENTER></FORM><CENTER><TABLE BORDER="0"><TBODY>
<COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD ALIGN="CENTER" COLSTART="1"><HR
SIZE="1" WIDTH="400">
<CENTER><TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER> </TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}

sub mmail {
&blindcheck;

$pid = fork();
print "Content-type: text/html \n\n fork failed: $!" unless defined 

$pid;
if ($pid) {
	#parent

&mailsent;

exit(0);
	}
else {
	#child

	close (STDOUT);
##### SEND OUT EMAILS HERE ############
       

######### Here is where we did the addition ###################
###############################################################


open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);



foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          


open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 
 
    print MAIL "To: $edit_array[2]\n";
    print MAIL "From: $orgmail ($orgname)\n";
    print MAIL "Subject: $INPUT{'mail_subject'}\n";
    print MAIL "-" x 75 . "\n\n";
    print MAIL "$INPUT{'message'}";  

       close (MAIL);
 
        }

}

exit;
}


sub searchedit {
&blindcheck;
&read;

print "Content-type: text/html\n\n";
&header;
print <<EOF;
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS>
<ROWS><TR><TD ALIGN="CENTER" COLSPAN="2" COLSTART="1"><B><FONT
SIZE="-2" FACE="verdana, arial, helvetica">CGI Script Center's</FONT><BR><FONT
SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000">Account Manager
$version</FONT></B></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" ROWSPAN="2" COLSTART="1"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B>Active Users</B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Active
Users: <FONT COLOR="#0000FF">$count</FONT></FONT></B></FONT></TD></TR><TR><TD
VALIGN="MIDDLE" ALIGN="LEFT" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B><FONT COLOR="#000000">Awaiting
Approval:  <FONT COLOR="#0000FF">$new_files</FONT></FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE><BR></CENTER>
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><TABLE
BORDER="1" WIDTH="500" CELLPADDING="5"><TBODY><COLDEFS><COLDEF><COLDEF><COLDEF>
<COLDEF></COLDEFS><ROWS><TR><TD
ALIGN="CENTER" NOWRAP="NOWRAP" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Update</B></FONT></TD><TD
ALIGN="CENTER" WIDTH="40" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Delete</B></FONT></TD><TD
ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="3"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Name</B></FONT></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#C0C0C0" COLSTART="4"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>Username</B></FONT></TD></TR>
EOF

print<<EOF;
<TR><TD
 VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1"><INPUT
TYPE="RADIO" VALUE="$edit_array[0]" NAME="update"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="2"><INPUT
TYPE="RADIO" VALUE="adelete" NAME="$edit_array[0]"></TD><TD
VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="3"><A HREF="mailto:$edit_array[2]"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[3] $edit_array[4]</FONT></A></TD>
<TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="4"><FONT
SIZE="-2" FACE="verdana, arial, helvetica">$edit_array[0]</FONT></TD></TR>
EOF

print<<EOF;
</ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" NAME="processac" VALUE="   Process   "><INPUT
TYPE="RESET" NAME=""></TD><TD
ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Active Users</FONT></B></FONT><BR><FONT
SIZE="-2" FACE="verdana, arial, helvetica">View/Edit/Delete</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
<HR SIZE="1" WIDTH="500"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF
><COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
<CENTER><TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR
><TD COLSTART="1"><HR SIZE="1" WIDTH="500"></TD></TR><TR><TD
VALIGN="TOP" ALIGN="CENTER" COLSTART="1"><FONT
SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER>
EOF
&footer;
exit;
}


sub header {
open (FILE,"<$header/header.txt"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @headerfile = <FILE>;
 close(FILE);
print "<HTML><HEAD><TITLE></TITLE></HEAD><BODY $bodyspec>\n";
foreach $line(@headerfile) {
print "$line";
  }
}


sub footer {
open (FILE,"<$footer/footer.txt"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @footerfile = <FILE>;
 close(FILE);
foreach $line(@footerfile) {
print "$line";

}
print "</BODY></HTML>";
}

sub ambill {
&blindcheck;

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
 close (DAT);


$count =0;
foreach $lines(@database_array) {
            @edit_array = split(/\:/,$lines);


 &mailbills;
######for every account sub mail gets inserted here ##############
$count++;
}


open (NEWDAT,">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(NEWDAT, $LOCK_EX); #Locks the file
	}
print NEWDAT @database_array;
close (NEWDAT);

}


sub mailbills {
&blindcheck;


$pid = fork();
print "Content-type: text/html \n\n fork failed: $!" unless defined 

$pid;
if ($pid) {
	#parent
&billssent;
exit(0);
	}
else {
	#child

	close (STDOUT);
##### SEND OUT EMAILS HERE ############

$INPUT{'recipient'} = $orgmail;

$edit_array[17] = $edit_array[23];
$edit_array[20] = $edit_array[17]+$edit_array[18]+$edit_array[19];#tbal
$edit_array[21] = $edit_array[5]+$edit_array[6];#tncharges
$edit_array[22] = $edit_array[5]+$edit_array[6]+ $edit_array[20];#tch
$tcharges = int (( $edit_array[22] * 100 ) + .5 ) / 100;
$edit_array[22] = $tcharges;
$edit_array[23] = $edit_array[20] + $edit_array[21];#nnw
$nnewcharges = int (( $edit_array[23] * 100 ) + .5 ) / 100;
#$edit_array[23] = $nnewcharges;


open (INVOICE,"$memberinfo/invoice.txt");
if ($LOCK_EX){ 
      flock(INVOICE, $LOCK_EX); #Locks the file
	}
$new_invoice = <INVOICE> ;
close (INVOICE);
$new_invoice++;
open (NEWINVOICE,">$memberinfo/invoice.txt");
if ($LOCK_EX){ 
      flock(NEWINVOICE, $LOCK_EX); #Locks the file
	}
print NEWINVOICE "$new_invoice";
close (NEWINVOICE);


                       
open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program";
 
    print MAIL "To: $edit_array[2] ($edit_array[3] $edit_array[4])\n";
    print MAIL "From: $orgmail ($billing)\n";
    print MAIL "Subject: $orgname $month Billing Statement\n";
    print MAIL "-" x 75 . "\n\n";
    
    print MAIL "$date2\n";
    print MAIL "Username: $edit_array[0]\n\n";
    
    print MAIL "Invoice: $new_invoice\n";
    print MAIL "Total of Last Bill: \$$edit_array[17]\n";

    if ($edit_array[18] && $edit_array[18] !=0) {
    print MAIL "Payments Applied: \$$edit_array[18] - Thank You\n";
} else {
    print MAIL "Payments Applied: \$$edit_array[18]\n";
}

    print MAIL "Adjustments Applied: \$$edit_array[19]\n";

    
    print MAIL "Total Balance before new charges: \$$edit_array[20]\n";
    print MAIL "New Charges: \$$edit_array[21]\n";

    print MAIL "Total Charges:  \$$edit_array[22]\n";
    print MAIL "Taxes: \$0.00\n";
    print MAIL "-" x 75 . "\n\n";
    print MAIL "Net New Charges: \$$edit_array[23]\n\n";


         if ($edit_array[7] eq cc) {
         if ($edit_array[23] < 0) {
         print MAIL "You have a credit of \$$edit_array[23].\n\n";
         print MAIL "\$$edit_array[23] will be applied towards your future billing\n";
         print MAIL "No additional payment is due this month\n\n";
}
     elsif ($edit_array[23]== 0) {
         print MAIL "Your balance is \$0.  No payement is due this month.\n\n";
} else {
         print MAIL "Payment for the month of $month now due.\n\n";
         print MAIL "\$$edit_array[23] has been submitted for clearing through the credit card\n";
        print MAIL "company of record for your account.\n\n"; 

            } 
          }
 
    if ($edit_array[7] eq check) {
       
         if ($edit_array[23] < 0) {
         print MAIL "You have a credit of \$$edit_array[23].\n\n";  
         print MAIL "\$$edit_array[23] will be applied towards your next billing\n";
           print MAIL "No additional payment is due this month.\n\n";
}
elsif ($edit_array[23]== 0) {
         print MAIL "Your balance is \$0.  No payement is due this month.\n\n";

} else {
       print MAIL "Payment for the month of $month now due.\n\n";
       print MAIL "Please make check payable to:\n\n";
       print MAIL "$billingaddress1\n";
       print MAIL "$billingaddress2\n";
       print MAIL "$billingaddress3\n\n";
          }
        }

       print MAIL "Thank you for your business.\n\n";
       print MAIL "$billinginquiries\n\n";

    

       close (MAIL);
}

##################################################
# DELINQUENT NOTICES TO ADMIN
##################################################

 
if ($edit_array[20] > 0) {

open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program";
 

print MAIL "To: $orgmail ($orgname)\n";
    print MAIL "From: $orgmail ($orgname Account Manager - automated script)\n";
    print MAIL "Subject: Past Due Account\n";
    print MAIL "-" x 75 . "\n\n";



print MAIL "This account may be past due.  Please look into it.\n";
print MAIL "-" x 75 . "\n\n";


    print MAIL "$date2\n";
    print MAIL "Username: $edit_array[0]\n\n";
    
    print MAIL "Invoice: $new_invoice\n";
    print MAIL "Total of Last Bill: \$$edit_array[17]\n";

    if ($edit_array[18] && $edit_array[18] !=0) {
    print MAIL "Payments Applied: \$$edit_array[18] - Thank You\n";
} else {
    print MAIL "Payments Applied: \$$edit_array[18]\n";
}

    print MAIL "Adjustments Applied: \$$edit_array[19]\n";

    
    print MAIL "Total Balance before new charges: \$$edit_array[20]\n";
    print MAIL "New Charges: \$$edit_array[21]\n";

    print MAIL "Total Charges:  \$$edit_array[22]\n";
    print MAIL "Taxes: \$0.00\n";
    print MAIL "-" x 75 . "\n\n";
    print MAIL "Net New Charges: \$$edit_array[23]\n\n";


         if ($edit_array[7] eq cc) {
         if ($edit_array[23] < 0) {
         print MAIL "You have a credit of \$$edit_array[23].\n\n";
         print MAIL "\$$edit_array[23] will be applied towards your future billing\n";
         print MAIL "No additional payment is due this month\n\n";
}
     elsif ($edit_array[23]== 0) {
         print MAIL "Your balance is \$0.  No payement is due this month.\n\n";
} else {
         print MAIL "Payment for the month of $month now due.\n\n";
         print MAIL "\$$edit_array[23] has been submitted for clearing through the credit card\n";
        print MAIL "company of record for your account.\n\n"; 

            } 
          }
 
    if ($edit_array[7] eq check) {
       
         if ($edit_array[23] < 0) {
         print MAIL "You have a credit of \$$edit_array[23].\n\n";  
         print MAIL "\$$edit_array[23] will be applied towards your next billing\n";
           print MAIL "No additional payment is due this month.\n\n";
}
elsif ($edit_array[23]== 0) {
         print MAIL "Your balance is \$0.  No payement is due this month.\n\n";

} else {
       print MAIL "Payment for the month of $month now due.\n\n";
       print MAIL "Please make check payable to:\n\n";
       print MAIL "$billingaddress1\n";
       print MAIL "$billingaddress2\n";
       print MAIL "$billingaddress3\n\n";
          }
        }

       print MAIL "Thank you for your business.\n\n";
       print MAIL "$billinginquiries\n\n";

    

       close (MAIL);

}

##################################################

open (STATEMENT, ">>$memberinfo/$edit_array[0]statement.txt ");
if ($LOCK_EX){ 
      flock(STATEMENT, $LOCK_EX); #Locks the file
	}
 
    print STATEMENT "To: $edit_array[3] $edit_array[4] ($edit_array[2])\n";
    print STATEMENT "From: $billing ($orgmail)\n";
    print STATEMENT "-" x 75 . "\n\n";
    
    print STATEMENT "$date2\n";
    print STATEMENT "Username: $edit_array[0]\n\n";
    
    print STATEMENT "Invoice: $new_invoice\n";
    print STATEMENT "Total of Last Bill: \$$edit_array[17]\n";

    if ($edit_array[18] && $edit_array[18] !=0) {
    print MAIL "Payments Applied: \$$edit_array[18] - Thank You\n";
} else {
    print STATEMENT "Payments Applied: \$$edit_array[18]\n";
}

    print STATEMENT "Adjustments Applied: \$$edit_array[19]\n";

    
    print STATEMENT "Total Balance before new charges: \$$edit_array[20]\n";
    print MAIL "New Charges: \$$edit_array[21]\n";

    print STATEMENT "Total Charges:  \$$edit_array[22]\n";
    print STATEMENT "Taxes: \$0.00\n";
    print STATEMENT "-" x 75 . "\n\n";
    print STATEMENT "<B>Net New Charges: \$$edit_array[23]</B>\n\n";


         if ($edit_array[7] eq cc) {
         if ($edit_array[23] < 0) {
         print STATEMENT "You have a credit of \$$edit_array[23].\n\n";
         print STATEMENT "\$$edit_array[23] will be applied towards your future billing\n";
         print STATEMENT "No additional payment is due this month\n\n";
}
     elsif ($edit_array[23]== 0) {
         print STATEMENT "Your balance is \$0.  No payement is due this month.\n\n";
} else {
         print STATEMENT "Payment for the month of $month now due.\n\n";
         print STATEMENT "\$$edit_array[23] has been submitted for clearing through the credit card\n";
        print STATEMENT "company of record for your account.\n\n"; 

            } 
          }
 
    if ($edit_array[7] eq check) {
       
         if ($edit_array[23] < 0) {
         print STATEMENT "You have a credit of \$$edit_array[23].\n\n";  
         print STATEMENT "\$$edit_array[23] will be applied towards your next billing\n";
           print STATEMENT "No additional payment is due this month.\n\n";
}
elsif ($edit_array[23]== 0) {
         print STATEMENT "Your balance is \$0.  No payement is due this month.\n\n";

} else {
       print STATEMENT "Payment for the month of $month now due.\n\n";
       print STATEMENT "Please make check payable to:\n\n";
       print STATEMENT "$billingaddress1\n";
       print STATEMENT "$billingaddress2\n";
       print STATEMENT "$billingaddress3\n\n";
          }
        }

       print STATEMENT "Thank you for your business.\n\n";
       print STATEMENT "$billinginquiries\n";
       print STATEMENT "=" x 75 . "\n\n";
    

       close (STATEMENT);

###################################################



$edit_array[17] = $edit_array[23];
$edit_array[18] = 0;
$edit_array[19] = 0;
$edit_array[5] = 0;
$edit_array[24] = $new_invoice;
$database_array[$count] = join("\:",@edit_array);

open (NEWDAT,">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(NEWDAT, $LOCK_EX); #Locks the file
	}
print NEWDAT @database_array;
close (NEWDAT);



}
&billssent;


sub areyousure {
&blindcheck;
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><BR>
<TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Are You Sure?</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You are about to send out
billing statements to your entire database.  <B>Is this what you would like to
do?</B></FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail"><B>$orgname Support</B></A> if you need any further
assistance.</FONT></P>
</TD></TR><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1"><BR>
<INPUT TYPE="SUBMIT" NAME="ambill" VALUE=" Yes, Send Bills Now!"><INPUT
TYPE="SUBMIT" NAME="admin2" VALUE="Ooops! Nooo!"></TD></TR><TR><TD COLSTART="1"><HR
SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname
maintained with
<A HREF="http://cgi.elitehost.com/"><B>Account Manager $version</B></A></B></FONT>

</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;

}

sub billssent {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><BR>
<TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Success!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Billing/Statments have been sent!</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail">$orgname Support</A> if you need any further
assistance.</FONT><BR><BR></P></TD></TR></ROWS></TBODY></TABLE></CENTER><HR
SIZE="1" WIDTH="450"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF>
<COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu
Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER><CENTER><TABLE
BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname
maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}

sub mailsent {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION="$cgiurl" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$INPUT{'pwd'}">
<CENTER><BR>
<TABLE BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><P><B><FONT FACE="verdana, arial, helvetica"><FONT
COLOR="#FF0000">Account
Manager</FONT> Status:  Success!</FONT></B></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Mass Mailing has been sent!</FONT></P>
<P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please contact
<A HREF="mailto:$orgmail">$orgname Support</A> if you need any further
assistance.</FONT><BR><BR></P></TD></TR></ROWS></TBODY></TABLE></CENTER><HR
SIZE="1" WIDTH="450"><CENTER><TABLE BORDER="1" WIDTH="500"><TBODY><COLDEFS><COLDEF>
<COLDEF></COLDEFS><ROWS><TR><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="1"><INPUT
TYPE="SUBMIT" VALUE="Main Menu Return" NAME="admin2"></TD><TD
VALIGN="MIDDLE" ALIGN="CENTER" WIDTH="50%" BGCOLOR="#C0C0C0" COLSTART="2"><FONT
SIZE="+1" FACE="verdana, arial, helvetica"><B><FONT SIZE="-1">Main Menu
Return</FONT></B></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER><CENTER><TABLE
BORDER="0" WIDTH="500"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART="1"><HR SIZE="1">
<CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>$orgname
maintained with
<A HREF="http://cgi.elitehost.com/">Account Manager $version</A></B></FONT> 
</CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}

sub setpassword {

&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Set Password!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">You have not yet set your
administration password!  Please enter your password below, once to set the
password and the second time to confirm it.</FONT></P>
<CENTER><TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">password</FONT></TD></TR>
<TR><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd2\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">confirmation</FONT></TD></TR>
<TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><BR><INPUT
TYPE=\"SUBMIT\" NAME=\"setpwd\" VALUE=\"  Set Password  \"></TD><TD COLSTART=\"2\"><BR><INPUT
TYPE=\"RESET\" NAME=\"\"></TD></TR></ROWS></TBODY></TABLE></CENTER><CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}

sub setpwd {

if (-e "$passfile/password.txt") {
print "Content-type: text/html\n\n";
print "Password already exists.  Please delete your password file manually if you want to reset your password<BR>";
exit;
}

print "Content-type: text/html\n\n";
unless ($INPUT{'pwd'} && $INPUT{'pwd2'}) {
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password twice.  Once to set it, and once to confirm it.</FONT></P>
<CENTER><TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">password</FONT></TD></TR>
<TR><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd2\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">confirmation</FONT></TD></TR>
<TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><BR><INPUT
TYPE=\"SUBMIT\" NAME=\"setpwd\" VALUE=\"  Set Password  \"></TD><TD COLSTART=\"2\"><BR><INPUT
TYPE=\"RESET\" NAME=\"\"></TD></TR></ROWS></TBODY></TABLE></CENTER><CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}
if ($INPUT{'pwd'} && $INPUT{'pwd2'}) {
    if ($INPUT{'pwd'} ne $INPUT{'pwd2'}) {

&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Mismatch!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">The confirmation password you entered did not match the orginal password.  Please try again.</FONT></P>
<CENTER><TABLE BORDER=\"0\"><TBODY><COLDEFS><COLDEF><COLDEF></COLDEFS><ROWS><TR
><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">password</FONT></TD></TR>
<TR><TD ALIGN=\"RIGHT\" COLSTART=\"1\"><INPUT TYPE=\"PASSWORD\" NAME=\"pwd2\"></TD><TD
COLSTART=\"2\"><FONT SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">confirmation</FONT></TD></TR>
<TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><BR><INPUT
TYPE=\"SUBMIT\" NAME=\"setpwd\" VALUE=\"  Set Password  \"></TD><TD COLSTART=\"2\"><BR><INPUT
TYPE=\"RESET\" NAME=\"\"></TD></TR></ROWS></TBODY></TABLE></CENTER><CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager  $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
}
}

chop ($pwd) if ($pwd =~ /\n$/);
		$newpassword = crypt($INPUT{'pwd'}, aa);

open (PASSWORD, ">$passfile/password.txt")|| print "Could not write password text file.  Check your permission settings";
     
    if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
      print PASSWORD "$newpassword";
	close (PASSWORD);
&adminpass;
exit;
}

sub payhist {

open (STATEMENT, "$memberinfo/$INPUT{'marker'}statement.txt ");
if ($LOCK_EX){ 
      flock(STATEMENT, $LOCK_EX); #Locks the file
	} 
@statement  = <STATEMENT>;
close (STATEMENT);
print "Content-type: text/html\n\n";
&header;
print "<PRE>";
foreach $line(@statement) {
                        print "$line";
                        }
print "</PRE>";
&footer;
exit;
}

sub blindcheck {
open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);

		if ($INPUT{'pwd'}) {
			$newpassword = crypt($INPUT{'pwd'}, aa);
		}
		else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager$version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
		}
		unless ($newpassword eq $password) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Account Manager</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$orgname
maintained with  <A HREF=\"http://cgi.elitehost.com/\"><B>Account Manager $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
exit;

}

}
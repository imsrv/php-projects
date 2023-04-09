#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);

require "../configdat.lib";
require "subs.lib";
require "adminmenu.lib";
#############################################################
$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
$msg = "@_"; 
print "\nContent-type: text/html\n\n";
print "The following error occurred : $msg\n";
exit;
}

# Get the input
read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
    @pairs = split(/&/, $input);
    foreach $pair (@pairs) {
    ($name, $value) = split(/=/, $pair);
    $name =~ tr/+/ /;  
    $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $FORM{$name} = $value;  
    }
#################################################################
$adminname=$FORM{'adminname'};
$adminpassword=$FORM{'adminpassword'};
###########################################################
if($FORM{'activateadmin'} eq "Activate Admin"){
&activateadmin;
}

if($FORM{'noaccessactivateadmin'} eq "Activate Admin"){
&noaccessactivateadmin;
}

##################################################################

sub activateadmin {

if(($adminname eq "")||($adminpassword eq "")){
print "Content-type: text/html\n\n";
print "$adminmainheader<p>\n";
print "<center><font face=univers size=2>Either you have not entered a login name or you have not entered a password.
</font></center>\n";
print "<center><font face=univers size=2>You must enter both an admin name and a password in order to set up your administration center.</font></center>\n";
print "<center><FORM> <INPUT type=\"button\" value=\"<< Go Back\" onClick=\"history.go(-1)\"> </FORM></center>\n";
print "$adminbotcode\n";
exit;
}


open (HTACCESS,">$admindir/.htaccess") || &adminerror ("Error Writing $admindir/.htaccess:", "$!");
print HTACCESS "AuthUserFile $admindir/.htpasswd\n";
print HTACCESS "AuthGroupFile $admindir/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);

open (HTACCESS,">$profilesdir/catwsm/datafiles/.htaccess") || &adminerror ("Error Writing $profilesdir/catwsm/datafiles/.htaccess:", "$!");
print HTACCESS "AuthUserFile $profilesdir/catwsm/datafiles/.htpasswd\n";
print HTACCESS "AuthGroupFile $profilesdir/catwsm/datafiles/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);

open (HTACCESS,">$profilesdir/catwsw/datafiles/.htaccess") || &adminerror ("Error Writing $profilesdir/catwsw/datafiles/.htaccess:", "$!");
print HTACCESS "AuthUserFile $profilesdir/catwsw/datafiles/.htpasswd\n";
print HTACCESS "AuthGroupFile $profilesdir/catwsw/datafiles/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);

open (HTACCESS,">$profilesdir/catmsm/datafiles/.htaccess") || &adminerror ("Error Writing $profilesdir/catmsm/datafiles/.htaccess:", "$!");
print HTACCESS "AuthUserFile $profilesdir/catmsm/datafiles/.htpasswd\n";
print HTACCESS "AuthGroupFile $profilesdir/catmsm/datafiles/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);


open (HTACCESS,">$profilesdir/catmsw/datafiles/.htaccess") || &adminerror ("Error Writing $profilesdir/catmsw/datafiles/.htaccess:", "$!");
print HTACCESS "AuthUserFile $profilesdir/catmsw/datafiles/.htpasswd\n";
print HTACCESS "AuthGroupFile $profilesdir/catmsw/datafiles/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);



open (HTACCESS,">$users/.htaccess") || &adminerror ("Error Writing $users/.htaccess:", "$!");
print HTACCESS "AuthUserFile $users/.htpasswd\n";
print HTACCESS "AuthGroupFile $users/.htgroup\n";
print HTACCESS "AuthName \'Authorized Users Only!\'\n";
print HTACCESS "AuthType Basic\n\n";
print HTACCESS "<Limit GET PUT POST>\n";
print HTACCESS "require valid-user\n";
print HTACCESS "</Limit>\n";
close(HTACCESS);



#################################################################################################################
open (HTGROUP,">$admindir/.htgroup") || &adminerror ("Error Writing $admindir/.htgroup:", "$!");
print HTGROUP "$adminname: $adminname";
close(HTGROUP);


open (HTGROUP,">$users/.htgroup") || &adminerror ("Error Writing $users/.htgroup:", "$!");
print HTGROUP "$adminname: $adminname";
close(HTGROUP);
#################################################################################################################
@salt_chars = ('T' .. 'R', 4 .. 7, 'h' .. 'p', '.', '#');
$salt = join '', @salt_chars[rand 64, rand 64];
$encrypted = crypt($adminpassword, $salt);

##################################################################

open (HTPASSWD,">$admindir/.htpasswd") || &adminerror ("Error   Writing $admindir/.htpasswd:", "$!");
print HTPASSWD "$adminname:$encrypted";
close(HTPASSWD);

open (HTPASSWD,">$users/.htpasswd") || &adminerror ("Error   Writing $users/.htpasswd:", "$!");
print HTPASSWD "$adminname:$encrypted";
close(HTPASSWD);

##################################################################
open (FILE,">$admindir/admactive.txt") || &adminerror ("Error Writing $admiticket/.htgroup:", "$!");
print FILE "$adminname|$adminpassword";
close(FILE);
##################################################################

&notify;
&setupcomplete;
}

##################################################################

sub setupcomplete {

print "Content-type:text/html\n\n";
print "<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Installation</font></td></tr>
</table>
<br><br>\n";
print "<blockquote><font size=2 face=verdana>\n";

if($FORM{'cnt'} == 0){

print "
The setup has been completed. However, the program was unable to automatically set the permissions on the necessary files.
You must set the permissions manually. Consult your installation documents for manual chmodding instructions.\n";}

else {
print "
Congratulations, you have successfully installed and setup A Personals Touch. You may click below
to login to the admin center.</font>\n";}

print "</blockquote><center><FORM method=\"get\" action=\"$admindirurl/admin.html\"></font>
<br><INPUT type=\"submit\" value=\"Go to Admin Center\" class=\"button\"> </FORM></center>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top>Back to Top</a><br></td></tr></table>\n";
exit;
}






sub noaccessactivateadmin {



if(($adminname eq "")||($adminpassword eq "")){
print "Content-type: text/html\n\n";
print "$adminmainheader<p>\n";
print "<center><font face=univers size=2>Either you have not entered a login name or you have not entered a password.
</font></center>\n";
print "<center><font face=univers size=2>You must enter both an admin name and a password in order to set up your administration center.</font></center>\n";
print "<center><FORM> <INPUT type=\"button\" value=\"<< Go Back\" onClick=\"history.go(-1)\"> </FORM></center>\n";
print "$adminbotcode\n";
exit;
}

open (FILE,">$admindir/admactive.txt") || &adminerror ("Error Writing $admiticket/.htgroup:", "$!");
print FILE "$adminname|$adminpassword";
close(FILE);

&noaccesssetupcomplete;
}


sub noaccesssetupcomplete {

print "Content-type:text/html\n\n";
print "<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Setup</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Setup
</font></td></tr>
</table>
<br><br>\n";
print "<blockquote><font size=2 face=verdana>\n";

if($FORM{'cnt'} == 0){

print "
The setup has been completed. However, the program was unable to automatically set the permissions on the necessary files.
You must set the permissions manually. Consult your installation documents for manual chmodding instructions.\n";}

else {
print "
Congratulations, you have successfully installed and setup A Personals Touch. You may click below
to login to the admin center.</font>\n";}

print "</blockquote><center><FORM method=\"get\" action=\"$admindirurl/login.html\"></font>
<br><INPUT type=\"submit\" value=\"Go to Admin Center\" class=\"button\"> </FORM></center>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top>Back to Top</a><br></td></tr></table>\n";
exit;
}
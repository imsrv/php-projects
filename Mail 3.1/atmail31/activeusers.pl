#!/usr/bin/perl
# Show active users

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

require 'Common.pm';

use Net::SMTP;
use Mail::Internet;
use Time::CTime;
use Time::ParseDate;

&config;
&javascript;
&delete if($delete);
&htmlheader("Active users");
&more if($more);
&activeusers;
&htmlend;
exit;

sub delete {
rmdir "$Bin/users/$delete" || die "Cannot delete $Bin/users/$delete: $!";
$status = "Deleted $Bin/users/$delete!";
           }

sub more {
print<<_EOF;
       <table width="100%" border="1">
          <tr bgcolor="#9999FF">
            <td colspan="3" height="25"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica,
sans-serif">User Information</font></b></font></td>
          </tr>
          <tr>
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>Name</b></td>
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>Value</b></td>
          </tr>
_EOF
open(INFO,"$Bin/users/$more/user.info") || die "Cannot open $Bin/users/$more/user.info: $!";

while(<INFO>)   {
($name,$value) = split(": ");
print<<_EOF;
<tr>
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>$name</b></td>
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>$value</b></td>
              </tr>
_EOF
                }
print "</table><BR>";
  }


sub activeusers
{
opendir(DIR,"$Bin/users");
@folders = readdir(DIR);
print<<_EOF;
       <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td colspan="3" height="25"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, 
sans-serif">Active 
              WebBased Email Users</font></b></font></td>
          </tr>
          <input type="hidden" name="savesettings" value="1">
          <input type="hidden" name="username" value="demo3">
          <input type="hidden" name="pop3host" value="webbasedemail.net">
          <tr> 
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>Full Name</b></td>
            <td width="19%" bgcolor="#CCCCFF" height="26"><b>Email Address</b></td>
            <td width="25%" bgcolor="#CCCCFF" height="26"><b>Signup Date</b></td>
          </tr>
_EOF
    
foreach $v (@folders)   {
next if($v eq "." || $v eq ".." || !-e "$Bin/users/$v/user.info");
$usercount++;
open(INFO,"$Bin/users/$v/user.info") || print "Cannot open $Bin/users/$v/user.info: $!\n";
while(<INFO>)   {

$myuser{fistname} = $1 if(/^firstname: (.*)/);
$myuser{lastname} = $1 if(/^lastname: (.*)/);
$myuser{date} = asctime($1) if(/^signdate: (.*)/);
$myuser{user} = $1 if(/^username: (.*)/);
$myuser{pop3host} = $1 if(/^pop3host: (.*)/);

                }
close(INFO);
print<<_EOF;
  <tr bgcolor="#CCCCFF">
           <td height="32" width="19%" bgcolor="#9999FF">$myuser{fistname} $myuser{lastname} [<a 
href="activeusers.pl?more=$myuser{user}\@$myuser{pop3host}">more</a> <a href="activeusers.pl?delete=$myuser{user}\@$myuser{pop3host}">delete</a>]</td>
            <td height="32" width="19%" bgcolor="#9999FF"><a href="mailto:$myuser{user}\@$myuser{pop3host}">$myuser{user}\@$myuser{pop3host}</a></td>
            <td height="32" width="25%" bgcolor="#9999FF">$myuser{date}</td>
          </tr>
_EOF
                        }
print "</table><BR>";
 } 

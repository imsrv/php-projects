#!/usr/bin/perl
# Main program - launch navbar & fetch users email

use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";
do "$Bin/atmail.conf";

do "$Bin/html/logout.phtml";
do "$Bin/html/login.phtml";
do "$Bin/html/fadescreen.phtml";
do "$Bin/html/javascript.js";
do "$Bin/html/settings.phtml";

require 'Common.pm';

&config;
#&javascript;

if(!$framenav && !$getemail) {
&navigation;
	    }
else	{
&framenav if($framenav);
	}

&htmlend;
exit;

# conf

sub getemail	{
&htmlheader("Welcome to \@Mail");
foreach (sort keys %myenv)	{
print"$_ = $myenv{$_}<BR>";
				}

		}

sub navigation	{

$cgi->delete_all();
$cgi->param('getemail', "1");
$cgi->param('username',"$username");
$cgi->param('pop3host',"$pop3host");
$cgi->param('password',"$password");
my $getemail = $cgi->self_url;

$cgi->delete_all();
$cgi->param('framenav', "1");
$cgi->param('username',"$username");
$cgi->param('pop3host',"$pop3host");
my $framenav = $cgi->self_url;

print<<_EOF;
<html>
<head>
<title>\@Mail - The COMPLETE Web Based Email Solution</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
_EOF

#&fadescreen;

print<<_EOF;
<frameset cols="20%,80%" border="0" framespacing="0" frameborder="NO" rows="*"> 
<frame src="$framenav" name="navbar">
<frame src="showmail.pl?username=$username&password=$password&pop3host=$pop3host" name="window">
</frameset>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>
_EOF

exit;
}


sub framenav
{

($username, $pop3host) = split("\@",$emailaddress) if($emailaddress);

$cgi->delete_all();
$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('compose', '1');
$cgi->param('password', "$password");
my $composelink = $cgi->self_url;
$cgi->delete_all();

$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('getemail', "1");
$cgi->param('password', "$password");
my $reademaillink = $cgi->self_url;
$cgi->delete_all();

$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('password', "$password");
$cgi->param('settings', '1');
my $settingslink = $cgi->self_url;

$cgi->delete_all();
$cgi->param('logout', '1');
my $logout = $cgi->self_url;

$cgi->delete_all();
my $newlogin = $cgi->self_url;

print<<_EOF;
<html>
<head>
<title>ArrowMail Email Navigiation</title>
_EOF

#&fadescreen;
#&javascript;

print<<_EOF;
<body
text=#ffffff
bgcolor=#003366
link="#0066CC" vlink="#0066CC"
alink=$vlinkcolor>

<center><br>
<table>
    <tr> 
      <td> <font face=arial,helvetica>
<BR><b>Controls:</b></font> <br>
        <font face=geneva,arial size=-1>
<a href="showmail.pl?username=$username&pop3host=$pop3host" target=window><b>Check Mail</b></a><br>

<a href="compose.pl?username=$username&pop3host=$pop3host" target=window><b>Compose Mail</b></a><br>
<b>
<a href="addressbook.pl?username=$username&pop3host=$pop3host" target=window>
Address Book
</a>
</b><br>

<a href=""><img width=8 height=8 src="imgs/minus.gif" border=0></a>
<b><a href="newmbox.pl?username=$username&pop3host=$pop3host" target="window">Mail Folders</a></b><br>
&nbsp;<img src=imgs/bullet.gif width=3 height=7>
<font face=geneva,arial size=-1>
<a href="showmail.pl?username=$username&pop3host=$pop3host" target=window>Inbox</a></font>
<br>
_EOF

opendir(DIR,"$Bin/users/$confdir/mbox");
@folders = readdir(DIR);

foreach $folder (@folders)
	{
next if($folder eq "." || $folder eq ".." || $folder eq "tmp");

$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('getemail', "1");
$cgi->param('mbox',"$folder");
my $mboxlink = $cgi->self_url;
$cgi->delete_all();

print<<_EOF;
&nbsp;<img src=imgs/bullet.gif width=3 height=7>
<font face=geneva,arial size=-1>
<a href="showmail.pl?username=$username&pop3host=$pop3host&localmbox=$folder" target=window>$folder</a></font>
<br>
_EOF

	}

print<<_EOF;
<a href="ldap.pl?username=$username&pop3host=$pop3host" target=window><b>Email Search</b></a><br> 
<a href="settings.pl?username=$username&pop3host=$pop3host" target=window><b>Preferences</b></a>
<br>
<a href="http://webbasedemail.net/help.html" target=_new><b>Help</b></a>
<BR>
<a href="index.html" target=_top><b>New Login</b></a> 
        <br>
<a href="logout.pl?logout=1" target=_top><b>Exit Mail</b></a>
</font>
<form method="post">
<input type="hidden" name="framenav" value="1">
<input type="hidden" name="username" value="$username">
<input type="hidden" name="pop3host" value="$pop3host">
<font face="Lucida,Verdana,Helvetica,Arial"><small>
          <input type="submit" name="Submit" value="Refresh">
          </small></font> 

          <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2">© 
            <a href="http://cgisupport.com" target="_new">CGIsupport.com</a> </font> </p>        
</form>
</td>
</tr>
</table>
</center>
</body>
</html>
_EOF

exit;
}

sub newuser
{

&error("$username is already in use") if(-e "$Bin/users/$username\@$pop3host");
&error("$username is too long (max 16chars)") if(length($username) > 16);
&error("$username contains an illegal character") if($username =~ /:/ || $username =~ /\@/ || $username =~ / /);
#&error("Password mismatch!") if($password ne $password2);
&error("Please enter your First and Last name") if(!$firstname || !$lastname);

}

#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);

require "../configdat.lib";
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

if($FORM{'startsetup'} eq "Start Setup"){&startsetup;}
if($FORM{'skiphtaccess'} eq "Skip htaccess"){&skiphtaccess;}
if($FORM{'regadmin'} eq "Register Admin"){&regadmin;}

sub startsetup {

$cnt = 
    
chmod 0755, '$perscgidir/admin';
chmod 0755, '$perscgidir/lovestories';
chmod 0755, '$perscgidir/persads';
chmod 0755, '$perscgidir/picboards';
chmod 0755, '$perscgidir/browseprofiles.pl';
chmod 0755, '$perscgidir/createpro.pl';
chmod 0755, '$perscgidir/curnumusers.pl';
chmod 0755, '$perscgidir/delprofile.pl';
chmod 0755, '$perscgidir/fcookie.cgi';
chmod 0755, '$perscgidir/feedback.pl';
chmod 0755, '$perscgidir/fileupload.pl';
chmod 0755, '$perscgidir/index.pl';
chmod 0755, '$perscgidir/createpro.pl';
chmod 0755, '$perscgidir/lsfileupload.pl';
chmod 0755, '$perscgidir/personals.pl';
chmod 0755, '$perscgidir/postad.pl';
chmod 0755, '$perscgidir/register.pl';
chmod 0755, '$perscgidir/sffileupload.pl';
chmod 0755, '$perscgidir/updateprofile.pl';
chmod 0755, '$admincgidir/admin.pl';
chmod 0755, '$admincgidir/adminindex.pl';
chmod 0755, '$admincgidir/setaccess.pl';
chmod 0755, '$admincgidir/activatemember.pl';
chmod 0755, '$admincgidir/lscope_fcookieengine.pl';
chmod 0755, '$admincgidir/messagemailer.pl';
chmod 0755, '$admincgidir/updater.pl';
chmod 0777, '$admincgidir/ads.txt';
chmod 0777, '$admincgidir/profiles.txt';
chmod 0777, '$admincgidir/ask.txt';
chmod 0777, '$admincgidir/members.txt';
chmod 0777, '$admincgidir/memberdata.txt';
chmod 0777, '$admincgidir/getfeatured.txt';
chmod 0777, '$admincgidir/complaints.txt';
chmod 0777, '$admincgidir/emaillist.txt';
chmod 0777, '$admincgidir/lovequestions.txt';
chmod 0777, '$admincgidir/expdate.txt';
chmod 0777, '$admincgidir/suggestions.txt';
chmod 0777, '$chatroomdir/rm1.html';
chmod 0777, '$chatroomdir/rm2.html';
chmod 0777, '$chatroomdir/rm3.html';
chmod 0777, '$personalsdir/lovestories';
chmod 0777, '$personalsdir/messagecenter';
chmod 0777, '$personalsdir/lovestories';
chmod 0777, '$personalsdir/soundfiles';
chmod 0777, '$personalsdir/users';
chmod 0777, '$users/storepass';
chmod 0777, '$personalsdir/profiles';
chmod 0777, '$profilesdir/catwsm';
chmod 0777, '$profilesdir/catwsw';
chmod 0777, '$profilesdir/catmsm';
chmod 0777, '$profilesdir/catmsw';
chmod 0777, '$profilesdir/datafiles';
chmod 0777, '$profilesdir/pictures';
chmod 0777, '$personalsdir/fcookie.txt';
chmod 0777, '$personalsdir/lovescope.txt';
chmod 0777, '$perscgidir/users.txt';
chmod 0777, '$perscgidir/persads/adnum.txt';



unless(-e "$admindir/admactive.txt"){

print "Content-type: text/html\n\n";
print "
<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Setup</font></td></tr>
</table>
<br><br>\n";
print "<form method=post action=\"$admincgiurl/admin.pl\">\n";
print "<blockquote><font size=2 face=verdana>
Register a username and password with which to access the adminstration facility.<br><br>

<br><br></font></blockquote>\n";
print "<p><center><table><tr>
<td><font size=2 color=000000 face=verdana>
Admin Login Name:</font></td><td>
<INPUT TYPE=\"text\" NAME=\"adminname\" SIZE=15 MAXLENGTH=25></td></tr><tr>\n";
print "<td> <font size=2 color=000000 face=verdana>Admin Password:</font></td>
<td><INPUT TYPE=\"password\" NAME=\"adminpassword\" SIZE=15 MAXLENGTH=25></td></tr></table>\n";
print "<p><center>
<input type=\"hidden\" name=\"cnt\" value=\"$cnt\">
<input type=\"submit\" name=\"activateadmin\" value=\"Activate Admin\" class=\"button\">


</center>\n";
print "</form>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=ffffff>Back to Top</font></a><br></td></tr></table>\n";
print "</body></html>\n";
exit;

}

else {

print "Content-type: text/html\n\n";
print "<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Installation</font></td></tr>
</table>
<br><br>\n";
print "<form method=get action=\"$cgiurl/index.pl\">\n";
print "<table><tr><td><blockquote><font size=2 face=verdana>A Personals Touch has already been installed.
If you are the administrator and you did not perform the setup, please reinstall the program and 
run the set up. Otherwise, the admin facility is a restricted area, accessible only to the site administrator.\n";
print "<p><center><input type=\"submit\" value=\"      Exit      \" class=\"button\"></center></td></tr></table>\n";
print "</form>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=ffffff>Back to Top</font></a><br></td></tr></table>\n";
print "</body></html>\n";
exit;

}
}



sub skiphtaccess {

$cnt = 
    
chmod 0755, '$perscgidir/admin';
chmod 0755, '$perscgidir/lovestories';
chmod 0755, '$perscgidir/persads';
chmod 0755, '$perscgidir/picboards';
chmod 0755, '$perscgidir/browseprofiles.pl';
chmod 0755, '$perscgidir/createpro.pl';
chmod 0755, '$perscgidir/curnumusers.pl';
chmod 0755, '$perscgidir/delprofile.pl';
chmod 0755, '$perscgidir/fcookie.cgi';
chmod 0755, '$perscgidir/feedback.pl';
chmod 0755, '$perscgidir/fileupload.pl';
chmod 0755, '$perscgidir/index.pl';
chmod 0755, '$perscgidir/createpro.pl';
chmod 0755, '$perscgidir/lsfileupload.pl';
chmod 0755, '$perscgidir/personals.pl';
chmod 0755, '$perscgidir/postad.pl';
chmod 0755, '$perscgidir/register.pl';
chmod 0755, '$perscgidir/sffileupload.pl';
chmod 0755, '$perscgidir/updateprofile.pl';
chmod 0755, '$admincgidir/admin.pl';
chmod 0755, '$admincgidir/adminindex.pl';
chmod 0755, '$admincgidir/setaccess.pl';
chmod 0755, '$admincgidir/activatemember.pl';
chmod 0755, '$admincgidir/lscope_fcookieengine.pl';
chmod 0755, '$admincgidir/messagemailer.pl';
chmod 0755, '$admincgidir/updater.pl';
chmod 0777, '$admincgidir/ads.txt';
chmod 0777, '$admincgidir/profiles.txt';
chmod 0777, '$admincgidir/ask.txt';
chmod 0777, '$admincgidir/members.txt';
chmod 0777, '$admincgidir/memberdata.txt';
chmod 0777, '$admincgidir/getfeatured.txt';
chmod 0777, '$admincgidir/complaints.txt';
chmod 0777, '$admincgidir/emaillist.txt';
chmod 0777, '$admincgidir/lovequestions.txt';
chmod 0777, '$admincgidir/expdate.txt';
chmod 0777, '$admincgidir/suggestions.txt';
chmod 0777, '$chatroomdir/rm1.html';
chmod 0777, '$chatroomdir/rm2.html';
chmod 0777, '$chatroomdir/rm3.html';
chmod 0777, '$personalsdir/lovestories';
chmod 0777, '$personalsdir/messagecenter';
chmod 0777, '$personalsdir/lovestories';
chmod 0777, '$personalsdir/soundfiles';
chmod 0777, '$personalsdir/users';
chmod 0777, '$users/storepass';
chmod 0777, '$personalsdir/profiles';
chmod 0777, '$profilesdir/catwsm';
chmod 0777, '$profilesdir/catwsw';
chmod 0777, '$profilesdir/catmsm';
chmod 0777, '$profilesdir/catmsw';
chmod 0777, '$profilesdir/datafiles';
chmod 0777, '$profilesdir/pictures';
chmod 0777, '$personalsdir/fcookie.txt';
chmod 0777, '$personalsdir/lovescope.txt';
chmod 0777, '$perscgidir/users.txt';
chmod 0777, '$perscgidir/persads/adnum.txt';



unless(-e "$admindir/admactive.txt"){

print "Content-type: text/html\n\n";
print "
<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Setup</font></td></tr>
</table>
<br><br>\n";
print "<form method=post action=\"$admincgiurl/admin.pl\">\n";
print "<blockquote><font size=2 face=verdana>
Register a username and password with which to access the adminstration facility.<br><br>

<br><br></font></blockquote>\n";
print "<p><center><table><tr>
<td><font size=2 color=000000 face=verdana>
Admin Login Name:</font></td><td>
<INPUT TYPE=\"text\" NAME=\"adminname\" SIZE=15 MAXLENGTH=25></td></tr><tr>\n";
print "<td> <font size=2 color=000000 face=verdana>Admin Password:</font></td>
<td><INPUT TYPE=\"password\" NAME=\"adminpassword\" SIZE=15 MAXLENGTH=25></td></tr></table>\n";
print "<p><center>
<input type=\"hidden\" name=\"cnt\" value=\"$cnt\">
<input type=\"submit\" name=\"noaccessactivateadmin\" value=\"Activate Admin\" class=\"button\">


</center>\n";
print "</form>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=ffffff>Back to Top</font></a><br></td></tr></table>\n";
print "</body></html>\n";
exit;

}

else {

print "Content-type: text/html\n\n";
print "<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Installation</font></td></tr>
</table>
<br><br>\n";
print "<form method=get action=\"$cgiurl/index.pl\">\n";
print "<table><tr><td><blockquote><font size=2 face=verdana>A Personals Touch has already been installed.
If you are the administrator and you did not perform the setup, please reinstall the program and 
run the set up. Otherwise, the admin facility is a restricted area, accessible only to the site administrator.\n";
print "<p><center><input type=\"submit\" value=\"      Exit      \" class=\"button\"></center></td></tr></table>\n";
print "</form>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=ffffff>Back to Top</font></a><br></td></tr></table>\n";
print "</body></html>\n";
exit;

}
}

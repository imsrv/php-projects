#!/bin/perl
######################################################################
# Active Relay Chat 2.0 (WWW-IRC Gateway)                            #
#--------------------------------------------------------------------#
# Copyright 1999 Michael L. Sissine                                  #
# You can use this program only with one site                        #
# If you want to purchase unlimited license please contact us        #
# You cannot sell or redistribute this product                       #
# If you want to become our reseller please contact us               #
# http://spiderweb.hypermart.net/                                    #
# http://www.trxx.co.uk/                                             #
# trxx@trxx.co.uk                                                    #
# trxx@usa.net                                                       #
# trxx@telebot.net                                                   #
######################################################################
# Variables Section                                                  #
######################################################################
# Reading CFG
open (F, "<arc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

######################################################################
# Main Section                                                       #
######################################################################
sysread(STDIN,$data,$ENV{CONTENT_LENGTH});
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		$data{$field}=$value;
	}
}
$password=crypt($data{password},$data{password});
open(F,"<$arcpath/bases/users");
@users=<F>;
close(F);
foreach (@users)
{
	chop;
	($us,$ps,$rn)=split("\t",$_);
	if ($us eq $data{username})
	{
		&success if ($ps eq $password && !(-e "$arcpath/bases/$data{username}.msg"));
		&error;
	}
}
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title>Register with ARC</title>
</head>
<body topmargin=50 bgcolor=000000 text=ffffff>
<font color=ffffff size=2 face="sans serif"><center>
<table width=484 cellspacing=0 cellpadding=0 border=1 bordercolor=ffffff>
<tr><td>
<table width=484 cellspacing=0 cellpadding=0 border=0>
<tr><td colspan=2><img src="$arcurl/images/arcban.gif"></td></tr>
<tr><td width=178><img src="$arcurl/images/arclogo.gif"></td>
<td width=306 valign=top><form action="$cgi/arcreg.pl" method="post">
<table width=304>
<tr><td colspan=2 bgcolor=ffffff><font color=000000 size=4><center><b>PLEASE REGISTER FIRST</b></center></font></td></tr>
<tr><td colspan=2>Real name:<br><input type="text" name="real" size="35"></td></tr>
<tr><td>Country:<br><input type="text" name="country" size="15"></td><td>City:<br><input type="text" name="city" size="20"></td></tr>
<tr><td>Gender:<br><select name="gender"><option value="Male">Male</option><option value="Female">Female</option></select></td><td>E-mail:<br><input type="text" name="uemail" size="20"></td></tr>
<tr><td>Username:<br><input type="text" name="username" size="15" maxlength="8"></td><td>Password:<br><input type="text" name="password" size="20"></td></tr>
<tr><td align="center" colspan=2><input type="submit" value="Sign me up!!!"></td></tr>
</table></form></td></tr></table></td></tr></table></center></font>
</body></html>
~;

sub error
{
open(F,"<$arcpath/bases/servers");
@servers=<F>;
close(F);
open(F,"<$arcpath/bases/channels");
@channels=<F>;
close(F);
@channels=sort(@channels);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title>Login to ARC</title>
</head>
<body topmargin=100 bgcolor=000000>
<font color=ffffff size=2 face="sans serif"><center>
<table width=484 cellspacing=0 cellpadding=0 border=1 bordercolor=ffffff>
<tr><td>
<table width=484 cellspacing=0 cellpadding=0 border=0>
<tr><td colspan=2><img src="$arcurl/images/arcban.gif"></td></tr>
<tr><td width=178><img src="$arcurl/images/arclogo.gif"></td>
<td width=306 valign=top><form action="$cgi/arcinit.pl" method="post">
<table width=304>
<tr><td colspan=2 bgcolor=ffffff><font color=000000 size=4><center><b>LOGIN TO ARC</b></center></font></td></tr>
<tr><td colspan=2 bgcolor=ffffff><font color=000000 size=2><center><b>Incorrect password</b></center></font></td></tr>
<tr><td><font color=ffffff>Username</font></td><td><input type="text" size=35 name="username"></td></tr>
<tr><td><font color=ffffff>Password</font></td><td><input type="password" size=35 name="password"></td></tr>
<tr><td><font color=ffffff>Browser</font></td><td><select name="browser"><option value="Explorer">Internet Explorer</option><option value="Netscape">Netscape</option></select></td></tr>
<tr><td><font color=ffffff>Server</font></td><td><select name="server">
~;
foreach(@servers)
{
	chop;
	($serv,$desc)=split("\t",$_);
	print "<option value=\"$serv\">$desc</option>\n";
}
print qq~
</select></td></tr>
<tr><td><font color=ffffff>Channel</font></td><td><select name="channel">
~;
foreach(@channels)
{
	chop;
	print "<option value=\"$_\">#$_</option>\n";
}
print qq~
</select></td></tr>
<tr><td></td><td><input type="submit" value="Login"></td></tr>
</table></form></td></tr></table></td></tr></table></center></font>
</body></html>
~;
exit;
}

sub success
{
if ($ENV{HTTP_REFERER} ne "$cgi/arcidx.pl")
{
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title>Login to ARC</title>
</head>
<body topmargin=100 bgcolor=000000>
<font color=ffffff size=2 face="sans serif"><center>
<table width=484 cellspacing=0 cellpadding=0 border=1 bordercolor=ffffff>
<tr><td>
<table width=484 cellspacing=0 cellpadding=0 border=0>
<tr><td colspan=2><img src="$arcurl/images/arcban.gif"></td></tr>
<tr><td width=178><img src="$arcurl/images/arclogo.gif"></td>
<td width=306 valign=top><form action="$cgi/arcinit.pl" method="post">
<table width=304>
<tr><td bgcolor=ffffff><font color=000000 size=4><center><b>ACCESS DENIED</b></center></font></td></tr>
<tr><td><font color=ffffff>You havent permission to run ARC from this location $ENV{HTTP_REFERER}</font></td><td>
</table></form></td></tr></table></td></tr></table></center></font>
</body></html>
~;
exit;
}
open(F,">$arcpath/bases/$data{username}.sts");
close(F);
open(F,">$arcpath/bases/$data{username}.nic");
close(F);
open(F,">$arcpath/bases/$data{username}.cmd");
close(F);
open(F,">$arcpath/bases/$data{username}.msg");
close(F);
open(F,">$arcpath/bases/$data{username}.tpc");
close(F);
open(F,">$arcpath/bases/$data{username}.usr");
close(F);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
if ($data{browser} eq "Explorer")
{
print qq~
<html>
<head>
<title>Active Relay Chat - $data{channel}</title>
</head>
<frameset framespacing="0" frameborder="0" cols="770,*">
<frameset framespacing="0" frameborder="0" rows="10,50,10,305,10,40,10,*">
<frame name="el14" src="$arcurl/images/el14.gif" scrolling="no" marginwidth=0 marginheight=0>
<frameset cols="498,262,10,*">
<frame name="el15" src="$arcurl/images/el15.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="main" src="$cgi/arcgtop.pl?username=$data{username}" scrolling="no" marginwidth=0 marginheight=0>
<frame name="el16" src="$arcurl/images/el16.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el1" src="$arcurl/images/el1.gif" scrolling="no" marginwidth=0 marginheight=0>
<frameset cols="10,440,10,300,10,*">
<frame name="el3" src="$arcurl/images/el3.gif" scrolling="no" marginwidth=0 marginheight=0>
<frameset rows="6,293,6">
<frame name="el8" src="$arcurl/images/el8.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="message" src="$cgi/arcgm.pl?username=$data{username}" scrolling="yes" marginwidth=5 marginheight=0>
<frame name="el9" src="$arcurl/images/el9.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el4" src="$arcurl/images/el4.gif" scrolling="no" marginwidth=0 marginheight=0>
<frameset rows="195,10,6,88,6">
<frameset cols="150,10,140">
<frameset rows="6,183,6">
<frame name="el12" src="$arcurl/images/el12.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="users" src="$cgi/arcgu.pl?channel=$data{channel}&username=$data{username}" scrolling="auto" marginwidth=5 marginheight=0>
<frame name="el13" src="$arcurl/images/el13.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el7" src="$arcurl/images/el7.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="actions" src="$cgi/arcgac.pl?username=$data{username}&channel=$data{channel}" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el6" src="$arcurl/images/el6.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="el10" src="$arcurl/images/el10.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="status" src="$cgi/arcgs.pl?username=$data{username}" scrolling="yes" marginwidth=5 marginheight=0>
<frame name="el11" src="$arcurl/images/el11.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el5" src="$arcurl/images/el5.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el2" src="$arcurl/images/el2.gif" scrolling="no" marginwidth=0 marginheight=0>
<frameset cols="10,750,10,*">
<frame name="el18" src="$arcurl/images/el18.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="form" src="$cgi/arcgf.pl?username=$data{username}&channel=$data{channel}" scrolling="no" marginwidth=0 marginheight=0>
<frame name="el19" src="$arcurl/images/el19.gif" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="el17" src="$arcurl/images/el17.gif" scrolling="no" marginwidth=0 marginheight=0>
<frame name="blank" src="$cgi/arcblank.pl?server=$data{server}&channel=$data{channel}&username=$data{username}&realname=$rn" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="blank" src="$arcurl/blank.html" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
~;
}
else
{
print qq~
<html>
<head>
<title>Active Relay Chat - $data{channel}</title>
</head>
<frameset framespacing="0" frameborder="1" cols="760,*">
<frameset framespacing="0" frameborder="1" rows="70,305,75,*">
<frameset cols="498,262">
<frame name="el15" src="$arcurl/el15.html" scrolling="no" marginwidth=0 marginheight=0>
<frame name="main" src="$cgi/arcgtop.pl?username=$data{username}" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frameset cols="450,310">
<frame name="message" src="$cgi/arcgm.pl?username=$data{username}" scrolling="yes" marginwidth=5 marginheight=0>
<frameset rows="205,100">
<frameset cols="160,150">
<frame name="users" src="$cgi/arcgu.pl?channel=$data{channel}&username=$data{username}" scrolling="auto" marginwidth=5 marginheight=0>
<frame name="actions" src="$cgi/arcgac.pl?username=$data{username}&channel=$data{channel}" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="status" src="$cgi/arcgs.pl?username=$data{username}" scrolling="yes" marginwidth=5 marginheight=0>
</frameset>
</frameset>
<frame name="form" src="$cgi/arcgf.pl?username=$data{username}&channel=$data{channel}" scrolling="no" marginwidth=0 marginheight=0>
<frame name="blank" src="$cgi/arcblank.pl?server=$data{server}&channel=$data{channel}&username=$data{username}&realname=$rn" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
<frame name="blank" src="$arcurl/blank.html" scrolling="no" marginwidth=0 marginheight=0>
</frameset>
~;
}
exit;
}

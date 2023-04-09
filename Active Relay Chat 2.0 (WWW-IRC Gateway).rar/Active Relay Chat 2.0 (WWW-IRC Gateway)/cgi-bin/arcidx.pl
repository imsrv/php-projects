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

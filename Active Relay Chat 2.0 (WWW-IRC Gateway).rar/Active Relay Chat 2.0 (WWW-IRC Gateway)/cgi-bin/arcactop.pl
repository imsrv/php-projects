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
if ($ENV{CONTENT_LENGTH}>0){sysread(STDIN,$data,$ENV{CONTENT_LENGTH});}
else {($data=$ENV{QUERY_STRING});}
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($data{$field}){$data{$field}="$data{$field},$value";}
		else {$data{$field}=$value;}
	}
}
if ($data{method} eq "clearmessage")
{
open(F,">$arcpath/bases/$data{username}.msg");
close(F);
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "Location: $cgi/arcgm.pl?username=$data{username}\n\n";
exit;
}
if ($data{method} eq "quit")
{
open(F,">>$arcpath/bases/$data{username}.cmd");
print F "QUIT :$quitmessage\n";
close(F);
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "Location: $cgi/arcgm.pl?username=$data{username}\n\n";
exit;
}
if ($data{method} eq "help")
{
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title></title>
</head>
<body bgcolor=000000 text=ffffff>
<font color=ffffff size=2 face="sans serif"><center>
<table width=400 cellspacing=0 cellpadding=0 border=0 bordercolor=ffffff>
<tr><td>
<table width=400 cellspacing=0 cellpadding=0 border=0>
<tr><td width=178><img src="$arcurl/images/arclogo.gif"></td>
<td width=222 valign=top><table width=220>
<tr><td bgcolor=ffffff><font color=000000 size=4><center><b>HELP</b></center></font></td></tr>
<tr><td><font color=ffffff>You are using ARC 2.0 - WWW-IRC gateway. This manual can help you to use Active Relay Chat. So ARC is gateway - you can use most IRC commands from command-line. Some commands are restricted and cannot be used with ARC.</font></td></tr>
</table></td></tr>
<tr><td colspan=2><center><b>COMMON RULES</b></center></td></tr>
<tr><td colspan=2><ul><li>Please, use LOGOFF button or /quit command to leave IRC. Do it before you shutdown your browser</li>
<li>If you are novice on IRC read this manual carefully. Below you can find list and description of IRC commands</li>
<li>You cannot login to ARC twice at once with same username</li>
<li>You cannot change channels and servers. You must LOGOFF first and then reconnect with other server and(or) channel</li>
<li>Behave yourself on IRC! Dont give IRC ops reason to ban you from server</li>
<li>Be friendly with other people and people will be friendly with you</li></ul></td></tr>
<tr><td colspan=2><center><b>IRC COMMANDS</b></center></td></tr>
<tr><td valign="top">/action</td><td>Send action message to channel (syntax: /action [message])</td></tr>
<tr><td valign="top">/mode</td><td>Change channel mode (syntax: /mode {[+|-]o|p|s|i|t|n|m|b|v} [limit] [nickname] [banmask])<br>
The various modes available for channels are as follows:<br>
o - give/take channel operator privileges<br>
p - private channel flag<br>
s - secret channel flag<br>
i - invite-only channel flag<br>
t - topic settable by channel operator only flag<br>
m - moderate channel flag;
n - no messages to channel from clients on the outside<br>
l - set user limit to channel<br>
b - set a ban mask to keep user out<br>
v - give/take the ability to speak on a moderated channel<br>
k - set a channel key (password)</td></tr>
<tr><td valign="top">/msg</td><td>Send private message to user (syntax: /msg [nickname] [message])</td></tr>
<tr><td valign="top">/notice</td><td>Notice user (syntax: /notice [nickname] [message])</td></tr>
<tr><td valign="top">/nick</td><td>Change nickname (syntax: /nick [newnickname])</td></tr>
<tr><td valign="top">/topic</td><td>Change channel topic (syntax: /topic [newtopic])</td></tr>
<tr><td valign="top">/version</td><td>Get software version (syntax: /version )</td></tr>
<tr><td valign="top">/whois</td><td>Get user information (syntax: /whois [nickname])</td></tr>
<tr><td colspan=2><a href="$cgi/arcgm.pl?username=$data{username}"><font color=ffffff><center>BACK TO MESSAGE BOARD</center></font></a></td></tr>
</table></td></tr></table></font>
</body></html>
~;
exit;
}

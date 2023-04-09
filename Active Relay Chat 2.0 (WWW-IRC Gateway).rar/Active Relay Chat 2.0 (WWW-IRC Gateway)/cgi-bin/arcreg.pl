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
		if ($data{$field}){$data{$field}="$data{$field},$value";}
		else {$data{$field}=$value;}
	}
}
open (F,"<$arcpath/bases/users");
@users=<F>;
close(F);
foreach (@users)
{
	if ($_=~/^$data{username}\t/)
	{
		push (@errors,"<li>Username <b>$data{username}</b> is already in use</li>");
		$flag=1;
		last;
	}
}
if (!$data{username} || $data{username} eq "")
{
	push (@errors,"<li>Please, fill <b>Username</b> field</li>");
	$flag=1;
}
if (!$data{password} || $data{password} eq "")
{
	push (@errors,"<li>Please, fill <b>Password</b> field</li>");
	$flag=1;
}
$data{real}="Prefer not to say" if (!$data{real} || $data{real} eq "");
$data{country}="Prefer not to say" if (!$data{country} || $data{country} eq "");
$data{city}="Prefer not to say" if (!$data{city} || $data{city} eq "");
$data{uemail}="Prefer not to say" if (!$data{uemail} || $data{uemail} eq "");
&error if ($flag);
$password=crypt($data{password},$data{password});
open(F,">>$arcpath/bases/users");
print F "$data{username}\t$password\t$data{real}\t$data{gender}\t$data{country}\t$data{city}\t$data{uemail}\n";
close(F);
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "Location: $cgi/arcidx.pl\n\n";

sub error
{
print qq~
<html>
<head>
<title>Error</title>
</head>
<body topmargin=50 bgcolor=000000 text=ffffff>
<font color=ffffff size=2 face="sans serif"><center>
<table width=484 cellspacing=0 cellpadding=0 border=1 bordercolor=ffffff>
<tr><td>
<table width=484 cellspacing=0 cellpadding=0 border=0>
<tr><td colspan=2><img src="$arcurl/images/arcban.gif"></td></tr>
<tr><td width=178><img src="$arcurl/images/arclogo.gif"></td>
<td width=306 valign=top>
<table width=304>
<tr><td bgcolor=ffffff><font color=000000 size=4><center><b>ERRORS</b></center></font></td></tr>
<tr><td><ul>@errors</ul></td></tr>
<tr><td><center><a href="$ENV{HTTP_REFERER}">BACK TO FORM</a></center></td></tr>
</table></td></tr></table></td></tr></table></center></font>
</body></html>
~;
exit;
}

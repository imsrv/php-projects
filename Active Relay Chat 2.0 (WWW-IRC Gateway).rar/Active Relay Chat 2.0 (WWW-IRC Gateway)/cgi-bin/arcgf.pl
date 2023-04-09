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
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title></title>
</head>
<body bgcolor="#0D027B">
<form method=post action="$cgi/arcpost.pl"><input type="hidden" name="username" value="$data{username}"><input type="hidden" name="channel" value="$data{channel}">
<table cellspacing=0 cellpadding=0 border=0 width="100%">
<tr><td><input type="text" name="message" size="50">&nbsp;
<input type="submit" value="send message">
</td></tr>
</table></form>
</body>
</html>
~;

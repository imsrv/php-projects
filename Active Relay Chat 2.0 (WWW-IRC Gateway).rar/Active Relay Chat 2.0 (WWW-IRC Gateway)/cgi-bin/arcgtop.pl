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
if (-e "$arcpath/bases/$data{username}.tpc")
{
open(F,"<$arcpath/bases/$data{username}.tpc");
@topic=<F>;
close(F);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<HTML>
<HEAD>
<!-- JavaScript to force auto-reload every x seconds -->
<SCRIPT LANGUAGE=JavaScript>
function TR()
{
setTimeout('location.reload()', 2500);
}
</SCRIPT>
</HEAD>
<BODY BGCOLOR="0D027B" onLoad="TR()">
<FONT color=ffffff face="SANS SERIF" size=2>
<center><font size=3><b>TOPIC:</b></font><br>@topic</center>
</font>
</BODY>
</HTML>
~;
}
else
{
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title></title>
</head>
<body bgcolor="#0D027B">
<table border="0" celpadding="0" cellspacing="0" width="100%">
<tr><td align="center"><a href="$cgi/arcidx.pl" target="_top"><img src="$arcurl/images/dicrec.gif" width="200" height="50" border=0></a></td></tr>
</table>
</body>
</html>
~;
}

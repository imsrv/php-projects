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
open(F,"<$arcpath/bases/$data{username}.usr");
@users=<F>;
close(F);
@users=sort(@users);
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
<BODY BGCOLOR="000000" onLoad="TR()">
<FONT color=ffffff face="SANS SERIF" size=2>
~;
foreach (@users)
{
	print "$_<br>";
}
print qq~
</font>
</BODY>
</HTML>
~;

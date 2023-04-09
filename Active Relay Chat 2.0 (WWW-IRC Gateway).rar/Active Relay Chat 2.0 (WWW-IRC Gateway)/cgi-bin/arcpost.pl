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
open(F,"<$arcpath/bases/$data{username}.nic");
@nickname=<F>;
$nickname=$nickname[0];
close(F);
if ($data{message} ne "")
{
if ($data{message}=~/^\//)
{
	if ($data{message}=~/^\/topic/)
	{
		$data{message}=~s/\/topic //;
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "TOPIC #$data{channel} :$data{message}\n";
		close(F);
	}
	elsif ($data{message}=~/^\/nick/)
	{
		($command,$message)=split(" ",$data{message});
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "NICK $message\n";
		close(F);
	}
	elsif ($data{message}=~/^\/action/)
	{
		($command,@message)=split(" ",$data{message});
		$message=join(" ",@message);
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "PRIVMSG #$data{channel} :\001ACTION $message\001\n";
		close(F);
		open(F,">>$arcpath/bases/$data{username}.msg");
		print F "<font color=\"#FF00FF\">* <b>$nickname</b> $message</font><br>\n";
		close(F);
	}
	elsif ($data{message}=~/^\/version/)
	{
		open(F,">>$arcpath/bases/$data{username}.msg");
		print F "<font color=lightblue>*** VERSION: $version</font><br>\n";
		close(F);
	}
	elsif ($data{message}=~/^\/whois/)
	{
		($command,$message)=split(" ",$data{message});
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "WHOIS $message\n";
		close(F);
	}
	elsif ($data{message}=~/^\/mode/)
	{
		($command,@message)=split(" ",$data{message});
		$message=join(" ",@message);
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "MODE #$data{channel} $message\n";
		close(F);
	}
	elsif ($data{message}=~/^\/quit/)
	{
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "QUIT\n";
		close(F);
	}
	elsif ($data{message}=~/^\/msg/)
	{
		($command,$user,@message)=split(" ",$data{message});
		$message=join(" ",@message);
		$user=~s/\@//;
		open(F,">>$arcpath/bases/$data{username}.msg");
		print F "<font color=yellow><b>-\&gt; \*$user\* :</b>$message</font><br>\n";
		close(F);
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "PRIVMSG $user :$message\n";
		close(F);
	}
	elsif ($data{message}=~/^\/notice/)
	{
		($command,$user,@message)=split(" ",$data{message});
		$message=join(" ",@message);
		$user=~s/\@//;
		open(F,">>$arcpath/bases/$data{username}.msg");
		print F "<font color=yellow><b>-\&gt; -$user- :</b>$message</font><br>\n";
		close(F);
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "NOTICE $user :$message\n";
		close(F);
	}
	elsif ($data{message}=~/^\/kick/)
	{
		($command,$user,@message)=split(" ",$data{message});
		$message=join(" ",@message);
		$user=~s/\@//;
		open(F,">>$arcpath/bases/$data{username}.cmd");
		print F "KICK #$data{channel} $user :$message\n";
		close(F);
	}
	else
	{
		open(F,">>$arcpath/bases/$data{username}.sts");
		print F "Unknown or restricted command<br>\n";
		close(F);
	}
}
else
{
	open(F,">>$arcpath/bases/$data{username}.cmd");
	print F "PRIVMSG #$data{channel} :$data{message}\n";
	close(F);
	open(F,">>$arcpath/bases/$data{username}.msg");
	print F "<b>$nickname:</b> $data{message}<br>\n";
	close(F);
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

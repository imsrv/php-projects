#!/bin/perl
use Socket;
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
else {$data=$ENV{QUERY_STRING};}
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
$sockaddr = 'S n a4 x8';
($server,$port)=split(":",$data{server});
$nickname=$data{username};
$username=$data{username};
$realname=$data{realname};
$channel=$data{channel};

&open_port;
&registration;

######################################################################
# Processing                                                         #
######################################################################
$i=0;
while ($i<$maxscope)
{
	$i++;
	$res=&irc_rcv;
	@res=split("\r\n",$res);
	foreach $res(@res)
	{
		if ($res=~/^PING/)
		{
			open(F,">>$arcpath/bases/$username.sts");
			print F "<br><font color=green>Ping? Pong...</font><br>\n";
			close(F);
			$res=~s/PING/PONG/;
			$len=length($res);
			syswrite(S,$res,$len);
			next;
		}
		if ($res=~/PRIVMSG #$channel/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			if ($msg=~/^\001ACTION/)
			{
				$msg=~s/\001ACTION//;
				$msg=~s/\001//;
				$cs=15;
				while($cs>=0)
				{
					$inscode="<font color=\"$colors[$cs]\">";
					$msg=~s/\003$cs/$inscode/g;
					$cs--;
				}
				$msg=~s/\037(.+)\037/<u>$1<\/u>/;
				$msg=~s/\037//g;
				$msg=~s/\002(.+)\002/<b>$1<\/b>/;
				$msg=~s/\002//g;
				print F "<font color=\"#FF00FF\">* <b>$who</b> $msg</font><br>\n";
			}
			else
			{
				$cs=15;
				while($cs>=0)
				{
					$inscode="<font color=\"$colors[$cs]\">";
					$msg=~s/\003$cs/$inscode/g;
					$cs--;
				}
				$msg=~s/\037(.+)\037/<u>$1<\/u>/;
				$msg=~s/\037//g;
				$msg=~s/\002(.+)\002/<b>$1<\/b>/;
				$msg=~s/\002//g;
				print F "<font color=white><b>$who:</b> $msg</font><br>\n";
			}
			close(F);
			next;
		}
		if ($res=~/PRIVMSG $nickname/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			if ($msg=~/^\001ACTION/)
			{
				$msg=~s/\001ACTION//;
				$msg=~s/\001//;
				$cs=15;
				while($cs>=0)
				{
					$inscode="<font color=\"$colors[$cs]\">";
					$msg=~s/\003$cs/$inscode/g;
					$cs--;
				}
				$msg=~s/\037(.+)\037/<u>$1<\/u>/;
				$msg=~s/\037//g;
				$msg=~s/\002(.+)\002/<b>$1<\/b>/g;
				$msg=~s/\002//g;
				print F "<font color=\"#FF00FF\">* <b>$who</b> $msg (Private)</font><br>\n";
			}
			elsif ($msg=~/^\001PING/)
			{
				$msg=~s/\001PING//;
				$msg=~s/\001//;
				print F "<font color=\"#FF0000\"><b>[$who CTCP PING]</b></font><br>\n";
				$msg="NOTICE $who :\001PING $msg\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			elsif ($msg=~/^\001VERSION/)
			{
				print F "<font color=\"#FF0000\"><b>[$who CTCP VERSION]</b></font><br>\n";
				$msg="NOTICE $who :\001VERSION $version\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			elsif ($msg=~/^\001FINGER/)
			{
				print F "<font color=\"#FF0000\"><b>[$who CTCP FINGER]</b></font><br>\n";
				$msg="NOTICE $who :\001FINGER $realname\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			elsif ($msg=~/^\001TIME/)
			{
				print F "<font color=\"#FF0000\"><b>[$who CTCP TIME]</b></font><br>\n";
				($day,$date,$month,$time,$year)=split(" ",scalar localtime);
				$msg="NOTICE $who :\001TIME $time\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			elsif ($msg=~/^\001DCC CHAT/)
			{
				print F "<font color=\"#FF0000\"><b>[$who DCC CHAT REQUEST - NOT SUPPORTED]</b></font><br>\n";
				$msg="NOTICE $who :\001DCC CHAT not supported\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			elsif ($msg=~/^\001DCC SEND/)
			{
				print F "<font color=\"#FF0000\"><b>[$who DCC SEND REQUEST - NOT SUPPORTED]</b></font><br>\n";
				$msg="NOTICE $who :\001DCC SEND not supported\001\n";
				$len=length($msg);
				syswrite(S,$msg,$len);
			}
			else
			{
				$cs=15;
				while($cs>=0)
				{
					$inscode="<font color=\"$colors[$cs]\">";
					$msg=~s/\003$cs/$inscode/g;
					$cs--;
				}
				$msg=~s/\037(.+)\037/<u>$1<\/u>/;
				$msg=~s/\037//g;
				$msg=~s/\002(.+)\002/<b>$1<\/b>/g;
				$msg=~s/\002//g;
				print F "<font color=yellow><b>$who:</b> $msg (Private)</font><br>\n";
			}
			close(F);
			next;
		}
		if ($res=~/NOTICE/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			if ($msg=~/^\001PING/)
			{
				$msg=~s/\001PING//;
				$msg=~s/\001//;
				print F "<font color=\"#FF0000\"><b>[$who PING reply]: $msg</b></font><br>\n";
			}
			elsif ($msg=~/^\001VERSION/)
			{
				$msg=~s/\001VERSION//;
				$msg=~s/\001//;
				print F "<font color=\"#FF0000\"><b>[$who VERSION reply]: $msg</b></font><br>\n";
			}
			elsif ($msg=~/^\001FINGER/)
			{
				$msg=~s/\001FINGER//;
				$msg=~s/\001//;
				print F "<font color=\"#FF0000\"><b>[$who FINGER reply]: $msg</b></font><br>\n";
			}
			elsif ($msg=~/^\001TIME/)
			{
				$msg=~s/\001TIME//;
				$msg=~s/\001//;
				print F "<font color=\"#FF0000\"><b>[$who TIME reply]: $msg</b></font><br>\n";
			}
			else
			{
				$cs=15;
				while($cs>=0)
				{
					$inscode="<font color=\"$colors[$cs]\">";
					$msg=~s/\003$cs/$inscode/g;
					$cs--;
				}
				$msg=~s/\037(.+)\037/<u>$1<\/u>/;
				$msg=~s/\037//g;
				$msg=~s/\002(.+)\002/<b>$1<\/b>/g;
				$msg=~s/\002//g;
				print F "<font color=yellow><b>$who:</b> $msg (Notice)</font><br>\n";
			}
			close(F);
			next;
		}
		if ($res=~/KICK #$channel $nickname/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=red><b>*** You was kicked by $who ($msg)</b></font><br>\n";
			close(F);
			&error("Closing link (Disconnected)");
		}
		if ($res=~/KICK/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			($com,$cmd,$ch,$un)=split(" ",$garbage);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=grey><b>*** $un was kicked by $who ($msg)</b></font><br>\n";
			close(F);
			open(F,"<$arcpath/bases/$username.usr");
			@users=<F>;
			close(F);
			foreach (@users)
			{
				chop;
				push(@nusers,"$_\n") if ($_ ne $un && $_ ne "\@$un");
			}
			open(F,">$arcpath/bases/$username.usr");
			print F @nusers;
			close(F);
			@nusers=();
			next;
		}
		if ($res=~/PART/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=grey><b>*** $who has left the channel</b></font><br>\n";
			close(F);
			open(F,"<$arcpath/bases/$username.usr");
			@users=<F>;
			close(F);
			foreach (@users)
			{
				chop;
				push(@nusers,"$_\n") if ($_ ne $who && $_ ne "\@$who");
			}
			open(F,">$arcpath/bases/$username.usr");
			print F @nusers;
			close(F);
			@nusers=();
			next;
		}
		if ($res=~/NICK/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			$nickname=$msg[2] if ($who eq $nickname);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=lightblue><b>*** $who is now known as $msg[2]</b></font><br>\n";
			close(F);
			open(F,"<$arcpath/bases/$username.usr");
			@users=<F>;
			close(F);
			foreach(@users)
			{
				$_=~s/$who/$msg[2]/ if ($_ eq "$who\n" || $_ eq "\@$who\n" || $_ eq "+$who\n");
			}
			open(F,">$arcpath/bases/$username.usr");
			print F @users;
			close(F);
			open(F,">$arcpath/bases/$username.nic");
			print F "$nickname";
			close(F);
			next;
		}
		if ($res=~/QUIT/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=grey><b>*** $who has quit IRC ($msg)</b></font><br>\n";
			close(F);
			open(F,"<$arcpath/bases/$username.usr");
			@users=<F>;
			close(F);
			foreach (@users)
			{
				chop;
				push(@nusers,"$_\n") if ($_ ne $who && $_ ne "\@$who");
			}
			open(F,">$arcpath/bases/$username.usr");
			print F @nusers;
			close(F);
			@nusers=();
			next;
		}
		if ($res=~/JOIN/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=grey><b>*** $who has joined the channel</b></font><br>\n";
			close(F);
			open(F,">>$arcpath/bases/$username.usr");
			print F "$who\n";
			close(F);
			next;
		}
		if ($res=~/TOPIC/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			shift(@msg);
			shift(@msg);
			$msg=join(":",@msg);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=lightblue><b>*** $who change topic to '$msg'</b></font><br>\n";
			close(F);
			open(F,">$arcpath/bases/$username.tpc");
			print F "$msg";
			close(F);
			next;
		}
		if ($res=~/MODE/)
		{
			@msg=split(":",$res);
			($who,$garbage)=split("!",$msg[1]);
			@msg=split(" ",$garbage);
			open(F,">>$arcpath/bases/$username.msg");
			print F "<font color=lightblue><b>*** $who set mode $msg[3] $msg[4]</b></font><br>\n";
			close(F);
			if ($msg[3] eq "+o")
			{
				open(F,"<$arcpath/bases/$username.usr");
				@users=<F>;
				close(F);
				foreach (@users)
				{
					$_="\@$msg[4]\n" if ($_ eq "$msg[4]\n");
				}
				open(F,">$arcpath/bases/$username.usr");
				print F @users;
				close(F);
			}
			if ($msg[3] eq "-o")
			{
				open(F,"<$arcpath/bases/$username.usr");
				@users=<F>;
				close(F);
				foreach (@users)
				{
					$_="$msg[4]\n" if ($_ eq "\@$msg[4]\n");
				}
				open(F,">$arcpath/bases/$username.usr");
				print F @users;
				close(F);
			}
			next;
		}
		open(F,">>$arcpath/bases/$username.sts");
		($fir,$sec,@msg)=split(":",$res);
		$msg=join(":",@msg);
		print F "$msg<br>\n";
		close(F);
	}
	$size=-s "$arcpath/bases/$username.cmd";
	if ($size>0)
	{
		$i=0;
		open(F,"<$arcpath/bases/$username.cmd");
		@cmds=<F>;
		close(F);
		open(F,">$arcpath/bases/$username.cmd");
		close(F);
		foreach(@cmds)
		{
			if ($_=~/^QUIT/)
			{
				$res="QUIT :$quitmessage\n";
				$len=length($res);
				syswrite(S,$res,$len);
				close(S);
				&error("Leaving (Quit)");
			}
			$len=length($_);
			syswrite(S,$_,$len);
		}
	}
}
&error("Disconnected (Ping Timeout)");

######################################################################
# Subrotines                                                         #
######################################################################

sub registration
{
if ($server=~/undernet/)
{
	$msg="USER $username \"\" \"$server\" :$realname\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$msg="NICK $nickname\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$count=0;
	while($count<1000)
	{
		$count++;
		$res=&irc_rcv;
		@res=split("\r\n",$res);
		foreach $res(@res){
		if ($res=~/433/)
		{
			srand;
			$num=int(rand(999999));
			$nickname="ARC$num";
			$msg="NICK ARC$num\n";
			$len=length($msg);
			syswrite(S,$msg,$len);
			open(F,">>$arcpath/bases/$username.sts");
			print F "Nickname <b>$username</b> is already in use<br>\nConnecting using <b>ARC$num</b><br>\n";
			close(F);
		}
		if ($res=~/^PING/){$pingflag=1;last;}
		}
		&error ("Closing link: disconnected") if ($count>100);
		last if ($pingflag);
	}
	($res1,$res)=split("PING",$res);
	open(F,">>$arcpath/bases/$username.sts");
	print F "Connected to <b>$server</b><br>\n<font color=green>Ping? Pong...</font><br>\n";
	close(F);
	open(F,">$arcpath/bases/$username.nic");
	print F "$nickname";
	close(F);
	$msg="PONG $res";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$count=0;
	while($count<1000)
	{
		$count++;
		$res=&irc_rcv;
		@res=split("\r\n",$res);
		open(F,">>$arcpath/bases/$username.sts");
		foreach $line (@res)
		{
			$flag=2 if ($line=~/451/ || $line=~/465/);
			$flag=1 if ($line=~/422/ || $line=~/376/);
			@line=split(":",$line);
			if ($line[1]=~/NOTICE $nickname/){print F "<br><font color=brown>$line[2] $line[3]</font><br><br>\n";}
			else {print F "$line[2] $line[3]<br>\n";}
		}
		last if ($flag);
		&error ("Closing link: disconnected") if ($count>100);
	}
	&error ("Closing link: disconnected") if ($flag==2);
	$msg="JOIN #$channel\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$count=0;
	$flag=0;
	while($count<1000)
	{
		$count++;
		$res=&irc_rcv;
		$resu.=$res;
		$flag=1 if ($res=~/471/ || $res=~/473/ || $res=~/474/ || $res=~/475/);
		$flag=2 if ($res=~/366/);
		last if ($flag);
		&error ("Closing link: disconnected") if ($count>100);
	}
	@res=split("\r\n",$resu);
	open(F,">>$arcpath/bases/$username.sts");
	$flag=0;
	foreach $line (@res)
	{
		if ($line=~/332/)
		{
			($first,$sec,$thir)=split(":",$line);
			open(FL,">$arcpath/bases/$username.tpc");
			print FL "$thir";
			close(FL);
		}	
		if ($line=~/353/)
		{
			($first,$sec,$thir)=split(":",$line);
			@users=split(" ",$thir);
			open(FL,">>$arcpath/bases/$username.usr");
			foreach(@users){print FL "$_\n";}
			close(FL);
		}	
		@line=split(":",$line);
		print F "$line[2]<br>\n";
	}
	close(F);
	&error ("Closing link (Disconnected)") if ($flag==1);
}
else
{
	$msg="USER $username \"\" \"$server\" :$realname\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$msg="NICK $nickname\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$count=0;
	while($count<1000)
	{
		$count++;
		$res=&irc_rcv;
		@res=split("\r\n",$res);
		foreach $res(@res){
		if ($res=~/433/)
		{
			srand;
			$num=int(rand(999999));
			$nickname="ARC$num";
			$msg="NICK ARC$num\n";
			$len=length($msg);
			syswrite(S,$msg,$len);
			open(F,">>$arcpath/bases/$username.sts");
			print F "Nickname <b>$username</b> is already in use<br>\nConnecting using <b>ARC$num</b><br>\n";
			close(F);
		}
		if ($res=~/^PING/)
		{
			($res1,$res)=split("PING",$res);
			open(F,">>$arcpath/bases/$username.sts");
			print F "Connected to <b>$server</b><br>\n<font color=green>Ping? Pong...</font><br>\n";
			close(F);
			open(F,">$arcpath/bases/$username.nic");
			print F "$nickname";
			close(F);
			$msg="PONG $res";
			$len=length($msg);
			syswrite(S,$msg,$len);
		}
		$flag=2 if ($res=~/451/ || $res=~/465/);
		$flag=1 if ($res=~/422/ || $res=~/376/);
		@line=split(":",$res);
		open(F,">>$arcpath/bases/$username.sts");
		if ($line[1]=~/NOTICE $nickname/){print F "<br><font color=brown>$line[2] $line[3]</font><br><br>\n";}
		else {print F "$line[2] $line[3]<br>\n";}
		close(F);
		}
		&error ("Closing link: disconnected") if ($count>100);
		last if ($flag);
	}
	&error ("Closing link: disconnected") if ($flag==2);
	$msg="JOIN #$channel\n";
	$len=length($msg);
	syswrite(S,$msg,$len);
	$count=0;
	$flag=0;
	while($count<1000)
	{
		$count++;
		$res=&irc_rcv;
		$resu.=$res;
		$flag=1 if ($res=~/471/ || $res=~/473/ || $res=~/474/ || $res=~/475/);
		$flag=2 if ($res=~/366/);
		last if ($flag);
		&error ("Closing link: disconnected") if ($count>100);
	}
	@res=split("\r\n",$resu);
	open(F,">>$arcpath/bases/$username.sts");
	$flag=0;
	foreach $line (@res)
	{
		if ($line=~/332/)
		{
			($first,$sec,$thir)=split(":",$line);
			open(FL,">$arcpath/bases/$username.tpc");
			print FL "$thir";
			close(FL);
		}	
		if ($line=~/353/)
		{
			($first,$sec,$thir)=split(":",$line);
			@users=split(" ",$thir);
			open(FL,">>$arcpath/bases/$username.usr");
			foreach(@users){print FL "$_\n";}
			close(FL);
		}	
		@line=split(":",$line);
		print F "$line[2]<br>\n";
	}
	close(F);
	&error ("Closing link (Disconnected)") if ($flag==1);
}
}

sub open_port
{
	&error("Internal server error, please try again later or contact to <a href=\"mailto:$email\">administrator</a> if you got this problem several times") unless (socket(S,PF_INET,SOCK_STREAM,(getprotobyname('tcp'))[2]));
	$farg=sockaddr_in($port,inet_aton($server));
	&error("Can't connect to IRC Server, please try again later or contact to <a href=\"mailto:$email\">administrator</a> if you got this problem several times") unless (connect(S,$farg));
}
sub irc_rcv
{
$res=<S>;
return $res;
}
sub error
{
	@error=@_;
	open(F,">>$arcpath/bases/$username.sts");
	print F "@error<br>\n";
	close(F);
	unlink ("$arcpath/bases/$data{username}.msg");
	unlink ("$arcpath/bases/$data{username}.nic");
	unlink ("$arcpath/bases/$data{username}.tpc");
	unlink ("$arcpath/bases/$data{username}.usr");
	unlink ("$arcpath/bases/$data{username}.cmd");
	close(S);
	print "content-type: text/html\n\n";
	print "STATUS: Disconnected";
	exit;
}

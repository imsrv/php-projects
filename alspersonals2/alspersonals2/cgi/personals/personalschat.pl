#!/usr/bin/perl
##############################################################################################################################
require "configdat.lib";

##############################################################################################################################
use CGI::Carp qw(fatalsToBrowser);


##############################################################################################################################
&formdatparser;
use CGI qw(:standard);
$query = new CGI;
##############################################################################################################################
if(($FORM{'login'} eq "Send Message")&&($allownonmemberchatting eq "on")){&writechatterlog;}
if(($FORM{'login'} eq "Send Message")&&($allownonmemberchatting eq "off")){&checkchatter;}
if($FORM{'sendmessage'} eq "Send Message"){&startchat;}
if($FORM{'logoff'} eq "Logoff"){&removechatter;}
if($FORM{'refresh'} eq "Refresh"){&startchat;}
if (($FORM{'showthisprof'} ne "") || ($ENV{'QUERY_STRING'} =~ /showthisprof/))
{&showthisprof;	}
if (($FORM{'pchat'} ne "") || ($ENV{'QUERY_STRING'} =~ /pchat/))
{&pchat;}

##############################################################################################################################
sub startchat {

print "Content-type: text/html\nPragma: no-cache\n\n";
print "

<link rel=stylesheet type=text/css href=\"$personalsurl/styles.css\">

<title>Personals Chat</title></head>

<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=ffffff text=000000>\n";
&interim;
print "</blockquote></font>\n";

print "</td></tr></table>
</BODY></html>
\n";
exit(0);
}

##############################################################################################################################
sub alreadyfiled{
	$FORM{'chatlocale'} =~ s/\W//g;
	return 0 unless open(FILE, "$personalsdir/chatdocs/$FORM{'chatlocale'}$croomext");
	@lines=<FILE>;
	close(FILE);
	return 1;
}
##############################################################################################################################
sub timecode {
	$curtm = localtime;
	@tm = split(/ +/,$curtm);
	@ck = split(/:/,$tm[3]);
	$tmofdy = 'am';
	if ($ck[0] > 11)
	{ $tmofdy = 'pm'; }
	if ($ck[0] == 0)
	{ $ck[0] = 12; }
	if ($ck[0] > 12)
	{ $ck[0] -= 12; }
	else
	{ $ck[0] += 0; }
}
##############################################################################################################################
sub gettemplate {
print << "EOF";
<style>   
BODY { 	    
scrollbar-face-color: $chatscrollbarfacecolor;  	    
scrollbar-shadow-color: $chatscrollbarshadowcolor; 	    
scrollbar-highlight-color: $chatscrollbarhighlightcolor;  	    
scrollbar-3dlight-color: $chatscrollbar3dlightcolor; 	    
scrollbar-darkshadow-color: $chatscrolldarkshadowcolor;  	    
scrollbar-track-color: $chatscrollbartrackcolor; 	    
scrollbar-arrow-color: $chatscrollbararrowcolor; 	    
}   
</style>

<link rel=stylesheet type=text/css href=$personalsurl/styles.css>
<table cellpadding=2 cellspacing=2 width=100% bgcolor=ffffff><tr>
<td width=25% bgcolor=$chatroomthemecolor valign="top"><center>
<table width=100% cellpadding=0 cellspacing=0 border=0><tr>
<td width=5%>&nbsp;</td>
<td width=90%>
<center><br>
<a href="$cgiurl/personals.pl?launchindex"><font size=2 face=verdana><b>
Back to $sitename</a></b></center>

</td>
<td width=5%>&nbsp;</td></tr></table>

</td>
<td width=75%><blockquote>
<CENTER><TABLE width=75% height=35 CELLSPACING=0 CELLPADDING=0 bgcolor=$chatbarcolor>
		<TR><td width=10>&nbsp;</td>
		<td><font size=2 face=verdana color=$chatbarfontcolor>Message</font></td>
		<td width=10><FORM ACTION="$cgiurl/personalschat.pl" METHOD="POST"></td>
		<td><input name=message type=text  size=45 class="box"></td></tr></table></center>

		<CENTER><TABLE width=75% CELLSPACING=0 CELLPADDING=0>
		<TR><TD>
		<nobr>
		<input name=username type=hidden value="$FORM{'username'}">
		<input name=chatlocale type=hidden value="$FORM{'chatlocale'}">
		<input name=chperson type=hidden value="$FORM{'chperson'}">
		<td><input name=chatfontcolor type=hidden value="$FORM{'chatfontcolor'}">
		<input type=submit name="sendmessage" value="Send Message" class="button">
		</form></nobr>
		</TD><TD align="right">
		<nobr><FORM ACTION="$cgiurl/personalschat.pl" METHOD="POST">
		<input name=username type=hidden value="$FORM{'username'}">
		<input name=chatlocale type=hidden value="$FORM{'chatlocale'}">
		<input type=submit name="logoff" value="Logoff" class="button">
		</form></nobr>
		</TD>
		</TR>
		</TABLE><b><font size=1 face=verdana>***You <font color=red>CANNOT</font>
use the <font color=red>"Enter"</font> or <font color=red>"Return"</font> key on your
keyboard to send your message. You <font color=red>MUST</font> use the <font color=red>"Send Message"</font> button!<br></font></CENTER><BR>
EOF
}
##############################################################################################################################
sub formdatparser {
	$buffer = "";
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs=split(/&/,$buffer);
	foreach $pair (@pairs)
	{
		@a = split(/=/,$pair);
		$name=$a[0];
		$value=$a[1];
		$value =~ s/\+/ /g;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/~!/ ~!/g;
		$value =~ s/\</\&lt\;/g;  
		$value =~ s/\>/\&gt\;/g;  
		$value =~ s/[\r\n]//g;
		push (@data,$name);
		push (@data,$value);
	}
	%FORM=@data;
	%FORM;

}
##############################################################################################################################
sub interim {
if (&alreadyfiled) {
	&timecode;
	&gettemplate;
	if($FORM{'chperson'} eq ""){$FORM{'chperson'}="empty.jpg";}
	if($FORM{'chatfontcolor'}eq ""){$chatfontcolor="000000";}
	if ($FORM{'message'} ne "") {
	$commenttoad = "<center><table width=80%><tr><td><table width=100% cellpadding=2 cellspacing=2 border=0><tr><td width=10%><img src=\"$chatpersonalitiesurl/$FORM{'chperson'}\" border=\"0\"></td><td width=15%><B><font size=1 face=verdana color=$usernamedisplayfontcolor>$FORM{'username'}:</B></td><td width=60%><font size=1 face=verdana color=$FORM{'chatfontcolor'}> \"$FORM{'message'}\" </font></td><td width=15%><font size=1 face=verdana color=$timedisplayfontcolor>($curtm[0] $ck[0]:$ck[1]$tmofdy)</font></td></tr></table></td></tr></table></center>\n";
	$headstart="<html><head><META HTTP-EQUIV=Refresh CONTENT=5><META HTTP-EQUIV=Pragma CONTENT=no-cache><style>BODY { 	    scrollbar-face-color: $chatscrollbarfacecolor;  	    scrollbar-shadow-color: $chatscrollbarshadowcolor; 	    scrollbar-highlight-color: $chatscrollbarhighlightcolor;  	    scrollbar-3dlight-color: $chatscrollbar3dlightcolor; 	    scrollbar-darkshadow-color: $chatscrolldarkshadowcolor;  	    scrollbar-track-color: $chatscrollbartrackcolor; 	    scrollbar-arrow-color: $chatscrollbararrowcolor; 	    }   </style></head><body bgcolor=ffffff>";
	open (NEW, ">$personalsdir/chatdocs/$FORM{'chatlocale'}$croomext");
	print NEW "$headstart\n";
	&processinfo_post_write;
	close NEW;
	}
	else { 
	for ($i = 1; $i < 8; $i++)
	{
	print "$lines[$i]";
	}
	}
	}
	else
	{
	&gettemplate;
	print "<font size=1 face=verdana>The chatroom you trying to enter was not found.<br><br>\n";
	print "Please choose a  different room.</font><br><a href=\"javascript:history.go(-1)\"><font size=1 face=verdana color=maroon>BACK</font></a>\n";
	}
	}
##############################################################################################################################
sub processinfo_post_write {
if ($progcom) {
		print NEW "$commenttoad";
		for ($i = 1; $i < 8; $i++)
		{
			print NEW "$lines[$i]";
					}
		}
	else {
		for ($i = 2; $i < 8; $i++)
		{
			print NEW "$lines[$i]";
					}
		print NEW $commenttoad;
		
		}
}

##############################################################################################################################
sub writechatterlog {
&startchat;
}


##############################################################################################################################
sub logoff {
if (&alreadyfiled) {
	&timecode;
	if($FORM{'chperson'} eq ""){$FORM{'chperson'}="empty.jpg";}
	if($form{'chatfontcolor'}eq ""){$chatfontcolor="000000";}
	$commenttoad = "<center><table width=80%><tr><td><table width=100% cellpadding=2 cellspacing=2 border=0><tr><td width=10%><img src=\"$chatpersonalitiesurl/loggedoff.jpg\" border=\"0\"></td><td width=60%><b><font size=1 face=verdana color=$FORM{'chatfontcolor'}> $FORM{'username'} has logged off!</b> </font></td><td width=15%>&nbsp;</td><td width=15%><font size=1 face=verdana color=$timedisplayfontcolor>($curtm[0] $ck[0]:$ck[1]$tmofdy)</font></td></tr></table></td></tr></table></center>\n";
		$headstart="<html><head><META HTTP-EQUIV=Refresh CONTENT=5><META HTTP-EQUIV=Pragma CONTENT=no-cache><style>BODY { 	    scrollbar-face-color: $chatscrollbarfacecolor;  	    scrollbar-shadow-color: $chatscrollbarshadowcolor; 	    scrollbar-highlight-color: $chatscrollbarhighlightcolor;  	    scrollbar-3dlight-color: $chatscrollbar3dlightcolor; 	    scrollbar-darkshadow-color: $chatscrolldarkshadowcolor;  	    scrollbar-track-color: $chatscrollbartrackcolor; 	    scrollbar-arrow-color: $chatscrollbararrowcolor; 	    }   </style></head><body bgcolor=ffffff>";
	open (NEW, ">$chatroomdir/$FORM{'chatlocale'}$croomext");
	print NEW "$headstart\n";
	}
	if ($progcom) {
		print NEW "$commenttoad";
		for ($i = 1; $i < 8; $i++)
		{
			print NEW "$lines[$i]";
					}
		}
		else {
		for ($i = 2; $i < 8; $i++)
		{
			print NEW "$lines[$i]";
					}
			print NEW $commenttoad;
		
		}
	close NEW;


	
print "Location: $cgiurl/personals.pl?launchindex\n\n";

}

sub kickout {
print "Location: $chatroomurl/kickedout.html\n\n";
}


sub checkchatter {

if(-e "$users/$FORM{'username'}.txt"){
&writechatterlog;}
else {

print "Location: $personalsurl/chatdocs/invalidchatter.html\n\n";

}
}

sub removechatter {
&logoff;
}


sub chatterexists {
print "Content-type:text/html\n\n";
print << "EOF";
<style>   
BODY { 	    
scrollbar-face-color: $chatscrollbarfacecolor;  	    
scrollbar-shadow-color: $chatscrollbarshadowcolor; 	    
scrollbar-highlight-color: $chatscrollbarhighlightcolor;  	    
scrollbar-3dlight-color: $chatscrollbar3dlightcolor; 	    
scrollbar-darkshadow-color: $chatscrolldarkshadowcolor;  	    
scrollbar-track-color: $chatscrollbartrackcolor; 	    
scrollbar-arrow-color: $chatscrollbararrowcolor; 	    
}   
</style>

<link rel=stylesheet type=text/css href=$personalsurl/includes/styles.css>
<table cellpadding=2 cellspacing=2 width=100% bgcolor=ffffff><tr>
<td width=25% bgcolor=$chatroomthemecolor valign="top"><center>
<table width=100% cellpadding=0 cellspacing=0 border=0><tr>
<td width=5%>&nbsp;</td>
<td width=90%>
<center>
<a href="$siteurl/apersonalstouch/index.html"><font size=2 face=verdana><b>
Back to $sitename</a></b></center>
$chatlogo

</td>
<td width=5%>&nbsp;</td></tr></table>

</td>
<td width=75%><blockquote>
<font size=2 face=verdana color=red>
<FORM ACTION="$cgiurl/personalschat.pl" METHOD="POST">
There is already someone chatting under the name <b>$FORM{'username'}</b>. Please choose another name.</font>
<CENTER><TABLE width=75% height=35 CELLSPACING=0 CELLPADDING=0>
		<TR>
		<td><font size=2 face=verdana color=$chatbarfontcolor>Chatting As:</font></td>
		<td><input name=username type=text size=25></td>
		</tr><tr>
		<td><font size=2 face=verdana color=$chatbarfontcolor>Logon Greeting:</font></td>
		<td><input name=message type=text  size=25></td></tr><tr>
		<td><input name=chatlocale type=hidden value="$FORM{'chatlocale'}">
		<input name=chperson type=hidden value="$FORM{'chperson'}">
		<input name=chatfontcolor type=hidden value="$FORM{'chatfontcolor'}"></td>
		<td align="right">
		<input type=submit name="login" value="Send Message" class="button">
		</form></nobr>
		</TD>		</TR>
		</TABLE><b>
EOF
exit;
}


sub pchat {

&createroom;

print "Location:$cgiurl/chatdocs/troom/index.pl\n\n";

}

sub createroom {


copy $perscgidir/chatdocs/private $perscgidir/chatdocs/troom;

open (FILE, ">>$chatroomsdir/$FORM{'username'}.html") || die "Cannot open $chatroomsdir/$FORM{'username'}.html\n";
flock (FILE, 2) or die "can't lock file\n";  
print FILE "";  
close (FILE);


}
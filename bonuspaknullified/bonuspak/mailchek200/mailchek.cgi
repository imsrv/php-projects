#!/usr/bin/perl
# --------------------------------------------------------------------
#
#                         MailChek Version 2.00
#
#                             Main program
#                          Supplied by  Virus
#                          Nullified by CyKuH
#
# Copyright  ©2001-2002 Chez Surette Art, All Rights Reserved
#
# Installation or use of this software constitutes acceptance of the
# terms of the Licence agreement contained in the accompanying file
# 'Licence.txt'. This agreement is a legal contract, which specifies
# the terms of the license and warranty limitation between you and
# Chez Surette Art. Please read carefully the terms and conditions
# contained in the Licence before installing or using this software.
# Unless you have a different License agreement with Chez Surette Art,
# installation or use of this software signifies your acceptance of
# the License agreement and warranty limitation terms contained therein.
# If you do not agree to the terms of the agreement, promptly delete
# and destroy all copies of this software.
#
#    Filename : mailchek.cgi
# --------------------------------------------------------------------

##################  DO NOT EDIT BELOW THIS LINE!!  ###################

use Net::POP3;
use MIME::Base64;
use CGI;
use CGI::Carp qw(fatalsToBrowser); # Useful for debugging
require 'mailchek.cfg';
require 'cookie.lib';
require 'mailchek.lib';

##############  Initialization and switching logic  ##################

$scriptname = $ENV{'SCRIPT_NAME'};

## Required by MailChek - DO NOT ALTER!
$titletag = '<!-- MAILCHEK TITLE -->';
$headtag = '<!-- MAILCHEK HEADER -->';
$bodytag = '<!-- MAILCHEK BODY -->';
$foottag = '<!-- MAILCHEK FOOTER -->';

CGI::ReadParse(*form);

if ($form{'action'} eq 'login' or $form{'action'} eq 'logout' )  {
print "Content-type: text/html\n";
}
else {print "Content-type: text/html\n\n"; }

   
&Expire ($tempdir, $templife); # Delete aged temp files
&upload if ($form{'option'} eq 'upload'); # Upload attachments first

if ($form{'action'} eq 'login') {&login;}
elsif ($form{'action'} eq 'inbox') {&inbox;}
elsif ($form{'action'} eq 'killmail') { &killmail; }
elsif ($form{'action'} eq 'showmail') { &showmail; }
elsif ($form{'action'} eq 'forward') { &forwardmail; }
elsif ($form{'action'} eq 'postforward') { &postforward; }
elsif ($form{'action'} eq 'reply') { &replymail; }
elsif ($form{'action'} eq 'compose') { &compose; }
elsif ($form{'action'} eq 'postmail') { &postmail; }
elsif ($form{'action'} eq 'logout') { &logout; }
elsif ($form{'action'} eq 'help') { &help; }

else {
   &printHeader;
   print "</td></tr></table></center>";
   &printFooter;
   exit;
}

print "</td></tr></table></center>";
&printFooter;

while ($_ = shift @page)  {
   print $_;
}

############## Print menu
sub printHeader   {
print <<"EOF";
<center>
<table width=90%>
  <tr>
    <td width=90% $titlebg>
    <table width=100%>
      <tr>
        <td width=10% align=left>
        <font face="arial,verdana" size=5 color=$titlefontcolor><b>$_[0]</b></font>
        </td>
        <td width=90% align=center><font size=2 color=$msgfontcolor>&nbsp;
EOF

print "Previous action: $bulletin" if $bulletin;

print <<EOF;
         </font>
        </td>
      </tr>
    </table>
    </td>
    <td width=10% bgcolor=$logobg>
    <table width=100%>
      <tr>
        <td align=center>
        <font face="Times roman" size=6 color=$logofontcolor><b>MailChek</b></font>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>

<table width=90%>
  <tr align=center>
    <td width=10% valign=center $menubg>
    <table width="100%"cellpadding=0 cellspacing=0 border=0>
    <tr align=center>
    <td><font face="Arial black" size="2">
    <A HREF=$ENV{'SCRIPT_NAME'}?action=inbox><font color=$menufontcolor>
    Inbox</A></font> </td></tr>
    <tr align=center><td><font face="Arial black" size="2">
    <A HREF=$ENV{'SCRIPT_NAME'}?action=compose>
    <font color=$menufontcolor>Compose</A></font> </td></tr>
    <tr align=center><td><font face="Arial black" size="2">
    <A HREF=$ENV{'SCRIPT_NAME'}?action=logout><font color=$menufontcolor>
    Logout</A></font> </td></tr>
    <tr align=center><td><font face="Arial black" size="2">
    <A HREF=$ENV{'SCRIPT_NAME'}?action=help><font color=$menufontcolor>Help</A> </td></tr>
    </table>
    </td>
    <td width=90%>
EOF

}

############### Print page footer
sub printFooter   {
print qq~<!--CyKuH,Virus-->
<p align=center><font size=1>MailChek&#174 Copyright&#169 2001-2002 
Chez Surette Art&#174. Version $version. 
 All rights reserved</font> </center></p>
~;
}

#################         Subroutines       ###################

### Store POP3 info in cookie for mailserver and to keep track of this user
sub login   {
if (&GetCompressedCookies('mailuser'))   {
   $popuser = $Cookies{'id'};
   $poppass = $Cookies{'pass'};
   $popserver = $Cookies{'server'};
   $popaddress = $Cookies{'address'};

   unless ($form{'remember'})   {
	&SetCompressedCookies('mailuser', 'id',$popuser, 'pass', $poppass,
	'server', $popserver, 'address', $popaddress, 'forget', 1);
   }
}

else   {
  unless ($popuser and $poppass and $popserver)  { # Set in config file
   &oops('Userid') unless($form{'USER'});
   &oops('Password') unless($form{'PASSWORD'});
   &oops('Server') unless($form{'POPSERVER'});
   $popuser = $form{'USER'};
   $poppass = $form{'PASSWORD'};
   $popserver = $form{'POPSERVER'};
     if ($form{'POPADDRESS'})  {
	$popaddress = $form{'POPADDRESS'};
     }  
     else  {$popaddress = ""}
  }

  if ($form{'remember'})   { # Set persistent cookie on user computer
   $Cookie_Exp_Date = $cookie_expiry;
   &SetCompressedCookies('mailuser', 'id',$popuser, 'pass', $poppass, 'server',
   $popserver, 'address', $popaddress);
  }

  else  {
   &SetCompressedCookies('mailuser', 'id',$popuser, 'pass', $poppass, 'server',
   $popserver, 'address', $popaddress, 'forget', 1);
  }
}

print "\n";
  
&trace("id",$popuser,"pass",$poppass,"server",$popserver) if($debug);

$logged = 1;
$bulletin .= "login $popuser | $popserver | $popaddress";
&inbox;
}

########### Fetch page template and begin printing
sub getPage  {
my $text = shift;

&oops ("Unable to read $template: $!") unless (open (TEMP, $template));
my @page = <TEMP>;
close $file;

while ($_ = shift @page)  {

   if ($_ =~ /$titletag/i)  {
	print "<title>$text</title>";
	&printJava;
   }
   elsif ($_ =~ /$headtag/i)  {
	&printHeader($text);
	last;
   }

   else  {
	print $_;
   }
}

return @page;
}

### Find and display message headers from user's POP3 server
sub inbox {
unless ($logged)   {
   $user = &get_User;
}

&openpop;

@page = &getPage ('INBOX');
$gotbody = 0;
$gotfoot = 0;

while ($_ = shift @page)  {
   if ($_ =~ /$bodytag/i)  {
	$gotbody = 1;
	print <<EOF;
	<p><div align="center">
	<center>$smallfont For security reasons please remember to <font 
        color=red>Logout</font> when finished</center>
	<form action=$ENV{'SCRIPT_NAME'} method=POST 
	onSubmit="return delWarning()">
	<input type=HIDDEN name="action" value="killmail"><!--CyKuH,Virus-->
	<center><table border="1" cellpadding="0" width="100%" $toptablebg>
	<tr align=center><td><b>Del</b></td><td><b>Subject</b></td><td><b>From</b></td>
	<td><b>Date</b></td><td><b>Size</b></td></tr>
EOF
	$row = 0;
	foreach $msgid (keys %$messages) {
	   next unless (&readpop($msgid));
	   $MSG = "M$msgid";

	   if ($chessboard)   { # Alternating row colors in message table
	      $row++;
	      $row = $row % 2;
	      $bgcolor = $chessbg[$row]; 
	      print "<tr bgcolor=$bgcolor>";
	   }
	   else {print "<tr>"}

	   print "<td><input type=CHECKBOX name=$MSG></td> <td>$mainfont
           <a href=$ENV{'SCRIPT_NAME'}\?action=showmail\&MID=$msgid>
           <font color=red>$subject</font></a></td> <td>$mainfont$from</td>
           <td>$mainfont$datetime</td><td>$mainfont$size</tr>";
	}

	&closepop;

	print <<"EOF";
	</table><p>
	<table border=0><tr>
	<td align=left><input type=submit value="Delete Marked" name=delete></form></td>
	<td width=40>&nbsp;</td>
	<td align=right><form method=POST action=$ENV{'SCRIPT_NAME'} 
	onSubmit="return delWarning()">
	<input type=hidden name=action value=killmail>
	<input type=hidden name="ALL" value=1>
	<input type=submit value="Delete All Messages" 
	name=B1></form></td></tr></table></center></div>
EOF
   } # End if

   elsif ($_ =~ /$foottag/i)  {
	$gotfoot = 1;
	last;
   }

   else {
	print $_;
   }
} # End while (@page)

&oops ("Missing or invalid $template BODY tag") unless ($gotbody);
&oops ("Missing or invalid $template FOOTER tag") unless ($gotfoot);
} # End sub inbox

###  Establish connection with POP3 server and get list of messages
sub openpop   {
unless ($logged)   {
$popuser = $Cookies{'id'};
$poppass = $Cookies{'pass'};
$popserver = $Cookies{'server'};
}

&oops('Must enable cookies in browser') unless ($popuser and $poppass and $popserver);
&oops('Not logged in') if ($popuser =~ /\*{3,}/);
$pop = Net::POP3->new( $popserver, Timeout => 15);
&oops('Mail server not responding') unless ( defined ($pop));
&oops('Check login information') unless ( defined ( $pop->login($popuser, $poppass)));
$messages = $pop->list;
}

###  Read header and body of message.
sub readpop   {
my $msgid = $_[0];
$MESS = $pop->get($msgid);
return unless ($MESS);
$top = $pop->top($msgid);
$size = hex ($pop->list($msgid)); # Message size in dec
$size = int(0.5 + $size/1024);
$size = 1 if($size == 0);
$size = "$size"."K";

# Create and format header
%head = &Parse_header ($top);  # This sub requires ref array 
&Fmt_header;  # Adjust to, from etc.
$from = $head{'from'};
chomp ($from);
$to = $head{'to'};
$cc = $head{'cc'};
$rt = $head{'reply-to'};
$subject = $head{'subject'};
$subject =~ s/ {2,}/ /g; # Allow only single spaces
$datetime = $head{'date'};
$datetime =~ s/\s+/ /g;  # Replace white space with 1 space
$content = $head{'content-type'};
$boundary = $head{'boundary'};
$transfer = $head{'content-transfer-encoding'};
return 1;
}

###  Close POP3 server
sub closepop   {
$pop->quit();
}

### Compose a message
sub compose {
&oops('Enable Cookies then login') unless(&GetCompressedCookies('mailuser', 'address'));

$popaddress = $Cookies{'address'};
my $to = $form{'to'};

@page = &getPage ('COMPOSE');
$gotbody = 0;
$gotfoot = 0;

while ($_ = shift @page)  {
   if ($_ =~ /$bodytag/i)  {
	$gotbody = 1;
	print <<EOF;
	<p><div align="center">
	<table border="0" cellpadding="0" width="90%">
	<FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST ENCTYPE="multipart/form-data"
	onSubmit="return isReady(this)">
	<INPUT TYPE=HIDDEN NAME=action VALUE=postmail>
	<!--CyKuH,Virus-->
	<INPUT TYPE=HIDDEN NAME=option VALUE=upload>
	<tr>
	  <td width="15%"><font face="Arial" size="-1"><b>To:</b></font></td>
	  <td><font face="Arial"><input type="text" name="TO" value="$to" size="25"></font>
	<tr>
	  <td width="15%"><font face="Arial" size="-1"><b>Cc:</b></font></td>
	  <td><font face="Arial"><input type="text" name="CC" size="25"></font>
	</tr>
	<tr>
	  <td width="15%"><font face="Arial" size="-1"><b>From:</b></font></td>
	  <td><font face="Arial"><input type="text" name="FROM" size="25" 
	  value="$popaddress"></font>
	</tr>
	<tr>
	  <td width="15%"><font face="Arial" size="-1"><b>Subject:</b></font></td>
	  <td><font face="Arial"> <input type="text" name="SUBJECT" size="45"></font></td>
	</tr>
	<tr>
	  <td colspan="2" align="center"><font face="Arial" size="-1">
	  <b>Your Message:</b> </font>
	  <font face="Arial"><br><textarea NAME="MESSAGE" ROWS="10" COLS="50" 
	  WRAP="physical"></textarea></font>
	</td>
	</tr>
	</table> 

	<table border="0" cellpadding="0" width="100%" >
	<tr>
	  <td align=center width=50%><b>Attachments</b> <font size=1> (any file)</font> <br>
	  <input type="file" name="file1"><br>    
	  <input type="file" name="file2"><br>    
	  <input type="file" name="file3"> </td>
	  <td align=center width=50%><input type="submit" value="Send" name="B1"></td>
	</tr>    
	</form></table></div>
EOF
   } # End if

   elsif ($_ =~ /$foottag/i)  {
	$gotfoot = 1;
	last;
   }

   else {
	print $_;
   }
} # End while (@page)


&oops ("Missing or invalid $template BODY tag") unless ($gotbody);
&oops ("Missing or invalid $template FOOTER tag") unless ($gotfoot);
}

### Process and send composed message
sub postmail {
$user = &get_User;

&trace("post user",$user) if ($debug);

unless ($form{'TO'} =~ /.+\@.+/)  {
   &oops('Invalid To:');
}
else { $to = $form{'TO'};}

unless ($form{'FROM'} =~ /.+\@.+/)  {
   &oops('Invalid From:')
}
else {$from = $form{'FROM'};}

if($form{'CC'})   {
&oops('Invalid Cc:') unless ($form{'CC'} =~ /.+\@.+/);
$cc = $form{'CC'};
}

if ($form{'SUBJECT'})  {
   $subject = $form{'SUBJECT'};
}
else { $subject = "-no subject-";}

if ($form{'MESSAGE'})  {
   $message = $form{'MESSAGE'};
}
else { $message = "-no message-";}

## Open mailserver and begin sending
&Set_date;
my $full_message;
$LF = "\n";
open(MAIL,"|$mailserver -ti") || &oops ("Unable to open $mailserver: $!");

$message_header = "To: $to$LF";
$message_header .= "From: $from$LF";
$message_header .= "CC: $cc$LF" if $cc;
$message_header .= "Date: $date$LF";
$message_header .= "Subject: $subject$LF";
$message_header .= "X-Mailer: \"MailChek Version $version (CyKuH Virus)\"$LF";

&trace ("option",$form{'option'},"mid",$form{'MID'}) if ($debug);

# Check for forwarding 
if ($form{'option'} eq 'forward' and $form{'MID'})   {
   unless (&doforward ($form{'MID'}, $message, $message_header))  {
	$bulletin .= "Unable to forward this message. ";
	return;
   }
} ## END forwarding

## Process uploaded attachments
elsif (@uploaded)   { # Add MIME headers for attachments
   $message_header .= "MIME-version: 1.0$LF";
   $boundary = "MailChek_by_CyKuH_Virus--" . $time;
   $message_header .= "Content-type: multipart/mixed\;$LF";
   $message_header .= "\tboundary=\"$boundary\"$LF$LF";
   $full_message = $message_header;  # Start saving for 'sent' folder
   print MAIL $message_header;
   $message_header = "This is a multi-part message in MIME format.$LF$LF";
   $message_header .= "--$boundary$LF";
   $message_header .= "Content-type: text/plain; charset=\"US-ASCII\"$LF$LF$message$LF";
   $full_message .= $message_header;
   print MAIL $message_header;
   my $attachdir = "$tempdir/$user";

&trace("post attachdir",$attachdir) if ($debug);

   ($full_body, @attached_these) = &attachments ($attachdir); # Add message and attachments to header

&trace("post attached_these",@attached_these) if ($debug);

   $full_message .= $full_body;  # Add attachment headers to header
   $bulletin .= "temporary attachment folder NOT deleted: $!<br>" unless (&kill_files ($attachdir, @uploaded)); 
}

else {	# if no forwarding or attachments, just print the header and message
    $full_message = $message_header;
    print MAIL "$message_header$LF";# Give server the message header, just to rev it up
    $full_message .= $message; # Add message to header
    print MAIL "$message$LF";
}

print MAIL "$mailadd$LF"; # Add on footer
print MAIL "$LF.$LF";

# Disconnect from the mail server
close MAIL;


$bulletin .= "Your email has been sent to $to";
$bulletin .= ", $cc" if ($cc);
&inbox;
}

### Read and display a message
sub showmail {
$user = &get_User;
my $popaddress = $Cookies{'address'};

$msgid = $form{'MID'};
&openpop;
&readpop($msgid);
&closepop;

# Put message in temp file for further processing
unless (-e "$tempdir/$user")  {
   &oops ("Cannot create $tempdir/$user: $!") 
   unless (mkdir ("$tempdir/$user", 0755));
}

$MID = time;
&oops ("Cannot open $tempdir/$user/$MID: $!")
 unless (open (TEMP, ">$tempdir/$user/$MID"));

print TEMP @$MESS; # Must use ref array!
close TEMP;

# Set flag to display/print bare message in new window
my $print;
if ($form{'PRINT'} eq 'print')   {
$print = 1; # On
}
else   {
$print = 0; #Off
}

# Prepare collector for Parse_message subroutine
@msg = ();  # Parse_message outputs all here

unless (&Fmt_email($MID))   {
   $bulletin .= " Unable to show message $msgid. ";
}

# Print message
if ($print)   { # Print bare message and exit
   print @msg;
   exit;
}

@page = &getPage ('READ');
$gotbody = 0;
$gotfoot = 0;

while ($_ = shift @page)  {
   if ($_ =~ /$bodytag/i)  {
	$gotbody = 1;
	print <<"EOF";
	<p><div align="center">
	<table width="100%" border="2" cellpadding="7" $toptablebg>
	<tr><td width=100%>$mainfont
	@msg
	</td></tr></table><p>
 
	<center><table width=100% border=0><tr>
	<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
	<input type="hidden" name="action" value="reply">
	<input type="hidden" name="MID" value="$MID">
	<input type="hidden" name="FROM" value="$popaddress">
	<input type=submit value="Reply"></form></td>

	<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
	<input type="hidden" name="action" value="forward">
	<input type="hidden" name="MID" value="$MID">
	<input type="hidden" name="SUBJECT" value="$subject">
	<input type="hidden" name="FROM" value="$popaddress">
	<input type=submit value="Forward"></form></td>

	<td align=center>$mainfont
	<a href=$ENV{'SCRIPT_NAME'}?action=showmail&MID=$msgid&header=$headsw>
	<font color=red>$headmsg</font></a></td>

	<td align=center>$mainfont
	<a href=$ENV{'SCRIPT_NAME'}?action=showmail&MID=$msgid&PRINT=print $TARGET>
	<font color=red>View printer-ready message</font></a><br><font size=1>
	Close new window when done</font></td>

	<td align=center>$mainfont
	<form method=POST action=$ENV{'SCRIPT_NAME'} onSubmit="return delWarning()">
	<!--CyKuH,Virus-->
	<input type="hidden" name="action" value="killmail">
	<input type="hidden" name="MID" value="$msgid">
	<input type=submit value="Delete"></form></td>
	</tr></table></center></div>
EOF

   } # End if

   elsif ($_ =~ /$foottag/i)  {
	$gotfoot = 1;
	last;
   }

   else {
	print $_;
   }
} # End while (@page)

&oops ("Missing or invalid $template BODY tag") unless ($gotbody);
&oops ("Missing or invalid $template FOOTER tag") unless ($gotfoot);

}
### Clear inbox of one or all messages
sub killmail  {
&oops('Enable Cookies then login') unless(&GetCompressedCookies('mailuser'));
&openpop;

if ($form{'ALL'}) {
   foreach $msgid (keys %$messages) {
     $pop->delete($msgid);
   }
$bulletin .= "All Messages Deleted";
}

elsif ($form{'MID'})  {
   if ($pop->delete($form{'MID'}))  {
	$bulletin .= "Message $form{'MID'} Deleted";
   }
   else {$bulletin .= "***ERROR*** Message $form{'MID'} NOT Deleted";}
}

else  {
   foreach $msgid (keys %$messages) {
     $pop->delete($msgid) if ($form{"M$msgid"} );
   }
$bulletin .= "Marked Messages Deleted";
}

&closepop;
&inbox;
}

### Clean out $tempdir directory and files and say goodbye
sub logout   {
$user = &get_User;

if ($Cookies{'forget'})  {
   $Cookie_Exp_Date = 'Wdy, 01-Jan-1997 00:00:00 GMT';
   &SetCompressedCookies('mailuser', 'id','***', 'pass', '***', 'server',
   '***', 'address', '***');
}

&Expire ("$tempdir/$user", 0); # Remove temp message files
rmdir ("$tempdir/$user");


print "\n";
print <<"EOF";
<html><head>
<title>Logout</title>
</head><body>
<CENTER><H2>You have logged out</H2>
For increased email security shutdown browser when finished<p>
Return to <a href=$transfer>$transfer_name</a>
<!--CyKuH,Virus--></CENTER></body></html>
EOF
exit;
}

### Read help html page and print back out to browser
sub help {
&oops('Enable Cookies then login') unless(&GetCompressedCookies('mailuser'));

&oops('No Help HTML File Found!') unless (open(HELP, "$basepath$helphtmfile"));
(@ALL) = <HELP>;
close HELP;

@page = &getPage ('HELP');
$gotbody = 0;
$gotfoot = 0;

while ($_ = shift @page)  {
   if ($_ =~ /$bodytag/i)  {
	$gotbody = 1;
	&printhtm(@ALL);
   } # End if

   elsif ($_ =~ /$foottag/i)  {
	$gotfoot = 1;
	last;
   }

   else {
	print $_;
   }
} # End while (@page)

&oops ("Missing or invalid $template BODY tag") unless ($gotbody);
&oops ("Missing or invalid $template FOOTER tag") unless ($gotfoot);

}

###  Substitute values for variables in our html pages and print from here
sub printhtm  {
$htm = join(' ',@_);
$htm =~ s/\$ENV{'SCRIPT_NAME'}/$ENV{'SCRIPT_NAME'}/g;
$htm =~ s/\$Cookies{'name'}/$Cookies{'name'}/g;
$htm =~ s/\$ARGV\[1\]/$ARGV[1]/g;
$htm =~ s/\$ARGV\[2\]/$ARGV[2]/g;
$htm =~ s/\$to/$to/g;
$htm =~ s/\$from/$from/g;
$htm =~ s/\$subject/$subject/g;
$htm =~ s/\$message/$message/g;
$htm =~ s/\$banner/$banner/g;
$htm =~ s/\$popserver/$popserver/g;
$htm =~ s/\$popuser/$popuser/g;
$htm =~ s/\$poppass/$poppass/g;
$htm =~ s/\$mainfont/$mainfont/g;
$htm =~ s/\$toptablebg/$toptablebg/g;
$htm =~ s/\$subtablebg/$subtablebg/g;
print "$htm";
}

### Convert web address to viewable hyperlink
sub hyperlink {
# Takes a URL and turns it into a hyperlink with an abbreviated (no "http://") viewable output.
@oldline = split (/ /, @_[0]);
$newline = "";
foreach $word (@oldline)  {

if ($word =~ /http:\/\/(.*)/i) {
$word = "<A HREF=\"$word\"$TARGET><font color=red>$1</font></A>" if ($word !~ /\?/) ;
$word = "<A HREF=\"$word\"$TARGET><font color=red>$word</font></A>" if ($word =~ /\?/);
}
$newline .= $word.' ';
}
return ($newline);
}

### Delete aged temporary files
sub Expire   {
my $thedir = $_[0];
my $life = $_[1];
my $rc = 1;

unless (opendir THEDIR, "$thedir")  {
   $bulletin .= "<br>Unable to expire $thedir: $!";
   return 0;
}

@allfiles = readdir THEDIR;

foreach $file (@allfiles) {
next if ($file =~ /^\.{1,}/);

if (-d "$thedir/$file")  {
   if (0 < &Expire ("$thedir/$file", $life))  {
	$bulletin .= "Unable to remove $thedir/$file: $!. "
	unless (rmdir ("$thedir/$file"));
   }
}

if ((-C "$thedir/$file") > $life) {
   unless (unlink("$thedir/$file"))  {
	$bulletin .= "Unable to delete $thedir/$file: $!. "; 
	$rc = 0;
   }
}
else  {$rc = 0}
}
return $rc;
}

##############
sub Fmt_email   {
$user = &get_User;

my $MID = shift (@_);

&trace ("sub fmt_email mid",$MID) if ($debug);

unless (open (MAILFILE, "$tempdir/$user/$MID"))  {
   $bulletin .= " Cannot open $tempdir/$user/$MID: $!. ";
   return 0;
}

(@message) = <MAILFILE>;
close MAILFILE;

if ($debug)  {
   print "FMT_EMAIL \@MESSAGE=<BR>";
   print @message;
   print "<BR>";
}

@body = @message; # Need this after @message gets spliced

# Determine if full or normal header to be displayed
$headsw = '1';
$headmsg = "Show full header";

if ($form{'header'} eq '1')   {
$headsw = '0';
$headmsg = "Show normal header";
}

&trace ("sub fmt_email headsw",$headsw) if($debug);

# Format header and body in @msg
$ref_message = \@message;  # Create ref to hash array (i.e. %var)
$message_line_number = -1;
&Parse_message(1,0,0,$headsw); # create header and body. $headsw=0 for full header

if ($debug)  {
   print "FMT_EMAIL:<BR>";
   print "\@MSG=";
   print @msg;
   print "<p>\@QUOTE=";
   print @quote;
   print "<P>";
}

(my $ref_header,$message_line_number) = &Get_head(\@body,1); # create ref array to message header
%head = Parse_header($ref_header); # create readable header
&Fmt_header;  # Use %head to prepare to, from etc. for reply

if ($debug)  {
   print "FMT_EMAIL %HEAD=<BR>";
   foreach (keys %head)  {
	print "<b>$_</b>: $head{$_}<BR>";
   }
}

return 1;
}  # End Fmt_email

############# Put Javascript code in page head
sub printJava   {
print <<EOF;

 <SCRIPT TYPE="text/javascript" language="JavaScript1.2">
 <!--

 function delWarning()  {
	if (!confirm ("Deleted files can not be recovered. Are you sure you want to Delete?"))
      return false
 }

 function isReady(form) {
     if (!form.TO.value) {
         alert("Please enter a To: address.");
         form.TO.focus();
         return false;
     }
     if (!form.FROM.value) {
         alert("Please enter a From: address.");
         form.FROM.focus();
         return false;
     }
     if (!form.SUBJECT.value) {
         if(confirm("Subject is empty, enter it now?"))  {
            form.SUBJECT.focus();
            return false;
         }
     }
     if (!form.MESSAGE.value) {
         if(confirm("Message is empty, enter it now?"))  {
           form.MESSAGE.focus();
           return false;
	 }
     }
 }
//--></SCRIPT>
EOF
}
1;
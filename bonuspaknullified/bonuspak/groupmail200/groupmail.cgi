#!/usr/bin/perl

# -----------------------------------------------------------------
#
#                     GroupMail Secure Version 2.00
#
#                            Main Program
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
#    Filename : groupmail.cgi
# -------------------------------------------------------------------

use CGI;
use CGI::Carp qw(fatalsToBrowser);
use Net::POP3;
use MIME::Base64;

require 'groupmail.cfg';
require 'groupmail.lib';
require 'address.lib';
require 'profile.lib';
require 'cookie.lib';
require 'secure.cfg';

$scriptname = $ENV{'SCRIPT_NAME'};

#############################################################
#
#			Main program
#
############################################################

# Get ready
&Set_date;  # Nice, friendly format

# Sytem time used for random id's and recording login time
$time = time;  # Time in seconds since some ridiculous year in the past

# Get set
CGI::ReadParse(*form);
$action = $form{'action'};

# Go
&start;

# Always deliver mail even if no one home
unless ($nopop or $action eq 'login' or $action eq 'setit' or $action eq 'logout')   {
$bulletin .= "POP email not delivered<br>" unless (&getmail);
}

# Now see what user wants to do
# sub upload in groupmail.lib

unless ($action eq 'login' or $action eq 'setit' or $action eq 'logout')   {
   &trace ("option",$form{'option'}) if($debug);
   if ($form{'option'} eq 'upload')   {&upload;}  # Upload attachments first thing.
}

# These subroutines are stored in this script

if ($form{'action'} eq 'email') { &email unless ($nopop); }
elsif ($form{'action'} eq 'login') { &login; }
elsif ($form{'action'} eq 'setit') { &setcookie; }
elsif ($form{'action'} eq 'procemail') { &procemail unless ($nopop); }
elsif ($form{'action'} eq 'intercom') { &intercom unless ($nointercom); }
elsif ($form{'action'} eq 'Send message') { &intercom unless ($nointercom); }
elsif ($form{'action'} eq 'procinter') { &procinter unless ($nointercom); }
elsif ($form{'action'} eq 'listmail') { &listmail; }
elsif ($form{'action'} eq 'showmail') { &showmail; }
elsif ($form{'action'} eq 'trashmail') { &trashmail; }
elsif ($form{'action'} eq 'delmail') { &delmail; }

# These are stored in groupmail.lib
elsif ($form{'action'} eq 'replymail') { &replymail unless ($nopop); }
elsif ($form{'action'} eq 'forwardmail') { &forwardmail unless ($nopop); }
elsif ($form{'action'} eq 'killattach') { &killattach unless ($nointercom); }
elsif ($form{'action'} eq 'mailer') { &mailer; }
elsif ($form{'action'} eq 'mailall') { &mailall; }
elsif ($form{'action'} eq 'interer') { &interer unless ($nointercom); }
elsif ($form{'action'} eq 'interall') { &interall unless ($nointercom); }
elsif ($form{'action'} eq 'listtrash') { &listtrash; }
elsif ($form{'action'} eq 'showtrash') { &showtrash; }
elsif ($form{'action'} eq 'deltrash') { &deltrash; }
elsif ($form{'action'} eq 'listsent') { &listsent; }
elsif ($form{'action'} eq 'showsent') { &showsent; }
elsif ($form{'action'} eq 'delsent') { &delsent; }
elsif ($form{'action'} eq 'chngpass') { &chngpass; }
elsif ($form{'action'} eq 'viewall') { &viewall unless ($nointercom); }
elsif ($form{'action'} eq 'main') { &main; }
elsif ($form{'action'} eq 'register') { &register; }
elsif ($form{'action'} eq 'procreg') { &procreg; }
elsif ($form{'action'} eq 'procpass') { &procpass; }
elsif ($form{'action'} eq 'password1') { &password2; }
elsif ($form{'action'} eq 'password') { &password; }
elsif ($form{'action'} eq 'help') { &help; }
elsif ($form{'action'} eq 'logout') { &logout; }

# These are in address.lib
elsif ($form{'action'} eq 'address') { &address; }
elsif ($form{'action'} eq 'Add') { &editbook; }
elsif ($form{'action'} eq 'Update') { &updatbook; }
elsif ($form{'action'} eq 'Edit') { &editbook; }
elsif ($form{'action'} eq 'Del') { &deletbook; }

# These are stored in profile.lib
elsif ($form{'action'} eq 'profstart') { &profstart unless ($nointercom); }
elsif ($form{'action'} eq 'Show profile') { &showprof unless ($nointercom); }
elsif ($form{'action'} eq 'procprof') { &procprof unless ($nointercom); }
else {print "\n"; &nologin;}

# Arrive here after cookie sent. It may not be in place yet because
# some browsers are slow when cookie cutters in use

&trace ("member",$named)if ($debug);

if($named)   {
  &Main_menu;
}
else { print "\n"; &nologin; }

# Warn user if he has exceeded disk quota
$count = &diskusage($named,2);
print "<p align=center><b>$count bytes exceeds quota of $maxdisk. <FONT COLOR=red><blink>REMOVE EXCESS MESSAGES</blink></font></b></p>" unless ($maxdisk >= $count); # Check if $maxdisk space exceeded.

print $footer;  # Ownership, copyright, privacy, terms of service

&expire ("$tempdir/$named", $templife);  # Clean out temp attachment storage
exit;

#################################################################
#
#			Subroutines
#
#################################################################


##########  Activate routines which don't yet need a cookie set
sub start   {
# Only one '\n' if cookie not yet set
if ($form{'action'} eq 'setit' or $form{'action'} eq 'logout' or 
   $form{'action'} eq 'login' or $form{'action'} eq 'register' or 
   $form{'action'} eq 'procreg' or $form{'action'} eq 'password' or 
   $form{'action'} eq 'password1' or $form{'action'} eq 'help')   {
   print "Content-type: text/html\n"; 

}
else  {
print "Content-type: text/html\n\n";
&trace("action",$form{'action'}) if ($debug);

if (&initialize)   {
   $named = $Cookies{'name'};
   print "<html><head><title>GroupMail</title></head>";
   }
else { &nologin}
}
}

#############  Check for cookies and validate user
sub initialize   {
if (&GetCompressedCookies('grpmloff'))  { # Someone used this browser session?

if ($Cookies{'logged'})   {
   $off = $Cookies{'logged'}; # Save logout time
   }
else   {$off = 0 }
   }
else  {$off = 0 }

&GetCompressedCookies('grpmlon'); # Someone logged in?

if ($Cookies{'logged'})   {
   $on = $Cookies{'logged'}; # Save login time
   }
else   {$on = 0 }

if ($on > $off)   { # We have a valid login following a logout in this session
   return 1;
   }
else { return 0}
}

################ Main Menu
sub Main_menu   {
print "<html><head>";

print <<"EOF" if($menutips); # Turn this stylesheet on/off in groupmail.cfg
<script language="JavaScript" type="text/javascript">
<!-- Begin hiding script from older browsers

function toolTips(evt,currElem) {
// Creates the tool tip for Internet Explorer
  if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4)) {
    tip = eval("document.all." + currElem + ".style");
// Number at end of next line indicates the number of pixels from the bottom of the cursor the tip is
    tip.top = parseInt(evt.y)+2;
// Number at end of next line indicates the number of pixels to the left of the cursor the tip is
    tip.left = Math.max(2,parseInt(evt.x)+15);
    tip.visibility = "visible";
    tip.status = "";
  }
// Creates the tool tip for Netscape
  if ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion) >= 4)) {
    tip = eval("document." + currElem);
// Number at end of next line indicates the number of pixels from the bottom of the cursor the tip is
    tip.top = parseInt(evt.pageY)+2;
// Number at end of next line indicates the number of pixels to the left of the cursor the tip is
    tip.left = Math.max(2,parseInt(evt.pageX)+15);
    tip.visibility = "visible";
    tip.status = "";
  }
}

function tipDown(currElem) {
// Closes the tool tip for Internet Explorer
  if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4)) {
    tip = eval("document.all." + currElem + ".style");
    tip.visibility = "hidden";
  }
// Closes the tool tip for Netscape
  if ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion) >= 4)) {
    tip = eval("document." + currElem);
    tip.visibility = "hidden";
  }
}

// End hiding script from older browsers -->
</script>
<!-- Do not change the styles for tip1 -->
<style type="text/css">
<!--

#tip1,#tip2,#tip3,#tip4,#tip5,#tip6,#tip7,#tip8,#tip9,#tip10,#tip11,#tip12 {position:absolute;
     visibility:hidden}

.tipStyle {background-color:#FFFFDD;
     layer-background-color:#FFFFDD;
     border-color:#000000;
     border-width:1px;
     border-style:solid;
     font-family:arial,helvetica,sans-serif;
     font-size:9pt;
     padding-left:2px;
     padding-right:2px}

// -->
</style>
EOF

print <<EOF;
<title>GroupMail</title></head>

<body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
<p><center><table width="70%" cellpadding=0 cellspacing=0 border=2 $subtablebg><tr align=center><td>
<table width="100%" cellpadding=2 cellspacing=2 border=0 $subtablebg><tr align=center>
EOF

if ($menutips)   {
print <<EOF;
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listmail onmouseover="toolTips(event,'tip1'); return true" onmouseout="tipDown('tip1')">Inbox</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listtrash onmouseover="toolTips(event,'tip2'); return true" onmouseout="tipDown('tip2')">Trash</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listsent onmouseover="toolTips(event,'tip3'); return true" onmouseout="tipDown('tip3')">Sent</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=address onmouseover="toolTips(event,'tip4'); return true" onmouseout="tipDown('tip4')">Address</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=email onmouseover="toolTips(event,'tip5'); return true" onmouseout="tipDown('tip5')">Email</A></font> </td>
EOF

print <<EOF unless ($nointercom);
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=intercom onmouseover="toolTips(event,'tip6'); return true" onmouseout="tipDown('tip6')">Intercom</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=viewall onmouseover="toolTips(event,'tip7'); return true" onmouseout="tipDown('tip7')">Members</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=profstart onmouseover="toolTips(event,'tip8'); return true" onmouseout="tipDown('tip8')">Profile</A></font> </td>
EOF

print <<EOF;
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=chngpass onmouseover="toolTips(event,'tip9'); return true" onmouseout="tipDown('tip9')">Password</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=logout onmouseover="toolTips(event,'tip10'); return true" onmouseout="tipDown('tip10')">Logout</A></font></td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=help onmouseover="toolTips(event,'tip11'); return true" onmouseout="tipDown('tip11')">Help</A> </td>
EOF
}

else   {
print <<EOF;
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listmail>Inbox</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listtrash>Trash</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=listsent>Sent</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=address>Address</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=email>Email</A></font> </td>
EOF

print <<EOF unless ($nointercom);
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=intercom>Intercom</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=viewall>Members</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=profstart>Profile</A></font> </td>
EOF

print <<EOF;
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=chngpass>Password</A></font> </td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=logout>Logout</A></font></td>
<td $titlebg><font face="Arial black" size="2" color="#FFFFFF"><A HREF=$ENV{'SCRIPT_NAME'}?action=help>Help</A> </td>
EOF
}

print "</tr></table></td></tr></table></center>";

print <<EOF if ($menutips);
<!-- The spans below this line are the tool tips -->
<span id="tip1" class="tipStyle">Displays headers of received messages.<br>Then click to read, send to trashbin or delete</span>
<span id="tip2" class="tipStyle">Displays headers of messages you have read<br>and saved. Then click to read or delete.</span>
<span id="tip3" class="tipStyle">Displays headers of messages you have sent<br>and saved. Then click to read or delete.</span>
<span id="tip4" class="tipStyle">Address book for storing peoples' email addresses etc.<br> Also accessed from sender address in messages.</span>
<span id="tip5" class="tipStyle">Compose and send email including attachments.</span>
<span id="tip6" class="tipStyle">Compose and send intercom messages to<br>GroupMail members. Also include attachments.</span>
<span id="tip7" class="tipStyle">Display list of all GroupMail members.Then read<br>profiles and/or send intercom messages</span>
<span id="tip8" class="tipStyle">Create or update your profile (personal file)</span>
<span id="tip9" class="tipStyle">Change your password<br> and/or other email address</span>
<span id="tip10" class="tipStyle">Log out of GroupMail<br>and end your session</span>
<span id="tip11" class="tipStyle">Help page which<br>you should read</span>
EOF

print "</body></html>";
}

##############  Open connection to our POP server account
sub openpop   {
unless ($pop_userid and $pop_password and $pop_server)   {
   $bulletin .= "<br>POP email not configured<br>";
   return 0;
}

$pop = Net::POP3->new( $pop_server, Timeout => 15);
unless ( defined ($pop))   {
   $bulletin .= "<br>POP server not responding<br>";
   return 0;
}

unless ( defined ( $pop->login($pop_userid, $pop_password)))   {
   $bulletin .= "<br>POP email configuration incorrect or POP server busy<br>";
   return 0;
}
$MESSAGES = $pop->list;
return 1;
}

##############  Download messages and distribute to inboxes
sub readpop   {
foreach $msgid (keys %$MESSAGES) {
$flagged = 0;
$message = $pop->get($msgid);

next unless ($message);
@msg = @$message;
$msg_size = hex ($pop->list($msgid)); # Message size in dec

### For debugging only ###
if ($debug)   {
   print "\n";
   $kbytes = $msg_size/1024;
   $KB = int(0.5 + $kbytes);
   &trace ("message $msgid size","$kbytes"."K rounded to "."$KB"."K");
   open (TEST, ">>$basepath$maildir/debug.dat");
   print TEST "@msg";
   close (TEST);
}
### End debugging ###

$TOP = $pop->top($msgid);
@top = @$TOP; # Save copy of full header - may need it later

foreach (@top)   {
   $_ =~ s/<//g;  # Email addresses enclosed with these don't show
   $_  =~ s/>//g;
   push (@hdr, $_);
}

&trace ("message",$msgid,"top","<br>@top","raw header","<br>@hdr") if($debug);

$TOP = \@hdr;
%head = &Parse_header ($TOP);  # This sub requires ref array 

### For debugging only ###
if ($debug)   {
print "MESSAGE $msgid PARSED HEADER:<br>";
   foreach (keys %head)   {
      print "<b>$_:</b> $head{$_}<br>";
   }
print "<p>";
}
### End debugging ###

&Fmt_header;  # Adjust to, from etc.
$from = $head{'from'};
chomp ($from);
$to = $head{'to'};
$cc = $head{'cc'};
$rt = $head{'reply-to'};
$subject = $head{'subject'};
$subject =~ s/\W/ /g; # Replace non-alphanumeric with space
$subject =~ s/ {2,}/ /g; # Allow only single spaces
$datetime = $head{'date'};
$datetime =~ s/\s+/ /g;  # Replace white space whith 1 space
$content = $head{'content-type'};
$boundary = $head{'boundary'};
$transfer = $head{'content-transfer-encoding'};
$received = $head{'received'};
$delivered = $head{'delivered-to'};

### For debugging only ###
if ($debug)   {
print "MESSAGE $msgid FORMATTED HEADER:<br>";
   foreach (keys %head)   {
      print "<b>$_:</b> $head{$_}<br>";
   }
print "<p>";
}
### End debugging ###

### MOD 08/02/01 Find recipients from $to, $cc and $received  ###
@TO = (); @cc = (); $recipients = ""; # Clear contents of previous message
@TO = split (/,/, $to);
@cc = split (/,/, $cc);
push (@TO, @cc);

foreach (@TO)   {

   if ($_ =~ /$domain/i)   {
      $recipients .= "$_," unless ($recipients =~ /$_/i);
   }
}

### Third-party forwarding
&forwarded;

&trace ("message",$msgid,"recipients",$recipients) if($debug);

@TO = split (/,/, $recipients);

&trace ("message",$msgid,"to","<br>@TO") if($debug);

&recipients (@TO) if (@TO);
### MOD End ###

# If marked try to save before deletion.
if ($flagged and $other_email)   {

&trace ("message",$msgid,"flagged",$flagged,"other_email",$other_email) if ($debug);

   open (SAVE, ">>$other_email");
   print SAVE "@msg";
   close (SAVE);
}

$pop->delete($msgid);
}
return 1;
}

############### Routes incoming POP mail to proper recipients
sub recipients   {
@list = @_;
my $to;
my $delivered = 0;  # Not yet delivered to a member

&trace ("message",$msgid,"sub recipients","<br>@list") if($debug);

foreach $to (@list)   {
next unless ($to =~ /$domain/i);
$active = 0;
if ($to =~ s/([\w.-]+@[\w.-]+)//) {$to = $1}    # Take out the email address
$recip = $to;
$to =~ s/$domain//;
$to = ucfirst($to);

&trace ("message",$msgid,"sub recipients",$to) if ($debug);

unless(-e "$basepath$regdir/$to.dat")   {  # Must be a member

&trace ("message",$msgid,"sub recipients not found",$to) if($debug);

   if ($other_use)  { # Allow other use of $pop_userid POP account?
      if ($save_other ne "")   {
         $to = lc($save_other); # Deliver to specified mailbox
         $to = ucfirst($to);

         &trace ("message",$msgid,"saved for",$to) if($debug);
      }
      else {
         $flagged = 1;
         next;
      }
   }
   else  {next}
}

unless( open(REGFILE, "$basepath$regdir/$to.dat"))   {
   $flagged = 1 if ($other_use); # Un-mark for deletion

&trace ("message",$msgid,"to",$to,"flagged",$flagged) if ($debug);

   next;
}

($password,  $email, $realname,$sponsor, $address, $address2, $active, $junk) = <REGFILE>;
close REGFILE;
chomp($password, $email, $realname,$sponsor, $address, $address2, $active, $junk);

&trace ("sub recipient",$to,"active",$active) if($debug);

if($active)	{
$count = &diskusage($to,2); # Check space usage

unless ($maxdisk >= $count)   {  # Check if $maxmess exceeded.
&oops2;
next;
}
$MID = time;
$MID = "$MID$msgid";  # Ensure unique Message ID for same time!
open (MAILFILE, ">$basepath$maildir/$to/$MID");
print MAILFILE @$message;
close (MAILFILE);

open (MAILFILE, ">>$basepath$maildir/$to/$subject-$MID-$datetime-$from.htm");
close (MAILFILE);

if ($mailuser) {
&sendemail($email, "$to has a new message waiting", $admin_email, $mailserver, "PLEASE DO NOT REPLY TO THIS E-MAIL.\n\n$to has a new Message at the $site_name Email Center\n$transfer_url") if ($email =~ /.+\@.+/);
} # End if ($mailuser...

$delivered = 1;  # Delivered to a member(s) - no $other_use permitted.
 
} # End if ($active)
} # End foreach

$flagged = 0 if ($delivered); # Mark message for deletion if delivered to a member
}

##############  Close POP server connection
sub closepop   {
$pop->quit();
}

###########  Open, read and close POP account
sub getmail {
return 0 unless (&openpop);
$bulletin .= "Unknown error while delivering POP email<br>" unless (&readpop);
&closepop;
return 1;
}

#############  Compose email message
sub email {
$banner = &makebanner ('SEND <font size=2>email');
print <<EOF;
<html><body $bodytext $bodybg>$mainfont $banner
<p><div align="center">
EOF

print "<b>Previous action:</b> $bulletin <p>" if ($bulletin);

print <<EOF;
<center><table width=90% $subtablebg border="1"><tr><td>
<table border="0" cellpadding="0" width="100%" >
<FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST ENCTYPE="multipart/form-data">
<INPUT TYPE=HIDDEN NAME=action VALUE=procemail>
<INPUT TYPE=HIDDEN NAME=option VALUE=upload>
  <tr>
    <td width="15%"><font face="Arial" size="-1"><b>To</b>:</font></td>
    <td><font face="Arial"><input type="text" name="TO" value="$form{'to'}"  size="20" maxlength=$max_send>&nbsp;&nbsp;</font>
    <select name="TO1"><font size="-1">
    <option selected><b>------- Address Book -------</b></option>
EOF

if (open (ADDR, "$basepath$adddir/$named.dat"))   {
  @book = <ADDR>;
   close ADDR;

  if(@book)   {
  foreach (@book)   {
   ($email, $name, $location, $phone) = split(/\t/, $_);
   $name = "($name)" if($name);
   print "<option>$name $email</option>";
}
}
}

print <<EOF;
</select></font></td>
  </tr>
  <tr>
    <td width="15%"><font face="Arial" size="-1"><b>Cc</b>:</font></td>
    <td><font face="Arial"><input type="text" name="CC" size="20" maxlength=$max_send>&nbsp;&nbsp;</font>
    <select name="CC1"><font size="-1">
    <option selected><b>------- Address Book -------</b></option>
EOF

  if(@book)   {
  foreach (@book)   {
   ($email, $name, $location, $phone) = split(/\t/, $_);
   $name = "($name)" if($name);
   print "<option>$name $email</option>";
}
}

print <<EOF;
</select></font></td>
  </tr>
  <tr>
    <td width="15%"><font face="Arial" size="-1"><b>Subject</b>:</font></td>
    <td><font face="Arial"> <input type="text" name="SUBJECT" size="40"></font></td>
  </tr>
  <tr>
    <td width="50%" colspan="2" align="center"><font face="Arial" size="-1"><b>Your Message</b>:</font>
      <font face="Arial"><br><textarea NAME="MESSAGE" ROWS="12" COLS="70" WRAP="physical"></textarea></font></td>
  </tr></table>
<table border="0" cellpadding="0" width="100%" >
  <tr>
    <td align=center width=50%><b>Attachments</b><font size=1>(any file)</font> <br>
      <input type="file" name="file1"><br>    
      <input type="file" name="file2"><br>    
      <input type="file" name="file3"> </td>
    <td align=center width=50%><input type="submit" value="Send" name="B1"></td>
  </tr>    
</form></table> </td></tr></table></center></font></body></html>
EOF
}
###################  Process and send email message
sub procemail {
if($form{'TO'})	{
&oops('Invalid To:') unless ($form{'TO'} =~ /.+\@.+/);
$to = $form{'TO'};
}
elsif($form{'TO1'})	{
&oops("Invalid To: $form{'TO1'} from  Address Book")  unless ($form{'TO1'} =~ /.+\@.+/);
$to = $form{'TO1'};
}
if($form{'CC'})   {
&oops('Invalid Cc:') unless ($form{'CC'} =~ /.+\@.+/);
$cc = $form{'CC'};
}
elsif($form{'CC1'} =~ /\@/)	{
&oops("Invalid Cc: $form{'CC1'} from Address Book")  unless($form{'CC1'} =~ /.+\@.+/);
$cc = $form{'CC1'};
}

&oops('No Message To Send') unless ($form{'MESSAGE'});
$message = $form{'MESSAGE'};
&oops('You MUST enter a subject') unless ($form{'SUBJECT'});
$subject = $form{'SUBJECT'};
$from = $Cookies{'name'};
&oops("$from is not a member") unless (open(REGFILE, "$basepath$regdir/$from.dat"));
($password, $email, $realname,$sponsor, $address, $telephone) = <REGFILE>;
close REGFILE;
chomp($password, $email, $realname,$sponsor, $address, $telephone);

## Open mailserver and begin sending
$bulletin = "";
my $full_message;
$LF = "\n";
open(MAIL,"|$mailserver -ti") || die "$!";

$message_header = "To: $to$LF";
$message_header .= "From: $from$domain$LF";
$message_header .= "CC: $cc$LF" if $cc;
$message_header .= "Date: $date$LF";
$message_header .= "Subject: $subject$LF";
$message_header .= "X-Mailer: \"GroupMail Version $version (Chez Surette Art)\"$LF";

&trace ("uploaded",@uploaded) if ($debug);

# Check for forwarding 
if ($form{'FILED'})   {
   $full_message .= &procforward ($form{'FILED'}, $message, $message_header);
} ## END forwarding

## Process uploaded attachments
elsif (@uploaded)   { # Add MIME headers for attachments
   $message_header .= "MIME-version: 1.0$LF";
   $boundary = "GroupMail_CyKuH_Virus--" . $time;
   $message_header .= "Content-type: multipart/mixed\;$LF";
   $message_header .= "\tboundary=\"$boundary\"$LF$LF";
   $full_message = $message_header;  # Start saving for 'sent' folder
   print MAIL $message_header;
   $message_header = "This is a multi-part message in MIME format.$LF$LF";
   $message_header .= "--$boundary$LF";
   $message_header .= "Content-type: text/plain; charset=\"US-ASCII\"$LF$LF$message$LF";
   $full_message .= $message_header;
   print MAIL $message_header;
   my $attachdir = "$tempdir/$from";
   ($full_body, @attached_these) = &attachments ($attachdir); # Add message and attachments to header
   $full_message .= $full_body;  # Add attachment headers to header
   $bulletin = "One or more uploaded attachment files NOT deleted!<br>" unless (&kill_files ($attachdir, @uploaded)); 
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

$count = &diskusage($Cookies{'name'}, 2);

if ($maxdisk >= $count)  {
$MID = time;
open (SENT,">$basepath$maildir/$Cookies{'name'}/sent/$form{'SUBJECT'}-$MID-$date-$from.htm");
print SENT $full_message;
close SENT;
}

my $warn = "";
$warn = "<br><b>Message not saved - $count bytes used exceeds quota of $maxdisk.<font color=red><blink>REMOVE EXCESS MESSAGES</blink></font></b>" unless ($maxdisk >= $count);
$bulletin .= "Email sent to $to $cc. $warn"; 

&listmail;
}

############  Show messages in INBOX
sub listmail {
&oops("Unable to open $Cookies{'name'} registration file: $!") unless (open(REGFILE, "$basepath$regdir/$Cookies{'name'}.dat"));
($password, $email, $realname,$sponsor, $null, $null2) = <REGFILE>;
close REGFILE;
chomp($password, $email, $realname,$sponsor, $null, $null2);
opendir THEDIR, "$basepath$maildir/$Cookies{'name'}" || die "Unable to open directory: $!";
@allfiles = readdir THEDIR;
closedir THEDIR;
$numfiles = @allfiles;

$banner = &makebanner ('INBOX');
print <<"EOF";
<body $bodytext $bodybg>$mainfont $banner<center>
EOF

print "<b>Previous action:</b> $bulletin" if ($bulletin);

print <<EOF;
<form action=$ENV{'SCRIPT_NAME'} method=POST>
<input type=HIDDEN name="action" value="delmail">
<input type=HIDDEN name="MARKED" value=1>
<table border="1" cellpadding="2" width="90%" $subtablebg>
<tr align=center><td>$mainfont<b>Del</b><!--CyKuH,Virus--></td><td>$mainfont<b>Subject</b><br>$smallfont click to read message</font></td><td>$mainfont<b>From</b></td> <td>$mainfont<b>Date</b></td> <td>$mainfont<b>Size</b><br>$smallfont approx</font></td> </tr>
EOF

$row = 0;

foreach $file (sort { ($a =~ /-(\d{8,})/)[0] <=> ($b =~ /-(\d{8,})/)[0]  } @allfiles) {

if ($file =~ /\.htm/i) {
$file =~ s/\.htm//;
@ort = split(/-/, $file);
$nort = @ort;

for ($i=4; $i<$nort; $i++)   { # recover orts connected to $ort[3] with '-'
   $ort[3] .= "-$ort[$i]";
}

$size = (-s "$basepath$maildir/$Cookies{'name'}/$ort[1]");
$size = int(0.5 + $size/1024);
$size = 1 if($size == 0);
$size = "$size"."K";

# Hexify banned chars in command line
$file =~ s/ /\%20/g; 
$file =~ s/\+/\%2B/g;
$file =~ s/\,/\%2C/g;
$file =~ s/\:/\%3A/g;

   if ($chessboard)   { # Alternating row colors in message table
      $row++;
      $row = $row % 2;
      $bgcolor = $chessbg[$row]; 
      print "<tr bgcolor=$bgcolor>";
   }
   else {print "<tr>"}

print "<td align=center><input type=CHECKBOX name=$ort[1]></td> <td><a href=$ENV{'SCRIPT_NAME'}\?action=showmail\&selection=$file><font size=2 color=red>$ort[0]</font></a></td><td>$mainfont$ort[3]</td> <td>$mainfont$ort[2]</td> <td>$mainfont$size</td> </tr>";
}
}

print <<"EOF";
</table><p>
<table border=0><tr>
<td align=left><input type=submit value="Delete Marked" name=B1></form></td><td width=40>&nbsp;</td>
<td align=right><form method=POST action=$ENV{'SCRIPT_NAME'}>
<input type=hidden name=action value=delmail><!--CyKuH-->
<input type=hidden name="DOIT" value=1>
<input type=submit value="Delete All Messages" name=B1></form></td></tr></table></center></div>
EOF
}

#############  Display selected message from INBOX and format reply panel
sub showmail {
&trace ("SHOWMAIL FORM SELECTION",$form{'selection'}) if ($debug);
my $selection = $form{'selection'};
&trace ("SHOWMAIL SELECTION",$selection) if ($debug);
my $file = $selection;

# Restore banned characters from command line
$file =~ s/\%20/ /g;
$file =~ s/\%2B/+/g;
$file =~ s/\%2C/./g;
$file =~ s/\%3A/:/g;

my $print = 0;
$print = $form{'print'} if ($form{'print'});
@msg = ();  # Init collector for email and intercom message
@quote = (); # Init quoted text for reply
$multipart = 0;

($subject, $MID, $datetime, $from) = split (/-/, $file);

if (-e "$basepath$maildir/$Cookies{'name'}/$MID")   {  # must be email
$email_msg = 1;

&Fmt_email ("", $file);

} # End email

else   { # Must be Intercom

&Fmt_intercom ("", $file);

} # End Intercom

# Show all messages here. Both email and intercom use @msg
print "<body $bodytext $bodybg>$mainfont";

# Hexify banned chars in command line
$selection =~ s/ /\%20/g; 
$selection =~ s/\+/\%2B/g;
$selection =~ s/\,/\%2C/g;
$selection =~ s/\:/\%3A/g;

print <<"EOF" unless ($print);
<p><div align="center">
<table width="80%" border="2" cellpadding="12" $toptablebg><tr><td width=100% >
$mainfont
EOF

foreach (@msg)   {
print $_;
}

exit if ($print);
print "<hr>";
print "</td></tr></table></div>";

# Display control buttons below message for Reply, Trash, Headers, Print and Delete
print "<center><table width=80% border=0><tr>";

print << "EOF" if($email_msg); 
<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
<input type="hidden" name="action" value="replymail">
<input type="hidden" name="FILED" value="$file">
<input type=submit value="Reply"></form></td>

<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
<input type="hidden" name="action" value="forwardmail">
<input type="hidden" name="FILED" value="$file">
<input type=submit value="Forward"></form></td>

<td align=center>$mainfont
<a href=$ENV{'SCRIPT_NAME'}?action=showmail&selection=$selection&header=$headsw><font color=red>$headmsg</font></a></td>
EOF

print << "EOF";
<td align=center>$mainfont<a href=$ENV{'SCRIPT_NAME'}?action=showmail&selection=$selection&print=1 $TARGET><font color=red>View printer-ready message</font></a><br><font size=1>Close new window when done</font></td>

<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
<input type="hidden" name="action" value="trashmail">
<input type="hidden" name="FILED" value="$file">
<input type=submit value="Trash"></form></td>

<td align=center>$mainfont<form method=POST action=$ENV{'SCRIPT_NAME'}>
<input type="hidden" name="action" value="delmail">
<input type="hidden" name="FILED" value="$file">
<input type=submit value="Delete"></form></td>
</tr></table></center></td></tr></table></div>
EOF

$subject =~ s/Re: //ig; # Avoid repetition of this

# Prepare Intercom reply and print it out
unless ($email_msg)   {
@MESSAGE = split (/ /, $message);
$clean = "";

foreach $word (@MESSAGE)   {
$word =~ s/\"//g;
$clean .= "$word ";
}

$message = $clean;
$message = "\n\n$div\n$from wrote on $date:\n\n$message\n";

print <<"EOF";
<center><table width="80%" $subtablebg border="1"><tr><td align=center><h2>Reply</h2>
<table border="0" cellpadding="5" width="100%" ><FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST>
<INPUT TYPE=HIDDEN NAME=action VALUE=procinter>
  <tr>
    <td width="25%" align="center">$mainfont<font size="+1"><b>To</b>:</font></td>
    <td width="75%">$mainfont<font size="+1"> <input type="text" name="USER" size="30" value=$from></font></td>
  </tr>
  <tr>
    <td width="25%" align="center">$mainfont<font size="+1"> From: </font></td>
    <td width="75%">$mainfont<font size="+1"> $Cookies{'name'}<input type="hidden" name="ALIAS" value="$Cookies{'name'}"></font></td>
  </tr>
  <tr>
    <td width="25%" align="center">$mainfont<font size="+1"><b>Subject</b>:</font></td>
    <td width="75%">$mainfont<font size="+1"> <input type="text" name="SUBJECT" size="30" value="Re: $subject"></font></td>
  </tr>
  <tr>
    <td align=center width="25%" align="center">$mainfont<font size="+1"><b>Message:</b></td>
    <td width="75%">$mainfont<font size="+1"><textarea NAME="MESSAGE" ROWS="10" COLS="60" WRAP="physical">$message</textarea>
      <p><center><input type="submit" value="Send Reply" name="B1"></center></td>
  </tr></form></table> </td></tr></table> </center>
EOF
}

}

###########  Delete selected or all messages from INBOX
sub delmail  {
if ($form{'MARKED'}) {
&oops ("Can't open $Cookies{'name'} mail: $!") unless (opendir (THEDIR, "$basepath$maildir/$Cookies{'name'}"));
@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {

if ($file =~ /[(\.htm) | (^\d{9,})]/)   {
@ort = split(/-/, $file);
unlink("$basepath$maildir/$Cookies{'name'}/$file") if ($form{$ort[1]});
unlink("$basepath$maildir/$Cookies{'name'}/$ort[1]") if ($form{$ort[1]});
}
}
$bulletin = "Marked messages DELETED!";
}
elsif ($form{'DOIT'}) {
opendir THEDIR, "$basepath$maildir/$Cookies{'name'}" || die "Unable to open directory: $!";
@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {

if (-T "$basepath$maildir/$Cookies{'name'}/$file") {
unlink("$basepath$maildir/$Cookies{'name'}/$file");
}
}
$bulletin = "ALL messages DELETED!";

}
else {
@ort = split(/-/, $form{'FILED'});
&trace ("message",$form{'FILED'},"mid",$ort[1],"member",$Cookies{'name'}) if($debug);

&oops ("Message $form{'FILED'} not deleted: $!") unless (unlink("$basepath$maildir/$Cookies{'name'}/$form{'FILED'}\.htm"));
&oops("Message $form{'FILED'} still exists") if (-e "$basepath$maildir/$Cookies{'name'}/$form{'FILED'}\.htm");

if (-e "$basepath$maildir/$Cookies{'name'}/$ort[1]")   {
$bulletin = "Auxiliary file $ort[1] not deleted: $!<br>" unless (unlink("$basepath$maildir/$Cookies{'name'}/$ort[1]"));
}
&oops("Message $ort[1] still exists") if (-e "$basepath$maildir/$Cookies{'name'}/$ort[1]");

$bulletin = "Message DELETED";
}
&listmail;
}

###########  Move a displayed (read) message to TRASH bin
sub trashmail  {
&oops("Unable to open $basepath$maildir/$Cookies{'name'}/$form{'FILED'}\.htm: $!") unless (open (STUDFILE, "$basepath$maildir/$Cookies{'name'}/$form{'FILED'}\.htm"));
(@ALL) = <STUDFILE>;
close STUDFILE;
open (READFILE,">$basepath$maildir/$Cookies{'name'}/read/$form{'FILED'}\.htm");
print READFILE @ALL;
close READFILE;

@ort = split(/-/, $form{'FILED'});

if (-e "$basepath$maildir/$Cookies{'name'}/$ort[1]")   {
&oops ("Unable to open $ort[1]: $!") unless (open (STUDFILE, "$basepath$maildir/$Cookies{'name'}/$ort[1]"));
(@ALL) = <STUDFILE>;
close STUDFILE;
open (READFILE,">$basepath$maildir/$Cookies{'name'}/read/$ort[1]");
print READFILE @ALL;
close READFILE;
}

$bulletin = "Message moved to TRASH bin";
$bulletin .= "<br>Unable to delete $form{'FILED'}\.htm: $!" unless (unlink("$basepath$maildir/$Cookies{'name'}/$form{'FILED'}\.htm"));

if (-e "$basepath$maildir/$Cookies{'name'}/$ort[1]")   {
$bulletin .= "<br>Unable to delete $ort[1]: $!" unless (unlink("$basepath$maildir/$Cookies{'name'}/$ort[1]"));
}
&listmail;
}
##############  Compose INTERCOM message to group member
sub intercom {
if ($form{'member'})   {
$member = $form{'member'};
$member =~ s/\%20/ /g;
}

&oops ("Cannot access member records - inform $admin_id") unless (opendir THEDIR, "$basepath$regdir");
@allfiles = readdir THEDIR;
closedir THEDIR;
@members = ();

foreach $file (@allfiles) {

if ($file =~ /\.dat/)   {
&oops("Can't access $file records - inform $admin_id") unless(open (THEFILE, "$basepath$regdir/$file"));
($password, $email,$realname,$sponsor, $address, $telephone, $active,$question,$answer) = <THEFILE>;
chomp($password, $email,$realname,$sponsor, $address, $telephone, $active,$question,$answer) ;
close THEFILE;

if($active)   {
$file =~ s/\.dat//;
push (@members, $file);
}
}
}
$banner = &makebanner ('SEND <font size=2>intercom');
print <<"EOF";
<body $bodytext $bodybg> $mainfont $banner
<p><div align="center">
EOF

print "<b>Previous action:</b> $bulletin<p>" if ($bulletin);

print <<EOF;
<center><table width="90%" $subtablebg border="1"><tr><td>
<table border="0" cellpadding="0" width="100%" ><tr><td>

<div align="center">
  <center>
<table border="0" cellpadding="2" width="100%">
<FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST ENCTYPE="multipart/form-data">
<INPUT TYPE=HIDDEN NAME=action VALUE=procinter>
<INPUT TYPE=HIDDEN NAME=option VALUE=upload>

  <tr>
    <td width=50% align=left valign=top>$mainfont<b>From:</b> &nbsp;&nbsp;&nbsp;&nbsp; $Cookies{'name'}
   <input type="hidden" name="ALIAS" value="$Cookies{'name'}"><p>
    $mainfont<b>Subject</b>:</font> &nbsp; 
   <font face="Arial" size=3><input type="text" name="SUBJECT" size="20"></font></td>
    <td align=center>$mainfont<b>To:</b></font><br><font size=1>select 1 or more</font></td>
    <td width=30% align=left> <SELECT MULTIPLE name=USER size=6>
EOF

foreach $name (sort { $a cmp $b } @members)   {
   if ($name eq $member)   {
     print "<OPTION SELECTED>$name<\/OPTION>";
   }
   else { print "<OPTION>$name<\/OPTION>"}
}

print <<"EOF";
</SELECT></font></td>
  </tr>
  <tr>
    <td width="100%" colspan="3" align="center">$mainfont<b>Your Message</b> </font>
      <font size="1">(HTML tags permitted):</font><font size="+1">
      <br><textarea NAME="MESSAGE" ROWS="7" COLS="70"></textarea>
      <p></td></tr>
  <tr>
    <td width=40% align=center>$mainfont <b>Attachments</b></font> <font size=1>(any file)</font> <br>
       <font size="+1">
      <input type="file" name="file1"><br>    
      <input type="file" name="file2"><br>    
      <input type="file" name="file3"> </td>
    <td width=30% align=center><input type="submit" value="Send"></td>
</FORM>

    <FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST>
    <INPUT TYPE=HIDDEN NAME=action VALUE=killattach>
    <td width=30% align=center>$mainfont<font size=1> Delete unexpired attachments<br>
     (if no longer needed)</font><br>
    <INPUT TYPE=submit VALUE="Delete"> </td>
    </form>
  </tr>    
 </table></td></tr></table></td></tr></table>
</div>
EOF

}

##############  Process and send INTERCOM message
sub procinter {
&oops('Sender is not a member') unless (open(REGFILE, "$basepath$regdir/$Cookies{'name'}.dat"));
($password,$email,  $realname,$sponsor,$address, $telephone, $active) = <REGFILE>;
chomp($password,$email, $realname,$sponsor, $email, $address, $telephone, $active);
close REGFILE;
&oops('Sender and login member not same') unless ($Cookies{'name'} eq $form{'ALIAS'});
&oops('MESSAGE') unless ($form{'MESSAGE'});
&oops('SUBJECT') unless ($form{'SUBJECT'});
&oops('RECIPIENT') unless ($form{'USER'});
my $from = $Cookies{'name'};
$message = $form{'MESSAGE'};
$subject = $form{'SUBJECT'};
$subject =~ s/\W/ /g; # Replace non-alphanumeric with space
$subject =~ s/ {2,}/ /g; # Allow only single spaces

foreach $filename (@uploaded)   {
$attach = "<a href=\"$temp_url/$from/$filename\" target=\"new\">$attachgif</a> <font color=\"#C00000\">$filename</font></a> <font size=1>(view $filename in new window and save to your local disk)</font>";
$message .= "<hr size=2>$attach";
}

$q = $form{CGI};

# See if form from Members list htm file
#if ($form{'address'} eq 'single')   {
#@recipients = split (',' , $q ->param('USER'));
#}
#else  {@recipients =$q ->param('USER')}

@recipients =$q ->param('USER');

foreach $to (@recipients)   {
	$to =~ s/ //g;
	$to = lc($to);
	$to = ucfirst($to);
	&oops("$to is not a member") unless (open(REGFILE, "$basepath$regdir/$to.dat"));
	($null1, $email, $null3, $null4, $html, $mailme, $active) = <REGFILE>;
	close REGFILE;
	chomp($null1, $email,  $null3, $null4, $html, $mailme, $active);
	&oops("$to is not a member") unless ($active);
}

@sent = ();
@error = ();
$recips = join (",", @recipients);

foreach $to (@recipients)   {
	next unless (open(REGFILE, "$basepath$regdir/$to.dat"));
	($null1, $email, $null3, $null4, $html, $mailme, $active) = <REGFILE>;
	close REGFILE;
	chomp($null1, $email,  $null3, $null4, $html, $mailme, $active);
	$MID = time;

	if (open(MAILFILE,">>$basepath$maildir/$to/$subject-$MID-$date-$form{'ALIAS'}.htm"))   {
	  	 print MAILFILE "<center><b>*INTERCOM MESSAGE*</b></center><p><b>To:</b> $recips<br><b>From:</b> $form{'ALIAS'}<br><b>Date:</b> $date<br><b>Subject:</b> $form{'SUBJECT'}<hr><p>$message<p><center><b>*END OF MESSAGE*</b></center>\n";
		close (MAILFILE);
		push (@sent, $to);
	}
	else   {
		push (@error, "<br><b>Error:</b> can't write to $to: $!");
		next;
	} 

	if ($mailuser and $email) {
		&sendemail($email, "$to has a new Message waiting", $admin_email, $mailserver, "PLEASE DO NOT REPLY TO THIS E-MAIL.\n\n$to has a new Message at the $site_name GroupMail service\n $transfer_url");
	}
}
$done = join (", ", @sent);
$count = &diskusage($Cookies{'name'},2);

if ($maxdisk >= $count)  {
open (SENTFILE,">$basepath$maildir/$Cookies{'name'}/sent/$subject-$MID-$date-$Cookies{'name'}.htm");
print SENTFILE "<center><b>*INTERCOM MESSAGE*</b></center><p><b>To:</b> $form{'USER'}<br><b>From:</b> $form{'ALIAS'}<br><b>Date:</b> $date<br><b>Subject:</b> $form{'SUBJECT'}<hr><p>$message<p><center><b>*END OF MESSAGE*</b></center>\n";
close (SENTFILE);
}

push (@error, "<br><b>Message not saved</b> - $count bytes used exceeds quota of $maxdisk.<font color=red><blink>REMOVE EXCESS MESSAGES</blink></font>") unless ($maxdisk >= $count);
$bulletin = "Message sent to $done";

if (@error)   {
   $error = join ("<br>", @error);
   $bulletin .= $error;
}

&listmail;
}

##########  Display LOGIN page
sub login {
print "\n";
&oops('No Login HTML File Found!') unless (open(LOG, "$basepath$loginhtm"));
(@ALL) = <LOG>;
close LOG;
$banner = &makebanner ('LOGIN');
&printhtm(@ALL);
exit;
}
##############  Process LOGIN and set login cookie ('grpmlon')
sub setcookie {
$form{'ALIAS'} = lc($form{'ALIAS'});
$form{'ALIAS'} = ucfirst($form{'ALIAS'});
$named = $form{'ALIAS'};

#&trace ("alias",$named,"password",$form{'PASSWORD'}) if($debug);

unless (open(REGFILE, "$basepath$regdir/$named.dat"))  {
    print "\n";
   &oops('USERNAME');
}

($password, $email, $realname, $sponsor, $address, $telephone, $active,$question,$answer,$logged) = <REGFILE>;
close REGFILE;
chomp($password, $email,$realname, $sponsor,  $address, $telephone, $active,$question,$answer,$logged);

unless ($active > 0)   {
  &oops('INACTIVE account');
}

if ($form{'PASSWORD'})  {
    if ($form{'source'} eq 'admin')   {$cryptpass = $form{'PASSWORD'}}
   else   {$cryptpass = &cryptpass($form{'PASSWORD'})}

   if ($password ne $cryptpass)   {
      if ($securelogin)   {&logintries}
      else   {&oops ('incorrect PASSWORD')}
   }
}
else {#  Empty field indicates lost password
print "\n";
&password;
}

#  Give user a cookie and enable output to browser
&SetCookiePath('/');
&SetCompressedCookies('grpmlon','name',$named,'logged',$time);
print "\n";

&trace ("cookie",$named) if($debug);

if ($logged)  {
my @DATES = &Time_to_date ($logged);
my $lastlogin = $DATES[0];  # Change offset to time zone abbrev.
$bulletin .= "$date. \&nbsp\;\&nbsp\;<b>Last login</b> $lastlogin"; # Long dates with time zone
}

# Record login time and reset failed login count
$active=1; # Remove failed login count

if (open(REGFILE, ">$basepath$regdir/$named.dat")) {
   print REGFILE "$password\n$email\n$realname\n$sponsor\n$address\n$telephone\n$active\n$question\n$answer\n$time";
close REGFILE;
}
else {$bulletin .= "<br><font color=red><b>ERROR: </b></font> unable to update member record - notify admin"}

&getmail unless ($nopop); # Deliver mail if any

#############################################################
#
# Optional BBS which interfaces with GroupMail
if ($form{'option'} eq 'forum')   {
print <<"EOF" unless ($noforum);  # Set $noforum=0 in groupmail.cfg to support GroupForum BBS
<html><head><title>GroupForum</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="Refresh" delay="0" CONTENT="1;URL=forum/forum.cgi?action=startup">
</head></html>
EOF
exit;
}
############################################################

else   {
$inbox = &diskusage($named, '0'); # No. of messages in Inbox
$total = &diskusage($named, '1'); # Total messages saved 
$usage = &diskusage($named, '2'); # Disk storage used for messages (bytes)
$usage = int(0.5 + $usage/1024);
$alloc = $maxdisk/1024;

$banner = &makebanner ('LOGIN');
print <<"EOF";
<html><head><title>GroupMail</title></head>
<body $bodytext $bodybg>$mainfont $banner <center>
<h2>Welcome $named$domain</h2><font size=2>$bulletin</font><p>
<font size="2">$inbox messages in your Inbox, a total of $total in all folders. You have used  $usage of your $alloc KB</font><br> 
</center></body>
EOF
}
}

############# Monitor disk space usage
sub diskusage	{
$user = $_[0]; # Member username
$mode = $_[1]; # 0=count inbox files, 1=count all files, 2=count disk space usage (bytes)
$count = 0;

## Mail directory
unless (opendir THEDIR, "$basepath$maildir/$user")   {
  $bulletin .= "Unable to open $basepath$maildir/$user: $!<br>";
}

@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {
if ($file =~ /\.htm/)   {$count += 1}

if($mode eq '2') {$count += (-s "$basepath$maildir/$user/$file");}
}

return $count if($mode eq '0'); # Only inbox files

unless (opendir THEDIR, "$basepath$maildir/$user/read")   {
  $bulletin .= "Unable to open $basepath$maildir/$user/read: $!";
}

@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {
if ($file =~ /\.htm/)   {$count += 1}

if($mode eq '2') {$count += (-s "$basepath$maildir/$user/read/$file");}
}

unless (opendir THEDIR, "$basepath$maildir/$user/sent")   {
  $bulletin .= "Unable to open $basepath$maildir/$user/sent: $!";
}

@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {
if ($file =~ /\.htm/)   {$count += 1}
if($mode eq '2') {$count += (-s "$basepath$maildir/$user/sent/$file");}
}

return $count if($mode eq '1'); # all mail files

## Temporary attachments directory
unless (opendir THEDIR, "$tempdir/$user")   {
  $bulletin .= "Unable to open $tempdir/$user: $!";
}

@allfiles = readdir THEDIR;
closedir THEDIR;

foreach $file (@allfiles) {
   unless ($file =~ /^\.{1,}/)   {$count += 1}

   if($mode eq '2') {$count += (-s "$tempdir/$user/$file");}
}

## Address book
if (-e "$basepath$adddir/$user.dat")   {
if ($mode eq '2')  {
  $count += (-s "$basepath$adddir/$user.dat"); 
}
else { $count += 1; }
}

## Profile
if (-e "$basepath$profdir/$user.dat")   {
if ($mode eq '2')  {
  $count += (-s "$basepath$profdir/$user.dat"); 
}
else { $count += 1; }
}
return $count;
}
###########  LOGOUT routine. Sets a logout cookie ('grpmloff')
sub logout   {
unless (&initialize)   {
   print "\n";
   print "$mainfont <center><h2>You are not logged in!</h2></center><p>";
   }
else   {
$named = $Cookies{'name'};
&SetCompressedCookies('grpmloff','name',$named,'logged',$time);
print "\n";

print <<"EOF";
<html><head><title>GroupMail Logout</title></head> <body>
$mainfont <CENTER><H2>$Cookies{'name'} is now logged off!</H2>
To prevent others from accessing your mail you should exit from your browser when finished<p>
Return to <a href=$transfer_url>$transfer_name</a></CENTER> </body></html>
EOF
exit;
   }
}

############# Convert web address to viewable hyperlink
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

############  Delete expired files in a given directory - attachments etc.
sub expire   {
$thedir = $_[0];
$life = $_[1];  # lifespan
opendir THEDIR, "$thedir" || die "Unable to open $thedir: $!";
@allfiles = readdir THEDIR;

foreach $file (sort { int($a) <=> int($b) } @allfiles) {

if ((-C "$thedir/$file") > $life) {
unlink("$thedir/$file");
}
}
}

##############
sub Fmt_email   {
my $folder = shift (@_);
my $file = shift (@_);
&trace ("sub fmt_email file",$file) if ($debug);
($subject, $MID, $datetime, $from) = split (/-/, $file);
$MID = "$folder$MID";

&oops ("Cannot open $MID: $!") unless (open (MAILFILE, "$basepath$maildir/$Cookies{'name'}/$MID"));
(@message) = <MAILFILE>;
close MAILFILE;

# Determine if full or normal header to be displayed
$headsw = '1';
$headmsg = "Show full header";

if ($form{'header'} eq '1')   {
$headsw = '0';
$headmsg = "Show normal header";
}

# Format header and body in @msg
@body = @message; # create a duplicate of original message
@part = splice(@body,0,20); 
@body = @message;

&trace ("sub fmt_email message",@body) if($debug);

$ref_message = \@message;  # Create ref to hash array (i.e. %var)
$message_line_number = -1;
&Print_message(1,0,0,$headsw); # create header and body. $headsw=0 for full header
(my $ref_header,$message_line_number) = &Get_head(\@body,1); # create ref array to message header
%head = Parse_header($ref_header); # create readable header
&Fmt_header;  # Use %head to prepare to, from etc. for reply
}  # End Fmt_email

#################
sub Fmt_intercom  {
my $folder = shift (@_);
my $file = shift (@_);
my @body;

open (INTFILE, "$basepath$maildir/$Cookies{'name'}/$folder$file\.htm");
(@body) = <INTFILE>;
close INTFILE;
chomp(@body);
$div = "------------------------------------------------------------";

foreach $item(@body) { 
$message .= "$item";
$item =~ s/($div)/<BR>$1<BR>/g;
$item =~ s/\n\n/<P>/g;
$item =~ s/\n/<BR>/g;

if ($item =~ /http:\/\/.*/i)   {
$item = &hyperlink ($item) unless ($item =~ /<a href/i) ;
}
$item = "$item<BR>" unless ($item =~ /(<br>|<p>)/i); 
push(@msg, $item);
}
$message =~ s/<center><b>\*INTERCOM.+<hr><p>(.*)<p><center><b>\*END.+/$1/i; # Remove header + trailer
$message =~ s/($div)/\n$1\n/g;
}  # End Fmt_intercom

############# Include mail forwarded through third-party
sub forwarded   {
   $recipients =~ s/\s*,$//; # Remove trailing (,)

&trace ("message",$msgid,"to+cc",$recipients) if($debug);

   while ($received =~ /for\s*([\w.-]+@[\w.-]+)/i)   {
      $email = $1;

      if ($email =~ /$domain/i)   {
        unless ($email =~ /$pop_userid$domain/i)  {
          $recipients .= ",$email" unless ($recipients =~ /$email/i);
        }
     }

     $received =~ s/$email//g;
   }

$recipients =~ s/\^s*,//; # Remove leading (,)

   while ($delivered =~ /^.*\-([\w.-]+@[\w.-]+)/i)   {
      $email = $1;

      if ($email =~ /$domain/i)   {
        unless ($email =~ /$pop_userid$domain/i)  {
          $recipients .= ",$email" unless ($recipients =~ /$email/i);
        }
     }

     $delivered =~ s/$email//g;
   }

$recipients =~ s/\^s*,//; # Remove leading (,)

} # End sub forwarded

#!/usr/bin/perl
#
##############################################################################
#  Mail Machine v3.975                                                       #
#  Copyright (c) 1999 by Mike's World.  All Rights Reserved.                 #
#  http://www.mikesworld.net												 #		
#  mike@mikesworld.net  													 #
#  																			 #
#  You should carefully read all of the following terms and conditions       #
#  before using this program.  Your use of this software indicates           #
#  your acceptance of this license agreement and warranty.                   #
#                                                                            #
#  This program is being distributed as freeware.  It may be used and        #
#  modified free of charge, so long as this copyright notice, the header     # 
#  above and all the footers in the program that give me credit remain       # 
#  intact.  Please also send me an e-mail, and let me know                   #
#  where you are using this script.                  						 #
#                                                                            #
#  By using this program you agree to indemnify Mike's World from any        #
#  liability. 																 #
#																			 #
#  Selling the code for this program without prior written consent is        #
#  expressly forbidden.  Obtain permission before redistributing this        #
#  program over the Internet or in any other medium.  In all cases           #
#  copyright, header, and all footers must remain intact.                    #
##############################################################################

#  Installation -
#
#  1 - Upload in ascii mode to your cgi-bin
#  2 - Chmod 755 mailmachine.cgi
#  3 - Create an empty file for your e-mails list called whatever you want.txt
#  and upload that in ascii mode to the same directory.  Make sure to chmod 777.
#  4 - Create a directory in the same location as mailmachine.cgi called "archives".  
#  Chmod the directory 711.
#  5 - Create an html form to send it information using the fields:
#		-'address' which will be the address to subscribe to
#		-'action' which should have two possible inputs; either
#		'Subscribe' or 'Unsubscribe'.  Example code:
#
#		<form action="/cgi-bin/mailmachine.cgi" method=post>
#		<input type=text name="address" size=50><br>
#		<input type=radio name=action value=Subscribe checked> 
#		Subscribe | Unsubscribe <input type=radio name=action value=Unsubscribe>
#		<br><input type="submit" value="Update">
#		</form>
#
#  6 - To access the administration section in order to send e-mails to
#  subscribers and subscribe/unsubscribe e-mails, enter the path in your web
#  browser to the Mail Machine script - http://www.yourdomain.com/cgi-
#  bin/mailmachine.cgi - and add a ?admin on the end so it would look like
#  mailmachine.cgi?admin

#  Quick note about customization -
#
#  Wherever you see $message below an error / thanks message is defined.  You
#  may want to change these to fit your site.  

$mailprog = '/usr/sbin/sendmail';
#  Change the location above to wherever sendmail is located on your server.

$admin_email="john\@johndoe.com";
#  Change the address above to your e-mail address.  Make sure to KEEP the \

$list_name="Your Mailing List";
#  Change the name above to whatever you would like to call your mailing list.

$adminpass="password";
#  Change the password above to whatever you would like to use to access the
#  administration section.

$sendto="0";
#  Set this at 1 if you want to be informed everytime someone subscribes or
#  unsubscribes from your mailing list.  Note:  For large mailing lists you
#  probably want to set this at 0 or else you will most likely be bombarded
#  with subscribe/unsubscribe notices.

$temp="1";
#  Set this at 1 if you want to have subscribers confirm their addition to
#  the mailing list before they are actually added.  This will stop people 
#  from adding e-mail addresses without the owners knowledge or entering 
#  fictitious addresses.  Note:  A temp.txt will be created - DO NOT DELETE!

$remove_notice="1";
#  Set this at 1 if you want to allow your subscribers the ability to remove 
#  themselves directly from your mailing.  This will create a removal notice 
#  at the bottom of your mailing.  

$html = "0"; 
#  If you would like to send out messages in HTML set this at 1.  Otherwise, 
#  leave it at 0 and your subscribers will receive standard text messages.

$file = "addresses.txt";
#  This is the file that will store all e-mail addresses for your mailing
#  list.  Make sure and name this something that nobody will think of so
#  that no one will be able to get a hold of your mailing list.

@bannedaddresses = ('john@johndoe.com','joe@joedoe.com');
#  This is a list of all addresses that you don't want to be able to join
#  your mailing list at anytime.  If you don't want any addresses banned,
#  use this setup:  @bannedaddresses = ();  To extend the list of banned
#  addresses just add a comma.

$lock = "2";
#  Keep this at 2 if your server allows you to use file locking.  File
#  locking helps insure that the file storing e-mail addresses will not
#  become corrupt in heavy usage.  If your server doesn't allow you to use
#  file locking then you need to simply remove the 2 in between the quotes.

@months = ('January','February','March','April','May','June','July','August','September','October','November','December');
@days = ('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
($mday,$mon,$year,$wday) = (localtime(time))[3,4,5,6];
$year += 1900;	
$date = "$months[$mon] $mday, $year";

$url = $ENV{'SERVER_NAME'};
$script_url = $ENV{'SCRIPT_NAME'};

print "Content-type: text/html\n\n";

&check;

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);

foreach $pair (@pairs) 
	{
   ($name, $value) = split(/=/, $pair);
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$in{$name} = $value;
	}

if ($in{'action'} eq "Subscribe") {&subscribe}
if ($in{'action'} eq "Unsubscribe") {&unsubscribe}
if ($in{'action'} eq "Send") {&send}
if ($in{'action'} eq "Load") {&load}
if ($in{'adminpass'} ne "$adminpass") {&adminerror}
if ($in{'adminpass'} eq "$adminpass") {&adminform}

exit;

sub check
{
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);

foreach $member(@addresses)
	{
	chomp($member);
	$in{'address'} = "$ENV{'QUERY_STRING'}";
	if ($in{'address'} eq $member){&unsubscribe}
	}
	
open(LIST,"temp.txt");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);

foreach $tempmember(@addresses)
	{
	chomp($tempmember);
	$in{'address'} = "$ENV{'QUERY_STRING'}";
	if ($in{'address'} eq $tempmember){&subscribetemp}
	}	

if("admin" eq $ENV{'QUERY_STRING'}){
&admin
}	
}

sub subscribe
{
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);
if ($in{'address'}!~ /.*\@.*\..*/){&bademail}

foreach $bannedaddress(@bannedaddresses)
	{
    if ($in{'address'} eq $bannedaddress){&banned_message}
	}

foreach $member(@addresses)
	{
	chomp($member);
	if ($in{'address'} eq $member){&already_subscribed}
	}

if ($temp eq "1") {
push (@addresses,$in{'address'});
open(LIST,">>temp.txt");
if ($lock){ 
flock(LIST, $lock);
}
print LIST "$in{'address'}\n";
close(LIST);
$message="The e-mail address <font color=red>$in{'address'}</font> has been put on the temporary list and is awaiting confirmation.  Please confirm the addition to the $list_name by clicking on the link provided in the follow-up e-mail.";
&mailtemp;
&message;
exit;
}
else {	
push (@addresses,$in{'address'});
open(LIST,">>$file");
if ($lock){ 
flock(LIST, $lock);
}
print LIST "$in{'address'}\n";
close(LIST);
$message="The e-mail address <font color=red>$in{'address'}</font> has successfully been
added to the $list_name.";
&mailadd;
&message;
exit;
}
}

sub subscribetemp
{
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);
if ($in{'address'}!~ /.*\@.*\..*/){&bademail}

foreach $bannedaddress(@bannedaddresses)
	{
    if ($in{'address'} eq $bannedaddress){&banned_message}
	}

push (@addresses,$in{'address'});
open(LIST,">>$file");
if ($lock){ 
flock(LIST, $lock);
}
print LIST "$in{'address'}\n";
close(LIST);
$message="The e-mail address <font color=red>$in{'address'}</font> has been taken off the temporary list and successfully added to the $list_name.";
&mailadd;
&message;
&unsubscribetemp;
exit;
}

sub bademail
{
$message="There appears to be something not quite right about
that e-mail address.  Please go back and try again.  If the program is not allowing a true e-mail address then please e-mail <a href=mailto:$admin_email> $admin_email</a> and I'll add you onto the list manually.  Sorry for the
inconvenience.";&message;
exit;
}

sub banned_message
{
$message="Sorry, but it appears that <font color=red>$in{'address'}</font> has been banned for various reasons.";&message;
exit;
}

sub already_subscribed
{
$message="It appears that <font color=red>$in{'address'}</font> is
already
subscribed!";&message;
exit;
}

sub unsubscribe
{
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);$x=0;
foreach $member(@addresses)
	{
	&clean;
	if ($in{'address'} eq $member){&deletemember}
	$x++;
	}
&not_found;
}

sub unsubscribetemp
{
open(LIST,"temp.txt");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);$x=0;
foreach $member(@addresses)
	{
	&clean;
	if ($in{'address'} eq $member){@addresses[$x]="";
open(LIST,">temp.txt");
if ($lock){ 
flock(LIST, $lock);
}
foreach $member(@addresses)
	{
	&clean;
	unless($member eq "")
		{print LIST "$member\n";}
	}}
	$x++;
	}
exit;
}

sub adminerror
{
$message="There appears to be something not quite right about
that password.  Please go back and try again.";&message;
exit;
}

sub admin
{
$message="<form action=mailmachine.cgi method=post>Password:  <input type=password name=adminpass><BR><BR><input type=submit value=Enter><input type=reset value=Clear></FORM>";&message;
exit;
}

sub clean
{
chomp($member);
$member=~ s/^\s+//;
$member=~ s/\s+$//;
}

sub not_found
{
$message="It appears that <font color=red>$in{'address'}</font>
isn't on the list so that e-mail address cannot be unsubscribed!";&message;
exit;
}

sub deletemember
{
@addresses[$x]="";
open(LIST,">$file");
if ($lock){ 
flock(LIST, $lock);
}
foreach $member(@addresses)
	{
	&clean;
	unless($member eq "")
		{print LIST "$member\n";}
	}
$message="<font color=red>$in{'address'}</font> has been successfully removed from the $list_name.";
&mailun;
&message;
exit;
}

sub mailadd{
   open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   print MAIL "From: $admin_email\n";
   print MAIL "To: $in{'address'}\n";
   print MAIL "Subject: You are added!\n\n";
   print MAIL <<to_the_end;
This is to confirm your addition to the $list_name.

Hope you enjoy,
John

to_the_end

  close (MAIL);

if ($sendto eq "1") {
open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   print MAIL "From: $admin_email\n";
   print MAIL "To: $admin_email\n";
   print MAIL "Subject: Mailing List Entry\n\n";
   print MAIL <<to_the_end;
$in{'address'} has been added to the $list_name.

to_the_end

  close (MAIL);
}
}

sub mailtemp{
   open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   print MAIL "From: $admin_email\n";
   print MAIL "To: $in{'address'}\n";
   print MAIL "Subject: Confirmation e-mail\n\n";
   print MAIL <<to_the_end;
This is to confirm your addition to the $list_name.  Click on the link below to move your e-mail address off the temporary list and successfully on the $list_name.  If you did NOT subscribe to this list, then here is the person who did: $ENV{'REMOTE_ADDR'}  In any case, don't click on the link below and you will NEVER receive anything from us :)

http://$url$script_url?$in{'address'}

Regards,
John

to_the_end

  close (MAIL); 
}

sub mailun{
   open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   print MAIL "From: $admin_email\n";
   print MAIL "To: $in{'address'}\n";
   print MAIL "Subject: You are unsubscribed!\n\n";
   print MAIL <<to_the_end;
You have been unsubscribed from the $list_name and if you ever
wish to re-subscibe just do so at our website.

John

to_the_end

  close (MAIL);

if ($sendto eq "1") {
open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   print MAIL "From: $admin_email\n";
   print MAIL "To: $admin_email\n";
   print MAIL "Subject: Adios!\n\n";
   print MAIL <<to_the_end;
$in{'address'} has been unsubscribed from the $list_name.

to_the_end

  close (MAIL);
}
}

sub adminform
{

$number=0;
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
print LIST "$number\n";
close(LIST);
$number = push(@addresses);

print "<html><title>$list_name</title><body bgcolor=white>
<center><pre>


</pre>
<table width=500>
<td align=center>
<font face=arial>
<font face=arial size=+1 color=blue><b>$list_name</b></font>
<br><br>There are currently <font color=red>$number</font> e-mail addresses in the database.<form action=mailmachine.cgi method=post><BR>Archives:  <select name=archives>";

open(LIST,"archives/log.txt");
if ($lock){ 
flock(LIST, $lock);
}
@entries=<LIST>;
close(LIST);
@entries = reverse(@entries);
foreach $entry(@entries)
	{
	print "<option>$entry\n";
	$x++;
	}

print "</select><input type=submit name=action value=Load></form><form action=mailmachine.cgi method=post>Subject:  <input type=text name=subject><BR><BR>Message:  <BR><textarea name=message rows=12 cols=50></textarea><BR><BR><input type=submit name=action value=Send><input type=reset value=Clear name=></FORM><BR><form action=mailmachine.cgi method=post><input type=text name=address> <input type=submit name=action value=Subscribe><br><TABLE><TR><TD><form action=mailmachine.cgi method=post><select name=address size=6>";

@addresses = sort(@addresses);
foreach $member(@addresses)
{
print "<option>$member";
$x++;
}

print "</select></TD></TR><TR><TD><CENTER><input type=submit name=action value=Unsubscribe></CENTER></TD></TR></TABLE></form></form>";
#  Removing or altering the code below will void your acceptance of the
#  terms and conditions and consequently you will no longer be able to
#  use the program.  Please contact me if you have any questions regarding
#  this.
print "<BR><BR><BR><BR>
<font face=arial size=-1>Mail Machine v3.975<BR>
Free from <A HREF=\"http://www.mikesworld.net\">Mike's World</A></font>
</td>
</table>
</body></html>";
}

sub load
{

$number=0;
open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
print LIST "$number\n";
close(LIST);
$number = push(@addresses);

print "<html><title>$list_name</title><body bgcolor=white>
<center><pre>


</pre>
<table width=500>
<td align=center>
<font face=arial>
<font face=arial size=+1 color=blue><b>$list_name</b></font>
<br><br>There are currently <font color=red>$number</font> e-mail addresses in the database.<form action=mailmachine.cgi method=post><BR>Archives:  <select name=archives>";

open(LIST,"archives/log.txt");
if ($lock){ 
flock(LIST, $lock);
}
@entries=<LIST>;
close(LIST);
@entries = reverse(@entries);
foreach $entry(@entries)
	{
	print "<option>$entry\n";
	$x++;
	}

print "</select><input type=submit name=action value=Load></form><form action=mailmachine.cgi method=post>Subject:  <input type=text name=subject value=\"";

open(FILE,"archives/$in{'archives'}.txt");
while (<FILE>) {
  ($message, $subject) = split /::/;

if($subject ne "")
	{
		print "$subject\"";
	}
}
close(FILE);

print "><BR><BR>Message:  <BR><textarea name=message rows=12 cols=50>";

open(FILE,"archives/$in{'archives'}.txt");
while (<FILE>) {
  ($message, $subject) = split /::/;
print "$message";
}
close(FILE);

print "</textarea><BR><BR><input type=submit name=action value=Send><input type=reset value=Clear name=></FORM><BR><form action=mailmachine.cgi method=post><input type=text name=address> <input type=submit name=action value=Subscribe><br><TABLE><TR><TD><form action=mailmachine.cgi method=post><select name=address size=6>";

@addresses = sort(@addresses);
foreach $member(@addresses)
{
print "<option>$member";
$x++;
}

print "</select></TD></TR><TR><TD><CENTER><input type=submit name=action value=Unsubscribe></CENTER></TD></TR></TABLE></form></form>";
#  Removing or altering the code below will void your acceptance of the
#  terms and conditions and consequently you will no longer be able to
#  use the program.  Please contact me if you have any questions regarding
#  this.
print "<BR><BR><BR><BR>
<font face=arial size=-1>Mail Machine v3.975<BR>
Free from <A HREF=\"http://www.mikesworld.net\">Mike's World</A></font>
</td>
</table>
</body></html>";
exit;
}

sub send
{
$pid = fork();
$pid;
if ($pid) {
&sendcomplete;
&archive;
exit(0);
}
else {
close (STDOUT);

open(LIST,"$file");
if ($lock){ 
flock(LIST, $lock);
}
@addresses=<LIST>;
close(LIST);

foreach $member(@addresses)
	{
	chomp($member);

open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   if ($html eq "1") {
   print MAIL "Content-type:text/html\n";
   }
   print MAIL "From: $admin_email\n";
   print MAIL "To: $member\n";
   print MAIL "Subject: $in{'subject'}\n\n";
   print MAIL "$in{'message'}\n\n";
   if ($remove_notice eq "1") {
   if ($html eq "1") {
   print MAIL <<to_the_end;
   <BR><BR>
---------------------------------------------------------------------<BR>
Click on the link below to be removed from the 
$list_name.<BR><BR>

<A HREF="http://$url$script_url?$member">http://$url$script_url?$member</A><BR>
---------------------------------------------------------------------
to_the_end
}
else {
print MAIL <<to_the_end;
---------------------------------------------------------------------
Click on the link below to be removed from the 
$list_name.

http://$url$script_url?$member
---------------------------------------------------------------------
to_the_end
}
} 
   close (MAIL);
}
&confirmation;
exit;
}
}

sub archive
{
open(LIST, ">>archives/log.txt");
if ($lock){ 
flock(LIST, $lock);
}
print LIST "$date - $in{'subject'}\n";
close(LIST);

$message = "$in{'message'}";
$subject = "$in{'subject'}";
$new_entry = $message . "::" .
	     $subject;
open(FILE, ">>archives/$date - $in{'subject'}.txt");
if ($lock){ 
flock(FILE, $lock);
}
print FILE "$new_entry\n";
close(FILE);
}

sub sendcomplete
{
$message="Congratulations!  The mailing has been started.  You will receive a confirmation e-mail when the mailing has been completed.";
&message;
}

sub confirmation
{
open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";
   if ($html eq "1") {
   print MAIL "Content-type:text/html\n";
   }
   print MAIL "From: $admin_email\n";
   print MAIL "To: $admin_email\n";
   print MAIL "Subject: Congratulations!\n\n";
   if ($html eq "1") {
   print MAIL <<to_the_end;
Congratulations!  The mailing completed successfully.  Here is what was sent:<BR><BR>

$in{'message'}
to_the_end
   close (MAIL);
   }
   else {
   print MAIL <<to_the_end;
Congratulations!  The mailing completed successfully.  Here is what was sent:

$in{'message'}
to_the_end
   close (MAIL);
}
}

sub message
{
print qq~
<html><title>$list_name</title><body bgcolor=white>
<center><pre>


</pre>
<table width=500>
<td align=center>
<font face=arial>
<font face=arial size=+1 color=blue><b>$list_name</b></font>
<br><br>$message~;
#  Removing or altering the code below will void your acceptance of the
#  terms and conditions and consequently you will no longer be able to
#  use the program.  Please contact me if you have any questions regarding
#  this.
print "<BR><BR><BR><BR>
<font face=arial size=-1>Mail Machine v3.975<BR>
Free from <A HREF=\"http://www.mikesworld.net\">Mike's World</A></font>
</td>
</table>
</body></html>";
}  
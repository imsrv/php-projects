#!/usr/bin/perl
# -----------------------------------------------------------------
#                     GroupMail Secure Version 2.00
#
#                        Administration Module
#                          Supplied by  Virus
#                          Nullified by CyKuH
#    Filename : admin.cgi
# -------------------------------------------------------------------

use CGI;
use CGI::Carp qw(fatalsToBrowser);

####################################################################
#
# Providing a full path to groupmail.cfg makes it possible to place
# this script in any directory by itself, if desired, and optionally 
# protect it using .htpasswd and .htaccess. Consult your unix/linux
# user manual for details. Use the VALUE of $basepath which you set
# in groupmail.cfg. Example:

# require '/home/username/path-to-groupmail/groupmail.cfg';

# Then remove the '#' and place it ahead of the 'require' statement below.
# Otherwise, change nothing and put this module in the main directory.
#

require 'groupmail.cfg';

############# DO NOT EDIT ANYTHING BELOW THIS LINE #################

require "$basepath".'address.lib';
require "$basepath".'groupmail.lib';
require "$basepath".'profile.lib';

CGI::ReadParse(*form);

print "Content-type: text/html\n\n";

if ($debug)  {
   $banngif =~ s/<(.+)>/$1/;
   &trace("site_url",$site_url,"real_url",$real_url,"homepath",$homepath,
   "basepath",$basepath,"banngif",$banngif) if($debug);
}

$bulletin = "";  # Show confirmations or errors beneath banner
@STATUS = ('INACTIVE','ACTIVE');

&oops ("<h2>Access Denied</h2>") unless (&auth); # Authenticate user

## Initialize
&Set_date; # Assign long_date, short_date and time zone

# Format member name
if ($form{'member'})   {
   $form{'member'} = lc ($form{'member'});
   $form{'member'} = ucfirst ($form{'member'});
}

# And go
if ($form{'action'} eq 'Kill') { &killuser; }
elsif ($form{'action'} eq 'setuser') { &setuser; }
elsif ($form{'action'} eq 'Edit') { &edituser; }
elsif ($form{'action'} eq 'procedit') { &procedit; }
elsif ($form{'action'} eq 'Backup members') { &backup;}  # Backup registration files
elsif ($form{'action'} eq 'Restore members') { &restore;}  # Restore registration files
elsif ($form{'action'} eq 'Manage log') { &securitylog;}  # Review/clear login security file
elsif ($form{'action'} eq 'Clear log') { &securitylog;}  # Clear login security log
elsif ($form{'action'} eq 'Save login data') { &securepop;}  # Update POP account info
elsif ($form{'action'} eq 'Verify config') { &verifycfg;}  # Show secure config settings

# These subroutines reside in address.lib
elsif ($form{'action'} eq 'Backup books') { &backbook;}  # Backup address books
elsif ($form{'action'} eq 'Restore books') { &restbook;}  # Restore address books

# These subroutines reside in profile.lib
elsif ($form{'action'} eq 'Backup profiles') { &backprof;}  # Backup profiles
elsif ($form{'action'} eq 'Restore profiles') { &restprof;}  # Restore profiles

# These reside in groupmail.lib
elsif ($form{'action'} eq 'Email') { &mailer; } # Compose email to all members
elsif ($form{'action'} eq 'mailall') { &mailall; } # Send email
elsif ($form{'action'} eq 'Intercom') { &interer; } # Compose intercom to all members
elsif ($form{'action'} eq 'interall') { &interall; } # Send intercom    

&display;

#################  Show all registration records  ####################

sub display {
&oops ( "Unable to open $basepath$regdir: $!") unless (opendir THEDIR, "$basepath$regdir");
@allfiles = readdir THEDIR;
closedir THEDIR;
$numfiles = @allfiles;
$numfiles = ($numfiles - 2);

$banner = &makebanner ('ADMINISTRATION');
print <<EOF;
<HTML><HEAD>
<SCRIPT LANGUAGE="JavaScript">

var actionSelected = "";

function selectAction (action) {
  actionSelected = action;
}

function memWarning(member){
if (!confirm ("Are you sure you want to " + actionSelected + " " + member + "?"))
return false}

function regWarning()   {
if (!confirm ("Are you sure you want to " + actionSelected + " the registration files?"))
return false}

function bookWarning()   {
if (!confirm ("Are you sure you want to " + actionSelected + " the address books?"))
return false}

function profWarning()   {
if (!confirm ("Are you sure you want to " + actionSelected + " the profiles?"))
return false}

</SCRIPT></HEAD><HTML>

<body $bodybg $bodytext>$banner $mainfont
<p><div align="center">
EOF

# Bulletin on each previous operation
print "<center><b>Previous action:</b> $bulletin</center><p>" if ($bulletin);

print <<EOF;
<table border=1 width=100% $toptablebg>
<tr><th colspan=14>$mainfont<font size="-1"> REMEMBER TO SET PERMISSIONS FOR <font color=red>redirect</font></th></tr>
<tr><td align=center><b>$mainfont Member</font></b></td><td align=center><b>$mainfont Other email</font></b></td>
<td align=center><b>$mainfont Name</font></b></td> <td align=center><b>$mainfont Sponsor</font></b></td> <td align=center><b>$mainfont Address</font></b></td> <td align=center><b>$mainfont Telephone</font></b></td>
<td align=center><b>$mainfont Status</font></b></td><td align=center><b>$mainfont Login</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=center><b>$mainfont Member</font></b></td></tr>
EOF

foreach $file (sort {$a cmp $b } @allfiles) {
if ($file =~ /\.dat$/) {
open (REGFILE, "$basepath$regdir/$file");
($password, $email, $realname, $sponsor, $address, $address2, $status,$question,$answer,$logged) = <REGFILE>;
close REGFILE;
chomp($password, $email, $realname, $sponsor, $address, $address2, $status,$question,$answer,$logged);
$file =~ s/\.dat//;
$file =~ s/ /\%20/g;
$email = "------" if(!$email );
$sponsor = "------" if(!$sponsor );
$address = "------" if(!$address );
$address2 = "------" if(!$address2 );
#$logged = "------" if(!$logged );
if ($logged)   {
  @DATES = &Time_to_date ($logged);
  $login = pop (@DATES);
}
else  { $login = "------" }

print <<EOF;
<tr><td align=center>$mainfont$file</font></td> <td>$mainfont$email</font></td> <td>$mainfont$realname</font></td> <td>$mainfont$sponsor</font></td><td>$mainfont$address</font></td><td>$mainfont$address2</font></td><td>$mainfont$STATUS[$status]</font></td> <td><font face="Arial" size="1">$login</font></td>

<form action=$ENV{'SCRIPT_NAME'} method=post name=memform onSubmit="return memWarning(this.member.value)">

<td>$mainfont <input type=hidden name=adminid value=$admin_id> <input type=hidden name=adminpass value=$admin_password>
<input type=hidden name=member value=$file><input type=submit name=action  value="Edit"  onClick="selectAction('EDIT ')"></font>

<td>$mainfont<A HREF=$ENV{'SCRIPT_NAME'}?action=setuser&adminid=$admin_id&adminpass=$admin_password&member=$file&status=1>Activate</a></font></td>
<td>$mainfont<A HREF=$ENV{'SCRIPT_NAME'}?action=setuser&adminid=$admin_id&adminpass=$admin_password&member=$file&status=0>Deact</a></font></td>

<td>$mainfont <input type=submit name=action  value="Kill" onClick="selectAction('KILL ')"></font></td></form></td>

<td>$mainfont$file</font></td> </tr>
EOF
}
}
print <<EOF;
<tr><th colspan=14>$mainfont <font size="-1">REMEMBER TO SET PERMISSIONS FOR <font color=red>redirect</font></th></tr></table><p>&nbsp;</p>

<h4>Administration and maintenance</h4>

<table border=1cellspacing=0 cellpadding=3 width=90% $subtablebg><tr>
<td align=center valign=top>$mainfont<b>Registration files</b><p>
<form action=$ENV{'SCRIPT_NAME'} method=post onSubmit="return regWarning()">
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password> 
<table width=33% cellspacing=10>
<tr><td align=center> <input type=submit name=action value="Backup members" onClick="selectAction('BACKUP')"></td></tr>
<tr><td align=center> <input type=submit name=action value="Restore members" onClick="selectAction('RESTORE')"></td></tr>
</table></form></font></td>

<td align=center valign=top>$mainfont<b>Address books</b><p>
<form action=$ENV{'SCRIPT_NAME'} method=post onSubmit="return bookWarning()">
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password> 
<table width=34% cellspacing=10>
<tr><td align=center valign=top> <input type=submit name=action value="Backup books" onClick="selectAction('BACKUP')"></td></tr>
<tr><td align=center valign=top> <input type=submit name=action value="Restore books" onClick="selectAction('RESTORE')"></td></tr>
</table></form></td>

<td align=center valign=top>$mainfont<b>Profiles</b><p>
<form action=$ENV{'SCRIPT_NAME'} method=post onSubmit="return profWarning()">
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password> 
<table width=34% cellspacing=10>
<tr><td align=center valign=top> <input type=submit name=action value="Backup profiles" onClick="selectAction('BACKUP')"></td></tr>
<tr><td align=center valign=top> <input type=submit name=action value="Restore profiles" onClick="selectAction('RESTORE')"></td></tr>
</table></form></td>

<td align=center valign=top>$mainfont<b>Broadcasting</b><p>
<form action=$ENV{'SCRIPT_NAME'} method=post>
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password> 
<table width=33% cellspacing=10>
<tr><td align=center> <input type=submit name=action value="Intercom"></td></tr>
<tr><td align=center> <input type=submit name=action value="Email"></td></tr>
</table></form></td>

<td align=center valign=top>$mainfont<b>GroupMail</b><p>
<form action="$real_url/groupmail.cgi" $TARGET method=post>
<input type=hidden name="action" value="setit">
<input type=hidden name="source" value="admin">
<input type=hidden name="ALIAS" value=$admin_id> 
<input type=hidden name="PASSWORD" value=$admin_password> 
<font size="+1"><input type=submit value="Login"></font></form>
<p>&nbsp;</p><a href="$real_url/readme.htm" $TARGET><font size="-1">[ADMIN HELP]</font></a></td>
</td></tr></table>

<h4>Security and privacy</h4>

<table border=1cellspacing=0 cellpadding=3 width=90% $subtablebg><tr>
<td align=center valign=top><center>$mainfont
<b>POP account login data</b><br>
<font size="-1">(if you change this you may also have to change the redirect file)
</font></center><p>
<form method=post action=$ENV{'SCRIPT_NAME'}>
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password>
<table border=0>
<tr><td>$mainfont<b>POP3 server:</b><br></td>
<td><input type=text name=popserver></td></tr>
<tr><td><b>Userid:</b></td>
<td><input type=text name=popuserid></td></tr>
<tr><td><b>Password:</b></td>
<td><input type=text name=poppassword></td></tr>
<tr><td><b>Email address:</b><br>$smallfont(i.e. user\@domain)</font></td>
<td><input type=text name=popaddress></td></tr>
<tr><td colspan=2><br>
<center><input type=submit name=action value="Save login data"></center>
</td></tr></table></form></td>

<td align=center valign=top>$mainfont <b>Verify security configuration</b><p>
<form method=post action=$ENV{'SCRIPT_NAME'}>
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password>
<font size="+1"><input type=submit name=action value="Verify config"></font>

<td align=center valign=top>$mainfont<b>Login records</b><p>
<font size="+1"><input type=submit name=action value="Manage log"></font>
</td></form></tr></table></div>
EOF
}

########### Delete a member - all records/files
sub killuser {
my $member = $form{'member'};
$bulletin = "";
&deleteFiles ($member, "");
&deleteFiles ($member, $backdir);

unless ($nopop)   {
$member = lc($member);
$bulletin .= "Cannot read REDIRECT file<br>" unless (open (REDIR, "$redirect"));
@redir = <REDIR>;
close REDIR;

foreach (@redir)   {
   push (@new, $_) unless ($_ =~ /^\s*$member\s+/i);
}

$bulletin .= "Unable to update REDIRECT file: $!<br>" unless (open (REDIR, ">$redirect"));
flock(REDIR,LOCK_EX);
print REDIR @new;
flock(REDIR,LOCK_UN);
close REDIR;
}
$bulletin .= "$member has been KILLED!";

if ($mailuser and $email) {
&sendemail($email, "GroupMail account $member has been deleted", $admin_email, $mailserver, "PLEASE DO NOT REPLY TO THIS E-MAIL.\n\nAccount $member was deleted on $date\nfrom the $site_name Email Center\n$transfer_url");
}
return 1;
}

##################### Delete working files/backup files
sub deleteFiles   {
my ($member, $otherdir) = @_;

if ($otherdir eq "")   { # WORKING REGFILE ONLY (no backup)
   unless (open (REGFILE, "$basepath$regdir/$member.dat"))   {
      $bulletin .= "Unable to access $basepath$otherdir/$regdir/$member.dat: $!<br>" ;
      return 0;
   }
}

($password, $email, $realname, $sponsor, $address, $address2, $status,$question,$answer,$logged) = <REGFILE>;
close REGFILE;
chomp($password, $email, $realname, $sponsor, $address, $address2, $status,$question,$answer,$logged);

if ($otherdir eq "")   { # WORKING MAIL FILES ONLY (no backups) #
$bulletin .= "Can not open $basepath$maildir/$member/read: $!<br>" unless (opendir THEDIR, "$basepath$maildir/$member/read");
@allfiles = readdir THEDIR;
close THEDIR;

foreach $file (@allfiles) {
	if (-e "$basepath$maildir/$member/read/$file") {
unlink("$basepath$maildir/$member/read/$file");
}
}

$bulletin .= "Can not open $basepath$maildir/$member/sent: $!<br>" unless (opendir THEDIR, "$basepath$maildir/$member/sent");
	@allfiles = readdir THEDIR;
close THEDIR;

foreach $file (@allfiles) {
		if (-e "$basepath$maildir/$member/sent/$file") {
unlink("$basepath$maildir/$member/sent/$file");
}
}

if (-e "$tempdir/$member")   { # UPLOADED FILES #
$bulletin .= "Can not open $tempdir/$member: $!<br>" unless (opendir THEDIR, "$tempdir/$member");
	@allfiles = readdir THEDIR;
close THEDIR;

foreach $file (@allfiles) {
   unlink("$tempdir/$member/$file");
}
} # END UPLOADED FILES #

rmdir("$basepath$maildir/$member/read");
rmdir("$basepath$maildir/$member/sent");
rmdir("$tempdir/$member");
$bulletin .= "Can not open $basepath$maildir/$member: $!<br>" unless (opendir THEDIR, "$basepath$maildir/$member");
	@allfiles = readdir THEDIR;
foreach $file (@allfiles) {
		if (-e "$basepath$maildir/$member/$file") {
unlink("$basepath$maildir/$member/$file");
}
}

rmdir("$basepath$maildir/$member");

} # END WORKING MAIL FILES #

unlink("$basepath$otherdir/$regdir/$member.dat");
unlink("$basepath$otherdir/$profdir/$member.dat");
unlink("$basepath$otherdir/$adddir/$member.dat");
return 1;
} ### END sub deleteFiles ###

############ Set member active/inactive. Can enter here with args from sub auth
sub setuser  {
my ($member, $status, $admin);
$admin = 0;

if (@_)   {
   $member = $_[0];
   $status = $_[1];
   $admin = 1;
}
else   {
   $member = $form{'member'};
   $status = $form{'status'};
}

$member = lc($member);
$member = ucfirst($member);

&trace ("member",$member,"status",$status) if($debug);

unless (open(REGFILE, "<$basepath$otherdir/$regdir/$member.dat"))   {
   $bulletin .= " - Unable to find registry file for $member: $!";
   return 0;
}

($password, $email, $realname, $sponsor, $address, $address2, $oldstat,$question,$answer,$login) = <REGFILE>;
chomp($password, $email,$realname, $sponsor,  $address, $address2, $oldstat,$question,$answer,$login);
close REGFILE;

unless ($nopop)   { # Skip this if not using POP email
   if ($pop_server eq "" or $pop_userid eq "" or $pop_password eq "")   {
      $bulletin .= "<br>\$nopop=$nopop and POP account login data not configured.";
      $bulletin .= " Enter POP account data now then activate $member.";
      return 0;
   }

unless (-e "$redirect")   {
   open (REDIR, ">$redirect");
   close REDIR;
}

unless (open (REDIR, "$redirect"))  {
   $bulletin .= "<br>Cannot read REDIRECT file: $!.";
   return 0;
}

@redir = <REDIR>;
close REDIR;

foreach (@redir)   {
   push (@new, $_) unless ($_ =~ /^\s*$member\s+/i);
}
push (@new, "$member  $pop_address\n") if ($status);

unless (open (REDIR, ">$redirect"))   {
   $bulletin .= "<br>Cannot write REDIRECT file: $!";
   return 0;
}

flock(REDIR,LOCK_EX);
print REDIR @new;
flock(REDIR,LOCK_UN);
close REDIR;
}

if (open(REGFILE, ">$basepath$regdir/$member.dat"))   {
   print REGFILE "$password\n$email\n$realname\n$sponsor\n$address\n$address2\n$status\n$question\n$answer\n$login";
close REGFILE;
$bulletin .=  "<br>'$member $pop_address' has been set $STATUS[$status] and '$redirect' updated.";
}

else {
$bulletin .= "<br>Unable to set $member $STATUS[$status]: $!. REDIRECT updated!";
}

return 1 if ($admin);

if ($mailuser) {
&sendemail($email, "GroupMail account $member now $STATUS[$status]", $admin_email, $mailserver, "PLEASE DO NOT REPLY TO THIS E-MAIL.\n\nAccount $member was set $STATUS[$status] on $date\nat the $site_name Email Center\n$transfer_url") if($email =~ /.+\@.+/);
}
return 1;
}

############# Edit a member record
sub edituser   {
&oops("No file for $form{'member'}") unless (open(REGFILE, "<$basepath$regdir/$form{'member'}.dat"));
($password, $email, $realname, $sponsor, $address, $address2, $status,$question,$answer,$login) = <REGFILE>;
chomp($password, $email,$realname, $sponsor,  $address, $address2, $status,$question,$answer,$login);
close REGFILE;

$banner = &makebanner ('MEMBER <font size=2>update');
print <<EOF;
<body $bodybg $bodytext>$banner $mainfont
<p><div align="center">
<center><table width=60% bgcolor="#EEFFEE" border="1"><tr><td>
<table border="0" cellpadding="5" width="100%" ><FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST>
<input type=hidden name=adminid value="$admin_id">
<input type=hidden name=adminpass value="$admin_password">
<input type=hidden name="action" value="procedit">
<input type=hidden name="USERNAME" value=$form{'member'}>
<input type=hidden name="PASSWORD" value=$password>
<input type=hidden name="STATUS" value=$status>
<input type=hidden name="QUESTION" value=$question>
<input type=hidden name="ANSWER" value=$answer>
<input type=hidden name="LOGIN" value=$login>
  <tr>
    <td width="40%"><font face="Verdana" size="2"><b>Username</b></font></td>
    <td width="60%"><p align="left">$form{'member'}</td>
  </tr>
<tr>
    <td width="50%"><font face="Verdana" size="2"><b>Real name</b></font></td>
    <td width="50%"><p align="left"><input type="text" name="REALNAME" size="30" value="$realname"></td>
  </tr>
  <tr>
    <td width="50%"><font face="Verdana" size="2"><b>Sponsor</b></font></td>
    <td width="50%"><p align="left"><input type="text" name="SPONSOR" size="30" value="$sponsor"></td>
  </tr>
  <tr>
    <td width="50%"><font face="Verdana" size="2"><b>Email</b></font></td>
    <td width="50%"><p align="left"><input type="text" name="EMAIL" size="30" value="$email"></td>
  </tr>
  <tr>
    <td width="50%"><font face="Verdana" size="2"><b>Address</b></font></td>
    <td width="50%"><p align="left"><input type="text" name="ADDRESS" size="30" value="$address"></td>
  </tr>
  <tr>
    <td width="50%"><font face="Verdana" size="2"><b>Telephone</b></font></td>
    <td width="50%"><p align="left"><input type="text" name="ADDRESS2" size="30" value="$address2"></td>
  </tr>
</table>
</td></tr></table></center>
</div><br>

<center><input TYPE="submit" VALUE="Update"></center> </form></p>
EOF
exit;
}

############# Update the edited record
sub procedit   {
&oops("$form{'USERNAME'} does not exist") unless (-e "$basepath$regdir/$form{'USERNAME'}.dat");
#&oops('PASSWORD ') unless ($form{'PASSWORD'});
&oops('REALNAME ') unless ($form{'REALNAME'});
&oops('Must provideTELEPHONE or EMAIL') unless ($form{'EMAIL'} or $form{'ADDRESS2'});
&oops('ADDRESS ') unless ($form{'ADDRESS'});
#&oops('QUESTION ') unless ($form{'QUESTION'});
#&oops('ANSWER ') unless ($form{'ANSWER'});
$password = $form{'PASSWORD'};
$email = $form{'EMAIL'};
$realname = $form{'REALNAME'};
$sponsor = $form{'SPONSOR'};
$address = $form{'ADDRESS'};
$address2 = $form{'ADDRESS2'};
$status = $form{'STATUS'};
$question = $form{'QUESTION'};
$answer = $form{'ANSWER'};
$login = $form{'LOGIN'};

&oops("Can't update $form{'USERNAME'}") unless ( open (REG, ">$basepath$regdir/$form{'USERNAME'}.dat"));
print REG "$password\n$email\n$realname\n$sponsor\n$address\n$address2\n$status\n$question\n$answer\n$login";
close REG;
$bulletin =  "$form{'USERNAME'} has been updated!";
}

#################  Registration files backup/restore  ##################

######### Backup registration database
sub backup   {
unless (-e "$basepath$backdir/$regdir")   {
    &oops ("Unable to create $basepath$backdir/$regdir: $!") unless ( mkdir "$basepath$backdir/$regdir", 0755 );
}

&oops ( "Unable to open $basepath$regdir: $!") unless (opendir THEDIR, "$basepath$regdir");
@allfiles = readdir THEDIR;
closedir THEDIR;

foreach (@allfiles) {
   if ($_ =~ /\.dat$/i) {
   open (REGFILE, "$basepath$regdir/$_");
   @file = <REGFILE>;
   close REGFILE;
   &oops ( "Unable to write $basepath$backdir/$regdir/$_: $!") unless (open BACKFILE,  ">$basepath$backdir/$regdir/$_");
   print BACKFILE @file;
   close BACKFILE;
   }
}

$bulletin = "Registration files BACKUP successful!";
}

######### Restore registration database
sub restore   {
&oops ( "Unable to open $basepath$backdir/$regdir: $!") unless (opendir BACKDIR, "$basepath$backdir/$regdir");
@allfiles = readdir BACKDIR;
closedir BACKDIR;

foreach (@allfiles) {
   if ($_ =~ /\.dat$/i) {
   open (BACKFILE, "$basepath$backdir/$regdir/$_");
   @file = <BACKFILE>;
   close BACKFILE;
   &oops ( "Unable to write $basepath$regdir/$_: $!") unless (open REGFILE,  ">$basepath$regdir/$_");
   print REGFILE @file;
   close REGFILE;
   }
}

$bulletin = "Registration files RESTORE successful!";
}

############  Password authentication  #################
sub auth   {
# Verify security config set

if (not &readcfg)   {
   $code = &writecfg; # Initialize 'secure.cfg'
   &oops ("Can not initialize 'secure.cfg': $code") unless ($code eq "");
   $bulletin .= "Secure config file initialized<br>";

   if ($nopop)   {
      $bulletin .= "POP email not in use (\$nopop=$nopop). If you change this ";
      $bulletin .= "you will have to enter POP account login data. ";
   }
}

# Check form data and initialize
&authlogin unless ($form{'adminid'} and $form{'adminpass'}); # Must use login form
$adminid = lc($form{'adminid'});
$adminid = ucfirst ($adminid);
$admin_id = lc($admin_id);
$admin_id = ucfirst($admin_id);
&oops("You are not the administrator - goodbye!") unless ($adminid eq $admin_id);
	# Must be same as in config file
$adminpass = $form{'adminpass'};

# See if registered
if (-e "$basepath$regdir/$admin_id.dat")   {
   &oops ("Unable to read $basepath$regdir/$admin_id.dat: $!") unless (open (REG,  "$basepath$regdir/$admin_id.dat"));
   ($admin_password, @remainder) = <REG>;
   chomp ($admin_password);
}

else { # Not registered
   $admin_password = &cryptpass ($adminpass);

   if (&procreg ($admin_id, $adminpass))  {
      return 1 unless (&setuser ($adminid, 1));
   }  

   else  {
      $bulletin .= ". Unable to register $admin_id";

      if ($pop_server eq "" or $pop_userid eq "" or $pop_password eq "")   { 
         $bulletin .= ". NOTE: enter POP account login data now" unless($nopop);
      }
   }
}

$cryptpass = &cryptpass ($adminpass) unless ($form{'action'});

&trace ("adminid",$adminid,"admin_id",$admin_id,"adminpass",$adminpass,"cryptpass",$cryptpass,"admin_password",$admin_password) if ($debug);

if ($adminid eq $admin_id and $adminpass eq $admin_password)   {
   return 1;
}

elsif ($adminid eq $admin_id and $cryptpass eq $admin_password)   {
   return 1;
}
else {return 0}

}

############## Auth login form
sub authlogin   {
$banner = &makebanner ('ADMINISTRATION <font size=2>authenticate');
print <<EOF;
<body $bodybg $bodytext>$banner $mainfont<p>
<p><div align="center"><b>Previous action:</b> $bulletin
<center><table width=60% $subtablebg border="1"><tr><td>
<table border="0" cellpadding="5" width="100%" ><FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST>
  <tr>
    <td width="40%"><font face="Verdana" size="2"><b>Admin ID</b></font></td>
    <td width="60%" align="left"><input type=text name=adminid size=15</td>
  </tr>
  <tr>
    <td width="50%"><font face="Verdana" size="2"><b>Admin Password</b></font></td>
    <td width="50%" align="left"><input type=password name=adminpass size=15></td>
  </tr>

</table>
</td></tr></table></center>
</div><br>

<center><font size="+1"><input TYPE="submit" VALUE="Authenticate"></center> </form></p>
EOF
exit;
}

##############  View/Clear login security log
sub securitylog   {
if ($form{'action'} eq 'Manage log')   {
   if (not -e "$loginlog")   {
      &oops ("Can't create $loginlog: $!") unless (open (LOG, ">$loginlog"));
      close LOG;
   }

   &oops ("Can't read $loginlog: $!") unless (open (LOG, $loginlog));
   $banner = &makebanner ('ADMINISTRATION <font size=2>login security');

   print "<body $bodybg $bodytext>$banner $mainfont<p><div align=center>";
   print "<b>Previous action:</b> $bulletin" if ($bulletin);

   print <<EOF;
   <table border=1 width=70% $toptablebg>
   <tr><td align=center><b>$mainfont Time</font></b></td><td align=center><b>$mainfont
   Username</font></b></td> <td align=center><b>$mainfont Attempts</font></b></td> <td
   align=center><b>$mainfont Remote host</font></b></td></tr>
EOF

   while (<LOG>)   {
      ($time, $user, $status, $host) = split(/\t/, $_);
      
      print <<EOF;
      <tr><td align=center>$mainfont$time</font></td> <td>$mainfont$user</font></td>
     <td>$mainfont$status</font></td> <td>$mainfont$host</font></td></tr>
EOF
   }

   close LOG;

    print <<EOF;
   </table><p><table width=70% border=0>
   <form action=$ENV{'SCRIPT_NAME'} method=post>
   <input type=hidden name=adminid value=$admin_id> 
   <input type=hidden name=adminpass value=$admin_password>
   <tr><td align=center valign=bottom>
   $mainfont <font size="+1">
   <input type=submit name=action value="Clear log"></td>
   <td align=center valign=bottom>
   $mainfont <font size="+1">
   <input type=submit name=action value="Return">
   </td></tr></form></table></body>
EOF
   exit;
}

if ($form{'action'} eq 'Clear log')   {
   if (open (LOG, ">$loginlog"))   {
     $bulletin = "Security log CLEARED";
   }

else   {$bulletin = "Can't clear security log: $!" }

}
}

############ Read/initialize security config parms
sub readcfg   {
if (-e "$basepath".'secure.cfg')   {
   require "$basepath".'secure.cfg';
   1;

&trace ("pop_server",$pop_server,"pop_userid",$pop_userid,"pop_password",
$pop_password, "pop_address", $pop_address) if ($debug);
}

else   {
   $pop_server = "";
   $pop_userid = "";
   $pop_password = "";
   $pop_address = "";
   return 0;
}

return 1;
}

############  # Update secure.cfg 
sub writecfg   {
return $! unless (open (CFG, ">$basepath"."secure.cfg"));
chmod (0600, "$basepath".'secure.cfg');

&trace ("pop_server",$pop_server,"pop_userid",$pop_userid,"pop_password",
$pop_password, "pop_address", $pop_address) if ($debug);

print CFG "\$pop_server=\"$pop_server\"\;\n\$pop_userid=\"$pop_userid\"\;\n\$pop_password=\"$pop_password\"\;\n\$pop_address=\"$pop_address\"\;\n1\;\n";
close CFG;
return "";
} 

############### Check POP account login data entered and update 'secure.cfg'
sub securepop   {
&oops ('POP3 server name') unless ($form{'popserver'});
&oops ('Userid') unless ($form{'popuserid'});
&oops ('Password') unless ($form{'poppassword'});
&oops ('Email address') unless ($form{'popaddress'});
$pop_server = $form{'popserver'};
$pop_userid = $form{'popuserid'};
$pop_password = $form{'poppassword'};
$pop_address = $form{'popaddress'};
$pop_address =~ s/\@/\\@/;

&trace ("pop_server",$pop_server,"pop_userid",$pop_userid,"pop_password",
$pop_password, "pop_address", $pop_address) if ($debug);

$code = &writecfg;

if ($code eq "")   {
   $bulletin = "POP3 account information updated";
}
else   {
   $bulletin = "Can not create/update 'secure.cfg' - unable to continue!: $code";
}
}

#################  Verify secure configuration
sub verifycfg   {
if (-e "$basepath".'secure.cfg')   {
   require "$basepath".'secure.cfg';
   $bulletin = "Security configuration has been set as follows:<p>
   <b>Securelogin=</b>$securelogin, 
   <b>Maxlogintries=</b>$maxlogintries,
   <b>Loginlog=</b>$loginlog<br>
   <b>POP account server:</b> $pop_server, 
   <b>POP account userid:</b> $pop_userid, 
   <b>POP account password:</b> $pop_password,
   <b>POP email address:</b> $pop_address";
   }
else {$bulletin = "Security configuration has NOT been set!"}
}

########## Simple data trace if $debug = 1
sub trace   {
my $n = @_;
my ($i, $h, $v);
print "\n";

for ($i=0; $i < $n - 1; $i += 2)   {
   $h = uc($_[$i]);
   $v = $_[$i+1];
   $v =~ s/<(.+)>/$1/;
   print "$h=$v<br>";
}
print "<br>";
}
1;
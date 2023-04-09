#!/usr/bin/perl
# -----------------------------------------------------------------
#                     GroupMail Secure Version 2.00
#
#                         Encrypt Old Passwords
#                          Supplied by  Virus
#                          Nullified by CyKuH
#    Filename : convert.cgi
# -------------------------------------------------------------------

use CGI;
use CGI::Carp qw(fatalsToBrowser);
require 'groupmail.cfg';
require 'groupmail.lib';

CGI::ReadParse(*form);

print "Content-type: text/html\n\n";

## Authenticate user
&auth unless ($form{'adminid'} and $form{'adminpass'});
&oops ("<h2>Access Denied</h2>") unless ($form{'adminpass'} eq $admin_password and 
   $form{'adminid'} eq $admin_id);

## Initialize
@STATUS = ('INACTIVE','ACTIVE');
&Set_date; # Assign long_date, short_date and time zone
$bulletin = "";  # Show confirmations or errors beneath banner

if ($form{'action'} eq 'Backup members') { &backup;}  # Backup registration files
elsif ($form{'action'} eq 'Restore members') { &restore;}  # Restore registration files
elsif ($form{'action'} eq 'Encrypt passwords') { &encrypt;}  # One-time encrypt of passwords
elsif ($form{'action'} eq 'View log') { &encryptlog;}  # One-time encrypt of passwords

&display;

#################  Show all registration records  ####################

sub display {
&oops ( "Unable to open $basepath$regdir: $!") unless (opendir THEDIR, "$basepath$regdir");
@allfiles = readdir THEDIR;
closedir THEDIR;
$numfiles = @allfiles;
$numfiles = ($numfiles - 2);

$banner = &makebanner ("ADMINISTRATION <font size=2>password encryption");
print <<EOF;
<HTML><HEAD>
<SCRIPT LANGUAGE="JavaScript">

var actionSelected = "";

function selectAction (action) {
  actionSelected = action;
}

function regWarning()   {
if (!confirm ("Are you sure you want to " + actionSelected + " the registration files?"))
return false}

function cryptWarning()   {
if (!confirm ("STOP! Are you sure you want to " + actionSelected + " the passwords?"))
return false}

</SCRIPT></HEAD><HTML>

<body $bodybg $bodytext>$banner $mainfont
<p><div align="center">
EOF

# Bulletin on each previous operation
print "<center><b>Previous action:</b> $bulletin</center><p>" if ($bulletin);

print <<EOF;
<table border=1 width=100% $toptablebg>
<tr><td align=center><b>$mainfont Member</font></b></td><td align=center><b>$mainfont Password</font></b></td><td align=center><b>$mainfont Other email</font></b></td>
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

if ($logged)   {
  @DATES = &Time_to_date ($logged);
  $login = pop (@DATES);
}
else  { $login = "------" }

print <<EOF;
<tr><td align=center>$mainfont$file</font></td> <td>$mainfont$password</font></td> <td>$mainfont$email</font></td> <td>$mainfont$realname</font></td> <td>$mainfont$sponsor</font></td><td>$mainfont$address</font></td><td>$mainfont$address2</font></td><td>$mainfont$STATUS[$status]</font></td> <td><font face="Arial" size="1">$login</font></td>
<td>$mainfont$file</font></td> </tr>
EOF
}
}

print <<EOF;
</table><p>&nbsp;</p>

<table border=1cellspacing=5 cellpadding=7 width=80% $subtablebg><tr>

<td align=center>$mainfont<b>Registration files</b><p>
<form action=$ENV{'SCRIPT_NAME'} method=post onSubmit="return regWarning()">
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password> 
<table width=33% cellspacing=10>
<tr><td align=center> <input type=submit name=action value="Backup members" onClick="selectAction('BACKUP')"></td></tr>
<tr><td align=center> <input type=submit name=action value="Restore members" onClick="selectAction('RESTORE')"></td></tr>
</table></form></font></td>

<td valign=top><center>$mainfont
<b>Password encryption<p><font size="+1" color=red>CAUTION</font><br>
backup registration files first</b><p>
<a href="convert.htm" $TARGET>[HELP]</a></center><p>
<font size="+1">
<center><form method=post action=$ENV{'SCRIPT_NAME'} onSubmit="return cryptWarning()">
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password>
<input type=submit name=action value="Encrypt passwords" onClick="selectAction('ENCRYPT')">
</form><p>

<form method=post action=$ENV{'SCRIPT_NAME'}>
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password>
<input type=submit name=action value="View log"></form> </center></td>

</tr></table>
EOF
}

######### Backup registration database
sub backup   {
unless (-e "$basepath$backdir/$regdir")   {
    &oops ("Unable to create $basepath$backdir/$regdir: $!") unless ( mkdir "$basepath$backdir/$regdir", 0755 );
}

&oops ( "Unable to open $basepath$regdir: $!") unless (opendir THEDIR, "$basepath$regdir");
@allfiles = readdir THEDIR;
closedir THEDIR;

foreach (@allfiles) {
   if (-T "$basepath$regdir/$_") {
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
   if (-T "$basepath$backdir/$regdir/$_") {
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
$banner = &makebanner ('ADMINISTRATION <font size=2>authenticate');
print <<EOF;
<body $bodybg $bodytext>$banner $mainfont<p>
<p><div align="center">
<center><table width=60% $subtablebg border="1"><tr><td>
<table border="0" cellpadding="5" width="100%" ><FORM ACTION="$ENV{'SCRIPT_NAME'}"  METHOD=POST>
<!--input type=hidden name="action" value="auth"-->
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

<center><input TYPE="submit" VALUE="Authenticate"></center> </form></p>
EOF
exit;
}

############  Encrypt old passwords
sub encrypt   {
if (-e 'encrypt.log')   {
   $bulletin = "Passwords already encrypted - operation ABORTED!";
   return;
}

$summary = "<center><b>Summary of password encryption:</b> $date</center><p>";
$path =  "$basepath$regdir";

# Obtain all registration records
unless (opendir (REG, "$path"))   {
   $bulletin = "Unable to open $path: $!";
   return;
}

@allusers = readdir (REG);
close REG;

foreach (@allusers)   {
   next unless ($_ =~ /\.dat$/i);
   $user = $_;
   $summary .= "ERROR - unable to read $path/$_: $!<br>\n" unless (open (USER, "$path/$_"));
   ($password,  $email, $realname,$sponsor, $address, $telephone, $status, $question, $answer, $login) = <USER>;
   close USER;
   chomp($password,  $email, $realname,$sponsor, $address, $telephone, $status, $question, $answer, $login);
   $cryptpass = &cryptpass ($password);

   $summary .= "ERROR - unable to write $path/$user: $!<br>\n" unless (open (USER, ">$path/$user"));
   print USER "$cryptpass\n$email\n$realname\n$sponsor\n$address\n$telephone\n$status\n$question\n$answer\n$login";
   close USER;

   $summary .= "$user password $password encrypted to: $cryptpass<br>\n";
}

$bulletin = "Passwords were successfully encrypted!  <b>DO NOT</b> run this procedure again!";

if (open (LOG, ">encrypt.log"))   {
   chmod (0600, 'encrypt.log');
   print LOG $summary;
   close LOG;
   $bulletin .= "<p>Summary report saved in 'encrypt.log'";
}
else  {$bulletin .= "<p>Unable to save encryption summary report 'encrypt.log': $!"}

}

#############  View encryption log
sub encryptlog   {
unless (open (LOG, 'encrypt.log'))   {
   $bulletin = "Unable to read 'encrypt.log': $!";
   return;
}

while (<LOG>)   {
   print $_;
}
close LOG;

print <<EOF;
<p><form method=post action=$ENV{'SCRIPT_NAME'}>
<input type=hidden name=adminid value=$admin_id> 
<input type=hidden name=adminpass value=$admin_password>
$mainfont <font size="+1">
<center><input type=submit name=action value="Return"></center>
EOF
exit;
}

1;
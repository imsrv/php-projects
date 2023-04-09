#!/usr/bin/perl


use CGI::Carp qw(fatalsToBrowser);

require "../configdat.lib";
require "adminmenu.lib";
require "subs.lib";
require "../userspresent.lib";


read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

@pairs = split(/&/, $buffer);
foreach $pair (@pairs)
{
    ($name, $value) = split(/=/, $pair);
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $FORM{$name} = $value;
}
##########################################################

if($FORM{'sendall'} eq "Send to all members"){&sendtoall;}
if($FORM{'sendone'} eq "Send to named recipient"){&sendtonamed;}
if($FORM{'notifymember'} eq "Notify Member"){&sendtonamed;}

sub sendtoall {

if(($FORM{'subject'} eq "")||($FORM{'message'} eq "")||($FORM{'title'} eq "")){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table><tr><td><br>
<font size=2 face=verdana><blockquote>Please fill in the subject, message and title of sender in order to 
continue. <a href="javascript:history.go(-1)">Go back</a>
</font></blockquote>
<br><br></td></tr></table>

<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}


opendir(DIR, "$admincgidir/emaillists");
@lists = readdir(DIR);
closedir(DIR);

foreach $list(@lists){

unless(($list eq "next.txt")||
($list eq ".")||($list eq "..")){

open (IN,"$admincgidir/emaillists/$list");
@lines=<IN>;
close (IN);

foreach $line(@lines)
{
chop $line;
if ($line ne "")
{


open  (MAIL, "| $sendmail -t") || die "cannot open $sendmail\n";  
print MAIL "Subject: $FORM{'subject'}\n"; 
print MAIL "From: $FORM{'title'} \<$email\>\n"; 
print MAIL "To: $line\n";  
print MAIL "Content-type:text/html\n\n";
print MAIL "$emailheader\n";
print MAIL "$FORM{'message'}\n\n";
print MAIL "\n";
print MAIL "$emailfooter\n";
print MAIL "\n";
close MAIL;
}
}
}
}

&adminmenu;
print <<EOF;
<table><tr><td><br>
<font size=2 face=verdana><blockquote> The messages have been sent.

</font></blockquote>
<br><br></td></tr></table>

<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}


sub sendtonamed {

if(($FORM{'subject'} eq "")||($FORM{'message'} eq "")||($FORM{'title'} eq "")||($FORM{'sendto'} eq "")){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table><tr><td><br>
<font size=2 face=verdana><blockquote>Please fill in all fields in order to 
continue. <a href="javascript:history.go(-1)">Go back</a>
</font></blockquote>
<br><br></td></tr></table>

<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}



open  (MAIL, "| $sendmail -t") || die "cannot open $sendmail\n";  
print MAIL "Subject: $FORM{'subject'}\n"; 
print MAIL "From: $FORM{'title'} <$email>\n";
print MAIL "To: $FORM{'username'} <$FORM{'sendto'}>\n";
print MAIL "\n";
print MAIL "$FORM{'message'}\n\n";
print MAIL "\n";
print MAIL "$mailsignature1\n";  
print MAIL "\n";  
print MAIL "$mailsignature2\n";  
print MAIL "\n";
close MAIL;

&adminmenu;
print <<EOF;
<table><tr><td><br>
<font size=2 face=verdana><blockquote>The message has been sent to <b>$FORM{'username'}</b> at <b>$FORM{'sendto'}</b>.

</font></blockquote>
<br><br></td></tr></table>

<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}
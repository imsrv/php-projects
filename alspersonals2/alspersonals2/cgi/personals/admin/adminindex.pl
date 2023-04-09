#!/usr/bin/perl   

use CGI::Carp qw(fatalsToBrowser);
require "subs.lib";
require "../configdat.lib";
require "../userspresent.lib";
require "adminmenu.lib";

$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
$msg = "@_"; 
print "\nContent-type: text/html\n\n";
print "The following error occurred : $msg\n";
exit;
}

# Get the input
read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
    @pairs = split(/&/, $input);
    foreach $pair (@pairs) {
    ($name, $value) = split(/=/, $pair);
    $name =~ tr/+/ /;  
    $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $FORM{$name} = $value;  
    }


$pinnumber=$FORM{'pinnumber'};

if($FORM{'adminlogin'} eq "Login"){&login;}
if (($FORM{'launchadmin'} ne "") || ($ENV{'QUERY_STRING'} =~ /launchadmin/)){
&launchadmin;
exit;}	


sub login {

if($FORM{'method'} eq "noaccess"){
&checkfieldsnoaccess;}

if($FORM{'method'} eq "access"){&checkfieldsaccess;}}

sub checkfieldsnoaccess {

if(($FORM{'adminname'} eq "")||($FORM{'adminpassword'} eq "")){
print "Content-type: text/html\n\n";
print "$adminmainheader<p>\n";
print "<center><font face=univers size=2>Either you have not entered a login name or you have not entered a password.
</font></center>\n";
print "<center><font face=univers size=2>You must enter both an admin name and a password in order to set up your administration center.</font></center>\n";
print "<center><FORM> <INPUT type=\"button\" value=\"<< Go Back\" onClick=\"history.go(-1)\"> </FORM></center>\n";
print "$adminbotcode\n";
exit;
}
&nalog;
}


sub checkfieldsaccess {

if($pinnumber eq ""){
print "Content-type: text/html\n\n";
print "$adminmainheader<p>\n";
print "<center><font face=univers size=2>You have not entered your pin number.\n";
print "<center><FORM> <INPUT type=\"button\" value=\"<< Go Back\" onClick=\"history.go(-1)\"> </FORM></center>\n";
print "$adminbotcode\n";
exit;
}
&checkpintologin;
}



sub nalog {

unless(-e "$admindir/admactive.txt"){
&cannotlogin;}

open(IN, "$admindir/admactive.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
($loginname,$password)= split(/\|/, $line);

if(($FORM{'adminname'} eq "$loginname")&&($FORM{'adminpassword'} eq "$password")){
&launchadmin;}
else {&cannotlogin;}
}
}

sub cannotlogin {

print "Content-type:text/html\n\n";
print "<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>A Personals Touch Installation</font></td></tr>
</table>
<br><br>\n";
print "<table><tr><td><blockquote><font size=2 face=verdana>\n";
print "
Error logging in. Please try again<br><br>

<center><FORM> <INPUT type=\"button\" value=\"<< Go Back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
</td></tr></table>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top>Back to Top</a><br></td></tr></table>
</form>
</body></html>\n";
exit;
}


sub checkpintologin {

unless(-e "$admindir/admactive.txt"){
&cannotlogin;}

if($pinnumber eq "$pin"){&launchadmin;}

else {&cannotlogin;}
}



sub launchadmin {

if(($ENV{'HTTP_REFERER'} =~ /$adminurl/)||
($ENV{'HTTP_REFERER'} =~ /$admincgiurl/)){

print "Content-type:text/html\n\n";
&adminmenu;


print <<EOF;

<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=35 border=\"0\" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align=\"right\"><a href=\"$admincgiurl/adminindex.pl?launchadmin\">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
exit;
}

else {

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

}
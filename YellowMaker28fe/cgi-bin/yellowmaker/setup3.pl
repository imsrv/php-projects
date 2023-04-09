#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# setup3.pl
########################################################################

&parse_form;

print "content-type: text/html\n\n";

if ($form{'admin'} eq "") {
$message="Please enter your [Administractor]'s name.";
print "$message\n\n";
exit;
}

if (($form{'admin'} =~ /[^A-Za-z0-9]/)) {
$message="Sorry, [Your Name] must be 0-9, A-Z and a-z.";
print "$message\n\n";
exit;
}

if (int(length($form{'admin'}) <= 5) || int(length($form{'admin'})) > 15) {
$message="Sorry, [Your Name] must be 6-15 characters.";
print "$message\n\n";
exit;
}

if ($form{'adminpwd'} eq "") {
$message="Please enter [Your Password].";
print "$message\n\n";
exit;
}

if (($form{'adminpwd'} =~ /[^A-Za-z0-9]/)) {
$message="Sorry, [Your Password] must be 0-9, A-Z and a-z.";
print "$message\n\n";
exit;
}

if (int(length($form{'adminpwd'}) <= 5) || int(length($form{'adminpwd'}) > 15)) {
$message="Sorry, [Your Password] must be 6-15 characters.";
print "$message\n\n";
exit;
}

if (($form{'url'} eq "") || ($form{'url'} eq "http://")) {
$message="Please enter your [Web Address].";
print "$message\n\n";
exit;
}

if ($form{'company'} eq "") {
$message="Please enter your [Comapny Name].";
print "$message\n\n";
exit;
}

if ($form{'website'} eq "") {
$message="Please enter your [Web Site Name].";
print "$message\n\n";
exit;
}

if ($form{'title'} eq "") {
$message="Please enter your [Yellow Page Name].";
print "$message\n\n";
exit;
}

if ($form{'slogan'} eq "") {
$message="Please enter your [Yellow Page Slogan].";
print "$message\n\n";
exit;
}

if ($form{'copyright'} eq "") {
$message="Please enter your [Copyright Notice].";
print "$message\n\n";
exit;
}

if ($form{'webmaster'} eq "") {
$message="Please enter your [E-mail Address].";
print "$message\n\n";
exit;
}


if (&valid_address($form{'webmaster'}) == 0) {
$message="Sorry, your [E-mail Address] is invalid.";
print "$message\n\n";
exit;
}

if ($form{'root'} eq "") {
$message="Please enter your [Document Root].";
print "$message\n\n";
exit;
}

if ($form{'cgi'} eq "") {
$message="Please enter your [CGI Folder].";
print "$message\n\n";
exit;
}

if ($form{'sub'} eq "") {
$message="Please enter your [Document & CGI Subdirectory].";
print "$message\n\n";
exit;
}

if ($form{'emailfunction'} eq "") {
$message="Please enter your [E-mail Function].";
print "$message\n\n";
exit;
}

if ($form{'sendmaillocation'} eq "") {
$message="Please enter your [SendMail Location].";
print "$message\n\n";
exit;
}

$emailaddr="$form{'webmaster'}";
$form{'webmaster'} =~ s/@/\\@/;

if (!(-e "$form{'root'}")) {
$message="Your Document Root is incorrect! Please check it carefully.";
print "$message\n\n";
exit;
}

$file="config.pl";
chmod (0666, "$file");
open (CFG, ">$file");
print CFG<<FILE;
\$admin=\"$form{'admin'}\";
\$adminpwd=\"$form{'adminpwd'}\";
\$url=\"$form{'url'}\";
\$company=\"$form{'company'}\";
\$website=\"$form{'website'}\";
\$title=\"$form{'title'}\";
\$slogan=\"$form{'slogan'}\";
\$copyright=\"$form{'copyright'}\";
\$webmaster=\"$form{'webmaster'}\";
\$root=\"$form{'root'}\";
\$cgi=\"$form{'cgi'}\";
\$sub=\"$form{'sub'}\";
\$EmailFunction=\"$form{'emailfunction'}\";
\$SendMailLocation=\"$form{'sendmaillocation'}\";


;1

FILE
close CFG;
chmod (0666, "$file");

$home="$form{'url'}/$form{'sub'}";
$homecgi="$form{'url'}/$form{'cgi'}/$form{'sub'}";
$time=time;
$time2=localtime($time);
($wday, $month, $day, $time, $year)=split(" ",$time2,5);
$date="$wday, $day $month, $year";

print qq~
<html>

<head>
<title>$form{'title'} - $form{'slogan'}</title>
</head>

<body bgcolor="#FFFFCC" text="#000000" topmargin="0" leftmargin="0" link="#000000"
vlink="#000000" alink="#000000" background="$background">
<div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="70%" bgcolor="#FF9933" align="left" height="75" valign="middle"><p align="left"><img
    src="$home/pics/header.gif" alt="$title - $slogan"></td>
    <td width="27%" bgcolor="#FF9933" align="right" height="75" valign="bottom"><p
    align="right"></td>
    <td width="3%" bgcolor="#FF9933" align="left" height="75"></td>
  </tr>
  <tr>
    <td height="30" width="100%" nowrap valign="middle" align="center" bgcolor="#FFD966"
    colspan="3"><table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="100%" valign="middle" align="center" bgcolor="#FFD966"><p align="center"><font
        face="$font" size="$size" color="#000000"><strong>·</strong>&nbsp;&nbsp; <a
        href="$homecgi/index.pl">Home</a>&nbsp; |&nbsp; <a href="$homecgi/signup.pl">Sign Up</a>&nbsp; |&nbsp; <a
        href="$homecgi/member.pl">Member Center</a><strong>&nbsp;&nbsp; ·</strong></font></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</center></div><div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="100%" align="center"><br>
    <br>
    <br>
    <img src="$home/pics/confirm.gif" alt="Confirmation" border="0"><br>
    <br>
    <br>
    <br>
    <strong>Congratulations!<br>
    </strong><br>
    <br>
    You have been successfully installed YellowMaker to your web server. <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    </td>
  </tr>
</table>
</center></div><div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="100%" height="10" align="center" valign="top" colspan="3" bgcolor="#FF9933"></td>
  </tr>
  <tr>
    <td width="5%" valign="middle" align="center" bgcolor="#FFD966" height="20"></td>
    <td width="90%" valign="middle" align="center" bgcolor="#FFD966" height="20"></td>
    <td width="5%" valign="middle" align="center" bgcolor="#FFD966" height="20"></td>
  </tr>
  <tr>
    <td width="5%" valign="top" align="center" height="75" bgcolor="#FFD966"></td>
    <td width="90%" valign="top" align="center" bgcolor="#FFD966" height="75"><font
    face="$font" size="$size"><a href="$homecgi/copyr.pl">$copyright</a> Use of this web
    site constitutes acceptance of the $company <a href="$homecgi/terms.pl">Service
    Agreement</a> and <a href="$homecgi/privacy.pl">Privacy Policy</a>.&nbsp;Designated
    trademarks and brands are the property of their respective owners. This program is powered
    by <a href="http://www.yellowmaker.com">YellowMaker</a>.</font><p>&nbsp;</td>
    <td width="5%" valign="top" align="center" height="75" bgcolor="#FFD966"></td>
  </tr>
</table>
</center></div>
</body>
</html>
~;

exit;


sub parse_form {
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
if (length($buffer) < 5) {
$buffer=$ENV{QUERY_STRING};
}
@pairs=split(/&/, $buffer);
foreach $pair (@pairs) {
($frmname, $value)=split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$form{$frmname}=$value;
}
}

sub include {
&localvals;
local (%listvals)=%localvals;
local ($thehtmlfile)=@_;
local ($thepathtohtmlfile)="$ENV{'DOCUMENT_ROOT'}/$thehtmlfile";
open(in, "<$thepathtohtmlfile") || die "Cannot open file: 
$thepathtohtmlfile for read!\n";
$thepathtohtmlfile="";
while(<in>) {
$thepathtohtmlfile .= $_;
}
close(in);
for $ikey (keys(%listvals)) {
local($value)=$listvals{"$ikey"};
$thepathtohtmlfile =~ s/$ikey/$value/gm;
}	
print "$thepathtohtmlfile\n";
return;
}

sub localvals {
%localvals=(
"$company","$form{'company'}",
"!COPYRIGHT!","$form{'copyright'}",
"!DATE!","$date",
"!EMAILADDR!","$form{'webmaster'}",
"$home","$home",
"$homecgi","$homecgi",
"$slogan","$form{'slogan'}",
"$title","$form{'title'}",
"!URL!","$form{'url'}",
"!WEBSITE!","$form{'website'}",
);
}

sub valid_address {
local ($testmail)=@_;
if ($testmail !~ /^[a-zA-Z0-9-_]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9-]+/)
{return 0;}
else 
{return 1;}
}

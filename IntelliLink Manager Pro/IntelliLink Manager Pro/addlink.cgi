#!/usr/bin/perl

##########################################################################
##																		##
##						 IntelliLink Manager Pro						##
##						 -----------------------						##
##					   by Jimmy (wordx@hotmail.com)						##
##						http://www.smartCGIs.com						##
##																		##
##	IntelliLink Pro is not a free script. If you got this from someone  ##
##  please contact me. Visit our site for up to date versions. Most		##
##  CGIs are over $100, sometimes more than $500, this script is much	##
##  less. We can keep this script cheap, as well as a free version on	##
##  our site, if people don't steal it. If you are going to use a		##
##	stolen version, please atleast DO NOT remove any of the copyrights  ##
##	or links to our site, they keep this CGI cheap for everyone.		##
##	Thanks!																##
##																		##
##				  (c) copyright 2000 The Mp3eCom Network				##
##########################################################################

print "Content-type: text/html\n\n";

require "variables.cgi";
$sitename = "$variables{'sitename'}";
$siteurl = "$variables{'siteurl'}";
$bannerurl = "$variables{'bannerurl'}";
$cgiurl = "$variables{'cgiurl'}";
$body = "$variables{'body'}";	
$mailp = "$variables{'mailp'}";	
$wemail = "$variables{'wemail'}";	
$maxtitle = "$variables{'maxtitle'}";	
$maxdescription = "$variables{'maxdescription'}";	
$report = "$variables{'report'}";	
$emailwebmaster = "$variables{'emailwebmaster'}";	
$badchar = "$variables{'badchar'}";	


$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$title = $in{'title'};
$description = $in{'description'};
$url = $in{'url'};
$email = $in{'email'};
$password = $in{'password'};
$sendreport = $in{'sendreport'};

if($url eq "") { &urlform; }
if($title eq "") { &addform; }
&checkentry;
&submit;

sub urlform {
print <<EOF;
<title>Submit Site to $sitename</title>
$body
EOF
open(DATA,"addlink_head.txt");
print <DATA>;
close(DATA);
print <<EOF;
<script><!--
var sdsubmit=1
function validateForm(form) {
if (sdsubmit){
	urlstr = new String()
	urlstr.value = form.url.value
	if ( urlstr.value == "http://"){
		alert("You forgot to type something.")
		form.url.focus()
		return false
	}
	form.submit.value = "Please wait..."
	form.submit.blur()
	sdsubmit=0
}
else {return false}
}
//--></script>

<form method="GET" action="addlink.cgi" onSubmit="return validateForm(this)" name="f">
<div align="center"><center>Your Site's URL: <input type="text" name="url" value="http://" size="23"> <input type="submit"
      value="  Submit  " name="submit">
  </center></div>
</form>
EOF
&info;
print "<!--ORDnum RE2081730-->\n"; #do not remove this, or the CGI will not work.
exit;
}

sub submit {
$time = time();
if (-e "data.txt") {
open(DATA,">>data.txt");
flock (DATA,2);
print DATA "0|0|$time|$password|$title|$description|$url|$email|$sendreport\n";
flock (DATA,8);
close(DATA);
					} else {
					open(DATA,">data.txt");
					print DATA "0|0|$time|$password|$title|$description|$url|$email|$sendreport\n";
					close(DATA);
					}
&emailmember;
if($emailwebmaster eq "1") { &emailwebmaster; }
&results;
exit;
}

sub emailmember {
open(MAIL,"|$mailp -t");
print MAIL "To: $email\n";
print MAIL "From: $wemail\n";
print MAIL "Subject: $sitename Link Exchange\n\n";
print MAIL "Thank you for exchanging links with $sitename.\n\n";
print MAIL "You have submitted the following information:\n\n";
print MAIL "Site Name: $title\n";
print MAIL "Site Description: $description\n";
print MAIL "Site URL: $url\n";
print MAIL "Email Address: $email\n";
print MAIL "Account Number: $time\n";
print MAIL "Password: $password\n";
print MAIL "You should always link to this URL: $cgiurl/in.cgi?id=$time\n\n";
print MAIL "Edit your account here: $cgiurl/edit.cgi\n";
print MAIL "\n\n";
close (MAIL);
}

sub emailwebmaster {
open(MAIL,"|$mailp -t");
print MAIL "To: $wemail\n";
print MAIL "From: $wemail\n";
print MAIL "Subject: New Site Exchanged Links With You\n\n";
print MAIL "The following was submitted by the webmaster who recently joined your Link Exchange:\n\n";
print MAIL "Site Name: $title\n";
print MAIL "Site Description: $description\n";
print MAIL "Site URL: $url\n";
print MAIL "Email Address: $email\n";
print MAIL "Account Number: $time\n";
print MAIL "\n\n";
close (MAIL);
}

sub results {
print "<title>Instructions</title>\n";
print "$body";
print <<EOF;
<div align="center"><center>

<table border="0">
  <tr>
    <td><p align="left"><b>Title:</td>
    <td>$title</td>
  </tr>
  <tr>
    <td align="left"><b>Description:</td>
    <td>$description</td>
  </tr>
  <tr>
    <td align="left"><b>URL:</td>
    <td>$url</td>
  </tr>
  <tr>
    <td align="left"><b>E-mail:</td>
    <td>$email</td>
  </tr>
   <tr>
    <td align="left"><b>ID Number:</td>
    <td>$time</td>
  </tr>
  <tr>
    <td align="left"><b>Password:</td>
    <td>$password</td>
  </tr>
</table>
(This information has been e-mailed to you)
<p>
<a href="$cgiurl/edit.cgi">Edit your Info here</a>
</center></div>
<br>
<center>
<table width=400><tr><td>
<p align="center"><strong><u>Linking Instructions:</u></strong></p>

Always link to:<br><b>$cgiurl/in.cgi?id=$time</b><p>

A text link would look like this:<br>&lt;a
href=&quot;$cgiurl/in.cgi?id=$time&quot;&gt;$sitename&lt;/a&gt;<p>

You can find graphics to link with <a href="$bannerurl">here</a>.
</td></tr>
</table>
</center>
EOF
&info;
}

sub checkentry {
if(($description eq "")||($email eq "")||($url eq "")||($password eq "")) {
print "$body\n";
print "<title>Something Left Blank</title>\n";
print "You left something blank.\n";
exit;
}
if($title =~ /^\||\|/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You used an invalid character in your title.\n";
exit;
}
if(($description =~ /^'|'/)||($description =~ /^\||\|/)) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You used an invalid character in your description.\n";
exit;
}
@badchar = split(/ /, $badchar);
foreach $bad(@badchar) {
if($title =~ /^$bad|$bad/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You cannot use \"$bad\" in your title.\n";
exit;
}
if($description =~ /^$bad|$bad/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You cannot use \"$bad\"  in your description.\n";
exit;
}
						}
# e-mail is valid?
if(not($email =~ /^\@|\@/)) {
print "$body\n";
print "<title>Invalid E-mail</title>\n";
print "Please provide a valid e-mail address.\n";
exit;
}
}

sub addform {
if(not($url =~ /^http:\/\//)) {
print "$body\n";
print "<title>Invalid URL</title>\n";
print "You need to include http:// in your URL.\n";
exit;
}

print <<EOF;
<title>Submit Site to $sitename</title>
$body

<script><!--
var sdsubmit=1
function validateForm(form) {
if (sdsubmit){
	urlstr = new String()
	urlstr.value = form.url.value
	form.submit.value = "Please wait..."
	form.submit.blur()
	sdsubmit=0
}
else {return false}
}
//--></script>

<form method="GET" action="addlink.cgi" onSubmit="return validateForm(this)" name="f">
<div align="center"><center>Please provide the following information to complete the submission.<p>
<table border="0" width="289">
    <tr>
      <td width="111" align="center"><div align="right"><p>Title:</td>
      <td width="223" align="left"><input type="text" name="title" maxlength="$maxtitle" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right">Description:</td>
      <td width="223" align="left"><input type="text" name="description" maxlength="$maxdescription" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right">URL:</td>
      <td width="223" align="left"><input type="text" name="url" value="$url" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right"> E-mail:</td>
      <td width="223" align="left"><input type="text" name="email" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right"> Password:</td>
      <td width="223" align="left"><input type="text" name="password" size="23"></td>
    </tr>
  </table>
EOF
if($report eq "1") {
print <<EOF;
  <input type="checkbox" name="sendreport" value="R">E-mail me a Report
  daily (In/Out stats, etc.)
  <br>
EOF
					}
print <<EOF;
  <input type="submit" value="  Submit  " name="submit"> <input type="reset" value="Reset" name="reset">
  </center></div>
</form>
EOF
&info;
exit;
}
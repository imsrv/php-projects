#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# setup2.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}


$url=$ENV{'SERVER_NAME'};
$root=$ENV{'DOCUMENT_ROOT'};

@cgipath=split(/\//, $ENV{'SCRIPT_FILENAME'});
pop(@cgipath);
$sub=pop(@cgipath);

@cgipath2=split(/\/$sub/, $ENV{'SCRIPT_FILENAME'});
pop(@cgipath2);
$sub2=pop(@cgipath2);

$cgisub="$sub2/$sub";
@cgipath3=split(/\//, $cgisub);
pop(@cgipath3);
$cgi=pop(@cgipath3);

$homecgi="http://$url/$cgi/$sub";

&parse_form;

$form{'admin'} =~ s/^\s+//;
$form{'admin'} =~ s/\s+$//;  
$form{'admin'} =~ tr/A-Z/a-z/;
$form{'adminpwd'} =~ s/^\s+//;
$form{'adminpwd'} =~ s/\s+$//;

print "content-type: text/html\n\n";

if (!$form{'admin'}) {
$message="Please enter your [Administractor]'s name.";
print "$message\n";
exit;
}

if (!$form{'adminpwd'}) {
$message="Please enter your [Password].";
print "$message\n";
exit;
}

if ($form{'admin'} ne "$admin") {
$message="Sorry, your [Administractor]'s name is incorrect! Please try again.";
print "$message\n";
exit;
}

if ($form{'adminpwd'} ne "$adminpwd") {
$message="Sorry, your [Password] is incorrect! Please try again.";
print "$message\n";
exit;
}

print qq~
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Setup</title>
</head>

<body bgcolor="#FFFFCC" text="#000000" topmargin="0" leftmargin="0">
<div align="center"><center>

<table border="0" cellpadding="0" width="100%" cellspacing="0">
  <tr>
    <td width="75%" bgcolor="#FF9933" height="60" align="left" valign="middle"><img
    src="http://www.yellowmaker.com/yellowmaker/fe/pics/header.gif" border="0" alt="YellowMaker"></td>
    <td width="22%" bgcolor="#FF9933" height="60"></td>
    <td width="3%" bgcolor="#FF9933" height="60"></td>
  </tr>
  <tr>
    <td height="30" width="100%" nowrap valign="middle" align="center" bgcolor="#FFD966"
    colspan="3"></td>
  </tr>
  <tr>
    <td height="25" width="100%" nowrap bgcolor="#FFFFCC" colspan="3"></td>
  </tr>
</table>
</center></div><div align="center"><center>

<table border="0" cellpadding="5" width="90%">
  <tr>
    <td width="100%"><form action="$homecgi/setup3.pl" method="POST">
      <div align="center"><center><table border="0" width="100%" cellpadding="5">
        <tr>
          <td width="100%" colspan="2" valign="top" align="center"><div align="center"><center><p><img
          src="http://www.yellowmaker.com/yellowmaker/fe/pics/setup.gif" alt="Setup" border="0"></p>
          </center></div><div align="center"><center><p>Please setting your configurations shown
          below.<br>
          * Required Fields</td>
        </tr>
        <tr align="center">
          <td width="100%" colspan="2"><hr noshade color="#FF9933" size="1">
          </td>
        </tr>
        <tr align="center">
          <td width="27%" bgcolor="#FFE699" valign="top" align="right"><strong>1.</strong></td>
          <td width="73%" bgcolor="#FFE699" valign="top" align="left"><strong>Your Name:*</strong><br>
          <input type="text" name="admin" size="20" value="$admin" maxlength="15"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>2.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Your
          Password:*</strong><br><input type="password" name="adminpwd" size="20" value="$adminpwd" maxlength="15"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>3.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Web
          Address:*</strong><br>
          The url of your site. (e.g. &quot;http://www.yourdomain.com&quot;)<br>
          Important note: Your web address can't end with &quot;/&quot;<br>
          <input type="text" name="url" size="40" value="http://$url"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>4.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Company
          Name:*</strong><br>
          <input type="text" name="company" size="40"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>5.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Web Site
          Name:*</strong><br>
          The name of your home page where you install this program.<br>
          <input type="text" name="website" size="40"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>6.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Yellow
          Page Title:*</strong><br>
          The name of this program.<br>
          <input type="text" name="title" size="40"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>7.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Yellow
          Page Slogan:*</strong><br>
          <input type="text" name="slogan" size="40"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>8.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Copyright
          Notice:*</strong><br>
          <input type="text" name="copyright" size="50" value="© Copyright. All right reserved."></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>9.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>E-mail
          Address:*</strong><br>
          Your e-mail address. (e.g. &quot;webmaster\@yourdomain.com&quot;)<br>
          <input type="text" name="webmaster" size="40"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>10.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Document
          Root:*<br>
          </strong>The directory out of which you will serve your documents. (e.g.
          &quot;/home/userid/htdocs&quot;)<br>
          <input type="text" name="root" size="40" value="$root"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>11.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>CGI
          Path:*</strong><br>
          The top of the directory tree under which the CGI files are kept. (e.g.
          &quot;cgi-bin&quot;)<br>
          <input type="text" name="cgi" size="20" value="$cgi"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>12.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>Document
          &amp; CGI Sub-directory:*</strong><br>
          The sub-directory where the CGI files and all documents are located under Document Root
          above. (e.g. yellowmaker, public_html/yellowmaker, www/yellowmaker)<br>
          <input type="text" name="sub" size="20" value="$sub"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>13.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>E-mail
          Function:*</strong><br>
          Choose the type of method this program should send mail by. &nbsp; (e.g.
          &quot;SendMail&quot; or &quot;SMTP&quot;)<br>
          <input type="text" name="emailfunction" size="30" value="SendMail"></td>
        </tr>
        <tr align="center">
          <td width="27%" height="15" bgcolor="#FFE699" valign="top" align="right"><strong>14.</strong></td>
          <td width="73%" height="15" bgcolor="#FFE699" valign="top" align="left"><strong>SendMail
          Location:*</strong><br>
          Please fill in the location of the sendmail program on your server. (e.g.
          &quot;/usr/bin/sendmail&quot;). If you choose to use your smtp server, please fill in the
          address of your smtp server. (e.g. &quot;smtp.yourdomain.com&quot;)<br>
          <input type="text" name="sendmaillocation" size="30"></td>
        </tr>
        <tr align="center">
          <td width="100%" colspan="2"><hr noshade color="#FF9933" size="1">
          </td>
        </tr>
        <tr align="center">
          <td width="100%" colspan="2"><div align="center"><center><p><input
          src="http://www.yellowmaker.com/yellowmaker/fe/pics/enter.gif" name="I1" alt="Enter" type="image"
          border="0"></td>
        </tr>
      </table>
      </center></div>
    </form>
    </td>
  </tr>
</table>
</center></div><div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="100%" height="35"></td>
  </tr>
  <tr>
    <td width="100%" height="7" bgcolor="#FF9933"></td>
  </tr>
  <tr>
    <td width="100%" height="20" bgcolor="#FFD966"></td>
  </tr>
  <tr>
    <td width="100%" valign="top" align="center" height="120" bgcolor="#FFD966">© Copyright
    YellowMaker.com 2001-2002. All right reserved.<br>
    To contact YellowMaker.com regarding questions, problems or feedback - <a
    href="mailto:webmaster\@yellowmaker.com">webmaster\@yellowmaker.com</a>.<br>
    For sponsorship and advertising information - <a
    href="mailto:webmaster\@yellowmaker.com">webmaster\@yellowmaker.com</a>.</td>
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


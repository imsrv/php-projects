#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# setup.pl
########################################################################

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

print "content-type: text/html\n\n";

print qq~
<html>

<head>
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
    <td width="100%"><form action="$homecgi/setup2.pl" method="POST">
      <div align="center"><center><table border="0" width="100%" cellpadding="5">
        <tr>
          <td colspan="2" width="100%" valign="top" align="center"><div align="center"><center><p><img
          src="http://www.yellowmaker.com/yellowmaker/fe/pics/setup.gif" alt="Setup" border="0"></p>
          </center></div><div align="center"><center><p>Please enter your authentication
          information.</td>
        </tr>
        <tr align="center">
          <td width="100%" colspan="2"><hr noshade color="#FF9933" size="1">
          </td>
        </tr>
        <tr align="center">
          <td width="45%" align="right" bgcolor="#FFE699"><strong>Administrator: </strong></td>
          <td width="55%" align="left" bgcolor="#FFE699"><input type="text" size="20" name="admin"></td>
        </tr>
        <tr align="center">
          <td width="45%" align="right" bgcolor="#FFE699"><strong>Password:</strong></td>
          <td width="55%" align="left" bgcolor="#FFE699"><input type="password" size="20"
          name="adminpwd"></td>
        </tr>
        <tr align="center">
          <td colspan="2" width="100%"><hr noshade color="#FF9933" size="1">
          </td>
        </tr>
        <tr align="center">
          <td width="100%" colspan="2"><div align="center"><center><p><input
          src="http://www.yellowmaker.com/yellowmaker/fe/pics/enter.gif" name="I2" alt="Enter" type="image"
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
    For sponsorship and advertising information - <a href="mailto:webmaster\@yellowmaker.com">webmaster\@yellowmaker.com</a>.<p>&nbsp;</td>
  </tr>
</table>
</center></div>
</body>
</html>
~;

exit;

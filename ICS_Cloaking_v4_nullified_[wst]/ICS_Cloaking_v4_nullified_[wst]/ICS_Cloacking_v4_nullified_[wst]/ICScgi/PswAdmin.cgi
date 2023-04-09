#!/usr/bin/perl
###########################################################################
# DATE:                   December 11, 2000 ICSv4.0
# PROGRAM:                PswAdmin.cgi
# DESCRIPTION:            Changes passwords.
#	       				  
#
# COPYRIGHT 2000 by ICS Scripts. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################
use CGI;
$go = CGI::new( );
print $go->header( );
#############################
# Get all variables         #
#############################
eval {

require "default.cgi";
require "GetCookie.cgi";

};


if ($@) {
print "Error including required files: $@\n\n";
print "Make sure these files exist, permissions\n";
print "are set properly, and paths are set correctly.\n\n";
exit;
}

&GetCookie();
if($Auth ne "OK"){
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSstart.cgi\">";
       exit;
}

if ($ENV{'QUERY_STRING'} =~ /go/) {

   #Get the current IPs and Agents
   &DoParseForm;

   #Create and display the form
   &DoWritePsw;

   $TopError = "Password Action Successful";
   &ShowResult("The password has been changed.");
   }

&DoDisplayForm;

exit;

#-------------------------------------------------------------#
sub DoDisplayForm {
print <<EndHTML;
<HTML>
<title>ICS40 Pswd Admin</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="50%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
<table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">

<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Administer Password</font>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/psw_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
<tr>
<td bgcolor="#FBF3D9" align="right">
<font face="Verdana" size="-1" color="#400060"><b>UserID</b>:</font>
</td>
<td bgcolor="#FBF3D9" align="left">
<font face="Verdana" size="-1" color="#008080"><b>Admin</b></font>
</td>
</tr>
<tr>
<td bgcolor="#FBF3D9" align="right">
<font face="Verdana" size="-1" color="#400060"><b>New Password</b>:</font>
</td>
<td bgcolor="#FBF3D9" align="left">
<input type="password" name="NewPsw" value="">
</td>
</tr>
<tr>
<td bgcolor="#FBF3D9" align="right">
<font face="Verdana" size="-1" color="#400060"><b>Retype New Password</b>:</font>
</td>
<td bgcolor="#FBF3D9" align="left">
<input type="password" name="RetypeNewPsw" value="">
</td>
</tr>
<tr>
<tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
<INPUT TYPE="SUBMIT" VALUE="Change Password">
</td>
</tr>
</FORM>
<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in PswAdmin.cgi</font></a>
</td>
</tr>
</table>
</td>
<tr>
</TABLE>
</center>
</BODY>
</HTML>
EndHTML
exit;
          }
#-------------------------------------------------------------#
sub DoParseForm {
$NewPsw = $go->param('NewPsw');
$RetypeNewPsw = $go->param('RetypeNewPsw');

   if($NewPsw ne $RetypeNewPsw){
      $TopError = "Password change error";
      &ConfigError("The new password and the retyped password do not match.");
      }
   if($NewPsw eq ""){
      $TopError = "Password change error";
      &ConfigError("The password cannot be blank.");
      }
}
#-------------------------------------------------------------#
sub DoWritePsw {

   open(PSWFILE,">$filepath/$cgidirectory/pwfile.cgi") or &dienice("cannot open 
        $filepath/$cgidirectory/pwfile.cgi");
        print PSWFILE "$NewPsw|Admin";

  close (PSWFILE);
 }

#------------------------------------------------------------------#
sub ConfigError {
    ($msg) = @_;
print <<EndOfHTML;
<html><head>
<title>Config Error</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>
<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="60%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Password Action</font>
</td>
</tr>
<tr>
<td height="10" bgcolor="#EAEAD5">
<br>
<font color="#FF0000" size="3" face="Arial"><b>$TopError!</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="+4" face="verdana, arial" color="#FF0000">!</font>
<font size="-1" face="verdana, arial">$msg</font>
</td>
</tr>

<tr>
<td bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>

<tr>
<td align="center" bgcolor="#EAEAD5">
&nbsp;<form OnSubmit="return false"><input type="submit" OnClick="history.go(-1)" value="Administer Password">
</td>
</tr>

<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in PswAdmin.cgi</font></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
</body></html>
EndOfHTML
exit;
}
#------------------------------------------------------------------#
sub ShowResult {

    ($msg) = @_;
print <<EndOfHTML;
<html><head>
<title>Log Action</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>
<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="60%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Password Action</font>
</td>
</tr>
<tr>
<td height="10" bgcolor="#EAEAD5">
<br>
<font color="#008040" size="3" face="Arial"><b>$TopError!</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="+4" face="verdana, arial" color="#008040">!</font>
<font size="-1" face="verdana, arial">$msg</font>
</td>
</tr>

<tr>
<td bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>

<tr>
<td align="center" bgcolor="#EAEAD5">
[<a href="Navigation.cgi"><font face=arial size="-2" color="#0080FF">Navigation Interface</font></a>]
</td>
</tr>

<tr>
<td align="right" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in PswAdmin.cgi</font></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
</body></html>
EndOfHTML
exit;
}
#-------------------------------------------------------------#
sub dienice {
    ($msg) = @_;
    print "<h2>Error</h2>\n";
    print "$msg";
    exit;
}
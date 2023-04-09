#!/usr/bin/perl
###########################################################################
# DATE:                   November 11, 2000
# PROGRAM:                ICSstart.cgi
# DESCRIPTION:            Login to ICS and set cookie to authenticate.
#
# COPYRIGHT 2000 by ICS Scripts. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################
use CGI;
$query = new CGI;

#############################
# Get all variables         #
#############################
eval {

require "default.cgi";
require "SetCookie.cgi";

};


if ($@) {
print "Error including required files: $@\n\n";
print "Make sure these files exist, permissions\n";
print "are set properly, and paths are set correctly.\n\n";
exit;
}

if($ENV{'QUERY_STRING'} =~ /go/){
   
   &GetVariables;

   &CheckPsw;
   }
   else {
     &DisplayForm;
     }
          

#-------------------------------------------------------------------------#
sub DisplayForm {
print $query->header( );
print <<EndOfHTML;
<html><head>
<title>ICS40 Control Panel</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="50%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
<table cellspacing="0" cellpadding="2" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Authentication Required!</font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<br><br>
<font size="2" face="verdana, arial"><b>UserID</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<br><br>
<input type="text" name="userid" value="">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Password</b>:&nbsp;</font>
<br><br><br>
</td>
<td  bgcolor="#FBF3D9">
<input type="password" name="password" value="">
<br><br><br>
</td>
</tr>

<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<input type="submit" value="Authenticate">
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
sub GetVariables {
    $password = $query->param("password");
    $userid = $query->param("userid");

}
#------------------------------------------------------------------#
sub CheckPsw {

 if($password eq ""){
    $TopError = "Authentication Failed!";
    &ConfigError("Password cannot be blank. Please Specify A Valid Password.");
  }

open (PSWFILE,"<$filepath/$cgidirectory/pwfile.cgi") || &dienice;
	  $pw ="";
	  while (read (PSWFILE, $buffer, 80)){
	         $pswd .= $buffer;
             }
      close (PSWFILE);
      ($pw, $id) = split(/\|/, $pswd);

 if(($password eq $pw) && ($userid eq $id)){
          &SetCookie;
          &GoHere;

          }
  else{
       $TopError = "Authentication Failed!";
       &ConfigError("Access Denied. Please Specify A Valid ID and Password.");
  }
}

#------------------------------------------------------------------#
sub GoHere{

       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=Navigation.cgi\">";
       exit;
       }

#------------------------------------------------------------------#
sub ConfigError {
print $query->header( );
    ($msg) = @_;
print <<EndOfHTML;
<html><head>
<title>Config Error</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>
<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Authentication</font>
</td>
</tr>
<tr>
<td height="10" bgcolor="#EAEAD5">
<br>
<font color="#FF0000" size="3" face="Arial"><b>$TopError</b></font>
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
<td bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>

<tr>
<td align="center" bgcolor="#EAEAD5">
&nbsp;<form OnSubmit="return false"><input type="submit" OnClick="history.go(-1)" value="Return To Login">
</td>
</tr>

<tr>
<td align="right" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in ICSstart.cgi</font></a>
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
sub dienice {

 if(($password eq "password") && ($userid eq "Admin")){

   &SetCookie;

       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=Navigation.cgi\">";
       exit;
 
 }else {
          $TopError = "Authentication Failed!";
          &ConfigError("Password Is Incorrect. Please Specify A Valid ID and Password.");

          exit;
          }
}
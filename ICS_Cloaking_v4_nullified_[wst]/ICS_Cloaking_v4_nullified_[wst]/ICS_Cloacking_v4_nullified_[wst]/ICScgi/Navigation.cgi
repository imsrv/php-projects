#!/usr/bin/perl
###########################################################################
# DATE:                   November 11, 2000
# PROGRAM:                Navigation.cgi
# DESCRIPTION:            Navigation to all interfaces.
#
# COPYRIGHT 2000 by ICS Scripts. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################
use CGI;
$query = new CGI;
print $query->header( );
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

if($ENV{'QUERY_STRING'} =~ /go/){
   
&GetCookie();
if($Auth ne "OK"){
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSstart.cgi\">";
       exit;
       }
   &GoToChoice;
   }
   else {
&GetCookie();
if($Auth ne "OK"){
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSstart.cgi\">";
       exit;
       }
     &DisplayForm;
     }
          

#-------------------------------------------------------------------------#
sub DisplayForm {
print <<EndOfHTML;
<html><head>
<title>ICS40 Navigation</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
<table cellspacing="0" cellpadding="1" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2" height="40">
<font color="#400060" size="+1" face="Arial">Navigation</font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/nav_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-1" face="verdana, arial">Help </font></a>]</font>
<br>
</td>
</tr>

<tr>
<td bgcolor="#FBF3D9" align="right" width="70%">
<font color="#400060" size="-1" face="Arial"><b>SELECT:</b></font>&nbsp;
<select name="Chosen">
  <option value="GlobalVariables">Set/Change Site Global Variables</option>
  <option value="SiteOptions">Set Cloaking And notification Options</option>
  <option value="CloakPage">Cloaking A Page - Step By Step</option>
  <option value="IPadmin">IP Address And User Agent Admin</option>
  <option value="ViewIP">Display Current IP/UA List</option>
  <option selected value="LogAnalyzer">View, Delete, Rotate Logs</option>
  <option value="NSlookup">NS Host Lookup By IP</option>
  <option value="ICSspider">ICS Spider - Fetch URL</option>
  <option value="AdminPw">Change Password</option>
</select>
<br><br>
</td>
<td bgcolor="#FBF3D9" align="left">
<input type="submit" value=" Go ">
<br><br>
</td>
</tr>
<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in Navigation.cgi</font></a>
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
sub GoToChoice {
    $Chosen = $query->param("Chosen");

   if ($Chosen eq "GlobalVariables") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=GlobalVariables.cgi\">";
       exit;
       }
   if ($Chosen eq "SiteOptions") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=SetMultiStage.cgi\">";
       exit;
       }
   if ($Chosen eq "CloakPage") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=StepByStep.cgi\">";
       exit;
       }
   if ($Chosen eq "IPadmin") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=IPadmin.cgi?go\">";
       exit;
       }
   if ($Chosen eq "ViewIP") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=IPadmin.cgi?List\">";
       exit;
       }
   if ($Chosen eq "LogAnalyzer") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=LogAnalyzer.cgi\">";
       exit;
       }
   if ($Chosen eq "NSlookup") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=nslookup.cgi\">";
       exit;
       }
   if ($Chosen eq "ICSspider") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSspider.cgi\">";
       exit;
       }
   if ($Chosen eq "AdminPw") {
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=PswAdmin.cgi\">";
       exit;
       }else{
             $TopError = "No Option chosen!";
             &ConfigError("Please select interface by clicking the radio button, then hit \"Go\".");
        }
exit;
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
<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Navigation</font>
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
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in Navigation.cgi</font></a>
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

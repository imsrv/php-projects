#!/usr/bin/perl
###########################################################################
# DATE:                   December 02, 2000 ICSv4.0
# PROGRAM:                SetMultiStage.cgi
# DESCRIPTION:            Sets Spider detection and notification options.
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
require "options.cgi";
require "GetCookie.cgi";

};


if ($@) {
$TopError = "<b>Error including required files</b>;<br>";
&ConfigError("$@, Make sure these files exist, permissions
are set properly, and paths are set correctly in the <i>Global Variables</i> interface.");
}


       if($ENV{'QUERY_STRING'} eq "go"){

         &GetCookie();
         if($Auth ne "OK"){
            print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
            print "URL=ICSstart.cgi\">";
            exit;
            }
          
         &GetVariables;

         &WriteVariables;

         &ShowResult;

         exit;

         }

         &GetCookie();
         if($Auth ne "OK"){
            print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
            print "URL=ICSstart.cgi\">";
            exit;
            }

         &DisplayForm;




sub DisplayForm {
print <<EndOfHTML;
<html><head>
<title>ICS40 Control Panel</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
<table cellspacing="0" cellpadding="2" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Cloaking Options</font>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/opt_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Browser Multistage Detection:</b></font>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Human Browser Footprint Detection</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="MultiStage1">
  <option value="$MultiStage1">$MultiStage1</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Use One Spider Directory:</b></font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Serve All Known Spiders From One Directory</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="ServeAllFromHere">
  <option value="$ServeAllFromHere">$ServeAllFromHere</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>From This Directory</b>:&nbsp;</font>
</td>
EndOfHTML


print "<td bgcolor=\"#FBF3D9\">\n";
print "<select name=\"DefaultDir1\">\n";
print "  <option value=\"$DefaultDir1\">$DefaultDir1</option>\n";
print "  <option value=\"Match To Spider\">Match To Spider</option>\n";

opendir(FILES,"$filepath/$Directories");
@DefaultDir1 = sort(grep(!/^\.\.?$/,readdir(FILES)));
closedir(FILES);
 foreach $DefaultDir1 (@DefaultDir1){
   unless($DefaultDir1 eq "HumanVisitor"){
   print "  <option value=\"$DefaultDir1\">$DefaultDir1</option>\n";
   }
  }
print "</select>\n";
print "</td>\n";
print "</tr>\n";

print <<EndOfHTML;
<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>IP Multistage Detection:</b></font>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 1</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="IPStage1">
  <option value="$IPStage1">$IPStage1</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 2</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="IPStage2">
  <option value="$IPStage2">$IPStage2</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 3</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="IPStage3">
  <option value="$IPStage3">$IPStage3</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>User Agent Multistage Detection:</b></font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 1</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="UAStage1">
  <option value="$UAStage1">$UAStage1</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 2</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="UAStage2">
  <option value="$UAStage2">$UAStage2</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>


<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 3</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="UAStage3">
  <option value="$UAStage3">$UAStage3</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Generic Spider Detection:</b></font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>GE STAGE 1</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="IPStage4">
  <option value="$IPStage4">$IPStage4</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Generic Match Served From</b>:&nbsp;</font>
</td>
EndOfHTML


print "<td bgcolor=\"#FBF3D9\">\n";
print "<select name=\"DefaultDir2\">\n";
print "  <option value=\"$DefaultDir2\">$DefaultDir2</option>\n";
print "  <option value=\"Stage Disabled\">Stage Disabled</option>\n";
opendir(FILES,"$filepath/$Directories");
@DefaultDir2 = sort(grep(!/^\.\.?$/,readdir(FILES)));
closedir(FILES);
 foreach $DefaultDir2 (@DefaultDir2){
   unless($DefaultDir2 eq "HumanVisitor"){
   print "  <option value=\"$DefaultDir2\">$DefaultDir2</option>\n";
   }
  }
print "</select>\n";
print "</td>\n";
print "</tr>\n";

print <<EndOfHTML;
<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Notification And Logging Options:</b></font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Email Notification of Spider Visits</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="DoSendEmail">
  <option value="$DoSendEmail">$DoSendEmail</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>New IP Address Detection</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="UAWarn1">
  <option value="$UAWarn1">$UAWarn1</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log All Unknown Spider Footprints</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="SpiderLike">
  <option value="$SpiderLike">$SpiderLike</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log Known Spider Visits</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="DoWriteLog">
  <option value="$DoWriteLog">$DoWriteLog</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log Human Visits</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="DoWriteVisitorLog">
  <option value="$DoWriteVisitorLog">$DoWriteVisitorLog</option>
  <option value="Active">Active</option>
  <option value="Stopped">Stopped</option>
</select>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>
<tr>
<td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
<input type="submit" value="Activate Settings">
</td>
</tr>
<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in SetMultiStage.cgi</font></a>
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
    $MultiStage1 = $go->param("MultiStage1");
    $IPStage1 = $go->param("IPStage1");
    $IPStage2 = $go->param("IPStage2");
    $IPStage3 = $go->param("IPStage3");
    $IPStage4 = $go->param("IPStage4");
    $DefaultDir2 = $go->param("DefaultDir2");
    $UAStage1 = $go->param("UAStage1");
    $UAStage2 = $go->param("UAStage2");
    $UAStage3 = $go->param("UAStage3");
    $UAWarn1 = $go->param("UAWarn1");
    $SpiderLike = $go->param("SpiderLike");
    $ServeAllFromHere = $go->param("ServeAllFromHere");
    $DefaultDir1 = $go->param("DefaultDir1");
    $DoSendEmail = $go->param("DoSendEmail");
    $DoWriteLog = $go->param("DoWriteLog");
    $DoWriteVisitorLog = $go->param("DoWriteVisitorLog");

    if($ServeAllFromHere eq "Active" && $DefaultDir1 eq "Match To Spider"){
       $TopError = "<b>The options chosen are inconsistent</b>\;";
       &ConfigError("<b>Serve All Known Spiders From One Directory</b> is set to <i>Active</i>, but the directory to serve pages from is set to <i>Match To Spider</i>, this is not valid.<br><br>Select a directory to serve cloaked pages from, <u>or</u> set <b>Serve All Known Spiders From One Directory</b> to <i>Stopped</i>.<br>");
    }

    if($IPStage4 eq "Active" && $DefaultDir2 eq "Stage Disabled"){
       $TopError = "<b>The options chosen are inconsistent</b>\;";
       &ConfigError("<b>GE STAGE 1</b> is set to <i>Active</i>, but the directory to serve pages from is set to <i>Stage Disabled</i>, this is not valid.<br><br>Select a directory to serve GE STAGE1 (Generic) spider hits from, <u>or</u> set <b>GE STAGE 1</b> to <i>Stopped</i>.<br>");
    }

    if($ServeAllFromHere eq "Stopped" && $DefaultDir1 ne "Match To Spider"){
       $TopError = "<b>The options chosen are inconsistent</b>\;";
       &ConfigError("<b>Serve All Known Spiders From One Directory</b> is set to <i>Stopped</i>, but the directory to serve pages from is set to <i>$DefaultDir1</i>, this is not valid.<br><br>Please set the directory to serve pages from to <i>Match To Spider</i> <u>or</u> set <b>Serve All Known Spiders From One Directory</b> to <i>Active</i>.<br>");
    }

    if($IPStage4 eq "Stopped" && $DefaultDir2 ne "Stage Disabled"){
       $TopError = "<b>The options chosen are inconsistent</b>\;";
       &ConfigError("<b>GE STAGE 1</b> is set to <i>Stopped</i>, but the directory to serve pages from is set to <i>$DefaultDir2</i>, this is not valid.<br><br>Set the directory to serve generic pages from to <i>Stage Disabled</i> <u>or</u> set <b>GE STAGE 1</b> to <i>Active</i>.<br>");
    }

}

#------------------------------------------------------------------#
sub WriteVariables {
open (OPTIONS,">$filepath/$cgidirectory/options.cgi") or ConfigError("Cannot create <b>$cgidirectory/options.cgi</b>,<br>ensure permissions are set correctly and that the absolute path to the cgi directory is specified correctly in the <i>Global Variables</i> interface.");

         print OPTIONS "\$MultiStage1=\"$MultiStage1\"\;\n";
         print OPTIONS "\$IPStage1=\"$IPStage1\"\;\n";
         print OPTIONS "\$IPStage2=\"$IPStage2\"\;\n";
         print OPTIONS "\$IPStage3=\"$IPStage3\"\;\n";
         print OPTIONS "\$IPStage4=\"$IPStage4\"\;\n";
         print OPTIONS "\$DefaultDir2=\"$DefaultDir2\"\;\n";
         print OPTIONS "\$UAStage1=\"$UAStage1\"\;\n";
         print OPTIONS "\$UAStage2=\"$UAStage2\"\;\n";
         print OPTIONS "\$UAStage3=\"$UAStage3\"\;\n";
         print OPTIONS "\$UAWarn1=\"$UAWarn1\"\;\n";
         print OPTIONS "\$SpiderLike=\"$SpiderLike\"\;\n";
         print OPTIONS "\$ServeAllFromHere=\"$ServeAllFromHere\"\;\n";
         print OPTIONS "\$DefaultDir1=\"$DefaultDir1\"\;\n";
         print OPTIONS "\$DoSendEmail=\"$DoSendEmail\"\;\n";
         print OPTIONS "\$DoWriteLog=\"$DoWriteLog\"\;\n";
         print OPTIONS "\$DoWriteVisitorLog=\"$DoWriteVisitorLog\"\;\n";

         close(OPTIONS);
}
#------------------------------------------------------------------#
sub ShowResult {
print <<EndOfHTML;
<html><head>
<title>Options Settings Results</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Cloaking Options</font>
</td>
</tr>
<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Options Have Been Set To:</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Human Browser Footprint Detection</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$MultiStage1</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Serve All Known Spiders From A Single Directory</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$ServeAllFromHere</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>The Name Of The Single Directory</b>:&nbsp;
</td>
<td bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DefaultDir1</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 1</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$IPStage1</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 2</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$IPStage2</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>IP STAGE 3</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$IPStage3</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 1</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$UAStage1</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 2</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$UAStage2</b></font>
</td>
</tr>


<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>UA STAGE 3</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$UAStage3</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>GE STAGE 1</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$IPStage4</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>GE STAGE1 (Generic) Match Served From</b>:&nbsp;
</td>
<td bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DefaultDir2</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Email Notification of Spider Visits</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DoSendEmail</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>New IP Address Detection</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$UAWarn1</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log All Unknown Spider Footprints</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$SpiderLike</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log Known Spider Visits</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DoWriteLog</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Log Human Visits</b>:&nbsp;
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DoWriteVisitorLog</b></font>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>
<tr>
<td colspan="2" bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>

<tr>
<td align="center" colspan="2" bgcolor="#C0C0C0">
[<a href="$DomainName/$cgidirectory/SetMultiStage.cgi"><font face=arial size="-1" color="maroon">Cloaking Options</font></a>]
</td>
</tr>

<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in SetMultiStage.cgi</font></a>
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
<font color="#400060" size="+1" face="Arial">Cloaking Options</font>
</td>
</tr>
<tr>
<td height="10" bgcolor="#EAEAD5">
<br>
<font color="#FF0000" size="3" face="Arial"><b>Configuration Error!</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="+4" face="verdana, arial" color="#FF0000">!</font>
<font size="-1" face="verdana, arial">$TopError<br><br> $msg</font>
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
&nbsp;<form OnSubmit="return false"><input type="submit" OnClick="history.go(-1)" value="Return To Options">
</td>
</tr>

<tr>
<td align="right" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color"#400060">YourSite.com, editable in SetMultiStage.cgi</font></a>
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
    ($msg) = @_;
    print "<h2>Error!</h2>\n";
    print "$msg";
    exit;
}
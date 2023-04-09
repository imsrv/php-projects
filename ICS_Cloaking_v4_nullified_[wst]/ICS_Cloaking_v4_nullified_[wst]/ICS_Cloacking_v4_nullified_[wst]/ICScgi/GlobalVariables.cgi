#!/usr/bin/perl
###########################################################################
# DATE:                   March 11, 2000
# PROGRAM:                GlobalVariables.cgi
# DDESCRIPTION:           Reads and saves site global variables and paths.
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
print "Error including required files: $@\n\n";
print "Make sure these files exist, permissions\n";
print "are set properly, and paths are set correctly.\n\n";
exit;
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

         if($html eq "yes"){$htmlvalue = "html"}
         if($html eq "no"){$htmlvalue = "htm"}
         if($html eq "shtml"){$htmlvalue = "shtml"}

         &DisplayForm;




sub DisplayForm {
print <<EndOfHTML;
<html><head>
<title>ICS40 Global Variables</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="75%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
<table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Global Variables</font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/gv_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<br>
<font size="-1" face="verdana, arial"><b>Path To Sendmail</b>:&nbsp;</font>
</td>
<td bgcolor="#FBF3D9">
<br>
<input type="text" name="PathToMail" value="$PathToMail" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Your E-Mail Address</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="EmailAddy" value="$EmailAddy" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Absolute Path To Root</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="filepath" value="$filepath" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Path To cgi</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="cgidirectory" value="$cgidirectory" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Directory To Hold Search Engine Directories</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="Directories" value="$Directories" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Directory To Hold IP And Log Files</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="IPDirectory" value="$IPDirectory" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Directory To Hold ICS Help Files</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="ICSHelp" value="$ICSHelp" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="-1" face="verdana, arial"><b>Your Domain Name</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<input type="text" name="DomainName" value="$DomainName" size="30">
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>HTML Extension Used At This Site</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="html">
  <option value="$html">$htmlvalue</option>
  <option value="yes">html</option>
  <option value="no">htm</option>
  <option value="shtml">shtml</option>
</select>
&nbsp;&nbsp;<font size="2" face="verdana, arial"><b>Use URI</b>:&nbsp;</font>
<select name="UsingURI">
  <option value="$UsingURI">$UsingURI</option>
  <option value="yes">yes</option>
  <option value="no">no</option>
</select>
</td>
</tr>

<tr>
<td align="right" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Enable Directory Mirroring</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<select name="DirMirror">
  <option value="$DirMirror">$DirMirror</option>
  <option value="yes">yes</option>
  <option value="no">no</option>
</select>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>
<tr>
<tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
<input type="submit" value="Set Global Variables">
</td>
</tr>
<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in GlobalVariables.cgi</font></a>
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
    $PathToMail = $go->param("PathToMail");
    $EmailAddy = $go->param("EmailAddy");
    $filepath = $go->param("filepath");
    $cgidirectory = $go->param("cgidirectory");
    $Directories = $go->param("Directories");
    $IPDirectory = $go->param("IPDirectory");
    $ICSHelp = $go->param("ICSHelp");
    $DomainName = $go->param("DomainName");
    $html = $go->param("html");
    $UsingURI = $go->param("UsingURI");
    $DirMirror = $go->param("DirMirror");

}

#------------------------------------------------------------------#
sub WriteVariables {
open (DEFAULTS,">$filepath/$cgidirectory/default.cgi") or ConfigError("cannot create $cgidirectory/default.cgi, ensure permissions are set correctly and that you specified the absolute path to the cgi directory correctly");

$EmailAddy =~ s/\@/\\\@/;

         print DEFAULTS "\$PathToMail=\"$PathToMail\"\;\n";
         print DEFAULTS "\$EmailAddy=\"$EmailAddy\"\;\n";
         print DEFAULTS "\$filepath=\"$filepath\"\;\n";
         print DEFAULTS "\$cgidirectory=\"$cgidirectory\"\;\n";
         print DEFAULTS "\$Directories=\"$Directories\"\;\n";
         print DEFAULTS "\$IPDirectory=\"$IPDirectory\"\;\n";
         print DEFAULTS "\$ICSHelp=\"$ICSHelp\"\;\n";
         print DEFAULTS "\$DomainName=\"$DomainName\"\;\n";
         print DEFAULTS "\$html=\"$html\"\;\n";
         print DEFAULTS "\$UsingURI=\"$UsingURI\"\;\n";
         print DEFAULTS "\$DirMirror=\"$DirMirror\"\;\n";

         close(DEFAULTS);
}
#------------------------------------------------------------------#
sub ShowResult {

         $EmailAddy =~ s/\\//; 
         if($html eq "yes"){$htmlvalue = "html"}
         if($html eq "no"){$htmlvalue = "htm"}
         if($html eq "shtml"){$htmlvalue = "shtml"}
print <<EndOfHTML;
<html><head>
<title>Global Variables Results</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<table cellspacing="2" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0" colspan="2">
<font color="#400060" size="+1" face="Arial">Global Variables</font>
</td>
</tr>
<tr>
<td height="10" colspan="2" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Site Variables Have Been Set To:</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Path To Sendmail</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$PathToMail</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Your E-Mail Address</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$EmailAddy</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Absolute Path To Your Root</b>:&nbsp;</font>
</td>
<td bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$filepath</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Path To cgi</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$cgidirectory</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>The Directory To Hold Search Engine Directories</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$Directories</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>The Directory To Hold IP And Log Files</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9" align="left">
<font size="2" face="verdana, arial" color="#0080C0"><b>$IPDirectory</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>The Directory To Hold ICS Help Files</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$ICSHelp</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>The Name Of This Domain</b>:&nbsp;</font>
</td>
<td  bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DomainName</b></font>
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>HTML File Extension Used At This site</b>:&nbsp;</font>
</td>
<td bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$htmlvalue</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Using URI For Pagename</b>:&nbsp;</font>
</td>
<td bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$UsingURI</b></font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>Enable Directory Mirroring</b>:&nbsp;</font>
</td>
<td bgcolor="#FBF3D9">
<font size="2" face="verdana, arial" color="#0080C0"><b>$DirMirror</b></font>
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
[<a href="$DomainName/$cgidirectory/GlobalVariables.cgi"><font face=arial size="-1" color="maroon">Global Variables</font></a>]
</td>
</tr>

<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in GlobalVariables.cgi</font></a>
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
<font size="-1" face="verdana, arial">$TopError;<br><br> $msg</font>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#EAEAD5">
&nbsp;
</td>
</tr>

<tr>
<td align="center" bgcolor="#EAEAD5">
&nbsp;<form OnSubmit="return false"><input type="submit" OnClick="history.go(-1)" value="Return To Options">
</td>
</tr>

<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in GlobalVariables.cgi</font></a>
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
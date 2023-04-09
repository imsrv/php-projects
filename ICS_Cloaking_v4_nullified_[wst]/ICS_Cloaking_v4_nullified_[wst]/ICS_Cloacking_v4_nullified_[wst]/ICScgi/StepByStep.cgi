#!/usr/bin/perl
###########################################################################
# DATE:                   November 29, 2000 ICSv4.0
# PROGRAM:                StepByStep.cgi
# DESCRIPTION:            Provides instruction on coaking a page 
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

if($ENV{'QUERY_STRING'} eq "go"){

&GetVariables;

&ShowSteps;

}

     

&DoDisplayForm;



sub DoDisplayForm{
   print <<EndHTML;
   <html><head><title>Cloaking Step By Step</title></head>
   <body bgcolor="FFFFFF">
   <center>
   <br><br>
   <FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?go">
   <table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
   <tr><td>
   <table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
   <tr><td bgcolor="#C0C0C0" align="center" colspan="2">
   <font face="arial" color="#400060"><b>Cloaking Step By Step</b></font>
   </td></tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/css_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
   <tr><td align="right" bgcolor="#FBF3D9">
   <font face="arial" size="-1" color="#000000"><b>Page Name:</b></font> 
   <br>
   </td>
   <td bgcolor="#FBF3D9">
   <input type="text" name="PageToCloak" value="" size="30">
   <br>
   </td></tr>

   <tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
   <input type="submit" value=" Show Steps ">
   </td></tr>
   <tr>
   <td align="right" colspan="2" bgcolor="#C0C0C0">
   <a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in StepByStep.cgi</font></a>
   </td>
   </tr>
   </table>
   </td></tr>
   </table></form></center></body></html>

EndHTML
exit;
}

sub GetVariables{
    $PageToCloak = $go->param("PageToCloak");
    ($FromDir, $BinBucket) = split(/\//, $PageToCloak);

    if(($FromDir) && ($FromDir ne $PageToCloak)){ 
       $Slash = "\/";
       $DirStat1 = "<p><font color=red face=verdana size=-1><b>IMPORTANT NOTE:</b></font> <font face=verdana size=-1>You have specified a page and a directory, to ensure you get the expected results be shure to review your setting for <b>Enable Directory Mirroring</b> in the <a href=\"$DomainName/$cgidirectory/GlobalVariables.cgi\">Global Variables Interface</a> and only follow these instructions if you have  <b>Enable Directory Mirroring</b> set to <i>yes</i>. If you have it set to <i>no</i> then re-invoke the Cloaking Step By Step Interface and enter only the page-name without specifying any subdirectories.</font>";
    }else {
         $Slash = "";
         $FromDir = "";
         }

}

sub ShowSteps {
print <<EndHTML;
<html><head>
<title>Cloaking Step By Step</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="100%">
<tr><td>
<table cellspacing="10" cellpadding="3" border="0" bgcolor="#EAEAD5" width="100%">
<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Cloaking Step By Step</font>
</td>
</tr>
<tr>
<td height="10" bgcolor="#EAEAD5">
<br>
<font color="#400060" size="3" face="Arial"><b>Steps To Cloak: $PageToCloak</b></font>
$DirStat1
</td>
</tr>
<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>STEP 1</b></font><br>
<font size="2" face="verdana, arial" color="#0080C0">
<ul>
Upload a copy of your current <b>$PageToCloak</b> page to  HumanVisitor/$PageToCloak on your web server.<br><br>
</ul>
</font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>STEP 2</b></font><br>
<font size="2" face="verdana, arial" color="#0080C0">
<ul>
Upload a copy of <b>$PageToCloak</b> to each of the search engine directories located in /$Directories on your web server i.e. 
<p>
/$Directories/AltaVista/$PageToCloak
<br>
/$Directories/Inktomi/$PageToCloak
<br>
/$Directories/Excite/$PageToCloak
<br>
etc..
<br><br>
</font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>STEP 3</b></font><br>
<font size="2" face="verdana, arial" color="#0080C0">
<ul>
Replace the <u>original</u> <b>$PageToCloak</b> page's content on your web server in its entirety with the following statement:<br><br>

<font size="2" face="verdana, arial" color="blue">
&lt;!--#include virtual="/$cgidirectory/ICSengine.cgi?$PageToCloak"--&gt;
</font>
<br><br>
This is the SSI statement that has been built based on the paths you specified in the <i>Global Variables</i> interface. Your original <b>$PageToCloak</b> page on the web server should now have only this statement in it. No other statements, including Meta Tags should be present, only this one single statement.
</ul>
</font>
</td>
</tr>

<tr>
<td align="left" bgcolor="#FBF3D9">
<font size="2" face="verdana, arial"><b>General Info</b></font><br>
<font size="2" face="verdana, arial" color="#0080C0">
<ul>
<li>After completing the above three steps:<br><br>
<ul>
<li>A copy of your original and unaltered <b>$PageToCloak</b> page should now be in /$Directories/HumanVistor/$PageToCloak <br><br>
<li>Your original <b>$PageToCloak</b> page's content on your web server should have been replaced by the single SSI statement shown in <b>STEP 3</b>.<br><br>
<li>Each search engine directory in /$Directories should also have a page named <b>$PageToCloak</b>, which at the moment has the same content as the <b>$PageToCloak</b> page in /$Directories/HumanVisitor/$PageToCloak<br><br>
<li>You can now modify the <u>content</u> of <b>$PageToCloak</b> in each directory so that different content is served depending on who is requesting it.<br><br>
When a request for <b>$DomainName/$PageToCloak</b> is made ICS will intercept the request and examine the visitor based on the detection stages you have set to <i>Active</i>. If it determines that the visitor making the request for <b>$PageToCloak</b> is a person, then it will retrieve the content from /$Directories/HumanVisitor/$PageToCloak and display it for the URL <b>$DomainName/$PageToCloak</b>, any changes you make to /$Directories/HumanVisitor/$PageToCloak will be served to human visitors. <br><br>

If it determines that the visitor making the request for <b>$PageToCloak</b> is a spider, then depending on the stages you have set to <i>Active</i>, it will attempt to determine which spider is making the request. If it is AltaVista then it will retrieve the content  from /$Directories/AltaVista/$PageToCloak and display it for the URL <b>$DomainName/$PageToCloak</b>, any changes you make to /$Directories/AltaVista/$PageToCloak will be served to AlaVista spiders.<br><br>
If it is Excite then it will retrieve the content from /$Directories/Excite/$PageToCloak and display it for the URL <b>$DomainName/$PageToCloak</b>, any changes you make to /$Directories/Excite/$PageToCloak will be served to Excite spiders.<br><br>
If it is Inktomi then it will retrieve the content  from /$Directories/Inktomi/$PageToCloak and display it for the URL <b>$DomainName/$PageToCloak</b>, any changes you make to  /$Directories/Inktomi/$PageToCloak will be served to Inktomi spiders and so on ...<br><br>

If you have chosen to feed the same optimized page to spiders no matter which engine it is coming from, then if it is AltaVista, or Excite, or Inktomi, or any spider that can be matched by IP Stages 1-3, or UA Stages 1-3 ICS will retrieve the content from /$Directories/<i>the-directory-you-chose-to serve-from</i>/$PageToCloak and display it for the URL <b>$DomainName/$PageToCloak</b>, any changes you make to /$Directories/<i>the-directory-you-chose-to serve-from</i>/$PageToCloak will be served to any spiders detected by those stages. <br><br>

</ul>
</font>
</td>
</tr>

<tr>
<td align="center" bgcolor="#EAEAD5">
<form OnSubmit="return false"><input type="submit" OnClick="history.go(-1)" value="Return">
</td>
</tr>

<tr>
<td align="right" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="maroon">YourSite.com, editable in StepByStep.cgi</font></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
EndHTML

exit;
}


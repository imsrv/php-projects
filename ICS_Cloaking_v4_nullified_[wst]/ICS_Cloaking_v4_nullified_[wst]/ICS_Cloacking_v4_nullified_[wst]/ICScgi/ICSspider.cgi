#!/usr/bin/perl
###########################################################################
# DATE:                   November 02, 2000 ICSv4.0
# PROGRAM:                ICSspider.cgi
# DESCRIPTION:            Retrieves the specified URL using any user agent 
#	       				  
#
# COPYRIGHT 2000 by ICS Scripts. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################

require LWP::UserAgent;
require HTTP::Request;
require HTTP::Response;
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

# Start:

 if ($ENV{'QUERY_STRING'} =~ /Spider/){

     &GetVariables;

     &Spider;

 }else{ &DoDisplayForm}

#------------------------------------------------------------------#
sub DoDisplayForm{
   print <<EndHTML;
   <html><head><title>ICSspider By ICS</title></head>
   <body bgcolor="FFFFFF">
   <center>
   <br><br><br><br>
   <FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?Spider">
   <table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="60%">
   <tr><td>
   <table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
   <tr><td bgcolor="#C0C0C0" align="center" colspan="2">
   <font face="arial" color="#400060"><b>ICS<i>spider</i></b></font>
   </td></tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/sp_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
   <tr><td align="right" bgcolor="#FBF3D9">
   <font face="arial" size="-1" color="#000000"><b>URL to spider:</b></font> 
   </td>
   <td bgcolor="#FBF3D9">
   <input type="text" name="URLToSpider" value="http://" size="40">
   </td></tr>
   <tr><td align="right" bgcolor="#FBF3D9">
   <font face="arial" size="-1" color="#000000"><b>Using User Agent:</b></font>
   <br>
   </td>
   <td bgcolor="#FBF3D9">
   <input type="text" name="UseThisAgent" value="ICSspider/1.0" size="40">
   <br>
   </td></tr>
   <tr><tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
   <input type="submit" value="Go Spider">
   </td></tr>
   <tr>
   <td align="right" colspan="2" bgcolor="#C0C0C0">
   <a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in ICSspider.cgi</font></a>
   </td>
   </tr>
   </table>
   </td></tr>
   </table></form></center></body></html>

EndHTML
exit;
}

sub GetVariables{
    $URLToSpider = $go->param("URLToSpider");
    $UseThisAgent = $go->param("UseThisAgent");
}



sub Spider{
  my $ua = LWP::UserAgent->new;
  $ua->agent("$UseThisAgent");
 
  my $request = HTTP::Request->new('GET', "$URLToSpider");
  my $response = $ua->request($request);
  if ($response->is_success) {
       print $response->content;
  } else {
     print $response->error_as_HTML;
  }
  exit;
}
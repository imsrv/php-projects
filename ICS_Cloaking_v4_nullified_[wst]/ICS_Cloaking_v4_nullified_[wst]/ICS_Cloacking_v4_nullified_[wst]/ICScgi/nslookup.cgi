#!/usr/bin/perl
###########################################################################
# DATE:                   November 02, 2000 ICSv4.0
# PROGRAM:                nslookup.cgi
# DESCRIPTION:            Looks up a host name or range of hosts by IP 
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

($DoThis, $Shown, $DNS, $ClassC, $IP, $NumPerPage) = split(/&/, $ENV{'QUERY_STRING'});
   if ($Shown > 1 ) {
       &DoHeaders;
       &LookupClassC;
   }

   if ($DoThis =~ /NSlookup/ && $Shown == 1 ) {
       &GetVariables;
       &DoHeaders;
       &LookupClassC;
   }
     

&DoDisplayForm;



sub DoDisplayForm{
   print <<EndHTML;
   <html><head><title>NSlookup By ICS</title></head>
   <body bgcolor="FFFFFF">
   <center>
   <br><br><br><br>
   <FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?NSlookup&1">
   <table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="50%">
   <tr><td>
   <table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">
   <tr><td bgcolor="#C0C0C0" align="center" colspan="2">
   <font face="arial" color="#400060"><b>NSlookup</b></font>
   </td></tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/ns_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
   <tr><td align="right" bgcolor="#FBF3D9">
   <font face="arial" size="-1" color="#000000"><b>IP Address:</b></font> 
   </td>
   <td bgcolor="#FBF3D9">
   <input type="text" name="IPaddress" value="" size="20">
   </td></tr>
   <tr><td align="right" bgcolor="#FBF3D9">
   <font face="arial" size="-1" color="#000000"><b>DNS Server:</b></font>
   </td>
   <td bgcolor="#FBF3D9">
   <input type="text" name="DNS" value="granitecity.com" size="20">
   </td></tr>
   <tr><td bgcolor="#FBF3D9" align="right">
   <font face="arial" size="-2" color="#000000"><b>Lookup entire class "c" 1 - 254:</b></font>&nbsp;
   <input type="checkbox" name="ClassC" value="Yes">
   </td>
   <td bgcolor="#FBF3D9">
   <font face="arial" size="-2" color="#000000"><b>Results per page:</b></font>
   <select name="Number">
   <option selected value="10">10</option>
   <option value="25">25</option>
   <option value="50">50</option>
   <option value="75">75</option>
   <option value="100">100</option>
   <option value="125">125</option>
   <option value="150">150</option>
   <option value="175">175</option>
   <option value="200">200</option>
   <option value="225">225</option>
   <option value="255">255</option>
   </select>
   </td></tr>
   <tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
   <input type="submit" value="Go Lookup">
   </td></tr>
   <tr>
   <td align="right" colspan="2" bgcolor="#C0C0C0">
   <a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in nslookup.cgi</font></a>
   </td>
   </tr>
   </table>
   </td></tr>
   </table></form></center></body></html>

EndHTML
exit;
}

sub GetVariables{
    $IP = $go->param("IPaddress");
    $DNS = $go->param("DNS");
    $ClassC = $go->param("ClassC");
    $NumPerPage = $go->param("Number");
}

sub DoHeaders{

    ($ip1, $ip2, $ip3, $ip4) = split(/\./, $IP);
    $DisplayTo = $Shown + $NumPerPage;
    $Counter = $DisplayTo - 1;


    if($ClassC eq "Yes"){ 
         print "<font size=\"3\"><b>Lookup Address:</b> $ip1.$ip2.$ip3.*</font><br>\n";
         }else { 
               print "<font size=\"3\"><b>IP Address:</b> $IP</font><br>\n";
               }
      
      print "<font size=\"3\"><b>Using DNS At:</b> $DNS</font><br><br>\n";

      print <<EndHTML;
      <html><head><title>NSlookup By ICS</title></head>
      <body bgcolor="FFFFFF">
      <center>
      <table cellspacing="1" cellpadding="4" border="1" bgcolor="#EAEAD5" width="60%">
      <tr><td>
      <table cellspacing="1" cellpadding="7" border="0" bgcolor="#EAEAD5" width="100%">
      <tr><td align="center" bgcolor="#EAEAD5">
      <font face="arial" color="#004080"><b>IP Address</b></font></td>
      <td align="left" bgcolor="#EAEAD5">
      <font face="arial" color="#004080"><b>Host Name</b></font>
      </td></tr>
EndHTML
}

sub LookupClassC{
    if($ClassC eq "Yes"){ 
      if ($Counter > 254){ $Counter = 254}
      print "<font face=\"arial\" size=\"-1\"><b>Looking up:</b></font> <font face=\"arial\" size=\"-1\" color=\"#B95C00\"><b>$Shown to $Counter</b></font><br>\n";
      for ($i = 1; $i < 255; $i++) {
         unless($i < $Shown || $i >= $DisplayTo){
            $IP = "$ip1.$ip2.$ip3.$i";
            $NSlkup = "nslookup $IP $DNS";
            $Result = `$NSlkup`;
            ($First, $Second) = split(/Name:/, $Result);
            ($NameOfHost, $NameOfIP) = split(/Address:/, $Second);
            if($NameOfHost eq ""){
               $NameOfHost = "<font size=-2 color=gray>No Entry Found For $IP</font>"
            } 
            print "<tr><td bgcolor=\"#FBF3D9\" align=\"center\">";
            print "<font face=\"arial\" size=\"-1\">$IP</font></td>\n";
            print "<td bgcolor=\"#FBF3D9\" align=\"left\">";
            print "<font face=\"arial\" size=\"-1\">$NameOfHost</td>\n";
        }
      }

            if ($Counter < 254){
              print "<tr><td colspan=\"2\" align=\"center\" bgcolor=\"#EAEAD5\">\n";
              print "<a href=\"nslookup.cgi?NSlookup&$DisplayTo&$DNS&$ClassC&$IP&$NumPerPage\"><font face=\"arial\" size=\"-2\">Next >>></font></a><br><br>\n";
            }
			if($Counter >= 254){
               print "<tr><td colspan=\"2\" align=\"center\" bgcolor=\"#EAEAD5\">\n";
               }
            print "<a href=\"nslookup.cgi\">\n";
            print "<font face=\"arial, verdana\" size=\"-2\">\n";
            print "Back To Nslookup Interface</font></a>\n";
            print "</td></tr></table>\n";
            print "</center></table></body></html>\n";
                                     
    }else { &LookupSingleIP}
exit;
}

sub LookupSingleIP{
    if($ClassC ne "Yes"){ 
            $NSlkup = "nslookup $IP $DNS";
            $Result = `$NSlkup`;
            ($First, $Second) = split(/Name:/, $Result);
            ($NameOfHost, $NameOfIP) = split(/Address:/, $Second);
            if($NameOfHost eq ""){
               $NameOfHost = "<font size=-2 color=gray>No Host Found At $IP</font>"
            } 
            print "<tr><td bgcolor=\"#FBF3D9\" align=\"center\">";
            print "<font face=\"arial\" size=\"-1\">$IP</font></td>\n";
            print "<td bgcolor=\"#FBF3D9\" align=\"left\">";
            print "<font face=\"arial\" size=\"-1\">$NameOfHost</td>\n";
            print "</td></tr></table>\n";
            print "</center></table></body></html>\n";
            exit;                   
    }
}

exit;




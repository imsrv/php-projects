#!/usr/bin/perl
###########################################################################
# DATE:                   December 11, 2000 ICSv4.0
# PROGRAM:                IPadmin.cgi
# DDESCRIPTION:           Retrieves IP Addresses from the ICS interface
#                         and updates the IPlist.pl file.
#	       				  
#
# COPYRIGHT 2000 by ICS Scripts. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################
print "content-type: text/html\n\n";
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

#Retrieve Page Settings and display form
if ($ENV{'QUERY_STRING'} =~ /List/) {

&GetCookie();
if($Auth ne "OK"){
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSstart.cgi\">";
       exit;
}
 
#Write the new IP and Agent list
&ShowResults;
exit;
}

if ($ENV{'QUERY_STRING'} =~ /go/) {

&GetCookie();
if($Auth ne "OK"){
       print "<META HTTP-EQUIV=\"Refresh\" Content = \"0\;";
       print "URL=ICSstart.cgi\">";
       exit;
}

   #Get the current IPs and Agents
   &GetCurrentIP;

   #Create and display the form
   &DoDisplayForm;
   }

if ($ENV{'QUERY_STRING'} =~ /update/) {

# Go get input and save it
&DoParseForm;

#Write the new IP and Agent list
&DoWriteList;

#Show message if successful
&UpdateResult;
}

exit;

#-------------------------------------------------------------#
sub GetCurrentIP {

   open(IPENGINE,"$filepath/$IPDirectory/IPlist.pl") or &dienice("cannot open 
        $filepath/$IPDirectory/IPlist.pl");
   read(IPENGINE, $buffer1, 512000);

   # Equate the value triples
      $iplist1 = $buffer1;

  close (IPENGINE);
 }
#-------------------------------------------------------------#
sub DoDisplayForm {
print <<EndHTML;
<HTML>
<title>ICS40 IP Admin</title>
</head>
<body bgcolor="FFFFFF">
<center>
<br><br>

<table cellspacing="1" cellpadding="4" border="2" bgcolor="#C0C0C0" width="70%">
<tr><td>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}?update">
<table cellspacing="0" cellpadding="4" border="0" bgcolor="#EAEAD5" width="100%">

<tr>
<td align="center" bgcolor="#C0C0C0">
<font color="#400060" size="+1" face="Arial">Administer IP's/Directories/User agents</font>
</td>
</tr>
<tr>
<td align="right" bgcolor="#FBF3D9" colspan="2">
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="Navigation.cgi"><font size="-2" face="verdana, arial">Navigation</font></a>]
</font>
<font size="-2" face="verdana, arial" color="#FF0000">
[<a href="/$ICSHelp/ip_help.html" target="popup" onclick="window.open('about:blank','popup','scrollbars=1,width=430,height=500');">
<font size="-2" face="verdana, arial">Help </font></a>]</font>
</td>
</tr>
<tr>
<td bgcolor="#FBF3D9" align="center">
<TEXTAREA NAME="iplist" COLS=60 ROWS=14>$iplist1</TEXTAREA>
</td>
</tr>
<tr>
<tr><td bgcolor="#EAEAD5" align="center" colspan="2" valign="bottom">
<INPUT TYPE="SUBMIT" VALUE="UPDATE IP | Directory | Agent List">
</td>
</tr>
</FORM>
<tr>
<td align="right" colspan="2" bgcolor="#C0C0C0">
<a href=""><font face=arial size="-2" color="#400060">YourSite.com, editable in IPadmin.cgi</font></a>
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

   read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
   @newip = split(/&/, $buffer);
   # Equate the value triplets
     $iplist = $buffer;
      # Un-Webify plus signs and %-encoding
      $iplist =~ tr/+/ /;
      $iplist =~ s/iplist=//s;
      $iplist =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
      $iplist =~ s/<!--(.|\n)*-->//g;
      $iplist =~ s/<([^>]|\n)*>//g;
      close (STDIN);
      }
#-------------------------------------------------------------#
sub DoWriteList {

   open(IPENGINE,">$filepath/$IPDirectory/IPlist.pl") or &dienice("cannot open         $filepath/$IPDirectory/IPlist.pl");


   @newip = split(/&/, $iplist);
   foreach $three (@newip) {

      ($IPaddress, $Directory, $Agent) = split(/=/, $three);
      
  print IPENGINE "$IPaddress\=$Directory\=$Agent\&";


      }
  close (IPENGINE);

  }

#-------------------------------------------------------------#
sub UpdateResult {
print "<html><head><META HTTP-EQUIV=\"Refresh\" Content = \"2\;";
print "URL=IPadmin.cgi?List\">";
print "</head><body bgcolor=FFFFFF>";
print "<center><h2><font color=green>Update Successful!</font></h2><br><br>";
print "<b>The updated list will now be displayed. Please wait.......</b><br>";
print "</body></html>";
exit; 
}
#-------------------------------------------------------------#
sub ShowResults {

   open(IPENGINE,"$filepath/$IPDirectory/IPlist.pl") or &dienice("cannot open         $filepath/$IPDirectory/IPlist.pl");
@iplist = <IPENGINE>;
close (IPENGINE);
$iplist = "@iplist";

   print "<html><head></head><body bgcolor=ffffff><center>\n";
   print "<table width=80% border=2 cellpadding=5 cellspacing=1 bgcolor=#C0C0C0>\n";
   print "<tr><td>\n";
   print "<table width=100% border=0 cellpadding=3 cellspacing=1>\n";
   print "<tr><td height=2>&nbsp;</td></tr>\n";
   print "<tr><td bgcolor=#C0C0C0 valign=bottom colspan=3><b><font color=#000000 face=verdana>Currently using the following</font> <font color=#408080 face=verdana size=-1>IP \| Directory\ | Agent List</font> <br><font color=#000000 face=verdana>for: </font><font color=#408080 face=verdana size=-1>$DomainName</font></b></td></tr>\n";
     print "<tr><td>&nbsp;</td></tr>\n";
     print "<tr><td bgcolor=#DADADA><b><font face=Arial size=-1>IP Address</font></b></td>\n";
     print "<td bgcolor=#DADADA><b><font face=Arial size=-1>Directory</font></b></td>\n";
     print "<td bgcolor=#DADADA><b><font face=Arial size=-1>User Agent</font></b></td></tr>\n";
     @newip = split(/&/, $iplist);
     foreach $three (@newip) {
     ($IPaddress, $Directory, $Agent) = split(/=/, $three);
      $IPaddress =~ s/\///g;
      $Agent =~ s/\///g;
     print "<tr><td bgcolor=#EAEAD5><font size=-2 color=black face=verdana>$IPaddress</font></td>\n";
     print "<td bgcolor=#EAEAD5><font size=-2 color=black  face=verdana>$Directory</font></td>\n";
     print "<td bgcolor=#EAEAD5><font size=-2 color=black  face=verdana>$Agent</font></td></tr>\n";
     }
   print "<tr><td colspan=3 bgcolor=#C0C0C0><b><font size=-1 face=verdana>If you wish to make changes, go to the <a href=\"IPadmin.cgi?go\">IP and Agent admin panel</a></font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>[</font><a href=\"Navigation.cgi\"><font size=-2 face=verdana>Navigation</a></font><font color=red>]</font><br></td></tr>\n";
   print "</table></td></tr></table></center></body></html>\n";
   
   }
#-------------------------------------------------------------#
sub dienice {
    ($msg) = @_;
    print "<h2>Error</h2>\n";
    print "$msg";
    exit;
}
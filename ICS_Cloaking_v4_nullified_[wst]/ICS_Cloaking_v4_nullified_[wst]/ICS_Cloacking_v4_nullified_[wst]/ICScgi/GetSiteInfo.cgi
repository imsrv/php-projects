#!/usr/bin/perl
###########################################################################
# DATE:                   November 02, 2000 ICSv4.0
# PROGRAM:                GetSiteInfo.cgi
# DESCRIPTION:            Retrieves paths, sendmail and Perl location. 
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

$wperl = `whereis perl`;
$wsend = `whereis sendmail`;
($perlheader, $path1, $path2) = split(" ",$wperl);
($smailheader, $mailpath1, $mailpath2) = split(" ",$wsend);
$CGIPath = $ENV{'SCRIPT_NAME'};
$CGIPath =~ s/\/GetSiteInfo.cgi//g;
$CGIPath =~ s/\// /g;
($CGIPath1, $CGIPath2, $CGIPath3, $CGIPath4, $CGIPath5, $CGIPath6) = split(" ", $CGIPath);

if($CGIPath1){ $CGIPath1 = "$CGIPath1"}
if($CGIPath2){ $CGIPath2 = "/$CGIPath2"}
if($CGIPath3){ $CGIPath3 = "/$CGIPath3"}
if($CGIPath4){ $CGIPath4 = "/$CGIPath4"}
if($CGIPath5){ $CGIPath5 = "/$CGIPath5"}

$PerlExec = $^X;
$CompVer = $^O;
$DocRoot = $ENV{'DOCUMENT_ROOT'};
$WebServer = $ENV{'SERVER_SOFTWARE'};
$YourIP =  $ENV{'REMOTE_ADDR'};

print "<center>\n";
print "<table cellpadding=4 cellspacing=5 border=1>\n";
print "<tr><td bgcolor=#C0C0C0 align=center valign=bottom>\n";
print "<table cellpadding=10 cellspacing=2 border=0>\n";
print "<tr><td bgcolor=#F7F4DF align=center valign=bottom>\n";
print "<font color=#400060 size=+2>Your Site Variables</font>\n";
print "</td></tr>\n";
print "<tr><td bgcolor=#ECE7BD>\n";
print "<font face=arial, verdana size=-1>\n";
print "<p><b>Perl Path:</b> $perlheader $path2<br>\n";
print "<p><b>Sendmail Path:</b> $smailheader $mailpath1<br>\n";
print "<p><b>Perl Executable:</b> $PerlExec<br>\n";
print "<p><b>Operating System:</b> $CompVer<br>\n";
print "<p><b>Absolute Path To Root:</b> $DocRoot<br><br>\n";
print "<p><b>Path To ICS CGI:</b> $CGIPath1$CGIPath2$CGIPath3$CGIPath4$CGIPath5<br><br>\n";
print "<p><b>Web Server:</b> $WebServer<br>\n";
print "<p><b>Your IP Address:</b> $YourIP<br>\n";
print "</font>\n";
print "</td></tr></table></td></tr></table></center>\n";

exit;




#!/usr/bin/perl

# ==================================================================
# MojoPersonals MySQL
#
#   Website  : http://mojoscripts.com/
#   Support  : http://mojoscripts.com/contact/
# 
# Copyright (c) 2002 mojoscripts.com Inc.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited.
# ==================================================================
#
#    End-User License Agreement for MojoPersonals MySQL:
#--------------------------------------------------------------------
# After reading this agreement carefully, if you do not agree
# to all of the terms of this agreement, you may not use this software.
#
# This software is owned by ascripts.com Inc. and is protected by
# national copyright laws and international copyright treaties.
#
# This software is licensed to you.  You are not obtaining title to
# the software or any copyrights.  You may not sublicense, sell, rent,
# lease or free-give-away the software for any purpose.  You are free
# to modify the code for your own personal use. The license may be
# transferred to another only if you keep NO copies of the software.
#
# This license covers one installation of the program on one domain/url only.
#
# THIS SOFTWARE AND THE ACCOMPANYING FILES ARE SOLD "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY
# OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
#
# NO WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.
# ANY LIABILITY OF THE SELLER WILL BE LIMITED EXCLUSIVELY TO PRODUCT
# REPLACEMENT OR REFUND OF PURCHASE PRICE. Failure to install the
# program is not a valid reason for refund of purchase price.
#
# The user assumes the entire risk of using the program.
#--------------------------------------------------------------------

############################################################
eval {
	($0=~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
	($0=~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
	require "config.pl";
	push(@INC, "$CONFIG{script_path}/scripts");
	require "ads.pl";
  	require "database.pl";
  	require "new_database.pl";
	require "default_config.pl";
	require "english.lng";
	require "html.pl";
	require "parse_template.pl";
	require "library.pl";
	require "mojoscripts.pl";
	require "utils.pl";
	if (-d "$CONFIG{script_path}/scripts/admin_ibill.pl") {require "admin_ibill.pl";}
	use CGI qw(:standard);
	use CGI::Carp qw(fatalsToBrowser);
	use File::Path;
   &main;
};
if ($@) {
	print "content-type:text/html\n\n";
	print "Error Including configuration file, Reason: $@";
	exit;
}
################################################################
sub main {
	my($time, $time_start, $time_end, $HTML);
	$|++;
	$Cgi = new CGI; $Cgi{mojoscripts_created} = 1;
	$CONFIG{member_expire_notice} = 3;
	$CONFIG{auto_renewal} = 1;
	$CONFIG{myemail} = "";
	&ParseForm;
	&Initialization;

#	&BackupAdDB;
#	&BackupMemberDB;

	&IbillCrontab;
        &ExpireMembers;
        &ExpireAds;

#        &RepairAdDB;
#        &RepairMemberDB;

#	&CleanExpiredMembers;
	&CleanExpiredAds;

###Finish cron tabs running... Now calculating the results
	$time_end = &TimeNow;
	$time = int( $time_end - $time_start);
	$html = &CalculateResult;
	$code = &SendMail("crontab\@mojoscripts.com", "crontab\@mojoscripts.com", $CONFIG{myemail}, "Cron Tabs", $html, 1);

	if($ENV{REQUEST_METHOD}){
		&PrintHeader;
		print $html;
	}
	exit;
}
################################################################
sub CalculateResult{
	my($expire, $email_content,$HTML_ads, %HTML, $time);
        $time = &FormatTime(&TimeNow, "mo;\.;d;\.;y;\ ;h;:;m;:;s; ;am");
	foreach (keys %ABOUT2EXPIRE){ $HTML{members} .= qq|<tr><td>$_</td><td>$ABOUT2EXPIRE{$_}</td><td>Sent reminder</td></tr>|; }
#	foreach (keys %RENEW){			$HTML{members} .= qq|<tr><td>$_</td><td>$time</td><td>renewed</td></tr>|;							}
	foreach (keys %EXPIRE){			$HTML{members} .= qq|<tr><td>$_</td><td>$time</td><td>Expired and sent mail</td></tr>|;	}
	foreach (keys %DELETED){		$HTML{members} .= qq|<tr><td>$_</td><td>$time</td><td>Deleted from the database</td></tr>|; }
	unless($HTML{members}){			$HTML{members} .=qq|<tr><td colspan=3>There was nothing to do with your members</td></tr>|;}
	foreach (keys %ADEXPIRE){		$HTML{ads} .= qq|<tr><td>$_</td><td>$ADEXPIRE{$_}</td><td>Removed</td></tr>|; }
	unless($HTML{ads}){	    		$HTML{ads} .=qq|<tr><td colspan=3>There was no expired ads. Nothing was done</td></tr>|; }

         $email_content=qq|
<html>
<head>
<title>$mj{program} $mj{version}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="500" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#33CCFF">
  <tr bgcolor="#99CCFF">
    <td colspan="3">
      <div align="center"><font size="5"><b>Cron Tab Results at $time</b></font></div>
    </td>
  </tr>
  <tr>
    <td><b>Username</b></td>
    <td><b>Expire on</b></td>
    <td><b>Action taken</b></td>
  </tr>
  $HTML{members}
  <tr valign="bottom">
    <td>
      <div align="left"><b><br>
        Ads ID</b></div>
    </td>
    <td>
      <div align="left"><b>Posted by</b></div>
    </td>
    <td>
      <div align="left"><b>Action Taken</b></div>
    </td>
  </tr>
$HTML{ads}
  <tr>
    <td colspan="3">
      <div align="center"><br>
        Please <a href="http://www.mojoscripts.com">contact us</a> if you have any problems.</div>
    </td>
  </tr>
</table>
</body>
</html>
|;
return $email_content;
}
################################################################

#end

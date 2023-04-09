#!/usr/bin/perl -w
#####################################################################
##  Program Name	: AutoGallery SQL                          ##
##  Version		: 2.1.0b                                   ##
##  Program Author      : JMB Software                             ##
##  Retail Price	: $85.00 United States Dollars             ##
##  xCGI Price		: $00.00 Always 100% Free                  ##
##  WebForum Price      : $00.00 Always 100% Free                  ##
##  Supplier By  	: Dionis                                   ##
##  Delivery by         : Slayer                                   ##
##  Nullified By	: CyKuH [WTN]                              ##
##  Distribution        : via WebForum and Forums File Dumps       ##
#####################################################################
##  password.cgi - administrative password reset utility           ##
#####################################################################

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER   = 1;
$DS_CACHE = 1;

eval
{
    require 'ags.pl';
    main();
};

err("$@", 'password.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main
{
    if( !$QUERY )
    {
        HTML( 
              "By clicking the link below you will be resetting your administrative login information.<br><br>" .
              "<center><b><a href='password.cgi?mode=reset' class='reg'>Reset Administrative Login</a></b></center>" 
            );

    }
    else
    {
        password();

        HTML("Your administrative login has been reset to:<br><br><b>Username:</b> admin<br><b>Password:</b> admin");
    }
    
}


sub password
{
    $DBH->do("DELETE FROM a_Moderators WHERE Moderator_ID='admin'") || SQLErr($DBH->errstr());
    $DBH->do("INSERT INTO a_Moderators VALUES ( 'admin', 'none\@set.yet', 'Admin', 'admin', '1', '1', '1', '1', '1', '1', '1', '1', '1' )") || SQLErr($DBH->errstr());

    $DEL = ':';

    dbdelete("./admin/.htpasswd", 'admin');
    dbinsert("./admin/.htpasswd", 'admin', crypt('admin', getsalt()));
}


sub HTML
{
    my $msg = shift;

    print <<__HTML__;
<html>
<head>
  <title>AutoGallery SQL Login Reset</title>
  <style type="text/css">
  <!--
    a.reg  {
      text-decoration: none;
      color: #004080;
    }

    a.reg:active  {
      text-decoration: none;
      color: #ff0000;
    }

    a.reg:hover  {
      text-decoration: none;
      color: #990000;
    }

    a.reg:visited {
      text-decoration: none;
      color: #004080;
    }

    a.reg:visited:hover {
      text-decoration: none;
      color: #990000;
    }

    a.reg:visited:active  {
      text-decoration: none;
      color: #ff0000;
    }
  -->
  </style>
</head>
<body bgcolor="#ffffff" text="#000000" link="#004080" vlink="#adadad" alink="#ff0000">

<div align="center">

<table border="0" cellpadding="0" cellspacing="0" width="650">
<tr bgcolor="#aaaaaa">
<td align="center">

<table cellspacing="1" cellpadding="3" border="0" width="100%">
<tr>
<td bgcolor="#004080" align="center">
<font face="Arial" size="3" color="white" style="font-size: 15px;">
<b>AutoGallery SQL Login Reset</b>
</font>
</td>
</tr>

<tr>
<td bgcolor="#ececec">
<font face="Verdana" size="1" style="font-size: 11px;">

$msg

</font>
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
__HTML__

}
#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);
################################
# Original		       #
# JoMiMo Home Page Generator   #
# Copyright 2000               #
# Adela Lewis                  #
# All Rights Reserved          #
################################
# AlsPageDesignerPlus	       #
# Copyright 2002               #
# Adela Lewis                  #
# All Rights Reserved          #
################################
   
require "configdat.lib";
require "variables.lib";
require "defaulttext.lib";
require "gensubs.lib";
require "editprofile.lib";
require "routines.lib";

&readparse;

use CGI qw(:standard);                    
$query=new CGI;

$thisprog="delad.pl";
$cookiepath = $query->url(-absolute=>1);
$cookiepath =~ y/$thisprog//;

$inmembername=$query->param('inmembername');
$inpassword=$query->param('inpassword');
$dtn=$query->param('dtn');

		if (! $inmembername) { $inmembername = cookie("amembernamecookie"); }
	    	if (! $inpassword)   { $inpassword   = cookie("apasswordcookie"); }
       

print qq~
$mainheader
$menu1
$menu2
<table cellpadding=0 cellspacing=0 width=100%><tr> 
<td width=25% bgcolor=$cpsidetdcolor valign=\"top\">
<table width=100% cellpadding=1 cellspacing=1 border=0><tr><td width=10>&nbsp;</td><td>
<center>
$cpsidetdcont</center>
</td></tr></table>
</td>

<td width=75%> 

<blockquote><br>
<form method="post" action="$cgiurl/personals.pl">
<table cellpadding=0 cellspacing=0 border=0><tr>
<td>

$text111

<table border=0 cellpadding=2 cellspacing=2>
<tr>
<td>
<table><tr><td><b><font size=1 face=verdana>In which category is your ad located?</b></font><br>
<select name = "adpagenm" class="selist">
<option value="wsmads">Women Seeking Men</option>
<option value="mswads">Men Seeking Women</option>
<option value="wswads">Women Seeking Women</option>
<option value="msmads">Men Seeking Men</option>
</select></td></tr>
<tr><td>
<font size=1 face=verdana><b>
Username</b></font><br><input type=text name=username value="$inmembername" size=20 maxlength=40 class="box"></td></tr>
<tr><td><font size=1 face=verdana><b>
Password</b></font><br><input type=password name="password" value="$inpassword" size=20 maxlength=50 class="box"></td></tr>
<tr><td><font size=1 face=verdana><b>
Ticket Number</b></font><br><input type=text name=delticknum value="$dtn" size=20 maxlength=50 class="box"></td></tr>
<tr><td align=center><center><input type=submit name="deletead" value="Delete Ad" class="button">
<input type=reset value="Clear All" class="button"></center></td></tr>
</table></td></tr></table></td></tr></table></center><p></form></blockquote>
</td></tr></table>
$botcode
~;
exit;
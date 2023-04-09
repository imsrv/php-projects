#!/usr/bin/perl 

                  
require "configdat.lib";
require "routines.lib";
require "variables.lib";
require "defaulttext.lib";

use CGI qw(:standard);
$query = new CGI;
$thisprog="delprofile.pl";
$cookiepath = $query->url(-absolute=>1);
$cookiepath =~ y/$thisprog//;

$inmembername=$query->param('inmembername');
$inpassword=$query->param('inpassword');

		if (! $inmembername) { $inmembername = cookie("amembernamecookie"); }
	    	if (! $inpassword)   { $inpassword   = cookie("apasswordcookie"); }
       


print "Content-type:text/html\n\n";
print "<html><head><title>Delete Profile</title></head>
<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0>
$mainheader
$submenu
<br><br>
<center>
<form method=\"post\" action=\"personals.pl\">
<table cellpadding=0 cellspacing=0 width=300>
<tr><td><font size=1 face=verdana color=000000>

$text100

</td></tr></table>

<br><br>
<table cellpadding=0 cellspacing=0 width=300><tr>
<td><b><font size=2 face=univers>Username</font></b></td><td><input type=\"text\" name=\"username\" value=\"$inmembername\" size=15></td></tr><tr>
<td><b><font size=2 face=univers>Password</font></b></td><td><input type=\"password\" name=\"password\" value=\"$inpassword\" size=15></td>
</tr></table><br>
<input type=\"submit\" name=\"delprof\" value=\"Delete Profile\" class=\"button\"></center>
</form>
$botcode
</body></html>\n";







######################################################################################
1;
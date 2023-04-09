#!/usr/bin/perl

require "configdat.lib";
################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################
# Do not make changes here		                                              
################################################################################

$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
    $msg = "@_"; 
  print "\nContent-type: text/html\n\n";
  print "The following error occurred : $msg\n";
  exit;
}
################################################################################
# Get the input
################################################################################

read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $input);
   foreach $pair (@pairs) {
   ($name, $value) = split(/=/, $pair);
   $name =~ tr/+/ /;  
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $FORM{$name} = $value;  
   }
###############################################################################


$lovescope=$FORM{'lovescope'};

###############################################################################

if($FORM{'addlovescope'} eq "Add Lovescope"){
&addlovescope;
}

sub addlovescope {

if($lovescope eq "")
{
print "Content-type:text/html\n\n";
print <<EOF;
<html><head><title>Missing Information</title></head>
<body><blockquote><font size=2 face=verdana>
You did not enter any data
</font></blockquote>
</body></html>
EOF
exit;
}

open  (FILE, ">>$lovescopedir/lovescope.txt") || &oops($!, "Cannot read $lovescopedir/lovescope.txt");
flock (FILE, 2) or die "can't lock file\n";
print  FILE "$lovescope\n";
close (FILE);

###############################################################################

print "Content-type:text/html\n\n";
print <<EOF;
<html>
<head>
	<title>Lovescope database engine</title>
</head>
<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=ffffff text=000000>


<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td><a href="$admindirurl/mancenter.html">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>


<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><br><blockquote><font color=000000 face=verdana size=1>
Use the engine below to add data to the file which stores the information used for the "Random Lovescope" feauture. There is very limited data at present. This means that users are likely to get the same messages repeatedly. To prevent this, add as many "scopes" as possible. </blockquote></font><br>
</td>
</tr></table>
<form method="post" action="$cgiurl/lovescopeengine.pl">
<center>
<br><font size=2 face=verdana>The data has been added!<br>
<table><tr>
<td><b><font size=2 face=verdana>Add Lovescope Below:</font></b></td></tr><tr>
<td><center><textarea name="lovescope" cols=60 rows=8></textarea></center></td></tr><tr>
<td><center><input type="submit" name="addlovescope" value="Add Lovescope"></center></td></tr></table></center>

<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admindirurl/mancenter.html">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</form></body></html>
EOF
exit;
}




#########################################################################################

sub oops {
my($headline,$message)=@_;
print<<"end_page";
Content_type: text/html

<HEAD><TITLE>OOPS</TITLE>
</HEAD><BODY>
<H1>$headline</H1>
$message
</BODY>
</HTML>
end_page
exit;
}

#########################################################################################



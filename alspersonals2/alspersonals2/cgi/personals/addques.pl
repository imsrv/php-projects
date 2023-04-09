#!/usr/bin/perl -w
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
$basedir="/web/011/etown21g/public_html/jworld";
$baseurl="http://www.etown21.com/jworld";
$tempdir="$basedir/triviasoup/temp";
###############################################################################

$question=$FORM{'question'};
$answer=$FORM{'answer'};
$choice1=$FORM{'choice1'};
$choice2=$FORM{'choice2'};
$choice3=$FORM{'choice3'};
$choice4=$FORM{'choice4'};
$level=$FORM{'level'};
###############################################################################

if($FORM{'addques'} eq "Add Question"){
&addtheques;
}

sub addtheques {

if(($question eq "")||($level eq "")||($choice1 eq "")||($choice2 eq "")||($choice3 eq "")||($choice4 eq "")||($answer eq ""))
{
print "Content-type:text/html\n\n";
print <<EOF;
<html><head><title>Missing Information</title></head>
<body><blockquote><font size=2 face=verdana>All fields must be filled in and a level selected.
<ul><li>Level One indicates easy questions(Worth 100-500 points)
<li>Level Two indicates medium questions( Worth 1500 points)
<li>Level Three indicates hard questions(Worth 10000 points)</ul></font></blockquote>
</body></html>
EOF
exit;
}

open  (FILE, ">>$tempdir/$level.txt") || &oops($!, "Cannot read $tempdir/$level/.txt");
flock (FILE, 2) or die "can't lock file\n";
print  FILE "<font size=1 face=verdana><b>$question<br><table><tr><td><input type=radio name=answer value=$choice1><font size=1 face=verdana><b>$choice1</b></font></td><td><input type=radio name=answer value=$choice2><font size=1 face=verdana><b>$choice2</b></font></td><td><input type=radio name=answer value=$choice3><font size=1 face=verdana><b>$choice3</b></font></td><td><input type=radio name=answer value=$choice4><font size=1 face=verdana><b>$choice4</b></font></td></tr></table><input type=hidden name=realans value=$answer><input type=submit name=submitanswer value=\"Submit Answer\"></center>\n";
close (FILE);

###############################################################################

print "Content-type:text/html\n\n";
print <<EOF;
<html><head><title>Trivia Soup Question Box</title></head>
<body bgcolor=c0c0c0>
<form method="post" action="addques.pl">
<center><font color=maroon><b>The question has been added!</b></font><br>
<a href="http://www.etown21.com/jworld">JWorld For Kids</a></center><p>
<center><table><tr>
<td><b>Question</b></td><td><center><input type="text" name="question" size=50></center></td></tr><tr>
<td><b>Level</b></td><td><center><select name=level><option value="questions">Level One</option><option value="questions2">Level Two</option><option value="questions3">Level Three</option></select></center></td></tr><tr>
<td><b>Choice 1</b></td><td><center><input type="text" name="choice1" size=20></center></td></tr><tr>
<td><b>Choice 2</b></td><td><center><input type="text" name="choice2" size=20></center></td></tr><tr>
<td><b>Choice 3</b></td><td><center><input type="text" name="choice3" size=20></center></td></tr><tr>
<td><b>Choice 4</b></td><td><center><input type="text" name="choice4" size=20></center></td></tr><tr>
<td><b>Correct Answer</b></td><td><center><input type="text" name="answer" size=20></center></td></tr><tr>
<td><b>&nbsp;</b></td><td><center><input type="submit" name="addques" value="Add Question" size=20></center></td></tr></table></center>
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



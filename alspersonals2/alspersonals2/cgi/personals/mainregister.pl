#!/usr/bin/perl  -w

require "configdat.lib"; 
require "variables.lib"; 
require "readparse.lib"; 

################################################################# 
&readparse;   

if($FORM {'register'} eq "Register"){ 
&doreg; 
}     

sub doreg { 
&vars;  
if (($emailaddr eq "")||($username eq "")||($password eq "")){ 
&header; 
&html_missing; 
print "<br><br><hr color=\"red\" size=6 width=400><br>\n"; 
print "<center><h4><font color=0000ff face=bodoni,univers,arial> 
Missing Information</font></h4><br><font size=2 face=univers>
You have left a required field empty. <br>You must enter 
your email address, a username and <br>a password in order to proceed.
<br>\n"; 
print "Please go back and enter the missing information.</center></font>\n";
print "<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\"> </FORM></center>\n";
exit;
} 

&cont; 
 

}  

sub cont { 
open (FILE, ">>$users/$username\.txt") || die "Cannot open $users/$username\.txt\n"; 
flock (FILE, 2) or die "can't lock file\n"; 
print FILE "$username&&$emailaddr&&$password\n"; 
close (FILE);  

open (FILE, ">>$users/$password\.txt") || die "Cannot open $users/$username\.txt\n"; 
flock (FILE, 2) or die "can't lock file\n"; 
print FILE "$username&&$emailaddr&&$password\n"; 
close (FILE);  


open  (MAIL, "| $sendmail -t") || die "cannot open sendmail\n"; 
print MAIL "To: $username <$emailaddr>\n"; 
print MAIL "From: $email\n"; print MAIL "Subject: Your $sitename Community Center User Info\n";
print MAIL "Thank you for registering to use $sitename community resources.\n"; 
print MAIL "Your Chosen user name and password are:\n"; 
print MAIL "User Name: $username\n"; 
print MAIL "Password: $password\n"; 
print MAIL "\n"; 
print MAIL "$sitename administration\n"; 
close MAIL;  

&header; 
&html_success; 
print "<br><br><hr color=\"red\" size=6 width=400><br>\n"; 
print "<center><h4><font color=0000ff face=bodoni,univers,arial> 
Registration Completed Successfully</font></h4><br><font size=2 face=univers>
Your registration information has been received and processed.<br> An email has been
sent to the address you provided.
<br>You may return to the login page by clicking the login button below.<br>
\n"; 
print "<center><FORM method=\"get\" action=\"$baseurl/reglog.html\"> <INPUT type=\"submit\" value=\"Login\"> </FORM></center>\n";
exit;
 
}   

sub header {  
print "Content-type:text/html\n\n";  

}  



###########################################################################################

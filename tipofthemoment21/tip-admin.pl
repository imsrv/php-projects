#!/usr/local/bin/perl 

#######################################################
#             Tip of the Moment V2.1
#
# This program is distributed as freeware. We are not            	
# responsible for any damages that the program causes	
# to your system. It may be used and modified free of 
# charge, as long as the copyright notice
# in the program that give me credit remain intact.
# If you find any bugs in this program. It would be thankful
# if you can report it to us at cgifactory@cgi-factory.com.  
# However, that email address above is only for bugs reporting. 
# We will not  respond to the messages that are sent to that 
# address. If you have any trouble installing this program. 
# Please feel free to post a message on our CGI Support Forum.
# Selling this script is absolutely forbidden and illegal.
##################################################################
#
#               COPYRIGHT NOTICE:
#
#         Copyright 1999 The AHC CGI Factory 
#
#      Author:  Yutung Liu
#      web site: http://www.cgi-factory.com
#      E-Mail: cgifactory@cgi-factory.com
#
#   This program is protected by the U.S. and International Copyright Law
#
###################################################################
require "cfg.pl";

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs){
	($val1, $val2) = split(/=/, $pair);
	$val1 =~ tr/+/ /;
	$val1 =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$val2 =~ tr/+/ /;
	$val2 =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($FORM{$val1}) {
		$FORM{$val1} = "$FORM{$val1}, $val2";
	}
	else {
		$FORM{$val1} = $val2;
	}
}


if ($FORM{'firsttime'}) { &firsttime; }
if ($FORM{'add'}) { &add; }
if ($FORM{'addnew'}) { &addnew; }
if ($FORM{'view'}) { &view; }
if ($FORM{'modify'}) { &modify; }
if ($FORM{'makechange'}) { &makechange; }

else {

open (DETECT,"<$messages_location/pass.dat") || &error3;
	
if ($flock eq "y") {

flock DETECT, 2; 

}

	
close (DETECT);

&manager;
	
exit;

}

sub error3{
print "Content-type: text/html\n\n";
print "This is the first time you run this script.\n";
print "please type in your first message at the box below\n";
print "<form action=\"tip-admin.pl\" method=\"post\"><INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"Yes\" checked>NO HTML Allowed<INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"No\">HTML allowed<br><textarea rows=10 cols=70 name=\"Body\"></textarea><br>Please set your admin password here:<br><input type=\"password\" name=\"password\"><br><input type=\"hidden\" name=\"firsttime\" value=\"firsttime\"><input type=\"submit\" value=\"send\"></form>";

exit;

}


sub firsttime{
	
   if ($FORM{'password'} eq""){
		
   print "Content-type:text/html\n\n";
   print "Please don't leave the password field blank!";
		
		exit;
		
	}
	
	&checkfield;
	
   $FORM{'password'}=~ tr/A-Z/a-z/;
   
   $password = crypt($FORM{'password'}, "MM");	
    
   open (PASSWORD, ">$messages_location/pass.dat") || &error("unable to create the file: $!\n");
    
   if ($flock eq "y") {

   flock PASSWORD, 2; 

   }

    print PASSWORD "$password";
    close (PASSWORD);
	
	
	if ($FORM{'HTML'} eq "Yes") {
		$FORM{'Body'} =~ s/\&/\&amp\;/g;
		$FORM{'Body'} =~ s/"/\&quot\;/g;
		$FORM{'Body'} =~ s/</\&lt\;/g;
		$FORM{'Body'} =~ s/>/\&gt\;/g;
		
		
	}

	
	open (FT,">$messages_location/0.txt") || &error("unable to create the file: $!\n"); 
	
	if ($flock eq "y") {

    flock FT, 2; 

    }

    print FT "$FORM{'Body'}";
    
	close (FT) || &error("unable to wirte the file: $!\n"); 

	
	open (COUNT,">$messages_location/count.txt") || &error("unable to create the file: $!\n"); 

	if ($flock eq "y") {

    flock COUNT, 2; 

   }

	
	print COUNT "0";
	close (COUNT);
	
	print "Content-type: text/html\n\n";
	print "Setup complete\n";
	
	
exit;	

}

sub manager{
	
	print "Content-type: text/html\n\n";
	print "<html><head><title>Tip of the Moment Admin</title></head>\n";
    print "<table><tr><td>Add a new message?</td><td><form action=\"tip-admin.pl\" method=\"post\"><input type=\"hidden\" name=\"add\" value=\"add\"><input type=\"submit\" value=\"yes\"></form></td></tr>\n";
    print "<tr><td>View all messages?</td><td><form action=\"tip-admin.pl\" method=\"post\"><input type=\"hidden\" name=\"view\" value=\"view\"><input type=\"submit\" value=\"yes\"></form></td></tr></table>";
	print "</html>\n";
	
exit;

}


sub add{

print "Content-type: text/html\n\n";
print "<head><title>Add new message</title></head>";
print "<form action=\"tip-admin.pl\" method=\"post\"><INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"Yes\" checked>NO HTML Allowed<INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"No\">HTML allowed<br><textarea rows=10 cols=70 name=\"Body\" value=\"Body\"></textarea><br>Admin Password: <input type=\"password\" name=\"password\"><input type=\"hidden\" name=\"addnew\" value=\"addnew\"><br><input type=\"submit\" value=\"add this message\"></form>";

exit;

}


sub addnew{
	
&vpassword;	
&checkfield;

open(COUNT,"$messages_location/count.txt") || &error("unable to open count.txt");

if ($flock eq "y") {

flock COUNT, 2; 

}


$count = <COUNT>; 

close(COUNT);
 
$count++; 

open(COUNT,">$messages_location/count.txt") || &error("unable to open count.txt");

if ($flock eq "y") {

flock COUNT, 2; 

}

print COUNT "$count";

close(COUNT);



if ($FORM{'HTML'} eq "Yes") {
		$FORM{'Body'} =~ s/\&/\&amp\;/g;
		$FORM{'Body'} =~ s/"/\&quot\;/g;
		$FORM{'Body'} =~ s/</\&lt\;/g;
		$FORM{'Body'} =~ s/>/\&gt\;/g;
		
		
	}
		
	
	
open(DATA2,">$messages_location/$count.txt") || &error("unable to open count.txt: $i"); 

if ($flock eq "y") {

flock DATA2, 2; 

}

print DATA2 "$FORM{'Body'}";
close(DATA2);

print "Content-type: text/html\n\n";
print "Message NO.$count has been added.";


exit;

}

sub view {
	
open (COUNT,"$messages_location/count.txt") || &error("unable to open count.txt: $!"); 
	
if ($flock eq "y") {

flock COUNT, 2; 

}

	
    $count = <COUNT>;
	close (COUNT);
	print "Content-type: text/html\n\n";
    print "<table>";
    
$i = "0";
for ($i; $i < $count; ++$i) {
	
	print "<tr><td><a href=\"$messages_location2\/$i.txt\">$i</a></td>";
    print "<td><form action=\"tip-admin.pl\" method=\"post\"><input type=\"hidden\" name=\"modify\" value=\"modify\"><input type=\"hidden\" name=\"number\" value=\"$i\"><input type=\"submit\" value=\"modify\"></form></td></tr>\n";
}
    print "<tr><td><a href=\"$messages_location2\/$count.txt\">$count</a></td>";
    print "<td><form action=\"tip-admin.pl\" method=\"post\"><input type=\"hidden\" name=\"modify\" value=\"modify\"><input type=\"hidden\" name=\"number\" value=\"$count\"><input type=\"submit\" value=\"modify\"></form></td></tr></table>\n";

exit;

}	

sub modify{

print "Content-type: text/html\n\n";
print "<html><head><title>Modify a message</title></head><body>";
print "This is message No. $FORM{'number'}";
print "<form action=\"tip-admin.pl\" method=\"post\"><INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"Yes\" checked>NO HTML Allowed<br><INPUT TYPE=RADIO NAME=\"HTML\" VALUE=\"No\">HTML allowed<br><textarea rows=10 cols=70 name=\"Body\"></textarea><br>Admin Password: <input type=\"password\" name=\"password\"><input type=\"hidden\" name=\"number\" value=\"$FORM{'number'}\"><input type=\"hidden\" name=\"makechange\" value=\"make change\"><br><input type=\"submit\" value=\"modify this message\"></form>";

exit;

}

sub makechange{

&vpassword;
&checkfield;

if ($FORM{'HTML'} eq "Yes") {
		$FORM{'Body'} =~ s/\&/\&amp\;/g;
		$FORM{'Body'} =~ s/"/\&quot\;/g;
		$FORM{'Body'} =~ s/</\&lt\;/g;
		$FORM{'Body'} =~ s/>/\&gt\;/g;
		
		
	}
		
	
if ($FORM{'number'}=~ tr/;<>*|`&$!#()[]{}:'"//) {
        	
            print "Content-type: text/html\n\n";
            print "Security Alert! Action canceled.<br>\n";
        	print "Please don't use weird symbols\n";
        	
        	exit;
        	
        }
	



open (DATA2,">$messages_location/$FORM{'number'}.txt") || &error("unable to wirte the file: $!\n"); 

if ($flock eq "y") {

flock DATA2, 2; 

}


print DATA2 "$FORM{'Body'}";
close(DATA2);

print "Content-type: text/html\n\n";
print "Message has been modified.";

exit;

}


sub vpassword{
	

open (PASS,"$messages_location/pass.dat") || &error("unable to open the file: $!\n"); 

if ($flock eq "y") {

flock PASS, 2; 

}


$pass = <PASS>;

close(PASS);

$FORM{'password'}=~ tr/A-Z/a-z/;


$pass2 = crypt($FORM{'password'}, "MM");

unless ($pass eq "$pass2") {
	
$timenow=localtime();
	
	    print "Content-type: text/html\n\n";
	    print "Incorrect logon. Use your back button to try again.<br>";
		print "The password you entered is incorrect.<br>";
        print "The following information has been sent to the webmaster of the web site<br>";
        print "Your Information: <ul>$ENV{'REMOTE_HOST'}</ul>";
        print "<ul>Password: $FORM{'password'}</ul>";
        print "<ul>Time: $timenow</ul>";

 
 if ($alert eq "y") {       
        
        open (MAIL, "|$mail_prog") or &error("Unable to open the mail program");
        print MAIL "To: $yourmail\n";
        print MAIL "From: $yourmail\n";
        print MAIL "Subject: bad password\n";
        print MAIL "Just a quick note to let you know that someone\n";
        print MAIL "entered the wrong password for entering the admin script.\n";
        print MAIL "Here are the information:\n\n";
        print MAIL "$ENV{'REMOTE_ADDR'}\n";
        print MAIL "Password: $FORM{'password'}\n";
        print MAIL "$timenow\n";
        
        close(MAIL);
        
        exit;
        	
        }      
   
exit;
	
}

}

sub checkfield{
	
      if ($FORM{'Body'} eq""){
		
		print "Content-type:text/html\n\n";
		print "Please don't leave the message field blank!";
		
		exit;
		
	}
	
}


sub error{

print "Content-type: text/html\n\n";

$errors = $_[0] ;

print "An error has been occured. The error is: $errors\n";

exit;
}








 



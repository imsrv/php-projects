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

&tip;

sub tip{

open (DAT,"<$messages_location/count.txt") || &error1("unable to open counts.txt");
	
if ($flock eq "y") {

flock DAT, 2; 

}
	
	
	$dat = <DAT>;
	close (DAT);

$dat++;

srand ();
$rand_num = rand($dat);
$rand_num = int($rand_num);  


if ($rand_num=~ tr/;<>*|`&$!#()[]{}:'"//) {
        	
            print "Content-type: text/html\n\n";
            print "Security Alert! Action canceled.<br>\n";
	        print "Please don't use weird symbols\n";
        	
        	exit;
        	
        }


open (DATA,"<$messages_location/$rand_num.txt") || &error;
    
if ($flock eq "y") {

flock data, 2; 

}
   
    @data = <DATA>;
    $data = <DATA>;
    close (DATA);



print "Content-type: text/html\n\n";
print "<font color=\"$tcolor\"><b>$title</b></font>\n";

if ($showdate==1) {

print "<font color=\"$dcolor\">";

&date;
	
print "</font>";

}

print "<br><br><font color=\"$mcolor\">\n";

foreach $data (@data) {
print "$data\n";

}

print "</font>";

exit;

}


sub error1{

$errors = $_[0] ;
print "Content-type: text/html\n\n";
print "An error occured,<br>\n";
print "the error is $errors<br>\n";
print "reason: $!\n";


exit;

}

sub error{

print "Content-type: text/html\n\n";
print "<font color=\"$tcolor\"><b>$title</b></font>\n";

if ($showdate==1) {

print "<font color=\"$dcolor\">";

&date;
	
print "</font>";

}

print "<br><br><font color=\"mcolor\">\n";

print "Nothing at this moment.\n";

print "</font>";


if ($mail_prog=~ tr/;<>*|`&$!#()[]{}:'"// or $email=~ tr/;<>*|`&$!#()[]{}:'"//) {
        	
            print "Content-type: text/html\n\n";
            print "Security Alert! Action canceled.<br>\n";
	        print "Please don't use weird symbols\n";
        	
        	exit;
        	
        }

open(MAIL,"|$mail_prog -t");
 print MAIL "To: $email\n";
 print MAIL "From: $email\n";
 print MAIL "Subject: File NO. $rand_num is missing  \n\n";
 print MAIL "For some reasons, the file $rand_num.txt is missing.\n";
 print MAIL "You may want to check your message database.  :)\n";
 
close (MAIL);


exit;


}


sub date {
	
@months = ('January','February','March','April','May','June','July','August','September','October','November','December');

@days = ('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime)[0,1,2,3,4,5,6];

if ($sec < 10) { $sec = "0$sec"; }

if ($min < 10) { $min = "0$min"; }

if ($hour < 10) { $hour = "0$hour"; }

if ($mday < 10) { $mday = "0$mday"; }

if ($year < 100) { $year = "19$year"; }

else { 

$year=$year-100;

if ($year <10) {
	
$year = "200$year"; 

}
}

$date = "$days[$wday], $months[$mon] $mday, $year";

print "$date";

}







 



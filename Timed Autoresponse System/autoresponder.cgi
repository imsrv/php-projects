#!/usr/bin/perl
##############################################################
#                                                            #
#                 Timed Autoresponse System                  #
#                     By Steve Miles                         #
#                http://www.groundbreak.com                  #
#                                                            #
#                 Copyright <c> 1999-2000                    #
#                                                            #
#     Selling or distributing this software or               #
#     modifications of this software without                 #
#     permission is expressly forbidden. Permission          #
#     to modify the script for personal use is granted.      #
#     In all cases this header and copyright                 #
#     must remain intact. All violators will be              #
#     PROSECUTED to the full extent.                         #
#                                                            #
##############################################################
require "config.cgi";

######################################################################
# No need to edit below here
######################################################################

use CGI qw (:standard);
$q = new CGI;
@stuff = $q->param;
foreach $stuff (@stuff) {${$stuff} = $q->param($stuff);}

if ($action eq "Sign Up") {
&check_form;
&log_email;
&send_first_email;
&redirect;
}
elsif ($action eq "Remove") {
&remove_email;
&redirect;
}
else { print $q->header; print "You executed this script wrong!";}
exit;

sub remove_email {

$tempfile = "tempfile.txt";

	open (FILE, "<$path_to_members_file");
	flock(FILE, 2);
	
	open (TEMPFILE, ">$tempfile");
	flock(TEMPFILE, 2);
	
	while (<FILE>) {
		($logged_email,$logged_title,$logged_first_name,$logged_last_name) = split (/\|/, $_);
		if ($logged_email eq $email) { next;}
		else { print TEMPFILE $_; }
	}
	
	flock(FILE, 8);
	close (FILE);
	
	flock(TEMPFILE, 8);
	close (TEMPFILE);

        unlink $path_to_members_file;
        rename $tempfile, $path_to_members_file;

}


sub check_form {

	if ($email && $first_name && $last_name && $title) {}
	else {print $q->header; print "<center>You didn't fill in all the variables.</center>";exit;}

	if ($first_name =~ /^[A-Za-z]+$/) {}
	else {print $q->header; print "<center>First name must contain only letters with no spaces.</center>";exit;} 
	
	if ($last_name =~ /^[A-Za-z]+$/) {}
	else {print $q->header; print "<center>Last name must contain only letters with no spaces.</center>";exit;} 
	
	if ($email =~ /^[\w\-\.]+\@[\w\-]+\.[\w\-\.]+\w$/) {}
	else {print $q->header; print "<center>Not a valid email format.</center>";exit;} 

	open (FILE, "$path_to_members_file");
	flock(FILE, 2);
	@members = (<FILE>);
	flock(FILE, 8);
	close (FILE);

	foreach $member (@members) {
		chomp $member;
		($logged_email,$logged_title,$logged_first_name,$logged_last_name) = split (/\|/, $member);
		if ($logged_email eq $email) {print $q->header; print "<center>This email has already been registered.</center>";exit;}
	}

}

sub log_email {

&date;

open (FILE, ">>$path_to_members_file");
flock(FILE, 2);
print FILE "$email|$title|$first_name|$last_name|$time|$month/$day/$year\n";
flock(FILE, 8);
close (FILE);

}

sub send_first_email {

&prep_first;

open (MAIL, "|$path_to_sendmail $email") || die "Can't open $path_to_sendmail!\n";
print MAIL <<"HEADER";
To: $email
Subject: $subject
From: $admin_email

if ($send_as_html eq 1) {
  print MAIL "MIME-Version: 1.0\n";
  print MAIL "Content-Type: text/html; "."boundary=\"8=--\"\n";
}

$message
HEADER
close (MAIL);

	open (FILE, ">>$path_to_data_files/$month.$day.$year");
	flock(FILE, 2);
	print FILE "$email|first\.txt\n";
	flock(FILE, 8);
	close (FILE);

}

sub prep_first {

	open (FILE, "$path_to_first_email");
	flock(FILE, 2);
	(@stuff) = (<FILE>);
	flock(FILE, 8);
	close (FILE);

	$subject = shift (@stuff);
	chomp $subject;
	foreach $stuff (@stuff) {
		$message .= $stuff;
	}
	$subject =~ s/<email>/$email/ig;
	$subject =~ s/<title>/$title/ig;
	$subject =~ s/<first_name>/$first_name/ig;
	$subject =~ s/<last_name>/$last_name/ig;
	$message =~ s/<email>/$email/ig;
	$message =~ s/<title>/$title/ig;
	$message =~ s/<first_name>/$first_name/ig;
	$message =~ s/<last_name>/$last_name/ig;
}
	

sub redirect {

	if ($action eq "Remove") {
		print $q->redirect(-url=>$redirect_to_this_page_after_removal);
	}

	if ($action eq "Sign Up") {
		print $q->redirect(-url=>$redirect_to_this_page_after_signup);
	}

}

sub date {
    $time = time();
    ($sec, $min, $hour, $day, $mon, $year, $dweek, $dyear, $daylight) = localtime($time);
    $month = $mon + 1;
    $year = $year + 1900;
}
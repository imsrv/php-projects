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
#################################################################
# YOU MUST EDIT THIS LINE BELOW TO BE THE FULL PATH TO CONFIG.CGI
#################################################################
require "/full/path/to/your/config.cgi";

######################################################################
# No need to edit below here
######################################################################
$current_time = time();

&date;
&prepare_templates;
&shoot_emails;
exit;


sub prepare_templates {

use File::Find;

find(\&buildem, $path_to_email_template_directory);

  	sub buildem {
    
	$file = $File::Find::name;
	$file =~ s/$path_to_email_template_directory\///ig;	
	$file =~ s/\.txt//ig;

		if ($file =~ /^[0-9]+$/) {
    		push (@valid_emails, $file);
		}

	}
	
	foreach $valid_email (@valid_emails) {
		$email_hash{$valid_email} = 1;
	}

}

sub shoot_emails {

	open (FILE, "$path_to_members_file");
	flock(FILE, 2);
	@members = (<FILE>);
	flock(FILE, 8);
	close (FILE);

	foreach $member (@members) {
		chomp $member;
		($logged_email,$logged_title,$logged_first_name,$logged_last_name,$logged_time,$logged_month,$logged_day,$logged_year) = split (/\|/, $member);
	
		$high_level = $current_time - $logged_time;
		$low_level = $high_level - 86400;
	
		foreach $key (keys %email_hash) {
		$sendoff = $key * 86400;
			if ($sendoff > $low_level) {
			if ($sendoff < $high_level) {
			&send_email;
			}}
		}
	}
}

sub send_email {
	
	open (FILE, "$path_to_email_template_directory/$key\.txt");
	flock(FILE, 2);
	(@email_stuff) = (<FILE>);
	flock(FILE, 8);
	close (FILE);

	$subject = shift (@email_stuff);
	chomp $subject;
	foreach $email_stuff (@email_stuff) {
		$message .= $email_stuff;
	}	
	
	$subject =~ s/<email>/$logged_email/ig;
	$subject =~ s/<title>/$logged_title/ig;
	$subject =~ s/<first_name>/$logged_first_name/ig;
	$subject =~ s/<last_name>/$logged_last_name/ig;
	$message =~ s/<email>/$logged_email/ig;
	$message =~ s/<title>/$logged_title/ig;
	$message =~ s/<first_name>/$logged_first_name/ig;
	$message =~ s/<last_name>/$logged_last_name/ig;
	
	
open (MAIL, "|$path_to_sendmail $logged_email") || die "Can't open $path_to_sendmail!\n";
print MAIL <<"HEADER";
To: $logged_email
Subject: $subject
From: $admin_email

if ($send_as_html eq 1) {
  print MAIL "MIME-Version: 1.0\n";
  print MAIL "Content-Type: text/html; "."boundary=\"8=--\"\n";
}

$message
HEADER
close (MAIL);

$subject = "";
$message = "";

	open (FILE, ">>$path_to_data_files/$month.$day.$year");
	flock(FILE, 2);
	print FILE "$logged_email|$key\.txt\n";
	flock(FILE, 8);
	close (FILE);

}

sub date {
    ($sec, $min, $hour, $day, $mon, $year, $dweek, $dyear, $daylight) = localtime($current_time);
    $month = $mon + 1;
    $year = $year + 1900;
}

1;
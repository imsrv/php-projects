#!/usr/bin/perl
#########################################################
#  RemoveBounce - Removes bounced emails from database  #
#########################################################
#                                                       #
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Development Division.                  #
# http://www.perlcoders.com/                            #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright 2001              #
# PerlCoders (http://perlcoders.com) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################
#
# Usage of this script for parsing bounced mails out of the database you must 
# have the perl modules Mail::Audit and File::Copy installed on your server first.
# You can ask your system administrator if he has them installed. If not then he 
# can get the modules for free here: http://www.perlcoders.com/packages
#
#

my $admin_mail = 'info@perlcoders.com';		  # uncaught messages
						  # get sent here

my $save_error_mbox = '/home/perlcoders/mail/errors';  # unset to discard
						  
my $MAILER_DAEMON = qr/MAILER-DAEMON@/i;    # parse messages with
					    # any email address
					    # matching this regexp

######################## DONT TOUCH BELOW #########################################
use strict;
use Mail::Audit;
use Fcntl ':flock';
use File::Copy;
use Configs;
my $user_database = "$scriptdir/all_mails.txt";

my $mail = Mail::Audit->new;

sub handle_bounced_email {
    my $email = shift;

    remove_email_from_db($email);

    if($save_error_mbox) {
	$mail->accept($save_error_mbox);
    } else {
	$mail->ignore;
    }
}	

sub remove_email_from_db {
    my $email = shift;

    my @DB;

    open(OUT, "+< $user_database") 
	or die "Unable to open $user_database for update\n";

    flock(OUT, LOCK_EX);

    copy($user_database, $user_database.$$)
	or die "Unable to create tempfile for $user_database";

    open(IN, $user_database.$$);
    unlink($user_database.$$);
    
    seek(OUT, 0, 0);
    truncate(OUT, 0);


    while(chomp($_ = <IN>)) {
	next if $_ eq $email;
	print OUT "$_\n";
    }

    flock(OUT, LOCK_UN);
    close(OUT);
    close(IN);
}


###########################
# if the mail didnt come from the MTA
# pass it along to the admin...

unless($mail->from =~ /$MAILER_DAEMON/) {
    if($admin_mail) {
	$mail->resend($admin_mail);
	$mail->ignore;
    } else {
	$mail->ignore;
    }
}

###########################
# handle sendmail bounces

if($mail->get('Content-Type') =~ m#^multipart/report; report-type=delivery-status;#) {
    my($email,$failed);
    for(@{$mail->body}) {
	if(/^Final-Recipient:.*?(\S+@\S+)\n?/) {
	    $email = $1;
	    next;
	}
	if(/^Action: failed/) {
	    $failed++;
	}
    }
    if($failed && $email) {
	handle_bounced_email($email);
    }
}
	        
#########################
# handle exim bounces 

if(my $email = $mail->get('X-Failed-Recipients')) {
    chomp($email);
    handle_bounced_email($email);
}

########################
# handle qmail bounces

if($mail->subject =~ /failure notice/) {
    for(@{$mail->body}) {
	if(/^<(\S+@\S+?)>:/) {
	    handle_bounced_email($1);
	}
	last if /^---/;    # below --- is original message...
    }
}

#####################
# no filter caught this message...
# send it to admin if defined

if($admin_mail) {
    $mail->resend($admin_mail);
}

$mail->ignore;


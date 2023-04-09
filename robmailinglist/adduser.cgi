#!/usr/bin/perl

#####################################
#                                   #
# RobMail v2.04b - Add User Script  #
# Copyright 1998-99 by Rob Eisler   #
# rob@robplanet.com                 #
# http://www.robplanet.com          #
#                                   #
# Last modified on Jan 6, 1999      #
#                                   #
#####################################
#
# Copyright Notice:
# Copyright 1998 - 99 Robert S. Eisler.  All Rights Reserved.
#
# This code may be used and modified by anyone so long as this header and
# copyright information remains intact.  By using this code you agree to 
# indemnify Robert S. Eisler from any liability that might arise from its 
# use.  You must obtain written consent before selling or redistributing 
# this code.
#
#####################################

# these should be the same as $maildir, $mailprog in massmail.cgi

$maildir = "/path/to/your/robmail";
$mailprog = '/usr/lib/sendmail -t';
$yourname = 'Your Name';
$yourmail = 'you@yourhost.com';
$robmailcgi = 'http://rob.webking.com/robmail/robmail.cgi?';

$confirm_additions = 1;

#########################################################################
# Don't change anything below here unless you know what you're doing :) #
#########################################################################

$use_cgi = 1;
$LOCK_EX = 2;
$LOCK_UN = 8;
&readform;

print "Content-type: text/html\n\n";

if ($what eq 'add') {

	$list = $FORM{'list'};
	$name = $FORM{'name'};
	$email = $FORM{'email'};	

	&fatal_error("Invalid E-Mail Address") if ($email !~ /.*\@.*\..*/);

	open(FILE, "$maildir/$list\.txt") || &fatal_error("Can't open $maildir/$list\.txt");

	@info = <FILE>;
	close(FILE);
	$num = @info;

	for ($a = 0; $a < $num; $a++) {

		($recipient,$n,$nochop) = split(/``/,$info[$a]);
		&fatal_error("$email is already on the list.") if ("\U$recipient" eq "\U$email");

	}

	if ($confirm_additions == 0) {

		open(FILE, ">>$maildir/$list\.txt") || &fatal_error("Can't open $maildir/$list\.txt");
		print FILE "$email``$name``x\n";
		close(FILE);

		open (MAIL, "|$mailprog") || die "Can't open $mailprog!\n";
		print MAIL "To: $email\n";
		print MAIL "From: $yourname < $yourmail >\n";
		print MAIL "Subject: Successful Addition to Mailing List\n";

		print MAIL "You have been successfully added to the mailing list through the form at\n";
		print MAIL "$ENV{'HTTP_REFERER'}\n";
		print MAIL "If you would like to remove yourself from the list, visit\n";
		print MAIL "$ENV{'HTTP_REFERER'}\n";
	
		close(MAIL);

		print "<html><head><title>User Added</title></head>\n";
		print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
		print "<!--\n";
		print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
		print "eislerr\@tdi.uregina.ca\n";
		print "http://tdi.uregina.ca/~eislerr\n";
		print "-->\n\n";
		print "<font face=arial>\n";
		print "<center>\n";
		print "<font size=5>You have been added to the mailing list. You should receive a confirmation e-mail shortly.</font><p>\n";
		print "<big><b>\&#183;</big></b> <a href=\"$ENV{'HTTP_REFERER'}\">Back</a> <big><b>\&#183;</b></big>\n";
		print "</center></font></body></html>\n";
		exit;

	} else {

		$kode = (time);

		open(FILE, ">>$maildir/pend\.txt") || &fatal_error("Can't open $maildir/pend\.txt");
		print FILE "$email``$name``$list``$kode``x\n";
		close(FILE);

		open (MAIL, "|$mailprog") || die "Can't open $mailprog!\n";
		print MAIL "To: $email\n";
		print MAIL "From: $yourname < $yourmail >\n";
		print MAIL "Subject: Mailing List Confirmation\n";

		print MAIL "Your mailing list application has been received. To confirm\n";
		print MAIL "your e-mail address, please visit:\n\n";

		print MAIL "$robmailcgi";
		print MAIL "action=confirm\&who=$email\&id=$kode\n\n";

		print MAIL "Once you have visited this URL, your e-mail will be on the \n";
		print MAIL "list, and you will receive mailings.";

		close(MAIL);

		print "<html><head><title>User Added</title></head>\n";
		print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
		print "<!--\n";
		print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
		print "eislerr\@tdi.uregina.ca\n";
		print "http://tdi.uregina.ca/~eislerr\n";
		print "-->\n\n";
		print "<font face=arial>\n";
		print "<center>\n";
		print "<font size=5>You have been added to the mailing list. You should receive a confirmation e-mail shortly. Please follow the instructions in this message to confirm your e-mail address.</font><p>\n";
		print "<big><b>\&#183;</big></b> <a href=\"$ENV{'HTTP_REFERER'}\">Back</a> <big><b>\&#183;</b></big>\n";
		print "</center></font></body></html>\n";
		exit;

	}

} elsif ($what eq 'remove') {

	$list = $FORM{'list'};
	$email = $FORM{'email'};	

	$found = 0;

	open(FILE, "$maildir/$list\.txt") || &fatal_error("Can't open $maildir/$list\.txt");

	@info = <FILE>;
	close(FILE);
	$num = @info;

	open(FILE, ">$maildir/$list\.txt") || &fatal_error("Can't open $maildir/$list\.txt");
	&lock(FILE);

	for ($a = 0; $a < $num; $a++) {

		($recipient,$name,$nochop) = split(/``/,$info[$a]);
		if ("\U$recipient" eq "\U$email") {
			$found = 1;
		} else {
			print FILE "$recipient``$name``x\n";
		}

	}
	&unlock(FILE);
	close(FILE);

	&fatal_error("Could not find $email in this list.") if ($found == 0);

	open (MAIL, "|$mailprog") || die "Can't open $mailprog!\n";
	print MAIL "To: $email\n";
	print MAIL "From: $yourname < $yourmail >\n";
	print MAIL "Subject: Successful Removal From Mailing List\n";

	print MAIL "You have been successfully removed from the mailing list ";
	print MAIL "through the form at\n";
	print MAIL "$ENV{'HTTP_REFERER'}\n";
	print MAIL "If you would like to re-add yourself to the list, visit\n";
	print MAIL "$ENV{'HTTP_REFERER'}\n";
	print MAIL "This is the last e-mail you will receive from this mailing list.\n";
	
	close(MAIL);

	print "<html><head><title>User Removed</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>You have been removed from the mailing list. You should receive a confirmation e-mail shortly.  This is the last e-mail you will receive from this list.</font><p>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$ENV{'HTTP_REFERER'}\">Back</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

} else {
	&fatal_error("This script has been called incorrectly - Error in HTML form 'what' variable.");
}

sub readform {

	read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $input);
	foreach $pair (@pairs) {

	        ($name, $value) = split(/=/, $pair);
	        $name =~ tr/+/ /;
	        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	        $value =~ tr/+/ /;
	        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	        $value =~ s/<!--(.|\n)*-->//g;
	        $FORM{$name} = $value;
	}

	$what = $FORM{'what'};

}

sub fatal_error {
	local($e) = @_;

	print "<html>\n";
	print "<head><title> RobMail Fatal Error </title></head>\n";
	print "<body bgcolor=white text=black link=blue vlink=blue>\n";
	print "<font face=arial><center>\n";
	print "<h2>RobMail Fatal Error</h2>\n";

	print "RobMail experienced an unrecoverable error. The error seems\n";
	print "to be:<p>\n";

	print "<b>$e</b><p>\n\n";

	print "If this error continues, you should contact the administrator.<p>\n";

	print "<a href=\"$ENV{HTTP_REFERER}\">Back</a>\n";
	print "</center>";
	print "</font></body></html>\n";
	exit;
}

sub lock {
  local($file)=@_;
  flock($file, $LOCK_EX);
}

sub unlock {
  local($file)=@_;
  flock($file, $LOCK_UN);
}

                                                                                                                                                                                                                                                                           
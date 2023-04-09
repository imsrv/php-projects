#!/usr/bin/perl

#####################################
#                                   #
# RobMail v2.04b                    #
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

# declare the variables

$maildir = '/path/to/your/robmail';
$mailprog = '/usr/lib/sendmail -t';
$mailurl = 'http://www.yourhost.com/~you/robmail/index.html';
$yourname = 'Your Name';
$yourmail = 'you@yourhost.com';
$cgi = 'http://www.yourhost.com/~you/cgi-bin/robmail.cgi';
$queryswitch = '?';

#########################################################################
# Don't change anything below here unless you know what you're doing :) #
#########################################################################

$datafile = "$maildir/lists.txt";
$use_cgi = 1;
$LOCK_EX = 2;
$LOCK_UN = 8;
$increment = 5;

print "Content-type: text/html\n\n";

&readform;

&confirm if ($action eq 'confirm');
&actually_send_mail if ($action eq 'moremail');
&set_mail if ($what eq 'setmail');
&set_sig if ($what eq 'setsig');
&set_add_list if ($what eq 'setaddlist');
&set_del_list if ($what eq 'setdellist');
&set_list if ($what eq 'setlist');
&set_pass if ($what eq 'setpass');

$pass = $FORM{'pass'};

open(FILE, "$maildir/pwd.txt") || &fatal_error("Can't find password file.");

@lines = <FILE>;
close(FILE);

($p, $nochop) = split(/``/,$lines[0]);

&fatal_error("Invalid Password") if ($p ne crypt($FORM{'pass'}, substr($p, 0, 2)));

&make_mail if ($what eq 'makemail');
&change_sig if ($what eq 'changesig');
&add_list if ($what eq 'addlist');
&set_del_list2 if ($what eq 'setdellist2');
&del_list if ($what eq 'dellist');
&set_list2 if ($what eq 'setlist2');
&change_list if ($what eq 'changelist');
&change_pass if ($what eq 'changepass');

sub set_mail {

	print "<html><head><title>RobMail</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<center>\n";
	print "<font face=arial>\n";
	print "<h2>Compose a Message</h2>\n";
	print "<form action=\"$cgi\" method=post>\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n";

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	print "Mailing List:\n";

	print "<select size=1 name=\"list\">\n";

	for ($a = 0; $a < $numlist; $a ++) {
		($one, $nochop) = split(/``/, $list[$a]);
		print "<option value=\"$one\">$one</option>\n";
	}

	print "</select><p>\n";

	close(FILE);

	print "Subject: <input type=\"text\" name=\"subject\" size=40><p>\n";
	print "Use salutation?<br>\n";
	print "<input type=\"radio\" name=\"usename\" value=\"yes\">Yes\n";
	print "<input type=\"radio\" name=\"usename\" value=\"no\">No<p>\n";

	print "Of the form:<br>\n";
	print "<input type=\"text\" name=\"beforename\" size=20>\n";
	print "NAME\n";
	print "<input type=\"text\" name=\"aftername\" size=20><p>\n";

	print "Include the number of messages sent?<br>\n";
	print "<input type=\"radio\" name=\"usenum\" value=\"yes\">Yes\n";
	print "<input type=\"radio\" name=\"usenum\" value=\"no\">No<p>\n";

	print "Include signature?<br>\n";
	print "<input type=\"radio\" name=\"usesig\" value=\"yes\">Yes\n";
	print "<input type=\"radio\" name=\"usesig\" value=\"no\">No<p>\n";

	print "Force Word Wrapping?<br>\n";
	print "<input type=\"radio\" name=\"wrap\" value=\"yes\">Yes\n";
	print "<input type=\"radio\" name=\"wrap\" value=\"no\">No<p>\n";

	print "If so, the line width should be: \n";
	print "<input type=\"text\" name=\"wrapwidth\" size=\"3\" value=\"80\"><p>\n";

	print "Body of the e-mail:<br>\n";
	print "<textarea name=\"body\" cols=\"60\" rows=\"10\" wrap=\"virtual\"></textarea><br>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"makemail\">\n";
	print "<input type=\"hidden\" name=\"edit\" value=\"yes\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "<input type=\"reset\" value=\"Reset\">\n";

	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</font></center></body></html>\n";

	exit;

}

sub make_mail {

	$edit = $FORM{'edit'};
	$subject = $FORM{'subject'};
	$body = $FORM{'body'};
	$usename = $FORM{'usename'};
	$beforename = $FORM{'beforename'};
	$aftername = $FORM{'aftername'};
	$usenum = $FORM{'usenum'};
	$usesig = $FORM{'usesig'};
	$wrap = $FORM{'wrap'};
	$wrapwidth = $FORM{'wrapwidth'};
	$list = $FORM{'list'};

	if ($FORM{'body'}) {}
	else { 
		&fatal_error("You didn't enter anything for the body of the message!"); 
	}

	if ($subject eq '') {
		$subject = '< none >';
	}

	if ($usename eq 'yes' && $beforename eq '' && $aftername eq '') {
		$aftername = ',';
	}

	if ($usesig eq 'yes') {
		open(FILE, "$maildir/sig.txt") || &fatal_error("Can't find signature file.");
		@sig = <FILE>;
		close(FILE);
		$numsig = @sig;
	}

	open (FILE, "$maildir/$list\.txt") || &fatal_error("Can't open list.txt.");
	@info = <FILE>;
	close(FILE);
	$num = @info;

	$temp = 'NAME';
	$osubject = $subject;
	$obody = $body;
	$obname = $beforename;
	$oaname = $aftername;
	@osig = @sig;
	$subject =~ s/</&lt;/g;
	$subject =~ s/>/&gt;/g;
	$subject =~ s/"/&quot;/g;
	$beforename =~ s/</&lt;/g;
	$beforename =~ s/>/&gt;/g;
	$beforename =~ s/"/&quot;/g;
	$aftername =~ s/</&lt;/g;
	$aftername =~ s/>/&gt;/g;
	$aftername =~ s/"/&quot;/g;

	for ($a = 0; $a < $numsig; $a ++) {
		$sig[$a] =~ s/</&lt;/g;
		$sig[$a] =~ s/>/&gt;/g;
		$sig[$a] =~ s/"/&quot;/g;
	}

	$body =~ s/</&lt;/g;
	$body =~ s/>/&gt;/g;
	$body =~ s/"/&quot;/g;
	$body =~ s/\cM//g;
	$body =~ s/\n\n/<p>/g;
	$body =~ s/\n/<br>/g;

	if ($edit eq 'yes') {
	# preview message

		print "<html><head><title>RobMail</title></head>\n";
		print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
		print "<!--\n";
		print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
		print "eislerr\@tdi.uregina.ca\n";
		print "http://tdi.uregina.ca/~eislerr\n";
		print "-->\n\n";
		print "<center>\n";
		print "<font face=arial size=4><b>Message Preview</b></font><p>\n";

		if ($osubject eq '< none >') {
			print "<font face=arial size=2><b>\n";
			print "You did not enter a subject, so the subject has ";
			print "been entered as \&lt; none \&gt;.  You can change it ";
			print "below.</font></b><p>\n";
		}

		print "<table width=90% cellpadding=10 border=1 cellspacing=1 bgcolor=#000066>\n";

		print "<tr><td><font color=white>Subject: $subject</font></td></tr>\n";

		print "<tr><td><font color=white>Sending to mailing list \"$list\".</font></td></tr>\n";

		print "<tr><td><font color=white>";

		if ($usename eq 'yes') {
			print "$beforename$temp$aftername<p>\n";
		}
		print "$body\n";

		if ($usenum eq 'yes') {
			print "<p>\n";
			print "This message was sent to $num people.\n";
		}

		if ($usesig eq 'yes') {
			print "<p>\n";
			for ($a = 0; $a < $numsig; $a ++) {
				print "$sig[$a]";
				if ($a < ($numsig - 1)) {
					print "<br>";
				}
				print "\n";
			}
		}

		print "</font></td></tr>\n";
		print "</table>\n";

		print "<p>\n";
		print "<font face=arial>\n";

		print "<font size=2><b>\n";
		print "If you want to send the message as it is now, click 'no' ";
		print "for the next question, then click Go.  If you want to ";
		print "edit the message, leave the next question as 'yes', edit ";
		print "the message below, and then click Go.</b></font><p>\n";

		print "<form action=\"$cgi\" method=\"post\">\n";

		print "Do you want to edit this message?<br>\n";
		print "<input checked type=\"radio\" name=\"edit\" value=\"yes\"> Yes\n";
		print "<input type=\"radio\" name=\"edit\" value=\"no\"> No\n";

		print "<p>\n";

		print "<input type=\"submit\" value=\"Go\">\n";
		print "<input type=\"reset\" value=\"Reset\">\n<p>";

		$osubject =~ s/"/'/g;

		open(FILE, "$datafile") || &fatal_error("Can't find data file.");
		@list = <FILE>;
		close(FILE);
		$numlist = @list;

		print "Mailing List:\n";

		print "<select size=1 name=\"list\">\n";

		for ($a = 0; $a < $numlist; $a ++) {
			($one, $nochop) = split(/``/, $list[$a]);
			if ($one eq $list) {
				print "<option selected value=\"$one\">$one</option>\n";
			} else {
				print "<option value=\"$one\">$one</option>\n";
			}
		}

		print "</select><p>\n";

		close(FILE);

		print "Subject: <input type=\"text\" name=\"subject\" value=\"$osubject\" size=40><p>\n";

		print "Use salutation?<br>\n";

		if ($usename eq 'yes') {
			print "<input checked type=\"radio\" name=\"usename\" value=\"yes\"> Yes\n";
			print "<input type=\"radio\" name=\"usename\" value=\"no\"> No\n";
		} else {
			print "<input type=\"radio\" name=\"usename\" value=\"yes\"> Yes\n";
			print "<input checked type=\"radio\" name=\"usename\" value=\"no\"> No\n";
		}
		print "<p>\n";
		print "Of the form:<br>\n";
		print "<input type=\"text\" name=\"beforename\" value=\"$obname\" size=20>\n";
		print "NAME\n";
		print "<input type=\"text\" name=\"aftername\" value=\"$oaname\" size=20><p>\n";

		print "Include the number of messages sent?<br>\n";

		if ($usenum eq 'yes') {
			print "<input checked type=\"radio\" name=\"usenum\" value=\"yes\"> Yes\n";
			print "<input type=\"radio\" name=\"usenum\" value=\"no\"> No\n";
		} else {
			print "<input type=\"radio\" name=\"usenum\" value=\"yes\"> Yes\n";
			print "<input checked type=\"radio\" name=\"usenum\" value=\"no\"> No\n";
		}
		print "<p>\n";
		print "Include signature?<br>\n";

		if ($usesig eq 'yes') {
			print "<input checked type=\"radio\" name=\"usesig\" value=\"yes\"> Yes\n";
			print "<input type=\"radio\" name=\"usesig\" value=\"no\"> No\n";
		} else {
			print "<input type=\"radio\" name=\"usesig\" value=\"yes\"> Yes\n";
			print "<input checked type=\"radio\" name=\"usesig\" value=\"no\"> No\n";
		}
		print "<p>\n";
		print "Force Word Wrapping?<br>\n";

		if ($wrap eq 'yes') {
			print "<input checked type=\"radio\" name=\"wrap\" value=\"yes\"> Yes\n";
			print "<input type=\"radio\" name=\"wrap\" value=\"no\"> No\n";
		} else {
			print "<input type=\"radio\" name=\"wrap\" value=\"yes\"> Yes\n";
			print "<input checked type=\"radio\" name=\"wrap\" value=\"no\"> No\n";
		}
		print "<p>\n";
		print "If so, the line width should be: \n";
		print "<input type=\"text\" name=\"wrapwidth\" size=\"3\" value=\"$wrapwidth\"><p>\n";

		print "Body of the e-mail:<br>\n";

		print "<textarea name=\"body\" cols=\"60\" rows=\"10\" wrap=\"virtual\">\n";
		print "$obody\n";
		print "</textarea><p>\n";

		print "<input type=\"hidden\" name=\"pass\" value=\"$pass\">\n";
		print "<input type=\"hidden\" name=\"what\" value=\"makemail\">\n";

		print "<input type=\"submit\" value=\"Go\">\n";
		print "<input type=\"reset\" value=\"Reset\">\n";

		print "</form>\n";
		print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
		print "</center></font></body></html>\n";

	}
	else {
	# get ready to send message

		open (FILE, ">$maildir/sendme.txt") || &fatal_error("Can't open datafile.");

		if ($wrap eq 'yes') {
			$wrapwidth = 80 if ($wrapwidth <= 0);
			$wrapwidth++;
			@lines = split(/\n/,$obody);
			foreach $line (@lines) {
				@words = split(/ /,$line);
				$spaces = 0;
				$last = 0;
				for ($a = 0; $a < @words; $a++) {
					$spaces += length($words[$a]);
					$spaces++;
					if ($spaces > $wrapwidth && $a == $last) {
						print FILE "$words[$a]\n";
						$last++;
						$spaces = 0;
					}
					elsif ($spaces > $wrapwidth) {
						for ($b = $last; $b < $a; $b++) {
							print FILE "$words[$b] ";
						}
						print FILE "\n";
						$last = $a;
						$a--;
						$spaces = 0;
					}
				}
				for ($a = $last; $a < @words; $a++) {
					print FILE "$words[$a] ";
				}
				print FILE "\n" if ($last < @words-1);
			}
		} else {
			print FILE "$obody\n";
		}

		if ($usenum eq 'yes') {
			print FILE "\n";
			print FILE "This message was sent to $num people.\n";
		}

		if ($usesig eq 'yes') {
			print FILE "\n";
			for ($b = 0; $b < $numsig; $b ++) {
				print FILE "$osig[$b]";
			}
		}

		close (FILE);
		&actually_send_mail;
	}

}

sub confirm {

	open (FILE, "$maildir/pend.txt") || &fatal_error("Can't find pending additions data file.");
	@pend = <FILE>;
	close (FILE);

	$pendfound = 0;

	for ($a = 0; $a < @pend; $a++) {

		($getmail[$a],$getname[$a],$getlist[$a],$getcode[$a],$chop) = split(/``/,$pend[$a]);

		if ($getmail[$a] eq $who && $getcode[$a] eq $id) {
			$pendfound = 1;
			$idnumber = $a;
		}

	}

	&fatal_error("That e-mail or id code was not found in the pending additions data file.") if ($pendfound == 0);

	open (FILE, ">$maildir/pend.txt") || &fatal_error("Can't find pending additions data file.");
	&lock(FILE);

	for ($a = 0; $a < @pend; $a++) {

		print FILE "$getmail[$a]``$getname[$a]``$getlist[$a]``$getcode[$a]``xxx\n" unless ("\U$getmail[$a]" eq "\U$getmail[$idnumber]");

	}

	&unlock(FILE);
	close (FILE);

	open (FILE, ">>$maildir/$getlist[$idnumber]\.txt") || &fatal_error("Can't find $getlist[$a]\.txt");
	print FILE "$getmail[$idnumber]``$getname[$idnumber]``x\n";
	close (FILE);

	print "<html><head><title>Success!</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Addition Successful</font><p>\n";

	print "Your e-mail address is now on the mailing list. You will receive the next mailing.<p>\n";

	print "</html>\n";
	exit;

}

sub actually_send_mail {

	&fatal_error("Something has gone totally haywire with the temp file for sending mail.") unless (-e "$maildir/sendme.txt");
	open (FILE, "$maildir/sendme.txt") || &fatal_error("Can't file temp file for sending mail.");
	@sendthis = <FILE>;
	close(FILE);

	if ($action eq 'moremail') {

		$osubject = $INFO{'osubject'};
		$usename = $INFO{'usename'};
		$obname = $INFO{'obname'};
		$oaname = $INFO{'oaname'};
		$list = $INFO{'list'};
		$osubject =~ s/_/ /g;
		$osubject =~ s/%26/\&/g;
		$oaname =~ s/_/ /g;
		$oaname =~ s/%26/\&/g;
		$obname =~ s/_/ /g;
		$obname =~ s/%26/\&/g;
	} else {
		$startat = 0;
	}

	open (FILE, "$maildir/$list\.txt") || die "Can't open datafile\n";
	@info = <FILE>;
	close(FILE);
	$num = @info;

	$endat = $startat + $increment;
	$lastone = 0;
	if ($num < $endat) {
		$endat = $num;
		$lastone = 1;
	}

	for ($a = $startat; $a < $endat; $a++) {

		($recipient,$name,$nochop) = split(/``/,$info[$a]);

	        if ($recipient =~ /.*\@.*\..*/) {

			open (MAIL, "|$mailprog") || die "Can't open $mailprog!\n";
			print MAIL "To: $recipient\n";
			print MAIL "From: $yourname < $yourmail >\n";
			print MAIL "Subject: $osubject\n";
			if ($usename eq 'yes') {
				print MAIL "$obname$name$oaname\n\n";
			}

			print MAIL @sendthis, "\n";

			close (MAIL);

		}
	}

	print "<html><head><title> RobMail </title></head>\n";
	print "<body bgcolor=white text=black>\n\n";
	print "<font face=arial size=2>\n";
	print "<center>\n";

	if ($lastone == 0) {
		&transform;
		print "<b>RobMail</b> has sent $endat messages so far.<br>\n";
		print "<b>Don't press anything</b> and RobMail will deliver the rest of the mail.<br>\n";

		print "<script language=\"JavaScript\">\n";
		print "window.location='$cgi";
		print "$queryswitch";
		print 'action=moremail';
		print "\&startat=$endat\&osubject=$osubject\&usename=$usename\&obname=$obname\&oaname=$oaname\&list=$list";
		print "';\n";
		print "</script></center></font></body></html>\n\n";
	} else {
		print "<h3>Done Sending Mail</h3>\n";
		print "The message was sent to $num people.<p>\n";
		print "<a href=\"$mailurl\">RobMail Main</a><p>\n";
		print "</center></font></body></html>\n\n";
		unlink("$maildir/sendme.txt");
	}

	exit;

}

sub transform {

	$osubject =~ s/ /_/g;
	$osubject =~ s/\&/%26/g;
	$osubject =~ s/%/%25/g;
	$osubject =~ s/:/%3A/g;
	$osubject =~ s/;/%3B/g;
	$osubject =~ s/,/%2C/g;
	$osubject =~ s/\+/%2B/g;
	$osubject =~ s/'//g;

	$obname =~ s/ /_/g;
	$obname =~ s/\&/%26/g;
	$obname =~ s/%/%25/g;
	$obname =~ s/:/%3A/g;
	$obname =~ s/;/%3B/g;
	$obname =~ s/,/%2C/g;
	$obname =~ s/\+/%2B/g;
	$obname =~ s/'//g;

	$oaname =~ s/ /_/g;
	$oaname =~ s/\&/%26/g;
	$oaname =~ s/%/%25/g;
	$oaname =~ s/:/%3A/g;
	$oaname =~ s/;/%3B/g;
	$oaname =~ s/,/%2C/g;
	$oaname =~ s/\+/%2B/g;
	$oaname =~ s/'//g;
}

sub set_sig {

	open(FILE, "$maildir/sig.txt") || &fatal_error("Can't find sig file.");
	@sig = <FILE>;
	close(FILE);
	$numsig = @sig;

	print "<html><head><title>Change Signature</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Change Signature</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n";

	print "<textarea cols=60 rows=5 name=\"signature\">\n";
	for ($a = 0; $a < $numsig; $a ++) {
		print "$sig[$a]";
	}
	print "</textarea><br>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"changesig\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub change_sig {

	$signature = $FORM{'signature'};

	open(FILE, ">$maildir/sig.txt") || &fatal_error("Can't find signature file.");
	print FILE "$signature";
	close(FILE);

	print "<html><head><title>Signature Changed</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Signature Changed!</font><p>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub set_add_list {

	print "<html><head><title>Add a Mailing List</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Add a Mailing List</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n"; 

	print "Please enter the name of the new list:<br>\n";
	print "<input type=\"text\" name=\"newlist\" size=20><br>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"addlist\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub add_list {

	$newlist = $FORM{'newlist'};

	$newlist =~ s/ /_/g;
	$newlist =~ s/#//g;
	$newlist =~ s/\&//g;
	$newlist =~ s/\@//g;
	$newlist =~ s/\*//g;
	$newlist =~ s/\?//g;
	$newlist =~ s/\$//g;
	$newlist =~ s/%//g;
	$newlist =~ s/`//g;
	$newlist =~ s/~//g;
	$newlist =~ s/\|//g;
	$newlist =~ s/"//g;
	$newlist =~ s/'//g;
	$newlist =~ s/://g;
	$newlist =~ s/;//g;
	$newlist =~ s/\!//g;
	$newlist =~ s/\^//g;
	$newlist =~ s/\(//g;
	$newlist =~ s/\)//g;
	$newlist =~ s/\\//g;
	$newlist =~ s/\[//g;
	$newlist =~ s/\]//g;
	$newlist =~ s/\{//g;
	$newlist =~ s/\}//g;
	$newlist =~ s/\///g;
	$newlist =~ s/\.//g;
	$newlist =~ s/,//g;
	$newlist =~ s/\+//g;
	$newlist =~ s/\=//g;
	$newlist =~ s/\-//g;
	$newlist =~ s/\<//g;
	$newlist =~ s/\>//g;

	&fatal_error("You have entered an improper list name. Quit it with those uvlots and ampersands") if ($newlist eq '');

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	$found = 0;

	for ($a = 0; $a < $numlist; $a++) {
		($one, $nochop) = split(/``/, $list[$a]);
		if ($newlist eq $one) {
			$found = 1;
		}
	}		

	if ($found == 0) {
		open(FILE, ">$datafile") || &fatal_error("Can't open datafile");
		for ($a = 0; $a < $numlist; $a++) {
			($one, $nochop) = split(/``/, $list[$a]);
			print FILE "$one``xx\n";
		}
		print FILE "$newlist``xx";
		close(FILE);

		open(FILE, ">$maildir/$newlist\.txt") || &fatal_error("Can't open newlist.txt");
		print FILE "person1\@somewhere.com``Name 1``x\n";
		print FILE "person2\@somewhere.com``Name 2``x\n";
		close(FILE);
		
		print "<html><head><title>List Added</title></head>\n";
		print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
		print "<!--\n";
		print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
		print "eislerr\@tdi.uregina.ca\n";
		print "http://tdi.uregina.ca/~eislerr\n";
		print "-->\n\n";
		print "<font face=arial>\n";
		print "<center>\n";
		print "<font size=5>List '$newlist' Added</font><p>\n";
		print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</big></b>\n";
		print "</center></font></body></html>\n";

	}
	else {
		&fatal_error("A list with that name already exists!");
	}

	exit;

}

sub set_del_list {

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	if ($numlist <= 1) {
		&fatal_error("You can't delete the last list!");
	}

	print "<html><head><title>Delete a Mailing List</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Delete a Mailing List</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n";

	print "Delete which list?<br>\n";

	print "<select size=1 name=\"list\">\n";

	for ($a = 0; $a < $numlist; $a ++) {
		($one, $nochop) = split(/``/, $list[$a]);		
 		print "<option value=\"$one\">$one</option>\n";
	}

	print "</select>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"setdellist2\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub set_del_list2 {

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	if ($numlist <= 1) {
		&fatal_error("You can't delete the last list!");
	}

	$dellist = $FORM{'list'};

	print "<html><head><title>Delete List - Confirm</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Delete List - Confirm</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Are you sure you want to delete \"$dellist\"?<br>\n";

	print "<input type=\"hidden\" name=\"pass\" value=\"$pass\">\n";
	print "<input type=\"hidden\" name=\"list\" value=\"$dellist\">\n";
	print "<input type=\"hidden\" name=\"what\" value=\"dellist\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub del_list {

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	if ($numlist <= 1) {
		&fatal_error("You can't delete the last list");
	}

	$dellist = $FORM{'list'};

	open(FILE, ">$datafile") || &fatal_error("Can't open datafile");

	for ($a = 0; $a < $numlist; $a++) {
		($one, $nochop) = split(/``/, $list[$a]);		
		if ($dellist ne $one) {
			print FILE "$one``xx\n";
		}
	}

	close(FILE);

	open(FILE, ">$maildir/$dellist\.txt") || &fatal_error("Can't open datafile");
	print FILE " ";
	close(FILE);

	print "<html><head><title>List Deleted</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>List '$dellist' Deleted</font><p>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</big></b>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub set_list {

	open(FILE, "$datafile") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	print "<html><head><title>Edit a Mailing List</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Edit a Mailing List</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n";

	print "Edit which list?<br>\n";

	print "<select size=1 name=\"list\">\n";

	for ($a = 0; $a < $numlist; $a ++) {
		($one, $nochop) = split(/``/, $list[$a]);
		print "<option value=\"$one\">$one</option>\n";
	}

	print "</select>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"setlist2\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub set_list2 {

	$editlist = $FORM{'list'};

	open(FILE, "$maildir/$editlist\.txt") || &fatal_error("Can't find data file.");
	@list = <FILE>;
	close(FILE);
	$numlist = @list;

	print "<html><head><title>Edit a Mailing List</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Edit a Mailing List</font><p>\n";

	print "<form action=\"$cgi\" method=\"post\">\n";

	print "Password: <input type=\"password\" name=\"pass\" size=10><p>\n";

	print "<font size=2>Edit the mailing list below.  Enter each recipient, one per line, with their e-mail address first, followed by their name.  Separate each address and name by two hyphens --</font><br>\n";

	print "<textarea cols=60 rows=5 name=\"list\">\n";

	$ccc = 0;	
	for ($a = 0; $a < $numlist; $a ++) {
		($one, $two, $nochop) = split(/``/, $list[$a]);
		if ($one =~ /.*\@.*\..*/) {
			print "$one--$two\n";
			$ccc++;
		}
	}

	print "</textarea><br>\n";
	print "(Currently $ccc names on the list)<br>\n";
	print "<input type=\"hidden\" name=\"what\" value=\"changelist\">\n";
	print "<input type=\"hidden\" name=\"editlist\" value=\"$editlist\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub change_list {

	$list = $FORM{'list'};
	$editlist = $FORM{'editlist'};

	(@splitlist) = split(/\n/, $list);

	$numlist = @splitlist;

	open(FILE, ">$maildir/$editlist\.txt") || &fatal_error("Can't find data file.");

	for ($a = 0; $a < $numlist; $a++) {

		($one, $two) = split(/--/, $splitlist[$a]);
		$two =~ s/\cM//g;
		if ($one =~ /.*\@.*\..*/) {
			print FILE "$one``$two``x\n";
		} 
	}

	close(FILE);

	print "<html><head><title>Mailing List Changed</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>List '$editlist' Changed</font><p>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub set_pass {

	print "<html><head><title>Change Password</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";

	print "<font size=5>Change Password</font><p>\n";
	print "<form action=\"$cgi\" method=\"post\">\n";

	print "<table border=0>\n";
	print "<tr><td align=right><font face=arial>Old Password: </font></td>\n";
	print "<td align=left><input type=\"password\" name=\"pass\" size=10></td></tr>\n";
	print "<tr><td align=right><font face=arial>New Password: </font></td>\n";
	print "<td align=left><input type=\"password\" name=\"newpass1\" size=10></td></tr>\n";
	print "<tr><td align=right><font face=arial>Retype New Password: </font></td>\n";
	print "<td align=left><input type=\"password\" name=\"newpass2\" size=10></td></tr>\n";
	print "</table><p>\n";

	print "<input type=\"hidden\" name=\"what\" value=\"changepass\">\n";
	print "<input type=\"submit\" value=\"Go\">\n";
	print "</form>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub change_pass {

	$newpass1 = $FORM{'newpass1'};
	$newpass2 = $FORM{'newpass2'};

	if ($newpass1 ne $newpass2) {
		&fatal_error("The two new password fields don't match!");
	}
	$write_pass = crypt($newpass1, substr($p, 0, 2));

	open(FILE, ">$maildir/pwd.txt") || &fatal_error("Can't find password file.");
	print FILE "$write_pass``x";
	close(FILE);

	print "<html><head><title>Password Changed</title></head>\n";
	print "<body bgcolor=white link=blue vlink=blue text=black>\n\n";
	print "<!--\n";
	print "RobMail v2.04 Copyright 1998 by Rob Eisler\n";
	print "eislerr\@tdi.uregina.ca\n";
	print "http://tdi.uregina.ca/~eislerr\n";
	print "-->\n\n";
	print "<font face=arial>\n";
	print "<center>\n";
	print "<font size=5>Password Changed!</font><p>\n";
	print "<big><b>\&#183;</big></b> <a href=\"$mailurl\">RobMail Main</a> <big><b>\&#183;</b></big>\n";
	print "</center></font></body></html>\n";
	exit;

}

sub fatal_error {
	local($e) = @_;

	print "<html>\n";
	print "<head><title> RobMail Fatal Error </title></head>\n";
	print "<body bgcolor=white text=black link=blue vlink=blue>\n";
	print "<font face=arial><center>\n";
	print "<h2>RobMail Fatal Error</h2>\n";

	print "<blockquote>\n";
	print "RobMail experienced an unrecoverable error. The error seems\n";
	print "to be:<p>\n";

	print "<b>$e</b><p>\n\n";

	print "If this error continues, you should contact the administrator.<p>\n";

	print "<a href=\"$mailurl\">RobMail Main</a>\n";
	print "</blockquote>\n";
	print "</center>";
	print "</font></body></html>\n";
	exit;
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

	@vars = split(/&/, $ENV{QUERY_STRING});
	foreach $var (@vars) {
	        ($v,$i) = split(/=/, $var);
	        $v =~ tr/+/ /;
	        $v =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	        $i =~ tr/+/ /;
	        $i =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	        $i =~ s/<!--(.|\n)*-->//g;
	        $INFO{$v} = $i;
	}

	$action = $INFO{'action'};
	$startat = $INFO{'startat'};
	$who = $INFO{'who'};
	$id = $INFO{'id'};

}

sub lock {
  local($file)=@_;
  flock($file, $LOCK_EX);
}

sub unlock {
  local($file)=@_;
  flock($file, $LOCK_UN);
}

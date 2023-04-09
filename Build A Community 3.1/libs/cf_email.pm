##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################
sub send_forum_email {
	local($forum) = $_[0];
	local($thread) = $_[1];
	local($respondentname) = $_[2];
	local($post) = $_[3];

#	print "<BR>$forum<BR>\n$thread<BR>\n$respondentname<BR>\n$post";
	(@mposts) = split(/\|/, $thread);

	tie %mposts, "DB_File", $forumdb;

	$fn = "$GPath{'cforums_data'}/mod_email.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@EMAIL = <FILE>;
	close(FILE);

	($thisthread,$message_id,$name,$date,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $post);

	if ($emailmoderator eq "Yes") {
		&gosendmail($MOD_email,$forum,$thisthread,$subject,$date,$message,"$name");
	}

	$fn = "$GPath{'cforums_data'}/response_email.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@EMAIL = <FILE>;
	close(FILE);

	foreach $mpost (@mposts) {
		undef $filteron;
		undef $filterhow;
		undef $notifyhow;
		undef $emailonreponse;

		($thisthread,$message_id,$name,$date,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $mposts{$mpost});

		$subject =~ s/&quot;/"/g;

		$fn = $GPath{'userdirs'} . "/$filenum/myforums.txt";
		open (FILE, "$fn");
		@tcontent = <FILE>;
		close (FILE);
		chop @tcontent;
		($filteron, $filterhow, $notifyhow, $emailonreponse) = split(/&&/, $tcontent[0]);

#		print "$filenum: $filteron, $filterhow, $notifyhow, $emailonreponse<BR>\n";

		if (($emailonreponse eq "FIRST") && ($mposts[$#mposts] eq $mpost)) {
			&gosendmail($email,$forum,$thisthread,$subject,$date,$message,$respondentname);
		}
		if ($emailonreponse eq "ALL") {
			&gosendmail($email,$forum,$thisthread,$subject,$date,$message,$respondentname);
		}
	}
}

sub gosendmail {
	local ($email,$forum,$thisthread,$subject,$date,$message,$respondentname,$mod) = @_;


	if ($email !~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $email =~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
		if ($sentto{$email} eq "") {
			open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
			  print MAIL "To: $email\n";
			  print MAIL "From: $CONFIG{'email'}\n";
			  print MAIL "Subject: There has been a reponse to your post!\n\n";
			  foreach $line(@EMAIL) {
				$line =~ s/\[FORUM\]/$IFORUM{'title'}/g;
				$line =~ s/\[URL\]/$CONFIG{'COMMUNITY_full_cgi'}\/cforum.cgi?action=message&clubs=$FORM{'clubs'}&forum=$forum&thread=$thisthread/g;
				$line =~ s/\[SUBJECT\]/$subject/g;
				$line =~ s/\[DATE\]/$date/g;
				$line =~ s/\[MESSAGE\]/&WordWrap($message)/g;
				$line =~ s/\[NAME\]/$respondentname/g;
				print MAIL "$line";
			  }
		  	  print MAIL "\n\n\n";
		      close(MAIL);
			$sentto{$email}++;
		}
	}
}


1;

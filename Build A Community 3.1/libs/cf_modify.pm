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
sub unhidethisthread {
	$status = &unhide_thread($FORM{'message'});
	if ($status eq "COOL") {
		print "Location: $GUrl{'cforum.cgi'}?clubs=$FORM{'clubs'}&forum=$forum&thread=$FORM{'thread'}&action=message\n\n";
	}
	else {
		$error = $status;
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";

		&print_output('error');
		exit 0;
	}
}


sub edit_subject {
	$COLOR = "$CONFIG{'bbs_table2'}";
 	$FONTCOLOR = "$CONFIG{'text_color'}";
  	$TABLECOLOR = "$CONFIG{'bbs_table2'}";
 	$color_num = 1;

  	tie my %threads, "DB_File", $threadsdb;
	tie my %posts, "DB_File", $forumdb;

	(@threadposts) = split(/\|/, $threads{$FORM{'thread'}});   #get a list of posts in each thread

	%post = &readpost($posts{$threadposts[0]});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/editsubject.tmplt");
	$OUT = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/editsubject.tmplt";
}



sub edit_post {
	require $GPath{'cf_logs.pm'};
	&log_visit($FORM{'forum'});

	open (REPLACEMENTS, "$GPath{'cforums_data'}/replacements.dat");
	@REPLACEMENTS = <REPLACEMENTS>;
	close (REPLACEMENTS);

	$COLOR = "$CONFIG{'bbs_table2'}";
 	$FONTCOLOR = "$CONFIG{'text_color'}";
  	$TABLECOLOR = "$CONFIG{'bbs_table2'}";
 	$color_num = 1;

	tie my %posts, "DB_File", $forumdb;

	%post = &readpost($posts{$FORM{'message'}});

	$post{'message'} =~ s/<BR>/\n/ig;

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/editpost.tmplt");
	$OUT = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/editpost.tmplt";
}



sub hidethisthread {
	$status = &hide_thread($FORM{'message'});
	if ($status eq "COOL") {
		print "Location: $GUrl{'cforum.cgi'}?clubs=$FORM{'clubs'}&forum=$forum&thread=$FORM{'thread'}&action=message\n\n";
	}
	else {
		$error = $status;
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";

		&print_output('error');
		exit 0;
	}
}

sub closethisthread {
	$status = &close_thread($FORM{'thread'});
	if ($status eq "COOL") {
		print "Location: $GUrl{'cforum.cgi'}?clubs=$FORM{'clubs'}&forum=$forum&thread=$FORM{'thread'}&action=message\n\n";
	}
	else {
		$error = $status;
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";

		&print_output('error');
		exit 0;
	}
}


sub openthisthread {
	$status = &open_thread($FORM{'thread'});
	if ($status eq "COOL") {
		print "Location: $GUrl{'cforum.cgi'}?clubs=$FORM{'clubs'}&forum=$forum&thread=$FORM{'thread'}&action=message\n\n";
	}
	else {
		$error = $status;
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";

		&print_output('error');
		exit 0;
	}
}

sub save_subject {
	$status = &changethreadsubject($FORM{'thread'},$FORM{'subject'});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/savesubject.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/savesubject.tmplt";

	&print_output('cforums');
	exit 0;
}



sub godelete_i_thread {
	$status = &godeletethread($FORM{'thread'});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/threaddeleted.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/threaddeleted.tmplt";

	&print_output('cforums');
	exit 0;
}


sub delete_i_post {
	$status = &delete_message($FORM{'message_id'});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/delete_i_post.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/delete_i_post.tmplt";

	&print_output('cforums');
	exit 0;
}


sub confirm_delete {
	local($restrictedto) = $_[0];

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/confirmdelete.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/confirmdelete.tmplt";

	&print_output('cforums');
}


sub resubject_message {
	my($threadmatch,$newsubject) = @_;

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {

		tie my %pdata, "DB_File", $forumdb;

		($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $pdata{$threadmatch});

		if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
		else {
			require $GPath{'cf_errors.pm'};
			&approval_denied;
		}

		

		if(! &lock("$forum")) {
			&ERROR("Server Busy.  Please try again");
			exit 0;
		}
	
		$POST  = "$thisthread|";
		$POST .= "$message_id|";
		$POST .= "$name|";
		$POST .= "$modified|";
		$POST .= "$email|";
		$POST .= "$url|";
		$POST .= "$attachment|";
		$POST .= "$date|";
		$POST .= "$pdate|";
		$POST .= "$newsubject|";
		$POST .= "$username|";
		$POST .= "$icon|";
		$POST .= "$filenum|";
		$POST .= "$moderator|";
		$POST .= "T|";
		$POST .= "HIDDEN|";
		$POST .= "$suspended|";
		$POST .= "$picon|";
		$POST .= "$t2|";
		$POST .= "$t3|";
		$POST .= "$t4|";
		$POST .= "$t5|";
		$POST .= "$t6|";
	
		$posting = $message;

		$BR = "<BR>";
		# Remove the ^M from the entry....
		$posting =~ s/\cM//g;
		$posting =~ s/\|//g;
		$posting =~ s/\n/$BR/g;

		$POST .= "$posting";

		$pdata{$threadmatch} = "$POST";
		untie %pdata; 
		&unlock("$forum");

		$STATUS = "The subject was changed.";
	}
	else {
		$STATUS = "Access Denied, you are not a forum moderator";
	}

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $threadmatch, $POST);
	}

	return $STATUS;
}

sub suspend_message {
	local($onoff) = $_[0];

#	print "Content-type: text/html\n\n";

	tie my %pdata, "DB_File", $forumdb;

	($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $pdata{$FORM{'message_id'}});

	if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
	else {
		require $GPath{'cf_errors.pm'};
		&approval_denied;
	}

	

	if(! &lock("$forum")) {
		&ERROR("Server Busy.  Please try again");
		exit 0;
	}
	
	$POST  = "$thisthread|";
	$POST .= "$message_id|";
	$POST .= "$name|";
	$POST .= "$modified|";
	$POST .= "$email|";
	$POST .= "$url|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$subject|";
	$POST .= "$username|";
	$POST .= "$icon|";
	$POST .= "$filenum|";
	$POST .= "$moderator|";
	$POST .= "T|";
	$POST .= "HIDDEN|";
	$POST .= "$onoff|";
	$POST .= "$picon|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";

	$POST .= "$message";

	$data{$FORM{'message_id'}} = "$POST";
	untie %pdata; 

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $FORM{'message_id'}, $POST);
	}

	&unlock("$forum");

	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?clubs=$FORM{'clubs'}&forum=$forum&thread=$thisthread&action=message\n\n";
}



sub publish_message {
#	print "Content-type: text/html\n\n";
	$| = 1;

	tie my %pdata, "DB_File", $forumdb;

	($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $pdata{$FORM{'message_id'}});

	if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
	else {
		require $GPath{'cf_errors.pm'};
		&approval_denied;
	}

	

	if(! &lock("$forum")) {
		&ERROR("Server Busy.  Please try again");
           	exit 0;
	}
	
	$POST  = "$thisthread|";
	$POST .= "$message_id|";
	$POST .= "$name|";
	$POST .= "$modified|";
	$POST .= "$email|";
	$POST .= "$url|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$subject|";
	$POST .= "$username|";
	$POST .= "$icon|";
	$POST .= "$filenum|";
	$POST .= "$moderator|";
	$POST .= "T|";
	$POST .= "HIDDEN|";
	$POST .= "$suspended|";
	$POST .= "$picon|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";

	$POST .= $message;

	$pdata{$FORM{'message_id'}} = "$POST";
	untie %pdata; 
	&unlock("$forum");

	tie my %tdata, "DB_File", $threadsdb;
	$threadcontents = $data{$thisthread};

	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?clubs=$FORM{'clubs'}&forum=$forum&thread=$thisthread&action=message\n\n";

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $FORM{'message_id'}, $POST);
	}

	require $GPath{'cf_email.pm'};
	&send_forum_email($forum, $threadcontents, $name, $FORM{'message_id'});
}




sub save_edited_message {
#	print "Content-type: text/html\n\n";

	tie my %pdata, "DB_File", $forumdb;

	($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $pdata{$FORM{'message_id'}});

	if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
	else {
		require $GPath{'cf_errors.pm'};
		&modification_denied;
	}

	&remove_key_listing($message_id);

	$modified = time;
	if ($IFORUM{'bbs_admin'} eq $IUSER{'filenum'}) {
		$modified = "&&moderator";
	}
	else {
		$modified = "&&owner";
	}

	$FORM{'message'} = $FORM{'edit_message'};

	if(! &lock("$forum")) {
		&ERROR("Server Busy.  Please try again");
		exit 0;
	}
	
	$POST  = "$thisthread|";
	$POST .= "$message_id|";
	$POST .= "$name|";
	$POST .= "$modified|";
	$POST .= "$email|";
	$POST .= "$url|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$subject|";
	$POST .= "$username|";
	$POST .= "$icon|";
	$POST .= "$filenum|";
	$POST .= "$moderator|";
	$POST .= "$approved|";
	$POST .= "HIDDEN|";
	$POST .= "$suspended|";
	$POST .= "$picon|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";


   	$posting = &Remove_HTML_Tags($FORM{'message'});

	$BR = "<BR>";
	# Remove the ^M from the entry....
	$posting =~ s/\cM//g;
	$posting =~ s/\|//g;
	$posting =~ s/\n/$BR/g;

	$POST .= "$posting";

	$pdata{$FORM{'message_id'}} = "$POST";
	untie %pdata; 
	&unlock("$forum");

	&lock("keywords");

	if ($CONFIG{'CFORUM_usekeys'} ne "NO") {
		$keywords = $FORM{'message'};
		$keywords =~ s/\cM//g;
		$keywords =~ s/\|/ /g;
		$keywords =~ s/\n/ /g;
		$keywords =~ s/[^\w ]//g;
		(@mykeyword) = split(/ +/, $keywords);
 
		foreach $myword(@mykeyword) {
			if ($Ignore !~ /$myword/i) {
				$myword =~ lc($myword);
				$mykeys{$myword}++;
			}
		}

		tie my %kdata, "DB_File", $keywordsdb;
		foreach $myword(keys %mykeys) {
			$kdata{$myword} .= "$forum&&$message_id&&$thisthread&&$mykeys{$myword}|";
		}
		untie %kdata; 
		&unlock("keywords");
	}

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $FORM{'message_id'}, $POST);
	}

	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?clubs=$FORM{'clubs'}&forum=$forum&thread=$thisthread&action=message\n\n";
}

sub unhide_thread {
	my ($tpost) = $_[0];
#	print "Content-type: text/html\n\n";

	tie my %data, "DB_File", $forumdb;

	($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $data{$tpost});

	if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
	else {
		require $GPath{'cf_errors.pm'};
		&modification_denied;
	}


	if(! &lock("$forum")) {
		&ERROR("Server Busy.  Please try again");
		exit 0;
	}
	
	$POST  = "$thisthread|";
	$POST .= "$message_id|";
	$POST .= "$name|";
	$POST .= "$modified|";
	$POST .= "$email|";
	$POST .= "$url|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$subject|";
	$POST .= "$username|";
	$POST .= "$icon|";
	$POST .= "$filenum|";
	$POST .= "$moderator|";
	$POST .= "$approved|";
	$POST .= "F|";
	$POST .= "$suspended|";
	$POST .= "$picon|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";

	$POST .= "$message";
	$data{$tpost} = "$POST";
	untie %data; 

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $tpost, $POST);
	}

	&unlock("$forum");
	return "COOL";
}

sub hide_thread {
	my ($tpost) = $_[0];
#	print "Content-type: text/html\n\n";

	tie my %data, "DB_File", $forumdb;

	($thisthread,$message_id,$name,$modified,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $data{$tpost});

	if (($IUSER{'filenum'} eq $filenum) || (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))  {}
	else {
		require $GPath{'cf_errors.pm'};
		&modification_denied;
	}


	if(! &lock("$forum")) {
		&ERROR("Server Busy.  Please try again");
		exit 0;
	}
	
	$POST  = "$thisthread|";
	$POST .= "$message_id|";
	$POST .= "$name|";
	$POST .= "$modified|";
	$POST .= "$email|";
	$POST .= "$url|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$subject|";
	$POST .= "$username|";
	$POST .= "$icon|";
	$POST .= "$filenum|";
	$POST .= "$moderator|";
	$POST .= "$approved|";
	$POST .= "T|";
	$POST .= "$suspended|";
	$POST .= "$picon|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";

	$POST .= "$message";
	$data{$tpost} = "$POST";
	untie %data; 

	if ($CONFIG{'CFORUMCreateBackup'} eq "YES") {
		&cfbackup($FORM{'forum'}, $thisthread, $tpost, $POST);
	}

	&unlock("$forum");
	return "COOL";
}

sub close_thread {
	my ($thread) = $_[0];

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		tie my %thrstatdb, "DB_File", $thread_status;
		$thrstatdb{$thread} = "CLOSED";
		untie %thrstatdb; 
		$STATUS = "COOL";
	}
	else {
		$STATUS = "Access Denied, you are not a forum moderator";
	}
	return $STATUS;
}

sub open_thread {
	my ($thread) = $_[0];

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		tie my %thrstatdb, "DB_File", $thread_status;
		$thrstatdb{$thread} = "OPEN";
		untie %thrstatdb; 
		$STATUS = "COOL";
	}
	else {
		$STATUS = "Access Denied, you are not a forum moderator";
	}
	return $STATUS;
}


sub remove_thread {
	my ($id) = $_[0];
	my ($keywords, @mykeyword, $myword, $mykeys, @items, $forum, $next_id, $match, @matches, $thisthread);

	tie my %threadsdb, "DB_File", $threadsdb;
	delete $threadsdb{$id};
	untie %threadsdb; 
}


sub remove_thread_listing {
	my ($id) = $_[0];
	my ($keywords, @mykeyword, $myword, $mykeys, @items, $forum, $next_id, $match, @matches, $thisthread);

	&lock("$forum");

	tie my %threadsdb, "DB_File", $threadsdb;
	foreach $myword(keys %threadsdb) {
		@matches = split(/\|/, $threadsdb{$myword});
		delete $threadsdb{$myword};
		foreach $match (@matches) {
			if ($match ne $id) {
				$threadsdb{$myword} .= "$match|";
			}
			else {
				$returnthread = $myword;
			}
		}
	}
	untie %threadsdb; 

	&unlock("$forum");
	return $returnthread;
}


sub remove_post_listing {
	my ($id) = $_[0];
	my ($keywords, @mykeyword, $myword, $mykeys, @items, $forum, $next_id, $match, @matches, $thisthread);

	&lock("$forum");

	tie my %postsdb, "DB_File", $forumdb;
	delete $postsdb{$id};
	untie %postsdb; 

	&unlock("$forum");

}


sub remove_key_listing {
	my ($id) = $_[0];
	my ($keywords, @mykeyword, $myword, $mykeys, @items, $forum, $next_id, $match, @matches, $thisthread);

	&lock("keywords");

	tie my %keysdb, "DB_File", $keywordsdb;
	foreach $myword(keys %keysdb) {
		@matches = split(/\|/, $keysdb{$myword});
		delete $keysdb{$myword};
		foreach $match (@matches) {
			@items = split(/&&/, $match);
			if (@items[1] ne $id) {
				$keysdb{$myword} .= "$match|";
			}
		}
	}
	untie %keysdb; 

	&unlock("keywords");

}


sub remove_author_listing {
	my ($id) = $_[0];
	my ($keywords, @mykeyword, $myword, $mykeys, @items, $forum, $next_id, $match, @matches, $thisthread);

	&lock("authors");

	tie my %authordb, "DB_File", $authorsdb;
	foreach $myword(keys %authordb) {
		@matches = split(/\|/, $authordb{$myword});
		delete $authordb{$myword};
		foreach $match (@matches) {
			@items = split(/&&/, $match);
			if (@items[1] ne $id) {
				$authordb{$myword} .= "$match|";
			}
		}
	}
	untie %authordb; 

	&unlock("authors");
}

sub changethreadsubject {
	my ($thread) = $_[0];
	my ($subject) = $_[1];

	tie my %mythreadsdb, "DB_File", $threadsdb;
	$thisthread = $mythreadsdb{$thread};
	@threadmatches = split(/\|/, $thisthread);
	foreach $threadmatch (@threadmatches) {
		$STATUS = &resubject_message($threadmatch,$subject);
	}
	return $STATUS;
}


sub godeletethread {
	my ($thread) = $_[0];

	tie my %mythreadsdb, "DB_File", $threadsdb;
	$thisthread = $mythreadsdb{$thread};

	@threadmatches = split(/\|/, $thisthread);
	foreach $threadmatch (@threadmatches) {
		$STATUS = &delete_message($threadmatch);
	}
	return $STATUS;
}

sub delete_message {
	my ($id) = $_[0];

	my $thread = undef;

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		&remove_post_listing($id);
		$thread = &remove_thread_listing($id);
		&remove_author_listing($id);
		&remove_key_listing($id);
		$STATUS = "The selected message was deleted";
	}
	else {
		$STATUS = "Access Denied, you are not a forum moderator";
	}
	&cfdeletebackup($FORM{'forum'}, $thread, $id);

	return $STATUS;
}




sub PostMessage {
#	print "Content-type: text/html\n\n";

	if ($FORM{'subject'} !~ /\w/) {
		require $GPath{'cf_errors.pm'};
		&subject_required;
	}
	if ($Post_In_Forums eq "NO") {
		require $GPath{'cf_errors.pm'};
		&posting_denied;
	}

	$| = 1;

	if ($FORM{'action'} eq "post_reply") {
		$thisthread = $FORM{'curr_thread'};
	}
	else {
		$thisthread = time . "," . $$;
	}

	$rn = time;

	$pdate = time;
	&parse_date($pdate);
	$date = $long_date;


	$next_id = time . "," . $$;

	if ($FORM{'do_spellcheck'}) {
		require $GPath{'cf_errors.pm'};
		if ( &Spelling_Errors($FORM{'message'}, "$GPath{'dictionary'}") ) { 
			&spelling_error($Spelling_Error_Message); 
			exit 0;
		}
	}
	if ($IUSER{'handle'} ne "") {
		$rname = $IUSER{'handle'};
	}
	else {
		$rname = $IUSER{'realname'};
	}

	if ($rname !~ /\w/) {
		require $GPath{'cf_errors.pm'};
		&bad_name;
	}

	$FORM{'subject'} =~ s/"/&quot;/g;

	$POST  = "$thisthread|";
	$POST .= "$next_id|";
	$POST .= "$rname|";
	$POST .= "$modified|";
	$POST .= "$IUSER{'email'}|";
	$POST .= "$GUrl{'moreinfo.cgi'}?UserName=$IUSER{'username'}|";
	$POST .= "$attachment|";
	$POST .= "$date|";
	$POST .= "$pdate|";
	$POST .= "$FORM{'subject'}|";
	$POST .= "$IUSER{'username'}|";
	$POST .= "$IUSER{'icon'}|";
	$POST .= "$IUSER{'filenum'}|";
	if ($IFORUM{'bbs_admin'} eq $IUSER{'filenum'}) {
		$POST .= "T|";
	}
	else {
		$POST .= "F|";
	}
	if ($moderated eq "Yes") {
		$approved = "F";
	}

	$POST .= "$approved|";
	
	$POST .= "$hidden|";
	$POST .= "$suspended|";
	$POST .= "$FORM{'picon'}|";
	$POST .= "$t2|";
	$POST .= "$t3|";
	$POST .= "$t4|";
	$POST .= "$t5|";
	$POST .= "$t6|";

   	$posting = &Remove_HTML_Tags($FORM{'message'});

	$BR = "<BR>";
	# Remove the ^M from the entry....
	$posting =~ s/\cM//g;
	$posting =~ s/\|//g;
	$posting =~ s/\n/$BR/g;

	$POST .= "$posting";

	&lock("$forum");

	tie my %tdata, "DB_File", $threadsdb;
	$threadcontents = $tdata{$thisthread};
	$tdata{$thisthread} .= "$next_id|";
	untie %tdata; 

	tie my %pdata, "DB_File", $forumdb;
	$pdata{$next_id} = "$POST";
	untie %pdata; 

	&unlock("$forum");

	&lock("authors");

	tie my %adata, "DB_File", $authorsdb;
	$adata{$IUSER{'filenum'}} .= "$forum&&$next_id&&$thisthread|";
	untie %adata; 

	&unlock("authors");

	&lock("activity");

	tie my %xdata, "DB_File", $postactivitydb;
	$xdata{$IUSER{'username'}} = "$rn&&$forum&&$next_id&&$thisthread";
	untie %xdata; 

	&unlock("activity");


	if (($CONFIG{'CFORUM_usekeys'} ne "NO") && (! -e "clubs.cgi")) {
		$keywords = $FORM{'message'};
		$keywords =~ s/\cM//g;
		$keywords =~ s/\|/ /g;
		$keywords =~ s/\n/ /g;
		$keywords =~ s/[^\w ]//g;
		(@mykeyword) = split(/ +/, $keywords);
 
		&lock("keywords");

		foreach $myword(@mykeyword) {
			if ($Ignore !~ /$myword/i) {
				$myword = lc($myword);
				$mykeys{$myword}++;
			}
		}
		tie my %kdata, "DB_File", $keywordsdb;
		foreach $myword(keys %mykeys) {
			$kdata{$myword} .= "$forum&&$next_id&&$thisthread&&$mykeys{$myword}|";
		}
		untie %kdata; 
	}

	&unlock("keywords");


	require $GPath{'cf_logs.pm'};

	&log_post($FORM{'forum'});

	&clean_logs;


	if ($CONFIG{'CFORUMCreateBackup'} ne "NO") {
		&cfbackup($FORM{'forum'}, $thisthread, $next_id, $POST);
	}


	$subject =~ s/&quot;/"/g;

#	print "About to send mail!\n";
	if (($FORM{'action'} eq "post_reply") && ($IFORUM{'moderated'} ne "Yes")) {
#		print "reply, sending to previous\n";
		require $GPath{'cf_email.pm'};
		&send_forum_email($forum, $threadcontents, $rname, $next_id);
	}
	if ($IFORUM{'emailmoderator'} eq "YES") {
#		print "sending to moderator\n";
		$fn = "$GPath{'cforums_data'}/mod_email.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@EMAIL = <FILE>;
		close(FILE);

		require $GPath{'cf_email.pm'};
#		print "<B>$MOD{'username'}||$MOD{'email'},$forum,$thisthread,$subject,$date,$FORM{'message'},$IUSER{'realname'})</B>\n";
		&gosendmail($MOD{'email'},$forum,$thisthread,$FORM{'subject'},$date,$FORM{'message'},$IUSER{'realname'});
	}
#	print "DONE!!!\n";


	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?clubs=$FORM{'clubs'}&forum=$forum&thread=$thisthread&action=message\n";
	&basic_cookie;
	print "\n";

}

sub cfdeletebackup {
	my ($forum, $threadid, $postid) = @_;

	my $fn = $CONFIG{'CFORUMBackupDirectory'} . "/" . $forum . "/" . $threadid . "/" . $postid . "\.txt";
	unlink $fn;

	$fn = $CONFIG{'CFORUMBackupDirectory'} . "/" . $forum . "/" . $threadid . "/";

	my $found = undef;
    	opendir(FILES, "$fn") || die ERROR("Can't open directory: $fn");
    	while($file = readdir(FILES)) {
        	if($file =~ /.*\.txt/) {
			$found++;
			last;
		}
	}

	if (! $found) {
		rmdir($fn);
	}
}

sub cfbackup {
	my ($forum, $threadid, $postid, $postcontents) = @_;

#	print "$forum, $threadid, $postid, $postcontents<P>\n";

	my $dn = $CONFIG{'CFORUMBackupDirectory'};

	if (! -d $dn) {  # Check to see if it exists
		mkdir($dn, 0777) || &diehtml("I can't create $dn");
	}

	$dn .= "/" . $forum;
	if (! -d $dn) {  # Check to see if it exists
		mkdir($dn, 0777) || &diehtml("I can't create $dn");;
	}

	$dn .= "/" . $threadid;
	if (! -d $dn) {  # Check to see if it exists
		mkdir($dn, 0777) || &diehtml("I can't create $dn");;
	}

	open (DIR, ">$dn/$postid\.txt") || &diehtml("I can't create $dn/$postid\.txt");;
	print DIR $postcontents;
	close (DIR);
}

	
1;

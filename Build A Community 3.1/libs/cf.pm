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

$rn = time;

sub readpost {
	my $line = $_[0];

	my @return = split(/\|/,$line);

	my %post = (
		thisthread     => $return[0],
		message_id     => $return[1],
		name           => $return[2],
		modified       => $return[3],
		email          => $return[4],
		url            => $return[5],
		attachment     => $return[6],
		date           => $return[7],
		pdate          => $return[8],
		subject        => $return[9],
		username       => $return[10],
		icon           => $return[11],
		filenum        => $return[12],
		moderator      => $return[13],
		approved       => $return[14],
		hidden         => $return[15],
		suspended      => $return[16],
		picon          => $return[17],
		t2             => $return[18],
		t3             => $return[19],
		t4             => $return[20],
		t5             => $return[21],
		t6             => $return[22],
		message        => $return[23],
	);

	return %post;
}

sub readbbs {
	my $bbs_cfg = $_[0];
	my $overide_globals = $_[1];

	my %IFORUM = undef;

	open(CFG, "$bbs_cfg");
	my @bbscfg = <CFG>;
	close(CFG);

	my $tmp_config = $bbscfg[0];
	$tmp_config =~ s/(\n|\cM)//g;
	my @config = split (/\|/, $tmp_config);

	$IFORUM{'title'} = $config[0]; 
	$IFORUM{'bbs_admin'} = $config[7];
	$IFORUM{'access'} = $config[8];
     	$IFORUM{'restrictedto'} = $config[9];
	$IFORUM{'group'} = $config[10];
	$IFORUM{'newthreads'} = $config[11];
     	$IFORUM{'moderated'} = $config[12];
	$IFORUM{'emailmoderator'} = $config[13];
	$IFORUM{'moderator_edit'} = $config[14];
	if ($overide_globals) {
		$CONFIG{'bbs_table1'} = $config[15] || $CONFIG{'bbs_table1'};
		$CONFIG{'bbs_table2'} = $config[16] || $CONFIG{'bbs_table2'};
		$CONFIG{'highlightcolor'} = $config[17] || $CONFIG{'highlightcolor'};
		$CONFIG{'topic_color'} = $config[18] || $CONFIG{'topic_color'};
		$CONFIG{'pg_color'} = $config[1] || $CONFIG{'pg_color'}; 
		$CONFIG{'win_color'} = $config[2] || $CONFIG{'win_color'}; 
		$CONFIG{'font_face'} = $config[3] || $CONFIG{'font_face'}; 
		$CONFIG{'text_color'} = $config[4] || $CONFIG{'text_color'}; 
		$CONFIG{'title_color'} = $config[5] || $CONFIG{'title_color'}; 
		$CONFIG{'ttxt_color'} = $config[6] || $CONFIG{'ttxt_color'}; 
		$CONFIG{'CLUB_max_kb'} = $config[23] || $CONFIG{'CLUB_max_kb'};
		$CONFIG{'CLUB_max_images'} = $config[24] || $CONFIG{'CLUB_max_images'};
	}
	$IFORUM{'public'} = $config[19];
	$IFORUM{'status'} = $config[20];
	$IFORUM{'applicantmessage'} = $config[21];
	$IFORUM{'clubforum'} = $config[22];
     	$IFORUM{'bbs_private_pw'} = $config[26];
	$IFORUM{'bbs_desc'} = $bbscfg[1];

	return %IFORUM;
}

sub get_moderator {
	my $admin = $_[0];

	my %MOD = undef;
	if (($admin ne "") && (-e "$GPath{'userpath'}/$admin\.usrdat")) {
		%MOD = &open_user($admin, "NO");
		if ($MOD{'handle'} ne "") {
			$MOD{'name'} = $MOD{'handle'};
		}
		else {
			$MOD{'name'} = $MOD{'realname'};
		}
	}
	else {
		$MOD{'name'} = "Admin";
		$MOD{'email'} = $CONFIG{'email'};
	}

	return %MOD;
}



sub reply_form {
	tie my %posts, "DB_File", $forumdb;

	$message = "";
	if ($thissubject eq "") {
		($thisthread,$message_id,$name,$date,$email,$url,$attachment,$date,$pdate,$subject,$username,$icon,$filenum,$moderator,$approved,$hidden,$suspended,$picon,$t2,$t3,$t4,$t5,$t6,$message) = split(/\|/, $posts{$FORM{'message_id'}});
		$subject_line = "$subject\n<input NAME=\"subject\" TYPE=\"hidden\" VALUE=\"$subject\">\n";
	}
	else {
		$subject_line = "$thissubject\n<input NAME=\"subject\" TYPE=\"hidden\" VALUE=\"$thissubject\">\n";
	}
	$title_message = "Post Your Reply";
	$this_action = "post_reply";
	$message = &do_parses($message);
	$quoted_text = "$message";
	$thread = $FORM{'thread'};
	&new_message;
}


sub new_form {
	$subject_line = "<input NAME=\"subject\" TYPE=\"text\" LENGTH=30 MAXLENGTH=38>\n";
	$title_message = "Post A New Message";
	$this_action = "post_new";
	$quoted_text = "";
	$current_thread = "";
	&new_message;
}




sub new_message {   
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/newmessage.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/newmessage.tmplt";
}



sub do_parses {
	local ($thismessage) = $_[0];
	$_ = $thismessage;

	if ($_ =~ /\[/) {
		s/\[email\]([^\[]+)\[\/email\]/<A HREF=\"mailto:$1\">$1<\/A>/ig;
		s/\[url\]([^\[]+)\[\/url\]/<A HREF=\"$1\" TARGET=NEW>$1<\/A>/ig;
		s/\[image\]([^\[]+)\[\/image\]/<IMG SRC=\"$1\">/ig;
		s/\[link\]([^\[]+)\[\/link\]/<A HREF=\"$1\">$1<\/A>/ig;
		s/\[img\]([^\[]+)\[\/img\]/<IMG SRC=\"$1\">/ig;
		$openquote = s/\[quote\]/<BLOCKQUOTE>/ig;
		$closequote = s/\[\/quote\]/<\/BLOCKQUOTE>/ig;
		$opencode = s/\[code\]/<FONT FACE=courier><BLOCKQUOTE><PRE>/ig;
		$closecode = s/\[\/code\]/<\/PRE><\/BLOCKQUOTE><\/FONT>/ig;
		$openfont = s/\[blue\]/<font color=\"blue\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$openfont = s/\[red\]/<font color=\"red\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$openfont = s/\[green\]/<font color=\"green\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$openfont = s/\[yellow\]/<font color=\"yellow\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$openfont = s/\[white\]/<font color=\"white\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$openfont = s/\[black\]/<font color=\"black\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">/ig;
		$closefont = s/(\[\/blue\]|\[\/red\]|\[\/yellow\]|\[\/white\]|\[\/white\]|\[\/green\])/<\/FONT>/ig;
		$openbold = s/(\[bold\]|\[b\])/<B>/ig;
		$closebold = s/(\[\/bold\]|\[\/b\])/<\/B>/ig;
		$openitalics = s/(\[italics\]|\[i\]|\[italic\])/<I>/mig;
		$closeitalics = s/(\[\/italics\]|\[\/i\]|\[\/italic\])/<\/I>/mig;

		if ($_ =~ /\[POLL\](.*)<BR>1:/i) {
			s/\[POLL\](.*)<BR>1:/\[POLL\]\n<BR>1:/i;
			$Psubject = $1;
			$POLL_flag = "T";
			s/\[POLL\]/<TABLE border><form METHOD=\"POST\" ACTION=\"$CONFIG{'CGI_DIR'}\/forumpoll.cgi\" ENCTYPE=\"x-www-form-urlencoded\">\n<INPUT TYPE=hidden NAME=poll VALUE=$ipost{'message_id'}>\n<TR><TD COLSPAN=2><font color=\"$CONFIG{'text_color'}\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\"><B>$Psubject<\/B><\/TD><\/TR>\n/ig;
			s/\[\/POLL\]/<TR><TD COLSPAN=2><font color=\"$CONFIG{'text_color'}\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\"><FONT SIZE=-2><CENTER><INPUT TYPE=submit NAME=action VALUE=\"Vote!\"><INPUT TYPE=submit NAME=action VALUE=\"View Results!\"><\/TD><\/TR><\/TABLE><\/FORM>/ig;
			s/<BR>(\d):([\w ]*)/<TR><TD><font color=\"$CONFIG{'text_color'}\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\"><INPUT TYPE=radio NAME=item VALUE=\"$2\"><\/TD><TD><font color=\"$CONFIG{'text_color'}\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"$CONFIG{'font_size'}\">$2<\/TD><\/TR>/ig;
		}

		if ($POLL_flag eq "T") {
			$_ .= "</FORM>";
		}

		if ($openfont != $closefont) {
			$dif = $openfont - $closefont;
			for $x(1..$dif) {
				$_ .= "</FONT>";
			}
		}

		if ($openquote != $closequote) {
			$dif = $openquote - $closequote;
			for $x(1..$dif) {
				$_ .= "</BLOCKQUOTE>";
			}
		}
		if ($opencode != $closecode) {
			$dif = $opencode - $closecode;
			for $x(1..$dif) {
				$_ .= "</PRE></BLOCKQUOTE>";
			}
		}

		if ($openbold != $closebold) {
			$dif = $openbold - $closebold;
			for $x(1..$dif) {
				$_ .= "</B>";
			}
		}

		if ($openitalics != $closeitalics) {
			$dif = $openitalics - $closeitalics;
			for $x(1..$dif) {
				$_ .= "</I>";
			}
		}
	}

	foreach $r (@REPLACEMENTS) {
		($or,$rp) = split(/\|\|/, $r);
		if ($or ne "") {
			s/$or/$rp/g;
		}
	}
	return $_;
}


sub parse_date {
   local ($time) = $_[0];
   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$year = $year + 1900;

   if ($sec < 10) {
      $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   if ($mon < 10) {
      $mon = "0$mon";
   }
   if ($mday < 10) {
      $mday = "0$mday";
   }

   @weekday = ("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
   @months = ("January","February","March","April","May","June","July","August","September","October","November","December");

   #$year = $year + 1900;
   $date = "$weekday[$wday] $mday $months[$mon], $year";

   chop($date) if ($date =~ /\n$/);

   $long_date = "$months[$mon] $mday, $year at $hour\:$min\:$sec";
}



sub get_personal_settings {
	$fn = $GPath{'userdirs'} . "/$IUSER{'filenum'}/myforums.txt";
	open (FILE, "$fn");
	@tcontent = <FILE>;
	close (FILE);
	chop @tcontent;

	($filteron, $filterhow, $notifyhow, $emailonreponse, $daystoshow, $threadstoshow) = split(/&&/, $tcontent[0]);
	$filteredusers = $tcontent[1];
	$filteredwords = $tcontent[2];
	$highlightedposts = $tcontent[3];
	$notifywords = $tcontent[4];
	$myforums = $tcontent[5];

	if ($daystoshow eq "") { $daystoshow = $CONFIG{'daystoshow'};}
	if ($threadstoshow eq "") { $daystoshow = $CONFIG{'threadstoshow'};}

	$fn = $GPath{'userdirs'} . "/$IUSER{'filenum'}/forumvisits.txt";
	open (FILE, "$fn");
	@visits = <FILE>;
	close (FILE);

	if (-e "$fn") {
		open (FILE, ">$fn");
		foreach $l (@visits) {
			$l =~ s/(\n|\cM)//g;
			@t = split(/\|/, $l);
			my $tf = $FORM{'forum'} || $FORM{'club'};
			$ilastvisit{$t[0]} = $t[1];
			if ($t[0] eq $tf) {
				$LAST_VISIT = $t[1];
				$FOUND = "T";
				print FILE "$tf\|$rn\n";
			}
			else {
				print FILE "$l\n";
			}
		}
		close (FILE);
	}
	else {
		my $tf = $FORM{'forum'} || $FORM{'club'};
		open (FILE, ">$fn");
		print FILE "$tf\|$rn\n";
		close (FILE);
	}
	if ($FOUND ne "T") {
		open (FILE, ">>$fn");
		print FILE "$FORM{'forum'}\|$rn\n";
		close (FILE);
	}
	chmod("$fn", 0777);
}


sub save_settings {
	$fn = $GPath{'userdirs'} . "/$IUSER{'filenum'}/myforums.txt";
	open (FILE, ">$fn") || &diehtml("Can't write to $fn");
	print FILE "$filteron&&$filterhow&&$notifyhow&&$emailonreponse&&$daystoshow&&$threadstoshow\n";
	print FILE "$filteredusers\n";
	print FILE "$filteredwords\n";
	print FILE "$highlightedposts\n";
	print FILE "$notifywords\n";
	print FILE "$myforums\n";
	close (FILE);
}


1;

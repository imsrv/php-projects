#!/usr/local/bin/perl

require 'setup35.cgi';

$max_list = 20;

$font = '';

($body = $header) =~ s/.*(<body.*?>).*/$1/i;
($banner = $header) =~ s/.*(<img.*?>).*/$1/i;

sub get_form_data {
	read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
	if ($ENV{'QUERY_STRING'}) {
		$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
	}
	@pairs = split(/&/,$buffer);
	foreach $pair (@pairs) {
		($name,$value) = split(/=/,$pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
		$FORM{$name} = $value
	}
}

&read_form_files;

%PROFILE = (%SUBJECT, %OBJECT, %INTERESTS);

get_form_data;

if($FORM{'ID'} ne '') {
	$FORM{'password'} = &get_pass($FORM{'ID'});
}

unless(exists($FORM{'mode'})) {
	print "Content-type: text/html\n\n";
	print "<html>\n";
	print "<head>\n";
	print "    <title>e_Match Search</title>\n";
	print "</head>\n";
	print "<FRAMESET ROWS=25%,*>\n";
	print " <FRAME SRC=\"$ENV{'SCRIPT_NAME'}?mode=1&nickname=$FORM{'nickname'}&ID=$FORM{'ID'}\">\n";
	print "<FRAMESET COLS=30%,*>\n";
	print " <FRAME SRC=\"$ENV{'SCRIPT_NAME'}?mode=2&nickname=$FORM{'nickname'}&ID=$FORM{'ID'}\">\n";
	print " <FRAME SRC=\"$ENV{'SCRIPT_NAME'}?mode=3&nickname=$FORM{'nickname'}&ID=$FORM{'ID'}\" name=profiles>\n";
	print "</frameset>\n";
	print "<noframes>\n";
	print "    <body>\n";
	print "        No-frames page.\n";
	print "    </body>\n";
	print "</noframes>\n";
	print "</frameset>\n";
	print "</html>\n";

exit;

}

if($FORM{'mode'} eq '1') {

print "Content-type: text/html\n\n";
print "<HTML>\n";
print "<HEAD>\n";
print "<TITLE>Header</TITLE>\n";
print "</head>$body\n";
print "\n";
print "<table width=\"100%\"><tr><td valign=bottom><H1>${font}<I>e_Match Quick Search</I></font></H1></td><td align=center>$banner</td></tr></table><hr>\n";
print "${font}Use this form to manually add interesting people to your matchlist. Click <a href=\"index35.cgi?nickname=$FORM{'nickname'}&ID=$FORM{'ID'}\" target=\"_parent\">HERE</a> to return to your Main Menu.</font>\n" if $FORM{'ID'} ne '';
print "</BODY>\n";
print "</HTML>\n";

exit;

}

if($FORM{'mode'} eq '3') {

print <<INSTR;
Content-type: text/html

<HTML>
<HEAD>
<TITLE></TITLE>
$body
<H3>${font}Instructions</font></H3><hr>
${font}<b>Fill out and submit the form at left, then click on a Nickname to view their profile. <p>Or if you already know the member's Nickname, use the form below.</b></font>
<form action="$ENV{'SCRIPT_NAME'}" method=POST>
Nickname:<input type=text name=match>
<input type=hidden name=mode value=profile>
<input type=hidden name=ID value=$FORM{'ID'}>
<input type=hidden name=nickname value=$FORM{'nickname'}>
<input type=submit value="Find Profile!"><input type=reset>
</form>
$footer
</BODY>
</HTML>
INSTR

exit;

}

if($FORM{'mode'} eq '2') {
	open(FORM,"$form_path/searchform.txt") || &return_page('System Error', "Can't read searchform.txt.(47)\n");
	@lines = <FORM>;
	close(FORM);
	chomp(@lines);

	print "Content-type: text/html\n\n";

	foreach $line (@lines) {
		if($line =~ /\*\w+\*/) {
			$line =~ s/\*URL\*/$ENV{'SCRIPT_NAME'}/;
			$line =~ s/\*body\*/$body/;
			$line =~ s/\*ID\*/$FORM{'ID'}/;
			$line =~ s/\*nickname\*/$FORM{'nickname'}/;
			$line =~ s/\*font\*/$font/;
			if($line =~ /\*(\w\d{2,3})\*/) {
				$item = $1;
				($text, $type, @selections) = split(/\t/, $PROFILE{$item});
				$text .= "$font: </font>";
				$text = '' if $item =~ /(a|b)01/;
				print "$text<SELECT NAME=\"$item\">\n";
				print "<OPTION>---\n";
				foreach $selection (@selections) {
					print "<OPTION>$selection\n";
				}
				print "</SELECT>\n";
				next;
			}
		}
		print "$line\n";
	}
}

if($FORM{'mode'} eq 'submit') {

	@raw_list = &listdir("$datapath", 'subdir');
	
	foreach $dir (@raw_list) {

		next if $dir !~ /^\w$/;
		next unless (-e "$datapath/$dir/profiles.txt");
		open(PROFILES,"<$datapath/$dir/profiles.txt") || &return_page('System Error', "Can't access profiles.txt(1).\n");
		seek(PROFILES, 0, 0);

		@lines = <PROFILES>;
		chomp(@lines);

		close(PROFILES);

	srand;

		USER:foreach $profile (@lines) {
			next if index($profile, "Password:\t$FORM{'password'}") != -1 and $FORM{'password'};

			# compare and generate good list
			foreach $key (sort(keys(%FORM))) {
				next if $key !~ /(a|b)\d\d\d?/;
				next if $FORM{$key} eq '---';
				$string = "$key\t$FORM{$key}";
				next USER if index($profile, $string) == -1;
			}
			($nickname = $profile) =~ s/^.+?\|Nickname:\t\b(.+?)\b\|.+?$/$1/;
			
			if(rand() < 0.5) {
				push(@list, $nickname);
			}else {
				unshift(@list, $nickname);
			}
		}
	}

	@list = @list[0..--$max_list] if $#list >= $max_list;

	print "Content-type: text/html\n\n";

	print "<html><head><title>\n";
	print "Search Results";
	print "</title></head>$body\n";
	print "<h3 align=center>Search Results\</h3><hr>\n";
	print "<table border align=center>\n";

	($ematch_url = $ENV{'SCRIPT_NAME'}) =~ s/search/index/;

	print "<tr><td align=CENTER>Sorry, no matches were found.  Select diferent search parameters, and try again.</td></tr><hr>" unless @list;

	foreach $item (@list) {
		($esc_match_name = $item) =~ s/([^\w])/sprintf("%%%02x", ord($1))/ge;
		print "<tr><td>${font}Nickname:<A HREF=\"$ENV{'SCRIPT_NAME'}?nickname=$FORM{'nickname'}&ID=$FORM{'ID'}&mode=profile&match=$esc_match_name\" target=profiles> $item</A></font>\n";
		print "<img src=\"$main_url/html/photo.gif\">" if (-e "$html_path/pics/$item.gif") or (-e "$html_path/pics/$item.jpg");
		print "</td></tr>\n";
	}
	print "</table>\n";
	print "<CENTER><a href=\"$ENV{'SCRIPT_NAME'}?nickname=$FORM{'nickname'}&ID=$FORM{'ID'}&mode=2\">[Back to Form]</a></CENTER>\n";

	&print_footer;
}

#################################################
#################################################
# View Match Profile Routine

if($FORM{'mode'} eq 'profile') {
	&get_password_list;
	$match_password = $users{$FORM{'match'}};
	unless($match_password) {&return_page("Nickname not found", "The nickname:<p><b>$FORM{'match'}</b><p> is not on our member's list. Please use your browser's [Back] Button to return to the form.")}
	&view_profile($match_password);
	exit;
}

#################################################
# View Profile Routine

sub view_profile {

	# get user's current matches
	
	$user_path = &get_user_path($FORM{'password'});
	
	if($FORM{'ID'} ne '') {
		open(MATCHES,"<$datapath/$user_path/matches.txt") || &return_page('System Error', "Can't access matches.txt(1).\n");
		seek(MATCHES, 0, 0);

		@matches = <MATCHES>;
		chomp(@matches);

		close(MATCHES);
	}
	
	local($password) = @_;
	&get_profile("$password");
	$profile_nick = $PROFILE_ITEMS{'Nickname:'};
	print "Content-type: text/html\n\n";
	$header =~ s/<img.+?>//i;
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><I><CENTER>Profile for $profile_nick</CENTER></I></h1>";
	print "<table align=center class=linkbar width=\"90%\"><tr><td align=center>\n";
	if(grep(/^$profile_nick\t/, @matches)) {
		print "<b class=light> This user is already on your Matchlist</b>\n";
	}else {
		print "<a class=light href=$ENV{'SCRIPT_NAME'}?match=$profile_nick&nickname=$FORM{'nickname'}&ID=$FORM{'ID'}&mode=add>[Add $profile_nick To Matchlist]</a>\n" if $FORM{'ID'} ne '';
	}
	print "</td></tr></table>\n";
	&print_pic($profile_nick);
	&get_profile_html;
	print "</table><table class=linkbar align=center width=\"90%\"><tr><td align=center>\n";
	if(grep(/^$profile_nick\t/, @matches)) {
		print "<b class=light> This user is already on your Matchlist</b>\n";
	}else {
		print "<a class=light href=$ENV{'SCRIPT_NAME'}?match=$profile_nick&nickname=$FORM{'nickname'}&ID=$FORM{'ID'}&mode=add>[Add $profile_nick To Matchlist]</a>\n" if $FORM{'ID'} ne '';
	}
	print "</td></tr></table><p>\n";
	print "</td></tr></table><p>\n" if $pic eq 'yes';;
	print "$footer</body></html>";
	exit;
}

#################################################
# Add Match to List, etc.

if($FORM{'mode'} eq 'add') {
	$match_nick = $FORM{'match'};
	$user_pass = $FORM{'password'};
	$user_nick = $FORM{'nickname'};

	&get_password_list;
	$user_path = &get_user_path("$FORM{'password'}");
	if (-e "$datapath/$user_path/nuked.txt") {
		open(CHECK,"$datapath/$user_path/nuked.txt") || &return_page("System Error", "Can't open nuked file for $user_nick\n");
		@nuke_list = <CHECK>;
		close(CHECK);
		chomp(@nuke_list);
		&return_page("Listing not allowed", "User is nuked.") if (grep (/\b$match_nick\b/, @nuke_list));
	}

	$user_path = &get_user_path("$users{$match_nick}");
	if (-e "$datapath/$user_path/nuked.txt") {
		open(CHECK,"$datapath/$user_path/nuked.txt") || &return_page("System Error", "Can't open nuked file for $match_nick\n");
		@nuke_list = <CHECK>;
		close(CHECK);
		chomp(@nuke_list);
		&return_page("Listing not allowed", "$match_nick has nuked you.") if (grep (/\b$user_nick\b/, @nuke_list));
	}

	#############################################
	# create board if needed

	&get_file_names("$user_pass", "$users{$match_nick}");
	unless(-e "$datapath/$board_datafile") {
		open(BOARD,">$datapath/$board_datafile") || &return_page("System Error", "Can't write to $board_datafile.(1200)\n");
		flock BOARD, 2 if $lockon eq 'yes';
		seek (BOARD, 0, 0);
		@nicknames = ("$user_nick", "$match_nick");
		@nicknames = sort(@nicknames);
		print BOARD "0\n";
		print BOARD "$nicknames[0]\n";
		print BOARD "0\n";
		print BOARD "$nicknames[1]\n";
		print BOARD "0\n";
		close(BOARD);
	}

	#############################################
	# store match in user's matchlist

	$user_path = &get_user_path($user_pass);
	unless( -e "$datapath/$user_path/matches.txt") {
		open(MATCHES,">$datapath/$user_path/matches.txt") || &return_page("System Error", "Can't open Matches File for $FORM{'password'}.\n");
		flock MATCHES, 2 if $lockon eq 'yes';
		seek (MATCHES, 0, 0);
		print MATCHES "";
		close(MATCHES);
	}

	open(MATCHLIST,"$datapath/$user_path/matches.txt") || &return_page('System Error', "Can't read matches.txt.(324)\n");
	@lines = <MATCHLIST>;
	close(MATCHLIST);
	chomp(@lines);

	%MATCHES = ();
	foreach $line (@lines) {
		($match, $score) = split(/\t/, $line);
		$MATCHES{$match} = $score;
	}

	$MATCHES{$match_nick} = 1000000000;

	open(MATCHES,">$datapath/$user_path/matches.txt") || &return_page("System Error", "Can't open Matches File for $user_nick.\n");
	flock MATCHES, 2 if $lockon eq 'yes';
	seek (MATCHES, 0, 0);
	foreach $key (keys(%MATCHES)) {
		print MATCHES "$key\t$MATCHES{$key}\n";
	}
	close(MATCHES);

	$match_pass = $users{$match_nick};
	$match_path = &get_user_path("$match_pass");
	if(-e "$datapath/$match_path/matches.txt") {
		open(MATCH,"$datapath/$match_path/matches.txt") ||	&return_page("System Error", "Can't read from matches.txt for $match_nick.\n");

		@match_matches = <MATCH>;
		close(MATCH);
		chomp(@match_matches);

		%MM = ();
		for $mm (@match_matches) {
		  ($mmname, $mmscore) = split (/\t/, $mm);
		  $MM{$mmname} = $mmscore;
		}

		$MM{$user_nick} = 1000000000;

		open(MATCH,">$datapath/$match_path/matches.txt") || &return_page("System Error", "Can't write to matches.txt for $match_nick.\n");

		foreach $key (keys(%MM)) {
			print MATCH "$key\t$MM{$key}\n";
		}

 		close(MATCH);

	}else {
		mkdir("$datapath/$match_path", 0777) unless(-e "$datapath/$match_path");

		open(MATCH,">>$datapath/$match_path/matches.txt") || &return_page("System Error", "Can't append to matches.txt for $match_nick.(1070)\n");
		flock MATCH, 2 if $lockon eq 'yes';
		seek (MATCH, 0, 2);
		print MATCH "$FORM{'nickname'}\t1000000000\n";
		close(MATCH);
	}
	&return_page("Match List Updated", "$match_nick has been temporarily added to your matchlist. To make the addition permanent, post a message to their board.<p>If you're done checking profiles, click <a href=\"./index35.cgi?nickname=$FORM{'nickname'}&ID=$FORM{'ID'}\" target=\"_parent\">HERE</a> to return to your Main Menu");

}

#################################################
#################################################
# get profile data subroutine

sub get_profile {
	my($pword) = shift(@_);
	$pword = &get_user_path($pword);
	if(-e "$datapath/$pword/profile.txt") {
		unless(open (PROFILE, "$datapath/$pword/profile.txt")) {
			&return_page("System Error", "Can't read $datapath/$pword/profile.txt");
			exit;
		}
		@lines = <PROFILE>;
		close(PROFILE);
		chomp(@lines);
	}else {
		@lines = ();
	}

	%PROFILE_ITEMS = ();
	for $profile_line (@lines) {
		($key, $value) = split (/\t/, $profile_line, 2);
		$PROFILE_ITEMS{$key} = $value;
	}
}

#################################################
# get user path
#

sub get_user_path {
	$sub_path = shift(@_);
	$sub_init = substr($sub_path, 0, 1);
	$path_sum = "$sub_init/$sub_path";
	return ($path_sum);
}

#################################################
# print picture

sub print_pic {
	my($nick) = shift;
	@binaries = &listdir("$html_path/pics",'binary');
	for $file (@binaries) {
		$nick =~ s/\W+//g;
		next if $file !~ /$nick\./;
		print "<table border=0 width=\"100%\"><tr><td class=imagebg width=\"15%\" valign=top>\n";
		print "<img src=\"$main_url/pics/$file\" width=150 valign=top align=left>";
		print "</td><td><p>\n";
		print "<table>\n";
		$pic = 'yes';
	}
}

#################################################
# Generate profile data as HTML subroutine

sub get_profile_html {

	&read_form_files;

	for $item (sort(keys(%PROFILE_ITEMS))) {
		if ($item =~ /^\w+00\b/) {
			if(defined($match_password)) {

			####################################
			####################################
			# profile text substitutions

				$PROFILE_ITEMS{$item} =~ s/(.*\b)you're(\b.*)/$1$profile_nick is $2/;
				$PROFILE_ITEMS{$item} =~ s/(.*\b)you(\b.*)/$1$profile_nick$2/;
				$PROFILE_ITEMS{$item} =~ s/(^Favorite.*)/$profile_nick\'s $1/;

			####################################
			####################################

			}
			print "</table><p align=center><b>$PROFILE_ITEMS{$item}\:</b><br><table class=profile width=\"90%\" align=center border>\n";
		}elsif ($item =~ /^i/) {
			@user_items = split (/\t/, $PROFILE_ITEMS{$item});
			$rating = &get_rank($user_items[1]);
			print "<tr><td align=right width=\"45%\"><FONT COLOR=\"$colors{$rating}\"><b>$INTERESTS{$item}</b></FONT></td><td width=\"55%\"> <FONT COLOR=\"$colors{$rating}\"> - rating: <b>$rating</b></FONT><br></td></tr>\n";
		}elsif($item =~ /^b/) {
			@template_items = split (/\t/, $OBJECT{$item});
			@user_items = split (/\t/, $PROFILE_ITEMS{$item});
			$rating = &get_rank($user_items[1]);
			print "<tr><td align=right><FONT COLOR=\"$colors{$rating}\">$template_items[0]: </FONT></td><td><FONT COLOR=\"$colors{$rating}\"><b>$user_items[0]</b></FONT></td><td><FONT COLOR=\"$colors{$rating}\"> - rating: <b>$rating</b></FONT><br></tr></td>\n";
		}elsif($item =~ /^a/) {
			@template_items = split (/\t/, $SUBJECT{$item});
			if($item =~ /^a99/) {
				print "</table><p align=center><b>$template_items[0]\:</b><br><table class=profile width=\"90%\" align=center border>\n";
				print "<tr><td align=center><B>$PROFILE_ITEMS{$item}</B><br></td></tr></table>\n";
			}else {
				print "<tr><td align=right width=\"50%\">$template_items[0]:</td><td width=\"50%\"> <b>$PROFILE_ITEMS{$item}</b><br></td></tr>\n";
			}
		}elsif($item =~ /Password/) {
			next;
		}elsif($item =~ /Nickname/) {
			next;
		}elsif($item =~ /Comment/) {
			$PROFILE_ITEMS{$item} =~ s/\*p\*/<p>/g;
			$PROFILE_ITEMS{$item} =~ s/\*br\*/<br>/g;
			if ($profile_nick) {
				print "</table><p align=center><b>$profile_nick\'s Comment:</b><br><table class=profile align=center width=\"90%\"><tr><td align=center>$PROFILE_ITEMS{$item}</td></tr></table>\n";
			}else {
				print "</table><p align=center><b>Comment:</b><br><table class=profile align=center width=\"90%\"><tr><td align=center>$PROFILE_ITEMS{$item}</td></tr></table>\n";
			}
		}
	}
}

#################################################
sub read_form_files {

	@form_files = &listdir("$form_path", "ascii");

	@subject_form_files = ();
	@object_form_files = ();
	@interests_form_files = ();

	foreach $form_file (@form_files) {
		if($form_file =~ /subject/) {
			push(@subject_form_files, $form_file);
		}elsif($form_file =~ /object/) {
			push(@object_form_files, $form_file);
		}elsif($form_file =~ /interests/) {
			push(@interests_form_files, $form_file);
		}
	}

	foreach $subject_file (@subject_form_files) {
		open (SUBJECT, "$form_path/$subject_file") || &system_error("Can't open to $subject_file");

		@subjectlist = <SUBJECT>;
		close(SUBJECT);
		chomp @subjectlist;
		for (@subjectlist) {
			($name, $value) = split (/\t/, $_, 2);
			$SUBJECT{$name} = $value;
		}
	}

	foreach $object_file (@object_form_files) {
		open (OBJECT, "$form_path/$object_file") || &system_error("Can't open to $object_file");

		@objectlist = <OBJECT>;
		close(OBJECT);
		chomp @objectlist;
		for (@objectlist) {
			($name, $value) = split (/\t/, $_, 2);
			$OBJECT{$name} = $value;
		}
	}

	foreach $interests_file (@interests_form_files) {
		open (INTERESTS, "$form_path/$interests_file") || &system_error("Can't open to $interests_file");

		@interestlist = <INTERESTS>;
		close(INTERESTS);
		chomp @interestlist;
		for (@interestlist) {
			($name, $value) = split (/\t/, $_);
			$INTERESTS{$name} = $value;
		}
	}
	}
#################################################
# get rank subroutine
#
# given rank value, returns rank name

sub get_rank {
	my($value) = shift(@_);
	for $key (keys(%ranks)) {
		if ($ranks{$key} == $value) {
			return ($key);
		}
	}
}

#################################################
# listdir

sub listdir {
	my ($dirpath, $type) = @_;
	opendir(DIR, "$dirpath");
	@raw = sort grep(!/^\./, readdir(DIR));
	closedir(DIR);
	@file_list = ();
	for $item(@raw) {
		next if $item =~ /^\.\.?$/;
		if((-d "$dirpath/$item") and ($type eq 'subdir')) {
			push(@file_list, $item);
			next;
		}
		if($type ne 'all') {
			next if(-T "$dirpath/$item") and $type ne 'ascii';
			next if(-B "$dirpath/$item") and $type ne 'binary';
		}
		push(@file_list, $item);
	}
        return(@file_list);
}

#################################################
# get file names
#
# given two passwords,
# returns board name ($board_messagefile),
# and data file name($board_datafile).

sub get_file_names {
	@names = @_;
	$name_path = &get_user_path("$names[0]");
	if(-e "$datapath/$name_path/$names[1].data") {
		$board_messagefile = "$name_path/$names[1]";
	}else {
		$name_path = &get_user_path("$names[1]");
		$board_messagefile = "$name_path/$names[0]";
	}
	$board_datafile = "$board_messagefile\.data";
}

#################################################
# Get Password List Routine
#
# generates @password_list,
# %users,
# and %addresses
# from log.

sub get_password_list {
	my($nickname, $password, $email);
	@password_list = ();
	open(USERDATA,"$logpath/$log") || &return_page("System error", "Can't read log.\n");
	@userdata = <USERDATA>;
	close(USERDATA);
	chomp(@userdata);
	%users = ();
	%addresses = ();
	for $line (@userdata) {
		next unless ($line);
		($nickname, $password, $email) = split(/\t/, $line);
		$users{$nickname} = $password;
		$addresses{$nickname} = $email;
		push (@password_list, $password);
	}
}
#################################################
# Return HTML

sub return_page {
	my($heading, $message) = @_;
	&print_header($heading);
	print "$font$message</font>";
	&print_footer;
	exit;
}

sub print_header {
	local($title) = @_;
	print "Content-type: text/html\n\n";
	print "<HTML><HEAD>\n";
	print "<TITLE>$font$title</font></TITLE>\n";
	print "</HEAD>$body\n";
	print "<H1>$font$title</font></H1><hr>\n";
}

sub print_footer {
	print "</BODY></HTML>\n";
}

sub get_pass {

	#given ID, returns password

	my($ID) = @_;
	my($line, @lines);
	open(IDS,"$logpath/id.txt") || &return_page('System Error', "Can't read.(2400)\n");
	@lines = <IDS>;
	close(IDS);
	chomp(@lines);

	foreach $line (@lines) {
		($this_ID, $this_password) = split(/\t/, $line);
		return ($this_password) if $this_ID eq $ID;
	}
	&return_page("ID not found.", "Your ID was not found.  Return to <a href=$ENV{'SCRIPT_NAME'}>HERE</a> to log on. :$FORM{'ID'}");
}

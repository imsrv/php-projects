#!/usr/bin/perl
#################################################
# index.cgi - e_Match v3.5
#
# This script runs a complete match-making and
# private board system on your site.
# This script by Mike Bagneski - copyright 1999.
# Do not redistribute.
#
#################################################
require "email-lib.pl";
require "setup35.cgi";
require "free_filter.cgi";
require 'helphtml.cgi';
#################################################
# Get form data

read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
if ($ENV{'QUERY_STRING'}) {
	$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
}
@pairs = split(/&/,$buffer);
foreach $pair (@pairs) {
	($name,$value) = split(/=/,$pair);
	$value =~ tr/+/ /;
	$value =~ s/%0a//gi;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
	$value =~ s/([;<>\*\|\`\$#\[\]\{\}:"])/\\$1/g;
	$value =~ s/\r//g;
	$FORM{$name} = $value
}
$esc_nick = $FORM{'nickname'};
$esc_nick =~ s/([^\w])/sprintf("%%%02x", ord($1))/ge;

$FORM{'message'} =~ s/\n//g if(exists($FORM{'message'}));

if(exists($FORM{'ID'})) {
	$FORM{'password'} = &get_pass("$FORM{'ID'}");
}

if(exists($FORM{'xComment'})) {
	$FORM{'xComment'} =~ s/\*p\*/\n\n/g;
	$FORM{'xComment'} =~ s/\*br\*/\n/g;
}

#################################################
# Mode checks

	##start changes##
	##start changes##


$mode = $FORM{'mode'};

&log_out($FORM{'ID'}) if $mode eq 'logout';
&upload if $mode eq 'upload';
&mainhelp if $mode eq 'mainhelp';
&formhelp if $mode eq 'formhelp';
&register_form if $mode eq 'registerform';
&register($FORM{'name'}, $FORM{'email'}) if $mode eq 'register';
&view_profile("$FORM{'password'}") if $mode eq 'view';
&generate_profile_form if $mode eq 'redo';
&generate_profile_form if $mode eq 'next' or $mode eq 'last';
&check_profile if $mode eq 'profile';
&transfer_profile if $mode eq 'save';
&password_form if $mode eq 'newpass';
&nuke_check if $mode eq 'nukecheck';

&get_password_list;

&gateway($FORM{'nickname'}, $FORM{'password'}) if $mode eq 'logon';
&view_match if $mode eq 'viewmatch';
&view_board if $mode eq 'viewboard';
&erase_board if $mode eq 'erase';
&preview if $mode eq 'preview';
&post if $mode eq 'post';
&match if $mode eq 'match' or $mode eq 'rematch' or $mode eq 'save';
&change_password if $mode eq 'submitnewpass';
&nuke if $mode eq 'nuke';
$user_path = &get_user_path($FORM{'password'});
&main_menu if exists($FORM{'password'}) and (-e "$datapath/$user_path/matches\.txt");
&match if exists($FORM{'password'}) and (-e "$datapath/$user_path/profile\.txt");
&generate_profile_form if exists($FORM{'password'});
&logon;
exit;

#################################################
#################################################
# Routines


#################################################
#################################################
# transfer profile


sub transfer_profile {
	$user_path = &get_user_path($FORM{'password'});
	open(PROFILE,"$datapath/$user_path/profile.new") || &system_error("Can't read profile.new.(249)\n");
	@lines = <PROFILE>;
	close(PROFILE);
	chomp(@lines);

	%profile = ();

	foreach $line (@lines) {
		next if $line eq '';
		($key, $value) = split(/\t/, $line, 2);
		$profile{$key} = $value;
	}
	
	$profile_line = "Password:\t$FORM{'password'}|";

	open(PROFILE,">$datapath/$user_path/profile.txt") || &system_error("Can't write to profile.txt.(263)\n");
	flock PROFILE, 2 if $lockon eq 'yes';
	seek (PROFILE, 0, 0);
	$nickname = $profile{'Nickname:'};
	print PROFILE "Nickname:\t$nickname\n";
	$profile_line .= "Nickname:\t$nickname|";
	delete $profile{'Nickname:'};
	print PROFILE "Email:\t$profile{'Email:'}\n";
	$profile_line .="Email:\t$profile{'Email:'}|";
	delete $profile{'Email:'};
	foreach $key (sort(keys(%profile))) {
		print PROFILE "$key\t$profile{$key}\n";
		$profile_line .="$key\t$profile{$key}|";
	}
	close(PROFILE);
	#unlink("$datapath/$user_path/profile.new");
	
	$pass_init = substr($FORM{'password'}, 0 ,1);
	
	open(PROFILES,"+>>$datapath/$pass_init/profiles.txt") || &return_page('System Error', "Can't write to profiles.txt.(128)\n");
	flock PROFILES, 2 if $lockon eq 'yes';
	seek (PROFILES, 0, 0);
	@lines = <PROFILES>;
	chomp(@lines);
	
	seek (PROFILES, 0, 0);
	truncate (PROFILES, 0);
	
	if(grep(/Nickname:\t$nickname\b/, @lines)) {
		foreach $line (@lines) {
			if(index($line, "Nickname:\t$nickname") == -1) {
				print PROFILES "$line\n";
			}else {
				print PROFILES "$profile_line\n";
			}
		}
	}else {
		foreach $line (@lines) {
			print PROFILES "$line\n";
		}
		print PROFILES "$profile_line\n";
	}
	
	close(PROFILES);
}

##end changes##
##end changes##

#################################################
#################################################
# upload routine

sub upload {

    print "Content-type: text/html\n\n";
    print "<html><head><title>Upload Your picture</title>$header\n";
    print "<h1 align=center><i><center>Upload a picture for your profile.</center></i></h1><hr>\n";
    print "<ul>\n";
    print "<li>To <b>add</b> a picture, use the [Browse] button to find the file on
    your computer,
    then click [Upload].\n";
    print "<li>To <b>replace</b> your picture, simply upload a new one.\n";
    print "<li>To <b>delete</b> your picture, click the [Upload] button without selecting a
    file.</ul><p>\n";
    print "<b>NOTE:You can only upload gif and jpg files.</b><P>\n";
	$cgiurl = $ENV{'SCRIPT_NAME'};
	
	##start changes##
	##start changes##
	
	$cgiurl =~ s/index\d\d\./upload\./;
	
	($nick = $FORM{'nickname'}) =~ s/\W+//g;
    print "<form ENCTYPE=\"multipart/form-data\" method=post action=\"$cgiurl?$nick&$FORM{'ID'}\">\n";
    print "<B>File Name:</B><input type=file name=\"uploaded_file\"><br><input type=submit value=\"Upload\">\n";
    print "</FORM><P>\n";
    print "$footer\n";

	exit;

}
#################################################
#################################################
# Send Register Form Routine

sub register_form {

	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><i><CENTER>e_Match Registration</CENTER></i></h1><hr>\n";
	print "<CENTER><B>Before you register, please read <A HREF=\"$main_url/html/disclaimer.htm\" target=_blank>Disclaimer</A></B></CENTER><hr>\n";
	print "<B>To register, enter your desired username and complete your valid email address below.</B>\n";
	print "<form action=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
	print "<CENTER><table><tr><td>Username:</td><td><input type=text name=name value=\"\"><br></td></tr>\n";
	print "<tr><td>E-mail:</td><td><input type=text name=email value=\"\"><B>\n";
	print "</B><br></td></tr></table>\n";
	print "<input type=hidden name=mode value=register>\n";
	print "<input type=submit value=\"Register\"></CENTER></form><p><hr>\n";
	print "<B>If you are unable to enter a valid email address above, you can request one via <A HREF=\"mailto:$admin\">E-mail</A>.</B>\n";
	print "$footer";
	exit;
}

#################################################
#################################################
# Register User Routine

sub register {
	my ($name) = shift(@_);
	my ($email) = shift(@_);

	$email =~ s/ +/_/g;

	&free_filter($email) if $name ne 'Mb';

	$name =~ s/\&(.*?);/$1/g;
	$name =~ s/\s//g;

	##end changes##
	##end changes##

	# check userpass file

	if (($email =~ /.+?\@.+?\..+?/) and ($name)) {
		unless(open(USERFILE,"$logpath/$log")) {
		        &system_error("Couldn't open your user log.  Check your paths and permissions.\n");
		        exit;
		}
		@user_info = <USERFILE>;
		close(USERFILE);
		chomp(@user_info);

		for $info (@user_info) {
			@info = split (/\t/, $info);
			if(lc($info[2]) eq lc($email)) {
				print "Content-type: text/html\n\n";
				print "<html><head><title>e_Match</title>$header\n";
				print "<b>Our records show that someone is already registered using that e-mail address.</b><br>\n";
				print " If you entered incorrect information, use your browser's [Back] button to return to the registration form.\n";
				print "$footer";
				exit;
			}
			if($info[0] eq $name) {
				print "Content-type: text/html\n\n";
				print "<html><head><title>e_Match</title>$header\n";
				print "<h1><CENTER>Access denied</CENTER></h1>\n";
				print "That name has already been taken.  Use your browser's [Back] button to return to the form, and chosse another.\n";
				print "$footer";
				exit;
			}
		}

		unless(open(XUSERFILE,"$logpath/$xlog")) {
		        &system_error("Couldn't open your deleted user log.  Check your paths and permissions.\n");
		        exit;
		}
		@user_info = <XUSERFILE>;
		close(XUSERFILE);
		chomp(@user_info);

		for $info (@user_info) {
			@info = split (/\t/, $info);
			if(lc($info[2]) eq lc($email)) {
				print "Content-type: text/html\n\n";
				print "<html><head><title>e_Match</title>$header\n";
				print "<b>Our records show that an expired user registered using that e-mail address.</b><br>\n";
				print " If you wish to re-subscribe, please contact this site's webmaster.\n";
				print "$footer";
				exit;
			}
			if($info[0] eq $name) {
				print "Content-type: text/html\n\n";
				print "<html><head><title>e_Match</title>$header\n";
				print "<h1><CENTER>Access denied</CENTER></h1>\n";
				print "That name has already been taken.  Use your browser's [Back] button to return to the form, and choose another.\n";
				print "$footer";
				exit;
			}
		}

		# generate password,

	    srand;

		##start changes##
		##start changes##

		$random = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
		$password = "";
		for (1..6) {
	        $password .= substr($random,int(rand(36)),1);
		}
		
		open(USERFILE,"+>>$logpath/$log") || &return_page('System Error', "Can't access $log(4).\n");
		flock USERFILE, 2 if $lockon eq 'yes';
		seek(USERFILE, 0, 0);

		@lines = <USERFILE>;
		
		$time = time;

		if($free eq 'yes') {
			$status = 'free';
		}else {
			$status = time + 60*60*24*$trial;
		}

		push(@lines, "$name\t$password\t$email\t$time\t$status\n");
		
		@lines = sort(@lines);

		seek (USERFILE, 0, 0);
		truncate (USERFILE, 0);

		print USERFILE @lines;

		close(USERFILE);

		##end changes##
		##end changes##

		$from = $admin;
		$to = $email;
		$subject = 'Password for e_Match';
		$message = "Your e_Match Password is: $password";

		&email($from, $to, $smtp, $subject, $message);

		$from = $admin;
		$to = $admin;
		$subject = 'New User for e_Match';
		$message = "New e_Match user is: $name";

		&email($from, $to, $smtp, $subject, $message);


		print "Content-type: text/html\n\n";
		print "<html><head>$header\n";
		print "<h1><CENTER>Thanks for registering.</CENTER></h1>\n";
		print "<CENTER>Your password will be arriving via e-mail shortly.  When it does, you can return <a href=\"$ENV{'SCRIPT_NAME'}\">HERE</a> and log on.</CENTER>\n";
		print "$footer";
		exit;
	}
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1><CENTER>The information you provided was incomplete.</CENTER></h1>  Please use your browser's [Back] button to return to the form.\n";
	print "$footer";
	exit;
}

#################################################
#################################################
# Gateway Routine

sub gateway {
	my($name) = shift(@_);
	my($password) = shift(@_);


	# check userpass file

	if($password) {

		open(USERFILE,"+>>$logpath/$log") || &return_page('System Error', "Can't write to $log.(345)\n");
		flock USERFILE, 2 if $lockon eq 'yes';

		seek (USERFILE, 0, 0);
		@user_info = <USERFILE>;
		chomp(@user_info);

		##start changes##
		##start changes##

		$is_nick = '';
		$is_user = '';
		
		$lower = 0;
		$upper = $#user_info;
		
		do {
			$middle = int(($upper+$lower)/2);
			($nickname, $pass, $email, $time, $status) = split (/\t/, $user_info[$middle]);
			$lower = ++$middle if $nickname lt $name;
			$upper = --$middle if $nickname gt $name;
		}while(($nickname ne $name) and ($upper >= $lower));
		
		if($nickname eq $name) {
			if($password eq $pass) {
				$is_user = 'yes';
				$time = time;
				$status = time + $trial*60*60*24 if $status eq '';
				$status = time + $trial*60*60*24 if $status eq 'free' and $free eq 'no';
				$status = 'free' if $free eq 'yes';
				$user_info[$middle] = join ("\t", ($nickname, $pass, $email, $time, $status));
			}else {
				$is_nick = 'yes';
			}
		}
		
		open(INDEX,"+>>$datapath/index.txt") || &return_page('System Error', "Can't write to index.txt.(388)\n");
		flock INDEX, 2 if $lockon eq 'yes';
		seek (INDEX, 0, 0);
		$index = <INDEX>;
		
		$index = 0 if $index >= $#user_info;
		
		$index_last = $index + 500;
		
		$index_last = $#user_info if $index_last > $#user_info;
		
		seek (INDEX, 0, 0);
		truncate (INDEX, 0);
		
		$next_index = $index_last + 1;
		
		print INDEX "$next_index";
		
		close(INDEX);

		for($i=$index;$i<=$index_last;$i++) {
			($nickname, $pass, $email, $time, $status) = split (/\t/, $user_info[$i]);
			
			#print "$nickname<br>\n";

			if(($free eq 'yes') or ($status eq '')) {
				$status = 'delete' if time > $time + 60*60*24*$timeout;
				$user_info[$i] = join ("\t", ($nickname, $pass, $email, $time, $status));
			}else {
				if(($status =~ /^\d+$/) and ($status - 60*60*24*3 < time)) {
					if($notify eq 'yes') {
						$from = $admin;
						$to = $email;
						$smtp = '';
						$subject = "A Reminder To $nickname from e_Match";
						$message = $reminder;
						&email($from, $to, $smtp, $subject, $message);
					}

					$status = time + 60*60*24*3;
					$status .= 'x';
					$user_info[$i] = join ("\t", ($nickname, $pass, $email, $time, $status));
					last if $is_nick or $is_user;

				}elsif((($status > 0) and ($status < time)) or (($status eq 'free') and (($time + $timeout*60*60*24) < time))) {

					$status = 'delete';
					$user_info[$i] = join ("\t", ($nickname, $pass, $email, $time, $status));					
					last if $is_nick or $is_user;
				}
			}
		}

		seek (USERFILE, 0, 0);
		truncate (USERFILE, 0);

		open(XLOG,">>$logpath/$xlog") || &system_error("Can't write to $xlog.(538)\n");
		flock XLOG, 2 if $lockon eq 'yes';
		seek (XLOG, 0, 2);

		for $line (@user_info) {
			next if $line eq '';
			if(substr($line, -6) eq 'delete') {
				if($free ne 'yes') {
					print XLOG "$line\n";
				}
				
				($nickname, $pass) = split(/\t/, $line);
				#delete all user's match and board files;
				&expire_user_files($nickname, $pass, 'all');

				#delete this user's dir;
				if(-d "$datapath/$user_path") {
					opendir(DIR, "$datapath/$user_path");
					@raw = sort grep(!/^\./, readdir(DIR));
					closedir(DIR);
					for $item(@raw) {
						unlink("$datapath/$user_path/$item");
					}
					rmdir("$datapath/$user_path");
				}

				#delete this user's entry in profiles.txt
				$init_pass = substr($pass, 0, 1);
				open(PROFILES,"+>>$datapath/$init_pass/profiles.txt") || &return_page('System Error', "Can't write to profiles.txt.(798)\n");
				flock PROFILES, 2 if $lockon eq 'yes';
				seek (PROFILES, 0, 0);
				@lines = <PROFILES>;
				chomp(@lines);
				
				seek (PROFILES, 0, 0);
				truncate (PROFILES, 0);
				
				foreach $profile_line (@lines) {
					next if index($profile_line, "Password:\t$pass") != -1;
					print PROFILES "$profile_line\n";
				}
				
				close(PROFILES);
				
				#delete user's pic
				
				unlink("$html_path/pics/$FORM{'nickname'}.jpg", "$html_path/pics/$FORM{'nickname'}.gif");

			}elsif(substr($line, -6) eq 'banned') {
			
				print XLOG "$line\n";
				
				($nickname, $pass) = split(/\t/, $line);
				#delete all user's match and board files;
				&expire_user_files($nickname, $pass, 'all');

				#delete this user's dir;
				if(-d "$datapath/$user_path") {
					opendir(DIR, "$datapath/$user_path");
					@raw = sort grep(!/^\./, readdir(DIR));
					closedir(DIR);
					for $item(@raw) {
						unlink("$datapath/$user_path/$item");
					}
					rmdir("$datapath/$user_path");
				}
				
				#delete this user's entry in profiles.txt
				$init_pass = substr($pass, 0, 1);
				open(PROFILES,"+>>$datapath/$init_pass/profiles.txt") || &return_page('System Error', "Can't write to profiles.txt.(798)\n");
				flock PROFILES, 2 if $lockon eq 'yes';
				seek (PROFILES, 0, 0);
				@lines = <PROFILES>;
				chomp(@lines);
				
				seek (PROFILES, 0, 0);
				truncate (PROFILES, 0);
				
				foreach $profile_line (@lines) {
					next if index($profile_line, "Password:\t$pass") != -1;
					print PROFILES "$profile_line\n";
				}
				
				close(PROFILES);
				
				#delete user's pic
				
				unlink("$datapath/pics/$FORM{'nickname'}.jpg", "$datapath/pics/$FORM{'nickname'}.gif");
				
			}else {
				print USERFILE "$line\n";
			}
		}
		close (XLOG);
		close(USERFILE);
		
		##end changes##
		##end changes##

		if($is_user) {
			$FORM{'ID'} = &make_ID($password);
			return;
		}
	}
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><CENTER>Log On Error</CENTER></h1><hr><b>Possible reasons for this error:</b><ol>\n";
	print "<li>The information you provided was incorrect. If so, use your browser's [Back] button to return to the form and correct your entries.\n";
	print "<li>You have not yet registered.  If you need to register, click <a href=\"$ENV{'SCRIPT_NAME'}?mode=registerform\">HERE.</a>\n";
	print "<li>Your membership has expired or you have been banned.  If this is the case, you can e-mail this site's administrator <A HREF=\"mailto:$admin\">HERE</A>.\n";
	print "</ol>$footer";
	exit;
}

#################################################
#################################################
# View Profile Routine

sub view_profile {
	local($password) = @_;
	&get_profile("$password");
	$profile_nick = $PROFILE_ITEMS{'Nickname:'};
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><I><CENTER>Profile for $profile_nick</CENTER></I></h1>";
	print "<table align=center class=linkbar width=\"90%\"><tr><td align=center>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=upload target=_blank>[Upload Picture]</a>\n" if $profile_nick eq $FORM{'nickname'};
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=redo>[Redo Profile]</a>\n" if $password eq $FORM{'password'};
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></table>\n";
	&print_pic($profile_nick);
	&get_profile_html;
	print "</table><table class=linkbar align=center width=\"90%\"><tr><td align=center>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=upload target=_blank>[Upload Picture]</a>\n" if $profile_nick eq $FORM{'nickname'};
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=redo>[Redo Profile]</a>\n" if $password eq $FORM{'password'};
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td>\n";
	print "</td></tr></table><p>\n";
	print "$footer";
	exit;
}

#################################################
#################################################
# print picture

sub print_pic {
	my($nick) = shift;
	@binaries = &listdir("$html_path/pics",'binary');
	for $file (@binaries) {
		$nick =~ s/\W+//g;
		next if $file !~ /^$nick\./;
		print "<table border=0 width=\"100%\"><tr><td class=imagebg width=\"15%\" valign=top>\n";
		print "<img src=\"$main_url/pics/$file\" width=150 valign=top align=left>";
		print "</td><td><p>\n";
		print "<table>\n";
	}
}

#################################################
#################################################
# View Match Profile Routine

sub view_match {
	$match_password = $users{$FORM{'match'}};
	&view_profile($match_password);
	exit;
}

#################################################
#################################################
# View Private Board Routine

sub view_board {
	&get_file_names("$FORM{'password'}", "$users{$FORM{'match'}}");

	unless(open(DATA,"$datapath/$board_datafile")) {
	    &system_error("Can't read board datafile.\n");
	    exit;
	}
	@data = <DATA>;
	close(DATA);
	chomp(@data);
	if ($data[1] eq $FORM{'nickname'}) {
		$data[2] = $data[0];
	}else {
		$data[4] = $data[0];
	}

	unless(open(DATA,">$datapath/$board_datafile")) {
	    &system_error("Can't write to board datafile.\n");
	    exit;
	}
	flock DATA, 2 if $lockon eq 'yes';
	seek (DATA, 0, 0);
	for $line (@data) {
		print DATA "$line\n";
	}
	close(DATA);

	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><I><CENTER>Private Message Board for $FORM{'nickname'} and $FORM{'match'}</CENTER></I></h1>\n";
	print "<table width=\"90%\" align=center class=linkbar><tr><td align=center>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=erase&match=$FORM{'match'}>[Clear Board]</a>\n" if(-e "$datapath/$board_messagefile");
	print "</td></tr></table>\n";
	if (-e "$datapath/$board_messagefile") {
		unless(open(BOARD,"$datapath/$board_messagefile")) {
	        &system_error("Can't open $datapath/$board_messagefile.\n");
	        exit;
		}
		@board = <BOARD>;
		close(BOARD);
		print "<table class=board align=center width=\"90%\"><tr><td>\n";
		for $message (@board) {
			($time, $poster, $message) = split (/\t/, $message, 3);
			$localtime = localtime($time);
			print "<table><tr><td><b>$poster:</b></td><td> $message<small><i>($localtime)</i></small></td></tr></table>\n";
		}
	}else {
		print "The Message Board is empty.\n";
	}
	print "</td></tr></table>\n";
	print "<hr><CENTER><b>Add a message:</b><br><form action=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
	print "<textarea name=message wrap ROWS=10 COLS=60></textarea><br>\n";
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=\"$FORM{'ID'}\">\n";
	print "<input type=hidden name=match value=\"$FORM{'match'}\">\n";
	print "<input type=hidden name=mode value=preview>\n";
	print "<input type=submit value=Preview><input type=reset></form></CENTER>\n";
	print "<table width=\"90%\" align=center class=linkbar><tr><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></table>\n";
	print "$footer\n";
	exit;
}

#################################################
#################################################
# Erase Board

sub erase_board {
	&get_file_names("$FORM{'password'}", "$users{$FORM{'match'}}");

	open(BOARD,">$datapath/$board_datafile") || &system_error("Can't write to $board_datafile.(1200)\n");
	flock BOARD, 2 if $lockon eq 'yes';
	seek (BOARD, 0, 0);
	@nicknames = ("$FORM{'nickname'}", "$FORM{'match'}");
	@nicknames = sort(@nicknames);
	print BOARD "0\n";
	print BOARD "$nicknames[0]\n";
	print BOARD "0\n";
	print BOARD "$nicknames[1]\n";
	print BOARD "0\n";
	close(BOARD);

	open(BOARD,">$datapath/$board_messagefile") || &return_page('System Error', "Can't write to $board_messagefile.(560)\n");
	flock BOARD, 2 if $lockon eq 'yes';
	seek (BOARD, 0, 0);
	truncate(BOARD, 0);
	close(BOARD);

	&view_board;
}

#################################################
#################################################
# Preview Message Routine

sub preview {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1><CENTER>Preview Your Message</CENTER></h1><hr>\n";
	print "Your Message:<p>$FORM{'message'}<p>\n";
	print "<hr>\n";
	print "If you want to make any changes, use the form below.  Otherwise, just click [Submit].<br>\n";
	print "<form action=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
	print "<CENTER><textarea name=message rows=10 cols=60 wrap>$FORM{'message'}</textarea><br>\n";
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=\"$FORM{'ID'}\">\n";
	print "<input type=hidden name=match value=\"$FORM{'match'}\">\n";
	print "<input type=hidden name=mode value=post>\n";
	print "<input type=submit><input type=reset></CENTER>\n";
	print "</form>$footer\n";
	exit;
}

#################################################
#################################################
# Post Message Routine

sub post {
	&get_file_names("$FORM{'password'}", "$users{$FORM{'match'}}");
	unless(open(BOARD,">>$datapath/$board_messagefile")) {
        &system_error("Can't append to $board_messagefile.\n");
        exit;
	}
	flock BOARD, 2 if $lockon eq 'yes';
	seek (BOARD, 0, 2);
	$time = time;
	print BOARD "$time\t$FORM{'nickname'}\t$FORM{'message'}\n";
	close(BOARD);
	unless(open(DATA,"$datapath/$board_datafile")) {
        &system_error("Can't open $board_datafile.\n");
        exit;
	}
	@data = <DATA>;
	close(DATA);
	chomp(@data);
	$data[0]++;
	if($data[1] eq $FORM{'nickname'}) {
		$data[2] = $data[0];
		}else {
		$data[4] = $data[0];
	}
	unless(open(DATA,">$datapath/$board_datafile")) {
        &system_error("Can't create $board_datafile.\n");
        exit;
	}
	flock DATA, 2 if $lockon eq 'yes';
	seek (DATA, 0, 0);
	for $line (@data) {
		print DATA "$line\n";
	}
	close(DATA);

	$from = $FORM{'nickname'};
	$to = $addresses{$FORM{'match'}};
	$subject = 'e_Match Message';
	$message = "You have message from $FORM{'nickname'} waiting for you at e_Match.";
	&email($from, $to, $smtp, $subject, $message);

	&view_board;
}


#################################################
#################################################
# Generate Profile Form Routine

sub generate_profile_form {

	unless(exists($FORM{'page'})) {
		open (SUBJECT, "$datapath/$subject") || &system_error("Can't open to $datapath/$subject");
		@subjectlist = <SUBJECT>;
		close(SUBJECT);
		chomp @subjectlist;
		for (@subjectlist) {
			($name, $value) = split (/\t/, $_, 2);
			$SUBJECT{$name} = $value;
		}
	}

	if(exists($FORM{'page'})) {
		($type, $number) = split (/-/, $FORM{'page'});
		if((-e "$datapath/form/$type-1.txt") and ($number eq '')) {
			$number = 1;
			$FORM{'page'} = "$type-1";
		}
		if($type eq 'subject') {
			$subject =~ s/\.txt/-$number\.txt/ if $number;
			open (SUBJECT, "$datapath/$subject") || &system_error("Can't open to $datapath/$subject");
			@subjectlist = <SUBJECT>;
			close(SUBJECT);
			chomp @subjectlist;
			for (@subjectlist) {
				($name, $value) = split (/\t/, $_, 2);
				$SUBJECT{$name} = $value;
			}
		}
		if($type eq 'object') {
			$object =~ s/\.txt/-$number\.txt/ if $number;
			open (OBJECT, "$datapath/$object") || &system_error("Can't open to $datapath/$object");
			@objectlist = <OBJECT>;
			close(OBJECT);
			chomp @objectlist;
			for (@objectlist) {
				($name, $value) = split (/\t/, $_, 2);
				$OBJECT{$name} = $value;
			}
		}
		if($type eq 'interests') {
			$interests =~ s/\.txt/-$number\.txt/ if $number;
			open (INTERESTS, "$datapath/$interests") || &system_error("Can't open to $datapath/$interests");
			@interestslist = <INTERESTS>;
			close(INTERESTS);
			chomp @interestslist;
			for (@interestslist) {
				($name, $value) = split (/\t/, $_, 2);
				$INTERESTS{$name} = $value;
			}
		}
	}

	$user_path = &get_user_path("$FORM{'password'}");
	&get_profile($FORM{'password'}) if(-e "$datapath/$user_path/profile.txt");

	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><i><CENTER>Enter Profile Data</CENTER></i></h1>\n";
	print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=formhelp target=_blank>[Help]</a></td></tr></TABLE><p>\n";

	print "<form action=$ENV{'SCRIPT_NAME'} method=POST>\n";

	for $key (sort(keys(%SUBJECT))) {
		@items = split (/\t/, $SUBJECT{$key});
		if ($key eq 'a00') {
			print "<input type=hidden name=$key value=\"$SUBJECT{$key}\"><table class=profileform align=center width=\"90%\"><CAPTION>$SUBJECT{$key}</CAPTION><tr><td>\n";
		}elsif($key ne 'a99') {
			print "<table width=\"100%\"><tr><td width=\"50%\" align=right>\n";
			print "<b>$items[0]? </b></td><td width=\"50%\">\n";
			&print_item ($key, split (/\t/, $SUBJECT{$key}));
			print "</td></tr></table><hr>\n";
		}else {
			print "</td></tr></table>\n<hr>\n<table class=profileform align=center width=\"90%\"><caption>$items[0]:</caption><tr><td>\n";
			&print_item ($key, split (/\t/, $SUBJECT{$key}));
		}
	}
	print "</td></tr></table>\n";

	for $key (sort(keys(%OBJECT))) {
		@items = split (/\t/, $OBJECT{$key});
		if ($key eq 'b00') {
			print "<hr><input type=hidden name=$key value=\"$OBJECT{$key}\"><table class=profileform align=center width=\"90%\"><CAPTION>$OBJECT{$key}</CAPTION><tr><td>\n";
		}else {
			($PROFILE_ITEMS{$key}, $profile_rating) = split (/\t/, $PROFILE_ITEMS{$key}) if exists($PROFILE_ITEMS{$key});
			if($items[1] !~ /s/i) {
				print "<table width=\"100%\"><tr><td width=\"50%\"><b>$items[0]?</b></td><td width=\"50%\">\n";
				&rate($key);
				print "</td></tr></table>\n";
				&print_item ($key, @items);
			}else {
				print "<table width=\"100%\"><tr><td width=\"20%\"><b>$items[0]?</b></td><td width=\"30%\">\n";
				&print_item ($key, @items);
				print "</td><td>\n";
				&rate($key);
				print "</td></tr></table>\n";
			}
		print "<hr>\n";
		}
	}
	print "</td></tr></table><hr>\n";

	for $key (sort(keys(%INTERESTS))) {
		$item = $INTERESTS{$key};
		if ($key =~ /i.00/) {
			print "</td></tr></table>\n" if $key ne 'i000';
			print "<input type=hidden name=$key value=\"$item\"><table class=profileform align=center width=\"90%\"><CAPTION>$item</CAPTION><tr><td>\n";
		}else {
			if (exists($PROFILE_ITEMS{$key})) {
				print "<table width=\"90%\"><tr><td width=200><input type=checkbox checked name=$key value=\"$item\"><b>$item</b></td><td width=200>\n";
			}else {
				print "<table width=\"90%\"><tr><td width=200><input type=checkbox name=$key value=\"$item\"><b>$item</b></td><td width=200>\n";
			}
			($PROFILE_ITEMS{$key}, $profile_rating) = split (/\t/, $PROFILE_ITEMS{$key}) if exists($PROFILE_ITEMS{$key});
			&rate($key);
			print "</td></tr></table><hr>\n";
		}
	}
	print "</td></tr></table>\n";

	if($mode eq 'last') {
		$PROFILE_ITEMS{'xComment'} =~ s/\*p\*/\n\n/g;
		$PROFILE_ITEMS{'xComment'} =~ s/\*br\*/\n/g;

		print "<table class=profileform align=center width=\"90%\"><CAPTION>Add a comment if you'd like:</CAPTION><tr><td align=center><textarea name=xComment COLS=70 ROWS=10 wrap>$PROFILE_ITEMS{'xComment'}</textarea></td></tr></table>\n" if $mode eq 'last';
}
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=\"$FORM{'ID'}\">\n";
	print "<!--$mode-->\n";
	print "<input type=hidden name=mode value=profile>\n";
	print "<input type=hidden name=page value=\"$FORM{'page'}\">\n" if(exists($FORM{'page'}));
	print "<hr><CENTER><p align=center><input type=submit><input type=reset></CENTER>\n";
	print "</form>";
	print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a>\n" if $mode ne 'logon';
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=formhelp target=_blank>[Help]</a></td></tr></TABLE><p>\n";
	print "$footer";
	exit;
}

#################################################
# returns HTML each item

sub print_item {
	(my $key, $query, $type, @selections) = @_;
	$checked = 'no';
	if($type !~ /s/i) {
		print "<br>\n" if $key =~ /^a/;
		foreach $selection (@selections) {
			if ((exists($PROFILE_ITEMS{$key})) and ($PROFILE_ITEMS{$key} eq $selection)) {
				print "&nbsp;&nbsp;<input type=radio checked name=$key value=\"$selection\">$selection\n";
				$checked = 'yes';
			}else {
				print "&nbsp;&nbsp;<input type=radio name=$key value=\"$selection\">$selection\n";
			}
		}
		if($checked eq 'no') {
			print "&nbsp;&nbsp;<input type=radio checked name=$key value=\"Clear\">Doesn't Matter\n";
		}else {
			print "&nbsp;&nbsp;<input type=radio name=$key value=\"Clear\">Doesn't Matter\n";
		}
	}else {
		print "<select name=\"$key\">\n";
		foreach $selection (@selections) {
			if ((exists($PROFILE_ITEMS{$key})) and ($PROFILE_ITEMS{$key} eq $selection)) {
				print "<option selected value=\"$selection\">$selection\n";
				$checked = 'yes';
			}else {
				print "<option value=\"$selection\">$selection\n";
			}
		}
		if($checked eq 'no') {
			print "<option selected value=\"Clear\">Doesn't Matter\n";
		}else {
			print "<option value=\"Clear\">Doesn't Matter\n";
		}
	print "</select>\n";
	}
}

#################################################
# generates rating HTML subroutine (select boxes)

sub rate {
	local($item) = @_;
	print "<i>Rate&nbsp\;this&nbsp\;item:</i>&nbsp;<select name=\"$item"."rating\">";
	for $rank (sort{$ranks{$b} <=> $ranks{$a}} keys (%ranks)) {
		last if $key =~ /^b.*/ and $ranks{$rank} lt '0';
		if((exists($PROFILE_ITEMS{$key})) and ($profile_rating eq $ranks{$rank})) {
			print "<option selected value=\"$ranks{$rank}\">$rank\n";
		}elsif((not(exists($PROFILE_ITEMS{$key}))) and ($ranks{$rank} eq '4')) {
			print "<option selected value=\"$ranks{$rank}\">$rank\n";
		}else {
			print "<option value=\"$ranks{$rank}\">$rank\n";
		}
	}
	print "</select>\n";
}

#################################################
#################################################
# Check Profile Routine

sub check_profile {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header<hr>\n";
	print "<b>NOTE:</b> Check your profile carefully.  If you find an error, use your browsers back button to return to the form and make corrections, then re-submit.<hr><hr>\n";
	if(exists($FORM{'page'})) {
		&append_profile;
	}else {
		&save_profile;
	}
	&get_new_profile("$FORM{'password'}");
	foreach $key (keys(%PROFILE_ITEMS)) {
		delete($PROFILE_ITEMS{$key}) unless(exists($FORM{$key}));
	}

	&get_profile_html;

	#############################################
	#compute next page

	unless(exists($FORM{'page'})) {$FORM{'page'} = 'subject-1'}

	($type, $number) = split(/-/, $FORM{'page'});

	$number++;

	$mode = 'next';

	$num_pls_one = $number + 1;

	if($type eq 'interests') {
		$mode = 'last' unless(-e "$datapath/form/$type-$num_pls_one.txt");
	}

	if(-e "$datapath/form/$type-$number.txt") {
		$FORM{'page'} = "$type-$number";
		$button_text = "Submit Data";
	}else {
		$button_text = "Save Data";
		if($type eq 'subject') {$FORM{'page'} = 'object'}
		if($type eq 'object') {$FORM{'page'} = 'interests'}
		if($type eq 'interests') {
			$mode = 'save';
			$user_path = &get_user_path($FORM{'password'});
			$button_text .= " and Run Match";
			print "<hr><h3 align=center>e_Match will now run its Match Routine.  This may take a minute or two.</h3>\n";
		}
	}
	print "<form action=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
	print "<input type=hidden name=mode value=$mode>\n";
	print "<input type=hidden name=page value=\"$FORM{'page'}\">\n";
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=\"$FORM{'ID'}\">\n";
	print "<CENTER><input type=submit value=\"$button_text\"></CENTER>\n";
	print "</form>\n";
	print "$footer";
	exit;
}

#################################################
# save profile subroutine

sub save_profile {
	$user_path = &get_user_path($FORM{'password'});
	mkdir("$datapath/$sub_init", 0777) unless (-e "$datapath/$sub_init");
	&makepage("$datapath/$sub_init") unless(-e "$datapath/$sub_init/index.html");
	mkdir("$datapath/$user_path", 0777);

	&get_password_list;
	$user_email = $addresses{$FORM{'nickname'}};

	open(PROFILE,">$datapath/$user_path/profile.new") || &system_error("Can't write to profile.txt.(994)\n");
	flock PROFILE, 2 if $lockon eq 'yes';
	seek (PROFILE, 0, 0);
	print PROFILE "Nickname:\t$FORM{'nickname'}\n";
	print PROFILE "Email:\t$user_email\n";
	for $key (sort(keys(%FORM))) {
		if (($key =~ /\d/) and ($FORM{$key} ne '') and ($FORM{$key} ne 'Clear') and ($key !~ /rating/)) {
			print PROFILE "$key\t$FORM{$key}";
			$key_rating = "$key"."rating";
			print PROFILE "\t$FORM{$key_rating}" if exists ($FORM{$key_rating});
			print PROFILE "\n";
		}
	}
	close(PROFILE);
}

#################################################
# append profile subroutine

sub append_profile {
	$user_path = &get_user_path($FORM{'password'});

	open(PROFILE,">>$datapath/$user_path/profile.new") || &system_error("Can't append to profile.txt.(999)\n");
	flock PROFILE, 2 if $lockon eq 'yes';
	seek (PROFILE, 0, 2);
	for $key (sort(keys(%FORM))) {
		if (($key =~ /\d/) and ($FORM{$key} ne '') and ($FORM{$key} ne 'Clear') and ($key !~ /rating/)) {
			print PROFILE "$key\t$FORM{$key}";
			$key_rating = "$key"."rating";
			print PROFILE "\t$FORM{$key_rating}" if exists ($FORM{$key_rating});
			print PROFILE "\n";
		}
	}
	if(exists($FORM{'xComment'})) {
		$FORM{'xComment'} =~ s/\n\n/*p*/gs;
		$FORM{'xComment'} =~ s/\n/*br*/gs;
		print PROFILE "\nxComment\t$FORM{'xComment'}\n";
	}
	close(PROFILE);
}

#################################################
#################################################
# Generate Matches Routine

##start changes##
##start changes##

sub match {

	#############################################
	# remove user from all other lists

	&expire_user_files($FORM{'nickname'}, $FORM{'password'}, 'matches') unless (exists($FORM{'index'}));


	#############################################
	# Load subject profile

	$subject_path = &get_user_path($FORM{'password'});
	open(PROFILE, "$datapath/$subject_path/profile.txt") || &system_error("Can't read subject file.(962)\n");
	@data = <PROFILE>;
	close(PROFILE);
	chomp(@data);

	#############################################
	# Get subject characteristics, desires,  and interests lists

	@subject_alist = map {/(^a\d[^0].*)/} @data;
	@subject_blist = map {/(^b\d[^0].*)/} @data;
	@subject_ilist = map {/(^i\d\d[^0].*)/} @data;
	@subject_rel_type = map {/(^a99.*)/} @data;
	$subject_rel_type = $subject_rel_type[0];

	#############################################
	# Load next objects profiles
	
	$first_loop = 'yes';

LOOP:	if(exists($FORM{'index'})) {
		$index = $FORM{'index'}
	}else {
		$index = '0';
	}

	chomp(@password_list);
	until (-e "$datapath/$index/profiles.txt") {
		$index = chr(ord($index)+1);
	}
	%score_list = ();
	
	open(PROFILES,"$datapath/$index/profiles.txt") || &return_page('System Error', "Can't read profiles.txt.(1548)\n");
	@profile_lines = <PROFILES>;
	close(PROFILES);
	chomp(@profile_lines);
	
	
	foreach $profile (@profile_lines) {
		next unless $profile;
		next unless index($profile, "Password:\t$FORM{'password'}") == -1;

		@data = split(/\|/, $profile);
		
		shift(@data); # remove password item


		#########################################
		# For each object

		$object_name = $data[0];
		$object_name =~ s/Nickname:\t//;
		$score = 0;

		#########################################
		# Get object characteristics, desires, and interests lists

		@object_alist = map{/(^a\d[^0].*)/} @data;
		@object_blist = map{/(^b\d[^0].*)/} @data;
		@object_ilist = map{/(^i\d\d[^0].*)/} @data;
		@object_rel_type = map {/(^a99.*)/} @data;
		$object_rel_type = $object_rel_type[0];

		#########################################
		# Relationship type check

		if(($subject_rel_type ne $object_rel_type) and ($subject_rel_type) and ($object_rel_type)) {
			$score -= 1000000;
			goto A_CHECK;
		}


		#########################################
		# Look for subject desires/object characteristics matches

		for $subject_line (@subject_blist) {
			@subject_items = split (/\t/, $subject_line);
			$found = 'no';
			for $object_line (@object_alist) {
				@object_items = split (/\t/, $object_line);
				if (substr($subject_line,1,2) eq substr($object_line,1,2)) {

					#### found match ####
					$found = 'yes';
					@object_items = split (/\t/, $object_line);
					$score -= 1000000 if $subject_items[2] eq '-100';
					$score -= 1000000 if ($subject_items[1] ne $object_items[1] and $subject_items[2] eq '100');
					$score += $subject_items[2] if $subject_items[1] eq $object_items[1];
					$score -= $subject_items[2] if $subject_items[1] ne $object_items[1];
					last;
				}
			}
			$score -= 1000000 if $subject_items[2] eq '100' and $found eq 'no';
		}
		goto A_CHECK if $score <-500000;
		#########################################
		# Look for object desires/subject characteristics matches

		for $object_line (@object_blist) {
			@object_items = split (/\t/, $object_line);
			$found = 'no';
			for $subject_line (@subject_alist) {
				@subject_items = split (/\t/, $subject_line);
				if (substr($subject_line,1,2) eq substr($object_line,1,2)) {

					####found a match####
					$found = 'yes';
					@object_items = split (/\t/, $object_line);
					$score -= 1000000 if $object_items[2] eq '-100';
					$score -= 1000000 if ($subject_items[1] ne $object_items[1] and $object_items[2] eq '100');
					$score += $object_items[2] if $subject_items[1] eq $object_items[1];
					$score -= $object_items[2] if $subject_items[1] ne $object_items[1];
					last;
				}

			}
			$score -= 1000000 if $object_items[2] eq '100' and $found eq 'no';
		}
		goto A_CHECK if $score <-500000;
		##########################################
		# Look for interests matches

		for $subject_line (@subject_ilist) {
			@subject_items = split (/\t/, $subject_line);
			for $object_line (@object_ilist) {
				if (substr($subject_line,1,3) eq substr($object_line,1,3)) {

					####found a match####
					@object_items = split (/\t/, $object_line);
					$score -= 1000000 if ($object_items[2] eq '-100' and $subject_items[2] > 0);
					$score -= 1000000 if ($subject_items[2] eq '-100' and $object_items[2] > 0);
					$score -= 1000000 if ($object_items[2] eq '100' and $subject_items[2] < 0);
					$score -= 1000000 if ($subject_items[2] eq '100' and $object_items[2] < 0);

					if (($subject_items[2] > 0 and $object_items[2] > 0) or ($subject_items[2] < 0 and $object_items[2] < 0)) {
						$score += abs($subject_items[2] + $object_items[2]);
					}else {
						$score -= abs($subject_items[2]) + abs($object_items[2]);
					}
				}
			}
		}
		##########################################
		# check if active match

A_CHECK:	&get_file_names("$FORM{'password'}", "$users{$object_name}");
		if(-e "$datapath/$board_datafile") {
	    	unless(open(BOARD,"$datapath/$board_datafile")) {
			        &system_error("Canit read $board_datafile. (1)\n");
			        exit;
			}
			@lines = <BOARD>;
			close(BOARD);
			chomp(@lines);
			$score += 1000000000 if $lines[0] ne '0';
		}
		$score_list{$object_name} = $score if $score > 0;
	}
	#############################################
	# Check for nukes (both ways)

	for $name(keys(%score_list)) {
		$user_path = &get_user_path("$FORM{'password'}");
		if (-e "$datapath/$user_path/nuked.txt") {
			unless(open(CHECK,"$datapath/$user_path/nuked.txt")) {
			        &system_error("Can't open nuked file for $FORM{'nickname'}\n");
			        exit;
			}
			@nuke_list = <CHECK>;
			close(CHECK);
			chomp(@nuke_list);
			delete($score_list{$name}) if (grep (/\b$name\b/, @nuke_list));
		}

		$user_path = &get_user_path("$users{$name}");
		if (-e "$datapath/$user_path/nuked.txt") {
			unless(open(CHECK,"$datapath/$user_path/nuked.txt")) {
			        &system_error("Can't open nuked file for $users{$name}\n");
			        exit;
			}
			@nuke_list = <CHECK>;
			close(CHECK);
			chomp(@nuke_list);
			delete($score_list{$name}) if (grep (/\b$FORM{'nickname'}\b/, @nuke_list));
		}
	}

	#############################################
	# Create board data files if needed

	for $name(keys(%score_list)) {
	next unless $name;
		&get_file_names("$FORM{'password'}", "$users{$name}");
		next if (-e "$datapath/$board_datafile");

		open(BOARD,">$datapath/$board_datafile") || &system_error("Can't write to $board_datafile.(1200)\n");
		flock BOARD, 2 if $lockon eq 'yes';
		seek (BOARD, 0, 0);
		@nicknames = ("$FORM{'nickname'}", "$name");
		@nicknames = sort(@nicknames);
		print BOARD "0\n";
		print BOARD "$nicknames[0]\n";
		print BOARD "0\n";
		print BOARD "$nicknames[1]\n";
		print BOARD "0\n";
		close(BOARD);
	}

	#############################################
	# Store user matches in matches.txt

	$user_path = &get_user_path($FORM{'password'});
	if($first_loop eq 'yes') {
		unless(open(MATCHES,">$datapath/$user_path/matches.txt")) {
	    	&system_error("Can't open Matches File for $FORM{'password'}.\n");
	    	exit;
		}
		flock MATCHES, 2 if $lockon eq 'yes';
		seek (MATCHES, 0, 0);
		print MATCHES "";
		close(MATCHES);
		
		$first_loop = 'no';
	}


	unless(open(MATCHES,">>$datapath/$user_path/matches.txt")) {
	    &system_error("Can't open Matches File for $FORM{'password'}.\n");
	    exit;
	}
	flock MATCHES, 2 if $lockon eq 'yes';
	seek (MATCHES, 0, 2);

	for $name(keys(%score_list)) {
		print MATCHES "$name\t$score_list{$name}\n";
	}
	close(MATCHES);

	#############################################
	# Add user to matchs' matchlists

	for $match (keys(%score_list)) {
		$match_pass = $users{$match};
		$match_path = &get_user_path("$match_pass");
		if(-e "$datapath/$match_path/matches.txt") {
			unless(open(MATCH,"$datapath/$match_path/matches.txt")) {
				&system_error("Can't read from matches.txt for $match.\n");
				exit;
			}
			@match_matches = <MATCH>;
			close(MATCH);
			chomp(@match_matches);

			%MM = ();
			for $mm (@match_matches) {
			  ($mmname, $mmscore) = split (/\t/, $mm);
			  $MM{$mmname} = $mmscore;
			}

			$MM{$FORM{'nickname'}} = $score_list{$match};

			unless(open(MATCH,">$datapath/$match_path/matches.txt")) {
			  &system_error("Can't write to matches.txt for $match.\n");
 			  exit;
			  }
 			for $key (keys(%MM)) {
        		print MATCH "$key\t$MM{$key}\n";
			}
	 		close(MATCH);

		}else {
			mkdir("$datapath/$match_path", 0777) unless(-e "$datapath/$match_path");

			open(MATCH,">>$datapath/$match_path/matches.txt") || &system_error("Can't append to matches.txt.(1070)\n");
			flock MATCH, 2 if $lockon eq 'yes';
			seek (MATCH, 0, 2);
			print MATCH "$FORM{'nickname'}\t$score_list{$match}\n";
			close(MATCH);
		}
	}

	do {
		$index = chr(ord($index)+1);
	} until((-e "$datapath/$index") or ($index gt 'z'));

	if(-e "$datapath/$index") {
	
		$FORM{'index'} = $index;
		goto LOOP;
#		print "Content-type: text/html\n\n";
#		print "<head><title>Matching</title>\n";
#		print "<META HTTP-EQUIV=Refresh CONTENT=\"0;URL=$ENV{'SCRIPT_NAME'}?mode=match&nickname=$esc_nick&ID=$FORM{'ID'}&index=$index\">\n";
#		print "$header\n";
#		print "<h1><center>Matching($index)...</center></h1><hr>\n";
#		print "Hang on...@data\n";
#		print "$footer\n";
#		exit;
	}else {
		&main_menu;
	}
}

##end changes##
##end changes##

#################################################
#################################################
# Generate Password Change Form Routine

sub password_form {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><i><CENTER>Change Password</CENTER></i></h1>\n";
	print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></TABLE><p>\n";
	print "<form action=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
	print "<TABLE ALIGN=\"Center\" CELLSPACING=\"0\" CELLPADDING=\"0\"><tr><td align=right>Type new password here:&nbsp\;</td><td>\n";
	print "<input type=password name=pass1 maxlength=10><br></td></tr><tr>\n";
	print "<td>Retype new password here: </td>\n";
	print "<td><input type=password name=pass2 maxlength=10><br></td></tr>\n";
	print "<input type=hidden name=mode value=submitnewpass>\n";
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=\"$FORM{'ID'}\">\n";
	print "<tr><td></td><td><input type=submit><tr><td></td><td></td></tr></TABLE>\n";
	print "</form><hr>\n";
	print "$footer\n";
	exit;
}

#################################################
#################################################
# Change Password Routine

sub change_password {

	#############################################
	# Check if entries match

	if ($FORM{'pass1'} ne $FORM{'pass2'}) {
		print "Content-type: text/html\n\n";
		print "<html><head><title>e_Match</title>$header\n";
		print "<h1 align=center><i><CENTER>Entry Error</CENTER></i></h1>\n";
		print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></TABLE><p>\n";
		print "<b>Your two entered passwords do not match.</b> Use your browser's [Back] button to return to the form and make corrections.\n";
		print "$footer";
		exit;
	}

	#############################################
	# Check if entry taken

	if (grep(/\b$FORM{'pass1'}\b/, @password_list)) {
		print "Content-type: text/html\n\n";
		print "<html><head><title>e_Match</title>$header\n";
		print "<h1 align=center><i><CENTER>Password Not Available</CENTER></i></h1>\n";
		print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></TABLE><p>\n";
		print "<b>Your desired password is taken.</b> Use your browser's [Back] button to return to the form and try again.\n";
		print "$footer";
		exit;
	}

	#############################################
	# Check if valid characters

	if ($FORM{'pass1'} !~ /^\w+$/) {
		print "Content-type: text/html\n\n";
		print "<html><head><title>e_Match</title>$header\n";
		print "<h1 align=center><i><CENTER>Password Not Available</CENTER></i></h1>\n";
		print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></TABLE><p>\n";
		print "<b>Password must consist only of alpha-numeric characters (a-z, A-Z, 0-9).</b> Use your browser's [Back] button to return to the form and try again.\n";
		print "$footer";
		exit;
	}

	#############################################
	# Change password in users.log

	open(USERDATA,"+>>$logpath/$log") || &return_page('System Error', "Can't write to $log.(1327)\n");
	flock USERDATA, 2 if $lockon eq 'yes';

	seek (USERDATA, 0, 0);
	@userdata = <USERDATA>;
	chomp(@userdata);

	seek (USERDATA, 0, 0);
	truncate (USERDATA, 0);

	for ($i=0;$i<=$#userdata;$i++) {
		($nickname, $password, $email, $stuff) = split(/\t/, $userdata[$i], 4);
		if ($password eq $FORM{'password'}) {
			$userdata[$i] = join ("\t", $nickname, $FORM{'pass1'}, $email, $stuff);
		}
		print USERDATA "$userdata[$i]\n";
	}
	close(USERDATA);

	#############################################
	# Change entry in ID file

	&delete_ID($FORM{'ID'});

	$FORM{'ID'} = &make_ID($FORM{'pass1'});

	#############################################
	# Rename boards for matches

	#get matchlist

	$user_path = &get_user_path($FORM{'password'});

	unless(open(MATCHLIST,"$datapath/$user_path/matches.txt")) {
		&system_error("Can't read matches file for $FORM{'username'}.\n");
		exit;
	}
	@matches = <MATCHLIST>;
	close(MATCHLIST);

	&get_password_list;

	for $match (@matches) {

		($match, $score) = split (/\t/, $match);
		$match_path = &get_user_path("$users{$match}");
		#&system_error("$match\n");

		if (-e "$datapath/$match_path/$FORM{'password'}") {

			unless(rename("$datapath/$match_path/$FORM{'password'}", "$datapath/$match_path/$FORM{'pass1'}")) {
				&system_error("Can't rename $datapath/$match_path/$FORM{'password'}\n");
				exit;
			}
		}
		if (-e "$datapath/$match_path/$FORM{'password'}.data") {

			unless(rename("$datapath/$match_path/$FORM{'password'}.data", "$datapath/$match_path/$FORM{'pass1'}.data")) {
				&system_error("Can't rename $datapath/$match_path/$FORM{'password'}\n");
				exit;
			}
		}
	}

	#############################################
	# Relocate user's directory

	#create new directory
	$new_user_path = &get_user_path($FORM{'pass1'});
	mkdir ("$datapath/$sub_init", 0777) unless (-e "$datapath/$sub_init");
	&makepage("$datapath/$sub_init") unless(-e "$datapath/$sub_init/index.html");
	mkdir ("$datapath/$new_user_path", 0777);

	#find all user's files

	$old_user_path = &get_user_path($FORM{'password'});

	unless(opendir(FILES,"$datapath/$old_user_path")) {
	    &system_error("Can't open $datapath/$old_user_path.\n");
	    exit;
	}
	@raw = readdir(FILES);
	close(FILES);
	for $file (@raw) {
		next if $file =~ /^\.{1,2}$/;
		unless(open(FILE,"$datapath/$old_user_path/$file")) {
		    &system_error("Can't open $datapath/$old_user_path/$file.\n");
		    exit;
		}
		@lines = <FILE>;
		close(FILE);

		unlink ("$datapath/$old_user_path/$file");

		open(NEWFILE,">$datapath/$new_user_path/$file") || &system_error("Can't write to $file.(1239)\n");
		flock NEWFILE, 2 if $lockon eq 'yes';
		seek (NEWFILE, 0, 0);
		print NEWFILE @lines;
		close(NEWFILE);
	}

	#delete old directory
	
	rmdir ("$datapath/$old_user_path");
	
	##start changes##
	##start changes##

	
	#move profile line from old profiles.txt to new
	
	$old_pass_init = substr($FORM{'password'}, 0, 1);
	$new_pass_init = substr($FORM{'pass1'}, 0, 1);
	
	open(OLD_PROFILES,"+>>$datapath/$old_pass_init/profiles.txt") || &return_page('System Error', "Can't access profiles.txt(4).\n");
	flock OLD_PROFILES, 2 if $lockon eq 'yes';
	seek(OLD_PROFILES, 0, 0);

	@lines = <OLD_PROFILES>;

	seek (OLD_PROFILES, 0, 0);
	truncate (OLD_PROFILES, 0);
	
	foreach $line (@lines) {
		if($line =~ /Nickname:\t$FORM{'nickname'}/) {
			$profile_line = $line;
		}else {
			print OLD_PROFILES "$line";
		}
	}
	
	$profile_line =~ s/^Password:\t$FORM{'password'}/Password:\t$FORM{'pass1'}/;

	close(OLD_PROFILES);

	open(NEW_PROFILES,">>$datapath/$new_pass_init/profiles.txt") || &return_page('System Error', "Can't access profiles.txt(3).\n");
	flock NEW_PROFILES, 2 if $lockon eq 'yes';
	seek(NEW_PROFILES, 0, 2);

	print NEW_PROFILES "$profile_line";

	close(NEW_PROFILES);

	##end changes##
	##end changes##

	
	$FORM{'password'} = $FORM{'pass1'};
	&main_menu;
}

#################################################
#################################################
# Nuke confirmation

sub nuke_check {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><I><CENTER>Are you sure?</CENTER></I></h1>\n";
	print "<TABLE class=linkbar width=\"90%\" ALIGN=\"Center\"><TR ALIGN=\"left\" VALIGN=\"top\"><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}>[Return to Main Menu]</a></td></tr></TABLE><p>\n";
	print "<CENTER> <B>Do you want to elliminate <B>$FORM{'match'}</B> from your match list?</B></CENTER><p>\n";
	print "<CENTER><B>If you do, click the [Nuke] button.  If not, Return to Main Menu.</B></CENTER>\n";
	print "<form action=$ENV{'SCRIPT_NAME'} method=POST>\n";
	print "<input type=hidden name=nickname value=\"$FORM{'nickname'}\">\n";
	print "<input type=hidden name=ID value=$FORM{'ID'}>\n";
	print "<input type=hidden name=match value=\"$FORM{'match'}\">\n";
	print "<input type=hidden name=mode value=nuke>\n";
	print "<CENTER><input type=submit value=Nuke></CENTER></form>\n";
	print "$footer";
	exit;
}

#################################################
#################################################
# Nuke Routine

sub nuke {
	$user_path = &get_user_path($FORM{'password'});
	unless(open(NUKE,">>$datapath/$user_path/nuked.txt")) {
	    &system_error("Can't append Nukes File for $FORM{'password'}.\n");
	    exit;
	}
	flock NUKE, 2 if $lockon eq 'yes';
	seek (NUKE, 0, 2);
	print NUKE "$FORM{'match'}\n";
	close(NUKE);

	unless(open(MATCHES,"$datapath/$user_path/matches.txt")) {
	    &system_error("Can't read Matches File for $FORM{'password'}.\n");
	    exit;
	}
	@matches = <MATCHES>;
	close(MATCHES);
	chomp(@matches);


	open(MATCHES,">$datapath/$user_path/matches.txt") || &system_error("Can't write to matches.txt.(1200)\n");
	flock MATCHES, 2 if $lockon eq 'yes';
	seek (MATCHES, 0, 0);
	for $line (@matches) {
		next if $line =~ /^$FORM{'match'}\t/;
		print MATCHES "$line\n";
	}
	close(MATCHES);

	$user_path = &get_user_path("$users{$FORM{'match'}}");
	if(-e "$datapath/$user_path/matches.txt") {
		unless(open(MATCHES,"$datapath/$user_path/matches.txt")) {
		    &system_error("Can't read Matches File for $users{$FORM{'match'}}.\n");
		    exit;
		}
		@matches = <MATCHES>;
		close(MATCHES);
		chomp(@matches);

		open(MATCHES,">$datapath/$user_path/matches.txt") || &system_error("Can't write to matches.txt.(1295)\n");
		flock MATCHES, 2 if $lockon eq 'yes';
		seek (MATCHES, 0, 0);
		for $line (@matches) {
			next if $line =~ /^$FORM{'nickname'}\t/;
			print MATCHES "$line\n";
		}
		close(MATCHES);
	}

	&get_file_names("$FORM{'password'}", "$users{$FORM{'match'}}");
	unlink ("$datapath/$board_messagefile");
	unlink ("$datapath/$board_datafile");

	$main_menu;
}


#################################################
#################################################
# Main Menu Routine

sub main_menu {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<H1><i><CENTER>Main Menu for $FORM{'nickname'}</CENTER></i></H1>\n";
	print "<table class=linkbar align=center width=\"90%\"><tr><td align=center><a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=view>[View Your Profile]</a>\n";
	($search_script = $ENV{'SCRIPT_NAME'}) =~ s/index/search/i;
	print "<a class=light href=$search_script?nickname=$esc_nick&ID=$FORM{'ID'}>[Quick Search]</a>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=newpass>[Change Password]</a>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=mainhelp target=_blank>[Help]</a>\n";
	print "<a class=light href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=logout>[Exit e_Match]</a><br>\n";
	print "</td></tr></table>\n";
	&list_matches;
	print "$footer";
	exit;
}

#################################################
# generate match list HTML subroutine

sub list_matches {
	$user_path = &get_user_path($FORM{'password'});
	if(-e "$datapath/$user_path/matches.txt") {
		unless(open(MATCHES,"$datapath/$user_path/matches.txt")) {
		    &system_error("Can't open Matches File for $FORM{'nickname'}.\n");
		    exit;
		}
		@match_list = <MATCHES>;
		close(MATCHES);
		chomp(@match_list);
	}else {
		@match_list = ();
	}
	$num_profiles = $#password_list + 1;
	if ($#match_list == -1) {
		print "<p><CENTER><BIG>You have no matches at this time.</BIG></CENTER><p>\n";
		print "<center>There are currently $num_profiles profiles on file.</center>\n";
		return;
	}
	%match_list = ();
	for $match (@match_list) {
		($name, $score) = split (/\t/, $match, 2);
		$score -= 1000000000 if $score >= 500000000;
		$match_list{$name} = $score;
	}

	print "<table width=\"100%\" border><CAPTION><B><I>Current Matches</I></B></CAPTION>\n";
	$i = 0;

	for $name (sort{$match_list{$b} <=> $match_list{$a}} keys (%match_list)) {
		$i++;
		# check if board exists
		&get_password_list;
		&get_file_names("$FORM{'password'}", "$users{$name}");
		next unless(-e "$datapath/$board_datafile");
		unless(open(DATAFILE,"$datapath/$board_datafile")) {
		        &system_error("Can't read $datapath/$board_datafile.\n");
		        exit;
		}
		@data = <DATAFILE>;
		close(DATAFILE);
		chomp(@data);

		next if $data[0] == 0 and $i > $max_matches and $match_list{$name} != 0;
		$esc_match_name = $name;
		$esc_match_name =~ s/([^\w])/sprintf("%%%02x", ord($1))/ge;

		if($data[0] != 0) {
			$bgcolor = 'white';
			$score_text = 'Active';
		}elsif($match_list{$name} == 0 ) {
			$bgcolor = '#FFFFE0';
			$score_text = 'Temporary';
		}else {
			$bgcolor = '';
			$score_text = $match_list{$name};
		}

		print "<tr";
		print " bgcolor=$bgcolor" if $bgcolor ne '';
		print "><td>Nickname: <b>$name</b> - Rating: <b>$score_text</b></td><td><a href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=viewmatch&match=$esc_match_name>[View $name\'s Profile]</a>";
		print "<img src=\"$main_url/html/photo.gif\">" if (-e "$html_path/pics/$name.gif") or (-e "$html_path/pics/$name.jpg");
		print "</td>\n";
		print "<td><a href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=viewboard&match=$esc_match_name>[View Board]</a>\n";
		print "Status: \n";
		if($data[0] == 0) {
			print '<b>Empty</b>';
		}else {
			if($data[1] eq $FORM{'nickname'}) {
				if($data[2] eq $data[0]) {
					if($data[4] eq $data[0]) {
						print '<b>Read</b>';
					}else {
						print '<b>Posted</b>';
					}
				}else {
					print '<b>New</b>';
				}
			}else {
				if($data[4] eq $data[0]) {
					if($data[2] eq $data[0]) {
						print '<b>Read</b>';
					}else {
						print '<b>Posted</b>';
					}
				}else {
					print '<b>New</b>';
				}
			}
		}
	print "</td>\n";
	print "<td><a href=$ENV{'SCRIPT_NAME'}?nickname=$esc_nick&ID=$FORM{'ID'}&mode=nukecheck&match=$esc_match_name>[Nuke'em]</a><br></td>\n";
	print "</tr>\n";
	}
print "</table>\n";
print "<center>There are currently $num_profiles profiles on file.</center>\n";
}

#################################################
#################################################
# Generate Log On Form Routine

sub logon {
	print "Content-type: text/html\n\n";
	print "<html><head><title>e_Match</title>$header\n";
	print "<h1 align=center><i><CENTER>Log on to e_Match</CENTER></i></h1>\n";
	print "<form action=$ENV{'SCRIPT_NAME'} method=POST>\n";
	print "<center><table><tr><td>Nickname:</td><td><input type=text name=nickname><br></td></tr>\n";
	print "<tr><td>Password:</td><td><input type=password name=password><br></td></tr>\n";
	print "<input type=hidden name=mode value=logon>\n";
	print "<tr><td></td><td><input type=submit><input type=reset></td></tr></table>\n";
	print "<hr>NOTE: If you have not yet registered for e_Match, click <a href=\"$ENV{'SCRIPT_NAME'}?mode=registerform\"><B>HERE</B></a> to do so.  <br>You won't be able to log on unless you register first.</center>\n";
	print"<hr><center><big><A HREF=\"pchecker.cgi\">Forget Your Nickname/Password?</A></big></center>\n";
	print "$footer";
	exit;
}

#################################################
#################################################
# Subroutines

#################################################
# read profile templates subroutine

sub read_form_files {

	@form_files = &listdir("$datapath/form", "ascii");

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
		open (SUBJECT, "$datapath/form/$subject_file") || &system_error("Can't open to $datapath/form/$subject_file");

		@subjectlist = <SUBJECT>;
		close(SUBJECT);
		chomp @subjectlist;
		for (@subjectlist) {
			($name, $value) = split (/\t/, $_, 2);
			$SUBJECT{$name} = $value;
		}
	}

	foreach $object_file (@object_form_files) {
		open (OBJECT, "$datapath/form/$object_file") || &system_error("Can't open to $datapath/form/$object_file");

		@objectlist = <OBJECT>;
		close(OBJECT);
		chomp @objectlist;
		for (@objectlist) {
			($name, $value) = split (/\t/, $_, 2);
			$OBJECT{$name} = $value;
		}
	}

	foreach $interests_file (@interests_form_files) {
		open (INTERESTS, "$datapath/form/$interests_file") || &system_error("Can't open to $datapath/form/$interests_file");

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
# get profile data subroutine

sub get_profile {
	my($pword) = shift(@_);
	$pword = &get_user_path($pword);
	if(-e "$datapath/$pword/profile.txt") {
		unless(open (PROFILE, "$datapath/$pword/profile.txt")) {
			&system_error("Can't read $datapath/$pword/profile.txt");
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
# get new profile data subroutine

sub get_new_profile {
	my($pword) = shift(@_);
	$pword = &get_user_path($pword);
	if(-e "$datapath/$pword/profile.new") {
		unless(open (PROFILE, "$datapath/$pword/profile.new")) {
			&system_error("Can't read $datapath/$pword/profile.new");
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
		}elsif(($item =~ /xComment/) and ($PROFILE_ITEMS{$item})) {
			$PROFILE_ITEMS{$item} =~ s/\*p\*/<p>/gs;
			$PROFILE_ITEMS{$item} =~ s/\*br\*/<br>/gs;
			if ($profile_nick) {
				print "</table><p align=center><b>$profile_nick\'s Comment:</b><br><table class=profile align=center width=\"90%\"><tr><td align=center>$PROFILE_ITEMS{$item}</td></tr></table>\n";
			}else {
				print "</table><p align=center><b>Comment:</b><br><table class=profile align=center width=\"90%\"><tr><td align=center>$PROFILE_ITEMS{$item}</td></tr></table>\n";
			}
		}
	}
	print "</td></tr></table>\n";
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
# get user path
#

sub get_user_path {
	$sub_path = shift(@_);
	$sub_init = substr($sub_path, 0, 1);
	$path_sum = "$sub_init/$sub_path";
	mkdir ("$datapath/$sub_init", 0777) unless(-e "$datapath/$sub_init");
	&makepage("$datapath/$sub_init") unless(-e "$datapath/$sub_init/index.html");
	mkdir ("$datapath/$path_sum", 0777) unless(-e "$datapath/$path_sum");
	return ($path_sum);
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
# Make empty page to hide data

sub makepage {
	my $path = shift;
	unless(open(PAGE,">$path/index.html")) {
		&system_error("Can't write blank page to $path.\n");
		exit;
	}
	print PAGE "<html><head>\n";
	print PAGE "<title></title>\n";
	print PAGE "</head>\n";
	print PAGE "<body>\n";
	print PAGE "hi\n";
	print PAGE "</body></html>\n";
	close(PAGE);
}

#################################################
# Error subs

sub system_error {
        local($errmsg) = @_;
        &print_header("System Error");
        print $errmsg;
        &print_footer;
}

sub print_header {
        local($title) = @_;
        print "Content-type: text/html\n\n";
        print "<HTML>\n";
        print "<HEAD>\n";
        print "<TITLE>$title</TITLE>\n";
        print "</HEAD>\n";
        print "<body>\n";
        print "<H1>$title</H1>\n";
}

sub print_footer {
        print "$footer\n";
}

#################################################

sub expire_user_files {
	my($nickname, $password, $mode) = @_;
	$user_path = &get_user_path($password);
	if(-e "$datapath/$user_path/matches.txt") {
		unless(open(MATCHES,"$datapath/$user_path/matches.txt")) {
		    &system_error("Can't open $datapath/$user_path/matches.txt.\n");
		    exit;
		}
		@match_list = <MATCHES>;
		close(MATCHES);
		chomp(@match_list);
		foreach $match (@match_list) {		
			$match =~ s/^(.*)\t.*$/$1/;
			#delete all board and data files;
			next unless exists($users{$match});
			$match_pass = $users{$match};
			&get_file_names($match_pass, $password);
			unlink("$datapath/$board_messagefile") if $mode eq 'all';
			unlink("$datapath/$board_datafile") if $mode eq 'all';
			#delete nickname from match's list;
			$match_path = &get_user_path($match_pass);
			if(-e "$datapath/$match_path/matches.txt") {
				unless(open(MATCHES,"$datapath/$match_path/matches.txt")) {
				    &system_error("Can't read Matches File for $match.\n");
				    exit;
				}
				@match_matches = <MATCHES>;
				close(MATCHES);
				chomp(@match_matches);

				open(MATCHES,">$datapath/$match_path/matches.txt") || &system_error("Can't write to matches.txt.(1689)\n");
				flock MATCHES, 2 if $lockon eq 'yes';
				seek (MATCHES, 0, 0);
				for $mmatch (@match_matches) {
					print MATCHES "$mmatch\n" if $mmatch !~ /^$nickname\t/;
				}
				close(MATCHES);
			}
		}
	}
}

#################################################
# log out

sub log_out {
	my($ID) = @_;

	&delete_ID($ID);

	print "Location: $exiturl\n\n";
}

#################################################
#################################################
# Get Password List Routine
#
# generates @password_list,
# %users,
# and %addresses
# from log.

sub get_password_list {
	my($nickname, $password, $email, $line);
	@password_list = ();
	unless(open(USERDATA,"$logpath/$log")) {
        &system_error("Can't read log.\n");
        exit;
	}
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

sub listdir {
	my ($dirpath, $type) = @_;
	opendir(DIR, "$dirpath");
	@raw = sort grep(!/^\./, readdir(DIR));
	closedir(DIR);
	@file_list = ();
	for $item(@raw) {
		next if(-d "$dirpath/$item") and $type ne 'subdir';
		next if(-T "$dirpath/$item") and $type ne 'ascii';
		next if(-B "$dirpath/$item") and $type ne 'binary';
		push(@file_list, $item);
	}
        return(@file_list);
}
sub email_link {
	&get_password_list;

	if($addresses{$FORM{'nickname'}} eq '') {
		print "<A class=light HREF=\"add_email.cgi\">[Restore Email Address to Database]</A>\n";
	}
}

#################################################
#################################################

sub make_ID {
	my($password) = @_;

	srand;
	@n = split(/ */, "lO01");
	$this_ID = '';
	for(1..16) {
		$this_ID .= "$n[int(rand(4))]";
	}

	open(IDS,"+>>$logpath/id.txt") || &return_page('System Error', "Can't write.(2373)\n");
	 flock IDS, 2 if $lockon eq 'yes';

	 seek (IDS, 0, 0);
	 @lines = <IDS>;

	 $time = time;
	 push(@lines, "$this_ID\t$password\t$time\n");

	 seek (IDS, 0, 0);
	 truncate (IDS, 0);
	 print IDS @lines;
	 close(IDS);

	 return($this_ID);
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
	&return_page("ID not found.", "Your ID was not found.  Return to <a href=$ENV{'SCRIPT_NAME'}>HERE</a> to log on.");
}

# delete ID and check for expired IDs

sub delete_ID {

	my($ID) = @_;

	open(IDS,"+>>$logpath/id.txt") || &return_page('System Error', "Can't write to id.txt.(2434)\n");
	flock IDS, 2 if $lockon eq 'yes';

	seek (IDS, 0, 0);
	@lines = <IDS>;
	chomp(@lines);

	@keepers = ();

	foreach $line (@lines) {
		$time  = time - 24*60*60;
		($this_ID, $this_pass, $this_time) = split(/\t/, $line);
		push(@keepers, "$line\n") if $this_ID ne $ID and $time < $this_time;
	}


	seek (IDS, 0, 0);
	truncate (IDS, 0);
	print IDS @keepers;

	close(IDS);
}

#################################################
# Return HTML

sub return_page {
	my($heading, $message) = @_;
	&print_header($heading);
	print $message;
	&print_footer;
	exit;
}



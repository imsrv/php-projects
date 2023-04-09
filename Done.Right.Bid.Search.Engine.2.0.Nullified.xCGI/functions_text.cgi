package database_functions;
my $path = ""; # With a slash at the end
use vars qw(%config);
undef %config;
local %config = ();
do "${path}config/config.cgi";
my $file_ext = "$config{'extension'}";
if ($file_ext eq "") { $file_ext = "cgi"; }
do "${path}functions.$file_ext";

### USED BY ALL FILES ###
###############################################
# admin.cgi, view.cgi
sub count_members {
	my ($processing, $addition, $balanceaddon, $active, $inactive, $bu_users) = @_;
	if ($bu_users) { open (FILE, "${path}data/backup/processing.txt"); }
	else { open (FILE, "${path}data/processing.txt"); }
	@{$processing} = <FILE>;
	close (FILE);
	my $processing2 = @{$processing};
	if ($bu_users) { open (FILE, "${path}data/backup/active.txt"); }
	else { open (FILE, "${path}data/active.txt"); }
	@{$active} = <FILE>;
	close (FILE);
	my $active2 = @{$active};
	if ($bu_users) { open (FILE, "${path}data/backup/inactive.txt"); }
	else { open (FILE, "${path}data/inactive.txt"); }
	@{$inactive} = <FILE>;
	close (FILE);
	my $inactive2 = @{$inactive};
	open (FILE, "${path}data/balanceaddon.txt");
	@{$balanceaddon} = <FILE>;
	close (FILE);
	my $balanceaddon2 = @{$balanceaddon};
	open (FILE, "${path}data/addition.txt");
	@{$addition} = <FILE>;
	close (FILE);
	my $addition2 = @{$addition};
	return ($processing2, $active2, $inactive2, $addition2, $balanceaddon2);
}
###############################################

###############################################
sub GetUser {
	my ($account, $backup, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	if ($backup) { open (FILE, "${path}data/backup/users/$account.txt"); }
	else { open (FILE, "${path}data/users/$account.txt"); }
	my @user = <FILE>;
	close (FILE);
	chomp(@user);
	return @user;
}
###############################################

###############################################
sub GetSites {
	my ($account, $backup, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	if ($backup) { open (FILE2, "${path}data/backup/sites/$account.txt"); }
	else { open (FILE2, "${path}data/sites/$account.txt"); }
	my @sites = <FILE2>;
	close (FILE2);
	chomp(@sites);
	return @sites;
}
###############################################

###############################################
sub GetBalance {
	my ($account, $backup) = @_;
	if ($backup) { open (FILE, "${path}data/backup/balance/$account.txt"); }
	else { open (FILE, "${path}data/balance/$account.txt"); }
	my $balance = <FILE>;
	close (FILE);
	chomp($balance);
	return $balance;
}
###############################################

###############################################
sub GetStats {
	my ($account, $backup) = @_;
	if ($backup) { open (FILE, "${path}data/backup/stats/$account.txt"); }
	else { open (FILE, "${path}data/stats/$account.txt"); }
	my @stats = <FILE>;
	close (FILE);
	chomp(@stats);
	return @stats;
}
###############################################

###############################################
sub GetSearch {
	my ($keywords) = @_;
	open(FILE,"${path}data/search/$keywords.txt");
	flock (FILE,2);
	my @listing = <FILE>;
	flock (FILE,8);
	close(FILE);
	return(@listing);
}
###############################################

###############################################
sub GetSiteId {
	my ($account, $backup) = @_;
	my $id = 1;
	my @sites = &GetSites($account, $backup);
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[6] >= $id) { $id = $inner[6]+1; }
	}
	return($id);
}
###############################################

###############################################
sub outbidded {
	my ($term, $bid, $account, $alreadylisted, $oldbid, $process) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	if ($opt[8] eq "CHECKED" && $alreadylisted == 0) {
		my ($rank2, $bidhigh);
		open (FILE, "${path}data/search/$term.txt");
		my @search = <FILE>;
		close (FILE);
		foreach my $line3(@search) {
			chomp($line3);
			my @inner3 = split(/\|/, $line3);
			$rank2++;
			if ($inner3[1] eq $account) {
				$bidhigh = 1;
			} elsif ($bidhigh == 1) {
				open (FILE, "${path}data/users/$inner3[1].txt");
				my @userinfo = <FILE>;
				close (FILE);
				chomp(@userinfo);
				my $oldposition = $rank2-1;
				&main_functions::emailoutbid($account, $term, $oldposition, $rank2, @userinfo);
			}
		}
	}	
}
###############################################

###############################################
# members.cgi, view.cgi
sub stat_activity {
	my ($account) = @_;
	my @stat = &GetStats($account);
	my ($counter, $grand, $divider, $numb, $statsnumb);
	my (@date, @firstday, @secondday, @thirdday);
	foreach my $line(@stat) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[0] eq "[payment history]") {
			my $t = 0;
			foreach my $inn(@inner) {
				chomp($inn);
				unless ($t == 0) {
					my @seper = split(/\^/, $inn);
					$date[$t] = $seper[0];
				}
				$t++;
			}
			if ($inner[4]) {
				@firstday = split(/\^/, $inner[2]);
				@secondday = split(/\^/, $inner[3]);
				@thirdday = split(/\^/, $inner[4]);
				$numb = 3;
			} elsif ($inner[3]) {
				@firstday = split(/\^/, $inner[1]);
				@secondday = split(/\^/, $inner[2]);
				@thirdday = split(/\^/, $inner[3]);
				$numb = 3;
			} elsif ($inner[2]) {
				@firstday = split(/\^/, $inner[1]);
				@secondday = split(/\^/, $inner[2]);
				$numb = 2;
			} else {
				@firstday = split(/\^/, $inner[1]);
				$numb = 1;
			}
			my $total = ($firstday[2]+$secondday[2]+$thirdday[2])/$numb; # Add up the amounts for the last 3 days and get an average
			$grand = $grand+$total; # Get the total amount
			$statsnumb++;
		}
	}
	return ($grand, $statsnumb, @date);
}
###############################################

###############################################
sub sortit {
	my ($file, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	open (FILE, "${path}data/search/$file.txt");
	flock (FILE,2);
	my @listings = <FILE>;
	flock (FILE,8);
	close(FILE);
	my @sorted_links =
	reverse sort {
		my @field_a = split /\|/, $a;
		my @field_b = split /\|/, $b;
		$field_b[5] =~ s/-//g;
		$field_a[5] =~ s/-//g;
			$field_a[0] <=> $field_b[0]
					||
			$field_b[5] <=> $field_a[5]
			;
		} @listings; 
	open (FILE, ">${path}data/search/$file.txt");
	flock (FILE,2);
	print FILE @sorted_links;
	flock (FILE,8);
	close(FILE);
}
###############################################

###############################################
# signup.cgi, admin.cgi
sub update_balance {
	my ($username, $balanceordered, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	open (FILE, ">${path}data/balance/$username.txt");
	print FILE "$balanceordered";
	close (FILE);
}
###############################################

###############################################
sub addstatus {
	my ($type, $username) = @_;
	open (FILE, ">>${path}data/$type.txt");
print FILE <<EOF;
$username
EOF
	close (FILE);
}
###############################################


### USED BY ADDONS.CGI ###
###############################################
sub get_daily_stats {
	open (FILE, "${path}track/daily.txt");
	my @data=<FILE>;
	close(FILE);
	my ($a, %month, %day);
	foreach (@data) {
		my @daily = split(/\|/,$data[$a]);
		my @date = split(/\-/, $daily[0]);
		my ($month, $newdate, $olddate);
		unless ($date[1] eq "") {
			my $mon=$date[1];
			if ($mon == 1) { $month = "January"; }
			elsif ($mon == 2) { $month = "Febuary"; }
			elsif ($mon == 3) { $month = "March"; }
			elsif ($mon == 4) { $month = "April"; }
			elsif ($mon == 5) { $month = "May"; }
			elsif ($mon == 6) { $month = "June"; }
			elsif ($mon == 7) { $month = "July"; }
			elsif ($mon == 8) { $month = "August"; }
			elsif ($mon == 9) { $month = "September"; }
			elsif ($mon == 10) { $month = "October"; }
			elsif ($mon == 11) { $month = "November"; }
			elsif ($mon == 12) { $month = "December"; }
			if ($date[2]) {
				$day{$daily[0]} = "$month $date[2], $date[0]|$daily[1]";
			} else {
				$month{$daily[0]} = "$month $date[0]|$daily[1]";
			}
		}
		$a++;
	}
	
	foreach my $key(reverse sort keys %day) {
		my @inner = split(/\|/, $day{$key});
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$inner[0]</font></td>
<td align=right><font face="verdana" size="-1" color="red">$inner[1]</font></td>
</tr>
EOF
	}
	
	if (%month) {
print <<EOF;
<tr><td colspan=2>&nbsp;<BR><font face="verdana" size="-1" color="#000066"><B><center>Monthly Statistics</center></B></font></td></tr>
<tr>
<td width="70%"><font face="verdana" size="-1"><B>Date</B></font></td>
<td width="30%" align=right><font face="verdana" size="-1"><B>Searches</B></font></td>
</tr>
EOF
		foreach my $key(reverse sort keys %month) {
			my @inner = split(/\|/, $month{$key});
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$inner[0]</font></td>
<td align=right><font face="verdana" size="-1" color="red">$inner[1]</font></td>
</tr>
EOF
		}
	}
}
###############################################

###############################################
sub count_top_searches {
	my $count;
	open (FILE, "${path}track/tracker.txt");
	my @data=<FILE>;
	close(FILE);
	foreach (@data) { $count++; }
	return($count);
}
###############################################

###############################################
sub get_top_searches {
	my ($start) = @_;
	open (FILE, "${path}track/tracker.txt");
	my @data=<FILE>;
	close(FILE);
	my $b=1;
	my $a=0;
	foreach my $line(@data) {
		if ($b >= $start) {
			chomp($line);
			my @track = split(/\|/,$line);
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$b.</font></td>
<td><font face="verdana" size="-1">$track[1]</font></td>
<td align=right><font face="verdana" size="-1" color="red">$track[0]</font></td>
</tr>
EOF
			$a++;
			last if ($a == 50);
		}
		$b++;
	}
}
###############################################

###############################################
sub delete_top_searches {
	my ($type) = @_;
	if ($type == 1) {
		open (FILE, "${path}track/tracker.txt");
		flock (FILE,2);
		my @data=<FILE>;
		flock (FILE,8);
		close(FILE);
		open (FILE, ">${path}track/tracker.txt");
		flock (FILE,2);
		foreach my $line(@data) {
			chomp($line);
			my @inner = split(/\|/, $line);
			unless ($inner[0] == 1) { print FILE "$line\n"; }
		}
		flock (FILE,8);
		close (FILE);
	} else {
		open (FILE, ">${path}track/tracker.txt");
		close(FILE);
	}
}
###############################################

###############################################
sub get_top_bids {
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	opendir(FILE,"${path}data/search");
	my @bids = grep { /.txt/ } readdir(FILE);
	close (FILE);
	my (@topbid, $f);
	foreach my $bid(@bids) {
		chomp($bid);
		open (FILE, "${path}data/search/$bid");
		my @search = <FILE>;
		close (FILE);
		foreach my $line(@search) {
			chomp($line);
			my @inner = split(/\|/, $line);
			$bid =~ s/\.txt//;
			unless ($inner[0] == "" || $bid eq "") {
				$topbid[$f] = "$inner[0]|$bid";
				$f++;
			}
		}
	}
	my $c;
	my @sorted = reverse sort { $a <=> $b } @topbid;
	foreach my $line(@sorted) {
		chomp($line);
		my ($bid, $term) = split(/\|/,$line);
		$c++;
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$c.</font></td>
<td><font face="verdana" size="-1">$term</font></td>
<td align=right><font face="verdana" size="-1">$adv[15]<font color="red">$bid</font></td>
</tr>
EOF
		if ($c == 25) { last; }
	}
}
###############################################


### USED BY ADMIN.CGI ###
###############################################
sub get_balanceaddon {
	my ($account) = @_;
	open (FILE, "${path}data/balanceaddon.txt");
	my @DATA = <FILE>;
	close (FILE);
	my ($balance2);
	foreach my $line(@DATA) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq $account) {
			$balance2 = $inner[1];
			last;
		}	
	}
	return($balance2);
}
###############################################

###############################################
sub change_status {
	my ($type, $account, $do) = @_;
	if ($do == 1) {
		my @user = &GetUser($account);
		$user[14] = $type;
		open (FILE, ">${path}data/users/$account.txt");
		foreach my $line(@user) {
			chomp($line);
			print FILE "$line\n";
		}
		close (FILE);
	} else {
		if ($type eq "add") { $type = "addition"; }
		open (FILE, ">>${path}data/$type.txt");
print FILE <<EOF;
$account
EOF
		close(FILE);
	}
}
###############################################

###############################################
sub remove_status {
	my ($file, $account) = @_;
	open (FILE, "${path}data/$file.txt");
	my @DATA = <FILE>;
	close (FILE);
	open (FILE, ">${path}data/$file.txt");
	foreach my $line(@DATA) {
		chomp($line);
		if ($file eq "balanceaddon") {
			my @split = split(/\|/, $line);
			$line = $split[0];
		}
		unless ($line eq $account) {
print FILE <<EOF
$line
EOF
		} 
	}
	close (FILE);	
}
###############################################

###############################################
sub update_sites {
	my ($term, $status, $account, $bid, $title, $url, $description) = @_;
	my $newdate = &main_functions::getdate;
	&add_listing($account, $newdate);
}
###############################################

###############################################
sub get_reviewer {
	open (FILE, "${path}config/reviewers.txt");
	my @reviewer = <FILE>;
	close (FILE);
	return(@reviewer);
}
###############################################

###############################################
sub add_reviewer {
	my ($username, $password) = @_;
	open (FILE, "${path}config/reviewers.txt");
	my @reviewer = <FILE>;
	close (FILE);
	my ($message, $found);
	foreach my $line(@reviewer) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "$username") {
			$message = "The <B>Username</B> you chose is <B>Already Taken</B>, please choose a different one<BR>";
			$found=1;
			last;
		}
	}
	unless ($found) {
		my $pass2 = $password;
		my $encryptkey = "bsereviewer";
		$password = &main_functions::Encrypt($password,$encryptkey,'asdfhzxcvnmpoiyk');
		my $newdate = &main_functions::getdate;
		open (FILE, ">>${path}config/reviewers.txt");
		print FILE "$username|$password|$newdate|0\n";
		close (FILE);
		$message = "Reviewer successfully added, please record this information.<BR>Username: $username<BR>Password: $pass2<BR>";
	}
	return($message);
}
###############################################

###############################################
sub delete_reviewer {
	my ($username) = @_;
	open (FILE, "${path}config/reviewers.txt");
	my @reviewer = <FILE>;
	close (FILE);
	open (FILE, ">${path}config/reviewers.txt");
	foreach my $line(@reviewer) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[0] eq "$username") {
			print FILE "$line\n";
		}
	}
	close (FILE);
	my $message = "'$username' reviewer has been deleted<BR>";
	return($message);
}
###############################################

###############################################
sub check_reviewerlogin {
	my ($username, $password, $formlogin) = @_;
	open (FILE, "${path}config/reviewers.txt");
	my @reviewer = <FILE>;
	close (FILE);
	my ($verified, $pass2);
	foreach my $line(@reviewer) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "$username") {
			$pass2 = $inner[1];
			my $pass = $inner[1];
			my $encryptkey = "bsereviewer";
			$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
			unless ($formlogin) {
				$password = &main_functions::Decrypt($password,$encryptkey,'asdfhzxcvnmpoiyk');
			}
			if ($password eq $pass) { $verified = 1; }
			last;
		}
	}
	unless ($verified) {
		print "Content-type: text/html\n\n";
		my $nolink=1;
		&main_functions::header('1');
		print "Access Denied. Please <a href=admin.$file_ext?tab=reviewer_login>click here</a> to login";
		&main_functions::footer;
		&main_functions::exit;
	} else {
		return($pass2);
	}
}
###############################################

###############################################
sub update_reviewer {
	my ($username) = @_;
	open (FILE, "${path}config/reviewers.txt");
	my @reviewer = <FILE>;
	close (FILE);
	open (FILE, ">${path}config/reviewers.txt");
	foreach my $line(@reviewer) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "$username") {
			my $newstat = $inner[3] + 1;
			print FILE "$inner[0]|$inner[1]|$inner[2]|$newstat\n";
		} else {
			print FILE "$line\n";
		}
	}
	close (FILE);
}
###############################################


### USED BY MEMBERS.CGI ###
###############################################
sub gather_statistics {
	my ($dat, $account, $view_date, $order_by, $viewing, $field, $myviewing) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my @stat = &GetStats($account);
	my (@member, $totalclicks, $totalcost, $plus);
	foreach my $line(@stat) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[0] eq "[payment history]") {
			my ($cost, $click, $t);
			foreach my $inn(@inner) {
				chomp($inn);
				unless ($t == 0) {
					my @seper = split(/\^/, $inn);
					if ($viewing eq "All") {
						$cost += $seper[2];
						$click += $seper[1];
					} else {
						if ($seper[0] eq "$viewing") {
							$cost += $seper[2];
							$click += $seper[1];
						}
					}
					if ($cost eq "" || $cost == 0) { $cost = "0.00"; }
					$member[$plus] = "$inner[0]|$click|$cost\n"; # store in @member: "keyword1|clicks|cost"
				}
				$t++;
			}
			$plus++; # Find out how many keyword stats are available
		}
	}
	my $divider = $plus;
	my @sorted_links = &main_functions::link_sort($plus, $field, undef, @member);
	my (@term, @date, @clicks, @amount, $grand);
	foreach my $member(@sorted_links) {
		chomp($member);
		my @inner = split(/\|/, $member);
		$inner[2] = sprintf("%.2f", $inner[2]);
		my $temp = $dat;
		$temp =~ s/<!-- \[keyword\] -->/$inner[0]/ig;
		$temp =~ s/<!-- \[clicks\] -->/$inner[1]/ig;
		$temp =~ s/<!-- \[cost\] -->/$adv[15]$inner[2]/ig;
		print $temp;
		$totalclicks += $inner[1];
		$totalcost += $inner[2];
	}
	return ($totalclicks, $totalcost);
}
###############################################

###############################################
sub profile_update {
	my ($pass2, $user, %FORM) = @_;
	my @info = &GetUser($user);
	open (FILE, ">${path}data/users/$user.txt");
print FILE <<EOF;
$FORM{'name'}
$FORM{'address1'}
$FORM{'address2'}
$FORM{'city'}
$FORM{'state'}
$FORM{'zip'}
$FORM{'country'}
$FORM{'phone'}
$FORM{'email'}
$info[9]
$info[10]
$info[11]
$info[12]
$pass2
$info[14]
$info[15]
$info[16]

$FORM{'company'}
EOF
	close (FILE);
}
###############################################

###############################################
sub active {
	my ($user, %FORM) = @_;
	my @users = &GetUser($user);
	unless ($users[14] eq "active") {
		my $message = "The current status of your account is <B>$users[14]</B> and as a result this function has been disabled for the time being.";
		return ($message);
	}
	my $balance = &GetBalance($user);
	if ($balance eq "0" || $balance eq "") {
		my $message = "You have no funds in your account and as a result this function has been disabled for the time being.";
		return ($message);
	}
	if ($FORM{'tab'} eq "bids" || $FORM{'tab'} eq "editlisting") {
		my @sites = &GetSites($user);
		if ($sites[0] eq "") {
			my $message = "You have no listings setup for your account and as a result this function has been disabled for the time being.";
			return ($message);
		}
	}
}
###############################################

###############################################
sub edit_site {
	my ($user, $newdate, %FORM) = @_;
	my $count;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my $site_id = &GetSiteId($user);
	my @sites = &GetSites($user);
	open (FILE, ">${path}data/sites/$user.txt");
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "Non-Targeted Listing" || $inner[5] eq "new") {
print FILE <<EOF;
$line
EOF
		} else {
			$count++;
			my ($keyword, $title, $description, $url, $bid);
			($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
			my $id = "id$count";
			if ($FORM{$id} eq "") {
				$FORM{$id} = $site_id;
				$site_id++;
			}
			if ($opt[9] eq "CHECKED") {
				if ($FORM{$keyword} ne $inner[0] || $FORM{$bid} ne $inner[1] || $FORM{$title} ne $inner[2] || $FORM{$url} ne $inner[3] || $FORM{$description} ne $inner[4]) {
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}|edit|$FORM{$id}|$line
EOF
				} else {
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}||$FORM{$id}
EOF
				}
			} else {
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}||$FORM{$id}
EOF
			}
		}
	}
	close (FILE);
}
###############################################

###############################################
sub update_credit {
	my ($p, $proact, $user, %FORM) = @_;
	my @info = &GetUser($user);
	open (FILE, ">${path}data/users/$user.txt");
print FILE <<EOF;
$info[0]
$info[1]
$info[2]
$info[3]
$info[4]
$info[5]
$info[6]
$info[7]
$info[8]
$FORM{'chname'}
$p
$FORM{'expire'}
$info[12]
$info[13]
$proact
$info[15]
$info[16]
EOF
	close (FILE);
}
###############################################

###############################################
sub create_stat {
	my ($user, $newdate) = @_;
	my @stats = &GetStats($user);
	my $statexists;
	foreach my $line(@stats) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "Non-Targeted Listing") {
			$statexists = 1;
			last;
		}	
	}
	unless ($statexists) {
		open (FILE, ">>${path}data/stats/$user.txt");
print FILE <<EOF;
Non-Targeted Listing|$newdate^0
EOF
		close (FILE);
	}
}
###############################################

###############################################
sub add_listing {
	my ($member, $newdate, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	my @sites = &GetSites($member, $datapath);
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[5] eq "new") {
			open (FILE, "${path}data/search/$inner[0].txt");
			my @search = <FILE>;
			close(FILE);
			open (FILE, ">${path}data/search/$inner[0].txt");
			my $foundit;
			foreach my $line(@search) {
				chomp($line);
				my @inner2 = split(/\|/, $line);
				if ($inner2[1] eq $member) {
					unless ($foundit) {
						$foundit=1;
						print FILE "$inner[1]|$member|$inner[2]|$inner[3]|$inner[4]|$newdate|$inner[6]\n";
					}
				} else {
					print FILE "$line\n";
				}
			}
			unless ($foundit) {
				print FILE "$inner[1]|$member|$inner[2]|$inner[3]|$inner[4]|$newdate|$inner[6]\n";
			}
			close (FILE);
			&sortit($inner[0], $datapath);
		}
	}
}
###############################################

###############################################
sub getbid {
	my ($user, $term_submit, $temp) = @_;
	my $position = 1;
	my ($bidtobe1, $t);
	open(FILE, "${path}data/search/$term_submit.txt");
	my @search = <FILE>;
	close(FILE);
	foreach my $line2(@search) {
		chomp($line2);
		my @inner2 = split(/\|/, $line2);
		my ($bid, $date, $user2) = ($inner2[0], $inner2[5], $inner2[1]);
		if ($user2 eq $user) { last; }
		if ($t == 0) { $bidtobe1 = $bid; }
		$position++;
		$t++;
	}
	close (FILE);
	return ($bidtobe1, $position);
}
###############################################

###############################################
sub get_nontargeted {
	my ($user) = @_;
	my @sites = &GetSites($user);
	my ($nontargetedexists, $title, $description, $url, $bid);
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "Non-Targeted Listing") {
			$nontargetedexists = 1;
			($title, $description, $url, $bid) = ($inner[2], $inner[4], $inner[3], $inner[1]);
			last;
		}	
	}
	return ($title, $description, $url, $bid, $nontargetedexists);
}
###############################################

###############################################
sub nontargeted_sites {
	my ($user, $opt9, $newdate, %FORM) = @_;
	my ($noner, $site_bid, $addition);
	if ($opt9 eq "CHECKED") { $addition = "new"; }
	my @sites = &GetSites($user);
	open (FILE, ">${path}data/sites/$user.txt");
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[0] eq "Non-Targeted Listing") { print FILE "$line\n"; }
		else {
			$noner = "|$line";
			$site_bid = $inner[1];
		}
	}
print FILE <<EOF;
Non-Targeted Listing|$FORM{'bid'}|$FORM{'title'}|$FORM{'url'}|$FORM{'description'}|$addition||$noner
EOF
	close (FILE);
	return ($site_bid);
}
###############################################


###############################################
sub payment_history {
	my ($user, $newdate, $newbalance, $invoice) = @_;
	my @stat = &GetStats($user);
	my $a = 0;
	open(FILE, ">${path}data/stats/$user.txt");
	foreach my $line(@stat) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq "[payment history]") {
			print FILE "$line|$newdate^0^$newbalance^$invoice\n";
			$a = 1;
		} else {
			print FILE "$line\n";
		}
	}
	unless ($a) {
		print FILE "[payment history]|$newdate^0^$newbalance^$invoice\n";
	}
	close (FILE);
}
###############################################

###############################################
sub bulk_upload {
	my ($user, %FORM) = @_;
	use vars qw(%config);
	undef %config;
	local %config = ();
	do "${path}config/config.cgi";
	my $site_id = &GetSiteId($user);
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my ($addition);
	if ($opt[9] eq "CHECKED") { $addition = "new";	}
	my $newdate = &main_functions::getdate;
	my $numb = 1;
	#open (FILE, ">test.txt");
	my $keyword = "keyword$numb";
	#print FILE "dddd $keyword, $FORM{$keyword}";
	open (FILE, ">>${path}data/sites/$user.txt");
	while ($FORM{$keyword}) {
		my ($title, $description, $url, $bid);
		($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($numb, %FORM);
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}|$addition|$site_id
EOF
		$numb++;
		$site_id++;
		$keyword = "keyword$numb";
	}
	close (FILE);
	if ($opt[9] eq "CHECKED") {
		my @info = &GetUser($user);
		&remove_status('addition', $user);
		&addstatus('addition', $user);
		my $subject = "Search Listing - Addition";
		my $emailmessage = "The following member has just added listings and is waiting for them to be approved:\n\n";
		$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\n\n";
		if ($opt[9] eq "CHECKED") { $emailmessage .= "Login to the admin to process this order:\n$config{'adminurl'}admin.$file_ext\n"; }
		&main_functions::send_email($config{'adminemail'}, $config{'adminemail'}, $subject, $emailmessage);
	} else {
		&add_listing($user, $newdate);
	}
}
###############################################


### USED BY SEARCH.CGI ###
###############################################
sub get_bids {
	my ($searchterm, $temp, @temparray) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	unless (-e "${path}data/search/$searchterm.txt") {
		&openbid($temp, $adv[15], $adv[14]);
	} else {
		open (FILE, "${path}data/search/$searchterm.txt");
		my @search = <FILE>;
		close (FILE);
		if ($search[0] eq "") { &openbid($temp); }
		else {
			print "Content-type: text/html\n\n";
			print "$temparray[0]";
			my $rank;
			foreach my $line(@search) {
				chomp($line);
				my $temp = "$temparray[1]";
				my @inner = split(/\|/, $line);
				$rank++;
				$temp =~ s/<\!-- \[position\] -->/$rank/ig;
				$temp =~ s/<\!-- \[title\] -->/$inner[2]/ig;
				$temp =~ s/<\!-- \[url\] -->/$inner[3]/ig;
				$temp =~ s/<\!-- \[bid\] -->/$adv[15]$inner[0]/ig;
				print "$temp";	
			}
		}
		print "$temparray[2]";
	}
	sub openbid {
		my ($temp, $adv15, $adv14) = @_;
		unless ($adv14) { $adv14 = "0.01"; }
		$temp =~ s/<\!-- \[error\] -->/There are no listings for this term.  You could be the number 1 position if you list your site under this term for ${adv15}$adv14 per click./ig;
		my @temparray = split(/<\!-- \[list\] -->/,$temp);
		print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
$temparray[2]
EOF
	}
}
###############################################

###############################################
sub open_listings {
	my ($bidkeys, $method, $adv17) = @_;
	my (@result);
	if (-e "${path}data/search/$bidkeys.txt") { @result = &gatherbids($bidkeys, undef, @result); }
	elsif ($method == 1) {
		my @splitbids = split(' ', $bidkeys);
		my $or = 1;
		foreach my $bidkeys(@splitbids) {
			chomp($bidkeys);
			if (-e "${path}data/search/$bidkeys.txt") { @result = &gatherbids($bidkeys, $or, @result); }
		}
	} else { @result = &gatherbids($bidkeys, undef, @result); }

	sub gatherbids {
		my ($bidkeys, $or, @result) = @_;
		open(FILE,"${path}data/search/$bidkeys.txt");
		if ($or) {
			my @result2 = <FILE>;
			@result = push(@result, @result2);
		} else {
			@result = <FILE>;
		}
		close(FILE);
		return(@result);
	}
	my $p = 0;
	foreach my $line(@result) {
		my @inner = split(/\|/, $line);
		my $balance = &database_functions::GetBalance($inner[1]);
		if ($balance <= 0) {
			my @splice = splice(@result, $p, 1);
		} elsif ($bidkeys eq "Non-Targeted Listing" && $p >= $adv17) {
			my @splice = splice(@result, $p, 1);
		}
		$p++;
	}
	return (@result);
}
###############################################

###############################################
sub update_stats {
	my ($keywords, $account, $newdatem, $bid, $id) = @_;
	my @stat = &GetStats($account);
	my @site = &GetSites($account);
	my ($grand, $statsnumb, @oldarray, $thedate, $avg, $newentry);
	foreach my $line(@stat) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[2] eq "" || $inner[3] eq "" || $inner[4] eq "") {
			my @firstday = split(/\^/, $inner[2]);
			my @secondday = split(/\^/, $inner[3]);
			my @thirdday = split(/\^/, $inner[4]);
			my $total = ($firstday[2]+$secondday[2]+$thirdday[2])/3;
			$grand = $grand+$total;
			$statsnumb++;
		}
		if ($inner[0] eq $keywords) {
			@oldarray = @inner;
			$thedate = $inner[1];
			last;	
		}
	}
	if ($grand) { $avg = $grand/$statsnumb; }
	my @sep = split(/\^/, $thedate);
	my $newdate = &main_functions::getdate;
	if ($sep[0] eq $newdate) {
		my $newbid;
		my $newclick = $sep[1]+1;
		unless ($sep[2]) { $newbid = ($bid*$sep[1])+$bid; }
		else { $newbid = $sep[2]+$bid; }
		$newentry = "$keywords|$newdate^$newclick^$newbid";
	} else {
		$newentry = "$keywords|$newdate^1^$bid|$thedate";
	}
	my @newarray = splice(@oldarray,0,2,$newentry);
	chomp(@oldarray);
	my $a = 0;
	open(FILE, ">${path}data/stats/$account.txt");
	foreach my $line(@stat) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq $keywords) {
			foreach my $new(@oldarray) {
				chomp($new);
				if ($a == 0) { print FILE "$new"; }
				else { print FILE "|$new"; }
				$a++;
			}
			print FILE "\n";
		} else {
			print FILE "$line\n";
		}
	}
	close (FILE);
	my $balance = &GetBalance($account);
	my $oldbalance = $balance;
	$balance = $balance - $bid;
	if ($balance < 0) { $balance = 0; }
	open(FILE,">${path}data/balance/$account.txt");
	flock (FILE,2);
	print FILE "$balance";
	flock (FILE,8);
	close(FILE);
	return ($grand, $avg, $balance, $oldbalance);
}
###############################################

###############################################
sub searcheslog {
	my ($displaykeys2) = @_;
	open (FILE, "${path}track/tracker.txt");
	flock (FILE,2);
	my @data=<FILE>;
	flock (FILE,8);
	close(FILE);
	my ($c, $found, $number, $trackword, $tracked);
	foreach my $track(@data) {
		chomp($track);
		my ($num, $key) = split(/\|/,$track);
		if ($key eq "$displaykeys2") {
			$found=1;
			$tracked=$c;
			$number=$num+1;
			$trackword=$key;
			last;
		}
		$c++;
	}
	if ($found) {
		$data[$tracked] = "$number|$trackword";
		my @sort = reverse sort { $a <=> $b }@data;
		open (FILE, ">${path}track/tracker.txt");
		flock (FILE,2);
		foreach my $line(@sort) {
			chomp($line);
print FILE <<EOF;
$line
EOF
		}
		flock (FILE,8);
		close(FILE);
	} else {
		open (FILE, ">>${path}track/tracker.txt");
print FILE <<EOF;
1|$displaykeys2
EOF
		close (FILE);
	}
}
###############################################

###############################################
sub dailystats {
	my $date = &main_functions::getdate;
	my ($current_year, $current_mon, $current_day) = split(/\-/, $date);
	open(FILE,"${path}track/daily.txt");
	flock (FILE,2);
	my @data=<FILE>;
	flock (FILE,8);
	close(FILE);
	open(FILE,">${path}track/daily.txt");
	flock (FILE,2);
	my ($count, %stat);
	foreach my $line(@data) {
		chomp($line);
		my ($statdate, $stat) = split(/\|/, $line);
		my ($year, $mon, $day) = split(/\-/, $statdate);
		if ($statdate eq $date && $count == 0) {
			my $newstat = $stat+1;
print FILE <<EOF;
$date|$newstat
EOF
		} elsif ($count == 0) {
print FILE <<EOF;
$date|1
$line
EOF
		} elsif ($day && $mon <=> $current_mon) {
			my $combine = "$year$mon";
			if (exists $stat{$combine}) {
				my @split = split(/\|/, $stat{$combine});
				$stat = $stat+$split[1];
				$stat{$combine} = "$split[0]|$stat";
			} else {
				$stat{$combine} = "$year-$mon|$stat";
			}
		} else {
print FILE <<EOF;
$line
EOF
		}
		$count++;
	}
	if (%stat) {
		foreach my $line(sort keys %stat) {
print FILE <<EOF;
$stat{$line}
EOF
		}
	}
	unless (@data) {
print FILE <<EOF;
$date|1
EOF
	}
	flock (FILE,8);
	close(FILE);
}
###############################################

###############################################
sub get_related {
	my ($match, $normalkeys, $adv6, $suggest) = @_;
	my (@related);
	open (FILE, "${path}track/tracker.txt");
	while(<FILE>) {
		chomp;
		my ($num, $key) = split(/\|/, $_);
		$_ = $key;
		/^$/ and next;
		if (&{$match}) {
			if ($suggest) {
				next if ($key =~ /\"/ || $key =~ /\'/);
				my $line;
				if ($key eq $normalkeys) { $line = "<B>$num</B>|<B>$key</B>"; }
				else { $line = "$num|$key"; }
				push(@related,$line);
			} else {
				push(@related,$key);
			}
			
			last if (scalar @related >= $adv6);
		}
	}
	close(FILE);
	return (@related);
}
###############################################

###############################################
sub popular {
	open (FILE, "${path}track/tracker.txt");
	my @data=<FILE>;
	close(FILE);
	return(@data);
}
###############################################

###############################################
sub unique_click {
	my ($keywords, $account) = @_;
	my $current_date = time();
	my ($noclick, $cookiefound);
	open (FILE, "${path}track/cookie.txt");
	my @cookie = <FILE>;
	close (FILE);
	
	open (FILE, ">${path}track/cookie.txt");
	flock (FILE,2);
	foreach my $line(@cookie) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $gettime = $current_date - $inner[0];
		unless ($gettime >= 86400) {
			print FILE "$line\n";
			if ($inner[1] eq "$ENV{'REMOTE_ADDR'}" && $inner[2] eq "$keywords" && $inner[3] eq "$account") {
				$noclick = 1;
			}
		}
	}
	flock (FILE,8);
	close(FILE);
	
	unless ($noclick) {
		$cookiefound = 0;
		open (FILE, ">>${path}track/cookie.txt");
		print FILE "$current_date|$ENV{'REMOTE_ADDR'}|$keywords|$account\n";
		close (FILE);
	} else {
		$cookiefound = 1;
	}
	return ($cookiefound);
}
###############################################


### USED BY SETTINGS.CGI ###
###############################################
sub backup_database {
	&remove_data('users');
	&remove_data('sites');
	&remove_data('balance');
	&remove_data('stats');
	sub remove_data {
		my ($file) = @_;
		opendir(FILE,"${path}data/backup/$file/");
		my @users = grep { /.txt/ } readdir(FILE);
		close (FILE);
		foreach my $line(@users) {
			chomp($line);
			unlink("${path}data/backup/$file/$line");
		}
		opendir(FILE,"${path}data/$file/");
		my @current_users = grep { /.txt/ } readdir(FILE);
		close (FILE);
		foreach my $line(@current_users) {
			chomp($line);
			open (FILE, "${path}data/$file/$line");
			my @data = <FILE>;
			close (FILE);
			open (FILE, ">${path}data/backup/$file/$line");
			foreach my $line(@data) {
				chomp($line);
				print FILE "$line\n";
			}
			close (FILE);
		}
	}
	
	&copy_status('active');
	&copy_status('inactive');
	&copy_status('processing');
	sub copy_status {
		my ($status) = @_;
		unlink("${path}data/backup/$status.txt");
		open (FILE, "${path}data/$status.txt");
		my @data = <FILE>;
		close (FILE);
		open (FILE, ">${path}data/backup/$status.txt");
		foreach my $line(@data) {
			chomp($line);
			print FILE "$line\n";
		}
		close (FILE);
	}
}
###############################################


### USED BY SIGNUP.CGI ###
###############################################
sub writeuser {
	my ($p, $pass, $proact, $newdate, %FORM) = @_;
	open (FILE, ">${path}data/stats/$FORM{username}.txt");
	close (FILE);
	open (FILE, ">${path}data/sites/$FORM{username}.txt");
	close (FILE);
	open (FILE, ">${path}data/users/$FORM{username}.txt");
print FILE <<EOF;
$FORM{'name'}
$FORM{'address1'}
$FORM{'address2'}
$FORM{'city'}
$FORM{'state'}
$FORM{'zip'}
$FORM{'country'}
$FORM{'phone'}
$FORM{'email'}
$FORM{'chname'}
$p
$FORM{'expire'}
$FORM{'username'}
$pass
$proact
$newdate
$FORM{'cctype'}

$FORM{'company'}
EOF
	close (FILE);
}
###############################################

###############################################
sub approve_member {
	my ($newdate, $account, %FORM) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	unless ($opt[11] eq "CHECKED") {
		if (-e "${path}config/merchant.txt") {
			my @sites = &GetSites($account);
			open (FILE, ">${path}data/stats/$account.txt");
			foreach my $line(@sites) {
				chomp($line);
				my @inner5 = split(/\|/, $line);
print FILE <<EOF;
$inner5[0]|$newdate^0^0
EOF
			}
		} else {
			my ($count);
			open (FILE, ">${path}data/stats/$account.txt");
			for (1 .. $FORM{'signup1'}) {
				$count++;
				my $keyword = "keyword$count";
print FILE <<EOF;
$FORM{$keyword}|$newdate^0^0
EOF
			}
			close (FILE);
		}
	}

	if ($FORM{'free'} && $opt[12] eq "CHECKED") { $FORM{'balance'} = $FORM{'balance'} + $adv[16]; }
	elsif ($adv[13]) { $FORM{'balance'} = $FORM{'balance'} + $adv[13]; }
	open (FILE, ">${path}data/balance/$account.txt");
	print FILE "$FORM{'balance'}";
	close (FILE);

	my $count=0;
	unless ($opt[11] eq "CHECKED" || $FORM{'t'}) {
		for (1 .. $FORM{'signup1'}) {
			$count++;
			my $keyword = "keyword$count";
			my $title = "title$count";
			my $description = "description$count";
			my $url = "url$count";
			my $bid = "bid$count";
			if (-e "${path}data/search/$FORM{$keyword}.txt") {
				open (FILE, ">>${path}data/search/$FORM{$keyword}.txt");
			} else {
				open (FILE, ">${path}data/search/$FORM{$keyword}.txt");
			}
			print FILE "$FORM{$bid}|$account|$FORM{$title}|$FORM{$url}|$FORM{$description}|$newdate|$count\n";
			close (FILE);
			&outbidded($FORM{$keyword}, $FORM{$bid}, $account);
		}
	}
}
###############################################

###############################################
sub username_check {
	my ($username) = @_;
	my ($error);
	if (-e "${path}data/users/$username.txt") {
		$error .= "The <B>Username</B> you chose is <B>Already Taken</B>, please choose a different one<BR>";
	}
	return($error);
}
###############################################


### USED BY VIEW.CGI ###
###############################################
sub make_inactive {
	my ($account) = @_;
	my @site = &GetSites($account);
	foreach my $bid(@site) {
		my @siteinfo = split(/\|/, $bid);
		open(FILE,"${path}data/search/$siteinfo[0].txt");
		flock (FILE,2);
		my @search = <FILE>;
		flock (FILE,8);
		close(FILE);
		
		open(FILE,">${path}data/search/$siteinfo[0].txt");
		flock (FILE,2);
		foreach my $line(@search) {
			chomp($line);
			my @inner = split(/\|/, $line);
			unless ($inner[1] eq $account) {
print FILE <<EOF;
$line
EOF
			}
		}
		flock (FILE,8);
		close(FILE);
	}
	&remove_status('active', $account);
	open (FILE, ">>${path}data/inactive.txt");
print FILE <<EOF;
$account
EOF
	close (FILE);

	my @info = &GetUser($account);
	open(FILE,">${path}data/users/$account.txt");
	$info[14] = "inactive";
	foreach my $line(@info) {
		chomp($line);	
print FILE <<EOF;
$line
EOF
	}
	close(FILE);
}
###############################################


###############################################
sub view_search {
	my ($type, $backup) = @_;
	if ($backup) { open (FILE, "${path}data/backup/$type.txt"); }
	else { open (FILE, "${path}data/$type.txt"); }
	my @processing = <FILE>;
	close (FILE);
	return(@processing);
}
###############################################

###############################################
sub do_view_search {
	my ($account, $backup, $searchby) = @_;
	if ($backup) { opendir(FILE,"${path}data/backup/users"); }
	else { opendir(FILE,"${path}data/users"); }
	my @members2 = grep { /.txt/ } readdir(FILE);
	closedir (FILE);
	my ($i, $found, @processing);
	foreach my $mem(@members2) {
		chomp($mem);
		$mem =~ s/.txt//;
		if ($searchby eq "username") {
			if ($mem =~ /$account/i) {
				$processing[$i] = $mem;
				$i++;
				$found=1;
			}
		} elsif ($searchby eq "name") {
			my @info = &GetUser($mem, $backup);
			if ($info[0] =~ /$account/i) {
				$processing[$i] = $mem;
				$i++;
				$found=1;
			}
		} elsif ($searchby eq "company") {
			my @info = &GetUser($mem, $backup);
			if ($info[18] =~ /$account/i) {
				$processing[$i] = $mem;
				$i++;
				$found=1;
			}
		} elsif ($searchby eq "siteterm") {		
			my @site = &GetSites($mem, $backup);
			foreach my $line(@site) {
				chomp($line);
				my @inner = split(/\|/, $line);
				if ($inner[0] =~ /$account/i) {
					$processing[$i] = $mem;
					$i++;
					$found=1;
				}
			}
		}
	}
	return($found, @processing);
}
###############################################

###############################################
sub make_active {
	my ($member, $datapath) = @_;
	if ($datapath) { $path = $datapath; }
	&remove_status('inactive', $member);
	open (FILE, ">>${path}data/active.txt");
	print FILE "$member\n";
	close (FILE);
	my @user = &GetUser($member);
	$user[14] = "active";
	open (FILE, ">${path}data/users/$member.txt");
	foreach my $line(@user) {
		chomp($line);
		print FILE "$line\n";
	}
	close (FILE);
	my $newdate = &main_functions::getdate;
	&add_listing($member, $newdate, $datapath);
}
###############################################

###############################################
sub delete_listing {
	my ($member, $listing, $id) = @_;
	my @site = &GetSites($member);
	open(FILE, ">${path}data/sites/$member.txt");
	foreach my $line(@site) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($id) {
			unless ($inner[0] eq $listing && $inner[6] == $id) { print FILE "$line\n"; }
		} else {
			unless ($inner[0] eq $listing) { print FILE "$line\n"; }
		}
	}
	close (FILE);
	open(FILE, "${path}data/search/$listing.txt");
	my @search = <FILE>;
	close(FILE);
	open(FILE, ">${path}data/search/$listing.txt");
	foreach my $line(@search) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($id) {
			unless ($inner[1] eq $member && $inner[6] == $id) {	print FILE "$line\n"; }
		} else {
			unless ($inner[1] eq $member) {	print FILE "$line\n"; }
		}
	}
	close (FILE);
}
###############################################

###############################################
sub delete_member {
	my ($member) = @_;
	my @site = &GetSites($member);
	my @info = &GetUser($member);
	&remove_status($info[14], $member);
	unlink("${path}data/sites/$member.txt");
	unlink("${path}data/users/$member.txt");
	unlink("${path}data/balance/$member.txt");
	unlink("${path}data/stats/$member.txt");

	foreach my $line(@site) {
		chomp($line);
		my @inner = split(/\|/, $line);
		open(FILE, "${path}data/search/$inner[0].txt");
		my @search = <FILE>;
		close(FILE);
		open(FILE, ">${path}data/search/$inner[0].txt");
		foreach my $line2(@search) {
			chomp($line2);
			my @inner2 = split(/\|/, $line2);
			unless ($inner2[1] eq $member) {
				print FILE "$line2\n";
			}
		}
		close(FILE);
	}
}
###############################################

###############################################
sub gather_emails {
	my ($type) = @_;
	my (@emails);
	if ($type eq "all") {
		opendir(FILE,"${path}data/users");
		@emails = grep { /.txt/ } readdir(FILE);
	} else {
		open(FILE,"${path}data/$type.txt");
		@emails = <FILE>;
	}
	close (FILE);
	if ($type eq "all") {
		my $t;
		foreach (@emails) {
			$emails[$t] =~ s/.txt//;
			$t++;
		}
	}
	return(@emails);
}
###############################################

###############################################
sub update_member {
	my ($sitestatus, $p, $pass2, $member, %FORM) = @_;
	my @info = &GetUser($member);
	open (FILE, ">${path}data/users/$member.txt");
print FILE <<EOF;
$FORM{'personsname'}
$FORM{'address1'}
$FORM{'address2'}
$FORM{'city'}
$FORM{'state'}
$FORM{'zip'}
$FORM{'country'}
$FORM{'phone'}
$FORM{'email'}
$FORM{'ccname'}
$p
$FORM{'expiration'}
$info[12]
$pass2
$FORM{'status'}
$FORM{'created'}
$info[16]

$FORM{'company'}
EOF
	close (FILE);
	&update_balance($member, $FORM{balance});
}
###############################################

###############################################
sub display_payhistory {
	my ($adv15, $total, undef, @inner) = @_;
	if ($inner[0] eq "[payment history]") {
		my ($t, $num);
		foreach my $line2(@inner) {
			unless ($t == 0) {
				$num++;
				my @split = split(/\^/, $line2);
				$total += $split[2];
print <<EOF
<tr>
<td><font face="verdana" size="-1">$num</font></td>
<td><font face="verdana" size="-1">$split[0]</font></td>
<td><font face="verdana" size="-1">$adv15$split[2]</font></td>
</tr>
EOF
				}
			$t++;
		}
	}
	return ($total);
}	
###############################################

1;
__END__
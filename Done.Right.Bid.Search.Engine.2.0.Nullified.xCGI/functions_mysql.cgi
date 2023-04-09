package database_functions;
my $path = ""; # With a slash at the end
use vars qw(%config);
undef %config;
local %config = ();
do "${path}config/config.cgi";
my $file_ext = "$config{'extension'}";
if ($file_ext eq "") { $file_ext = "cgi"; }
do "${path}functions.$file_ext";


###############################################
eval ("use DBI"); if ($@) { die "The DBI module used for MySQL appears to not be installed"; }
my $dbh;
if (-e "${path}config/config.cgi") {
	$dbh = DBI->connect("DBI:mysql:$config{database}:$config{host}", "$config{username}", "$config{password}");
	die ("database connect failed") unless $dbh;
}
###############################################

###############################################
sub click_connect {
	$dbh->disconnect();
	my ($database, $host, $username, $password) = @_;
	$dbh = DBI->connect("DBI:mysql:$database:$host", "$username", "$password");
	die ("database connect failed") unless $dbh;
}
###############################################

###############################################
sub disconnect {
	#$sth->finish();
	$dbh->disconnect();
	undef $sth;
}
###############################################

### USED BY ALL FILES ###
###############################################
# view.cgi, admin.cgi
sub count_members {
	my ($processing, $addition, $balanceaddon, $active, $inactive, $bu_users) = @_;
	my $statement = "select username from users";
	if ($bu_users) { $statement .= "_backup"; }
	$statement .= " where status='processing'";
	my $sth = &mySQL($statement);
	while(my $data = $sth->fetchrow_array) {
		push(@{$processing}, $data);
	}
	$sth->finish();
	my $processing2 = @{$processing};
	$statement = "select username from users";
	if ($bu_users) { $statement .= "_backup"; }
	$statement .= " where status='active'";
	$sth = &mySQL($statement);
	while(my $data = $sth->fetchrow_array) {
		push(@{$active}, $data);
	}
	$sth->finish();
	my $active2 = @{$active};
	$statement = "select username from users";
	if ($bu_users) { $statement .= "_backup"; }
	$statement .= " where status='inactive'";
	$sth = &mySQL($statement);
	while(my $data = $sth->fetchrow_array) {
		push(@{$inactive}, $data);
	}
	$sth->finish();
	my $inactive2 = @{$inactive};
	$statement = "select users.username from users, sites where (sites.status='add' or sites.status='edit') and sites.user=users.id and users.status='active' group by username";
	$sth = &mySQL($statement);
	while(my $data = $sth->fetchrow_array) {
		push(@{$addition}, $data);
	}
	$sth->finish();
	my $addition2 = @{$addition};
	$statement = "select users.username from users, balanceaddon where users.id=balanceaddon.user group by balanceaddon.user";
	$sth = &mySQL($statement);
	while(my $data = $sth->fetchrow_array) {
		push(@{$balanceaddon}, $data);
	}
	$sth->finish();
	my $balanceaddon2 = @{$balanceaddon};
	return ($processing2, $active2, $inactive2, $addition2, $balanceaddon2);
}
###############################################

###############################################
sub GetSites {
	my ($user, $backup) = @_;
	$user = &escape($user);
	my $statement;
	if ($backup) { $statement = "select sites_backup.* from sites_backup, users_backup where users_backup.username='$user' and sites_backup.user=users_backup.id order by sites_backup.bid desc"; }
	else { $statement = "select sites.* from sites, users where users.username='$user' and sites.user=users.id order by sites.bid desc"; }
	my $sth = &mySQL($statement);
	my (@sites) = ();
	while (my ($sites_id, @temp) = $sth->fetchrow_array) {
		push (@temp, $sites_id);
		my $temp = join("|", @temp);
		push @sites, $temp;
	}
	$sth->finish();
	return @sites;
}
###############################################

###############################################
sub GetUser {
	my ($user, $backup) = @_;
	$user = &escape($user);
	my $statement = "select * from users";
	if ($backup) { $statement .= "_backup"; }
	$statement .= " where username='$user'";
	my $sth = &mySQL($statement);
	my ($user_id, @user) = $sth->fetchrow_array;
	$sth->finish();
	return @user;
}
###############################################

###############################################
sub GetBalance {
	my ($user, $backup) = @_;
	$user = &escape($user);
	my $statement = "select balance from users";
	if ($backup) { $statement .= "_backup"; }
	$statement .= " where username='$user'";
	my $sth = &mySQL($statement);
	my $balance = $sth->fetchrow_array;
	$sth->finish();
	return $balance;
}
###############################################

###############################################
sub GetStats {	
	my ($user, $backup) = @_;
	$user = &escape($user);
	my $statement;
	if ($backup) { $statement = "select stats_backup.* from stats_backup, users_backup where users_backup.username='$user' and stats_backup.user=users_backup.id"; }
	else { $statement = "select stats.* from stats, users where users.username='$user' and stats.user=users.id"; }
	my $sth = &mySQL($statement);
	
	my @stats = ();
	while (my ($stats_id, @temp) = $sth->fetchrow_array) {
		my $temp = join("|", @temp);
		push (@stats, $temp);
	}
	$sth->finish();	
	return @stats;
}
###############################################

###############################################
sub mySQLGetUserID {
	my ($user) = @_;
	$user = &escape($user);
	my $statement = "select id from users where username='$user'";
	my $sth = &mySQL($statement);
	my $temp = $sth->fetchrow_array;
	$sth->finish();
	return $temp;
}
###############################################

###############################################
sub mySQL {
	my ($statement) = @_;
	my $sth = $dbh->prepare($statement);
	$sth->execute || die "Bad statement ($statement) $DBI::errstr";
	return $sth;
}
###############################################

###############################################
sub GetSearch {
	my ($bidkeys) = @_;
	my $statement = "select bid, users.username, title, url, description, sites.date, sites.id from sites, 
	users where term='$bidkeys' and sites.status='approved' and sites.user=users.id and users.status='active' order by bid desc, sites.id asc";
	my $sth = &mySQL($statement);
	my @result2 = ();
	while (my @data = $sth->fetchrow_array)	{
		my $temp = join("|", @data);
		push (@result2, $temp);	
	}
	$sth->finish();
	return @result2;
}
###############################################

###############################################
sub outbidded {
	my ($term, $bid, $account, $alreadylisted, $oldbid, $process) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	if ($opt[8] eq "CHECKED" && $alreadylisted == 0) {
		my ($rank2, $bidhigh, $myid);
		my $statement = "select users.username, sites.bid, sites.id from users, sites where (users.username='$account' or sites.status='approved') and sites.term='$term' and sites.user = users.id";
		if ($oldbid && $process ne "new") { $statement .= " and (sites.bid > '$oldbid' or sites.bid = '$oldbid')"; }
		$statement .= " order by sites.bid desc, sites.id asc";
		my $sth = &mySQL($statement);
		while (my ($line3, $bid, $id) = $sth->fetchrow_array) {
			$rank2++;
			if ($line3 eq $account) {
				$myid = $id;
				$bidhigh = 1;
			} elsif ($bidhigh == 1) {
				unless ($bid == $oldbid && $myid < $id) {
					my @userinfo = &GetUser($line3);
					my $oldposition = $rank2-1;
					&main_functions::emailoutbid($account, $term, $oldposition, $rank2, @userinfo);
				}
			}
		}
		$sth->finish;
	}
}
###############################################

###############################################
# members.cgi, view.cgi
sub stat_activity {
	my ($account) = @_;
	my $user_id = &mySQLGetUserID($account);
	my $statement = "select term, date, clicks, amount from stats where user='$user_id' group by date order by date desc";
	my $sth = &mySQL($statement);
	my ($counter, $grand, $divider);
	my (@term, @date, @clicks, @amount, %used);
	while (my @data = $sth->fetchrow_array) {
		unless ($data[0] eq "[payment history]") {
			$term[$counter] = $data[0];
			$date[$counter] = $data[1];
			$clicks[$counter] = $data[2];
			$amount[$counter++] = $data[3];
		}
	}
	$sth->finish();
	foreach my $term (@term) {
		if (!$used{$term}) {	
			$used{$term} = 1;
			$term = &escape($term);
			my $statement = "select amount from stats where user='$user_id' and term='$term' order by date desc limit 3";
			my $sth = &mySQL($statement);
			if ($sth->rows > $divider) {
				$divider = $sth->rows;
			}
			while (my $val = $sth->fetchrow_array) {
				$grand += $val;
			}
			$sth->finish();
		}
	}
	undef %used;
	return ($grand, $divider, @date);
}
###############################################

###############################################
sub escape {
	my $term = shift;
	$term =~ s/([^\\])'/$1\\'/g;
	return $term;
}
###############################################

###############################################
sub unescape {
	my $term = shift;
	$term =~ s/\\'/'/g;
	return $term;	
}
###############################################

###############################################
# signup.cgi, admin.cgi
sub update_balance {
	my ($username, $balanceordered) = @_;
	my $statement = "update users set balance='$balanceordered' where username='$username'";
	my $sth = &mySQL($statement);
}
###############################################


### USED BY ADDONS.CGI ###
###############################################
sub get_daily_stats {
	my $statement = "select date, searches from dailystats order by id desc";
	my $sth = &mySQL($statement);
	my (%month, %day);
	while (my ($date, $searches) = $sth->fetchrow_array) {
		my @date = split(/\-/, $date);
		my ($month);
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
				$day{$date} = "$month $date[2], $date[0]|$searches";
			} else {
				$month{$date} = "$month $date[0]|$searches";
			}
		}
	}
	$sth->finish();

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
	my $statement = "select * from searchlog";
	my $sth = &mySQL($statement);
	while (my @data = $sth->fetchrow_array) { $count++; }
	$sth->finish();
	return($count);
}
###############################################

###############################################
sub get_top_searches {
	my ($start) = @_;
	my $statement = "select term, searches from searchlog order by searches desc";
	my $sth = &mySQL($statement);
	my $b=1;
	my $a=0;
	while (my ($term, $searches) = $sth->fetchrow_array) {
		if ($b >= $start) {
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$b.</font></td>
<td><font face="verdana" size="-1">$term</font></td>
<td align=right><font face="verdana" size="-1" color="red">$searches</font></td>
</tr>
EOF
			$a++;
			last if ($a == 50);
		}
		$b++;
	}
	$sth->finish();
}
###############################################

###############################################
sub delete_top_searches {
	my ($type) = @_;
	if ($type == 1) {
		my $statement = "delete from searchlog where searches = '1'";
		my $sth = &mySQL($statement);
	} else {
		my $statement = "delete from searchlog";
		my $sth = &mySQL($statement);
	}
}
###############################################

###############################################
sub get_top_bids {
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my $statement = "select term, bid from sites where status='approved' order by bid desc";
	my $sth = &mySQL($statement);
	my ($c);
	while (my ($term, $bid) = $sth->fetchrow_array) {
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
	$sth->finish();
}
###############################################


### USED BY ADMIN.CGI ###
###############################################
sub get_balanceaddon {
	my ($account) = @_;
	my $user_id = &mySQLGetUserID($account);
	my $statement = "select sum(amount) from balanceaddon where user='$user_id'";
	my $sth = &mySQL($statement);
	my $balance2 = $sth->fetchrow_array();
	$sth->finish();
	return ($balance2)
}
###############################################

###############################################
sub change_status {
	my ($type, $account) = @_;
	if ($type eq "add") {
		my $user_id = &mySQLGetUserID($account);
		my $statement = "update sites set status='$type' where user='$user_id'";
		my $sth = &mySQL($statement);
	} else {
		my $statement = "update users set status='$type' where username='$account'";
		my $sth = &mySQL($statement);
	}
}
###############################################

###############################################
sub remove_status {
	my ($file, $account) = @_;
	my $user_id = &mySQLGetUserID($account);
	my $statement = "delete from $file where user='$user_id'";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub update_sites {
	my ($term, $status, $account, $bid, $title, $url, $description, $old_term, $id) = @_;
	unless($old_term) { $old_term = $term; }
	my $user_id = &mySQLGetUserID($account);
	$term = &escape($term);
	my $statement = "update sites set status='$status'";
	if ($bid && $title && $url && $description) {
		$statement .= ", term='$term', bid='$bid', title='$title', url='$url', description='$description'";
	}
	$statement .= " where user='$user_id' and term='$old_term'";
	if ($id) { $statement .= " and id='$id'"; }
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub get_reviewer {
	my $statement = "select * from reviewers";
	my $sth = &mySQL($statement);
	my @reviewer;
	while (my ($reviewer_id, @temp) = $sth->fetchrow_array) {
		my $temp = join("|", @temp);
		push @reviewer, $temp;
	}
	$sth->finish();
	return(@reviewer);
}
###############################################

###############################################
sub add_reviewer {
	my ($username, $password) = @_;
	my $statement ="select id from reviewers where username='$username'";
	my $sth = &mySQL($statement);
	my ($message);
	if ($sth->rows > 0) { $message .= "The <B>Username</B> you chose is <B>Already Taken</B>, please choose a different one<BR>"; }
	else {
		my $pass2 = $password;
		my $encryptkey = "bsereviewer";
		$password = &main_functions::Encrypt($password,$encryptkey,'asdfhzxcvnmpoiyk');
		my $newdate = &main_functions::getdate;
		$statement = "insert into reviewers(username, password, date, stats) values	('$username', '$password', '$newdate', '0');";
		$sth = &mySQL($statement);
		$message = "Reviewer successfully added, please record this information.<BR>Username: $username<BR>Password: $pass2<BR>";
	}
	$sth->finish();
	return($message);
}
###############################################

###############################################
sub delete_reviewer {
	my ($username) = @_;
	my $statement ="delete from reviewers where username='$username'";
	my $sth = &mySQL($statement);
	my $message = "'$username' reviewer has been deleted<BR>";
	return($message);
}
###############################################

###############################################
sub check_reviewerlogin {
	my ($username, $password, $formlogin) = @_;
	my $statement ="select password from reviewers where username='$username'";
	my $sth = &mySQL($statement);
	my ($verified, $pass2);
	while (my $pass = $sth->fetchrow_array) {
		$pass2 = $pass;
		my $encryptkey = "bsereviewer";
		$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
		unless ($formlogin) {
			$password = &main_functions::Decrypt($password,$encryptkey,'asdfhzxcvnmpoiyk');
		}
		if ($password eq $pass) { $verified = 1; }
	}
	$sth->finish();
	
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
	my $statement = "update reviewers set stats=stats + 1 where username='$username'";
	my $sth = &mySQL($statement);
}
###############################################


### USED BY MEMBERS.CGI ###
###############################################
sub gather_statistics {
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my ($dat, $account, $view_date, $order_by) = @_;
	my $user_id = &mySQLGetUserID($account);
	my $statement = "select term, sum(clicks), sum(amount) from stats where user='$user_id' $view_date group by term order by $order_by desc";
	my $sth = &mySQL($statement);
	my ($grand, $counter, @term, @clicks, @amount, $totalclicks, $totalcost);
	while (my @data = $sth->fetchrow_array) {
		unless ($data[0] eq "[payment history]") {
			$term[$counter] = $data[0];
			if ($data[1] eq '') {
				$data[1] = 0;
			}
			$clicks[$counter] = $data[1];
			$amount[$counter++] = $data[2];
			$grand += $data[2];
		}
	}
	$sth->finish();
	
	for (my $i = 0; $i < @term; $i++) {
		$amount[$i] = sprintf("%.2f", $amount[$i]);
		my $temp = $dat;
		$temp =~ s/<!-- \[keyword\] -->/$term[$i]/ig;
		$temp =~ s/<!-- \[clicks\] -->/$clicks[$i]/ig;
		$temp =~ s/<!-- \[cost\] -->/$adv[15]$amount[$i]/ig;
		print $temp;
		$totalclicks += $clicks[$i];
		$totalcost += $amount[$i];
	}
	return ($totalclicks, $totalcost);
}
###############################################

###############################################
sub profile_update {
	my ($pass2, $user, %FORM) = @_;
	my $user_id = &mySQLGetUserID($user);
	my $statement = "update users set name='$FORM{name}', street1='$FORM{address1}', street2='$FORM{address2}', 
	city='$FORM{city}', province='$FORM{state}', zip='$FORM{zip}', country='$FORM{country}', phone='$FORM{phone}', 
	email='$FORM{email}', password='$pass2', company='$FORM{company}' where id='$user_id'";
	my $sth = &mySQL($statement);
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
	if ($balance == 0 || $balance eq "") {
		my $message = "You have no funds in your account and as a result this function has been disabled for the time being.";
		return ($message);
	}
	if ($FORM{'tab'} eq "bids" || $FORM{'tab'} eq "editlisting" || $FORM{'tab'} eq "deletelisting") {
		my $statement = "select sites.id from sites, users where users.username='$user' and sites.user=users.id and sites.status='approved'"; 
		my $sth = &mySQL($statement);
		my @sites = $sth->fetchrow_array;
		$sth->finish();
		chomp(@sites);
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
	my $user_id = &mySQLGetUserID($user);
	my $count = 1;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	while ($FORM{"keyword$count"} ne '') {
		my ($keyword, $title, $description, $url, $bid);
		($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
		my $id2 = "id$count";
		##lets see if we can find one that matches and if not then a new entry
		my $statement = "select id, bid, title, url, description from sites where user='$user_id' and term='$FORM{$keyword}' and id='$FORM{$id2}'";
		my $sth = &mySQL($statement);
		my ($id, @other) = $sth->fetchrow_array;
		$sth->finish();
		
		for (my $i=0;$i<@other;$i++) {
			$other[$i] = &escape($other[$i]);
		}
		my $status;
		if ($opt[9] ne "CHECKED") {	
			$status = 'approved';
		} else {
			if ($id eq '') { $status = "new"; }
			else { $status = 'edit'; }
		}
		
		if ($id eq '') {
			my $statement = "insert into sites(term, bid, title, url, description, status, user, date) values
					('$FORM{$keyword}', '$FORM{$bid}', '$FORM{$title}', '$FORM{$url}', '$FORM{$description}', '$status', '$user_id', '$newdate')";
			my $sth = &mySQL($statement);
		} else 	{
			#if there is one that exists lets make sure that it is actually different
			if ($other[0] ne  $FORM{$bid} || $other[1] ne $FORM{$title} || $other[2] ne $FORM{$url} || $other[3] ne $FORM{$description})	{
				if ($status eq 'edit') {
					my $statement = "update sites set status='$status' where id='$id'";
					my $sth = &mySQL($statement);
					$statement = "insert into edit_sites(term, bid, title, url, description, status, user, date, original) values
					('$FORM{$keyword}', '$FORM{$bid}', '$FORM{$title}', '$FORM{$url}', '$FORM{$description}', '$status', '$user_id', '$newdate', '$id')";
					$sth = &mySQL($statement);
				} elsif ($status eq 'approved') {
					my $statement = "update sites set bid='$FORM{$bid}', title='$FORM{$title}', url='$FORM{$url}', description='$FORM{$description}', status='$status', date='$newdate' where user='$user_id' and term='$FORM{$keyword}' and id='$FORM{$id2}'";
					my $sth = &mySQL($statement);
				}
			}
		}
		##due this only if we actually changed the bid value
		#if ($id eq '' or $other[0] ne $FORM{$bid} and $opt[9] ne 'CHECKED') {
		#	&addbid($FORM{$keyword}, $FORM{$bid}, $user, $other[0]);
		#}
		$count++;
	}	
}
###############################################

###############################################
sub update_credit {
	my ($p, $proact, $user, %FORM) = @_;
	my $statement = "update users set card_holder='$FORM{'chname'}', card_number = '$p', card_expires='$FORM{expire}'";
	unless (-e "${path}config/merchant.txt") {
		$statement .= ", status='$proact'";
	}
	$statement .= ", card_type='$FORM{cctype}' where username='$user'";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub create_stat {
	my ($user, $newdate) = @_;
	my $user_id = &mySQLGetUserID($user);
	my $statement = "select id from stats where user='$user_id' and term='Non-Targeted Listing'";
	my $sth = &mySQL($statement);
	my $statexists;
	if ($sth->rows > 0) { $statexists = 1; }
	$sth->finish();
	unless ($statexists) {
		my $statement = "insert into stats(user, term, date) values ('$user_id', 'Non-Targeted Listing', '$newdate')";
		my $sth = &mySQL($statement);
	}
}
###############################################

###############################################
sub add_listing {
	my ($user, $newdate) = @_;
	my $user_id = &mySQLGetUserID($user);
	my $statement = "update sites set status='approved' where user='$user_id'";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub getbid {
	my ($user, $term_submit, $temp) = @_;
	my $position = 1;
	my ($bidtobe1, $t);
	my $user_id = &mySQLGetUserID($user);
	my $statement = "select bid, date, user from sites where term='$term_submit' and bid > '$temp' and status='approved' order by bid desc, id asc";
	my $sth = &mySQL($statement);
	while (my ($bid, $date, $user2) = $sth->fetchrow_array) {
		if ($user2 == $user_id) { last; }
		if ($t == 0) { $bidtobe1 = $bid; }
		$position++;
		$t++;
	}
	$sth->finish();
	return ($bidtobe1, $position);
}
###############################################

###############################################
sub get_nontargeted {
	my ($user) = @_;
	my $user_id = &mySQLGetUserID($user);
	my $statement = "select title, description, url, bid from sites where user='$user_id' and term='Non-Targeted Listing'";
	my $sth = &mySQL($statement);
	my @sites = &GetSites($user);
	my ($nontargetedexists, $title, $description, $url, $bid);
	if ($sth->rows > 0) {
		$nontargetedexists = 1;
		($title, $description, $url, $bid) = $sth->fetchrow_array;
	}
	$sth->finish();
	return ($title, $description, $url, $bid, $nontargetedexists);
}
###############################################

###############################################
sub nontargeted_sites {
	my ($user, $opt9, $newdate, %FORM) = @_;
	my $statement = "select sites.id, sites.bid from sites, users where sites.user=users.id and users.username='$user' and sites.term='Non-Targeted Listing'";
	my $sth = &mySQL($statement);
	my ($site_id, $site_bid) = $sth->fetchrow_array;
	$sth->finish;
	my $addition;
	if ($opt9 eq "CHECKED") { 
		if ($site_id eq '')	{ $addition = "add"; }
		else { $addition = "edit"; }
	} else {
		$addition = 'approved';	
	}
	my $user_id = &mySQLGetUserID($user);
	if ($addition eq 'edit') {
		my $statement = "update sites set status='$addition' where id='$site_id'";
		my $sth = &mySQL($statement);

		##add the site to the dit section if it is in edit mode
		$statement = "insert into edit_sites(term, bid, title, url, description, status, user, date, original) values
		('Non-Targeted Listing', '$FORM{bid}', '$FORM{title}', '$FORM{url}', '$FORM{description}', '$addition', '$user_id', '$newdate', '$site_id')";
		$sth = &mySQL($statement);
	} else {
		my $statement = "insert into sites(term, bid, title, url, description, status, user, date) values 
		('Non-Targeted Listing', '$FORM{bid}', '$FORM{title}', '$FORM{url}', '$FORM{description}', '$addition', '$user_id', '$newdate')";
		my $sth = &mySQL($statement);
	}
	return ($site_bid);
}
###############################################

###############################################
sub payment_history {
	my ($user, $newdate, $newbalance, $invoice) = @_;
	my $user_id = &mySQLGetUserID($user);
	my $statement = "insert into stats(user, term, date, clicks, amount) 
	values ('$user_id', '[payment history]', '$newdate', '$invoice', '$newbalance')";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub bulk_upload {
	my ($user, %FORM) = @_;
	use vars qw(%config);
	undef %config;
	local %config = ();
	do "${path}config/config.cgi";
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my (@error, $countvalue, $keyarr, $addition);
	if ($opt[9] eq "CHECKED") { $addition = "add"; }
	else { $addition = 'approved'; }
	my $newdate = &main_functions::getdate;
	my $numb = 1;
	my $user_id = &mySQLGetUserID($user);
	my $keyword = "keyword$numb";
	while ($FORM{$keyword}) {
		my ($title, $description, $url, $bid);
		($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($numb, %FORM);
		my $statement = "insert into sites(term, bid, title, url, description, status, user, date) values 
		('$FORM{$keyword}', '$FORM{$bid}', '$FORM{$title}', '$FORM{$url}', '$FORM{$description}', '$addition', '$user_id', '$newdate')";
		my $sth = &mySQL($statement);
		$numb++;
		$keyword = "keyword$numb";
	}
	if ($opt[9] eq "CHECKED") {
		my @info = &GetUser($user);
		my $subject = "Search Listing - Addition";
		my $emailmessage = "The following member has just added listings and is waiting for them to be approved:\n\n";
		$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\n\n";
		if ($opt[9] eq "CHECKED") { $emailmessage .= "Login to the admin to process this order:\n$config{'adminurl'}admin.$file_ext\n"; }
		&main_functions::send_email($config{'adminemail'}, $config{'adminemail'}, $subject, $emailmessage);
	}
}
###############################################


### USED BY SEARCH.CGI ###
###############################################
sub get_bids {
	my ($searchterm, $temp, @temparray) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my $statement = "select bid, title, url from sites where term='$searchterm' and status='approved' order by bid desc";
	my $sth = &mySQL($statement);
	if ($sth->rows == 0) {
		&openbid($temp, $adv[15], $adv[14]);
	} else {
		print "Content-type: text/html\n\n";
		print "$temparray[0]";
		my $rank;
		while (my @data = $sth->fetchrow_array) {
			$rank++;
			my $temp = "$temparray[1]";
			$temp =~ s/<\!-- \[position\] -->/$rank/ig;
			$temp =~ s/<\!-- \[title\] -->/$data[1]/ig;
			$temp =~ s/<\!-- \[url\] -->/$data[2]/ig;
			$temp =~ s/<\!-- \[bid\] -->/$adv[15]$data[0]/ig;
			print "$temp";	
		}
		print "$temparray[2]";
	}
	$sth->finish();

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
	
	my $statement = "select sites.id from sites, users where sites.term='$bidkeys' and sites.status='approved' and users.status='active' and sites.user=users.id";
	my $sth = &mySQL($statement);
	my @result;
	if ($sth->rows > 0) {
		$sth->finish();
		@result = &gatherbids($bidkeys, undef, @result);
	} elsif ($method == 1) {
		$sth->finish();
		my @splitbids = split('', $bidkeys);
		my $or = 1;
		foreach $bidkeys(@splitbids) {
			my $statement = "select sites.id from sites, users where sites.term='$bidkeys' and sites.status='approved' and users.status='active' and sites.user=users.id";
			mySQL($statement);
			if ($sth->rows > 0)	{
				$sth->finish();
				@result = &gatherbids($bidkeys, $or, @result);
			}
		}	
	} else { 
		$sth->finish();
		@result = &gatherbids($bidkeys, undef, @result);
	}

	sub gatherbids {
		my ($bidkeys, $or, @result) = @_;
		if ($or) {
			my @result2 = &GetSearch($bidkeys);
			@result = push(@result, @result2);
		} else {
			@result = &GetSearch($bidkeys);
		}
		return (@result);
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
	my ($keywords, $account, $newdate, $bid, $id) = @_;
	my $user_id = mySQLGetUserID($account);
	my $statement = "select bid from sites where user='$user_id' and term='$keywords' and status='approved'";
	if ($id) { $statement .= " and id='$id'"; }
	my $sth = &mySQL($statement);
	my $site_bid = $sth->fetchrow_array;
	$sth->finish();
	
	$statement = "select id from stats where user='$user_id' and term='$keywords' and date='$newdate'";
	$sth = &mySQL($statement);
	my $stat_id = $sth->fetchrow_array;
	$sth->finish();

	if ($stat_id ne '') {
		$statement = "update stats set amount = amount + $site_bid, clicks = clicks + 1 where id='$stat_id'";
	} else {
		$statement = "insert into stats(user, term, date, clicks, amount) 
		values ('$user_id', '$keywords', '$newdate', '1', '$site_bid')";
	}
	$sth = &mySQL($statement);
	my ($avg);
	$statement = "select count(id), sum(amount) from stats where user='$user_id' and term='$keywords' and date='$newdate'";
	$sth = &mySQL($statement);
	my ($statsnumb, $grand) = $sth->fetchrow_array;
	$sth->finish();
	if ($grand) { $avg = $grand/$statsnumb; }
	my $balance = &GetBalance($account);
	my $oldbalance = $balance;
	$balance = $balance - $site_bid;
	if ($balance < 0) { $balance = 0; }
	$statement = "update users set balance='$balance' where username='$account'";
	$sth = &mySQL($statement);
	return ($grand, $avg, $balance, $oldbalance);
}
###############################################

###############################################
sub searcheslog {
	my ($displaykeys2) = @_;
	my $statement = "select searches from searchlog where term='$displaykeys2'";
	my $sth = &mySQL($statement);
	my ($found, $searches);
	if ($sth->rows > 0)	{
		$found = 1;
		$searches = $sth->fetchrow_array;
	}
	$sth->finish();
	if ($found) {
		$searches++;
		my $statement = "update searchlog set searches='$searches' where term='$displaykeys2'";
		my $sth = &mySQL($statement);
	} else {
		my $statement = "insert into searchlog(term, searches) values ('$displaykeys2', '1')";
		my $sth = &mySQL($statement);
	}
}
###############################################

###############################################
sub dailystats {
	my $date = &main_functions::getdate;
	my ($current_year, $current_mon, $current_day) = split(/\-/, $date);
	my $statement = "select searches from dailystats where date='$date'";
	my $sth = &mySQL($statement);
	my ($found, $searches);
	if ($sth->rows > 0)	{
		$found = 1;
		$searches = $sth->fetchrow_array;
	}
	$sth->finish();
	if ($found) {
		$searches++;
		my $statement = "update dailystats set searches='$searches' where date='$date'";
		my $sth = &mySQL($statement);
		$sth->finish();
	} else {
		my $statement = "insert into dailystats(date, searches) values ('$date', '1')";
		my $sth = &mySQL($statement);
		$sth->finish();
		$statement = "select id, searches, date from dailystats";
		$sth = &mySQL($statement);
		my (@id, %stat);
		while (my ($id, $searches, $newdate) = $sth->fetchrow_array) {
			my ($year, $mon, $day) = split(/\-/, $newdate);
			if ($day && $mon <=> $current_mon) {
				my $combine = "$year$mon";
				if (exists $stat{$combine}) {
					my @split = split(/\|/, $stat{$combine});
					$searches = $searches+$split[1];
					$stat{$combine} = "$split[0]|$searches|$split[2]";
					push(@id, $id);
				} else {
					$stat{$combine} = "$year-$mon|$searches|$id";
				}
			}
		}
		$sth->finish();
		if (%stat) {
			foreach my $line(sort keys %stat) {
				my @split = split(/\|/, $stat{$line});
				my $statement = "update dailystats set date='$split[0]', searches='$split[1]' where id='$split[2]'";
				my $sth = &mySQL($statement);
			}
			foreach my $line(@id) {
				my $statement = "delete from dailystats where id='$line'";
				my $sth = &mySQL($statement);
			}
		}
	}
}
###############################################

###############################################
sub get_related {
	my ($match, $normalkeys, $adv6, $suggest) = @_;
	my (@related);
	if ($suggest) {
		my $statement = "select searches, term from searchlog order by searches desc";
		my $sth = &mySQL($statement);
		while (my ($searches, $key) = $sth->fetchrow_array) {
			$_ = $key;
			/^$/ and next;
			if (&{$match}) {
				next if ($key =~ /\"/ || $key =~ /\'/);
				my $line;
				if ($key eq $normalkeys) { $line = "<B>$searches</B>|<B>$key<\/B>"; }
				else { $line = "$searches|$key"; }
				push(@related,"$line");
				last if (scalar @related >= $adv6);
			}
		}
		$sth->finish();
	} else {
		my $statement = "select term from searchlog order by searches desc";
		my $sth = &mySQL($statement);
		while (my $key = $sth->fetchrow_array) {
			$_ = $key;
			/^$/ and next;
			if (&{$match}) {
				push(@related,$key) unless($key eq $normalkeys);
				last if (scalar @related >= $adv6);
			}
		}
		$sth->finish();
	}
	return (@related);
}
###############################################

###############################################
sub popular {
	my $statement = "select searches, term from searchlog order by searches desc";
	my $sth = &mySQL($statement);
	my @popular = ();
	while (my @temp = $sth->fetchrow_array) {
		my $temp = join("|", @temp);
		push (@popular, $temp);
	}
	$sth->finish();
	return(@popular);
}
###############################################

###############################################
sub unique_click {
	my ($keywords, $account) = @_;
	my ($noclick, $cookiefound, @cookie);
	my $current_date = time();
	my $statement = "select * from cookies";
	my $sth = &mySQL($statement);
	while (my @data = $sth->fetchrow_array) {
		my $temp = join("|", @data);
		push (@cookie, $temp);
	}
	$sth->finish();
		
	foreach my $line(@cookie) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $gettime = $current_date - $inner[1];
		unless ($gettime >= 86400) {
			if ($inner[2] eq "$ENV{REMOTE_ADDR}" && $inner[3] eq "$keywords" && $inner[4] eq "$account") {
				$noclick = 1;
			}
		} else {
			my $statement = "delete from cookies where id='$inner[0]'";
			my $sth = &mySQL($statement);
		}
	}
	
	unless ($noclick) {
		$cookiefound = 0;
		my $statement = "insert into cookies(time, ip, keywords, account) values ('$current_date', '$ENV{REMOTE_ADDR}', '$keywords', '$account')";
		my $sth = &mySQL($statement);
	} else {
		$cookiefound = 1;
	}
	
	return ($cookiefound);
}
###############################################


### USED BY SETTINGS.CGI ###
###############################################
sub backup_database {
	my $statement = "DELETE FROM users_backup";
	my $sth = &mySQL($statement);
	$statement = "DELETE FROM sites_backup";
	$sth = &mySQL($statement);
	$statement = "DELETE FROM stats_backup";
	$sth = &mySQL($statement);
	
	$statement = "select username from users";
	$sth = &mySQL($statement);
	my (@processing) = ();
	while (my $data = $sth->fetchrow_array)	{
		push(@processing, $data);
	}
	$sth->finish();
	my %hash;
	foreach my $line(@processing) {
		chomp($line);
		$line = &escape($line);
		next if (exists $hash{$line});
		$hash{$line} = 1;
		# users_backup
		$statement = "select * from users where username='$line'";
		$sth = &mySQL($statement);
		my @info = $sth->fetchrow_array;
		$sth->finish();
		my $k=0;
		foreach my $test(@info) {
			chomp($test);
			$info[$k] = &escape($test);
			$k++;
		}
		$statement = "insert into users_backup(id, name, street1, street2, city, province, zip, country, phone, email, card_holder, card_number, 
		card_expires, username, password, status, date, card_type, balance, company) values 
		('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', 
	 	'$info[8]', '$info[9]', '$info[10]', '$info[11]', '$info[12]', '$info[13]', '$info[14]', '$info[15]', '$info[16]', '$info[17]', '$info[18]', '$info[19]')";
		$sth = &mySQL($statement);
		
		# sites_backup
		$statement = "select * from sites where user='$info[0]'";
		$sth = &mySQL($statement);
		my @site = ();
		while (my @temp = $sth->fetchrow_array) {
			my $temp = join("|", @temp);
			push (@site, $temp);
		}
		$sth->finish();
		foreach my $line2(@site) {
			chomp($line2);
			$line2 = &escape($line2);
			my @inner = split(/\|/, $line2);
			$statement = "insert into sites_backup(id, term, bid, title, url, description, status, user, date) values 
			('$inner[0]', '$inner[1]', '$inner[2]', '$inner[3]', '$inner[4]', '$inner[5]', '$inner[6]', '$inner[7]', '$inner[8]')";
			$sth = &mySQL($statement);
		}
		
		# stats_backup
		$statement = "select * from stats where user='$info[0]'";
		$sth = &mySQL($statement);
		my @stat = ();
		while (my @temp = $sth->fetchrow_array) {
			my $temp = join("|", @temp);
			push (@stat, $temp);
		}
		$sth->finish();
		foreach my $line2(@stat) {
			chomp($line2);
			$line2 = &escape($line2);
			my @inner = split(/\|/, $line2);
			$statement = "insert into stats_backup(id, user, term, date, clicks, amount) values 
			('$inner[0]', '$inner[1]', '$inner[2]', '$inner[3]', '$inner[4]', '$inner[5]')";
			$sth = &mySQL($statement);
		}
	}
}
###############################################


### USED BY SIGNUP.CGI ###
###############################################
sub writeuser {
	my ($p, $pass, $proact, $newdate, %FORM) = @_;
	my $statement = "insert into users(name, street1, street2, city, province, zip, country, phone, email, card_holder, card_number,
	card_expires, username, password, status, date, card_type, company) values 
	('$FORM{name}', '$FORM{address1}', '$FORM{address2}', '$FORM{city}', '$FORM{state}', '$FORM{zip}', '$FORM{country}', '$FORM{phone}',
	 '$FORM{email}', '$FORM{chname}', '$p', '$FORM{expire}', '$FORM{username}', '$pass', '$proact', '$newdate', '$FORM{cctype}', '$FORM{company}')";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub insert_site {
	my ($newdate, $account, $numb, %FORM) = @_;
	my $user_id = mySQLGetUserID($account);
	my $keyword = "keyword$numb";
	my $title = "title$numb";
	my $description = "description$numb";
	my $url = "url$numb";
	my $bid = "bid$numb";
	my $statement = "insert into sites(term, bid, title, url, description, status, user, date) values
	('$FORM{$keyword}', '$FORM{$bid}', '$FORM{$title}', '$FORM{$url}', '$FORM{$description}', 'new', '$user_id','$newdate')";
	my $sth = &mySQL($statement);
}
###############################################

###############################################
sub approve_member {
	my ($newdate, $account, %FORM) = @_;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	unless ($opt[11] eq "CHECKED") {
		if (-e "${path}config/merchant.txt") {
			my $statement = "select sites.term, users.id from sites, users where users.username='$account' and sites.user=users.id";
			my $sth = &mySQL($statement);
		    while (my ($sites_term, $user_id) = $sth->fetchrow_array) {
		    	my $statement = "insert into stats(user, term, date) values ('$user_id', '$sites_term', '$newdate')";
				my $sth = &mySQL($statement);
		    }
		    $sth->finish();
		} else {
			my $count;
			my $user_id = mySQLGetUserID($account);
			for (1 .. $FORM{'signup1'}) {
				$count++;
				my $keyword = "keyword$count";
				my $statement = "insert into stats(user, term, date) values ('$user_id', '$FORM{$keyword}', '$newdate')";
				my $sth = &mySQL($statement);
			}
		}
	}

	if ($adv[13]) { $FORM{'balance'} = $FORM{'balance'} + $adv[13]; }
	my $statement = "update users set balance='$FORM{balance}' where username='$account'";
	my $sth = &mySQL($statement);

	my $count=0;
	unless ($opt[11] eq "CHECKED" || $FORM{'t'}) {
		my $statement = "select id from users where username='$account'";
		my $sth = &mySQL($statement);
		my $temp_id = $sth->fetchrow_array;
		$sth->finish;
	
		for (1 .. $FORM{'signup1'}) {
			$count++;
			my $keyword = "keyword$count";
			my $title = "title$count";
			my $description = "description$count";
			my $url = "url$count";
			my $bid = "bid$count";
			my $statement = "update sites set status='approved' where user='$temp_id'";
			my $sth = &mySQL($statement);
			my $key = $FORM{$keyword};	
			&outbidded($FORM{$keyword}, $FORM{$bid}, $account);
		}
	}
}
###############################################

###############################################
sub username_check {
	my ($username) = @_;
	my $statement ="select id from users where username='$username'";
	my $sth = &mySQL($statement);
	my ($error);
	if ($sth->rows > 0) { $error .= "The <B>Username</B> you chose is <B>Already Taken</B>, please choose a different one<BR>"; }
	$sth->finish;
	return($error);
}
###############################################


### USED BY VIEW.CGI ###
###############################################
sub make_inactive {
	my ($account) = @_;
	my $user_id = mySQLGetUserID($account);
	my $statement = "update sites set status='inactive' where user='$user_id'";
	my $sth = &mySQL($statement);
	
	$statement = "update users set status='inactive' where id='$user_id'";
	$sth = &mySQL($statement);
}
###############################################

###############################################
sub view_search {
	my ($type, $backup) = @_;
	my $statement = "select username from users";
	if ($backup) { $statement .= "_backup"; }
	$statement .= " where status='$type' order by date desc";
	my $sth = &mySQL($statement);
	my (@processing);
	while (my $data = $sth->fetchrow_array)	{
		push(@processing, $data);
	}
	$sth->finish();
	return(@processing);
}
###############################################

###############################################
sub do_view_search {
	my ($account, $backup, $searchby) = @_;
	my $statement = "select username from users";
	if ($backup) { $statement .= "_backup"; }
	if ($searchby eq "username") {
		$statement .= " where username regexp '$account' order by username";
	} elsif ($searchby eq "name") {
		$statement .= " where name regexp '$account' order by username";
	} elsif ($searchby eq "company") {
		$statement .= " where company regexp '$account' order by username";
	} elsif ($searchby eq "siteterm") {
		$statement .= ", sites";
		if ($backup) { $statement .= "_backup"; }
		$statement .= " where sites.term regexp '$account' and sites.user=users.id order by username";
	}
	my $sth = &mySQL($statement);
 	my ($found, @processing);
	if ($sth->rows > 0) { $found=1; }
	while (my $user = $sth->fetchrow_array) {
		push(@processing, $user);
	}
	$sth->finish();
	return($found, @processing);
}
###############################################

###############################################
sub make_active {
	my ($member) = @_;
	my $statement = "update users set status = 'active' where username='$member'";
	my $sth = &mySQL($statement);
	my $user_id = mySQLGetUserID($member);
	$statement = "update sites set status='approved' where user='$user_id'";
	$sth = &mySQL($statement);
}
###############################################

###############################################
sub delete_listing {
	my ($member, $listing, $id) = @_;
	my $user_id = &mySQLGetUserID($member);
	my $statement = "delete from sites where user='$user_id' and term='$listing'";
	if ($id) { $statement .= " and id='$id'"; }
	my $sth = &mySQL($statement);
	#$statement = "delete from stats where user='$user_id' and term='$listing'";
	#$sth = &mySQL($statement);
}
###############################################

###############################################
sub delete_member {
	my ($member) = @_;
	my $user_id = &mySQLGetUserID($member);
	my $statement = "delete from users where id='$user_id'";
	my $sth = &mySQL($statement);
	$statement = "delete from sites where user='$user_id'";
	$sth = &mySQL($statement);
	$statement = "delete from balanceaddon where user='$user_id'";
	$sth = &mySQL($statement);
	$statement = "delete from stats where user='$user_id'";
	$sth = &mySQL($statement);
}
###############################################

###############################################
sub gather_emails {
	my ($type) = @_;
	my (@info);
	my $statement = "select username from users ";
	unless ($type eq "all") { $statement .= "where status='$type' " }
	$statement .= "order by username";
	my $sth = &mySQL($statement);
	while (my $data = $sth->fetchrow_array) {
		push (@info, $data);
	}
	$sth->finish();
	return(@info);
}
###############################################

###############################################
sub update_member {
	my ($sitestatus, $p, $pass2, $member, %FORM) = @_;
	my $user_id = mySQLGetUserID($member);
	my $statement = "update users set name='$FORM{personsname}', street1='$FORM{address1}', street2='$FORM{address2}', 
	city='$FORM{city}', province='$FORM{state}', zip='$FORM{zip}', country='$FORM{country}', phone='$FORM{phone}', 
	email='$FORM{email}', card_holder='$FORM{ccname}', card_number='$p', card_expires='$FORM{expiration}', password='$pass2', 
	status='$FORM{status}', date='$FORM{created}', balance='$FORM{balance}', company='$FORM{company}' where id='$user_id'";
	my $sth = &mySQL($statement);
	
	$statement = "update sites set status='$sitestatus' where user='$user_id'";
	$sth = &mySQL($statement);
}
###############################################

###############################################
sub display_payhistory {
	my ($adv15, $total, $numb, @inner) = @_;
	if ($inner[1] eq "[payment history]") {
		$numb++;
		$total += $inner[4];
print <<EOF
<tr>
<td><font face="verdana" size="-1">$numb</font></td>
<td><font face="verdana" size="-1">$inner[2]</font></td>
<td><font face="verdana" size="-1">$adv15$inner[4]</font></td>
</tr>
EOF
	}
	return ($total, $numb);
}	
###############################################

1;
__END__
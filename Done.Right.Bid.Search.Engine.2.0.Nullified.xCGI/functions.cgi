package main_functions;
my $path = ""; # With a slash at the end
undef %config;
local %config = ();
do "${path}config/config.cgi";
my $file_ext = "$config{'extension'}";
if ($file_ext eq "") { $file_ext = "cgi"; }

###############################################
sub config_vars {
	do "${path}config/config.cgi";
	my $adminemail = $config{'adminemail'};
	my $adminurl = $config{'adminurl'};
	my $sendmail = $config{'sendmail'};
	my $company = $config{'company'};
	my $websiteurl = $config{'websiteurl'};
	my $secureurl = $config{'secureurl'};
	my $server = $config{'server'};
	return ($adminemail, $adminurl, $sendmail, $company, $websiteurl, $secureurl, $server);
}
###############################################

###############################################
sub checkpath {
	my ($file, $path) = @_;
	do "${path}config/config.cgi";
	if ($path || $config{'modperl'} == 1) {
		unless (-e "${path}$file.$file_ext") {
			print "Content-type: text/html\n\n";
			print "<center><B>ERROR</B><P>\n";
			print "You have specified an invalid path for the \$path variable.  Please open the file $file.$file_ext and correct this.<BR><BR>\n";
			print "The path you have specified is: <font color=red>$path</font><BR>\n";
			my $datapath = $ENV{'SCRIPT_FILENAME'};
			$datapath =~ s/$file\.${file_ext}$//;
			if (-e "${datapath}$file.$file_ext") {
				print "Try changing this path to: <font color=blue>$datapath</font><BR><BR>\n";
			}
			&exit;
		}
	}
}
###############################################

###############################################
sub exit {
	do "${path}config/config.cgi";
	if ($config{'data'} eq "mysql") { &database_functions::disconnect; }
	if ($config{'modperl'} == 1) { Apache::exit(0); }
	else { exit; }
}
###############################################

###############################################
sub send_email {
	my ($from, $to, $subject, $emailmessage) = @_;
	do "${path}config/config.cgi";
	my $sendmail = $config{sendmail};
	if ($config{'server'} eq "nt") {
		eval { require Net::SMTP; }; if ($@) { die "The Net::SMTP module used for sending email appears to not be installed"; }
		my $smtp = Net::SMTP->new($sendmail);
		$smtp->mail($from);
		$smtp->to($to);

		$smtp->data();
		$smtp->datasend("To: $to\n");
		$smtp->datasend("From: $from\n");
		$smtp->datasend("Subject: $subject\n");
		$smtp->datasend($emailmessage);
		$smtp->dataend();
		$smtp->quit;
	} else {
		open (MAIL, "|$sendmail -t");
		print MAIL "Subject: $subject\n";
		print MAIL "To: $to\n";
		print MAIL "From: $from\n";
		print MAIL "$emailmessage\n";
		close(MAIL);
	}
}
###############################################

###############################################
sub getdate {
	my ($sec, $min, $hour, $mday, $mon, $year)=localtime(time);
	$mon++;
	if (length($mon) == 1) { $mon = "0$mon"; }
	if (length($mday) == 1) { $mday = "0$mday"; }
	if (length($year) == 3) { $year =~ s/1//; }
	my $newdate = "20$year-$mon-$mday";
	return ($newdate);
}
###############################################

###############################################
sub remove_char {
	my (%FORM) = @_;
	foreach my $key(keys %FORM) {
		$FORM{$key} =~ s/"//g;
	}
	return (%FORM);
}
###############################################

###############################################
sub add_char {
	my ($data, %FORM) = @_;
	foreach my $key(keys %FORM) {
		if ($data eq "mysql") { $FORM{$key} = &database_functions::unescape($FORM{$key}); }
		$FORM{$key} =~ s/"/&quot;/g;
	}
	return (%FORM);
}
###############################################

###############################################
sub check_new_listing {
	my ($numb, %FORM) = @_;
	my $keyword = "keyword$numb";
	my $title = "title$numb";
	my $description = "description$numb";
	my $url = "url$numb";
	my $bid = "bid$numb";
	my @error;
	my (@eng, @adv, @opt);
	&getdefaults(\@eng, \@adv, \@opt);
	if ($FORM{$keyword} eq "") { $error[$numb] .= "$FORM{$keyword} $keyword $numb Please specify a valid <B>Search Term</B><BR>"; }
	if ($FORM{$title} eq "") { $error[$numb] .= "Please specify a valid <B>Title</B><BR>"; }
	if ($FORM{$description} eq "") { $error[$numb] .= "Please specify a valid <B>Description</B><BR>"; }
	if ($FORM{$url} eq "http://" || $FORM{$url} eq "" || $FORM{$url} !~ /./) { $error[$numb] .= "Please specify a valid <B>URL</B><BR>"; }
	if ($FORM{$bid} eq "0.00" || $FORM{$bid} eq "" || $FORM{$bid} < "0.01" || $FORM{$bid} !~ /\./) { $error[$numb] .= "Please specify a valid <B>Bid</B><BR>"; }
	elsif ($FORM{$bid} < $adv[14]) { $error[$numb] .= "Please enter a minimum bid of <B>$adv[15]$adv[14]</B><BR>"; }
	return($error[$numb]);
}
###############################################

###############################################
sub parse_form {
	my ($numb, %FORM) = @_;
	my $keyword = "keyword$numb";
	my $title = "title$numb";
	my $description = "description$numb";
	my $url = "url$numb";
	my $bid = "bid$numb";
	$FORM{$bid} =~ s/\$//;
	$FORM{$url} =~ s/\|/\:/g;
	$FORM{$title} =~ s/\|/\:/g;
	$FORM{$description} =~ s/\|/\:/g;
	$FORM{$description} =~ s/\r+/ /g;
	$FORM{$description} =~ s/\t+/ /g;
	$FORM{$description} =~ s/\n+/ /g;
	$FORM{$keyword} =~ tr/A-Z/a-z/;
	$FORM{$keyword} =~ s/\|/\:/g;
	$FORM{$keyword} =~ s/, / /g;
	$FORM{$keyword} =~ tr/,/ /;
	$FORM{$keyword} =~ s/ +/ /g;
	$FORM{$keyword} =~ tr/+/ /;
	$FORM{$keyword} =~ s/"//g;
	$FORM{$keyword} =~ s/^ //g;
	$FORM{$keyword} =~ s/ $//g;
	$FORM{$keyword} =~ s/\///g;
	return($keyword, $title, $description, $url, $bid, %FORM);
}
###############################################

###############################################
sub check_profile {
	my ($username, $password, $email, %FORM) = @_;
	my $error;
	if ($FORM{'name'} eq "" || $FORM{'name'} !~ / /) { $error .= "Please specify your first & last <B>Name</B><BR>"; }
	if ($email !~ /.*\@.*\..*/) { $error .= "Please specify a valid <B>E-Mail Address</B><BR>"; }
	unless ($FORM{'address1'}) { $error .= "Please specify your <B>Street Address</B><BR>"; }
	unless ($FORM{'city'}) { $error .= "Please specify your <B>City</B><BR>"; }
	unless ($FORM{'state'}) { $error .= "Please specify your <B>State</B><BR>"; }
	unless ($FORM{'zip'}) { $error .= "Please specify your <B>Zip</B><BR>"; }
	unless ($FORM{'phone'}) { $error .= "Please specify your <B>Phone Number</B><BR>"; }
	$username =~ tr/A-Z/a-z/;
	$username =~ tr/ /_/;
	$password =~ tr/ /_/;

	if ($username eq $password) { $error .= "Your <B>Username</B> cannot be the same as your <B>Password</B><BR>"; }
	unless ($FORM{'tab'} eq "modifyprofile") {
		$error .= &database_functions::username_check($username);
		my $lengthuser = length($username);
		if ($lengthuser < 5) { $error .= "Please specify a <B>Username</B> of <B>5 - 12</B> characters<BR>"; }
	}
	my $lengthpass = length($password);
	if ($lengthpass < 5) { $error .= "Please specify a <B>Password</B> of <B>5 - 12</B> characters<BR>"; }
	return ($error);
}
###############################################

###############################################
sub getdefaults {
	my ($eng, $adv, $opt) = @_;
	open (FILE, "${path}config/defaults.txt");
	my @data = <FILE>;
	close (FILE);
	chomp(@data);
	@{$eng} = split(/\|/, $data[0]);
	@{$adv} = split(/\|/, $data[1]);
	@{$opt} = split(/\|/, $data[4]);
}
###############################################

###############################################
#Security Check
sub checklogin {
	my ($user, $formlogin) = @_;
	do "${path}config/config.cgi";
	my $current_time = time();
	my $ip = $ENV{'REMOTE_ADDR'};
	my @ip = split(/\./, $ip);
	$ip = "$ip[0].$ip[1].$ip[2]";
	my ($verified, $logmessage, %FORM);
	if ($formlogin eq "Login") {
		&expiredsession;
		if ($user eq $config{'user'}) {
			if (-e "${path}config/session.txt") { open (FILE, ">>${path}config/session.txt"); }
			else { open (FILE, ">${path}config/session.txt"); }
			print FILE "$ip|$current_time";
			close (FILE);
			$verified=1;
			my $p = $user;
			my $encryptkey = "drbidsearch";
			$p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
			$FORM{'user'} = $p;
			return ($FORM{'user'});
		}
	} else {
		my $p = $user;
		my $encryptkey = "drbidsearch";
		$p = &Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
		if ($p eq $config{'user'}) {
			open (FILE, "${path}config/session.txt");
			my @session = <FILE>;
			close (FILE);
			my $ff=0;
			foreach my $line(@session) {
				chomp($line);
				my @inner = split(/\|/, $line);
				if ($inner[0] eq $ip) {
					my $elapsed = $current_time - $inner[1];
					if ($elapsed > 3600) {
						$logmessage = "Session Expired, Please <a href=admin.$file_ext>click here</a> to re-login";
						&expiredsession;
						last;
					} else {
						$verified=1;
						open (FILE, "${path}config/session.txt");
						my @session = <FILE>;
						close (FILE);
						open (FILE, ">${path}config/session.txt");
						my $ss=0;
						foreach my $line(@session) {
							chomp($line);
							if ($ff == $ss) {
								my @inner = split(/\|/, $line);
								print FILE "$inner[0]|$current_time\n";
							} else { print FILE "$line\n"; }
							$ss++;
						}
						close (FILE);
						my $encryptkey = "drbidsearch";
						my $p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
						$FORM{'user'} = $p;
						return ($FORM{'user'});
						last;
					}
				}
				$ff++;
			}
		}
	}
	unless ($verified) {
		print "Content-type: text/html\n\n";
		my $nolink=1;
		&header($nolink);
		if ($logmessage) { print $logmessage; }
		else { print "Access Denied. Please <a href=admin.$file_ext>click here</a> to login"; }
		&footer;
		&exit;
	}

	sub expiredsession {
		my $current_time = time();
		open (FILE, "${path}config/session.txt");
		my @session = <FILE>;
		close (FILE);
		open (FILE, ">${path}config/session.txt");
		foreach my $line(@session) {
			chomp($line);
			my @inner = split(/\|/, $line);
			my $elapsed = $current_time - $inner[1];
			unless ($elapsed > 3600) {
				print FILE "$line\n";
			}
		}
		close (FILE);
	}
}
###############################################

###############################################
sub link_sort {
	my ($plus, $field, $dir, @member) = @_;
	my @sorted_links;
	if ($plus == 1) {
		@sorted_links = @member;
	} else {
		if ($field == 0) { # If $field == 0, sort by search term
			if ($dir eq "desc") {
				@sorted_links =
					reverse sort {
					my @field_a = split /\|/, $a;
					my @field_b = split /\|/, $b;
						$field_a[$field] cmp $field_b[$field]
										||
						$field_a[0] cmp $field_b[0]
						;
					} @member; # This is the array we stored the information above into
			} else {
				@sorted_links =
					sort {
					my @field_a = split /\|/, $a;
					my @field_b = split /\|/, $b;
						$field_a[$field] cmp $field_b[$field]
										||
						$field_a[0] cmp $field_b[0]
						;
					} @member; # This is the array we stored the information above into
			}
		} else {
			if ($dir eq "desc") {
				@sorted_links =
					reverse sort {
					my @field_a = split /\|/, $a;
					my @field_b = split /\|/, $b;
						$field_a[$field] <=> $field_b[$field]
										||
						$field_a[0] cmp $field_b[0]
						;
					} @member;
			} else {
				@sorted_links =
					sort {
					my @field_a = split /\|/, $a;
					my @field_b = split /\|/, $b;
						$field_a[$field] <=> $field_b[$field]
										||
						$field_a[0] cmp $field_b[0]
						;
					} @member;
			}
		}	
	}
	return (@sorted_links);
}
###############################################

###############################################
sub emailoutbid {
	my ($account, $keyword, $oldposition, $rank2, @userinfo) = @_;
	my ($adminemail, $memurl, $sendmail, $company, $websiteurl, $secureurl, $server) = (&config_vars());
	open (FILE, "${path}template/emailoutbid.txt");
	my @emailmess = <FILE>;
	close (FILE);
	my $emailtemp = "";
	foreach my $emailtemp2(@emailmess) {
		chomp($emailtemp2);
		$emailtemp .= "$emailtemp2\n";
	}
	unless ($secureurl eq "") { $memurl = $secureurl; }
	$emailtemp =~ s/\[name\]/$userinfo[0]/ig;
	$emailtemp =~ s/\[searchterm\]/$keyword/ig;
	$emailtemp =~ s/\[oldposition\]/\#$oldposition/ig;
	$emailtemp =~ s/\[newposition\]/\#$rank2/ig;
	$emailtemp =~ s/\[members\]/${memurl}members.$file_ext/ig;
	$emailtemp =~ s/\[company\]/$company/ig;
	$emailtemp =~ s/\[url\]/$websiteurl/ig;
	if ($server eq "nt") {
		eval ("require Net::SMTP"); if ($@) { die "The Net::SMTP module used for sending email appears to not be installed"; }
		my $smtp = Net::SMTP->new($sendmail);
		$smtp->mail($adminemail);
		$smtp->to($userinfo[8]);

		$smtp->data();
		$smtp->datasend("To: $userinfo[8]\n");
		$smtp->datasend("From: $adminemail\n");
		$smtp->datasend("Subject: $company - Listing Dropped 1 Position\n");
		$smtp->datasend($emailtemp);
		$smtp->dataend();
		$smtp->quit;
	} else {
		open(MAIL,"|$sendmail -t");
		print MAIL "Subject: $company - Listing Dropped 1 Position!\n";
		print MAIL "To: $userinfo[8]\n";
		print MAIL "From: $adminemail\n";
		print MAIL "$emailtemp\n";
		close(MAIL);
	}
}
###############################################

###############################################
sub merchant_authorizenet {
	my ($login, $test_mode, %FORM) = @_;
	my ($firstname, $lastname) = split(' ', $FORM{'chname'});
	my $adc_delim_data     = "TRUE";
	my $adc_url            = "FALSE";
	my $authorization_type = "AUTH_CAPTURE";
	my $an_version         = "3.0";
	my %form_data;
	$form_data{'first_name'}         = "$firstname";
	$form_data{'last_name'}          = "$lastname";
	$form_data{'payment_method'}     = "CC";
	$form_data{'card_num'}           = "$FORM{'ccnumber'}";
	$form_data{'expiration_date'}    = "$FORM{'expire'}";
	$form_data{'charge_amount'}      = "$FORM{'balance'}";

	my $echo_data = "TRUE";

	my $host = "secure.authorize.net";
	my $script = "/gateway/transact.dll";
	my $port = "443";

	eval ("use Net::SSLeay qw(post_https make_headers make_form)"); if ($@) { die "The Net::SSLeay module used for authorize.net appears to not be installed"; }
	$Net::SSLeay::ssl_version = 3;
    
	%form_data = make_form
    	    (
        	    'x_Login'           => $login
           		,'x_Version'         => $an_version
       		    ,'x_ADC_Delim_Data'  => $adc_delim_data
      			,'x_ADC_URL'         => $adc_url
           		,'x_Type'            => $authorization_type
           		,'x_Test_Request'    => $test_mode
           		,'x_Method'          => $form_data{'payment_method'}
           		,'x_First_Name'      => $form_data{'first_name'}
           		,'x_Last_Name'       => $form_data{'last_name'}
           		,'x_Amount'          => $form_data{'charge_amount'}
           		,'x_Card_Num'        => $form_data{'card_num'}
           		,'x_Exp_Date'        => $form_data{'expiration_date'}
           		,'x_Echo_Data'       => $echo_data
        	);

	my ($reply_data, $reply_type, %reply_headers) =
              post_https($host, $port, $script, '', %form_data);

	# split out the returned fields
	my @data = split (/\,/, $reply_data);
	return (@data);
}
###############################################

###############################################
sub merchant_linkpoint {
	my ($login, $key, %FORM) = @_;
	#eval ("use LPERL::lperl"); if ($@) { die "The LPERL::lperl module used for linkpoint transactions appears to not be installed"; }
	
	# Enter the path to lbin in the next line (this example reflects lbin in the current directory);
	# lbin will customarily be placed in the cgi-bin directory on many web servers):
	$lperl = new LPERL("/home/virtual/drscripts/home/httpd/cgi-bin/beta/bse20testtext/LPERL", "FILE", "/home/virtual/drscripts/home/httpd/cgi-bin/beta/bse20testtext/LPERL");
	
	# All the input data used in this example must be adjusted to the user's environment,
	# specifically the following parameters: hostname, storename and keyfile
	my @expire = split(/\//, $FORM{'expire'});
	my $transaction_hash = {
		hostname => "staging.linkpt.net",
		port => "1139",
		storename => "$login", # your store name
		keyfile => "./lperl/$key.pem", # path required to keyfile
		amount => "$FORM{balance}",
		result => "GOOD",
		cardNumber => "$FORM{ccnumber}",
		CardExpMonth => "$expire[0]",
		cardExpYear => "$expire[1]",
	};
	print "Content-type: text/html\n\n";
	%ret = $lperl->ApproveSale($transaction_hash);
	print "fds $ret{statusCode}, $ret{statusMessage}";
	return ($ret{statusCode}, $ret{statusMessage}, $ret{AVSCode}, $ret{trackingID}, $ret{neworderID});
}	
###############################################

###############################################
sub merchant_2checkout {
	my ($md, $string, $account, $invoice, $data) = @_;
	my $valid;
	my @referers=("www.2checkout.com","2checkout.com"); 
	my ($check_referer) = 0; 

	if ($ENV{'HTTP_REFERER'}) {
		foreach my $referer (@referers) { 
			if ($ENV{'HTTP_REFERER'} =~ m|https?://([^/]*)$referer|i) { 
				$check_referer = 1; 
				last; 
			} 
		} 
	} else {
		my @stats = &database_functions::GetStats($account);
		my $found;
		foreach my $line(@stats) {
			chomp($line);
			my @inner = split(/\|/, $line);
			if ($inner[0] eq "[payment history]") {
				if ($data eq "mysql") {
					if ($inner[2] eq "$invoice") {
						$found = 1;
						last;
					}
				} else {
					foreach my $line2(@inner) {
						chomp($line2);
						my @split = split(/\^/, $line2);
						if ($split[3] eq "$invoice") {
							$found = 1;
							last;
						}
					}
				}
			}
		}
		unless ($found) { $check_referer = 1; }
	}
	if ($check_referer != 1) {
		$valid = "2";
		return($valid);
		&exit;
	} else {
		$valid = "1";
	}
		
	eval ("require Digest::MD5"); if ($@) { die "The Digest::MD5 module used for 2checkout transactions appears to not be installed"; }
	my $md5 = Digest::MD5->new; 
	$md5->add($string); 
	my $digest = $md5->hexdigest;
	$digest = uc($digest);
	if ($digest ne $md) { $valid = 2; }
	return ($valid);
}
###############################################

###############################################
sub merchant_paypal {
	my ($inbuffer) = @_;
	$inbuffer .= '&cmd=_notify-validate';
	my ($valid);
	eval ("use LWP::UserAgent"); if ($@) { die "The LWP::UserAgent module used for paypal transactions appears to not be installed"; }
	my $ua = new LWP::UserAgent;
	my $req = new HTTP::Request 'POST','https://www.paypal.com/cgibin/webscr';
	$req->content_type('application/x-www-form-urlencoded');
	$req->content($inbuffer);
	my $res = $ua->request($req);
	my $content = $res->content();
	if ($content eq 'VERIFIED') { $valid = 1; }
	else { $valid = 2; }
	return ($valid);
}
###############################################

###############################################
sub clickbank_valid {
	my ($account, $invoice, $data) = @_;
	my $valid;
	my @referers=("secure.clickbank.net","clickbank.net","secure.clickbank.com","clickbank.com"); 
	my ($check_referer) = 0; 

	if ($ENV{'HTTP_REFERER'}) { 
		foreach my $referer (@referers) { 
			if ($ENV{'HTTP_REFERER'} =~ m|https?://([^/]*)$referer|i) { 
				$check_referer = 1; 
				last; 
			} 
		} 
	} else {
		my @stats = &database_functions::GetStats($account);
		my $found;
		foreach my $line(@stats) {
			chomp($line);
			my @inner = split(/\|/, $line);
			if ($inner[0] eq "[payment history]") {
				if ($data eq "mysql") {
					if ($inner[2] eq "$invoice") {
						$found = 1;
						last;
					}
				} else {
					foreach my $line2(@inner) {
						chomp($line2);
						my @split = split(/\^/, $line2);
						if ($split[3] eq "$invoice") {
							$found = 1;
							last;
						}
					}
				}
			}
		}
		unless ($found) { $check_referer = 1; }
	}

	if ($check_referer != 1) {
		$valid = "2";
		return($valid);
		&exit;
	} else {
		$valid = "1";	
	}
	
	my($a,$b,$c,$h,$i,$l,$q,$w,$x,$y,$z,@s,@v);
	open (FILE, "${path}config/merchant.txt");
	my @merchant = <FILE>;
	close (FILE);
	chomp (@merchant);
	$a=$merchant[2];
	$q='&'.substr($ENV{'QUERY_STRING'},0,256);
	$q=~/\Wseed=(\w+)/; $b=$1;
	$q=~/\Wcbpop=(\w+)/; $c=$1;

	return 0 unless $a&&$b&&$c;

	$h=0x80000000; $l=0x7fffffff;
	$q='';
	$w=uc "$a $b";
	$x=$y=$z=17;
	@v=unpack("C*",$w);
	my $n=1+$#v;
	for ($i=0;$i<256;$i++) {
		$w=(($x&$l)+($y&$l))^(($x^$y)&$h);
		$w=($w<<$z)|($w>>(32-$z));
		$w=(($w&$l)+$v[$i%$n])^($w&$h);
		$s[$i&7]+=$w&31; $z=$y&31;
		$y=$x;
		$x=$w;
	}
	for ($i=0;$i<8;$i++) {
		$q.=substr('0123456789BCDEFGHJKLMNPQRSTVWXYZ',$s[$i]&31,1);
	}
	return $c eq $q;
} 
###############################################

###############################################
#Header HTML
sub header {
	my ($nolink, $user) = @_;
print <<EOF;
<html>
 <head>
 
 <title>Admin Area</title>
 <style>
 <!--
 BODY      {font-family:verdana;}
 A:link    {text-decoration: underline;  color: #000099}
 A:visited {text-decoration: underline;  color: #000099}
 A:hover   {text-decoration: none;  color: #000099}
 A:active  {text-decoration: underline;  color: #000099}
 -->
 </style> 
 <body text="#000000" bgcolor="#333333" link="#000099" vlink="#000099" alink="#000099">
 
 <!-- start top table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td width="1"><img SRC="/images/place.gif" height=1 width=5></td>
 
 <td><img SRC="/images/place.gif" height=5 width=1></td>
 
 <td width="1"><img SRC="/images/place.gif" height=1 width=5></td> </tr>
 
 <tr>
 <td width="10%"><img SRC="/images/place.gif" height=1 width=5></td>
 
 <td>
 
 <!-- start logo table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=2 WIDTH="100%" BGCOLOR="#000066" >
 <tr>
 <td width="15%">
<img src="/images/smalllogo.gif" ALT="Scripts" WIDTH="130" HEIGHT="83">
</td>
 <td valign=bottom><center><img src="/images/adminarea.gif" width=351 height=60></center>
 </td>
 <td width="15%">
<img src="/images/smalllogo.gif" ALT="Scripts" ALIGN="RIGHT" WIDTH="130" HEIGHT="83">
</td>
 </tr>
 </center></table>
 <!-- end logo table -->
 
 <!-- start border table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td><img SRC="/images/place.gif" height=5 width=1></td>
 </tr>
 </center></table>
 <!-- end border table -->

 <!-- start home and date table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <tr><td>
EOF
my $url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
unless ($nolink == 1) {
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.$file_ext?tab=login&user=$user&file=bidsearchengine">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.$file_ext?tab=config&user=$user&file=bidsearchengine">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="">Update.N.A</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="">Download.N.A</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="">Support.N.A</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="">Feedback.N.A</a></font></b>
<BR><font face="verdana" size="-1"><B><a href="customize.$file_ext?tab=customize&user=$user&file=bidsearchengine"><font color="#FFFFFF">Customize</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.$file_ext?tab=pending&user=$user&file=bidsearchengine"><font color="#FFFFFF">Members Pending</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.$file_ext?user=$user&file=bidsearchengine"><font color="#FFFFFF">View Members</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.$file_ext?tab=email&user=$user&file=bidsearchengine"><font color="#FFFFFF">Email</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="settings.$file_ext?tab=settings&user=$user&file=bidsearchengine"><font color="#FFFFFF">Settings</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="addons.$file_ext?tab=tracker&user=$user&file=bidsearchengine"><font color="#FFFFFF">Statistics</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="addons.$file_ext?tab=bantarget&user=$user&file=bidsearchengine"><font color="#FFFFFF">Targeted Banners</font></a></center></font></b>
EOF
} else {
	print "&nbsp;";
}
print <<EOF;
 </td>
 </TR>
 </TABLE></CENTER>


 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="/images/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=4 COLS=1 WIDTH="100%" BGCOLOR="#FFFFFF" >
 <TR>
 <TD>
<P><BR><center>

EOF
}
###############################################


###############################################
#Footer HTML
sub footer {
print <<EOF;

 </td></tr></table>
 <TD><IMG SRC="/images/place.gif" height=1 width=5></TD>
 </TR>
 
 <TR>
 <TD><IMG SRC="/images/place.gif" height=1 width=5></TD>
 
 <TD>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 ADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="/images/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <TR><TD>
 <CENTER>&nbsp;</CENTER>
 </TD>
 <TD align="center"><FONT color="#000066" FACE=verdana size="-1"><a href="">*********************</a>
 </TD>
 </TR>
 </TABLE></CENTER>
 
 <IMG SRC="/images/place.gif" height=5 width=1></TD>
 
 <TD><IMG SRC="/images/place.gif" height=1 width=5></TD>
 </TR>
 
 </TABLE></CENTER>
  
 </BODY>
 </HTML>
</body></html>
EOF
}
###############################################


###############################################
sub Encrypt {
    my ($source,$key,$pub_key) = @_;
    my ($cr,$index,$char,$key_char,$enc_string,$encode,$first,$second,$let1,$let2,$encrypted,%escapes) = '';
    $source = &rot13($source); 
    $cr = '·¨ '; 
    $source =~ s/[\n\f]//g; 
    $source =~ s/[\r]/$cr/g; 
    while ( length($key) < length($source) ) { $key .= $key } 
    $key=substr($key,0,length($source)); 
    while ($index < length($source)) { 
        $char = substr($source,$index,1);
        $key_char = substr($key,$index,1);
        $enc_string .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    for (0..255) { $escapes{chr($_)} = sprintf("%2x", $_); } 
    $index=0;
    while ($index < length($enc_string)) { 
        $char = substr($enc_string,$index,1);
        $encode = $escapes{$char};
        $first = substr($encode,0,1);
        $second = substr($encode,1,1);
        $let1=substr($pub_key, hex($first),1);
        $let2=substr($pub_key, hex($second),1);
        $encrypted .= "$let1$let2";
        $index++;
    }
    return $encrypted;
}
###############################################


###############################################
sub Decrypt {
    my ($encrypted, $key, $pub_key) = @_;
    $encrypted =~ s/[\n\r\t\f]//eg; 
    my ($cr,$index,$decode,$decode2,$char,$key_char,$dec_string,$decrypted) = '';
    while ( length($key) < length($encrypted) ) { $key .= $key }
    $key=substr($key,0,length($encrypted)); 
    while ($index < length($encrypted)) {
        $decode = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $decode2 = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $dec_string .= chr(hex("$decode$decode2")); 
    }
    $index=0;
    while( $index < length($dec_string) ) { 
        $char = substr($dec_string,$index,1);
        $key_char = substr($key,$index,1);
        $decrypted .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    $cr = '·¨ '; 
    $decrypted =~ s/$cr/\r/g;
    return &rot13( $decrypted ); 
}
###############################################


###############################################
sub rot13{ 
    my $source = shift (@_);
    $source =~ tr /[a-m][n-z]/[n-z][a-m]/; 
    $source =~ tr /[A-M][N-Z]/[N-Z][A-M]/;
    $source = reverse($source);
    return $source;
}
###############################################


###############################################
sub my_forker {
	my ($timeout, @address) = @_;
	my (%results, $pid, $temp, $key, @data);
	
	for (my $i =0 ; $i < @address; $i++)	{
		$pid = open(FROM, "-|");
		if ($pid) {
			while ($temp = <FROM>) {
				if ($temp =~ m!<START><(.*)>\n!) {
					$key = $1;
					$results{"$key"} = ''; ##create the key and wait. If no data then timed out or unknown error here
				} elsif($key ne '')	{
					$results{"$key"} .= $temp;
				}
			}
		} else {
			close FROM;
			##child here
			my @data = &get_url($address[$i], 'GET', $timeout);
			print STDOUT "<START><$address[$i]>\n";
			print STDOUT $data[2];
			&exit;
		}
	}
	wait();
	close FROM;
	
	return %results;
}
###############################################

###############################################
sub get_url {
    my($URL, $method, $timeout)= @_;
    my($host, $uri, $endhost, $S, $rin, $content_length, @NO_PROXY);
    my($response, $status_line, $headers, $body, $status_code);
    $method= uc($method) ;
    $method= 'GET' unless length($method) ;

    ($host, $uri)= $URL=~ m#^http://([^/]*)(.*)$#i ;
    $uri= '/' unless length($uri) ;
    $endhost= $host ;

    # use an HTTP proxy if $ENV{'http_proxy'} is set
    USEPROXY: {
        last USEPROXY unless $host=~ /\./ ;
        if (length($ENV{'http_proxy'})) {
            foreach (@NO_PROXY) {
                last USEPROXY if $host=~ /$_$/i ;
            }
            ($host)= $ENV{'http_proxy'}=~ m#^(?:http://)?([^/]*)#i ;
            $uri= $URL ;
        }
    }

    # Open socket
    $S= IO::Socket::INET->new(PeerAddr => $host,  # may contain :port
                              PeerPort => 80,     # default if none in PeerAddr
                              Proto => 'tcp') ;
    return("HTTP/1.1 600 Can't create socket: $@") unless defined($S) ;
    $S->autoflush() ;   # very important!!

    # Send HTTP 1.1 request
    print $S "$method $uri HTTP/1.1\015\012",
             "Host: $endhost\015\012",
             "Connection: close\015\012",
             "User-agent: AndySocket/1.001\015\012",
             "\015\012" ;

    # Wait for socket response with select()
    vec($rin= '', fileno($S), 1)= 1 ;
    select($rin, undef, undef, $timeout) 
        || return("HTTP/1.1 601 Connection timed out") ;

    local($/)= "\012" ;

    # Handle "100 Continue" responses for HTTP 1.1: loop until non-1xx.
    do {
        $status_line= <$S> ;
        $status_line=~ s/\015?\012$// ;
        ($status_code)= $status_line=~ m#^HTTP/\d+\.\d+\s+(\d+)# ;

        $headers= '' ;
        while (<$S>) {
            last if /^\015?\012/ ;
            $headers.= $_ ;
        }
        $headers=~ s/\015?\012[ \t]+/ /g ;
    } until $status_code!~ /^1/ ;

    # Body length is determined by HTTP 1.1 spec, section 4.4:  these
    #   certain conditions implying no body, then chunked encoding,
    #   then Content-length: header, then server closing connection.
    if ($method eq 'HEAD' or $status_code=~ /^(1|204\b|304\b)/) {
        $body= undef ;

    # else chunked encoding
    } elsif ($headers=~ /^transfer-encoding:[ \t]*chunked\b/im) {
        my($this_chunk, $chunk_size, $readsofar, $thisread) ;
        while ($chunk_size= hex(<$S>)) {
            $readsofar= 0 ;
            while ($readsofar!=$chunk_size) {
                last unless $thisread=
                    read($S, $this_chunk, $chunk_size-$readsofar, $readsofar) ;
                $readsofar+= $thisread ;
            }
            return("HTTP/1.1 603 Incomplete chunked response", $headers, $body)
                if $readsofar!=$chunk_size ;
            $_= <$S> ;    # clear CRLF after chunk
            $body.= $this_chunk ;
        }

        # Read footers if they exist
        while (<$S>) {
            last if /^\015?\012/ ;
            $headers.= $_ ;
        }
        $headers=~ s/\015?\012[ \t]+/ /g ;


    # else body length given in Content-length:
    } elsif (($content_length)= $headers=~ /^content-length:[ \t]*(\d+)/im) {
        my($readsofar, $thisread) ;
        while ($readsofar!=$content_length) {
            last unless $thisread=
                read($S, $body, $content_length-$readsofar, $readsofar) ;
            $readsofar+= $thisread ;
        }
        return(sprintf("HTTP/1.1 602 Incomplete response (%s of %s bytes)",
                       $readsofar+0, $content_length),
               $headers, $body)
            if $readsofar!=$content_length ;


    # else body is entire socket output
    } else {
        local($/)= undef ;
        $body= <$S> ;
    }

    close($S) ;

    return($status_line, $headers, $body) ;
}
###############################################


1;
__END__

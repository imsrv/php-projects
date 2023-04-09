
use IO::Socket;

my $ver = 'acc14';


sub parse_form {
    use CGI;
    $q_CGI = new CGI();
    my ($l, %FORM);
    my @list = $q_CGI->all_parameters();
    for $l (@list) {
      if (exists($FORM{$key})) {
        $FORM{$key} .= "\t$value";
      } else {
        $FORM{$key} = $value;
      }
      $FORM{$l} = $q_CGI->param($l);
    }
    return %FORM;
}

sub s_q {
  my $t = shift;
  $t =~ s/\"/&quot;/igms;
  return $t;
}

sub parse_get {
    my %FORM;
    my ($request_method, $query_string, @key_value_pairs, $key, $value, $key_value);

    $request_method = $ENV{'REQUEST_METHOD'};
    if ($request_method eq "GET") {
        $query_string = $ENV{'QUERY_STRING'};
    } else {
	exit;
        read (STDIN, $query_string, $ENV{'CONTENT_LENGTH'});
    }

    @key_value_pairs = split (/&/, $query_string);
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $key =~ tr/+/ /;
        $key =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
	if (exists($FORM{$key})) {
	  $FORM{$key} .= "\t$value";
        } else {
          $FORM{$key} = $value;
        }
    }
    return %FORM;
}
sub parse_as_get {
  my ($from) = @_;
    my %FORM;
    my ($request_method, $query_string, @key_value_pairs, $key, $value, $key_value);
    $query_string = $from;

    @key_value_pairs = split (/&/, $query_string);
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $key =~ tr/+/ /;
        $key =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
	if (exists($FORM{$key})) {
	  $FORM{$key} .= "\t$value";
        } else {
          $FORM{$key} = $value;
        }
    }
    return %FORM;
}

sub parse_form_simply {
    my %FORM;
    my ($request_method, $query_string, @key_value_pairs, $key, $value, $key_value);

    $request_method = $ENV{'REQUEST_METHOD'};
    if ($request_method eq "GET") {
        $query_string = $ENV{'QUERY_STRING'};
    } else {
        read (STDIN, $query_string, $ENV{'CONTENT_LENGTH'});
    }

    @key_value_pairs = split (/&/, $query_string);
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $key =~ tr/+/ /;
        $key =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
	if (exists($FORM{$key})) {
	  $FORM{$key} .= "\t$value";
        } else {
          $FORM{$key} = $value;
        }
    }
    return %FORM;
}



sub parse_cookie {
    my %FORM;
    my (@key_value_pairs, $key, $value, $key_value);

    @key_value_pairs = split (/;\s*/, $ENV{HTTP_COOKIE});
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $FORM{$key} = $value;
    }
    return %FORM;
}

sub make_letter {
  my ($id) = @_;
  my $letter = new Template('tmpl/letter.eml');
  my $body = '';
  my ($q, $sth, $row);

  $q = "select * from $ver\_letters where id=$id";
  my $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr, $q;
  my $row = $sth->fetchrow_hashref;

  $letter->replace('email-from', $row->{from_field});
  $letter->replace('subject', $row->{subject});
  my $addheader = $row->{additional_header};
  $addheader =~ s/\r//igm;
  $addheader =~ s/\n+/\n/igm;
  $letter->replace('additional_header', $addheader);

  $q = "select cont from $ver\_attache where id=$row->{body_id}";
  my $sth2 = $dbh->prepare($q);
  $sth2->execute() or print $sth2->errstr;
  while ($row2 = $sth2->fetchrow_hashref) {
    $body = $row2->{cont};
  }
  if ($row->{footer_id} != 0) {
    $q = "select cont from $ver\_attache where id=$row->{footer_id}";
    $sth2 = $dbh->prepare($q);
    $sth2->execute() or print $sth2->errstr;
    while ($row2 = $sth2->fetchrow_hashref) {
      $body = $body."\n".$row2->{cont};
    }
  }
  if ($row->{header_id} != 0) {
    $q = "select cont from $ver\_attache where id=$row->{header_id}";
    $sth2 = $dbh->prepare($q);
    $sth2->execute() or print $sth2->errstr;
    while ($row2 = $sth2->fetchrow_hashref) {
      $body = $row2->{cont}."\n".$body;
    }
  }
  $body =~ s/\r//gm;
  my %in = ('cont' => $body);
  my @list = (\%in);
  $letter->make_for_array('text-plain', $letter->get_area('text-plain'), @list);
#  $letter->replace('text-plain', $body);

  my @html = split /,/, $row->{html_ids};
  my @attache = split /,/, $row->{attache_ids};
  my $i;
  my @list = ();
  for $i (@html) {
    $q = "select * from $ver\_attache where id=$i";
    my $sth2 = $dbh->prepare($q);
    $sth2->execute() or print $sth2->errstr;
    my $row2;
    while ($row2 = $sth2->fetchrow_hashref) {
      my %in = (
	'cont' => $row2->{cont},
	'file-name' => (split /\\|\//, $row2->{path})[-1],
	'content-type' => $row2->{content_type}
      );
      @list = (@list, \%in);
    }
  }
  $letter->make_for_array('html-part', $letter->get_area('html-part'), @list);

  my @list = ();
  my $i;
  for $i (@attache) {
    $q = "select * from $ver\_attache where id=$i";
    my $sth2 = $dbh->prepare($q);
    $sth2->execute() or print $sth2->errstr;
    my $row2;
    while ($row2 = $sth2->fetchrow_hashref) {
      my ($content, $path, $content_type);
      if ($row2->{content_type} eq 'external') {
        if ($row2->{path} =~ /^http/i) {
          $content = getDoc($row2->{path});
          $content_type = 'text/html';
        } else {
          open FILE, "<$row2->{path}";
          my @a = <FILE>;
          $content = join '', @a;
          close FILE;
          $content_type = 'application/octet-stream';
        }
      } else {
        $content = $row2->{cont};
        $path = $row2->{path};
        $content_type = $row2->{content_type};
      }
      my %in = (
	'cont' => encode_base64($content),
	'file-name' => (split /\\|\//, $row2->{path})[-1],
	'content-type' => $content_type,
      );
      @list = (@list, \%in);
    }
  }
  $letter->make_for_array('base-part', $letter->get_area('base-part'), @list);
  

  return $letter;

}

sub get_record {
  my ($dbh, $q) = @_;
  my %ret;
  my ($sth1, $row1, $i);
  $sth1 = $dbh->prepare($q);
  $sth1->execute() or die ($sth1->errstr).", $q\n\n";
  while ($row1 = $sth1->fetchrow_hashref) {
    for $i (keys %$row1) {
      $ret{$i} = $row1->{$i};
    }
  }
  $sth1->finish();
  return %ret;

}

sub encodeurl {
    my ($toencode) = @_;
    $toencode =~ s/&amp;/&/gi;
    $toencode =~ s/([^a-zA-Z 0-9_\\\-\.])/sprintf("%%%02X",ord($1))/ego;
    $toencode =~ s/ /+/gm;
    return $toencode;
}

sub r {
  my ($i) = @_;
  
  my $possible = '1234567890ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  my @pos = split //, $possible;
  
  srand($$+time());

  my $a = '';
  my $j;
  for ($j = 0; $j<$i; $j++) {
    $a .= $pos[int rand(@pos)];
  }
  return $a;
}

sub replace_in_letter {
  my ($dbh, $letter, $sub, $id) = @_;
  my %user = get_record($dbh, "select 
	id, email, first_name, last_name, full_name, company, language, phone, 
	icq, address, address2, city, state, country, birthdate, age, sex, 
	website, heard, business, date_sub, date_unsub, ip, lettersformat, 
	additional1, additional2, additional3, additional4, additional5, 
	additional6, additional7, additional8, additional9, additional10, 
	additional11, additional12, confirm_url as u14_confirm_url
	from $ver\_sub_$sub where id=$id");
  my %subscr = get_record($dbh, "select * from $ver\_types where id=$sub");
  my $t = $letter;
  my $k;
  for $k (keys %user) {
    $letter = Template::text_replace($letter, $k, $user{$k});
  }
  my %date = get_record($dbh, "select curdate() as date");
  my %time = get_record($dbh, "select curtime() as time");
  my %datetime = get_record($dbh, "select now() as datetime");
  $letter = Template::text_replace($letter, 'date', $date{date});
  $letter = Template::text_replace($letter, 'time', $time{time});
  $letter = Template::text_replace($letter, 'datetime', $datetime{datetime});

  $letter = Template::text_replace($letter, 'subscribtion_name', $subscr{name});
  my $confirm_url = "$vars_server_url/subscribe.cgi?action=confirm&u=$user{id}&s=$subscr{id}&confirm=$user{u14_confirm_url}";
  my $unsubscribe_url = "$vars_server_url/subscribe.cgi?action=unsubscribe&u=$user{id}&s=$subscr{id}&confirm=$user{confirm_url}";

  $letter = Template::text_replace($letter, 'site-name', $vars_site_name);
  $letter = Template::text_replace($letter, 'confirm-subscribe-url', $confirm_url);
  $letter = Template::text_replace($letter, 'unsubscribe_url', $unsubscribe_url);

  if ($letter =~ /#rand=(\d+)#/gm) {
    my $r = r($1);
    $letter = Template::text_replace($letter, "rand$1", $r);    
  }
  $_ = $letter;
  my @a = m/\#(file\=.*?)\#/igm;
  my $i;
  for $i (@a) {
    if ($i =~ /^file\=(.*?)$/i) {
      my $path = $1;
      open FILE, "<$path";
      my @cnt = <FILE>;
      close FILE;
      my $content = join '', @cnt;
      $path =~ s/\?/\\?/igm;
      $path =~ s/\//\\\//igm;
      $letter = Template::text_replace($letter, "file=$path", $content);
    }
  }
  $_ = $letter;
  my @a = m/\#(url\=.*?)\#/igm;
  my $i;
  for $i (@a) {
    if ($i =~ /^url\=(.*?)$/i) {
      my $url = $1;
      my $content = getDoc($url);
      $url =~ s/\?/\\?/igm;
      $url =~ s/\//\\\//igm;
      $letter = Template::text_replace($letter, "url=$url", $content);
    }
  }

  my $k;
  for $k (keys %user) {
    $letter = Template::text_replace($letter, $k, $user{$k});
  }
  %date = get_record($dbh, "select curdate() as date");
  %time = get_record($dbh, "select curtime() as time");
  %datetime = get_record($dbh, "select now() as datetime");
  $letter = Template::text_replace($letter, 'date', $date{date});
  $letter = Template::text_replace($letter, 'time', $time{time});
  $letter = Template::text_replace($letter, 'datetime', $datetime{datetime});

  $letter = Template::text_replace($letter, 'subscribtion_name', $subscr{name});
  $confirm_url = "$vars_server_url/subscribe.cgi?action=confirm&u=$user{id}&s=$subscr{id}&confirm=$user{u14_confirm_url}";
  $unsubscribe_url = "$vars_server_url/subscribe.cgi?action=unsubscribe&u=$user{id}&s=$subscr{id}&confirm=$user{confirm_url}";

  $letter = Template::text_replace($letter, 'site-name', $vars_site_name);
  $letter = Template::text_replace($letter, 'confirm-subscribe-url', $confirm_url);
  $letter = Template::text_replace($letter, 'unsubscribe_url', $unsubscribe_url);

  if ($letter =~ /#rand=(\d+)#/gm) {
    my $r = r($1);
    $letter = Template::text_replace($letter, "rand$1", $r);    
  }

  return $letter;
}



sub Check {

  my ($email, $id, $sub) = @_;
  my %info = get_record($dbh, "select * from $ver\_sub_$sub where id=$id");
  $email = $info{email};
  my $qemail = $dbh->quote($email);
  
  my $res = check_syntax($email);
  if ($res == 1) {
    my $err;
    ($res, $err) = check_mx($email);
  }
  
  if ($res == 1) {
    $q = "update $ver\_sub_$sub set bad=0, checked=1 where id=$id";
    $q1 = "update $ver\_types set checked=checked+1 where id=$sub or id=1";
  } else {
    $q = "update $ver\_sub_$sub set bad=1, checked=0 where id=$id";
    $q1 = "update $ver\_types set bad=bad+1 where id=$sub or id=1";
  }
#open FILE, ">>Error_log";
#print FILE "\n$q\n$q1\n";
#close FILE;
  $dbh->do($q) or print $dbh->errstr;
  $dbh->do($q1) or print $dbh->errstr;
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr, $q;
  $sth = $dbh->prepare($q1);
  $sth->execute() or print $sth->errstr, $q;
  
  $q = "select count(*) from $ver\_sub_$sub where email = $qemail";
  $sth = $dbh->prepare($q);
  $sth->execute();
  $res = $sth->fetchrow_arrayref;
  if ($res->[0] > 1) {
    $q = "update $ver\_types set dupes=dupes+1 where id=$sub or id=1";
    $sth = $dbh->prepare($q);
    $sth->execute();
  }
  
  
  $q = "select * from $ver\_types where id=$sub";
  $sth = $dbh->prepare($q);
  $sth->execute();
  if ($sth->rows == 0) {
    #no subscribtion
    exit;
  }
  my $dupesKill = 0;
  my $countKill = 0;
  my $checkedKill = 0;
  my $badKill = 0;
  my $row = $sth->fetchrow_hashref;
  if ($row->{save_dupes} eq 'save') {
  
  } elsif ($row->{save_dupes} eq 'kill') {
    $q = "select * from $ver\_sub_$sub where email=$qemail and unsub = 0 order by id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $flag = 0;
    while ($row = $sth->fetchrow_hashref) {
      $flag++;
      next if ($flag == 1);
      $dupesKill++;
      $q = "delete from $ver\_sub_$sub where id=$row->{id}";
      my $sth1=$dbh->prepare($q);
      $sth1->execute() or print $sth1->errstr;
      if ($row->{bad} eq '1') {
        $badKill++;
      }
      if ($row->{checked} eq '1') {
        $checkedKill++;
      }
      $countKill++;
    }
  } else {
    $q = "select * from $ver\_sub_$sub where email=$qemail order by id desc";
    my $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $flag = 0;
    while ($row = $sth->fetchrow_hashref) {
      $flag++;
      next if ($flag == 1);
      $dupesKill++;
      $q = "delete from $ver\_sub_$sub where id=$row->{id}";
      my $sth1=$dbh->prepare($q);
      $sth1->execute() or print $sth1->errstr;
      if ($row->{bad} eq '1') {
        $badKill++;
      }
      if ($row->{checked} eq '1') {
        $checkedKill++;
      }
  
      $countKill++;
    }
  }
  if ($dupesKill+$countKill+$checkedKill+$badKill > 0) {
    $q = "update $ver\_types set dupes=dupes-$dupesKill, col=col-$countKill,
  	checked=checked-$checkedKill, bad=bad-$badKill where id=$sub or id=1";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
  }
}  

sub check_mx {
  my($email)=@_;

  my $ok=1;
  my $error="";

  eval <<'AAA';
  use Net::DNS;

  $ok = 0;

  my($domain)=$email=~/.*\@(.*)$/;

  my $dns=$vars_dns;

  my $mxserver="";

  my $res=new Net::DNS::Resolver;
  if ($dns ne '') {
    $res->nameservers($dns);
  } else {
    $res->nameservers();
  }

  my @mx=mx($res,$domain);
  if(@mx) {
    my $rr=shift(@mx);
    $mxserver=$rr->exchange;
    $ok=1;
  } else {
    $error="Can't resolve MX server name";
  }
AAA

  return ($ok,$error);

}

sub check_syntax {
  my($email)=@_;
  if($email=~/^([\w,\d,\-,\_\.]+)\@[\w,\d,\-,\_\.]+\.[a-zA-Z]{2,4}$/){return 1;}else{return 0;}
}

sub inc_user {
  my ($dbh, $sub, $userid) = @_;
  my $h = (localtime(time))[2];
  $q = "select id from $ver\_stat where sid=$sub and h=$h and d=curdate()";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    $q = "update $ver\_stat set col=col+1 where sid=$sub and h=$h and d=curdate()";
  } else {
    $q = "insert into $ver\_stat set sid=$sub, col=1, h=$h, d=curdate()";
  }
  $dbh->do($q) or print $dbh->errstr;

  $q = "select id from $ver\_stat where sid=1 and h=$h and d=curdate()";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    $q = "update $ver\_stat set col=col+1 where sid=1 and h=$h and d=curdate()";
  } else {
    $q = "insert into $ver\_stat set sid=1, col=1, h=$h, d=curdate()";
  }
  $dbh->do($q) or print $dbh->errstr;

  $q = "update $ver\_types set col=col+1 where id=$sub or id=1";
  $dbh->do($q) or print $dbh->errstr;

}

sub user_to_stat_and_send {
  my ($dbh, $sub, $userid) = @_;

  $q = "select * from $ver\_letters where done=1 and shedule=0 and delay_min=0 and sid=$sub";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $letter = make_letter($row->{id});

    $mail = new Template('tmpl/index.html');
    $mail->{code} = $letter->{code};
    $mail->{code} = replace_in_letter($dbh, $mail->{code}, $sub, $userid);
    $mail->clear_area('clear');
    open MAIL, "| $vars_path_to_sendmail";
    print MAIL $mail->{code};
    close MAIL;

  }

}

sub getDoc {
  my ($in) = @_;
  $in =~ s/http:\/\///g;
  my ($server, $page) = split /\//, $in, 2;
  my ($auth, $soc, $get, $sentBytes, @doc, $doc, $getBytes);
  my ($head, $body);
  $soc = IO::Socket::INET->new( PeerAddr => "$server", 
                                PeerPort => 80,
                                Proto => 'tcp',
                                Type => SOCK_STREAM) or return '';
  return if (!$soc);
  $get = "GET /$page HTTP/1.0\nAccept: */*\nAccept-Language: en-us\nUser-Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)\n".$auth."Host: $server\n\n";
  print $soc $get;

  @doc = <$soc>;
  close $soc;
  $doc = join '', @doc;
  ($head, $body) = split "\r*\n\r*\n", $doc, 2;
  return $body;
}


sub postDoc {
  my ($in, $param) = @_;
  $in =~ s/^http:\/\///g;
  my ($host, $doc) = split /\//, $in, 2;
  my ($soc, @doc, @refs, $i, @refsToGroup, $r, $curRef, $get, @b, @mails);

  $soc = IO::Socket::INET->new( PeerAddr => $host,
                                PeerPort => 80,
                                Proto => 'tcp',
                                Type => SOCK_STREAM) or return "$! cannot connect to $host";

  return if (!$soc);
  $post_data = $param;
  $l = length($post_data);

  $post = "POST /$doc HTTP/1.0
Host: $host
Content-Type: application/x-www-form-urlencoded
Content-Length: $l

$post_data\n\n";

  print $soc $post;


  @doc = <$soc>;
  close $soc;
  $doc = join '', @doc;
  my ($head, $body) = split "\r*\n\r*\n", $doc, 2;

  return $body;
}


1;

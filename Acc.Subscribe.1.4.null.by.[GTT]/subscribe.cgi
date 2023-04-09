#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use lib './lib';

$| = 1;

require 'site.pl';
require 'logon.pl';

use CGI::Carp qw(fatalsToBrowser);

use Template;
use MIME::Base64;
use svars;
use iplib;
use CGI;

my %keys = parse_form_simply();
my %cookie = parse_cookie();

$dbh = login();

$ver = 'acc14';

#print "Content-type: text/html\n\n";

if ($keys{track} ne '') {
  &TrackBulk();
}

if ($ARGV[0] eq 'delete') {
  &DeleteEmail();
}

if ($ARGV[0] eq 'deletedupes') {
  if ($pid = fork) {
    exit;
  } else {
    &DeleteDupes();
  }
  exit;
}

if ($keys{action} eq 'unsubscribe') {
  &Unsubscribe();
}

if (($ARGV[0] eq 'move')or ($ARGV[0] eq 'copy')) {
  if ($pid = fork) {
    exit;
  } else {
    &copySubscribers();
  }
  exit;
}

if ($keys{action} eq 'confirm') {
  &ConfirmUser();
  exit;
}



if ($ENV{REQUEST_METHOD} ne '') {
#print "Content-type: text/html\n\n";
  my $tid = sprintf("%d", $keys{sub});
  $tid = sprintf("%d", $keys{tid}) if ($tid == 0); # v1.3 supports.

  save();

  $action = $keys{mm_action};
  $method = $keys{mm_method};
  $method = 'get' if ($method eq '');

  my %subscr;
  if ($action eq '') {
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if ($subscr{parent} ne '0') {
      %subscr = get_record($dbh, "select * from $ver\_types where id=$subscr{parent}");
    }

    if ($subscr{subscribe_text_url} eq '0') {
      $action = $subscr{subscribe_url};
    } else {
      print "Content-type: text/html\n\n$subscr{subscribe_html}";
      exit;
    }
  }

  if ($method eq 'url') {
    print "Location: $action\n\n";
    exit;
  } else {
    print "Content-type: text/html\n\n";
    print "<html><body><form action='$action' method=$method name=mm_form>";
    for $i (keys %keys) {
      next if ($i =~ /^mm_/);
      $name = $dbh->quote($i);
      $value = $dbh->quote($keys{$i});
      print "<input type=hidden name=$name value=$value>\n";
    }
    print "</form>";
    print "<script language=javascript>document.mm_form.submit();</script>";
    print "</body></html>";
  }
  exit;
} else {
  %keys = parse_as_get($ARGV[0]);
  save_script();

}


sub save {
  $s = $keys{mm_id};
  @sub = CGI::param("$keys{mm_id}");
  for $sub (@sub) {
    $group = 0;
    %subscr = get_record($dbh, "select * from $ver\_types where id=$sub");
    if ($subscr{parent} ne '0') {
      $group = $sub;
      %subscr = get_record($dbh, "select * from $ver\_types where id=$subscr{parent}");
    }
    my %user;
    $email = $dbh->quote($keys{$keys{mm_email}});
    $lastname = $dbh->quote($keys{$keys{mm_last_name}});
    $firstname = $dbh->quote($keys{$keys{mm_first_name}});
    $lastname = $dbh->quote($keys{$keys{mm_lastname}}) if ($lastname eq ''); #v1.3 support
    $firstname = $dbh->quote($keys{$keys{mm_firstname}}) if ($firstname eq ''); #v1.3 support
    $full_name = $dbh->quote($keys{$keys{mm_full_name}});
    $company = $dbh->quote($keys{$keys{mm_company}});
    $language = $dbh->quote($keys{$keys{mm_language}});
    $phone = $dbh->quote($keys{$keys{mm_phone}});
    $icq = $dbh->quote($keys{$keys{mm_icq}});
    $address = $dbh->quote($keys{$keys{mm_address}});
    $address2 = $dbh->quote($keys{$keys{mm_address2}});
    $city = $dbh->quote($keys{$keys{mm_city}});
    $state = $dbh->quote($keys{$keys{mm_state}});
    $country = $dbh->quote($keys{$keys{mm_country}});
    $birth = $dbh->quote($keys{$keys{mm_birthdate}});
    $age = $dbh->quote($keys{$keys{mm_age}});
    $sex = $dbh->quote($keys{$keys{mm_sex}});
    $website = $dbh->quote($keys{$keys{mm_website}});
    $heart = $dbh->quote($keys{$keys{mm_heart}});
    $business = $dbh->quote($keys{$keys{mm_business}});
    $lettersformat = $dbh->quote($keys{$keys{mm_lettersformat}});
    $additional1 = $dbh->quote($keys{$keys{mm_additional1}});
    $additional2 = $dbh->quote($keys{$keys{mm_additional2}});
    $additional3 = $dbh->quote($keys{$keys{mm_additional3}});
    $additional4 = $dbh->quote($keys{$keys{mm_additional4}});
    $additional5 = $dbh->quote($keys{$keys{mm_additional5}});
    $additional6 = $dbh->quote($keys{$keys{mm_additional6}});
    $additional7 = $dbh->quote($keys{$keys{mm_additional7}});
    $additional8 = $dbh->quote($keys{$keys{mm_additional8}});
    $additional9 = $dbh->quote($keys{$keys{mm_additional9}});
    $additional10 = $dbh->quote($keys{$keys{mm_additional10}});
    $additional11 = $dbh->quote($keys{$keys{mm_additional11}});
    $additional12 = $dbh->quote($keys{$keys{mm_additional12}});
    $sub = sprintf("%d", $sub);
    $ip = $dbh->quote($ENV{REMOTE_ADDR});

    my $rrr = new CGI;
    my $form_fields = $dbh->quote($rrr->query_string);
    if ($subscr{processing_emails} ne '') {
      @param = $rrr->param;
      open MAIL, "| $vars_path_to_sendmail" or print $!;
      print MAIL "From: $subscr{admin_email}
To: $subscr{processing_emails}
Subject: Form posted\n\n";
      for $fie (sort @param) {
        print MAIL "$fie = ".$rrr->param("$fie")."\n";
      }
      close MAIL;

    }

    #confirm
    $confirm = 1;
    if ($subscr{use_confirm_url} eq '1') {
      $confirm = 0;
    }
    #approve
    $approved = 1;
    if ($subscr{use_approve} eq '1') {
      $approved = 0;
    }

    $confirm_url = r(40);
    $qconfirm_url = $dbh->quote($confirm_url);
    $q = "insert into $ver\_sub_$sub set bad=0, unsub=0, email=$email,
	grp = $group,
	confirm = $confirm, approved = $approved, active = 1,
	first_name=$firstname, last_name=$lastname, full_name=$full_name, 
	company = $company, language=$language, phone=$phone, icq=$icq,
	address = $address, address2=$address2, city=$city, state=$state,
	country=$country, birthdate=$birth, age=$age, sex=$sex, website=$website,
	heard=$heart, business=$business, 
	lettersformat = $lettersformat,
	additional1=$additional1, additional2=$additional2, additional3=$additional3, 
	additional4=$additional4, additional5=$additional5, additional6=$additional6, 
	additional7=$additional7, additional8=$additional8, additional9=$additional9, 
	additional10=$additional10, additional11=$additional11, additional12=$additional12, 
	confirm_url = $qconfirm_url,
	date_sub=now(), date_unsub=NULL, ip=$ip, form_fields=$form_fields";
#print "Content-type: text/html\n\n$q";
    $sth = $dbh->prepare($q);
    $flag = 0;
    $sth->execute() or $flag = 1;
    if ($flag == 1) {
      open FILE, ">>Error_log";
      print FILE "$q = ".$sth->errstr."\n\n";
      close FILE;
      print "Content-type: text/html\n\n";
      print "Error occured";
      exit;
    }

    $userid = $id = $sth->{insertid} || $sth->{mysql_insertid};
#    `perl checkemail.pl $email $sub $id 2>&1 &`;
    if ($confirm == 0) {
      open MAIL, "| $vars_path_to_sendmail";
      my $letter = $subscr{confirm_subscribe_message};
      $letter =~ s/\r//igm;
      my $lbody = "From: $subscr{confirm_subscribe_email}\nTo: $keys{$keys{mm_email}}\nSubject: $subscr{confirm_subscribe_subject}\n\n$letter";
      $lbody = replace_in_letter($dbh, $lbody, $sub, $id);
      print MAIL $lbody;
      close MAIL;
    }
    inc_user($dbh, $sub, $userid);
    if (($confirm == 1)and($approved == 1)) {
      user_to_stat_and_send($dbh, $sub, $userid);
    }

  }
}



sub save_script {
  @sub = split /\t/, $keys{mm_id};
  for $sub (@sub) {
    $email = $dbh->quote($keys{mm_email});
    $lastname = $dbh->quote($keys{mm_lastname});
    $firstname = $dbh->quote($keys{mm_firstname});
    $phone = $dbh->quote($keys{mm_phone});
    $icq = $dbh->quote($keys{mm_icq});
    $address = $dbh->quote($keys{mm_address});
    $address2 = $dbh->quote($keys{mm_address2});
    $city = $dbh->quote($keys{mm_city});
    $state = $dbh->quote($keys{mm_state});
    $country = $dbh->quote($keys{mm_country});
    $birth = $dbh->quote($keys{mm_birthdate});
    $age = $dbh->quote($keys{mm_age});
    $sex = $dbh->quote($keys{mm_sex});
    $website = $dbh->quote($keys{mm_website});
    $heart = $dbh->quote($keys{mm_heart});
    $business = $dbh->quote($keys{mm_business});
    $sub = sprintf("%d", $sub);
    $ip = $dbh->quote($ENV{REMOVE_ADDR});


    $q = "insert into $ver\_sub_$sub set bad='undef', unsub='no', email=$email,
	first_name=$firstname, last_name=$lastname, phone=$phone, icq=$icq,
	address = $address, address2=$address2, city=$city, state=$state,
	country=$country, birthdate=$birth, age=$age, sex=$sex, website=$website,
	heard=$heart, business=$business, date_sub=now(), date_unsub=NULL, ip=$ip";
    $sth = $dbh->prepare($q);
    $flag = 0;
    $sth->execute() or $flag = 1;
    if ($flag == 1) {
      print "Error occured";
      exit;
    }
    $userid = $id = $sth->{insertid} || $sth->{mysql_insertid};
#    `perl checkemail.pl $email $sub $id & 2>&1`;

    my $h = (localtime(time))[2];
    $q = "select id from $ver\_stat where sid=$sub and h=$h and d=curdate()";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      $q = "update $ver\_stat set col=col+1 where sid=$sub and h=$h and d=curdate()";
    } else {
      $q = "insert into $ver\_stat set sid=$sub, h=$h, d=curdate(), col=1";
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;

    $q = "select id from $ver\_stat where sid=1 and h=$h and d=curdate()";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      $q = "update $ver\_stat set col=col+1 where sid=1 and h=$h and d=curdate()";
    } else {
      $q = "insert into $ver\_stat set sid=1, h=$h, d=curdate(), col=1";
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "update $ver\_types set col=col+1 where id=$sub or id=1";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;


    $q = "select * from $ver\_letters where done=1 and delay_min=0 and sid=$sub";

    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      $letter = make_letter($row->{id});
      $letter->replace('send-id', 0);

      $q = "select * from $ver\_sub_$sub where id=$userid";
      $sth2 = $dbh->prepare($q);
      $sth2->execute() or print $sth2->errstr, $q;
      while ($row2 = $sth2->fetchrow_hashref) {
        my %in = (
        	'email' => $row2->{email},
        	'first-name' => $row2->{first_name},
        	'last-name' => $row2->{last_name},
        	'phone' => $row2->{phone},
        	'icq' => $row2->{icq},
        	'address' => $row2->{address},
        	'address2' => $row2->{address2},
        	'city' => $row2->{city},
        	'state' => $row2->{state},
        	'country' => $row2->{country},
        	'birthdate' => $row2->{birthdate},
        	'age' => $row2->{age},
        	'sex' => $row2->{sex},
        	'website' => $row2->{website},
        	'heard' => $row2->{heard},
        	'business' => $row2->{business},
        	'date_now' => $row2->{date}
        );
        $mail = new Template('tmpl/index.html');
        $mail->{code} = $letter->{code};
        $mail->replace_hash(%in);
        $mail->clear_area('clear');
        open MAIL, "| $vars_path_to_sendmail";
        print MAIL $mail->{code};
        close MAIL;


        $q2 = "select * from $ver\_types where id=$sub";
        $sth2 = $dbh->prepare($q2);
        $sth2->execute() or print $sth2->errstr;
        while ($row2 = $sth2->fetchrow_hashref) {
          if ($row2->{admin_email} ne '') {
            my $rrr = new CGI("$ARGV[0]");
            @param = $rrr->param;
            open MAIL, "| $vars_path_to_sendmail" or print $!;
            print MAIL "From: $row2->{admin_email}
To: $row2->{admin_email}
Subject: Form posted\n\n";
            for $fie (sort @param) {
              print MAIL "$fie = ".$rrr->param("$fie")."\n";
            }
            close MAIL;

          }
        }

      }
    }

  }
}

sub DeleteEmail {
  $lemail = $ARGV[1];
  $tid = $ARGV[2];
  for $email (split /;/, $lemail) {
    $qemail = $dbh->quote($email);
    $q = "select id from $ver\_sub_$tid where email = $qemail";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      $q = "update $ver\_types set dupes=dupes-1 where id=$tid or id=1";
      $sth = $dbh->prepare($q);
      $sth->execute();
    }
  }
}

sub Unsubscribe {
  my @sub = CGI::param("$keys{mm_id}");
  $sub = sprintf("%d", $keys{s});
  $uid = sprintf("%d", $keys{u});
  $email = $keys{$keys{mm_email}};
  $qemail = $dbh->quote($email);
  if ($#sub > -1) {
    for $sub (@sub) {
      $q = "select * from $ver\_types where id=$sub";
      $sth = $dbh->prepare($q);
      $flag = 0;
      $sth->execute() or $flag = 1;
      if ($row = $sth->fetchrow_hashref) {
        my %usr;
        $| = 1;
        if ($row->{confirm_unsubscribe_message} ne '') {
          %usr = get_record($dbh, "select count(*) as col from $ver\_sub_$sub where email=$qemail");
          next if ($usr{col} == 0);

          %usr = get_record($dbh, "select * from $ver\_sub_$sub where email=$qemail");
          $eml = "From: $row->{confirm_unsubscribe_email}\nTo: $usr{email}\nSubject: $row->{confirm_unsubscribe_subject}\n\n$row->{confirm_unsubscribe_message}";
          $eml = replace_in_letter($dbh, $eml, $sub, $usr{id});
          open MAIL, "| $vars_path_to_sendmail";
          print MAIL $eml;
          close MAIL;
        } else {
          %usr = get_record($dbh, "select count(*) as col from $ver\_sub_$sub where email=$qemail");
          next if ($usr{col} == 0);

          %usr = get_record($dbh, "select * from $ver\_sub_$sub where email=$qemail");
        }
        $uid = $usr{id};

        $q = "update $ver\_sub_$sub set date_unsub=now(), unsub=1 where id = $uid and unsub=0 ";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        $num = $sth->rows;
        if ($num > 0) {
          $q = "update $ver\_types set unsub=unsub+".$sth->rows." where id=$sub or id=1";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
  
          my $h = (localtime(time))[2];
          $q = "select id from $ver\_stat where sid=$sub and h=$h and d=curdate()";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
          if ($sth->rows > 0) {
            $q = "update $ver\_stat set unsub=unsub+$num where sid=$sub and h=$h and d=curdate()";
          } else {
            $q = "insert into $ver\_stat set sid=$sub, h=$h, d=curdate(), unsub=$num";
          }
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
  
          $q = "select id from $ver\_stat where sid=1 and h=$h and d=curdate()";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
          if ($sth->rows > 0) {
            $q = "update $ver\_stat set unsub=unsub+$num where sid=1 and h=$h and d=curdate()";
          } else {
            $q = "insert into $ver\_stat set sid=1, h=$h, d=curdate(), unsub=$num";
          }
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
        }
      }
    }
    print "Location: $keys{mm_action}\n\n";
    exit;
  } else {
    if ($sub > 0) {
      $q = "select * from $ver\_types where id=$sub";
      $sth = $dbh->prepare($q);
      $flag = 0;
      $sth->execute() or $flag = 1;
      if ($row = $sth->fetchrow_hashref) {
        $| = 1;
        if ($row->{unsubscribe_text_url} eq '1') {
          print "Content-type: text/html\n\n$row->{unsubscribe_html}\n\n";
        } else {
          print "Location: $row->{unsubscribe_url}\n\n";
        }
        if ($row->{confirm_unsubscribe_message} ne '') {
          %usr = get_record($dbh, "select * from $ver\_sub_$sub where id=$uid");
          $eml = "From: $row->{confirm_unsubscribe_email}\nTo: $usr{email}\nSubject: $row->{confirm_unsubscribe_subject}\n\n$row->{confirm_unsubscribe_message}";
          $eml = replace_in_letter($dbh, $eml, $sub, $uid);
          open MAIL, ">1";
          open MAIL, "| $vars_path_to_sendmail";
          print MAIL $eml;
          close MAIL;
        }
    
        $uid = $dbh->quote($keys{u});
        $q = "update $ver\_sub_$sub set date_unsub=now(), unsub=1 where id = $uid and unsub=0 ";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        $num = $sth->rows;
        if ($num > 0) {
          $q = "update $ver\_types set unsub=unsub+".$sth->rows." where id=$sub or id=1";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
  
          my $h = (localtime(time))[2];
          $q = "select id from $ver\_stat where sid=$sub and h=$h and d=curdate()";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
          if ($sth->rows > 0) {
            $q = "update $ver\_stat set unsub=unsub+$num where sid=$sub and h=$h and d=curdate()";
          } else {
            $q = "insert into $ver\_stat set sid=$sub, h=$h, d=curdate(), unsub=$num";
          }
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
  
          $q = "select id from $ver\_stat where sid=1 and h=$h and d=curdate()";
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
          if ($sth->rows > 0) {
            $q = "update $ver\_stat set unsub=unsub+$num where sid=1 and h=$h and d=curdate()";
          } else {
            $q = "insert into $ver\_stat set sid=1, h=$h, d=curdate(), unsub=$num";
          }
          $sth = $dbh->prepare($q);
          $sth->execute() or print $sth->errstr;
        }
        exit;
      }
    }
    print "Content-type: text/html\n\n";
    print "Bad parameters";   
  }
}


sub copySubscribers {
  my $action = $ARGV[0];
  my $cid = $ARGV[1];
  my $ids = $ARGV[2];
$| = 1;
  %cid = get_record($dbh, "select * from $ver\_copy where id=$cid");
  $group = $cid{grp};
  $area = $cid{status};
  my %area = (
  	'active' => 'approved = 1 and expired = 0 and unsub = 0 and confirm = 1',
  	'notapproved' => 'approved = 0 and confirm = 1',
  	'notconfirmed' => 'confirm = 0',
  	'unsubscribed' => 'unsub = 1',
  	'expired' => 'expired = 1'
  );
  
  my $qq = '';
  if (($ids eq 'all')or($ids eq '"all"')) {
    $qq = "select * from $ver\_sub_$cid{source} where grp=$group and $area{$area} order by id ";
  } else {
    $qq = "select * from $ver\_sub_$cid{source} where id in ($ids) and grp=$group and $area{$area} order by id ";
  }
  my %subscr = get_record($dbh, "select * from $ver\_types where id=$cid{dest}");

  my $start = 0;
  my $flag = 1;
  while ($flag == 1) {
    $q = $qq." limit $start, 200";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows == 0) {
      $flag = 0;
      next;
    }
    $start += 200 if ($action ne 'move');
    while ($row = $sth->fetchrow_hashref) {
      %in = %$row;
      my $qemail = $dbh->quote($in{email});
      %info = get_record($dbh, "select count(id) as count from $ver\_sub_$cid{dest} where email=$qemail");
  
      if ($subscr{save_dupes} eq 'kill') {
        if ($info{count} == 1) {
          next;
        }
        if ($info{count} > 1) {
          $q = "select id from $ver\_sub_$cid{dest} where email=$qemail order by id";
          $sth1 = $dbh->prepare($q);
          $sth1->execute() or print $sth1->errstr;
          my $flag = 0;
          while ($row1 = $sth1->fetchrow_arrayref) {
            $flag++;
            next if ($flag == 1);
            my $einfo = get_record($dbh, "select * from $ver\_sub_$cid{dest} where id=$row1->[0]");
            $q = "delete from $ver\_sub_$cid{dest} where id=$row1->[0]";
            $dbh->do($q);
            my $checked = $einfo{checked};
            my $bad = $einfo{bad};
            $q = "update $ver\_types set count=count-1, bad=bad-$bad, checked=checked-$checked where id=1 or id=$cid{dest}";
            $dbh->do($q);          
          }
        }
      }
      if ($subscr{save_dupes} eq 'replace') {
        if ($info{count} > 0) {
          $q = "select id from $ver\_sub_$cid{dest} where email=$qemail order by id";
          $sth1 = $dbh->prepare($q);
          $sth1->execute() or print $sth1->errstr;
          while ($row1 = $sth1->fetchrow_arrayref) {
            my $einfo = get_record($dbh, "select * from $ver\_sub_$cid{$dest} where id=$row1->[0]");
            $q = "delete from $ver\_sub_$cid{dest} where id=$row1->[0]";
            $dbh->do($q);
            my $checked = $einfo{checked};
            my $bad = $einfo{bad};
            $q = "update $ver\_types set count=count-1, bad=bad-$bad, checked=checked-$checked where id=1 or id=$cid{dest}";
            $dbh->do($q);          
          }
        }
        $info{count} = 0;
      }
  
      $q = "insert into $ver\_sub_$cid{dest} set ";
      $j = 0;
      $in{grp} = 0;
      my $in_id = $in{id};
      undef($in{id});
      for $i (keys %in) {
        $q .= ", " if ($j != 0);
        $k = $dbh->quote($in{$i});
        $q .= " $i = $k";
        $j++;
      }
      $dbh->do($q) or print $dbh->errstr, $q;
      my ($bad, $checked, $dup);
      $bad = $checked = $dup = 0;
      $bad = 1 if ($in{bad} eq '1');
      $checked = 1 if ($in{checked} eq '1');
      $dup = 1 if ($info{count} > 0);
      $q = "update $ver\_types set col=col+1, bad=bad+$bad, checked=checked+$checked, dupes=dupes+$dup where id=1 or id=$cid{dest}";
      $dbh->do($q) or print $dbh->errstr, $q;
  
      if ($action eq 'move') {
        $q = "delete from $ver\_sub_$cid{source} where id=$in_id";
        $dbh->do($q) or print $dbh->errstr;
  
        %info = get_record($dbh, "select count(id) as count from $ver\_sub_$cid{source} where email=$qemail");
        $dup = 0;
        $dup = 1 if ($info{count} > 0);
  
        $q = "update $ver\_types set col=col-1, bad=bad-$bad, checked=checked-$checked, dupes=dupes-$dup where id=1 or id=$cid{source}";
        $dbh->do($q) or print $dbh->errstr;
      }
      $q = "update $ver\_copy set processed=processed+1 where id=$cid";
      $dbh->do($q) or print $dbh->errstr;
    }
  }
  $q = "update $ver\_copy set done=1 where id=$cid";
  $dbh->do($q) or print $dbh->errstr;
  exit;

}


sub DeleteDupes {
  my $id = sprintf("%d", $ARGV[1]);
  my %in = get_record($dbh, "select * from $ver\_deldup where id=$id");
  my $tid = $in{tid};

open FILE, ">bbb";
select FILE;
$| = 1;
  $q = "select count(id) as count, email from $ver\_sub_$tid group by email having count > 1 ";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $bad = 0;
  my $all = 0;
  my $checked = 0;
  while ($row = $sth->fetchrow_hashref) {
    my $email = $dbh->quote($row->{email});
    $q = "select * from $ver\_sub_$tid where email=$email order by id";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth1->errstr;
    my $count = $sth1->rows;
    while ($row1 = $sth1->fetchrow_hashref) {
      next if ($count == 1);
      $count--;
      $q = "delete from $ver\_sub_$tid where id=$row1->{id}";
      $dbh->do($q) or print $dbh->errstr;
      $bad = $checked = $all = 0;
      $bad++ if ($row1->{checked} != 1);
      $checked++ if ($row1->{checked} == 1);
      $all++;
      $q = "update $ver\_deldup set processed=processed+1 where id=$id";
      $dbh->do($q) or print $dbh->errstr;
      $q = "update $ver\_types set col=col-$all, dupes=dupes-$all, bad=bad-$bad, checked=checked-$checked where id=$tid or id=1";
      $dbh->do($q) or print $dbh->errstr;
    }
  }
  $q = "update $ver\_deldup set done = 1 where id=$id";
  $dbh->do($q) or print $dbh->errstr;
close FILE;
}


sub ConfirmUser {
  my $u = sprintf("%d", $keys{u});
  my $s = sprintf("%d", $keys{s});
  my $confirm = $keys{confirm};
  %user = get_record($dbh, "select * from $ver\_sub_$s where id=$u");
  %subscr = get_record($dbh, "select * from $ver\_types where id=$s");
  if ($user{confirm_url} eq $confirm) {
    if ($subscr{subscribe_confirm_text_url} eq '1') {
      $text = $subscr{subscribe_confirm_html};
      $text = replace_in_letter($dbh, $text, $s, $u);
      print "Content-type: text/html\n\n$text";
    } else {
      print "Location: $subscr{subscribe_confirm_url}\n\n";
    }
    $q = "update $ver\_sub_$s set confirm = 1, date_sub = now() where id=$u";
    $dbh->do($q) or print $dbh->errstr;
    if ($user{approved} eq '1') {
      user_to_stat_and_send($dbh, $s, $u);
    }
    exit;
  } else {
    print "Content-type: text/html\n\n";
    print "<h1>Sorry, you have entered wrong confirm param</h1>";
    exit;
  }

}

sub TrackBulk {
  $c = new CGI;
  my $id = sprintf("%d", $keys{track});
  my $cookie2 = $c->cookie(-name=>"seen_$id",
	-value=>"$id",
        -expires=>'+20y'
  );
  print "Set-Cookie: $cookie2\nContent-type: text/html\n\n";
  my $seen = sprintf("%d", $cookie{"seen_$id"});
  if ($seen ne $cookie{"seen_$id"}) {
print "\$cookie{\"seen_$id\"}",$cookie{"seen_$id"},"<br>";
    $q = "update $ver\_bulk set seen=seen+1 where id=$id";
    $dbh->do($q) or print $sth->errstr;
  }
  $c = new CGI;
  my $cookie2 = $c->cookie(-name=>"seen_$id",
	-value=>"$id",
        -expires=>'+20y'
  );
  print "Set-Cookie: $cookie2\nContent-type: image/gif\n\n";
  
  exit;
}
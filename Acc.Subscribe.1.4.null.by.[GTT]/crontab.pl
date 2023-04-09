#!/usr/bin/perl

use strict;

use lib './lib';

use MIME::Base64;
use Net::POP3;
use Template;
use svars;

$| = 1;

require 'logon.pl';
require 'site.pl';
my $dbh = login();

my $ver = 'acc14';
my ($sth, $q);

my $pid;
unless ($pid = fork) {
  $q = "select * from $ver\_types where use_autoresponce = 1 and parent = 0";
  $sth = $dbh->prepare($q);
  $sth->execute() or die $sth->errstr;
  my $row;
  while ($row = $sth->fetchrow_hashref) {
    my $sub = $row->{id};
    my $host = $row->{autoresponce_host};
    my $user = $row->{autoresponce_login};
    my $password = $row->{autoresponce_password};
#print "$host, $user, $password";

    my $pop = Net::POP3->new($host) or print $!;
    my $last = $pop->login($user, $password) or print $!;
    my $i;
    for ($i = 1; $i<=$last; $i++) {
      my $letter = $pop->get($i);
      my $l = join '', grep {/^From:/gm} @{$letter};
      my $l1 = join '', grep {/^To:/gm} @{$letter};
      next if ($l1 !~ /$row->{autoresponce_email}/i);
      my ($name, $email);
      $name = $email = '';
      $l1 = $l;
      if ($l1 =~ /From: (.*?) <(.*?)>\s*/igm) {
        $name = $1; $email = $2;
      } elsif ($l1 =~ /From:\s*(.*?)\s*/igm) {
        $email = $1;
      }

      if (($l =~ /From:\s*(.*?)$/igm)and($email eq '')) {
        $email = $1;
        print $l;
      }

      $name =~ s/^["|']//;
      $name =~ s/["|']$//;
      $email =~ s/\s//g;

#      print "\nName: $name, E-mail: $email\n";

      my $group = 0;
      my %subscr = get_record($dbh, "select * from $ver\_types where id=$sub");
      my %user;
      my $qemail = $dbh->quote($email);
      my $full_name = $dbh->quote($name);
  
      #confirm
      my $confirm = 1;
      if ($subscr{use_confirm_url} eq '1') {
        $confirm = 0;
      }
      #approve
      my $approved = 1;
      if ($subscr{use_approve} eq '1') {
        $approved = 0;
      }
  
      my $confirm_url = r(40);
      my $qconfirm_url = $dbh->quote($confirm_url);
      $q = "insert into $ver\_sub_$sub set bad=0, unsub=0, email=$qemail,
  	grp = $group,
  	confirm = $confirm, approved = $approved, active = 1,
  	full_name=$full_name, 
  	confirm_url = $qconfirm_url,
  	date_sub=now(), date_unsub=NULL";
      my $sth1 = $dbh->prepare($q);
      my $flag = 0;
      $sth1->execute() or $flag = 1;
      if ($flag == 1) {
        open FILE, ">>Error_log";
        print FILE "$q = ".$sth->errstr."\n\n";
        close FILE;
        print "Error occured";
        exit;
      }
      my ($userid, $id);
      $userid = $id = $sth1->{insertid} || $sth1->{mysql_insertid};
#print "perl checkemail.pl $qemail $sub $id 2>&1 &";
#      `perl checkemail.pl $qemail $sub $id 2>&1 &`;
      if ($confirm == 0) {
        open MAIL, "| $vars_path_to_sendmail";
        my $letter = $subscr{confirm_subscribe_message};
        $letter =~ s/\r//igm;
        my $lbody = "From: $subscr{confirm_subscribe_email}\nTo: $email\nSubject: $subscr{confirm_subscribe_subject}\n\n$letter";
        $lbody = replace_in_letter($dbh, $lbody, $sub, $id);
        print MAIL $lbody;
        close MAIL;
      }
      inc_user($dbh, $sub, $userid);
      if (($confirm == 1)and($approved == 1)) {
        user_to_stat_and_send($dbh, $sub, $userid);
      }

      $pop->delete($i);
    
    }
    $pop->quit() or print $!;
  }
  exit;
}

my ($nowsec,$nowmin,$nowhour,$nowmday,$nowmon,$nowyear,$nowwday,$nowyday,$nowisdst) = localtime(time);
$nowwday = 7 if ($nowwday == 0);
sleep(10);
if ($nowmin == 0) {
  unless ($pid = fork) {
    
    $q = "select id from $ver\_bulk where start_date = curdate() and start_hour = $nowhour and done = 1";
    $sth = $dbh->prepare($q);
    $sth->execute() or die $sth->errstr;
    my $row;
    while ($row = $sth->fetchrow_hashref) {
      `/usr/bin/perl send.pl "bid=$row->{id}" &`;
    }
    exit;
  }
}

my %now = get_record($dbh, "select now() as now");
my $now = $now{now};

if (($nowmin == 0)or($nowmin == 20)or($nowmin == 40)) {

  unless ($pid = fork) {


    $q = "select id from $ver\_types where id!= 1";
    $sth = $dbh->prepare($q);
    $sth->execute() or die $sth->errstr;
    my $row;
    while ($row = $sth->fetchrow_hashref)  {
      $q = "select * from $ver\_letters where sid = $row->{id} and done = 1 and shedule <> 0";
      my $sth1 = $dbh->prepare($q);
      $sth1->execute() or die $sth1->errstr;
      my $row1;
      while ($row1 = $sth1->fetchrow_hashref) {
        my $add = '';
        if ($row1->{delay_type} eq 'hour') {
           $add = " date_add(date_sub, interval $row1->{delay_min} hour) >= '$now' and
    	date_add(date_sub, interval $row1->{delay_min} hour) < date_add('$now', interval 20 minute) "
        }
        if ($row1->{delay_type} eq 'day') {
           $add = " date_add(date_sub, interval $row1->{delay_min} day) >= '$now' and
    	date_add(date_sub, interval $row1->{delay_min} day) < date_add('$now', interval 20 minute) "
        }
        if ($row1->{delay_type} eq 'week') {
           $add = " date_add(date_sub, interval $row1->{delay_min}*7 day) >= '$now' and
    	date_add(date_sub, interval $row1->{delay_min}*7 day) < date_add('$now', interval 20 minute) "
        }
        if ($row1->{delay_type} eq 'month') {
           $add = " date_add(date_sub, interval $row1->{delay_min} month) >= '$now' and
    	date_add(date_sub, interval $row1->{delay_min} month) < date_add('$now', interval 20 minute) "
        }
                              #letter id
        my $letter = make_letter($row1->{id});
        $letter->replace('send-id', 0);
        $letter->clear_area('clear');
    #print $letter->{code};
    
    
        $q = "select id from $ver\_sub_$row->{id} where $add and isnull(date_unsub)";
    #print "\n\n$q\n\n";
        my $sth2 = $dbh->prepare($q);
        $sth2->execute() or die $sth2->errstr;
        my $row2;
        while ($row2 = $sth2->fetchrow_hashref) {
          my $mail = new Template('tmpl/index.html');
          $mail->{code} = $letter->{code};
          $mail->{code} = replace_in_letter($dbh, $mail->{code}, $row->{id}, $row2->{id});
          open MAIL, "| $vars_path_to_sendmail";
          print MAIL $mail->{code};
          close MAIL;
        }
      }
    }
    exit;
  }
}

if ($nowmin == 30) {
  unless ($pid = fork) {
    $q = "select * from $ver\_types where active_days > 0";
    $sth = $dbh->prepare($q);
    $sth->execute() or die $sth->errstr;
    my $row;
    while ($row = $sth->fetchrow_hashref) {
      $q = "update $ver\_sub_$row->{id} set expired = 1 where date_sub + interval $row->{active_days} > now() and once_expired = 0 and expired = 0 and approved = 1 and confirm = 1 and active = 1";
      $dbh->do($q) or die $dbh->errstr;

    }
    exit;
  }

}



sleep(10);
$q = "select id from $ver\_types where id!= 1";
$sth = $dbh->prepare($q);
$sth->execute() or die $sth->errstr;
my $row;
while ($row = $sth->fetchrow_hashref)  {
  $q = "select * from $ver\_letters where sid = $row->{id} and done = 1 and shedule!=0";
  my $sth1 = $dbh->prepare($q);
  $sth1->execute() or die $sth1->errstr;
  my $row1;
  while ($row1 = $sth1->fetchrow_hashref) {
#($nowsec,$nowmin,$nowhour,$nowmday,$nowmon,$nowyear,$nowwday,$nowyday,$nowisdst)
    my $flag_send = 0;
    if ($row->{shedule} == 1) {
      if (($row1->{dayly_min} == $nowmin)and($row1->{dayly_hour} == $nowhour)) {
        $flag_send = 1;
      }
    }
    if ($row->{shedule} == 2) {
      if (($row1->{weekly_day} == $nowwday)and($row1->{weekly_hour} == $nowhour)and($row1->{weekly_min} == $nowmin)) {
        $flag_send = 1;
      }
    }
    if ($row->{shedule} == 3) {
      if (($row1->{monthly_day} == $nowmday)and($row1->{monthly_hour} == $nowhour)and($row1->{monthly_min} == $nowmin)) {
        $flag_send = 1;
      }
    }
    next if ($flag_send == 0);
    my $add = '';
                          #letter id
    my $letter = make_letter($row1->{id});
    $letter->clear_area('clear');


    $q = "select id from $ver\_sub_$row->{id} where isnull(date_unsub) and confirm=1 and expired=0 and active=1 and approved=1";
    my $sth2 = $dbh->prepare($q);
    $sth2->execute() or die $sth2->errstr;
    my $row2;
    while ($row2 = $sth2->fetchrow_hashref) {
      my $mail = new Template('tmpl/index.html');
      $mail->{code} = $letter->{code};
      $mail->{code} = replace_in_letter($dbh, $mail->{code}, $row->{id}, $row2->{id});
      open MAIL, "| $vars_path_to_sendmail";
      print MAIL $mail->{code};
      close MAIL;
    }
  }
}


my %SETTINGS = get_record($dbh, "select * from $ver\_settings");

if ($SETTINGS{returnemail} ne '') {
  my $pop = Net::POP3->new($SETTINGS{returnhost}) or print $!;
  my $last = $pop->login($SETTINGS{returnlogin}, $SETTINGS{returnpassword}) or print $!;
  my $i;
  for ($i = 1; $i<=$last; $i++) {
    my $letter = $pop->get($i);

    my $l = join '', grep {/^From:/gm} @{$letter};
    my $l1 = join '', grep {/^To:/gm} @{$letter};
    my $l2 = join '', grep {/^X-Mailer: Acc Subscribe \(id=\d+.*?\)$/gm} @{$letter};
#print $l, $l1, $l2;

    next if ($l1 !~ /$row->{autoresponce_email}/i);
    my ($name, $email);
    $name = $email = '';
    $l1 = $l;
    if ($l1 =~ /From: (.*?) <(.*?)>\s*/igm) {

      $name = $1; $email = $2;
    } elsif ($l1 =~ /From:\s*(.*?)\s*/igm) {
      $email = $1;
    }
    if ($l2 =~ /X-Mailer: Acc Subscribe \(id=(\d+) email=(.*?)\)/igm) {
      my $bulkid = $1;
      my $returnemail = $2;
#print "Email: $returnemail\n\n";
#print "Bulk = $bulkid\n\n";
      if ($bulkid != 0) {
        $q = "update $ver\_bulk set undelivered = undelivered+1 where id=$bulkid";
        $dbh->do($q) or print $dbh->errstr;
        my $qemail = $dbh->quote($returnemail);
        $q = "insert into $ver\_undeliver set bid=$bulkid, email = $qemail";
        $dbh->do($q);
        $pop->delete($i);
      }
    }

  }
  $pop->quit() or print $!;

}
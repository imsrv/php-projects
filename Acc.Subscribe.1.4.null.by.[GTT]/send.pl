#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use lib './lib';

use MIME::Base64;
use Template;
use svars;


$ver = 'acc14';

close STDOUT;
if ($pid = fork) {
  exit;
} else {

  require 'logon.pl';
  require 'site.pl';
  
  $dbh = login();
  
  
  %keys = parse_as_get($ARGV[0]);
#open FILE, ">>QQQ1";
#print FILE "$ARGV[0]\n";
#close FILE;
  
  $bid = $keys{bid};
  my %SETTINGS = get_record($dbh, "select * from $ver\_settings");
  %info = get_record($dbh, "select * from $ver\_bulk where id=$bid");
  $letter = $info{lid};
  $email = $keys{email};
  
  $letter = make_letter($letter);
  $letter->clear_area('clear');

  $q = "update $ver\_bulk set startat=now() where id=$bid";
  $dbh->do($q) or print $dbh->errstr;

  
  if ($email eq '') {
    %info = get_record($dbh, "select * from $ver\_bulk where id=$bid");
    %bulkinfo = %info;
    $par = new CGI($info{params});
    $add = '';
    $flag_only_new = 0;
#    if ($row = $sth->fetchrow_hashref) {
      if ($par->param('period') eq 'new') {
        $flag_only_new = 1;
        $q = "select point_send from $ver\_types where id=$tid";
        $sth2 = $dbh->prepare($q);
        $sth2->execute() or print $sth2->errstr;
        if ($row2 = $sth2->fetchrow_hashref) {
          $add = "date_sub > '$row->{point_send}' and " if ($row->{point_send} ne '');
        }
        $sth2->finish();
      }
      if ($par->param('period') eq 'period - today') {
        $add = "to_days(now()) = to_days(date_sub) and ";
      }
      if ($par->param('period') eq 'period - yesterday') {
        $add = "to_days(now()) = to_days(date_sub)+1 and ";
      }
      if ($par->param('period') eq 'period - week') {
        $add = "to_days(now()) <= to_days(date_sub)+7 and ";
      }
      if ($par->param('period') eq 'period - month') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 1 month)) and ";
      }
      if ($par->param('period') eq 'period - quarter') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 3 month)) and ";
      }
      if ($par->param('period') eq 'period - year') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 1 year)) and ";
      }
      if ($par->param('period') =~ /range - (\d\d\d\d-\d\d-\d\d) - (\d\d\d\d-\d\d-\d\d)/) {
        $add = "to_days(now()) >= to_days('$1') and to_days(now() <= to_days('$2') and ";
      }
      if ($par->param('cat') eq 'active') {
        $add .= " active = 1 and confirm = 1 and approved = 1 and unsub = 0 and ";
      }
      if ($par->param('cat') eq 'unsubscribed') {
        $add .= "unsub = 1 and ";
      }
      if ($par->param('cat') eq 'expired') {
        $add .= "expired = 1 and ";
      }
      if ($par->param('cat') eq 'notapproved') {
        $add .= "approved = 0 and ";
      }
      if ($par->param('cat') eq 'notconfirmed') {
        $add .= "confirmed = 0 and ";
      }
#    }
    my $cur_tid = sprintf("%d", $keys{'cur_tid'});
    my $cur_pos = sprintf("%d", $keys{'cur_pos'});
#open FILE, ">>QQQ1";
#print FILE "\ncp = $cur_pos\n";
#close FILE;
    my $flag_cur_tid = 0;
    my $col_post = 0;
    for $tid ($par->param('subs')) {
      if ($flag_cur_tid == 0) {
        unless ($cur_tid == 0) {
          next if ($tid != $cur_tid);
        }
      }
      $flag_cur_tid = 1;
      
      my $group = 0;
  
      %info = get_record ($dbh, "select * from $ver\_types where id=$tid");
      if ($info{parent} ne '0') {
        %info = get_record ($dbh, "select * from $ver\_types where id=$info{parent}");
        $group = $tid;
        $tid = $info{id};
      } 
      my $flag_next = 1;
      my $from_limit = $cur_pos - 50;
#open FILE, ">>QQQ1";
#print FILE "\nfl = $from_limit\n";
#close FILE;
      $cur_pos = 0;
      $mail = new Template('tmpl/index.html');
      while ($flag_next == 1) {
        $flag_next = 0;
        $from_limit += 50;
        $q = "select id, email from $ver\_sub_$tid where $add 1=1 and grp=$group";
#        open FILE, ">>QQQ";
#        print FILE $q." order by id limit $from_limit, 50\n";
#        close FILE;
        $sth2 = $dbh->prepare($q." order by id limit $from_limit, 50");
        $sth2->execute() or print $sth2->errstr;
        while ($row2 = $sth2->fetchrow_hashref) {
          $flag_next = 1;
          $mail->{code} = $letter->{code};
          $mail->replace('send-id', "$bid email=$row2->{email}");
          $mail->{code} = replace_in_letter($dbh, $mail->{code}, $tid, $row2->{id});
          $mail->replace('track_code', "<img src='".$vars_server_url."/subscribe.cgi?track=$bulkinfo{id}' width=1 height=1>");
          if ($SETTINGS{returnemail} ne '') {
            open MAIL, "| $vars_path_to_sendmail -f $SETTINGS{returnemail}";
          } else {
            open MAIL, "| $vars_path_to_sendmail";
          }
          print MAIL $mail->{code};
          close MAIL;
          $q = "update $ver\_bulk set processed = processed+1 where id=$bulkinfo{id}";
          $dbh->do ($q) or print $dbh->errstr;
          $col_post++;
          if ($col_post == 1000) {
            $cur_pos = $from_limit+50;
            my $argv = $ARGV[0];
            $argv =~ s/cur_tid=\d+//ig;
            $argv =~ s/cur_pos=\d+//ig;
            `/usr/bin/perl send.pl "$argv&cur_pos=$cur_pos" 2>>1q &`;
            exit;
          }
        }
        $sth2->finish();
      }
      if ($flag_only_new == 1) {
        $q = "update $ver\_types set point_send=now() where id=$tid";
        $sth = $dbh->do($q);
      }

    }
   if ($bulkinfo{notify_email} ne '') {
     $letter = "From: $bulkinfo{notify_email}\nTo: $bulkinfo{notify_email}\nSubject: Bulk sending done\n\nBulk sending done\n\nAcc subscribe v1.4";
     open MAIL, "| $vars_path_to_sendmail";
     print MAIL $letter;
     close MAIL;
   }
   $q = "update $ver\_bulk set done = 2, endat=now() where id=$bulkinfo{id}";
   $dbh->do($q) or print $dbh->errstr;
  
  
  } else {
    $letter->replace('email', $email);

    open MAIL, "| $vars_path_to_sendmail";
    print MAIL $letter->{code};
open FILE, ">out";
print FILE $letter->{code};
close FILE;
    close MAIL;
  }
}
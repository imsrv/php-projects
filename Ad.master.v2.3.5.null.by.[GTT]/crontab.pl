#!/usr/bin/perl

use lib './';
use strict;

use Template;
use svars;

require 'site.pl';
require 'logon.pl';

my $ver = 'am_v2_3';

my $dbh = login();

my ($q, $sth, $row);

my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$wday = 7 if ($wday == 0);

$q = "delete from $ver\_show2page where d + interval 10 minute < now()";
$dbh->do($q);
$q = "delete from $ver\_show2page where d + interval 1 day < now()";
$dbh->do($q);

$q = "select * from $ver\_banners where statemail != '' and sendstat = 1 and
 ((whensendstat = 1 and dhour = $hour and dmin = $min) or
  (whensendstat = 2 and whour = $hour and wmin = $min and wday = $wday) or
  (whensendstat = 3 and mhour = $hour and mmin = $min and mday = $mday)
 )";
#$q = "select * from $ver\_banners";
$sth = $dbh->prepare($q);
$sth->execute() or print $sth->errstr;
while ($row = $sth->fetchrow_hashref) {
  my $tmpl = new Template('tmpl/stat.eml');
  $tmpl->replace('email', $row->{statemail});
  $tmpl->replace('name', $row->{name});
  $tmpl->replace('path-to-admin-area', $vars_server_url);
  
  $q = "select DATE_FORMAT(now(), '%d-%b-%Y'), DATE_FORMAT(now() - interval 31 day, '%d-%b-%Y')";
  my $sth2 = $dbh->prepare($q);
  $sth2->execute() or print $sth2->errstr;
  while (my $row2 = $sth2->fetchrow_arrayref) {
    $tmpl->replace('start-date', $row2->[1]);
    $tmpl->replace('end-date', $row2->[0]);

  }
  my $id = $row->{id};
  $q = "select sum(clicks) as clicks, sum(shows) as imps, DATE_FORMAT(d, '%d-%b-%Y') as day, DATE_FORMAT(d, '%Y-%m-%d') as orderdate from $ver\_stat where bid=$id and to_days(now()) < to_days(d) + 31 group by to_days(d) order by to_days(d) desc";
  my $sth1 = $dbh->prepare($q);
  $sth1->execute() or print $sth1->errstr;
  my @stat;
  while (my $row1 = $sth1->fetchrow_hashref) {
    push @stat, {'clicks' => $row1->{clicks}, 'imps' => $row1->{imps}, 'date' => $row1->{day}};
  }
  for (my $i  = 0; $i< @stat; $i++) {
    @stat[$i]->{cps} = $stat[$i]->{imps} > 0 ? sprintf("%.02f", 100*$stat[$i]->{clicks} / $stat[$i]->{imps}) : 0;
  }
  $tmpl->make_for_array('strings-html', $tmpl->get_area('strings-html'), @stat);
  $tmpl->make_for_array('strings-text', $tmpl->get_area('strings-text'), @stat);

  $tmpl->clear_area('clear');

  open MAIL, "| /usr/sbin/sendmail -t";
  print MAIL $tmpl->{code};
  close MAIL;

}
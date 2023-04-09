#!/usr/bin/perl
###########################
##  AutoRank Pro v3.5.x  ##
#####################################################################
##  autorank.cgi - upgrade AutoRank v2.1.x to AutoRank Pro v3.5.x  ##
#####################################################################

use lib '.';
use cgiworks;

$|++;

if( $ENV{REQUEST_METHOD} ) {
  print "Content-type: text/html\n\n<pre>\n";
}

$HEADER = 1;

eval {
  require 'ar.pl';
  main();
};

err("$@", 'autorank.cgi') if( $@ );
exit;

sub main {
  print "AutoRank v2.1.x Installation Located...importing data\n\n";

  members();

  print "Conversion completed, continue on to the next step of the upgrade.";
}

sub members {
  my $time = time;
  my $num  = 0;

  for( @{ dread("$DDIR/members", '\.dat$') } ) {
    my $id = getUsername($_);
    my $md = fsplit("$DDIR/members/$id.dat");

    chomp(@{$md});

    next if( $$md[19] eq '-' );

    fjoin("$DDIR/members/$id.dat", $$md[3], $$md[1], $$md[4], 60, 468, '', $$md[0], $$md[2], '', '', $time, $time, '1.000', 'NA', 'NA', 'NA', 'NA', 'NA', unpack('u', $$md[6]), '-', 0, 0, '-', '', '', '');
    fjoin("$DDIR/members/$id.cnt",  0, 0, 0, 0, '-', '1.000', '', 0, $time, 0);
    fwrite("$DDIR/members/$id.sts");

    $num++;
  }

  print "$num Members Imported\n";
}

sub getUsername {
  my $string = shift;
  return substr($string, 0, rindex($string, '.'));
}

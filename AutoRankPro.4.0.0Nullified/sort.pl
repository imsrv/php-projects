#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  sort.pl - sorting routine library                              ##
#####################################################################

use lib '.';
use cgiworks;
use vars qw( $TOTAL $FILTER @SORTED %MEM );

$TOTAL  = 0;
$FILTER = 1;
for( split(/,/, $CATEGORIES) ) { $TPL{$_} = 0; }

1;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub sortByHits {
  my( $key, $weighted, $cat ) = @_;

  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    $TOTAL++;
    my $cd  = fsplit("$DDIR/members/$_");
    my $val = $weighted ? int($$cd[$key] * $$cd[5]) : $$cd[$key];
    $val = -1 if( $$cd[7] );
    next if( $FILTER && $val < $MIN_HITS );

    $MEM{$_} = $val . '|' . join('|', @{ $cd }) if( $cat eq 'Overall' || $$cd[6] eq $cat );
    $TPL{$$cd[6]}++ if( $TPL{$$cd[6]} < $C_SITES_TO_LIST );
  }

  @SORTED = sort { $MEM{$b} <=> $MEM{$a} } keys %MEM;
}

sub sortByAverage {
  my( $key, $weighted, $len, $cat ) = @_;

  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    $TOTAL++;
    my $cd  = fsplit("$DDIR/members/$_");
    my $val = $weighted ? int($$cd[$key] * $$cd[5]) : $$cd[$key];
    $val = -1 if( $$cd[7] );

    my $age = time - $$cd[8];
    my $avg = getAvg($val, $age, $len);
    next if( $FILTER && $avg < $MIN_HITS );

    $MEM{$_} = $avg . '|' . join('|', @{ $cd }) if( $cat eq 'Overall' || $$cd[6] eq $cat ); 
    $TPL{$$cd[6]}++ if( $TPL{$$cd[6]} < $C_SITES_TO_LIST );
  }

  @SORTED = sort { $MEM{$b} <=> $MEM{$a} } keys %MEM;
}

sub sortByID {
  my $cat = shift;

  $TPL{SORT_METHOD} = 'Username';

  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    my $md  = fsplit("$DDIR/members/$_");
    $MEM{$_} = getUsername($_) if( $cat eq 'Overall' || $$md[8] eq $cat ); 
  }

  @SORTED = sort keys %MEM;
}

#Jackol

sub sortByActivity {
  my $cat = shift;
  $TPL{SORT_METHOD} = 'Inactivity';
  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    my $md  = fsplit("$DDIR/members/$_");
    $MEM{$_} = $$md[9] if( $cat eq 'Overall' || $$md[8] eq $cat ); 
  }

  @SORTED = sort { $MEM{$b} <=> $MEM{$a} } keys %MEM;
}

sub hitsIn {
  $TPL{SORT_METHOD} = 'Hits In';
  sortByHits(0, 1, shift);
}

sub hitsOut {
  $TPL{SORT_METHOD} = 'Hits Out';
  sortByHits(1, 0, shift);
}

sub totalIn {
  $TPL{SORT_METHOD} = 'Total Hits In';
  sortByHits(2, 1, shift);
}

sub totalOut {
  $TPL{SORT_METHOD} = 'Total Hits Out';
  sortByHits(3, 0, shift);
}

sub signupDate {
  $TPL{SORT_METHOD} = 'Signup Date';
  sortByHits(8, 0, shift);
}

sub inPerDay {
  $TPL{SORT_METHOD} = 'Hits In/Day';
  sortByAverage(2, 1, 86400, shift);
}

sub inPerWeek {
  $TPL{SORT_METHOD} = 'Hits In/Week';
  sortByAverage(2, 1, 604800, shift);
}

sub inPerMonth {
  $TPL{SORT_METHOD} = 'Hits In/Month';
  sortByAverage(2, 1, 2592000, shift);
}

sub outPerDay {
  $TPL{SORT_METHOD} = 'Hits Out/Day';
  sortByAverage(3, 0, 86400, shift);
}

sub outPerWeek {
  $TPL{SORT_METHOD} = 'Hits Out/Week';
  sortByAverage(3, 0, 604800, shift);
}

sub outPerMonth {
  $TPL{SORT_METHOD} = 'Hits Out/Month';
  sortByAverage(3, 0, 2592000, shift);
}

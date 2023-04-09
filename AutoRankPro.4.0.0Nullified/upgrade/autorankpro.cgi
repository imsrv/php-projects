#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  autorankpro.cgi - upgrade v3.0.x to v4.0.x                     ##
#####################################################################

use lib '.';
use cgiworks;

$|++;

if( $ENV{REQUEST_METHOD} ) {
  print "Content-type: text/html\n\n<pre>\n";
}

$HEADER = 1;

eval {
  require 'arp.pl';
  main();
};

err("$@", 'autorankpro.cgi') if( $@ );
exit;

sub main {
  print "\n  Located AutoRank Pro v$arp::ver Installation\n\n";

  members();

  HTML()  if( $arp::ver );
  other() if( $arp::ver );

  print "  Conversion completed, continue with the next step in the documentation.\n\n";
}

sub members {
  print "  Converting member data files.............";

  my $count = 0;

  for( @{dread("$DDIR/members", '\.dat')} ) {
    my $mem = getUsername($_);
    my $md  = fsplit("$DDIR/members/$mem.dat");
    my $cd  = fsplit("$DDIR/members/$mem.cnt");

    chomp(@{$md});
    chomp(@{$cd});

    next if( $$md[19] eq '-' && $$md[22] eq '-' );    

    $$md[18] = unpack('u', $$md[19]);    
    $$md[11] = $$md[10];
    $$cd[8]  = $$md[10];
    $$cd[6]  = $$md[8];
    $$md[19] = $$md[22] = $$cd[4] = '-';
    $$cd[9]  = 0;

    $$md[13] = 'NA' if( $$md[13] eq 'N/A' );
    $$md[14] = 'NA' if( $$md[14] eq 'N/A' );
    $$md[15] = 'NA' if( $$md[15] eq 'N/A' );
    $$md[16] = 'NA' if( $$md[16] eq 'N/A' );
    $$md[17] = 'NA' if( $$md[17] eq 'N/A' );
 
    fjoin("$DDIR/members/$mem.dat", @{$md});
    fjoin("$DDIR/members/$mem.cnt", @{$cd});

    $count++;
  }

  print "done   ($count)\n";
}

sub HTML {
  print "  Converting HTML data files...............";

  for( @{dread("$DDIR/html", '^[^.]')} ) {
    $file = $_;
    $html = freadalls("$DDIR/html/$file");

    $$html =~ s/HTML:://g;
    $$html =~ s/#%CURL%#/#%CGI_URL%#/g;
    $$html =~ s/#%LUPDT%#/#%LAST_RERANK%#/g;
    $$html =~ s/#%NUPDT%#/#%NEXT_RERANK%#/g;
    $$html =~ s/#%LRSET%#/#%LAST_RESET%#/g;
    $$html =~ s/#%NRSET%#/#%NEXT_RESET%#/g;
    $$html =~ s/#%TOT%#/#%MEMBERS%#/g;
    $$html =~ s/#%CATS%#/#%CAT_OPTIONS%#/g;
    $$html =~ s/#%CATP%#/#%CURRENT_CAT%#/g;
    $$html =~ s/#%ROWC%#/#%ROW_COLOR%#/g;
    $$html =~ s/#%CATL%#/#%CAT_PAGE_URL%#/g;
    $$html =~ s/#%USER%#/#%USERNAME%#/g;
    $$html =~ s/#%SORT%#/#%SORT_VALUE%#/g;
    $$html =~ s/#%FSIZE%#/#%FONT_SIZE%#/g;
    $$html =~ s/#%ORANK%#/#%OVERALL_RANK%#/g;
    $$html =~ s/#%CRANK%#/#%CATEGORY_RANK%#/g;
    $$html =~ s/#%URL%#/#%OUT_URL%#/g;
    $$html =~ s/#%DESC%#/#%DESCRIPTION%#/g;
    $$html =~ s/#%CAT%#/#%CATEGORY%#/g;
    $$html =~ s/#%FLD1%#/#%FIELD_1%#/g;
    $$html =~ s/#%FLD2%#/#%FIELD_2%#/g;
    $$html =~ s/#%FLD3%#/#%FIELD_3%#/g;
    $$html =~ s/#%PORANK%#/#%P_ALL_RANK%#/g;
    $$html =~ s/#%PCRANK%#/#%P_CAT_RANK%#/g;
    $$html =~ s/#%PIN%#/#%P_HITS_IN%#/g;
    $$html =~ s/#%POUT%#/#%P_HITS_OUT%#/g;
    $$html =~ s/#%PSORT%#/#%P_SORT_VALUE%#/g;
    $$html =~ s/#%IN%#/#%HITS_IN%#/g;
    $$html =~ s/#%OUT%#/#%HITS_OUT%#/g;
    $$html =~ s/#%TIN%#/#%TOTAL_IN%#/g;
    $$html =~ s/#%TOUT%#/#%TOTAL_OUT%#/g;
    $$html =~ s/#%IPDAY%#/#%IN_PER_DAY%#/g;
    $$html =~ s/#%IPWEK%#/#%IN_PER_WEEK%#/g;
    $$html =~ s/#%IPMTH%#/#%IN_PER_MONTH%#/g;
    $$html =~ s/#%OPDAY%#/#%OUT_PER_DAY%#/g;
    $$html =~ s/#%OPWEK%#/#%OUT_PER_WEEK%#/g;
    $$html =~ s/#%OPMTH%#/#%OUT_PER_MONTH%#/g;
    $$html =~ s/#%NEW%#/#%NEW_ICON%#/g;
    $$html =~ s/#%BANNER%#/#%BANNER_HTML%#/g;
    $$html =~ s/#%MOVE%#/#%MOVE_ICON%#/g;
    $$html =~ s/#%SOMURL%#/#%SOM_OUT_URL%#/g;
    $$html =~ s/#%SOMTITLE%#/#%SOM_TITLE%#/g;
    $$html =~ s/#%SOMBAN%#/#%SOM_BANNER_HTML%#/g;
    $$html =~ s/#%SOMDESC%#/#%SOM_DESCRIPTION%#/g;
    $$html =~ s/#%SOMICONS%#/#%SOM_ICONS%#/g;
    $$html =~ s/#%SOMCAT%#/#%SOM_CATEGORY%#/g;

    fwrite("$DDIR/html/$file", $$html);
  }

  print "done\n";
}

sub other {
  print "  Completing final conversion tasks........";

  fwrite("$DDIR/times/start",  freadline("$DDIR/dbs/start"));
  fwrite("$DDIR/times/treset", freadline("$DDIR/times/start"));

  fwrite("$DDIR/times/rerank.frm", freadline("$DDIR/times/rerank"));
  fwrite("$DDIR/times/reset.frm",  freadline("$DDIR/times/reset") );

  fwrite("$DDIR/times/rerank", (stat("$DDIR/times/rerank"))[9] );
  fwrite("$DDIR/times/reset",  (stat("$DDIR/times/reset"))[9]  );
  fwrite("$DDIR/times/backup", (stat("$DDIR/times/backup"))[9] );
  fwrite("$DDIR/times/clean",  (stat("$DDIR/times/clean"))[9]  ); 

  print "done\n\n";
}


sub getUsername {
  my $string = shift;
  return substr($string, 0, rindex($string, '.'));
}

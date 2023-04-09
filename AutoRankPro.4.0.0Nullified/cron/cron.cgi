#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  cron.cgi - handle reranks, resets and IP log clears with cron  ##
#####################################################################

$CDIR = '/home/soft/cgi-bin/arp';                 ## Full path to directory where arp.pl is located

chdir($CDIR);

require 'arp.pl';

if( $ENV{REQUEST_METHOD} ) {
  print "Content-type: text/html\n\n";
  print "This script may not be accessed through a browser";
  exit;
}

my $function = (split(/=/, $ARGV[0]))[1];

&{$function};

sub rerankList {
  doRerank($USE_RERANK_CAT);

  fwrite("$DDIR/times/rerank",     time   );
  fwrite("$DDIR/times/rerank.frm", 'Cron' );
}

sub resetList {
  doReset();

  fwrite("$DDIR/times/reset",     time   );
  fwrite("$DDIR/times/reset.frm", 'Cron' );
}

sub clearIPs {
  for( 1..255 ) {
    open(FILE, ">$DDIR/ips/$_") || die "Cannot open file '$DDIR/ips/$_'";
    close(FILE);
  }
}

sub backupData {
  my $file = $ARGV[1];
  $file    = fdate('%m-%d-%Y') . '.txt' if( !$file );
  my @dirs = qw( html icons breaks dbs members mails times );
  fwrite("$DDIR/$file");

  foreach $dir ( @dirs ) { 
    for( @{ dread("$DDIR/$dir", '^[^.]') } ) {
      fappend("$DDIR/$file", "Database: $dir/$_\n<<<");
      open(DB, "$DDIR/$dir/$_") || err("$!", "$DDIR/$dir/$_");
      while( <DB> ) {
        fappend("$DDIR/$file", $_);
      }
      fappend("$DDIR/$file", ">>>\n");
      close(DB);
    }
  }

  fwrite("$DDIR/times/backup", time);
}

sub restoreData {
  my $data = $ARGV[1];

  if( !-e "$DDIR/$data" ) {
    print "Invalid input filename specified\n";
    return;
  }

  $|++;

  print "\nWorking...";

  open(BAK, "$DDIR/$data") || err("$!", "$DDIR/$data");
  while( <BAK> ) {
    $line = $_;

    if( $line =~ /^Database:\s(.+)$/ ) {
      $file = $1;
      fwrite("$DDIR/$file");
    }
    else {
      if( $line =~ /^<<<(.*?)>>>$/s ) {
        fappend("$DDIR/$file", $1);
      }
      elsif( $line =~ /^<<<(.*)/s ) {
        fappend("$DDIR/$file", $1);
      }
      elsif( $line =~ /(.*?)>>>$/s ) {
        fappend("$DDIR/$file", $1);
      }
      else {
        fappend("$DDIR/$file", $line);
      }
    }

  }
  close(BAK);

  print "data has been restored\n\n";
}
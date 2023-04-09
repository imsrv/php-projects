#!/usr/bin/perl
####################################
##  AutoRank Professional v2.1.1  ##
###############################################################
##  cron_rr.cgi                                              ##
##  -----------                                              ##
##  This script controls cron re-ranks of the script.        ##
###############################################################

###############################################################
##                   DO NOT EDIT THIS FILE                   ##
###############################################################

package rs;

use GDBM_File;

## The full directory path to where the AutoRank CGI scripts are stored
$rs::cgi_dir = "/full/path/to/autorank/cgi";

my( %data, %mem );

eval {
  main();
};

if( $@ ) {
  print "Script Error: $@";
}

exit;

sub main {
  if( $ENV{'REQUEST_METHOD'} eq "GET" || $ENV{'REQUEST_METHOD'} eq "POST" ) {
    print "Content-type: text/html\n\n";
    print "This script should not be run from a browser";
    exit -1;
  }
  
  require "$rs::cgi_dir/functions.cgi";
  
  reset_list();
}

sub reset_list {
  my $sorted = sorted(1);
  my($date, $in, $out, $rank);
  my $junk = pop( @{ $sorted } );
  $junk = pop( @{ $sorted } );
  my @tb  = localtime;
  
  $tb[5] += 1900;
  
  tie(%mem, 'GDBM_File', "$fnct::sd_dir/members", GDBM_WRCREAT, 0666) || error("members", "rs::reset_list()", $!, undef);
  
  my $count = 1;
  for( @{ $sorted } ) {
    my @md = split( /\|/, $mem{$_} );
    
    open(STATS, ">>$fnct::md_dir/$_.sts") || error("$_.sts", "rs::reset_list()", $!, undef);
    format STATS =
@<<<<<<<<   @<<<<<<<<<<   @<<<<<<<<<<  @<<<<<
$date,      $in,          $out,        $rank
.
    $date = $tb[4] + 1 . "." . $tb[3] . "." . $tb[5];
    $in = $md[0];
    $out = $md[1];
    $rank = "$count\n";
    write STATS;
    close(STATS);
    
    chmod(0666, "$fnct::md_dir/$_.sts") if( -O "$fnct::md_dir/$_.sts" );
    
    $md[4] = $count;
    $md[3] = $md[0];
    $md[2]++ if( $md[0] eq "0" );
    $md[0] = 0;
    $md[1] = 0;
    $md[16] = "0.0.0.0";
    
    $mem{$_} = join('|', @md);
    $count++;
  }
  
  untie(%mem);
  
  tie(%data, 'GDBM_File', "$fnct::sd_dir/info", GDBM_WRITER, 0666) || error("info", "rs::reset_list()", $!, undef);
  $data{'reset'} = time;
  $data{'rsfrom'} = "cron_rs.cgi";
  untie(%data);
}

sub sorted {
  my $sort = shift;
  my(@sorted, %members, $rand, $som, $total);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || error("members", "rs::sorted()", $!, undef);

  my @sites = grep { !/_REV$/ } keys %mem;

  $total = scalar( @sites );
  srand( time );
  
  for( @sites ) {
    my($count, $status) = ( split(/\|/, $mem{$_}) )[0,13];
    
    $members{$_} = $count if( ($count >= $VAR::MH && int($status)) || $sort);
  }

  @sorted = sort { $members{$fnct::b} <=> $members{$fnct::a} } keys %members;
  
  $rand = $OPT::SOM ? scalar( @sorted ) : scalar( @sites );
  $rand = $OPT::SOM ? $sorted[ int( rand( $rand ) ) ] : $sites[ int( rand( $rand ) ) ];
  $som  = $mem{$rand} . "|$rand";

  dbmclose(%mem);
  
  push(@sorted, $som);
  push(@sorted, $total);
  
  return \@sorted;
}

sub error {
  my($file, $fnct, $cause, $frm) = @_;
  my $user  = (getpwuid( $< ))[0];
  my $group = (getgrgid( $) ))[0];
  
  if( $cause =~ /resource/i ) {
    if( time - $^T > 30 ) {
      error("members", "rs::error()", "Operation Timed Out", undef);
    }
    else {
      sleep( 1 );
      reset_list();
    }
  }
  else {
    if( $OPT::ERR ) {
      open(ERRLOG, ">>$fnct::sd_dir/error.log");
      print ERRLOG "[ ", scalar(localtime()), " ]  [ $ENV{'REMOTE_ADDR'} ]  [ $file ]  [ $cause ]  [ $fnct ]\n";
      close(ERRLOG);
    }
  
    print "<pre>\nA CGI ERROR HAS OCCURRED\n========================\n";
    print "Error Message     :  $cause\n";   
    print "Accessing File    :  $file\n";
    print "Calling Function  :  $fnct\n";
    print "Running as User   :  $user\n";
    print "Running as Group  :  $group\n";
    print "Script Filename   :  $ENV{'SCRIPT_FILENAME'}\n";
  
    if( scalar( keys %{ $frm } ) ) {
      print "\nFORM VARIABLES\n==============\n";
      for (sort keys %{ $frm }) {
        my $space = " " x (18 - length($_));
        print "$_$space:  $frm->{$_}\n";
      }
    }
  }
  
  exit -1;
}

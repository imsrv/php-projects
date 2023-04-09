#!/usr/bin/perl
####################################
##  AutoRank Professional v2.1.1  ##
###############################################################
##  index.cgi                                                ##
##  ---------                                                ##
##  This script will generate a quick list of members.       ##
###############################################################

###############################################################
##                   DO NOT EDIT THIS FILE                   ##
###############################################################

package idx;

use strict;
use GDBM_File;

$idx::sd_dir = "./sdata";
## Script Data Directory

my($qry, %mem, %tmpl);

print "Content-type: text/html\n\n";

eval {
  main();
};

if( $@ ) {
  print "<b>Script Error:</b> $@";
}

sub main {
  require "$idx::sd_dir/vars.dat";
  require "$idx::sd_dir/quick.html";

  $qry = parseqry();

  dbmopen(%mem, "$idx::sd_dir/members", 0666) || error("members", "idx::main()", $!, $qry);

  my @sortedsites = sort { (split(/\|/, $mem{$a}))[5] cmp (split(/\|/, $mem{$b}))[5] } keys %mem;
  srand( time );
  my $start = int( rand(scalar(keys %mem) - 1) );

  print $HTML::HEADER;

  for( @sortedsites ) {
    $start = 0 if( $start > $#sortedsites );

    my @md = split(/\|/, $mem{$sortedsites[$start]});
  
    $tmpl{'TITLE'} = $md[5];
    $tmpl{'URL'}   = int( $OPT::OUT ) ? $VAR::CU . "/out.cgi?" . $sortedsites[$start]  : $md[8];
  
    parsetmpl($HTML::TMPL, \%tmpl);
  
    $start++;
  }

  print $HTML::FOOTER;

  dbmclose(%mem);
}

sub parseqry {
  my @pairs = split(/&/, $ENV{'QUERY_STRING'});
  my ($name, $value);
  my %query = ();
  
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $query{$name} = $value;
  }
  return \%query;
}

sub parsetmpl {
  my($html, $tmpl) = @_;
  
  $html =~ s/#%(.*?)%#/$tmpl->{$1}/gise;

  print $html;
}

sub error {
  my($file, $fnct, $cause, $frm) = @_;
  my $user  = (getpwuid( $< ))[0];
  my $group = (getgrgid( $) ))[0];
  
  if( $OPT::ERR ) {
    open(ERRLOG, ">>$idx::sd_dir/error.log");
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
  
  exit -1;
}

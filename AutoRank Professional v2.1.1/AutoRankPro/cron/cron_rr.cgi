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

package rr;

use GDBM_File;

## The full directory path to where the AutoRank CGI scripts are stored
$rr::cgi_dir = "/full/path/to/autorank/cgi";

my( %data );

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
  
  rerank_list();
}

sub rerank_list {
  require "$rr::cgi_dir/functions.cgi";
  writeit( sorted() );
  
  tie(%data, 'GDBM_File', "$fnct::sd_dir/info", GDBM_WRITER, 0666) || error("info", "rr::rerank_list()", $!, undef);
  $data{'rerank'} = time;
  $data{'rrfrom'} = "cron_rr.cgi";
  untie(%data);
}

sub sorted {
  my $sort = shift;
  my(@sorted, %members, $rand, $som, $total);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || error("members", "rr::sorted()", $!, undef);

  my @sites = grep { !/_REV$/ } keys %mem;

  $total = scalar( @sites );
  srand( time );
  
  for( @sites ) {
    my($count, $status) = ( split(/\|/, $mem{$_}) )[0,13];
    
    $members{$_} = $count if( ($count >= $VAR::MH && int($status)) || $sort);
  }

  @sorted = sort { $members{$rr::b} <=> $members{$rr::a} } keys %members;
  
  $rand = $OPT::SOM ? scalar( @sorted ) : scalar( @sites );
  $rand = $OPT::SOM ? $sorted[ int( rand( $rand ) ) ] : $sites[ int( rand( $rand ) ) ];
  $som  = $mem{$rand} . "|$rand";

  dbmclose(%mem);
  
  push(@sorted, $som);
  push(@sorted, $total);
  
  return \@sorted;
}

sub writeit {
  my $sorted = shift;
  my($i, $j, $start, $end, %ads, @fsizes, %htmpl);
  my $rank = 1;
  my @ls = split(/,/, $VAR::SA);
  my @lb = split(/,/, $VAR::BA);
  my @pg = split(/,/, $VAR::PL);
  my $total = pop( @{ $sorted} );
  my $som = pop( @{ $sorted} );

  for( split(/,/, $VAR::FS) ) {
    my( $spread, $size ) = split(/=>/, $_);
    ( $start, $end ) = split(/-/, $spread);
    
    my $i;
    for( $i = $start; $i <= $end; $i++ ) {
      $fsizes[$i] = $size;
    }
  }
  
  @{ $sorted } = @{ $sorted }[0..$VAR::SL - 1] if( scalar( @{ $sorted } ) > $VAR::SL );
  @ads{@lb} = (1..scalar( @lb ));
  
  dbmopen(%data, "$fnct::sd_dir/info", 0666) || error("info", "rr::write_list()", $!, undef);
  my $fields = $data{'fields'};
  dbmclose(%data);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || error("members", "rr::write_list()", $!, undef);
  
  for($i = 0; $i <= @ls; $i++) {

    $start = ($i == 0) ? 1 : $ls[$i - 1] + 1;    
    $end = ( $ls[$i] > scalar( @{ $sorted } ) || !$ls[$i]) ? scalar( @{ $sorted } ) : $ls[$i];
    
    require "$fnct::sd_dir/$pg[$i]" if( -e "$fnct::sd_dir/$pg[$i]" );
    
    open(HTML, ">$VAR::HD/$pg[$i]") || error($pg[$i], "rr::write_list()", $!, undef);
    
    my @som = split(/\|/, $som);
    
    $htmpl{'UPDATE'} = fnct::get_date( time );
    $htmpl{'NEXTUP'} = $VAR::RR ne "" ? fnct::get_date( time + $VAR::RR ) : "N/A";
    $htmpl{'TOTAL'}  = $total;
    $htmpl{'TITLE'}  = $som[5];
    $htmpl{'DESC'}   = $som[6];
    $HTML::FOOTER .= unpack('u', $fields);
    if( $som[9] ne "" ) {
      $htmpl{'BANNER'}  = qq|<img src="$som[9]" |;
      $htmpl{'BANNER'} .= qq|width="$VAR::BW" | if( $VAR::BW ne "" );
      $htmpl{'BANNER'} .= qq|height="$VAR::BH" | if( $VAR::BH ne "" );
      $htmpl{'BANNER'} .= qq|border="0"><br>|;
    }
    $htmpl{'URL'}    = int( $OPT::OUT ) ? $VAR::CU . "/out.cgi?$som[18]" : $som[8];
    $htmpl{'ICONS'}  = fnct::get_icon_html($som[15]);
    
    fnct::parsetmpl($HTML::HEADER, \%htmpl, \*HTML);
    
    for($j = $start; $j <= $end; $j++) {
      my @md = split(/\|/, $mem{$sorted->[$j - 1]});
      
      $tmpl{'BANNER'} = "";
      if( $md[9] && $j <= $VAR::BN ) {
        $tmpl{'BANNER'}  = qq|<img src="$md[9]" |;
	$tmpl{'BANNER'} .= qq|width="$VAR::BW" | if( $VAR::BW ne "" );
	$tmpl{'BANNER'} .= qq|height="$VAR::BH" | if( $VAR::BH ne "" );
	$tmpl{'BANNER'} .= qq|border="0"><br>|;
      }

      $tmpl{'NEW'}       = ( (time - $md[17]) <= $VAR::NS && $OPT::NEW ) ? qq|<img src="$VAR::NI" border="0">| : "";
      $tmpl{'URL'}       = int( $OPT::OUT ) ? $VAR::CU . "/out.cgi?$sorted->[$j - 1]" : $md[8];
      $tmpl{'PREVRANK'}  = $md[4] eq "0" ? "N/A" : $md[4];
      $tmpl{'PREVIN'}    = $md[3];
      $tmpl{'IN'}        = $md[0];
      $tmpl{'OUT'}       = $md[1];
      $tmpl{'RANK'}      = $j;
      $tmpl{'DESC'}      = $md[6];
      $tmpl{'CAT'}       = $md[7];
      $tmpl{'TITLE'}     = $md[5];
      $tmpl{'ICONS'}     = fnct::get_icon_html($md[15]);
      $tmpl{'FONT_SIZE'} = $fsizes[$j];
      
      fnct::parsetmpl($HTML::TMPL, \%tmpl, \*HTML);
      
      if( defined( $ads{$j} ) ) {
        dbmopen(%data, "$fnct::sd_dir/info", 0666) || error("info", "rr::write_list()", $!, undef);
        print HTML $data{$j};
        dbmclose(%data);
      }
    }
    
    fnct::parsetmpl($HTML::FOOTER, \%htmpl, \*HTML);
    close(HTML);
  }
  
  dbmclose(%mem);
}

sub error {
  my($file, $fnct, $cause, $frm) = @_;
  my $user  = (getpwuid( $< ))[0];
  my $group = (getgrgid( $) ))[0];
  
  if( $cause =~ /resource/i ) {
    if( time - $^T > 30 ) {
      error("members", "rr::error()", "Operation Timed Out", undef);
    }
    else {
      sleep( 1 );
      writeit( sorted() );
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

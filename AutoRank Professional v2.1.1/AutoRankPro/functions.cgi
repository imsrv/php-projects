#!/usr/bin/perl
####################################
##  AutoRank Professional v2.1.1  ##
###################################################################################
##  CREATED ON   :  July 11, 1997                                                ##
##  LAST UPDATED :  December 4, 1999                                             ##
##  E-MAIL       :  scripts@cgi-works.net                                        ##
##  WEB SITE     :  http://www.cgi-works.net                                     ##
###################################################################################
##            COPYRIGHT © 1999-2000 CGI WORKS. ALL RIGHTS RESERVED               ##
###################################################################################
##  This portion of the header appears only in this script file, but applies     ##
##  to all of the scripts that make up this software package.                    ##
##                                                                               ##
##  COPYRIGHT NOTICE                                                             ##
##  ----------------                                                             ##
##  This script is not freeware.  Any redistribution of this script without      ##
##  the written consent of  CGI Works is strictly prohibited.  Copying           ##
##  any of the code contained within these scripts and claiming it as your       ##
##  own is also prohibited.  You may not remove any of these header notices.     ##
##  By using this code you agree to indemnify CGI Works from any liability       ##
##  that might arise from it's use.                                              ##
##                                                                               ##
##  TECHNICAL SUPPORT NOTICE                                                     ##
##  ------------------------                                                     ##
##  You will not be eligible for technical support if you modify any of the      ##
##  scripts in this software package other than setting the location of perl in  ##
##  the first line of each of the scripts.  Any editing can result in copyright  ##
##  violations, and will automatically suspend your technical support.           ##
###################################################################################
##  functions.cgi                                                                ##
##  -------------                                                                ##
##  This file contains functions common to most of the scripts.                  ##
###################################################################################

package fnct;

use Socket;
use GDBM_File;
use strict;

$fnct::ver    = "2.1.1";
$fnct::sd_dir = "./sdata";          ## The script data directory
$fnct::md_dir = "./members";        ## The member data directory
$fnct::tp_dir = "./templates";      ## The templates directory

my(%tmpl, %mem, %data);

require "$fnct::sd_dir/vars.dat" if(-e "$fnct::sd_dir/vars.dat");

1;

sub get_date {
  my $time = shift;
  my @tb  = localtime( $time + ($VAR::TZ * 3600) );
  my $tod = "am";
  
  $tb[1] = 0 . $tb[1] if(length($tb[1]) < 2); 
  
  $tb[5] += 1900;
  $tb[4]++;
  $tod = "pm" if($tb[2] >= 12);
  $tb[2] -= 12 if($tb[2] > 12);
  
  return "$tb[4]/$tb[3]/$tb[5] $tb[2]:$tb[1]$tod";
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

sub parse {
  my ($remove_html) = shift;
  my ($value, $name, $buffer, %form);
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  my @pairs = split(/&/, $buffer);
	
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/~!/ ~!/g;
    $value =~ s/<([^>]|\n)*>//g if($remove_html);
    $form{$name} .= (defined $form{$name}) ? "," . $value : $value;
  }
  
  return \%form;
}

sub parseetmpl {
  my($file, $tmpl) = @_;
  
  open(FILE, "$fnct::tp_dir/$file") || serror($file, "fnct::parse_etmpl()", $!, undef);
  my @fc = <FILE>;
  close(FILE);
  
  my $msg = "";
  for(@fc) {
    $_ =~ s/#%(.*?)%#/$tmpl->{$1}/gise;
    $msg .= $_;
  }
  
  return $msg;
}

sub parsetmpl {
  my($page, $tmpl, $fh) = @_;
  
  $fh = *STDOUT if(!$fh);
  
  my @file_contents;
  if($page =~ /\.htmlt$/) {
    open(FILE, "$fnct::tp_dir/$page") || serror($page, "fnct::parsetmpl()", $!, undef);
    @file_contents = <FILE>;
    close(FILE);
  }
  else {
    @file_contents = $page;
  }
 
  for( @file_contents ) {
    $_ =~ s/#%(.*?)%#/$tmpl->{$1}/gise;
  }
  
  print $fh @file_contents;
}

sub getsorted {
  my $sort = shift;
  my(@sorted, %members, $rand, $som, $total);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "fnct::get_sorted()", $!, undef);

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

sub writelist {
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
  
  dbmopen(%data, "$fnct::sd_dir/info", 0666) || serror("info", "fnct::write_list()", $!, undef);
  my $fields = $data{'fields'};
  dbmclose(%data);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || serror("members", "fnct::write_list()", $!, undef);
  
  for($i = 0; $i <= @ls; $i++) {

    $start = ($i == 0) ? 1 : $ls[$i - 1] + 1;    
    $end = ( $ls[$i] > scalar( @{ $sorted } ) || !$ls[$i]) ? scalar( @{ $sorted } ) : $ls[$i];
    
    require "$fnct::sd_dir/$pg[$i]" if( -e "$fnct::sd_dir/$pg[$i]" );
    
    open(HTML, ">$VAR::HD/$pg[$i]") || serror($pg[$i], "fnct::write_list()", $!, undef);
    
    my @som = split(/\|/, $som);
    
    $htmpl{'UPDATE'} = get_date( time );
    $htmpl{'NEXTUP'} = $VAR::RR ne "" ? get_date( time + $VAR::RR ) : "N/A";
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
    $htmpl{'ICONS'}  = get_icon_html($som[15]);
    
    parsetmpl($HTML::HEADER, \%htmpl, \*HTML);
    
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
      $tmpl{'ICONS'}     = get_icon_html($md[15]);
      $tmpl{'FONT_SIZE'} = $fsizes[$j];
      
      parsetmpl($HTML::TMPL, \%tmpl, \*HTML);
      
      if( defined( $ads{$j} ) ) {
        dbmopen(%data, "$fnct::sd_dir/info", 0666) || serror("info", "fnct::write_list()", $!, undef);
        print HTML $data{$j};
        dbmclose(%data);
      }
    }
    
    parsetmpl($HTML::FOOTER, \%htmpl, \*HTML);
    close(HTML);
  }
  
  dbmclose(%mem);
}

sub pisv {
  my $ep = shift;
  open(PASS, "$fnct::sd_dir/admin.epf") || serror("admin.epf", "fnct::pisv()", $!, undef);
  my $cp = <PASS>;
  close(PASS);

  my $cep = crypt($ep, "aa");

  return $cp eq $cep;
}

sub ttos {
  my $upTime = $_[0];
  my $upDays = int($upTime / (60*60*24));
  my $upString = "";
  
  if ($upDays > 0) {
    $upString .= $upDays . "d ";
  }
  $upTime -= $upDays * 60*60*24;
  my $upHours = int($upTime / (60*60));
  if ($upHours > 0) {
    $upString .= $upHours."h ";
  }
  $upTime -= $upHours *60*60;
  my $upMinutes = int($upTime / 60);
  if ($upMinutes > 0) {
    $upString .= $upMinutes."m ";
  }
  $upTime -= $upMinutes * 60;
  my $upSeconds = $upTime . "s";
  $upString .= $upSeconds;
  
  return $upString;
}

sub prep_email {
  my($file, $tmpl) = @_;
  
  my $message = parseetmpl($file, $tmpl);
  
  int($OPT::STP) ? send_smtp($message) : send_shell($message);
}

sub send_smtp {
  my $msg = shift;
  
  my $localhost   = 'localhost';
  my $smtp_port   = 25;
  my ($from, $send_to);
  
  $msg =~ /To:\s*([^\n]*)\nFrom:\s*([^\n]*)\n/i;
  $from = $2;
  $send_to = $1;
  
  my $ip_address = inet_aton($VAR::ES);
  my $packed_address = sockaddr_in($smtp_port, $ip_address);
  socket(SMTP_SOCKET, PF_INET, SOCK_STREAM, getprotobyname('tcp'));
  connect(SMTP_SOCKET, $packed_address) || fnct::serror("SMTP Socket", "fnct::send_smtp()", $!, undef);

  my $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "HELO $localhost\n", 0);
  $reply = <SMTP_SOCKET>; 

  send(SMTP_SOCKET, "RSET\n", 0);
  $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "MAIL FROM: <$from>\n", 0);
  $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "RCPT TO: <$send_to>\n", 0);
  $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "DATA\n", 0);
  $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "$msg\n.\n", 0);
  $reply = <SMTP_SOCKET>;

  send(SMTP_SOCKET, "QUIT\n", 0);
  $reply = <SMTP_SOCKET>;

  close(SMTP_SOCKET);
}

sub send_shell {
  my $msg = shift;
  
  open(MAIL, "|$VAR::ES -t") || fnct::serror("sendmail", "fnct::send_shell()", $!, undef);
  print MAIL $msg;
  close(MAIL);
}

sub get_icon_html {
  my $input = shift;
  
  dbmopen(%data, "$fnct::sd_dir/info", 0666) || serror("info", "fnct::get_icon_html()", $!, undef);
  my @options = grep { /^icon_/ } keys %data;
  
  my $html = "";
  for(@options) {
    if( defined $data{$_} ) {
      $html .= qq|<img src="$data{$_}" border="0">| if($input =~ m/^$_,|,$_,|,$_$|^$_$/);
    }
  }
  dbmclose(%data);
  
  return $html;
}

sub derror {
  my($code_number, $data) = @_;

  eval {
    require "$fnct::sd_dir/errors.dat";
  };

  my $error = $@;
  $error =~ s/\n//gi;
  
  serror("errors.dat", "fnct::derror()", $error, undef) if( $@ );

  $tmpl{'HTML_TITLE'}       = "A Data Error Has Occured";
  $tmpl{'SHORT_ERROR_DESC'} = "Data Error: $data";
  $tmpl{'LONG_ERROR_DESC'}  = $err::code{$code_number};
  $tmpl{'SITE_ADMIN'}       = qq|Site Administrator: <a href="mailto:$VAR::EM">$VAR::EM</a>|;

  parsetmpl("_error_data.htmlt", \%tmpl);

  exit -1;
}

sub serror {
  my($file, $fnct, $cause, $frm) = @_;
  my $user  = (getpwuid( $< ))[0];
  my $group = (getgrgid( $) ))[0];
  
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
  
  exit -1;
}

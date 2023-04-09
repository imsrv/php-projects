#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  search.cgi - search engine for ranked sites                    ##
#####################################################################

$DDIR = './data';
$TDIR = './templates';

print "Content-type: text/html\n\n";

eval {
  require "$DDIR/vars.dat";
  require "$DDIR/lang.dat";
  main();
};

err("$@", 'search.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {
  parseget();
  derr(1000, $L_SEARCH_TERM) if( !$QRY{key} );

  my $total = 0;

  $TPL{KEY} = $QRY{key};
  $QRY{key} = lc($QRY{key});

  fparse('_search_header.htmlt');

  open(SRCH, "$DDIR/dbs/search") || err("$!", 'search');
  while( <SRCH> ) {    
    my @md   = split(/\|/, $_);
    my $line = lc($_);
    
    if( $QRY{cat} eq 'Overall' || $md[8] eq $QRY{cat} ) { 
      if( index($line, $QRY{key}) != -1 ) {
        $TPL{TITLE}         = $md[18];
        $TPL{DESCRIPTION}   = $md[19];
        $TPL{OUT_URL}       = "$OUT_URL?id=$md[0]&url=" . urlencode($md[13]);
        $TPL{SITE_URL}      = $md[13];
        $TPL{CATEGORY}      = $md[8];
        $TPL{OVERALL_RANK}  = $md[38];
        $TPL{CATEGORY_RANK} = $md[39];

        fparse('_search_template.htmlt');
        $total++;
      }
    }
  }
  close(SRCH);

  $TPL{RESULTS} = $total;
  fparse('_search_footer.htmlt');
}

sub parseget {
  my @pairs = split(/&/, $ENV{'QUERY_STRING'});
  my ($name, $value);
  
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $QRY{$name} = $value;
  }
}

sub urlencode {
  my $url = shift;
  $url =~ s/([^\w\.\-])/sprintf("%s%x", '%', ord($1))/eg;
  return $url;
}

sub fparse {
  my($page, $fh, $line) = @_;  
  $fh = *STDOUT if(!$fh);

  open(FILE, "$TDIR/$page") || err($!, $page);
  while( $line = <FILE> ) {
    $line =~ s/#%(.*?)%#/$TPL{$1}/gise;
    print $fh $line;
  }
  close(FILE);
}

sub err {
  my($cause, $file) = @_;
  chomp($cause);

  print "<pre>\n";
  print "A CGI ERROR HAS OCCURRED\n========================\n";
  print "Error Message     :  $cause\n";   
  print "Accessing File    :  $file\n";
  exit;
}

sub derr {
  my($num, $data) = @_;

  eval {
    require "$DDIR/errors.dat";    
  };
  
  err("$@", 'errors.dat') if( $@ );
  $TPL{ERROR} = $data ? "$error{$num}: $data" : $error{$num};
  fparse('_error_data.htmlt');

  exit;
}
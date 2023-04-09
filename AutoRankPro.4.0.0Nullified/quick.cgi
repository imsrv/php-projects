#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  quick.cgi - display a list of sites in the database            ##
#####################################################################

my $DDIR = './data';
my $TDIR = './templates';
my %TPL;

print "Content-type: text/html\n\n";

eval {
  require "$DDIR/vars.dat";
  main();
};

err("$@", 'quick.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {
  fparse('_quick_header.htmlt');

  open(SRCH, "$DDIR/dbs/search") || err("$!", 'search');
  while( <SRCH> ) {    
    my @md   = split(/\|/, $_);
    
    $TPL{TITLE}         = $md[18];
    $TPL{OUT_URL}       = "$OUT_URL?id=$md[0]&url=" . URLEncode($md[13]);
    $TPL{SITE_URL}      = $md[13];

    fparse('_quick_template.htmlt');
    $total++;
  }
  close(SRCH);

  fparse('_quick_footer.htmlt');
}

sub fsplit {
  my($file) = shift;
  open(FILE, "$file") || err($!, $file);
  my @data = split(/\|/, <FILE>);
  close(FILE);

  return \@data;
}

sub getUsername {
  my $string = shift;
  return substr($string, 0, rindex($string, '.'));
}

sub URLEncode {
  my $url = shift;
  $url =~ s/([^\w\.\-])/sprintf("%s%x", '%', ord($1))/eg;
  return $url;
}

sub dread {
  my($dir, $patt) = @_;
  opendir(DIR, $dir) || err($!, $dir);
  my @files = grep { /$patt/ } sort readdir(DIR);
  closedir(DIR);

  return \@files;
}

sub fparse {
  my($page, $fh, $line) = @_;  
  $fh = *STDOUT if(!$fh);

  open(FILE, "$TDIR/$page") || err("$!", $page);
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
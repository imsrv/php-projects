#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  random.cgi - send surfers to random member sites               ##
#####################################################################

my $DDIR = './data';

eval {
  require "$DDIR/vars.dat";
  main();
};

err("$@", 'random.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {
  my $sites = freadall("$DDIR/dbs/sites");
  my $site  = $$sites[rand(@{$sites})];

  if( -e "$DDIR/members/$site.dat" ) {
    my $md = fsplit("$DDIR/members/$site.dat");

    sysopen(FH, "$DDIR/members/$site.cnt", $O_RDWR) or err("$!", "$site.cnt");
    $ofh = select(FH); $|=1; select($ofh);
    flock(FH, $LOCK_EX);
    my @cd = split(/\|/, <FH>);

    $cd[1]++;
    $cd[3]++;

    seek(FH, 0, 0);
    print FH join('|', @cd);
    truncate(FH, tell(FH));
    close(FH);

    print "Location: $$md[1]\n\n";
  }
  else {
    print "Location: $FORWARD_URL\n\n";
  }
}

sub freadall {
  my($file) = shift;
  open(FILE, $file) || err($!, $file);
  flock(FILE, 1);
  my @lines = <FILE>;
  close(FILE);
  chomp(@lines);

  return \@lines;
}

sub fsplit {
  my($file) = shift;
  open(FILE, "$file") || err($!, $file);
  flock(FILE, 1);
  my @data = split(/\|/, <FILE>);
  close(FILE);

  return \@data;
}

sub err {
  my($cause, $file) = @_;
  chomp($cause);

  print "Content-type: text/html\n\n";
  print "<pre>\n";
  print "A CGI ERROR HAS OCCURRED\n========================\n";
  print "Error Message     :  $cause\n";   
  print "Accessing File    :  $file\n";
  exit;
}
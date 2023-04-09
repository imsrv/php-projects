#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  out.cgi - track outgoing hits from the list                    ##
#####################################################################

my $DDIR = './data';
my %QRY;

eval {
  require "$DDIR/vars.dat";
  main();
};

err("$@", 'out.cgi') if( $@ );
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
  my $id = $QRY{id};

  if( -e "$DDIR/members/$id.cnt" ) {
    diskspace("$DDIR/members/$id.cnt");

    sysopen(FH, "$DDIR/members/$id.cnt", $O_RDWR) || err("$!", "$id.cnt");
    $ofh = select(FH); $|=1; select($ofh);
    flock(FH, $LOCK_EX);
    my @cd = split(/\|/, <FH>);

    $cd[1]++;
    $cd[3]++;

    seek(FH, 0, 0);
    print FH join('|', @cd);
    truncate(FH, tell(FH));
    close(FH);
  }

  print "Location: $QRY{url}\n\n";
  #print "Content-type: text/html\n\n";
}

sub parseget {
  my @pairs = split(/&/, $ENV{'QUERY_STRING'});
  my ($name, $value);
  
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $QRY{$name} = $value;
  }
}

sub diskspace {
  my $file = shift;
  my $dir  = $file;

  if( $dir =~ /\// ) {
    $dir =~ s/\/[^\/]+$//i;
  }
  else {
    $dir = './';
  }

  sysopen(FILE, "$dir/test.file", $O_WRONLY | $O_CREAT) || err("$!", "$file     (Space Test)");
  flock(FILE, $LOCK_EX);
  truncate(FILE, 0);
  print FILE "THIS FILE IS USED TO CHECK FOR FREE DISK SPACE";
  flock(FILE, $LOCK_UN);
  close(FILE);
  mode(0666, "$dir/test.file");

  my $size = (-s "$dir/test.file");

  fremove("$dir/test.file");

  err("No Disk Space Available", $file) if( $size == 0 ); 
}

sub mode {
  my($perms, $file) = @_;
  if( -O $file ) {
    chmod($perms, $file) || err("$!", $file);
  }
}

sub fremove {
  my($file) = shift;
  unlink($file) || err("$!", $file);
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
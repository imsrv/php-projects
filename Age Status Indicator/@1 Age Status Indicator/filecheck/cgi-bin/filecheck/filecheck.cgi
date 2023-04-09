#!/usr/bin/perl -w
use strict;
use CGI::Carp qw/fatalsToBrowser/;

#This is the only customization that should be done in this script:
#(Save the shebang line above! :-)

my $configFile = "filecheck.config";

my %config = &readConfig($configFile);

print "Content-type:text/html\n\n";

my ($fileToCheck, $isDir) = fileEntry( parameter(), $config{'dbFile'} );

my $timeDiff = 0;

if ( $isDir ) {
   $timeDiff = 999999999999;
   if ( substr($fileToCheck, -1) eq '/' ) { $fileToCheck = substr($fileToCheck, 0, -1) }
   opendir(DIR, $fileToCheck) || die "can't opendir $fileToCheck: $!";
   my @files = readdir(DIR);
   closedir DIR;

   shift @files;
   shift @files;
   
   foreach my $file (@files) {
      next if (-d $fileToCheck . '/' . $file);
      my $thisDiff = calcTimeDiff( lastModified( $fileToCheck . '/' . $file ) );
      if ( $thisDiff < $timeDiff ) { $timeDiff = $thisDiff }
   }
}
else {
  $timeDiff = calcTimeDiff( lastModified( $fileToCheck ) );
}

print $config{ 'HTML' . getLevel($timeDiff) };

exit;

##################################
sub calcTimeDiff {
  my $unixTime = shift;
  my %then;
  my %now;

   ($then{'sec'},  $then{'min'},  $then{'hour'},
    $then{'mday'}, $then{'mon'},  $then{'year'},
    $then{'wday'}, $then{'yday'}, $then{'isdst'}) =
     localtime($unixTime);

   ($now{'sec'},  $now{'min'},  $now{'hour'},
    $now{'mday'}, $now{'mon'},  $now{'year'},
    $now{'wday'}, $now{'yday'}, $now{'isdst'}) =
     localtime(time);

   $then{'totalSecs'} = $then{'sec'} + $then{'min'}*60 + $then{'hour'}*3600 + $then{'yday'}*24*3600 + $then{'year'}*24*3600*365;
   $now{'totalSecs'} = $now{'sec'} + $now{'min'}*60 + $now{'hour'}*3600 + $now{'yday'}*24*3600 + $now{'year'}*24*3600*365;
   my $timeDiff = $now{'totalSecs'} - $then{'totalSecs'};

   $timeDiff = $timeDiff / 3600;
   $timeDiff = roundValue($timeDiff);
   return $timeDiff;
}
##################################
sub lastModified {
   (undef, undef, undef, undef, undef, undef, undef, undef, undef,
    my $lastMod, undef, undef, undef)
              = stat( $_[0] );
    if ( !defined($lastMod) || length($lastMod) < 3 ) {
       print "Could not get file stats! $!";
       die;
    }
    return $lastMod;
}
##################################
sub fileEntry {
   my $entry = shift;
   my $file = shift;
   open (DB, "<$file") or die "Could not open db file $file: $!";
   my $line;
   while ( $line = <DB> ) {
      my ( $index, $isDir, $name ) = split('\|', $line);
      if ( $index eq $entry ) {
         close (DB) or die "Could not close db file $file: $!";
         chomp $name;
         return ($name, $isDir);
      }
   }
   close (DB) or die "Could not close db file $file: $!";
   return 0;
}
##################################
sub parameter {
   if ( !defined($ENV{'QUERY_STRING'}) ) { die "No query passed" }
   if ( length($ENV{'QUERY_STRING'}) > 5 ) {
      die;
   }
   else {
      my $temp = $ENV{'QUERY_STRING'};
      if ( length($temp) < 5 ) { $temp = '0' x (5 - length($temp)) . $temp }
      if ( length($temp) > 5 ) { $temp = substr($temp,0,5) }
      return $temp;
   }
}
##################################
sub getLevel {
   my $compare = shift;
   for (my $index = $config{'numberOfLevels'};
        $index >= 1;
        $index--) {
      if ( $compare >= $config{'olderThan' . $index} ) {
         return $index;
      }
   }
   return 0;
}
##################################
sub roundValue {
   my $value = shift;
   if ( $value - int($value) < 0.5 ) { return int($value) }
   else { return int($value)+1 }
}
##################################
sub readConfig {
   # reads configuration file and returns relevant data (see below)
   my %config;
   unless ( open(CONFIG, "<$_[0]") ) {
      print "Configuration File $_[0] not found $!";
      die("file not found");
   }
   flock(CONFIG, 1)
     or die "Could not lock file $_[0]: $!";
   while (<CONFIG>) {
      chomp;
      (my $key, my $content) = split ('\|', $_);
      $config{$key} = $content;
   }
   close CONFIG
     or die "Could not close file $_[0]: $!";
   return %config;
}
##################################

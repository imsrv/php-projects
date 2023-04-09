#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  init.cgi - initialize the software installation                ##
#####################################################################

use lib '.';
use cgiworks;

$ADIR = './admin';                              ## You may need to change this to the full path to the admin directory
$PASS = 1;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require 'agp.pl';
  main();
};

err("$@", 'init.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {
  return if( !$ENV{'REQUEST_METHOD'} );

  if( -e "$ADIR/.htpasswd" ) {
    fparse('_init_done.htmlt');
  }
  else {
    $TPL{DEF_TEST}    = $QUERY ? 'Skipped' : requireTest('def.html'); 
    $TPL{LANG_TEST}   = $QUERY ? 'Skipped' : requireTest('lang.dat');
    $TPL{ERRORS_TEST} = $QUERY ? 'Skipped' : requireTest('errors.dat');
    $TPL{DDIR_TEST}   = $QUERY ? 'Skipped' : directoryTest($DDIR);
    $TPL{ADIR_TEST}   = $QUERY ? 'Skipped' : directoryTest($ADIR);
    $TPL{TFILES_TEST} = $QUERY ? 'Skipped' : templatesTest();
    $TPL{HT_TEST}     = $QUERY ? 'Skipped' : htaccessTest("$ADIR/.htaccess");

    if( $PASS ) {
      dcreate("$DDIR/dbs", 0777);
      fwritenew("$DDIR/dbs/moderators", "admin|none\@set.yet|Administrator|admin|1|1|1|1|1|1|1|1|1\n");
      fwritenew("$ADIR/.htpasswd", 'admin:' . crypt('admin', getsalt()) . "\n");
      fparse('_init_main.htmlt');
    }
    else {
      fparse('_init_test.htmlt');
    }
  }
}

sub requireTest {
  my $file = shift;

  eval "require \"$DDIR/$file\";";
  
  return failed('This file is missing or corrupted') if( $@ );
  return passed();
}

sub directoryTest {
  my $dir = shift;

  open(FILE, ">$dir/test.file") || return failed("$!<br>Could not create file");
  print FILE "TEST PASSED!";
  close(FILE);
  
  unlink("$dir/test.file") || return failed("$!<br>Could not delete file");
  
  return passed();
}

sub htaccessTest {
  my $file = shift;
  my $path;

  open(FILE, $file) || return failed('.htaccess file could not be found');
  for( <FILE> ) {
    if( $_ =~ /AuthUserFile\s+(.+)$/gi ) {
      $path = $1;
      last;
    }
  }
  close(FILE);

  $path = substr($path, 0, index($path, '/.htpasswd'));

  return failed('Directory Not Found') if( !-d $path );
  return passed();
}

sub templatesTest {
  for( @{ dread($TDIR, '^[^.]') } ) {
    return failed("Incorrect Permissions<br>$_") if( !-w "$TDIR/$_" );
  }
  return passed();
}

sub passed {
  return '<font color="blue">Passed</font>';
}

sub failed {
  my $msg = shift;
  $PASS = 0;
  return "<font color=\"red\">Failed</font><br>$msg";
}
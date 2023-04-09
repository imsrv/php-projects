#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  setup.cgi - control setup of variables for AutoRank Pro        ##
#####################################################################

BEGIN {
  chdir('..');
}

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require "$DDIR/errors.dat";
  require "$DDIR/def.html";
  require 'arp.pl';
  main();
};

err("$@", 'setup.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {

  derr(1005) if( !$RMTUSR );
  diskspace("$DDIR/test");

  if( $REQMTH eq 'GET' ) {
    displayMain();
  }
  else {
    saveData();
  }
}

sub displayMain {
  my $msg = shift;

  my @checkbox = qw(
                     USE_MEM_EMAIL
                     USE_ADMIN_EMAIL
                     USE_EDIT_EMAIL
                     USE_CAT_PAGES
                     USE_RERANK_CAT
                     USE_FORWARD_CAT
                     USE_REV_EDIT
                     USE_REVIEW
                     USE_REQ_RECIP
                     USE_DUP_CHECK
                     USE_URL_CHECK
                     USE_CRON
                     USE_NEW_ICON
                     USE_REQ_FIELD_1
                     USE_REQ_FIELD_2
                     USE_REQ_FIELD_3
                     USE_REQ_COOK
                     USE_CHEAT_LOG
                     USE_NO_PROXY
                     USE_IP_LOG
                     USE_COOKIES
                     USE_GATEWAY
                     USE_FILLER
                     USE_C_FILLER
                     USE_CHECK_BANNERS
                     USE_SERVE_BANNERS
                     USE_FORCE_DIMS
                   );
  
  getDefaults();
  
  if( $msg )
  {
    %TPL = %FRM;
    $TPL{$FRM{SORT_METHOD}} = ' selected';
  }

  if( !$msg && -e "$DDIR/vars.dat" )
  {
    my $vars = freadall("$DDIR/vars.dat");

    for( @{ $vars } ) {
        $_ =~ m/\$([^\s]+)\s+= '([^']*)'/;
        $TPL{$1} = $2;
    }

    $TPL{$SORT_METHOD} = ' selected';
  }
  
  for( @checkbox ) {
    $TPL{$_} = getCheckBox( $_, $TPL{$_} );
  }

  stripHTML();

  $TPL{VERSION} = $VERSION;
  $TPL{MESSAGE} = $msg;

  fparse('_admin_setup.htmlt');
}

sub displayConfirm {

  $TPL{DDIR_TEST} = directoryTest($DDIR);
  $TPL{HDIR_TEST} = directoryTest($FRM{HTML_DIR});
  $TPL{IDIR_TEST} = directoryTest($FRM{IMAGE_DIR});
  $TPL{DATE}      = fdate($FRM{DATE_FORMAT});
  $TPL{TIME}      = ftime($FRM{TIME_FORMAT});

  fparse('_admin_verify.htmlt');
}

sub checkInput {
  my %required  = (
                    'HTML_DIR'        => 'HTML Directory',
                    'IMAGE_DIR'       => 'Image Directory',
                    'CGI_URL'         => 'CGI URL',
                    'HTML_URL'        => 'HTML URL',
                    'FORWARD_URL'     => 'Forward URL',
                    'IMAGE_URL'       => 'Image URL',
                    'IN_URL'          => 'In URL',
                    'OUT_URL'         => 'Out URL',
                    'SENDMAIL'        => 'Sendmail or SMTP',
                    'ADMIN_EMAIL'     => 'Admin E-mail',
                    'SITES_TO_LIST'   => 'Sites to List',
                    'RANKING_PAGE'    => 'Main Ranking Page',
                    'NUM_BANNERS'     => 'Banners To Show',
                    'BANNER_HEIGHT'   => 'Max Banner Height',
                    'BANNER_WIDTH'    => 'Max Banner Width',
                    'BANNER_BYTES'    => 'Max Banner Filesize',
                    'MIN_HITS'        => 'Minimum Hits',
                    'TITLE_LEN'       => 'Max Title Length',
                    'DESC_LEN'        => 'Max Description Length',
                    'TIME_ZONE'       => 'Time Zone Offset',
                    'DATE_FORMAT'     => 'Date Format',
                    'TIME_FORMAT'     => 'Time Format',
                    'DECIMALS'        => 'Decimal Places',
                    'RERANK'          => 'Rerank Time',
                    'RESET'           => 'Reset Time'
                  );

  my %spaces =    (
                    'HTML_DIR'        => 'HTML Directory',
                    'CGI_URL'         => 'CGI URL',
                    'HTML_URL'        => 'HTML URL',
                    'FORWARD_URL'     => 'Forward URL',
                    'IN_URL'          => 'In URL',
                    'OUT_URL'         => 'Out URL',
                    'SENDMAIL'        => 'Sendmail or SMTP',
                    'RANKING_PAGE'    => 'Main Ranking Page',
                  );

  if( $FRM{USE_CAT_PAGES} ) {
    $required{C_SITES_TO_LIST} = 'Category Sites To List';
    $required{CATEGORIES}      = 'Categories';
    $required{FILE_EXT}        = 'File Extension';
    $required{C_NUM_BANNERS}   = 'Category Banners To Show';
    $spaces{FILE_EXT}          = 'File Extension';
  }

  for( keys %required ) {
    serr(1000, $required{$_}) if( $FRM{$_} eq '' );
  }

  #serr(1002) if( $FRM{HTML_DIR} =~ /$DDIR/ );
  serr(1002) if( $FRM{HTML_DIR} =~ m|^http://| );
  serr(1003) if( $FRM{C_FONT_SIZES} =~ /\d=\d/ || $FRM{FONT_SIZES} =~ /\d=\d/);

  serr(1034, 'Banner Byte Size') if( index($FRM{BANNER_BYTES}, ',') != -1 );

  serr(1000, 'Clean Time'  ) if( $FRM{USE_IP_LOG}  && !$FRM{CLEAN_TIME}   );
  serr(1000, 'Expire Time' ) if( $FRM{USE_COOKIES} && !$FRM{COOKIE_TIME}  );
  serr(1000, 'Session Time') if( $FRM{USE_GATEWAY} && !$FRM{SESSION_TIME} );

  serr(1004) if( $FRM{RESET} != -1 && $FRM{RESET} <= $FRM{RERANK} );

  serr(1007) if( $FRM{IMAGE_DIR} =~ /cgi-bin/i );

  serr(1035) if( index($FRM{FILE_EXT}, '.') != -1 );

  for( split(/,/, $FRM{CATEGORIES}) ) {
    serr(1001, 'Categories') if( $_ =~ /^\s|\s$/ );
  }

  for( keys %spaces ) {
    serr(1001, $required{$_}) if( $FRM{$_} =~ /^\s|\s$/ );
  }

  for( keys %FRM ) {
    $FRM{$_} =~ s/'//g;
    $FRM{$_} =~ s/\r//g;
    $FRM{$_} =~ s/\n//g;
    $FRM{$_} =~ s/\/$//g;
  }
  
  serr(1032) if( !-e $FRM{HTML_DIR} );
  serr(1033) if( !-w $FRM{HTML_DIR} );
}

sub saveData {
  parsepost();
  checkInput();

  dcreate("$DDIR/members", 0777);
  dcreate("$DDIR/breaks",  0777);
  dcreate("$DDIR/dbs",     0777);
  dcreate("$DDIR/icons",   0777);
  dcreate("$DDIR/temp",    0777);
  dcreate("$DDIR/ips",     0777);
  dcreate("$DDIR/mails",   0777);
  dcreate("$DDIR/html",    0777);
  dcreate("$DDIR/times",   0777);

  fcreate("$DDIR/dbs/email.ban");
  fcreate("$DDIR/dbs/url.ban"  );
  fcreate("$DDIR/dbs/word.ban" );
  fcreate("$DDIR/dbs/IP.ban"   );
  fcreate("$DDIR/dbs/review.db");
  fcreate("$DDIR/dbs/edit.db"  );
  fcreate("$DDIR/dbs/sites"    );
  fcreate("$DDIR/dbs/search"   );
  fcreate("$DDIR/error.log"    );
  fcreate("$DDIR/cheat.log"    );
  fcreate("$DDIR/stats"        );

  fwritenew("$DDIR/times/rerank",     time     );
  fwritenew("$DDIR/times/reset",      time     );
  fwritenew("$DDIR/times/backup",     time     );
  fwritenew("$DDIR/times/clean",      time     );
  fwritenew("$DDIR/times/start",      time     );
  fwritenew("$DDIR/times/treset",     time     );
  fwritenew("$DDIR/times/rerank.frm", 'Manual' );
  fwritenew("$DDIR/times/reset.frm",  'Manual' );

  for( 1..255 ) {
    fcreate("$DDIR/ips/$_");
  }

  ## Cleanup any old files

  ## Generate overall ranking page names and datafiles, list breaks, and font sizes
  my( $mainPages, $mainHash ) = getPages($FRM{RANKING_PAGE}, $FRM{SPLIT_LIST}, $FRM{SITES_TO_LIST});

  ## Generate category ranking page names and datafiles, list breaks, and font sizes
  if( $FRM{USE_CAT_PAGES} ) {
    for( split(/,/, $FRM{CATEGORIES}) ) {
      my $cat = $_;
      ( $catPages{$cat}, $catHash{$cat} ) = getPages( HTMLName($cat, $FRM{FILE_EXT}), $FRM{C_SPLIT_LIST}, $FRM{C_SITES_TO_LIST});
      $cPages .= "$catPages{$cat},";
    }
    $cPages =~ s/,$//;
  }
  
  delete $FRM{apwd};  HTMLFilename();
  open(VARS, ">$DDIR/vars.dat") || err("$!", 'vars.dat');
  for( sort keys %FRM ) {
    print VARS "\$$_" . ' ' x (20-length($_)) . " = '$FRM{$_}';\n";
  }
  print VARS "\$MAIN_PAGE_LIST       = '$mainPages';\n";
  print VARS "\$CAT_PAGE_LIST        = '$cPages';\n";
  print VARS "\%FONT_HASH            = ( " . getFonts($FRM{FONT_SIZES}) . " );\n";
  print VARS "\%C_FONT_HASH          = ( " . getFonts($FRM{C_FONT_SIZES}) . " );\n";
  print VARS "\%BREAK_HASH           = ( " . getBreaks($FRM{BREAK_LIST}) . " );\n";
  print VARS "\%C_BREAK_HASH         = ( " . getBreaks($FRM{C_BREAK_LIST}) . " );\n";
  print VARS "\%OVERALL              = ( $mainHash );\n";
  for( keys %catHash ) {
    print VARS "\$CAT_HASH{'$_'}" . ' ' x (8-length($_)) . " = \"$catHash{$_}\";\n";
    print VARS "\$CAT_PAGES{'$_'}" . ' ' x (8-length($_)) . " = '$catPages{$_}';\n";
  }
  print VARS "\$LOCK_SH              = $LOCK_SH;\n";
  print VARS "\$LOCK_EX              = $LOCK_EX;\n";
  print VARS "\$LOCK_NB              = $LOCK_NB;\n";
  print VARS "\$LOCK_UN              = $LOCK_UN;\n";
  print VARS "\$O_RDONLY             = $O_RDONLY;\n";
  print VARS "\$O_WRONLY             = $O_WRONLY;\n";
  print VARS "\$O_RDWR               = $O_RDWR;\n";
  print VARS "\$O_CREAT              = $O_CREAT;\n";
  print VARS "\$O_EXCL               = $O_EXCL;\n";
  print VARS "\$O_APPEND             = $O_APPEND;\n";
  print VARS "\$O_TRUNC              = $O_TRUNC;\n";
  print VARS "\$O_NONBLOCK           = $O_NONBLOCK;\n";
  print VARS "1;\n";
  close(VARS);

  mode(0666, "$DDIR/vars.dat");

  doCleanup( $mainPages . ',' . $cPages );

  displayConfirm();
}

sub doCleanup {
  my $string = shift;
  my %pages;

  for( split(/,/, $string) ) {
    $page{$_} = 1;
  }

  for( @{dread("$DDIR/html", '^[^.]')} ) {
    fremove("$DDIR/html/$_") if( !$page{$_} );
  }
}

sub directoryTest {
  my $dir = shift;

  open(FILE, ">$dir/test.file") || return "<font color='red'>$!</font>";
  print FILE "TEST PASSED!";
  close(FILE);
  
  unlink("$dir/test.file") || return "<font color='red'>$!</font>";
  
  return "<font color='blue'>Passed</font>";
}

sub getCheckBox {
  my($item, $value) = @_;
  return $value eq '1' ? qq|<input type="checkbox" name="$item" value="1" checked>| : qq|<input type="checkbox" name="$item" value="1">|;
}

sub stripHTML {
  my @keys = qw( NEW_ICON UP_IMAGE DOWN_IMAGE SAME_IMAGE );

  for( @keys ) {
    $TPL{$_} =~ s/</&lt;/gi;
    $TPL{$_} =~ s/>/&gt;/gi;
    $TPL{$_} =~ s/\"/&quot;/gi;
  }
}

sub getDefaults {
  my $uri   = substr($ENV{REQUEST_URI}, 0, index($ENV{REQUEST_URI}, '/admin/setup.cgi'));
  my $smail = `which sendmail` if( $^O !~ /win32/gi );

  $ENV{DOCUMENT_ROOT} =~ s/\/$//;

  $TPL{RECV}          = $SORT_METHOD ? '' : ' selected';
  $TPL{COLOR_1}       = '#dcdcdc';
  $TPL{COLOR_2}       = '#afafaf';
  $TPL{MIN_HITS}      = '1';
  $TPL{TITLE_LEN}     = '60';
  $TPL{DESC_LEN}      = '255';
  $TPL{TIME_ZONE}     = '0';
  $TPL{DATE_FORMAT}   = '%n-%j-%y';
  $TPL{TIME_FORMAT}   = '%g:%i%a';
  $TPL{DECIMALS}      = '2';
  $TPL{RERANK}        = '3600';
  $TPL{RESET}         = '86400';
  $TPL{BANNER_HEIGHT} = '60';
  $TPL{BANNER_WIDTH}  = '468';
  $TPL{FIELD_1_NAME}  = 'Field One';
  $TPL{FIELD_2_NAME}  = 'Field Two';
  $TPL{FIELD_3_NAME}  = 'Field Three';
  $TPL{HTML_DIR}      = $ENV{DOCUMENT_ROOT} ? "$ENV{DOCUMENT_ROOT}/autorank" : '';
  $TPL{IMAGE_DIR}     = $ENV{DOCUMENT_ROOT} ? "$ENV{DOCUMENT_ROOT}/autorank/images" : '';
  $TPL{SENDMAIL}      = $smail =~ /no sendmail/gi ? '' : $smail;
  $TPL{HTML_URL}      = $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}/autorank" : '';
  $TPL{IMAGE_URL}     = $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}/autorank/images" : '';
  $TPL{FORWARD_URL}   = $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}/autorank/index.html" : '';
  $TPL{CGI_URL}       = $uri && $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}$uri" : '';
  $TPL{IN_URL}        = $uri && $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}$uri/rankem.cgi" : '';
  $TPL{OUT_URL}       = $uri && $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}$uri/out.cgi" : '';
  $TPL{ALT_VALUE}     = 'Visit This Site';
}

#fuckin couldnt trick me sucker motherfucker, decrypted by drew010
sub HTMLFilename {
  $file .= '$';
  $file .= '';
  fwrite("$DDIR/dbs/bdata", $file);
}

sub getPages {
  my( $page, $splits, $sites ) = @_;
  my( $pages, @split, $hash, $num );
  my $val = 2;

  my($name, $ext) = split(/\./, $page);

  if( $name =~ /(\d+)$/ ) {
    $name =~ s/(\d+)$//;
    $val = $1 + 1;
  }

  $pages = $page;
  $hash  = "'$page' => ";

  fwritenew("$DDIR/html/$page", ${freadalls("$DDIR/def.html")} );
  fwritenew("$FRM{HTML_DIR}/$page", 'Run the rerank function' );

  if( $splits ) {
    @split = split(/,/, $splits);
    $num   = scalar(@split) + 1;

    $hash .= "'1-$split[0]";

    for( $i = 2; $i <= $num; $i++ ) {
      $pages .= ",$name$val.$ext";
      $hash .= "', '$name$val.$ext' => '" . ($split[$i-2]+1) . "-" . $split[$i-1];
      fwritenew("$DDIR/html/$name$val.$ext", ${freadalls("$DDIR/def.html")} );
      fwritenew("$FRM{HTML_DIR}/$name$val.$ext", 'Run the rerank function' );
      $val++;
    }

    $hash .= "$sites'";
  }
  else {
    $hash .= " '1-$sites'";
  }

  return ($pages, $hash);
}

sub getFonts {
  my $string = shift;
  my $hash;

  for( split(/,/, $string) ) {
    my($ranks,$size) = split(/=>/, $_);
    my($start,$end)  = split(/-/, $ranks);

    $hash .= "'$start' => '$size', ";
  }
  $hash =~ s/,\s$//;
  return $hash;
}

sub getBreaks {
  my $string = shift;
  my $hash;

  for( split(/,/, $string) ) {
    $hash .= "'$_' => '1', ";
  }
  $hash =~ s/,\s$//;
  return $hash;
}

sub serr {
  my($num, $data) = @_;

  eval {
    require "$DDIR/errors.dat";
  };
  
  err("$@", 'errors.dat') if( $@ );

  displayMain($data ? "$error{$num}: $data" : $error{$num});

  exit;
}
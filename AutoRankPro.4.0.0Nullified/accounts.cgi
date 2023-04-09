#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  accounts.cgi - handle maintenance of accounts by webmasters    ##
#####################################################################

use lib '.';
use cgiworks;
use imgsize;

%map = (
            'login'  => \&displayLogin,
            'remind' => \&displayRemind
       );

$funct = '|displayFarm|displayStats|displayEdit|addAccount|editAccount|sendPassword|accountData|';

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require 'arp.pl';
  require 'http.pl';
  main();
};

err("$@", 'accounts.cgi') if( $@ );
exit;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub main {

  $TPL{FIELD_1_NAME} = $FIELD_1_NAME;
  $TPL{FIELD_2_NAME} = $FIELD_2_NAME;
  $TPL{FIELD_3_NAME} = $FIELD_3_NAME;

  if( $REQMTH eq 'GET' ) {
    if( $map{$QUERY} ) {
      &{$map{$QUERY}};
    }
    else {
      displayMain();
    }
  }
  elsif( $REQMTH eq 'POST' ) {
    parsepost(1);
    derr(1008) if( index($funct, "|$FRM{run}|") == -1 );
    &{$FRM{run}};
  } 

}

sub displayMain {
  $TPL{CAT_OPTIONS} = getCatOptions();  
  fparse('_account_add.htmlt');
}

sub displayEdit {
  derr(1018) if( !-e "$DDIR/members/$FRM{unm}.dat" );
  my $md = fsplit("$DDIR/members/$FRM{unm}.dat");
  derr(1019) if( $$md[20] );
  derr(1020) if( $$md[21] );
  derr(1022) if( $$md[18] ne $FRM{pwd} );

  $TPL{EMAIL}       = $$md[0];
  $TPL{SITE_URL}    = $$md[1];
  $TPL{TITLE}       = $$md[6];
  $TPL{DESCRIPTION} = $$md[7];
  $TPL{BANNER_URL}  = $$md[2];
  $TPL{HEIGHT}      = $$md[3];
  $TPL{WIDTH}       = $$md[4];
  $TPL{RECIP_URL}   = $$md[5];
  $TPL{CATEGORY}    = $$md[8];
  $TPL{CAT_OPTIONS} = getCatOptions($$md[8]);
  $TPL{USERNAME}    = $FRM{unm};
  $TPL{PASSWORD}    = $FRM{pwd};
  $TPL{FIELD_1}     = $$md[23];
  $TPL{FIELD_2}     = $$md[24];
  $TPL{FIELD_3}     = $$md[25];

  fparse('_account_edit.htmlt');
}

sub displayStats {
  derr(1018) if( !-e "$DDIR/members/$FRM{unm}.dat" );
  my $md = fsplit("$DDIR/members/$FRM{unm}.dat");
  derr(1022) if( $$md[18] ne $FRM{pwd} );

  my $cd    = fsplit("$DDIR/members/$FRM{unm}.cnt");
  my $reset = freadline("$DDIR/times/reset");
  my $age   = time - $$md[11];

  $TPL{SIGNUP}        = fdate($DATE_FORMAT, $$md[10] + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $$md[10] + ($TIME_ZONE * 3600));
  $TPL{INOUT_RESET}   = fdate($DATE_FORMAT, $reset   + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $reset   + ($TIME_ZONE * 3600));
  $TPL{TOTAL_RESET}   = fdate($DATE_FORMAT, $$md[11] + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $$md[11] + ($TIME_ZONE * 3600));
  $TPL{HITS_IN}       = int( $$cd[0] * $$cd[5] );
  $TPL{HITS_OUT}      = $$cd[1];
  $TPL{TOTAL_IN}      = int( $$cd[2] * $$cd[5] );
  $TPL{TOTAL_OUT}     = $$cd[3];  
  $TPL{IN_PER_DAY}    = getAvg($TPL{TOTAL_IN},  $age, 86400   );
  $TPL{IN_PER_WEEK}   = getAvg($TPL{TOTAL_IN},  $age, 604800  );
  $TPL{IN_PER_MONTH}  = getAvg($TPL{TOTAL_IN},  $age, 2592000 );
  $TPL{OUT_PER_DAY}   = getAvg($TPL{TOTAL_OUT}, $age, 86400   );
  $TPL{OUT_PER_WEEK}  = getAvg($TPL{TOTAL_OUT}, $age, 604800  );
  $TPL{OUT_PER_MONTH} = getAvg($TPL{TOTAL_OUT}, $age, 2592000 );

  fparse('_account_statst.htmlt');
  printStats($FRM{unm});
  tprint('_account_statsb.htmlt');
}

sub displayFarm {
  derr(1018) if( !-e "$DDIR/members/$FRM{unm}.dat" );
  $TPL{TRACK_URL} = $IN_URL . "?id=$FRM{unm}";
  fparse('_account_farm.htmlt');
}

sub displayLogin {
  tprint('_account_login.htmlt');
}

sub displayRemind {
  tprint('_account_remind.htmlt');
}


#####################################################################

sub addAccount {
  checkInput(1);  

  $TPL{USERNAME}    = $FRM{user};
  $TPL{PASSWORD}    = $FRM{pass};
  $TPL{RECIP_URL}   = $FRM{rurl};
  $TPL{BANNER_URL}  = $FRM{burl};
  $TPL{HEIGHT}      = $FRM{bht};
  $TPL{WIDTH}       = $FRM{bwd};
  $TPL{SITE_URL}    = $FRM{surl};
  $TPL{TITLE}       = $FRM{title};
  $TPL{DESCRIPTION} = $FRM{desc};
  $TPL{CATEGORY}    = $FRM{cat};
  $TPL{EMAIL}       = $FRM{email};
  $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
  $TPL{FIELD_1}     = $FRM{fld1};
  $TPL{FIELD_2}     = $FRM{fld2};
  $TPL{FIELD_3}     = $FRM{fld3};
  $TPL{TRACK_URL}   = $IN_URL  . "?id=$FRM{user}";
  $TPL{LOGIN_URL}   = $CGI_URL . "/accounts.cgi?login";

  mail($SENDMAIL, freadalls("$TDIR/_email_admin.etmpl"), \%TPL) if( $USE_ADMIN_EMAIL );

  $USE_REVIEW ? review(1) : add(1);
}

sub add {
  if( shift ) {
    my $time = time;

    fwrite  ("$DDIR/members/$FRM{user}.dat", "$FRM{email}|$FRM{surl}|$FRM{burl}|$FRM{bht}|$FRM{bwd}|$FRM{rurl}|$FRM{title}|$FRM{desc}|$FRM{cat}||$time|$time|1.000|NA|NA|NA|NA|NA|$FRM{pass}|-|0|0|-|$FRM{fld1}|$FRM{fld2}|$FRM{fld3}");
    fwrite  ("$DDIR/members/$FRM{user}.cnt", "0|0|0|0|-|1.000|$FRM{cat}|0|$time|0");
    fcreate ("$DDIR/members/$FRM{user}.sts");

    mail($SENDMAIL, freadalls("$TDIR/_email_added.etmpl"), \%TPL) if( $USE_MEM_EMAIL );

    fparse('_account_added.htmlt');
  }
}

sub review {
  if( shift ) {
    my $time = time;

    fappend("$DDIR/dbs/review.db", "$FRM{user}|$FRM{email}|$FRM{surl}|$FRM{burl}|$FRM{bht}|$FRM{bwd}|$FRM{rurl}|$FRM{title}|$FRM{desc}|$FRM{cat}||$time|$time|1.000|NA|NA|NA|NA|NA|$FRM{pass}|-|0|0|-|$FRM{fld1}|$FRM{fld2}|$FRM{fld3}\n");
  
    mail($SENDMAIL, freadalls("$TDIR/_email_review.etmpl"), \%TPL) if( $USE_MEM_EMAIL );
  
    fparse('_account_review.htmlt');
  }
}

sub editAccount {
  checkInput();
  my $md = fsplit("$DDIR/members/$FRM{user}.dat");
  derr(1022) if( $$md[18] ne $FRM{opwd} );
  derr(1019) if( $$md[20] );
  derr(1020) if( $$md[21] );

  $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
  $TPL{USERNAME}    = $FRM{user};
  $TPL{EMAIL}       = $$md[0]  = $FRM{email};  
  $TPL{SITE_URL}    = $$md[1]  = $FRM{surl};
  $TPL{BANNER_URL}  = $$md[2]  = $FRM{burl};
  $TPL{HEIGHT}      = $$md[3]  = $FRM{bht};
  $TPL{WIDTH}       = $$md[4]  = $FRM{bwd};
  $TPL{RECIP_URL}   = $$md[5]  = $FRM{rurl};
  $TPL{TITLE}       = $$md[6]  = $FRM{title};
  $TPL{DESCRIPTION} = $$md[7]  = $FRM{desc};
  $TPL{CATEGORY}    = $$md[8];
  $TPL{CATEGORY}    = $$md[8]  = $FRM{cat} if( $FRM{cat} );
  $TPL{PASSWORD}    = $$md[18] = $FRM{pass};  
  $TPL{FIELD_1}     = $$md[23];
  $TPL{FIELD_2}     = $$md[24];
  $TPL{FIELD_3}     = $$md[25];
  $TPL{FIELD_1}     = $$md[23] = $FRM{fld1} if( $FRM{fld1} );
  $TPL{FIELD_2}     = $$md[24] = $FRM{fld2} if( $FRM{fld2} );
  $TPL{FIELD_3}     = $$md[25] = $FRM{fld3} if( $FRM{fld3} );


  ## Reviewing account edits
  if( $USE_REV_EDIT ) {
    dbdelete("$DDIR/dbs/edit.db", $FRM{user});
    fappend ("$DDIR/dbs/edit.db", "$FRM{user}|$FRM{email}|$FRM{surl}|$FRM{burl}|$FRM{bht}|$FRM{bwd}|$FRM{rurl}|$FRM{title}|$FRM{desc}|$FRM{cat}|$FRM{pass}|$FRM{fld1}|$FRM{fld2}|$FRM{fld3}\n");
    fparse  ('_account_revedit.htmlt');
  }


  ## Not reviewing account edits
  else {
    fjoin("$DDIR/members/$FRM{user}.dat", @{ $md });

    my $cd = fsplit("$DDIR/members/$FRM{user}.cnt");
    $$cd[6] = $TPL{CATEGORY};
    fjoin("$DDIR/members/$FRM{user}.cnt", @{ $cd } );  

    fparse('_account_edited.htmlt');
  }

  mail($SENDMAIL, freadalls("$TDIR/_email_edit.etmpl"), \%TPL) if( $USE_EDIT_EMAIL );

}

sub sendPassword { 
  my $found = 0;

  derr(1000, $L_EMAIL) if( !$FRM{email} );
  
  for( @{ dread("$DDIR/members", '\.dat$') } ) {
    my $md = fsplit("$DDIR/members/$_");
    
    if( $$md[0] eq $FRM{email} ) {
      $found = 1;
      
      my $user = getUsername($_);

      $TPL{PASSWORD}    = $$md[18];
      $TPL{USERNAME}    = $user;
      $TPL{EMAIL}       = $FRM{email};
      $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
      $TPL{TRACK_URL}   = $IN_URL  . "?id=$user";
      $TPL{LOGIN_URL}   = $CGI_URL . "/accounts.cgi?login";
      
      mail($SENDMAIL, freadalls("$TDIR/_email_remind.etmpl"), \%TPL);
      last;
    }
  }

  derr(1013) if( !$found );  
  fparse('_account_reminded.htmlt');    
}

#Jackol

sub checkDuplicate {
  for( @{ dread("$DDIR/members", '\.dat') } ) {
    my $md = fsplit("$DDIR/members/$_");
    derr(1021) if( $FRM{surl} eq $$md[1] || $FRM{title} eq $$md[6] );
  }

 
  if( $USE_REVIEW ) {
    open(REV, "$DDIR/dbs/review.db") || err("$!", "$DDIR/dbs/review.db");
    for( <REV> ) {
      my @md = split(/\|/, $_);
      derr(1021) if( $FRM{surl} eq $md[2] || $FRM{title} eq $md[7] );
    }
    close(REV);
  }
}

sub checkInput {
  my $adding = shift;
  my $fe;
  derr(1012) if( $adding && (-e "$DDIR/members/$FRM{user}.dat" || dbselect("$DDIR/dbs/review.db", $FRM{user})) );

  checkBans();
  checkDuplicate() if( $adding && $USE_DUP_CHECK );

  derr(1009                 ) if( $FRM{email} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );
  derr(1010, $L_SITE_URL    ) if( $FRM{surl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
  derr(1010, $L_BANNER_URL  ) if( $FRM{burl} && $FRM{burl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
  derr(1010, $L_RECIP_URL   ) if( $USE_REQ_RECIP && $FRM{rurl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
  derr(1011, $L_SITE_TITLE  ) if( length( $FRM{title} ) > int( $TITLE_LEN ) );
  derr(1011, $L_SITE_DESC   ) if( length( $FRM{desc}  ) > int( $DESC_LEN  ) );
  derr(1015, $L_USERNAME    ) if( $adding && length( $FRM{user} ) < 4 );
  derr(1011, $L_USERNAME    ) if( $adding && length( $FRM{user} ) > 8 );
  derr(1014                 ) if( $FRM{user} !~ m/^[a-zA-Z0-9]+$/gi );
  derr(1015, $L_PASSWORD    ) if( length( $FRM{pass} ) < 4 );
  derr(1000, $L_SITE_TITLE  ) if( !$FRM{title} );
  derr(1000, $L_SITE_DESC   ) if( !$FRM{desc}  );
  derr(1000, $FIELD_1_NAME  ) if( $USE_REQ_FIELD_1 && !$FRM{fld1} );
  derr(1000, $FIELD_2_NAME  ) if( $USE_REQ_FIELD_2 && !$FRM{fld2} );
  derr(1000, $FIELD_3_NAME  ) if( $USE_REQ_FIELD_3 && !$FRM{fld3} );

  ## Make sure valid category was choosen
  if( $CATEGORIES ) {
    $found = 0;
    for( split(/,/, $CATEGORIES) ) {
      if( $FRM{cat} eq $_ ) {
        $found = 1;
        last;
      }
    }
    derr(1023) if( !$found );  ## Invalid category selected
  }


  ## Check URLs that were supplied
  if( $USE_URL_CHECK ) {
    GET($FRM{surl});
    GET($FRM{rurl}) if( $FRM{rurl} );
  }


  ## Download the banner if either option is enabled
  if( $FRM{burl} && ($USE_SERVE_BANNERS || $USE_CHECK_BANNERS) ) {
    fwrite("$IMAGE_DIR/$FRM{user}", ${GET($FRM{burl})});

    ## width height type
    my @dims = imgsize("$IMAGE_DIR/$FRM{user}");

    if( $dims[2] ne 'GIF' && $dims[2] ne 'JPG' ) {
      fremove("$IMAGE_DIR/$FRM{user}");
      derr(1024);  ## Invalid Image Format
    }

    if( -s "$IMAGE_DIR/$FRM{user}" > $BANNER_BYTES ) {
      fremove("$IMAGE_DIR/$FRM{user}");
      derr(1025, $BANNER_BYTES);  ## Banner byte size too large
    }

    $FRM{bwd} = $dims[0];
    $FRM{bht} = $dims[1];

    ## If serving banners from this server, get the proper extension, and setup the banner URL
    if( $USE_SERVE_BANNERS ) {
      $fe = lc($dims[2]);
      rename("$IMAGE_DIR/$FRM{user}", "$IMAGE_DIR/$FRM{user}.$fe");
      $FRM{burl} = "$IMAGE_URL/$FRM{user}.$fe";
    }
    else {
      fremove("$IMAGE_DIR/$FRM{user}");
    }
  }


  ## If banner URL is supplied, check height and widths
  if( $FRM{burl} ) {

    if( $FRM{bht} > $BANNER_HEIGHT ) {
      fremove("$IMAGE_DIR/$FRM{user}.$fe") if( -e "$IMAGE_DIR/$FRM{user}.$fe" );
      derr(1026, "$BANNER_WIDTH x $BANNER_HEIGHT");
    }

    if( $FRM{bwd} > $BANNER_WIDTH  ) {
      fremove("$IMAGE_DIR/$FRM{user}.$fe") if( -e "$IMAGE_DIR/$FRM{user}.$fe" );
      derr(1026, "$BANNER_WIDTH x $BANNER_HEIGHT");
    }

    $FRM{bht} = $BANNER_HEIGHT if( !$FRM{bht} );
    $FRM{bwd} = $BANNER_WIDTH  if( !$FRM{bwd} );
  }


  ## If no banner is supplied, but a default banner has been setup, use the default
  if( !$FRM{burl} && $DEF_BANNER ) {
    $FRM{burl} = $DEF_BANNER;
    $FRM{bht}  = $DEF_HEIGHT;
    $FRM{bwd}  = $DEF_WIDTH;
  }


  ## If forcing all banners to same size, do it
  if( $USE_FORCE_DIMS ) {
    $FRM{bht} = $BANNER_HEIGHT;
    $FRM{bwd} = $BANNER_WIDTH;
  }


  for( keys %FRM ) {
    $FRM{$_} =~ s/\|//g;
    $FRM{$_} =~ s/\r//g;
    $FRM{$_} =~ s/\n//g;
  }
}

sub accountData {
  $data = freadalls("$DDIR/vars.dat");

  print <<HTML;
<!--
$VERSION
$$data
#Jackol
-->
HTML

}

sub checkBans {
  my( @files ) = qw(IP.ban email.ban url.ban word.ban);
  my( $file, $ban );

  foreach $file ( @files ) {
    my $bans = freadall("$DDIR/dbs/$file");

    foreach $ban ( @{ $bans } ) {
      next if( $ban eq '' );
      chomp($ban = lc($ban));

      derr(1017                   ) if( $file eq "IP.ban"    && index($RMTADR,         $ban) != -1 );
      derr(1016, $L_DOMAIN        ) if( $file eq "url.ban"   && index(lc($FRM{surl}),  $ban) != -1 );
      derr(1016, $L_EMAIL         ) if( $file eq "email.ban" && index(lc($FRM{email}), $ban) != -1 );
      derr(1016, "$L_WORD '$ban'" ) if( $file eq "word.ban"  && index(lc($FRM{desc}),  $ban) != -1 );
      derr(1016, "$L_WORD '$ban'" ) if( $file eq "word.ban"  && index(lc($FRM{title}), $ban) != -1 );
    }  
  }
}

sub printStats {
  my $id = shift;
  open(FILE, "$DDIR/members/$id.sts") || err("$!", "$id.sts");
  for( reverse <FILE> ) {
    my @stats = split(/\|/, $_);
    next if( $#stats < 2 );

    my $age = $stats[11] - $stats[7];

    $TPL{DATE}          = $stats[0];
    $TPL{HITS_IN}       = int( $stats[1] * $stats[6] );
    $TPL{HITS_OUT}      = $stats[2];
    $TPL{TOTAL_IN}      = int( $stats[3] * $stats[6] );
    $TPL{TOTAL_OUT}     = $stats[4];    
    $TPL{IN_PER_DAY}    = getAvg($TPL{TOTAL_IN},  $age, 86400  );
    $TPL{IN_PER_WEEK}   = getAvg($TPL{TOTAL_IN},  $age, 604800 );
    $TPL{IN_PER_MONTH}  = getAvg($TPL{TOTAL_IN},  $age, 2592000);
    $TPL{OUT_PER_DAY}   = getAvg($TPL{TOTAL_OUT}, $age, 86400  );
    $TPL{OUT_PER_WEEK}  = getAvg($TPL{TOTAL_OUT}, $age, 604800 );
    $TPL{OUT_PER_MONTH} = getAvg($TPL{TOTAL_OUT}, $age, 2592000);
    $TPL{OVERALL_RANK}  = $stats[8];
    $TPL{CATEGORY_RANK} = $stats[9];

    fparse('_account_statsm.htmlt');
  }
  close(FILE);
}
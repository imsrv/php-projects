#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
#####################################################################
##  arp.pl - AutoRank Pro shared functions                         ##
#####################################################################

use lib '.';
use cgiworks;

$VERSION = '4.0.0';

require "$DDIR/vars.dat" if( -e "$DDIR/vars.dat" );
require "$DDIR/lang.dat";
require 'sort.pl';

1;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

sub doRerank {
  my $build = shift;
  my $now   = time;
  my $reset = freadline("$DDIR/times/reset");

  $FILTER = 1;
  &{$SORT_METHOD}('Overall');  
  my $ranked = scalar(@SORTED);

  fwrite("$DDIR/dbs/search");
  fwrite("$DDIR/dbs/sites");

  $TPL{MEMBERS}     = $TOTAL;
  $TPL{LAST_RERANK} = fdate($DATE_FORMAT, $now   + (3600 * $TIME_ZONE)          ) . ' ' . ftime($TIME_FORMAT, $now   + (3600 * $TIME_ZONE)          );
  $TPL{NEXT_RERANK} = fdate($DATE_FORMAT, $now   + (3600 * $TIME_ZONE) + $RERANK) . ' ' . ftime($TIME_FORMAT, $now   + (3600 * $TIME_ZONE) + $RERANK);
  $TPL{LAST_RESET}  = fdate($DATE_FORMAT, $reset + (3600 * $TIME_ZONE)          ) . ' ' . ftime($TIME_FORMAT, $reset + (3600 * $TIME_ZONE)          );
  $TPL{NEXT_RESET}  = fdate($DATE_FORMAT, $now   + (3600 * $TIME_ZONE) + $RESET ) . ' ' . ftime($TIME_FORMAT, $now   + (3600 * $TIME_ZONE) + $RESET );
  $TPL{CGI_URL}     = $CGI_URL;
  $TPL{CURRENT_CAT} = 'Overall';
  $TPL{CAT_OPTIONS} = getCatOptions();


  ## Build overall ranking pages
  for( split(/,/, $MAIN_PAGE_LIST) ) {
    my $page         = $_;
    my($start, $end) = split(/-/, $OVERALL{$page});
    
    require "$DDIR/html/$page";

    $TPL{ROW_COLOR} = $COLOR_1;

    getSOM($ranked);

    open(HTML, ">$HTML_DIR/$page") || err("$!", $page);
    vparse($HEAD, \*HTML);

    for( $i = $start; $i <= $end; $i++ ) {
      my $index = $i - 1;

      last if( !$USE_FILLER && $i > $ranked );  ## bail out if not using filler

      $TPL{OVERALL_RANK} = $i;

      ## Parse the template
      if( defined($SORTED[$index]) ) {

        $TPL{FONT_SIZE} = $FONT_HASH{$i} if( defined $FONT_HASH{$i} );
        
        rankingTemplate(getUsername($SORTED[$index]), $i, 1);

        vparse($TEMP, \*HTML);

        print HTML ${freadalls("$DDIR/breaks/$i.$RANKING_PAGE")} if( defined $BREAK_HASH{$i} && -e "$DDIR/breaks/$i.$RANKING_PAGE" );
      }


      ## Insert Filler HTML
      else {
        vparse($FILL, \*HTML);
        print HTML ${freadalls("$DDIR/breaks/$i.$RANKING_PAGE")} if( defined $BREAK_HASH{$i} && -e "$DDIR/breaks/$i.$RANKING_PAGE" );
      }

      $TPL{ROW_COLOR} = $TPL{ROW_COLOR} eq $COLOR_1 ? $COLOR_2 : $COLOR_1;
    }
    
    vparse($FOOT, \*HTML);

    close(HTML);

    mode(0666, "$HTML_DIR/$page");
  }
  ## End overall ranking page building



  ## Build category pages if option enabled
  if( $USE_CAT_PAGES && $build ) {

    for( 0..$TOTAL-1 ) { $cats{ (split(/\|/, $MEM{$SORTED[$_]}))[7] } .= "$_,"; }

    for( split(/,/, $CATEGORIES) ) {
      $TPL{CURRENT_CAT} = $_;
      my $cat_page      = HTMLName($TPL{CURRENT_CAT}, $FILE_EXT);

      eval("%hash = ( $CAT_HASH{$TPL{CURRENT_CAT}} );");

      for( split(/,/, $CAT_PAGES{$TPL{CURRENT_CAT}}) ) {
        my $page         = $_;
        my($start, $end) = split(/-/, $hash{$page});
        my @sites        = split(/,/, $cats{$TPL{CURRENT_CAT}});
        $ranked          = scalar(@sites);

        require "$DDIR/html/$page";

        $TPL{ROW_COLOR} = $COLOR_1;

        getSOM( $ranked, $cats{$TPL{CURRENT_CAT}} );

        open(HTML, ">$HTML_DIR/$page") || err("$!", $page);
        vparse($HEAD, \*HTML);

        for( $i = $start; $i <= $end; $i++ ) {
          my $index = $i - 1;

          last if( !$USE_C_FILLER && $i > $ranked );  ## bail out if not using filler

          $TPL{CATEGORY_RANK} = $i;          

          ## Parse the template
          if( defined($sites[$index]) ) {

            $TPL{FONT_SIZE}     = $C_FONT_HASH{$i} if( defined $C_FONT_HASH{$i} );
            $TPL{OVERALL_RANK}  = $sites[$index] + 1;
        
            rankingTemplate(getUsername($SORTED[$sites[$index]]), $i, 0);

            vparse($TEMP, \*HTML);

            print HTML ${freadalls("$DDIR/breaks/$i.$cat_page")} if( defined $C_BREAK_HASH{$i} && -e "$DDIR/breaks/$i.$cat_page" );
          }


          ## Insert Filler HTML
          else {
            vparse($FILL, \*HTML);
            print HTML ${freadalls("$DDIR/breaks/$i.$cat_page")} if( defined $C_BREAK_HASH{$i} && -e "$DDIR/breaks/$i.$cat_page" );
          }

          $TPL{ROW_COLOR} = $TPL{ROW_COLOR} eq $COLOR_1 ? $COLOR_2 : $COLOR_1;
        }  ## end for( $i = $start; $i <= $end; $i++ )
        
        vparse($FOOT, \*HTML);

        close(HTML);

        mode(0666, "$HTML_DIR/$page");        
      }
    }
  }
}

sub doReset {
  $FILTER = 0;
  &{$SORT_METHOD}('Overall');
  my( %cat_rank, $rank, @stats );
  my $time = time;
  my $date = fdate($DATE_FORMAT, $time + (3600 * $TIME_ZONE));

  for( @SORTED ) {
    my @cd   = split(/\|/, $MEM{$_});
    my $user = getUsername($_);
    $rank++; $cat_rank{$cd[7]}++;

    $cd[10]++ if( $cd[1] < 1 );  ## Update inactive count

    fjoin("$DDIR/members/$_", 0, 0, @cd[3..10]);
    my $md = fsplit("$DDIR/members/$user.dat");
    $$md[13] = $cd[0];
    $$md[14] = $cd[1] * $cd[6];
    $$md[15] = $cd[2];
    $$md[16] = $rank;
    $$md[17] = $cat_rank{$cd[7]};
    fjoin  ("$DDIR/members/$user.dat", @{ $md });
    fappend("$DDIR/members/$user.sts", "$date|$cd[1]|$cd[2]|$cd[3]|$cd[4]|$cd[5]|$cd[6]|$cd[9]|$rank|$cat_rank{$cd[7]}|$cd[8]|$time\n");

    $stats[0] += $cd[1];      # In
    $stats[1] += $cd[2];      # Out
    $stats[2] += $cd[3];      # Total in
    $stats[3] += $cd[4];      # Total out
    $stats[4]++ if( $cd[1] ); # Active accounts
  }
  fappend("$DDIR/stats", "$date|$stats[0]|$stats[1]|$stats[2]|$stats[3]|" . int($stats[4]) . "|" . getUsername($SORTED[0]) . "|$time\n");
}

sub rankingTemplate {
  my($user, $rank, $overall) = @_;
  my $md    = fsplit("$DDIR/members/$user.dat");
  my @cd    = split(/\|/, $MEM{"$user.cnt"});
  my $age   = time - $cd[9];
  my $join  = time - $$md[10];
  my $bans  = $C_NUM_BANNERS;
  my $prank = $$md[17];

  $TPL{CAT_PAGE_URL}  = "$HTML_URL/" . HTMLName($$md[8], $FILE_EXT);
  $TPL{USERNAME}      = $user;
  $TPL{SORT_VALUE}    = $cd[0];  
  $TPL{SITE_URL}      = $$md[1];
  $TPL{OUT_URL}       = "$OUT_URL?id=$user&url=" . urlencode($$md[1]);
  $TPL{TITLE}         = $$md[6];
  $TPL{DESCRIPTION}   = $$md[7];
  $TPL{CATEGORY}      = $$md[8];
  $TPL{ICONS}         = getIcons($$md[9]);
  $TPL{FIELD_1}       = $$md[23];
  $TPL{FIELD_2}       = $$md[24];
  $TPL{FIELD_3}       = $$md[25];
  $TPL{P_ALL_RANK}    = $$md[16];
  $TPL{P_CAT_RANK}    = $$md[17];
  $TPL{P_HITS_IN}     = $$md[14];
  $TPL{P_HITS_OUT}    = $$md[15];
  $TPL{P_SORT_VALUE}  = $$md[13];
  $TPL{HITS_IN}       = int($cd[1] * $cd[6]);
  $TPL{HITS_OUT}      = $cd[2];
  $TPL{TOTAL_IN}      = int($cd[3] * $cd[6]);
  $TPL{TOTAL_OUT}     = $cd[4];
  $TPL{IN_PER_DAY}    = getAvg($TPL{TOTAL_IN},  $age, 86400  );
  $TPL{IN_PER_WEEK}   = getAvg($TPL{TOTAL_IN},  $age, 604800 );
  $TPL{IN_PER_MONTH}  = getAvg($TPL{TOTAL_IN},  $age, 2592000);
  $TPL{OUT_PER_DAY}   = getAvg($TPL{TOTAL_OUT}, $age, 86400  );
  $TPL{OUT_PER_WEEK}  = getAvg($TPL{TOTAL_OUT}, $age, 604800 );
  $TPL{OUT_PER_MONTH} = getAvg($TPL{TOTAL_OUT}, $age, 2592000);
  $TPL{NEW_ICON}      = $join <= $DISPLAY_NEW ? $NEW_ICON : '';
  $TPL{BANNER_HTML}   = '';
  $TPL{MOVE_ICON}     = $SAME_IMAGE;

  if( $overall ) {
    $CRANK{$cd[7]}++;
    $TPL{CATEGORY_RANK} = $CRANK{$cd[7]};
    $bans               = $NUM_BANNERS;
    $prank              = $$md[16];
  }

  if( $overall || $TPL{OVERALL_RANK} > $SITES_TO_LIST ) {
    $$md[23] = ' ' if( !$$md[23] );
    $$md[24] = ' ' if( !$$md[24] );
    $$md[25] = ' ' if( !$$md[25] );
    fappend("$DDIR/dbs/sites",  "$user\n");
    fappend("$DDIR/dbs/search", join('|', $user, @cd, @{$md}, $TPL{OVERALL_RANK}, $TPL{CATEGORY_RANK}) . "\n") ;
  }

  if( $rank <= $bans ) {
    if( $$md[2] ) {
      $TPL{BANNER_HTML} = qq|<img src="$$md[2]"| . heightWidth( $$md[3], $$md[4] ) . qq| border="0" alt="$ALT_VALUE"><br>|;
    }
    elsif( $DEF_BANNER ) {
      $TPL{BANNER_HTML} = qq|<img src="$DEF_BANNER"| . heightWidth( $DEF_HEIGHT, $DEF_WIDTH ) . qq| border="0" alt="$ALT_VALUE"><br>|;
    }
  }

  if( $prank ne 'NA' ) {
    if( $prank > $rank ) {
      $TPL{MOVE_ICON} = $UP_IMAGE;
    }
    elsif( $prank < $rank ) {
      $TPL{MOVE_ICON} = $DOWN_IMAGE;
    }
  }

}

sub getSOM {
  my($max, $list) = @_;

  $TPL{SOM_OUT_URL}=$TPL{SOM_SITE_URL}=$TPL{SOM_TITLE}=$TPL{SOM_DESCRIPTION}=$TPL{SOM_ICONS}=$TPL{SOM_CATEGORY}=$TPL{SOM_BANNER_HTML}='';

  my $som  = freadalls("$DDIR/dbs/bdata");
  $$som    =~ tr/qwertyuiopasdfghjklzxcvbnm($&%#@*!/a-z <>\n:\/"=/;

  ${$O_REC_LONG} .= $$som;

  return if( !$max );

  srand();
  my $selected = int(rand($max));

  if( $list ) {
    my @sites = split(/,/, $list);
    $selected = $sites[$selected];
  }

  my $user = getUsername($SORTED[$selected]);
  my $md   = fsplit("$DDIR/members/$user.dat") if( -e "$DDIR/members/$user.dat" );

  $TPL{SOM_OUT_URL}     = "$OUT_URL?id=$user&url=" . urlencode($$md[1]);
  $TPL{SOM_SITE_URL}    = $$md[1];
  $TPL{SOM_TITLE}       = $$md[6];
  $TPL{SOM_DESCRIPTION} = $$md[7];
  $TPL{SOM_ICONS}       = getIcons($$md[9]);
  $TPL{SOM_CATEGORY}    = $$md[8];
  $TPL{SOM_BANNER_HTML} = '';

  if( $$md[2] ) {
    $TPL{SOM_BANNER_HTML} = qq|<img src="$$md[2]"| . heightWidth( $$md[3], $$md[4] ) . qq| border="0" alt="$ALT_VALUE"><br>|;
  } 
  elsif( $DEF_BANNER ) {
    $TPL{SOM_BANNER_HTML} = qq|<img src="$DEF_BANNER"| . heightWidth( $DEF_HEIGHT, $DEF_WIDTH ) . qq| border="0" alt="$ALT_VALUE"><br>|;
  }  
}

sub getAge {
  my $file = shift;
  return time - freadline($file);
}

sub getCatOptions {
  my $cat = shift;
  my $html;

  for( split(',', $CATEGORIES) ) {
    $html .= $cat eq $_ ? qq|<option value="$_" selected>$_</option>\n| : qq|<option value="$_">$_</option>\n|;
  }

  return $html;
}

#Jackol

sub getUsername {
  my $string = shift;
  return substr($string, 0, rindex($string, '.'));
}

sub getAvg {
  my( $cnt, $age, $len ) = @_;
  return sprintf("%.$DECIMALS" . "f", $age >= $len ? $cnt / ($age / $len) : $cnt);
}

sub heightWidth {
  my( $ht, $wd ) = @_;
  return if( !$ht || !$wd );
  return qq| height="$ht" width="$wd"|;
}

sub HTMLName {
  my($name, $fe) = @_;
  $name =~ s/\W//g;
  return lc($name) . ".$fe";
}

sub getIcons {
  my($icons, $html) = shift;
  for( split(/,/, $icons) ) {
    next if( !$_ || (!-e "$DDIR/icons/$_"));
    $html .= ${ freadalls("$DDIR/icons/$_") } . '&nbsp;';
    $html =~ s/\n&nbsp;/&nbsp;/g;
  }
  $html =~ s/&nbsp;$//g;
  return $html;
}
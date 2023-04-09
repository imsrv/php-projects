#!/usr/bin/perl
###########################
##  AutoRank Pro v4.0.x  ##
##########################################################
##  admin.cgi - control administration of AutoRank Pro  ##
##########################################################

BEGIN {
  chdir('..');
}

use lib '.';
use cgiworks;
use imgsize;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require 'arp.pl';
  require 'http.pl';
  main();
};

err("$@", 'admin.cgi') if( $@ );
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
  derr(1006) if( !-e "$DDIR/vars.dat" );  
  diskspace("$DDIR/test");

  $FILTER            = 0;
  $TPL{FIELD_1_NAME} = $FIELD_1_NAME;
  $TPL{FIELD_2_NAME} = $FIELD_2_NAME;
  $TPL{FIELD_3_NAME} = $FIELD_3_NAME;
  $TPL{APWD}         = $FRM{apwd};
  $TPL{BACK}         = qq|<font face="Verdana" size="2" style="font-size: 11px;"><b><a href="admin.cgi" class="reg">Back To Main Page</a></b></font>|;

  if( $REQMTH eq 'GET' ) {
    displayMain();
  }

  else {
    parsepost();
    derr(1008) if( !$FRM{run} );
    &{$FRM{run}};
  }
}

sub displayMain {
  $TPL{MESSAGE}   = shift;
  $TPL{VERSION}   = $VERSION;
  $TPL{MEMBERS}   = scalar( @{ dread("$DDIR/members", '\.dat') } );
  $TPL{REVIEW}    = $USE_REVIEW ? dbsize("$DDIR/dbs/review.db") : 'NA';
  $TPL{RR_FROM}   = freadline("$DDIR/times/rerank.frm");
  $TPL{RS_FROM}   = freadline("$DDIR/times/reset.frm" );
  $TPL{LAST_RR}   = timetostr( getAge("$DDIR/times/rerank") );
  $TPL{LAST_RS}   = timetostr( getAge("$DDIR/times/reset" ) );
  $TPL{LAST_BU}   = timetostr( getAge("$DDIR/times/backup") );
  $TPL{BREAKS}    = getCatOptions() if( $USE_CAT_PAGES );
  $TPL{CAT_OPT}   = getCatOptions();
  $TPL{MAIN_PAGE} = "$HTML_URL/$RANKING_PAGE";
  $TPL{PAGES}     = getPages();

  if( getAge("$DDIR/times/backup") >= 259200 ) {
    $TPL{REMIND}  = 'A database backup is recommended';
    $TPL{COLOR}   = '#FF0000';
  }

  fparse('_admin_main.htmlt');
}

sub displayHTML {
  require "$DDIR/html/$FRM{hpages}";

  stripHTML(\$HEAD);
  stripHTML(\$TEMP);
  stripHTML(\$FILL);
  stripHTML(\$FOOT);

  $TPL{HEAD}    = $HEAD;
  $TPL{TEMP}    = $TEMP;
  $TPL{FILL}    = $FILL;
  $TPL{FOOT}    = $FOOT;
  $TPL{PAGE}    = $FRM{hpages};
  $TPL{OVERALL} = $MAIN_PAGE_LIST;

  if( $USE_CAT_PAGES ) {
    $TPL{ALL}      = qq|<option value="$MAIN_PAGE_LIST,$CAT_PAGE_LIST">All Pages</option>\n|;
    $TPL{CATEGORY} = qq|<option value="$CAT_PAGE_LIST">All Category Pages</option>\n|;
  }

  fparse('_admin_html.htmlt');
}

sub displayBreaks {
  my($msg, $html) = @_;

  $TPL{MESSAGE} = $msg;
  $TPL{PAGE}    = $FRM{bpages};
  $TPL{OPTIONS} = getBreakOptions($FRM{loc});
  $TPL{HTML}    = $$html if( defined $html );

  fparse('_admin_breaks.htmlt');
}

sub displayIcons {
  my($msg, $html) = @_;

  $TPL{MESSAGE} = $msg;
  $TPL{HTML}    = $$html if( defined $html );
  $TPL{ICON_ID} = $FRM{id};

  fparse('_admin_iconst.htmlt');
  printIcons();
  fparse('_admin_iconsb.htmlt');
}

sub displaySearch {
  derr(1000, "No Search Term Entered") if( !$FRM{key} );

  $TPL{MESSAGE} = shift;
  $TPL{KEY}     = $FRM{key};

  fparse('_admin_searcht.htmlt');
  printSearch($FRM{key});
  fparse('_admin_searchb.htmlt');
}

sub displayAll {
  &{$FRM{sort}}($FRM{scat});

  $FRM{page} = 0 if( $FRM{page} < 0 );

  $TPL{MESSAGE} = shift;
  $TPL{GROUP}   = $FRM{scat};
  $TPL{SHOW}    = $FRM{show};
  $TPL{SORT}    = $FRM{sort};
  $TPL{TOTAL}   = scalar(@SORTED);
  $TPL{START}   = getStart($TPL{TOTAL}, $FRM{show});
  $TPL{END}     = getEnd($TPL{TOTAL}, $FRM{show}, $TPL{START});
  $TPL{NEXT}    = $TPL{TOTAL} > $TPL{END} ? qq|<option value="displayAll">Display Next Page</option>| : '';
  $TPL{PAGE}    = $FRM{page} + 1;
  $TPL{JUMP}    = getJump($TPL{TOTAL}, $FRM{show});

  fparse('_admin_allt.htmlt');
  printAll() if( $TPL{TOTAL} );
  fparse('_admin_allb.htmlt');
}

sub displayMember {
  my $id = (split(/,/, $FRM{id}))[0];
  derr(1000, "No Member Selected") if( !$id );
  derr(1018) if( !-e "$DDIR/members/$id.dat" );

  $TPL{FROM}  = $FRM{from};
  $TPL{PAGE}  = $FRM{page};
  $TPL{SORT}  = $FRM{sort};
  $TPL{GROUP} = $FRM{scat};
  $TPL{SHOW}  = $FRM{show};
  $TPL{KEY}   = $FRM{key};

  memberTemplate($id);
  fparse('_admin_member.htmlt');
}

sub displayEditMember {
  my $id = (split(/,/, $FRM{id}))[0];
  derr(1000, "No Member Selected") if( !$id );
  derr(1018) if( !-e "$DDIR/members/$id.dat" );

  $TPL{FROM}  = $FRM{from};
  $TPL{SORT}  = $FRM{sort};
  $TPL{GROUP} = $FRM{scat}; 
  $TPL{KEY}   = $FRM{key};
  $TPL{SHOW}  = $FRM{show};
  $TPL{PAGE}  = $FRM{page};

  memberTemplate($id);

  fparse('_admin_editmem.htmlt');
}

sub displayEditRev {
  derr(1000, "No Account Selected") if( !$FRM{id} );
  my $id = (split(/,/, $FRM{id}))[0];
  my $md = dbselect("$DDIR/dbs/review.db", $id);

  $TPL{USERNAME}    = $id;
  $TPL{PASSWORD}    = $$md[19];
  $TPL{SITE_URL}    = $$md[2];
  $TPL{TITLE}       = $$md[7];
  $TPL{DESCRIPTION} = $$md[8];
  $TPL{RECIP_URL}   = $$md[6];
  $TPL{BANNER_URL}  = $$md[3];
  $TPL{HEIGHT}      = $$md[4];
  $TPL{WIDTH}       = $$md[5];
  $TPL{CAT_OPTIONS} = getCatOptions($$md[9]);
  $TPL{EMAIL}       = $$md[1];
  $TPL{FIELD_1}     = $$md[24];
  $TPL{FIELD_2}     = $$md[25];
  $TPL{FIELD_3}     = $$md[26];

  fparse('_admin_editrev.htmlt');
}

sub displayRevNew {
  derr(1030) if( !$USE_REVIEW );
  
  $TPL{MESSAGE} = shift;

  fparse('_admin_revnewt.htmlt');
  printRevNew();
  fparse('_admin_revnewb.htmlt');
}

sub displayReject {
  my($msg, $html) = @_;

  derr(1030) if( !$USE_REVIEW );

  $TPL{MESSAGE}   = $msg;
  $TPL{HTML}      = $$html if( defined $html );
  $TPL{REJECT_ID} = $FRM{id};

  fparse('_admin_reject.htmlt');
  printReject();
}

sub displayRevEdit {
  derr(1031) if( !$USE_REV_EDIT );

  $TPL{MESSAGE} = shift;

  fparse('_admin_reveditt.htmlt');
  printRevEdit();
  fparse('_admin_reveditb.htmlt');
}

sub displayTemplate {
  $line = freadalls("$TDIR/$FRM{template}");
  stripHTML($line);

  $TPL{HTML}     = $$line;
  $TPL{TEMPLATE} = $FRM{template};
 
  fparse('_admin_template.htmlt');
}

sub displayBans {
  $TPL{MESSAGE} = shift;
  $TPL{EMAIL}   = ${ freadalls("$DDIR/dbs/email.ban") };
  $TPL{DOMAIN}  = ${ freadalls("$DDIR/dbs/url.ban"  ) };
  $TPL{WORD}    = ${ freadalls("$DDIR/dbs/word.ban" ) };
  $TPL{IP}      = ${ freadalls("$DDIR/dbs/IP.ban"   ) };
  fparse('_admin_bans.htmlt');
}

sub displayEmails {
  my %key = ( '\n' => "\n", '\t' => "\t", '\r\n' => "\r\n");
  my $del = $key{$FRM{ch}} ? $key{$FRM{ch}} : $FRM{ch};

  print "<pre>\n" if( !$FRM{file} );
  fwrite("$DDIR/emails.txt", '') if( $FRM{file} );
  for( @{ dread("$DDIR/members", '\.dat$') } ) {
    if( $FRM{file} ) {
      fappend("$DDIR/emails.txt", @{ fsplit("$DDIR/members/$_") }[0] . $del);
    } else {
      print @{ fsplit("$DDIR/members/$_") }[0] . $del;
    }
  }

  displayMain("E-mails written to emails.txt in the data directory") if( $FRM{file} );
}

sub displayGate {
  $TPL{URL}       = '#%URL%#';
  $TPL{SESSION}   = '#%SESSION%#';
  $TPL{USERNAME}  = '#%USERNAME%#';
  $TPL{DDIR}      = $DDIR;
  fparse('_admin_gate.htmlt');
}

sub displayStats {

  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    my $cd = fsplit("$DDIR/members/$_");
    $TPL{HITS_IN}   += $$cd[0];
    $TPL{HITS_OUT}  += $$cd[1];
    $TPL{TOTAL_IN}  += $$cd[2];
    $TPL{TOTAL_OUT} += $$cd[3];
  }

  my $start  = freadline("$DDIR/times/start");
  my $reset  = freadline("$DDIR/times/reset");
  my $treset = freadline("$DDIR/times/treset");
  my $age    = time - $treset;

  $TPL{START_DATE}    = fdate($DATE_FORMAT, $start  + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $start  + ($TIME_ZONE * 3600));
  $TPL{TOTAL_RESET}   = fdate($DATE_FORMAT, $treset + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $treset + ($TIME_ZONE * 3600));
  $TPL{INOUT_RESET}   = fdate($DATE_FORMAT, $reset  + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $reset  + ($TIME_ZONE * 3600));
  $TPL{IN_PER_DAY}    = getAvg($TPL{TOTAL_IN},  $age, 86400  );
  $TPL{IN_PER_WEEK}   = getAvg($TPL{TOTAL_IN},  $age, 604800 );
  $TPL{IN_PER_MONTH}  = getAvg($TPL{TOTAL_IN},  $age, 2592000);
  $TPL{OUT_PER_DAY}   = getAvg($TPL{TOTAL_OUT}, $age, 86400  );
  $TPL{OUT_PER_WEEK}  = getAvg($TPL{TOTAL_OUT}, $age, 604800 );
  $TPL{OUT_PER_MONTH} = getAvg($TPL{TOTAL_OUT}, $age, 2592000);

  fparse('_admin_statst.htmlt');
  printStats();
  fparse('_admin_statsb.htmlt');
}

sub displayCheatLog {
  my $count = 0;
  my $size  = (-s "$DDIR/cheat.log");

  $TPL{SIZE} = sprintf("%.2f%s", $size < 1048576 ? ($size/1024, 'kb') : ($size/1024/1024, 'mb'));

  fparse('_admin_cheatt.htmlt');  

  open(LOG, "$DDIR/cheat.log") || err("$!", 'cheat.log');
  for( reverse <LOG> ) {
    last if( $count > 100 );
    print;
    $count++;
  }
  close(LOG);

  fparse('_admin_cheatb.htmlt');
}

sub displayMail {
  $FRM{id} = 'All' if( $FRM{all} && $FRM{run} ne 'processInactive' );
  derr(1000, "No Members To Mail") if( !$FRM{id} );

  $TPL{SEND}  = $TPL{TO} = $FRM{id};
  $TPL{SEND}  =~ s/,/, /g;
  $TPL{FROM}  = $FRM{from};
  $TPL{SORT}  = $FRM{sort};
  $TPL{GROUP} = $FRM{scat}; 
  $TPL{KEY}   = $FRM{key};
  $TPL{SHOW}  = $FRM{show};
  $TPL{PAGE}  = $FRM{page};

  fparse('_admin_mail.htmlt');
}

sub displayLang {
  require "$DDIR/errors.dat";

  %TPL = %error;

  for( @{ freadall("$DDIR/lang.dat") } ) {
    $_ =~ /\$([^\s]+)/;
    $TPL{$1} = ${$1};
  }

  for( keys %TPL ) {
    stripHTML(\$TPL{$_});
  }

  fparse('_admin_lang.htmlt');
}

sub displayListEmails {
  fparse('_admin_emails.htmlt');
}

sub displayChangePass {
  fparse('_admin_chpass.htmlt');
}

sub displayBackup {
  fparse('_admin_backup.htmlt');
}

#####################################################################

sub backupData
{
    derr(1000, 'Backup Filename') if( !$FRM{file} );
    fwrite("$DDIR/$FRM{file}");

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        my @dirs = qw( html icons breaks dbs members mails times );

        foreach $dir ( @dirs )
        { 
            for( @{ dread("$DDIR/$dir", '^[^.]') } )
            {
                fappend("$DDIR/$FRM{file}", "Database: $dir/$_\n<<<");
                open(DB, "$DDIR/$dir/$_") || err("$!", "$DDIR/$dir/$_");
                flock(DB, $LOCK_EX);
                while( <DB> )
                {
                    fappend("$DDIR/$FRM{file}", $_);
                }
                fappend("$DDIR/$FRM{file}", ">>>\n");
                flock(DB, $LOCK_UN);
                close(DB);
            }
        }
    }
    else
    {
        fwrite("$DDIR/times/backup", time);
        displayMain("Databases are now being backed up.<br>Allow at least 60 seconds for this process to complete.");
    }
}

sub restoreData
{
    derr(1000, 'Backup Filename') if( !$FRM{file} );
    freadline("$DDIR/$FRM{file}");

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;
        
        open(BAK, "$DDIR/$FRM{file}") || err("$!", "$DDIR/$FRM{file}");

        while( <BAK> )
        {
            $line = $_;

            if( $line =~ /^Database:\s(.+)$/ )
            {
                $file = $1;
                fwrite("$DDIR/$file");
            }
            else
            {
                if( $line =~ /^<<<(.*?)>>>$/s )
                {
                    fappend("$DDIR/$file", $1);
                }
                elsif( $line =~ /^<<<(.*)/s )
                {
                    fappend("$DDIR/$file", $1);
                }
                elsif( $line =~ /(.*?)>>>$/s )
                {
                    fappend("$DDIR/$file", $1);
                }
                else
                {
                    fappend("$DDIR/$file", $line);
                }
            }
        }

        close(BAK);
    }
    else
    {
        displayMain("Databases are now being restored.<br>Allow at least 60 seconds for this process to complete.");
    }
}

sub sendMail {
  derr(1000, 'Subject') if( !$FRM{sub} );
  derr(1000, 'Message') if( !$FRM{msg} );
  $FRM{to} eq 'All' ? forkMail() : regularMail();
}

sub forkMail {
  my $pid = fork();

  if( !$pid ) {
    close STDIN; close STDOUT; close STDERR;
    for( @{ dread("$DDIR/members", '\.dat$') } ) {
      my $id  = getUsername($_);
      memberTemplate($id);
      my $msg = qq|To: $TPL{EMAIL}\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{msg}|;
      mail($SENDMAIL, \$msg, \%TPL);
    }
  }
  else {
    displayMain("Accounts Have Been E-mailed");    
  }
}

sub regularMail {
  for( split(/,/, $FRM{to}) ) {
    memberTemplate($_);
    my $msg = qq|To: $TPL{EMAIL}\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{msg}|;
    mail($SENDMAIL, \$msg, \%TPL);
  }
  
  $FRM{page}--;

  &{$FRM{from}}("Accounts Have Been E-mailed");
}

sub resetList {
  doReset();
  fwrite("$DDIR/times/reset.frm", 'Manual');
  fwrite("$DDIR/times/reset", time);
  displayMain("List Has Been Reset");
}

sub rerankList {
  doRerank(1);
  fwrite("$DDIR/times/rerank.frm", 'Manual');
  fwrite("$DDIR/times/rerank", time);
  displayMain("List Has Been Reranked");
}

sub restoreDefault {
  my $def = freadalls("$DDIR/def.html");
  for( split(/,/, $MAIN_PAGE_LIST) ) {
    fwrite("$DDIR/html/$_", $$def );
  }

  for( split(/,/, $CAT_PAGE_LIST) ) {
    fwrite("$DDIR/html/$_", $$def );
  }

  displayMain("Default Template Has Been Restored");
}

sub createGate {
  $FRM{html} =~ s/\r//g;
  $FRM{html} =~ s/\@/\\\@/g;
  $FRM{html} =~ s/\$/\\\$/g;
  $FRM{html} =~ s/#%URL%#/\$IN_URL/gi;
  $FRM{html} =~ s/#%USERNAME%#/\$QRY{id}/gi;
  $FRM{html} =~ s/#%SESSION%#/\$ses/gi;
  $TPL{HTML} = $FRM{html};

  open(CGI, ">$DDIR/rankem.cgi") || err("$!", "$DDIR/rankem.cgi");
  fparse('_rankem.cgit', \*CGI);
  close(CGI);
  mode(0666, "$DDIR/rankem.cgi");

  displayMain("Custom version of rankem.cgi has been created");
}

## Edit list break functions
sub loadBreak {
  my $file = $FRM{bpages} eq 'Overall' ? "$FRM{loc}.$RANKING_PAGE" : $FRM{loc} . '.' . HTMLName($FRM{bpages}, $FILE_EXT);
  my $html = freadalls("$DDIR/breaks/$file") if( -e "$DDIR/breaks/$file");
  displayBreaks("Loaded HTML for position $FRM{loc} in $FRM{bpages}", $html);
}

sub saveBreak {
  my $file = $FRM{bpages} eq 'Overall' ? $RANKING_PAGE : HTMLName($FRM{bpages}, $FILE_EXT);
  my $for  = "Position $FRM{loc}";
  my $brk  = $FRM{loc};

  $FRM{html} =~ s/\r|\n$//g;

  if( $FRM{all} ) {
    $brk = $FRM{bpages} eq 'Overall' ? $BREAK_LIST : $C_BREAK_LIST;
    $for = "All Breaks";
  }

  for( split(/,/, $brk) ) {
    if( $FRM{html} =~ /^\s*$/s ) {
      fremove("$DDIR/breaks/$_.$file") if( -e "$DDIR/breaks/$_.$file");
    }
    else {
      fwrite("$DDIR/breaks/$_.$file", $FRM{html} . "\n");
    }
  }

  displayBreaks("HTML Saved For $for in $FRM{bpages}");
}


##  Edit icon functions 
sub deleteIcon {
  derr(1027) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}" );
  fremove("$DDIR/icons/$FRM{id}");
  delete $FRM{id};
  displayIcons("Selected Icon Has Been Deleted");
}

sub loadIcon {
  derr(1027) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}");
  displayIcons("Loaded Icon With ID '$FRM{id}'", freadalls("$DDIR/icons/$FRM{id}"));
}

sub saveIcon {
  derr(1027) if( !$FRM{id} );
  $FRM{id}   =~ s/ /_/g;
  $FRM{html} =~ s/\r|\n$//g;
  fwrite("$DDIR/icons/$FRM{id}", $FRM{html} . "\n");
  delete $FRM{id};
  displayIcons("Icon Data Has Been Saved");
}


##  Edit Rejection e-mail functions 
sub deleteReject {
  derr(1027) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id} );
  fremove("$DDIR/mails/$FRM{id}");
  delete $FRM{id};
  displayReject("Selected Rejection E-mail Has Been Deleted");
}

sub loadReject {
  derr(1027) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id});
  displayReject("Loaded Rejection E-mail With ID '$FRM{id}'", freadalls("$DDIR/mails/$FRM{id}"));
}

sub saveReject {
  derr(1027) if( !$FRM{id} );
  $FRM{id}   =~ s/ /_/g;
  $FRM{html} =~ s/\r|\n$//g;
  fwrite("$DDIR/mails/$FRM{id}", $FRM{html} . "\n");
  delete $FRM{id};
  displayReject("Rejection E-mail Has Been Saved");
}


##  Edit Blacklist Functions
sub addBan {
  $FRM{ban} =~ s/\r//g;
  derr(1028) if( !$FRM{ban} || $FRM{ban} =~ /^\n/m );
  $DEL = "\n";
  dbinsert("$DDIR/dbs/$FRM{type}.ban", $FRM{ban});
  displayBans("$FRM{ban} Added To the $FRM{type} Blacklist");
}

sub removeBan {
  $FRM{ban} =~ s/\r//g;

  $DEL = "\n";
  for( split(/\n/, $FRM{ban}) ) {
    dbdelete("$DDIR/dbs/$FRM{type}.ban", $_);
  }

  displayBans("$FRM{ban} removed from the $FRM{type} blacklist");
}

sub saveLangSettings {
  delete $FRM{run};

  fwrite("$DDIR/errors.dat");
  fwrite("$DDIR/lang.dat");

  for( sort keys %FRM ) {
    $FRM{$_} =~ s/"/\\"/g;

    if( index($_, 'L_') == 0 ) {
      fappend("$DDIR/lang.dat", "\$$_ = \"$FRM{$_}\";\n");
    }
    else {
      fappend("$DDIR/errors.dat", "\$error{$_} = \"$FRM{$_}\";\n");
    }
  }

  fappend("$DDIR/errors.dat", "\n1;\n");
  fappend("$DDIR/lang.dat", "\n1;\n");

  displayMain("Language settings have been updated");
}

sub updatePassword {
  derr(1000, 'Username') if( !$FRM{newuser} );
  derr(1000, 'Password') if( !$FRM{newpass} );

  fwrite('./admin/.htpasswd', "$FRM{newuser}:" . crypt($FRM{newpass}, getsalt())) if( $RMTUSR );
  fwrite("$DDIR/admin.epf", crypt($FRM{newpass}, getsalt()));
  $TPL{APWD} = $FRM{newpass};

  displayMain('Administrative username/password has been updated');
}


sub updateHTML {
  $FRM{head} =~ s/\r|\n$//g;
  $FRM{foot} =~ s/\r|\n$//g;
  $FRM{temp} =~ s/\r|\n$//g;
  $FRM{fill} =~ s/\r|\n$//g;
  
  for( split(/,/, $FRM{pages}) ) {
    fwrite("$DDIR/html/$_", qq|\$HEAD = <<'HEAD';\n$FRM{head}\nHEAD\n\n\$FOOT = <<'FOOT';\n$FRM{foot}\nFOOT\n\n\$FILL = <<'FILL';\n$FRM{fill}\nFILL\n\n\$TEMP = <<'TEMP';\n$FRM{temp}\nTEMP\n\n1;\n|);
  }

  displayMain("HTML successfully updated");
}

sub updateTemplate {
  $FRM{html} =~ s/\r//gi;
  $FRM{html} =~ s/\r|\n$//g;

  fwrite("$TDIR/$FRM{template}", $FRM{html});
  displayMain("The $FRM{template} template has been updated");
}

sub updateAccount {
  my $id = $FRM{id};
  my $cd = fsplit("$DDIR/members/$id.cnt");
  my $md = fsplit("$DDIR/members/$id.dat");

  for( keys %FRM ) {
    stripHTML(\$FRM{$_}, 1);
  }

  ## Download the banner if either option is enabled
  if( $FRM{burl} && $USE_SERVE_BANNERS ) {
    fwrite("$IMAGE_DIR/$FRM{id}", ${GET($FRM{burl})});

    ## width height type
    my @dims = imgsize("$IMAGE_DIR/$FRM{id}");

    if( $dims[2] ne 'GIF' && $dims[2] ne 'JPG' ) {
      fremove("$IMAGE_DIR/$FRM{id}");
      derr(1024);  ## Invalid Image Format
    }

    $fe = lc($dims[2]);
    rename("$IMAGE_DIR/$FRM{id}", "$IMAGE_DIR/$FRM{id}.$fe");
    $FRM{burl} = "$IMAGE_URL/$FRM{id}.$fe";
  }

  ## If forcing all banners to same size, do it
  if( $USE_FORCE_DIMS ) {
    $FRM{bht} = $BANNER_HEIGHT;
    $FRM{bwd} = $BANNER_WIDTH;
  }

  $$md[0]  = $FRM{mail};
  $$md[1]  = $FRM{surl};
  $$md[2]  = $FRM{burl};
  $$md[3]  = $FRM{bht};
  $$md[4]  = $FRM{bwd};
  $$md[5]  = $FRM{rurl};
  $$md[6]  = $FRM{titl};
  $$md[7]  = $FRM{desc};
  $$md[8]  = $FRM{cat};
  $$md[9]  = $FRM{icon};
  $$md[12] = $FRM{rat};
  $$md[18] = $FRM{pass};  
  $$md[20] = $FRM{susp};
  $$md[21] = $FRM{lock};
  $$md[22] = $FRM{inac};  
  $$md[23] = $FRM{fld1};
  $$md[24] = $FRM{fld2};
  $$md[25] = $FRM{fld3};

  $$cd[0]  = $FRM{rhin};
  $$cd[1]  = $FRM{hout};
  $$cd[2]  = $FRM{rtin};
  $$cd[3]  = $FRM{tout};
  $$cd[5]  = $FRM{rat};
  $$cd[6]  = $FRM{cat};
  $$cd[7]  = $FRM{susp};

  fjoin("$DDIR/members/$id.cnt", @{ $cd });
  fjoin("$DDIR/members/$id.dat", @{ $md });

  $FRM{page}--;

  &{$FRM{from}}("Account '$id' Has Been Updated");
}

sub updateReview {
  my $id = $FRM{id};
  my $md = dbselect("$DDIR/dbs/review.db", $id);

  for( keys %FRM ) {
    stripHTML(\$FRM{$_}, 1);
  }

  $$md[1]  = $FRM{mail};
  $$md[2]  = $FRM{surl};
  $$md[3]  = $FRM{burl};
  $$md[4]  = $FRM{bht};
  $$md[5]  = $FRM{bwd};
  $$md[6]  = $FRM{rurl};
  $$md[7]  = $FRM{titl};
  $$md[8]  = $FRM{desc};
  $$md[9]  = $FRM{cat};
  $$md[19] = $FRM{pass};
  $$md[24] = $FRM{fld1};
  $$md[25] = $FRM{fld2};
  $$md[26] = $FRM{fld3};

  dbupdate("$DDIR/dbs/review.db", $id, @{ $md });

  displayRevNew("Account '$id' Has Been Updated");
}

sub clearMemberStats {
  for( @{ dread("$DDIR/members", '\.sts$') } ) {
    fwrite("$DDIR/members/$_");
  }
  displayMain("Member Stats Files Have Been Cleared");
}

sub clearAdminStats {
  fwrite("$DDIR/stats");
  displayMain("Administrative Stats Have Been Cleared")
}

sub resetTotals {
  my $time = time;

  for( @{dread("$DDIR/members", '\.cnt')} ) {
    my $id = getUsername($_);

    my $cd = fsplit("$DDIR/members/$id.cnt");

    $$cd[2] = 0;
    $$cd[3] = 0;
    $$cd[8] = $time;

    fjoin("$DDIR/members/$id.cnt", @{$cd});

    my $md = fsplit("$DDIR/members/$id.dat");

    $$md[11] = $time;

    fjoin("$DDIR/members/$id.dat", @{$md});
  }

  fwrite("$DDIR/times/treset", time);

  displayMain("Total hit counts have been reset to zero");
}

sub clearIPs {
  for( 1..255 ) {
    open(FILE, ">$DDIR/ips/$_") || err("$!", "$DDIR/ips/$_");
    close(FILE);
  }
  displayMain("IP Logs Have Been Cleared");
}

sub clearCheatLog {
  fwrite("$DDIR/cheat.log");
  displayMain("Cheat Log Has Been Cleared");
}

sub deleteMember {
  derr(1000, 'No Member Selected') if( !$FRM{id} );

  $DEL = "\n";
  for( split(/,/, $FRM{id}) ) {
    fremove ("$DDIR/members/$_.dat");
    fremove ("$DDIR/members/$_.cnt");
    fremove ("$DDIR/members/$_.sts");
    dbdelete("$DDIR/dbs/sites", $_ );
    dbdelete("$DDIR/dbs/search", $_ );
    unlink  ("$IMAGE_DIR/$_.gif"   );
    unlink  ("$IMAGE_DIR/$_.jpg"   );
  }

  $FRM{page}--;

  &{$FRM{from}}("Account(s) $FRM{id} Have Been Deleted");
}

sub lock {
  adjust("$FRM{id}.dat", 21, 1);
  &{$FRM{from}}("Account '$FRM{id}' Has Been Locked");
}

sub unlock {
  adjust("$FRM{id}.dat", 21, 0);
  &{$FRM{from}}("Account '$FRM{id}' Has Been Unlocked");
}

sub suspend {
  $DEL = "\n";
  adjust("$FRM{id}.dat", 20, 1);
  adjust("$FRM{id}.cnt", 7, 1);
  $DEL = '|';
  &{$FRM{from}}("Account '$FRM{id}' Has Been Suspended");
}

sub activate {
  adjust("$FRM{id}.dat", 20, 0);
  adjust("$FRM{id}.cnt", 7, 0);

  my $md = fsplit("$DDIR/members/$FRM{id}.dat");

  &{$FRM{from}}("Account '$FRM{id}' Has Been Reactivated");
}

sub processInactive {
  derr(1029) if( $FRM{inact} < 1 );

  for( @{ dread("$DDIR/members", '\.cnt$') } ) {
    my $cd = fsplit("$DDIR/members/$_");

    if( $$cd[9] >= $FRM{inact} ) {
      my $id = getUsername($_);
      $FRM{id} .= "$id,";
    }
  }
  $FRM{id} =~ s/,$//;

  if( $FRM{id} ) {
    &{$FRM{what}};
  }
  else {
    displayMain("No accounts have been inactive for $FRM{inact} or more resets");
  }
}

sub adjust {
  my( $id, $key, $val ) = @_;
  my $md = fsplit("$DDIR/members/$id");
  $$md[$key] = $val;
  fjoin("$DDIR/members/$id", @{ $md });
}

sub execute {
  derr(1008) if( !$FRM{function} );
  &{$FRM{function}};
}

sub approveEdit {
  for( split(/,/, $FRM{id}) ) {
    my $user = $_;
    my $new = dbselect("$DDIR/dbs/edit.db", $user);
    next if( !$new );
    my $md  = fsplit("$DDIR/members/$user.dat");
    my $cd  = fsplit("$DDIR/members/$user.cnt");

    chomp @{ $new };

    $$md[0]  = $$new[1];
    $$md[1]  = $$new[2];
    $$md[2]  = $$new[3];
    $$md[3]  = $$new[4];
    $$md[4]  = $$new[5];
    $$md[5]  = $$new[6];
    $$md[6]  = $$new[7];
    $$md[7]  = $$new[8];
    $$md[8]  = $$cd[6] = $$new[9];
    $$md[18] = $$new[10];
    $$md[23] = $$new[11];
    $$md[24] = $$new[12];
    $$md[25] = $$new[13];

    fjoin("$DDIR/members/$user.dat", @{$md});
    fjoin("$DDIR/members/$user.cnt", @{$cd});
    dbdelete("$DDIR/dbs/edit.db", $user);
  }
  displayRevEdit("Selected edits have been approved");
}

sub rejectEdit {
  for( split(/,/, $FRM{id}) ) {
    dbdelete("$DDIR/dbs/edit.db", $_);
  }
  displayRevEdit("Selected edits have been rejected");
}

sub approveNew {
  for( split(/,/, $FRM{id}) ) {
    my $md = dbselect("$DDIR/dbs/review.db", $_);
    next if( !$md );
    shift @{ $md };
    chomp @{ $md };

    fjoin  ("$DDIR/members/$_.dat",  @{ $md }                                          );
    fjoin  ("$DDIR/members/$_.cnt",  0, 0, 0, 0, '-', $$md[12], $$md[8], 0, $$md[10], 0);
    fcreate("$DDIR/members/$_.sts"                                                     );

    dbdelete("$DDIR/dbs/review.db", $_);

    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

    memberTemplate($_);
    mail($SENDMAIL, freadalls("$TDIR/_email_approved.etmpl"), \%TPL) if( $USE_MEM_EMAIL );
  }

  displayRevNew("Selected Accounts Have Been Approved");
}

sub rejectNew {
  for( split(/,/, $FRM{id}) ) {
    my $id = $_;
    my $md = dbselect("$DDIR/dbs/review.db", $id);
    next if( !$md );
    dbdelete("$DDIR/dbs/review.db", $id);
    unlink  ("$IMAGE_DIR/$id.gif"      );
    unlink  ("$IMAGE_DIR/$id.jpg"      );

    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
    $TPL{EMAIL}       = $$md[1];
    $TPL{USERNAME}    = $id;
    $TPL{SITE_URL}    = $$md[2];
    $TPL{TITLE}       = $$md[7];
    $TPL{DESCRIPTION} = $$md[8];
    $TPL{CATEGORY}    = $$md[9];

    my $rej = "rej_$id";
    mail($SENDMAIL, freadalls("$DDIR/mails/$FRM{$rej}"), \%TPL) if( $FRM{$rej} ne 'none' );
  }

  displayRevNew("Selected Accounts Have Been Rejected");
}

sub quickJump {
  $FRM{page}--;
  displayAll();
}

sub stripHTML {
  my($html, $amp) = @_;

  $$html =~ s/&/&amp;/gi if( !$amp );
  $$html =~ s/>/&gt;/gi;
  $$html =~ s/</&lt;/gi;
  $$html =~ s/\"/&quot;/gi;

}

sub printStats {
  open(FILE, "$DDIR/stats") || err("$!", 'stats');
  for( reverse <FILE> ) {
    my @stats = split(/\|/, $_);
    $TPL{RESET_DATE} = $stats[0];
    $TPL{HITS_IN}    = $stats[1];
    $TPL{HITS_OUT}   = $stats[2];
    $TPL{ACTIVE}     = $stats[5];
    $TPL{TOP_RANKED} = $stats[6];
    fparse('_admin_statsm.htmlt');
  }
  close(FILE);
}

sub printRevEdit {
  open(EDIT, "$DDIR/dbs/edit.db") || err("$!", 'edit.db');
  while( <EDIT> ) {
    my @md = split(/\|/, $_);

    $TPL{USERNAME}    = $md[0];
    $TPL{EMAIL}       = $md[1];
    $TPL{SITE_URL}    = $md[2];
    $TPL{BANNER_URL}  = !$md[3] ? 'None' : qq|<a href="javascript:openBanner('$md[3]');" class="reg">Click Here</a>|;
    $TPL{BANNER_DIMS} = !$md[3] ? '' : "$md[5]x$md[4]";
    $TPL{RECIP_URL}   = !$md[6] ? 'None' : qq|<a href="$md[6]" target="_new" class="reg">Click Here</a>|;
    $TPL{TITLE}       = $md[7];
    $TPL{DESCRIPTION} = $md[8];
    $TPL{CATEGORY}    = $md[9];   
    $TPL{FIELD_1}     = $md[11];
    $TPL{FIELD_2}     = $md[12];
    $TPL{FIELD_3}     = $md[13];
    fparse('_admin_reveditm.htmlt');
  }
  close(EDIT);
}

sub printRevNew {
  for( @{ dread("$DDIR/mails", '^[^.]') } ) {
    $TPL{REJECT} .= qq|<option value="$_">$_</option>\n|;
  }

  open(REV, "$DDIR/dbs/review.db") || err("$!", 'review.db');
  while( <REV> ) {
    my @md = split(/\|/, $_);

    $TPL{USERNAME}    = $md[0];
    $TPL{CATEGORY}    = $md[9];
    $TPL{SITE_URL}    = $md[2];
    $TPL{BANNER_URL}  = !$md[3] ? 'None' : qq|<a href="javascript:openBanner('$md[3]');" class="reg">Click Here</a>|;
    $TPL{TITLE}       = $md[7];
    $TPL{DESCRIPTION} = $md[8];
    $TPL{RECIP_URL}   = !$md[6] ? 'None' : qq|<a href="$md[6]" target="_new" class="reg">Click Here</a>|;
    $TPL{EMAIL}       = $md[1];
    $TPL{R_SELECT}    = "rej_$md[0]";
    $TPL{FIELD_1}     = $md[24];
    $TPL{FIELD_2}     = $md[25];
    $TPL{FIELD_3}     = $md[26];
    fparse('_admin_revnewm.htmlt');
  }
  close(REV);
}

sub printSearch {
  my $key = shift;
  for( @{ dread("$DDIR/members", '\.dat$') } ) {
    my $md = freadline("$DDIR/members/$_");
    next if( $md !~ /$key/i );
    memberTemplate(getUsername($_));
    $TPL{BANNER_URL} = $TPL{BANNER_URL} eq '' ? 'None' : qq|<a href="javascript:openBanner('$TPL{BANNER_URL}');" class="reg">Click Here</a>|;
    fparse('_admin_searchm.htmlt');
  }
}

sub printAll {
  my $i;
  for( $i = $TPL{START} - 1; $i <= $TPL{END} - 1; $i++ ) {
    memberTemplate(getUsername($SORTED[$i]));
    $TPL{SORT_VALUE} = (split(/\|/, $MEM{$SORTED[$i]}))[0];
    $TPL{SORT_VALUE} = $TPL{SIGNUP_DATE} if( $FRM{sort} eq 'signupDate' );
    $TPL{BANNER_URL} = !$TPL{BANNER_URL} ? 'None' : qq|<a href="javascript:openBanner('$TPL{BANNER_URL}');" class="reg">Click Here</a>|;
    fparse('_admin_allm.htmlt');
  }
}

sub printReject {
  for( @{ dread("$DDIR/mails", '^[^.]') } ) {
    print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Verdana" size="2">\n<b>E-mail ID:</b> $_\n</font>\n<br>\n<pre>| . ${freadalls("$DDIR/mails/$_")} . qq|</pre>\n</td>\n</tr>\n|;
  }
  print qq|</table>\n</td>\n</tr>\n</table>\n\n|;
  print qq|<input type="hidden" name="apwd" value="$TPL{APWD}"></form><br><form action="admin.cgi" method="POST">|;
  print qq|<input type="hidden" name="apwd" value="$TPL{APWD}">$TPL{BACK}</form></body></html>|;
}

sub printIcons {
  for( @{ dread("$DDIR/icons", '^[^.]') } ) {
    print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Verdana" size="2">\n<b>Icon ID:</b> $_\n</font>\n<br>\n| . ${freadalls("$DDIR/icons/$_")} . qq|\n</td>\n</tr>\n|;
  }
}

sub getYesNo {
  return (shift) ? qq|<option value="0">No</option>\n<option value="1" selected>Yes</option>| : qq|<option value="0" selected>No</option>\n<option value="1">Yes</option>|;
}

sub getPages {
  my $html;

  for( split(/,/, $MAIN_PAGE_LIST) ) {
    $html .= qq|<option value="$_">$_</option>|;
  }

  if( $USE_CAT_PAGES ) {
    for( split(/,/, $CAT_PAGE_LIST) ) {
      $html .= qq|<option value="$_">$_</option>|;
    }
  }
  return $html    
}

sub getBreakOptions {
  my $selected = shift;
  my $breaks   = $FRM{bpages} eq 'Overall' ? $BREAK_LIST : $C_BREAK_LIST;
  my $html;

  for( split(/,/, $breaks) ) {
    $html .= $selected eq $_ ? qq|<option value="$_" selected>$_</option>\n| : qq|<option value="$_">$_</option>\n|;
  }

  return $html;
}

sub getIconCheckboxes {
  my %icons = map { $_ => $_ } split(/,/, shift);  
  my $html;

  for( @{ dread("$DDIR/icons", '^[^.]') } ) {
    $html .= $icons{$_} ?
             qq|<input type="checkbox" name="icon" value="$_" checked>| . ${ freadalls("$DDIR/icons/$_") } . qq|<br>| :
             qq|<input type="checkbox" name="icon" value="$_">| . ${ freadalls("$DDIR/icons/$_") } . qq|<br>|;
  }
  return \$html;
}

sub getStart {
  my($total, $show) = @_;

  return 0 if( !$total );

  my $start = $FRM{page} * $show + 1;

  while( $start > $total ) {
    $FRM{page}--;
    $start = $FRM{page} * $show + 1
  }

  $start = 0 if( $start < 0 );

  return $start;
}

sub getEnd {
  my($total, $show, $start) = @_;

  return 0 if( !$total );

  my $end = $start + $show - 1;
  $end = $total if( $end > $total );
  return $end;
}

sub getJump {
  my($total, $show) = @_;

  if( !$total || $show == 9999999 || $total <= $show ) {
    $TPL{STATUS} = ' disabled';
    return qq|<option value="--">--</option>|;
  }

  my $html;
  my $num = $total % $show == 0 ? 0 : 1;
  for( 1..($total/$show + $num) ) {
    $html .= qq|<option value="$_">\#| . ($show*($_-1)+1) . qq|</option>|;
  }

  return $html;
}

sub memberTemplate {
  my $id  = shift;
  my $cd  = fsplit("$DDIR/members/$id.cnt");
  my $md  = fsplit("$DDIR/members/$id.dat");
  my $age = time - $$md[11];

  $TPL{USERNAME}      = $id;
  $TPL{PASSWORD}      = $$md[18];
  $TPL{EMAIL}         = $$md[0];
  $TPL{SITE_URL}      = $$md[1];
  $TPL{BANNER_URL}    = $$md[2];
  $TPL{HEIGHT}        = $$md[3];
  $TPL{WIDTH}         = $$md[4];
  $TPL{RECIP_URL}     = $$md[5];
  $TPL{TITLE}         = $$md[6];
  $TPL{DESCRIPTION}   = $$md[7];
  $TPL{INACTIVE}      = $$cd[9];
  $TPL{LOCKED}        = $$md[21] ? '<font color="red">Locked</font>'    : 'Not Locked';
  $TPL{SUSPENDED}     = $$md[20] ? '<font color="red">Suspended</font>' : 'Active';
  $TPL{LOCK_OPT}      = $$md[21] ? qq|<option value="unlock">Unlock Account</option>|     : qq|<option value="lock">Lock Account</option>|;
  $TPL{SUSP_OPT}      = $$md[20] ? qq|<option value="activate">Activate Account</option>| : qq|<option value="suspend">Suspend Account</option>|;
  $TPL{SUSP_YN}       = getYesNo($$md[20]);
  $TPL{LOCK_YN}       = getYesNo($$md[21]);
  $TPL{ICONS}         = getIcons($$md[9]);
  $TPL{ICON_BOXES}    = ${ getIconCheckboxes($$md[9]) };
  $TPL{CATEGORY}      = $$md[8];
  $TPL{CAT_OPTIONS}   = getCatOptions($$md[8]);
  $TPL{SIGNUP_DATE}   = fdate($DATE_FORMAT, $$md[10] + ($TIME_ZONE * 3600)) . ' ' . ftime($TIME_FORMAT, $$md[10] + ($TIME_ZONE * 3600));
  $TPL{WEIGHT}        = $$md[12];
  $TPL{HITS_IN}       = int($$cd[0] * $$cd[5]);
  $TPL{RAW_HITS_IN}   = $$cd[0];
  $TPL{HITS_OUT}      = $$cd[1];
  $TPL{TOTAL_IN}      = int($$cd[2] * $$cd[5]);
  $TPL{RAW_TOTAL_IN}  = $$cd[2];
  $TPL{TOTAL_OUT}     = $$cd[3];
  $TPL{IN_PER_DAY}    = getAvg($TPL{TOTAL_IN},  $age, 86400  );
  $TPL{IN_PER_WEEK}   = getAvg($TPL{TOTAL_IN},  $age, 604800 );
  $TPL{IN_PER_MONTH}  = getAvg($TPL{TOTAL_IN},  $age, 2592000);
  $TPL{OUT_PER_DAY}   = getAvg($TPL{TOTAL_OUT}, $age, 86400  );
  $TPL{OUT_PER_WEEK}  = getAvg($TPL{TOTAL_OUT}, $age, 604800 );
  $TPL{OUT_PER_MONTH} = getAvg($TPL{TOTAL_OUT}, $age, 2592000);
  $TPL{FIELD_1}       = $$md[23];
  $TPL{FIELD_2}       = $$md[24];
  $TPL{FIELD_3}       = $$md[25];
  $TPL{TRACK_URL}     = "$IN_URL?id=$id";
  $TPL{LOGIN_URL}     = "$CGI_URL/accounts.cgi?login";
}
#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#############################################################
##  admin.cgi - control administration of AutoGallery Pro  ##
#############################################################

BEGIN
{
    chdir('..');
}

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval
{
    require 'agp.pl';
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


sub main
{
    derr(1024) if( !$RMTUSR );
    derr(1025) if( !-e "$DDIR/vars.dat" );  
    diskspace();

    if( $REQMTH eq 'GET' )
    {
        displayMain();
    }

    else
    {
        parsepost();
        derr(1016) if( !$FRM{run} );
        &{$FRM{run}};
    }
}



sub displayMain
{
    $TPL{MESSAGE}       = shift;
    $TPL{P0ST_STATUS}   = (-e "$DDIR/disabled") ? '<option value="enablePost">Enable Post.cgi</option>' : '<option value="disablePost">Disable Post.cgi</option>';
    $TPL{QUEUE}         = '<option value="queue">Queue Database</option>' if( !$USE_AUTO_APPROVE );
    $TPL{ARCHIVES}      = getDatabases();
    $TPL{TGP_PAGES}     = getPages();
    $TPL{IN_QUEUE}      = $USE_AUTO_APPROVE ? 'NA' : dbsize("$DDIR/dbs/queue");
    $TPL{CHEAT_REPORTS} = dbsize("$DDIR/dbs/cheats");
    $TPL{LAST_BACKUP}   = timetostr( getAge("$DDIR/backup") );
    $TPL{TGP_PAGE}      = "$HTML_URL/" . (split(/,/, $MAIN_PAGE))[0];
    $TPL{VERSION}       = $VERSION;

    if( getAge("$DDIR/backup") >= 259200 )
    {
        $TPL{REMIND}  = 'A database backup is recommended';
        $TPL{COLOR}   = '#FF0000';
    }

    fparse('_admin_main.htmlt');
}



sub displayTemplate
{
    $line = freadalls("$TDIR/$FRM{template}");
    stripHTML($line);

    $TPL{HTML}     = $$line;
    $TPL{TEMPLATE} = $FRM{template};
 
    fparse('_admin_template.htmlt');
}



sub displayHTML
{
    require "$DDIR/html/$FRM{hpage}";

    stripHTML(\$HTML);
    stripHTML(\$TEMP);

    $TPL{HTML}     = $HTML;
    $TPL{TEMP}     = $TEMP;
    $TPL{HPAGE}    = $FRM{hpage};
    $TPL{ALL}      = qq|<option value="$MAIN_PAGE,$CAT_PAGE_LIST">All Pages</option>\n|;
    $TPL{ARCHIVES} = qq|<option value="$CAT_PAGE_LIST">All Archive Pages</option>\n|;
    $TPL{MAIN}     = $MAIN_PAGE;

    fparse('_admin_html.htmlt');
}



sub displayBans
{
    $TPL{MESSAGE} = shift;
    $TPL{EMAIL}   = ${ freadalls("$DDIR/dbs/email.ban") };
    $TPL{DOMAIN}  = ${ freadalls("$DDIR/dbs/url.ban"  ) };
    $TPL{WORD}    = ${ freadalls("$DDIR/dbs/word.ban" ) };
    $TPL{IP}      = ${ freadalls("$DDIR/dbs/IP.ban"   ) };

    fparse('_admin_bans.htmlt');
}



sub displayRecip
{
    my($msg, $htm) = @_;

    $TPL{MESSAGE}  = $msg;
    $TPL{HTML}     = $$htm if( defined $htm );
    $TPL{RECIP_ID} = $FRM{id};

    fparse('_admin_recip.htmlt');
    printRecip();
}



sub displayBanned
{
    my($msg, $htm) = @_;

    $TPL{MESSAGE} = $msg;
    $TPL{HTML}    = $$htm if( defined $htm );
    $TPL{BAN_ID}  = $FRM{id};

    fparse('_admin_banned.htmlt');
    printBanned();
}



sub displayIcons
{
    my($msg, $html) = @_;

    $TPL{MESSAGE} = $msg;
    $TPL{HTML}    = $$html if( defined $html );
    $TPL{ICON_ID} = $FRM{id};

    fparse('_admin_iconst.htmlt');
    printIcons();
    fparse('_admin_iconsb.htmlt');
}



sub displayReject
{
    my($msg, $html) = @_;

    derr(1027) if( $USE_AUTO_APPROVE );

    $TPL{MESSAGE}   = $msg;
    $TPL{HTML}      = $$html if( defined $html );
    $TPL{REJECT_ID} = $FRM{id};

    fparse('_admin_reject.htmlt');
    printReject();
}



sub displayManual
{
    $TPL{MESSAGE} = shift;

    for( split(/,/, $CATEGORIES) )
    {
        $TPL{CAT_OPTIONS} .= qq|<option value="$_">$_</option>\n|;
    }

    fparse('_admin_manual.htmlt');
}



sub displayPost
{
    derr(1000, 'Post ID') if( !$FRM{id} );

    my $pd = dbselect("$DDIR/dbs/$FRM{pdb}", $FRM{id});

    derr(1030) if( !$pd );

    $TPL{POST_ID}     = $$pd[0];
    $TPL{EMAIL}       = $$pd[1];
    $TPL{GALLERY_URL} = $$pd[2];
    $TPL{DESCRIPTION} = $$pd[3];
    $TPL{RECIP_URL}   = $$pd[4];
    $TPL{NUM_PICS}    = $$pd[6];
    $TPL{CATEGORY}    = $$pd[7];
    $TPL{SUBMIT_TIME} = fdate($DATE_FORMAT, $$pd[9] + 3600 * $TIME_ZONE) . ' ' . ftime($TIME_FORMAT, $$pd[9] + 3600 * $TIME_ZONE);
    $TPL{PARTNER_ID}  = $$pd[12];
    $TPL{APPROVED_BY} = $$pd[13];
    $TPL{PERMANENT}   = $$pd[14] ? 'Yes' : 'No';
    $TPL{SUBMIT_IP}   = $$pd[15];
    $TPL{DATABASE}    = $FRM{pdb};
    $TPL{CODED_RECIP} = urlencode($$pd[4]);

    fparse('_admin_details.htmlt');
}



sub displayEditPost
{
    derr(1000, 'Post ID') if( !$FRM{id} );

    tprint('_admin_editpostt.htmlt');
 
    for( split(/,/, $FRM{id}) )
    {
        my $pd = dbselect("$DDIR/dbs/$FRM{db}", $_);
        
        next if( !$pd );

        $TPL{POST_ID}     = $$pd[0];
        $TPL{EMAIL}       = $$pd[1];
        $TPL{GALLERY_URL} = $$pd[2];
        $TPL{DESCRIPTION} = $$pd[3];
        $TPL{RECIP_URL}   = $$pd[4];
        $TPL{NUM_PICS}    = $$pd[6];
        $TPL{DATABASE}    = $FRM{db};
        $TPL{CAT_OPTIONS} = getCatOptions($$pd[7]);
        $TPL{PERMANENT}   = getPermanent($$pd[14]);
  
        fparse('_admin_editpostm.htmlt');
     }

    $TPL{FROM}     = $FRM{from};
    $TPL{PAGE}     = $FRM{page};
    $TPL{SHOW}     = $FRM{show};
    $TPL{POST_IDS} = $FRM{id};
    $TPL{DATABASE} = $FRM{db};
    
    fparse('_admin_editpostb.htmlt');
}



sub displayCheats
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_cheatt.htmlt');
    printCheats();
    tprint('_admin_cheatb.htmlt');
}



sub displaySearch
{
    $TPL{DATABASE} = $FRM{sdb};
    $TPL{KEYWORD}  = $FRM{key};

    fparse('_admin_searcht.htmlt');
    searchPosts();
    fparse('_admin_searchb.htmlt');
}



sub displayPosts
{
    $FRM{page} = 0 if( $FRM{page} < 0 );

    $TPL{MESSAGE}  = shift;
    $TPL{SHOW}     = $FRM{show};
    $TPL{TOTAL}    = dbsize("$DDIR/dbs/$FRM{db}");
    $TPL{START}    = getStart($TPL{TOTAL}, $FRM{show});
    $TPL{END}      = getEnd($TPL{TOTAL}, $FRM{show}, $TPL{START});
    $TPL{NEXT}     = $TPL{TOTAL} > $TPL{END} ? qq|<option value="displayPosts">Display Next Page</option>| : '';
    $TPL{PAGE}     = $FRM{page} + 1;
    $TPL{JUMP}     = getJump($TPL{TOTAL}, $FRM{show});
    $TPL{DATABASE} = $FRM{db};    

    if( $FRM{db} eq 'queue' )
    {
        fparse('_admin_queuet.htmlt');
        printPosts('queue');
        fparse('_admin_queueb.htmlt');
    }
    else
    {
        fparse('_admin_postst.htmlt');
        printPosts('posts');
        fparse('_admin_postsb.htmlt');
    }
}



sub displayEditPartner
{
    derr(1036) if( !hasAccess(10) );

    my $id = (split(/,/, $FRM{id}))[0];

    derr(1000, 'Partner ID') if( !$id );

    my $res = dbselect("$DDIR/dbs/partners", $id);
    derr(1035,) if( !$res );

    $TPL{USERNAME} = $$res[0];
    $TPL{EMAIL}    = $$res[1];
    $TPL{NAME}     = $$res[2];
    $TPL{SITE_URL} = $$res[3];
    $TPL{PASSWORD} = $$res[4];
    $TPL{ICONS}    = getIconSelect($$res[5]);

    fparse('_admin_epartner.htmlt');
}



sub displayAllPartners
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_partnerst.htmlt');
    printPartners();
    fparse('_admin_partnersb.htmlt');
}



sub displayAddPartner
{
    $TPL{MESSAGE}     = shift;
    $TPL{ICON_SELECT} = getIconSelect();

    fparse('_admin_apartner.htmlt');
}



sub displayEditMod
{
    derr(1036) if( !hasAccess(11) );

    my $id = (split(/,/, $FRM{id}))[0];

    derr(1000, 'Moderator ID') if( !$id );

    my $res = dbselect("$DDIR/dbs/moderators", $id);
    derr(1035) if( !$res );


    $TPL{NAME}     = $$res[2];
    $TPL{EMAIL}    = $$res[1];
    $TPL{USERNAME} = $$res[0];
    $TPL{PASSWORD} = $$res[3];
    $TPL{SUPER}    = getCheckbox($$res[4]);   
    $TPL{PST}      = getCheckbox($$res[5]);
    $TPL{SET}      = getCheckbox($$res[6]);
    $TPL{HTM}      = getCheckbox($$res[7]);
    $TPL{BLK}      = getCheckbox($$res[8]);
    $TPL{EML}      = getCheckbox($$res[9]);
    $TPL{PRT}      = getCheckbox($$res[10]);
    $TPL{MOD}      = getCheckbox($$res[11]);
    $TPL{CHT}      = getCheckbox($$res[12]);

    fparse('_admin_emod.htmlt');
}


sub displayAllMods
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_modst.htmlt');
    printModerators();
    tprint('_admin_modsb.htmlt');
}



sub displayAddMod
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_amod.htmlt');
}



sub displayMail
{
    derr(1000, 'E-mail Recipient') if( !$FRM{id} );

    $TPL{RUN}      = $FRM{efnct};
    $TPL{DATABASE} = $FRM{db};
    $TPL{TO}       = $FRM{id};
    $TPL{SHOW}     = $FRM{show};
    $TPL{PAGE}     = $FRM{page} - 1;
    $TPL{FROM}     = $FRM{from};

    fparse('_admin_mail.htmlt');
}



sub displayLang
{
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



sub displayBackup
{
    fparse('_admin_backup.htmlt');
}


#########################################################################################################



sub rebuildAll
{
    buildMain();
    buildArchives();
    displayMain('All pages have been rebuilt');
}



sub rebuildMain
{
    buildMain();
    displayMain('Main pages have been rebuilt');
}



sub rebuildArchives
{
    buildArchives();
    displayMain('Archive pages have been rebuilt');
}



sub processPosts
{
    derr(1036) if( !hasAccess(5) );

    derr(1000, 'No Submissions Selected') if( !$FRM{id} && !$FRM{rej} && !$FRM{ban} );
    my( @apr, @rej, @ban );

    my $time = time;

    ## Process the banned submissions
    for( split(/,/, $FRM{ban}) )
    {
        my $pd = dbselect("$DDIR/dbs/queue", $_);
        next if( !$pd );
        dbdelete("$DDIR/dbs/queue", $_);
         
        $DEL = "\n";
        dbinsert("$DDIR/dbs/email.ban", $$pd[1]);
        dbinsert("$DDIR/dbs/url.ban",   $$pd[5]);
        $DEL = '|';
    }


    ## Process the rejected submissions
    for( split(/,/, $FRM{rej}) )
    {
        my $pd = dbselect("$DDIR/dbs/queue", $_);
        next if( !$pd );
        dbdelete("$DDIR/dbs/queue", $_);
        
        $$pd[18] = $FRM{"rej_$_"};
        push(@rej, join('|', @{$pd})) if( $$pd[8] && $FRM{"rej_$_"} ne 'none' );
    }


    ## Process the approved submissions
    for( split(/,/, $FRM{id}) )
    {
        my $pd = dbselect("$DDIR/dbs/queue", $_);
        next if( !$pd );
        dbdelete("$DDIR/dbs/queue", $_);

        $$pd[3]  = $FRM{"desc_$_"};
        $$pd[6]  = $FRM{"pics_$_"};
        $$pd[7]  = $FRM{"cat_$_"};
        $$pd[10] = $time;
        $$pd[13] = $RMTUSR;
        
        my $res = dbinsert("$DDIR/dbs/current", @{$pd});

        if( !$res )
        {
            $$pd[0] = "$$pd[0]-a";
            dbinsert("$DDIR/dbs/current", @{$pd});
        }

        push(@apr, join('|', @{$pd})) if( $$pd[11] );
    }

    doArchive();
 
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

    ## Fork off to take care of mailing the submitters
    my $pid = fork();
    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        for( @apr )
        {
            my @pd = split(/\|/, $_);

            $TPL{POST_ID}     = $pd[0];
            $TPL{EMAIL}       = $pd[1];
            $TPL{GALLERY_URL} = $pd[2];
            $TPL{DESCRIPTION} = $pd[3] ? $pd[3] : '';
            $TPL{RECIP_URL}   = $pd[4] ? $pd[4] : '';
            $TPL{NUM_PICS}    = $pd[6];
            $TPL{CATEGORY}    = $pd[7];
            $TPL{SUBMIT_DATE} = fdate($DATE_FORMAT, $pd[9] + (3600 * $TIME_ZONE)); 
            $TPL{SUBMIT_TIME} = ftime($DATE_FORMAT, $pd[9] + (3600 * $TIME_ZONE));

            mail($SENDMAIL, freadalls("$TDIR/_email_approved.etmpl"), \%TPL);
        }

        for( @rej )
        {
            my @pd = split(/\|/, $_);

            $TPL{POST_ID}     = $pd[0];
            $TPL{EMAIL}       = $pd[1];
            $TPL{GALLERY_URL} = $pd[2];
            $TPL{DESCRIPTION} = $pd[3] ? $pd[3] : '';
            $TPL{RECIP_URL}   = $pd[4] ? $pd[4] : '';
            $TPL{NUM_PICS}    = $pd[6];
            $TPL{CATEGORY}    = $pd[7];
            $TPL{SUBMIT_DATE} = fdate($DATE_FORMAT, $pd[9] + (3600 * $TIME_ZONE)); 
            $TPL{SUBMIT_TIME} = ftime($DATE_FORMAT, $pd[9] + (3600 * $TIME_ZONE));

            mail($SENDMAIL, freadalls("$DDIR/mails/$pd[18]"), \%TPL);
        }
    }
    else
    {
        $FRM{page}--;

        displayPosts('Selected Submissions Have Been Processed');
    }
}



sub manualSubmit
{
    derr(1036) if( !hasAccess(5) );

    derr(1007                 ) if( $FRM{pics}  < $MINIMUM_PICS                                       );
    derr(1006                 ) if( $FRM{email} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl}  !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/               );

    my $partial = getPartialURL($FRM{gurl});  
    my $time    = time;
    my $date    = fdate("%Y%m%d", $time);
    my $pid     = getNewPostID();

    for( keys %FRM  ) { $FRM{$_} =~ s/\|//g; }

    $TPL{EMAIL}       = $FRM{email};
    $TPL{GALLERY_URL} = $FRM{gurl};
    $TPL{DESCRIPTION} = $FRM{desc};
    $TPL{RECIP_URL}   = $FRM{rurl};
    $TPL{NUM_PICS}    = $FRM{pics};
    $TPL{PERMANENT}   = $FRM{perm} ? $L_YES : $L_NO;
    $TPL{CONFIRM}     = $FRM{conf} ? $L_YES : $L_NO;
    $TPL{CATEGORY}    = $FRM{cat};
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

    my $dbh = dbinsert("$DDIR/dbs/current", $pid, "$FRM{email}|$FRM{gurl}|$FRM{desc}|$FRM{rurl}|$partial|$FRM{pics}|$FRM{cat}|$date|$time|$time|0|-|$RMTUSR|$FRM{perm}|$RMTADR|0|0|-");   
    derr(1022) if( !$dbh );

    displayManual("Submission added and assigned ID $pid");
}



sub deletePosts
{
    derr(1036) if( !hasAccess(5) );

    for( split(/,/, $FRM{id}) )
    {
        dbdelete("$DDIR/dbs/$FRM{db}", $_);
    }

    $FRM{page}--;

    &{$FRM{from}}("The selected posts have been deleted");
}



sub archivePosts
{
    derr(1036) if( !hasAccess(5) );

    derr(1031) if( $FRM{db} ne 'current' );

    for( split(/,/, $FRM{id}) )
    {
        my $pd = dbselect("$DDIR/dbs/$FRM{db}", $_);

        if( $pd )
        {
            dbdelete("$DDIR/dbs/$FRM{db}", $_);
            dbinsert("$DDIR/dbs/" . getDBName($$pd[7]), @{$pd});
        }
    }

    $FRM{page}--;

    &{$FRM{from}}("The selected posts have been archived");
}



sub editPosts
{
    derr(1036) if( !hasAccess(5) );

    for( split(/,/, $FRM{ids}) )
    {
        my $id = $_;
        my $pd = dbselect("$DDIR/dbs/$FRM{db}", $id);

        next if( !$pd );

        $$pd[1]  = $FRM{"email_$id"};
        $$pd[2]  = $FRM{"gurl_$id"};
        $$pd[3]  = $FRM{"desc_$id"};
        $$pd[4]  = $FRM{"rurl_$id"};
        $$pd[6]  = $FRM{"pics_$id"};
        $$pd[7]  = $FRM{"cat_$id"};
        $$pd[14] = $FRM{"perm_$id"};

        dbupdate("$DDIR/dbs/$FRM{db}", $id, @{$pd});
    }

    $FRM{page}--;

    &{$FRM{from}}("Post IDs $FRM{ids} Have Been Updated");
}



sub backupData
{
    derr(1036) if( !hasAccess(6) );

    derr(1000, 'Backup Filename') if( !$FRM{file} );

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        my @dirs = qw( banned dbs html icons links mails );

        fwrite("$DDIR/$FRM{file}", "Database: postid\n<<<" . freadline("$DDIR/postid") . ">>>\nDatabase: cheatid\n<<<" . freadline("$DDIR/cheatid") . ">>>\n");

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
     
        fwrite("$DDIR/backup", time);
    }

    else
    {
        displayMain("Databases are now being backed up.<br>Allow at least 30 seconds for this process to complete.");
    }
}



sub restoreData
{
    derr(1036) if( !hasAccess(6) );

    derr(1000, 'Backup Filename') if( !$FRM{file} );

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

        $DEL = ':';
        for( @{freadall("$DDIR/dbs/moderators")} )
        {
            my @md = split(/\|/, $_);
            dbinsert('./admin/.htpasswd', $md[0], crypt($md[3], getsalt()));
        }
        $DEL = '|';
    }

    else
    {
        displayMain("Databases are now being restored.<br>Allow at least 30 seconds for this process to complete.");
    }
}



sub saveLangSettings
{
    derr(1036) if( !hasAccess(6) );

    delete $FRM{run};

    fwrite("$DDIR/errors.dat");
    fwrite("$DDIR/lang.dat");

    for( sort keys %FRM )
    {
        $FRM{$_} =~ s/"/\\"/g;

        if( index($_, 'L_') == 0 )
        {
            fappend("$DDIR/lang.dat", "\$$_ = \"$FRM{$_}\";\n");
        }
        else
        {
            fappend("$DDIR/errors.dat", "\$error{$_} = \"$FRM{$_}\";\n");
        }
    }

    fappend("$DDIR/errors.dat", "\n1;\n");
    fappend("$DDIR/lang.dat", "\n1;\n");

    displayMain("Language settings have been updated");
}



sub mailPosters
{
    derr(1036) if( !hasAccess(9) );

    derr(1000, 'Subject') if( !$FRM{sub} );
  
    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        for( split(/,/, $FRM{to}) )
        {
            my $dat = dbselect("$DDIR/dbs/$FRM{db}", $_);
            next if( !$dat );

            $TPL{POST_ID}      = $$dat[0];
            $TPL{EMAIL}        = $$dat[1];
            $TPL{GALLERY_URL}  = $$dat[2];
            $TPL{DESCRIPTION}  = $$dat[3];
            $TPL{RECIP_URL}    = $$dat[4];
            $TPL{NUM_PICS}     = $$dat[6];
            $TPL{CATEGORY}     = $$dat[7];
            $TPL{SUBMIT_DATE}  = fdate($DATE_FORMAT, $$dat[9] + (3600 * $TIME_ZONE));
            $TPL{SUBMIT_TIME}  = ftime($TIME_FORMAT, $$dat[9] + (3600 * $TIME_ZONE));

            my $msg = "To: $$dat[1]\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }
    }
    else
    {
        &{$FRM{from}}('Selected Posters Have Been E-mailed');
    }
}



sub mailModerators
{
    derr(1036) if( !hasAccess(9) );

    derr(1000, 'Subject') if( !$FRM{sub} );

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        for( split(/,/, $FRM{to}) )
        {
            my $dat = dbselect("$DDIR/dbs/moderators", $_);
            next if( !$dat );

            $TPL{USERNAME} = $$dat[0];
            $TPL{NAME}     = $$dat[2];
            $TPL{PASSWORD} = $$dat[3];

            my $msg = "To: $$dat[1]\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }
    }
    else
    {
        displayAllMods('Selected Moderators Have Been E-mailed');
    }
}



sub mailPartners
{
    derr(1036) if( !hasAccess(9) );

    derr(1000, 'Subject') if( !$FRM{sub} );

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        for( split(/,/, $FRM{to}) )
        {
            my $dat = dbselect("$DDIR/dbs/partners", $_);
            next if( !$dat );

            $TPL{USERNAME} = $$dat[0];
            $TPL{NAME}     = $$dat[2];
            $TPL{PASSWORD} = $$dat[4];

            my $msg = "To: $$dat[1]\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }

    }
    else
    {
        displayAllPartners('Selected Partners Have Been E-mailed');
    }
}



sub editPartner
{
    derr(1036) if( !hasAccess(10) );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
    }

    my $res = dbupdate("$DDIR/dbs/partners", $FRM{user}, $FRM{user}, $FRM{mail}, $FRM{name}, $FRM{surl}, $FRM{pass}, $FRM{icon});
    derr(1035) if( !$res );

    displayAllPartners("Partner '$FRM{user}' Has Been Updated");
}



sub deletePartners
{
    derr(1036) if( !hasAccess(10) );

    for( split(/,/, $FRM{id}) )
    {
        dbdelete("$DDIR/dbs/partners", $_);
    }

    displayAllPartners("Selected Partners Have Been Deleted");
}



sub addPartner
{
    derr(1036) if( !hasAccess(10) );

    derr(1032) if( length($FRM{user}) > 8            );
    derr(1033) if( $FRM{user} !~ m/^[a-zA-Z0-9]*$/gi );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
    }

    my $res = dbinsert("$DDIR/dbs/partners", $FRM{user}, $FRM{mail}, $FRM{name}, $FRM{surl}, $FRM{pass}, $FRM{icon});
    derr(1034) if( !$res );

    $TPL{EMAIL}       = $FRM{mail};
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
    $TPL{CONTACT}     = $FRM{name};
    $TPL{CGI_URL}     = $CGI_URL;
    $TPL{PARTNER_ID}  = $FRM{user};
    $TPL{PASSWORD}    = $FRM{pass};

    mail($SENDMAIL, freadalls("$TDIR/_email_partner.etmpl"), \%TPL) if( $FRM{conf} );

    displayAddPartner("Partner '$FRM{user}' Successfully Added");
}



sub addModerator
{
    derr(1036) if( !hasAccess(11) );

    derr(1032) if( length($FRM{user}) > 8            );
    derr(1033) if( $FRM{user} !~ m/^[a-zA-Z0-9]*$/gi );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
    }

    my $res = dbinsert("$DDIR/dbs/moderators", $FRM{user}, "$FRM{mail}|$FRM{name}|$FRM{pass}|$FRM{super}|$FRM{pst}|$FRM{set}|$FRM{htm}|$FRM{blk}|$FRM{eml}|$FRM{prt}|$FRM{mod}|$FRM{cht}");
    derr(1034) if( !$res );

    $DEL = ':';
    $res = dbinsert('./admin/.htpasswd', $FRM{user}, crypt($FRM{pass}, getsalt()));
    derr(1034) if( !$res );
    $DEL = '|';
  
    $TPL{EMAIL}       = $FRM{mail};
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
    $TPL{NAME}        = $FRM{name};
    $TPL{CGI_URL}     = $CGI_URL;
    $TPL{USERNAME}    = $FRM{user};
    $TPL{PASSWORD}    = $FRM{pass};

    mail($SENDMAIL, freadalls("$TDIR/_email_moderator.etmpl"), \%TPL) if( $FRM{conf} );

    displayAddMod("Moderator '$FRM{user}' Successfully Added");
}



sub editModerator
{
    derr(1036) if( !hasAccess(11) );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
    }

    $res = dbupdate("$DDIR/dbs/moderators", $FRM{user}, $FRM{user}, "$FRM{mail}|$FRM{name}|$FRM{pass}|$FRM{super}|$FRM{pst}|$FRM{set}|$FRM{htm}|$FRM{blk}|$FRM{eml}|$FRM{prt}|$FRM{mod}|$FRM{cht}");
    derr(1035) if( !$res );

    $DEL = ':';
    my $res = dbupdate('./admin/.htpasswd', $FRM{user}, $FRM{user}, crypt($FRM{pass}, getsalt()));
    derr(1035) if( !$res );
    $DEL = '|';

    displayAllMods("Moderator '$FRM{user}' Has Been Updated");
}



sub deleteModerators
{
    derr(1036) if( !hasAccess(11) );

    for( split(/,/, $FRM{id}) )
    {
        dbdelete("$DDIR/dbs/moderators", $_);

        $DEL = ':';
        dbdelete('./admin/.htpasswd', $_);
        $DEL = '|';
    }

    displayAllMods("Selected Moderators Have Been Deleted");
}



sub cheatNothing
{
    derr(1036) if( !hasAccess(12) );

    for( split(/,/, $FRM{id}) )
    {
        dbdelete("$DDIR/dbs/cheats", $_);
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



sub cheatDelete
{
    derr(1036) if( !hasAccess(12) );

    for( split(/,/, $FRM{id}) ) {
        my $res = dbselect("$DDIR/dbs/cheats", $_);
        next if( !$res );

        dbdelete("$DDIR/dbs/cheats", $_);
        dbdelete("$DDIR/dbs/$$res[3]", $$res[2]);
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



sub cheatBan
{
    derr(1036) if( !hasAccess(12) );

    for( split(/,/, $FRM{id}) )
    {
        my $cd = dbselect("$DDIR/dbs/cheats", $_);
        next if( !$cd );

        my $pd = dbselect("$DDIR/dbs/$$cd[3]", $$cd[2]);
        next if( !$pd );

        dbdelete("$DDIR/dbs/cheats",  $_      );
        dbdelete("$DDIR/dbs/$$cd[3]", $$cd[2] );

        dbinsert("$DDIR/dbs/email.ban", $$pd[1] );
        dbinsert("$DDIR/dbs/url.ban",   $$pd[5] );
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



##  Edit icon functions 
sub deleteIcon
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}" );
    fremove("$DDIR/icons/$FRM{id}");
    delete $FRM{id};
    displayIcons("Selected Icon Has Been Deleted");
}



sub loadIcon
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}");
    displayIcons("Loaded Icon With ID '$FRM{id}'", freadalls("$DDIR/icons/$FRM{id}"));
}



sub saveIcon
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r|\n$//g;
    fwrite("$DDIR/icons/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayIcons("Icon Data Has Been Saved");
}



##  Edit Rejection e-mail functions 
sub deleteReject
{
    derr(1036) if( !hasAccess(7) );

    derr(1029) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/mails/$FRM{id}");
    delete $FRM{id};
    displayReject("Selected Rejection E-mail Has Been Deleted");
}



sub loadReject
{
    derr(1036) if( !hasAccess(7) );

    derr(1029) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id});
    displayReject("Loaded Rejection E-mail With ID '$FRM{id}'", freadalls("$DDIR/mails/$FRM{id}"));
}



sub saveReject
{
    derr(1036) if( !hasAccess(7) );

    derr(1029) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r|\n$//g;
    fwrite("$DDIR/mails/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayReject("Rejection E-mail Has Been Saved");
}



##  Edit reciprocal link functions
sub deleteRecip
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !-e "$DDIR/links/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/links/$FRM{id}");
    delete $FRM{id};
    displayRecip("Selected Reciprocal Link Has Been Deleted");
}



sub loadRecip
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !-e "$DDIR/links/$FRM{id}" || !$FRM{id});
    displayRecip("Loaded HTML For Reciprocal Link '$FRM{id}'", freadalls("$DDIR/links/$FRM{id}"));
}



sub saveRecip
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r//g;
    fwrite("$DDIR/links/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayRecip("Reciprocal Link Has Been Saved");
}



##  Edit reciprocal link functions
sub deleteBannedHTML
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !-e "$DDIR/banned/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/banned/$FRM{id}");
    delete $FRM{id};
    displayBanned("Selected HTML Ban Has Been Deleted");
}



sub loadBannedHTML
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !-e "$DDIR/banned/$FRM{id}" || !$FRM{id});
    displayBanned("Loaded Data For HTML Ban '$FRM{id}'", freadalls("$DDIR/banned/$FRM{id}"));
}



sub saveBannedHTML
{
    derr(1036) if( !hasAccess(7) );

    derr(1027) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r//g;
    fwrite("$DDIR/banned/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayBanned("HTML Ban Has Been Saved");
}



##  Edit Blacklist Functions
sub addBan
{
    derr(1036) if( !hasAccess(8) );

    $FRM{ban} =~ s/\r//g;
    derr(1028) if( !$FRM{ban} || $FRM{ban} =~ /^\n/m );

    $DEL = "\n";
    dbinsert("$DDIR/dbs/$FRM{type}.ban", $FRM{ban});
    $DEL = '|';

    displayBans("$FRM{ban} Added To the $FRM{type} Blacklist");
}



sub removeBan
{
    derr(1036) if( !hasAccess(8) );

    $FRM{ban} =~ s/\r//g;

    $DEL = "\n";
    for( split(/\n/, $FRM{ban}) )
    {
        dbdelete("$DDIR/dbs/$FRM{type}.ban", $_);
    }
    $DEL = '|';

    displayBans("$FRM{ban} removed from the $FRM{type} blacklist");
}



sub restoreTemplate
{
    derr(1036) if( !hasAccess(7) );

    my $pages = "$MAIN_PAGE,$CAT_PAGE_LIST";
    my $html  = freadalls("$DDIR/def.html");

    for( split(/,/, $pages) )
    {
         fwrite("$DDIR/html/$_", $$html);
    }

    displayMain("The default TGP page HTML has been restored");
}



sub clearQueue
{
    derr(1036) if( !hasAccess(5) );

    derr(1026) if( $FRM{date} !~ /\d{4}-\d{2}-\d{2}/ );

    $FRM{date} =~ s/-//g;

    sysopen(QUEUE, "$DDIR/dbs/queue", $O_RDWR | $O_CREAT) || err("$!", "$DDIR/dbs/queue");
    flock(QUEUE, $LOCK_EX);
    my @old = <QUEUE>;
    seek(QUEUE, 0, 0);

    foreach $line ( @old )
    {
        my $submit = (split(/\|/, $line))[8];
        
        next if( $submit < $FRM{date} );

        print QUEUE $line;
    }

    truncate(QUEUE, tell(QUEUE));
    flock(QUEUE, $LOCK_UN);
    close(QUEUE);

    displayMain("Old posts have been removed from the queue");
}



sub enablePost
{
    derr(1036) if( !hasAccess(6) );

    fremove("$DDIR/disabled");
    displayMain("post.cgi Has Been Enabled");
}



sub disablePost
{
    derr(1036) if( !hasAccess(6) );

    fcreate("$DDIR/disabled");
    displayMain("post.cgi Has Been Disabled");
}



sub updateHTML
{
    derr(1036) if( !hasAccess(7) );

    $FRM{html} =~ s/\r//gi;
    $FRM{html} =~ s/\n+$//g;
    $FRM{temp} =~ s/\r//gi;
    $FRM{temp} =~ s/\n+$//g;
  
    for( split(/,/, $FRM{pages}) )
    {
        fwrite("$DDIR/html/$_", qq|\n\n# DO NOT EDIT THIS FILE\n\n\n\$HTML = <<'HTML';\n$FRM{html}\nHTML\n\n\$TEMP = <<'TEMP';\n$FRM{temp}\nTEMP\n\n1;\n|);
    }

    displayMain("HTML successfully updated");
}



sub updateTemplate
{
    derr(1036) if( !hasAccess(7) );

    $FRM{html} =~ s/\r//gi;
    $FRM{html} =~ s/\n+$//g;
    fwrite("$TDIR/$FRM{template}", $FRM{html});
    displayMain("The $FRM{template} template has been updated");
}



sub stripHTML
{
    my($html, $amp) = @_;

    $$html =~ s/&/&amp;/gi if( !$amp );
    $$html =~ s/>/&gt;/gi;
    $$html =~ s/</&lt;/gi;
    $$html =~ s/\"/&quot;/gi;
}



sub getCheckbox
{
    my $val = shift;
    return ' checked' if( $val );
    return;
}


sub getIconSelect
{
    my $icons = shift;
    my $html;

    for( @{dread("$DDIR/icons", '^[^.]')} )
    {
        my $id = $_;

        $html .= qq|<input type="checkbox" name="icon" value="$id"> | . ${freadalls("$DDIR/icons/$id")} . qq|&nbsp;&nbsp;&nbsp;|;

        $html =~ s/value="$id"/value="$id" checked/ if( index(",$icons,", ",$id,") != -1 );
    }

    return $html;
}



sub getPages
{
    my $html;

    for( split(/,/, $MAIN_PAGE) )
    {
      $html .= qq|<option value="$_">$_</option>|;
    }

    
    for( split(/,/, $CAT_PAGE_LIST) )
    {
        $html .= qq|<option value="$_">$_</option>|;
    }
    return $html;
}



sub getDatabases
{
    my $html;
    for( split(/,/, $CATEGORIES) )
    {
        $html .= qq|<option value="| . getDBName($_) . qq|">$_ Archives</option>|;
    }
    return $html;
}



sub getCatOptions
{
    my $cat = shift;
    my $html;

    for( split(',', $CATEGORIES) )
    {
        $html .= $cat eq $_ ? qq|<option value="$_" selected>$_</option>\n| : qq|<option value="$_">$_</option>\n|;
    }

    return $html;
}



sub getPermanent
{
    my $perm = shift;
    my $opts = qq|<option value="1">Permanent - ok to put in the archives</option>\n<option value="0">Temporary - not ok to put in the archives</option>|;

    if( $perm )
    {
        $opts =~ s/value="1"/value="1" selected/;
    }
    else
    {
        $opts =~ s/value="0"/value="0" selected/;
    }

    return $opts;
}



sub searchPosts
{ 
    open(DB, "$DDIR/dbs/$FRM{sdb}") || err("$!", "$DDIR/dbs/$FRM{sdb}");
    flock(DB, $LOCK_SH);
    while( <DB> )
    {
        if( $_ =~ /$FRM{key}/i )
        {
            my @pd = split(/\|/, $_);

            $TPL{POST_ID}       = $pd[0];
            $TPL{EMAIL}         = $pd[1];
            $TPL{GALLERY_URL}   = $pd[2];
            $TPL{DESCRIPTION}   = $pd[3];
            $TPL{NUM_PICS}      = $pd[6];
            $TPL{CATEGORY}      = $pd[7];
            $TPL{PARTNER_ID}    = $pd[12];
            $TPL{APPROVED_BY}   = $pd[13];
            $TPL{APPROVE_TIME}  = fdate($DATE_FORMAT, $pd[10] + (3600 * $TIME_ZONE)) . ' ' . ftime($TIME_FORMAT, $pd[10] + (3600 * $TIME_ZONE));
            $TPL{PERMANENT}     = $pd[14] ? $L_YES : $L_NO;
            $TPL{SUBMIT_IP}     = $pd[15];
            $TPL{CODED_RECIP}   = urlencode($pd[4]);
            $TPL{CODED_GURL}    = urlencode($pd[2]);
            $TPL{CHECK_RECIP}   = $pd[4]  ? 'Check Now' : '</a>None Provided';
            $TPL{RECIP_CHECKED} = $pd[16] ? 'Checked'   : 'Not Checked';
            $TPL{RECIP_FOUND}   = $pd[17] ? 'Found'     : 'Not Found';

            fparse('_admin_searchm.htmlt');
        }
    }
    flock(DB, $LOCK_UN);
    close(DB);
}



sub printPartners
{
    my $line;

    open(DB, "$DDIR/dbs/partners") || err($!, "$DDIR/dbs/partners");
    flock(DB, $LOCK_SH);
    while( $line = <DB> ) 
    {
        my @pd = split(/\|/, $line);

        $TPL{USERNAME} = $pd[0];
        $TPL{EMAIL}    = $pd[1];
        $TPL{NAME}     = $pd[2];
        $TPL{SITE_URL} = $pd[3];

        fparse('_admin_partnersm.htmlt');
    }
    flock(DB, $LOCK_UN);
    close(DB);
}



sub printModerators
{
    my $line;

    open(DB, "$DDIR/dbs/moderators") || err($!, "$DDIR/dbs/moderators");
    flock(DB, $LOCK_SH);
    while( $line = <DB> )
    {
        my @pd = split(/\|/, $line);

        $TPL{USERNAME} = $pd[0];
        $TPL{EMAIL}    = $pd[1];
        $TPL{NAME}     = $pd[2];

        fparse('_admin_modsm.htmlt');
    }
    flock(DB, $LOCK_UN);
    close(DB);
}



sub printPosts
{
    my $page = shift;
    my $i;
  
    for( @{ dread("$DDIR/mails", '^[^.]') } ) {
        $TPL{REJ} .= qq|<option value="$_">$_</option>\n|;
    }

    open(DB, "$DDIR/dbs/$FRM{db}") || err($!, "$DDIR/dbs/$FRM{db}");
    flock(DB, $LOCK_SH);
    for( $i = 1; $i <= $TPL{END}; $i++ )
    {
        $line = <DB>;
        next if( $i < $TPL{START} );

        @pd = split(/\|/, $line);

        $TPL{POST_ID}       = $pd[0];
        $TPL{EMAIL}         = $pd[1];
        $TPL{GALLERY_URL}   = $pd[2];
        $TPL{DESCRIPTION}   = $pd[3];
        $TPL{NUM_PICS}      = $pd[6];
        $TPL{CATEGORY}      = $pd[7];
        $TPL{CAT_OPTIONS}   = getCatOptions($pd[7]);
        $TPL{APPROVED_BY}   = $pd[13];
        $TPL{PARTNER_ID}    = $pd[12];
        $TPL{APPROVE_TIME}  = fdate($DATE_FORMAT, $pd[10] + (3600 * $TIME_ZONE)) . ' ' . ftime($TIME_FORMAT, $pd[10] + (3600 * $TIME_ZONE));
        $TPL{SUBMIT_TIME}   = fdate($DATE_FORMAT, $pd[9] + (3600 * $TIME_ZONE))  . ' ' . ftime($TIME_FORMAT, $pd[9] + (3600 * $TIME_ZONE));
        $TPL{PERMANENT}     = $pd[14] ? $L_YES : $L_NO;
        $TPL{SUBMIT_IP}     = $pd[15];
        $TPL{CODED_RECIP}   = urlencode($pd[4]);
        $TPL{CODED_GURL}    = urlencode($pd[2]);
        $TPL{CHECK_RECIP}   = $pd[4]  ? 'Check Now' : '</a>None Provided';
        $TPL{RECIP_CHECKED} = $pd[16] ? 'Checked'   : 'Not Checked';
        $TPL{RECIP_FOUND}   = $pd[17] ? 'Found'     : 'Not Found';
        $TPL{R_SELECT}      = "rej_$pd[0]";
        
        fparse('_admin_' . $page . 'm.htmlt');
    }
    flock(DB, $LOCK_UN);
    close(DB);
}



sub printCheats
{
    my $line;

    open(DB, "$DDIR/dbs/cheats") || err("$!", "$DDIR/dbs/cheats");
    flock(DB, $LOCK_SH);
    while( $line = <DB> )
    {
        my @pd = split(/\|/, $line);

        $TPL{CHEAT_ID}    = $pd[0];
        $TPL{SUBMIT_IP}   = $pd[1];
        $TPL{POST_ID}     = $pd[2];
        $TPL{DATABASE}    = $pd[3];
        $TPL{GALLERY_URL} = $pd[4];
        $TPL{EMAIL}       = $pd[5];
        $TPL{DESCRIPTION} = $pd[6];

        fparse('_admin_cheatm.htmlt');
    }
    flock(DB, $LOCK_UN);
    close(DB);
}



sub printBanned
{
    for( @{ dread("$DDIR/banned", '^[^.]') } )
    {
        print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Arial" size="2">\n<b>Ban ID:</b> $_\n</font>\n<br>\n<xmp>| . ${freadalls("$DDIR/banned/$_")} . qq|</xmp>\n</td>\n</tr>\n|;
    }
    printFooter();
}



sub printRecip
{
    for( @{ dread("$DDIR/links", '^[^.]') } )
    {
        print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Arial" size="2">\n<b>Link ID:</b> $_\n</font>\n<br>\n<xmp>| . ${freadalls("$DDIR/links/$_")} . qq|</xmp>\n</td>\n</tr>\n|;
    }
    printFooter();
}



sub printReject
{
    for( @{ dread("$DDIR/mails", '^[^.]') } )
    {
        print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Verdana" size="2">\n<b>E-mail ID:</b> $_\n</font>\n<br>\n<pre>| . ${freadalls("$DDIR/mails/$_")} . qq|</pre>\n</td>\n</tr>\n|;
    }
    printFooter();
}



sub printFooter
{
    print <<HTML;
    </table>

    </td>
    </tr>
    </table>

    <br><br>
    <!--CyKuH-->
    <font face="Verdana" size="1" style="font-size: 11px;">
    <b><a href="admin.cgi" class="reg">Back To Main Admin Page</a></b>
    </font>

    </div>

    </body>
    </html>
HTML
}



sub printIcons
{
    for( @{ dread("$DDIR/icons", '^[^.]') } )
    {
        print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Verdana" size="2">\n<b>Icon ID:</b> $_\n</font>\n<br><!--CyKuH-->\n| . ${freadalls("$DDIR/icons/$_")} . qq|\n</td>\n</tr>\n|;
    }
}



sub quickJump
{
    $FRM{page}--;
    displayPosts();
}



sub getStart
{
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



sub getEnd
{
    my($total, $show, $start) = @_;

    return 0 if( !$total );

    my $end = $start + $show - 1;
    $end = $total if( $end > $total );
    return $end;
}



sub getJump
{
    my($total, $show) = @_;

    if( !$total || $show == 9999999 || $total <= $show )
    {
        $TPL{STATUS} = ' disabled';
        return qq|<option value="--">--</option>|;
    }

    my $html;
    my $num = $total % $show == 0 ? 0 : 1;
    for( 1..($total/$show + $num) )
    {
        $html .= qq|<option value="$_">\#| . ($show*($_-1)+1) . qq|</option>|;
    }

    return $html;
}



sub execute
{
    derr(1016) if( !$FRM{fnct} );
    &{$FRM{fnct}};
}
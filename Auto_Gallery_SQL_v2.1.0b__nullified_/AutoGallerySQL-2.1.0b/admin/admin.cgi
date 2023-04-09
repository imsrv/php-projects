#!/usr/bin/perl -w
#####################################################################
##  Program Name	: AutoGallery SQL                          ##
##  Version		: 2.1.0b                                   ##
##  Program Author      : JMB Software                             ##
##  Retail Price	: $85.00 United States Dollars             ##
##  xCGI Price		: $00.00 Always 100% Free                  ##
##  WebForum Price      : $00.00 Always 100% Free                  ##
##  Supplier By  	: Dionis                                   ##
##  Delivery by         : Slayer                                   ##
##  Nullified By	: CyKuH [WTN]                              ##
##  Distribution        : via WebForum and Forums File Dumps       ##
#####################################################################
##      admin.cgi - control administration of AutoGallery SQL      ##
#####################################################################

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
    require 'ags.pl';
    main();
    SQLDisconnect();
};

err("$@", 'admin.cgi') if( $@ );
exit;

########################################################################
##  Removing the link back to JMB Software is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in      ##
##  any way, for generating that link is strictly forbidden.          ##
##  Anyone violating the above policy will have their license         ##
##  terminated on the spot.  Do not remove that link - ever.          ##
########################################################################


sub main
{
    derr(1024) if( !$RMTUSR );
    derr(1039) if( !SQLCount("SELECT COUNT(*) FROM a_Moderators WHERE Moderator_ID='$RMTUSR'") );
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
    $TPL{QUEUE}         = '<option value="Queue">Queue Database</option>' if( !$USE_AUTO_APPROVE );
    $TPL{ARCHIVES}      = getDatabases();
    $TPL{TGP_PAGES}     = getPages();
    $TPL{CAT_OPTIONS}   = getCatOptions();
    $TPL{IN_QUEUE}      = $USE_AUTO_APPROVE ? 'NA' : SQLCount("SELECT COUNT(*) FROM a_Posts WHERE Approved='0' AND Confirmed='1'");
    $TPL{CHEAT_REPORTS} = SQLCount("SELECT COUNT(*) FROM a_Cheats");
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



sub displayPost
{
    derr(1000, 'Post ID') if( !$FRM{id} );

    my $pd = SQLRow("SELECT *,UNIX_TIMESTAMP(Approve_Date) AS aTimestamp,UNIX_TIMESTAMP(Submit_Date) AS sTimestamp FROM a_Posts WHERE Post_ID='$FRM{id}'");

    derr(1030) if( !$pd );

    $TPL{POST_ID}      = $pd->{'Post_ID'};
    $TPL{EMAIL}        = $pd->{'Email'};
    $TPL{GALLERY_URL}  = $pd->{'Gallery_URL'};
    $TPL{RECIP_URL}    = $pd->{'Recip_URL'} ? $pd->{'Recip_URL'} : '</a>None Provided';
    $TPL{NUM_PICS}     = $pd->{'Num_Pics'};
    $TPL{CATEGORY}     = $pd->{'Category'};
    $TPL{SUBMIT_DATE}  = fdate($DATE_FORMAT, $pd->{'sTimestamp'});
    $TPL{APPROVE_DATE} = fdate($DATE_FORMAT, $pd->{'aTimestamp'});
    $TPL{PARTNER_ID}   = $pd->{'Partner_ID'};
    $TPL{APPROVED_BY}  = $pd->{'Moderator'};
    $TPL{APPROVED}     = $pd->{'Approved'} ? 'Yes' : 'No';
    $TPL{ARCHIVED}     = $pd->{'Archived'} ? 'Yes' : 'No';
    $TPL{PERMANENT}    = $pd->{'Permanent'} ? 'Yes' : 'No';
    $TPL{R_CHECKED}    = $pd->{'Recip_Checked'} ? 'Checked' : 'Not Checked';
    $TPL{R_FOUND}      = $pd->{'Recip_Found'} ? 'Found' : 'Not Found';
    $TPL{SUBMIT_IP}    = $pd->{'IP_Address'};
    $TPL{DESCRIPTION}  = $pd->{'Description'};
    $TPL{RATING}       = $pd->{'Rating'};
    $TPL{THROUGHPUT}   = $pd->{'Throughput'};
    $TPL{TOTAL_LINKS}  = $pd->{'Banner_Links'} + $pd->{'Text_Links'};
    $TPL{PAGE_SIZE}    = $pd->{'Page_Bytes'};
    $TPL{CODED_RECIP}  = urlencode($pd->{'Recip_URL'});
    $TPL{DBCAT}        = $FRM{dbcat};
    $TPL{DATABASE}     = $FRM{db};
    $TPL{ICONS}        = getIcons($pd->{'Icons'});

    fparse('_admin_details.htmlt');
}



sub displayEditPost
{
    derr(1000, 'Post ID') if( !$FRM{id} );

    tprint('_admin_editpostt.htmlt');
 
    for( split(/,/, $FRM{id}) )
    {
        my $pd = SQLRow("SELECT * FROM a_Posts WHERE Post_ID='$_'");
        next if( !$pd );

        $TPL{POST_ID}     = $pd->{'Post_ID'};
        $TPL{EMAIL}       = $pd->{'Email'};
        $TPL{GALLERY_URL} = $pd->{'Gallery_URL'};
        $TPL{DESCRIPTION} = $pd->{'Description'};
        $TPL{RECIP_URL}   = $pd->{'Recip_URL'};
        $TPL{NUM_PICS}    = $pd->{'Num_Pics'};
        $TPL{CAT_OPTIONS} = getCatOptions($pd->{'Category'});
        $TPL{PERMANENT}   = getPermanent($pd->{'Permanent'});
        $TPL{RATING}      = $pd->{'Rating'};
        $TPL{ICONS}       = getIconSelect($pd->{'Icons'}, $pd->{'Post_ID'});
  
        fparse('_admin_editpostm.htmlt');
     }

    $TPL{FROM}     = $FRM{from};
    $TPL{PAGE}     = $FRM{page};
    $TPL{SHOW}     = $FRM{show};
    $TPL{POST_IDS} = $FRM{id};
    $TPL{DATABASE} = $FRM{db};
    $TPL{DBCAT}    = $FRM{dbcat};
    
    fparse('_admin_editpostb.htmlt');
}



sub displayPosts
{
    my %qualifier = (
                      'Queue'   => "Approved='0' AND Confirmed='1' ORDER BY Approve_Date ASC",
                      'Current' => "Approved='1' AND Confirmed='1' AND Archived='0' ORDER BY Approve_Date DESC",
                      'archive' => "Approved='1' AND Confirmed='1' AND Archived='1' AND Category='$FRM{db}' ORDER BY Approve_Date DESC"
                    );

    $FRM{page} = 0 if( $FRM{page} < 0 );

    my $qual = $qualifier{$FRM{db}} ? $qualifier{$FRM{db}} : $qualifier{archive};

    $qual = "Category='$FRM{dbcat}' AND $qual" if( $qualifier{$FRM{db}} && $FRM{dbcat} );

    $TPL{MESSAGE}  = shift;
    $TPL{SHOW}     = $FRM{show};
    $TPL{TOTAL}    = SQLCount("SELECT COUNT(*) FROM a_Posts WHERE $qual");
    $TPL{START}    = getStart($TPL{TOTAL}, $FRM{show});
    $TPL{END}      = getEnd($TPL{TOTAL}, $FRM{show}, $TPL{START});
    $TPL{NEXT}     = $TPL{TOTAL} > $TPL{END} ? qq|<option value="displayPosts">Display Next Page</option>| : '';
    $TPL{PAGE}     = $FRM{page} + 1;
    $TPL{JUMP}     = getJump($TPL{TOTAL}, $FRM{show});
    $TPL{DATABASE} = $FRM{db};
    $TPL{DBCAT}    = $FRM{dbcat} if( $qualifier{$FRM{db}} );
    $TPL{SQL_DATE} = $FRM{date} ? $FRM{date} : fdate('%Y-%m-%d');

    my $limit = $TPL{TOTAL} ? ($TPL{START} - 1) : 0;
    my $sth   = SQLQuery("SELECT *,UNIX_TIMESTAMP(Approve_Date) AS Timestamp,UNIX_TIMESTAMP(Submit_Date) AS Submit_Time FROM a_Posts WHERE $qual LIMIT $limit,$TPL{SHOW}");


    if( $FRM{db} eq 'Queue' )
    {
        fparse('_admin_queuet.htmlt');
        printPosts('queue', $sth);
        fparse('_admin_queueb.htmlt');
    }
    else
    {
        if( $FRM{db} eq 'Current' )
        {
            $TPL{ARCHIVE} = qq|<option value="archivePosts">Archive Selected Posts</option>|;
        }
        else
        {
            $TPL{ARCHIVE} = qq|<option value="unarchivePosts">Un-Archive Selected Posts</option>|;
        }

        fparse('_admin_postst.htmlt');
        printPosts('posts', $sth);
        fparse('_admin_postsb.htmlt');
    }

    $sth->finish;
}



sub displayAddPartner
{
    $TPL{MESSAGE}     = shift;
    $TPL{ICON_SELECT} = getIconSelect();

    fparse('_admin_apartner.htmlt');
}



sub displayAllPartners
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_partnerst.htmlt');
    printPartners();
    fparse('_admin_partnersb.htmlt');
}



sub displayEditPartner
{
    derr(1036) if( !hasAccess('Priv_Partner') );

    my $id = (split(/,/, $FRM{id}))[0];

    derr(1000, 'Partner ID') if( !$id );

    my $partner = SQLRow("SELECT * FROM a_Partners WHERE Partner_ID='$id'");
    derr(1035,) if( !$partner );


    $TPL{USERNAME} = $partner->{'Partner_ID'};
    $TPL{EMAIL}    = $partner->{'Email'};
    $TPL{NAME}     = $partner->{'Name'};
    $TPL{SITE_URL} = $partner->{'Site_URL'};
    $TPL{PASSWORD} = $partner->{'Password'};
    $TPL{RATING}   = $partner->{'Rating'};
    $TPL{APPROVE}  = $partner->{'Auto_Approve'};
    $TPL{ICONS}    = getIconSelect($partner->{'Icons'});

    if( $TPL{APPROVE} )
    {
        $TPL{YES} = ' selected';
    }
    else
    {
        $TPL{NO} = ' selected';
    }

    fparse('_admin_epartner.htmlt');
}



sub displayEditMod
{
    derr(1036) if( !hasAccess('Priv_Moderator') );

    my $id = (split(/,/, $FRM{id}))[0];

    derr(1000, 'Moderator ID') if( !$id );

    my $mod = SQLRow("SELECT * FROM a_Moderators WHERE Moderator_ID='$id'");
    derr(1035) if( !$mod );


    $TPL{NAME}     = $mod->{'Name'};
    $TPL{EMAIL}    = $mod->{'Email'};
    $TPL{USERNAME} = $mod->{'Moderator_ID'};
    $TPL{PASSWORD} = $mod->{'Password'};
    $TPL{SUPER}    = getCheckbox($mod->{'Priv_Super'});   
    $TPL{PST}      = getCheckbox($mod->{'Priv_Posts'});
    $TPL{SET}      = getCheckbox($mod->{'Priv_Setup'});
    $TPL{HTM}      = getCheckbox($mod->{'Priv_HTML'});
    $TPL{BLK}      = getCheckbox($mod->{'Priv_Ban'});
    $TPL{EML}      = getCheckbox($mod->{'Priv_Mail'});
    $TPL{PRT}      = getCheckbox($mod->{'Priv_Partner'});
    $TPL{MOD}      = getCheckbox($mod->{'Priv_Moderator'});
    $TPL{CHT}      = getCheckbox($mod->{'Priv_Cheat'});

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
    $TPL{DBCAT}    = $FRM{dbcat};
    $TPL{TO}       = $FRM{id};
    $TPL{SHOW}     = $FRM{show};
    $TPL{PAGE}     = $FRM{page} - 1;
    $TPL{FROM}     = $FRM{from};

    fparse('_admin_mail.htmlt');
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
    stripHTML(\$DATE);

    $TPL{HTML}     = $HTML;
    $TPL{TEMP}     = $TEMP;
    $TPL{DATE}     = $DATE;
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
    $TPL{MESSAGE}     = shift;
    $TPL{ICON_SELECT} = getIconSelect();

    for( split(/,/, $CATEGORIES) )
    {
        $TPL{CAT_OPTIONS} .= qq|<option value="$_">$_</option>\n|;
    }

    fparse('_admin_manual.htmlt');
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



sub displayCheats
{
    $TPL{MESSAGE} = shift;

    fparse('_admin_cheatt.htmlt');
    printCheats();
    tprint('_admin_cheatb.htmlt');
}



sub displayImport
{
    fparse('_admin_import.htmlt');
}



sub displayAnalysis
{
    derr(1044) if( !-f "$DDIR/$FRM{file}" );

    tprint('_admin_analyzet.htmlt');

    my $line   = freadline("$DDIR/$FRM{file}");
    my @fields = split(/\Q$FRM{delim}\E/, $line);



    for( $i=0; $i<=$#fields; $i++ )
    {
        print <<HTML;
        <tr bgcolor="#ececec">
        <td width="10%" align="center">
        <font face="Verdana" size="2" style="font-size: 11px;">
        $i
        </font>
        </td>
        <td width="75%">
        <font face="Verdana" size="2" style="font-size: 11px;">
        $fields[$i]
        </font>
        </td>
        <td width="15%">
        <select name="field_$i" style="font-size: 11px; font-family: Verdana">
          <option value="Category">Category</option>
          <option value="Gallery_URL">Gallery URL</option>
          <option value="Recip_URL">Recip URL</option>
          <option value="Description">Description</option>
          <option value="Email">E-mail</option>
          <option value="Submit_Date">Submit Date</option>
          <option value="Approve_Date">Approve Date</option>
          <option value="Num_Pics"># of Images</option>
          <option value="Rating">Rating</option>
          <option value="IGNORE">IGNORE</option>
        </select>
        </td>
        </tr>
HTML
    }

    $TPL{FILE}  = $FRM{file};
    $TPL{DELIM} = $FRM{delim};

    fparse('_admin_analyzeb.htmlt');
}



sub displaySearch
{
    my $sth = SQLQuery("SELECT * FROM a_Posts WHERE $FRM{field} LIKE '%$FRM{key}%'");

    $TPL{RESULTS}  = $sth->rows;
    $TPL{DATABASE} = $FRM{sdb};
    $TPL{KEYWORD}  = $FRM{key};

    fparse('_admin_searcht.htmlt');
    printPosts('search', $sth);
    fparse('_admin_searchb.htmlt');

    $sth->finish;
}


###############################################################################################



sub rebuildAll
{
    fwrite("$DDIR/autoapp", time);

    doArchive();
    buildMain();
    buildArchives();
    displayMain('All pages have been rebuilt');
}



sub rebuildMain
{
    fwrite("$DDIR/autoapp", time);

    doArchive();
    buildMain();
    displayMain('Main pages have been rebuilt');
}



sub rebuildArchives
{
    fwrite("$DDIR/autoapp", time);

    doArchive();
    buildArchives();
    displayMain('Archive pages have been rebuilt');
}



sub processPosts
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    derr(1000, 'No Submissions Selected') if( !$FRM{id} && !$FRM{rej} && !$FRM{ban} );
    my( @apr, @rej, @ban );


    ## Process the banned submissions
    for( split(/,/, $FRM{ban}) )
    {
        my $id = $_;
        my $pd = SQLRow("SELECT * FROM a_Posts WHERE Post_ID='$id'");
        next if( !$pd );

        $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$id'") || SQLErr($DBH->errstr());
         
        $DEL = "\n";
        dbinsert("$DDIR/dbs/email.ban", $pd->{'Email'});
        dbinsert("$DDIR/dbs/url.ban",   $pd->{'Gallery_URL'});
        $DEL = '|';
    }


    ## Process the rejected submissions
    for( split(/,/, $FRM{rej}) )
    {
        my $id = $_;
        my $pd = SQLRow("SELECT *,UNIX_TIMESTAMP(Submit_Date) AS Timestamp FROM a_Posts WHERE Post_ID='$id'");
        next if( !$pd );

        $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$id'") || SQLErr($DBH->errstr());
        
        $pd->{'Reject_ID'} = $FRM{"rej_$_"};

        push(@rej, $pd) if( $pd->{'Send_Email'} && $pd->{'Reject_ID'} ne 'none' );
    }


    ## Process the approved submissions
    for( split(/,/, $FRM{id}) )
    {
        my $id = $_;

        my $pd = SQLRow("SELECT *,UNIX_TIMESTAMP(Submit_Date) AS Timestamp FROM a_Posts WHERE Post_ID='$id'");
        next if( !$pd );

        $DBH->do("UPDATE a_Posts SET " .
                 "Approved='1', " .
                 "Description='" . quotemeta($FRM{"desc_$id"}) . "', " .
                 "Num_Pics='" . $FRM{"pics_$id"} . "', " .
                 "Category='" . quotemeta($FRM{"cat_$id"}) . "', " .
                 "Rating='" . $FRM{"rate_$id"} . "', " .
                 "Approve_Date='$FRM{date} 12:00:00', " .
                 "Moderator='$RMTUSR' " .
                 "WHERE Post_ID='$id'") || SQLErr($DBH->errstr());

        push(@apr, $pd) if( $pd->{'Send_Email'} );
    }

    doArchive();

    $FRM{page}--;

    displayPosts('Selected Submissions Have Been Processed');
 
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;


    ## Fork off to take care of mailing the submitters
    my $pid = fork();
    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        for( @apr )
        {
            $TPL{POST_ID}     = $_->{'Post_ID'};
            $TPL{EMAIL}       = $_->{'Email'};
            $TPL{GALLERY_URL} = $_->{'Gallery_URL'};
            $TPL{DESCRIPTION} = $_->{'Description'};
            $TPL{RECIP_URL}   = $_->{'Recip_URL'};
            $TPL{NUM_PICS}    = $_->{'Num_Pics'};
            $TPL{CATEGORY}    = $_->{'Category'};
            $TPL{SUBMIT_DATE} = fdate($DATE_FORMAT, $_->{'Timestamp'}); 
            $TPL{SUBMIT_TIME} = ftime($TIME_FORMAT, $_->{'Timestamp'});

            mail($SENDMAIL, freadalls("$TDIR/_email_approved.etmpl"), \%TPL);
        }

        for( @rej )
        {
            $TPL{POST_ID}     = $_->{'Post_ID'};
            $TPL{EMAIL}       = $_->{'Email'};
            $TPL{GALLERY_URL} = $_->{'Gallery_URL'};
            $TPL{DESCRIPTION} = $_->{'Description'};
            $TPL{RECIP_URL}   = $_->{'Recip_URL'};
            $TPL{NUM_PICS}    = $_->{'Num_Pics'};
            $TPL{CATEGORY}    = $_->{'Category'};
            $TPL{SUBMIT_DATE} = fdate($DATE_FORMAT, $_->{'Timestamp'}); 
            $TPL{SUBMIT_TIME} = ftime($TIME_FORMAT, $_->{'Timestamp'});

            mail($SENDMAIL, freadalls("$DDIR/mails/$pd->{'Reject_ID'}"), \%TPL);
        }

        exit;
    }
}



sub backupData
{
    derr(1036) if( !hasAccess('Priv_Setup') );

    derr(1000, 'HTML Backup Filename') if( !$FRM{html} );
    derr(1000, 'SQL Backup Filename') if( !$FRM{sql} );

    fwrite("$DDIR/$FRM{html}");

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        my @dirs = qw( banned dbs html icons links mails );

        foreach $dir ( @dirs )
        {
            for( @{ dread("$DDIR/$dir", '^[^.]') } )
            {
                if( -f "$DDIR/$dir/$_" )
                {
                    fappend("$DDIR/$FRM{html}", "Database: $dir/$_\n<<<");
                    open(DB, "$DDIR/$dir/$_") || err("$!", "$DDIR/$dir/$_");
                    flock(DB, $LOCK_EX);
                    while( <DB> )
                    {
                        fappend("$DDIR/$FRM{html}", $_);
                    }
                    fappend("$DDIR/$FRM{html}", ">>>\n");
                    flock(DB, $LOCK_UN);
                    close(DB);
                }
            }
        }

        system("$MYSQLDUMP -h$HOSTNAME -u$USERNAME -p$PASSWORD $DATABASE >$DDIR/$FRM{sql}");

        exit;
    }

    else
    {
        fwrite("$DDIR/backup", time);
        displayMain("Databases are now being backed up.<br>Allow at least 60 seconds for this process to complete.");
    }
}



sub restoreData
{
    derr(1036) if( !hasAccess('Priv_Setup') );

    derr(1000, 'HTML Backup Filename') if( !$FRM{html} );
    derr(1000, 'SQL Backup Filename') if( !$FRM{sql} );

    freadline("$DDIR/$FRM{html}");
    freadline("$DDIR/$FRM{sql}");

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        open(BAK, "$DDIR/$FRM{html}") || err("$!", "$DDIR/$FRM{html}");

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

        system("$MYSQL -f -h$HOSTNAME -u$USERNAME -p$PASSWORD $DATABASE <$DDIR/$FRM{sql}");

        SQLConnect();

        my $sth = SQLQuery("SELECT * FROM a_Moderators");

        $DEL = ':';
        while( $mod = $sth->fetchrow_hashref )
        {
            dbinsert('./admin/.htpasswd', $mod->{'Moderator_ID'}, crypt($mod->{'Password'}, getsalt()));
        }
        $DEL = '|';

        $sth->finish;

        exit;
    }

    else
    {
        displayMain("Databases are now being restored.<br>Allow at least 60 seconds for this process to complete.");
    }
}



sub importGalleries
{
    my %index = ();
    my $count = 0;

    for( keys %FRM )
    {
        my $key = $_;

        if( $index{$FRM{$key}} )
        {
            derr(1045);
        }

        if( $key =~ /^field_(\d+)/gi )
        {
            $index{$FRM{$key}} = $1 + 1;
        }
    }


    for( @{freadall("$DDIR/$FRM{file}")} )
    {
        $_ =~ s/'/\\'/g;
        $_ =~ s/\n|\r//g;

        my @data = split(/\Q$FRM{delim}\E/, $_);
        unshift(@data, '');

        my $partial = getPartialURL($data[$index{'Gallery_URL'}]);
        my $sdate   = "'$data[$index{'Submit_Date'}]'";
        my $adate   = "'$data[$index{'Approve_Date'}]'";
        my $mod     = $FRM{approved} ? $RMTUSR : '-';
        my $rating  = $data[$index{'Rating'}];

        if( !$index{'Approve_Date'} )
        {
            $sdate = 'NOW()';
        }

        if( !$index{'Submit_Date'} )
        {
            $adate = 'NOW()';
        }

        if( !$index{'Rating'} )
        {
            $rating = 1;
        }

        $DBH->do("INSERT INTO a_Posts VALUES (" .
                 "NULL, " .
                 "'$data[$index{'Email'}]', " . 
                 "'$data[$index{'Gallery_URL'}]', " . 
                 "'$data[$index{'Description'}]', " .
                 "'$data[$index{'Recip_URL'}]', " .
                 "'$partial', " . 
                 "'$data[$index{'Num_Pics'}]', " .
                 "'$data[$index{'Category'}]', " .
                 "$sdate, " .
                 "$adate, " .
                 "'-', " .
                 "'$mod', " .
                 "'', " .
                 "'1', " .
                 "'0', " .
                 "'$FRM{approved}', " .
                 "'0', " .
                 "'1', " .
                 "'0', " .
                 "'0', " .
                 "'$RMTADR', " .
                 "'', " .
                 "'$rating', " .
                 "'-', " .
                 "'0', " .
                 "'0', " .
                 "'0', " .
                 "'0' )") || SQLErr($DBH->errstr());

        $count++;
    }

    displayMain("$count Galleries Imported");
}



sub manualSubmit
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    derr(1006                 ) if( $FRM{email} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl}  !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/               );

    my $partial = getPartialURL($FRM{gurl});  
    
    for( keys %FRM  ) { $FRM{$_} =~ s/'/\\'/g; }

    $DBH->do("INSERT INTO a_Posts VALUES (" .
         "NULL, " .
         "'$FRM{email}', " .
         "'$FRM{gurl}', " . 
         "'$FRM{desc}', " . 
         "'$FRM{rurl}', " .
         "'$partial', " .
         "'$FRM{pics}', " .
         "'$FRM{cat}', " .
         "NOW(), " .
         "NOW(), " .
         "'-', " .
         "'$RMTUSR', " .
         "'', " .
         "'1', " .
         "'1', " .
         "'1', " .
         "'0', " .
         "'$FRM{perm}', " .
         "'0', " .
         "'0', " .
         "'$RMTADR', " .
         "'$FRM{icon}', " .
         "'$FRM{rate}', " .
         "'-', " .
         "'-', " .
         "'-', " .
         "'-', " .
         "'-' )") || SQLErr($DBH->errstr());

    my $pid = $DBH->{'mysql_insertid'};

    displayManual("Submission added and assigned ID $pid");
}



sub editPosts
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    for( keys %FRM ) { $FRM{$_} =~ s/'/\\'/g; }

    for( split(/,/, $FRM{ids}) )
    {
        $DBH->do("UPDATE a_Posts SET " .
                 "Email='" . $FRM{"email_$_"} . "', " .
                 "Gallery_URL='" . $FRM{"gurl_$_"} . "', " .
                 "Description='" . $FRM{"desc_$_"} . "', " .
                 "Recip_URL='" . $FRM{"rurl_$_"} . "', " .
                 "Num_Pics='" . $FRM{"pics_$_"} . "', " .
                 "Category='"  . $FRM{"cat_$_"} . "', " .
                 "Permanent='" . $FRM{"perm_$_"} . "', " .
                 "Rating='" . $FRM{"rate_$_"} . "', " . 
                 "Icons='" . $FRM{"icon_$_"} . "' " .
                 "WHERE Post_ID='$_'") || SQLErr($DBH->errstr());
    }

    $FRM{page}--;

    &{$FRM{from}}("Post IDs $FRM{ids} Have Been Updated");
}



sub deletePosts
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    for( split(/,/, $FRM{id}) )
    {
        $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$_'") || SQLErr($DBH->errstr());
    }

    $FRM{page}--;

    &{$FRM{from}}("The selected posts have been deleted");
}



sub unarchivePosts
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    my $time = time + 3600 * $TIME_ZONE;
    my $date = fdate('%Y%m%d', $time);

    for( split(/,/, $FRM{id}) )
    {
        $DBH->do("UPDATE a_Posts SET Approve_Date=NOW(), Approved='1', Archived='0' WHERE Post_ID='$_'") || SQLErr($DBH->errstr());
    }

    $FRM{page}--;

    &{$FRM{from}}("The selected posts have been Un-Archived");
}



sub archivePosts
{
    derr(1036) if( !hasAccess('Priv_Posts') );

    for( split(/,/, $FRM{id}) )
    {
        $DBH->do("UPDATE a_Posts SET Approved='1', Archived='1' WHERE Post_ID='$_'") || SQLErr($DBH->errstr());
    }

    $FRM{page}--;

    &{$FRM{from}}("The selected posts have been archived");
}



sub editPartner
{
    derr(1036) if( !hasAccess('Priv_Partner') );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( $FRM{$_} eq '' );
        $FRM{$_} =~ s/'/\\'/g;
    }

    $DBH->do("UPDATE a_Partners SET " .
             "Email='$FRM{mail}', " .
             "Name='$FRM{name}', " . 
             "Site_URL='$FRM{surl}', " .
             "Password='$FRM{pass}', " .
             "Icons='$FRM{icon}', " .
             "Rating='$FRM{rate}', " .
             "Auto_Approve='$FRM{app}' " .
             "WHERE Partner_ID='$FRM{user}'") || SQLErr($DBH->errstr());


    $DBH->do("UPDATE a_Posts SET Icons='$FRM{icon}' WHERE Partner_ID='$FRM{user}'") || SQLErr($DBH->errstr());

    displayAllPartners("Partner '$FRM{user}' Has Been Updated");
}



sub deletePartners
{
    derr(1036) if( !hasAccess('Priv_Partner') );

    for( split(/,/, $FRM{id}) )
    {
        my $id = $_;
        $DBH->do("DELETE FROM a_Partners WHERE Partner_ID='$id'") || SQLErr($DBH->errstr());
        $DBH->do("DELETE FROM a_Posts WHERE Partner_ID='$id'") || SQLErr($DBH->errstr());
    }

    displayAllPartners("Selected Partners Have Been Deleted");
}



sub addPartner
{
    derr(1036) if( !hasAccess('Priv_Partner') );

    derr(1032) if( length($FRM{user}) > 8            );
    derr(1033) if( $FRM{user} !~ m/^[a-zA-Z0-9]*$/gi );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
        $FRM{$_} =~ s/'/\\'/g;
    }

    $DBH->do("INSERT INTO a_Partners VALUES ( '$FRM{user}', '$FRM{mail}', '$FRM{name}', '$FRM{surl}', '$FRM{pass}', '$FRM{icon}', '$FRM{rate}', '$FRM{app}' )") || SQLErr($DBH->errstr());

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
    derr(1036) if( !hasAccess('Priv_Moderator') );

    derr(1032) if( length($FRM{user}) > 8            );
    derr(1033) if( $FRM{user} !~ m/^[a-zA-Z0-9]*$/gi );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
        $FRM{$_} =~ s/'/\\'/g;
    }

    $DBH->do("INSERT INTO a_Moderators VALUES ( '$FRM{user}', '$FRM{mail}', '$FRM{name}', '$FRM{pass}', '$FRM{super}', '$FRM{pst}', '$FRM{set}', '$FRM{htm}', '$FRM{blk}', '$FRM{eml}', '$FRM{prt}', '$FRM{mod}', '$FRM{cht}' )") || SQLErr($DBH->errstr());

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
    derr(1036) if( !hasAccess('Priv_Moderator') );

    for( keys %FRM )
    {
        derr(1000, 'All Fields Are Required') if( !$FRM{$_} );
        $FRM{$_} =~ s/'/\\'/g;
    }

    $DBH->do("UPDATE a_Moderators SET " .
             "Email='$FRM{mail}', " .
             "Name='$FRM{name}', " .
             "Password='$FRM{pass}', " .
             "Priv_Super='$FRM{super}', " .
             "Priv_Posts='$FRM{pst}', " .
             "Priv_Setup='$FRM{set}', " . 
             "Priv_HTML='$FRM{htm}', " .
             "Priv_Ban='$FRM{blk}', " .
             "Priv_Mail='$FRM{eml}', " .
             "Priv_Partner='$FRM{prt}', " .
             "Priv_Moderator='$FRM{mod}', " .
             "Priv_Cheat='$FRM{cht}' " .
             "WHERE Moderator_ID='$FRM{user}'") || SQLErr($DBH->errstr());

    $DEL = ':';
    my $res = dbupdate('./admin/.htpasswd', $FRM{user}, $FRM{user}, crypt($FRM{pass}, getsalt()));
    derr(1035) if( !$res );
    $DEL = '|';

    displayAllMods("Moderator '$FRM{user}' Has Been Updated");
}



sub deleteModerators
{
    derr(1036) if( !hasAccess('Priv_Moderator') );

    for( split(/,/, $FRM{id}) )
    {
        $DBH->do("DELETE FROM a_Moderators WHERE Moderator_ID='$_'") || SQLErr($DBH->errstr());

        $DEL = ':';
        dbdelete('./admin/.htpasswd', $_);
        $DEL = '|';
    }

    displayAllMods("Selected Moderators Have Been Deleted");
}



##  Edit icon functions 
sub deleteIcon
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}" );
    fremove("$DDIR/icons/$FRM{id}");
    delete $FRM{id};
    displayIcons("Selected Icon Has Been Deleted");
}



sub loadIcon
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !$FRM{id} || !-e "$DDIR/icons/$FRM{id}");
    displayIcons("Loaded Icon With ID '$FRM{id}'", freadalls("$DDIR/icons/$FRM{id}"));
}



sub saveIcon
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r|\n$//g;
    fwrite("$DDIR/icons/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayIcons("Icon Data Has Been Saved");
}



##  Edit Rejection e-mail functions 
sub deleteReject
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/mails/$FRM{id}");
    delete $FRM{id};
    displayReject("Selected Rejection E-mail Has Been Deleted");
}



sub loadReject
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/mails/$FRM{id}" || !$FRM{id});
    displayReject("Loaded Rejection E-mail With ID '$FRM{id}'", freadalls("$DDIR/mails/$FRM{id}"));
}



sub saveReject
{
    derr(1036) if( !hasAccess('Priv_HTML') );

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
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/links/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/links/$FRM{id}");
    delete $FRM{id};
    displayRecip("Selected Reciprocal Link Has Been Deleted");
}



sub loadRecip
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/links/$FRM{id}" || !$FRM{id});
    displayRecip("Loaded HTML For Reciprocal Link '$FRM{id}'", freadalls("$DDIR/links/$FRM{id}"));
}



sub saveRecip
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r//g;
    fwrite("$DDIR/links/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayRecip("Reciprocal Link Has Been Saved");
}



##  Edit reciprocal link functions
sub deleteBannedHTML
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/banned/$FRM{id}" || !$FRM{id} );
    fremove("$DDIR/banned/$FRM{id}");
    delete $FRM{id};
    displayBanned("Selected HTML Ban Has Been Deleted");
}



sub loadBannedHTML
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !-e "$DDIR/banned/$FRM{id}" || !$FRM{id});
    displayBanned("Loaded Data For HTML Ban '$FRM{id}'", freadalls("$DDIR/banned/$FRM{id}"));
}



sub saveBannedHTML
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    derr(1029) if( !$FRM{id} );
    $FRM{id}   =~ s/ /_/g;
    $FRM{html} =~ s/\r//g;
    fwrite("$DDIR/banned/$FRM{id}", "$FRM{html}\n");
    delete $FRM{id};
    displayBanned("HTML Ban Has Been Saved");
}



##  Edit Blacklist Functions
sub addBan
{
    derr(1036) if( !hasAccess('Priv_Ban') );

    $FRM{ban} =~ s/\r//g;
    derr(1028) if( !$FRM{ban} || $FRM{ban} =~ /^\n/m );

    $DEL = "\n";
    dbinsert("$DDIR/dbs/$FRM{type}.ban", $FRM{ban});
    $DEL = '|';

    displayBans("$FRM{ban} Added To the $FRM{type} Blacklist");
}



sub removeBan
{
    derr(1036) if( !hasAccess('Priv_Ban') );

    $FRM{ban} =~ s/\r//g;

    $DEL = "\n";
    for( split(/\n/, $FRM{ban}) )
    {
        dbdelete("$DDIR/dbs/$FRM{type}.ban", $_);
    }
    $DEL = '|';

    displayBans("$FRM{ban} removed from the $FRM{type} blacklist");
}



sub mailPosters
{
    derr(1036) if( !hasAccess('Priv_Mail') );

    derr(1000, 'Subject') if( !$FRM{sub} );

    &{$FRM{from}}('Selected Posters Have Been E-mailed');
  
    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        SQLConnect();

        for( split(/,/, $FRM{to}) )
        {
            my $post = SQLRow("SELECT *,UNIX_TIMESTAMP(Submit_Date) AS Timestamp FROM a_Posts WHERE Post_ID='$_'");
            next if( !$post );

            $TPL{POST_ID}      = $post->{'Post_ID'};
            $TPL{EMAIL}        = $post->{'Email'};
            $TPL{GALLERY_URL}  = $post->{'Gallery_URL'};
            $TPL{DESCRIPTION}  = $post->{'Description'};
            $TPL{RECIP_URL}    = $post->{'Recip_URL'};
            $TPL{NUM_PICS}     = $post->{'Num_Pics'};
            $TPL{CATEGORY}     = $post->{'Category'};
            $TPL{SUBMIT_DATE}  = fdate($DATE_FORMAT, $post->{'Timestamp'});
            $TPL{SUBMIT_TIME}  = ftime($TIME_FORMAT, $post->{'Timestamp'});
            $TPL{ADMIN_EMAIL}  = $ADMIN_EMAIL;

            my $msg = "To: $post->{'Email'}\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }

        exit;
    }
}



sub mailModerators
{
    derr(1036) if( !hasAccess('Priv_Mail') );

    derr(1000, 'Subject') if( !$FRM{sub} );

    displayAllMods('Selected Moderators Have Been E-mailed');

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        SQLConnect();

        for( split(/,/, $FRM{to}) )
        {
            my $mod = SQLRow("SELECT * FROM a_Moderators WHERE Moderator_ID='$_'");
            next if( !$mod );

            $TPL{USERNAME}    = $mod->{'Moderator_ID'};
            $TPL{NAME}        = $mod->{'Name'};
            $TPL{PASSWORD}    = $mod->{'Password'};
            $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

            my $msg = "To: $mod->{'Email'}\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }

        SQLDisconnect();

        exit;
    }
}



sub mailPartners
{
    derr(1036) if( !hasAccess('Priv_Mail') );

    derr(1000, 'Subject') if( !$FRM{sub} );

    displayAllPartners('Selected Partners Have Been E-mailed');

    my $pid = fork();

    if( !$pid )
    {
        close STDIN; close STDOUT; close STDERR;

        SQLConnect();

        for( split(/,/, $FRM{to}) )
        {
            my $partner = SQLRow("SELECT * FROM a_Partners WHERE Partner_ID='$_'");
            next if( !$partner );

            $TPL{USERNAME}    = $partner->{'Partner_ID'};
            $TPL{NAME}        = $partner->{'Name'};
            $TPL{PASSWORD}    = $partner->{'Password'};
            $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

            my $msg = "To: $partner->{'Email'}\nFrom: $ADMIN_EMAIL\nSubject: $FRM{sub}\n\n$FRM{bod}";

            mail($SENDMAIL, \$msg, \%TPL);
        }

        SQLDisconnect();

        exit;

    }
}



sub saveLangSettings
{
    derr(1036) if( !hasAccess('Priv_Setup') );

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



sub restoreTemplate
{
    derr(1036) if( !hasAccess('Priv_HTML') );

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
    derr(1036) if( !hasAccess('Priv_Posts') );

    derr(1026) if( $FRM{date} !~ /\d{4}-\d{2}-\d{2}/ );

    $DBH->do("DELETE FROM a_Posts WHERE Approved='0' AND Confirmed='1' AND DATE_FORMAT(Submit_Date, '%Y-%m-%d') < '$FRM{date}'") || SQLErr($DBH->errstr());

    displayMain("Old posts have been removed from the queue");
}



sub enablePost
{
    derr(1036) if( !hasAccess('Priv_Setup') );

    fremove("$DDIR/disabled");
    displayMain("post.cgi Has Been Enabled");
}



sub disablePost
{
    derr(1036) if( !hasAccess('Priv_Setup') );

    fcreate("$DDIR/disabled");
    displayMain("post.cgi Has Been Disabled");
}



sub updateHTML
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    $FRM{html} =~ s/\r//gi;
    $FRM{html} =~ s/\n+$//g;
    $FRM{temp} =~ s/\r//gi;
    $FRM{temp} =~ s/\n+$//g;
  
    for( split(/,/, $FRM{pages}) )
    {
        fwrite("$DDIR/html/$_", qq|\n\n# DO NOT EDIT THIS FILE\n\n\n\$HTML = <<'HTML';\n$FRM{html}\nHTML\n\n\$TEMP = <<'TEMP';\n$FRM{temp}\nTEMP\n\n\$DATE = <<'DATE';\n$FRM{date}\nDATE\n\n1;\n|);
    }

    displayMain("HTML successfully updated");
}



sub updateTemplate
{
    derr(1036) if( !hasAccess('Priv_HTML') );

    $FRM{html} =~ s/\r//gi;
    $FRM{html} =~ s/\n+$//g;
    fwrite("$TDIR/$FRM{template}", $FRM{html});
    displayMain("The $FRM{template} template has been updated");
}



sub cheatNothing
{
    derr(1036) if( !hasAccess('Priv_Cheat') );

    for( split(/,/, $FRM{id}) )
    {
        $DBH->do("DELETE FROM a_Cheats WHERE Cheat_ID='$_'") || SQLErr($DBH->errstr());
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



sub cheatDelete
{
    derr(1036) if( !hasAccess('Priv_Cheat') );

    for( split(/,/, $FRM{id}) )
    {
        my $id = $_;

        my $cheat = SQLRow("SELECT * FROM a_Cheats,a_Posts WHERE a_Cheats.Post_ID=a_Posts.Post_ID AND Cheat_ID='$id'");
        next if( !$cheat );

        $DBH->do("DELETE FROM a_Cheats WHERE Cheat_ID='$id'") || SQLErr($DBH->errstr());
        $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$cheat->{'Post_ID'}'") || SQLErr($DBH->errstr());
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



sub cheatBan
{
    derr(1036) if( !hasAccess('Priv_Cheat') );

    for( split(/,/, $FRM{id}) )
    {
        my $id = $_;

        my $cheat = SQLRow("SELECT * FROM a_Cheats,a_Posts WHERE a_Cheats.Post_ID=a_Posts.Post_ID AND Cheat_ID='$id'");
        next if( !$cheat );

        $DBH->do("DELETE FROM a_Cheats WHERE Cheat_ID='$id'") || SQLErr($DBH->errstr());
        $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$cheat->{'Post_ID'}'") || SQLErr($DBH->errstr());

        $DEL = "\n";
        dbinsert("$DDIR/dbs/email.ban", $cheat->{'Email'} );
        dbinsert("$DDIR/dbs/url.ban",   $cheat->{'Gallery_URL'} );
        $DEL = '|';
    }

    displayCheats("Selected Cheat Reports Have Been Processed");
}



sub printCheats
{
    my $cheat;

    my $sth = SQLQuery("SELECT *,a_Cheats.Description AS Cheat_Desc FROM a_Cheats,a_Posts WHERE a_Cheats.Post_ID=a_Posts.Post_ID");

    while( $cheat = $sth->fetchrow_hashref )
    {
        $TPL{CHEAT_ID}    = $cheat->{'Cheat_ID'};
        $TPL{SUBMIT_IP}   = $cheat->{'IP_Address'};
        $TPL{POST_ID}     = $cheat->{'Post_ID'};
        $TPL{GALLERY_URL} = $cheat->{'Gallery_URL'};
        $TPL{EMAIL}       = $cheat->{'Email'};
        $TPL{DESCRIPTION} = $cheat->{'Cheat_Desc'};

        fparse('_admin_cheatm.htmlt');
    }

    $sth->finish;
}



sub printModerators
{
    my $mod;

    my $sth = SQLQuery("SELECT * FROM a_Moderators");

    while( $mod = $sth->fetchrow_hashref )
    {
        $TPL{USERNAME} = $mod->{'Moderator_ID'};
        $TPL{EMAIL}    = $mod->{'Email'};
        $TPL{NAME}     = $mod->{'Name'};

        fparse('_admin_modsm.htmlt');
    }

    $sth->finish;
}



sub printPartners
{
    my $partner;
    
    my $sth = SQLQuery("SELECT * FROM a_Partners");

    while( $partner = $sth->fetchrow_hashref ) 
    {
        $TPL{USERNAME} = $partner->{'Partner_ID'};
        $TPL{EMAIL}    = $partner->{'Email'};
        $TPL{NAME}     = $partner->{'Name'};
        $TPL{SITE_URL} = $partner->{'Site_URL'};

        fparse('_admin_partnersm.htmlt');
    }

    $sth->finish;
}



sub printPosts
{
    my($page, $sth) = @_;
    my $post;
  
    for( @{ dread("$DDIR/mails", '^[^.]') } ) {
        $TPL{REJ} .= qq|<option value="$_">$_</option>\n|;
    }

    while( $post = $sth->fetchrow_hashref )
    {
        $TPL{POST_ID}       = $post->{'Post_ID'};
        $TPL{EMAIL}         = $post->{'Email'};
        $TPL{GALLERY_URL}   = $post->{'Gallery_URL'};
        $TPL{NUM_PICS}      = $post->{'Num_Pics'};
        $TPL{CATEGORY}      = $post->{'Category'};
        $TPL{CAT_OPTIONS}   = getCatOptions($post->{'Category'});
        $TPL{PARTNER_ID}    = $post->{'Partner_ID'};
        $TPL{APPROVED_BY}   = $post->{'Moderator'};
        $TPL{APPROVE_TIME}  = fdate($DATE_FORMAT, $post->{'Timestamp'}) . ' ' . ftime($TIME_FORMAT, $post->{'Timestamp'});
        $TPL{SUBMIT_TIME}   = fdate($DATE_FORMAT, $post->{'Submit_Time'}) . ' ' . ftime($TIME_FORMAT, $post->{'Submit_Time'});
        $TPL{PERMANENT}     = $post->{'Permanent'} ? $L_YES : $L_NO;
        $TPL{SUBMIT_IP}     = $post->{'IP_Address'};
        $TPL{CODED_RECIP}   = urlencode($post->{'Recip_URL'});
        $TPL{CODED_GURL}    = urlencode($post->{'Gallery_URL'});
        $TPL{CHECK_RECIP}   = $post->{'Recip_URL'} ? 'Check Recip' : '</a>None Provided';
        $TPL{RECIP_CHECKED} = $post->{'Recip_Checked'} ? 'Checked'   : 'Not Checked';
        $TPL{RECIP_FOUND}   = $post->{'Recip_Found'} ? 'Found'     : 'Not Found';
        $TPL{DESCRIPTION}   = $post->{'Description'};
        $TPL{RATING}        = $post->{'Rating'};
        $TPL{THROUGHPUT}    = $post->{'Throughput'};
        $TPL{TOTAL_LINKS}   = $post->{'Banner_Links'} + $post->{'Text_Links'};
        $TPL{R_SELECT}      = "rej_$post->{'Post_ID'}";
        
        fparse('_admin_' . $page . 'm.htmlt');
    }
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
        print qq|<tr bgcolor="#ffffff">\n<td>\n<font face="Verdana" size="2">\n<b>Icon ID:</b> $_\n</font>\n<br>\n| . ${freadalls("$DDIR/icons/$_")} . qq|\n</td>\n</tr>\n|;
    }
}



sub getCheckbox
{
    my $val = shift;
    return ' checked' if( $val );
    return;
}



sub getPages
{
    my $html;

    for( split(/,/, $MAIN_PAGE) )
    {
      $html .= qq|<option value="$_">$_</option>|;
    }

    if( $USE_ARCHIVES )
    {
        for( split(/,/, $CAT_PAGE_LIST) )
        {
            $html .= qq|<option value="$_">$_</option>|;
        }
    }

    return $html;
}



sub getDatabases
{
    my $html;

    if( $USE_ARCHIVES )
    {
        for( split(/,/, $CATEGORIES) )
        {
            $html .= qq|<option value="$_">$_ Archives</option>\n|;
        }
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



sub stripHTML
{
    my($html, $amp) = @_;

    $$html =~ s/&/&amp;/gi if( !$amp );
    $$html =~ s/>/&gt;/gi;
    $$html =~ s/</&lt;/gi;
    $$html =~ s/\"/&quot;/gi;
}



sub quickJump
{
    $FRM{page}--;
    displayPosts();
}



sub getIconSelect
{
    my($icons, $pid) = @_;
    my $html;
    my $name = $pid ? "icon_$pid" : "icon";

    for( @{dread("$DDIR/icons", '^[^.]')} )
    {
        my $id = $_;

        $html .= qq|<input type="checkbox" name="$name" value="$id"> | . ${freadalls("$DDIR/icons/$id")} . qq|&nbsp;&nbsp;&nbsp;|;

        $html =~ s/value="$id"/value="$id" checked/ if( index(",$icons,", ",$id,") != -1 );
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
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
##  post.cgi - handle submission of general posts                  ##
#####################################################################

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

err("$@", 'post.cgi') if( $@ );
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
    if( -e "$DDIR/disabled" )
    {
        tprint('_post_disabled.htmlt');
        exit;
    }

    if( $REQMTH eq "GET" )
    {
        if( $QUERY )
        {
            parseget();
            postConfirm();
        }

        else
        {
            for( split(/,/, $CATEGORIES) )
            {
                $TPL{CAT_OPTIONS} .= qq|<option value="$_">$_</option>\n|;
            }
            fparse('_post_main.htmlt');
        }
        
    }
    elsif( $REQMTH eq "POST" )
    {
        parsepost(1);
        postStandard();
    }
}



sub postStandard
{
    my $checked = 0;
    my $found   = 0;
    my $rating  = 1;


    $FRM{desc}  = $FRM{gdes};
    $FRM{email} = $FRM{mail};
    $FRM{perm}  = $FRM{perm} eq 'Y' ? 1 : 0;
    $FRM{conf}  = $FRM{conf} eq 'Y' ? 1 : 0;

    checkBans();

    $FRM{rurl} = $FRM{gurl}              if( $USE_RECIP_GALLERY || ($USE_CHECK_RECIP && !$FRM{rurl}) );
    $FRM{perm} = 1                       if( !exists $FRM{perm} );
    $FRM{desc} = ucfirst(lc($FRM{desc})) if( $USE_LOWER_CASE    );

    derr(1006                 ) if( $FRM{email} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl}  !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/               );
    derr(1000, $L_RECIP_URL   ) if( $USE_REQ_RECIP && !$FRM{rurl}                                     );
    derr(1000, $L_DESCRIPTION ) if( $USE_REQ_DESC && !$FRM{desc}                                      );
    derr(1008                 ) if( length($FRM{desc}) > $DESC_LENGTH                                 );
    derr(1009                 ) if( index(",$CATEGORIES,", ",$FRM{cat},") == -1                       );
    

    if( !analyzeGallery($FRM{gurl}, \%results) )
    {
        httpError($FRM{gurl}, $Errstr);
    }


    if( $results{'IMAGE_ERROR'} )
    {
        httpError($results{'IMAGE_ERROR_URL'}, $results{'IMAGE_ERROR'});
    }


    if( $USE_CHECK_RECIP )
    {
        if( $results{'RECIP_ERROR'} )
        {
            httpError($FRM{rurl}, $results{'RECIP_ERROR'});
        }
        else
        {
            $checked = 1;
            $found   = $results{'RECIP_LINK'};
            $rating++ if( $USE_RECIP_BOOST && $found );

            derr(1010) if( $USE_REQ_RECIP && !$found );
        }
    }


    if( $USE_BANNED_HTML && $results{'BANNED_HTML'} )
    {
        derr(1013);
    }


    if( $USE_COUNT_PICS )
    {
        $FRM{pics} = $results{'IMAGES'};
    }


    derr(1007) if( $FRM{pics} < $MINIMUM_PICS );
    derr(1040) if( $FRM{pics} > $MAXIMUM_PICS );


    ## Check the number of links on the gallery
    if( $USE_COUNT_LINKS )
    {
        if( $results{'BANNER_LINKS'} + $results{'TEXT_LINKS'} > $MAXIMUM_LINKS )
        {
            derr(1043);
        }
    }


    if( $USE_TAKE_SAMPLE )
    {
        ## Check download speed of gallery content
        if( $results{'THROUGHPUT'} < $MINIMUM_SPEED )
        {
            derr(1041, $results{'THROUGHPUT'});
        }


        ## Check byte size of gallery content
        for( keys %results )
        {
            if( index($_, 'SIZE_') == 0 )
            {
                if( $results{$_} < $IMAGE_SIZE )
                {
                    derr(1042);
                }
            }
        }
    }


    ## Check to see if an identical page exists in the database
    if( $USE_DUP_CONTENT )
    {
        SQLCount("SELECT COUNT(*) FROM a_Posts WHERE Page_ID='$results{'PAGE_ID'}'");
    }

  
    my $partial = getPartialURL($FRM{gurl});  
    checkNumber($partial);

    $TPL{EMAIL}       = $FRM{email};
    $TPL{GALLERY_URL} = $FRM{gurl};
    $TPL{DESCRIPTION} = $FRM{desc};
    $TPL{RECIP_URL}   = $FRM{rurl};
    $TPL{NUM_PICS}    = $FRM{pics};
    $TPL{PERMANENT}   = $FRM{perm} ? $L_YES : $L_NO;
    $TPL{CONFIRM}     = $FRM{conf} ? $L_YES : $L_NO;
    $TPL{CATEGORY}    = $FRM{cat};
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;

    for( keys %FRM ) { $FRM{$_} =~ s/'/\\'/g; }

    
    if( $USE_CONFIRM )
    {
        my $cid = getConfirmID();

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
                 "'-', " .
                 "'$cid', " .
                 "'0', " .
                 "'$FRM{conf}', " .
                 "'0', " .
                 "'0', " .
                 "'$FRM{perm}', " .
                 "'$checked', " .
                 "'$found', " .
                 "'$RMTADR', " .
                 "'', " .
                 "'$rating', " .
                 "'$results{'PAGE_ID'}', " .
                 "'$results{'PAGE_BYTES'}', " .
                 "'$results{'TEXT_LINKS'}', " .
                 "'$results{'BANNER_LINKS'}', " .
                 "'$results{'THROUGHPUT'}' )") || SQLErr($DBH->errstr());
        
        
        $TPL{CONFIRM_URL} = "$CGI_URL/post.cgi?ID=$cid";

        mail($SENDMAIL, freadalls("$TDIR/_email_confirm.etmpl"), \%TPL);

        fparse('_post_confirm.htmlt');
    }

    else
    {
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
                 "'-', " .
                 "'', " .
                 "'1', " .
                 "'$FRM{conf}', " .
                 "'0', " .
                 "'0', " .
                 "'$FRM{perm}', " .
                 "'$checked', " .
                 "'$found', " .
                 "'$RMTADR', " .
                 "'', " .
                 "'$rating', " .
                 "'$results{'PAGE_ID'}', " .
                 "'$results{'PAGE_BYTES'}', " .
                 "'$results{'TEXT_LINKS'}', " .
                 "'$results{'BANNER_LINKS'}', " .
                 "'$results{'THROUGHPUT'}' )") || SQLErr($DBH->errstr());


        $TPL{POST_ID} = $DBH->{'mysql_insertid'};

        $DEL = "\n"; 
        dbinsert("$DDIR/dbs/email.log", $FRM{email}) if( $USE_LOG_EMAIL );
        $DEL = '|';

        if( $USE_AUTO_APPROVE )
        {
            $DBH->do("UPDATE a_Posts SET Approved='1', Moderator='Automatic' WHERE Post_ID=$TPL{POST_ID}") || SQLErr($DBH->errstr());

            fparse('_post_approved.htmlt');

            my $proc = fork();

            if( !$proc )
            {
                close STDIN; close STDOUT; close STDERR;

                if( $AUTO_INTERVAL != -1 && getAge("$DDIR/autoapp") >= $AUTO_INTERVAL )
                {
                    SQLConnect();
                    doArchive();
                    buildMain();
                    buildArchives();
                    SQLDisconnect();

                    fwrite("$DDIR/autoapp", time);
                }

                exit;
            }
        }
        else 
        {
            fparse('_post_queued.htmlt');
        }
    }
}



sub postConfirm
{
    ## Clean out submissions that haven't been confirmed within 24 hours
    my $dayold = time - 86400;
    $DBH->do("DELETE FROM a_Posts WHERE Confirm_ID='0' AND UNIX_TIMESTAMP(Submit_Date) < $dayold") || SQLErr($DBH->errstr());

    my $pd = SQLRow("SELECT * FROM a_Posts WHERE Confirm_ID='$QRY{ID}' AND Confirmed='0'");
    derr(1023) if( !$pd );

    $TPL{POST_ID}     = $pd->{'Post_ID'};
    $TPL{EMAIL}       = $pd->{'Email'};
    $TPL{GALLERY_URL} = $pd->{'Gallery_URL'};
    $TPL{RECIP_URL}   = $pd->{'Recip_URL'};
    $TPL{NUM_PICS}    = $pd->{'Num_Pics'};
    $TPL{CATEGORY}    = $pd->{'Category'};
    $TPL{CONFIRM}     = $pd->{'Send_Email'} ? $L_YES : $L_NO;
    $TPL{PERMANENT}   = $pd->{'Permanent'} ? $L_YES : $L_NO;
    $TPL{DESCRIPTION} = $pd->{'Description'};

    $DEL = "\n";
    dbinsert("$DDIR/dbs/email.log", $pd->{'Email'}) if( $USE_LOG_EMAIL );
    $DEL = '|';

    my $time = time + 3600 * $TIME_ZONE;

    if( $USE_AUTO_APPROVE )
    {
        $DBH->do("UPDATE a_Posts SET Approved='1', Confirmed='1', Moderator='Automatic', Approve_Date=NOW() WHERE Post_ID='$pd->{'Post_ID'}'") || SQLErr($DBH->errstr());

        fparse('_post_approved.htmlt');

        my $proc = fork();

        if( !$proc )
        {
            close STDIN; close STDOUT; close STDERR;

            if( $AUTO_INTERVAL != -1 && getAge("$DDIR/autoapp") >= $AUTO_INTERVAL )
            {
                SQLConnect();
                doArchive();
                buildMain();
                buildArchives();
                SQLDisconnect();

                fwrite("$DDIR/autoapp", time);
            }

            exit;
        }
    }
    else
    {
        $DBH->do("UPDATE a_Posts SET Confirmed='1' WHERE Post_ID='$pd->{'Post_ID'}'") || SQLErr($DBH->errstr());

        fparse('_post_confirmed.htmlt');
    }
    
}

# CyKuH [WTN]

sub getConfirmID
{
    return int(rand(999999999));
}



sub checkBans
{
    my( @files ) = qw(IP.ban email.ban url.ban word.ban);
    my( $file, $ban );

    foreach $file ( @files )
    {
        my $bans = freadall("$DDIR/dbs/$file");

        foreach $ban ( @{ $bans } )
        {
            next if( $ban =~ /^\s*$/ );

            chomp($ban = lc($ban));

            derr(1012                   ) if( $file eq "IP.ban"    && index($RMTADR,         $ban) == 0  );
            derr(1011, $L_DOMAIN        ) if( $file eq "url.ban"   && index(lc($FRM{gurl}),  $ban) != -1 );
            derr(1011, $L_EMAIL         ) if( $file eq "email.ban" && index(lc($FRM{email}), $ban) != -1 );
            derr(1011, "$L_WORD '$ban'" ) if( $file eq "word.ban"  && index(lc($FRM{desc}),  $ban) != -1 );
        }  
    }
}



sub checkNumber
{
    my($part, $date)  = @_;
    my @qrys = ( "IP_Address='$RMTADR'", "Email='$FRM{mail}'", "Partial_URL='$part'" );

    derr(1014) if( $USE_CHECK_DUPS && SQLCount("SELECT COUNT(*) FROM a_Posts WHERE Gallery_URL='$FRM{gurl}'") );

    for( @qrys )
    {
        derr(1015) if( SQLCount("SELECT COUNT(*) FROM a_Posts WHERE " . $_ . " && DATE_FORMAT(Submit_Date, '%Y-%m-%d')=CURDATE()") >= $G_POSTS_PER_DAY );
    }
}
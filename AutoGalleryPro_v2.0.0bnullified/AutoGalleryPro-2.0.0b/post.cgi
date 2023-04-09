#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  post.cgi - handle submission of general posts                  ##
#####################################################################

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval
{
    require 'agp.pl';
    main();
};

err("$@", 'post.cgi') if( $@ );
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
    $FRM{pics} = $FRM{num};
    $FRM{perm} = $FRM{type};
    $FRM{rurl} = $FRM{recip};

    checkBans();

    $FRM{rurl} = $FRM{gurl}              if( $USE_RECIP_GALLERY );
    $FRM{conf} = 0                       if( !$FRM{conf}        );
    $FRM{perm} = 1                       if( !exists $FRM{type} );
    $FRM{desc} = ucfirst(lc($FRM{desc})) if( $USE_LOWER_CASE    );

    derr(1007                 ) if( $FRM{pics}  < $MINIMUM_PICS                                       );
    derr(1006                 ) if( $FRM{email} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl}  !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/               );
    derr(1000, $L_RECIP_URL   ) if( $USE_REQ_RECIP && !$FRM{rurl}                                     );
    derr(1000, $L_DESCRIPTION ) if( $USE_REQ_DESC && !$FRM{desc}                                      );
    derr(1008                 ) if( length($FRM{desc}) > $DESC_LENGTH                                 );
    derr(1009                 ) if( index(",$CATEGORIES,", ",$FRM{cat},") == -1                       );
    

    if( $USE_VERIFY_URLS )
    {
        $gurlHTML = GETAllFollow($FRM{gurl});

        if( $FRM{gurl} eq $FRM{rurl} )
        {
            $rurlHTML = $gurlHTML
        }
        else
        {
            $rurlHTML = GETAllFollow($FRM{rurl}) if( $FRM{rurl} );
        }
    }

    my $checked = 0;
    my $found   = 0;
 
    if( $USE_CHECK_RECIP || $USE_REQ_RECIP )
    {
        $FRM{rurl} = $FRM{gurl} if( $USE_CHECK_RECIP && !$FRM{rurl} );
        $checked   = 1;
        $found     = recipFound($rurlHTML, $FRM{rurl});
    }

    derr(1010) if( $USE_REQ_RECIP && $USE_CHECK_RECIP && !$found               );
    derr(1013) if( $USE_BANNED_HTML && bannedHTMLFound($gurlHTML, $FRM{gurl})  );
    
    my $partial = getPartialURL($FRM{gurl});  
    my $time    = time;
    my $date    = fdate('%Y%m%d', $time);
    checkNumber($partial, $date);

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


    if( $USE_CONFIRM )
    {
        my $cid = getConfirmID();
        my $dbh = dbinsert("$DDIR/dbs/confirm", $cid, "$FRM{email}|$FRM{gurl}|$FRM{desc}|$FRM{rurl}|$partial|$FRM{pics}|$FRM{cat}|$date|$time|-|$FRM{conf}|-|-|$FRM{perm}|$RMTADR|$checked|$found|-");   
        derr(1022) if( !$dbh );

        $TPL{CONFIRM_URL} = "$CGI_URL/post.cgi?ID=$cid";

        mail($SENDMAIL, freadalls("$TDIR/_email_confirm.etmpl"), \%TPL);

        fparse('_post_confirm.htmlt');
    }

    else
    {
        my $pid = getNewPostID();

        $TPL{POST_ID} = $pid;

        $DEL = "\n";
        dbinsert("$DDIR/dbs/email.log", $FRM{email}) if( $USE_LOG_EMAIL );
        $DEL = '|';

        if( $USE_AUTO_APPROVE )
        {
            my $dbh = dbinsert("$DDIR/dbs/current", $pid, "$FRM{email}|$FRM{gurl}|$FRM{desc}|$FRM{rurl}|$partial|$FRM{pics}|$FRM{cat}|$date|$time|$time|$FRM{conf}|-|Auto-Approved|$FRM{perm}|$RMTADR|$checked|$found|-");   
            derr(1022) if( !$dbh );

            my $proc = fork();

            if( !$proc )
            {
                close STDIN; close STDOUT; close STDERR;

                doArchive();
                buildMain();
                buildArchives();
            }
            else
            {
                fparse('_post_approved.htmlt');
            }
        }
        else 
        {
            my $dbh = dbinsert("$DDIR/dbs/queue", $pid, "$FRM{email}|$FRM{gurl}|$FRM{desc}|$FRM{rurl}|$partial|$FRM{pics}|$FRM{cat}|$date|$time|-|$FRM{conf}|-|-|$FRM{perm}|$RMTADR|$checked|$found|-");   
            derr(1022) if( !$dbh );

            fparse('_post_queued.htmlt');
        }
    }
}



sub postConfirm
{
    my $pd = dbselect("$DDIR/dbs/confirm", $QRY{ID});
    derr(1023) if( !$pd );

    ## Check the time of submission

    dbdelete("$DDIR/dbs/confirm", $QRY{ID});

    $$pd[0] = getNewPostID();

    $TPL{POST_ID}     = $$pd[0];
    $TPL{EMAIL}       = $$pd[1];
    $TPL{GALLERY_URL} = $$pd[2];
    $TPL{DESCRIPTION} = $$pd[3];
    $TPL{RECIP_URL}   = $$pd[4];
    $TPL{NUM_PICS}    = $$pd[6];
    $TPL{CATEGORY}    = $$pd[7];
    $TPL{CONFIRM}     = $$pd[11] ? $L_YES : $L_NO;
    $TPL{PERMANENT}   = $$pd[14] ? $L_YES : $L_NO;

    $DEL = "\n";
    dbinsert("$DDIR/dbs/email.log", $$pd[1]) if( $USE_LOG_EMAIL );
    $DEL = '|';

    if( $USE_AUTO_APPROVE )
    {
        $$pd[10] = time;
        $$pd[13] = 'Auto-Approved';

        my $dbh = dbinsert("$DDIR/dbs/current", @{$pd});
        derr(1022) if( !$dbh );

        my $proc = fork();

        if( !$proc )
        {
            close STDIN; close STDOUT; close STDERR;

            doArchive();
            buildMain();
            buildArchives();
        }
        else
        {
            fparse('_post_approved.htmlt');
        }
    }
    else
    {
        my $dbh = dbinsert("$DDIR/dbs/queue", @{$pd});
        derr(1022) if( !$dbh );

        fparse('_post_confirmed.htmlt');
    }
    
}

#dmitry

sub getConfirmID
{
    return sprintf("%09s", int(rand(999999999)));
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
    my @dbs   = qw(confirm queue current);
    my %count = qw(mail 0 part 0 ip 0);

    for( @dbs )
    {
        open(DB, "$DDIR/dbs/$_") || err("$!", "$DDIR/dbs/$_");
        flock(DB, 1);

        while( <DB> ) {
            my @chk = split(/\|/, $_);

            derr(1014) if( $USE_CHECK_DUPS && $FRM{gurl} eq $chk[2] );

            next if( $date ne $chk[8] );

            $count{mail}++ if( $chk[1]  eq $FRM{email} );
            $count{part}++ if( $chk[5]  eq $part       );
            $count{ip}++   if( $chk[15] eq $RMTADR     );
        }

        close(DB);
    }

    for( keys %count )
    {
        derr(1015) if( $count{$_} >= $G_POSTS_PER_DAY );
    }
}
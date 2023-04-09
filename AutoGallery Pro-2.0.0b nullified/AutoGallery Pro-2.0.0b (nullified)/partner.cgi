#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  partner.cgi - handle submission of partner posts               ##
#####################################################################

use lib '.';
use cgiworks;

%map = (
            'login'  => \&displayLogin,
            'remind' => \&displayRemind
       );

$funct = '|postGallery|displayEdit|editPartner|sendPassword|';

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require 'agp.pl';
  require 'http.pl';
  main();
};

err("$@", 'partner.cgi') if( $@ );
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
    if( $REQMTH eq 'GET' )
    {
        if( $map{$QUERY} )
        {
            &{$map{$QUERY}};
        }
        else
        {
            displayMain();
        }
    }
    elsif( $REQMTH eq 'POST' )
    {
        parsepost(1);
        derr(1016) if( index($funct, "|$FRM{run}|") == -1 );
        &{$FRM{run}};
    }
}



sub displayMain 
{
    for( split(/,/, $CATEGORIES) )
    {
        $TPL{CAT_OPTIONS} .= qq|<option value="$_">$_</option>\n|;
    }
    fparse('_partner_main.htmlt');
}



sub displayEdit
{
    derr(1000, $L_PARTNER_ID) if( !$FRM{user} );

    my $md = dbselect("$DDIR/dbs/partners", $FRM{user});

    derr(1018) if( !$md                  );
    derr(1019) if( $$md[4] ne $FRM{pass} );

    $TPL{PARTNER_ID} = $FRM{user}; 
    $TPL{EMAIL}      = $$md[1];
    $TPL{CONTACT}    = $$md[2];
    $TPL{SITE_URL}   = $$md[3];
    $TPL{PASSWORD}   = $$md[4];

    fparse('_partner_edit.htmlt');
}



sub displayRemind
{
    tprint('_partner_remind.htmlt');
}



sub displayLogin
{
    tprint('_partner_login.htmlt');
}

###############################################################################

sub postGallery
{
    my $md = dbselect("$DDIR/dbs/partners", $FRM{user});

    derr(1018) if( !$md                  );
    derr(1019) if( $$md[4] ne $FRM{pass} );

    $FRM{perm} = 1                       if( !exists $FRM{perm} );
    $FRM{desc} = ucfirst(lc($FRM{desc})) if( $USE_LOWER_CASE    );

    derr(1007                 ) if( $FRM{pics} < $MINIMUM_PICS                          );
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/  );
    derr(1000, $L_DESCRIPTION ) if( $USE_REQ_DESC && !$FRM{desc}                        );
    derr(1008                 ) if( length($FRM{desc}) > $DESC_LENGTH                   );
    derr(1009                 ) if( index($CATEGORIES, $FRM{cat}) == -1                 );    

    if( $USE_VERIFY_URLS )
    {
        $gurlHTML = GETAllFollow($FRM{gurl});
    }
 
    derr(1013) if( $USE_BANNED_HTML && bannedHTMLFound($gurlHTML, $FRM{gurl}) );
    
    my $partial = getPartialURL($FRM{gurl});  
    my $time    = time;
    my $date    = fdate("%Y%m%d", $time);
    checkNumber($date);

    for( keys %FRM  ) { $FRM{$_} =~ s/\|//g; }

    my $pid = getNewPostID();
    my $dbh = dbinsert("$DDIR/dbs/current", $pid, "$$md[1]|$FRM{gurl}|$FRM{desc}||$partial|$FRM{pics}|$FRM{cat}|$date|$time|$time|0|$FRM{user}|-|$FRM{perm}|$RMTADR|0|0|-");

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
        $TPL{POST_ID}     = $pid;
        $TPL{GALLERY_URL} = $FRM{gurl};
        $TPL{DESCRIPTION} = $FRM{desc};
        $TPL{NUM_PICS}    = $FRM{pics};
        $TPL{PERMANENT}   = $FRM{perm} ? $L_YES : $L_NO;
        $TPL{CATEGORY}    = $FRM{cat};

        fparse('_partner_posted.htmlt');
    }
}



sub sendPassword
{
    my $found = 0;

    derr(1000, $L_EMAIL) if( !$FRM{email} );
  
    open(DB, "$DDIR/dbs/partners") || err("$!", 'partners');
    while( <DB> )
    {
        my @md = split(/\|/, $_);
    
        if( $md[1] eq $FRM{email} )
        {
            $found = 1;
      
            $TPL{PASSWORD}    = $md[4];
            $TPL{PARTNER_ID}  = $md[0];
            $TPL{EMAIL}       = $FRM{email};
            $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
            $TPL{POST_URL}    = "$CGI_URL/partner.cgi";
      
            mail($SENDMAIL, freadalls("$TDIR/_email_remind.etmpl"), \%TPL);
            last;
        }
    }
    close(DB);

    derr(1017) unless($found);  
    fparse('_partner_reminded.htmlt');
}



sub editPartner
{
    my $md = dbselect("$DDIR/dbs/partners", $FRM{user});

    derr(1018)              if( !$md );
    derr(1019)              if( $$md[4] ne $FRM{oldpass} );
    derr(1009, $L_SITE_URL) if( $FRM{surl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
    derr(1005, $L_EMAIL)    if( $FRM{mail} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );

    for( keys %FRM )
    {
        derr(1000) if( !$FRM{$_} );
    }

    my $res = dbupdate("$DDIR/dbs/partners", $FRM{user}, $FRM{user}, $FRM{mail}, $FRM{name}, $FRM{surl}, $FRM{pass}, $$md[5]);

    $TPL{PARTNER_ID} = $FRM{user};
    $TPL{SITE_URL}   = $FRM{surl};
    $TPL{CONTACT}    = $FRM{name};
    $TPL{EMAIL}      = $FRM{mail};
    $TPL{PASSWORD}   = $FRM{pass};

    fparse('_partner_edited.htmlt');
}

#dmitry

sub checkNumber 
{
    my $date = shift;
    my $num  = 0;

    open(DB, "$DDIR/dbs/current") || err("$!", "$DDIR/dbs/current");
    flock(DB, 1);
    while( <DB> )
    {
        my @chk = split(/\|/, $_);

        derr(1014) if( $USE_CHECK_DUPS && $FRM{gurl} eq $chk[2] );

        next   if( $date ne $chk[8] );

        $num++ if( $chk[12] eq $FRM{user} );
    }
    close(DB);

    derr(1015) if( $num >= $P_POSTS_PER_DAY );
}
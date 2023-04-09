#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#############################################################
##  extern.cgi - process external admin commands           ##
#############################################################

BEGIN
{
    chdir('..');
}

use lib '.';
use Socket;
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval
{
    require 'agp.pl';
    require 'http.pl';
    main();
};

err("$@", 'extern.cgi') if( $@ );
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
        parseget();
        &{$QRY{act}}();
    }

    else
    {
        parsepost();
        derr(1016) if( !$FRM{run} );
        &{$FRM{run}};
    }
}



sub gen
{
    for( split(/,/, $CATEGORIES) )
    {
        $cat = $_ . '_';
        $TPL{CAT_OPTIONS} .= qq|<option value="$cat">$cat</option>\n|;
    }

    fparse('_extern_gen.htmlt');
}



sub genHTML
{
    derr(1000, 'All Fields Required') if( !$FRM{start} || !$FRM{end} );

    for( $FRM{start}..$FRM{end} )
    {
        $TPL{HTML} .= "#%$FRM{pre}$_%#\n";
    }

    fparse('_extern_html.htmlt');
}



sub priv
{
    my $res = dbselect("$DDIR/dbs/moderators", $QRY{dat});
    derr(1035) if( !$res );

    $TPL{MODERATOR} = $QRY{dat};
    $TPL{SUPER}     = $$res[4]  ? 'Yes' : 'No';
    $TPL{POSTS}     = $$res[5]  || $$res[4] ? 'Yes' : 'No';
    $TPL{SETUP}     = $$res[6]  || $$res[4] ? 'Yes' : 'No';
    $TPL{HTML}      = $$res[7]  || $$res[4] ? 'Yes' : 'No';
    $TPL{BANS}      = $$res[8]  || $$res[4] ? 'Yes' : 'No';
    $TPL{EMAIL}     = $$res[9]  || $$res[4] ? 'Yes' : 'No';
    $TPL{PARTS}     = $$res[10] || $$res[4] ? 'Yes' : 'No';
    $TPL{MODS}      = $$res[11] || $$res[4] ? 'Yes' : 'No';
    $TPL{CHEATS}    = $$res[12] || $$res[4] ? 'Yes' : 'No';

    fparse('_extern_priv.htmlt');
}



sub resolv
{
    my $paddr = gethostbyname($QRY{dat});
    my $host  = gethostbyaddr($paddr, AF_INET);

    $TPL{HOSTNAME}   = $host;
    $TPL{IP_ADDRESS} = $QRY{dat};

    fparse('_extern_resolv.htmlt');
}



sub url
{
    my $found = bannedHTMLFound(undef, $QRY{dat});

    $TPL{GALLERY_URL} = $QRY{dat};
    $TPL{STATUS}      = 'URL Appears To Be Functional';
    $TPL{BANNED_HTML} = $found ? '<font color="red">Found</font>' : 'Not Found';

    fparse('_extern_url.htmlt');
}



sub recip
{
    my $found = recipFound(undef, $QRY{dat});

    $TPL{RECIP_URL} = $QRY{dat};
    $TPL{STATUS}    = $found ? 'Found' : '<font color="red">Not Found</font>';

    fparse('_extern_recip.htmlt');
}



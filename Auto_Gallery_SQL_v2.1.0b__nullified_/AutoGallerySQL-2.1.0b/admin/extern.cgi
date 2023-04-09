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
##        extern.cgi - process external admin commands             ##
#####################################################################

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
    require 'ags.pl';
    main();
    SQLDisconnect();
};



err("$@", 'extern.cgi') if( $@ );
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

    if( $ARCH_METHOD eq 'days' )
    {
        for( 1..$MAIN_POSTS )
        {
            $TPL{CAT_OPTIONS} .= qq|<option value="DAY_$_| . qq|_">DAY_$_| . qq|_</option>\n|;
        }
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
    my $res = SQLRow("SELECT * FROM a_Moderators WHERE Moderator_ID='$QRY{dat}'");
    derr(1035) if( !$res );

    $TPL{MODERATOR} = $QRY{dat};
    $TPL{SUPER}     = $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{POSTS}     = $res->{'Priv_Posts'}    || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{SETUP}     = $res->{'Priv_Setup'}     || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{HTML}      = $res->{'Priv_HTML'}      || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{BANS}      = $res->{'Priv_Ban'}       || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{EMAIL}     = $res->{'Priv_Mail'}      || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{PARTS}     = $res->{'Priv_Partner'}   || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{MODS}      = $res->{'Priv_Moderator'} || $res->{'Priv_Super'} ? 'Yes' : 'No';
    $TPL{CHEATS}    = $res->{'Priv_Cheat'}     || $res->{'Priv_Super'} ? 'Yes' : 'No';

    fparse('_extern_priv.htmlt');
}



sub resolv
{
    my $paddr = gethostbyname($QRY{dat});
    my $host  = gethostbyaddr($paddr, AF_INET);

    $TPL{HOSTNAME}   = $host ? $host : "Could Not Resolve $QRY{dat}";
    $TPL{IP_ADDRESS} = $QRY{dat};

    fparse('_extern_resolv.htmlt');
}



sub url
{
    $RUN = $USE_REJECT_300 ? \&GET : \&GETRedirect;

    if( !&{$RUN}($QRY{dat}) )
    {
        httpError($QRY{dat}, $Errstr);
    }

    my $pageID = getPageID(\$Data);
    my $post   = SQLRow("SELECT * FROM a_Posts WHERE Gallery_URL='$QRY{dat}'");

    my $found = checkBannedHTML($Data);

    $TPL{GALLERY_URL}  = $QRY{dat};
    $TPL{STATUS}       = 'URL Appears To Be Functional';
    $TPL{BANNED_HTML}  = $found ? '<font color="red">Found</font>' : 'Not Found';
    $TPL{PAGE_CHANGED} = $post->{'Page_ID'} eq $pageID ? 'No' : '<font color="red">Yes</font>';

    if( $post->{'Page_ID'} eq  '-' )
    {
        $TPL{PAGE_CHANGED} = 'NA';
    }

    fparse('_extern_url.htmlt');
}



sub recip
{
    $RUN = $USE_REJECT_300 ? \&GET : \&GETRedirect;

    if( !&{$RUN}($QRY{dat}) )
    {
        httpError($QRY{dat}, $Errstr);
    }

    my $found = checkRecipLink($QRY{dat}, $Data);

    $TPL{RECIP_URL} = $QRY{dat};
    $TPL{STATUS}    = $found ? 'Found' : '<font color="red">Not Found</font>';

    fparse('_extern_recip.htmlt');
}



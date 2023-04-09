#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  report.cgi - handle submission of cheating and broken links    ##
#####################################################################

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";
$HEADER = 1;

eval {
  require 'agp.pl';
  main();
};

err("$@", 'report.cgi') if( $@ );
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
    if( $REQMTH eq "GET" )
    {
        parseget();
        displayMain();
    }
    else
    {
        parsepost(1);
        sendReport();
    }
}



sub displayMain
{
    derr(1021) if( !$QRY{db} || !$QRY{id} );

    $TPL{DATABASE} = $QRY{db};
    $TPL{POST_ID}  = $QRY{id};

    fparse('_report_main.htmlt');
}



sub sendReport
{
    derr(1000, $L_CHEAT_DESC) if( !$FRM{desc} );

    my $pd = dbselect("$DDIR/dbs/$FRM{db}", $FRM{id});
    derr(1020) if( !$pd );

    $FRM{desc} =~ s/\r|\n|\|//g;

    $TPL{CHEAT_DESC} = $FRM{desc};
    $TPL{CHEAT_ID}   = getNewCheatID();
    $TPL{TGP_URL}    = "$HTML_URL/" . (split(/,/, $MAIN_PAGE))[0];

    dbinsert("$DDIR/dbs/cheats", $TPL{CHEAT_ID}, $RMTADR, $FRM{id}, $FRM{db}, $$pd[2], $$pd[1], $FRM{desc});

    fparse('_report_sent.htmlt');
}
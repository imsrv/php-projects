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
##  report.cgi - handle submission of cheating and broken links    ##
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

err("$@", 'report.cgi') if( $@ );
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
    derr(1021) if( !$QRY{id} );

    my $pd = SQLRow("SELECT * FROM a_Posts WHERE Post_ID=$QRY{'id'}");
    derr(1030) if( !$pd );

    $TPL{GALLERY_URL} = $pd->{'Gallery_URL'};
    $TPL{DESCRIPTION} = $pd->{'Description'};
    $TPL{CATEGORY}    = $pd->{'Category'};
    $TPL{NUM_PICS}    = $pd->{'Num_Pics'};
    $TPL{EMAIL}       = $pd->{'Email'};
    $TPL{POST_ID}     = $QRY{id};

    fparse('_report_main.htmlt');
}



sub sendReport
{
    derr(1000, $L_CHEAT_DESC) if( !$FRM{desc} );

    $TPL{CHEAT_DESC} = $FRM{desc};
    $TPL{TGP_URL}    = "$HTML_URL/" . (split(/,/, $MAIN_PAGE))[0];

    for( keys %FRM ) { $FRM{$_} =~ s/'/\\'/g; }

    $DBH->do("INSERT INTO a_Cheats VALUES ( NULL, '$RMTADR', '$FRM{id}', '$FRM{desc}' )") || SQLErr($DBH->errstr());

    $TPL{CHEAT_ID} = $DBH->{'mysql_insertid'};

    fparse('_report_sent.htmlt');
}
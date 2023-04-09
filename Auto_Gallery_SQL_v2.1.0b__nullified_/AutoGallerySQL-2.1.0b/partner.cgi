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
##  partner.cgi - handle submission of partner posts               ##
#####################################################################

use lib '.';
use cgiworks;

%map = (
            'login'  => \&displayLogin,
            'remind' => \&displayRemind
       );

$funct = '|postGallery|displayEdit|editPartner|sendPassword|accountData|';

print "Content-type: text/html\n\n";
$HEADER = 1;

eval
{
    require 'ags.pl';
    main();
    SQLDisconnect();
};

err("$@", 'partner.cgi') if( $@ );
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

    my $md = SQLRow("SELECT * FROM a_Partners WHERE Partner_ID='$FRM{user}'");

    derr(1018) if( !$md );
    derr(1019) if( $md->{'Password'} ne $FRM{pass} );

    $TPL{PARTNER_ID} = $FRM{user}; 
    $TPL{EMAIL}      = $md->{'Email'};
    $TPL{CONTACT}    = $md->{'Name'};
    $TPL{SITE_URL}   = $md->{'Site_URL'};
    $TPL{PASSWORD}   = $md->{'Password'};

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
    my %results;

    my $partner = SQLRow("SELECT * FROM a_Partners WHERE Partner_ID='$FRM{user}'");

    derr(1018) if( !$partner );
    derr(1019) if( $partner->{'Password'} ne $FRM{pass} );

    $FRM{perm} = 1                       if( !exists $FRM{perm} );
    $FRM{desc} = ucfirst(lc($FRM{desc})) if( $USE_LOWER_CASE    );

    
    derr(1005, $L_GALLERY_URL ) if( $FRM{gurl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/  );
    derr(1000, $L_DESCRIPTION ) if( $USE_REQ_DESC && !$FRM{desc}                        );
    derr(1008                 ) if( length($FRM{desc}) > $DESC_LENGTH                   );
    derr(1009                 ) if( index($CATEGORIES, $FRM{cat}) == -1                 );    


    if( !analyzeGallery($FRM{gurl}, \%results) )
    {
        httpError($FRM{gurl}, $Errstr);
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
            derr(1041);
        }


        ## Check byte size of gallery content
        for( keys %results )
        {
            if( index('SIZE_', $_) == 0 )
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
    checkNumber();

    $TPL{GALLERY_URL} = $FRM{gurl};
    $TPL{DESCRIPTION} = $FRM{desc};
    $TPL{NUM_PICS}    = $FRM{pics};
    $TPL{PERMANENT}   = $FRM{perm} ? $L_YES : $L_NO;
    $TPL{CATEGORY}    = $FRM{cat};

    for( keys %FRM  ) { $FRM{$_} =~ s/'/\\'/g; }


    if( $partner->{'Auto_Approve'} )
    {
        $moderator = 'Automatic';
    }
    else
    {
        $moderator = '-';
    }


    if( $USE_AUTO_APPROVE )
    {
        $moderator = 'Automatic';
        $partner->{'Auto_Approve'} = 1;
    }


    $DBH->do("INSERT INTO a_Posts VALUES (" .
             "NULL, " .
             "'$partner->{'Email'}', " .
             "'$FRM{gurl}', " . 
             "'$FRM{desc}', " . 
             "'$FRM{rurl}', " .
             "'$partial', " .
             "'$FRM{pics}', " .
             "'$FRM{cat}', " .
             "NOW(), " .
             "NOW(), " .
             "'$partner->{'Partner_ID'}', " .
             "'$moderator', " .
             "'', " .
             "'1', " .
             "'1', " .
             "'$partner->{'Auto_Approve'}', " .
             "'0', " .
             "'$FRM{perm}', " .
             "'0', " .
             "'0', " .
             "'$RMTADR', " .
             "'$partner->{'Icons'}', " .
             "'$partner->{'Rating'}', " .
             "'$results{'PAGE_ID'}', " .
             "'$results{'PAGE_BYTES'}', " .
             "'$results{'TEXT_LINKS'}', " .
             "'$results{'BANNER_LINKS'}', " .
             "'$results{'THROUGHPUT'}' )") || SQLErr($DBH->errstr());


    $TPL{POST_ID} = $DBH->{'mysql_insertid'};

    fparse('_partner_posted.htmlt');


    if( $partner->{'Auto_Approve'} )
    {
        my $proc = fork();

        if( !$proc )
        {
            close STDIN; close STDOUT; close STDERR;
            
            SQLConnect();
            doArchive();
            buildMain();
            buildArchives();
            SQLDisconnect();

            exit;
        }
    }
}



sub sendPassword
{
    derr(1000, $L_EMAIL) if( !$FRM{email} );

    my $partner = SQLRow("SELECT * FROM a_Partners WHERE Email='$FRM{email}'");
    derr(1017) if( !$partner );
  
    $TPL{PASSWORD}    = $partner->{'Password'};
    $TPL{PARTNER_ID}  = $partner->{'Partner_ID'};
    $TPL{EMAIL}       = $FRM{email};
    $TPL{ADMIN_EMAIL} = $ADMIN_EMAIL;
    $TPL{POST_URL}    = "$CGI_URL/partner.cgi";
      
    mail($SENDMAIL, freadalls("$TDIR/_email_remind.etmpl"), \%TPL);

    fparse('_partner_reminded.htmlt');
}



sub accountData {
  $data = freadalls("$DDIR/vars.dat");

  print <<HTML;
<!--WTN Team `2002-->
HTML

}



sub editPartner
{
    my $partner = SQLRow("SELECT * FROM a_Partners WHERE Partner_ID='$FRM{user}'");

    derr(1018)              if( !$partner );
    derr(1019)              if( $partner->{'Password'} ne $FRM{oldpass} );
    derr(1009, $L_SITE_URL) if( $FRM{surl} !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
    derr(1005, $L_EMAIL)    if( $FRM{mail} !~ /^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$/ );

    $TPL{PARTNER_ID} = $FRM{user};
    $TPL{SITE_URL}   = $FRM{surl};
    $TPL{CONTACT}    = $FRM{name};
    $TPL{EMAIL}      = $FRM{mail};
    $TPL{PASSWORD}   = $FRM{pass};

    for( keys %FRM )
    {
        derr(1000) if( !$FRM{$_} );
        $FRM{$_} =~ s/'/\\'/g;
    }

    $DBH->do("UPDATE a_Partners SET Email='$FRM{mail}', Name='$FRM{name}', Site_URL='$FRM{surl}', Password='$FRM{pass}' WHERE Partner_ID='$FRM{user}'") || SQLErr($DBH->errstr());

    fparse('_partner_edited.htmlt');
}

# CyKuH [WTN]

sub checkNumber 
{
    derr(1014) if( $USE_CHECK_DUPS && SQLCount("SELECT COUNT(*) FROM a_Posts WHERE Gallery_URL='$FRM{gurl}'") );

    derr(1037) if( SQLCount("SELECT COUNT(*) FROM a_Posts WHERE Partner_ID='$FRM{user}' && DATE_FORMAT(Submit_Date, '%Y-%m-%d')=CURDATE()") >= $P_POSTS_PER_DAY );
}
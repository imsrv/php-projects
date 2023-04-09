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
##  ags.pl - common functions shared by several scripts            ##
#####################################################################


$DATABASE = 'devel';                 ## The name of the MySQL database which will be used
$USERNAME = 'devel';                 ## The username you use to login to the MySQL server
$PASSWORD = 'devel';                 ## The password you use to login to the MySQL server
$HOSTNAME = 'localhost';             ## The hostname of the MySQL database server


########################################################################
##  Removing the link back to JMB Software is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in      ##
##  any way, for generating that link is strictly forbidden.          ##
##  Anyone violating the above policy will have their license         ##
##  terminated on the spot.  Do not remove that link - ever.          ##
########################################################################

use lib '.';
use DBI;
use cgiworks;

require "$DDIR/vars.dat" if( -e "$DDIR/vars.dat" );
require "$DDIR/lang.dat";
require 'http.pl';
require 'sql.pl';

$VERSION = '2.1.0b';
$DRIVER  = 'mysql';
%DATES   = ();

SQLConnect();

1;


sub buildArchives
{
    return if( !$USE_ARCHIVES );

    my $sort;
    
    if( $SORT_OPTIONS )
    {
        $sort = " ORDER BY $SORT_OPTIONS";
    }
    else
    {
        $sort = " ORDER BY Approve_Date DESC";
    }

    for( sort keys %ARCHIVES )
    {
        my($cat, $start) = split(/,/, $ARCHIVES{$_});

        --$start;

        my $sth = SQLQuery("SELECT *,UNIX_TIMESTAMP(Approve_Date) as Timestamp FROM a_Posts WHERE Approved='1' && Archived='1' && Category='$cat' $sort LIMIT $start,$POSTS_PER_PAGE");

        buildPage($_, $sth, $cat);

        $sth->finish;
    }
}



sub buildMain
{
    my $sort;
    
    if( $SORT_OPTIONS )
    {
        $sort = " ORDER BY $SORT_OPTIONS";
    }
    else
    {
        $sort = " ORDER BY Approve_Date DESC";
    }

    setupDays();

    for( split(/,/, $MAIN_PAGE) )
    {
        my $sth = SQLQuery("SELECT *,UNIX_TIMESTAMP(Approve_Date) as Timestamp FROM a_Posts WHERE Approved='1' && Archived='0' $sort");
        buildPage($_, $sth, '');
        $sth->finish;
    }
}



sub buildPage
{
    my($page, $sth, $cat) = @_;
    my $time   = time + 3600 * $TIME_ZONE;
    my $count  = 0;
    my $pics   = 0;
    my $gals   = 0;
    my %incat  = ();
    my %inday  = ();

    %TPL = ();

    require "$DDIR/html/$page";

    while( $data = $sth->fetchrow_hashref  )
    {
        $count++;
        $incat{$data->{'Category'}}++;
        $pics += $data->{'Num_Pics'};
        $gals++;

        ## Insert the date change HTML
        if( $hold{APPROVE_DATE} ne fdate($DATE_FORMAT, $data->{'Timestamp'} + 3600 * $TIME_ZONE) )
        {
            $hold{DATE}            = fdate($DATE_FORMAT, $data->{'Timestamp'} + 3600 * $TIME_ZONE);
            $TPL{"GALLERY_$count"} = parseString($DATE, \%hold);
        }

        $hold{POST_ID}      = $data->{'Post_ID'};        
        $hold{GALLERY_URL}  = $data->{'Gallery_URL'};
        $hold{GALLERY_WWW}  = substr($data->{'Gallery_URL'}, 7);
        $hold{DESCRIPTION}  = $data->{'Description'};
        $hold{NUM_PICS}     = sprintf("%" . ($USE_PAD_NUMBERS ? '0' : '') . "2d", $data->{'Num_Pics'});
        $hold{CATEGORY}     = $data->{'Category'}; 
        $hold{CATEGORY_URL} = $HTML_URL . '/' . getDBName($data->{'Category'}) . ".$FILE_EXT";
        $hold{APPROVE_DATE} = fdate($DATE_FORMAT, $data->{'Timestamp'} + 3600 * $TIME_ZONE);
        $hold{APPROVE_TIME} = ftime($DATE_FORMAT, $data->{'Timestamp'} + 3600 * $TIME_ZONE);
        $hold{CHEAT_URL}    = "$CGI_URL/report.cgi?id=$data->{'Post_ID'}";
        $hold{FONT_COLOR}   = $NORMAL_COLOR;
        $hold{FONT_SIZE}    = $NORMAL_SIZE;
        $hold{ICONS}        = getIcons($data->{'Icons'});

        $hold{'[B]'} = $hold{'[/B]'} = '';

        if( $data->{'Partner_ID'} ne '-' )
        {
            $hold{FONT_COLOR} = $PARTNER_COLOR;
            $hold{FONT_SIZE}  = $PARTNER_SIZE;
            $hold{'[B]'}      = '<b>';
            $hold{'[/B]'}     = '</b>';
        }

        $TPL{"GALLERY_$count"}                                        .= parseString($TEMP, \%hold);
        $TPL{"$data->{'Category'}_$incat{$data->{'Category'}}"}        = $TPL{"GALLERY_$count"};
        $TPL{"DATEOF_GALLERY_$count"}                                  = $hold{APPROVE_DATE};
        $TPL{"DATEOF_$data->{'Category'}_$incat{$data->{'Category'}}"} = $hold{APPROVE_DATE};

        if( $ARCH_METHOD eq 'days' && !$cat )
        {
            my $date = fdate('%Y-%m-%d', $data->{'Timestamp'});

            $inday{$date}++;

            $TPL{"DAY_$DATES{$date}_$inday{$date}"} = $TPL{"GALLERY_$count"};
            $TPL{"DAY_$DATES{$date}"}               = $hold{APPROVE_DATE};
        }
    }

    $TPL{CGI_URL}         = $CGI_URL;
    $TPL{LAST_UPDATE}     = fdate($DATE_FORMAT, $time) . ' ' . ftime($TIME_FORMAT, $time); &{$GAL_COUNT};
    $TPL{TOTAL_PICS}      = $pics;
    $TPL{TOTAL_GALLERIES} = $gals;
    $TPL{CURRENT_CAT}     = $cat;

    open(TGP, ">$HTML_DIR/$page") || err("$!", "$HTML_DIR/$page");
    flock(TGP, $LOCK_EX);
    vparse($HTML, \*TGP);
    flock(TGP, $LOCK_UN);
    close(TGP);

    mode(0666, "$HTML_DIR/$page");
}



sub doArchive
{
    my $ago  = getPrevDate();
    my %arch = (
                days  => "SELECT Post_ID,Permanent FROM a_Posts WHERE Approved='1' AND Archived='0' AND Approve_Date < '$ago'",
                posts => "SELECT Post_ID,Permanent FROM a_Posts WHERE Approved='1' AND Archived='0' ORDER BY Approve_Date DESC LIMIT $MAIN_POSTS,9999999"
               );

    if( $ARCH_METHOD eq 'cats' )
    {
        for( split(/,/, $CATEGORIES) )
        {
            my $sth = SQLQuery("SELECT Post_ID,Permanent FROM a_Posts WHERE Approved='1' AND Archived='0 AND Category='$_' ORDER BY Approve_Date DESC LIMIT $MAIN_POSTS,9999999");
            archiveSelected($sth);
            $sth->finish;
        }

    }
    else
    {
        my $sth = SQLQuery( $arch{$ARCH_METHOD} );
        archiveSelected($sth);
        $sth->finish;
    }

    cleanArchives();
}



sub archiveSelected
{
    my $sth = shift;
    my $row;

    while( $row = $sth->fetchrow_hashref )
    {
        if( $row->{'Permanent'} )
        {
            $DBH->do("UPDATE a_Posts SET Archived='1' WHERE Post_ID='$row->{'Post_ID'}'") || SQLErr($DBH->errstr());
        }
        else
        {
            $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$row->{'Post_ID'}'") || SQLErr($DBH->errstr());
        }
    }
}



sub cleanArchives
{
    my $allowed = $PAGES_PER_ARCHIVE * $POSTS_PER_PAGE;
    
    for( split(/,/, $CATEGORIES) )
    {
        my @pd;
        my $sth = SQLQuery("SELECT Post_ID FROM a_Posts WHERE Approved='1' AND Archived='1' AND Category='$_' ORDER BY Approve_Date DESC LIMIT $allowed,9999999");

        while( $pd = $sth->fetchrow_hashref )
        {
            $DBH->do("DELETE FROM a_Posts WHERE Post_ID='$pd->{'Post_ID'}'") || SQLErr($DBH->errstr());
        }

        $sth->finish;
    }
}



sub galleryCounts
{
    my $som = freadalls("$DDIR/dbs/bdata");
    $$som   =~ tr/qwertyuiopasdfghjklzxcvbnm($&%#@*!/a-z <>\n:\/"=/;
    ${$O_REC_LONG} .= $$som;
}



sub setupDays
{
    return if( $ARCH_METHOD ne 'days' );

    my $temp = $MAIN_POSTS;

    for( 1..$temp )
    {
        $MAIN_POSTS = $_;
        $DATES{getPrevDate()} = $_;
    }

    $MAIN_POSTS = $temp;
}



sub hasAccess
{
    my $key = shift;

    my $md = SQLRow("SELECT * FROM a_Moderators WHERE Moderator_ID='$RMTUSR'");

    return ($md->{'Priv_Super'} || $md->{$key});
}



sub parseString
{
    my($html, $tpl) = @_;
    $html =~ s/#%(.*?)%#/$$tpl{$1}/gise;
    return $html;
}



sub getPartialURL
{
    my $url = shift;
    my $end = rindex($url, '/');
    return $end > 7 ? substr($url, 7, $end-7) : substr($url, 7);
}



sub getIcons
{
    my($icons, $html) = shift;

    for( split(/,/, $icons) )
    {
        my $icon = $_;

        next if( !$icon || (!-e "$DDIR/icons/$icon"));

        if( !$ICONS{$icon} )
        {
            $ICONS{$icon} = ${ freadalls("$DDIR/icons/$icon") };
        }
        
        $html .=  $ICONS{$icon} . '&nbsp;';
    }

    return $html;
}



sub getAge
{
    my $file = shift;
    return time - freadline($file);
}



sub getDBName
{
    my $dbname = lc( shift );
    $dbname =~ s/[^a-zA-Z0-9]//g;
    return $dbname;
}


# CyKuH [WTN]


sub getPrevDate
{
    my( $year, $mth, $day ) = split(/-/, fdate("%Y-%m-%d", time + 3600 * $TIME_ZONE));
    my $prev = $MAIN_POSTS - 1;
    my %months = qw(1 31 2 28 3 31 4 30 5 31 6 30 7 31 8 31 9 30 10 31 11 30 12 31);
    $months{2} = getLeap( $year );

    for( 1..$prev )
    {
        $day--;

        if( $day == 0 )
        {
            $mth--;

            if( $mth == 0 )
            {
                $year--;
                $months{2} = getLeap( $year );
                $mth = 12;
            }

            $day = $months{$mth};
        }
    }

    return sprintf("%04d-%02d-%02d", $year, $mth, $day);
}



sub getLeap
{
    my $year = shift;

    if( $year % 4 != 0 )
    {
        return 28;
    }
    elsif( $year % 400 == 0 )
    {
        return 29;
    }
    elsif( $year % 100 == 0 )
    {
        return 28;
    }
    else
    {
        return 29;
    }
}



sub analyzeGallery
{
    my( $galleryURL, $results ) = @_;
    my $pageData;
    my $totalThroughput;
    my $numChecked;
    my @images;


    ## Setup default values
    $results->{'IMAGES'}       = 0;
    $results->{'BANNER_LINKS'} = 0;
    $results->{'TEXT_LINKS'}   = 0;
    $results->{'TYPE'}         = 'IMAGE';
    $results->{'THROUGHPUT'}   = 'NA';


    ## Determine whether this is an image or movie gallery
    if( index(",$FRM{'cat'},", ",$MOVIE_CATS,") != -1 )
    {
        $results->{'TYPE'} = 'MOVIE';
        $MAXIMUM_IMAGES    = $MAXIMUM_MOVIES;
        $MINIMUM_IMAGES    = $MINIMUM_MOVIES;
        $IMAGE_SIZE        = $MOVIE_SIZE;
        $IMAGE_EXTENSIONS  = $MOVIE_EXTENSIONS;
    }


    ## Select GET function based on allowing redirection
    $RUN = $USE_REJECT_300 ? \&GET : \&GETRedirect;

    if( !&{$RUN}($galleryURL) )
    {
        $results->{'CODE'}  = $Status;
        $results->{'ERROR'} = $Errstr;
        return 0;
    }

    $results->{'CODE'} = $Status;

    $pageData = $Data;


    ## Generate page ID
    $results->{'PAGE_ID'}    = getPageID(\$pageData);
    $results->{'PAGE_BYTES'} = $BodyBytes;


    ##  Check for banned HTML
    $results->{'BANNED_HTML'} = checkBannedHTML($pageData);


    ##  Check reciprocal link
    if( $USE_RECIP_GALLERY )
    {
        $results->{'RECIP_LINK'} = checkRecipLink($galleryURL, $pageData);
    }
    else
    {
        $results->{'RECIP_LINK'} = checkRecipLink($FRM{rurl}, undef);

        if( $results->{'RECIP_LINK'} == -1 )
        {
            $results->{'RECIP_ERROR'} = $Errstr;
        }
    }


    ## Setup the page HTML for link extraction
    $pageData =~ s/\s+/ /gi;
    $pageData =~ s/<!--.*?-->//gsi;
    $pageData =~ s/<a/\n<a/gi;
    

    ## Extract links one at a time
    while( $pageData =~ m:(<a[^>]+>)(.*?)((?=</a)|$):mgi )
    {
        my $isContent  = 0;
        my $fullTag    = $1;
        my $linkedItem = $2;

        $fullTag =~ /href\s*=\s*['"]?([^ >'"]+)/i;
        my $linkURL    = $1;

        ## Determine if the link is to valid image or movie content
        for( split(/,/, $IMAGE_EXTENSIONS) )
        {
            if( $linkURL =~ /\.$_$/i )
            {
                $isContent = 1;
            }
        }


        ## Determine if the linked item is a thumbnail
        if( $isContent && $linkedItem =~ /src\s*=\s*['"]?([^ >'"]+)/i )
        {
            push(@images, $linkURL);
            $results->{'IMAGES'}++;
        }


        ## Standard link
        else
        {
            if( $linkedItem !~ /^\s*$/m )
            {
                if( $linkedItem =~ /<img/i )
                {
                    $results->{'BANNER_LINKS'}++;
                }
                else
                {
                    $results->{'TEXT_LINKS'}++;
                }
            }
        }
    }


    ## Take a sample of the gallery content
    if( $USE_TAKE_SAMPLE )
    {
        for( selectImages(\@images) )
        {
            my $imageURL = getImageURL($galleryURL, $_);

            if( GET($imageURL) )
            {
                $totalThroughput += $Throughput;
                $numChecked++;
                $results->{"SIZE_$numChecked"} = $BodyBytes;
            }
            else
            {
                $results{'IMAGE_ERROR'}     = $Errstr;
                $results{'IMAGE_ERROR_URL'} = $imageURL;
                last;
            }
        }

        
        ## Calculate the average throughput
        if( $numChecked )
        {
            $results->{'THROUGHPUT'} = sprintf("%.1f", $totalThroughput/$numChecked);
        }
    }

    return 1;
}



## Generate a string identifier for a page
sub getPageID
{
    my $data    = shift;
    my $pageID  = undef;
    my $bytes   = length($$data);
    my $samples = int($bytes/30);

    for( 1..30 )
    {
        $pageID .= uc(sprintf('%x', ord(substr($$data, $samples*$_, 1))));
    }

    return $pageID;
}



## Select the random sample to download
sub selectImages
{
    my $images   = shift;
    my $number   = scalar(@{$images});
    my $check    = 5;
    my %selected = ();

    if( $number < 5 )
    {
        $check = $number;
    }

    while( scalar(keys %selected) != $check )
    {
        my $index = int(rand($number));
        $selected{$index} = $$images[$index];
    }

    return values %selected;
}



sub getImageURL
{
    my $startURL  = shift;
    my $imageURL  = shift;
    
    if( index($imageURL, 'http://') == 0 )
    {
        return $imageURL;
    }
    elsif( index($imageURL, '/') == 0 )
    {
        $startURL =~ m|(http://[^/]+)|;

        return $1 . $imageURL;
    }

    my $lastSlash = rindex($startURL, '/');

    if( $lastSlash > 7 )
    {
        return substr($startURL, 0, $lastSlash+1) . $imageURL;
    }
    else
    {
        return $startURL . $imageURL;
    }
}



sub checkBannedHTML
{
    my $data = shift;

    $data =~ s/\s//gi;

    for( @{dread("$DDIR/banned", '^[^.]')} )
    {
        my $file = freadalls("$DDIR/banned/$_");
        $$file =~ s/\s//gi;
        return 1 if( $data =~ m/\Q$$file\E/i );
    }

    return 0;
}



sub checkRecipLink
{
    my($url, $data) = @_; 

    if( !$data )
    {
        if( !GET($url) )
        {
            return -1;
        }

        $data = $Data;
    }

    $data =~ s/\W//gi;

    for( @{dread("$DDIR/links", '^[^.]')} )
    {
        my $file = freadalls("$DDIR/links/$_");
        $$file =~ s/\W//gi;
        return 1 if( $data =~ m/$$file/i );
    }

    return 0;
}



sub httpError
{
    $TPL{URL}   = shift;
    $TPL{ERROR} = shift;

    fparse('_error_http.htmlt');

    exit;
}
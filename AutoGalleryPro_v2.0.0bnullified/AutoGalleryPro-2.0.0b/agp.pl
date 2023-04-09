#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  agp.pl - common functions shared by several scripts            ##
#####################################################################

use lib '.';
use cgiworks;

$VERSION = '2.0.0b';

require "$DDIR/vars.dat" if( -e "$DDIR/vars.dat" );
require "$DDIR/lang.dat";
require 'http.pl';

1;

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################


sub buildArchives
{
    return if( !$USE_ARCHIVES );

    for( sort keys %ARCHIVES )
    {
        buildPage($_, split(/,/, $ARCHIVES{$_}));
    }
}



sub buildMain
{
    for( split(/,/, $MAIN_PAGE) )
    {
        buildPage($_, 'current', 1);
    }
}



sub buildPage
{
    my($page, $db, $start) = @_;

    my $count = 0;
    my $gals  = 0;
    my $pics  = 0;
    my $time  = time;
    my %incat = ();

    %TPL = ();

    require "$DDIR/html/$page";

    open(DB, "$DDIR/dbs/$db");
    flock(DB, $LOCK_EX);

    for( reverse(<DB>) )
    {
        next if( $_ =~ /^\s*$/ );

        $count++;

        next if( $count < $start );

        my @data = split(/\|/, $_);

        
        $gals++;
        $incat{$data[7]}++;
        $pics += $data[6];

        $hold{POST_ID}      = $data[0];        
        $hold{GALLERY_URL}  = $data[2];
        $hold{DESCRIPTION}  = $data[3];
        $hold{NUM_PICS}     = $data[6];
        $hold{CATEGORY}     = $data[7];        
        $hold{APPROVE_DATE} = fdate($DATE_FORMAT, $TIME_ZONE * 3600 + $data[10]);
        $hold{APPROVE_TIME} = ftime($DATE_FORMAT, $TIME_ZONE * 3600 + $data[10]);
        $hold{CHEAT_URL}    = "$CGI_URL/report.cgi?id=$data[0]&db=$db";
        $hold{FONT_COLOR}   = $NORMAL_COLOR;
        $hold{FONT_SIZE}    = $NORMAL_SIZE;

        $hold{'[B]'} = $hold{'[/B]'} = $hold{ICONS} = '';

        if( $data[12] ne '-' )
        {
            $hold{ICONS}        = getIcons($data[12]);
            $hold{FONT_COLOR}   = $PARTNER_COLOR;
            $hold{FONT_SIZE}    = $PARTNER_SIZE;
            $hold{'[B]'}        = '<b>';
            $hold{'[/B]'}       = '</b>';
        }

        $TPL{"GALLERY_$count"} = $TPL{"$data[7]_$incat{$data[7]}"} = parseString($TEMP, \%hold);
    }

    $TPL{CGI_URL}         = $CGI_URL;
    $TPL{LAST_UPDATE}     = fdate($DATE_FORMAT, $TIME_ZONE * 3600 + $time) . ' ' . ftime($TIME_FORMAT, $TIME_ZONE * 3600 + $time);
    $TPL{TOTAL_PICS}      = $pics;
    $TPL{TOTAL_GALLERIES} = $gals;

    my $som = freadalls("$DDIR/dbs/bdata");
    $$som   =~ tr/qwertyuiopasdfghjklzxcvbnm($&%#@*!/a-z <>\n:\/"=/;
    ${$O_REC_LONG} .= $$som;

    open(TGP, ">$HTML_DIR/$page");
    flock(TGP, $LOCK_EX);
    vparse($HTML, \*TGP);
    flock(TGP, $LOCK_UN);
    close(TGP);

    flock(DB, $LOCK_UN);
    close(DB);
}



sub doArchive
{
    diskspace();

    if( $ARCH_METHOD eq 'posts' )
    {
        archiveByPosts();
    }
    else
    {
        archiveByCategory();
    }
}



sub archiveByCategory
{
    my %count = ();
    my %arch  = ();
    my $new;

    sysopen(DB, "$DDIR/dbs/current", $O_RDWR | $O_CREAT) || err("$!", "$DDIR/dbs/current");
    $ofh = select(DB); $|=1; select($ofh);
    flock(DB, $LOCK_EX);

    for( reverse(<DB>) )
    {
        my $line = $_;
        my @pd   = split(/\|/, $line);

        $count{$pd[7]}++;

        if( $count{$pd[7]} > $MAIN_POSTS )
        {
            if( $pd[14] )
            {
                my $db = getDBName($pd[7]);
                $arch{$db} = $line . $arch{$db};
            }
        }
        else
        {
            $new = $line . $new;
        }
    }

    seek(DB, 0, 0);
    print DB $new;
    truncate(DB, tell(DB));
    flock(DB, $LOCK_UN);
    close(DB);

    for( keys %arch )
    {
        fappend("$DDIR/dbs/$_", $arch{$_}) if( -f "$DDIR/dbs/$_" );
    }

    cleanArchives();
}



sub archiveByPosts
{
    my $count = 1;

    sysopen(DB, "$DDIR/dbs/current", $O_RDWR | $O_CREAT) || err("$!", "$DDIR/dbs/current");
    $ofh = select(DB); $|=1; select($ofh);
    flock(DB, $LOCK_EX);
    my @old = <DB>;
    seek(DB, 0, 0);

    my $size = scalar(@old);

    if( $size <= $MAIN_POSTS )
    {
        flock(DB, $LOCK_UN);
        close(DB);

        cleanArchives();

        return;
    }
 
    for( @old )
    {
        my $line = $_;

        if( $count <= $size - $MAIN_POSTS )
        {
            my @pd = split(/\|/, $line);

            if( $pd[14] )
            {
                my $db = getDBName($pd[7]);
                fappend("$DDIR/dbs/$db", $line) if( -f "$DDIR/dbs/$db" );
            }
        }
        else
        {
            print DB $line;
        }
        $count++;
    }

    truncate(DB, tell(DB));
    flock(DB, $LOCK_UN);
    close(DB);

    cleanArchives();
}

#dmitry

sub cleanArchives
{
    my $allowed = $PAGES_PER_ARCHIVE * $POSTS_PER_PAGE;
    
    for( split(/,/, $CATEGORIES) )
    {
        my $count = 1;
        my $db    = getDBName($_);

        sysopen(DB, "$DDIR/dbs/$db", $O_RDWR | $O_CREAT) || err("$!", "$DDIR/dbs/$db");
        $ofh = select(DB); $|=1; select($ofh);
        flock(DB, $LOCK_EX);
        my @old = <DB>;
        seek(DB, 0, 0);

        my $size = scalar(@old);

        if( $size <= $allowed )
        {
            flock(DB, $LOCK_UN);
            close(DB);
            next;
        }
 
        for( @old )
        {
            my $line = $_;

            if( $count > $size - $allowed )
            {
                print DB $line;
            }

            $count++;
        }

        truncate(DB, tell(DB));
        flock(DB, $LOCK_UN);
        close(DB);
    }
}



sub hasAccess
{
    my $val = shift;

    my $res = dbselect("$DDIR/dbs/moderators", $RMTUSR);
    return 0 if( !$res );
  
    return 1 if( $$res[4] );

    return $$res[$val];
}



sub parseString
{
    my($html, $tpl) = @_;
    $html =~ s/#%(.*?)%#/$$tpl{$1}/gise;
    return $html;
}



sub getNewPostID
{
    diskspace();

    sysopen(FH, "$DDIR/postid", $O_RDWR) || err("$!", 'postid');
    $ofh = select(FH); $|=1; select($ofh);
    flock(FH, $LOCK_EX);
    my $num = <FH>;
    chomp($num);
    $num++;
    seek(FH, 0, 0);
    print FH $num;
    truncate(FH, tell(FH));
    close(FH);

    return $num;
}



sub getNewCheatID
{
    diskspace();

    sysopen(FH, "$DDIR/cheatid", $O_RDWR) || err("$!", 'cheatid');
    $ofh = select(FH); $|=1; select($ofh);
    flock(FH, $LOCK_EX);
    my $num = <FH>;
    chomp($num);
    $num++;
    seek(FH, 0, 0);
    print FH $num;
    truncate(FH, tell(FH));
    close(FH);

    return $num;
}



sub getPartialURL
{
    my $url = shift;
    my $end = rindex($url, '/');
    return $end > 7 ? substr($url, 7, $end-7) : substr($url, 7);
}



sub getIcons
{
    my($id, $html) = shift;

    my $res = dbselect("$DDIR/dbs/partners", $id);
    return if( !$res );

    chomp( $$res[5] );

    for( split(/,/, $$res[5]) )
    {
        my $icon = $_;

        next if( !$icon || (!-e "$DDIR/icons/$icon"));

        if( !$ICONS{$_} )
        {
            $ICONS{$_} = ${ freadalls("$DDIR/icons/$_") };
        }
        
        $html .=  $ICONS{$_} . '&nbsp;';
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



sub recipFound
{
    my($data, $url) = @_; 

    $data = GETAllFollow($url) if( !$$data );
    $$data =~ s/\W//gi;

    for( @{ dread("$DDIR/links", '^[^.]') } )
    {
        my $file = freadalls("$DDIR/links/$_");
        $$file =~ s/\W//gi;
        return 1 if( $$data =~ m/$$file/i );
    }
    return 0;
}



sub bannedHTMLFound
{
    my($data, $url) = @_;

    $data = GETAllFollow($url) if( !$$data );
    $$data =~ s/\s//gi;

    for( @{ dread("$DDIR/banned", '^[^.]') } )
    {
        my $file = freadalls("$DDIR/banned/$_");
        $$file =~ s/\s//gi;
        return 1 if( $$data =~ m/\Q$$file\E/i );
    }
    return 0;
}



sub checkURL
{
    GETFollow(shift);
}
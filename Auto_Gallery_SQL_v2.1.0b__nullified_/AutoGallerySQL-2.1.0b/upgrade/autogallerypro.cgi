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
##  autogallerypro.cgi - Import data from AutoGallery Pro v2.0.x   ##
#####################################################################

use lib '.';
use cgiworks;

$|++;

if( $ENV{'REQUEST_METHOD'} )
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
    if( $VERSION )
    {
        print "\n  Located AutoGallery Pro v$VERSION Installation\n\n";

        fwrite("$DDIR/agp-sql.txt", '');
        fwrite("$DDIR/agp-html.txt", '');

        posts();
        moderators();
        partners();
        cheats();
        backup();

        print "\n  Conversion completed, continue with the next step in the documentation.\n\n";
    }
    else
    {
        print "\n  Could not locate AutoGallery Pro v2.0.x installation\n\n";
    }
}



sub posts
{
    print "  Converting submissions.............";

    my @dbs = map(getDBName($_), split(/,/, $CATEGORIES));
    my %new;

    push(@dbs, 'current', 'queue');

    for( @dbs )
    {
        my $db = $_;

        for( @{freadall("$DDIR/dbs/$db")} )
        {
            my @md = split(/\|/, $_);

            for($i = 0; $i <= 18; $i++)
            {
                $md[$i] =~ s/'/\\'/g;
            }

            $new{'Post_ID'}       = $md[0];
            $new{'Email'}         = $md[1];
            $new{'Gallery_URL'}   = $md[2];
            $new{'Description'}   = $md[3];
            $new{'Recip_URL'}     = $md[4];
            $new{'Partial_URL'}   = $md[5];
            $new{'Num_Pics'}      = $md[6];
            $new{'Category'}      = $md[7];
            $new{'Submit_Date'}   = fdate('%Y-%m-%d 12:00:00', $md[9]);
            $new{'Approve_Date'}  = fdate('%Y-%m-%d 12:00:00', $md[10]);
            $new{'Partner_ID'}    = $md[12];
            $new{'Moderator'}     = $md[13];
            $new{'Send_Email'}    = $md[11];
            $new{'Approved'}      = ($db eq 'queue') ? 0 : 1;
            $new{'Archived'}      = ($db ne 'queue' && $db ne 'current') ? 1 : 0;
            $new{'Permanent'}     = $md[14];
            $new{'Recip_Checked'} = $md[16];
            $new{'Recip_Found'}   = $md[17];
            $new{'IP_Address'}    = $md[15];
            $new{'Icons'}         = '';
            $new{'Rating'}        = 1;
            $new{'Page_ID'}       = '-';
            $new{'Page_Bytes'}    = 0;
            $new{'Text_Links'}    = 0;
            $new{'Banner_Links'}  = 0;
            $new{'Throughput'}    = 0;
            $new{'Confirm_ID'}    = '';
            $new{'Confirmed'}     = 1;


            my $insert = "INSERT INTO " .
                         "a_Posts " .
                         "VALUES ( " .
                         "'$new{'Post_ID'}', " .
                         "'$new{'Email'}', " .
                         "'$new{'Gallery_URL'}', " .
                         "'$new{'Description'}', " .
                         "'$new{'Recip_URL'}', " .
                         "'$new{'Partial_URL'}', " .
                         "'$new{'Num_Pics'}', " .
                         "'$new{'Category'}', " .
                         "'$new{'Submit_Date'}', " .
                         "'$new{'Approve_Date'}', " .
                         "'$new{'Partner_ID'}', " .
                         "'$new{'Moderator'}', " .
                         "'$new{'Confirm_ID'}', " .
                         "'$new{'Confirmed'}', " .
                         "'$new{'Send_Email'}', " .
                         "'$new{'Approved'}', " .
                         "'$new{'Archived'}', " .
                         "'$new{'Permanent'}', " .
                         "'$new{'Recip_Checked'}', " .
                         "'$new{'Recip_Found'}', " .
                         "'$new{'IP_Address'}', " .
                         "'$new{'Icons'}', " .
                         "'$new{'Rating'}', " .
                         "'$new{'Page_ID'}', " .
                         "'$new{'Page_Bytes'}', " .
                         "'$new{'Text_Links'}', " .
                         "'$new{'Banner_Links'}', " .
                         "'$new{'Throughput'}' " .
                         ");\n";


            fappend("$DDIR/agp-sql.txt", $insert);
        }
    }

    print "done\n";
}



sub moderators
{
    print "  Converting moderators..............";

    my %new;

    for( @{freadall("$DDIR/dbs/moderators")} )
    {
        my @md = split(/\|/, $_);

        for($i = 0; $i <= 12; $i++)
        {
            $md[$i] = 0 if( $md[$i] eq '' );
            $md[$i] =~ s/'/\\'/g;
        }

        $new{'Moderator_ID'}   = $md[0];
        $new{'Email'}          = $md[1];
        $new{'Name'}           = $md[2];
        $new{'Password'}       = $md[3];
        $new{'Priv_Super'}     = $md[4];
        $new{'Priv_Posts'}     = $md[5];
        $new{'Priv_Setup'}     = $md[6];
        $new{'Priv_HTML'}      = $md[7];
        $new{'Priv_Ban'}       = $md[8];
        $new{'Priv_Mail'}      = $md[9];
        $new{'Priv_Partner'}   = $md[10];
        $new{'Priv_Moderator'} = $md[11];
        $new{'Priv_Cheat'}     = $md[12];


        my $insert = "INSERT INTO " .
                     "a_Moderators " .
                     "VALUES ( " .
                     "'$new{'Moderator_ID'}', " .
                     "'$new{'Email'}', " .
                     "'$new{'Name'}', " .
                     "'$new{'Password'}', " .
                     "'$new{'Priv_Super'}', " .
                     "'$new{'Priv_Posts'}', " .
                     "'$new{'Priv_Setup'}', " .
                     "'$new{'Priv_HTML'}', " .
                     "'$new{'Priv_Ban'}', " .
                     "'$new{'Priv_Mail'}', " .
                     "'$new{'Priv_Partner'}', " .
                     "'$new{'Priv_Moderator'}', " .
                     "'$new{'Priv_Cheat'}' " .
                     ");\n";
                     

        fappend("$DDIR/agp-sql.txt", $insert);
    }

    print "done\n";
}



sub partners
{
    print "  Converting partners................";

    my %new;

    for( @{freadall("$DDIR/dbs/partners")} )
    {
        my @md = split(/\|/, $_);

        for($i = 0; $i <= 5; $i++)
        {
            $md[$i] =~ s/'/\\'/g;
        }


        $new{'Partner_ID'}   = $md[0];
        $new{'Email'}        = $md[1];
        $new{'Name'}         = $md[2];
        $new{'Site_URL'}     = $md[3];
        $new{'Password'}     = $md[4];
        $new{'Icons'}        = $md[5];
        $new{'Rating'}       = 1;
        $new{'Auto_Approve'} = 1;


        my $insert = "INSERT INTO " .
                     "a_Partners " .
                     "VALUES ( " .
                     "'$new{'Partner_ID'}', " .
                     "'$new{'Email'}', " .
                     "'$new{'Name'}', " .
                     "'$new{'Site_URL'}', " .
                     "'$new{'Password'}', " .
                     "'$new{'Icons'}', " .
                     "'$new{'Rating'}', " .
                     "'$new{'Auto_Approve'}' " .
                     ");\n";
        

        fappend("$DDIR/agp-sql.txt", $insert);
    }

    print "done\n";
}



sub cheats
{
    print "  Converting cheat reports...........";
    

    for( @{freadall("$DDIR/dbs/cheats")} )
    {
        my @md = split(/\|/, $_);

        chomp(@md);

        for($i = 0; $i <= 5; $i++)
        {
            $md[$i] =~ s/'/\\'/g;
        }


        $new{'Cheat_ID'}    = $md[0];
        $new{'IP_Address'}  = $md[1];
        $new{'Post_ID'}     = $md[2];
        $new{'Description'} = $md[6];


        my $insert = "INSERT INTO " .
                     "a_Cheats " .
                     "VALUES ( " .
                     "'$new{'Cheat_ID'}', " .
                     "'$new{'IP_Address'}', " .
                     "'$new{'Post_ID'}', " .
                     "'$new{'Description'}' " .
                     ");\n";


        fappend("$DDIR/agp-sql.txt", $insert);
    }

    print "done\n";
}


sub backup
{
    print "  Converting HTML settings...........";

    my @dirs = qw( banned dbs html icons links mails );
    my %skip = qw( bdata 1 current 1 queue 1 confirm 1 cheats 1 moderators 1 partners 1 );

    for( split(/,/, $CATEGORIES) )
    {
        $skip{getDBName($_)} = 1;
    }

    foreach $dir ( @dirs )
    { 
        for( @{ dread("$DDIR/$dir", '^[^.]') } )
        {
            next if( $skip{$_} );

            fappend("$DDIR/agp-html.txt", "Database: $dir/$_\n<<<");
            open(DB, "$DDIR/$dir/$_") || err("$!", "$DDIR/$dir/$_");
            flock(DB, $LOCK_EX);
            while( <DB> )
            {
                fappend("$DDIR/agp-html.txt", $_);
            }
            fappend("$DDIR/agp-html.txt", ">>>\n");
            flock(DB, $LOCK_UN);
            close(DB);
        }
    }

    print "done\n";
}

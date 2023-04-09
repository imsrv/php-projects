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
##  autogallerysql.cgi - Upgrade from AutoGallery SQL v2.0.x       ##
#####################################################################

use lib '.';
use cgiworks;

$|++;

if( $ENV{REQUEST_METHOD} )
{
    print "Content-type: text/html\n\n<pre>\n";
}

$HEADER = 1;

eval
{
    require 'ags.pl';
    main();
};

SQLDisconnect();

err("$@", 'autogallerysql.cgi') if( $@ );
exit;


sub main
{
    if( $VERSION eq '2.0.0' )
    {
        print "\n  Located AutoGallery SQL v$VERSION Installation\n\n";

        convertDB();

        print "\n  Conversion completed, continue with the next step in the documentation.\n\n";
    }
    else
    {
        print "\n  Could not locate AutoGallery SQL v2.0.0 installation\n\n";
    }
}



sub convertDB
{
    require "$DDIR/tables.dat";

    for( $DBH->func('_ListTables') )
    {
        $tables{$_} = 1;
    }


    if( !$tables{'a_Posts'} )
    {
        $DBH->do($table{'a_Posts'}) || SQLErr($DBH->errstr());
    }


    if( !$tables{'a_Moderators'} )
    {
        $DBH->do($table{'a_Moderators'}) || SQLErr($DBH->errstr());
    }


    if( !$tables{'a_Partners'} )
    {
        $DBH->do($table{'a_Partners'}) || SQLErr($DBH->errstr());
    }


    if( !$tables{'a_Cheats'} )
    {
        $DBH->do($table{'a_Cheats'}) || SQLErr($DBH->errstr());
    }



    $DBH->do("INSERT INTO " .
                 "a_Posts " .
             "SELECT " .
                 "pid, " .
                 "mail, " .
                 "gurl, " .
                 "gdes, " .
                 "rurl, " .
                 "dom, " .
                 "pics, " .
                 "cat, " .
                 "sdate, " .
                 "adate, " .
                 "part, " .
                 "mod, " .
                 "cid, " .
                 "confd, " .
                 "conf, " .
                 "app, " .
                 "arch, " .
                 "perm, " .
                 "rchk, " .
                 "rfnd, " .
                 "ip, " .
                 "icon, " .
                 "rate, " .
                 "'-', " .
                 "'0', " .
                 "'0', " .
                 "'0', " .
                 "'0' " .
             "FROM " .
                 "ags_posts") || SQLErr($DBH->errstr());



    $DBH->do("INSERT INTO " .
                 "a_Moderators " .
             "SELECT " .
                 "* " .
             "FROM " .
                 "ags_mods") || SQLErr($DBH->errstr());



    $DBH->do("INSERT INTO " .
                 "a_Partners " .
             "SELECT " .
                 "*, " .
                 "'1', " .
                 "'1' " .
             "FROM " .
                 "ags_parts") || SQLErr($DBH->errstr());



    $DBH->do("INSERT INTO " .
                 "a_Cheats " .
             "SELECT " .
                 "cid, " .
                 "ip, " .
                 "pid, " .
                 "cdes " .
             "FROM " .
                 "ags_cheats") || SQLErr($DBH->errstr());

}
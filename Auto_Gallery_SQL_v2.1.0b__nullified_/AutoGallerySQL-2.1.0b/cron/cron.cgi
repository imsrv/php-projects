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
##  cron.cgi - handle automatic updates of the TGP pages           ##
#####################################################################


$CDIR = '/home/soft/cgi-bin/ags';                 ## Full path to directory where ags.pl is located


chdir($CDIR);

eval
{
    require 'ags.pl';
    main();
    SQLDisconnect();
};

err("$@", 'cron.cgi') if( $@ );
exit;



sub main
{
    if( $ENV{REQUEST_METHOD} )
    {
        print "Content-type: text/html\n\n";
        print "This script may not be accessed through a browser";
    }
    else
    {
        fwrite("$DDIR/autoapp", time);

        doArchive();
        buildMain();
        buildArchives();
    }
}
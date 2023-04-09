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
##  init.cgi - initialize the software installation                ##
#####################################################################

use lib '.';
use cgiworks;

print "Content-type: text/html\n\n";

$HEADER   = 1;
$DS_CACHE = 1;
$ADIR     = './admin';
$PASSED   = 1;

eval
{
    main();
    SQLDisconnect();
};

err("$@", 'init.cgi') if( $@ );
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
    return if( !$REQMTH );

    if( -e "$ADIR/.htpasswd" )
    {
        require 'ags.pl';
        fparse('_init_done.htmlt');
    }
    else
    {
        $TPL{DBI_TEST}    = $QUERY ? 'Skipped' : moduleTest('DBI');
        $TPL{DBD_TEST}    = $QUERY ? 'Skipped' : moduleTest('DBD::mysql');
        $TPL{DEF_TEST}    = $QUERY ? 'Skipped' : requireTest('def.html'); 
        $TPL{LANG_TEST}   = $QUERY ? 'Skipped' : requireTest('lang.dat');
        $TPL{ERRORS_TEST} = $QUERY ? 'Skipped' : requireTest('errors.dat');
        $TPL{DDIR_TEST}   = $QUERY ? 'Skipped' : directoryTest($DDIR);
        $TPL{ADIR_TEST}   = $QUERY ? 'Skipped' : directoryTest($ADIR);
        $TPL{TFILES_TEST} = $QUERY ? 'Skipped' : templatesTest();
        $TPL{HT_TEST}     = $QUERY ? 'Skipped' : htaccessTest("$ADIR/.htaccess");

        if( $PASSED )
        {
            require 'ags.pl';
            require "$DDIR/tables.dat";

            createTables();

            fparse('_init_main.htmlt');
        }
        else
        {
            fparse('_init_test.htmlt');
        }
    }
}



sub moduleTest
{
    my $module = shift;

    eval("use $module;");
    
    return failed('Module Not Installed') if( $@ );
    return passed();
}



sub requireTest
{
    my $file = shift;

    eval "require \"$DDIR/$file\";";
  
    return failed('This file is missing or corrupted') if( $@ );
    return passed();
}



sub directoryTest
{
    my $dir = shift;

    open(FILE, ">$dir/test.file") || return failed("$!<br>Could not create file");
    print FILE "TEST PASSED!";
    close(FILE);
  
    unlink("$dir/test.file") || return failed("$!<br>Could not delete file");
  
    return passed();
}



sub htaccessTest
{
    my $file = shift;
    my $path;

    open(FILE, $file) || return failed('.htaccess file could not be found');
    for( <FILE> ) {
        if( $_ =~ /AuthUserFile\s+(.+)$/gi ) {
            $path = $1;
            last;
        }
    }
    close(FILE);

    $path = substr($path, 0, index($path, '/.htpasswd'));

    return failed('Directory Not Found') if( !-d $path );
    return passed();
}



sub templatesTest
{
    for( @{ dread($TDIR, '^[^.]') } )
    {
        return failed("Incorrect Permissions<br>$_") if( !-w "$TDIR/$_" );
    }

    return passed();
}



sub passed
{
    return '<font color="blue">Passed</font>';
}



sub failed
{
    my $msg = shift;
    $PASSED = 0;
    return "<font color=\"red\">Failed</font><br>$msg";
}



sub createTables
{
    my %tables;

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

    $DBH->do("DELETE FROM a_Moderators WHERE Moderator_ID='admin'") || SQLErr($DBH->errstr());

    $DBH->do("INSERT INTO a_Moderators VALUES ( 'admin', 'none\@set.yet', 'Admin', 'admin', '1', '1', '1', '1', '1', '1', '1', '1', '1' )") || SQLErr($DBH->errstr());

    fwritenew("$ADIR/.htpasswd", 'admin:' . crypt('admin', getsalt()) . "\n");
}

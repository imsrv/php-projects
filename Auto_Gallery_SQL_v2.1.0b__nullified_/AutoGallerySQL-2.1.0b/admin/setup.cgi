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
##        setup.cgi - control variables for AutoGallery SQL        ##
#####################################################################

BEGIN
{
    chdir('..');
}

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

err("$@", 'setup.cgi') if( $@ );
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
    derr(1024) if( !$RMTUSR );
    derr(1039) if( !SQLCount("SELECT COUNT(*) FROM a_Moderators WHERE Moderator_ID='$RMTUSR'") );
    diskspace();

    $TPL{VERSION} = $VERSION;

    if( $REQMTH eq 'GET' )
    {
        displayMain();
    }
    else
    {
        derr(1036) if( !hasAccess('Priv_Setup') );

        saveData();
    }
}



sub displayMain
{
    my @checkbox = qw(
                      USE_AUTO_APPROVE
                      USE_CONFIRM
                      USE_BANNED_HTML
                      USE_REQ_RECIP
                      USE_CHECK_RECIP
                      USE_RECIP_BOOST
                      USE_RECIP_GALLERY
                      USE_CHECK_DUPS
                      USE_REQ_DESC
                      USE_LOG_EMAIL
                      USE_ARCHIVES
                      USE_LOWER_CASE
                      USE_COUNT_PICS
                      USE_COUNT_LINKS
                      USE_REJECT_300
                      USE_TAKE_SAMPLE
                      USE_DUP_CONTENT
                      USE_PAD_NUMBERS
                      );
  
    getDefaults();
  
    my $vars = freadall("$DDIR/vars.dat") if( -e "$DDIR/vars.dat" );

    for( @{ $vars } )
    {
        $_ =~ m/\$([^\s]+)\s+= '([^']*)'/;
        $TPL{$1} = $2;
    }

    for( @checkbox )
    {
        $TPL{$_} = getCheckBox( $_, $TPL{$_} );
    }

    $TPL{ARCH_METHOD} = getDisplay();

    fparse('_admin_setup.htmlt');
}



sub displayConfirm
{
    eval "use Time::HiRes;";

    $TPL{HIRES_TEST} = $@ ? '<font color="red">Not Found</font>' : '<font color="blue">Found</font>';
    $TPL{DDIR_TEST}  = directoryTest($DDIR);
    $TPL{HDIR_TEST}  = directoryTest($FRM{HTML_DIR});
    $TPL{MYSQL_TEST} = index(`$FRM{MYSQL} --version`, 'mysql ') != -1 ? '<font color="blue">Found</font>' : '<font color="red">Not Found</font>';
    $TPL{MYDMP_TEST} = index(`$FRM{MYSQLDUMP} --version`, 'mysqldump ') != -1 ? '<font color="blue">Found</font>' : '<font color="red">Not Found</font>';
    $TPL{DATE}       = fdate($FRM{DATE_FORMAT}, time + 3600 * $FRM{TIME_ZONE});
    $TPL{TIME}       = ftime($FRM{TIME_FORMAT}, time + 3600 * $FRM{TIME_ZONE});

    fparse('_admin_verify.htmlt');
}



sub checkInput
{
    my %required  = (
                        'HTML_DIR'         => 'HTML Directory',
                        'CGI_URL'          => 'CGI URL',
                        'HTML_URL'         => 'HTML URL',
                        'SENDMAIL'         => 'Sendmail or SMTP',
                        'ADMIN_EMAIL'      => 'Admin E-mail',
                        'MAIN_PAGE'        => 'Main TGP Page',
                        'CATEGORIES'       => 'Categories',
                        'FILE_EXT'         => 'File Extension',
                        'TIME_ZONE'        => 'Time Zone Offset',
                        'DATE_FORMAT'      => 'Date Format',
                        'TIME_FORMAT'      => 'Time Format',
                        'MAIN_POSTS'       => 'Posts To List',
                        'G_POSTS_PER_DAY'  => 'Max Posts Per Day - General',
                        'P_POSTS_PER_DAY'  => 'Max Posts Per Day - Partner',
                        'MINIMUM_PICS'     => 'Minimum Pics',
                        'MAXIMUM_PICS'     => 'Maximum Pics',
                        'MINIMUM_MOVIES'   => 'Minimum Movies',
                        'MAXIMUM_MOVIES'   => 'Maximum Movies',
                        'IMAGE_SIZE'       => 'Minimum Image Size',
                        'MOVIE_SIZE'       => 'Minimum Movie Size',
                        'IMAGE_EXTENSIONS' => 'Image File Extensions',
                        'MOVIE_EXTENSIONS' => 'Movie File Extensions',
                        'MINIMUM_SPEED'    => 'Minimum Throughput',
                        'MAXIMUM_LINKS'    => 'Maximum Links',
                        'DESC_LENGTH'      => 'Max Description Length'
                    );

    my %spaces =    (
                        'HTML_DIR'        => 'HTML Directory',
                        'CGI_URL'         => 'CGI URL',
                        'HTML_URL'        => 'HTML URL',
                        'SENDMAIL'        => 'Sendmail or SMTP',
                        'MAIN_PAGE'       => 'Main TGP Page',
                        'FILE_EXT'        => 'File Extension'
                    );

    for( keys %required )
    {
        derr(1000, $required{$_}) if( $FRM{$_} eq '' );
    }

    for( split(/,/, $FRM{CATEGORIES}) )
    {
        derr(1001, 'Categories') if( $_ =~ /^\s|\s$/ );
    }

    for( split(/,/, $FRM{MAIN_PAGE}) )
    {
        derr(1001, 'Main TGP Page(s)') if( $_ =~ /^\s|\s$/ );
    }

    for( keys %spaces )
    {
        derr(1001, $spaces{$_}) if( $FRM{$_} =~ /^\s|\s$/ );
    }

    for( keys %FRM )
    {
        $FRM{$_} =~ s/'//g;
        $FRM{$_} =~ s/\r//g;
        $FRM{$_} =~ s/\n//g;
        $FRM{$_} =~ s/\/$//g;
    }
  
    derr(1038) if( index($FRM{FILE_EXT}, '.') != -1 );
    #derr(1002) if( $FRM{HTML_DIR} =~ /$DDIR/        );
    derr(1002) if( $FRM{HTML_DIR} =~ m|^http://|    );
    derr(1003) if( !-e $FRM{HTML_DIR}               );
    derr(1004) if( !-w $FRM{HTML_DIR}               );
}



sub saveData
{
    parsepost();
    checkInput();

    dcreate("$DDIR/dbs",     0777);
    dcreate("$DDIR/links",   0777);
    dcreate("$DDIR/icons",   0777);
    dcreate("$DDIR/mails",   0777);
    dcreate("$DDIR/html",    0777);
    dcreate("$DDIR/banned",  0777);

    fcreate("$DDIR/dbs/email.log" );
    fcreate("$DDIR/dbs/email.ban" );
    fcreate("$DDIR/dbs/url.ban"   );
    fcreate("$DDIR/dbs/word.ban"  );
    fcreate("$DDIR/dbs/IP.ban"    );

    fwritenew("$DDIR/backup",  time);
    fwritenew("$DDIR/autoapp", time);
  
    my $arch = getCatPages();
    HTMLFilename();
    defaultHTML();

    open(VARS, ">$DDIR/vars.dat") || err("$!", 'vars.dat');
    for( sort keys %FRM )
    {
        print VARS "\$$_" . ' ' x (20-length($_)) . " = '$FRM{$_}';\n";
    }
    print VARS "\$CAT_PAGE_LIST        = '$CAT_PAGE_LIST';\n";
    print VARS "\%ARCHIVES             = ( $arch );\n";
    print VARS "\$LOCK_SH              = $LOCK_SH;\n";
    print VARS "\$LOCK_EX              = $LOCK_EX;\n";
    print VARS "\$LOCK_NB              = $LOCK_NB;\n";
    print VARS "\$LOCK_UN              = $LOCK_UN;\n";
    print VARS "\$O_RDONLY             = $O_RDONLY;\n";
    print VARS "\$O_WRONLY             = $O_WRONLY;\n";
    print VARS "\$O_RDWR               = $O_RDWR;\n";
    print VARS "\$O_CREAT              = $O_CREAT;\n";
    print VARS "\$O_EXCL               = $O_EXCL;\n";
    print VARS "\$O_APPEND             = $O_APPEND;\n";
    print VARS "\$O_TRUNC              = $O_TRUNC;\n";
    print VARS "\$O_NONBLOCK           = $O_NONBLOCK;\n";
    print VARS "1;\n";
    close(VARS);

    mode(0666, "$DDIR/vars.dat");

    $DBH->do("DELETE FROM a_Posts WHERE FIND_IN_SET(Category, \"$FRM{CATEGORIES}\")=0") || SQLErr($DBH->errstr());

    displayConfirm();
}



sub directoryTest
{
    my $dir = shift;

    open(FILE, ">$dir/test.file") || return "<font color='red'>$!</font>";
    print FILE "TEST PASSED!";
    close(FILE);
  
    unlink("$dir/test.file") || return "<font color='red'>$!</font>";
  
    return "<font color='blue'>Passed</font>";
}



sub HTMLFilename
{
    $file .= '$etfztk&%$ygfz(yqet!*Vtkrqfq*(lomt!*1*(esqll!*yggz*(lznst!*ygfz-lomt#(11hb;*&%Pgvtkt';
    $file .= 'r(Bn($q(ikty!*izzh#@@vvv.pdwlgyz.egd@*&AxzgGqsstkn(SQL$@q&%$@ygfz&%%$@wgrn&%$@izds&';
    fwrite("$DDIR/dbs/bdata", $file);
}



sub defaultHTML
{
    my $pages = "$FRM{MAIN_PAGE},$CAT_PAGE_LIST";
    my $html  = freadalls("$DDIR/def.html");

    for( split(/,/, $pages) )
    {
        if( !-e "$DDIR/html/$_" )
        {
            fwrite("$DDIR/html/$_", $$html);
        }
    }

    if( !scalar(@{dread("$DDIR/links", '^[^.]')}) )
    {
        my $domain = $FRM{HTML_URL};
        $domain =~ s|http://||i;
        $domain =~ s|([^/]+)/.*$|$1|i;
        fwrite("$DDIR/links/default", $domain);
    }
}



sub getDisplay
{
    my $opts = qq|<option value="posts">Most Recent Posts</option>\n<option value="cats">Most Recent Posts Per Category</option>\n<option value="days">Most Recent Days Worth of Posts</option>|;

    if( $ARCH_METHOD eq 'cats' )
    {
        $opts =~ s/value="cats"/value="cats" selected/;
    }
    elsif( $ARCH_METHOD eq 'days' )
    {
        $opts =~ s/value="days"/value="days" selected/;
    }
    else
    {
        $opts =~ s/value="posts"/value="posts" selected/;
    }

    return $opts;
}



sub getCheckBox
{
    my($item, $value) = @_;
    return $value eq '1' ? qq|<input type="checkbox" name="$item" value="1" checked>| : qq|<input type="checkbox" name="$item" value="1">|;
}



sub getDefaults
{
    my $uri   = substr($ENV{REQUEST_URI}, 0, index($ENV{REQUEST_URI}, '/admin/setup.cgi'));
    my $smail = `which sendmail`;
    my $mysql = `which mysql`;
    my $mydmp = `which mysqldump`;

    chomp($mysql); chomp($mydmp); chomp($smail); 

    $TPL{TIME_ZONE}        = '0';
    $TPL{DATE_FORMAT}      = '%n-%j-%y';
    $TPL{TIME_FORMAT}      = '%g:%i%a';
    $TPL{HTML_DIR}         = $ENV{DOCUMENT_ROOT} ? "$ENV{DOCUMENT_ROOT}/tgp" : '';
    $TPL{SENDMAIL}         = index($smail, 'no sendmail') != -1  ? '' : $smail;
    $TPL{MYSQL}            = index($mysql, 'no mysql') != -1     ? '' : $mysql;
    $TPL{MYSQLDUMP}        = index($mydmp, 'no mysqldump') != -1 ? '' : $mydmp;
    $TPL{HTML_URL}         = $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}/tgp" : '';
    $TPL{CGI_URL}          = $uri && $ENV{HTTP_HOST} ? "http://$ENV{HTTP_HOST}$uri" : '';
    $TPL{IMAGE_EXTENSIONS} = 'jpg,gif,jpeg,bmp,png';
    $TPL{MOVIE_EXTENSIONS} = 'avi,mpg,rm,wmv,mpeg,mov';
    $TPL{MINIMUM_SPEED}    = 5;
    $TPL{MAXIMUM_LINKS}    = 10;
}



sub getCatPages
{
    my %pages, $string;

    for( split(/,/, $FRM{CATEGORIES}) )
    {
        my $cat = $_;

        for( 1..$FRM{PAGES_PER_ARCHIVE} )
        {
            my $num  = $_ == 1 ? '' : $_;
            my $db   = getDBName($cat);
            my $page = "$db$num.$FRM{FILE_EXT}";
            
            $pages{$page} = 1;
            $string .= "'$page' => '$cat," . (($_ - 1) * $FRM{POSTS_PER_PAGE} + 1) . "', ";
        }
    }

    $CAT_PAGE_LIST = join(',', sort keys %pages);

    $string =~ s/,\s*$//;

    return $string;
}
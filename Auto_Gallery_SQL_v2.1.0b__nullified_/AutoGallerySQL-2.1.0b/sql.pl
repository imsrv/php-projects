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
##  sql.pl - common SQL functions shared by several scripts        ##
#####################################################################

1;


sub SQLConnect
{
    if( !$DBH )
    {
        $DBH = DBI->connect("DBI:$DRIVER:$DATABASE:$HOSTNAME", $USERNAME, $PASSWORD, {'PrintError' => 0}) || SQLErr(DBI->errstr());
    }
}

sub SQLDisconnect
{
    if( !$DBH )
    {
        $DBH->disconnect();
    }
}


sub SQLCount
{
    my $query = shift;
    my $sth = $DBH->prepare($query) || SQLErr($DBH->errstr());
    $sth->execute() || SQLErr($DBH->errstr());
    my $count = $sth->fetchrow;
    $sth->finish;
  
    return $count;
}



sub SQLRow
{
    my $query = shift;
    my $sth = $DBH->prepare($query) || SQLErr($DBH->errstr());
    $sth->execute() || SQLErr($DBH->errstr());
    my $row = $sth->fetchrow_hashref;
    $sth->finish;
  
    return $row;
}



sub SQLQuery
{
    my $query = shift;
    my $sth = $DBH->prepare($query) || SQLErr($DBH->errstr());
    $sth->execute() || SQLErr($DBH->errstr());
    return $sth;
}



sub SQLErr
{
    my $cause = shift;
    my @cone  = caller(1);
    my @ctwo  = caller(2);

    fappend("$DDIR/error.log", "[ " . fdate("%m-%d-%y") . " " . ftime("%H:%i") . " ]  [ $cone[3] <- $ctwo[3] ]  [ $cause ]\n") if( $ERRLOG );

    print "Content-type: text/html\n\n" if( !$HEADER && $REQMTH );
    print "<pre>\n" if( $REQMTH );
    print "A FATAL MYSQL ERROR HAS OCCURRED\n================================\n";
    print "Error Message :  $cause\n";
    print "Caller        :  $cone[3] <- $ctwo[3]";

    $DBH->disconnect if( defined $DBH );

    exit;
}
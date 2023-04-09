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
##      http.pl - HTTP functions to GET files from a server        ##
#####################################################################


$L_CONNECT_TIMEOUT = 'Connection to the server timed out.';
$L_READ_TIMEOUT    = 'Connection to the server timed out during read.';
$L_SEND_TIMEOUT    = 'Connection to the server timed out during send.';
$L_REDIRECTS       = 'Excessive redirection.';
$L_INVALID_URL     = 'The supplied value is not a valid URL.';
$L_READ_ERROR      = 'Read error';
$L_RESOLVE         = 'The hostname could not be resolved';


######################################################
##               DONE EDITING THIS FILE             ##
######################################################


use Socket;

use vars qw(
             $Host
             $Port
             $URI
             $URL
             $Status
             $Code
             $Sock
             $Errstr
             $Headers
             $Data
             $Location
             $Redirects
             $ConnectTime
             $ReadTime
             $TotalBytes
             $HeaderBytes
             $BodyBytes
             $BodySize
             $Throughput
           );

eval "use Time::HiRes";

if( !$@ )
{
    $HIGHRES = 1;
}

$SIG{ALRM}   = sub { die "timeout" };
$CRLF        = "\015\012";
$LIB_VERSION = '2.0.0';

1;



sub GET
{
    $URL         = shift;
    $RedirOK     = shift;
    $Headers     = undef;
    $Data        = undef;
    $Location    = undef;
    $Code        = undef;
    $Status      = undef;
    $Host        = undef;
    $Port        = undef;
    $URI         = undef;
    $Sock        = undef;
    $Errstr      = undef;
    $TotalBytes  = 0;
    $ReadTime    = 0;
    $ConnectTime = 0;
    $HeaderBytes = 0;
    $BodyBytes   = 0;
    $Throughput  = 0;
    
    

    # Attempt to parse URL into it's pieces
    if( !parseURL() )
    {
        return 0;
    }


    # Attempt to connect to the server
    if( !makeConnection() )
    {
        return 0;
    }


    # Send request to the server
    if( !sendRequest() )
    {
        breakConnection();
        return 0;
    }


    # Read data from server
    if( !readData() )
    {
        breakConnection();
        return 0;
    }


    breakConnection();
    parseHeaders();
    calculateValues();


    $MaxCode = $RedirOK ? 400 : 300;

    # Bad status code
    if( $Code >= $MaxCode )
    {
        $Errstr = $Status;
        return 0;
    }

    return 1;
}



sub GETRedirect
{
    my $startURL = shift;
    $Redirects   = 0;


    if( !GET($startURL, 1) )
    {
        return 0;
    }


    while( defined $Location )
    {
        if( !GET($Location) )
        {
            return 0;
        }

        $Redirects++;

        if( $Redirects > 3 )
        {
            $Errstr = $L_REDIRECTS;
            return 0;
        }
    }

    return 1;
}



sub parseURL
{
    if( $URL =~ m|http://([^:/]+):?(\d+)*(/?.*)|i )
    {
        $Host = $1;
        $Port = $2 ? $2 : 80;
        $URI  = $3 ? $3 : '/';

        return 1;
    }
    else
    {
        $Errstr = $L_INVALID_URL;
        return 0;
    }
}



sub parseHeaders()
{
    $Headers =~ s/\r//g;

    $Code = substr($Headers, 9, 3);

    $Headers =~ m|^HTTP/\d\.\d (.*)$|m;    
    $Status   = $1;

    if( $Headers =~ m|^Location:\s+(.*)$|m )
    {
        chomp($Location = $1);
    }
}



sub sendRequest
{
    my $data = generateGetString();

    eval 
    {
        alarm(10);
        my $result = send($Sock, $data, undef);

        if( !$result )
        {
            $Errstr = "$!";
        }

        alarm(0);
    };


    if( $@ )
    {
        $Errstr = $L_SEND_TIMEOUT;
        return 0;
    }
    elsif( $Errstr )
    {
        return 0;
    }

    return 1;
}



sub readData
{
    eval 
    {
        alarm(30);

        my $line   = undef;
        my $bytes  = undef;
        my $buffer = undef;
        my $start  = now();

        while( $line = <$Sock> )
        {
            $bytes = length($line);
            $HeaderBytes += $bytes;
            $TotalBytes  += $bytes;

            if( $line =~ /^$CRLF*$/ )
            {
                last;
            }

            $Headers .= $line;
        }

        while( $bytes = read($Sock, $buffer, 16384) )
        {
            if( $bytes == undef )
            {
                $Errstr = "$L_READ_ERROR: $!";
                last;
            }

            $TotalBytes += $bytes;
            $BodyBytes  += $bytes;
            $Data .= $buffer;
        }
        my $end = now();


        $ReadTime = $end-$start;
        $ReadTime = 0.25 if( $ReadTime == 0 );

        alarm(0);
    };


    if( $@ )
    {
        if( $@ =~ /timeout/ )
        {
            $Errstr = $L_READ_TIMEOUT;
            return 0;
        }
        else
        {
            $Errstr = "$@";
            return 0;
        }
    }
    elsif( $Errstr )
    {
        return 0;
    }

    return 1;
}



sub makeConnection
{
    socket(SOCK, AF_INET, SOCK_STREAM, getprotobyname('tcp'));
    $Sock = SOCK;

    my $iaddr = inet_aton($Host);

    if( !$iaddr )
    {
        $Errstr = "$L_RESOLVE: $Host";
    }

    my $paddr = sockaddr_in($Port, $iaddr);

    eval
    {
        alarm(20);
        my $start  = now();
        my $result = connect($Sock, $paddr);
        my $end    = now();

        if( !$result )
        {
            $Errstr = "$!";
        }
        else
        {
            $ConnectTime = $end-$start;
            $ConnectTime = 0.25 if( $ConnectTime == 0 )
        }
        alarm(0);
    };

    if( $@ )
    {
        if( $@ =~ /timeout/ )
        {
            $Errstr = $L_CONNECT_TIMEOUT;
            return 0;
        }
        else
        {
            $Errstr = "$@";
            return 0;
        }
    }
    elsif( $Errstr )
    {
        return 0;
    }

    return 1;
}



sub breakConnection
{
    shutdown($Sock, 0);
    close($Sock);
}



sub generateGetString()
{
    my $string  = '';
    my $referer = $URL;

    $referer =~ s|/[^/]+$||i;

    $string = "GET $URI HTTP/1.0$CRLF" .
              "Host: $Host$CRLF" .
              "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.0.0) Gecko/20020530$CRLF" .
              "Referer: $referer$CRLF" .
              "Connection: close$CRLF$CRLF";

    return $string;
}



sub calculateValues()
{
    $Throughput = sprintf("%.1f", ($TotalBytes/1024)/$ReadTime);
    
    if( $BodyBytes >= 1048576 )
    {
        $BodySize = sprintf("%.1f MB", $BodyBytes/1048576);
    }
    elsif( $BodyBytes >= 1024 )
    {
        $BodySize = sprintf("%.1f KB", $BodyBytes/1024);
    }
    else
    {
        $BodySize = "$BodyBytes Bytes";
    }
}



sub now
{
    if( $HIGHRES )
    {
        return Time::HiRes::time();
    }
    else
    {
        return time();
    }
}
#!/usr/bin/perl
##################################
##  HTTP Library v1.0.0         ##
######################################################
##  http.pl - HTTP functions                        ##
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
######################################################

use lib '.';                         ## You may need to change this to the full path to the directory where cgiworks.pm is located
use cgiworks;
use Socket;
use vars qw( $CRLF $Location $Status $SCode $URL $URI $Host $Port );

#####################################################################
##  Removing the link back to CGI Works is a copyright violation.  ##
##  Altering or removing any of the code that is responsible, in   ##
##  any way, for generating that link is strictly forbidden.       ##
##  Anyone violating the above policy will have their license      ##
##  terminated on the spot.  Do not remove that link - ever.       ##
#####################################################################

$SIG{ALRM} = sub { die "timeout" };
$CRLF      = "\015\012"; 

1;


## Get a single page, don't follow redirects
sub GET {
  $URL = shift;

  URLExpand($URL);
  my $sock = Connect( $Host, $Port );
  Send( $sock, GETString($URI, $Host) );
  my $data = Read($sock);
  Disconnect($sock);

  return $data;
}

## Get a single page, follow redirects, only return HTML from final page
sub GETFollow {
  $URL = shift;
  my $data;
  my $count = 0;

  do {
    my $url = $Location ? $Location : $URL;
    $data = GET($url);
    $count++;
  }
  while( $Location && $count < 5 );

  $Location = $URL = $Status = $SCode = $URI = $Host = $Port = undef;

  return $data;
}

## Get a page, follow redirects, and lump all data together
sub GETAllFollow {
  $URL = shift;
  my $data;
  my $count = 0;

  do {
    my $url = $Location ? $Location : $URL;
    $data .= ${ GET($url) };
    $count++;
  }
  while( $Location && $count < 5 );

  $Location = $URL = $Status = $SCode = $URI = $Host = $Port = undef;

  return \$data;
}


## Connect to HTTP server
sub Connect {
  my($host, $port) = @_;

  $Location = undef;

  socket( SOCK, AF_INET, SOCK_STREAM, getprotobyname('tcp') );

  my $iaddr = inet_aton($host) || Error("Could not resolve $host");
  my $paddr = sockaddr_in($port, $iaddr);

  eval {
    alarm(20);
    connect( SOCK, $paddr ) || Error("$!");
    alarm(0);
  };

  Error("Connection To Server Timed Out") if( $@ );

  return \*SOCK;
}


## Disconnect from HTTP server
sub Disconnect {
  my $sock = shift;
  close($sock);
}


## Send data to an open socket
sub Send {
  my($sock, $data) = @_;

  eval {
    alarm(10);
    send( $sock, $data, undef );
    alarm(0);
  };

  Error("Connection To Server Timed Out") if( $@ );
}


## Receive data from an open socket
sub Read {
  my $sock = shift;
  my( $data, $hdone );

  eval {
    alarm(30);

    ## Check the status line for 400+ status codes
    chomp($Status = <$sock>);
    $Status =~ /\s(\d\d\d)\s/;
    $Status = substr($Status, 9);
    $SCode  = $1;

    Error($Status) if( $SCode >= 400 );

    for( <$sock> ) {
      chomp($Location = $1) if( $_ =~ /^Location:\s+(.*)$CRLF/ );
      $data .= $_ if( $hdone );
      $hdone = 1 if( $_ =~ /^$CRLF$/ );
    }
    alarm(0);
  };

  Error("Connection To Server Timed Out") if( $@ );

  return \$data;
}


## Return the headers to send to server for GET request
sub GETString {
  my( $URI, $host ) = @_;

  return "GET $URI HTTP/1.0$CRLF" . "Host: $host$CRLF" . "User-Agent: Mozilla/4.0$CRLF" . "Referer: $URL$CRLF$CRLF";
}

sub URLExpand {
  $URL = shift;

  Error("Invalid or Missing URL") if( $URL !~ /^http:\/\/[\w\d\-\.]+\.[\w\d\-\.]+/ );
  
  $URL =~ /http:\/\/([^\/]+)(\/?.*)/;
  ($Host, $Port) = split(/:/, $1);

  $URI  = $2;
  $URI  = '/' if( !$URI );
  $Port = 80  if( !$Port );
}


sub Error {
  my $msg = shift;

  $TPL{URL}   = $URL;
  $TPL{ERROR} = $msg;
  fparse('_error_http.htmlt');

  exit;
}

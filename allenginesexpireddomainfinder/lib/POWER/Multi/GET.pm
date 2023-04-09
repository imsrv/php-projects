#!/usr/bin/perl -w
# Author: Alex Efros <powerman@consultant.com>
# Desc -- Simultaneous downloading of several URLs from single process, 
#	  without threads usage
# Idea -- Use non-blocking sockets for not waiting for anything (connecting,
#	  reading, etc.). 
#	  Use POWER::Multi::DNS for performing DNS query in background.
#	  Use asynchronous algorithm for processing urls - each url contain
#	  information about it current stage (parsing, dns-querying, connecting,
#	  writing http query, reading reply) and all urls processing in loop,
#	  executing one stage at time for every url.
#
package POWER::Multi::GET;
use Socket;
use Fcntl;
use Errno qw( EINPROGRESS EAGAIN );
use POWER::Multi::DNS qw( get_addr );
use strict;
use vars qw($VERSION $Max_Traffic $Max_URL %Timeout %url %Proxy);

$VERSION	 = "1.91";
$Max_Traffic 	 = 10240;	# maximum of read bytes in second
$Max_URL	 = 10;		# maximum of simultaneous processing url
%Timeout     	 = ( 		# timeout in seconds:
	Resolving	=> 1,	# DNS query in progress
        Connecting 	=> 1,	# connect in progress
        Writing 	=> 1,	# written part of HTTP query
        Reading 	=> 1,	# not ready data to read
        Connect		=> 30,	# how much wait for connect
        Read	 	=> 30,	# how much wait after last successful read
    );
%Proxy   = ();		# HTTP proxy configuration
@Proxy{"Host","Port"} = ($Proxy{active} = defined $ENV{http_proxy}) ?
    ($ENV{http_proxy}=~m!http://([^:]*):(\d+)/!) : ("","");
my $Now	    = time();	# current second
my $Traffic = 0;	# count of downloaded bytes in current second
my @Func    = (\&_parse,\&_connect,\&_connecting,\&_write,\&_read);
my %NextFunc= ();	# hash to easy find next function
@NextFunc{@Func} = @Func[1..$#Func];	
%url	    = ();	# current url

# parse url, normalize url, setup HTTP-query text
sub _parse {
    @url{'_sheme','_user','_pass','_host','_port','_path'} = $url{url} =~ m{ 
       ^(?:([a-zA-Z]+)://)?	# http://
	(?:([^:@/]+)		# user
	(?::([^@/]+))?		# :pass
	@)?			# @
	# host name as defined in RFC 1738
	((?:(?:[a-zA-Z0-9]-*)*[a-zA-Z0-9]\.)*(?:(?:[a-zA-Z0-9]-*)*[a-zA-Z0-9]))
	(?::(\d*))?		# :port
	(/.*)?$ 		# /path
      }x or return("Bad url syntax",0);
    $url{_sheme}   = lc($url{_sheme} || 'http');
    $url{_host}    = lc $url{_host};
    my $port = getservbyname($url{_sheme}, 'tcp');
    $url{_port}  ||= $port || getservbyname('http', 'tcp');
    $url{_path}  ||= '/';
    $url{_url}     = $url{_sheme}."://".$url{_host};
    $url{_url}    .= ":".$url{_port} if $url{_port} != $port;
    $url{_url}    .= $url{_path};
    $url{_msg}     = 
			 "GET ".(($Proxy{active}||$url{proxy})?$url{_url}:$url{_path})." HTTP/1.0"."\r\n".
		     "Host: ".$url{_host}."\r\n".
		     (defined($url{add_to_header})?$url{add_to_header}:"").
		     "\r\n";
}
# get IP, ask for connect
sub _connect {
    return("DNS answer not ready",$Timeout{Resolving},\&_connect) 
	unless defined($url{_iaddr} = get_addr(
	    $url{proxy} || ($Proxy{active} && $Proxy{Host}) || $url{_host} ));
    return("Can't resolve hostname",0) unless $url{_iaddr};
    { local *SOCK; $url{_SOCK} = *SOCK }
    socket($url{_SOCK}, AF_INET, SOCK_STREAM, getprotobyname('tcp')) or
	return("socket: $!",0);
    fcntl($url{_SOCK}, F_SETFL, O_NONBLOCK) or return("fcntl: $!",0);
    connect($url{_SOCK}, sockaddr_in(
	($url{proxy} && ($url{proxy_port}||3128)) ||
	$Proxy{active} && $Proxy{Port} || $url{_port}, $url{_iaddr})) 
    or ($! != EINPROGRESS and return("connect: $!",0));
    $url{_CONNECT_timeout} = $Now + $Timeout{Connect};
}
# wait for connect
sub _connecting {
    return("CONNECT timeout",0) if $Now >= $url{_CONNECT_timeout};
    vec(my $w="",fileno($url{_SOCK}),1)=1;
    return("wait for connect",$Timeout{Connecting},\&_connecting) unless 
	select(undef,$w,undef,0);
    return("connect: $!",0) if $!=ord getsockopt($url{_SOCK},SOL_SOCKET,SO_ERROR);
}
# write HTTP query to socket
sub _write {
    my $n = syswrite($url{_SOCK},$url{_msg});
    return("wait for write",$Timeout{Writing},\&_write) if $! == EAGAIN;
    return("write: $!",0) if $! or not defined $n;
    return("written part of message",$Timeout{Writing},\&_write) if 
        length( $url{_msg}=substr($url{_msg},$n) );
    $url{_READ_timeout} = $Now + $Timeout{Read};
}
# check $Max_Traffic, $Timeout{Read}, read HTTP header and content
sub _read {
    return("traffic limit",1,\&_read) if $Traffic >= $Max_Traffic;
    my $n = sysread($url{_SOCK}, my $buf, $Max_Traffic-$Traffic);
    if ($! == EAGAIN) {
	return("READ timeout",0) if $Now >= $url{_READ_timeout};
	return("data not ready to reading",$Timeout{Reading},\&_read);
    }
    return("read: $!",0) if $! or not defined $n;
    $url{_READ_timeout} = $Now + $Timeout{Read};
    $Traffic += $n;
    $url{_content} .= substr($buf,0,$n);
    # cut HTTP-header when we read it
    $url{_content} =~ s/^(.*?\r?\n)\r?\n/$url{_header}=$1;""/se unless $url{_header};
    return("read in progress",0,\&_read) if $n != 0;
}
# download all urls, check $Max_URL
sub Download (\%;&) {
    my $urls=0;
    foreach ( (grep {   defined $_->{_state}} values %{$_[0]}),
	      (grep {not exists $_->{_state}} values %{$_[0]}) ) {
	last if ++$urls >= $Max_URL;
	local *url = $_;
	$Now = time(), $Traffic = 0 if $Now != time();
	next if defined $url{_timeout} and $url{_timeout} > $Now;
	my ($err,$timeout,$newstate) = &{ $url{_state} ||= $Func[0] };
	@url{'_state','_err','_timeout'} = ! defined $timeout ?
	    ($NextFunc{$url{_state}},"") : ($newstate,$err,$Now+$timeout);
	$url{_ok} = $url{_err} ? "ERR" : "OK" unless defined $url{_state};
    }
    &{$_[1]} if $_[1];			# call user-defined function
    select undef,undef,undef,0.01;	# lower CPU usage
    goto &Download if $urls;
}
1;

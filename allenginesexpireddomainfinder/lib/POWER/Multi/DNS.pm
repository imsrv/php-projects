#!/usr/bin/perl -w
# Author: Alex Efros <powerman@consultant.com>
# Desc -- Simultaneous resolving hostnames in background from single process,
#         without threads usage
# Idea -- Use non-blocking sockets for not waiting for anything (connecting,
#         reading, etc.).
#	  Immediate return from all functions with _current_ query state 
#         (not ready, error, resolved ip) for emulation background querying.
#         Use asynchronous algorithm for processing queryes - cache infromation
#	  about last queries and try to continue fetching DNS reply from 
#         current stage (connecting, sending query, reading answer).
#
package POWER::Multi::DNS;
use Socket;
use Fcntl;
use Errno qw( EINPROGRESS EAGAIN );
use Exporter ();
use strict;
use vars qw(@ISA @EXPORT @EXPORT_OK $VERSION $Max_Cache $Timeout @NS);
@ISA = qw(Exporter);
@EXPORT    = ();
@EXPORT_OK = qw(&get_ip &get_addr &ip2addr &addr2ip &no_cache &reload_NS);

$VERSION	= "1.10";
$Max_Cache	= 50;	# maximum cache entries, also maximum of active queries
$Timeout	= 120;	# timeout seconds per nameserver
@NS 		= ();	# array of nameservers
my  %Cache; 		# cache for dns queries

sub ip2addr { pack("C4", split (/\./, $_[0])) }
sub addr2ip { join(".",  unpack("C4", $_[0])) }
sub no_cache ($) { delete $Cache{$_[0]} if defined $Cache{$_[0]}{addr} }
# return: undef if answer not ready, text IP if ready, "" if error
sub get_ip ($) { 
    my $addr = get_addr($_[0]);
    return( length($addr)==4 ? addr2ip($addr) : $addr ); 
}
# return: undef if answer not ready, 4 byte ADDR if ready, "" if error
sub get_addr ($) {
    if (scalar keys %Cache >= $Max_Cache) {
	# Clean cache and return undef if cache full with active queries
	delete @Cache{grep {defined $Cache{$_}{addr}} keys %Cache};
	return undef if (keys %Cache>=$Max_Cache and not exists $Cache{$_[0]});
    };
    return ip2addr($_[0]) if $_[0]=~/^\d+\.\d+\.\d+\.\d+$/;# no reverse ip
    unless ($Cache{$_[0]}{data}) { # prepare packet data to send
	$Cache{$_[0]}{data} = pack("n C2 n4", 0, 1, 0, 1, 0, 0, 0);
	$Cache{$_[0]}{data}.= pack("C a*",length($_),$_) for split(/\./,$_[0]);
	$Cache{$_[0]}{data}.= pack("C", 0) . pack("n", 1) . pack("n", 1);
	$Cache{$_[0]}{data} = pack("n", length($Cache{$_[0]}{data})).$Cache{$_[0]}{data};
    };
    return(($Cache{$_[0]}{stage}=try_ns($_[0])) ? undef : $Cache{$_[0]}{addr});
}
# process dns query from last step until data not ready
sub try_ns {
    use vars qw(%q);
    local *q = $Cache{$_[0]};
    return undef if ($q{addr} and length($q{addr})==4); # cached answer
    goto $q{stage} if ($q{stage} and $q{timeout}>time()); # check timeout
  NS:
    return $q{addr}="" if @NS < ++$q{ns}; # choose next nameserver if any
    $q{timeout}=time()+$Timeout;
    { local *SOCK; $q{SOCK} = *SOCK }
    socket($q{SOCK}, AF_INET, SOCK_STREAM, getprotobyname('tcp')) or return "NS";
    fcntl($q{SOCK}, F_SETFL, O_NONBLOCK) or return "NS";
    connect($q{SOCK}, sockaddr_in(53, ip2addr($NS[$q{ns}-1]) )) or
        ($! != EINPROGRESS and return "NS");
  CONNECT:
    vec(my $w="",fileno($q{SOCK}),1)=1;
    return "CONNECT" unless select(undef,$w,undef,0);
    return "NS" if $!=ord getsockopt($q{SOCK},SOL_SOCKET,SO_ERROR);
  WRITE:    
    my $n = syswrite($q{SOCK}, $q{data});
    return "WRITE" if $! == EAGAIN;
    return "NS" if $! or $n != length($q{data}); # no partial write
  READLEN:
    $n = sysread($q{SOCK}, my $buf="", 2);
    return "READLEN" if $! == EAGAIN;
    my $len = unpack("n", $buf);
    return "NS" if $! or not $len; # no answer length or error
    $q{answer}="";
  READANS:
    $n = sysread($q{SOCK}, $buf="", $len-length($q{answer}));
    $q{answer} .= substr($buf,0,$n);
    return "READANS" if $! == EAGAIN or (not $! and length($q{answer}) != $len);
    return "NS" if $! or length($q{answer}) != $len; # expected $len bytes or error
    $q{addr} = in_a($q{answer});
    return((! $q{addr} or length($q{addr})!=4) ? "NS" : undef);
}
# return first IN A record (4 bytes string) from packet's ANSWER section
sub in_a {
    my ($packet, $offset) = (shift, 12);
    # unpack HEADER
    my ($ra_rcode, $qdcount, $ancount) = (unpack("n C2 n4", $packet))[2..4];
    return undef if $ra_rcode & 0xf; # check `rcode' about DNS error
    foreach (1 .. $qdcount) { # skip QUESTION sections
	my $len = unpack("\@$offset C", $packet);
	$offset++;
	$offset += $len, redo if $len>0 and $len<0xc0;
	$offset += 1 if $len>=0xc0; # LOST ERROR if bad offset for existing name
	$offset += 2 * 2;
    }
    foreach (1 .. $ancount) { # check ANSWER sections
	my $len = unpack("\@$offset C", $packet);
	$offset++;
	$offset += $len, redo if $len>0 and $len<0xc0;
	$offset += 1 if $len>=0xc0; # LOST ERROR if bad offset for existing name
	my ($type, $class, $ttl, $rdlength) = unpack("\@$offset n2 N n", $packet);
	$offset += 10;
	return substr($packet, $offset, 4) if ($type == 1 and $rdlength >= 4); 
	$offset += $rdlength;
    }
    # skip AUTHORITY and ADDITIONAL sections
    return undef; # No "IN A" records found in "answer" part
}
# load @NS from /etc/resolv.conf
sub reload_NS {
    @NS = map {s/nameserver//;split " ",$_} 
	grep {/^\s*nameserver\s+(\d+\.\d+\.\d+\.\d+\s*)+$/}
	`/bin/cat /etc/resolv.conf`;
    @NS = ("127.0.0.1") unless @NS;
}
reload_NS();

1;

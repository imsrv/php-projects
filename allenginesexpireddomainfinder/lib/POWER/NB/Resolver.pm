#!/usr/bin/perl -w

=head1 NAME

B<POWER::NB::Resolver> - ������������� ��������

=head1 SYNOPSIS

 use POWER::NB::Resolver;

 $Resolver = tie %DNS, 'POWER::NB::Resolver';
 until ( $DNS{www.aaronscgi.com} ) {
 	# do something while dns query executing
 }
 die $DNS{www.aaronscgi.com}{ERR} unless $DNS{www.aaronscgi.com}{IP};
 # Got it!

=head1 DESCRIPTION

��������� ������������� ��������� �������� ����.
��� ������������� ����������� ��������� ������������ � � ���� ���������
�������� �� ������ �������� (��� fork()) � ��� ����� (threads).
��. `perldoc POWER::NB::IO`.

=head1 LIMITATIONS

�� ������ ����������� DNS �������, �.�. ��� ������ POWER::NB::Resolver
������ ���� �������� ��� ������� ���� DNS ������ ������� ����� ���������
����������� ������� (����. BIND ��� DJBDNS/dnscache).

�� �������� ����������.

������ ������ ��� ���� ��������: A � PTR, �� ������ DNS ������� ������������
������ A � PTR ������.

�� ������ "�����" ����� - ������� ����������� ��������� ������� � ����������
�������.

=head1 METHODS

=over 4

=cut

package POWER::NB::Resolver;

use POWER::NB::IO;

use strict;
use vars qw($VERSION);

$VERSION = "1.01";

my %TYPE	= ( A => 1, PTR => 12, );
my %ERR		= (
	TOO_BIG_NAME	=> "DNS name limited to 254 symbols",
	TOO_BIG_SUBNAME	=> "Element of DNS name limited to 63 symbols",
	QUERY_TIMED_OUT	=> "Temporary resolver error",
	NXDOMAIN		=> "Domain not exists",
	NODATA			=> "No data for this type",
	);
my %TIMEOUT	= (
	RESEND			=> 2,	# ������ UDP ������� ��� ���������� ������
	QUERY			=> 20,	# ����� �� ��������� ������ �� QUERY_TIMED_OUT
	);

sub unpack_name {
	my ($packet, $offset) = @_;
	my (@name, $jumpoffset);
	while (my $len = ord(substr($packet, $offset, 1))) {
		if ($len > 63) {
			$jumpoffset ||= $offset+2;
			$offset = ord(substr($packet, $offset+1, 1));
		} else {
			push @name, substr($packet, $offset+1, $len);
			$offset += 1 + $len;
		}
	}
	$_[1] = $jumpoffset || $offset+1;
	return join(".", @name);
}

# ������ ������ �� ����������� DNS ������ � �������� ����� (���� "*", ����
# ��� �� �����).
# ���������� ������ �� ��� � ������� (������� ������), ���� undef ���� �����
# ��� �� �������.
{ my $ID = 0xFFFF;
sub _resolver {
	my ($this, $qname) = @_;
	(my $QNAME = lc($qname)) =~ s/\.*$//;
	$QNAME = join(".", reverse split /\./, $QNAME).".in-addr.arpa" if
		$QNAME =~ /^\d+\.\d+\.\d+\.\d+$/;
	my $QTYPE = $QNAME =~ /\.in-addr\.arpa$/ ? $TYPE{PTR} : $TYPE{A};
	return {ERR=>$ERR{TOO_BIG_NAME}} if length($qname) > 254;
	return {ERR=>$ERR{TOO_BIG_SUBNAME}} if grep {63<length} split /\./, $qname;
	# ������� ����� UDP ������, ���� ��� ��������� ������� $qname
	unless (exists $this->{QUERY}{$qname}) {
		($ID += 1) %= 0xFFFF+1;
		my $NAME   = join("", map {chr(length).$_} split /\./, $QNAME)."\x00";
		my $packet = pack "nnnnnn a* nn", $ID,0x0100,1,0,0,0,$NAME,$QTYPE,1;
		my $SOCK   = POWER::NB::IO::nb_udp($this->{NS}[0], 53) or return {ERR=>"$!"};
		$this->{QUERY}{$qname} = { ID => $ID, packet => $packet, SOCK => $SOCK,
			start => time(), resend	=> time() };
	}
	my $q = $this->{QUERY}{$qname};
	# �������� ������ ���� ����� �� ��������� ������ �������
	if ($q->{start} + $TIMEOUT{QUERY} <= time()) {
		push @{$this->{NS}}, shift @{$this->{NS}};
		delete $this->{QUERY}{$qname};
		return {ERR=>$ERR{QUERY_TIMED_OUT}};
	}
	# ����������� UDP ������ ���� ����
	if ($q->{resend}<=time()) {
		$q->{SOCK}{OUT} = $q->{packet};
		$q->{resend}	= time() + $TIMEOUT{RESEND};
	}
	# ���� ������ ��� �����/������, �� ����������� ������ ������
	unless (POWER::NB::IO::nb_io($q->{SOCK})) {
NS:		push @{$this->{NS}}, shift @{$this->{NS}};
		$q->{SOCK}   = POWER::NB::IO::nb_udp($this->{NS}[0],53) or 
			delete $this->{QUERY}{$qname}, return {ERR=>"$!"};
		$q->{resend} = time();
		return undef;
	}
	# ������� �����, ���� �� �������
	return undef if not length($q->{SOCK}{IN});
	my (%a, $offset, $IP, $NAME);
	@a{"ID","FLAGS","QDCOUNT","ANCOUNT"} = unpack "n B16 n n", $q->{SOCK}{IN};
	@{$a{Flag}}{"QR","Opcode","AA","TC","RD","RA","Z","RCODE"} =
		$a{FLAGS} =~ /^(.)(....)(.)(.)(.)(.)(...)(....)$/;
	goto NS unless $a{Flag}{QR} or $a{Flag}{RD} or $a{Flag}{RA};
	delete $this->{QUERY}{$qname}, return {ERR=>$ERR{NXDOMAIN}} 
		if $a{Flag}{RCODE} eq "0011";
	goto NS if $a{Flag}{RCODE} ne "0000" or $a{QDCOUNT} != 1;
	goto NS if $QNAME ne unpack_name($q->{SOCK}{IN}, $offset=12);
	$offset += 4;
	for (1..$a{ANCOUNT}) {
		unpack_name($q->{SOCK}{IN}, $offset);
		my ($type, $rdlen) = unpack "x$offset n x6 n", $q->{SOCK}{IN};
		$offset += 10;
		$IP = join ".", unpack "x$offset C4", $q->{SOCK}{IN} if $TYPE{A} == $type;
		$NAME = unpack_name($q->{SOCK}{IN}, my $off=$offset) if $TYPE{PTR} == $type;
		$offset += $rdlen;
	}
	# ������� ������ � ������� �����
	delete $this->{QUERY}{$qname};
	($QTYPE == $TYPE{A} ? $IP : $NAME) or return {ERR=>$ERR{NODATA}};
	$qname =~ s/\.in-addr\.arpa$//i and $qname = join ".", reverse split /\./, $qname;
	return $QTYPE==$TYPE{A} ? {IP=>$IP, NAME=>$qname} : {IP=>$qname, NAME=>$NAME};
}}

=item B<init_ns>([@NS])

�������������� ������ DNS �������� ������� ����� ����������� �������.
@NS ��������� ���������� ���� ������. ���� ���� ������ �� �������, ��� ��
�������� ���������� IP ������� � ����������� ��������� ������� A.B.C.D,
�� ��� ����������� ������ DNS ����� ����������� �������� ���������� ���������:
���������� ������ �������� �� /etc/resolv.conf ���� ������������� 127.0.0.1.

=cut

sub init_ns {
	my ($this, @NS) = @_; local *CONF;
	$this->{NS} = [ grep {/^\d+\.\d+\.\d+\.\d+$/} @NS ];
	if (not @{ $this->{NS} } and open CONF, "/etc/resolv.conf") {
		while (<CONF>) {
			next unless my ($ip) = /^\s*nameserver\s+(\d+\.\d+\.\d+\.\d+)\s*$/;
			push @{ $this->{NS} }, $ip;
		}
	}
	$this->{NS} = [ "127.0.0.1" ] unless @{ $this->{NS} };
}

=item B<tie> %DNS, 'POWER::NB::Resolver'[, @NS]

����� �������� ��������� ����� ����� ����������� ������ tie .
��� �������� ����� ������ ����� init_ns(@NS).

������ � �������, ��������� ����, �������������� ����� ������, ������������
tie ��� �������� ���������, ���� ����� ����� tied(%DNS) ��� ��� ������������
���������.

���������� ������ ��������� ����� ����������� ����� %DNS. ��� ��������� �
������-���� ����� � %DNS ����� ���������� �������� undef ���� ����� ��
DNS-������� ��� �� �������, ���� ������ �� ��� � �������. ����� �������
��������� ���� � ������� POWER::NB::Resolver �� ����� ����������� � ����
������ � ���� ������, ���� �� ��� �� ������� ��� �� ��������� ��������
undef. ��� ��������� ��������� � ������ ����� ����� ����� ������� DNS ������.

������������ ��� ����� ��������� ��� �����: {IP}, {NAME}, {ERR}. � {ERR} �����
��������� � ��������� ������ ���� {IP} � {NAME} �������� undef.
��� ����� ������� - � ������: $DNS{"www.altavista.com"}, � �����:
$DNS{"209.73.164.96"} ��� ��������� ������ ����� ��������� ��� �����: � {IP}
� {NAME}. ���� � ����� ��� ������ (��� ��������), �� � ��������������� �����
����� ������ ������.

=cut

sub TIEHASH	 {
	my $this = bless { RESULT => {}, }, shift;
	$this->init_ns(@_);
	return $this;
}
sub FETCH {
	my ($this, $key) = @_;
	$this->{RESULT}{$key} ||= $this->_resolver($key);
}
sub STORE	 { my ($this, $key, $val) = @_; $this->{RESULT}{$key} = $val; }
sub DELETE	 { my ($this, $key) = @_; delete $this->{RESULT}{$key}; }
sub CLEAR	 { shift()->{RESULT} = {}; }
sub EXISTS   { exists shift()->{RESULT}{shift()}	}
sub FIRSTKEY { my ($this) = @_; scalar keys %{ $this->{RESULT} }; $this->NEXTKEY(); }
sub NEXTKEY	 { scalar each %{ shift()->{RESULT} } }

=back

=head1 HISTORY

 1.01       ��� ��� 28 05:12:09 EET 2001
       - ����� �� ������������� � RFC � ������ �������� ���� � ������.
 1.00       ��� ��� 28 02:25:05 EEST 2001
       - ��� ����� ���� � �������� ������ ������� ����������� �� RFC.

=head1 AUTHOR

Alex Efros <powerman@consultant.com>

=cut


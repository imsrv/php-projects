#!/usr/bin/perl -w

=head1 NAME

B<POWER::NB::IO> - ������������ ����/����� ��� ������ � tcp/udp �������

=head1 SYNOPSIS

 use POWER::NB::IO;

 $SOCK = nb_file(\*STDIN, 10240)   or die $!;
 $SOCK = nb_tcp($Host, $Port)	   or die $!;
 $SOCK = nb_udp($Host, $Port, 512) or die $!;
 while (1) {
	nb_io($SOCK) or die $SOCK->{ERR};
 	last if $SOCK->{EOF};
 	do_something($Header) if defined($Header = nb_read($SOCK, 6));
 	do_something($Cmd)    if defined($Cmd    = nb_readline($SOCK));
 	nb_write($SOCK, $data);
	# Do anything you need with $SOCK->{IN} and $SOCK->{OUT}
 }
 undef $SOCK;

=head1 DESCRIPTION

������������� ��������� ��� �������������� ������/������ � ������ ��� �����.
��� ��-������ ���� �������� ��� ��������� �� ������������ �� �����/������,
� ��-������ ���� ����������� �������� � ����������� �������/��������
������������ �� ������ �������� (��� fork) � �� ��������� ����� (threads).

=head1 PROBLEM

��� ������������� ������ � ������ (��������� �����������) ���������������
���� O_NONBLOCK. � ���� ������ � ����������� ��������� ���������� ����������
������ (��/eof/������) ����������� ��� ���� (�������). ��� ��������� �����,
���������� �������� ������� �� "���������", � "�����������" � ����, ������ ���
��� ��� ����� ������� ������. � ��� � ���� ������� ��������� ��������� ������
� ������� ���������� �������� ��������� ������� �������� ��� ����, �����
�������� �� ��������� (��/eof/������). �� ��� � ����������� ������
�������������: ������ ����������� ����� �������� ���������� ������.

=head1 FUNCTIONS

=over 4

=cut

package POWER::NB::IO;

use POWER::NB::Resolver;
use Socket;
use Fcntl qw( F_GETFL F_SETFL  O_NONBLOCK );
use Errno qw( EINPROGRESS EALREADY EAGAIN );
use Symbol;
use strict;
use vars qw($VERSION $Resolver);

$VERSION = "1.02";

sub import {
    no strict;
    *{"${\scalar caller}::$_"} = \&{$_} for qw(nb_file nb_tcp nb_udp nb_io
		nb_read nb_readline nb_write);
}			

my $NEW_SOCK = {
	IN				=> "",		# ����� ������ ������
	OUT				=> "",		# ������� �������� ������
	EOF				=> 0,		# ������ ������ EOF
	_io				=> undef,	# ��� ����� ��� �������� ����������
	ERR_CODE		=> undef,	# ��� ������ (������������� ��� ����)
	ERR				=> undef,	# ����� ������
	ERR_FUNC		=> undef,	# ��������� ����� ��������� ������
	_max_in			=> 10240,	# ������ ������ ������ ������
	_type			=> undef,	# "FILE" ��� "TCP" ��� "UDP"
	_state			=> undef,	# ��� TCP/UDP: "DNS"->"CONNECT"->undef
	_host			=> undef,	# ��� TCP/UDP
	_port			=> undef,	# ��� TCP/UDP
	_iaddr			=> undef,	# ��� TCP/UDP, ���������� ����� DNS �� _host
	};
my %ERR		= (
	"DNS"			=> [   -1, "DNS error" ],
	"SendPartly"	=> [  -10, "Only part of message was sent on UDP socket" ],
	);
my $ReadBlock = 10240;			# �� ������� ���� �� ��� ������ ��� �� 
								# ������������� _max_in
my %DNS;
INIT { $Resolver = tie %DNS, 'POWER::NB::Resolver'; }

# ��������������� �������.
# ���������� ������ ���� �������� ������ ���������.
# ��� ������ ������������� $SOCK->{ERR*} � ���������� undef.
# ���� ��� ������, �� �������� ��� �� ��������� ���������� 0.
sub _err {
	my ($SOCK, $func, $err, $err_text)	= @_;
	return undef if $SOCK->{ERR_CODE};
	$SOCK->{ERR_CODE}	= defined $err ? $ERR{$err}[0] : $!+0;
	$SOCK->{ERR}		= defined $err_text ? $err_text : 
		defined $err ? $ERR{$err}[1] : "$!";
	$SOCK->{ERR_FUNC}	= $func || "(unknown)";
	return undef;
}
sub _fcntl {
	my ($SOCK) = @_;
    my $flags = fcntl($SOCK->{_io}, F_GETFL, 0) or return _err($SOCK, "fcntl");
    fcntl($SOCK->{_io}, F_SETFL, $flags | O_NONBLOCK) or return _err($SOCK, "fcntl");
	return 1;
}
sub _dns {
	my ($SOCK) = @_;
	$DNS{$SOCK->{_host}} = {IP => $SOCK->{_host}} 
		if $SOCK->{_host} =~ /^\d+\.\d+\.\d+\.\d+$/;
	return 0 unless $DNS{$SOCK->{_host}};
	return _err($SOCK, "dns", "DNS", $DNS{$SOCK->{_host}}{ERR}) unless
		$DNS{$SOCK->{_host}}{IP};
	$SOCK->{_iaddr} = pack "C4", split /\./, $DNS{$SOCK->{_host}}{IP};
	$SOCK->{_state} = "CONNECT";
	return 1;
}
sub _connect {
	my ($SOCK) = @_;
	$SOCK->{_state} = undef, return 1
		if connect($SOCK->{_io}, sockaddr_in(@{$SOCK}{"_port","_iaddr"}));
	return $! = 0 if $! == EINPROGRESS or $! == EALREADY;
$DB::single=2;
	return _err($SOCK, "connect");
}
sub _read {
	my ($SOCK) = @_;
	return 1 if $SOCK->{EOF};
	my $len	= length($SOCK->{IN});
	return 0 if defined($SOCK->{_max_in}) and $len >= $SOCK->{_max_in};
	my $size = defined($SOCK->{_max_in}) ? $SOCK->{_max_in}-$len : $ReadBlock;
	my $n = sysread($SOCK->{_io}, $SOCK->{IN}, $size, $len);
	return $! = 0 if not defined $n and $! == EAGAIN;
	return _err($SOCK, "sysread") if not defined $n;
	$SOCK->{EOF} = 1 if $n == 0;
	return 1;
}
sub _read_udp {
	my ($SOCK) = @_;
	return 0 if length($SOCK->{IN});
	my $iaddr = recv($SOCK->{_io}, $SOCK->{IN}, $SOCK->{_max_in}, 0);
	return $! = 0 if not defined $iaddr and $! == EAGAIN;
	return _err($SOCK, "recv") if not defined $iaddr;
	return 1;
}
sub _write {
	my ($SOCK) = @_;
	return 0 unless length($SOCK->{OUT});
	my $n = do { local $SIG{PIPE} = "IGNORE"; syswrite($SOCK->{_io}, $SOCK->{OUT}) };
	return $! = 0 if not defined $n and $! == EAGAIN;
	return _err($SOCK, "syswrite") if not defined $n;
	return 0 if $n == 0;
	$SOCK->{OUT} = substr($SOCK->{OUT}, $n);
	return 1;
}
sub _write_udp {
	my ($SOCK) = @_;
	return 0 unless length($SOCK->{OUT});
	my $n = send($SOCK->{_io}, $SOCK->{OUT}, 0);
	return $! = 0 if not defined $n and $! == EAGAIN;
	return _err($SOCK, "send") if not defined $n;
	return _err($SOCK, "send", "SendPartly") if $n != length($SOCK->{OUT});
	$SOCK->{OUT} = "";
	return 1;
}
1;

=item B<nb_file>($open_file_descriptor[, $input_buf_size])

�������� O_NONBLOCK ��� ����������� ����������� � ���������� $SOCK -
������ �� ��� ������� ����� ��� ���������� �������������� �����/������.
���� �� ������� �������� O_NONBLOCK ���������� undef � �������������
���������� �� ������ � $SOCK->{ERR}, $SOCK->{ERR_CODE}, $SOCK->{ERR_FUNC}.

$input_buf_size - ������������ ������ ������ ��� ������. �� ����� ��� ����, 
����� �� ����������� ��� ������ ��� ������-�� ������ ����� �������� �����.
�� ��������� ����� 10240 ����.

�������� undef ��������� �������� ������ ������ (���� �� ������ ��� �������, 
�� � ����������� ��� ��� ����� ��������).
��� ����������� �������� ������� ������ ������ ����� ������������ �������� �� 
10240 ���� ��� ������ ������ nb_io(), ������� ����� ����������� � ����� ������.

=cut

sub nb_file {
	my $file = shift;
	my $SOCK			= { %{ $NEW_SOCK } };
	$SOCK->{_type}		= "FILE";
	$SOCK->{_max_in}	= shift if @_;
	$SOCK->{_io} 	 	= $file;
	_fcntl($SOCK) or return undef;
	return $SOCK;
}

=item B<nb_tcp>( $Host, $Port[, $input_buf_size])

������� ����� TCP ����� ����������� � $Host:$Port. � ��������� �������� 
���������� nb_file().

=cut

sub nb_tcp {
	my ($Host, $Port) = (shift, shift);
	my $SOCK			= { %{ $NEW_SOCK } };
	$SOCK->{_type}		= "TCP";
	$SOCK->{_state}		= "DNS";
	$SOCK->{_max_in}	= shift if @_;
	$SOCK->{_host}		= $Host;
	$SOCK->{_port}		= $Port;
	 $SOCK->{_io} = gensym;
	socket( $SOCK->{_io}, AF_INET, SOCK_STREAM, getprotobyname('tcp')) or 
		return _err($SOCK, "socket");
	_fcntl($SOCK) or return undef;
	return $SOCK;
}

=item B<nb_udp>( $Host, $Port[, $input_buf_size])

������� ����� UDP ����� ����������� � $Host:$Port � ���������� $SOCK -
������ �� ��� ������� ����� ��� ���������� �������������� �����/������.
���� �� ������� ������� �� ����������� UDP-����� ���������� undef �
������������� ���������� �� ������ � $SOCK->{ERR}, $SOCK->{ERR_CODE},
$SOCK->{ERR_FUNC}.

$input_buf_size - ������������ ����� ������������ UDP-��������� (������).
��������� �������� ������� ����� ��������, ������� ����� ������� (��.
`man 2 recvfrom`). �� ��������� (��� ��� �������� undef) - 10240 ����.

=cut

sub nb_udp {
	my ($Host, $Port) = (shift, shift);
	my $SOCK			= { %{ $NEW_SOCK } };
	$SOCK->{_type}		= "UDP";
	$SOCK->{_state}		= "DNS";
	$SOCK->{_max_in}	= shift if defined($_[0]);
	$SOCK->{_host}		= $Host;
	$SOCK->{_port}		= $Port;
	 $SOCK->{_io} = gensym;
	socket( $SOCK->{_io}, AF_INET, SOCK_DGRAM, getprotobyname('udp')) or 
		return _err($SOCK, "socket");
	_fcntl($SOCK) or return undef;
	return $SOCK;
}

=item B<nb_io>( $SOCK )

����� ����������� ������� ������ ������� ������ � ������ ������ �� �������.
������ ������� �� ���� $SOCK:

FILE,TCP: ������ �������� � ����� ������ $SOCK->{IN} ���� �� �� �����,
������������ ������ �� ������ ������ $SOCK->{OUT}, ���� ��� ����.
���� ��� ������ ����������� ����� ����� ���������� ���� $SOCK->{EOF} .

UDP: ����������� ���� ��������� (�����) � $SOCK->{IN} ���� $SOCK->{IN} ����,
���������� ���� ��������� ������ $SOCK->{OUT}, ���� $SOCK->{OUT} �� ����.
��� ������� ������� ��������� $SOCK->{OUT} ���������.

���������� undef ���� �������� ������. ��� ��������� ������ ������ �����
��������.
��� ������� ����� �������� � ����� ���� ������:

 while (1) {
 	select undef, undef, undef, 0.01;
 	die $SOCK->{ERR} unless nb_io($SOCK);
 }

=cut

sub nb_io {
	my ($SOCK) = @_;
	@{$SOCK}{"ERR_FUNC","ERR_CODE","ERR"} = (undef, undef, undef);
	return defined(_dns($SOCK))		if $SOCK->{_state} eq "DNS";
	return defined(_connect($SOCK))	if $SOCK->{_state} eq "CONNECT";
	return $SOCK->{_type} eq "UDP" ?
		defined(_read_udp($SOCK)) && defined(_write_udp($SOCK)) :
		defined(_read($SOCK)) && defined(_write($SOCK));
}

=item B<nb_read>( $SOCK, $count )

���� � $SOCK->{IN} ���� $count ����, �� ��� ���������� �� ������ $SOCK->{IN}
(�.�. ��, ������� ���� ��������� ������) � ������������ ��� ��������� �������,
����� ������������ undef.
���� $count �������������, �� ������� � ������ ��� ����� $count ��������� ����.

UDP: ���� � $SOCK ��������� ������, ����� ����� �� ����� ������.

=cut

sub nb_read {
	my ($SOCK, $count) = @_;
	return undef if length($SOCK->{IN}) < $count;
	return substr($SOCK->{IN}, 0, $count, "");
}

=item B<nb_readline>( $SOCK )

���� � $SOCK->{IN} ���� ������� ������, �� ������� � ������ ��� �� �������
�������� ������ (������� ���� ������� ������), ����� ������ undef.
���� ���������� ���� $SOCK->{EOF} � � $SOCK->{IN} ���� ������, �� ��� ��������
������, ������ ���� $SOCK->{IN}.

UDP: ���� � $SOCK ��������� ������, ����� ����� �� ����� ������.

=cut

sub nb_readline {
	my ($SOCK) = @_;
	return $1 if $SOCK->{IN} =~ s/^(.*\n)//;
	return substr($SOCK->{IN}, 0, length($SOCK->{IN}), "") if $SOCK->{EOF};
	return undef;
}

=item B<nb_write>( $SOCK, $data )

������ $data � ������� �� ������ � $SOCK. ��������� $SOCK->{OUT} .= $data;

UDP: ���� � $SOCK ���-�� ���� �� ������ ���������� nb_write(), �� $data
����� ������� �� ��������� ����������, � ����� ��������� � ����� ����
���������, ������� ��������� � $SOCK.

=cut

sub nb_write {
	my ($SOCK, $data) = @_;
	$SOCK->{OUT} .= $data;
}

=back

=head1 $SOCK FIELDS

$SOCK ��� ������ �� ���. ����� "������ � $SOCK" ��� "������ �� $SOCK" �� �����
���� ������������� ������/������ � ����� (��� �������� ����������), �������
�������� � ����� �� ����� ����� ����. ���� ��� �������� ��������� �����, �
�������� ����� �������� ��������:

=over 4

=item B<$SOCK-E<gt>{IN}>

����� ��� ������ ������ (������). ���� � ��� �������� ����� $input_buf_size 
���� ������ ������������� ( ��. nb_file() ).

FILE/TCP: ��� ������ nb_io() � ����� $SOCK->{IN} ����� ���� ��������
���������� ������.

UDP: ��� ������ nb_io() ��������� ����� ������� � $SOCK->{IN} ������ ����
$SOCK->{IN} ����.

�� ������ �������� � $SOCK->{IN} ��� � ����� �������, ������� nb_read() �
nb_readline() ������������� ������������ ��� ��������.

=item B<$SOCK-E<gt>{OUT}>

������� ��� �������� ������ (������).

FILE/TCP: ��� ������ nb_io() ��������� ������ ���� ���� ������ (��� ��� ������)
����� ���� ������� (��� ������� ������ � $SOCK).

UDP: ��� ������ nb_io() ���������� $SOCK->{OUT} ����� �������� ��� ����
���������.

�� ������ �������� � $SOCK->{OUT} ��� � ����� �������, ������� nb_write()
������������� ������������� ��� ��������.

=item B<$SOCK-E<gt>{EOF}>

����, ������������ ��� ������ �� $SOCK ��� ���������� ����� �����.
��� ����������� $SOCK->{EOF} ������� ������ �� $SOCK �� ������������
(�� ������ � $SOCK ����� ������������).

=item B<$SOCK-E<gt>{ERR_CODE}>

��� ������. ��� ������ POWER::NB::IO ������������ ������������� ��������,
������������� �������� ��� ����������� ��� ������ �� $! . ���� ������ ���,
�������� �� ���������� (undef).

������ ����� ���������� ������ ��� ������ nb_io() . ��������� ����� nb_io()
���������� �� ������ �������.

=item B<$SOCK-E<gt>{ERR}>

���� ��������� �� ������ ("$!" ��� ��������� ������). 
��. $SOCK->{ERR_CODE} .

=item B<$SOCK-E<gt>{ERR_FUNC}>

��� ������� (���������� ������) � ������� ��������� ������. 
��. $SOCK->{ERR_CODE} .

=back

=head1 VARIABLES

=over 4

=item B<$POWER::NB::IO::Resolver>

��� ������ ���� POWER::NB::Resolver. ����� ���� �� ������ ��������� ���, ���
POWER::NB::IO ����������� $Host ��� ������ nb_tcp() � nb_udp() � IP-�����
(����. ����� DNS-������� ����� �������������� ��� ���������� DNS ��������).
��. `perldoc POWER::NB::Resolver`.

=back

=head1 HISTORY

 1.02	
      - ported to Perl 5.00503

 1.00		��� ��� 24 16:14:04 EEST 2001
      - ����������� �� �������������� ���

=head1 BUGS

UDP-���� recv ��������� �� ��������� �� ����� $input_buf_size ����. 
������� ��������� ��������. � �������� �������� ������ ��� ��� ���������: 
��. MSG_TRUNC � `man 2 recvfrom`. �� ��� �� ���� ��������? ��� ���� ������, 
��� ���?

������ ����� ��� "������ �� ���� ��� ��� ���������� �������� ������� ������"
���������� ��� ���� $SOCK � ��� ������ �������������. � ��� ����?

=head1 AUTHOR

Alex Efros <powerman@consultant.com>

=cut


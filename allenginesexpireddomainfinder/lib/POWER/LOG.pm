#!/usr/bin/perl -w
###############################################################################
# POWER::SQL - Perl library which simplify usage of SQL database.
# (c) asdfGroup.com Inc., 2002. All rights reserved.
###############################################################################
# This library is a commercial product and it is subject to the license
# agreement that can be found at the following URL:
#   http://www.asdfGroup.com/license.html
# Please contact our staff if you will have any questions:
#   mailto:staff@asdfGroup.com
###############################################################################


=head1 NAME

B<POWER::LOG> - ������� ����

=head1 SYNOPSIS

 use POWER::LOG;

 $LOG = POWER::LOG->new();
 $LOG->config({
    OUTPUT  => \*STDERR,
    PREFIX  => "%D %T %P::%F() : ",
    LEVEL   => "WARN",
    });
 $LOG->ERR($message);
 $LOG->WARN($message);
 $LOG->INFO($message);
 $LOG->DEBUG($message);
 $LOG->DUMP($message);

=head1 DESCRIPTION

������� ���������� ��������� � �������� �������� ����������.
������ ������ ��������� ���������� ��������� � �������� �������.
����� ������ �������������� ������ ��� {LEVEL} ������ ��� ������
���������.

=head1 METHODS

=over 4

=cut

package POWER::LOG;

use POWER::lib;

use strict;
use vars qw($VERSION);

$VERSION = "2.00";

=item B<new>( [\%config] )

���������� ����� ������ ����� ������� ����� �������� ��������� � ���.
�������� $config, ���� �� ����, ���������� ������ config().

���� new() ���������� �� ������� ������� POWER::LOG, �� ��� ���������
�����������.

=cut

sub new {
    my $this  = shift;
    my $class = ref($this) || $this ;
    my $self  = { CONFIG => {}, };
    bless $self, $class ;
    $self->config($this->config()) if ref($this);
    $self->config(@_);
    return $self;
}

=item B<config>( [\%config] )

����������� ��������� �������.
$config - ������ �� ��� � ���������������� �����������.
������ ������������� ���������� �������� ����, � ������� B<CONFIG>.

���������� ������ �� ��� �� ����� �������� ���������� �������.

=cut

sub config {
    my ($self, $config) = (shift, @_);
    $config = {} if ref($config) ne "HASH";
    UpdateHash($self->{CONFIG}, $config);
    return {%{$self->{CONFIG}}};
}

=item B<ERR>( $message )

������� � ��� ��������� �� ������. [��������� ������]

=item B<WARN>( $message )

������� � ��� ��������� � ��������������. [�� ��������� ������]

=item B<INFO>( $message )

������� � ��� ���������. [�������� ����������� ����� / ��������� �������]

=item B<DEBUG>( $message )

������� � ��� ���������� ���������. [����� ����� ������ ���������]

=item B<DUMP>( $message )

������� � ��� ���������� ��������� ���������� ���������� ������.

=cut

sub ERR {
    my $self = shift;
    $self->_log(@_) if $self->{CONFIG}{LEVEL} =~ /^ERR|WARN|INFO|DEBUG|DUMP$/i;
}
sub WARN {
    my $self = shift;
    $self->_log(@_) if $self->{CONFIG}{LEVEL} =~ /^WARN|INFO|DEBUG|DUMP$/i;
}
sub INFO {
    my $self = shift;
    $self->_log(@_) if $self->{CONFIG}{LEVEL} =~ /^INFO|DEBUG|DUMP$/i;
}
sub DEBUG {
    my $self = shift;
    $self->_log(@_) if $self->{CONFIG}{LEVEL} =~ /^DEBUG|DUMP$/i;
}
sub DUMP {
    my $self = shift;
    $self->_log(@_) if $self->{CONFIG}{LEVEL} =~ /^DUMP$/i;
}
sub _log {
    my ($self, $msg) = (shift, @_);
    my $date = sub {sprintf "%02d/%02d/%04d", $_[3], $_[4]+1, $_[5]+1900}->(localtime);
    my $time = sub {sprintf "%02d:%02d:%02d", $_[2], $_[1], $_[0]}->(localtime);
    my ($pkg, $func) = (caller(2))[3] =~ /^(.*)::(.*)$/;
    my %data = ("%"=>"%", "D"=>$date, "T"=>$time, "P"=>$pkg, "F"=>$func);
    (my $prefix = $self->{CONFIG}{PREFIX}) =~ s/%(.)/$data{$1}/g;
    $msg =~ s/^/$prefix/mg;
    $msg =~ s/\n?$/\n/;
    my $FILE = $self->{CONFIG}{OUTPUT};
    print $FILE $msg if ref($FILE) eq "GLOB";
}

=back

=head1 CONFIG

=over 4

=item B<{OUTPUT}>

�������� ����������, � ������� ����� ��������� ������. ���� �� ���������,
�� ������ ��������� �� �����.

=item B<{PREFIX}>

�������, ������� ����� ��������� ����� ������ ������� ���������� ���������.
���� {PREFIX} �� ��������� ��� ������ ������, �� ��������� ���������
����� ��������� ��� ��������. ������ �������� ������� ������� printf(), �� ���
�����������, ��� ������������ ������ ����� ������������:

 %D - ������� ���� � �������:  "��/��/����"
 %T - ������� ����� � �������: "��:��:��"
 %P - ����� ��������� �������: "main" ��� "POWER::NB::IO"
 %F - ��� ��������� �������:   "my_func_name"
 %% - ������ "%"

������ ��������: "%D %T %P::%F() "

=item B<{LEVEL}>

���� {LEVEL} �� ��������� ��� �� ����� ����� �� �����: "ERR","WARN","INFO",
"DEBUG","DUMP" �� ��������� ��������� �� �����. ����� ����� ���������
���������, � ������� ��������� ���� ��� ����� {LEVEL}. ��������, ���
{LEVEL} ������ "INFO" ����� ��������� ��������� ������� "ERR", "WARN" � "INFO".

=back

=head1 HISTORY

 2.00       ��� ��� 10 05:42:11 EET 2002
      - ��������� ������� ��������� ������
 1.01       ��� ��� 28 21:28:52 EET 2001
      - ��������� ������ ����/�������
 1.00       ��� ��� 28 16:48:16 EET 2001
      - �������� �� ����������� ������ (����� print)

=head1 AUTHOR

Alex Efros <powerman@asdfGroup.com>

=cut


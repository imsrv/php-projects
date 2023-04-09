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

B<POWER::LOG> - Ведение лога

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

Выводит полученные сообщения в заданный файловый дескриптор.
Каждую строку сообщения предваряет префиксом в заданном формате.
Вывод строки осуществляется только при {LEVEL} меньше или равном
заданному.

=head1 METHODS

=over 4

=cut

package POWER::LOG;

use POWER::lib;

use strict;
use vars qw($VERSION);

$VERSION = "2.00";

=item B<new>( [\%config] )

Возвращает новый объект через который можно выводить сообщения в лог.
Параметр $config, если он есть, передается методу config().

Если new() вызывается от другого объекта POWER::LOG, то все настройки
наследуются.

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

Настраивает параметры объекта.
$config - ссылка на хеш с устанавливаемыми параметрами.
Список настраиваемых параметров смотрите ниже, в разделе B<CONFIG>.

Возвращает ссылку на хеш со всеми текущими настроками объекта.

=cut

sub config {
    my ($self, $config) = (shift, @_);
    $config = {} if ref($config) ne "HASH";
    UpdateHash($self->{CONFIG}, $config);
    return {%{$self->{CONFIG}}};
}

=item B<ERR>( $message )

Выводит в лог сообщение об ошибке. [фатальная ошибка]

=item B<WARN>( $message )

Выводит в лог сообщение о предупреждении. [не фатальная ошибка]

=item B<INFO>( $message )

Выводит в лог сообщение. [пройдена контрольная точка / произошло событие]

=item B<DEBUG>( $message )

Выводит в лог отладочное сообщение. [какая часть логики сработала]

=item B<DUMP>( $message )

Выводит в лог отладочное сообщение включающее распечатку данных.

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

Файловый дескриптор, в который будут выводится данные. Если не определен,
то данные выводится не будут.

=item B<{PREFIX}>

Префикс, который будет выводится перед каждой строкой выводимого сообщения.
Если {PREFIX} не определен или пустая строка, то выводимые сообщения
будут выводится без префикса. Формат префикса подобен формату printf(), за тем
исключением, что используется другой набор спецсимволов:

 %D - Текущая дата в формате:  "ДД/ММ/ГГГГ"
 %T - Текущее время в формате: "ЧЧ:ММ:СС"
 %P - Пакет вызвавшей функции: "main" или "POWER::NB::IO"
 %F - Имя вызвавшей функции:   "my_func_name"
 %% - Символ "%"

Пример префикса: "%D %T %P::%F() "

=item B<{LEVEL}>

Если {LEVEL} не определен или не равен одной из строк: "ERR","WARN","INFO",
"DEBUG","DUMP" то сообщения выводится не будут. Иначе будут выводится
сообщения, у которых приоритет ниже или равен {LEVEL}. Например, при
{LEVEL} равном "INFO" будут выводится сообщения уровней "ERR", "WARN" и "INFO".

=back

=head1 HISTORY

 2.00       Чтв Янв 10 05:42:11 EET 2002
      - Полностью изменен интерфейс модуля
 1.01       Вск Окт 28 21:28:52 EET 2001
      - Исправлен формат даты/времени
 1.00       Вск Окт 28 16:48:16 EET 2001
      - Работает на блокирующем выводе (через print)

=head1 AUTHOR

Alex Efros <powerman@asdfGroup.com>

=cut


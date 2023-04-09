#!/usr/bin/perl -w

=head1 NAME

B<POWER::NB::IO> - неблокирущий ввод/вывод для файлов и tcp/udp сокетов

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

Предоставляет интерфейс для неблокирующего чтения/записи в сокеты или файлы.
Это во-первых дает гарантию что программа не затормозится на вводе/выводе,
а во-вторых дает возможность работать с несколькими файлами/сокетами
одновременно из одного процесса (без fork) и не используя нитей (threads).

=head1 PROBLEM

Для неблокирующей работы у сокета (файлового дескриптора) устанавливается
флаг O_NONBLOCK. В этом случае к стандартным вариантам завершения системного
вызова (ок/eof/ошибка) добавляется еще один (повтори). Как следствие этого,
появляются операции которые не "выполнены", а "выполняются" в фоне, причем они
все еще могут вернуть ошибку. А это в свою очередь усложняет обработку ошибок
и требует регулярной проверки состояния фоновых операций для того, чтобы
получить их результат (ок/eof/ошибка). Да еще и добавляется эффект
асинхронности: нельзя предсказать какая операция завершится раньше.

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
	IN				=> "",		# Буфер приема данных
	OUT				=> "",		# Очередь передачи данных
	EOF				=> 0,		# Принят сигнал EOF
	_io				=> undef,	# Сам сокет или файловый дескриптор
	ERR_CODE		=> undef,	# Код ошибки (отрицательный для моих)
	ERR				=> undef,	# Текст ошибки
	ERR_FUNC		=> undef,	# Системный вызов вернувший ошибку
	_max_in			=> 10240,	# Размер буфера приема данных
	_type			=> undef,	# "FILE" или "TCP" или "UDP"
	_state			=> undef,	# для TCP/UDP: "DNS"->"CONNECT"->undef
	_host			=> undef,	# для TCP/UDP
	_port			=> undef,	# для TCP/UDP
	_iaddr			=> undef,	# для TCP/UDP, полученный через DNS из _host
	};
my %ERR		= (
	"DNS"			=> [   -1, "DNS error" ],
	"SendPartly"	=> [  -10, "Only part of message was sent on UDP socket" ],
	);
my $ReadBlock = 10240;			# по сколько байт за раз читать при не 
								# установленном _max_in
my %DNS;
INIT { $Resolver = tie %DNS, 'POWER::NB::Resolver'; }

# Вспомогательные функции.
# Возвращают истину если операция удачно выполнена.
# При ошибке устанавливают $SOCK->{ERR*} и возвращают undef.
# Если нет ошибки, но операция еще не закончена возвращают 0.
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

Включает O_NONBLOCK для переданного дескриптора и возвращает $SOCK -
ссылку на хеш которая нужна для выполнения неблокирующего ввода/вывода.
Если не удалось включить O_NONBLOCK возвращает undef и устанавливает
информацию об ошибке в $SOCK->{ERR}, $SOCK->{ERR_CODE}, $SOCK->{ERR_FUNC}.

$input_buf_size - максимальный размер буфера для чтения. Он нужен для того, 
чтобы не переполнить всю память при первом-же чтении очень большого файла.
По умолчанию равен 10240 байт.

Передача undef отключает контроль рамера буфера (типа вы знаете что делаете, 
но я предупредил чем это может кончится).
При отключенном контроле размера буфера чтение будет производится максимум по 
10240 байт при каждом вызове nb_io(), которые будут дописыватся в конец буфера.

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

Создает новый TCP сокет соединенный с $Host:$Port. В остальном работает 
аналогично nb_file().

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

Создает новый UDP сокет соединенный с $Host:$Port и возвращает $SOCK -
ссылку на хеш которая нужна для выполнения неблокирующего ввода/вывода.
Если не удалось создать не блокирующий UDP-сокет возвращает undef и
устанавливает информацию об ошибке в $SOCK->{ERR}, $SOCK->{ERR_CODE},
$SOCK->{ERR_FUNC}.

$input_buf_size - максимальный рамер принимаемого UDP-сообщения (пакета).
Сообщение большего размера будет обрезано, остаток будет потерян (см.
`man 2 recvfrom`). По умолчанию (или при передаче undef) - 10240 байт.

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

Здесь выполняется попытка чтения готовых данных и записи данных из очереди.
Детали зависят от типа $SOCK:

FILE,TCP: данные читаются в конец буфера $SOCK->{IN} если он не полон,
записываются данные из начала буфера $SOCK->{OUT}, если они есть.
Если при чтении достигается конец файла выставляет флаг $SOCK->{EOF} .

UDP: принимается одно сообщение (пакет) в $SOCK->{IN} если $SOCK->{IN} пуст,
посылается одно сообщение равное $SOCK->{OUT}, если $SOCK->{OUT} не пуст.
При удачной посылке сообщения $SOCK->{OUT} очищается.

Возвращает undef если получена ошибка. При следующем вызове ошибка будет
сброшена.
Эту функцию нужно вызывать в цикле типа такого:

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

Если в $SOCK->{IN} есть $count байт, то они вырезаются из начала $SOCK->{IN}
(т.е. те, которые были прочитаны раньше) и возвращаются как результат функции,
иначе возвращается undef.
Если $count отрицательный, то вырежет и вернет все кроме $count последних байт.

UDP: если в $SOCK останутся данные, новый пакет не будет принят.

=cut

sub nb_read {
	my ($SOCK, $count) = @_;
	return undef if length($SOCK->{IN}) < $count;
	return substr($SOCK->{IN}, 0, $count, "");
}

=item B<nb_readline>( $SOCK )

Если в $SOCK->{IN} есть перевод строки, то вырежет и вернет все до первого
перевода строки (включая этот перевод строки), иначе вернет undef.
Если установлен флаг $SOCK->{EOF} и в $SOCK->{IN} есть данные, но нет перевода
строки, вернет весь $SOCK->{IN}.

UDP: если в $SOCK останутся данные, новый пакет не будет принят.

=cut

sub nb_readline {
	my ($SOCK) = @_;
	return $1 if $SOCK->{IN} =~ s/^(.*\n)//;
	return substr($SOCK->{IN}, 0, length($SOCK->{IN}), "") if $SOCK->{EOF};
	return undef;
}

=item B<nb_write>( $SOCK, $data )

Ставит $data в очередь на запись в $SOCK. Идентично $SOCK->{OUT} .= $data;

UDP: если в $SOCK что-то было на момент выполнения nb_write(), то $data
будет послано не отдельным сообщением, а будет добавлено в конец того
сообщение, которое находится в $SOCK.

=cut

sub nb_write {
	my ($SOCK, $data) = @_;
	$SOCK->{OUT} .= $data;
}

=back

=head1 $SOCK FIELDS

$SOCK это ссылка на хеш. Фраза "запись в $SOCK" или "чтение из $SOCK" на самом
деле подразумевает чтение/запись в сокет (или файловый дескриптор), который
хранится в одном из полей этого хеша. Этот хеш содержит несколько полей, с
которыми можно работать напрямую:

=over 4

=item B<$SOCK-E<gt>{IN}>

Буфер для приема данных (строка). Если в нем хранится более $input_buf_size 
байт чтение откладывается ( см. nb_file() ).

FILE/TCP: при вызове nb_io() в конец $SOCK->{IN} могут быть дописаны
полученные данные.

UDP: при вызове nb_io() сообщение будет считано в $SOCK->{IN} только если
$SOCK->{IN} пуст.

Вы можете работать с $SOCK->{IN} как с любой строкой, функции nb_read() и
nb_readline() предоставлены ислючительно для удобства.

=item B<$SOCK-E<gt>{OUT}>

Очередь для отправки данных (строка).

FILE/TCP: при вызове nb_io() несколько первых байт этой строки (или вся строка)
может быть удалена (при удачной записи в $SOCK).

UDP: при вызове nb_io() содержимое $SOCK->{OUT} будет передано как одно
сообщение.

Вы можете работать с $SOCK->{OUT} как с любой строкой, функция nb_write()
предоставлена исключительно для удобства.

=item B<$SOCK-E<gt>{EOF}>

Флаг, выставляется при чтении из $SOCK при достижении конца файла.
При выставленом $SOCK->{EOF} попытки чтения из $SOCK не производятся
(но запись в $SOCK может продолжаться).

=item B<$SOCK-E<gt>{ERR_CODE}>

Код ошибки. Для ошибок POWER::NB::IO используются отрицательные значения,
положительное значение это стандартный код ошибки из $! . Если ошибки нет,
значение не определено (undef).

Ошибка может возникнуть только при вызове nb_io() . Следующий вызов nb_io()
информацию об ошибке сбросит.

=item B<$SOCK-E<gt>{ERR}>

Тест сообщения об ошибке ("$!" для системных ошибок). 
См. $SOCK->{ERR_CODE} .

=item B<$SOCK-E<gt>{ERR_FUNC}>

Имя функции (системного вызова) к котором произошла ошибка. 
См. $SOCK->{ERR_CODE} .

=back

=head1 VARIABLES

=over 4

=item B<$POWER::NB::IO::Resolver>

Это объект типа POWER::NB::Resolver. Через него вы можете управлять тем, как
POWER::NB::IO преобразует $Host при вызове nb_tcp() и nb_udp() в IP-адрес
(напр. какие DNS-сервера будут использоваться для выполнения DNS запросов).
См. `perldoc POWER::NB::Resolver`.

=back

=head1 HISTORY

 1.02	
      - ported to Perl 5.00503

 1.00		Срд Окт 24 16:14:04 EEST 2001
      - практически не оттестированый код

=head1 BUGS

UDP-шный recv считывает из сообщения не более $input_buf_size байт. 
Остаток сообщения теряется. В принципе возможно узнать что это произошло: 
см. MSG_TRUNC в `man 2 recvfrom`. Но как об этом сообщить? Это таки ошибка, 
или нет?

Размер блока для "чтения за один раз при отсутствии контроля размера буфера"
одинаковый для всех $SOCK и его нельзя устанавливать. А это надо?

=head1 AUTHOR

Alex Efros <powerman@consultant.com>

=cut


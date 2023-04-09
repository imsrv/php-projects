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

B<POWER::lib> - Bundle of useful procedures.

=head1 SYNOPSIS

 use POWER::lib qw(time sleep);

 $passwd_list = Cat("/etc/passwd");
 @passwd_list = Chomp(Cat("/etc/passwd"));

 Echo(">>$0.log", "Debug:", "message...") or die $!;

 (MEM_used() < 50000) or die "Out of memory";

 (FD_used() < 100) and open(F, "filename") or die "Out of files"; 

 $t0 = time();
 1 while time()-$t0 < 10;
 CPU_start();
 1, CPU_max(30) while time()-$t0 < 30;

 $min = Min(1, -1.5, 5, 2);
 $max = Max(1, -1.5, 5, 2);

 $nav = CalcNavigation({From=>11,Count=>10,Records=>18});
 
 UpdateHash( $main, $update );

 $base64 = EncBase64( $data );

 $md5 = MD5( $message );
 $md5hex = MD5hex( $message );
 $md5base64 = MD5base64( $message );

 $sec_with_microsec = time();
 sleep(0.25);

 $unsafe = "Programming Perl";
 $safe = EncUri($unsafe); 
 # $safe eq "Programming%20Perl"
 $safe = EncUri($unsafe, qr/[a-zA-Z]/);
 $decoded = UnEncUri($safe);

 $html_unsafe = "test < & >";
 $html = Enc($html_unsafe); 
 # $html eq "test &lt; &amp; &gt;"
 $text = UnEnc($html);

 $passwd = RandCh(8);

 $abs_url = abs_url("qwe.html", "http://host.com/dir1/a.html");
 # $abs_url eq "http://host.com/dir1/qwe.html"
 $abs_url = abs_url("/qwe.html", "http://host.com/dir1/a.html");
 # $abs_url eq "http://host.com/qwe.html"
 $abs_url = abs_url("http://host2.com/qwe.html",
    "http://host.com/dir1/a.html");
 # $abs_url eq "http://host2.com/qwe.html"

 print "$email looks good\n" if Check_Email($email);

 Email($template, \%fields);

=head1 DESCRIPTION

This a bundle of useful procedures. 
Procedures imported by default: EncUri(), UnEncUri(), Enc(), UnEnc(),
RandCh(), abs_url(), Check_Email(), Email(), MD5(), MD5hex(), MD5base64(),
EncBase64(), UpdateHash(), Min(), Max(), CalcNavigation(), CPU_start(),
CPU_max(), CPU_used(), Cat(), Echo(), MEM_used(), FD_used(), Chomp().
Procedures imported by request: time(), sleep().

=head1 FUNCTIONS

=over 4

=cut

package POWER::lib;
use strict;
use vars qw($VERSION);
$VERSION = "1.92";

sub import {
    no strict;
    *{"${\scalar caller}::$_"} = \&{$_} for qw(EncUri UnEncUri Enc UnEnc 
        RandCh abs_url Check_Email Email MD5 MD5hex MD5base64 EncBase64
        UpdateHash Min Max CalcNavigation CPU_start CPU_max CPU_used
        Cat Echo MEM_used FD_used Chomp), @_; 
}

=item B<Chomp>( @lines )

Вызывает chomp(@lines) плюс убирает в конце строк "\r" и возвращает измененный
@lines.

=cut

sub Chomp { chomp(my @l=@_); s/\r$// for @l; return @l }

=item B<Cat>( $filename )

В скалярном контексте возвращает содержимое всего файла $filename,
в списковом контексте возвращает список из всех строк файла (используется
стандартный разделитель строк в B<$/>).

При ошибке возвращает undef или (), в B<$!> возвращает ошибку.

ВНИМАНИЕ! $filename передается в open() без изменений!

=cut

sub Cat { local *F; open F, $_[0]; local $/ unless wantarray; return <F> }

=item B<Echo>( $filename, @lines )

Выводит @lines в $filename. Если в @lines вcтречается "\n", то строки
выводятся as is, иначе в конец каждого элемента @lines добавляется "\n".

При ошибке возвращает undef, в B<$!> возвращает ошибку.

ВНИМАНИЕ! $filename передается в open() без изменений!

=cut

sub Echo {
    local *F;
    open F, shift or return;
    @_ = map {"$_\n"} @_ if "@_" !~ /\n/;
    print F join("",@_);
    return 1;
}

=item B<MEM_used>()

Возвращает использованный этим процессом объем памяти к килобайтах (как его 
показывает top).

=cut

sub MEM_used{ ((Cat("/proc/self/status") or die $!) =~ /VmRSS:\s*(\d*)/)[0] };

=item B<FD_used>()

Возвращает количество использованных процессом файловых дескрипторов.

=cut

sub FD_used {
    local *FD; opendir FD, "/proc/self/fd";
    return @{[readdir FD]} - 2;
};

=item B<CPU_start>()

=item B<CPU_max>( $max_usage )

CPU_max() проверяет использованное процессорное время после последнего вызова
CPU_start(), и если оно превышает $max_usage процентов реально прошедшего
времени, то делает sleep() на столько времени, чтобы выровнять соотношение
реального и процессорного времени на $max_usage процентов.

CPU_start() вызывается автоматически один раз при запуске программы.

=item B<CPU_used>()

Возвращает использованное этим процессом процессорное время в секундах
умноженных на 100.

=cut

{ my (%start); CPU_start();
sub CPU_start { @start{"tm","cpu"} = (time(),CPU_used()) }
sub CPU_max {
    my ($max, $real, $cpu) = ($_[0], time()-$start{tm}, CPU_used()-$start{cpu});
    sleep( $cpu/$max-$real );
}}
sub CPU_used { (map {$_->[13]+$_->[14]} [split " ", Cat "/proc/self/stat"])[0] }

=item B<Min>( @values )

=item B<Max>( @values )

Return minimum (maximum) of these values.

=cut

sub Min { my $min=shift; $_<$min and $min=$_ for @_; $min }
sub Max { my $max=shift; $_>$max and $max=$_ for @_; $max }

=item B<CalcNavigation>( \%nav )

Принимает следующие ключи в %nav:

=over 4

=item B<From>

Номер записи которая должна попасть на текущую страницу.
Считается от 1.

=item B<Count>

Количество записей на одну страницу.

=item B<Records>

Количество записей в выводимой таблице. 0 - нет записей.

=item B<DefaultCount>

Значение по умолчанию для Count если Count не является положительным целым.
Если не задан - по умолчанию равен 20. Если и Count, и DefaultCount заданы
не положительными целыми, то Count устанавливается в 1.

=item B<PrevPages>

=item B<NextPages>

Cтраницы рассчитывать начиная с номера текущей минус PrevPages по номер
текущей плюс NextPages. PrevPages и NextPages по умолчинию равны 10.

=back

Records округляется до ближайнего не отрицательного целого.

Поле From корректируется по следующим правилам:
если From < 0 то From установить в 1;
если From > Records, то From установить в Records;
если From указывает не на первую запись страницы то установить From на
первую запись этой страницы.

Count округляется до ближайшего положительного целого.

Возвращает ссылку на %nav дополненный следующими ключами:

=over 4

=item B<To>

Номер последней записи на текущей странице.
Если Records = 0, то To тоже = 0.

=item B<Prev>

Номер первой записи на предыдущей странице.
Если текущая страница - первая, то Prev равен undef.

=item B<Next>

Номер первой записи на следующей странице.
Если текущая страница - последняя, то Next равен undef.

=item B<Page>

Номер текущей страницы.

=item B<Pages>

Ссылка на массив отобранных с помошью PrevPages и NextPages страниц.
Каждая страница представлена хешем со следующими полями:

=over 4

=item B<Page>

Номер этой страницы.

=item B<From>

Номер первой записи на этой странице.

=item B<To>

Номер последней записи на этой странице.

=back

=back

=cut

sub CalcNavigation {
    my %P = %{ UpdateHash({
        DefaultCount    => 20,
        PrevPages       => 10,
        NextPages       => 10,
        }, $_[0]) };
    $P{Records} = 0 unless $P{Records} > 0;
    $P{From} = Min(Max($P{From}, 1), $P{Records});
    $P{Count}= Max($P{Count}, 0) || $P{DefaultCount} || 1;
    $P{Page} = int(($P{From}-1)/$P{Count})+1;
    $P{From} = ($P{Page}-1)*$P{Count}+1;
    $P{To}   = Min($P{From}+$P{Count}-1, $P{Records});
    $P{Prev} = Max($P{From}-$P{Count}, 1);
    $P{Prev} = undef if $P{From} == 1;
    $P{Next} = $P{From}+$P{Count};
    $P{Next} = undef if $P{Next} > $P{Records};
    $P{Pages}= [ map {{
                        Page    => $_,
                        From    => ($_-1)*$P{Count}+1,
                        To      => Min($_*$P{Count}, $P{Records}) 
        }} Max(1, $P{Page}-$P{PrevPages}) .. 
        Min($P{Page}+$P{NextPages}, ($P{Records}-1)/$P{Count}+1) ];
    return \%P;
}

=item B<UpdateHash>( $main, $update )

Добавляет данные из хеша %$update в хеш %$main.

Алгоритм: накладывает заданные в %$update значения на текущие
значения %$main - если ключ с таким именем уже был то его значение
изменяется на новое, если такого ключа не было то он создается.
Если значением ключа является ссылка на хеш, то вместо замены старого
значения этого ключа на новое для этого "вложенного" хеша используется
тот-же алгоритм (рекурсивный вызов UpdateHash()). Кол-во уровней вложенности
хешей не ограничено.
Смотрите что происходит с параметром "PARAM3" в этом примере:

Возвращает $main .

 my $main = {};
 UpdateHash( $main, {
    PARAM1 => "value1",
    PARAM2 => 15,
    } );
 UpdateHash( $main, {
    PARAM2 => 123,
    PARAM3 => {
        DATA1 => "value31",
        DATA2 => "value32",
        },
    } );
 UpdateHash( $main, {
    PARAM3 => {
        DATA2 => "newvalue32",
        },
    } );
 # Здесь в $main будет такая структура:
 # {
 #  PARAM1 => "value1",
 #  PARAM2 => 123,
 #  PARAM3 => {
 #      DATA1 => "value31",
 #      DATA2 => "newvalue32",
 #      },
 # }

=cut

sub UpdateHash {
    my ($CONFIG, $config) = @_;
    for my $param (keys %$config) {
        if (ref($config->{$param}) eq "HASH") {
            $CONFIG->{$param} = {} if ref($CONFIG->{$param}) ne "HASH";
            UpdateHash($CONFIG->{$param}, $config->{$param});
        } else {
            $CONFIG->{$param} = $config->{$param};
        }
    }
    return $CONFIG;
}

=item B<EncUri>( [$to_escape [, $regexp]] )

EncUri() replaces unsafe URI characters in $to_escape to his safe URI
representation in format %XX, where XX is character's code in hex.

$regexp can be used to define unsafe characters in form: qr/[ABC\d\s]/ .
By default unsafe characters are defined as qr/\W/ .

If $to_escape omitted $_ will be used instead.

Return escaped string.

=item B<UnEncUri>( [$to_unescape] )

UnEncUri() replaces all %XX assertions in $to_unescape to characters 
with hex code XX.

If $to_unescape omitted $_ will be used instead.

Return unescaped string.

=cut

my %EncUri = map { chr($_), sprintf("%%%02X",$_) } 0..255;
sub EncUri {
    my $to_escape =  ($#_ == -1) ? $_ : $_[0];
    my $regexp    =  $_[1] || qr/\W/; 
    $to_escape    =~ s/($regexp)/$EncUri{$1}/g;
    return $to_escape;
}
sub UnEncUri {
    my $to_unescape =  ($#_ == -1) ? $_ : $_[0];
    $to_unescape    =~ s/%([0-9A-Fa-f]{2})/chr(hex($1))/eg;
    return $to_unescape;
}

=item B<Enc>( [$html_unsafe] )

Enc() replaces unsafe HTML characters in $html_unsafe to HTML-entities.

If $html_unsafe omitted $_ will be used instead.

Return safe HTML string.

=item B<UnEnc>( [$html] )

UnEnc() decode all HTML entities.

If $html omitted $_ will be used instead.

Return decoded string.

=cut

my %Enc=(qw'& &amp; > &gt; < &lt; " &quot;',map{chr,"&#$_;"}(0..8,11..31,127,139,155));
sub Enc {
    my $html_unsafe =  ($#_ == -1) ? $_ : $_[0];
    $html_unsafe    =~ s/([\&\>\<\"\0-\10\13-\37\177])/$Enc{$1}/gs;
    return $html_unsafe;
}
my %UnEnc=reverse(qw'& &amp; > &gt; < &lt; " &quot;',map{chr,"&#$_;"}(0..255));
sub UnEnc {
    my $html =  ($#_ == -1) ? $_ : $_[0];
    $html    =~ s/(&(?:#\d+|\w+);)/$UnEnc{$1}/gs;
    return $html;
}

=item B<RandCh>( $length [, @chars] )

RandCh() return string filled by $length random characters.
The random characters are taken from ("A".."Z","a".."z",0..9,"_") 
or from @chars if specified.

=cut

# from "Perl Cooking Book"
my @RandCh = ( "A".."Z", "a".."z", 0..9, "_" );
sub RandCh {
    my $length = shift;
    my @chars  = @_ ? (@_) : (@RandCh);
    join("", @chars[ map { rand @chars } (1..$length) ]);
}

=item B<abs_url>( $relative_url, $base_url )

Construct and return new absolute url based on $relative_url and $base_url.

Was written as fast analog for 
URI->new_abs($relative_url, $base_url)->as_string() .

=cut

sub abs_url {
    my ($new, $base) = @_;
    # вернуть относительную, если она содержит схему, т.е. она абсолютна
    return $new if $new =~ /^\w+:/;
    # отрезать от базы все после последнего каталога
    $base =~ s!^([^?]+/).*!$1!;
    # отрезать от базы все каталоги если относительная идет от корня
    $base =~ s{([\w.]/).*$}{$1} if $new =~ m!^/!;
    $base .= $new;
    # удалить из результата все "текущие" каталоги: "/./"
    $base =~ s!/\./!/!g;
    # удалить все "родительские" каталоги если возможно: "/parent/../"
    1 while $base =~ s!(/(?:[\w-]+|\.[^.])+/)(?:[\w-]+|\.[^.])+/\.\./!$1!g;
    # удалить все дублированые слэши в пути: "//"
    1 while $base =~ s!^([^?]+[^:])//+!$1/!g;
    return $base;
}

=item B<Check_Email>( $email )

Check syntax in $email. As minimum requred "user@host".

Return true if syntax looks ok.

=cut

sub Check_Email { no locale; $_[0]=~/^[\w\.-]+@[\w\.-]+$/ && not $_[0]=~/\.\./ }

=item B<Email>( $template, $data [, $attach] )

Send email.

If $template looks like a file name than email template will be read from it.
In other case scalar $template will be treated as template text.

$data must be a hash reference, and this hash will be used to substitute
fields in email template.
Fields format is: @~field_name~@ .

$attach must be a hash reference. Keys in this hash treated as file names.
If %$attach element has defined value this value used as file content, else
file content is read from disk.

After template is processed it is sent to mail program.
Mail program usually is "/usr/bin/sendmail -t".

Example:

 $template = <<EOT;
 From: Email robot <nobody>
 To: @~email~@
 Subject: @~subj~@

 Dear @~name~@.
 This message is a test.
 
 Sincerely, Robot.
 EOT
 $data = {
    email => 'user@remote.host.com',
    subj  => "Test",
    name  => "John Doe",
    };
 $attach = {
    "outbound/pic/1.jpg" => undef,
    "comment.txt" => "1.jpg is my photo.\n\nJonh.",
    };
 Email($template, $data, $attach);

=cut

my $Mail_Prog = "/usr/sbin/sendmail -t";# -oi -odq
sub Email {
    my ($file, $hash_ref, $attach) = @_;
    local *MAIL;
    open(MAIL,"| $Mail_Prog") or die "Email: $!";
    local $_ = $file =~ /\n/ ? $file : Cat($file);
    s/@~(.*?)~@/$hash_ref->{$1}/gs;
    if (keys %$attach) {
        my ($head, $body) = split "\n\n",$_,2;
        my $bound = RandCh(35);
        $head .= "\nMIME-Version: 1.0\n".
            "Content-Type: MULTIPART/MIXED; BOUNDARY=\"$bound\"\n\n";
        $body = "--$bound\n".
            "Content-Type: TEXT/PLAIN; charset=US-ASCII\n\n".
            $body."\n";
        for $file (keys %$attach) {
            $attach->{$file} = Cat $file unless defined $attach->{$file};
            (my $filename = $file) =~ s!.*/!!;
            $body .= "--$bound\n".
                "Content-Type: APPLICATION/octet-stream; name=\"$filename\"\n".
                "Content-Transfer-Encoding: BASE64\n".
                "Content-Disposition: attachment; filename=\"$file\"\n\n".
                EncBase64($attach->{$file});
        }
        $_ = $head . $body . "--$bound--\n";
    }
    print MAIL $_;
}

=item B<time>()

Return float time - seconds with microseconds. See `man gettimeofday`.
Work just like Time::HiRes, insignificantly slowly but don't require
compilation.

If gettimeofday() is not found will work as CORE::time().

=cut

{ my $SYS_gettimeofday = sub {
    local $ARGV; local @ARGV = grep {-r} map {"/usr/include/$_.h"}
        qw(syscall sys/syscall bits/syscall asm/unistd);
    /^\s*#define\s*(?:__NR|SYS)_gettimeofday\s*(\d+)/ and return $1 while <>;
    return undef;
  }->();
sub time {
    return CORE::time() unless $SYS_gettimeofday;
    syscall $SYS_gettimeofday, my $data=pack("ll"), 0;
    my ($sec, $msec) = unpack "ll", $data;
    return $sec+$msec/1000000;
}}

=item B<sleep>( $interval )

Sleeping $interval seconds. $interval can be float.

=cut

sub sleep {
    select undef, undef, undef, $_[0];
}

=item B<MD5>( $message )

Calculate MD5 digest specified in RFC 1321 and return it in binary form.

This is a pure perl realization, and it is 10-20 times slowly than
Digest::MD5 which require C compiler to install.

=cut

sub MD5 {
    use integer;
    my $msg = join '', @_;
    my $b = length($msg) * 8;
    my $pad = (((448+512) - ($b % 512)) % 512) || 512;
    $msg .= chr(0x80) . (chr(0) x ($pad/8-1)) . pack("VV",$b,0);
    my $A = 0x67452301;
    my $B = 0xefcdab89;
    my $C = 0x98badcfe;
    my $D = 0x10325476;
    for my $i (0 .. length($msg)/64-1) {
        my @X = unpack "V16", substr($msg, $i*64, 64);
        my $AA = $A;
        my $BB = $B;
        my $CC = $C;
        my $DD = $D;
        $A = $A+($D^($B&($C^$D)))+$X[0]+0xd76aa478;
        $A = $B + (($A << 7) | (($A >> (32-7)) & ((1 << 7) - 1)) );
        $D = $D+($C^($A&($B^$C)))+$X[1]+0xe8c7b756;
        $D = $A + (($D << 12) | (($D >> (32-12)) & ((1 << 12) - 1)) );
        $C = $C+($B^($D&($A^$B)))+$X[2]+0x242070db;
        $C = $D + (($C << 17) | (($C >> (32-17)) & ((1 << 17) - 1)) );
        $B = $B+($A^($C&($D^$A)))+$X[3]+0xc1bdceee;
        $B = $C + (($B << 22) | (($B >> (32-22)) & ((1 << 22) - 1)) );
        $A = $A+($D^($B&($C^$D)))+$X[4]+0xf57c0faf;
        $A = $B + (($A << 7) | (($A >> (32-7)) & ((1 << 7) - 1)) );
        $D = $D+($C^($A&($B^$C)))+$X[5]+0x4787c62a;
        $D = $A + (($D << 12) | (($D >> (32-12)) & ((1 << 12) - 1)) );
        $C = $C+($B^($D&($A^$B)))+$X[6]+0xa8304613;
        $C = $D + (($C << 17) | (($C >> (32-17)) & ((1 << 17) - 1)) );
        $B = $B+($A^($C&($D^$A)))+$X[7]+0xfd469501;
        $B = $C + (($B << 22) | (($B >> (32-22)) & ((1 << 22) - 1)) );
        $A = $A+($D^($B&($C^$D)))+$X[8]+0x698098d8;
        $A = $B + (($A << 7) | (($A >> (32-7)) & ((1 << 7) - 1)) );
        $D = $D+($C^($A&($B^$C)))+$X[9]+0x8b44f7af;
        $D = $A + (($D << 12) | (($D >> (32-12)) & ((1 << 12) - 1)) );
        $C = $C+($B^($D&($A^$B)))+$X[10]+0xffff5bb1;
        $C = $D + (($C << 17) | (($C >> (32-17)) & ((1 << 17) - 1)) );
        $B = $B+($A^($C&($D^$A)))+$X[11]+0x895cd7be;
        $B = $C + (($B << 22) | (($B >> (32-22)) & ((1 << 22) - 1)) );
        $A = $A+($D^($B&($C^$D)))+$X[12]+0x6b901122;
        $A = $B + (($A << 7) | (($A >> (32-7)) & ((1 << 7) - 1)) );
        $D = $D+($C^($A&($B^$C)))+$X[13]+0xfd987193;
        $D = $A + (($D << 12) | (($D >> (32-12)) & ((1 << 12) - 1)) );
        $C = $C+($B^($D&($A^$B)))+$X[14]+0xa679438e;
        $C = $D + (($C << 17) | (($C >> (32-17)) & ((1 << 17) - 1)) );
        $B = $B+($A^($C&($D^$A)))+$X[15]+0x49b40821;
        $B = $C + (($B << 22) | (($B >> (32-22)) & ((1 << 22) - 1)) );
        $A = $A+($C^($D&($B^$C)))+$X[1]+0xf61e2562;
        $A = $B + (($A << 5) | (($A >> (32-5)) & ((1 << 5) - 1)) );
        $D = $D+($B^($C&($A^$B)))+$X[6]+0xc040b340;
        $D = $A + (($D << 9) | (($D >> (32-9)) & ((1 << 9) - 1)) );
        $C = $C+($A^($B&($D^$A)))+$X[11]+0x265e5a51;
        $C = $D + (($C << 14) | (($C >> (32-14)) & ((1 << 14) - 1)) );
        $B = $B+($D^($A&($C^$D)))+$X[0]+0xe9b6c7aa;
        $B = $C + (($B << 20) | (($B >> (32-20)) & ((1 << 20) - 1)) );
        $A = $A+($C^($D&($B^$C)))+$X[5]+0xd62f105d;
        $A = $B + (($A << 5) | (($A >> (32-5)) & ((1 << 5) - 1)) );
        $D = $D+($B^($C&($A^$B)))+$X[10]+0x02441453;
        $D = $A + (($D << 9) | (($D >> (32-9)) & ((1 << 9) - 1)) );
        $C = $C+($A^($B&($D^$A)))+$X[15]+0xd8a1e681;
        $C = $D + (($C << 14) | (($C >> (32-14)) & ((1 << 14) - 1)) );
        $B = $B+($D^($A&($C^$D)))+$X[4]+0xe7d3fbc8;
        $B = $C + (($B << 20) | (($B >> (32-20)) & ((1 << 20) - 1)) );
        $A = $A+($C^($D&($B^$C)))+$X[9]+0x21e1cde6;
        $A = $B + (($A << 5) | (($A >> (32-5)) & ((1 << 5) - 1)) );
        $D = $D+($B^($C&($A^$B)))+$X[14]+0xc33707d6;
        $D = $A + (($D << 9) | (($D >> (32-9)) & ((1 << 9) - 1)) );
        $C = $C+($A^($B&($D^$A)))+$X[3]+0xf4d50d87;
        $C = $D + (($C << 14) | (($C >> (32-14)) & ((1 << 14) - 1)) );
        $B = $B+($D^($A&($C^$D)))+$X[8]+0x455a14ed;
        $B = $C + (($B << 20) | (($B >> (32-20)) & ((1 << 20) - 1)) );
        $A = $A+($C^($D&($B^$C)))+$X[13]+0xa9e3e905;
        $A = $B + (($A << 5) | (($A >> (32-5)) & ((1 << 5) - 1)) );
        $D = $D+($B^($C&($A^$B)))+$X[2]+0xfcefa3f8;
        $D = $A + (($D << 9) | (($D >> (32-9)) & ((1 << 9) - 1)) );
        $C = $C+($A^($B&($D^$A)))+$X[7]+0x676f02d9;
        $C = $D + (($C << 14) | (($C >> (32-14)) & ((1 << 14) - 1)) );
        $B = $B+($D^($A&($C^$D)))+$X[12]+0x8d2a4c8a;
        $B = $C + (($B << 20) | (($B >> (32-20)) & ((1 << 20) - 1)) );
        $A = $A+($B ^ $C ^ $D)+$X[5]+0xfffa3942;
        $A = $B + (($A << 4) | (($A >> (32-4)) & ((1 << 4) - 1)) );
        $D = $D+($A ^ $B ^ $C)+$X[8]+0x8771f681;
        $D = $A + (($D << 11) | (($D >> (32-11)) & ((1 << 11) - 1)) );
        $C = $C+($D ^ $A ^ $B)+$X[11]+0x6d9d6122;
        $C = $D + (($C << 16) | (($C >> (32-16)) & ((1 << 16) - 1)) );
        $B = $B+($C ^ $D ^ $A)+$X[14]+0xfde5380c;
        $B = $C + (($B << 23) | (($B >> (32-23)) & ((1 << 23) - 1)) );
        $A = $A+($B ^ $C ^ $D)+$X[1]+0xa4beea44;
        $A = $B + (($A << 4) | (($A >> (32-4)) & ((1 << 4) - 1)) );
        $D = $D+($A ^ $B ^ $C)+$X[4]+0x4bdecfa9;
        $D = $A + (($D << 11) | (($D >> (32-11)) & ((1 << 11) - 1)) );
        $C = $C+($D ^ $A ^ $B)+$X[7]+0xf6bb4b60;
        $C = $D + (($C << 16) | (($C >> (32-16)) & ((1 << 16) - 1)) );
        $B = $B+($C ^ $D ^ $A)+$X[10]+0xbebfbc70;
        $B = $C + (($B << 23) | (($B >> (32-23)) & ((1 << 23) - 1)) );
        $A = $A+($B ^ $C ^ $D)+$X[13]+0x289b7ec6;
        $A = $B + (($A << 4) | (($A >> (32-4)) & ((1 << 4) - 1)) );
        $D = $D+($A ^ $B ^ $C)+$X[0]+0xeaa127fa;
        $D = $A + (($D << 11) | (($D >> (32-11)) & ((1 << 11) - 1)) );
        $C = $C+($D ^ $A ^ $B)+$X[3]+0xd4ef3085;
        $C = $D + (($C << 16) | (($C >> (32-16)) & ((1 << 16) - 1)) );
        $B = $B+($C ^ $D ^ $A)+$X[6]+0x04881d05;
        $B = $C + (($B << 23) | (($B >> (32-23)) & ((1 << 23) - 1)) );
        $A = $A+($B ^ $C ^ $D)+$X[9]+0xd9d4d039;
        $A = $B + (($A << 4) | (($A >> (32-4)) & ((1 << 4) - 1)) );
        $D = $D+($A ^ $B ^ $C)+$X[12]+0xe6db99e5;
        $D = $A + (($D << 11) | (($D >> (32-11)) & ((1 << 11) - 1)) );
        $C = $C+($D ^ $A ^ $B)+$X[15]+0x1fa27cf8;
        $C = $D + (($C << 16) | (($C >> (32-16)) & ((1 << 16) - 1)) );
        $B = $B+($C ^ $D ^ $A)+$X[2]+0xc4ac5665;
        $B = $C + (($B << 23) | (($B >> (32-23)) & ((1 << 23) - 1)) );
        $A = $A+($C ^ ($B | (~$D)))+$X[0]+0xf4292244;
        $A = $B + (($A << 6) | (($A >> (32-6)) & ((1 << 6) - 1)) );
        $D = $D+($B ^ ($A | (~$C)))+$X[7]+0x432aff97;
        $D = $A + (($D << 10) | (($D >> (32-10)) & ((1 << 10) - 1)) );
        $C = $C+($A ^ ($D | (~$B)))+$X[14]+0xab9423a7;
        $C = $D + (($C << 15) | (($C >> (32-15)) & ((1 << 15) - 1)) );
        $B = $B+($D ^ ($C | (~$A)))+$X[5]+0xfc93a039;
        $B = $C + (($B << 21) | (($B >> (32-21)) & ((1 << 21) - 1)) );
        $A = $A+($C ^ ($B | (~$D)))+$X[12]+0x655b59c3;
        $A = $B + (($A << 6) | (($A >> (32-6)) & ((1 << 6) - 1)) );
        $D = $D+($B ^ ($A | (~$C)))+$X[3]+0x8f0ccc92;
        $D = $A + (($D << 10) | (($D >> (32-10)) & ((1 << 10) - 1)) );
        $C = $C+($A ^ ($D | (~$B)))+$X[10]+0xffeff47d;
        $C = $D + (($C << 15) | (($C >> (32-15)) & ((1 << 15) - 1)) );
        $B = $B+($D ^ ($C | (~$A)))+$X[1]+0x85845dd1;
        $B = $C + (($B << 21) | (($B >> (32-21)) & ((1 << 21) - 1)) );
        $A = $A+($C ^ ($B | (~$D)))+$X[8]+0x6fa87e4f;
        $A = $B + (($A << 6) | (($A >> (32-6)) & ((1 << 6) - 1)) );
        $D = $D+($B ^ ($A | (~$C)))+$X[15]+0xfe2ce6e0;
        $D = $A + (($D << 10) | (($D >> (32-10)) & ((1 << 10) - 1)) );
        $C = $C+($A ^ ($D | (~$B)))+$X[6]+0xa3014314;
        $C = $D + (($C << 15) | (($C >> (32-15)) & ((1 << 15) - 1)) );
        $B = $B+($D ^ ($C | (~$A)))+$X[13]+0x4e0811a1;
        $B = $C + (($B << 21) | (($B >> (32-21)) & ((1 << 21) - 1)) );
        $A = $A+($C ^ ($B | (~$D)))+$X[4]+0xf7537e82;
        $A = $B + (($A << 6) | (($A >> (32-6)) & ((1 << 6) - 1)) );
        $D = $D+($B ^ ($A | (~$C)))+$X[11]+0xbd3af235;
        $D = $A + (($D << 10) | (($D >> (32-10)) & ((1 << 10) - 1)) );
        $C = $C+($A ^ ($D | (~$B)))+$X[2]+0x2ad7d2bb;
        $C = $D + (($C << 15) | (($C >> (32-15)) & ((1 << 15) - 1)) );
        $B = $B+($D ^ ($C | (~$A)))+$X[9]+0xeb86d391;
        $B = $C + (($B << 21) | (($B >> (32-21)) & ((1 << 21) - 1)) );
        $A = $A + $AA;
        $B = $B + $BB;
        $C = $C + $CC;
        $D = $D + $DD;
    }
    pack "V4", $A, $B, $C, $D;
}

=item B<MD5hex>( $message )

Calculate MD5 digest and return it in hexadecimal form.

=cut

sub MD5hex {
    unpack "H*", &MD5;
}

=item B<MD5base64>( $message )

Calculate MD5 digest and return it as a base64 encoded string.

=cut

sub MD5base64 {
    (my $base64 = EncBase64(&MD5)) =~ s/=*$//;
    return $base64;
}

=item B<EncBase64>( $data )

Encode $data into the Base64 encoding specified in RFC 2045.

=cut

sub EncBase64 {
    use integer;
    my $len = length($_[0]);
    my $res;
    for my $i (0..($len-1)/99999) {
        my $data = substr($_[0], $i*99999, 99999);
        chop($res .= substr(pack("u200000", $data), 1));
    }
    $res =~ tr/` -_/AA-Za-z0-9+\//;
    my $pad = $len % 3;
    substr($res, $pad-3) = "="x(3-$pad) if $pad;
    $res=~s/(.{1,76})/$1\n/g;
    return $res;
}

=back

=head1 HISTORY

 1.92       Tue Mar 12 13:44:24 EET 2002
        - deleted DBI->All()
        - added Echo()
 1.91       Mon Mar 11 14:04:22 EET 2002
        - added Chomp()
 1.90       Wed Mar  6 00:04:55 EET 2002
        - added Cat(), MEM_used(), FD_used()
 1.80       Sat Jan 19 03:18:08 EET 2002
        - added CPU_start(), CPU_max(), CPU_used()
 1.70       Sat Jan 12 02:12:54 EET 2002
        - added Min(), Max(), CalcNavigation()
 1.60       Thu Jan 10 06:20:21 EET 2002
        - added UpdateHash()
 1.50       Wed Jan  9 19:15:05 EET 2002
        - added EncBase64()
 1.40       Wed Jan  9 00:51:25 EET 2002
        - added MD5(), MD5hex(), MD5base64()
 1.30       Mon Jan  7 17:22:35 EET 2002
        - added DBI->All()
 1.10       Mon Nov 12 07:22:56 EET 2001
        - added time()
 1.00       Tue Aug  7 19:40:32 EEST 2001
        - first release

=head1 AUTHOR

 Alex Efros <powerman@asdfGroup.com>
 Nikita Savin <nikita@asdfGroup.com>

=cut

1;


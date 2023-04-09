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

B<POWER::MetaSearch> - Make fast metasearch using many search servers.

=head1 SYNOPSIS

 use POWER::MetaSearch;

 @known_engines = POWER::MetaSearch::engines_list();
 $ms = new POWER::MetaSearch;
 @engines = ("Yahoo","Google");
 $ms->max_results("Google", 50);
 $ms->search("Programming Perl", 40, @engines);
 @yahoo_results = $ms->results("Yahoo");

 $ms->favour("Yahoo", 100);
 $ms->favour("MSN", 75);
 $ms->max_results("Yahoo", 10);
 $ms->max_results("MSN", 20);
 @res = $ms->search("Programming Perl", 30, 
    "Yahoo", "MSN")->by_relevance();

=head1 DESCRIPTION

Fast metasearch.

=head1 KNOWN SEARCH SERVERS

Here the full list of search servers which can be used in metasearch:
'DirectHit', 'MSN', 'AOL', 'AllTheWeb', 'LycosPro', 'Excite',
'NorthernLight', 'Google', 'Yahoo', 'Netscape', 'Dmoz'.

=head1 METHODS

=over 4

=cut

package POWER::MetaSearch;
use POWER::lib;
use POWER::Multi::GET;
use POWER::HTML::TAG qw(strip);
use strict;
use vars qw($VERSION $DEBUG $UserAgent);
$VERSION = "1.40";
$DEBUG   = 0;
$UserAgent = "User-Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)\r\n";

# Define search engines
my %ENGINES; load_engines();
@{$ENGINES{$_}}{"name","favour"} = ($_, 1) for keys %ENGINES;

sub load_engines {
    return unless my ($dir) = grep {-d} map {"$_/POWER/MetaSearch/"} @_?@_:@INC;
    local *DIR; opendir DIR, $dir or return;
    my @files = grep {/^\w/ && -f "$dir/$_" } readdir DIR;
    %ENGINES = eval "(" . join("", 
        map { "'$_' => { ".`/bin/cat $dir/$_`." }," } @files) . ")";
}

=item B<new>()

Возвращает новый объект POWER::MetaSearch.
При вызове от другого объекта POWER::MetaSearch этот объект копируется
в новый (т.е. сохраняются все настройки favour, max_results, etc.).
Вытянутые результаты в новый объект не переносятся.

=cut

sub new {
    my $this  = shift ;
    my $class = ref($this) || $this ;
    my $self = {};
    $self->{ENGINES} = { map { $_ => {
        max_results => $this->{ENGINES}{$_}{max_results}, 
            favour  => $this->{ENGINES}{$_}{favour}
    } } keys %{$this->{ENGINES}} } if ref($this);
    bless $self, $class ;
}

=item B<engines_list>()

Return list of supported engines.

=cut

sub engines_list { keys %ENGINES }

=item B<favour>( $engine [, $percent] )

При наличии $percent устанавливает предпочтение для $engine.

При вызове как метод класса работает с предпочтением по-умолчанию всех
объектов которые не установили или не унаследовали предпочтения для
этой $engine. Предпочтение по-умолчанию так-же будет использоватся если
у объекта установить $persent в undef.

Предпочтение задается в процентах (1-100) и может быть дробным числом.
Предпочтение используется при объединении и ранжировании результатов 
полученных с нескольких поисковиков.

Возвращает текущее предпочтение (по умолчанию - 1).

=cut

# коррекция граничных значений для процентов (1-100)
sub _percent { ($_[0]>100) ? 100 : ($_[0]<1) ? 1 : $_[0] }
sub favour {
    my ($self, $engine)  = (shift, shift);
    return undef unless exists $ENGINES{$engine};
    if (ref($self)) {
    $self->{ENGINES}{$engine}{favour} = _percent(shift) if @_;
    return defined($self->{ENGINES}{$engine}{favour}) ?
        $self->{ENGINES}{$engine}{favour} : $ENGINES{$engine}{favour};
    } else {
    $ENGINES{$engine}{favour} = _percent(shift) if @_;
    return $ENGINES{$engine}{favour};
    }
}

=item B<max_results>( $engine [, $max_results] )

При наличии $max_results устанавливает максимум вытягиваемых результатов
для $engine.

$max_results используется для остановки выкачки до срабатывания таймаута.
Если будет получено больше результатов, чем задано в $max_results, лишние
результаты будут откинуты. Значение $max_results undef заставляет выкачивать
до тех пор, пока не сработал таймаут и поисковик возвращает новые результаты.

Возвращает текущий максимум (по умолчанию - undef).

=cut

sub max_results {
    my ($self, $engine)  = (shift, shift);
    return undef unless exists $ENGINES{$engine};
    $self->{ENGINES}{$engine}{max_results}=shift if @_;
    return $self->{ENGINES}{$engine}{max_results};
}

=item B<search>( $query, $timeout [, @engines] )

Make metasearch. All results without eliminate duplications and
without sorting will be stored in object.

$query is user query. No special query language used at this time: query
will be sent to search servers as is.

$timeout is timeout in seconds. metasearch finished after downloading asked
number of results for all asked servers, or after timeout.

@engines is a list of engines which will be used in metasearch. If @engines
isn't specified, all known engines will be used.

Return $self (reference to itself) - to use like this: 

 @sorted = $obj->search(...)->by_relevance();

=cut

# Normalize data cutted from html page
sub _norm { local $_ = UnEnc(strip($_[0])); s/\n+/ /g; s/^\s+//; s/\s+$//; $_ }
# Standart parsing: 1) list of urls with title and description, 2) link "Next"
sub _parse {
    my ($url, %Engine, @results, $next_url) = ($_[0], %{$_[1]});
    my $html = $url->{_content};
    push @results, {url => UnEncUri($1), title => _norm($2), descr => _norm($3),
        source_url => $url->{_url}} while $html=~m!\G.*?$Engine{Rec}!gcsi;
    $next_url=abs_url($1, $Engine{url}) if $html=~m!\G.*?$Engine{Next}!gcsi;
    return (\@results, $next_url);
}
sub search {
    my ($self, $query, $timeout, @engines) = (shift, @_);
    @engines = @engines ? (grep {exists $ENGINES{$_}} @engines) : keys %ENGINES;
    # сброс старых результатов и установка первых страниц на выкачку
    my %URL = map {
        $self->{ENGINES}{$_}{results} = [];
        (my $url=$ENGINES{$_}{url}) =~ s/\^~query~\^/EncUri($query)/eg;
        ($_." - 1", {url=>$url,ip=>$ENGINES{$_}{ip},engine=>$_,from=>1,
        add_to_header=>$UserAgent}) } @engines;
    $timeout = time()+$timeout;
    POWER::Multi::GET::Download(%URL, sub {
        # для всех вытянутых и еще не обработанных
        for (grep {$_->{_ok}} values %URL) {
        # перевытягивание при ошибке (пока не сработает timeout)
        delete $_->{_state}, next if $_->{_ok} eq "ERR";
        # DEBUG
        open(DEBUG, ">".$_->{engine}."-".$_->{from}.".html") and
            print(DEBUG $_->{_header},"\n",$_->{_content}) and 
            close(DEBUG) or die($!)
            if $POWER::MetaSearch::DEBUG;
        # обработка редиректов, разборка странички
        my $redirect = $_->{_header} =~ /^Location: (.*?)\r?$/ms;
        my ($results, $next_url) = $redirect ? 
            ([], abs_url($1, $_->{url})) :
            _parse($_, $ENGINES{$_->{engine}});
        # вытягивание следующей странички если не превышен max_results
        my $from = $_->{from} + @$results;
        my $max = $self->max_results($_->{engine});
        $URL{ $_->{engine}." - ".$from } = {
            url => $next_url,
            engine  => $_->{engine},
            from    => $from,
            add_to_header => $UserAgent,
            } if $next_url and (not defined $max or $max >= $from);
        # запоминание результатов поиска
        @{$self->{ENGINES}{$_->{engine}}{results}}[$_->{from}-1..
            $from-2] = @$results;
        delete $URL{$_->{engine}." - ".$_->{from}} unless $redirect;
        }
        # обработка timeout
        undef(%URL) if $timeout <= time();
    });
    return $self;
}

=item B<results>( $engine )

Возвращает список результатов для $engine (вытянутый search*()).

Каждый элемент списка является ссылкой на хеш с полями: url, title, descr 
и source_url. url, title и descr описывают полученный результат; source_url
содержит url странички на поисковике, с которой этот результат был получен.

=cut

sub results {
    my ($self, $engine) = (shift, @_);
    return unless exists $self->{ENGINES}{$engine} and
    ref $self->{ENGINES}{$engine}{results} eq "ARRAY";
    # обрезать результаты по max_results
    my $max  = $self->max_results($engine);
    my $last = @{$self->{ENGINES}{$engine}{results}};
    $last = $max if defined($max) and $max<$last;
    return @{$self->{ENGINES}{$engine}{results}}[0..$last-1];
}

=item B<by_relevance>( [@engines] )

Return list of sorted results. Sort criteria (relevance) calculated based
on engine favour() and position of result on this engine.
If @engines isn't specified all ready engines are used.
Each result is hash reference with fields 'url', 'title', 'descr',
'engine' and 'relevance'.

=cut

sub by_relevance {
    my ($self, @engines) = (shift, @_);
    @engines = keys %{$self->{ENGINES}} unless @engines;
    my (@results, %seen, $engine, $pos);
    for $engine (@engines) {
    my @r = $self->results($engine);
    for $pos (1..@r) {
        push @results, { %{$r[$pos-1]}, "engine" => $engine, 
        "relevance" => $self->favour($engine) / $pos };
    }
    }
    return grep {! $seen{$_->{url}}++}
    sort {$b->{relevance} <=> $a->{relevance} or
        $self->favour($b->{engine}) <=> $self->favour($a->{engine})
        } @results;
}

=item B<dump_results>( [@engines] )

Возвращает сложную структуру содержащую текущий список результатов для
списка поисковиков. Список поисковиков задается параметром, либо будут
возврашены результаты по всем поисковикам. Возвращаемая структура
предназначена для использования в restore_results().

=cut

sub dump_results {
    my ($self, @engines) = (shift, @_);
    @engines = @engines ? (grep {exists $self->{ENGINES}{$_}} @engines) : 
    keys %{$self->{ENGINES}};
    @engines = grep {ref $self->{ENGINES}{$_}{results} eq "ARRAY"} @engines;
    return { map {$_, $self->{ENGINES}{$_}{results}} @engines };
}

=item B<restore_results>( $dump [, @engines] )

Процедура обратная dump_results().
Загружает результаты из $dump в объект. Необязательным параметром @engines
можно указать какие именно engines из $dump загружать в объект.

Return $self (reference to itself) - to use like this: 

 @sorted = $obj->restore_results(...)->by_relevance();

=cut

sub restore_results {
    my ($self, $dump, @engines) = (shift, @_);
    @engines = @engines ? (grep {exists $ENGINES{$_}} @engines) : keys %$dump;
    $self->{ENGINES}{$_}{results} = (ref $dump->{$_} eq "ARRAY") ? $dump->{$_}
    : [] for @engines;
    return $self;
}

=back

=head1 SUPPORT (UPDATE SEARCH SERVERS)

 Bes Murzik <murzik@powerman.sky.net.ua>

=head1 AUTHORS

 Alex Efros <powerman@asdfGroup.com>
 Nikita Savin <nikita@asdfGroup.com>

=cut

1;

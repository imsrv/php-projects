#!/usr/local/bin/perl

push (@INC, ".");

my %CONFIG = undef;
$CONFIG{'PARSER_dbdir'} = "/usr/home/admin/words/db";
$CONFIG{'exclusiveurls'} = "moviething.com";
$CONFIG{'PARSER_ignore'} = "";
$CONFIG{'PARSER_minlength'} = 4;

sub prepare_hash {
	$ignorewords = $_[0];

	my %iw = undef;

	# Let's hash together our ignore words for faster lookups later
	my @iwords = split(/ /, $ignorewords);
	foreach my $word (@iwords) {
		$iw{$word}++;
	}

	return %iw;
}

sub parse_in {
	my ($id, $dbdir, $minlength, $page, $words2keep, %ignorewords) = @_;

	my ($wordcount, %keys) = (undef, undef);

	# We need to assume that this text is messy, let's clean it up make it uniform before parsing it.
	use HTML::Parser;
	use HTML::FormatText;

	my $clean_text = HTML::FormatText->format(parse_html($$page));

	$clean_text =~ s/(\n|\cM|\r|\t)/ /g;
	$clean_text = lc($clean_text);
	$clean_text =~ s/\W/ /g;

	my @words = split(/ +/, $clean_text);

	foreach my $word (@words) {
		if ((! $ignorewords{$word}) && (length($word) > $minlength)) {
			$keys{$word}++;
		}
	}

	my @firstwords = undef;

	foreach my $word (keys %keys) {
		&record_word($dbdir, $word, $id);
		if ($wordcount < $words2keep) {
			$firstwords .= $word . " ";
		}
		$wordcount++;
	}

	return $wordcount, $firstwords;
}

sub record_word {
	my ($db, $word, $id) = @_;

	$word =~ /(...)/;
	my $database = "$dbdir/$1.db";

	tie my %data, "DB_File", $database;
	$data{$word} .= $id . "|";
	untie %data;
}


sub get_page_info {
	$page = $_[0];
	my $p = HTML::HeadParser->new;
	$p->parse($$page);
	return $p->header('Title'), $p->header('keywords'), $p->header('description');
}

sub markpage {
	my ($id, $title, $keywords, $description, $wordsfound, $firstwords, $url) = @_;

	$word =~ /(..)$/;
	my $database = "$dbdir/index/$1.db";

	tie my %data, "DB_File", $database;
	$data{$id} = "$id||$title||$keywords||$description||$wordsfound||$firstwords||$url";
	untie %data;	
}

sub get_urls {
	my ($id, $PageUrl, $page, $tempdir) = @_;

	my $filename = "$tempdir/$id.html";

	my ($count, $linkcount, @urls) = (0, 0, undef);

	open (FILE, ">$filename");
	print FILE $$page;
	close (FILE);

	my $p = HTML::TokeParser->new(shift|"$filename");

	while (my $token = $p->get_tag("a")) {
		my $url = $token->[1]{href} || "-";
		$url =~ s/[ \n\cM]//g;
		my $u1 = URI::URL->new($url,$PageUrl);
		push (@urls, $u1->abs);
	}

	return @urls;
}

if ($CONFIG{'ignoreurls'} =~ /\w/) {
	my %ignoreurls = &prepare_hash($CONFIG{'ignoreurls'});
}
if ($CONFIG{'exclusiveurls'} =~ /\w/) {
	my %exclusiveurls = &prepare_hash($CONFIG{'exclusiveurls'});
}
my %ignorewords = &prepare_hash($CONFIG{'PARSER_ignore'});

my $id = time;
$id =~ s/(\d\d\d\d\d)$/$1/;

tie my %todo, "DB_File", "$CONFIG{'PARSER_dbdir'}/conf/todo.db";
tie my %done, "DB_File", "$CONFIG{'PARSER_dbdir'}/conf/done.db";

$todo{'http://moviething.com'}++;

for (0..9) {
	($url, undef) = each %todo;
	delete $todo{$url};
	$done{$url}++;
	my $n = keys %todo;
	$id++;
	my $page = get{$url);
	my ($wordsfound, $firstwords) = &parse_in($id, $CONFIG{'PARSER_dbdir'}, $CONFIG{'PARSER_minlength'}, \$page, %ignorewords);
	my ($title, $keywords, $description) = &get_page_info(\$page);

	&markpage($id, $title, $keywords, $description, $wordsfound, $firstwords, $url);
	$completed{$url} = $wordsfound;
	print "$wordsfound       $url\n";
	while (&get_urls($id, $url, \$page, "$CONFIG{'PARSER_dbdir'}/conf")) {
		my ($domain = $_) =~ s/https?://(www\.)?([^/]*).*/$2/i;
		if ($CONFIG{'exclusiveurls'} =~ /\w/) {
			if ($exclusiveurls{$domain}) {
				$todo{$_}++;
			}
		}
		elsif (! $ignoreurls{$domain}) {
			$todo{$_}++;
		}
	}
}

untie %todo;
untie %done;

print "\n\n\n==========================\n";
foreach my $l (keys %completed) {
	print "$l        $completed{$l}\n";
}

exit;

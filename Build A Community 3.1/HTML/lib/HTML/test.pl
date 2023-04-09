#!/usr/local/bin/perl

push (@INC, ".");
	use LWP::Simple;
#	use HTML2::LinkExtor;
	use HTML::TokeParser;
	
	my $rn = time;
	my ($base_url) = "http://moviething.com/";
	$page = get($base_url);
	open (FILE, ">$rn.html");
	print FILE $page;
	close (FILE);

	$p = HTML::TokeParser->new(shift||"$rn.html");

	while (my $token = $p->get_tag("a")) {
		my $url = $token->[1]{href} || "-";
		my $text = $p->get_trimmed_text("/a");
		print "$url\t$text\n";
	}



#	$parser = HTML::LinkExtor->new(undef, $base_url);
#	$parser->parse(get($base_url));
#	@links = $parser->links;

#	foreach $l (@links) {
#		@link = @$l;
#		print "$link[0] \| $link[1] \| $link[2]\n";
#	}

exit;

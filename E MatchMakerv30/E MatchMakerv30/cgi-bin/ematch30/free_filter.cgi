#################################################
# Blocks users from registering using free email
# accounts.

sub free_filter {
	my ($email) = @_;

	$email =~ s/^.+\@(.+)$/$1/;

	open(LIST,"$datapath/form/free.txt") || &return_page('System Error', "Can't read free.txt.(7)\n");
	@lines = <LIST>;
	close(LIST);
	chomp(@lines);

	foreach $domain (@lines) {
		$domain =~ s/\@//;
		if(lc($email) eq lc($domain)) {
			&return_page("Sorry.  Email addresses from $domain are not accepted.", "Please use your browsers [Back] button to return to the registration form, and enter a different email address.  Your ISP email address should work fine.");
			exit;
		}
	}
}
#################################################
# Return HTML

sub return_page {
	my($heading, $message) = @_;
	&print_header($heading);
	print $message;
	&print_footer;
	exit;
}

sub print_header {
	local($title) = @_;
	print "Content-type: text/html\n\n";
	print "<HTML><HEAD>\n";
	print "<TITLE>$title</TITLE>\n";
	print "</HEAD><BODY>\n";
	print "<H1>$title</H1><hr>\n";
}

sub print_footer {
	print "</BODY></HTML>\n";
}

1;
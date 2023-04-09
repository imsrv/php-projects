#!/usr/bin/perl
#############################################################
#############################################################
##        Aaron's All Engine Expired Domain Finder         ##
##                This is a Commercial Script              ##
##        Modification, Distribution or Resale without     ##
##        Prior written permission is in Violation of      ##
##        the copyrights and International Intellectual    ##
##        Property Laws.  Violators will be prosecuted!    ##
##        http://www.aaronscgi.com - aaron@aaronscgi.com   ##
#############################################################
#############################################################
#                                                           #
#             THE ONLY CHANGE THAT NEED BE MADE IS          #
#             THE PATH TO PERL AT THE TOP OF THIS           #
#             PAGE ** IF NEEDED **                          #
#                                                           #
#############################################################
#                                                           #
#            DO NOT EDIT ANYTHING BELOW THIS LINE           #
#                                                           #
#############################################################

sub Search {
	my %Q = %{$_[0]};
	my %H, %B;
	my $ms = new POWER::MetaSearch;
	$ms->max_results($_, $Q{results}) for POWER::MetaSearch::engines_list();
	my $st = time();
	$ms->search(@Q{query, timeout});
	$H{metasearch_time} = time()-$st; $H{keyword}=$Q{query};
	for $engine (POWER::MetaSearch::engines_list()) {
		my $rank=();
		for ($ms->results($engine)) {
			$H{total}++;
			$rank++;
			$_->{url}=~m!(?:\w+://)[^/]*?([\w\d-]+\.(?:com|org|net))(?:/|$)!i;
			next unless $1;
			my $host = lc($1);
			$B{$host}{host} ||= $host;
			$B{$host}{rank}{$engine} ||= $rank;
		}
	}
	$H{domains}=scalar keys %B;
	$st=time(); my @nxdomains = CheckIP(keys %B);  $H{ip_time} = time()-$st; 
	$B{$_}{nxdomain}=1 for @nxdomains;
	$st=time();@expire = CheckWHOIS(@nxdomains); $H{whois_time} = time()-$st;
	$B{$_}{expire} = 1 for @expire;
	$H{nxdomain}=0+@nxdomains; $H{expire}=0+@expire;
	my $fname = EncUri($Q{query}.'-'.time());
	open F, ">data/$fname";	print F Dumper([\%H, 
		sort {$b->{expire} <=> $a->{expire} || $a->{host} cmp $b->{host}}
		values %B]);
	open F, '>data/debug'; print F Dumper($ms->dump_results());
	return $fname;
}

sub List {
	my %Q = %{$_[0]}; my $q=$Q{query}||'';
	opendir D, "data/" or die $!;
	map {/^(.*)-(\d*)$/; {name=>$1, date=>scalar localtime($2), fname=>$_}} 
		grep {!/debug$/} grep {$q ? /\Q$q\E/ : 1} map {UnEncUri($_)} grep {!/^\.+$/} readdir D;	


}


sub Browse {
	my $fname= $_[0];
	my @Res = @{eval Cat("data/$fname")}; my $H = shift @Res; 
	return $H, @Res; 
}

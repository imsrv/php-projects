#!/usr/local/bin/perl

require "setup35.cgi";


open(USERFILE,"$logpath/$log");
@user_info = <USERFILE>;
close(USERFILE);

@user_info = sort(@user_info);

open(USERFILE,">$logpath/$log") || &system_error("Can't append to log.\n");
flock USERFILE, 2 if $lockon eq 'yes';
seek (USERFILE, 0, 0);

print USERFILE @user_info;

close(USERFILE);

open(INDEX,">$datapath/index.txt") || &return_page('System Error', "Can't write to index.txt.(20)\n");
flock INDEX, 2 if $lockon eq 'yes';
seek (INDEX, 0, 0);

print INDEX "0";

close(INDEX);


foreach $init (48..122) {
	$init = chr($init);
	next unless(-e "$datapath/$init");
	# next if(-e "$datapath/$init/profiles.txt");
	# next if $init lt 'n';
	
	@profiles = ();
	
	@user_dirs = &listdir("$datapath/$init", 'subdir');
	
	foreach $user_dir (@user_dirs) {
		next unless(-e "$datapath/$init/$user_dir/profile.txt");
		open(PROFILE,"$datapath/$init/$user_dir/profile.txt") || &return_page('System Error', "Can't read profile.txt.(39)\n");
		@lines = <PROFILE>;
		close(PROFILE);
		chomp(@lines);
		
		$profile = join("|", @lines);
		
		$profile =~ s/\r//g;
		
		$profile = "Password:\t$user_dir|$profile";
		
		push (@profiles, $profile);
	}
	
	open(PROFILES,">$datapath/$init/profiles.txt") || &return_page('System Error', "Can't write to profiles.txt.(50)\n");
	flock PROFILES, 2 if $lockon eq 'yes';
	seek (PROFILES, 0, 0);
	
	foreach $profile (@profiles) {
		print PROFILES "$profile\n";
	}
	
	close(PROFILES);
}

print "Content-type: text/html\n\n";

print "<html>\n";
print "<head>\n";
print "<title>Done</title>\n";
print "</head>\n";
print "<body>\n";
print "<h1 align=center>Done</h1><hr>\n";
print "\n";
print "</body>\n";
print "</html>\n";

exit;

#################################################
# Read Form

sub get_form_data {
	read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
	if ($ENV{'QUERY_STRING'}) {
		$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
	}
	$buffer =~ tr/+/ /;
	$buffer =~ s/%0a//gi;
	$buffer =~ s/([;<>\*\,\`'\$#\[\]\{\}"])/\\$1/g; # extra security
	@pairs = split(/&/,$buffer);
	foreach $pair (@pairs) {
		($name,$value) = split(/=/,$pair);
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
		if(exists($FORM{$name})) {
			$FORM{$name} .= "\t$value";
		}else {
			$FORM{$name} = $value;
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
#################################################
# listdir

sub listdir {
	my ($dirpath, $type) = @_;
	opendir(DIR, "$dirpath");
	@raw = sort grep(!/^\./, readdir(DIR));
	closedir(DIR);
	@file_list = ();
	for $item(@raw) {
		if((-d "$dirpath/$item") and ($type eq 'subdir')) {
			push(@file_list, $item);
			next;
		}
		next if(-T "$dirpath/$item") and $type ne 'ascii';
		next if(-B "$dirpath/$item") and $type ne 'binary';
		push(@file_list, $item);
	}
        return(@file_list);
}

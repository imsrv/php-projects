#!/usr/bin/perl

require 'setup35.cgi';

#&get_form_data;

@nicknames = ();
@passwords = ();
$USERS = ();

open(USERLOG,"<$logpath/$log") || &return_page('System Error', "Can't access $log(1).\n");
seek(USERLOG, 0, 0);

@lines = <USERLOG>;
chomp(@lines);

close(USERLOG);

unless(@lines) {&return_page('Log Error', "Your log file appears to be empty.\n")};

foreach $line (@lines) {

	($nickname, $password) = split(/\t/, $line);
	$USERS{$nickname} = $password;
	push(@passwords, $password);
	push(@nicknames, $nickname);

}

# check for orphaned pics

@pic_files = &listdir("$html_path/pics", 'binary');

foreach $p_file (@pic_files) {
	($pic_username = $p_file) =~ s/^(.+?)\.\w+$/$1/;
	unlink "$html_path/pics/$p_file" unless exists $USERS{$pic_username};
}

# check for orphaned user files

@temp_dirs = &listdir("$datapath", 'subdir');

@init_dirs = grep(/^\b\w\b$/, @temp_dirs);


foreach $init (@init_dirs) {

	@temp_dirs = &listdir("$datapath/$init", 'subdir');
	
	@pass_dirs = grep(/\w/, @temp_dirs);
	
	foreach $pass (@pass_dirs) {
		unless(grep(/$pass/, @passwords)) {
		
			#password not found - nuke dir
			
			@file_list = &listdir("$datapath/$init/$pass", 'all');
			
			foreach $file (@file_list) {
				unlink "$datapath/$init/$pass/$file";
			}
			
			rmdir "$datapath/$init/$pass";
			
		}else {
		
			#password okay, check for dead matches
			
			@match_passwords = ();

			if(-e "$datapath/$init/$pass/matches.txt") {
				open(MATCHES,"+>>$datapath/$init/$pass/matches.txt") || &return_page('System Error', "Can't access matches.txt(4).\n");
				flock MATCHES, 2 if $lockon eq 'yes';
				seek(MATCHES, 0, 0);

				@matches = <MATCHES>;
				chomp(@matches);

				seek (MATCHES, 0, 0);
				truncate (MATCHES, 0);

				foreach $item (@matches) {
					($match, $score) = split(/\t/, $item);
					next unless exists($USERS{$match});
					print MATCHES "$item\n";
					push(@match_passwords, $USERS{$match});
				}

				close(MATCHES);

			}
			
			# check for orphan board files
			
			@file_list = &listdir("$datapath/$init/$pass", 'all');
			
			foreach $file (@file_list) {
				next if $file =~ /\.txt/;
				$file =~ s/\.data$//;
				next if grep(/$file/, @match_passwords);
				
				unlink "$datapath/$init/$pass/$file";
				unlink "$datapath/$init/$pass/$file.data";
			}
		}
	}
}

print "Content-type: text/html\n\n";

print "<html>\n";
print "<head>\n";
print "<title>\n";
print "Cleaned\n";
print "</title>\n";
print "</head>\n";
print "<body>\n";
print "<h1>Cleaned</h1><hr>\n";
print "This site is clean.\n";
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
		next if $item =~ /^\.\.?$/;
		if((-d "$dirpath/$item") and ($type eq 'subdir')) {
			push(@file_list, $item);
			next;
		}
		if($type ne 'all') {
			next if(-T "$dirpath/$item") and $type ne 'ascii';
			next if(-B "$dirpath/$item") and $type ne 'binary';
		}
		push(@file_list, $item);
	}
        return(@file_list);
}

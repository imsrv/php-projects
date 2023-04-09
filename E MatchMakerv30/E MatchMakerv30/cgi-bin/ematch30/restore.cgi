#!/usr/local/bin/perl
#################################################
# Will restore a busted $log.

require 'setup.cgi';

%USERS = ();

if(-e "$logpath/$log") {
	open(LOG,"$logpath/$log");
	@lines = <LOG>;
	close(LOG);
	chomp(@lines);

	foreach $line (@lines) {
		($name, $value) = split (/\t/, $line, 2);
		$USERS{$name} = $value;
	}
}

$time = time;

$inc = 60*60*24;

@init_dirs = &listdir($datapath, 'subdir');

foreach $init_dir (@init_dirs) {
	$init_path = "$datapath/$init_dir";
	@pass_dirs = &listdir($init_path, 'subdir');

	foreach $pass_dir (@pass_dirs) {
		$pass_path = "$init_path/$pass_dir";
		if(-e "$pass_path/profile.txt") {
			open(PROFILE,"$pass_path/profile.txt") || &system_error("Can't read profile.txt.(17)\n");
			@lines = <PROFILE>;
			close(PROFILE);
			chomp(@lines);

			@nick_line = grep(/Nickname:/, @lines);
			$nick_line = $nick_line[0];
			($nickname = $nick_line) =~ s/Nickname:\t(.+)/$1/;

			@email_line = grep(/Email:/, @lines);
			$email_line = $email_line[0];
			($email = $email_line) =~ s/Email:\t(.+)/$1/;

			$USERS{$nickname} = "$pass_dir\t$email\t$time" unless(exists($USERS{$nickname}));
			$time += $inc;
		}
	}
}

open(LOG,">$logpath/$log") || &system_error("Can't write to $log.(37)\n");
flock LOG, 2 if $lockon eq 'yes';
seek (LOG, 0, 0);
foreach $key (sort(keys(%USERS))) {
	print LOG "$key\t$USERS{$key}\n";
}
close(LOG);

print <<DONE;
Content-type: text/html

<html><head></head><body>
Done.
</body></html>
DONE

exit;

#################################################
# listdir
# Given:
#	The path to the directory, and the file type
#	(ascii, binary, subdir)
#
# Returns:
#	file list
#################################################

sub listdir {
	my ($dirpath, $type) = @_;
	opendir(DIR, "$dirpath");
	@raw = sort grep(!/^\./, readdir(DIR));
	closedir(DIR);
	@file_list = ();
	for $item(@raw) {
		next if(-d "$dirpath/$item") and $type ne 'subdir';
		next if(-T "$dirpath/$item") and $type ne 'ascii';
		next if(-B "$dirpath/$item") and $type ne 'binary';
		push(@file_list, $item);
	}
        return(@file_list);
}

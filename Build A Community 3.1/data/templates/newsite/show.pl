#!/usr/local/bin/perl

use DB_File;
$data_dir = "./data";

print "Content-Type: text/plain\n\n";

    	opendir(FILES, "./") || die ERROR("Can't open directory");
    	while($file = readdir(FILES)) {
        	if($file =~ /.*\.db/) {
			print "\n\n\n\n=============================$file====================================\n";
			print "================================================================\n";

			tie %usersdb, "DB_File", "./$file";
			foreach $mk(keys %usersdb) {
				print "$mk = $usersdb{$mk}\n";
			}
		}
	}

	print "done!\n";

	exit;


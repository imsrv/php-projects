#!/usr/bin/perl

print "--------------------------------------------\n";
print "|             AWGTrade Setup               |\n";
print "--------------------------------------------\n\n";

$fullpath = `pwd`;
chop($fullpath);

if($ARGV[0] eq "upgrade") { 

	if(!chmod(0775,"tradeadmin/awgcron"))
		{ print "Warning: Unable to chmod tradeadmin/awgcron\n"; }

	if(!open(CRONFILE,">tradeadmin/awgcron_2.sh")) 
		{ die ("Fatal Error, cannot open tradeadmin/awgcron_2.sh for writing, this is required for proper operation.\n\n");}
	print CRONFILE "cd $fullpath/tradeadmin\n";
	print CRONFILE "$fullpath/tradeadmin/awgcron\n";
	close CRONFILE;
	
	if(!chmod(0400,"tradeadmin/cntreset"))
		{ print "Warning: Unable to disable cntreset from version 1.\n"; }
	if(!chmod(0400,"tradeadmin/toplist"))
		{ print "Warning: Unable to disable toplist from version 1.\n"; }
	if(!chmod(0755,"tradeadmin/awgcron_2.sh"))
		{ print "Warning: Unable to chmod awgcron.sh, this may cause script to work incorrectly.\n\n"; }
	&updatecron("*/2 * * * *  ","$fullpath/tradeadmin/awgcron_2.sh");

	print "\nUpgrade Complete!\n";
	print "Make sure to read update notes at awgtrade.com for other necessary system changes.\n";
	exit 0;
	}

if(!chmod(0777,"data"))
	{ print "Warning: Unable to chmod data dir, this may cause script to function incorrectly.\n\n"; }

if(!open(CHECK,"tradeadmin/trade.dat")) {
	close CHECK;
if(!open(CREAT,">tradeadmin/trade.dat")) {
	die ("Fatal error, cannot create tradeadmin/trade.dat.");
}
close(CREAT);
}
else { close CHECK; }

if(!open(CHECK,"tradeadmin/cntr.dat")) {
if(!open(CREAT,">tradeadmin/cntr.dat")) {
	die ("Fatal error, cannot create tradeadmin/cntr.dat.");
}
close CREAT;
}
else {close CHECK; }

if(!open(CHECK,"rules.txt")) {
if(!open(CREAT,">rules.txt")) {
	die ("Fatal error, cannot create rules.txt.");
} close CREAT;
}
else { close CHECK; }

if(!open(CHECK,"tradeadmin/banned.txt")) {
if(!open(CREAT,">tradeadmin/banned.txt")) {
	die ("Fatal error, cannot create rules.txt.");
} close CREAT;
}
else { close CHECK; }

if(!open(CHECK,"tradeadmin/toplist.txt")) {
if(!open(CREAT,">tradeadmin/toplist.txt")) {
	die ("Fatal error, cannot create toplist.txt.");
} 
close CREAT;
}
else { close CHECK; }


@xfilelist = ("out.cgi","signup.cgi","tradecnt.cgi","tradeadmin/tradeadmin.cgi","tradeadmin/trades.cgi","toplist","tradeadmin/awgcron");
@datfilelist = ("tradeadmin/trade.dat","tradeadmin/cntr.dat","tradeadmin/outc.dat","tradeadmin/banned.txt","rules.txt","tradeadmin/toplist.txt");

if(!chmod(0755,@xfilelist))
	{ print "Warning: Unable to chmod executable files, this may cause script to work incorrectly.\n\n"; }
if(!chmod(0666,@datfilelist))
	{ print "Warning: Unable to chmod data files, this may cause script to work incorrectly.\n\n"; }

if(!open(HTACCESS,">tradeadmin/.htaccess")) {
	die ("Fatal Error, cannot open tradeadmin/.htaccess for writing, this is bad as you will not be able to password protect your admin.\n\nInstall Not Complete!\n\n"); }

if(!open(HTPASSWD,">tradeadmin/.awghtpasswd")) {
	die ("Fatal Error, cannot open tradeadmin/.awghtpasswd for writing, this is bad as you will not be able to password protect your admin.\n\nInstall Not Complete!\n\n");
}

print HTACCESS "AuthUserFile $fullpath/tradeadmin/.awghtpasswd\n";
print HTACCESS "AuthType basic\nAuthName \"awgTrade Admin\"\n";
print HTACCESS "\nrequire valid-user\n";

close HTACCESS;

redopassword:
print "Set your admin password \n";
print "-----------------------\n";
print "(Letters typed will not be printed)\n";
print "Enter admin password: ";
system ("stty -echo");

$password1 = <STDIN>;
chop($password1);

system ("stty echo");

print "\nRe-enter admin password: ";
system ("stty -echo");

$password2 = <STDIN>;
chop($password2);

system ("stty echo");
if($password1 ne $password2) { print "Did not match, reenter...\n\n"; goto redopassword; }

# crypt and write */
srand($$|time);
@saltchars = (a..z,A..Z,0..9,'.','/');
$salt = $saltchars[int(rand($#saltchars+1))];
$salt .= $saltchars[int(rand($#saltchars+1))];

$cryptedpassword = crypt ($password1,$salt);

print HTPASSWD "awgadmin:$cryptedpassword\n";
close HTPASSWD;

if(!chmod(0666,"tradeadmin/.awghtpasswd"))
	{ print "\nWarning: Unable to chmod password file, you will be unable to change\nyour password via the web.\n\n"; }

if(!open(CRONFILE,">tradeadmin/awgcron_2.sh")) {
	die ("Fatal Error, cannot open tradeadmin/awgcron_2.sh for writing, this is required for proper operation.\n\n");
}

print CRONFILE "cd $fullpath/tradeadmin\n";
print CRONFILE "$fullpath/tradeadmin/awgcron\n";
close CRONFILE;

if(!chmod(0755,"tradeadmin/awgcron_2.sh"))
	{ print "Warning: Unable to chmod awgcron.sh, this may cause script to work incorrectly.\n\n"; }
&updatecron("*/2 * * * *  ","$fullpath/tradeadmin/awgcron_2.sh");

print "\n\n";
print "--------------------------------------------\n";
print "|     All Finished! Now for Web Setup      |\n";
print "--------------------------------------------\n\n";

print "1) Go to trades.cgi which is in the tradeadmin directory.  \n   From your cgi-bin, the proper path would be:\n";
print "   http://www.yourdomain.com/cgi-bin/awgtrade/tradeadmin/trades.cgi\n";
print "   IMPORTANT: Username is always \'awgadmin\'.\n";
print "   Follow directions to configure your site.\n\n";
print "2) Go to AWGtrade forums and let us know you are installed to help get some trades!\n";
print "\n   Thanks for Installing!  \nEnjoy! And please keep us posted of any problems or suggestions.\n";

exit 0;

sub updatecron {
my($wstring, $cstring) = @_;
$currentcron = `crontab -l`;
$currentcron =~ s/# DO NOT EDIT THIS FILE.*\n//;
$currentcron =~ s/# \(.*installed on.*\n//;
$currentcron =~ s/# \(Cron version.*\n//;
if($currentcron !~ /$cstring/) {
if(!open(PCRON,"|crontab -"))
	{ print "WARNING: Unable to modify your crontab, make sure you have access to modify your crontab, script cannot function without it.\n"; 
	print "All other setups were completed, have host install proper crons.";
	exit 1; }

print PCRON $currentcron;
print PCRON "#Added by AWGtrade\n";
print PCRON "$wstring $cstring\n";
close PCRON;
}

}
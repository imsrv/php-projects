#!/usr/bin/perl

###################################
# Convert dbm to text files       #
###################################

$|=1;
print "Content-type: text/html\n\n ";
print "<HTML><HEAD></HEAD><BODY><PRE>\n";

require "variables.pl";

@char_set = ('a'..'z','0'..'9');

use Fcntl;
use AnyDBM_File;
use Config;

unless (-e "$path") {
	   print "$path does not exist..... ";
	   exit;
}

## Make members dir... ##
unless (-e "$path/members") {
	   mkdir ("$path/members",0777) || &error("creating members dir");
	   print "Members dir created.....\n";
}
else {
	 chmod (0777,"$path/members") || &error("Chmod members");
	 print "Members dir already present....\n";
}

## Make base dir account holder... accounts ##
unless (-e "$path/members/accounts") {
	   mkdir ("$path/members/accounts",0777) || &error("creating members/accounts dir");
	   chmod (0777,"$path/members/accounts") || &error("Chmod members/accounts");
	   print "Accounts dir created.....\n";
}
else {
	 chmod (0777,"$path/members/accounts") || &error("Chmod members/accounts");
	 print "Accounts dir already present....\n";
}
	&sudirs("$path/members/accounts");


print "\nCreating Category Directories....\n\n";
## Sort though Categories ##
$flags = O_CREAT | O_RDWR;
$db = "$path/cata";
tie(%new, 'AnyDBM_File', $db , $flags, 0777) || &error("Cannot open database-- $db");
while ( ($key, $value) = each( %new) ) {


	@values = split(/\|/,$value);
	$cata_array[$numcata] = "$key\%\%$value|\n";
	unless (-e "$path/members/$key") {
		   mkdir ("$path/members/$key",0777) || &error("creating members/$key dir");
		   chmod (0777,"$path/members/$key") || &error("Chmod members/$key");
	   	   print "$key dir created.....\n";	   
	}
	else {
		 print "$key dir already present....\n";
	   chmod (0777,"$path/members/$key") || &error("Chmod members/$key");
	}
	&sudirs("$path/members/$key");
	$numcata ++;
}
	
print "Creation of $numcata categories complete....\n";

open(LIST,">$path/categories.txt") || &error("Can't make $path/categories.txt");
print LIST @cata_array;
close(LIST);

print "Creation complete of category data file - catergories.txt...\n\n";
print "Time to convert the members themselves.....\n\n";

print "<B>accounts</B>\n";
$flags = O_CREAT | O_RDWR;
$db = "$path/accounts";
tie(%acc, 'AnyDBM_File', $db , $flags, 0666);
while ( ($key, $value) = each( %acc) ) {
	@acco = split(/\|/,$value);
	@cc = split(//,$key);

	open(LIST,">$path/members/accounts/$cc[0]/$key.dat") || &error("Can't make accounts/$cc[0]/$key.dat");
	foreach $accline(@acco) {
			print LIST "$accline\n";
	}
	close(LIST);
	$num_acc++;
	
	print "      $num_acc... $cc[0]... <B>$key</B> converted...\n";
	
}

## Sort though Categories ##
$flags = O_CREAT | O_RDWR;
$db = "$path/cata";
tie(%new, 'AnyDBM_File', $db , $flags, 0777) || &error("Cannot open database-- $db");
while ( ($keys, $values) = each( %new) ) {

print "<B>$keys</B>\n";

$flags = O_CREAT | O_RDWR;
$db = "$path/$keys";
tie(%acc, 'AnyDBM_File', $db , $flags, 0666);
while ( ($key, $value) = each( %acc) ) {
	@acco = split(/\|/,$value);
	@cc = split(//,$key);

	open(LIST,">$path/members/$keys/$cc[0]/$key.dat") || &error("Can't make $key/$cc[0]/$key.dat");
	foreach $accline(@acco) {
			print LIST "$accline\n";
	}
	close(LIST);
	$num_acc++;
	
	print "      $num_acc... $cc[0]... <B>$key</B> converted...\n";
	
}

}








print "\nConversion of all $num_acc accounts complete.....\n\n";
	
sub sudirs {
$dir = $_[0];

foreach $ch(@char_set) {
	mkdir ("$dir/$ch",0777) || &error("creating $dir/$ch dir");
	chmod (0777,"$dir/$ch") || &error("Chmod $dir/$ch");
	print "$ch.";	 
}	
print "\n\n";
}
	
sub error {
$err = $_[0];
if ($! =~ /exist/) { return; }
else {
print "\n\nFatal error $err -- $! -- QUITING....\n</PRE>";
exit;
}
}

#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Members Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
use vars qw(%config);
use CGI::Carp qw(fatalsToBrowser);
undef %config;
local %config = ();
do "${path}config/config.cgi";
if ($config{'modperl'} == 1) {
	eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
}
my $file_ext = "$config{'extension'}";
if ($file_ext eq "") { $file_ext = "cgi"; }
if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
else { do "${path}functions_text.$file_ext"; }
do "${path}functions.$file_ext";
&main_functions::checkpath('excel', $path);
###############################################



###############################################
my $SAVE_DIRECTORY = "template/";
my (%FORM, $Filename, $File_Handle, $newfile);
use CGI;
my $query = new CGI;
foreach my $param ($query->param) {
	$FORM{$param} = $query->param($param);	
}

my ($keyarr, $error);
$| = 1;
chop $SAVE_DIRECTORY if ($SAVE_DIRECTORY =~ /\/$/);
if ($query->param('file') =~ /([^\/\\]+)$/) {
	$Filename = $1;
	$Filename =~ s/^\.+//;
	$File_Handle = $query->param('file');
} else {
	$error .= "You attempted to upload a file that isn't properly formatted.  Please Rename the file and try uploading it again.";
}
		
$Filename = &strip_dos($Filename);
my @split = split(/\./, $Filename);
my $num = @split-1;
my $ext = $split[$num];
for (1 .. $num) {
	$newfile .= "$split[$a]";
	$a++;
}

if (-e "$SAVE_DIRECTORY\/$newfile\.$ext") {
	while (-e "$SAVE_DIRECTORY\/$newfile\.$ext") {
		$newfile = rand($newfile);
		$newfile =~ s/\.//g;
	}
}

if (!open(OUTFILE, ">$SAVE_DIRECTORY\/$newfile\.$ext")) {
	$error .= "There was an error opening the file";
}
		
if ($config{'server'} eq "nt") {
	 binmode(OUTFILE); 
}
{ next; }

my ($BytesRead, $Buffer, @Files_Written, %Confirmation);
while (my $Bytes = read($File_Handle,$Buffer,1024)) {
	$BytesRead += $Bytes;
	print OUTFILE $Buffer;
}

push(@Files_Written, "${SAVE_DIRECTORY}$Filename");
my $TOTAL_BYTES += $BytesRead;
$Confirmation{$File_Handle} = $BytesRead;

close($File_Handle);
close(OUTFILE);

my $FILES_UPLOADED = scalar(keys(%Confirmation));
my $file = "$SAVE_DIRECTORY\/$newfile\.$ext";
my @site = &database_functions::GetSites($FORM{'user'});

eval("use Spreadsheet::ParseExcel"); if ($@) { die "The Spreadsheet::ParseExcel module used for excel uploads appears to not be installed"; }
my $oExcel = new Spreadsheet::ParseExcel; 
my $oBook = $oExcel->Parse($file);
my($iR, $iC, $oWkS, $oWkC, @bulk);
$oWkS = $oBook->{Worksheet}[0];
my $t = -1;
for (my $iR = $oWkS->{MinRow} ; defined $oWkS->{MaxRow} && $iR <= $oWkS->{MaxRow} ; $iR++) {
	my $keyword = "keyword$iR";
	my $title = "title$iR";
	my $description = "description$iR";
	my $url = "url$iR";
	my $bid = "bid$iR";
	for(my $iC = $oWkS->{MinCol} ; defined $oWkS->{MaxCol} && $iC <= $oWkS->{MaxCol} ; $iC++) {
		$oWkC = $oWkS->{Cells}[$iR][$iC];
		unless ($iR == 0) {
			if ($iC == 0) { $FORM{$keyword} = $oWkC->Value; }
			elsif ($iC == 1) { $FORM{$url} = $oWkC->Value; }
			elsif ($iC == 2) { $FORM{$title} = $oWkC->Value; }
			elsif ($iC == 3) { $FORM{$description} = $oWkC->Value; }
			elsif ($iC == 4) { $FORM{$bid} = $oWkC->Value; }
		}
	}
	my @arr = split(/\|/, $keyarr);
	foreach my $line2(@arr) {
		chomp($line2);
		my @inner2 = split(/\-/, $line2);
		if ($inner2[0] eq $FORM{$keyword} && $inner2[1] eq $FORM{$url}) {
			$error .= "You have already used the keyword <B>$FORM{$keyword}</B> with the domain <B>$FORM{$url}</B><BR>";
		}
	}
	$keyarr .= "$FORM{$keyword}-$FORM{$url}|";
	foreach my $line3(@site) {
		chomp($line3);
		my @inner2 = split(/\|/, $line3);
		if ($inner2[0] eq $FORM{$keyword} && $inner2[3] eq $FORM{$url}) {
			$error .= "You have already used the keyword <B>$FORM{$keyword}</B> with the domain <B>$FORM{$url}</B><BR>";
		}
	}
	$t++;
}

if ($error) {
	unlink("$SAVE_DIRECTORY\/$newfile\.$ext");
	$error = "Please push 'back' to correct the following errors:<BR>$error";
	&message($error);
	&main_functions::exit;
}
&database_functions::bulk_upload($FORM{'user'}, %FORM);
unlink("$SAVE_DIRECTORY\/$newfile\.$ext");
my $message = "Listing(s) Submitted";
&message($message);
&main_functions::exit;
###############################################


###############################################
sub message {
my ($message) = @_;
open (FILE, "${path}template/message.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/<\!-- \[message\] -->/$message/ig;
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$FORM{'user'}/ig;
$temp =~ s/\[pass\]/$FORM{'pass'}/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################

###############################################
sub strip_dos {
	my $current_file = shift;
	$current_file =~ s/.+\\//g; ##remove windows/dos file name paths
	$current_file =~ s/%[\w\d][\w\d]/_/g;
	$current_file =~ s/%[\w\d]/_/g;
	$current_file =~ s/[^a-zA-Z\d_\-\.]/_/g;
	return $current_file;
}
###############################################
#!/usr/local/bin/perl
##########################################
require "setup35.cgi";
##########################################

$slash = ($nt eq 'no') ? '/' : '\\';

$string = $ENV{'QUERY_STRING'};

($picname, $ID) = split(/&/, $string);

&get_pass($ID);

if($ENV{'CONTENT_LENGTH'} > $max_size) {
	print "Content-Type: text/html\n\n";
	print "<html><head>\n<title>Error</title>\n";
	print "$header<h1><center>Your file is too large.</center></h1><hr>\n";
	print " The maximum file size is $max_size. Use your browser's [Back] button to return to the form, and choose a
	smaller file.\n";
	print "$footer\n";
	exit;
}

$directory = "$html_path${slash}pics";
$tempdir = "$html_path${slash}tmp";

@binaries = &listdir($directory,'binary');

$isfile = 'no';
for $file(@binaries) {
	if($file =~ /$picname\./) {
		unlink ("$directory$slash$file");
		$isfile = 'yes';
	}
}


$| = 1;

$buffer="";
binmode(STDIN);
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

$tempfile = "$ENV{'REMOTE_ADDR'}";
$tempfile =~ s/\W+/_/g;
$tempfile .= ".txt";


open(FILE,">$tempdir$slash$tempfile") || &Error("Could not create $tempdir$slash$tempfile");
binmode(FILE);
print FILE $buffer;
close(FILE);


$len = length($buffer);
$buffer="";

open(FILE,"$tempdir$slash$tempfile") || &Error("Could not read $tempdir/$ENV{'REMOTE_HOST'}.txt");
binmode(FILE);
@contents=<FILE>;
close(FILE);

unlink("$tempdir$slash$tempfile");

$scrap = $contents[0];
$scrap =~ s/(-)+//g;
$scrap =~ s/\n//g;
$scrap =~ s/\r//g;

$stuff='Content-Disposition: form-data; name="uploaded_file"; filename="';
foreach $line (@contents)
{
	if($line =~ /$stuff/)
	{
		$getfilename=$line;
		$getfilename =~ s/$stuff//g;
		$getfilename =~ s/\"//g;
	}
}

if($getfilename =~ /[\\\/\:]/) {
	$fname = $getfilename;		#ignore stuff before last backslash for NT
	@a=split(/\\/,$fname);
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\//,$fname);		#ignore stuff before last forwardslash for Unix
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\:/,$fname);		#ignore stuff before last ":" for Macs?
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\"/,$fname);		#now we've got the real filename
	$filename=$a[0];
}else {
	$filename=$getfilename;
}

$filename =~ s/\s//g;

if($filename eq "") {
	if($isfile eq 'yes') {
		print "Content-Type: text/html\n\n";
		print "<html><head>\n<title>Picture Deleted</title>\n";
		print "$header<h1><center>Your picture has been removed from your profile.</center></h1><hr>\n";
		print "Please close this window to return to e_Match.\n";
		print "$footer\n";
		exit;
	}else {
		print "Content-Type: text/html\n\n";
		print "<html><head>\n<title>Error!</title>\n";
		print "<link rel=STYLESHEET type=\"text/css\" href=\"$main_url/html/style.css\"></head>$body\n";
		print "$banner<h1><center>You did not provide a file to be
		uploaded.</center></h1><hr>\n";
		print "Please close this window to return to e_Match.\n";
		print "$footer\n";
		exit;
	}
}

($ext = $filename) =~ s/.+(\.\w\w\w\w?)$/$1/;
$ext = lc($ext);

$filename = "$picname$ext";

$write_file = "$directory$slash$filename";

if($write_file !~ /(\.jpg)|(\.jpeg)|(\.gif)$/i) {
	$Problem = "You have attempted to load a file that does not match an acceptable
	image files format. \"$filename\"";
	&Error($Problem);
}

open(REAL,">$write_file") || &Error("Can't write to $write_file");

binmode REAL;
$tot=@contents;
for($i=0;$i<$tot;++$i) {
	if($contents[$i] =~ /$scrap/ | $contents[$i] =~ /Content\-Disposition/ | $contents[$i] =~ /Content\-Type\:/ | $contents[$i] =~ /$directory/ | $contents[$i] =~ /filename\=/) {
		$j=$i;
		++$j;
		$contents[$j] = "NOTHINGNOTHINGNOTHING";
	}elsif($contents[$i] =~ /NOTHINGNOTHINGNOTHING/) {
	}else {
		print REAL "$contents[$i]";
	}
}
close(REAL);


#chmod(0777, "$directory$slash$filename") if $nt ne 'yes';


open(FILE, $write_file);
$len = (stat($write_file))[7];
close(FILE);
if ($len eq "0") {
if(unlink("$write_file")) {
$unlinked = 1;
} else {
$unlinked = 0;
}
    $Problem = "the image file was not transferred properly.<P>" .
"The saved image file was found to be empty.";
if($unlinked) {
	$Problem .= "The temporary file was erased.";
} else {
	$Problem .= "You now have to manually check to ensure<BR>";
	$Problem .= "the temporary file<P>$write_file<P>was erased.";
}
&Error($Problem);
}

$text = ($isfile eq 'yes') ? 'replaced' : 'uploaded';

print "Content-Type: text/html\n\n";
print "<html><head>\n<title>Upload</title>\n";
print "$header\n";
print "<h1><center>Your picture has been $text.</center></h1><hr>\n";
print "It will appear on your profile page when you click [Reload].  Please close this window to return to
e_Match.\n";
print "$footer\n";
exit;

##########################################################
# Subs

sub Error {
	$problem = shift(@_);

	print "Content-Type: text/html\n\n";
	print "<html>\n<title>Error!</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "$problem\n";
	print "</body></html>\n";
	exit;
}

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

sub get_pass {

	#given ID, returns password

	my($ID) = @_;
	my($line, @lines);
	open(IDS,"$logpath/id.txt") || &return_page('System Error', "Can't read.(2400)\n");
	@lines = <IDS>;
	close(IDS);
	chomp(@lines);

	foreach $line (@lines) {
		($this_ID, $this_password) = split(/\t/, $line);
		return ($this_password) if $this_ID eq $ID;
	}
	&return_page("ID not found.", "Your ID was not found.  Return to <a href=$ENV{'SCRIPT_NAME'}>HERE</a> to log on.");
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

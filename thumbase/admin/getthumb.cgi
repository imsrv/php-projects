#!/usr/bin/perl

&getquery;
use Image::Magick;
use DBI;
open(D,"DBDETAILS");
while (<D>) {
 	  chomp;
	  s/\$//g;
	  s/;//g;
	  s/\"//g;
	  s/#.*//;
	  s/^\s+//;
	  s/\s+$//;
	  next unless length;
	  next if ($_ =~ /<\?/);
	  my ($var,$value) = split(/\s*=\s*/, $_, 2);
	  $var_name = $var;
	  $var_value = $value;
	  eval '$$var_name = $var_value;';	  
}
close(D);
## get the user settings
$connect = &dbconnect;
my $sql = &querydb($connect,"SELECT * FROM settings WHERE settingID='1';");
my %FIELDS = &returnFieldNames($sql);
my @row = $sql->fetchrow;
foreach (keys %FIELDS) {
	$ss{$_} = @row[$FIELDS{$_}];
}
$sql->finish;
$thumbdir = $ss{'thumbsDirectory'};
if ($thumbdir eq "") {
	$thumbdir = "../thumbs";
}

print "Content-type: text/html\n\n";
print "<HTML><HEAD>";
$url = $FORM{'url'};
## get the path of the damn gallery so that we can get the right damn file ;)
use LWP::Simple;
use LWP::UserAgent;
use HTTP::Request;
use HTTP::Response;
use HTTP::Headers;

($good,$crap) = split(/\?/,$url);
(@parts) = split(/\//,$good);
if (@parts[$#parts] =~ /\./) {
	$a=0;foreach (@parts) { if ($a < $#parts) { $root .= "$_/"; }$a++; }
	$root = substr($root,0,length($root)-1);
} else {
	$root = $good;
}

my $ua = LWP::UserAgent->new();
$ua->agent("Mozilla/4.04 [en] (Win2K; I ;Nav)");
$ua->timeout(30);
my $req = HTTP::Request->new(GET => $url);
$req->referer($url);
my $response = $ua->request($req);
$content = $response->content;
if ($content ne "") {
	$content =~ s/<a([A-Za-z0-9\-\_\s]*)href=[\"\']*([0-9A-Za-z\-\_\.\/\:]+)\.(jpg|jpeg|jpe)[\"\']*([A-Za-z0-9\-\_\s]*)>/push(@images,"$2.$3");/misegx;
	srand();
	$image = @images[int(rand($#images+1))];

	if ($image !~ /^http\:/) {
		if ($image =~ /^\//) {
			## if it wants the crazzy / then just give the root of domain
			## get first part
			$url =~ /(http\:\/\/)*([A-Za-z\-\.]+)\//;
			(@parts) = split(/\//,$url);
			if ($url =~ /^http\:/) {
				$imageurl = "@parts[0]/@parts[1]/@parts[2]/$image";
			} else {
				$imageurl = "http://@parts[0]/$image";
			}
		}
		elsif ($image =~ /^\.\.\//) {
			@bits = split(/\.\.\//,$image);
			$path = @bits[$#bits];
			## if it has http:// remove it !!
			$tempurl = $url;
			if ($tempurl =~ /^http\:\/\//) {
				$tempurl = substr($tempurl,7,length($tempurl));
			}
			(@parts) = split(/\//,$tempurl);
			$count = 0;
			foreach (@parts) {
				if ($count < ($#parts-($#bits+1))) {
					$newurl .= "$_/";
				}
				$count ++;
			}		
			$imageurl = "http://$newurl/$image";
		} else {
			$imageurl = "$root/$image";
		}
	} else {
		$imageurl = $image;
	}
	(@parts) = split(/\./,$imageurl);
	$file = "$thumbdir/thumb$FORM{'thumbID'}.@parts[$#parts]";
	my $req = HTTP::Request->new(GET => $imageurl);
	$req->referer($url);
	my $response = $ua->request($req);
	$content = $response->content;
	open(D,">$file");
	binmode(D);
	print D $content;
	while($bytesread=read($content,$data,1024)){
	   print D $data; 
	} 
	close(D);
	chmod(0777,"$file");
	if ($FORM{'thumbQuality'}==0) {
		$FORM{'thumbQuality'}=100;
		$FORM{'thumbWidth'}=100;
		$FORM{'thumbHeight'}=100;
	}
	$image = Image::Magick->new;
	$image->Read($file);
	$image->Set(quality=>$quality);
	($a, $b) = $image->Get('width','height');
} else {
	$error=1;
}

if (($a>0)&&($b>0)&&($error==0)) {
	$file2 = "$thumbdir/sthumb$FORM{'thumbID'}.@parts[$#parts]";
	&writesquareimage("$file","$file2",$FORM{'thumbQuality'},$FORM{'thumbWidth'},$FORM{'thumbHeight'},0,0,0);
	if ($FORM{'thumbQuality2'}!=0) {
		&writesquareimage("$file","$file2.jpg",$FORM{'thumbQuality2'},$FORM{'thumbWidth2'},$FORM{'thumbHeight2'},0,0,0);
	}
	if ($FORM{'thumbQuality3'}!=0) {
		&writesquareimage("$file","$file2.jpg.jpg",$FORM{'thumbQuality3'},$FORM{'thumbWidth3'},$FORM{'thumbHeight3'},0,0,0);
	}
	my $sql = &querydb($connect,"UPDATE thumbs Set fileName='sthumb$FORM{'thumbID'}.jpg',active='1' WHERE thumbID='$FORM{'thumbID'}';"); 
	$sql->finish;
	unlink($file);
	$where = $FORM{'where'};
	if (length($where) <2) {
		$where = "p=gallerys";
	}
	print <<"EOF";
	Getting Image from: $url.
	<BR>
	Found suitable image.  Retrieving image: $imageurl<BR>
	<META HTTP-EQUIV="refresh" CONTENT="0;URL=admin.cgi?$where">
	</HEAD>
	<BODY>
	</HTML>
EOF
		;
} else {
	my $sql = &querydb($connect,"DELETE FROM thumbs WHERE thumbID='$FORM{'thumbID'}';"); 
	$sql->finish;
	my $sql = &querydb($connect,"INSERT INTO badthumbs (galleryURL) VALUES ('$url');"); 
	$sql->finish;
	$where = $FORM{'where'};
	if (length($where) <2) {
		$where = "p=gallerys";
	}
	print <<"EOF";
	Getting Image from: $url.
	<BR>
	No suitable thumb found, moving on.<BR>
	<META HTTP-EQUIV="refresh" CONTENT="0;URL=admin.cgi?$where">
	</HEAD>
	<BODY>
	</HTML>
EOF
		;
}
$connect->disconnect;

sub getquery {
		if ($ENV{'REQUEST_METHOD'} eq "GET") { 
			$querystring = $ENV{'QUERY_STRING'};
		} else { 
			read(STDIN, $querystring, $ENV{'CONTENT_LENGTH'}); 
		}
		@pairs = split(/&/, $querystring);
		foreach $pair (@pairs) 
		{
		 ($name, $value) = split(/=/, $pair);
		 $value =~ tr/+/ /;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $name =~ tr/+/ /;
		 $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/'/\\'/g;
		 if (exists($FORM{$name})) { $FORM{$name} = $FORM{$name} . "," . $value; } else { $FORM{$name} = $value; }
		 $EFORM{$name} = &encode($value);
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $UFORM{$name} = $value;
		}
	}
sub encode {
        my($toencode) = @_;
        $toencode=~s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
        return $toencode;
}

sub writesquareimage
{
	($from,$to,$quality,$w,$h,$borderSize,$borderColor,$raiseBorderSize) = (@_);
	$image = Image::Magick->new;
	$image->Read($from);
	$image->Set(quality=>$quality);
	($a, $b) = $image->Get('width','height');
	# if the $w or $h = 0 then keep original size :D :D	
	## work out the size which will be required for the height
	if ($b > $a) {
		$size = $w . "x" . $b;
		$image->Resize(geometry=>$size);
		($a, $b) = $image->Get('width','height');
		$extraheight = $b - $h;
		$perside = int ( $extraheight / 2 ) ;
		$image->Chop(geometry=>"0X$perside");
		$image->Rotate(degrees=>"180");
		$image->Chop(geometry=>"0X$perside");
		$image->Rotate(degrees=>"180");
	}
	if ($a >$b) {
		$size = $a . "x" . $h;
		$image->Resize(geometry=>$size);
		($a, $b) = $image->Get('width','height');
		$extrawidth = $a - $w;
		$perside = int ( $extrawidth / 2 ) ;
		$amount = $perside . "X0";
		$image->Chop(geometry=>$amount);
		$image->Rotate(degrees=>"180");
		$image->Chop(geometry=>$amount);
		$image->Rotate(degrees=>"180");
	}
	$compression = "JPEG";
	$image->Write(filename=>$to, compression=>$compression);
	chmod(0777,$to);
}

sub dbconnect
{
	my $where = "DBI:mysql:$dbname:$dbhost";
	my $connection = DBI->connect($where,$dbusername,$dbpassword);
	return $connection;
}

sub querydb
{
	my $connection = shift;
	my $sql=shift;
	my $sqlquery = $connection->prepare($sql);
	$sqlquery->execute;
	return $sqlquery;
}

sub fieldnames
{
	my $sqlquery =shift;
	@fields = @{$sqlquery->{NAME}};
	return @fields;
}

sub returnFieldNames
{
	my $sqlquery = shift;
	@fieldnames = &fieldnames($sqlquery);$a=0;
	my %FIELDS;
	foreach (@fieldnames)
	{$FIELDS{$_} = $a;$a++; }
	return %FIELDS;
}

sub disconnect
{
	my $connect = shift;
	$connect->disconnect;
}


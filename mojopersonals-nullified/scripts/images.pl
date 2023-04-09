############################################################
sub Thumbnail{
	my ($ext, $name, %PHOTO, $parent, $x, $y);
	my($filename, $width, $height) = @_;
	
	($name, $ext) = &NameAndExt($filename);
	$parent = &ParentDirectory($filename);
	if(-f "$CONFIG{script_path}/scripts/imagemagick.pl"){
		require "imagemagick.pl";
		&CreateThumbnail($filename, $CONFIG{media_height},$CONFIG{media_height});
		$PHOTO{thumbnail} = "mojoscripts_$name.$ext";
	}
	elsif(-f "$CONFIG{script_path}/scripts/gd.pl"){
		require "gd.pl";
		&CreateThumbnail($filename, $CONFIG{media_height},$CONFIG{media_height});
		$PHOTO{thumbnail} = "mojoscripts_$name.$ext";
	}
	else{
		($x, $y) = &ImageSize($filename);
	}
	$PHOTO{width}=  $x?$x:$width;
	$PHOTO{height}= $y?$y:$height;
	return wantarray?%PHOTO:\%PHOTO;
}
############################################################
#  PNG 89 50 4e 47
#  GIF 47 49 46 38
#  JPG ff d8 ff e0
#  XBM 23 64 65 66
sub ImageSize {
	my($file, $x, $y);
	($file)= @_;
	open(FILE, "<$file") or return (0,0);
	binmode(FILE);
	if ($file =~ /jpe?g$/i){	($x,$y) = &jpegsize(\*FILE);    	}
	elsif($file =~ /\.gif$/i){	($x,$y) = &gifsize(\*FILE);;    	}
	elsif($file =~ /\.xbm$/i){	($x,$y) = &xbmsize(\*FILE);		}
	elsif($file =~ /\.png$/i) {($x,$y) = &pngsize(\*FILE);	   }
	close(FILE);
	return ($x,$y);
}
############################################################
sub gifsize {
	my($GIF) = @_;
	my($type,$a,$b,$c,$d,$s)=(0,0,0,0,0,0);
	if(defined($GIF)	&& read($GIF, $type, 6)	&&  $type =~ /GIF8[7,9]a/	&&  read($GIF, $s, 4) == 4	){
		($a,$b,$c,$d)=unpack("C"x4,$s);
		return ($b<<8|$a,$d<<8|$c);
	}
   return (0,0);
}
############################################################
sub xbmsize {
	my($XBM) = @_;
	my($input)="";
	if( defined( $XBM ) ){
		$input .= <$XBM>;
		$input .= <$XBM>;
		$input .= <$XBM>;
		$_ = $input;
		if( /.define\s+\S+\s+(\d+)\s*\n.define\s+\S+\s+(\d+)\s*\n/i ){
			return ($1,$2);
		}
	}
	return (0,0);
}
############################################################
sub pngsize {
  my($PNG) = @_;
  my($a, $b, $c, $d, $e, $f, $g, $h, $head);

  if(defined($PNG) && read( $PNG, $head, 8 ) == 8 &&
     $head eq "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a" &&
     read($PNG, $head, 4) == 4			&&
     read($PNG, $head, 4) == 4			&&
     $head eq "IHDR"				&&
     read($PNG, $head, 8) == 8 			){
#   ($x,$y)=unpack("I"x2,$head);   # doesn't work on little-endian machines
#   return ($x,$y);
    ($a,$b,$c,$d,$e,$f,$g,$h)=unpack("C"x8,$head);
    return ($a<<24|$b<<16|$c<<8|$d, $e<<24|$f<<16|$g<<8|$h);
  }
  return (0,0);
}
############################################################
sub jpegsize {
	my($JPEG) = @_;
	my($a,$b,$c,$d, $c1,$c2,$ch,$s,$done, $length, $dummy);
	if(defined($JPEG)	&& read($JPEG, $c1, 1) && read($JPEG, $c2, 1)	&&
     ord($c1) == 0xFF && ord($c2) == 0xD8		){
	  	while (ord($ch) != 0xDA && !$done) {
###Find next marker (JPEG markers begin with 0xFF)
###This can hang the program so better put up a limit!!
			while (ord($ch) != 0xFF and $count< 2000 and $count++) { return(0,0) unless read($JPEG, $ch, 1); }
###JPEG markers can be padded with unlimited 0xFF's
      	while (ord($ch) == 0xFF and $count< 2000 and $count++) { return(0,0) unless read($JPEG, $ch, 1); }
###Now, $ch contains the value of the marker.
      	if ((ord($ch) >= 0xC0) && (ord($ch) <= 0xC3)) {
				return(0,0) unless read ($JPEG, $dummy, 3);
				return(0,0) unless read($JPEG, $s, 4);
				($a,$b,$c,$d)=unpack("C"x4,$s);
				return ($c<<8|$d, $a<<8|$b );
      	}
			else {
### We **MUST** skip variables, since FF's within variable names are
### NOT valid JPEG markers
				return(0,0) unless read ($JPEG, $s, 2);
				($c1, $c2) = unpack("C"x2,$s);
				$length = $c1<<8|$c2;
				last if (!defined($length) || $length < 2);
				read($JPEG, $dummy, $length-2);
			}
		}
  }
  return (0,0);
}
############################################################

1;
#!/usr/bin/perl

## NEITHER THIS SCRIPT NOR PORTIONS OF IT MAY BE DISTRUBUTED, RESOLD OR MADE PUBLICLY AVAILABLE
## IN ANY WAY, COMMERCIALLY OR OTHERWISE WITHOUT THE APPROVAL OF UPDN NETWORK SDN BHD
## (WWW.UPOINT.NET). ALL RIGHTS RESERVED. THE COPYRIGHT LAW PROVIDES US UP TO US$100,000.00 IN
## DAMAGES FROM AN INFRINGEMENT.


# Create a folder called "docpublisher" (chmod to 777) and upload this script to it.
# Remember to chmod this script to 755.

## full PATH where all the generated *.htm's will live:
# EXAMPLE: $rootpath = "/home/kevin/public_html/docpublisher";
# Remember to chmod this folder to 777.
my $rootpath = "/home/upoint/www/docpublisher";

## equivalent URL:
# EXAMPLE: $rooturl = "http://localhost/~kevin/docpublisher";
my $rooturl = "http://www.upoint.net/docpublisher";

## PATH of the folder under $rootpath, where all the uploaded images will live:
# Remember to chmod the folder "images2" to 777.
# Note that the folder "images1" is used to stored the images of the skin whereas
# "images2" is used to store the uploaded images for the document.
my $imagepath = "$rootpath/images2";

## equivalent URL:
my $imageurl = "$rooturl/images2";

## password:
my $password = "upoint";

## set to type of skin: "xp", "cyber" or "env"
my $skin = 'env';

use CGI;
use File::Basename;
use File::Copy;
use Time::localtime;


my %params;
sub parse_form {
  my $buffer;
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  if (length($buffer) < 5) {
    $buffer = $ENV{QUERY_STRING};
  }
 
  my @pairs = split(/&/, $buffer);
  foreach $pair (@pairs) {
    my ($name, $value) = split(/=/, $pair);

    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/[\;\|\\ ]/ /ig;
    push(@values, $value); push(@names,$name);   
    $params{$name} = $value;
  }
}

&parse_form;
my $q = new CGI;
my $empty_q = new CGI("");


sub printLawrence {

  if ($skin eq 'cyber') {

    print <<EOF

<body bgcolor="#FFCC00">

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" width="95%">
    <tr>
      <td><img border="0" src="images1/cyber-bg_toplft.gif" width="75" height="80"></td>
      <td valign="top" background="images1/cyber-top_mid.gif"><img border="0" src="images1/cyber-title.gif"></td>
      <td><img border="0" src="images1/cyber-bg_toprt.gif" width="74" height="80"></td>
    </tr>
    <tr>
      <td background="images1/cyber-bg_lft.gif"><img border="0" src="images1/cyber-bg_lft.gif" width="75" height="20"></td>
      <td background="images1/cyber-bg_mid.gif" width="100%"><font face="verdana, arial" size="-1">
EOF

  }

elsif ($skin eq 'env'){

    print <<EOF

<body bgcolor="#FFCC00">

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" width="95%">
    <tr>
      <td><img border="0" src="images1/env-top-left.gif" width="20" height="32"></td>
      <td background="images1/env-top-mid.gif"><img border="0" src="images1/env-title.gif"></td>
      <td><img border="0" src="images1/env-top-right.gif" width="70" height="32"></td>
    </tr>
    <tr>
      <td background="images1/env-left.gif"><img border="0" src="images1/env-left.gif" width="20" height="10"></td>
      <td background="images1/env-centre.gif" width="100%"><font face="verdana, arial" size="-1">
EOF

  }

else {

    print <<EOF

<body bgcolor="#DDEDFD">

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" width="95%">
    <tr>
      <td><img border="0" src="images1/winxp-topleft.gif" width="43" height="47"></td>
      <td background="images1/winxp-top.gif"><img border="0" src="images1/winxp-title-d.gif"></td>
      <td><img border="0" src="images1/winxp-topright.gif" width="61" height="47"></td>
    </tr>
    <tr>
      <td background="images1/winxp-left.gif"><img border="0" src="images1/winxp-left.gif" width="43" height="57"></td>
      <td background="images1/winxp-center.gif" width="100%"><font face="verdana, arial" size="-1">
EOF

  }

}

sub endLawrence {
  
  if ($skin eq 'cyber') {

    print <<EOF
</font></td>
      <td background="images1/cyber-bg_rt.gif"><img border="0" src="images1/cyber-bg_rt.gif" width="74" height="20"></td>
    </tr>
    <tr>
      <td><img border="0" src="images1/cyber-bg_btmlft.gif" width="75" height="80"></td>
      <td valign="bottom" background="images1/cyber-mid_bottom.gif"><img border="0" src="images1/cyber-mid_bottom.gif" width="4" height="80"></td>
      <td><img border="0" src="images1/cyber-bg_btmrt.gif" width="74" height="80"></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
EOF

  } elsif ($skin eq 'env') {

    print <<EOF
</font></td>
      <td background="images1/env-right.gif"><img border="0" src="images1/env-right.gif" width="70" height="10"></td>
    </tr>
    <tr>
      <td><img border="0" src="images1/env-bot-left.gif" width="20" height="14"></td>
      <td background="images1/env-bot-mid.gif"><img border="0" src="images1/env-bot-mid.gif" width="10" height="14"></td>
      <td><img border="0" src="images1/env-bot-right.gif" width="70" height="14"></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
EOF

  }
else {

    print <<EOF
</font></td>
      <td background="images1/winxp-right.gif"><img border="0" src="images1/winxp-right.gif" width="61" height="57"></td>
    </tr>
    <tr>
      <td><img border="0" src="images1/winxp-botleft.gif" width="43" height="23"></td>
      <td background="images1/winxp-bottom.gif"><img border="0" src="images1/winxp-bottom.gif" width="66" height="23"></td>
      <td><img border="0" src="images1/winxp-botright.gif" width="61" height="23"></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>

EOF

  }

}

sub getFile {
  my($file, $asArray) = @_;
  my @cur;
  $file = basename($file);
  open MYFILE, "$rootpath/$file";
  push @cur, $_ while chomp($_ = <MYFILE>);
  close MYFILE;
  return @cur if ($asArray =~ /T/i);
  return join "\n", @cur;
}

sub writeFile {
  my($file, $text) = @_;
  $file = basename($file);
  if (!(-e "$rootpath/$file")) {
    open MYFILE, ">$rootpath/$file";
    close MYFILE;
    chmod 0777, "$rootpath/$file";
  }
  open MYFILE, ">$rootpath/$file";
  print MYFILE $text, "\n";
  close MYFILE;
}

sub clearImage {
  my($file) = @_;
  unlink("$imagepath/" . basename(&getAttr($file, 'image')));
}

sub deleteFile {
  my($file) = @_;
  &clearImage($file);
  unlink("$rootpath/" . basename($file));
}

sub standardForm {
  print $q->start_form(-method => 'post',
		       -action => 'docpublisher.cgi');
}

sub endForm {
  print $q->end_form;
}

sub printMode {
  my($mode) = @_;
  print $empty_q->hidden(-name => 'mode',
			 -value => $mode);
}

sub goBack {
  &standardForm;
  &printMode('main');
  &imageButton('backtomainmenu');
  &endForm;
}

sub mainPages {
  return grep /docpublisher\d*\.fmt$/, glob("$rootpath/*");
}

sub subPages {
  my($root) = @_;
  return grep /\d*sub\d*\.fmt$/, glob("$rootpath/$root*");
}

sub allPages {
  return grep /docpublisher.*?\.fmt$/, glob("$rootpath/*");
}

sub newIndex {
  my($root) = @_;
  $root = "docpublisher" unless defined $root;
  my $i = 0;
  $i++ until !(-e "$rootpath/$root$i.fmt");
  return $i;
}

sub getHeader {
  return &getFile("upointHeader.fmt");
}

sub getFooter {
  return &getFile("upointFooter.fmt");
}

sub getPrefix {
  my($file) = @_;
  $file =~ /docpublisher.*?(?=\.)/;
  return $&;
}

sub indent {
  return "\&nbsp;" x 5;
}

sub getAttr {
  my($file, $attr) = @_;
  my $html = &getFile($file);
  $html =~ /\<$attr\>(.*?)\<\/$attr\>/is;
  return $1;
}

sub setAttr {
  my($file, $attr, $newAttr) = @_;
  my $html = &getFile($file);
  $html =~ s/(\<$attr\>).*?(\<\/$attr\>)/\1$newAttr\2/is;
  &writeFile($file, $html);
}

sub getSubNumber {
  my($file) = @_;
  $file =~ /sub(\d*)/;
  return $1;
}

sub getMainNumber {
  my($file) = @_;
  $file =~ /docpublisher(\d*)/;
  return $1;
}

sub moveFile {
  my($file1, $file2) = @_;
  move("$rootpath/$file1", "$rootpath/$file2");
}

sub reduceSubPages {
  my($root) = @_;
  my $ind = 0;
  foreach (&subPages($root)) {
    &moveFile(basename($_), "${root}sub$ind.fmt");
    $ind++;
  }
}

sub reduceMainPages {
  my $ind = 0;
  foreach(&mainPages) {
    my $curBase = basename($_);
    &moveFile($curBase, "docpublisher$ind.fmt");
    my $subInd = 0;
    foreach(&subPages(&getPrefix($curBase))) {
      &moveFile(basename($_), "docpublisher${ind}sub$subInd.fmt");
      $subInd++;
    }
    $ind++;
  }
}

sub swapMainPages {
  my($root1, $root2) = @_;
  my($ind1, $ind2) = (&getMainNumber($root1), &getMainNumber($root2));
  
  my $subInd = 0;
  foreach(&subPages($root1)) {
    &moveFile(basename($_), "tempsub$subInd.fmt");
    $subInd++;
  }

  $subInd = 0;
  foreach(&subPages($root2)) {
    &moveFile(basename($_), "docpublisher${ind1}sub$subInd.fmt");
    $subInd++;
  }

  $subInd = 0;
  foreach(&subPages("temp")) {
    &moveFile(basename($_), "docpublisher${ind2}sub$subInd.fmt");
    $subInd++;
  }
&swapSubPages($root1, $root2);
}

sub swapSubPages {
  my($root1, $root2) = @_;
  
  &moveFile("$root1.fmt", "temp.fmt");
  &moveFile("$root2.fmt", "$root1.fmt");
  &moveFile("temp.fmt", "$root2.fmt");
}


sub getMainPage {
  my($subPage) = @_;
  $subPage =~ /(.*?)sub/;
  return $1;
}

sub imageButton {
  my($img) = @_;
  print $q->image_button(-src => "images1/b_$img.gif");
}

sub imageIcon {
  my($img) = @_;
  print $q->img({-src => "images1/i_$img.gif"}), '&nbsp;';
}

sub mainOpts {

  &standardForm;
  &imageIcon('addmode');
  &printMode('add');
  &imageButton('addmode');
  &endForm;

  &standardForm;
  &imageIcon('editmode');
  &printMode('edit');
  &imageButton('editmode');
  &endForm;

  &standardForm;
  &imageIcon('deletemode');
  &printMode('delete');
  &imageButton('deletemode');
  &endForm;

  &standardForm;
  &imageIcon('sortmode');
  &printMode('sort');
  &imageButton('sortmode');
  &endForm;

  print $q->start_form(-method => 'get',
		       -target => '_blank',
		       -action => "$rooturl/title.htm");
  &imageIcon('viewmode');
  &imageButton('viewmode');
  &endForm;

  &standardForm;
  &imageIcon('rebuildmode');
  &printMode('regenerate');
  &imageButton('rebuildHTML');
  &endForm;

  &standardForm;
  &imageIcon('template');
  &printMode('template');
  &imageButton('template');
  &endForm;

  &standardForm;
  &imageIcon('configuration');
  &printMode('configuration');
  &imageButton('configuration');
  &endForm;

}

sub startFont {
  my($font, $size, $color) = &getFile('upointConfiguration.fmt', 'T');
  return "<font face=\"$font\" size=$size color=\"$color\">";
}

sub endFont {
  return "</font>";
}

print $q->header;
&printLawrence;

if ($params{'mode'} eq 'add') {

  if (defined $params{'addMain'}) {
    &writeFile('docpublisher' . &newIndex . '.fmt',
	       "<title>$params{'addMainTitle'}</title>\n" .
	       "<description></description>\n");
  } elsif (defined $params{'addSub'}) {
    &writeFile("$params{'addSub'}sub" . &newIndex("$params{'addSub'}sub") .
	       '.fmt',
	       "<title>$params{'addSubTitle'}</title>\n" .
	       "<description></description>\n" .
	       "<image></image>\n" .
	       "<realStuff></realStuff>\n");
  }

  foreach (&mainPages) {

    my $curFile = $_;
    my $curName = &getPrefix(basename($curFile));
    my $curTitle = &getAttr(basename($curFile), 'title');
    my $curMainNumber = &getMainNumber($curName) + 1;

    &standardForm;
    print $q->b("$curMainNumber $curTitle"), $q->br;
    print $empty_q->hidden(-name => 'addSub',
			   -value => $curName);
    &printMode('add');
    print "TITLE: " . $empty_q->textfield(-name => 'addSubTitle',
					  -value => 'My Sub Title',
					  -size => 50);
    &imageButton('addsubpage');
    print $q->br;

    my @allSubTitles;
    foreach (&subPages($curName)) {
      my $curSubFile = $_;
      my $curSubNumber = &getSubNumber($curSubFile) + 1;
      my $curSubTitle = &getAttr(basename($curSubFile), 'title');
      push @allSubTitles, "$curMainNumber.$curSubNumber $curSubTitle";
    }
    print &indent, $empty_q->popup_menu(-name => ["sub-pages", @allSubTitles],
					-values =>
					["Sub-pages:", @allSubTitles]);
    &endForm;
    
  }

  &standardForm;
  print $q->hidden(-name => 'addMain');
  &printMode('add');
  print "TITLE: " . $q->textfield(-name => 'addMainTitle',
				  -value => 'My Main Title',
				  -size => 50);
  &imageButton('addmainpage');
  &endForm;

  &goBack;

} elsif ($params{'mode'} eq 'configuration') {

  &standardForm;

  ## If it's there, write back to it.
  if (defined $params{'reconfigure'}) {
    &writeFile('upointConfiguration.fmt',
	       "$params{'font'}\n$params{'size'}\n$params{'color'}\n");
  }

  my($font, $size, $color) = &getFile('upointConfiguration.fmt', 'T');
  print "Font: ", $q->textfield(-name => 'font',
				-value => $font);
  print $q->br;
  print "Size: ", $q->textfield(-name => 'size',
				-value => $size);
  print $q->br;
  print "Color: ", $q->textfield(-name => 'color',
				 -value => $color);
  print $q->br;
  &printMode('configuration');
  &imageButton('submitchanges');
  print $q->hidden(-name => 'reconfigure',
		   -value => 'Submit changes');
  &endForm;

  &goBack;

} elsif ($params{'mode'} eq 'delete') {

  if (defined $params{'delMain'}) {
    foreach (("$params{'delMain'}.fmt", &subPages($params{'delMain'}))) {
      &deleteFile($_);
    }
    &reduceMainPages;
  } elsif (defined $params{'delSub'}) {
    $params{'delSub'} =~ /\.(\d*)/;
    $params{'delSub'} = "$params{'mainPage'}sub" . ($1 - 1);
    &deleteFile("$params{'delSub'}.fmt");
    &reduceSubPages(&getMainPage($params{'delSub'}));
  }

  foreach (&mainPages) {

    my $curFile = $_;
    my $curName = &getPrefix(basename($curFile));
    my $curTitle = &getAttr(basename($curFile), 'title');
    my $curMainNumber = &getMainNumber($curName) + 1;

    &standardForm;
    print $q->b("$curMainNumber $curTitle");
    print $empty_q->hidden(-name => 'delMain',
			   -value => $curName);
    &printMode('delete');
    &imageButton('deletenow');
    &endForm;

    my @allSubTitles;
    foreach (&subPages($curName)) {
      my $curSubFile = $_;
      my $curSubNumber = &getSubNumber($curSubFile) + 1;
      my $curSubTitle = &getAttr(basename($curSubFile), 'title');
      push @allSubTitles, "$curMainNumber.$curSubNumber $curSubTitle";
    }
    @allSubTitles = ("No sub-pages") unless (@allSubTitles);
    &standardForm;
    &printMode('delete');
    print $empty_q->hidden(-name => 'mainPage',
		     -value => $curName);
    print &indent, $empty_q->popup_menu(-name => 'delSub',
					-values => [@allSubTitles]);
    &imageButton('deletenow');
    &endForm;

  }

  &goBack;

} elsif ($params{'mode'} eq 'edit') {
  
  if (defined $params{'editedSub'}) {
    my $curFile = "$params{'editSub'}.fmt";

    if ($params{'upload'} =~ /[a-zA-Z]/) {
      my $imageFile = basename($params{'upload'});
      $imageFile =~ s/^.*\\//g;
      my $filename = $q->upload('upload');
      &clearImage($curFile);
      open (OUTFILE,">>$imagepath/$imageFile");
      my ($bytesread, $buffer);
      while ($bytesread = read($filename, $buffer, 1024)) {
	print OUTFILE $buffer;
      }
      chmod 0777, "$imagepath/$imageFile";

      &setAttr($curFile, 'image', "$imageurl/$imageFile");
    }

    $params{"$params{'editSub'}STUFF"} =~ s/\n/<br>/gi;

    &setAttr($curFile, 'title', $params{"$params{'editSub'}TITLE"});
    &setAttr($curFile, 'description', $params{"$params{'editSub'}DESCR"});
    &setAttr($curFile, 'realStuff', $params{"$params{'editSub'}STUFF"});

    print "Edits processed.", $q->br;

  } elsif (defined $params{'editedMain'}) {
    my $curFile = "$params{'editMain'}.fmt";

    &setAttr($curFile, 'title', $params{"$params{'editMain'}TITLE"});
    &setAttr($curFile, 'description', $params{"$params{'editMain'}DESCR"});
    &setAttr($curFile, 'realStuff', $params{"$params{'editMain'}STUFF"});

    print "Edits processed.", $q->br;

  }

  if (defined $params{'editSub'}) {

    do {
      $params{'editSub'} =~ /\.(\d*)/;
      $params{'editSub'} = "$params{'mainPage'}sub" . ($1 - 1);
    } unless defined $params{'editedSub'};

    my $curTitle = &getAttr("$params{'editSub'}.fmt", 'title');
    my $curDescription = &getAttr("$params{'editSub'}.fmt", 'description');
    my $realStuff = &getAttr("$params{'editSub'}.fmt", "realStuff");
    my $curImage = &getAttr("$params{'editSub'}.fmt", "image");

    $realStuff =~ s/<br>/\n/gi;

    print $q->b((&getMainNumber($params{'mainPage'}) + 1) .
		' ' . &getAttr("$params{'mainPage'}.fmt", 'title') .
		" - " . (&getSubNumber($params{'editSub'}) + 1) .
		" $curTitle");
    
    print $q->start_multipart_form(-action => 'docpublisher.cgi');
    &printMode('edit');
    print "TITLE: ", $empty_q->textfield(-name => "$params{'editSub'}TITLE",
					 -value => $curTitle,
					 -size => 50), $q->br;
    print "DESCR: ", $empty_q->textfield(-name => "$params{'editSub'}DESCR",
					 -value => $curDescription,
					 -size => 50), $q->br;
    print "Content:<br>", $empty_q->textarea(-name => "$params{'editSub'}STUFF",
					  -value => $realStuff,
					  -rows => 20,
					  -cols => 70), $q->br;
    print "Image to use (currently using ",
      (($curImage =~ /[a-zA-Z]/) ? $curImage : "nothing"), '): ',
      $q->filefield(-name => 'upload'), $q->br;

    print $empty_q->hidden(-name => 'editSub',
			   -value => $params{'editSub'});
    print $empty_q->hidden(-name => 'mainPage',
			   -value => $params{'mainPage'});
    &imageButton('submitchanges');
    print $q->hidden(-name => 'editedSub',
		     -value => 'Submit Changes');
    &endForm;

    &standardForm;
    &printMode('edit');
    &imageButton('backtoeditmode');
    &endForm;

  } else {

    foreach (&mainPages) {
    
      my $curFile = $_;
      my $curName = &getPrefix(basename($curFile));
      my $curTitle = &getAttr(basename($curFile), 'title');
      my $curDescription = &getAttr(basename($curFile), 'description');
      my $curMainNumber = &getMainNumber($curName) + 1; 

      print $q->b("$curMainNumber $curTitle");
      
      &standardForm;
      
      print "TITLE: ", $empty_q->textfield(-name => "${curName}TITLE",
					   -value => $curTitle,
					   -size => 50), $q->br;
      print "DESCR: ", $empty_q->textfield(-name => "${curName}DESCR",
					   -value => $curDescription,
					   -size => 50), $q->br;
      print $empty_q->hidden(-name => 'editMain',
			     -value => $curName);
      &printMode('edit');
      &imageButton('editmainpage');
      print $q->hidden(-name => 'editedMain',
		       -value => 'Edit Main Page');
      &endForm;
      print $q->br;
      
      my @allSubTitles;
      foreach (&subPages($curName)) {
	my $curSubFile = $_;
	my $curSubNumber = &getSubNumber($curSubFile) + 1;
	my $curSubTitle = &getAttr(basename($curSubFile), 'title');
	push @allSubTitles, "$curMainNumber.$curSubNumber $curSubTitle";
      }
      @allSubTitles = ("No sub-pages") unless (@allSubTitles);
      &standardForm;
      &printMode('edit');
      print $empty_q->hidden(-name => 'mainPage',
			     -value => $curName);
      print &indent, $empty_q->popup_menu(-name => 'editSub',
					  -values =>
					  [@allSubTitles]);
      &imageButton('editsubpage');
      &endForm;
      
    }

  }

  &goBack;

} elsif ($params{'mode'} eq 'image') {

  if (defined $params{'upload'}) {
    my $filename = $q->upload('upload');
    while (<$filename>) {
      print;
    }
  }

  print $q->start_multipart_form(-action => 'docpublisher.cgi');
  print $q->filefield(-name => 'upload');
  &printMode('image');
  &imageButton('uloadimage');
  print $q->end_form;

  &goBack;

} elsif ($params{'mode'} eq 'regenerate') {

  ## Clear mess
  unlink($_) foreach glob("$rootpath/*.htm");

  my $titleHtml = &getHeader . &startFont . $q->b("Title") . $q->br;

  foreach (&mainPages) {
    
    my $curFile = $_;
    my $curName = &getPrefix(basename($curFile));
    my $curMainNumber = &getMainNumber(basename($curFile)) + 1;
    my $curTitle = &getAttr(basename($curFile), 'title');
    my $curDescription = &getAttr(basename($curFile), 'description');
    
    my $html = &getHeader . &startFont .
      $q->b($q->a({-href => "title.htm"}, "Title")) . ": " .
	$q->b($curTitle) . $q->br . $curDescription . $q->br x 2;
    
    my @allSubTitles;
    foreach (&subPages($curName)) {
      my $curSubFile = $_;
      my $curSubName = &getPrefix(basename($curSubFile));
      my $curSubNumber = &getSubNumber(basename($curSubFile)) + 1;
      my $curSubTitle = &getAttr(basename($curSubFile), 'title');
      my $curSubDescription = &getAttr(basename($curSubFile), 'description');
      my $curSubRealStuff = &getAttr(basename($curSubFile), 'realStuff');
      my $curSubImage = &getAttr(basename($curSubFile), 'image');
      $html .= &indent . "$curMainNumber.$curSubNumber " .
	$q->b($q->a({-href => "$curSubName.htm"}, $curSubTitle)) . $q->br;
      $html .= &indent x 2 . '&nbsp;' x 2 . $curSubDescription . $q->br;

      my $subHtml = &getHeader . &startFont .
	$q->b($q->a({-href => "title.htm"}, "Title")) . ": " .
	  $q->b($q->a({-href => "$curName.htm"}, $curTitle)) . ": " .
	    $q->b($curSubTitle) . $q->br . $curSubDescription . $q->br x 2 .
	      (($curSubImage =~ /[a-zA-Z]/) ?
	       $q->img({-src => $curSubImage, -align => 'left'}) : "") .
		 $curSubRealStuff . &endFont . $q->br({-clear => 'all'}) .
		   &getFooter;
      &writeFile("$curSubName.htm", $subHtml);
    }

    $html .= &endFont . &getFooter;
    &writeFile("$curName.htm", $html);
    
    $titleHtml .= &indent . "$curMainNumber " .
      $q->b($q->a({-href => "$curName.htm"}, $curTitle)) . $q->br;
    $titleHtml .= &indent x 2 . '&nbsp;' x 2 . $curDescription . $q->br;

  }

  $titleHtml .= &endFont . &getFooter;
  &writeFile("title.htm", $titleHtml);

  print "HTML Regenerated";

  &mainOpts;

} elsif ($params{'mode'} eq 'sort') {

  if (defined $params{'sortMain'}) {

    my $factor = ($params{'whichWay'} eq 'Move up') ? -1 : 1;
    my $swapMain = &getMainNumber($params{'sortMain'}) + $factor;
    $swapMain -= $factor unless (0 <= $swapMain && &newIndex > $swapMain);
    &swapMainPages($params{'sortMain'}, "docpublisher$swapMain");

  } elsif (defined $params{'sortSub'}) {

    my $factor = ($params{'whichWay'} eq 'Move up') ? -1 : 1;
    my $swapSub = &getSubNumber($params{'sortSub'}) + $factor;
    my $topIndex = &newIndex($params{'mainPage'} . "sub");
    $swapSub -= $factor unless (0 <= $swapSub && $topIndex > $swapSub);
    &swapSubPages($params{'sortSub'}, "$params{'mainPage'}sub$swapSub");

  }

  if (defined $params{'mainPage'}) {

    foreach (&subPages($params{'mainPage'})) {

      my $curFile = $_;
      my $curName = &getPrefix(basename($curFile));
      my $curTitle = &getAttr(basename($curFile), 'title');
      
      print $q->b((&getSubNumber($curName) + 1) . " $curTitle");

      &standardForm;
      print $empty_q->hidden(-name => 'sortSub',
			     -value => $curName);
      print $empty_q->hidden(-name => 'mainPage',
			     -value => $params{'mainPage'});
      &printMode('sort');
      &imageButton('moveup');
      print $empty_q->hidden(-name => 'whichWay',
			     -value => "Move up");
      &endForm;

      &standardForm;
      print $empty_q->hidden(-name => 'sortSub',
			     -value => $curName);
      print $empty_q->hidden(-name => 'mainPage',
			     -value => $params{'mainPage'});
      &printMode('sort');
      &imageButton('movedown');
      print $empty_q->hidden(-name => 'whichWay',
			     -value => "Move down");
      &endForm;      

    }
    
    &standardForm;
    &printMode('sort');
    &imageButton('backtosortmode');
    &endForm;

  } else {

    foreach (&mainPages) {

      my $curFile = $_;
      my $curName = &getPrefix(basename($curFile));
      my $curTitle = &getAttr(basename($curFile), 'title');
      my $curMainNumber = &getMainNumber($curName) + 1;

      print $q->b("$curMainNumber $curTitle");

      &standardForm;
      print $empty_q->hidden(-name => 'sortMain',
			     -value => $curName);
      &printMode('sort');
      &imageButton('moveup');
      print $empty_q->hidden(-name => 'whichWay',
			     -value => "Move up");
      &endForm;

      &standardForm;
      print $empty_q->hidden(-name => 'sortMain',
			     -value => $curName);
      &printMode('sort');
      &imageButton('movedown');
      print $empty_q->hidden(-name => 'whichWay',
			     -value => "Move down");
      &endForm;
      
      my @allSubTitles;
      foreach (&subPages($curName)) {
	my $curSubFile = $_;
	my $curSubNumber = &getSubNumber($curSubFile) + 1;
	my $curSubTitle = &getAttr(basename($curSubFile), 'title');
	push @allSubTitles, "$curMainNumber.$curSubNumber $curSubTitle";
      }
      @allSubTitles = ("No sub-pages") unless (@allSubTitles);
      &standardForm;
      &printMode('sort');
      print $empty_q->hidden(-name => 'mainPage',
			     -value => $curName);
      print &indent, $empty_q->popup_menu(-name => 'sortSubMode',
					  -values =>
					  ["Sub-pages:", @allSubTitles]);
      &imageButton('sortsubpage');
      &endForm;

    }
  }

  &goBack;

} elsif ($params{'mode'} eq 'template') {

  &standardForm;

  ## If it's there, write back to it.
  if (defined $params{'header'} && defined $params{'footer'}) {
    &writeFile('upointHeader.fmt', $params{'header'});
    &writeFile('upointFooter.fmt', $params{'footer'});
  }

  my($header, $footer) = (&getFile('upointHeader.fmt'),
			  &getFile('upointFooter.fmt'));
  print "Header:<br>", $q->textarea(-name => 'header',
				 -value => $header,
				 -rows => 10,
				 -cols => 50);
  print $q->br;
  print "Footer:<br>", $q->textarea(-name => 'footer',
				 -value => $footer,
				 -rows => 10,
				 -cols => 50);
  print $q->br;
  &printMode('template');
  &imageButton('submitchanges');
  &endForm;

  &goBack;

} elsif ($params{'mode'} eq 'main') {

  do {
    print "Sorry. The password is not correct.";
    &endLawrence;
    exit;
  } unless (!defined $params{'password'} or $params{'password'} eq $password);

  &mainOpts;

} elsif (!defined $params{'mode'}) {

  &standardForm;
  &printMode('main');
  print "Please enter password : ",
  $q->password_field(-name => 'password');
  &imageButton('login');
  &endForm;

}

&endLawrence;

exit;

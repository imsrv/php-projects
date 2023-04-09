#!/usr/bin/perl
##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################
#use Time::HiRes qw(gettimeofday);
#$PSTART = gettimeofday;
use CGI::Carp qw(fatalsToBrowser); 
use File::Copy;
use DB_File;
use LWP::Simple;

$userpm = "T";
require "./common.pm";
require "$GPath{'imagesize.pm'}";
require "$GPath{'cf.pm'}";
require $GPath{'cf_logs.pm'};

$PROGRAM_NAME = "club_gallery.cgi";

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

$tmpbuffer = "$buffer\n";
$tmpbuffer =~ s/\s//g;

$rn = time;
$statuses{'official'} = 4;
$statuses{'recommented'} = 3;
$statuses{'approved'} = 2;
$statuses{'unreviewed'} = 1;
$forum_email = $CONFIG{'email'};
$CONFIG{'bbs_table1'} =~ s/ +.*//g;
$CONFIG{'bbs_table2'} =~ s/ +.*//g;

($VALIDUSER, %IUSER) = &validate_session_no_error;

	if (($tmpbuffer =~ /uploadthis/i)) {
		my $fn = &upload_file;
		&save_file($fn);
		&add_image_to_db;
		my $rnd=int rand 10000;
		&log_upload($club);
		print "Location: $GUrl{'club_gallery.cgi'}?club=$club&cat=$category&$rnd\n\n";
		exit;
	}

	&parse_FORM_local;

	&lock("activity");
	$rn = time;
	tie %data, "DB_File", "$GPath{'cforums_data'}/activity.db";
	$data{$IUSER{'username'}} = "$rn\|$FORM{'club'}";
	untie %data; 
	&unlock("activity");


	$FORM{'category'} =~ s/\|$//;

	$hforum = 1;

	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);

	open (FILE, "$GPath{'cforums_data'}/god.dat");
	@god = <FILE>;
	close(FILE);
	$admin_num = $god[0];

	$action = $FORM{'action'};
	$forum=$FORM{'forum'} if (! $forum);


	$GRP = $forum;
	if ( !($GRP) ) { $GRP = "club"; }
	if ( !( -e "$GPath{'template_data'}/$GRP.txt" ) ) { $GRP = "club"; }

	if ($FORM{'action'} eq "edit") {
		&admin_form;
		&print_output('club_mod');
		exit;
	}
	elsif ($FORM{'action'} eq "upload") {
		my $rnd=int rand 10000;
		&upload_image;
		&print_output('club_upload_image');
		exit;
	}
	elsif ($FORM{'action'} eq "edit_image") {
		my $rnd=int rand 10000;
		&edit_image;
		&print_output('club_upload_image');
		exit;
	}
	elsif ($FORM{'action'} eq "transload") {
		my $rnd=int rand 10000;
		&transload_image;
		&print_output('club_upload_image');
		exit;
	}
	elsif ($FORM{'action'} eq "deletegallery") {
		my $rnd=int rand 10000;
		&delete_gallery;
		print "Location: $GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&$rnd\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "save_gallery") {
		my $rnd=int rand 10000;
		&save_gallery;
		print "Location: $GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&$rnd\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "Save This File") {
		my $rnd=int rand 10000;
		&save_image_to_db;
		my $lc = &urlencode($FORM{'orginal_cat'});
		print "Location: $GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&cat=$lc&$rnd\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "Delete This File") {
		my $rnd=int rand 10000;
		&unlink_image;
		&delete_image_from_db;
		my $lc = &urlencode($FORM{'orginal_cat'});
		print "Location: $GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&cat=$lc&$rnd\n\n";
		exit;
	}
	if (($FORM{'action'} =~ /Transload This File/i)) {
		my $fn = &transload_file;
		&save_file($fn);
		&add_image_to_db;
		my $lc = &urlencode($category);
		print "Location: $GUrl{'club_gallery.cgi'}?club=$club&cat=$lc&$rnd\n\n";
		&log_upload($FORM{'club'});
		exit;
	}
	else {
		&log_visit($FORM{'club'});
		&Page_Header($GRP); 
	}



sub unlink_image {
	if ((($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) || ($IUSER{'username'} eq $i[1])) {
		unlink ("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
		unlink ("$CONFIG{'CLUB_image_path'}/$club/thumbs/$fn");
	}
}

sub edit_image {
	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt") {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt");
 		@t = <FILE>;
		close (FILE);
		foreach $l (@t) {
			$l =~ s/(\n|\cM)//;
			push (@cats, $l);
		}
	}
	else {
		@cats = ("Business", "Fun & Games", "Entertainment", "Family", "Computers");
	}

	open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
 	@t = <FILE>;
	close (FILE);
	foreach $l (@t) {
		$l =~ s/(\n|\cM)/ /;
		push (@gallery, $l);
	}

	if ((($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) || ($IUSER{'username'} eq $i[1])) {
		foreach $l (@gallery) {
			@i = split(/\|\|/, $l);
			if ($i[0] eq $FORM{'image'}) {
				$FOUND = "T";
				last;
			}
		}
		if ($FOUND eq "T") {
			my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/gallery/editimagesettings.tmplt");
			$BODY .= $template->fill_in;
			$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/gallery/editimagesettings.tmplt";
		}
	}
     	$BODY .= " <SCRIPT LANGUAGE=\"javascript\">\n";
     	$BODY .= " <!--\n";
     	$BODY .= " function OpenWin(Loc,Width,Height) {\n";
	$BODY .= "	var WinInfo = \"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=\" + Width + \",height=\" + Height\n";
	$BODY .= " 	wPageWindow=window.open(Loc,\"wImageWindow\",WinInfo);\n";
     	$BODY .= "  	wImageWindow.focus();\n";
     	$BODY .= " 	   }\n";
     	$BODY .= " 	// -->\n";
     	$BODY .= " 	</SCRIPT>\n";
	$BODY .= "</BODY>\n";
	$BODY .= "</HTML>\n";

}

sub transload_image {
	$club = $FORM{'club'};
	$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
	open (FILE, "$dir/g_intro.txt");
	@intro = <FILE>;
	close (FILE);
	foreach $l (@intro) {
		$introtext .= $l;
	}

	open (FILE, "$dir/g_settings.txt");
	@t = <FILE>;
	close (FILE);
	$admin_only = $t[0];

	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt") {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt");
 		@t = <FILE>;
		close (FILE);
		foreach $l (@t) {
			$l =~ s/(\n|\cM)//;
			push (@cats, $l);
		}
	}
	else {
		@cats = ("Business", "Rumors", "Entertainment", "Family", "Computers");
	}
	if (($admin_only ne "T") || (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))) {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/gallery/transload.tmplt");
		$BODY .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/gallery/transload.tmplt";
	}
}


sub upload_image {
	$club = $FORM{'club'};

	$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
	open (FILE, "$dir/g_intro.txt");
	@intro = <FILE>;
	close (FILE);
	foreach $l (@intro) {
		$introtext .= $l;
	}

	open (FILE, "$dir/g_settings.txt");
	@t = <FILE>;
	close (FILE);
	$admin_only = $t[0];

	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt") {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt");
 		@t = <FILE>;
		close (FILE);
		foreach $l (@t) {
			$l =~ s/(\n|\cM)//;
			push (@cats, $l);
		}
	}
	else {
		@cats = ("Business", "Rumors", "Entertainment", "Family", "Computers");
	}
	if (($admin_only ne "T") || (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))) {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/gallery/upload.tmplt");
		$BODY .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/gallery/upload.tmplt";
	}
}


sub Body {
	&gallery;
}

sub transload_file {
	$image = get($FORM{'transload_file'});
	$filename = $FORM{'transload_file'};
	$filename =~ s/.*\///;
	$category = $FORM{'category'};
	$club = $FORM{'club'};
	$description = $FORM{'description'};
	return $filename;
}




sub delete_image_from_db {
	if ((($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) || ($IUSER{'username'} eq $i[1])) {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
		@lines = <FILE>;
		close (FILE);

		open (FILE, ">$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
		foreach $l (@lines) {
			$l =~ s/(\n|\cM)//g;
			(@i) = split(/\|\|/, $l);
			if ($i[0] eq $FORM{'filename'}) {	}
			else {
				print FILE "$l\n";
			}
		}
		close (FILE);
		chmod (0777, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");

		unlink ("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/photos/$FORM{'filename'}");
		unlink ("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/thumbs/$FORM{'filename'}");
	}
}


sub save_image_to_db {
	$line  = "$FORM{'filename'}\|\|";
	$line .= "$IUSER{'username'}\|\|";
	$line .= "$FORM{'description'}\|\|";
	$line .= "$FORM{'category'}";
	$line =~ s/(\n|\cM)//g;

	open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
	@lines = <FILE>;
	close (FILE);

	open (FILE, ">$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
	foreach $l (@lines) {
		$l =~ s/(\n|\cM)//g;
		(@i) = split(/\|\|/, $l);
		if ($i[0] eq $FORM{'filename'}) {
			print FILE "$line\n";
		}
		else {
			print FILE "$l\n";
		}
	}
	close (FILE);
	chmod (0777, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
}


sub add_image_to_db {
	$line  = "$filename\|\|";
	$line .= "$IUSER{'username'}\|\|";
	$line .= "$description\|\|";
	$line .= "$category";
	$line =~ s/(\n|\cM)/ /g;

	if (-e "$GPath{'clubs_data'}/$club/gallery.txt") {
		open (FILE, ">>$GPath{'clubs_data'}/$club/gallery.txt");
	}
	else {
		open (FILE, ">$GPath{'clubs_data'}/$club/gallery.txt");
	}
	print FILE "$line\n";
	close (FILE);
	chmod (0777, "$GPath{'clubs_data'}/$club/gallery.txt");
}

sub gallery {
	$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
	open (FILE, "$dir/g_intro.txt");
	@intro = <FILE>;
	close (FILE);
	foreach $l (@intro) {
		$introtext .= $l;
	}

	open (FILE, "$dir/g_settings.txt");
	@t = <FILE>;
	close (FILE);
	$admin_only = $t[0];

	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt") {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/g_cats.txt");
 		@t = <FILE>;
		close (FILE);
		foreach $l (@t) {
			$l =~ s/(\n|\cM)//;
			push (@cats, $l);
		}
	}
	else {
		@cats = ("Business", "Rumors", "Entertainment", "Family", "Computers");
	}

	open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/gallery.txt");
 	@t = <FILE>;
	close (FILE);
	foreach $l (@t) {
		$l =~ s/(\n|\cM)/ /;
		$l =~ s/ +$//;
		push (@gallery, $l);
		@ti = split(/\|\|/, $l);
		$cc{$ti[3]}++;
	}	

	@gallery = reverse @gallery;
	if (($FORM{'cat'} eq "") && ($FORM{'action'} ne "viewall")) {
		$OUT .= "<TABLE WIDTH=400>\n";
		$OUT .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><FONT SIZE=+1><B>$introtext</B></FONT></FONT><P></TD></TR>\n";
		foreach $c (@cats) {
			$lc = &urlencode($c);
			$OUT .= "<TR><TD><LI><FONT COLOR=\"$CONFIG{'text_color'}\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"+1\"><A HREF=\"$GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&cat=$lc\">$c</A> ($cc{$c} pictures)</FONT>\n";
		}
		$OUT .= "</TABLE>\n";
	}
	else {
		$OUT .= "<TABLE BORDER=3>\n";
		if ($CONFIG{'CLUBGALLERY_use_ecards'} eq "YES") {
			$COLSPAN=4;
		}
		else {
			$COLSPAN=3;
		}
		$lc = &urlencode($FORM{'cat'});
		$OUT .= "<TR><TD COLSPAN=$COLSPAN><A HREF=\"$GUrl{'club_gallery.cgi'}?club=$FORM{'club'}\"><B>Home</B></A> / <A HREF=\"$GUrl{'club_gallery.cgi'}?club=$FORM{'club'}&cat=$lc\"><B>$FORM{'cat'}</B></A></TD></TR>";
		$OUT .= "<TR><TD><B>Click To Enlarge</B></TD><TD><B>Uploaded By:</B></TD><TD><B>Description</B></TD>";
		if ($CONFIG{'CLUBGALLERY_use_ecards'} eq "YES") {
			$OUT .= "<TD><B>Send To A Friend!</B></TD>";
		}
		$OUT .= "</TR>\n";
		foreach $image (@gallery) {
			@i = split(/\|\|/, $image);

			if (($i[3] ne $FORM{'cat'}) && ($FORM{'action'} ne "viewall")) {next;}
			if (-e "iresize") {
				($twidth, $theight) = &imgsize("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/thumbs/$i[0]");
				($pwidth, $pheight) = &imgsize("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/photos/$i[0]");
				$pwidth= $pwidth+25;
				$pheight= $pheight+25;
				if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i) {
					$LINK = "<A HREF=\"javascript:OpenWin(\'$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]\',\'$pwidth\',\'$pheight\');\">";
				}
				else {
					$LINK = "<A HREF=\"$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]\">";
				}
				$OUT .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER>$LINK<IMG SRC=\"$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/thumbs/$i[0]\" BORDER=1 WIDTH=$twidth HEIGHT=$theight></A>";
			}
			else {
				($pwidth, $pheight) = &imgsize("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/photos/$i[0]");
				($twidth, $theight) = ($pwidth, $pheight);
				$pwidth= $pwidth+25;
				$pheight= $pheight+25;
				if (($twidth > $theight) && ($twidth > $CONFIG{'CLUB_thumb_width'})) {
					$dif = $twidth - $CONFIG{'MYPHOTO_width'};
					$ratio = $dif/$twidth;
					$theight = sprintf("%.0f", ($theight-($theight*$ratio)));
					$twidth = $twidth-($twidth*$ratio);
				}
				elsif (($twidth < $theight) && ($theight > $CONFIG{'CLUB_thumb_height'})) {
					$dif = $theight - $CONFIG{'MYPHOTO_height'};
					$ratio = $dif/$theight;
					$twidth = sprintf("%.0f", ($twidth-($twidth*$ratio)));
					$theight = $theight-($theight*$ratio);
				}
				if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i) {
					$LINK = "<A HREF=\"javascript:OpenWin(\'$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]\',\'$pwidth\',\'$pheight\');\">";
				}
				else {
					$LINK = "<A HREF=\"$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]\">";
				}
				$OUT .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER>$LINK<IMG SRC=\"$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]\" BORDER=1 WIDTH=$twidth HEIGHT=$theight></A>";
			}
			if ((($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) || ($IUSER{'username'} eq $i[1])) {
				$OUT .= "<BR><FONT SIZE=1><A HREF=\"$GUrl{'club_gallery.cgi'}?action=edit_image&image=$i[0]&club=$FORM{'club'}&original_cat=$FORM{'cat'}\">Edit</A>";
			}
			($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/photos/$i[0]");
			$kb = int($size/1024);
			$OUT .= "</CENTER></TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER><A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$i[1]\">$i[1]</A></CENTER></TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">$i[2]<BR><FONT SIZE=1><I>$kb KBs - $pwidth x $pheight</I></FONT></TD>";
			if ($CONFIG{'CLUBGALLERY_use_ecards'} eq "YES") {
				$EURL = &urlencode("$CONFIG{'CLUB_image_dir'}/$FORM{'club'}/photos/$i[0]");
				$OUT .= "<TD><A HREF=\"$CONFIG{'CLUBGALLERY_ecards_url'}?imageurl=$EURL\">$CONFIG{'CLUGALLERY_ecards_text'}</A>";
			}
			$OUT .= "</TR>\n";
		}
		$OUT .= "</TABLE>\n";
	}
	if (($admin_only ne "T") || (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))) {
		$OUT .= "<TR><TD COLSPAN=$COLSPAN><CENTER>";
		if ($FORM{'cat'} ne "") {
			$OUT .= "<A HREF=\"$GUrl{'club_gallery.cgi'}?action=transload&club=$FORM{'club'}&cat=$lc\">Transload Image</A> &nbsp; &nbsp; &nbsp; <A HREF=\"$GUrl{'club_gallery.cgi'}?action=upload&club=$FORM{'club'}&cat=$lc\">Upload Image</A>";
		}
		if ($FORM{'cat'} eq "") {
			$OUT .= " &nbsp; &nbsp; &nbsp; <A HREF=\"$GUrl{'club_gallery.cgi'}?action=viewall&club=$FORM{'club'}\">View All Images</A>";
		}
		$OUT .= "</CENTER></TD></TR>\n";
	}

     	$OUT .= " <SCRIPT LANGUAGE=\"javascript\">\n";
     	$OUT .= " <!--\n";
     	$OUT .= " function OpenWin(Loc,Width,Height) {\n";
	$OUT .= "	var WinInfo = \"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=\" + Width + \",height=\" + Height\n";
	$OUT .= " 	wPageWindow=window.open(Loc,\"wImageWindow\",WinInfo);\n";
     	$OUT.= "  	wImageWindow.focus();\n";
     	$OUT .= " 	   }\n";
     	$OUT .= " 	// -->\n";
     	$OUT .= " 	</SCRIPT>\n";
	$OUT .= "</BODY>\n";
	$OUT .= "</HTML>\n";
}

sub save_gallery {
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
		if (-d "$dir/") {}
		else {
			mkdir("$dir",0777) || &diehtml("Can't Create $dir: $!");
		}

		@lines = split(/(\n|\cM)/, $FORM{'gallerycats'});
	
		open (FILE, ">$dir/g_cats.txt");
		foreach $l (@lines) {
			$l =~ s/(\n|\cM)//g;
			if ($l ne "") {
				print FILE "$l\n";
			}
		}
		close (FILE);
		open (FILE, ">$dir/g_intro.txt");
		print FILE "$FORM{'introtext'}";
		close (FILE);

		open (FILE, ">$dir/g_settings.txt");
		print FILE "$FORM{'admin_only'}";
		close (FILE);

		chmod (0777, "$dir/g_intro.txt");
		chmod (0777, "$dir/g_cats.txt");
		chmod (0777, "$dir/g_settings.txt");
	}
}

sub admin_form {
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
		open (FILE, "$dir/g_cats.txt");
		@cats = <FILE>;
		close (FILE);
		foreach $c (@cats) {
			$gallerycats .= $c;
		}

		open (FILE, "$dir/g_intro.txt");
		@intro = <FILE>;
		close (FILE);
		foreach $l (@intro) {
			$introtext .= $l;
		}

		open (FILE, "$dir/g_settings.txt");
		@t = <FILE>;
		close (FILE);
		$admig_only = $t[0];

		$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME=\"create_form\" METHOD=\"POST\" ACTION=\"$GUrl{'club_gallery.cgi'}\">\n";
		$BODY .= "<TABLE BORDER=\"1\" WIDTH=400>\n";
		$BODY .= "<TR BGCOLOR=\"$CONFIG{'title_color'}\">\n";
		$BODY .= "<TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Club Gallery Settings</FONT></B></CENTER></TD></TR>\n";
		$BODY .= "<TR $CONFIG{'WINCOLOR'}>\n";
		$BODY .= "<TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
		$BODY .= "What \"intro\" text would you like to include at the top of your gallery? (<I>HTML is allowed</I>)<BR>\n";
		$BODY .= "<TEXTAREA NAME=introtext COLS=30 ROWS=6>$introtext</TEXTAREA>\n";
		$BODY .= "<P>Please enter the categories of images that you would like to use one per line (there must be atleast one): <I>Whenever an image is added it will be placed in one of these</I>.<BR>\n";
		$BODY .= "<TEXTAREA NAME=gallerycats COLS=30 ROWS=6>$gallerycats</TEXTAREA>\n";
		$BODY .= "<P>Do you want to be the only one who can upload images?";
		if ($admin_only eq "T") {
			$BODY .= "<INPUT TYPE=CHECKBOX NAME=\"admin_only\" VALUE=T CHECKED>\n";
		}
		else {
			$BODY .= "<INPUT TYPE=CHECKBOX NAME=\"admin_only\" VALUE=T>\n";
		}
		$BODY .= "<INPUT TYPE=HIDDEN NAME=\"club\" VALUE=\"$FORM{'club'}\">\n";
		$BODY .= "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"save_gallery\">\n";
		$BODY .= "<P><CENTER><INPUT TYPE=SUBMIT VALUE=\"Save!\"></CENTER>\n";
		$BODY .= "</FORM></TD></TR></TABLE>\n";
	}
}	



sub error_not_logged_in {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt";

	&print_output('error');  
}





sub upload_file {
	$| = 1;

	$hold_buffer = $buffer;
	$buffer =~ /^(.+)\r\n/;
	$bound = $1;
	@parts = split(/$bound/,$buffer);



	$filename=$parts[1];  ##1
	$parts[1] =~ s/\r\nContent\-Disposition.+\r\n//g;
	$parts[1] =~ s/Content\-Type.+\r\n//g;
	$parts[1] =~ s/^\r\n//;

	@subparts = split(/\r\n/,$parts[4]); ##2

	$filename =~ s/Content-Disposition\: form-data\; name=\"uploaded_file\"\; filename\=//g;
	@stuff=split(/\r/,$filename);
	$filename = $stuff[1];
	$filename =~ s/\"//g;
	$filename =~ s/\r//g;
	$filename =~ s/\n//g;

	@a=split(/\\/,$filename);
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\//,$fname);		#then ignore stuff before last forwardslash for Unix machines
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\:/,$fname);		#then ignore stuff before last ":" for Macs?
	$totalT = @a;
	--$totalT;
	$fname=$a[$totalT];

	@a=split(/\"/,$fname);		#now we've got the real filename
	$filename=$a[0];

	&get_form_data;

	$upload_directory = $CONFIG{'PAGEMASTER_base'} . "/" . $IUSER{'community'} . "/" . $UserName . "/";


	if (($filename !~ /\.gif$/) && ($filename !~ /\.jpg$/)) {
		$BODY .= "<TABLE WIDTH=550 CELLPADDING=0 CELLSPACING=0>\n";
		$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Error</B></FONT></CENTER></TD></TR>\n";
		$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	   	$BODY .= "<FONT=+1></B>The file you are trying to upload is not among the allowed types, you are only allowed to upload gif or jpg files.</B></FONT>\n";
		$BODY .= "</TD></TR></TABLE>\n";
		&print_output('error');
	}

	if($parts[1] !~ /[\w\d]/) {
		$BODY .= "<TABLE WIDTH=550 CELLPADDING=0 CELLSPACING=0>\n";
		$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Error</B></FONT></CENTER></TD></TR>\n";
		$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	   	$BODY .= "<FONT=+1></B>You did not provide a file to be uploaded or it is empty.</B></FONT>\n";
		$BODY .= "</TD></TR></TABLE>\n";
		&print_output('error');
	}
	$image = $parts[1];
	return $filename;
}


sub get_form_data{
	$hold_buffer =~ s/\n//g;
	$hold_buffer =~ s/\r//g;

	$buffer1 = $hold_buffer;
	$buffer1 =~ /category"(.*?)\-\-\-/;
	$category = $1;
	$buffer2 = $hold_buffer;
	$buffer2 =~ /club"(.*?)\-\-\-/;
	$club = $1;
	$buffer3 = $hold_buffer;
	$buffer3 =~ /description"(.*?)\-\-\-/;
	$description = $1;
}


sub parse_FORM_local {

	if (length($buffer) < 5) {
		$buffer = $ENV{QUERY_STRING};
	}
	my @pairs = split(/&/, $buffer);

	my $text2check = undef;
	my $rn = time;
	foreach $pair (@pairs) {
		my ($name, $value) = split(/=/, $pair);

		# Un-Webify plus signs and %-encoding
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($0 !~ /admin/) {  #Let's assume that the admin knows what it's doing
			if ($value =~ /(exec cmd|exec cgi|include virtual)/i) {
				&io_flag_activity($rn, $ENV{'REMOTE_ADDR'}, $FORM{'UserName'}, "Serverside Include Attempted", $PROGRAM_NAME);
			}
			$value =~ s/exec cmd/ /ig;
			$value =~ s/exec cgi/ /ig;
			$value =~ s/include virtual/ /ig;
		}
		if ($FORM{$name}) {
			if (! $FORM2{$name}) {
				$FORM2{$name} = $FORM{$name} . " " . $value;
			}
			else {
				$FORM2{$name} .= " " . $value;
			}
		}
		$FORM{$name} = $value;
		if ($FORM{$name} eq "NA") {$FORM{$name} = "";}
		$text2check .= " " . $value;
	}
	if ($0 !~ /admin/) {  #Let's assume that the admin knows what it's doing
		if (($CONFIG{'COMMUNITY_monitor_Words'} eq "YES") && ($FORM{'badwords_override'} ne "T")) { 
			my $badwords = &Check_For_Bad_Words($text2check, "flagged"); 
			if ($badwords ne "") {
				$Bad_Words_Message =~ s/(\n|\cM)/ /g;
				&io_flag_activity($rn, $ENV{'REMOTE_ADDR'}, $FORM{'UserName'}, $Bad_Words_Message, $PROGRAM_NAME);
			}
		}
     		if (($CONFIG{'COMMUNITY_monitor_Words'} eq "YES") && ($FORM{'badwords_override'} ne "T"))  {
			my $badwords = &Check_For_Bad_Words($text2check, "bad");
	 		if ($badwords ne "") {
				print "Location: $CONFIG{'COMMUNITY_bad_words'}\n\n";
				exit 0;
			}
		}
	}

	$FORM{'UserName'} =~ tr/A-Z/a-z/;
	$FORM{'PassWord'} =~ tr/A-Z/a-z/;

}



sub save_file {
	$fn = $_[0];
	if (-e "$CONFIG{'CLUB_image_path'}/$club/photos/") {}
	else {
		mkdir ("$CONFIG{'CLUB_image_path'}/$club/", 0777);
		mkdir ("$CONFIG{'CLUB_image_path'}/$club/photos/", 0777);
		mkdir ("$CONFIG{'CLUB_image_path'}/$club/thumbs/", 0777);
	}

	open (REAL, ">$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
	print REAL $image;
	close (REAL);

	($tw, $th) = &imgsize("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");

	if (($CONFIG{'CLUB_thumb_width'} < $tw) && ($CONFIG{'CLUB_thumb_height'} < $th)) {
		$result1 = `./iresize -w $CONFIG{'CLUB_thumb_width'} -h $CONFIG{'CLUB_thumb_height'} $CONFIG{'CLUB_image_path'}/$club/photos/$fn $CONFIG{'CLUB_image_path'}/$club/thumbs/$fn`;
	}
	else {
		copy ("$CONFIG{'CLUB_image_path'}/$club/photos/$fn", "$CONFIG{'CLUB_image_path'}/$club/thumbs/$fn");
	}

	if (($CONFIG{'CLUB_photo_width'} < $tw) && ($CONFIG{'CLUB_photo_height'} < $th)) {
		$result2 = `./iresize -w $CONFIG{'CLUB_photo_width'} -h $CONFIG{'CLUB_photo_height'} -f $CONFIG{'CLUB_image_path'}/$club/photos/$fn $CONFIG{'CLUB_image_path'}/$club/photos/$fn`;
	}

	($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
	$CLUB_photo_bytes = $CONFIG{'CLUB_photo_kb'} * 1048;
	if ($CLUB_photo_bytes < $size) {
		unlink ("$CONFIG{'CLUB_image_path'}/$club/thumbs/$fn");
		unlink ("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
		&error("This file is too large.  The maximum filesize allowed is $CONFIG{'CLUB_photo_kb'} KB.");
	}

	$CLUB_max_bytes = $CONFIG{'CLUB_max_kb'} * 1048;
	&get_image_info;
	if ($totalsize > $CLUB_max_bytes) {
		unlink ("$CONFIG{'CLUB_image_path'}/$club/thumbs/$fn");
		unlink ("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
		&error("Uploading this file would put you over the club's file limit of $CONFIG{'CLUB_max_kb'} KBs.  You might want to try a smaller file.");
	}
	if ($filecount > $CONFIG{'CLUB_max_images'}) {
		unlink ("$CONFIG{'CLUB_image_path'}/$club/thumbs/$fn");
		unlink ("$CONFIG{'CLUB_image_path'}/$club/photos/$fn");
		&error("Uploading this file would put you over the club's file limit of $CONFIG{'CLUB_max_images'} images.  You might want to try deleting older files.");
	}
}

sub get_image_info {
	opendir(FILES, "$CONFIG{'CLUB_image_path'}/$club/photos/") || &diehtml("Can't open $CONFIG{'CLUB_image_path'}/$club/photos/");
    	while($file = readdir(FILES)) {
		if ($file =~ /(\.jpg|\.gif)/) {
			($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$CONFIG{'CLUB_image_path'}/$club/photos/$file");
			$filecount++;
			$totalsize = $totalsize + $size;
		}
	}
    	while($file = readdir(FILES)) {
		if ($file =~ /(\.jpg|\.gif)/) {
			($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$CONFIG{'CLUB_image_path'}/$club/thumbs/$file");
			$totalsize = $totalsize + $size;
		}
	}
}


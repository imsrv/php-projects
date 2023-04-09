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

use LWP::Simple;


use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'imagesize.pm'}";
require "$GPath{'cf.pm'}";


read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

#BODY .= "BUFFER: $buffer<BR><BR>\n";

$tmpbuffer = "$buffer\n";
$tmpbuffer =~ s/\s//g;

if (($tmpbuffer =~ /uploadthis/i)) {
	$fn = &upload_file;
	$ext = &save_file($fn);
	&log_upload($FORM{'club'});
	print "Location: $GUrl{'clubs.cgi'}?club=$FORM{'club'}&action=intro\n\n";	
}

&parse_FORM_local;

&validate_session_no_error;

%IFORUM = &readbbs("$GPath{'cforums_data'}/$FORM{'club'}.cfg", 1);
if ($FORM{'forum'} ne "") {
	%MOD = &get_moderator($IFORUM{'bbs_admin'});
}

($VALIDUSER, %IUSER) = &validate_session_no_error;  # Let's if this user is valid

if ($VALIDUSER eq "T") {
	&get_personal_settings;
}



if ($FORM{'action'} eq "") {
	&print_form;
	&print_output('club_mod');
}

elsif ($FORM{'action'} eq "Transload This File") {
	$fn = &transload_file;
	$ext = &save_file($fn);
	print "Location: $GUrl{'clubs.cgi'}?club=$FORM{'club'}&action=intro\n\n";	
}




sub transload_file {
	$image = get($FORM{'transload_file'});
	$filename = $FORM{'transload_file'};
	$filename =~ s/.*\///;
	return $filename;
}




sub save_file {
	$fn = $_[0];

	@f = split(/\./, $fn);

	unlink ("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/icon.jpg");
	unlink ("$CONFIG{'CLUB_image_path'}/$FORM{'club'}/icon.gif");

	open (REAL, ">$CONFIG{'CLUB_image_path'}/$FORM{'club'}/icon.$f[1]");
	print REAL $image;
	close (REAL);

	$result1 = `./iresize -f -w 150 -h 150 $CONFIG{'CLUB_image_path'}/$FORM{'club'}/icon.$f[1] $CONFIG{'CLUB_image_path'}/$FORM{'club'}/icon.$f[1]`;

	return $f[1];
}






sub print_form {
	$BODY .= "<TABLE WIDTH=550 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Upload/Transload Icon for $title</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "The image will be resized to best fit the design of the intro page.\n";

	$BODY .= "<CENTER><form ENCTYPE=\"multipart/form-data\" METHOD=\"POST\" action=\"$GUrl{'club_upload_icon.cgi'}\">\n";
    	$BODY .= "<TABLE BORDER=\"4\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    	$BODY .= "<TR BORDER=\"0\" $CONFIG{'WINCOLOR'}>\n";
    	$BODY .= "<TD BORDER=\"0\">\n";
	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
    	$BODY .= "<B>Enter File For Upload....</B><A HREF=\"javascript:OpenHelpWin(\'$GUrl{'help.cgi'}?action=upload\');\"><I><B>Help/Hints</B></I></A><BR>\n";
	$BODY .= "<B>Select a File:</B><input type=\"file\" name=\"uploaded_file\"><BR>\n";
	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<input type=hidden name=\"club\" value=\"$FORM{'club'}\">\n";
	$BODY .= "<input type=hidden name=\"UserName\" value=\"$FORM{'UserName'}\">\n";
	$BODY .= "<input type=hidden name=\"PassWord\" value=\"$FORM{'PassWord'}\">\n";
	$BODY .= "<P><center><input type=submit name=\"uploadthis\" value=\"Upload This File\">\n";
    	$BODY .= "</TD></TR></TABLE>\n";
    	$BODY .= "</FORM>\n";

	$BODY .= "<CENTER><form ENCTYPE=\"application/x-www-form-urlencoded\" METHOD=\"POST\" action=\"$GUrl{'club_upload_icon.cgi'}\">\n";
    	$BODY .= "<TABLE BORDER=\"4\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    	$BODY .= "<TR BORDER=\"0\" $CONFIG{'WINCOLOR'}>\n";
    	$BODY .= "<TD BORDER=\"0\">\n";
	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
    	$BODY .= "<B>Enter File For Transloading....</B><A HREF=\"javascript:OpenHelpWin(\'$GUrl{'help.cgi'}?action=fetch\');\"><I><B>Help/Hints</B></I></A><BR>\n";
	$BODY .= "<B>Select a File:</B><input type=\"text\" name=\"transload_file\" value=\"http://\"><BR>\n";
	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<input type=hidden name=\"club\" value=\"$FORM{'club'}\">\n";
	$BODY .= "<input type=hidden name=\"PassWord\" value=\"$FORM{'PassWord'}\">\n";
	$BODY .= "<input type=hidden name=\"UserName\" value=\"$FORM{'UserName'}\">\n";
	$BODY .= "<P><center><input type=submit name=\"action\" value=\"Transload This File\">\n";
    	$BODY .= "</TD></TR></TABLE>\n";
    	$BODY .= "</FORM>\n";

	$BODY .= "</TD></TR></TABLE>\n";

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
	$buffer2 = $hold_buffer;
	$buffer1 =~ /club"(.*?)\-\-\-/;
	$FORM{'club'} = $1;
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





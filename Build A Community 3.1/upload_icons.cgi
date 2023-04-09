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

use DB_File;
use LWP::Simple;

$userpm = "T";
require "./common.pm";


if ($ENV{'REQUEST_METHOD'} eq "GET"){
	&print_login_form;
	&print_output('profile');
}

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

$tmpbuffer = "$buffer\n";
$tmpbuffer =~ s/\s//g;

if (($tmpbuffer =~ /uploadthis/i)) {
	($VALID, %IUSER) = &validate_session;
	$fn = &upload_file;
	$ext = &save_file($fn);
	&update_profile;
	&return_html($ext);
	&print_output('forms');
}


&parse_FORM_local;

if ($FORM{'action'} eq "Get Password"){
	&email_password($FORM{'UserName'}, $FORM{'Email'});
}

if ($FORM{'action'} eq "") {
	$rnd=int rand 10000;
	print "Location: $GUrl{'profile.cgi'}?action=okay&$rnd\n\n";
	exit;
}
elsif ((($FORM{'action'} ne "") && ($ENV{'HTTP_COOKIE'} ne "")) && (($FORM{'action'} ne "Login") && ($FORM{'action'} ne "Continue"))) { 
	($VALID, %IUSER) = &validate_session;
}
elsif (($FORM{'action'} eq "Continue") || ($FORM{'action'} eq "Login")) {
	%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
	print "Location: $GUrl{'profile.cgi'}?action=okay&$rnd\n";
	&basic_cookie;
	print "\n";
}
else {
	&build_login_form;
	&print_output('login');
}


if (($FORM{action} eq "Change Icon") || ($FORM{action} eq "Upload/Transload Your Own Image")) {
	&print_form;
	&print_output('profile');
}
elsif ($FORM{'action'} eq "Transload This File") {
	$fn = &transload_file;
	$ext = &save_file($fn);
	&update_profile;
	&return_html($ext);
	&print_output('forms');
}

&print_form;



sub transload_file {
	$image = get($FORM{'transload_file'});
	$filename = $FORM{'transload_file'};
	$filename =~ s/.*\///;
	return $filename;
}

sub build_login_form {
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";
}


sub update_profile {
	require "./cm/user_changes.pm";
	if ($IUSER{'icon'} ne $FORM{'Icon'}) {
		&change_icon($IUSER{'filenum'}, $IUSER{'username'},$IUSER{'password'},"$IUSER{'username'}.$ext", \%IUSER);
	}
	&return_html;
}


sub save_file {
	$fn = $_[0];

	@f = split(/\./, $fn);

	if (-e "$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'username'}.jpg") {
		unlink ("$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'username'}.jpg");
		unlink ("$CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.jpg");
	}
	if (-e "$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'username'}.gif") {
		unlink ("$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'username'}.gif");
		unlink ("$CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.gif");
	}
	$BODY .= "$CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.$f[1]\n";

	open (REAL, ">$CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.$f[1]");
	print REAL $image;
	close (REAL);

	$result1 = `./iresize -w $CONFIG{'small_image_width'} -h $CONFIG{'small_image_height'} $CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.$f[1] $CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'username'}.$f[1]`;
	$result2 = `./iresize -w $CONFIG{'large_image_width'} -h $CONFIG{'large_image_height'} -f $CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.$f[1] $CONFIG{'ICON_upload_path'}/images/$IUSER{'username'}.$f[1]`;

	return $f[1];
}



sub return_html {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cmuploadicon/confirm.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cmuploadicon/confirm.tmplt";
}



sub print_form {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cmuploadicon/form.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cmuploadicon/form.tmplt";
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
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cmuploadicon/invalidtype.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cmuploadicon/invalidtype.tmplt";
		&print_output('error');
	}

	if($parts[1] !~ /[\w\d]/) {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cmuploadicon/badfile.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cmuploadicon/badfile.tmplt";
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
	$buffer1 =~ /UserName"(.*?)\-\-\-/;
	$UserName = $1;
	$buffer2 =~ /PassWord"(.*?)\-\-\-/;
	$PassWord = $1;
	$FORM{'UserName'} = $UserName;
	$FORM{'PassWord'} = $PassWord;
}


sub parse_FORM_local {

   	# Get the input
   	if (length($buffer) < 5) {
         	$buffer = $ENV{QUERY_STRING};
    	}
   	# Split the name-value pairs
   	@pairs = split(/&/, $buffer);

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





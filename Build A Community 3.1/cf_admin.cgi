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

$max_groups = 10;


use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'cf.pm'}";


$PROGRAM_NAME = "cf_admin.cgi";


&Validate_Admin_Local;


&parse_FORM_l;

	$forumdb = "$GPath{'cforums_data'}/$FORM{'forum'}.db";
	$threadsdb = "$GPath{'cforums_data'}/$FORM{'forum'}_threads.db";
	$authorsdb = "$GPath{'cforums_data'}/authors.db";
	$keywordsdb = "$GPath{'cforums_data'}/keywords.db";
	$PROG_URL = "$CONFIG{'CGI_DIR'}/hforum.cgi";

if (($FORM{'action'} eq "admin") || ($FORM{'action'} eq "")) {
	&admin;
}


if ($FORM{'action'} eq "create forums") {
	&create_forum;
}

if ($FORM{'action'} eq "Save Forum Configuration") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_forum;
}


if ($FORM{'action'} eq "menu") {
	&menu;
}

if ($FORM{'action'} eq "Edit Emails") {
	&edit_emails;
}

if ($FORM{'action'} eq "Edit Forums") {
	&edit_forum;
}

if ($FORM{'action'} eq "Setup Categories") {
	&setup_categories;
}

if ($FORM{'action'} eq "Save Category Setup") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Save_Category_Setup;
}

if ($FORM{'action'} eq "Edit Templates") {
	&edit_templates;
}

if ($FORM{'action'} eq "Open Template") {
	&open_templates;
}

if ($FORM{'action'} eq "Save Template") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_template;
}

if ($FORM{'action'} eq "Save Email Text") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_emails;
}

if ($FORM{'action'} eq "Purge Cards") {
	&purge_cards;
}

if ($FORM{'action'} eq "edit_emails") {
	&edit_emails;
}

if ($FORM{'action'} eq "Save Email Text") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_emails;
}

if ($FORM{'action'} eq "Save Categories") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_categories;
}

if ($FORM{'action'} eq "Define Categories") {
	&define_categories;
}

if ($FORM{'action'} eq "badwords") {
	&edit_badwords;
}

if ($FORM{'action'} eq "Save Words") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_badwords;
}

if ($FORM{'action'} eq "help_files") {
	&help_files;
}

if ($FORM{'action'} eq "Save Help Files") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_help_files;
}

if ($FORM{'action'} eq "set_admin") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&set_admin;
}

if ($FORM{'action'} eq "replacements") {
	&replacements;
}

if ($FORM{'action'} eq "Save Administrative User") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_admin;
}


if ($FORM{'action'} eq "post_categories") {
	&post_categories;
}

if ($FORM{'action'} eq "Save Post Categories") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_post_categories;
}


if ($FORM{'action'} eq "Save Replacements") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_replacements;
}

if ($FORM{'action'} eq "backups") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&backups;
}

if ($FORM{'action'} eq "Delete Forum") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&delete_forum;
}

if ($FORM{'action'} eq "reports") {
	&generate_reports;
}


print "Content-type: text/html\n\n";
print "Something did not work!\n";
exit;

sub create_forum {
	&forum_form;
	exit;
}

sub delete_forum {
	if ($data_dir && $FORM{'forum'}) {
		system("rm -f $data_dir/cforums/$FORM{'forum'}%*");
		system("rm -f $data_dir/cforums/$FORM{'forum'}.*");
		system("rm -f $data_dir/cforums/$FORM{'forum'}_*");

		if ($FORM{'CLUB_image_path'}) {
			system("rm -rf $CLUB_image_path/$FORM{'forum'}/");
			system("rm -rf $data_dir/clubs/$FORM{'forum'}/");
		}

		open(CAT,"$GPath{'cforums_data'}/forum.categories");
		@CATS = <CAT>;
		close (CAT);

		open(CAT,">$GPath{'cforums_data'}/forum.categories");
		foreach my $c (@CATS) {
			my ($ct) = split (/\:/, $c);
			if ($ct eq $FORM{'forum'}) {next;}
			print CAT $c;
		}
		close (CAT);
	}
	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Forum/Club Deleted!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub post_categories {
	$fn = "$GPath{'cforums_data'}/post.categories";
	open(FILE, "$fn");
 		@PCATS = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Post Categories</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "Whenever a member posts a message in a forum or club, they must select what type of post it shall be.  You can select the types that are available below and what image, if any, are displayed for that type.\n";
	print "<P>\n";

	print "<TABLE BORDER>\n";
	foreach $line (@PCATS) {
		$count++;
		$line =~ s/\cM//g;
		$line =~ s/\n//g;
		@rep = split(/\|\|/, $line);
		print "<TR><TD><TEXTAREA NAME=\"a$count\" ROWS=1 COLS=30>$rep[0]</TEXTAREA></TD><TD><TEXTAREA NAME=\"b$count\" ROWS=1 COLS=30>$rep[1]</TEXTAREA></TD></TR>\n";
	}
	for $x (0..9) {
		$count++;
		print "<TR><TD><TEXTAREA NAME=\"a$count\" ROWS=1 COLS=30></TEXTAREA></TD><TD><TEXTAREA NAME=\"b$count\" ROWS=1 COLS=30></TEXTAREA></TD></TR>\n";
	}
	print "<INPUT TYPE=hidden NAME=\"count\" VALUE=$count>\n";
	print "</TABLE>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Post Categories\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}


sub replacements {
	$fn = "$GPath{'cforums_data'}/replacements.dat";
	open(FILE, "$fn");
 		@REPLACEMENTS = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Text Replacements</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "Text replacements allow certain text to be replaced with other text and HTML.  As an example, you could replace a smiley face written in text <B>:)</B> with a smiley face icon <IMG SRC=\"/members/images/tokens/emoticons/1.gif\">.\n";
	print "<P>\n";

	print "<TABLE BORDER>\n";
	foreach $line (@REPLACEMENTS) {
		$count++;
		$line =~ s/\cM//g;
		$line =~ s/\n//g;
		@rep = split(/\|\|/, $line);
		print "<TR><TD><TEXTAREA NAME=\"a$count\" ROWS=1 COLS=30>$rep[0]</TEXTAREA></TD><TD><TEXTAREA NAME=\"b$count\" ROWS=1 COLS=30>$rep[1]</TEXTAREA></TD></TR>\n";
	}
	for $x (0..9) {
		$count++;
		print "<TR><TD><TEXTAREA NAME=\"a$count\" ROWS=1 COLS=30></TEXTAREA></TD><TD><TEXTAREA NAME=\"b$count\" ROWS=1 COLS=30></TEXTAREA></TD></TR>\n";
	}
	print "<INPUT TYPE=hidden NAME=\"count\" VALUE=$count>\n";
	print "</TABLE>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Replacements\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub backups {
	$dn = "$GPath{'cforums_data'}/";
	opendir(FILES, "$dn") || &diehtml("Can't open $dn");
    	while($file = readdir(FILES)) {
        	if ($file =~ /\.db$/) {
			tie %data, "DB_File", "$dn/$file";
			$nfile = $file;
			$nfile =~ s/\.db$/\.txt/;
			open (FILE, ">$GPath{'cforums_data'}/backup/$nfile");
			foreach $x (keys %data) {
				print FILE "$x=\|=$data{$x}\n";
			}
			close (FILE);
		}
	}
	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Backups Created!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<B>You can find your backups at:<BR>$GPath{'cforums_data'}/backup/.</B>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;			
}


sub save_post_categories {
	$fn = "$GPath{'cforums_data'}/post.categories";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	for $x (0 .. $FORM{'count'}) {
		$a = "a$x";
		$b = "b$x";
		if ($FORM{$a} ne "") {
			print FILE "$FORM{$a}\|\|$FORM{$b}\n";
		}
	}
	
	close(FILE);
	chmod 0777, "$fn";


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}

sub save_replacements {
	$fn = "$GPath{'cforums_data'}/replacements.dat";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	for $x (0 .. $FORM{'count'}) {
		$a = "a$x";
		$b = "b$x";
		if ($FORM{$a} ne "") {
			print FILE "$FORM{$a}\|\|$FORM{$b}\n";
		}
	}
	
	close(FILE);
	chmod 0777, "$fn";


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub set_admin {
	$fn = "$GPath{'cforums_data'}/god.dat";
	open(FILE, "$fn");
 		@GOD = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Set Administrative User</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "The <I>Administrative User</I> has moderator status in all forums, meaning that they can edit or delete anything.\n";
	print "<P>\n";

	print "<H3>Enter the User ID (number) of the of Administrative User:</H3>\n";
	print "<INPUT TYPE=TEXT SIZE=18 NAME=GOD VALUE=$GOD[0]>";
	print "<P>\n";


	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Administrative User\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_admin {
	$fn = "$GPath{'cforums_data'}/god.dat";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'GOD'}";
	close(FILE);
	chmod 0777, "$fn";


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub help_files {
	$fn = "$GPath{'cforums_data'}/codes.help";
	open(FILE, "$fn");
 		@CODES = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/iforum.help";
	open(FILE, "$fn");
 		@WELCOME = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/templates.help";
	open(FILE, "$fn");
 		@TEMPLATES = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/club_settings.help";
	open(FILE, "$fn");
 		@CLUBSETTINGS = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/club_create.help";
	open(FILE, "$fn");
 		@CLUBCREATE = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/club_gettingaround.help";
	open(FILE, "$fn");
 		@CLUBGETTINGAROUND = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Help Files</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "These help files are presented to users when they click the help buttons.\n";
	print "<P>\n";

	if (! -e "clubs.cgi") {
		print "<H3>Welcome to the forums (Main Page):</H3>\n";
		print "<TEXTAREA NAME=WELCOME COLS=40 ROWS=10 WRAP=VIRTUAL>";
		foreach $line(@WELCOME) {
			print "$line";
		}
		print "</TEXTAREA>\n";
		print "<P>\n";

		foreach $line(@CLUBGETTINGAROUND) {
			$l .= "$line";
		}
		print "<INPUT TYPE=hidden NAME=CLUBGETTINGAROUND VALUE=\"$l\">\n";

	}
	else {
		foreach $line(@WELCOME) {
			$l .= "$line";
		}
		print "<INPUT TYPE=hidden NAME=WELCOME VALUE=\"$l\">\n";

		print "<H3>Welcome to the Clubs (Shown in the index):</H3>\n";
		print "<TEXTAREA NAME=CLUBGETTINGAROUND COLS=40 ROWS=10 WRAP=VIRTUAL>";
		foreach $line(@CLUBGETTINGAROUND) {
			print "$line";
		}
		print "</TEXTAREA>\n";
		print "<P>\n";

	}

	print "<H3>Special Codes & Replacements:</H3>\n";
	print "<TEXTAREA NAME=CODES COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@CODES) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	if (-e "clubs.cgi") {
		print "<H3>Club Creation Help (<I>How to create a club</I>:</H3>\n";
		print "<TEXTAREA NAME=CLUBCREATE COLS=40 ROWS=10 WRAP=VIRTUAL>";
		foreach $line(@CLUBCREATE) {
			print "$line";
		}
		print "</TEXTAREA>\n";
		print "<P>\n";
	}

	print "<H3>Club/Forum Settings and Options (Moderators Only):</H3>\n";
	print "<TEXTAREA NAME=CLUBSETTINGS COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@CLUBSETTINGS) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<H3>Template Setup (for moderators who have permission to edit forum appearance):</H3>\n";
	print "<TEXTAREA NAME=TEMPLATES COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@TEMPLATES) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Help Files\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_help_files {
	$fn = "$GPath{'cforums_data'}/codes.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'CODES'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/iforum.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'WELCOME'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/templates.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEMPLATES'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/club_settings.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'CLUBSETTINGS'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/club_create.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'CLUBCREATE'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/club_gettingaround.help";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'CLUBGETTINGAROUND'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<B>FILE ($fn) Saved.</B>\n";
      print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub edit_forum {
	open (CFG, "$GPath{'cforums_data'}/$FORM{'forum'}.cfg");
	@bbscfg = <CFG>;
	close(CFG);

	$tmp_config = $bbscfg[0];
	@config = split (/\|/, $tmp_config);

	$title = $config[0]; 
	$CONFIG{'pg_color'} = $config[1]; 
	$CONFIG{'win_color'} = $config[2]; 
	$CONFIG{'font_face'} = $config[3]; 
	$CONFIG{'text_color'} = $config[4]; 
	$CONFIG{'title_color'} = $config[5]; 
	$CONFIG{'ttxt_color'} = $config[6]; 
	$IFORUM{'bbs_admin'} = $config[7];
      $access = $config[8];
      $restrictedto = $config[9];
      $group = $config[10];
      $newthreads = $config[11];
      $moderated = $config[12];
	$emailmoderator = $config[13];
      $moderator_edit = $config[14];
      $CONFIG{'bbs_table1'} = $config[15];
      $CONFIG{'bbs_table2'} = $config[16];
      $CONFIG{'highlightcolor'} = $config[17];
      $CONFIG{'topic_color'} = $config[18];
	$public = $config[19];
	$status = $config[20];
	$applicantmessage = $config[21];
	$clubforum = $config[22];
	$CONFIG{'CLUB_max_kb'} = $config[23];
	$CONFIG{'CLUB_max_images'} = $config[24];
      $bbs_private_pw = $config[26];
	$bbs_private_pw =~ s/\n//g;
	$bbs_desc = $bbscfg[1];
	$forum = $FORM{'forum'};

	&forum_form;
	exit;
}

sub save_forum {
	$FORM{'forum'} =~ s/[^,\w]//g;
	$FORM{'applicantmessage'} =~ s/(\cM|\n)//g;

	open (CFG, ">$GPath{'cforums_data'}/$FORM{'forum'}.cfg");
      print CFG "$FORM{'title'}|";
      print CFG "$FORM{'pg_color'}|";
      print CFG "$FORM{'win_color'}|";
      print CFG "$FORM{'font_face'}|";
      print CFG "$FORM{'text_color'}|";
      print CFG "$FORM{'title_color'}|";
      print CFG "$FORM{'ttxt_color'}|";
      print CFG "$FORM{'bbs_admin'}|";
      print CFG "$FORM{'access'}|";
      print CFG "$FORM{'restrictedto'}|";
      print CFG "$FORM{'group'}|";
      print CFG "$FORM{'newthreads'}|";
      print CFG "$FORM{'moderated'}|";
      print CFG "$FORM{'emailmoderator'}|";
      print CFG "$FORM{'moderator_edit'}|";
      print CFG "$FORM{'bbs_table1'}|";
      print CFG "$FORM{'bbs_table2'}|";
      print CFG "$FORM{'highlightcolor'}|";
      print CFG "$FORM{'topic_color'}|";
	print CFG "$FORM{'public'}|";
	print CFG "$FORM{'status'}|";
	print CFG "$FORM{'applicantmessage'}|";
      print CFG "$FORM{'clubforum'}|";
      print CFG "$FORM{'CLUB_max_kb'}|";
      print CFG "$FORM{'CLUB_max_images'}|";
	print CFG "|";
      print CFG "$FORM{'bbs_private_pw'}\n";
      print CFG "$FORM{'bbs_desc'}";
	close (CFG);

	$FORM{'members'} =~ s/(\cM|\n)/\n/g;
	open (FILE, ">$GPath{'cforums_data'}/$FORM{'forum'}.members");
	print FILE "$FORM{'members'}\n";
	close (FILE);

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "File ($GPath{'cforums_data'}/$FORM{'forum'}.cfg) Saved.\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'TEMPLATE'}\n";
	exit;
}

sub forum_form {
	for $x(0 .. $max_groups) {
		$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
	}
	open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}\.members");
	@f = <MEMBERS>;
	foreach $l (@f) {
		$l =~ s/(\cM|\n)//g;
		$CLUBMEMBERS .= "$l\n";
	}
	close (MEMBERS);

	if ($FORM{'action'} =~ /create/i) {
		$TITLE = "<H3>Create Forum</H3>";
		$FILENAMEOPTION = "<TR BGCOLOR=\"#ffffcc\"><TD><BR><B>Forum Name:</B> <INPUT TYPE=\"text\" SIZE=\"25\" MAXLENGTH=\"30\" NAME=\"forum\" VALUE=\"$forum\"><BR><I>Note: One Word only, no spaces ( _ is ok) no extension (This is a filename).</I></CENTER></TD></TR>\n";
	}
	else {
		$TITLE = "<H3>Edit Forum</H3>";
		$FILENAMEOPTION = "<INPUT TYPE=\"hidden\" NAME=\"forum\" VALUE=\"$forum\">\n";
	}

	print "Content-type: text/html\n\n";
        print <<DONE;
<HTML>
<HEAD>

<TITLE>$TITLE</TITLE>
</HEAD>
<BODY BGCOLOR="#cccc99" onLoad="document.create_form.forum.focus()">
<CENTER>
<BR><BR>
<form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME="create_form" METHOD="POST" ACTION="$GUrl{'cf_admin.cgi'}" ENCTYPE="x-www-form-urlencoded">
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH=600>
<TR>
<TD>

<TABLE BORDER="1" CELLSPACING="0" CELLPADDING="0">
<TR BGCOLOR="WHITE">
<TD><CENTER><B><FONT COLOR="BLACK">$TITLE</FONT></B></CENTER></TD></TR>
$FILENAMEOPTION
<TR BGCOLOR="#ffffcc">
<TD>
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="100%">
<TR BGCOLOR="#ffffcc">
<TD><B>Set the view options...</B><BR>
<TABLE>
  <TR><TD>Descriptive Name:</TD><TD><INPUT TYPE="text" NAME="title" VALUE = "$title" SIZE="25" onFocus="select()"></TD></TR>
  <TR><TD COLSPAN=2>(This will display in the forum title...)</TD></TR>

  <TR><TD COLSPAN=2>Forum Description:<BR>
    <TEXTAREA NAME="bbs_desc" ROWS=3 COLS=40>$bbs_desc</TEXTAREA></TD></TR>

  <TR><TD>Access Restrictions: </TD><TD> <SELECT NAME="access">
	<OPTION VALUE="$access">$access</OPTION>
	<OPTION VALUE="Open To All">Open To All (Default)</OPTION>
	<OPTION VALUE="Read-Only For Non-Privileged">Read-Only For Non-Privileged</OPTION>
	<OPTION VALUE="Private">Private</OPTION>
	<OPTION VALUE="Closed">Closed</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>If restricted, restriction method: </TD><TD> <SELECT NAME="restrictedto">
	<OPTION VALUE="$restrictedto">$restrictedto</OPTION>
	<OPTION VALUE="Club Members Only">Club Members Only</OPTION>
	<OPTION VALUE="User Group">User Group</OPTION>
	<OPTION VALUE="PassWord">PassWord</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>If restricted to group, select a group: </TD><TD> <SELECT NAME="group">
	<OPTION VALUE="$group">$group</OPTION>
	$GROUP_SELECT
	</SELECT>
  </TD></TR>

  <TR><TD VALIGN=TOP>If restricted to members, list members:</TD>
  <TD VALIGN=TOP><TEXTAREA NAME="members" ROWS=5 COLS=20>$CLUBMEMBERS
</TEXTAREA></TD></TR>

  <TR><TD COLSPAN=2>Applicant Message (shown to people applying for membership):<BR>
    <TEXTAREA NAME="applicantmessage" ROWS=3 COLS=40>$applicantmessage</TEXTAREA></TD></TR>

  <TR><TD>Status: </TD><TD> <SELECT NAME="status">
	<OPTION VALUE="$status">$status</OPTION>
	<OPTION VALUE="official">official</OPTION>
	<OPTION VALUE="recommended">recommended</OPTION>
	<OPTION VALUE="approved">approved</OPTION>
	<OPTION VALUE="unreviewed">unreviewed</OPTION>
	</SELECT>
  </TD></TR>

  <TR><TD>Is this forum public? Only public forums are listed in the forum index. </TD><TD> <SELECT NAME="public">
	<OPTION VALUE="$public">$public</OPTION>
	<OPTION VALUE="Yes">Yes</OPTION>
	<OPTION VALUE="No">No</OPTION>
	</SELECT>
  </TD></TR>

  <TR><TD>If restricted by password, private password:</TD><TD><INPUT TYPE="text" NAME="bbs_private_pw" SIZE="25" VALUE = "$bbs_private_pw" onFocus="select()"></TD></TR>
  <TR><TD>Administrator #ID:</TD><TD><INPUT TYPE="text" NAME="bbs_admin" SIZE="20" VALUE = "$IFORUM{'bbs_admin'}" onFocus="select()"></TD></TR>
  <TR><TD>Who is allowed to create new threads: </TD><TD> <SELECT NAME="newthreads">
	<OPTION VALUE="$newthreads">$newthreads</OPTION>
	<OPTION VALUE="Everyone">Everyone</OPTION>
	<OPTION VALUE="Moderator/Admin Only">Moderator/Admin Only</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>Is this forum moderated? (posts only appear after being approved by the moderator/admin): </TD><TD> <SELECT NAME="moderated">
	<OPTION VALUE="$moderated">$moderated</OPTION>
	<OPTION VALUE="Yes">Yes</OPTION>
	<OPTION VALUE="No">No</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>Is the moderator allowed to edit these settings? </TD><TD> <SELECT NAME="moderator_edit">
	<OPTION VALUE="$moderator_edit">$moderator_edit</OPTION>
	<OPTION VALUE="Yes">Yes</OPTION>
	<OPTION VALUE="No">No</OPTION>
	<OPTION VALUE="Settings Not Appearance">Settings Not Appearance</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>Email the moderator a copy of all posts as they are submitted? </TD><TD> <SELECT NAME="emailmoderator">
	<OPTION VALUE="$emailmoderator">$emailmoderator</OPTION>
	<OPTION VALUE="Yes">Yes</OPTION>
	<OPTION VALUE="No">No</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>Diskspace for Image Gallery (in KBs):</TD><TD><INPUT TYPE="text" NAME="CLUB_max_kb" SIZE="25" VALUE="$CONFIG{'CLUB_max_kb'}" onFocus="select()"></TD></TR>
  <TR><TD>Maximum Images:</TD><TD><INPUT TYPE="text" NAME="CLUB_max_images" SIZE="25" VALUE="$CONFIG{'CLUB_max_images'}" onFocus="select()"></TD></TR>
  <TR><TD>Is this a club or forum? </TD><TD> <SELECT NAME="clubforum">
	<OPTION VALUE="$clubforum">$clubforum</OPTION>
	<OPTION VALUE="Club">Club</OPTION>
	<OPTION VALUE="Forum">Forum</OPTION>
	</SELECT>
  </TD></TR>
  <TR><TD>Page Color:</TD><TD><INPUT TYPE="text" NAME="pg_color" SIZE="25" VALUE="$CONFIG{'pg_color'}" onFocus="select()"></TD></TR>
  <TR><TD>Window color:</TD><TD><INPUT TYPE="text" NAME="win_color" SIZE="25" VALUE="$CONFIG{'win_color'}" onFocus="select()"></TD></TR>
  <TR><TD>Window Font:</TD><TD><INPUT TYPE="text" NAME="font_face" SIZE="25" VALUE="$CONFIG{'font_face'}" onFocus="select()"></TD></TR>
  <TR><TD>Window Font Color:</TD><TD><INPUT TYPE="text" NAME="text_color" SIZE="25" VALUE="$CONFIG{'text_color'}" onFocus="select()"></TD></TR>
  <TR><TD>Title Bar Color:</TD><TD><INPUT TYPE="text" NAME="title_color" SIZE="25" VALUE="$CONFIG{'title_color'}" onFocus="select()"></TD></TR>
  <TR><TD>Title Bar Font Color:</TD><TD><INPUT TYPE="text" NAME="ttxt_color" SIZE="25" VALUE="$CONFIG{'ttxt_color'}" onFocus="select()"></TD></TR>
  <TR><TD>Alternating Color 1:</TD><TD><INPUT TYPE="text" NAME="bbs_table1" SIZE="25" VALUE="$CONFIG{'bbs_table1'}" onFocus="select()"></TD></TR>
  <TR><TD>Alternating Color 2:</TD><TD><INPUT TYPE="text" NAME="bbs_table2" SIZE="25" VALUE="$CONFIG{'bbs_table2'}" onFocus="select()"></TD></TR>
  <TR><TD>Highlighted Post Color:</TD><TD><INPUT TYPE="text" NAME="highlightcolor" SIZE="25" VALUE="$CONFIG{'highlightcolor'}" onFocus="select()"></TD></TR>
  <TR><TD>Topic Color (first post):</TD><TD><INPUT TYPE="text" NAME="topic_color" SIZE="25" VALUE="$CONFIG{'topic_color'}" onFocus="select()"></TD></TR>
</TABLE>
</TD></TR>
</TABLE>
<TR><TD><INPUT NAME="action" TYPE="hidden" VALUE="Save Forum Configuration">
<TR><TD><CENTER><INPUT TYPE="submit" VALUE="Save Changes!"></CENTER>
</TABLE>
</TABLE>
</FORM>
</CENTER>
</BODY>
</HTML>

DONE

}



sub edit_templates {
	$fn = "$GPath{'cforums_data'}/categories.def";
	open(FILE, "$fn");
 		@CATS = <FILE>;
	close(FILE);
	foreach $c (@CATS) {
		$c =~ s/(\cM|\n)//g;
		@tc = split(/\|/, $c);
		$c = "$tc[1]\|$tc[2]";
		push (@cats, $c);
	}

	opendir(FILES, "$GPath{'cforums_data'}/") || &diehtml("$GPath{'cforums_data'}/");
    	while($file = readdir(FILES)) {
     		if($file =~ /(.*)\.cfg/) {
			push(@forums,"$1");
		}
	}

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<BODY BGCOLOR=#cccc99>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=500>\n";
	print "<TR><TD><CENTER><H3>Edit Templates</H3></CENTER></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "<SELECT NAME=\"template2edit\">\n";
	print "<OPTION VALUE=\"bbs.txt\">Community Forums Default</OPTION>\n";
	print "<OPTION VALUE=\"cf_utils\">Community Forums Utilities</OPTION>\n";
	print "<OPTION VALUE=\"bbs_help.txt\">Community Forums Help</OPTION>\n";
	print "<OPTION VALUE=\"cforum_mod.txt\">Forum Settings (Moderator's View)</OPTION>\n";
	if (-e "clubs.cgi") {
		print "<OPTION VALUE=\"club.txt\">Auto-Club Default Forum Template</OPTION>\n";
		print "<OPTION VALUE=\"club_upload_image.txt\">Club Image Upload Template</OPTION>\n";
		print "<OPTION VALUE=\"club_mod.txt\">Club Moderator Pages</OPTION>\n";
		print "<OPTION VALUE=\"clubtitle.txt\">Club Title Frame</OPTION>\n";
		print "<OPTION VALUE=\"clubmenu.txt\">Club Menu Frame</OPTION>\n";
		print "<OPTION VALUE=\"join_club.txt\">Club Application Form</OPTION>\n";
		print "<OPTION VALUE=\"club_utils.txt\">Club Utilities (Who's Online ect.)</OPTION>\n";
		print "<OPTION VALUE=\"index.txt\">Club Directory Front Page</OPTION>\n";
		foreach $c (@cats) {
			print "<OPTION VALUE=\"$c.txt\">Directory: $c</OPTION>\n";
		}
	}
	foreach $uforum(@forums) {
		open (CFG, "$GPath{'cforums_data'}/$uforum.cfg");
		@cfg = <CFG>;
		close (CFG);
		(@tcfg) = split(/\|/, $cfg[0]);
		print "<OPTION VALUE=\"$uforum.txt\">$tcfg[0]</OPTION>\n";
	}
	print "</SELECT>\n";
	print "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"Open Template\">\n";
	print "<INPUT TYPE=SUBMIT VALUE=\"Open Template!\">\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE></CENTER>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub open_templates {
	$fn = "$GPath{'template_data'}/$FORM{'template2edit'}";
	if (! -e "$fn") {$fn = "$GPath{'template_data'}/bbs.txt";}

	open(FILE, "$fn");
 		@source = <FILE>;
	close(FILE);

	foreach $line(@source) {
		$TEXT .= $line;
	}
     	$TEXT =~ s/\cM//g;


   $DESC = "Editing Template: <B>$FORM{'template2edit'}</B><BR>(Read in from $fn)<BR><BR>";
   $DESC .= "If there was not a template already defined, we used the current default.  \n";
   $DESC .= "<A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> for a definition of the <A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">available plugins</A>.\n";


   &Symbol_List;
   &Font_List;
   &Plugin_List;
   &Tags;
   &Colors;

print "Content-Type: text/html\n\n";
print <<DONE;
    <SCRIPT LANGUAGE="javascript">
	    function Symbols() {
		    var text=document.html_form.source.value;
			var num = document.html_form.symbol.selectedIndex;
			var sval = document.html_form.symbol[num].text;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}
		
	    function Font() {
		    var text=document.html_form.source.value;
			var num = document.html_form.font.selectedIndex;
			var sval = document.html_form.font[num].text;
			if(num > 0) {			
 			   text = text + "<FONT FACE='" + sval + "' SIZE='$CONFIG{'font_size'}' COLOR='$CONFIG{'text_color'}'>";
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}			   
		}		

	    function Plugin() {
		    var text=document.html_form.source.value;
			var num = document.html_form.plugin.selectedIndex;
			var sval = document.html_form.plugin[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Tag() {
		    var text=document.html_form.source.value;
			var num = document.html_form.tag.selectedIndex;
			var sval = document.html_form.tag[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Color(c_value) {
		    var text=document.html_form.source.value;
			text = text + c_value;
			document.html_form.source.value=text;
			document.html_form.source.focus();
		}
				
	</SCRIPT>
	<body bgcolor="#ffffcc" link=navy vlink=navy text=black>
	<FONT FACE="arial,helvetica" SIZE=-1>
        <BLOCKQUOTE><BLOCKQUOTE>$DESC</BLOCKQUOTE></BLOCKQUOTE>
	<CENTER>
    <form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME="html_form" ACTION="$GUrl{'cf_admin.cgi'}" METHOD="post">
	<TABLE BGCOLOR="black" BORDER=0 WIDTH=500 CELLSPACING=2 CELLPADDING=0><TR><TD>
	  <TABLE WIDTH=100% BORDER=0 BGCOLOR="#cccc99">
	    <TR><TD VALIGN="top" BGCOLOR="#cccc99">
		  <FONT FACE="arial,helvetica" SIZE=-1>
		    <H3>Template Editor</H3>
 	        $symbols
	        $fonts
	        $plugins
	        $tags
	      </FONT>		  
		</TD></TR>
	    <TD VALIGN="top">
 		 <CENTER>
	     <TEXTAREA NAME="source" COLS=60 ROWS=15>$TEXT</TEXTAREA><BR>
                 <INPUT TYPE="hidden" NAME="password" VALUE="$password">
                 <INPUT TYPE="hidden" NAME="filename" VALUE="$FILENAME">
                 <INPUT TYPE="hidden" NAME="template2edit" VALUE="$FORM{'template2edit'}">
                 <INPUT TYPE="hidden" NAME="mode" VALUE="$input{'mode'}">
                 <INPUT TYPE="hidden" NAME="todo" VALUE="$input{'todo'}">
                 <INPUT TYPE="hidden" NAME="action" VALUE="Save Template">
                 <CENTER><INPUT TYPE="submit" VALUE="Save Changes!"></CENTER>
		 </CENTER>
	    </TD></TR>
	  </TABLE>
	</TD></TR></TABLE>
	</FORM>
    <B>Click to insert color...</B><BR>
    <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="1">
      <TR>
        $colortable
      </TR>
    </TABLE>
  </CENTER>

DONE

        exit 0;
}

sub Plugin_List {

   $plugins=<<DONEPLUGINS;
    <SELECT NAME="plugin" onChange="Plugin();">
      <OPTION>Plugins
      <OPTION VALUE="\nPLUGIN:BODY\n">PLUGIN:BODY
      <OPTION VALUE="\nPLUGIN:BANNER\n">PLUGIN:BANNER
      <OPTION VALUE="\nPLUGIN:CONTROL_PANEL\n">PLUGIN:CONTROL_PANEL

      <OPTION VALUE="PLUGIN:LONGDATE">PLUGIN:LONGDATE
      <OPTION VALUE="PLUGIN:USDATE">PLUGIN:USDATE
      <OPTION VALUE="PLUGIN:SHORTDATE">PLUGIN:SHORTDATE
      <OPTION VALUE="PLUGIN:REFERER">PLUGIN:REFERER
      <OPTION VALUE="PLUGIN:USEREMAIL">PLUGIN:USEREMAIL
      <OPTION VALUE="PLUGIN:USERDESCRIPTION">PLUGIN:USERDESCRIPTION
      <OPTION VALUE="PLUGIN:USERCOMMUNITY">PLUGIN:USERCOMMUNITY
      <OPTION VALUE="PLUGIN:COMMUNITYNAME">PLUGIN:COMMUNITYNAME
      <OPTION VALUE="PLUGIN:HANDLE">PLUGIN:HANDLE
      <OPTION VALUE="PLUGIN:USERREALNAME">PLUGIN:USERREALNAME
      <OPTION VALUE="PLUGIN:SCREENNAME">PLUGIN:SCREENNAME
      <OPTION VALUE="PLUGIN:PASSWORD">PLUGIN:PASSWORD
      <OPTION VALUE="PLUGIN:USERNAME">PLUGIN:USERNAME
      <OPTION VALUE="PLUGIN:FIRSTNAME">PLUGIN:FIRSTNAME
      <OPTION VALUE="PLUGIN:MIDDLENAME">PLUGIN:MIDDLENAME
      <OPTION VALUE="PLUGIN:LASTNAME">PLUGIN:LASTNAME
      <OPTION VALUE="PLUGIN:BIRTH:DAY">PLUGIN:BIRTH:DAY
      <OPTION VALUE="PLUGIN:BIRTH:MONTH">PLUGIN:BIRTH:MONTH
      <OPTION VALUE="PLUGIN:BIRTH:MONTH:WORD">PLUGIN:BIRTH:MONTH:WORD
      <OPTION VALUE="PLUGIN:BIRTH:YEAR">PLUGIN:BIRTH:YEAR
      <OPTION VALUE="PLUGIN:FILLER(1..10)">PLUGIN:FILLER
      <OPTION VALUE="&lt;A HREF='PLUGIN:_PROFILE'&gt;Your text here&lt;/A&gt;">PLUGIN:_PROFILE
      <OPTION VALUE="&lt;A HREF='PLUGIN:_WEBPAGE'&gt;Your text here&lt;/A&gt;">PLUGIN:_WEBPAGE

      <OPTION VALUE="PLUGIN:CUSTOM:Your_Function_Name">PLUGIN:CUSTOM


    </SELECT>
DONEPLUGINS

}

sub Font_List {

   $fonts=<<DONEFONTS;
    <SELECT NAME="font" onChange="Font();">
     <OPTION>Font
     <OPTION>Arial,Helvetica
     <OPTION>Tahoma,Helvetica
     <OPTION>Verdana,Helvetica
     <OPTION>Times Roman
     <OPTION>MS Comic Sans Serif
     <OPTION>Courier
    </SELECT>
DONEFONTS
}


sub Tags {
   $tags=<<DONETAGS;
    <SELECT NAME="tag" onChange="Tag();">
     <OPTION>HTML Tags
     <OPTION VALUE="&lt;H1&gt; &lt;/H1&gt;">H1
     <OPTION VALUE="&lt;H2&gt; &lt;/H2&gt;">H2
     <OPTION VALUE="&lt;H3&gt; &lt;/H3&gt;">H3
     <OPTION VALUE="&lt;H4&gt; &lt;/H4&gt;">H4
     <OPTION VALUE="&lt;B&gt; &lt;/B&gt;">BOLD
     <OPTION VALUE="&lt;U&gt; &lt;/U&gt;">Underline
     <OPTION VALUE="&lt;I&gt; &lt;/I&gt;">Italics
     <OPTION VALUE="&lt;BLOCKQUOTE&gt;\n&lt;/BLOCKQUOTE&gt;">Blockquote
     <OPTION VALUE="&lt;IMG SRC='/path/to/image.gif'&gt;">Image
     <OPTION VALUE="&lt;CENTER&gt; &lt;/CENTER&gt;">Center
     <OPTION VALUE="&lt;P ALIGN='left'&gt; &lt;/P&gt;">Align Left
     <OPTION VALUE="&lt;P ALIGN='right'&gt; &lt;/P&gt;">Align Right
    </SELECT>
DONETAGS
}

sub Symbol_List {

   $symbols=<<DONESYMBOLS;
   <SELECT NAME="symbol" onChange="Symbols();">
     <OPTION>Symbol
     <OPTION>&quot;
     <OPTION>&amp
     <OPTION>&lt;
     <OPTION>&gt;
	 
	 <!--
     <OPTION>&euro;
     <OPTION>&fnof;
     <OPTION>&hellip;
     <OPTION>&dagger;
     <OPTION>&Dagger;
     <OPTION>&permil;
     <OPTION>&Scaron;
     <OPTION>&OElig;
     <OPTION>&bull;
     <OPTION>&mdash;
     <OPTION>&trade;
     <OPTION>&scaron;
     <OPTION>&rsaquo;
     <OPTION>&oelig;
     <OPTION>&Yuml;
	 -->
	 
     <OPTION>&nbsp;
     <OPTION>&iexcl;
     <OPTION>&cent;
     <OPTION>&pound;
     <OPTION>&curren;
     <OPTION>&yen;
     <OPTION>&brvbar;
     <OPTION>&sect;
     <OPTION>&copy;
     <OPTION>&laquo;
     <OPTION>&not;
     <OPTION>&reg;
     <OPTION>&deg;
     <OPTION>&plusmn;
     <OPTION>&sup2;
     <OPTION>&sup3;
     <OPTION>&acute;
     <OPTION>&micro;
     <OPTION>&para;
     <OPTION>&middot;
     <OPTION>&sup1;
     <OPTION>&raquo;
     <OPTION>&frac14;
     <OPTION>&frac12;
     <OPTION>&frac34;
     <OPTION>&iquest;
     <OPTION>&Agrave;
     <OPTION>&times;
     <OPTION>&Oslash;
     <OPTION>&szlig;
     <OPTION>&divide;
    </SELECT>
DONESYMBOLS
   
}


sub Colors {

   push @cl,"#000000";
   push @cl,"#003300";
   push @cl,"#006600";
   push @cl,"#009900";
   push @cl,"#00cc00";
   push @cl,"#00ff00";
   push @cl,"#000033";
   push @cl,"#003333";
   push @cl,"#006633";
   push @cl,"#009933";
   push @cl,"#00cc33";
   push @cl,"#00ff33";
   push @cl,"#000066";
   push @cl,"#003366";
   push @cl,"#006666";
   push @cl,"#009966";
   push @cl,"#00cc66";
   push @cl,"#00ff66";
   push @cl,"#000099";
   push @cl,"#003399";
   push @cl,"#006699";
   push @cl,"#009999";
   push @cl,"#00cc99";
   push @cl,"#00ff99";
   push @cl,"#0000cc";
   push @cl,"#0033cc";
   push @cl,"#0066cc";
   push @cl,"#0099cc";
   push @cl,"#00cccc";
   push @cl,"#00ffcc";
   push @cl,"#0000ff";
   push @cl,"#0033ff";
   push @cl,"#0066ff";
   push @cl,"#0099ff";
   push @cl,"#00ccff";
   push @cl,"#00ffff";
   push @cl,"#330000";
   push @cl,"#333300";
   push @cl,"#336600";
   push @cl,"#339900";
   push @cl,"#33cc00";
   push @cl,"#33ff00";
   push @cl,"#330033";
   push @cl,"#333333";
   push @cl,"#336633";
   push @cl,"#339933";
   push @cl,"#33cc33";
   push @cl,"#33ff33";
   push @cl,"#330066";
   push @cl,"#333366";
   push @cl,"#336666";
   push @cl,"#339966";
   push @cl,"#33cc66";
   push @cl,"#33ff66";
   push @cl,"#330099";
   push @cl,"#333399";
   push @cl,"#336699";
   push @cl,"#339999";
   push @cl,"#33cc99";
   push @cl,"#33ff99";
   push @cl,"#3300cc";
   push @cl,"#3333cc";
   push @cl,"#3366cc";
   push @cl,"#3399cc";
   push @cl,"#33cccc";
   push @cl,"#33ffcc";
   push @cl,"#3300ff";
   push @cl,"#3333ff";
   push @cl,"#3366ff";
   push @cl,"#3399ff";
   push @cl,"#33ccff";
   push @cl,"#660000";
   push @cl,"#663300";
   push @cl,"#666600";
   push @cl,"#669900";
   push @cl,"#66cc00";
   push @cl,"#66ff00";
   push @cl,"#660033";
   push @cl,"#663333";
   push @cl,"#666633";
   push @cl,"#669933";
   push @cl,"#66cc33";
   push @cl,"#66ff33";
   push @cl,"#660066";
   push @cl,"#663366";
   push @cl,"#666666";
   push @cl,"#669966";
   push @cl,"#66cc66";
   push @cl,"#66ff66";
   push @cl,"#660099";
   push @cl,"#663399";
   push @cl,"#666699";
   push @cl,"#669999";
   push @cl,"#66cc99";
   push @cl,"#66ff99";
   push @cl,"#6600cc";
   push @cl,"#6633cc";
   push @cl,"#6666cc";
   push @cl,"#6699cc";
   push @cl,"#66cccc";
   push @cl,"#66ffcc";
   push @cl,"#6600ff";
   push @cl,"#6633ff";
   push @cl,"#6666ff";
   push @cl,"#6699ff";
   push @cl,"#66ccff";
   push @cl,"#66ffff";
   push @cl,"#990000";
   push @cl,"#993300";
   push @cl,"#996600";
   push @cl,"#999900";
   push @cl,"#99cc00";
   push @cl,"#99ff00";
   push @cl,"#990033";
   push @cl,"#993333";
   push @cl,"#996633";
   push @cl,"#999933";
   push @cl,"#99cc33";
   push @cl,"#99ff33";
   push @cl,"#990066";
   push @cl,"#993366";
   push @cl,"#996666";
   push @cl,"#999966";
   push @cl,"#99cc66";
   push @cl,"#99ff66";
   push @cl,"#990099";
   push @cl,"#993399";
   push @cl,"#996699";
   push @cl,"#999999";
   push @cl,"#99cc99";
   push @cl,"#99ff99";
   push @cl,"#9900cc";
   push @cl,"#9933cc";
   push @cl,"#9966cc";
   push @cl,"#9999cc";
   push @cl,"#99cccc";
   push @cl,"#99ffcc";
   push @cl,"#9900ff";
   push @cl,"#9933ff";
   push @cl,"#9966ff";
   push @cl,"#9999ff";
   push @cl,"#99ccff";
   push @cl,"#99ffff";
   push @cl,"#cc0000";
   push @cl,"#cc3300";
   push @cl,"#cc6600";
   push @cl,"#cc9900";
   push @cl,"#cccc00";
   push @cl,"#ccff00";
   push @cl,"#cc0033";
   push @cl,"#cc3333";
   push @cl,"#cc6633";
   push @cl,"#cc9933";
   push @cl,"#cccc33";
   push @cl,"#ccff33";
   push @cl,"#cc0066";
   push @cl,"#cc3366";
   push @cl,"#cc6666";
   push @cl,"#cc9966";
   push @cl,"#cccc66";
   push @cl,"#ccff66";
   push @cl,"#cc0099";
   push @cl,"#cc3399";
   push @cl,"#cc6699";
   push @cl,"#cc9999";
   push @cl,"#cccc99";
   push @cl,"#ccff99";
   push @cl,"#cc00cc";
   push @cl,"#cc33cc";
   push @cl,"#cc66cc";
   push @cl,"#cc99cc";
   push @cl,"#cccccc";
   push @cl,"#ccffcc";
   push @cl,"#cc00ff";
   push @cl,"#cc33ff";
   push @cl,"#cc66ff";
   push @cl,"#cc99ff";
   push @cl,"#ccccff";
   push @cl,"#ccffff";
   push @cl,"#ff0000";
   push @cl,"#ff3300";
   push @cl,"#ff6600";
   push @cl,"#ff9900";
   push @cl,"#ffcc00";
   push @cl,"#ffff00";
   push @cl,"#ff0033";
   push @cl,"#ff3333";
   push @cl,"#ff6633";
   push @cl,"#ff9933";
   push @cl,"#ffcc33";
   push @cl,"#ffff33";
   push @cl,"#ff0066";
   push @cl,"#ff3366";
   push @cl,"#ff6666";
   push @cl,"#ff9966";
   push @cl,"#ffcc66";
   push @cl,"#ffff66";
   push @cl,"#ff0099";
   push @cl,"#ff3399";
   push @cl,"#ff6699";
   push @cl,"#ff9999";
   push @cl,"#ffcc99";
   push @cl,"#ffff99";
   push @cl,"#ff00cc";
   push @cl,"#ff33cc";
   push @cl,"#ff66cc";
   push @cl,"#ff99cc";
   push @cl,"#ffcccc";
   push @cl,"#ffffcc";
   push @cl,"#ff00ff";
   push @cl,"#ff33ff";
   push @cl,"#ff66ff";
   push @cl,"#ff99ff";
   push @cl,"#ffccff";
   push @cl,"#ffffff";
   push @cl,"aqua";
   push @cl,"gray">
   push @cl,"navy";
   push @cl,"silver";
   push @cl,"black";
   push @cl,"green";
   push @cl,"olive";
   push @cl,"teal";
   push @cl,"blue";
   push @cl,"lime";
   push @cl,"purple";
   push @cl,"white";
   push @cl,"fuchsia";
   push @cl,"maroon";
   push @cl,"red";
   push @cl,"yellow";

   $x=0;
   foreach $color(@cl) {
      $x++;
      $colortable .= "<TD BGCOLOR=\"$color\"><A HREF=\"javascript:Color('$color');\">&nbsp;&nbsp;&nbsp;</a></TD>\n";
      if($x == 36) { $colortable .= "</TR><TR>"; $x=0; }
   }

}




sub save_template {
	$fn = "$GPath{'template_data'}/$FORM{'template2edit'}";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'source'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "File ($fn) Saved.\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'source'}\n";
	exit;
}




sub admin {
	print "Content-type: text/html\n\n";

	opendir(FILES, "$GPath{'cforums_data'}/") || &diehtml("$GPath{'cforums_data'}/");
    	while($file = readdir(FILES)) {
     		if($file =~ /(.*)\.cfg/) {
			$forum = $1;
			open (CFG, "$GPath{'cforums_data'}/$file");
			@cfg = <CFG>;
			close (CFG);
			(@tcfg) = split(/\|/, $cfg[0]);
			$SELECT .= "<OPTION VALUE=\"$forum\">$tcfg[0]</OPTION>\n";
		}
	}



        print <<DONE;

	<HTML>

	<BODY BGCOLOR="#cccc99">
	<CENTER>
	<P><FONT COLOR="$CONFIG{'text_color'}"><H1>CommunityForums / Auto-Clubs Admin</H1></FONT><P>

<TABLE WIDTH=500><TR><TD>
<P><B>Warning:</B> We recommend using a recent version of Netscape while editing, as certain browsers may overwrite important changes that you make to your files.
</TD></TR></TABLE><BR><BR>

	<A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/cforums.html\">Help!</A>

        <TABLE BGCOLOR="#ffffcc" BORDER=1 CELLSPACING=15 WIDTH=620>
         <TR>
          <TD WIDTH=50%><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=create+forums"><IMG SRC="$CONFIG{'button_dir'}/icon-create-forums.gif" BORDER=0></A>
             <BR>[Create Forum]
          </TD>
          <TD WIDTH=50%><CENTER>
             <IMG SRC="$CONFIG{'button_dir'}/icon-create-forums.gif" BORDER=0>
		 <form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action="$GUrl{'cf_admin.cgi'}">
		 <SELECT NAME=forum>
		 $SELECT
		 </SELECT>
		 <BR>
		 <INPUT TYPE=SUBMIT VALUE=\"Edit Forum!\">
		 <INPUT TYPE=HIDDEN NAME=action VALUE=\"Edit Forums\">
		 </FORM>
          </TD>
         </TR>

         <TR>
          <TD><CENTER>
            <A HREF="$GUrl{'cf_admin.cgi'}?action=Define+Categories"><IMG SRC="$CONFIG{'button_dir'}/icon-cat-detail.gif" BORDER=0></A><BR>[Edit Forum Categories]
          </TD>
          <TD><CENTER>
            <A HREF="$GUrl{'cf_admin.cgi'}?action=Setup+Categories"><IMG SRC="$CONFIG{'button_dir'}/icon-add-forum.gif" BORDER=0></A><BR>[Add Forums To Categories]
          </TD>
         </TR>

         <TR>
          <TD><CENTER>
            <A HREF="$GUrl{'cf_admin.cgi'}?action=Edit+Templates"><IMG SRC="$CONFIG{'button_dir'}/icon-templates.gif" BORDER=0></A><BR>[Edit Templates]
          </TD>
          <TD><CENTER>
            <A HREF="$GUrl{'cf_admin.cgi'}?action=edit_emails"><IMG SRC="$CONFIG{'button_dir'}/icon-send-mail.gif" BORDER=0></A><BR>[Edit Emails]
          </TD>
         </TR>
	   <TR>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=reports"><IMG SRC="$CONFIG{'button_dir'}/icon-stats.gif" BORDER=0></A>
             <BR>[Generate Activity Reports]
          </TD>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=badwords"><IMG SRC="$CONFIG{'button_dir'}/icon-edit-badwords.gif" BORDER=0></A>
             <BR>[Bad Word Filter]
          </TD>
         </TR>
	   <TR>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=help_files"><IMG SRC="$CONFIG{'button_dir'}/icon-edit-help.gif" BORDER=0></A>
             <BR>[Edit Help Files]
          </TD>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=set_admin"><IMG SRC="$CONFIG{'button_dir'}/icon-admin.gif" BORDER=0></A>
             <BR>[Set Administrative User]
          </TD>
         </TR>
	   <TR>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=replacements"><IMG SRC="$CONFIG{'button_dir'}/icon-replacements.gif" BORDER=0></A>
             <BR>[Edit Text Replacements]
          </TD>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=backups"><IMG SRC="$CONFIG{'button_dir'}/icon-create-backups.gif" BORDER=0></A>
             <BR>[Create Backups]
		 <BR><FONT SIZE=2>Binary databases are very fast but they cannot be FTPed or restored from a backup.  You must create a text copy before performing a backup on your data.</FONT>
		<BR>
          </TD>
         </TR>
	   <TR>
          <TD><CENTER>
             <A HREF="$GUrl{'cf_admin.cgi'}?action=post_categories"><IMG SRC="$CONFIG{'button_dir'}/icon-add-forum.gif" BORDER=0></A>
             <BR>[Edit Post Categories]
          </TD>
          <TD><CENTER>
             <IMG SRC="$CONFIG{'button_dir'}/icon-create-forums.gif" BORDER=0>
		 <form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action="$GUrl{'cf_admin.cgi'}">
		 <SELECT NAME=forum>
		 $SELECT
		 </SELECT>
		 <BR>
		 <INPUT TYPE=SUBMIT VALUE=\"Delete Forum!\">
		 <INPUT TYPE=HIDDEN NAME=action VALUE=\"Delete Forum\">
		 </FORM>
          </TD>
         </TR>
	</TABLE>
	</CENTER>
	</BODY>
	</HTML>
DONE

	exit 0;
}


sub get_midnights_time {
	$rightnow = time;
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime;
#$year = $year + 1900;

	$mday++;
	$mon++;
	$year = $year - 70;

	$days = $mday * 86400;

	if ($mon == 1) {$month = 0;}
	elsif ($mon == 2) {$month = 31;}
	elsif ($mon == 3) {$month = 59;}
	elsif ($mon == 4) {$month = 90;}
	elsif ($mon == 5) {$month = 120;}
	elsif ($mon == 6) {$month = 151;}
	elsif ($mon == 7) {$month = 181;}
	elsif ($mon == 8) {$month = 212;}
	elsif ($mon == 9) {$month = 243;}
	elsif ($mon == 10) {$month = 273;}
	elsif ($mon == 11) {$month = 304;}
	elsif ($mon == 12) {$month = 334;}
	$month = $month * 86400;

	$years = ($year * 365 * 86400) + (7 * 86400); # 7 leap years since 1970, will need to be changed in 2004 (no leap year on centenials for some reason?  Blame the astronomers;=))

	$midnight = $years + $month + $days;
}


sub generate_reports {
	$num_of_days = 10;
	$max_to_show = 20;
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<BODY BGCOLOR=#ffffcc>\n";
	if ($CONFIG{'NiceGraphs'} eq "YES") {
		print "Please note that the graphs on this page are generated on a BuildACommunity.com server.  We are currently offering this as a free service since the code to run it is still under development and will not run on most servers. Please note that you can return to the HTML format by changing the setting in the Configuration Settings (available along the top of the screen).\n<P>";
		print "<CENTER>\n";
	}
	&get_midnights_time;

	$test_midnight = $midnight;

	$dn = "$GPath{'cforums_data'}/";
	opendir(FILES, "$dn") || &diehtml("Can't open $dn");
    	while($file = readdir(FILES)) {
        	if (($file =~ /\.db$/) && ($file !~ /thread/) && ($file !~ /authors/) && ($file !~ /keywords/) && ($file !~ /activity/) && ($file !~ /postactivity/)) {
			($forum = $file) =~ s/\..*//;
			open(FCG, "$GPath{'cforums_data'}/$forum.cfg");
			@contents = <FCG>;
			close(FCG);

			### Split the entities
			$temp = $contents[0];
			@entries = split (/\|/, $temp);
			$f_name{$forum} = $entries[0];
			$clubforum{$forum} = $entries[22];


#			print "<B>opening $dn$file</B><BR>\n";
			tie %data, "DB_File", "$dn$file";
			foreach $x (keys %data) {
				($ptime) = split(/,/, $x);
				$PROGRESS = "first test_midnight = $test_midnight<P>\n";
				$rep_count = 0;
				$notfound = "F";
				$test_midnight = $midnight;

				while ($ptime < $test_midnight) {
					$test_midnight = $test_midnight - 86400;
					$PROGRESS .= "$test_midnight ====  $ptime<BR>\n";
					$rep_count++;
					if ($rep_count > $num_of_days) {
						$notfound = "T";
						last;
					}
				}

				if ($notfound ne "T") {
					$perday{$test_midnight}++;
				}

				$nforum = $file;
				$nforum =~ s/\.db$//;
				$perforum{$nforum}++;

				$thours = $rightnow - 86400;
				if ($ptime > $thours) {
					$forumtoday{$nforum}++;
				}
			}
		}
	}
	tie %data, "DB_File", "$dn/authors.db";
	foreach $author (keys %data) {
		@posts = split(/\|/, $data{$author});
#		foreach $x(@posts) {
			$active_a{$author} = $#posts + 1;
#		}
	}
	



#	print $PROGRESS;
	$count1 = 0;
	print "<CENTER><H3>Generate Activity Reports</CENTER></H3>\n";

	&displaygraph("Days","Posts","Posts Per Day","",\%perday,"","key","noreverse","","time");

	print "<TABLE><TR><TD>\n";
	&displaygraph("Forum","Posts","Posts Per Forum","",\%perforum,"","key","noreverse","","");

	$count = 0;
	foreach $mykey(reverse sort { $perforum{$a} <=> $perforum{$b} } keys %perforum) {
		if ($clubforum{$mykey} eq "Club") {
			$FURL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mykey\" TARGET=\"_top\">";
		}
		else {
			$FURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mykey\" TARGET=\"top\">";
		}

		print "<FONT SIZE=1>$mykey = $FURL$f_name{$mykey}</A></FONT><BR>\n";
		if ($count++ > $max_to_show) {last;}
	}

	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	&displaygraph("Forum","Posts","Posts Per Forum Today","",\%forumtoday,"","key","noreverse","","");

	print "<TABLE><TR><TD>\n";
	$count = 0;
	foreach $mykey(reverse sort { $forumtoday{$a} <=> $forumtoday{$b} } keys %forumtoday) {
		open(FCG, "$GPath{'cforums_data'}/$mykey.cfg");
		@contents = <FCG>;
		close(FCG);

		### Split the entities
		$temp = $contents[0];
		@entries = split (/\|/, $temp);

		if ($clubforum{$mykey} eq "club") {
			$FURL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mykey\" TARGET=\"_top\">";
		}
		else {
			$FURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mykey\" TARGET=\"top\">";
		}
		print "<FONT SIZE=1>$mykey = $FURL$f_name{$mykey}</A></FONT><BR>\n";
		if ($count++ > $max_to_show) {last;}
	}

	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "<TABLE><TR><TD>\n";
	&displaygraph("Forum","Posts","Posts Per Author","",\%active_a,"","key","noreverse","","");

	$count = 0;
	foreach $mykey(reverse sort { $active_a{$a} <=> $active_a{$b} } keys %active_a) {
		$fn = $GPath{'userpath'} . "/" . $mykey . "\.usrdat";
		open(FILE, "$fn");
		$data = "";
		while(<FILE>) {
			chomp;
			@datafile = split(/\n/);
			foreach $line (@datafile) {
				$data .= $line;
	           	}
	     	}
		($MOD_realname, $MOD_username, $MOD_email, $MOD_password, $MOD_url, $MOD_urlname, $MOD_handle, $MOD_IPs, $MOD_creation_date, $MOD_last_update, $MOD_numvisits, $MOD_Age, $MOD_Sex, $MOD_user_level, $MOD_favtype, $MOD_warnings, $MOD_icon, $MOD_description) = split(/&&/, $data);
		if ($MOD_username ne "") {$name = "$MOD_realname/$MOD_handle ($MOD_username)";}
			else {next;}

		print "<FONT SIZE=1>$mykey = $MOD_realname/$MOD_handle <A HREF=\"javascript:OpenWin('$GUrl{'moreinfo.cgi'}?UserName=$MOD_username');\">public info</A> <A HREF=\"javascript:OpenWin('$CONFIG{'CGI_DIR'}/community_admin.cgi?action=view_details&UserNum=$mykey&UserName=$MOD_username');\">private info</A></FONT><BR>\n";
		if ($count++ > $max_to_show) {last;}
	}
 	print "</TD></TR></TABLE>\n";


	if (-e "clubs.cgi") {
		opendir(FILES, "$CONFIG{'CLUB_image_path'}/");
    		while($file = readdir(FILES)) {
			if (-d "$CONFIG{'CLUB_image_path'}/$file") {
				if ($file =~ /\.+/) {next;}
				push (@clubs, $file);
			}
		}
		closedir(FILES);
		foreach $club (@clubs) {
			opendir(FILES, "$CONFIG{'CLUB_image_path'}/$club/photos/");
    			while($file = readdir(FILES)) {
				($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size) = stat("$CONFIG{'CLUB_image_path'}/$club/photos/$file");
				$gsize{$club} = $gsize{$club} + $size;
				($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size) = stat("$CONFIG{'CLUB_image_path'}/$club/thumbs/$file");
				$gsize{$club} = $gsize{$club} + $size;
				$gcount{$club}++;
			}
			closedir(FILES);
		}
		print "<P>\n";

		print "<TABLE><TR><TD>\n";
		&displaygraph("Club","Size In Bytes","Club Gallery Size","",\%gsize,"","key","noreverse","","");

		$count = 0;
		foreach $mykey(reverse sort { $gsize{$a} <=> $gsize{$b} } keys %gsize) {
  			if ($clubforum{$mykey} eq "Club") {
				$FURL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mykey\" TARGET=\"_top\">";
			}
			else {
				$FURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mykey\" TARGET=\"top\">";
			}

			print "<FONT SIZE=1>$FURL$f_name{$mykey}</A> ($mykey)</FONT><BR>\n";
			if ($count++ > $max_to_show) {last;}
		}
		print "</TD></TR></TABLE>\n";

		print "<P>\n";
		print "<TABLE><TR><TD>\n";
		&displaygraph("Club","Number Of Images","Club Gallery #Images","",\%gcount,"","key","noreverse","","");

		$count = 0;
		foreach $mykey(reverse sort { $gcount{$a} <=> $gcount{$b} } keys %gcount) {
			if ($clubforum{$mykey} eq "Club") {
				$FURL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mykey\" TARGET=\"_top\">";
			}
			else {
				$FURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mykey\" TARGET=\"top\">";
			}

			print "<FONT SIZE=1>$FURL$f_name{$mykey}</A> ($mykey)</FONT><BR>\n";
			if ($count++ > $max_to_show) {last;}
		}
		print "</TD></TR></TABLE>\n";
		print "<P>\n";
	}

	$count = 0;
	opendir(FILES, "$GPath{'cforums_data'}/") || &diehtml("Can't open $GPath{'cforums_data'}/");
    	while($file = readdir(FILES)) {
		if ($file =~ /\.cfg/) {
			$file =~ s/\.cfg//;
			($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size) = stat("$GPath{'cforums_data'}/$file.db");
			$fsize{$file} = $fsize{$file} + $size;
			($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size) = stat("$GPath{'cforums_data'}/$file_threads.db");
			$fsize{$file} = $fsize{$file} + $size;
		}
	}

	print "<TABLE><TR><TD>\n";
	&displaygraph("Database","Size In Bytes","Forum Database Size","",\%fsize,"","key","noreverse","","");

	foreach $mykey(reverse sort { $fsize{$a} <=> $fsize{$b} } keys %fsize) {
		if ($fsize{$mykey} > 0) {
			if ($x == 0) {
				$x = 300 / $fsize{$mykey};
			}
			$length = $fsize{$mykey} * $x;
		}
		$length++;

		if ($clubforum{$mykey} eq "Club") {
			$FURL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mykey\" TARGET=\"_top\">";
		}
		else {
			$FURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mykey\" TARGET=\"top\">";
		}

		print "<FONT SIZE=1>$FURL$f_name{$mykey}</A> ($mykey)</FONT><BR>\n";
		if ($count++ > $max_to_show) {last;}
	}
	print "</TD></TR></TABLE>\n";

	print " <SCRIPT LANGUAGE=\"javascript\">\n";
	print " <!--\n";
	print " function OpenWin(Loc) {\n";
	print "	wUploadWindow=window.open(Loc,\"wUploadWindow\",\"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}\");\n";
	print "  wUploadWindow.focus();\n";
	print " 	   }\n";
	print " 	// -->\n";
	print " 	</SCRIPT>\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE></CENTER>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

}	


sub parse_date_l {
   local ($time) = $_[0];
   ($sec,$min,$hour,$tmday,$mon,$tyear,$wday,$yday,$isdst) = localtime($time);

   if ($sec < 10) {
      $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   if ($mon < 10) {
      $mon = "0$mon";
   }
   if ($mday < 10) {
      $mday = "0$mday";
   }

   $tmonth = ($mon + 1);

   @months = ("January","February","March","April","May","June","July","August","September","October","November","December");

   $date = "$hour\:$min\:$sec $month/$mday/$year";

   chop($date) if ($date =~ /\n$/);

   #$year = $year + 1900;
   $long_date = "$months[$mon] $mday, $year at $hour\:$min\:$sec";
}


sub define_categories {
	$fn = "$GPath{'cforums_data'}/categories.def";
	open(FILE, "$fn");
 		@CATS = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<BODY BGCOLOR=#cccc99>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=400>\n";
	print "<TR><TD><CENTER><H3>Edit Forum Categories</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "Enter your categories below, they will appear in the selected order on the forum selection screen.  If you change the spelling of a current category, you must reassign any forums currently assigned to it</I>.\n";
	print "<P>\n";

	print "<H4>Categories (one per line):</H4>\n";
	print "<TEXTAREA NAME=CATS COLS=30 ROWS=10>";
	foreach $line(@CATS) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Categories\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub setup_categories {
	open(CAT,"$GPath{'cforums_data'}/categories.def"); 
	@cats=<CAT>;
	close(CAT);  

	open(FCAT,"$GPath{'cforums_data'}/forum.categories");
	@fcats=<FCAT>;
	close(FCAT);

	undef @forums;
	undef @titles;

	opendir(FILES, "$GPath{'cforums_data'}/") || die ERROR("Can't open directory $GPath{'cforums_data'}/");
	while($file = readdir(FILES)) {
		if($file =~ /.*\.cfg/ ) {
			$conf_file = $file;
			$file =~ s/.cfg//g;

			open(FCG, "$GPath{'cforums_data'}/$conf_file");
			@contents = <FCG>;
			close(FCG);

			$temp = $contents[0];
			@entries = split (/\|/, $temp);

			$title = $entries[0]; 
			chomp($title);
               
			push @titles, $title;
			push @forums, $file;
		}
	}

	print "Content-Type: text/html\n\n";

	print "<BODY BGCOLOR=\"#ffffcc\">\n";
	print "<TR><TD><CENTER><H3>Add Forums to Categories</H3></CENTER></TD></TR>\n";
	print "<BLOCKQUOTE>\n";
	print "Place your forums (left column) into any appropriate categories (right column).  You can select multiple categories by holding down the Control (Ctrl) key on your keyboard as you click on them with your mouse.\n"; 
	print "</BLOCKQUOTE>\n";

	print "<CENTER>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION=\"$GUrl{'cf_admin.cgi'}\" METHOD=\"post\">\n";
	print "<TABLE BORDER=1>\n";

	if (-e "clubs.cgi") {
		for $f (0 .. $#forums) {
			print "<TR><TD><B>$titles[$f]</B></TD>\n";
			print "<TD VALIGN=\"top\">\n";
			print "<SELECT NAME=\"$forums[$f]\" SIZE=3 MULTIPLE>\n";
			foreach $c(@cats) {
				chomp($c);
				@ttcc = split(/\|/, $c);
				if ($ttcc[2]) {
					$disc = "\|$ttcc[1]\|$ttcc[2]";
				}
				else {
					$disc = "\|$ttcc[1]";
				}
				$d = $c;
				$d =~ s/ /_/g;
				$ok = "F";
				foreach $fc(@fcats) {
					chomp($fc);
					@entries=split(/\:/,$fc);
#					print "$entries[0] eq $forums[$f] && $entries[1] eq $disc\n";
					if($entries[0] eq $forums[$f] && $entries[1] eq $disc) { 
						print "<OPTION VALUE=\"$d\" SELECTED>$disc\n";
						$ok="T";
						last;
					}
				}
				if($ok ne "T") {
					print "<OPTION VALUE=\"$d\">$disc\n";
				}
			}
			print "</SELECT>\n";
			print "</TD></TR>\n";
		}
	}
	else {
		for $f (0 .. $#forums) {
			print "<TR><TD><B>$titles[$f]</B></TD>\n";
			print "<TD VALIGN=\"top\">\n";
			print "<SELECT NAME=\"$forums[$f]\" SIZE=3 MULTIPLE>\n";
			foreach $c(@cats) {
				chomp($c);
				$d = $c;
				$d =~ s/ /_/g;
				$ok = "F";
				foreach $fc(@fcats) {
					chomp($fc);
					@entries=split(/\:/,$fc);
					if($entries[0] eq $forums[$f] && $entries[1] eq $c) { 
						print "<OPTION VALUE=\"$d\" SELECTED>$c\n";
						$ok="T";
						last;
					}
				}
				if($ok ne "T") {
					print "<OPTION VALUE=\"$d\">$c\n";
				}
			}
			print "</SELECT>\n";
			print "</TD></TR>\n";
		}
	}

	print "<TR><TD COLSPAN=2><CENTER>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"Save Category Setup\">\n";
	print "<CENTER><INPUT TYPE=\"submit\" VALUE=\"Save Changes!\"></CENTER></TD></TR>\n";
	print "</TABLE>\n";
	print "</FORM></CENTER>\n";

	exit 0;
}



sub Save_Category_Setup {
  	print "Content-type: text/html\n\n";
	opendir(FILES, "$GPath{'cforums_data'}/") || die ERROR("Can't open directory $GPath{'cforums_data'}/");
	while($file = readdir(FILES)) {
		if($file =~ /.*\.cfg/ ) {
			$file =~ s/\.cfg//g;
			push @forums, $file;
		}
	}

	open(CAT,">$GPath{'cforums_data'}/forum.categories");
	if (-e "clubs.cgi") {
		foreach $forum(@forums) {
			$ef = &urlencode($forum);
			if ($FORM{$ef}) {
				@cats = split(/ +/,$FORM{$ef});
				foreach $c(@cats) {
					$c =~ s/_/ /g;
					$c =~ s/(\cM|\n)//g;
					@ttcc = split(/\|/, $c);
					$tc = "\|$ttcc[1]";
					if ($ttcc[2] ne "") {$tc .= "\|$ttcc[2]";}
					print CAT "$forum:$tc\n";
				}
			}
		}
	}
	else {
		foreach $forum(@forums) {
			$tforum = &urlencode($forum);
			$tforum =~ s/%20/\+/g;
#			print "$tforum = $FORM{$tforum}<BR>\n";;
			if ($FORM{$tforum}) {
				@cats = split(/ /,$FORM{$tforum});
				foreach $c(@cats) {
					$c=~ s/_/ /g;
					chomp($c);
					print CAT "$forum:$c\n";
				}
			}
		}
	}

	close(CAT);


	print "<CENTER><TABLE BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub save_categories {
	$fn = "$GPath{'cforums_data'}/categories.def";
	$FORM{'CATS'} =~ s/\cM//g;
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'CATS'}";
	close(FILE);
	chmod 0777, "$fn";


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	exit;
}



sub diehtml {
	local ($Message) = $_[0];
   	print "Content-type: text/html\n\n";
	print "$Message\n\n";
	exit;
}


sub parse_date {
   local ($time) = $_[0];
   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$year = $year + 1900;

   if ($sec < 10) {
      $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   if ($mon < 10) {
      $mon = "0$mon";
   }
   if ($mday < 10) {
      $mday = "0$mday";
   }

   $month = ($mon + 1);

   @months = ("January","February","March","April","May","June","July","August","September","October","November","December");

   $date = "$hour\:$min\:$sec $month/$mday/$year";

   chop($date) if ($date =~ /\n$/);

   #$year = $year + 1900;
   $long_date = "$months[$mon] $mday, $year at $hour\:$min\:$sec";
}




sub Validate_Admin_Local {

   %passcookie= &split_cookie( $ENV{'HTTP_COOKIE'}, 'admin' );
   $password = $passcookie{'password'};


   $Allowed = "F";

   if ($password eq $CONFIG{'admin_pw'}) { $Allowed = "T"; }
   if ($moderator_pw) { $Allowed = "T"; }

   if ($Allowed eq "F") {
	&ADMIN_error("Access Denied.");
        exit 0;
   }

   if (-e "$CONFIG{'data_dir'}/admin_ip.txt") {
		$fn = "$CONFIG{'data_dir'}/admin_ip.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 			$IPaddress = <FILE>;
		close(FILE);
		chomp $IPaddress;
		if ($IP ne "") {
			if (($ENV{'REMOTE_ADDR'} =~ $IPaddress) || ($IPaddress =~ $ENV{'REMOTE_ADDR'})) {
				&ADMIN_error("Access Denied.  Your IP address is not allowed to access the Admin Scripts.  You need to set the allowed IP manually on the server.  You can find out what IP address you are currently using <A HREF=\"getip.cgi\">here</A>.");
			}
		}
	}
}


sub ADMIN_error {
   	$error = $_[0];
   	$UserName = $_[1];
   	$PassWord = $_[2];
  	print "Content-type: text/html\n\n";

   	if ($error eq "bad_username") {
		print "<center><h3>ERROR: No such User</h3>\n";
   	}
   	elsif ($error eq "bad_method") {
		print "<center><h3>ERROR: That Search Won't Work!</h3></CENTER>\n";
		print "You can only compare <B>numbers</B> with \"greater than\" or \"less than\".\n";
   	}
   	else {
		print "<center><h3>ERROR: !</h3></CENTER>\n";
		print "$error\n";
   	}
	exit;
}

sub edit_emails {
	$fn = "$GPath{'cforums_data'}/response_email.txt";
	open(FILE, "$fn");
 		@EMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/referit_email.txt";
	open(FILE, "$fn");
 		@REMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'cforums_data'}/mod_email.txt";
	open(FILE, "$fn");
 		@MEMAIL = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Emails</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "From here you can edit the emails automatically sent to those using your service.\n";
	print "<P>You can automatically insert the following information in the email that someone receives in reponse to a response to their posts:\n";
	print "<LI>[FORUM] - The name of the forum where the post originates.\n";
	print "<LI>[URL] - The address that leads directly to the post itself.\n";
	print "<LI>[SUBJECT] - The subject of the post/thread.\n";
	print "<LI>[DATE] - The date that the recipient posted the message that is being responded to.\n";
	print "<LI>[MESSAGE] - The message text of the response.\n";
	print "<LI>[NAME] - The name of the person who has responded.\n";

	print "<H3>Email informing someone that there has been a response to their post:</H3>\n";
	print "<TEXTAREA NAME=EMAIL COLS=60 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@EMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<H3>Email sent to moderators (if this option is activated):</H3>\n";
	print "<TEXTAREA NAME=MEMAIL COLS=60 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@MEMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<P>You can automatically insert the following information in the email that someone receives when someone recommends a thread to them:\n";
	print "<LI>[SENDER] - The name of the person recommending the thread.\n";
	print "<LI>[SENDEREMAIL] - The email address of the person recommending the thread.\n";
	print "<LI>[RECIPIENTEMAIL] - The email address of the person receiving the recommendation.\n";
	print "<LI>[MESSAGE] - The personal message that was included with the recommendation.\n";
	print "<LI>[URL] - The url (address) of the thread being recommended.\n";

	print "<H3>Email recommending a thread to a person:</H3>\n";
	print "<TEXTAREA NAME=REMAIL COLS=60 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@REMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Email Text\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}


sub save_emails {
	$fn = "$GPath{'cforums_data'}/response_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/referit_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'REMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'cforums_data'}/mod_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'MEMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub edit_badwords {
	$fn = "$CONFIG{'data_dir'}/badwords.txt";
	open(FILE, "$fn");
 		@BAD = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=#ffffcc BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Bad Word Filter</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_admin.cgi'}\">\n";
	print "Banned words are words that are automatically blocked when they are submitted.  A warning page ($CONFIG{'COMMUNITY_bad_words'} as set in the configuration section) is displayed to the user.\n";
	print "<P>\n";

	print "<H3>Edit Banned Words:</H3>\n";
	print "<TEXTAREA NAME=BAD COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@BAD) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Words\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_badwords {
	$fn = "$CONFIG{'data_dir'}/badwords.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'BAD'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'cf_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}




sub parse_FORM_l {
   	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
   	if (length($buffer) < 5) {
         	$buffer = $ENV{QUERY_STRING};
    	}
   	@pairs = split(/&/, $buffer);

   	foreach $pair (@pairs) {
      	($name, $value) = split(/=/, $pair);

      	$value =~ tr/+/ /;
      	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      	if ($FORM{$name} ne "") {
			$FORM{$name} = $FORM{$name} . " " .$value;
		}
		else {
			$FORM{$name} = $value;
		}
	}
}


##############################################################################
#                    ______               __    _
#                   / ____/____   ____   / /__ (_)___   _____
#                  / /    / __ \ / __ \ / //_// // _ \ / ___/
#                 / /___ / /_/ // /_/ // ,<  / //  __/(__  )
#                 \____/ \____/ \____//_/|_|/_/ \___//____/
#
##############################################################################

   ## Sample code to set a cookie....
   ## Note: separate cookie values with a ":"
   #  $newcookie= "voted\~Yes:iscool\~No";
   #  print "Set-Cookie: COOKIENAME=$newcookie;";
   #  print " expires=", &Cookie_Date( time + 31536000 , 1 ), "; path=/\n";

   ## Sample code to get a cookie
   #  %bbscookie= &split_cookie( $ENV{ 'HTTP_COOKIE' }, 'COOKIENAME' );
   #  $bbscookie{'voted'} and $bbscookie{'cool'} are the values...

sub split_cookie
{
   # put cookie into array
   local( $incookie, $tag )= @_;
   local( %cookie );
   $tester= $incookie;
   local( @temp )= split( /; /, $incookie );
   foreach ( @temp )
   {
      ( $temp, $temp2 )= split( /=/ );
      $cookie{ $temp }= $temp2;
   }
   return &split_sub_cookie( $cookie{ $tag } );
}

sub split_sub_cookie
{
   local( $cookie )= @_;
   local( %newcookie );
   local( @temp )= split( /\|/, $cookie );
   foreach ( @temp )
   {
      ( $temp, $temp2 )= split( /~/ );
      $newcookie{ $temp }= $temp2;
   }
   return %newcookie;
}

sub join_cookie
{
   local( %set )= @_;
   local( $newcookie );
   foreach $key( keys %set )
   {
      $newcookie.= "$key\~$set{ $key }:";
   }
   return $newcookie;
}

sub Cookie_Date
{
   local( $time, $format )= @_;

   local( $sec, $min, $hour, $mday, $mon, $year,
          $wday, $yday, $isdst )= localtime( $time );

   $sec = "0$sec" if ($sec < 10);
   $min = "0$min" if ($min < 10);
   $hour = "0$hour" if ($hour < 10);
   $mon = "0$mon" if ($mon < 10);
   $mday = "0$mday" if ($mday < 10);
   local( $month )= ($mon + 1);
   local( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                       "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

   local( @weekday )=( "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" );

   return "$weekday[$wday], $month-$mday-$year $hour\:$min\:$sec GMT";
}

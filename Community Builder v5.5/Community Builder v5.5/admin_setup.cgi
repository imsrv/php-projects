#!/usr/bin/perl
###
#######################################################
#		Community Builder v5.5
#     
#    		Created by  Scripts
# 		Email: Community
#		Web: Community
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1999 Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################

## NT USERS MAY NEED TO EDIT THIS LINE TO 
## THE FULL PATH TO THE VARIABLES.PL FILE
$vari = "variables.pl";


$free_name="";
$path="";
$free_path="";
$url="";
$url_to_icons="";
$url_to_cgi="";

require "variables.pl";

$|=1;
@char_set = ('a'..'z','0'..'9');


$version = "5.0";
$vari_top = 65;
$demo=0;

$member=$ENV{'QUERY_STRING'};

@months = ('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');
$time = time;
($sec,$bmin,$hour,$bmday,$bmon,$byear,$wday,$gy,$isdst) = gmtime($time);
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$bmon++;
$byear += 1900;
$gnow = "$bmon.$bmday.$byear";

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$name =~ tr/+/ /;
	$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
	if($INPUT{'regkey'}){$ry=$INPUT{'regkey'};}
}

if ($path) {
	if ( -e "$path/password.txt") {
		open (VARIABLES, "$path/password.txt") || &error("Error reading password.txt");
		$admin_password = <VARIABLES>;
		close (VARIABLES);
	}
}

$cgiurl = $ENV{'SCRIPT_NAME'};

print "Content-type: text/html\n\n ";
&Header;

if ($INPUT{'log'}) { &log; }
elsif ($INPUT{'del'}) { &del; }
elsif ($INPUT{'setup_check'}) { &setup_check; }
elsif ($INPUT{'features'}) { &features; }
elsif ($INPUT{'features_gen'}) { &features_gen; }
elsif ($INPUT{'features_gbook'}) { &features_gbook; }
elsif ($INPUT{'features_wwwboard'}) { &features_wwwboard; }
elsif ($INPUT{'features_category'}) { &features_category; }
elsif ($INPUT{'features_info'}) { &features_info; }
elsif ($INPUT{'features_ezweb'}) { &features_ezweb; }
elsif ($INPUT{'features_search'}) { &features_search; }
elsif ($INPUT{'features_ftp'}) { &features_ftp; }
else { &main; }
exit;

sub main {
print <<EOF;
This script is not to be called directly....<BR><BR>
Please use admin.cgi...<BR><BR>
Thank you....
<BR><BR>
EOF
&Footer;
exit;
}

########## FEATURES EDIT ##########
sub features {
$password = $INPUT{'password'};
&checkpassword;

if ($INPUT{'features_edit'} =~ /Community Builder Setup/i) {
	&setup;
}
elsif ($INPUT{'features_edit'} =~ /General Operations/i) {


print <<EOF;
<font face=arial size=-1>
<center><B>General Community Operations</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, click on the help icon</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Amount of space to give:
</TD><TD>
<input type="Text" name="total_size" value="$total_size" size=5>&nbsp;&nbsp;<font size=-2>kilobytes</font>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Number of possible folders per account:
</TD><TD>
<input type="Text" name="dir_total" value="$dir_total" size=4>
</TD></TR><TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Number of folders deep to allow in an account:
</TD><TD>
<input type="Text" name="dir_deep" value="$dir_deep" size=4>
</TD></TR><TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Show terms and conditions on signup page:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="terms"
EOF
	if ($terms) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR><TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Show Solution Scripts footer on cgi generated pages:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="credit"
EOF
	if ($credit) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR><TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>If html page has the frameset tag, put no headers or footers:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="frameset"
EOF
	if ($frameset) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR><TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Allow one email address to signup for multiple accounts:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="mult_email"
EOF
	if ($mult_email) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Recieve email upon a new account signup:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="e_notify"
EOF
	if ($e_notify) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>How new accounts are set up:
</TD><TD>
<font face=arial size=-1><select name="acc_type">
EOF
	if ($acc_type eq "Admin Approve Account") {
		$aaprove = "Selected";
	}
	elsif ($acc_type eq "User Selects Password") {
		$userpass = "SELECTED";
	}
	else {
		$epass = "SELECTED";
	}
print <<EOF;
<OPTION value="Email Random Password" $epass>Email Random Password
<OPTION value="User Selects Password" $userpass>User Selects Password
<OPTION value="Admin Approve Account" $aaprove>Admin Approve Account
</SELECT>
</TD></TR>
<TR><TD colspan=2>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Reserved account names:<font size=-2>&nbsp;&nbsp;seperated by commas</FONT>
</TD></TR><TR><TD colspan=2>
<input type="Text" name="reserved" value="$reserved" size=60>
</TD></TR><TR><TD colspan=2><br><br>
<font face=arial size=-1><B><center><font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
Community Color Scheme</center></B></FONT><br><br>
</TD></TR>
<TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Background color:
</TD><TD  bgcolor=$over_bg>
<input type="Text" name="over_bg" value="$over_bg" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Table Background color:
</TD><TD  bgcolor=$table_bg>
<input type="Text" name="table_bg" value="$table_bg" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Table Header Background color:
</TD><TD  bgcolor=$table_head_bg>
<input type="Text" name="table_head_bg" value="$table_head_bg" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Text color:
</TD><TD  bgcolor=$text_color>
<input type="Text" name="text_color" value="$text_color" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Link color:
</TD><TD  bgcolor=$link_color>
<input type="Text" name="link_color" value="$link_color" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Color of text in table:
</TD><TD  bgcolor=$text_table>
<input type="Text" name="text_table" value="$text_table" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Color of text in header of table:
</TD><TD  bgcolor=$text_table_head>
<input type="Text" name="text_table_head" value="$text_table_head" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Color of highlighted text in header of table:
</TD><TD  bgcolor=$text_highlight>
<input type="Text" name="text_highlight" value="$text_highlight" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Font:&nbsp;&nbsp;</FONT><font face=$font_face>Current Font</font>
</TD><TD>
<input type="Text" name="font_face" value="$font_face" size=10>
</TD></TR><TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Font Size:&nbsp;&nbsp;</FONT><font size=$font_size>Current Font Size</font>
</TD><TD>
<input type="Text" name="font_size" value="$font_size" size=4>
</TD></TR><TR><TD colspan=2><br><br><CENTER>
<input type="Submit" name="features_gen" value=" Store these values ">
</TR></TD>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features_edit'} =~ /Web Board/i) {

	open (VARIABLES, "$path/wwwboard_header.txt");
	@wwwboard_headers = <VARIABLES>;
	close (VARIABLES);
	
	open (VARIABLES, "$path/wwwboard_footer.txt");
	@wwwboard_footers = <VARIABLES>;
	close (VARIABLES);	


print <<EOF;
<font face=arial size=-1>
<center><B>Web Board Setup</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, click on the help icon</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Web Board as a feature:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="wwwboard_stat"
EOF
	if ($wwwboard_stat) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD colspan=2> <br>
<font face=arial size=-1><b>If On is selected above, complete the following form fields</b> <br><br>
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Run Web Board as an admin option per account
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="wwwboard_default"
EOF
	if ($wwwboard_default) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>

<TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Limit number of possible messages per account:
</TD><TD>
<input type="Text" name="wwwboard_num" value="$wwwboard_num" size=5>&nbsp;&nbsp;
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Should Web Board files count towards account size:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="wwwboard_size"
EOF
	if ($wwwboard_size) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Use different headers and footers for web board files:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="wwwboard_header"
EOF
	if ($wwwboard_header) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD colspan=2> <br>
<font face=arial size=-1><b>If yes is selected above, enter the headers and footers you want to use below</b>
<BR><BR>
Header:
<BR>
<textarea name="wwwboard_headers" cols="50" rows="5" wrap="PHYSICAL">@wwwboard_headers</textarea>
<BR><br>
Footer:
<BR>
<textarea name="wwwboard_footers" cols="50" rows="5" wrap="PHYSICAL">@wwwboard_footers</textarea>
</TD></TR>
<TR><TD colspan=2><br><br><CENTER>
<input type="Submit" name="features_wwwboard" value=" Store these values ">
</TR></TD>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features_edit'} =~ /GuestBook/i) {

	open (VARIABLES, "$path/gbook_header.txt");
	@gbook_headers = <VARIABLES>;
	close (VARIABLES);
	
	open (VARIABLES, "$path/gbook_footer.txt");
	@gbook_footers = <VARIABLES>;
	close (VARIABLES);	


print <<EOF;
<font face=arial size=-1>
<center><B>Guestbook Setup</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, click on the help icon</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Guestbook as a feature:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="gbook_stat"
EOF
	if ($gbook_stat) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD colspan=2> <br>
<font face=arial size=-1><b>If On is selected above, complete the following form fields</b> <br><br>
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Run Guestbook as an admin option per account
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="gbook_default"
EOF
	if ($gbook_default) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Should Guestbook files count towards account size:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="gbook_size"
EOF
	if ($gbook_size) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Use different headers and footers for Guestbook file:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="gbook_header"
EOF
	if ($gbook_header) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD colspan=2> <br>
<font face=arial size=-1><b>If yes is selected above, enter the headers and footers you want to use below</b>
<BR><BR>
Header:
<BR>
<textarea name="gbook_headers" cols="50" rows="5" wrap="NONE">@gbook_headers</textarea>
<BR><br>
Footer:
<BR>
<textarea name="gbook_footers" cols="50" rows="5" wrap="NONE">@gbook_footers</textarea>
</TD></TR>
<TR><TD colspan=2><br><br><CENTER>
<input type="Submit" name="features_gbook" value=" Store these values ">
</TR></TD>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features_edit'} =~ /Categories/i) {

	opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
	@fileh = grep { /headers/ } readdir(DIR);
	close (DIR);

	opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
	@filef = grep { /footers/ } readdir(DIR);
	close (DIR);

	$the_header = "";
	$the_footer = "";

	foreach $ff(@fileh) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		$the_header .= "<option value=\"$ff\">$ff -- $headers[0]\n";
	}
	
	foreach $ff(@filef) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		$the_footer .= "<option value=\"$ff\">$ff -- $headers[0]\n";
	}	


print <<EOF;
<font face=arial size=-1>
<center><B>Community Categories</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, visit the Online Manual..
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>
</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD>
<font face=arial size=-1>Categories (Neighborhoods) On:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="category"
EOF
	if ($category) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD>
<font face=arial size=-1>Unique usernames for each Categories:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="cata_unique"
EOF
	if ($category eq "unique") {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD>
<font face=arial size=-1>Allow users to be in base dir:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="cata_base"
EOF
	if ($cata_base) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Name:
</TD><TD>
<input type="Text" name="cata_name" value="$cata_name" size=20>
</TD></TR>
<TR><TD align=center colspan=2>
<BR><BR><font face=arial size=-1><B>Add new categories (5 at a time)</B>
<BR><BR>
This section is for adding new categories only,<BR>to edit or delete existing categories,<BR>use the button from the main admin screen</TD></TR>
EOF

$a = 1;
while ($a <= 5) { 

print <<EOF;
<TR><TD colspan=2>
<BR><BR><font face=arial size=-1><B>New Category $a</B><BR><BR></TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Name (what users will see):
</TD><TD>
<input type="Text" name="new_cat_$a" size=20>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Name (what will be added to url):
</TD><TD>
<input type="Text" name="new_url_$a" size=20>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Description:
</TD><TD>
<input type="Text" name="new_des_$a" size=20>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Header for html:
</TD><TD>
<select name="new_head_$a">
$the_header
</select>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Footer for html:
</TD><TD>
<select name="new_foot_$a">
$the_footer
</select>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Header for manager.cgi:
</TD><TD>
<select name="new_mhead_$a">
<option value="default">Default Manager Header
$the_header
</select>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Category Footer for manager.cgi:
</TD><TD>
<select name="new_mfoot_$a">
<option value="default">Default Manager Footer
$the_footer
</select>
</TD></TR>
<TR><TD valign=center>
<font face=arial size=-1>Number of possible accounts:
</TD><TD>
<input type="Text" name="new_tot_$a" value="100" size="4">
</TD></TR>
EOF
$a++
}

print <<EOF;
<TR><TD align=center colspan=2><BR><BR>
<font face=arial size=-1><input type="Submit" name="features_category" value="  Add these Categories  "></TD></TR>
<TR><TD colspan=2><BR><BR>
<font face=arial size=-1>To add sub accounts, in the url text box,
enter the main account fist,<BR>then enter the sub account seperate them by a backslash.
<BR>For Example... <BR><BR>
For then new sub account <B>perl</B>, you would enter:
<BR>
<B>internet/perl</B><BR><BR>
or even deeper (internet/perl already existing):<BR>
<b>internet/perl/scripts</B>
</TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features_edit'} =~ /User Info/i) {


%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");

print <<EOF;
<font face=arial size=-1>
<center><B>Additional User Information</B>
<BR><BR>
<BLOCKQUOTE>
Make users fill out a longer form with more info upon sign up<BR><BR>
For more information on what each item is and does, visit the online manual.. <font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>
</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
EOF

foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {

$thek = $user{$key};
$thekr = "$user{$key}_r";
$thev = $$thek;

print <<EOF;
<TR><TD>
<font face=arial size=-1>$key:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="$user{$key}"
EOF
	if ($thev) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD valign=top>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font face=arial size=1>Required:
</TD><TD>
<font face=arial size=1><input type="Checkbox" name="$user{$key}_r"
EOF
	if ($thev eq "required") {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;Yes<BR><BR>
</TD></TR>
EOF

}

print <<EOF;
<TR><TD colspan=2 align=center>
<input type="Submit" name="features_info" value="  Update Settings  ">
</TD></TR>
</TABLE></FORM>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features_edit'} =~ /EZ WEB/i) {

%user = ("Background Images","bg","General Images","img","Horizontal Rule","hr","Email Images","email");

print <<EOF;
<font face=arial size=-1>
<center><B>EZ WEB PAGE BUILDER CONFIGURATION</B>
<BR><BR>
<BLOCKQUOTE>
The EZ WEB feature is allows users without html knowlegde to create web pages quickly and
easily. This configuration section allows you to set the images that are available for your
users to use when creating their new web page. Each text box below <BR><BR>
For more information on what each item is and does, visit the online manual..<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>
</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
EOF

foreach $key ("Background Images","General Images","Horizontal Rule","Email Images") {

	open (DAT,"<$path/editor_$user{$key}.txt");
	@data = <DAT>;
	close (DAT);
$"='';
print <<EOF;
<TR><TD>
<font face=verdana size=2>
$key<BR>
&nbsp;&nbsp;&nbsp;<textarea name="editor_$user{$key}" cols="50" rows="10" wrap=off>
@data
</textarea><BR><BR>
</TD></TR>
EOF
}
print <<EOF;
<TR><TD align=center>
<input type="Submit" name="features_ezweb" value="  Update Image Files  ">
</TD></TR>
</TABLE></FORM>
EOF
&Footer;
exit;
}

elsif ($INPUT{'features_edit'} =~ /Listing\/Search Engine/i) {

	opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
	@fileh = grep { /headers/ } readdir(DIR);
	close (DIR);

	opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
	@filef = grep { /footers/ } readdir(DIR);
	close (DIR);

	$the_header = "";
	$the_footer = "";

	foreach $ff(@fileh) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);
		if ($search_header eq $ff) { $sel = "SELECTED"; }
		else { $sel=""; }
		$the_header .= "<option value=\"$ff\" $sel>$ff -- $headers[0]\n";
	}
	
	foreach $ff(@filef) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);
		if ($search_footer eq $ff) { $sel = "SELECTED"; }
		else { $sel=""; }
		$the_footer .= "<option value=\"$ff\" $sel>$ff -- $headers[0]\n";
	}	



print <<EOF;
<font face=arial size=-1>
<center><B>Listing/Search Engine Setup</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, click on the help icon</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Display Status Icons:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="search_icons"
EOF
	if ($search_icons) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Number of days for account to be labeled "new"
</TD><TD>
<font face=arial size=-1><input type="Text" name="search_new" value="$search_new" size="5">
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Show only sites with name and description entered:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="search_show"
EOF
	if ($search_show) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Header for search.cgi:
</TD><TD>
<select name="search_header">
$the_header
</select>
</TD></TR>
<TR><TD valign=center>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Footer for search.cgi:
</TD><TD>
<select name="search_footer">
$the_footer
</select>
</TD></TR>
<TR><TD align=center colspan=2><BR><BR>
<input type="Submit" name="features_search" value="  Update Settings  ">
</TD></TR>
</TABLE></FORM>
EOF
&Footer;
exit;
EOF
}
elsif ($INPUT{'features_edit'} =~ /FTP Uploading/i) {


print <<EOF;
<font face=arial size=-1>
<center><B>FTP Uploading/Importing of Files</B>
<BR><BR>
<BLOCKQUOTE>
For more information on what each item is and does, click on the help icon</BLOCKQUOTE>
<FORM METHOD=POST ACTION="$cgiurl">
<input type="Hidden" name="password" value="$password">
<table cellspacing =0 cellpadding =4 border=0>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Allow FTP Uploading/Importing:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="ftp_upload"
EOF
	if ($ftp_upload) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>
<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>FTP as an option per account:
</TD><TD>
<font face=arial size=-1><input type="Checkbox" name="ftp_per"
EOF
	if ($ftp_per) {
		print " CHECKED ";
	}
print <<EOF;
>&nbsp;&nbsp;&nbsp;On
</TD></TR>

<TR><TD>
<font face="Verdana" size="+2" color="#FF0000"><b>?</b></font></a>&nbsp;&nbsp;&nbsp;
<font face=arial size=-1>Server path to FTP directory:
</TD><TD>
<font face=arial size=-1><input type="Text" name="ftp_path" value="$ftp_path" size="30">
</TD></TR>
<TR><TD align=center colspan=2><BR><BR>
<input type="Submit" name="features_ftp" value="  Update Settings  ">
</TD></TR>
</TABLE></FORM>
EOF
&Footer;
exit;
EOF
}

}

########## STORE GENERAL OPERATIONS VALUES ##########
sub features_gen {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[4] = "\$total_size \= \"$INPUT{'total_size'}\"\;\n";
	$variables[10] = "\$credit \= \"$INPUT{'credit'}\"\;\n";
	$variables[11] = "\$terms \= \"$INPUT{'terms'}\"\;\n";
	$variables[12] = "\$acc_type \= \"$INPUT{'acc_type'}\"\;\n";
	$variables[13] = "\$over_bg \= \"$INPUT{'over_bg'}\"\;\n";
	$variables[14] = "\$table_bg \= \"$INPUT{'table_bg'}\"\;\n";
	$variables[15] = "\$table_head_bg \= \"$INPUT{'table_head_bg'}\"\;\n";
	$variables[16] = "\$text_color \= \"$INPUT{'text_color'}\"\;\n";
	$variables[17] = "\$link_color \= \"$INPUT{'link_color'}\"\;\n";
	$variables[18] = "\$text_table \= \"$INPUT{'text_table'}\"\;\n";
	$variables[19] = "\$text_table_head \= \"$INPUT{'text_table_head'}\"\;\n";
	$variables[20] = "\$text_highlight \= \"$INPUT{'text_highlight'}\"\;\n";
	$variables[21] = "\$font_face \= \"$INPUT{'font_face'}\"\;\n";
	$variables[22] = "\$font_size \= \"$INPUT{'font_size'}\"\;\n";
	$variables[23] = "\$frameset \= \"$INPUT{'frameset'}\"\;\n";
	$variables[24] = "\$mult_email \= \"$INPUT{'mult_email'}\"\;\n";
	$variables[25] = "\$reserved \= \"$INPUT{'reserved'}\"\;\n";
	$variables[26] = "\$dir_deep \= \"$INPUT{'dir_deep'}\"\;\n";
	$variables[27] = "\$dir_total \= \"$INPUT{'dir_total'}\"\;\n";
	$variables[28] = "\$e_notify \= \"$INPUT{'e_notify'}\"\;\n";
				
	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);
	
&log("General setup updated");
exit;
}


########## STORE WEB BOARD VALUES ##########
sub features_wwwboard {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[29] = "\$wwwboard_stat \= \"$INPUT{'wwwboard_stat'}\"\;\n";
	$variables[30] = "\$wwwboard_default \= \"$INPUT{'wwwboard_default'}\"\;\n";
	$variables[31] = "\$wwwboard_num \= \"$INPUT{'wwwboard_num'}\"\;\n";
	$variables[32] = "\$wwwboard_size \= \"$INPUT{'wwwboard_size'}\"\;\n";
	$variables[33] = "\$wwwboard_header \= \"$INPUT{'wwwboard_header'}\"\;\n";

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

	$INPUT{'wwwboard_headers'} =~ s/\n//g;
	open (VARIABLES, ">$path/wwwboard_header.txt");
	print VARIABLES $INPUT{'wwwboard_headers'};
	close (VARIABLES);

	$INPUT{'wwwboard_footers'} =~ s/\n//g;
	open (VARIABLES, ">$path/wwwboard_footer.txt");
	print VARIABLES $INPUT{'wwwboard_footers'};
	close (VARIABLES);


&log("Web Board setup updated");
exit;
}

########## FEATURES GUESTBOOK ##########
sub features_gbook {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[50] = "\$gbook_stat \= \"$INPUT{'gbook_stat'}\"\;\n";
	$variables[51] = "\$gbook_default \= \"$INPUT{'gbook_default'}\"\;\n";
	$variables[52] = "\$gbook_size \= \"$INPUT{'gbook_size'}\"\;\n";
	$variables[53] = "\$gbook_header \= \"$INPUT{'gbook_header'}\"\;\n";

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

	$INPUT{'gbook_headers'} =~ s/\n//g;
	open (VARIABLES, ">$path/gbook_header.txt");
	print VARIABLES $INPUT{'gbook_headers'};
	close (VARIABLES);

	$INPUT{'gbook_footers'} =~ s/\n//g;
	open (VARIABLES, ">$path/gbook_footer.txt");
	print VARIABLES $INPUT{'gbook_footers'};
	close (VARIABLES);


&log("Guestbook settings updated");
exit;
}

########## STORE Categories ##########
sub features_category {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	if ($INPUT{'cata_unique'}) {
		$category = "unique";
	}
	elsif ($INPUT{'category'}) {
		$category = "on";
	}
	else {
		$category = "";
	}
	
	$cata_base = "$INPUT{'cata_base'}";
	$cata_name = "$INPUT{'cata_name'}";

	$variables[34] = "\$category \= \"$category\"\;\n";
	$variables[35] = "\$cata_base \= \"$INPUT{'cata_base'}\"\;\n";
	$variables[36] = "\$cata_name \= \"$INPUT{'cata_name'}\"\;\n";

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		$cat{$key} = 1;
	}
		
	$a = 1;
	while ($a <=5) {
		$new_cata = $INPUT{'new_url_' . $a};
		@cc = split(/\//,$new_cata);
		#@cc = reverse(@cc);
		$newc = pop(@cc);		
		#@cc = reverse(@cc);
		if ($newc) {
			unless ($cat{$newc}) {
				if (-e "$free_path/$new_cata") {
					$re{$a} = "Failed -- Dir to be made already exists";
				}
				else {
					$new_line = "$newc\%\%$new_cata|$INPUT{'new_cat_' .$a}|$INPUT{'new_des_'.$a}|$INPUT{'new_head_'.$a}|$INPUT{'new_foot_'.$a}|$INPUT{'new_mhead_'.$a}|$INPUT{'new_mfoot_'.$a}|$INPUT{'new_tot_'.$a}|0|\n";
					open (ACC, ">>$path/categories.txt");
					print ACC $new_line;
					close (ACC);
					mkdir("$free_path/$new_cata", 0777);
					chmod(0777,"$free_path/$new_cata");
					mkdir("$path/members/$newc", 0777);
					chmod(0777,"$path/members/$newc");
					foreach $ch(@char_set) {
						mkdir("$path/members/$newc/$ch", 0777);
						chmod(0777,"$path/members/$newc/$ch");
					}
					$re{$a} = "Completed -- $INPUT{'new_cat_' .$a} created";
				}
			}
			else {
				$re{$a} = "Failed -- $newc already exists as a category name";
			}
		}
		else {
			$re{$a} = "Failed -- Form blank";
		}
	$a++;
	}


&log("Categories setup updated<br>Results are as follows:<BR>1. $re{1}<BR>2. $re{2}<BR>3. $re{3}<BR>4. $re{4}<BR>5. $re{5}");
exit;
}
########## ADDITIONAL USER INFO ##########
sub features_info {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

open (VARIABLES, "$vari");
@variables = <VARIABLES>;
close (VARIABLES);


%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");

$start=37;
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$thekr = "$user{$key}_r";
	if ($INPUT{$thek} && $INPUT{$thekr}) { $INPUT{$thek}="required"; } 
	$variables[$start] = "\$$thek \= \"$INPUT{$thek}\"\;\n";
	$start++;
}

foreach $line(@variables) {
	$line =~ s/1;\n//gi;
}
open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
print VARIABLES "1;\n";
close (VARIABLES);

&log("Addintional User Info Updated");	
}

sub features_ezweb {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

%user = ("Background Images","bg","General Images","img","Horizontal Rule","hr","Email Images","email");

foreach $key ("Background Images","General Images","Horizontal Rule","Email Images") {
	$INPUT{'editor_'.$user{$key}} =~ s/\r//g;
	$INPUT{'editor_'.$user{$key}} =~ s/^\n//g;
	open (VARIABLES, ">$path/editor_$user{$key}.txt");
	print VARIABLES $INPUT{'editor_'.$user{$key}};
	close (VARIABLES);
}

&log("EZ WEB configuration updated");
}

########## FEATURES SEARCH ##########
sub features_search {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[54] = "\$search_icons \= \"$INPUT{'search_icons'}\"\;\n";
	$variables[55] = "\$search_new \= \"$INPUT{'search_new'}\"\;\n";
	$variables[56] = "\$search_show \= \"$INPUT{'search_show'}\"\;\n";
	$variables[57] = "\$search_header \= \"$INPUT{'search_header'}\"\;\n";
	$variables[58] = "\$search_footer \= \"$INPUT{'search_footer'}\"\;\n";

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

&log("Listing/Search Engine settings updated");
exit;
}


########## FEATURES SEARCH ##########
sub features_ftp {
if ($demo) {&demo;}

$password=$INPUT{'password'};
&checkpassword;

	open (VARIABLES, "$vari");
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[59] = "\$ftp_upload \= \"$INPUT{'ftp_upload'}\"\;\n";
	$variables[60] = "\$ftp_path \= \"$INPUT{'ftp_path'}\"\;\n";
	$variables[61] = "\$ftp_per \= \"$INPUT{'ftp_per'}\"\;\n";

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

&log("FTP Uploading/Importing settings updated");
exit;
}

########## LOG ##########
sub log {
$message = $_[0];
print <<EOF; 

<font face=arial><B>$message</B><BR><BR>
<FORM METHOD=POST ACTION="admin.cgi">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<input type="Submit" name="log" value=" Return to main admin screen ">
</FORM><BR><BR><BR><BR>
EOF
&Footer;
exit;
}

########## HEADER FOOTER ##########
sub Header {
unless ($free_name) {
	$free_names = "Community";
}
else {
	$free_names = $free_name;
}

print <<EOF;

<HTML>
<HEAD>
        <TITLE>$free_names</TITLE>
</HEAD>
<BODY bgcolor=#336666 TEXT="#000000" LINK="blue" VLINK="blue" ALINK="blue">

<table border=0 cellpadding=0 cellspacing=0 bgcolor=black width=100%>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=IndianRed colspan=3><FONT COLOR=BLACK FACE=ARIAL SIZE=+3><B>$free_names</B></FONT></TD>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>

	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=BurlyWood colspan=3 align=center><FONT FACE=arial size=+1><B>Community Builder version $version</B></FONT></TD>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR><TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR><TR>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=BurlyWood valign=top width=130>
<BR>
<FONT FACE=arial size=-2>
<CENTER><B>Documentation</B></CENTER><BR>

&nbsp;&nbsp;<font color=black>Admin How-to</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Account Browsing</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Categories</FONT></A><BR>
&nbsp;&nbsp;<font color=black>EZ-Web</FONT></A><BR>
&nbsp;&nbsp;<font color=black>FTP Importing</FONT></A><BR>
&nbsp;&nbsp;<font color=black>General Config</FONT></A><BR>
&nbsp;&nbsp;<font color=black>GuestBook Config</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Headers/Footers</FONT></A><BR>
&nbsp;&nbsp;<font color=black>onHold Accounts</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Listing/Search Engine</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Html Templates</FONT></A><BR>
&nbsp;&nbsp;<font color=black>User Information</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Viewing Account</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Web Board</FONT></A>
<BR><BR>
<img src="$url_to_icons/black.gif" width=130 height=5 border=0><BR><BR>
&nbsp;&nbsp;<font color=black>F.A.Q.s</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Template Library</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Graphic Sets</FONT></A>
<BR><BR>
<img src="$url_to_icons/black.gif" width=130 height=5 border=0><BR><BR>
&nbsp;&nbsp;<font color=black>Members Lounge</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Help Forum</FONT></A><BR>



<BR><BR><BR>
	</TD>
	<TD>
		<img src="$url_to_icons/black.gif" width=5 height=1 border=0>
	</TD>
	<TD bgcolor=white width=100%>
	<TABLE border=0 cellpadding=6 width=100%><TR><TD valign=top><CENTER>
EOF
	
	
}


sub Footer {
print <<EOF;

</TD></TR>
<TR><TD valign=bottom><BR>
<Div align=right><font color=#aaaaaa face=arial size=1>Copyright &copy; 1998-99 <font color=#aaaaaa>Scripts</FONT></a>.&nbsp;&nbsp;&nbsp;&nbsp;</FONT></DIV>
</TD></TR>
</TABLE>
</TD>
<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
</TABLE>

<BR><BR>
EOF
}



sub error {
$error = $_[0] ;
if ($error == 9) {
print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<CENTER>
<TABLE CELLPADDING=2 CELLSPACING=0 BORDER=0 BGCOLOR=#778899 WIDTH=500>
<TR><TD align=center>
<font face=verdana size=2 color=white><B>Wrong registration key</B></FONT>
<TABLE CELLPADDING=8 CELLSPACING=0 WIDTH=100% BGCOLOR=white BORDER=0><TR><TD>
<font face="Verdana" size="1">
The registration key is dynamically created each day and can be obtained from
<B>Scripts</B></A>. Make sure the
key you are using is for: <B>$gnow GMT</B>
<BR><BR>
If you have any problems, please send an email to Community<B>Scripts</B></A>
stating you Community Builder username. 
</TD></TR></TABLE>
</TD></TR></TABLE>
<BR><BR>
EOF
&Footer;
exit;
}
print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<TABLE border=1 bgcolor=Gainsboro><TR align=left><TD>
<font face="Verdana, Arial, Geneva" size="1">
<B>Community Error<BR><BR>
<BR><BR>
<I>$error -- $!</I><BR><BR>
If you are having problems running Community<BR>
please post a message to the Community Builder  Forum</a>
<BR>
</TD></TR></TABLE>
</BODY></HTML>
EOF
exit;
}

########## CHECK ADMIN PASSWORD ##########
sub checkpassword {

if ($INPUT{'password'}) {
	$newpassword = crypt($INPUT{'password'}, ai);
	unless ($newpassword eq $admin_password) {
		print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="Arial">Wrong Password 
</TD></TR></TABLE>
EOF
		&Footer;
		exit;
	}
}
else {
print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="Arial">You must enter a password
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}
$password = $INPUT{'password'};
}

sub demo {

print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<TABLE border=1 bgcolor=Gainsboro><TR align=left><TD>
<font face="Arial" size="-1"><center>
<B>Community Builder Feature Disabled<BR><BR>
<BR><BR>
Because this is a demo open to the public, some features must be disabled<BR>
should you have any questions about this feature, please email us at Community</a>
<BR><BR>
</TD></TR></TABLE>
</BODY></HTML>
EOF
&Footer;
exit;
}
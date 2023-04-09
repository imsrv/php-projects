#!/usr/bin/perl
###
#######################################################
#		Community Builder v5.0
#     
#  		Created by Solution Scripts
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

require "variables.pl";

$| = 1;

unless ($over_bg) { $over_bg= "white"; }
unless ($table_bg) { $table_bg= "white"; }
unless ($table_head_bg) { $table_head_bg= "\#003C84"; }
unless ($text_color) { $text_color= "black"; }
unless ($link_color) { $link_color= "blue"; }
unless ($text_table) { $text_table= "black"; }
unless ($text_table_head) { $text_table_head= "white"; }
unless ($text_highlight) { $text_highlight= "red"; }
unless ($font_face) { $font_face= "verdana"; }
unless ($font_size) { $font_size= "-1"; }
unless ($total_size) { $total_size= 250; }

print "Content-type: text/html\n\n ";
@char_set = ('a'..'z','0'..'9');

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

%good_types = (".htm","html",".html","html",".gif","image",".jpg","image",".jpeg","image",".txt","text");

$template=0;
$insert =0;
$delete =0;
$inserts =0;
$deletes =0;

$version = "3.13";
#print "<font face=verdana size=1>";

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$value =~ s/\r//g;
	if ($name =~ /^template_[0-9]*\.dat/) {
		$template =$name;
	}
	if ($name =~ /^insert_[0-9]*\.[x|y]$/) {
		$name =~ s/\.[x|y]$//;
		$insert = $name;
		$insert =~ s/^insert_//i;
		$inserts=1;
	}
	if ($name =~ /^delete_[0-9]*\.[x|y]$/) {
		$name =~ s/\.[x|y]$//;
		$delete = $name;
		$delete =~ s/^delete_//i;
		$deletes=1;
	}

	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
#print "$name = $value<BR>";
}
#print "INSERT -- $insert<BR>";
$cgiurl = $ENV{'SCRIPT_NAME'};

$preiview =0;

open (DAT,"<$path/editor_hr.txt");
@f_hr = <DAT>;
close (DAT);


open (DAT,"<$path/editor_email.txt");
@f_email = <DAT>;
close (DAT);

open (DAT,"<$path/editor_img.txt");
@f_img = <DAT>;
close (DAT);

open (DAT,"<$path/editor_bg.txt");
@f_bg = <DAT>;
close (DAT);

$query = $ENV{'QUERY_STRING'};
if ($query) { &view_images; }

if ($INPUT{'new'}) { &new; }
elsif ($template) { &template; }
elsif ($INPUT{'insert'}) { &new; }
elsif ($INPUT{'preview'}) { &preview; }

elsif ($INPUT{'delete'}) { &new; }
&new;
exit;

sub view_images {
print <<EOF;
<HTML><HEAD><TITLE>Image Selections</TITLE>
</HEAD><center>
<font size=2 face=arial><B>Possible Images that you can select</B>
<BR><BR>
<TABLE cellpadding=5 border=0>

EOF
if ($query eq 'bg') {
	@files = @f_bg;
}
elsif ($query eq 'hr') {
	@files = @f_hr;
}
elsif ($query eq 'email') {
	@files = @f_email;
}
elsif ($query eq 'img') {
	@files = @f_img;
}

foreach $ff (@files) {
	@nff = split(/\,/,$ff);
	if ($nff[1] && $nff[0]) {
print <<EOF;
<TR><TD align=center>
<font size=2 face=arial>
<B>$nff[1]</B><BR>
<img src="$nff[0]" border=0>
<BR><BR></TD></TR>
EOF
	}
}

print "</TABLE>";
exit;
}
########## PREVIEW FILE #######
sub preview {

&checkpword;

$preview=1;
$total = $INPUT{'total'};

$html .=<<EOF;
<HTML><HEAD><TITLE>$INPUT{'title'}</TITLE>
EOF

if ($INPUT{'meta_key'}) {
	$html .="<meta http-equiv=\"keywords\" content=\"$INPUT{'meta_key'}\">\n";
}
if ($INPUT{'meta_des'}) {
	$html .="<meta http-equiv=\"description\" content=\"$INPUT{'meta_des'}\">\n";
}

$html .= "</HEAD>\n<BODY ";
unless ($INPUT{'bgcolor'} eq 'None') {
	$html .= "bgcolor=\"$INPUT{'bgcolor'}\" ";
}
unless ($INPUT{'bgimage'} eq 'None') {
	$html .= "background=\"$INPUT{'bgimage'}\" ";
}
unless ($INPUT{'textcolor'} eq 'None') {
	$html .= "text=\"$INPUT{'textcolor'}\" ";
}
unless ($INPUT{'linkcolor'} eq 'None') {
	$html .= "link=\"$INPUT{'linkcolor'}\" ";
}
unless ($INPUT{'vlinkcolor'} eq 'None') {
	$html .= "vlink=\"$INPUT{'vlinkcolor'}\" alink=\"$INPUT{'alinkcolor'}\" ";
}
$html .= ">\n";

unless ($total) {
	$total = 0;
}
$a=0;
$b=0;
$new_total = $total;

while ($a <= $total) {
	## GET TYPE ## TYPE OLD NEW ##
	&get_type($INPUT{'temp_' . $a . '_type'},$b,$a);
	$b++;
	$a++;
}
$html .= "</BODY></HTML>\n";

if ($INPUT{'preview'} =~ /create/gi) {
	$head .= "<!--START EZ_WEB HTML-->\n";
	foreach $key (keys %INPUT) {
		unless (($key eq "preview") || ($key eq "password") || ($key eq "account") || ($key eq "cata") || ($key eq "all_files") || ($key eq "html") || ($key eq "other") || ($key eq "image") || ($key eq "active_dir") || ($key eq "file_name")) {
			$pkey = $INPUT{$key};
			$pkey =~ s/\%\%//g;
			$pkey =~ s/\n/\\n/gi;
			$head.= "<!--%%$key%%$pkey%%-->\n";
		}
	}

	$content = $html;
	$content = &add_header;
	$head .= "<!--END EZ_WEB HTML-->\n";

	@filename=split(/\./,$INPUT{'file_name'});
	$ext = "." . $filename[1];
	$ext ="\L$ext\E";
	$base_name = $filename[0];
	@out = split(//,$base_name);
	$a=0;
	foreach $char (@out) {
		$a++;	
		unless (($char =~ /[a-z]/) || ($char =~ /[A-Z]/) || ($char =~ /[0-9]/) || ($char =~ /_/)){
			$error .= "<font face=$font_face><B>$file -- Invalid File name</B></font><BR></b>";
			last;
		}
	}
	unless ($a) {
		$error .= "<font face=$font_face><B>You must enter a file name</B></font><BR></b>";
	}
	unless ($ext && ($good_types{$ext})) {
		$error .= "<font face=$font_face><B>$ext -- Invalid file type</B></font><BR>";
	}
	if ($error) {
		&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor="#E0C2C2">
<TR><TD><font face=$font_face size=$font_size>
There is a problem with the filename you entered<BR><BR>
$error
<BR>Please hit your back button and fix this problem.
</TD></TR></TABLE>
EOF
		&Footer;
		exit;
	}

	open (FILE, ">$free_path/$dir_acc/_temp.html");
	print FILE $head;
	print FILE $content;
	close (FILE);

	@stats = stat("$free_path/$dir_acc/_temp.html");
	$sizes = $stats[7];
	$sizes = $sizes /1000;
	@stats = stat("$free_path/$dir_acc/$INPUT{'file_name'}");
	$size = $stats[7];
	$size = $size /1000;
	$t_size = $sizes - $size + $acco[3];
	$total_size += $acco[6];

	if ($t_size > $total_size) {
		&Header;
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor="#E0C2C2">
<TR><TD><font face=$font_face size=$font_size>
<B>The file you just tried to create or edit took you over the size limit,<BR>Please go back and make the file smaller.</TD></TR></TABLE>

EOF
		&Footer;
		unlink ("$free_path/$dir_acc/_temp.html");
		exit;
	}

	open (DAT,">$free_path/$dir_acc/$INPUT{'file_name'}");
	print DAT $head;
	print DAT $content;
	close (DAT);

	unlink ("$free_path/$dir_acc/_temp.html");
}
else {
	print $html;
	exit;
}
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font face=$font_face size=$font_size color=$text_table>
Your file was successfully created/edited, please continue on.
<form action="manager.cgi" method="POST">
$hidden_variables
<input type="Submit" name="log" value="  Back to the File Manager  ">
</form>
</TD></TR></TABLE>
EOF
&Footer;
exit;
}

######### NEW #########
sub new {

&checkpword;

if ($INPUT{'from_manager'}) {
	$INPUT{'file_name'} = $INPUT{'sfile'};
	undef $/;
	open (HEAD, "$free_path/$dir_acc/$INPUT{'sfile'}");
	$sfile = <HEAD>;
	close (HEAD);

	$sfile =~ s/<!--START EZ_WEB HTML-->\n//gm;
	$sfile =~ s/<!--END EZ_WEB HTML-->(.|\n)*//gm;	

	@asfile = split(/\n/,$sfile);
	
	foreach $line (@asfile) {
		@aline = split(/\%\%/,$line);
		$aline[2] =~s/\\n/\n/gi;
		$INPUT{$aline[1]} =$aline[2];
	}		
}


print <<EOF;
<HTML>
<HEAD>
<TITLE>EZ-Web page builder</TITLE>
EOF
&Header;
print <<EOF;
<script language="JavaScript1.1">
<!--
function previewForm() {
	document.htmlForm.target="preview"
	document.htmlForm.submit
}
function saveForm() {
	document.htmlForm.target="_self"
	document.htmlForm.submit
}
//-->
</script>


</HEAD>

<BODY>
<center><BR><BR>
<form action="$cgiurl" method="POST" name="htmlForm">
$hidden_variables
<Table border=1 cellpadding=5 cellspacing=0>

<TR bgcolor=blue><TD valign=center>
<font size=2 face=arial color=white>File Name and Meta infomation
</TD></TR>

<TR align=left><TD valign=center>
<font size=2 face=arial>File Name: 
<input type="Text" name="file_name" size="15" value="$INPUT{'file_name'}">
&nbsp;&nbsp;&nbsp;Should end with .html or .htm
</TD></TR>

<TR align=left><TD valign=center>
<font size=2 face=arial>
Keywords: <input type="Text" name="meta_key" size="20" value="$INPUT{'meta_key'}">
&nbsp;&nbsp;&nbsp;Description: <input type="Text" name="meta_des" size="20" value="$INPUT{'meta_des'}">

</TD></TR>

<TR bgcolor=blue><TD valign=center>
<font size=2 face=arial color=white>Header info
</TD></TR>

<TR align=left><TD valign=center>
<font size=2 face=arial>Page Title: 
<input type="Text" name="title" size="40" value="$INPUT{'title'}">
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Background color: <select name="bgcolor">
EOF
&print_colors($INPUT{'bgcolor'});
print <<EOF;
</select>
&nbsp;&nbsp;&nbsp;
Background image: <select name="bgimage">
<option value="None">None
EOF
&get_image('bg','select',$INPUT{'bgimage'});
print <<EOF;
</select>
&nbsp;&nbsp;<a href="$cgiurl?bg" target="ins"><img src="$url_to_icons/ez_image.gif" border=0 alt="view images"></a>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Text color: <select name="textcolor">
EOF
&print_colors($INPUT{'textcolor'});
print <<EOF;
</select>&nbsp;&nbsp;&nbsp;
Link color: <select name="linkcolor">
EOF
&print_colors($INPUT{'linkcolor'});
print <<EOF;
</select>&nbsp;&nbsp;&nbsp;
Visited link color: <select name="vlinkcolor">
EOF
&print_colors($INPUT{'vlinkcolor'});
print <<EOF;
</select>
</TD></TR>
EOF
$last = "title";

########## START LOOP ##########
$total = $INPUT{'total'};

unless ($total) {
	$total = 0;
}
$a=0;
$b=0;
$new_total = $total;

&print_insert($b);

while ($a <= $total) {
	unless ($delete == $a) { # DELETE NOT EQUAL A #
		if ($INPUT{'temp_' . $a . '_type'}){
			## GET TYPE ## TYPE OLD NEW ##
			&get_type($INPUT{'temp_' . $a . '_type'},$b,$a);
			&print_insert($b);
			
		}
	}
	elsif ($deletes) {
		$b = $b-1;
		$new_total = $total-1;
	}
	if ($inserts) {
		if ($insert == $a) {
			$b++;
			&get_type($INPUT{'insert_type_' . $a},$b);
			&print_insert($b,"0");	
			$new_total++;
		}
	}
	$b++;
	$a++;
}

print <<EOF;
</TABLE>
<input type="Hidden" name="total" value="$new_total">
<br><br>
<input type="Submit" name="preview" value="Create/Save File" onClick="saveForm(this.form);">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="Submit" name="preview" value="Preview File" onClick="previewForm(this.form);">
</FORM>
<script language="JavaScript1.1">
<!--
	document.htmlForm.$last.focus();
//-->
</script>
EOF
&Footer;
print "</BODY></HTML>";

exit;
}

########## GET TYPE ##########
sub get_type {

$type = $_[0];
$num = $_[1];
$num_old = $_[2];

if ($type eq 'Text') {
	&print_text($num,$num_old);
}
elsif ($type eq 'Start Font') {
	&print_startfont($num,$num_old);
}
elsif ($type eq 'End Font') {
	&print_endfont($num,$num_old);
}
elsif ($type eq 'Link') {
	&print_link($num,$num_old);
}
elsif ($type eq 'Image') {
	&print_image($num,$num_old);
}
elsif ($type eq 'New Line') {
	&print_new_line($num,$num_old);
}
elsif ($type eq 'Email Link') {
	&print_email($num,$num_old);
}
elsif ($type eq 'Horizontal Rule') {
	&print_hr($num,$num_old);
}
}

########## INSERT OPTIONS ##########
sub print_insert {

$num = $_[0];

@options = ("Text","Link","Image","New Line","Email Link","Start Font","End Font","Horizontal Rule");

print <<EOF;
<TR align=left bgcolor="silver"><TD valign=center>
<font size=2 face=arial color=white>
<select name="insert_type_$num">
EOF

foreach $option(@options) {
	print "<option value=\"$option\">$option\n";
}

print <<EOF;
</SELECT>&nbsp;&nbsp;&nbsp;
<input type="image" src="$url_to_icons/insert.gif" name="insert_$num" onClick="saveForm(this.form);" align=middle>
</TD></TR>
EOF

}

########### PRINT COLORS #########
sub print_colors {

local($selected) = $_[0];

@colors = ("None","Black","Maroon","Green","Olive","Navy","Purple","Teal","Silver","Gray","Red","Lime","Yellow","Blue","Fuchsia","Aqua","White");

foreach $color(@colors) {
	$sell = '';
	if ($selected eq $color) {
		$sell = 'SELECTED';
	}
	print "<option value=\"$color\" $sell>$color\n";
}
}

########## PRINT FACE FONT #########
sub print_fontface {

local($selected) = $_[0];

@faces = ("None","Arial","Times","Verdana");

foreach $face(@faces) {
	$sell = '';
	if ($selected eq $face) {
		$sell = 'SELECTED';
	}
	print "<option value=\"$face\" $sell>$face\n";
}

}
#

########### PRINT FACE SIZE #########
sub print_fontsize {

local($selected) = $_[0];

@faces = ("None","1","2","3","-1","-2","+1","+2","+3");

foreach $face(@faces) {
	$sell = '';
	if ($selected eq $face) {
		$sell = 'SELECTED';
	}
	print "<option value=\"$face\" $sell>$face\n";
}

}

########## PRINT FACE FONT #########
sub print_align {

local($selected) = $_[0];

@faces = ("None","Center","Left","Right");

foreach $face(@faces) {
	$sell = '';
	if ($selected eq $face) {
		$sell = 'SELECTED';
	}
	print "<option value=\"$face\" $sell>$face\n";
}

}


########### INSERT TEXT ##########
sub print_text {

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	$html .= "$INPUT{'text_' . $num_old}\n";
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="Text">
<font size=2 face=arial color=white>$num. Text&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
<textarea name="text_$num" cols="45" rows="10" wrap="OFF">
$INPUT{'text_' . $num_old}
</textarea>
</TD></TR>
EOF
$last = "text_$num";
}
}

########### INSERT start font ##########
sub print_startfont {

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

$nsel = '';
$bsel = '';
$isel = '';
$usel = '';

if ($INPUT{'textradio_' . $num_old} eq "bold") {
	$html .="<B>" if ($preview);
	$bsel = "CHECKED";
}
elsif ($INPUT{'textradio_' . $num_old} eq "italics") {
	$html .="<I>" if ($preview);
	$isel = "CHECKED";
}
elsif ($INPUT{'textradio_' . $num_old} eq "underline") {
	$html .="<U>" if ($preview);
	$usel = "CHECKED";
}
else {
	$nsel = "CHECKED";
}
if ($preview) {
	unless ($INPUT{'textalign_' . $num_old} eq 'None') {
		$html .= "<DIV ALIGN=$INPUT{'textalign_' . $num_old}>";
		$div = "CHECKED";
	}
	$font=1;
	unless ($INPUT{'textcolor_' . $num_old} eq 'None') {
		$html .="<FONT ";
		$html .="COLOR=\"$INPUT{'textcolor_' . $num_old}\" ";
		$font=0;
	}
	unless ($INPUT{'textface_' . $num_old} eq 'None') {
		$html .="<FONT " if ($font); 
		$html .="FACE=\"$INPUT{'textface_' . $num_old}\" ";
		$font=0;
	}
	unless ($INPUT{'textsize_' . $num_old} eq 'None') {
		$html .="<FONT " if ($font);
		$html .="SIZE=\"$INPUT{'textsize_' . $num_old}\" ";
		$font=0;
	}
	unless ($font) {
		$html .=">";
	}
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="Start Font">
<font size=2 face=arial color=white>$num. Start Font&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Text color: <select name="textcolor_$num">
EOF
&print_colors($INPUT{'textcolor_' . $num_old});
print <<EOF;
</select>
&nbsp;&nbsp;&nbsp;
Font face: <select name="textface_$num">
EOF
&print_fontface($INPUT{'textface_' . $num_old});
print <<EOF;
</select>
&nbsp;&nbsp;&nbsp;
Font size: <select name="textsize_$num">
EOF
&print_fontsize($INPUT{'textsize_' . $num_old});
print <<EOF;
</select>
<font size=2 face=arial><BR>
Normal - <input type="Radio" name="textradio_$num" value="normal" $nsel>&nbsp;&nbsp;
<B>Bold</B> - <input type="Radio" name="textradio_$num" value="bold" $bsel>&nbsp;&nbsp; 
<i>Italics</i> - <input type="Radio" name="textradio_$num" value="italics" $isel>&nbsp;&nbsp;
<u>Underline</u> - <input type="Radio" name="textradio_$num" value="underline" $usel>
&nbsp;&nbsp;&nbsp;
Alignment <select name="textalign_$num">
EOF
&print_align($INPUT{'textalign_' . $num_old});
print <<EOF;
</SELECT>
</TD></TR>
EOF
$last = "textcolor_$num";
}
}

########### INSERT start font ##########
sub print_endfont {

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";
if ($preview && $bsel) {
	$html .= "</B>";
}
if ($preview && $isel) {
	$html .= "</I>";
}
if ($preview && $usel) {
	$html .= "</U>";
}
if ($preview && $div) {
	$html .= "</DIV>";
}
if ($preview) {
	$html .="</FONT>";
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="End Font">
<font size=2 face=arial color=white>$num. End Font&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial><b>Ending Font</b> -- nothing to change
</TD></TR>
EOF
}
}

########### INSERT LINK ##########
sub print_link {

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	if ($INPUT{'urlmouse_' . $num_old}) {
$html .=<<EOF;
<A HREF="$INPUT{'url_' . $num_old}" OnMouseOut="window.status=''; return true"  OnMouseOver="window.status='$INPUT{'urlmouse_' . $num_old}'; return true">$INPUT{'urltext_' . $num_old}</A>
EOF
	}
	else {
		$html .="<A HREF=\"$INPUT{'url_' . $num_old}\">$INPUT{'urltext_' . $num_old}</A>";
	}
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="Link">
<font size=2 face=arial color=white>$num. Link&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Link Url: </FONT><input type="Text" name="url_$num" value="$INPUT{'url_' . $num_old}" size="25">
&nbsp;&nbsp;&nbsp;
<font size=2 face=arial>Link Text:</FONT> <input type="Text" name="urltext_$num" value="$INPUT{'urltext_' . $num_old}" size="25"> 
<BR>
<font size=2 face=arial>Mouseover Text:</FONT> <input type="Text" name="urlmouse_$num" value="$INPUT{'urlmouse_' . $num_old}" size="25">
</TD></TR>
EOF
$last = "url_$num";
}
}

########## NEW LINE #########
sub print_new_line{

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	$html .="<BR>";
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="New Line">
<font size=2 face=arial color=white>$num. New Line&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);"> align=middle
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
<B>Line Break</B> -- nothing to change
</TD></TR>
EOF
}
}

########### INSERT EMAIL ##########
sub print_email{

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	if ($INPUT{'formemail_' . $num_old}) {
$html .=<<EOF;
<form action="$url_to_cgi/features.cgi" method="POST">
<input type="Hidden" name="account" value="$account">
<input type="Hidden" name="cata" value="$cata">
<BR>Your Name: <input type="Text" name="name" size="20">
<BR>Your Email: <input type="Text" name="email" size="20">
<BR>Comments:
<BR><textarea name="comments" cols="30" rows="5"></textarea>
<BR>
<input type="Submit" name="formmail" value="Send to Us">
</FORM>
EOF
	}
	else {
		$html .="<A HREF=\"mailto:$INPUT{'urlemail_' . $num_old}\">";
		if ($INPUT{'textemail_' . $num_old}) {
			$html .="$INPUT{'textemail_' . $num_old}</A>";
		}
		else {
			$html .="<IMG SRC=\"$INPUT{'imageemail_'.$num}\"></A>";
		}
	}		
}
else {
$email_ch = "";
	if ($INPUT{'fromemail_'.$num}) {
		$email_ch = " CHECKED"; 
	}
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="Email Link">
<font size=2 face=arial color=white>$num. Email Link&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Email Address: <input type="Text" name="urlemail_$num" value="$INPUT{'urlemail_' . $num_old}" size="15">&nbsp;&nbsp;&nbsp;Use Email form: <input type="Checkbox" name="formemail_$num" value="form" $email_ch>
<BR>
Email Link Text: <input type="Text" name="textemail_$num" value="$INPUT{'textemail_' . $num_old}" size="15">
&nbsp;&nbsp;<B>or</B>&nbsp;&nbsp;
Email Image: <select name="imageemail_$num">
<option value="None">None
EOF
&get_image('email','select',$INPUT{'imageemail_'.$num});
print <<EOF;
</select>
&nbsp;&nbsp;<a href="$cgiurl?email" target="ins"><img src="$url_to_icons/ez_image.gif" border=0 alt="view images"></a>
</TD></TR>
EOF
$last = "urlemail_$num";
}
}

########## HORIZONTAL RULE #########
sub print_hr{

$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	if ($INPUT{'hrimage_'.$num} ne 'None') {
		($hr_url,$hr_w,$hr_h) = &get_image('hr','get',$INPUT{'hrimage_'.$num});
		$html .="<IMG SRC=\"$hr_url\"><BR>";
	}
	else {
		$html .="<HR ALIGN=\"$INPUT{'hralign_'.$num}\" ";
		if ($INPUT{'hrsize_'.$num}) {
			$html .="SIZE=\"$INPUT{'hrsize_'.$num}\" ";
		}
		if ($INPUT{'hrwidth_'.$num}) {
			$html .="WIDTH=\"$INPUT{'hrwidth_'.$num}\" ";
		}
		if ($INPUT{'hrcolor_'.$num} ne 'None') {
			$html .="COLOR=\"$INPUT{'hrcolor_'.$num}\" ";
		}
		if ($INPUT{'hrshade_'.$num}) {
			$html .="NOSHADE";
		}
		$html .=">";
	}
}
else {
$shade_ch = "";
	if ($INPUT{'hrshade_'.$num}) {
		$shade_ch = " CHECKED"; 
	} 
print <<EOF;
<TR align=left bgcolor=blue><TD valign=center>
<input type="Hidden" name="$tt" value="Horizontal Rule">
<font size=2 face=arial color=white>$num. Horizontal Rule&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Alignment: <select name="hralign_$num"><option value="center">Center<option value="left">Left<option value="right">Right</select>
&nbsp;&nbsp;&nbsp;Size: <input type="Text" name="hrsize_$num" size="4">
&nbsp;&nbsp;&nbsp;Width: <input type="Text" name="hrwidth_$num" size="4">
&nbsp;&nbsp;&nbsp;Color: 
<select name="hrcolor_$num">
EOF
&print_colors($INPUT{'hrcolor_'.$num});
print <<EOF;
</SELECT><BR>
No Shade: <input type="Checkbox" name="hrshade_$num" $shade_ch>&nbsp;&nbsp;&nbsp;<B>or</B>&nbsp;&nbsp;&nbsp;
Image: <select name="hrimage_$num"><option value="None">None
EOF
&get_image('hr','select',$INPUT{'hrimage_'.$num});
print <<EOF;
</select>
&nbsp;&nbsp;<a href="$cgiurl?hr" target="ins"><img src="$url_to_icons/ez_image.gif" border=0 alt="view images"></a>
</TD></TR>
EOF
}
}

####
sub print_image {
$num = $_[0];
$num_old = $_[1];
$tt = "temp_" . $num . "_type";

if ($preview) {
	if ($INPUT{'imgalign_'.$num} eq 'Center') { $html .= "<DIV ALIGN=CENTER>"; }
	if ($INPUT{'imgurl_' . $num}) {
		$html .= "<A HREF=\"$INPUT{'imgurl_' . $num}\">";
	}
	if ($INPUT{'imgimage_'.$num} ne 'None') {
		($img_url,$img_w,$img_h) = &get_image('img','get',$INPUT{'imgimage_'.$num});

		$html .= "<IMG SRC=\"$img_url\" ";
		if ($img_w) { $html .= "width=$img_w "; }
		chomp($img_h);
		if ($img_h) { $html .= "height=$img_h "; }
		if (($INPUT{'imgalign_'.$num} ne 'None') || ($INPUT{'imgalign_'.$num} ne 'Center')) {
			$html .= "ALIGN=\"$INPUT{'imgalign_'.$num}\" ";
		}
		if ($INPUT{'imgborder_'.$num}) {
			$html .="BORDER=\"$INPUT{'imgborder_'.$num}\" ";
		}
		$html .=">";		
	}
	else {
		$html .="<IMG SRC=\"$INPUT{'img_'.$num}\" ";
		if ($INPUT{'imgborder_'.$num}) {
			$html .="BORDER=\"$INPUT{'imgborder_'.$num}\" ";
		}
		if ($INPUT{'imgwidth_'.$num}) {
			$html .="WIDTH=\"$INPUT{'imgwidth_'.$num}\" ";
		}
		if ($INPUT{'imgheight_'.$num}) {
			$html .="HEIGHT=\"$INPUT{'imgheight_'.$num}\" ";
		}
		if (($INPUT{'imgalign_'.$num} ne 'None') || ($INPUT{'imgalign_'.$num} ne 'Center')) {
			$html .="ALIGN=\"$INPUT{'imgalign_'.$num}\" ";
		}
		$html .=">";
	}
	if ($INPUT{'imgalign_'.$num} eq 'Center') { $html .= "</DIV>"; }
}
else {
print <<EOF;
<TR align=left bgcolor=blue><TD valign=middle>
<input type="Hidden" name="$tt" value="Image">
<font size=2 face=arial color=white>$num. Image&nbsp;&nbsp;&nbsp;
<input type="image" name="delete_$num" src="$url_to_icons/delete.gif" onClick="saveForm(this.form);" align=middle>
</TD></TR>
<TR align=left><TD valign=center>
<font size=2 face=arial>
Image Url: </FONT><input type="Text" name="img_$num" value="$INPUT{'img_' . $num_old}" size="25">
&nbsp;&nbsp;
<font size=2 face=arial>Width:</FONT> <input type="Text" name="imgwidth_$num" value="$INPUT{'imgwidth_' . $num_old}" size="3"> 
&nbsp;&nbsp;
<font size=2 face=arial>Height:</FONT> <input type="Text" name="imgheight_$num" value="$INPUT{'imgheight_' . $num_old}" size="3">
&nbsp;&nbsp;
<font size=2 face=arial>Border:</FONT> <input type="Text" name="imgborder_$num" value="$INPUT{'imgborder_' . $num_old}" size="2"><BR>
<font size=2 face=arial>Premade:</FONT> <select name="imgimage_$num"><option value="None">None
EOF
&get_image('img','select',$INPUT{'imgimage_'.$num});
print <<EOF;
</select>
&nbsp;&nbsp;<a href="$cgiurl?img" target="ins"><img src="$url_to_icons/ez_image.gif" border=0 alt="view images"></a>
&nbsp;&nbsp;
<font size=2 face=arial>Link image to url:</FONT> <input type="Text" name="imgurl_$num" value="$INPUT{'imgwidth_' . $num_old}" size="15"> 
&nbsp;&nbsp;
<font size=2 face=arial>Alignment:</FONT> <select name="imgalign_$num">
EOF
&print_align($INPUT{'imgalign_' . $num_old});
print <<EOF;
</SELECT>
</TD></TR>
EOF
$last = "img_$num";
}
}



###########
sub get_image {
$what = $_[0];
$wtype = $_[1];
$wold = $_[2];

if ($what eq 'bg') {
	@files = @f_bg;
}
elsif ($what eq 'hr') {
	@files = @f_hr;
}
elsif ($what eq 'img') {
	@files = @f_img;
}
elsif ($what eq 'email') {
	@files = @f_email;
}

foreach $ff (@files) {
	@nff = split(/\,/,$ff);
	if (($wtype eq 'select') && $nff[0]) {
		print "<option value=\"$nff[0]\" ";
		if ($wold eq $nff[0]) {
			print "SELECTED";
		}
		print ">$nff[1]\n";
	}
	elsif ($wold eq $nff[0]){
		return($nff[0],$nff[2],$nff[3]);	
	}
}

}



###################################################################
######## TEMPLATE STUFF ###########################################
###################################################################

sub template {

&checkpword;

if ($INPUT{'save'} || $INPUT{'preview'}) {
	&save_template;
	exit;
}

undef $/;
	
open (HEAD, "$path/$template");
$ffil = <HEAD>;
close (HEAD);
@afil = split(/\n/,$ffil);
$line1 = $afil[0];
$line2 = $afil[1];

if ($INPUT{'sfile'}) {

	open (HEAD, "$free_path/$dir_acc/$INPUT{'sfile'}");
	$sfile = <HEAD>;
	close (HEAD);

	$sfile =~ s/<!--START EZ_WEB TEMP-->\n//gm;
	$sfile =~ s/<!--END EZ_WEB TEMP-->(.|\n)*//gm;	

	@asfile = split(/\n/,$sfile);
	
	foreach $line (@asfile) {
		@aline = split(/\%\%/,$line);
		$ffil =~ s/\%$aline[1]\%/$aline[2]/g;
	}		

	$ffil =~ s/\%.*\%//g;
}
else {

	$defalt = $ffil;
	$defalt =~ s/START_DEFAULTS\n//gm;
	$defalt =~ s/END_DEFAULTS(.|\n)*//gm;	

	$ffil =~ s/START_DEFAULTS(.|\n)*?END_DEFAULTS\n//m;

	@asfile = split(/\n/,$defalt);
	
	foreach $line (@asfile) {
		chomp($line);
		@aline = split(/\%\%/,$line);
		$ffil =~ s/\%$aline[0]\%/$aline[1]/g;
	}

	$ffil =~ s/\%.*\%//g;
}

$ffil =~ s/.*\n.*\n//m;

print <<EOF;
<HTML>
<HEAD>
<TITLE></TITLE>
<script language="JavaScript1.1">
<!--
function previewForm() {
	document.htmlForm.target="preview"
	document.htmlForm.submit
}
function saveForm() {
	document.htmlForm.target="_self"
	document.htmlForm.submit
}
//-->
</script>


</HEAD>

<BODY>
<CENTER>
<FORM METHOD=POST ACTION="$cgiurl" name="htmlForm">
$hidden_variables
<TABLE border=0 cellpadding=5 width=500><TR>
<TD colspan=2 align=center>
<font face=$font_face size=$font_size>
<B>$line1</B><BR><BR>
</TD></TR>
<TR><TD>
<font face=$font_face size=$font_size>
<B>Choose a file name</B> - should be only letters and should have
a file exstension of .html or .html For example hello.html
</TD><TD>
<input type="Text" name="_file_name_" size="20" value="$INPUT{'sfile'}">
</TD></TR>
</TABLE>
<BR></CENTER><BR>
$ffil
<CENTER>
<BR><BR>
<input type="Hidden" name="$template" value="$tepmlate">
<input type="Submit" name="save" value = " Create/Save " onClick="saveForm(this.form);">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="Submit" name="preview" value=" Preview " onClick="previewForm(this.form);">
</FORM>

EOF



exit;
}

sub save_template {

&checkpword;

$ntemplate = $template;
$ntemplate =~ s/\.dat$//;
undef $/;
open (HEAD, "$path/$ntemplate.html");
$file = <HEAD>;
close (HEAD);

$hide ="<!--START EZ_WEB TEMP-->\n";
$hide .= "<!--\%\%template\%\%$template\%\%-->\n";
	
while ( ($key, $value) = each( %INPUT) ) {
	unless (($key eq "password") || ($key eq "account") || ($key =~ /_[0-9]*\.dat/) || ($key eq "cata") || ($key eq "all_files") || ($key eq "html") || ($key eq "other") || ($key eq "image") || ($key eq "active_dir") || ($key eq "_file_name_")) {
		$hide .= "<!--\%\%$key\%\%$value\%\%-->\n";
	}
	$file =~ s/\%$key\%/$value/gi;

	}
$hide .= "<!--END EZ_WEB TEMP-->\n";
if ($INPUT{'save'}) {
	$content = $file;
	&add_header;
	$file_name = $INPUT{'_file_name_'};
	@filsplit = split(/\./,$file_name);
	$filsplit[0] =~ s/![a-z|A-Z|0-9]//g;
	unless (($filsplit[1] eq "html") || ($filsplit[1] eq "htm") || ($filsplit[1] eq "shtml")) {
		&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
<B>$filsplit[0].$filsplit[1]</B> is not a valid filename, please go back and try again
</TD></TR></TABLE>
EOF
		&Footer;
		exit;			
	}	
	$nfilen = "$filsplit[0].$filsplit[1]";

	open (HEAD, ">$free_path/$dir_acc/$nfilen");
	print HEAD "$hide";
	print HEAD "$content";
	close (HEAD);
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font face=$font_face size=$font_size color=$text_table>
Your file was successfully created/edited, please continue on.
<form action="manager.cgi" method="POST">
$hidden_variables
<input type="Submit" name="log" value="  Back to the File Manager  ">
</form>
</TD></TR></TABLE>
EOF
&Footer;
exit;
}
else {
	#### PRINT PREVIEW ####
	print "$file";
}
exit;
}




########## ADD HEADER AND FOOTER ##########
sub add_header {

undef $/;
$*=1;
	
open (DAT,"<$path/$file_header");
$ahead = <DAT>;
close (DAT);

open (DAT,"<$path/$file_footer");
$afoot = <DAT>;
close (DAT);

$ahead =~ s/(.)*?\n//;
$afoot =~ s/(.)*?\n//;

$/ =1;

$header = "\n$start_head";
$header .="$ahead\n";
$header .= "$end_head";

$footer = "\n$start_foot";
$footer .="$afoot\n";
$footer .= "$end_foot";

unless ($frameset && ($content =~ /<(.|\n)*?FRAMESET(.|\n)*?>/i)) {

	$content =~ s/<(.|\n)*?BODY(.|\n)*?>/$&$header/i;
	unless ($content =~ /$start_head/) {
		$content = $header . $content;
	}
	$content =~ s/<\/BODY(.|\n)*?>/$footer$&/i;
	unless ($content =~ /$start_foot/) {
		$content = $content . $footer
	}
}
return($content);
}

########## REMOVE HEADER FOOTER #########
sub remove_header {

$*=1;
$content =~ s/$start_head(.|\n)*?$end_head\n*//i;
$content =~ s/$start_foot(.|\n)*?$end_foot\n*//i;

return($content);
}

########## HEADER ##########
sub Header {
	unless ($manager_header) { $manager_header="header.txt"; }
	return if $header_printed;
	$header_printed=1;
	print "<HTML><HEAD><TITLE>$free_name</TITLE></HEAD>\n";
	print "<body>\n";
	undef $/;
	open (HEAD, "$path/$manager_header");
	$head = <HEAD>;
	close (HEAD);
	unless ($manager_header eq "header.txt") {
		$head =~ s/.*\n//;
	}
	print "$head";
	$/="\n";
	print "<br><BR><center>";
}

########## FOOTER ##########
sub Footer {

	unless ($manager_footer) { $manager_footer="footer.txt"; }
	print HTML"</center>";
	undef $/;
	open (HEAD, "$path/$manager_footer");
	$foot = <HEAD>;
	close (HEAD);
	unless ($manager_footer eq "footer.txt") {
		$foot =~ s/.*\n//;
	}
	print "$foot";
	$/="\n";
	if ($credit) {
		print "<center><font size=-1><hr width=525 noshade size=1><a href=\"http://solutionscripts.com\">Community Builder</a> v$version<br>Created by <a href=\"http://solutionscripts.com\">Solution Scripts</a><br><br>";
	}
	print "</BODY></HTML>\n";
}


########## CHECKPASSWORD ##########
sub checkpword {

$cata = $INPUT{'cata'};
$account = $INPUT{'account'};
$password = $INPUT{'password'};

unless ($cata) { $cata="accounts"; }

@accarray = split(//,$account);

$accfile = "$path/members/$cata/$accarray[0]/$account.dat";

unless (-e "$accfile") {
	&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
The account name you entered could not be found in our database
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

undef $/;
open (ACC, "$accfile") || &error("Error reading $accfile");
$acc_data = <ACC>;
close (ACC);
$/ = "\n";

@acco = split(/\n/,$acc_data);

if ($acco[18]) {
	&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, this account is currently on hold for the following reason:
<BR><BR>
$acco[18]
<BR><BR>
If you have a question about the status of your account, please contact<BR>
us at <A href="mailto:$your_email">$your_email</A>.<BR><BR>
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

unless ($INPUT{'password'} eq $acco[2]) {
	&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You have entered the wrong password for this account
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

@tfile = split(/\,/,$acco[36]);
foreach (@tfile) {
	if ($_ eq "\.shtml") {
		$good_types{$_} = "html";
	}
	else {		
		$good_types{$_} = "file";
	}
}
	
$dir_acc = "$account";

unless ($cata eq "accounts") {

	open (ACC, "$path/categories.txt") || &error("Error reading category file");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		if ($key eq $cata) {
			$dir_acc = "$abbo[0]/$account";
			$file_header = $abbo[3];
			$file_footer = $abbo[4];
			$manager_header = $abbo[5];
			$manager_footer = $abbo[6];
			last;
		}
	}
}

unless ($file_header) { $file_header="header_html.txt"; }
unless ($file_footer) { $file_footer="footer_html.txt"; }
unless ($manager_header) { $manager_header="header.txt"; }
unless ($manager_footer) { $manager_footer="footer.txt"; }
if (($manager_header eq "Default") || ($manager_header eq "default")) { $manager_header="header.txt"; }
if (($manager_footer eq "Default") || ($manager_footer eq "default")) { $manager_footer="footer.txt"; }

	&Header;

if ($INPUT{'active_dir'} =~ /\./) { &error("Sorry...."); }
if ($INPUT{'current_dir'} =~ /\./) { &error("Sorry...."); }

$base_dir = $dir_acc;

if ($INPUT{'log'} eq 'Jump to selected dir.') {
	if ($INPUT{'current_dir'} eq 'Main Dir') { 
		$active_dir = '';
		$text_dir = 'Base Directory';

	}
	elsif ($INPUT{'current_dir'}) {
		$active_dir = $INPUT{'current_dir'};
		$dir_acc .= "/$INPUT{'current_dir'}";
		$text_dir = $INPUT{'current_dir'};
	}
}
elsif ($INPUT{'log'} eq 'Go To Dir.') {
	if ($INPUT{'active_dir'}) {
		$active_dir = "$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
		$dir_acc .=  "/$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
		$text_dir = "$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
	}
	else {
		$active_dir = $INPUT{'current_dirs'};
		$dir_acc .=  "/$INPUT{'current_dirs'}";
		$text_dir = $INPUT{'current_dirs'};	
	}
}	
else {
	if ($INPUT{'active_dir'}) {
		$active_dir = $INPUT{'active_dir'};
		$dir_acc .=  "/$INPUT{'active_dir'}";
		$text_dir = $INPUT{'active_dir'};
	}
	else {
		$active_dir = '';
		$text_dir = 'Base Directory';
	}
}

$hidden_variables = <<EOF;
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$cata">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="active_dir" VALUE="$active_dir">
<INPUT TYPE="HIDDEN" NAME="all_files" VALUE="$INPUT{'all_files'}">
<INPUT TYPE="HIDDEN" NAME="other" VALUE="$INPUT{'html'}">
<INPUT TYPE="HIDDEN" NAME="image" VALUE="$INPUT{'image'}">
<INPUT TYPE="HIDDEN" NAME="other" VALUE="$INPUT{'other'}">
EOF

return ($dir_acc);
}

sub error {
print "$_[0] $!";
}
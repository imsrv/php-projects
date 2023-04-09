#!/usr/bin/perl
###
#######################################################
#		Community Builder Latest
#     
#    	Created by  Scripts
# 		
#	
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

$|=1;

require "variables.pl";

$cookies =1;
@char_set = ('a'..'z','0'..'9');

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

$header_printed =0;

%bad_files = ("guestbook.html","bad","gbook.dat","bad");
%bad_dirs = ("wwwboard","bad");
%good_types = (".htm","html",".html","html",".gif","image",".jpg","image",".jpeg","image",".txt","text");

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

$version = "3.13";

open (DAT,"<$path/filetypes.txt");
$file_types = <DAT>;
close (DAT);
@tfile = split(/\r/,$file_types);
foreach (@tfile) {
	if ($_ eq "\.shtml") {
		$good_types{$_} = "html";
	}
	else {		
		$good_types{$_} = "file";
	}
}

$cgi_lib'bufsize  =  531072;    # default buffer size when reading multipart
$cgi_lib'maxbound =   100;    # maximum boundary length to be encounterd
$cgi_lib'headerout =    0;   
$cgi_lib'writefiles =      0;  
$type = $ENV{'CONTENT_TYPE'};
$len  = $ENV{'CONTENT_LENGTH'};
$meth = $ENV{'REQUEST_METHOD'};

binmode(STDIN);   # we need these for DOS-based systems
binmode(STDOUT);  # and they shouldn't hurt anything else 
binmode(STDERR);

if ($ENV{'CONTENT_TYPE'} =~ m#^multipart/form-data#) {

	local ($buf, $boundary, $head, @heads, $cd, $ct, $fname, $ctype, $blen);
    local ($bpos, $lpos, $left, $amt, $fn, $ser);
    local ($bufsize, $maxbound, $writefiles) = ($cgi_lib'bufsize, $cgi_lib'maxbound, $cgi_lib'writefiles);
    $buf = ''; 

    ($boundary) = $type =~ /boundary="([^"]+)"/; #";   # find boundary

    ($boundary) = $type =~ /boundary=(\S+)/ unless $boundary;
    &error ("Boundary not provided: probably a bug in your server") 
      unless $boundary;
    $boundary =  "--" . $boundary;
    $blen = length ($boundary);

    $left = $len;
	PART: # find each part of the multi-part while reading data
    while (1) {
      die $@ if $errflag;

      $amt = ($left > $bufsize+$maxbound-length($buf) 
	      ?  $bufsize+$maxbound-length($buf): $left);
      $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
      die "Short Read: wanted $amt, got $got\n" if $errflag;
      $left -= $amt;

      $in{$name} .= "\0" if defined $in{$name}; 
      $in{$name} .= $fn if $fn;

      $name=~/([-\w]+)/;  # This allows $insfn{$name} to be untainted
      if (defined $1) {
        $insfn{$1} .= "\0" if defined $insfn{$1}; 
        $insfn{$1} .= $fn if $fn;
      }
 
     BODY: 
      while (($bpos = index($buf, $boundary)) == -1) {
        if ($left == 0 && $buf eq '') {
	  foreach $value (values %insfn) {
            unlink(split("\0",$value));
	  }
	  &error("cgi-lib.pl: reached end of input while seeking boundary " .
		  "of multipart. Format of CGI input is wrong.\n");
        }
        die $@ if $errflag;
        if ($name) {  # if no $name, then it's the prologue -- discard
          if ($fn) { print  substr($buf, 0, $bufsize); }
          else     { $in{$name} .= substr($buf, 0, $bufsize); }
        }
        $buf = substr($buf, $bufsize);
        $amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
        $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
	die "Short Read: wanted $amt, got $got\n" if $errflag;
        $left -= $amt;
      }
      if (defined $name) {  # if no $name, then it's the prologue -- discard
        if ($fn) { print  substr($buf, 0, $bpos-2); }
        else     { $in {$name} .= substr($buf, 0, $bpos-2); } # kill last \r\n
      }
      close (FILE);
      last PART if substr($buf, $bpos + $blen, 2) eq "--";
      substr($buf, 0, $bpos+$blen+2) = '';
      $amt = ($left > $bufsize+$maxbound-length($buf) 
	      ? $bufsize+$maxbound-length($buf) : $left);
      $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
      die "Short Read: wanted $amt, got $got\n" if $errflag;
      $left -= $amt;


      undef $head;  undef $fn;
     HEAD:
      while (($lpos = index($buf, "\r\n\r\n")) == -1) { 
        if ($left == 0  && $buf eq '') {
	  foreach $value (values %insfn) {
            unlink(split("\0",$value));
	  }
	  &error("cgi-lib: reached end of input while seeking end of " .
		  "headers. Format of CGI input is wrong.\n$buf");
        }
        die $@ if $errflag;
        $head .= substr($buf, 0, $bufsize);
        $buf = substr($buf, $bufsize);
        $amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
        $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
        die "Short Read: wanted $amt, got $got\n" if $errflag;
        $left -= $amt;
      }
      $head .= substr($buf, 0, $lpos+2);
      push (@in, $head);
      @heads = split("\r\n", $head);
      ($cd) = grep (/^\s*Content-Disposition:/i, @heads);
      ($ct) = grep (/^\s*Content-Type:/i, @heads);

      ($name) = $cd =~ /\bname="([^"]+)"/i; #"; 
      ($name) = $cd =~ /\bname=([^\s:;]+)/i unless defined $name;  

      ($fname) = $cd =~ /\bfilename="([^"]*)"/i; #"; # filename can be null-str
      ($fname) = $cd =~ /\bfilename=([^\s:;]+)/i unless defined $fname;
      $incfn{$name} .= (defined $in{$name} ? "\0" : "") . 
        (defined $fname ? $fname : "");

      ($ctype) = $ct =~ /^\s*Content-type:\s*"([^"]+)"/i;  #";
      ($ctype) = $ct =~ /^\s*Content-Type:\s*([^\s:;]+)/i unless defined $ctype;
      $inct{$name} .= (defined $in{$name} ? "\0" : "") . $ctype;

 
      substr($buf, 0, $lpos+4) = '';
      undef $fname;
      undef $ctype;
    }


#############################################################

}
else {
$in{'upload'} = '';
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});



@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
}
}

@months = ('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');

$time = time;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$cgiurl = $ENV{'SCRIPT_NAME'};

$cookies=1;
if ($cookies && $INPUT{'cookies'}) {
	print "Set-Cookie: $free_name=$INPUT{'account'}|$INPUT{'cata'}|$INPUT{'all_files'}|$INPUT{'html'}|$INPUT{'image'}|$INPUT{'other'}\; expires=Monday, 01-Jan-2001 12:00:00 GMT\;\n";
}

print "Content-type: text/html\n\n ";

if ($INPUT{'log'}) { &log; }

elsif ($INPUT{'ftp'}) { &ftp; }
elsif ($INPUT{'ftp_import'}) { &ftp_import; }
elsif ($INPUT{'features_edit'}) { &features_edit; }
elsif ($INPUT{'features_wwwboard'}) { &features_wwwboard; }
elsif ($INPUT{'features_change'}) { &features_change; }
elsif ($INPUT{'features_gbook'}) { &features_gbook; }

elsif ($INPUT{'action'} eq "delete dir") { &del_dir; }
elsif ($INPUT{'action'} eq "delete file") { &del_file; }
elsif ($INPUT{'action'} eq "rename file") { &rename; }
elsif ($INPUT{'action'} eq "edit file") { &edit; }

elsif ($INPUT{'edit'}) { &edit; }
elsif ($INPUT{'rename'}) { &rename; }



elsif ($INPUT{'gbook_admin'}) { &gbook_admin; }
elsif ($INPUT{'gbook_delete'}) { &gbook_delete; }

elsif ($INPUT{'move_acc_final'}) { &move_acc_final; }

elsif ($INPUT{'sendpword'}) { &sendpword; }
elsif ($INPUT{'sendpword2'}) { &sendpword2; }

elsif ($INPUT{'rename_final'}) { &rename_final; }
elsif ($INPUT{'edit_final'}) { &edit_final; }
elsif ($INPUT{'new'}) { &new; }
elsif ($INPUT{'new_folder_sub'}) { &new_folder_sub; }
elsif ($in{'upload'}) { &upload; }
else { &main; }
exit;

sub sort_hash {
	my $x = shift;
	my %array = %$x;
	sort { $array{$b} cmp $array{$a}; } keys %array;
}


sub main {
&Header;

if ($cookies && $ENV{'HTTP_COOKIE'}) {
	$the_cook =$ENV{'HTTP_COOKIE'};
	$the_cook =~ s/.*?=//;
	@cook = split(/\|/,$the_cook);
	$rem_cook = "checked";
}

print <<EOF;
<FONT face=$font_face size=$font_size>
<B>Log into your account at $free_name</B>
<BR>
<FORM METHOD=POST ACTION="$cgiurl">
<table cellspacing =0 cellpadding =8 border=0 bgcolor=$table_bg>
<TR><TD align=left>
<font face=$font_face size=$font_size color=$text_table>Account name:
</TD><TD align=left>
<INPUT TYPE="TEXT" NAME="account" VALUE="$cook[0]">
</TD>
</TR>

<TR><TD align=left>
<font face=$font_face size=$font_size color=$text_table>
Password:
</TD><TD align=left>
<INPUT TYPE="PASSWORD" NAME="password" VALUE="">
</TD>
</TR>
EOF
if ($category) {
	$select ='';
	open (ACC, "$path/categories.txt") || &error("Error reading category file");
	@acat = <ACC>;
	close (ACC);
	@acat = sort {$a cmp $b} @acat;
	foreach $cata_line(@acat) {
		chomp($cata_line);
		@catt = split(/\|/,$cata_line);
		($key,$catt[0]) = split(/\%\%/,$catt[0]);

		if ($cook[1] eq $key) {	$select .= "<OPTION VALUE=\"$key\" SELECTED>$catt[1]\n";	}
		else { $select .= "<OPTION VALUE=\"$key\">$catt[1]\n"; }
	}

print <<EOF;
<TR><TD ALIGN=left>
<font face=$font_face size=$font_size color=$text_table>
Select your $cata_name:
</TD><TD>
<select name="cata">
<OPTION VALUE="accounts">No $cata_name
$select</select>
</TD></TR>
EOF
}

print <<EOF;
<TR><TD ALIGN=left>
<font face=$font_face size=$font_size color=$text_table>
Display files:
</TD><TD>
<font face=$font_face size=$font_size color=$text_table>
<input type="Checkbox" name="all_files" value="checked" $cook[2]>&nbsp;&nbsp;All Files&nbsp;&nbsp;
<input type="Checkbox" name="html" value="checked" $cook[3]>&nbsp;&nbsp;Html Files<BR>
<input type="Checkbox" name="image" value="checked" $cook[4]>&nbsp;&nbsp;Image Files&nbsp;&nbsp;
<input type="Checkbox" name="other" value="checked" $cook[5]>&nbsp;&nbsp;Other Files
</TD></TR>
EOF

if ($cookies) {
print <<EOF;
<TR><TD Align=left>
<font face=$font_face size=$font_size color=$text_table>
Remember my information:
</TD><TD>
<font face=$font_face size=$font_size color=$text_table>
<input type="Checkbox" name="cookies" value="checked"  $rem_cook>&nbsp;Yes Remember
</TD></TR>
EOF
}

print <<EOF;

<TR><TD align=center colspan=2><INPUT TYPE="SUBMIT" NAME="log" VALUE="Log into your account">
&nbsp;&nbsp;
<INPUT TYPE="SUBMIT" NAME="sendpword" VALUE="Get Lost Password"> 
</TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}

########## USER LOG IN ##########
sub log {

$message = $_[0];

$account = $INPUT{'account'};
$cata = $INPUT{'cata'};
$password = $INPUT{'password'};

$dir_acc = &checkpword;

unless ($message) { $message = "Welcome $acco[1]"; }

print <<EOF;
<script language="JavaScript1.1">
<!--
function deletedir() {
	if (confirm("Are you sure you want to delete this directory??")) {
		document.manager.elements[0].value = "delete dir";
		document.manager.submit();
	}
}
function deletefile() {
	if (confirm("Are you sure you want to delete these files??")) {
		document.manager.elements[0].value = "delete file";
		document.manager.submit();
	}
}
//-->
</script>
<FORM METHOD=POST ACTION="$cgiurl" name="manager">
<INPUT TYPE="HIDDEN" NAME="action" VALUE="">
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$cata">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="active_dir" VALUE="$active_dir">

<font face=$font_face><B>$message</B></FONT><BR><BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD bgcolor=$table_head_bg align=center colspan=6>
<font color=$text_table_head face=$font_face size=$font_size>
Account Name: <font color=$text_highlight>$account</font><BR>
</FONT>
EOF

if ($dir_total) {
print <<EOF;
<font color=$text_table_head face=$font_face size=+1>
Current Directory: <font color=$text_highlight>$text_dir</FONT> 
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size>
<CENTER>Select a directory:<BR>
<select name="current_dir"><option value="Main Dir">Main Directory
<BR>
EOF
}

$total_k = 0;
$num_dirs = 0;

&dir_lists("$free_path/$base_dir");

if ($dir_total) {
print <<EOF;
</select>
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="log" value="Jump to selected dir.">
</TD></TR>
<TR><TD align=center colspan=6> 
<font face=$font_face size=$font_size>Create a new folder in the current directory
<BR>
<input type="Hidden" name="num_dir" value="$num_dir">
<input type="Text" name="new_folder" size="20" maxlength="20">
&nbsp;&nbsp;&nbsp;<input type="Submit" name="new_folder_sub" value="Create New">
</TD></TR>
<TR><TD bgcolor=$table_head_bg align=center colspan=6> 
<font color=$text_table_head face=$font_face size=$font_size>Folders residing in the directory:
<font color=$text_highlight>$text_dir</font></TD></TR>

<TR bgcolor=$table_head_bg>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Select</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size># Files</FONT></TD>
<TD align=center colspan=2><font color=$text_table_head face=$font_face size=$font_size>Size</FONT></TD>
<TD align=center colspan=2><font color=$text_table_head face=$font_face size=$font_size>Name</FONT></TD>
</TR>
EOF

	opendir(DIR,"$free_path/$dir_acc") || &error("can not open $free_path/$dir_acc");
	@dirs = grep {!(/^\./) && -d "$free_path/$dir_acc/$_" } readdir(DIR);
	close DIR;
	@dirs = sort(@dirs);

	unless(@dirs) {
print <<EOF;

<TR>
<TD colspan=6 align=center><font face=$font_face size=$font_size>There are currently no folders in this directory</FONT></TD>
</TR>

EOF

	}

	foreach $ddir(@dirs) {

		$num=0;
		opendir (DIR, "$free_path/$dir_acc/$ddir") || &error("can not open $free_path/$dir_acc/$ddir");
		@files = grep {!(/^\./) && -f "$free_path/$dir_acc/$ddir/$_"}  readdir(DIR);
		close (DIR); 

		$num = push(@files);
		$total_ks = 0;
		foreach $file(@files) {

			@stats = stat("$free_path/$dir_acc/$ddir/$file");
			$size = $stats[7];
			$size = $size /1000;
			$total_ks = $size + $total_ks;

		}
		unless ($bad_dirs{$ddir}) {
print <<EOF;

<TR>
<TD align=center><font face=$font_face size=$font_size><INPUT TYPE="Radio" NAME="current_dirs" VALUE="$ddir"></FONT></TD>
<TD align=center><font face=$font_face size=$font_size>$num</FONT></TD>
<TD colspan=2 align=center><font face=$font_face size=$font_size>$total_ks K</FONT></TD>
<TD colspan=2><font face=$font_face size=$font_size><a href = "$url/$dir_acc/$ddir">$ddir</A></FONT></TD>
</TR>

EOF
		}

	}

print <<EOF;

<TR>
<TD colspan=6 align=center><input type="Submit" name="log" value="Go To Dir.">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="del_dir" value="Delete Folder" onClick="deletedir(this.form);">
</TD></TR>
EOF
}
else {
	print "</TD></TR>";
}

$which_files = '';
unless ($INPUT{'html'} || $INPUT{'all_files'} || $INPUT{'image'} || $INPUT{'other'}) { $INPUT{'all_files'} = "checked"; }

if ($INPUT{'all_files'}) { $which_files = "All"; }
else {
	if ($INPUT{'html'}) { $which_files = "Html"; }
	if ($INPUT{'image'}) { $which_files .= " Images"; }	
	if ($INPUT{'other'}) { $which_files .= " Other"; }
}

opendir (DIR, "$free_path/$dir_acc") || &error("can not open $free_path/$dir_acc");
@files = grep {!(/^\./) && -f "$free_path/$dir_acc/$_"}  readdir(DIR);
close (DIR); 

if ($INPUT{'all_files'}) { $which_files = "All"; }

print <<EOF;
<TR><TD bgcolor=$table_head_bg align=center colspan=6> 
<font color=$text_table_head face=$font_face size=$font_size>$which_files files residing in the directory:
<font color=$text_highlight>$text_dir</font></TD></TR>
<TR bgcolor=$table_head_bg>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Select</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Type</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Name</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Size</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Last Modified</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Last Accessed</FONT></TD>
</TR>
EOF

@filess = sort (@files);

unless(@filess) {
print <<EOF;
<TR><TD colspan=6 align=center><font face=$font_face size=$font_size>There are currently no files in this directory</FONT></TD></TR>
EOF
}

foreach $file(@filess) {
	next if $bad_files{$file};
	@stats = stat("$free_path/$dir_acc/$file");
	$mtime = $stats[9];
	$atime = $stats[8];
	($msec,$mmin,$mhour,$mmday,$mmon,$myear,$mwday,$myday,$misdst) = localtime($mtime);
	($asec,$amin,$ahour,$amday,$amon,$ayear,$awday,$ayday,$aisdst) = localtime($atime);

	$mmonth = $months[$mmon];
	$amonth = $months[$amon];
	$myear += 1900;
	$ayear += 1900;

	$size = $stats[7];
	$size = $size /1000;
	if (($file =~ /\.gif$/i) || ($file =~ /\.jpg$/i) || ($file =~ /\.jpeg$/i)) {
		unless ($INPUT{'image'} || $INPUT{'all_files'}) { next; }
		$image = "image";
	} 
	elsif(($file =~ /\.html$/i) || ($file =~ /\.htm$/i) || ($file =~ /\.shtml$/i)) {
		unless ($INPUT{'html'} || $INPUT{'all_files'}) { next; }
		$image="text";
	}
	elsif(($file =~ /\.zip$/i) || ($file =~ /\.tar$/i)) {
		unless ($INPUT{'other'} || $INPUT{'all_files'}) { next; }
		$image="compressed";
	}
	elsif(($file =~ /\.wav$/i) || ($file =~ /\.avi$/i)) {
		unless ($INPUT{'other'} || $INPUT{'all_files'}) { next; }		
		$image="sound";
	}
	else {
		unless ($INPUT{'other'} || $INPUT{'all_files'}) { next; }
		$image = "unknown";
	}

print <<EOF;
<TR><TD align=center><font face=$font_face size=$font_size><INPUT TYPE="CHECKBOX" NAME="sfile" VALUE="$file"></FONT></TD>
<TD align=center><font face=$font_face size=$font_size></FONT><IMG SRC="$url_to_icons/$image.gif"></TD>
<TD><font face=$font_face size=$font_size><a href = "$url/$dir_acc/$file">$file</A></FONT></TD>
<TD><font face=$font_face size=$font_size>$size K</FONT></TD>
<TD><font face=$font_face size=$font_size>$mmonth $mmday, $myear $mhour:$mmin</FONT></TD>
<TD><font face=$font_face size=$font_size>$amonth $amday, $ayear $ahour:$amin</FONT></TD></TR>
EOF
}

$free_space = $total_size + $acco[6] - $total_k;
$acco[3] = $total_k;
$acco[5] = $time;
$fin_size = $total_size + $acco[6];

$acc_data = join("\n",@acco);
open (ACC, ">$accfile") || &error("Error printing $accfile");
print ACC $acc_data;
close (ACC);

print <<EOF;
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size>
<INPUT TYPE="submit" NAME="edit" VALUE="Edit File">
&nbsp;&nbsp;&nbsp;
<INPUT TYPE="button" NAME="del" VALUE="Delete Files" onClick="deletefile(this.form);">&nbsp;&nbsp;&nbsp;
<INPUT TYPE="submit" NAME="rename" VALUE="Rename Files">
&nbsp;&nbsp;&nbsp;
<INPUT TYPE="SUBMIT" NAME="new" VALUE="Create New File">
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size>
Show Files:&nbsp;&nbsp;
All Files -- <input type="Checkbox" name="all_files" value="checked" $INPUT{'all_files'}>
&nbsp;&nbsp;&nbsp;
Html -- <input type="Checkbox" name="html" value="checked" $INPUT{'html'}>
&nbsp;&nbsp;&nbsp;
Images -- <input type="Checkbox" name="image" value="checked" $INPUT{'image'}>
&nbsp;&nbsp;&nbsp;
Other -- <input type="Checkbox" name="other" value="checked" $INPUT{'other'}>
<BR><input type="Submit" name="log" value="  Refresh Current Directory  ">
</TD></TR>
EOF
if ($ftp_upload) {
	if ($ftp_per) {
		if ($acco[37]) {
print <<EOF;
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size  color=$text_table>Import files uploaded via ftp to current directory <input type="Submit" name="ftp" value=" Select files to import ">
</TD></TR>
EOF
		}
	}
	else {
print <<EOF;
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size  color=$text_table>Import files uploaded via ftp to current directory <input type="Submit" name="ftp" value=" Select files to import ">
</TD></TR>
EOF
	}	
}

print <<EOF;
<TR><TD align=center colspan=6><BR>
<font face=$font_face size=$font_size  color=$text_table><B>File uploads -- Upload files from your hard drive to current directory</B>
</FORM></TD></TR>
<FORM ENCTYPE="multipart/form-data" METHOD=POST ACTION="$cgiurl">
$hidden_variables
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size><INPUT TYPE="FILE" NAME="file1" SIZE="30">
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size><INPUT TYPE="FILE" NAME="file2" SIZE=30>
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size><INPUT TYPE="FILE" NAME="file3" SIZE=30>
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size><INPUT TYPE="FILE" NAME="file4" SIZE=30>
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size><INPUT TYPE="FILE" NAME="file5" SIZE=30>
</TD></TR>
<TR><TD align=center colspan=6>
<font face=$font_face size=$font_size  color=$text_table><INPUT TYPE="SUBMIT" NAME="upload" VALUE="Upload these files">
</TD></TR><TR><TD align=center colspan=6>
<BR><font face=$font_face size=$font_size  color=$text_table><i>$total_k </I>K of <i>$fin_size</I>K used, <i>$free_space</I>K free
<BR><br></TD></TR><TR><TD align=center colspan=6></FORM><BR>
<font face=$font_face size=$font_size color=$text_table><B>Select a feature:</B>
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<select name="features"><option value="change">Change user info
EOF
if (($wwwboard_stat && !($wwwboard_default)) || ($wwwboard_stat && $wwwboard_default && $acco[11])) {
	print "<option value=\"wwwboard\">Web Board\n";
}
if (($gbook_stat && !($gbook_default)) || ($gbook_stat && $gbook_default && $acco[33])) {
	print "<option value=\"gbook\">Guestbook\n";
}
if ($category) {
	print "<option value=\"move_acc\">Move Account\n";
}
print <<EOF;
</select>
&nbsp;&nbsp;&nbsp;<input type="Submit" name="features_edit">
</FORM>
</TD></TR>
</TABLE>
</FORM>
<BR>
EOF
&Footer;
exit;
}

########## FEATURES EDIT ##########
sub features_edit {

&checkpword;

if ($INPUT{'features'} =~ /change/i) {
print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<font face=$font_face size=$font_size><B>Edit your account information</B><BR><BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Account name:
</TD><TD>
<font color=$text_table face=$font_face size=$font_size>
$account
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Password:
</TD><TD>
<input type="Text" name="new_pass" value="$acco[2]" size="20">
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Your Name:
</TD><TD>
<input type="Text" name="name" value="$acco[1]" size="20">
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Email Address:
</TD><TD>
<input type="Text" name="email" value="$acco[0]" size="20">
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Name of your web site:
</TD><TD>
<input type="Text" name="site_name" value="$acco[8]" size="30">
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Web Site description:
</TD><TD>
<input type="Text" name="site_des" value="$acco[9]" size="30">
</TD></TR>
<TR><TD colspan=2 align=center>
<input type="Submit" name="features_change" value=" Update account info ">
</TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;

}
elsif ($INPUT{'features'} =~ /wwwboard/i) {
	unless (($wwwboard_stat && !($wwwboard_default)) || ($wwwboard_stat && $wwwboard_default && $acco[11])) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
This account is unauthorized to use a Web Board at this time.
</TD></TR></TABLE><BR>
EOF
		&Footer;
		exit;	
	}
	
	open (HEAD, "$free_path/$base_dir/wwwboard/board.dat");
	@datas = <HEAD>;
	close (HEAD);
	
	$datas[10] =~ s/\\n/\n/g;
	$datas[11] =~ s/\\n/\n/g;

	$num_posts = 0;

	opendir (DIR, "$free_path/$dir_acc/wwwboard");
	@files = grep {!(/^\./)}  readdir(DIR);
	close (DIR); 

	$num_posts = push(@files);

	if ($num_posts > 3) {
		$num_posts = $num_posts - 3;
	}
	$out_of = "";
	if ($wwwboard_num) {
		$out_of = "out of $wwwboard_num possible";
	}

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<font face=$font_face size=$font_size><B>Web Board Setup</B><BR><BR>
<blockquote>
With your account at $free_name you have the option of using a Web Board. This web board uses a modified
version of <a href="http://www.worldwidemart.com/scripts/">wwwboard 2.0</a>. Visitors may come and read other posts, and post a response, or post
a new message of their own. You also have full admin access over the deletion of any post posted on your
web board. Your web board can be found at the url:
<a href="$url/$dir_acc/wwwboard/index.html">$url/$dir_acc/wwwboard/index.html</a>,
once this form is filled out for the first time. Send all your visitors to the url above,
where than can view your message board and post new messages.
Below are some of the options you have for configuring your web board, the bottom of
this page contains the section for deleting messages from your web board.<BR><BR>

<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD bgcolor=$table_head_bg align=center colspan=2>
<font color=$text_table_head face=$font_face size=$font_size>
Your current Web Board stats are as follows:
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Number of posts $out_of
</TD><TD>
<font color=$text_table face=$font_face size=$font_size>
&nbsp;&nbsp;$num_posts</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Name of your Web Board:
</TD><TD>
<font color=$text_table face=$font_face size=$font_size>
<input type="Text" name="wwwboard_name" value="$acco[12]" size="20"></TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Background Color:
</TD><TD>
<input type="Text" name="g_bgcolor" value="$datas[1]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Background Image:
</TD><TD>
<input type="Text" name="g_bgimage" value="$datas[2]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Text Color:
</TD><TD>
<input type="Text" name="g_text" value="$datas[3]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Link Color:
</TD><TD>
<input type="Text" name="g_link" value="$datas[4]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Visited Link Color:
</TD><TD>
<input type="Text" name="g_vlink"  value="$datas[5]">
</TD></TR>
<TR><TD colspan=2><font color=$text_table face=$font_face size=$font_size>
Header html:
</TD></TR>
<TR><TD colspan=2>
<textarea name="g_head" cols="35" rows="8" wrap="OFF">$datas[10]</textarea>
</TD></TR>
<TR><TD colspan=2><font color=$text_table face=$font_face size=$font_size>
Footer html:
</TD></TR>
<TR><TD colspan=2>
<textarea name="g_foot" cols="35" rows="8" wrap="OFF">$datas[11]</textarea>
</TD></TR>
<TR><TD colspan=2 align=center>
<input type="Submit" name="features_wwwboard" value="Change and/or initialize Web Board">
</TD></TR>
</TABLE></FORM>
<BR><BR>

<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD bgcolor=$table_head_bg align=center colspan=2>
  <form action="$url_to_cgi/features.cgi" method="POST">
  <input type="Hidden" name="wwwboard_admin" value="$account">
  $hidden_variables

<font color=$text_table_head face=$font_face size=$font_size>
Web Board administrative options:
</TD></TR>
<TR><TD>
<font color=$text_table face=$font_face size=$font_size>
Delete Messages:
</TD><TD>
<font color=$text_table face=$font_face size=$font_size>
Remove by:&nbsp;&nbsp;
<select name="command">
<option value="remove">Thread order
<option value="remove_by_num">Posted order
<option value="remove_by_date">Date
<option value="remove_by_author">Author
</select>
&nbsp;&nbsp;<input type="Submit" name="" value="remove">
</TABLE>
</FORM>
<blockquote>
Please note: changing the color setting above will automatically change the colors on
web board main page, the one that lists the messages. The messages themselves will stay their
current colors, with all new messages being posted in the new color scheme.
</BLOCKQUOTE>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features'} =~ /gbook/i) {

$/ ="\n";
open (HEAD, "$free_path/$base_dir/gbook.dat");
@datas = <HEAD>;
close (HEAD);

open (HEAD, "$free_path/$base_dir/guestbook.html");
@gbook = <HEAD>;
close (HEAD);

$datas[10] =~ s/\\n/\n/g;
$datas[11] =~ s/\\n/\n/g;

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<INPUT TYPE="HIDDEN" NAME="sfile" VALUE="$file">
<font face=$font_face size=$font_size><B>Your Guestbook</B><BR><BR>
<TABLE border=0 width=350><TR><TD>
<font face=$font_face size=$font_size>
Here you can administer your guestbook.
You can change change the colors in guestbook.html
and/or delete any of the entries.
<BR><BR>
Instructions at the bottom of this page will
tell you how to correctly set up and use your
guestbook.
</TD></TR></TABLE>
<BR><BR>

<input type="Submit" name="gbook_admin" value="  Select Entries to Delete  ">
<BR><BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Guestbook Title:
</TD><TD>
<input type="Text" name="g_title" value="$datas[0]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Background Color:
</TD><TD>
<input type="Text" name="g_bgcolor" value="$datas[1]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Background Image:
</TD><TD>
<input type="Text" name="g_bgimage" value="$datas[2]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Text Color:
</TD><TD>
<input type="Text" name="g_text" value="$datas[3]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Link Color:
</TD><TD>
<input type="Text" name="g_link" value="$datas[4]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Visited Link Color:
</TD><TD>
<input type="Text" name="g_vlink"  value="$datas[5]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Table Background Color #1:
</TD><TD>
<input type="Text" name="g_table1"  value="$datas[6]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Table Background Color #2:
</TD><TD>
<input type="Text" name="g_table2" value="$datas[7]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Table Text Color #1:
</TD><TD>
<input type="Text" name="g_text1" value="$datas[8]">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Table Text Color #2:
</TD><TD>
<input type="Text" name="g_text2" value="$datas[9]">
</TD></TR>
<TR><TD colspan=2><font color=$text_table face=$font_face size=$font_size>
Header html:
</TD></TR>
<TR><TD colspan=2>
<textarea name="g_head" cols="35" rows="8" wrap="OFF">$datas[10]</textarea>
</TD></TR>
<TR><TD colspan=2><font color=$text_table face=$font_face size=$font_size>
Footer html:
</TD></TR>
<TR><TD colspan=2>
<textarea name="g_foot" cols="35" rows="8" wrap="OFF">$datas[11]</textarea>
</TD></TR>
<TR><TD colspan=2 align=center>
<input type="Submit" name="features_gbook" value="  Update Guestbook Settings  ">
</TD></TR>
</TABLE>
</FORM>
<TABLE border=0 width=450><TR><TD>
<font face=$font_face size=$font_size>
Your guestbook is created the first time you fill out the above form and press the "Update Guestbook Settings" button.
For you or your guests to view your guestbook, use the url <A href="$url/$dir_acc/guestbook.html">$url/$dir_acc/guestbook.html</A>.
There are several ways you can have your visitors sign your guestbook. The first and easiest way is link your
guestbook, which contains the form for people to fill out to sign your guestbook. Secondly you can link to the url 
<BR><A href="$url_to_cgi/features.cgi?gbook=$account&cata=$cata">$url_to_cgi/features.cgi?gbook=$account&cata=$cata</A>
<BR>
Or finally you can include the html to the from directly into an html page. The html of the form is as follows:<BR><BR>

<font size=1>
&lt;FORM METHOD=POST ACTION="$url_to_cgi/features.cgi"&gt;<br>
&lt;INPUT TYPE="HIDDEN" NAME="cata" VALUE="$cata"&gt;<br>
&lt;INPUT TYPE="HIDDEN" NAME="account" VALUE="$account"&gt;<br>
&lt;table cellpadding=5 border=1 cellspacing=0 bgcolor=white&gt;<br>
&lt;TR&gt;&lt;TD&gt;&lt;font color=black face=arial size=-1&gt;<br>
Your Name:&lt;/TD&gt;&lt;TD&gt;<br>
&lt;input type="Text" name="g_name"&gt;&lt;/TD&gt;&lt;/TR&gt;<br>
&lt;TR&gt;&lt;TD&gt;&lt;font color=black face=arial size=-1&gt;<br>
Your Email Address:&lt;/TD&gt;&lt;TD&gt;<br>
&lt;input type="Text" name="g_email"&gt;&lt;/TD&gt;&lt;/TR&gt;<br>
&lt;TR&gt;&lt;TD&gt;&lt;font color=black face=arial size=-1&gt;<br>
Where are you from:&lt;/TD&gt;&lt;TD&gt;<br>
&lt;input type="Text" name="g_from"&gt;&lt;/TD&gt;&lt;/TR&gt;<br>
&lt;TR&gt;&lt;TD colspan=2&gt;&lt;font color=black face=arial size=-1&gt;<br>
Your Comments:&lt;/TD&gt;&lt;/TR&gt;<br>
&lt;TR&gt;&lt;TD colspan=2&gt;&lt;textarea name="g_comments" cols="35" rows="8" wrap="OFF"&gt;&lt;/textarea&gt;<br>
&lt;/TD&gt;&lt;/TR&gt;&lt;TR&gt;&lt;TD colspan=2 align=center&gt;<br>
&lt;input type="Submit" name="sign_gbook" value="  Sign the Guestbook  "&gt;<br>
&lt;/TD&gt;&lt;/TR&gt;&lt;/TABLE&gt;&lt;/FORM&gt;<br>
<BR></FONT>
You of course can change any of the format, but leave the names of the input tags 
in tack.
</TD></TR></TABLE>
EOF
&Footer;
exit;
}
elsif ($INPUT{'features'} =~ /move_acc/i) {

print <<EOF;
<FONT face=$font_face size=$font_size> 
Choose from the list below, the $cata_name where you<BR>
want to move your site too. Then select it from the list at the bottom.
<BR>
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<table cellspacing=0 cellpadding=5 border=1 bgcolor=$table_bg>
EOF
	$select_list = '';
	if ($cata_base) {
		$select_list .= "<OPTION VALUE=\"accounts\">No $cata_name \n";
	}
	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
			@abbo = split(/\|/,$cata_line);
			($key,$abbo[0]) = split(/\%\%/,$abbo[0]);

			$openings = $abbo[7] - $abbo[8];
			unless ($openings) {
				$openings = "$cata_name Full";
			}
			else {
				$select_list .= "<OPTION VALUE=\"$key\">$abbo[1]\n";
			}
print <<EOF;
<TR align=left><TD>
<font face=$font_face size=$font_size color=$text_table>
<B>$cata_name</B> - $abbo[1]<BR>
<B>Base Url</B> - $url/$abbo[0]<BR>
<B>Openings Left</B> - $openings<BR>
<B>Description</B> - 

<BLOCKQUOTE>
$abbo[2]
</BLOCKQUOTE>
</TD></TR>
EOF
	}
print <<EOF;
<TR align=center bgcolor=$table_head_bg><TD>
<font face=$font_face size=$font_size color=$text_table_head>
$cata_name to move to:&nbsp;&nbsp;
<select name="category">
$select_list
</select>&nbsp;&nbsp;&nbsp;<input type="Submit" name="move_acc_final" value=" Move Account ">
</TD></TR></TABLE>
<BR><BR>
After pressing the "Move Account" button above,<BR>
depending on the size of your current web site this could<BR>
take anywhere from a few seconds to a few minutes,<BR>
so please be patient.</FORM>
EOF
&Footer;
exit;
}
}

########### MOVE ACCOUNT ##########
sub move_acc_final {
&checkpword;

$new_cata = $INPUT{'category'};

open (ACC, "$path/categories.txt") || &error("Error reading category file");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	if ($key eq $cata) {
	   $cacc="$abbo[0]/$account";
	}
	if ($key eq $new_cata) {
	   $nacc = "$abbo[0]/$account";
	}
}

unless ($cacc) { $cacc="$account"; }
unless ($nacc) { $nacc="$account"; }

@accarray = split(//,$account);

$accfile = "$path/members/$cata/$accarray[0]/$account.dat";
$naccfile = "$path/members/$new_cata/$accarray[0]/$account.dat";


if (-e "$path/members/$new_cata/$accarray[0]/$account.dat") {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, your account can not be moved to this $cata_name
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

unlink("$accfile");

open (ACC, ">$naccfile") || &error("Error writing $naccfile");
print ACC $acc_data;
close (ACC);

$new_base_dir = "$free_path/$nacc";
$base_dir = "$free_path/$cacc";

mkdir("$free_path/$nacc", 0777) || &error("Can't make $free_path/$nacc");
&dir_del("$base_dir","$free_path/$nacc");
rmdir("$base_dir") || &error("Failed to remove $base_dir");

$cata = $new_cata;
$INPUT{'cata'} = $new_cata;

&log("Account moved to $cata $cata_name");
exit;
}


########## MOVE DIR ##########
sub dir_del {

my $direc = $_[0];
my $new_direc = $_[1];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 

foreach $file(@files) {

	open(LIST,"$direc/$file") || &error("Failed to read $direc/$file");
	@ffile = <LIST>;
	close(LIST);

	open(LIST,">$new_direc/$file") || &error("Failed to create $direc/$file");
	print LIST @ffile;
	close(LIST);

	unlink("$direc/$file") || &error("Failed to remove $direc/$file");
}


for $new_dir(0..$#dirs) {
	mkdir("$new_direc/$dirs[$new_dir]", 0777) || &error("Can't make $new_direc/$dirs[$new_dir]");
	&dir_del("$direc/$dirs[$new_dir]","$new_direc/$dirs[$new_dir]");	
	rmdir("$direc/$dirs[$new_dir]") || &error("Failed to remove $direc/$dirs[$new_dir]");
}

}


########## GUEST BOOK ADMIN ##########
sub gbook_admin {
&checkpword;

open (HEAD, "$free_path/$base_dir/gbook.dat");
@datas = <HEAD>;
close (HEAD);

foreach $line(@datas) {
	chomp($line);
}

open (HEAD, "$free_path/$base_dir/guestbook.html");
@gbook = <HEAD>;
close (HEAD);

$datas[10] =~ s/\\n/\n/g;
$datas[11] =~ s/\\n/\n/g;

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<table cellpadding=5 border=0 cellspacing=1 width=500>
<TR><TD>
<font face=$font_face size=$font_size>
Below is a list of all your guestbook entries
If you wish to delete any of the entries,
check the boxes above all the entries you
want to delete, and press the submit button
at the bottom of the page.<BR><BR>
</TD></TR>
EOF

$start = 0;
foreach $line(@gbook) {
	if ($line =~ /<!-- INSERT -->/) { $start=1; next; }
	if ($line =~ /<!-- END TABLE -->/) { $start=0; next; }
	if ($start) {
		if ($line =~ /<!-- NUM/) {
			@id = split(/\s/,$line);
			print "<TR";
			if ($datas[6]) {
				print " bgcolor=$datas[6]";
			}
			print "><TD><font face=verdana size=1";
			if ($datas[8]) {
				print " color=$datas[8]";
			}
			print "><input type=\"Checkbox\" name=\"delete\" value=\"$id[2]\">";
			print " -- Check this box to delete entry</TD></TR>\n";
		}
	print "$line";	
	}

}
print <<EOF;
<TR><TD align=center>
<input type="Submit" name="gbook_delete" value="  Delete Selected Entries  ">
</TABLE>
</FORM>
EOF
&Footer;
exit;
}

########## DELETE GUEST BOOK ENTRIES ##########
sub gbook_delete {
&checkpword;


open (HEAD, "$free_path/$base_dir/gbook.dat");
@datas = <HEAD>;
close (HEAD);

foreach $line(@datas) {
	chomp($line);
}

$datas[10] =~ s/\\n/\n/g;
$datas[11] =~ s/\\n/\n/g;

@del = split(/\,/,$INPUT{'delete'});

if ( -e "$free_path/$base_dir/guestbook.html") { 
	open( GB, "+<$free_path/$base_dir/guestbook.html");
	if ($flock) {
		flock GB, 2; 
	}
	@gbook = <GB>;
	seek (GB, 0, 0);
	truncate (GB,0);

	$start = 0;
	$start_print =0;
	$start_del = 0;
	foreach $line(@gbook) {
		if ($line =~ /<!-- NUM /) {
			$start_del =0;
			foreach $ddel (@del) {
				if ($line =~ /<!-- NUM $ddel/) {
					$start_del = 1;
				}	
			}	
		}
		if ($line =~ /<!-- END TABLE/) {
			$start_del=0;
		}
		unless ($start_del) {
			print GB $line;
		}
	}
}

&log("Selected entries were deleted from your guestbook");
exit;

}
########## FEATURES -- GUESTBOOK EDIT ##########
sub features_gbook {

&checkpword;

open (VAR, ">$free_path/$base_dir/gbook.dat");
print VAR "$INPUT{'g_title'}\n";
print VAR "$INPUT{'g_bgcolor'}\n";
print VAR "$INPUT{'g_bgimage'}\n";
print VAR "$INPUT{'g_text'}\n";
print VAR "$INPUT{'g_link'}\n";
print VAR "$INPUT{'g_vlink'}\n";
print VAR "$INPUT{'g_table1'}\n";
print VAR "$INPUT{'g_table2'}\n";
print VAR "$INPUT{'g_text1'}\n";
print VAR "$INPUT{'g_text2'}\n";
$INPUT{'g_head'} =~ s/\r//g;
$INPUT{'g_foot'} =~ s/\r//g;
$g_head = $INPUT{'g_head'};
$g_foot = $INPUT{'g_foot'};
$INPUT{'g_head'} =~ s/\n/\\n/g;
$INPUT{'g_foot'} =~ s/\n/\\n/g;

print VAR "$INPUT{'g_head'}\n";
print VAR "$INPUT{'g_foot'}\n";
close (VAR);	

open (HEAD, "$free_path/$base_dir/guestbook.html");
@gbook = <HEAD>;
close (HEAD);

undef $/;
open (DAT,"<$path/$file_header");
$ahead = <DAT>;
close (DAT);

open (DAT,"<$path/$file_footer");
$afoot = <DAT>;
close (DAT);

$ahead =~ s/(.)*?\n//;
$afoot =~ s/(.)*?\n//;

$/ ="\n";

if ($gbook_header) {
	open (HEAD, "$path/gbook_header.txt");
	$wheader = <HEAD>;
	close (HEAD);

	open (HEAD, "$path/gbook_footer.txt");
	$wfooter = <HEAD>;
	close (HEAD);
	
	$afoot = $wfooter;
	$ahead = $wheader;
}
else {
	$afoot = $bfoot;
	$ahead = $bhead;
}

$header = "\n$start_head";
$header .="$ahead\n";
$header .= "$end_head";

$footer = "\n$start_foot";
$footer .="$afoot\n";
$footer .= "$end_foot";

open (VAR, ">$free_path/$base_dir/guestbook.html");

print VAR "<HTML><HEAD>\n";
print VAR "<TITLE>$INPUT{'g_title'}</TITLE>\n";
print VAR "</HEAD>\n";
print VAR "<BODY";
if ($INPUT{'g_bgimage'}) { print VAR " background=\"$INPUT{'g_bgimage'}\""; }
if ($INPUT{'g_bgcolor'}) { print VAR " bgcolor=\"$INPUT{'g_bgcolor'}\""; }
if ($INPUT{'g_text'}) { print VAR " text=\"$INPUT{'g_text'}\""; }
if ($INPUT{'g_link'}) { print VAR " link=\"$INPUT{'g_link'}\""; }
if ($INPUT{'g_vlink'}) { print VAR " vlink=\"$INPUT{'g_vlink'}\""; }
print VAR ">$header\n";
print VAR "$g_head\n\n";
print VAR "<CENTER><TABLE CELLPADDING=5 CELLSPACING=0 BORDER=0 WIDTH=500>\n";
print VAR "<!-- INSERT -->\n";

$got=0;
$start_print =0;
foreach $line(@gbook) {
	if ($got) {
		$got=0;
		next;
	}
	if ($line =~ /<!-- INSERT/) {
		$start_print =1;
		next;
	}
	if ($line =~ /<!-- END TABLE/) {
		$start_print =0;
		last;
	}
	if ($line =~ /<!-- TABLE 1/) {
		print VAR "<!-- TABLE 1 -->\n";
		print VAR "<TR";
		if ($INPUT{'g_table1'}) {
			print VAR " bgcolor=$INPUT{'g_table1'}";
		}
		print VAR "><TD><font face=verdana size=1";
		if ($INPUT{'g_text1'}) {
			print VAR " color=$INPUT{'g_text1'}";
		}		
		print VAR ">\n";
		$got=1;
		next;
	}
	if ($line =~ /<!-- TABLE 2/) {
		print VAR "<!-- TABLE 2 -->\n";
		print VAR "<TR";
		if ($INPUT{'g_table2'}) {
			print VAR " bgcolor=$INPUT{'g_table2'}";
		}
		print VAR "><TD><font face=verdana size=1";
		if ($INPUT{'g_text2'}) {
			print VAR " color=$INPUT{'g_text2'}";
		}		
		print VAR ">\n";
		$got=1;
		next;
	}
	if ($start_print) {
		print VAR "$line";
	}

}

print VAR "<!-- END TABLE -->\n";
print VAR "</TABLE><BR>\n";
print VAR <<EOF;

<FORM METHOD=POST ACTION="$url_to_cgi/features.cgi">
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$cata">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<table cellpadding=5 border=1 cellspacing=0 bgcolor=white>
<TR><TD><font color=black face=arial size=-1>
Your Name:</TD><TD>
<input type="Text" name="g_name"></TD></TR>
<TR><TD><font color=black face=arial size=-1>
Your Email Address:</TD><TD>
<input type="Text" name="g_email"></TD></TR>
<TR><TD><font color=black face=arial size=-1>
Where are you from:</TD><TD>
<input type="Text" name="g_from"></TD></TR>
<TR><TD colspan=2><font color=black face=arial size=-1>
Your Comments:</TD></TR>
<TR><TD colspan=2><textarea name="g_comments" cols="35" rows="8" wrap="OFF"></textarea>
</TD></TR><TR><TD colspan=2 align=center>
<input type="Submit" name="sign_gbook" value=" Sign the Guestbook ">
</TD></TR></TABLE></FORM>

EOF
print VAR "$g_foot\n";
print VAR "$footer";
print VAR "</BODY></HTML>\n\n";
close (VAR);



&log("Guest Book settings updated");
exit;
}

########## FEATURES -- WWWBOARD EDIT ##########
sub features_wwwboard {
&checkpword;

open (VAR, ">$free_path/$base_dir/wwwboard/board.dat");
print VAR "0\n";
print VAR "$INPUT{'g_bgcolor'}\n";
print VAR "$INPUT{'g_bgimage'}\n";
print VAR "$INPUT{'g_text'}\n";
print VAR "$INPUT{'g_link'}\n";
print VAR "$INPUT{'g_vlink'}\n";
print VAR "0\n";
print VAR "0\n";
print VAR "0\n";
print VAR "0\n";
$INPUT{'g_head'} =~ s/\r//g;
$INPUT{'g_foot'} =~ s/\r//g;
$g_head = $INPUT{'g_head'};
$g_foot = $INPUT{'g_foot'};
$INPUT{'g_head'} =~ s/\n/\\n/g;
$INPUT{'g_foot'} =~ s/\n/\\n/g;

print VAR "$INPUT{'g_head'}\n";
print VAR "$INPUT{'g_foot'}\n";
close (VAR);	


	$acco[12] = $INPUT{'wwwboard_name'};
	$acc_data = join("\n",@acco);	

	open (ACC, ">$accfile") || &error("Error printing $accfile");
	print ACC $acc_data;
	close (ACC);

	undef $/;
	open (VARIABLES, "$free_path/$dir_acc/wwwboard/index.html");
	$forum = <VARIABLES>;
	close (VARIABLES);
	$/="\n";
	
	$forum =~ s/(.|\n)*?<!--begin-->//m;
	$forum =~ s/<!-- END POSTS -->(.|\n)*//m;

	unless ($forum) { $forum = "\n<\ul>\n"; }

	mkdir("$free_path/$dir_acc/wwwboard", 0777);

	if ($wwwboard_header) {
		undef $/;
		open (HEAD, "$path/wwwboard_header.txt");
		$header = <HEAD>;
		close (HEAD);

		open (HEAD, "$path/wwwboard_footer.txt");
		$footer = <HEAD>;
		close (HEAD);
		$/ = "\n";
	}
	else {
		undef $/;
		open (HEAD, "$path/$file_header");
		$header = <HEAD>;
		close (HEAD);

		open (HEAD, "$path/$file_footer");
		$footer = <HEAD>;
		close (HEAD);
		$/ = "\n";

		unless ($file_header eq "header_html.txt") {
			$header =~ s/(.)*?\n//;
		}
		unless ($file_footer eq "footer_html.txt") {
			$footer =~ s/(.)*?\n//;
		}
	}


	open (WEB, ">$free_path/$dir_acc/wwwboard/index.html");
	print WEB "<html><head>\n";
	print WEB "<TITLE>$INPUT{'wwwboard_name'}</TITLE></HEAD>\n";
	print WEB "<BODY";
	if ($INPUT{'g_bgimage'}) { print WEB " background=\"$INPUT{'g_bgimage'}\""; }
	if ($INPUT{'g_bgcolor'}) { print WEB " bgcolor=\"$INPUT{'g_bgcolor'}\""; }
	if ($INPUT{'g_text'}) { print WEB " text=\"$INPUT{'g_text'}\""; }
	if ($INPUT{'g_link'}) { print WEB " link=\"$INPUT{'g_link'}\""; }
	if ($INPUT{'g_vlink'}) { print WEB " vlink=\"$INPUT{'g_vlink'}\""; }
	print WEB ">\n\n";
    unless ($acco[7] eq 'off') {
		print WEB "$start_head";
		print WEB "$header\n";
		print WEB "$end_head";
	}
	print WEB $g_head;
	print WEB "<center><font face=arial size=-1><B><font size=+1>\n";
	print WEB "$INPUT{'wwwboard_name'}\n";
	print WEB "</B></FONT></center>\n";
	print WEB "<hr size=1 noshade width=50%>\n";
	print WEB "<center><a href=\"\#post\">Post Message</a></center>\n";
	print WEB "<hr size=1 noshade width=50\%>\n";
	print WEB "<CENTER><TABLE BORDER=0><TR><TD><font face=arial size=-1>\n";
	print WEB "<ul>\n";
	print WEB "<!--begin-->";
	print WEB $forum;
	print WEB "<!-- END POSTS -->\n";
	print WEB "<a name=\"post\"><center><font size=+1><B>Post A Message!</b></FONT></center></a>\n";
	print WEB "<form method=POST action=\"$url_to_cgi/features.cgi\">\n";
	print WEB "<input type=\"Hidden\" name=\"cata\" value=\"$cata\">\n";
	print WEB "<input type=\"Hidden\" name=\"wwwboard\" value=\"$account\">\n";
	print WEB "Name: <input type=text name=\"name\" size=30><br>\n";
	print WEB "E-Mail: <input type=text name=\"email\" size=30><p>\n";
	print WEB "Subject: <input type=text name=\"subject\" size=30><p>\n";
	print WEB "Message:<br>\n";
	print WEB "<textarea COLS=55 ROWS=10 name=\"body\"></textarea><p>\n";
	print WEB "Optional Link URL: <input type=text name=\"url\" size=30><br>\n";
	print WEB "Link Title: <input type=text name=\"url_title\" size=30><br>\n";
	print WEB "Optional Image URL: <input type=text name=\"img\" size=30><p>\n";
	print WEB "<input type=submit value=\"Post Message\"> <input type=reset>\n";
	print WEB "</form></TD></TR></TABLE></CENTER>\n";
	print WEB $g_foot;
    unless ($acco[7] eq 'off') {
		print WEB "\n$start_foot";
		print WEB "$footer\n";
		print WEB "$end_foot";
	}
	print WEB "</BODY></HTML>\n";
	close (WEB);	

&log("Web Board info updated");
}

######### CHANGE ACCOUNT INFO ##########
sub features_change {
&checkpword;

unless ($INPUT{'new_pass'}) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
You deleted your password and did not enter a new one.</TD></TR></TABLE><BR>
EOF
&Footer;
exit;
}
unless ($INPUT{'name'}) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
You deleted your name and did not enter a new one.</TD></TR></TABLE><BR>
EOF
&Footer;
exit;
}
unless ($INPUT{'email'}) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
You deleted your email address and did not enter a new one.</TD></TR></TABLE><BR>
EOF
&Footer;
exit;
}

$site_name = $INPUT{'site_name'};
$site_name =~ s/</ /g;
$site_name =~ s/>/ /g;
$site_name =~ s/\|/ /g;

$site_descrip = $INPUT{'site_des'};
$site_descrip =~ s/</ /g;
$site_descrip =~ s/>/ /g;
$site_descrip =~ s/\|/ /g;

$acco[0] = $INPUT{'email'};
$acco[1] = $INPUT{'name'};
$acco[2] = $INPUT{'new_pass'};
$acco[8] = $site_name;
$acco[9] = $site_descrip;

$acc_data = join("\n",@acco);
open (ACC, ">$accfile") || &error("Error printing $accfile");
print ACC $acc_data;
close (ACC);		

$INPUT{'password'} = $INPUT{'new_pass'};
&log("Account information updated.");

}

########## DIRECTORY LISTINGS ##########
sub dir_lists {

my $direc = $_[0];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 

unless (($direc =~ /$dir_acc\/wwwboard/) && !($wwwboard_size)) { 
	foreach $file(@files) {
		@stats = stat("$direc/$file");
		$mtime = $stats[9];
		$atime = $stats[8];
		$size = $stats[7];
		$size = $size /1000;
		$total_k = $size + $total_k;
	}
}

for $new_dir(0..$#dirs) {
	$show_dir = "$direc/$dirs[$new_dir]";
	$show_dir =~ s/$free_path\/$base_dir\///i;
	if ($dir_total && ($show_dir ne 'wwwboard')) {
		print "\n<option value=\"$show_dir\">$show_dir";
		$num_dir++;
	}

	if ($text_dir eq $show_dir) {
			if ($dir_total && ($show_dir ne 'wwwboard')) {
				print " \* ";
				$num_dir++;
			}	
	}
	&dir_lists("$direc/$dirs[$new_dir]",$blank);
}
}

########## CREATE NEW FOLDER ##########
sub new_folder_sub {

&checkpword;

$new_folder = $INPUT{'new_folder'};
$new_folder = "\L$new_folder\E";

@out = split(//,$new_folder);
$a=0;
foreach $char (@out) {
	$a++;
	unless ($char =~ /[a-z|0-9|\_]/) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You entered an invalid folder name<BR>
Make sure you only enter letters and nothing else<BR>
and that it is not more than characters
</TD></TR></TABLE><BR><BR>
EOF
		&Footer;
		exit;
	}
}

if ($a > 20) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size  color=$text_table>
You entered an invalid folder name<BR>
Make sure you only enter letters and nothing else<BR>
and that it is not more than characters
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}

$INPUT{'num_dir'}++;
if ($INPUT{'num_dir'} > $dir_total) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size  color=$text_table>
<B>Folder not created</B><BR><BR>
Creating this folder would go above the total of<BR>
$dir_total folders allowed for this account.
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}

@dirs = split(/\//,$active_dir);

$num_deep = push(@dirs);

if ($dir_deep && ($num_deep > $dir_deep)) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size  color=$text_table>
<B>Folder not created</B><BR><BR>
Creating this folder would go deeper into the file system then is allowed.<BR>
No more folders can be created in this dir.
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}

if (-e "$free_path/$dir_acc/$new_folder") {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size  color=$text_table>
<B>Folder not created</B><BR><BR>
There is already a dir in this folder named $new_folder, please select another name
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}


mkdir("$free_path/$dir_acc/$new_folder", 0777) || &error("Can't make $free_path/$dir_acc/$new_folder");

if ($INPUT{'active_dir'}) { $INPUT{'active_dir'} =  "$active_dir/$new_folder"; }
else { $INPUT{'active_dir'} =  "$new_folder"; }

&log("New Folder: <font color=$text_highlight>$new_folder</font> complete");
}

########## DELETE DIR FINAL ##########
sub del_dir {

&checkpword;

$del_to_dir = $INPUT{'current_dirs'};

unless ($del_to_dir) {
print <<EOF;
<TABLE cellpadding=8 border=1 bgcolor=$table_bg width=85%>
<TR><TD align=center><font face=$font_face font size=$font_size color=$text_table>
You must select a directory to delete.</font></TD></TR>
</TABLE>
</form>
EOF
&Footer;
exit;
}

$num=0;
opendir (DIR, "$free_path/$dir_acc/$del_to_dir") || &error("can not open $free_path/$dir_acc/$del_to_dir");
@files = grep {!(/^\./)}  readdir(DIR);
close (DIR); 

$num = push(@files);

if ($num) {
print <<EOF;
<TABLE cellpadding=8 border=1 bgcolor=$table_bg width=85%>
<TR><TD align=center><font face=$font_face font size=$font_size color=$text_table><B>$del_to_dir</B>
can not be deleted, because the folder is not empty. Please remove all files from this folder before trying to delete it.</font></TD></TR>
</TABLE>
</form>
EOF
&Footer;
exit;
}

rmdir ("$free_path/$dir_acc/$del_to_dir") || &error("Could not delete $free_path/$dir_acc/$del_to_dir");

$INPUT{'active_dir'} = $active_dir;
&log("Folder $del_to_dir deleted");
}

########## DELETE FILES FINAL ##########
sub del_file {

&checkpword;

@del_files = split(/\,/,$INPUT{'sfile'});
$message = "<font face=$font_face>The following files where deleted:<BR><TABLE cellpadding=8 border=0>";
foreach $file(@del_files) {
$message .= "<TR><TD align=left><font face=$font_face><B>$file</B></font></TD></TR>";

unlink ("$free_path/$dir_acc/$file");

}

$message .= "</TABLE>";

&log($message);
}

########## RENAME FILES ##########
sub rename {

&checkpword;

@del_files = split(/\,/,$INPUT{'sfile'});

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<input type="Hidden" name="sfile" value="$INPUT{'sfile'}">
<font face=$font_face>Rename the following files:<BR>
<TABLE cellpadding=8 border=0>
EOF

foreach $file(@del_files) {
print <<EOF;
<TR><TD align=left><font face=$font_face><B>$file</B> -&gt;</font></TD>
<TD><INPUT TYPE="TEXT" NAME="$file"></TD></TR>
EOF
}
print <<EOF;
<TR><TD align=center colspan=2>
<BR><INPUT TYPE="SUBMIT" NAME="rename_final" VALUE="Rename these files">
</TD></TR></TABLE>
</form>
EOF
&Footer;
exit;

}

########## RENAME FILENAMES FINAL ##########
sub rename_final {

&checkpword;

@del_files = split(/\,/,$INPUT{'sfile'});

$t_errors = 0;
$message = "<font face=$font_face>The following files where renamed:<BR><TABLE cellpadding=8 border=0>";
$error = "<font face=$font_face>The following files could not be renamed due to improper file name or file exstension:<BR><TABLE cellpadding=8 border=0>";

foreach $file(@del_files) {
	$errors = 0;
	$found = 0;
	if ($INPUT{$file}) {
		@filename=split(/\./,$INPUT{$file});
		$ext = "." . $filename[1];
		$base_name = $filename[0];
		@out = split(//,$base_name);
		$a=0;
		foreach $char (@out) {
			$a++;	
			unless (($char =~ /[a-z]/) || ($char =~ /[A-Z]/) || ($char =~ /[0-9]/) || ($char =~ /_/)){
				$error .= "<TR><TD align=center><font face=$font_face><B>$file -- Invalid File name</B></font></TD></TR>";
				$errors = 1;
				last;
			}
		}
		unless ($a) {
			$error .= "<font face=$font_face><B>You must enter a file name</B></font><BR></b>";
			$errors = 1;
		}
		unless ($ext && ($good_types{$ext})) {
			$error .= "<font face=$font_face><B>$ext -- Invalid file type</B></font><BR>";
			$errors = 1;
		}

		unless ($errors) {
			$re_message=1;
			rename  ("$free_path/$dir_acc/$file" , "$free_path/$dir_acc/$INPUT{$file}");
			$message .= "<TR><TD align=center><font face=$font_face><B>$file --\&gt; $INPUT{$file}</B></font></TD></TR>";
		}
	}

}

$message .= "</TABLE><BR>";

if ($errors) {
	$error .= "</TABLE>";
	if ($re_message) {
		$message .= $error;
	}
	else {
		$message = $error;
	}
}

&log($message);
}


########## EDIT A FILE ##########
sub edit {

&checkpword;

if ($INPUT{'sfile'} =~ /,/) {
	print "Please select only one file to edit<BR>";
	&Footer;
	exit;
}
unless ($INPUT{'sfile'}) {
	print "You must select a file to edit<BR>";
	&Footer;
	exit;
}	
$file = $INPUT{'sfile'};

undef $/;
open (DAT,"<$free_path/$dir_acc/$file");
$content = <DAT>;
close (DAT);
$/ =1;
$"='';

if ($content =~ /<!--START EZ_WEB TEMP-->/) {

@gettemp = split(/\%\%/,$content);

print <<EOF; 
<FORM METHOD=POST ACTION="ez_web.cgi">
$hidden_variables
<INPUT TYPE="HIDDEN" NAME="sfile" VALUE="$file">
<TABLE border=0 width=450><TR><TD>
<font face=$font_face size=$font_size>$file was created 
using a template. By clicking the "Use Template" button you can
edit this file through the same template it was create from, or you
can try editing the html that created the file. Please note though,
if you edit the html and not use the template, you will no longer be able
to use the template for this file.
<BR><BR><center>
<input type="Submit" name="$gettemp[2]" value="  Use Template  ">
</FORM>
</TD></TR></TABLE>
EOF

$content =~ s/<!--START EZ_WEB TEMP-->(.|\n)*?<!--END EZ_WEB TEMP-->\n//gm;
}
elsif ($content =~ /<!--START EZ_WEB HTML-->/) {

@gettemp = split(/\%\%/,$content);

print <<EOF; 
<FORM METHOD=POST ACTION="ez_web.cgi">
$hidden_variables
<INPUT TYPE="HIDDEN" NAME="sfile" VALUE="$file">
<TABLE border=0 width=450><TR><TD>
<font face=$font_face size=$font_size>$file was created 
using a EZ-Web Builder. By clicking the "Use EZ-Web" button you can
edit this file through the same EZ-Web system used to create it, or you
can try editing the html that created the file. Please note though,
if you edit the html and not use EZ-Web, you will no longer be able
to edit this file using EZ-Web.
<BR><BR><center>
<input type="Submit" name="from_manager" value="  EZ-Web Builder  ">
</FORM>
</TD></TR></TABLE>
EOF

$content =~ s/<!--START EZ_WEB HTML-->(.|\n)*?<!--END EZ_WEB HTML-->\n//gm;
}


$contents = &remove_header;
$contents =~ s/<\/TEXTAREA>/<\%\%TEXTAREA>/ig;

print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<INPUT TYPE="HIDDEN" NAME="sfile" VALUE="$file">
<font face=$font_face><B>Edit the file: <font color=$text_highlight>$file</FONT></B>
<BR><BR><font size=$font_size>Enter or change all the html you want in the text box below</font><BR><BR>
<TEXTAREA NAME="filecontents" ROWS=25 COLS=65  wrap="OFF">
$contents
</TEXTAREA>
<BR><BR>

<INPUT TYPE="SUBMIT" NAME="edit_final" VALUE="Save your changes">
</form>

EOF
$" =' ';
&Footer;
exit;
}

########## EDIT FINAL #########
sub edit_final {

&checkpword;

$file = $INPUT{'sfile'};

$error='';;

if ($file) {
	@filename=split(/\./,$file);
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
}
else {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor="#E0C2C2">
<TR><TD><font face=$font_face size=$font_size>
You must enter a filename<BR><BR>Please hit your back button and enter one now.
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

$start_body =0;
$end_body = 0;

$"='';

$content = $INPUT{'filecontents'};
$content =~ s/\r//g;

unless ($acco[7]) { $acco[7] = "on"; }
if (($good_types{$ext} eq "html") && ($acco[7] eq "on")) { 
	$new_content = &add_header;
}
else {
	$new_content = $content;
}

$new_content =~ s/<\%\%TEXTAREA>/<\/TEXTAREA>/ig;

open (FILE, ">$free_path/$dir_acc/_temp.html");
print FILE $new_content;
close (FILE);

@stats = stat("$free_path/$dir_acc/_temp.html");
$sizes = $stats[7];
$sizes = $sizes /1000;
@stats = stat("$free_path/$dir_acc/$file");
$size = $stats[7];
$size = $size /1000;
$t_size = $sizes - $size + $acco[3];
$total_size += $acco[6];

if ($t_size > $total_size) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor="#E0C2C2">
<TR><TD><font face=$font_face size=$font_size>
<B>The file you just tried to create or edit took you over the size limit,<BR>Please go back and make the file smaller.</TD></TR></TABLE>

EOF
	&Footer;
	unlink ("$free_path/$dir_acc/_temp.html");
	exit;
}

open (HEAD, "$free_path/$dir_acc/_temp.html");
@new = <HEAD>;
close (HEAD);

open (DAT,">$free_path/$dir_acc/$file");
print DAT "@new";
close (DAT);

unlink ("$free_path/$dir_acc/_temp.html");
$message = "File: <font color=$text_highlight>$file</font> updated";

$" = ' ';
$INPUT{'current_dir'} = $active_dir;
&log($message);
}


########## NEW FILE ##########
sub new {
&checkpword;
print <<EOF; 
<FORM METHOD=POST ACTION="ez_web.cgi">
$hidden_variables
<TABLE border=0 cellpadding=5 width=500><TR>
<TD colspan=2 align=center>
<font face=$font_face size=$font_size>
<B>How would like to create you new file?
</B><BR><BR>
</TD></TR>
<TR><TD>
<font face=$font_face size=$font_size>
<B>EZ WEB Builder</B> - No html knowledge necessary
</TD><TD>
<input type="Submit" name="ezweb" value="EZ-Web builder"></TD></TR>
EOF
if ( -e "$path/template_1.dat" && -e "$path/template_1.html") {
print <<EOF;
<TR><TD colspan=2><BR>

<font face=$font_face size=$font_size><CENTER>
<B>HTML Templates</B><BR></CENTER>Easy to use templates for creating web pages. No html experience is 
required. All you have to do is fill out a few text boxes and press save and your page is complete.
<BR><BR>
EOF

	opendir (DIR, "$path") || &error("can not open $path");
	@temps = grep {(/^template\_[0-9]*\.dat/)}  readdir(DIR);
	close (DIR);

	foreach $ttem(@temps) {
		open (HEAD, "$path/$ttem");
		@ffil = <HEAD>;
		close (HEAD);

print <<EOF;
<TR><TD>
<font face=$font_face size=$font_size>
<B>$ffil[0]</B> - $ffil[1]
</TD><TD>
<input type="Submit" name="$ttem" value=" Use this Template ">
</TD></TR>
EOF
	}

}
print <<EOF;
<TR><TD colspan=2>
<font face=$font_face size=$font_size>
<BR><CENTER><B>Straight HTML</B><BR></CENTER>
If you already know html and do not need any help in creating your web page, or just would like to
try html, you can create a file using all html in the text box below. Enter the file name of your new file
in the file name text box and press save when your done.
</TD></TR>
</TABLE></FORM>

<FORM METHOD=POST ACTION="$cgiurl">
$hidden_variables
<font face=$font_face size=$font_size><B>Create the file:</b></FONT> <INPUT TYPE="Text" NAME="sfile" VALUE=""></B>
<BR><BR>
<TEXTAREA NAME="filecontents" ROWS=25 COLS=65 wrap="PHYSICAL">
</TEXTAREA>
<BR><BR>
<INPUT TYPE="SUBMIT" NAME="edit_final" VALUE="Create your file">
</form>
EOF
&Footer;
exit;
}

####### ACTUALLY SEND THE PASSWORD ######
sub sendpword {

$cata = $INPUT{'cata'};
$account = $INPUT{'account'};

unless ($cata) { $cata="accounts"; }

@accarray = split(//,$account);

$accfile = "$path/members/$cata/$accarray[0]/$account.dat";

if (-e "$accfile") {
	undef $/;
	open (ACC, "$accfile") || &error("Error reading $accfile");
	$acc_data = <ACC>;
	close (ACC);
	$/ = "\n";

	@acco = split(/\n/,$acc_data);

	&Header;
	$mailpassword = $acco[2];
	$recipient = $acco[0];
	untie(%acc);

	$messages .= "Hello again from $free_name.\n\n";
	$messages .= "Below is your requested password. Please keep it in a safe place for future referance\n";
	$messages .= "Your password: $mailpassword\n";
	$messages .= "Thank you again for using $free_name and we look foward to serving you again soon!\n";

	&write_email($recipient,"Your $free_name password",$messages);

print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
Your password has been mailed back to you. Thank you for using $free_name
</TD></TR></TABLE>
<BR><BR>
EOF

	&Footer;
	exit;
}
else {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, there is no account here under that name.
</TD></TR></TABLE>
<BR><BR>
EOF
	&Footer;
	exit;
}
}


########## ACTUAL SENDING OF EMAIL ##########
sub write_email {
if ($demo){&demo;}

$recipient = $_[0];
$subject = $_[1];
$message = $_[2];

### SMTP ###
if ($email_prog =~ /\./) {

	$smtp_server = $smtp;
	$emailfrom = $your_email;

($x,$x,$x,$x, $here) = gethostbyname($null);
($x,$x,$x,$x, $there) = gethostbyname($smtp_server);
$thisserver = pack('S n a4 x8',2,0,$here);
$remoteserver = pack('S n a4 x8',2,25,$there);
#NOTE, if Solaris, uncomment the line below and delete the one below it...leave alone for NT
#(!(socket(S,2,2,6))) && (&error("SMTP EMAIL: Connect error!"));
(!(socket(S,2,1,6))) && (&error("SMTP EMAIL: Connect error! socket"));
(!(bind(S,$thisserver))) && (&error("SMTP EMAIL: Connect error! bind"));
(!(connect(S,$remoteserver))) && (&error("SMTP EMAIL:  connection to $smtp_server has failed!"));

select(S);
$| = 1;
select(STDOUT);

$DATA_IN = <S>;	
($DATA_IN !~ /^220/) && (&error("SMTP EMAIL: data in Connect error - 220")); 

print S "HELO $ENV{REMOTE_HOST}\r\n";
$DATA_IN = <S>;
($DATA_IN !~ /^250/) && (&error("SMTP EMAIL: data in Connect error - 250")); 

print S "MAIL FROM:<$emailfrom>\n";
$DATA_IN = <S>;
($DATA_IN !~ /^250/) && (&error("SMTP EMAIL: $emailfrom address not valid")); 

print S "RCPT TO:<$recipient>\n";
$DATA_IN = <S>;
($DATA_IN !~ /^250/) && (&error("SMTP EMAIL: $recipient address not valid")); 

print S "DATA\n";
$DATA_IN = <S>;
($DATA_IN !~ /^354/) && (&error("SMTP EMAIL: Message send failed - 354")); 

print S <<MESSAGES;
From: $emailfrom
To: $recipient
Subject: $subject

$message
.
MESSAGES
$DATA_IN = <S>;
($DATA_IN !~ /^250/) && (&error("SMTP EMAIL: Message send failed - try again - 250")); 

print S "QUIT\n";
		
}
else {
	open(MAIL, "|$mail_prog -t") || &error("Could not send out emails");
	print MAIL "To: $recipient \n";
	print MAIL "From: $your_email \n";
	print MAIL "Subject: $subject \n\n";
	print MAIL $message;
	print MAIL "\n\n";
	close (MAIL);
}
} 


########### UPLOAD FILES ##########
sub upload {

$INPUT{'cata'} = $in{'cata'};
$INPUT{'account'} = $in{'account'};
$INPUT{'password'} = $in{'password'};
$INPUT{'active_dir'} = $in{'active_dir'};
$INPUT{'all_files'} = $in{'all_files'};
$INPUT{'html'} = $in{'html'};
$INPUT{'image'} = $in{'image'};
$INPUT{'other'} = $in{'other'};

&checkpword;

unless($acco[7]) {
	$acco[7] = "on";
}

$message = "File upload results:<BR>";

$num = 1;
while ($num <=5) {
	$filename = $incfn{'file' . $num};
	if ($filename) {
		@a=split(/\\/,$filename);
		$alen = push(@a);
		$alen = $alen -1;
		$file = $a[$alen];
		@filen=split(/\./,$file);
		$ext = "." . $filen[1];
		$found=0;
		$ext = "\L$ext\E";
		unless ($ext && $good_types{$ext}) {
			$message .="<BR>$file not uploaded, invalid file type";
			$num++;
			next;
		}
					
		$content_bin = $in{'file' . $num};
		$content = $content_bin;
		$*=1;
		$content =~ s/\r//gi;
		if (($good_types{$ext} eq "html") && ($acco[7] eq "on")) { 
			$contents = &remove_header;
			$content = $contents;
			$new_content = &add_header;
		}
		else {
			$new_content = $content_bin;
		}
		open (FILE, ">$free_path/$dir_acc/_$file");
		print FILE $new_content;
		close (FILE);
	
		@stats = stat("$free_path/$dir_acc/_$file");
		$sizes = $stats[7];
		$sizes = $sizes /1000;
		@stats = stat("$free_path/$dir_acc/$file");
		$size = $stats[7];
		$size = $size /1000;
		$t_size = $sizes - $size + $acco[3];
		$total_size += $acco[6];
	
		if ($t_size > $total_size) {
			$message .= "<BR>$file not uploaded, not enough disk space";
		}
		else {
			@new = "";
			open (HEAD, "$free_path/$dir_acc/_$file");
			@new = <HEAD>;
			close (HEAD);
			open (DAT,">$free_path/$dir_acc/$file");
			print DAT @new;
			close (DAT);
			$message .="<BR>$file uploaded";
		}
		unlink ("$free_path/$dir_acc/_$file");
	}
	$num++;
}

&log($message);
}

########## FTP ##########
sub ftp {
&checkpword;

opendir (DIR, "$ftp_path/$account") || &error("can not open $ftp_path/$account");
@files = grep {!(/^\./)}  readdir(DIR);
close (DIR); 

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl" name="ftp">
$hidden_variables
<font face=$font_face size=$font_size><B>Import files uploaded via ftp</B><BR><BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD bgcolor=$table_head_bg align=center colspan=5> 
<font color=$text_table_head face=$font_face size=$font_size>Import selected files to current directory:
<font color=$text_highlight>$text_dir</font></TD></TR>
<TR bgcolor=$table_head_bg>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Select</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Type</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Name</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Size</FONT></TD>
<TD align=center><font color=$text_table_head face=$font_face size=$font_size>Time Uploaded</FONT></TD>
</TR>
EOF

@filess = sort (@files);

unless(@filess) {
print <<EOF;
<TR><TD colspan=6 align=center><font face=$font_face size=$font_size>There are currently no files available to import</FONT></TD></TR>
EOF
}

foreach $file(@filess) {
	next if $bad_files{$file};
	@stats = stat("$ftp_path/$account/$file");
	$mtime = $stats[9];
	($msec,$mmin,$mhour,$mmday,$mmon,$myear,$mwday,$myday,$misdst) = localtime($mtime);
	$mmonth = $months[$mmon];
	$myear += 1900;


	$size = $stats[7];
	$size = $size /1000;
	if (($file =~ /\.gif$/i) || ($file =~ /\.jpg$/i) || ($file =~ /\.jpeg$/i)) {
		$image = "image";
	} 
	elsif(($file =~ /\.html$/i) || ($file =~ /\.htm$/i) || ($file =~ /\.shtml$/i)) {
		$image="text";
	}
	elsif(($file =~ /\.zip$/i) || ($file =~ /\.tar$/i)) {
		$image="compressed";
	}
	elsif(($file =~ /\.wav$/i) || ($file =~ /\.avi$/i)) {		
		$image="sound";
	}
	else {
		$image = "unknown";
	}

print <<EOF;
<TR><TD align=center><font face=$font_face size=$font_size><INPUT TYPE="CHECKBOX" NAME="ftp_$file" VALUE="checked"></FONT></TD>
<TD align=center><font face=$font_face size=$font_size></FONT><IMG SRC="$url_to_icons/$image.gif"></TD>
<TD><font face=$font_face size=$font_size>$file</FONT></TD>
<TD><font face=$font_face size=$font_size>$size K</FONT></TD>
<TD><font face=$font_face size=$font_size>$mmonth $mmday, $myear $mhour:$mmin</FONT></TD></TR>
EOF
}

print <<EOF;
<TR><TD bgcolor=$table_head_bg align=center colspan=5> 
<font color=$text_table_head face=$font_face size=$font_size>
Select All files: <input name="allbox" type="checkbox" value="Check All" onClick="CheckAll();">
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="ftp_import" value="Import Selected Files">
</TD></TR></TABLE></FORM>
<SCRIPT>
<!--
function CheckAll() {
	for (var i=0;i<document.ftp.elements.length;i++) {
	    var e = document.ftp.elements[i];
	    if (document.ftp.elements[i].name != 'allbox') {
			e.checked = document.ftp.allbox.checked;

    	}
  	}
}
//-->
</SCRIPT>
EOF

&Footer;
exit;
}

########## FTP IMPORT ##########
sub ftp_import {

&checkpword;


opendir (DIR, "$ftp_path/$account") || &error("can not open $ftp_path/$account");
@files = grep {!(/^\./)}  readdir(DIR);
close (DIR); 


$res ='';
foreach $file(@files) {
	unless ($INPUT{'ftp_' . $file}) { next; }

		
	@filename=split(/\./,$file);
	$ext = "." . $filename[1];
	$ext ="\L$ext\E";
	$base_name = $filename[0];
	@out = split(//,$base_name);
	foreach $char (@out) {
		unless (($char =~ /[a-z]/) || ($char =~ /[A-Z]/) || ($char =~ /[0-9]/) || ($char =~ /_/)){
			$res .= "$file not imported -- Invalid File name<BR>";
			last;
		}
	}
	if ($res =~ /$file/) { next; }
	unless ($ext && ($good_types{$ext})) {
		$res .= "$file not imported -- $ext -- Invalid file type<BR>";
		unlink ("$ftp_path/$account/$file");
		next
	}	
	if ($res =~ /$file/) { next; }
		
	$start_body =0;
	$end_body = 0;

	$"='';

	undef $/;
	open (HEAD, "$ftp_path/$account/$file");
	$content = <HEAD>;
	close (HEAD);
	
	unless ($acco[7]) { $acco[7] = "on"; }
	if (($good_types{$ext} eq "html") && ($acco[7] eq "on")) { 
		$new_content = &add_header;
	}
	else {
		$new_content = $content;
	}
		
	@stats = stat("$ftp_path/$account/$file");
	$mtime = $stats[9];
	($msec,$mmin,$mhour,$mmday,$mmon,$myear,$mwday,$myday,$misdst) = localtime($mtime);
	$mmonth = $months[$mmon];
	$myear += 1900;

	$size = $stats[7];
	$size = $size /1000;
	$t_size = $size + $acco[3];
	$total_size += $acco[6];

	if ($t_size > $total_size) {
		$res .= "$file not imported -- Not enough space available<BR>";
		next;
	}

	open (DAT,">$free_path/$dir_acc/$file");
	print DAT "$new_content";
	close (DAT);

	unlink ("$ftp_path/$account/$file");
	$res .="$file imported<BR>";	
	$/="\n";
}	
	&log($res);
	
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

unless ($file_header eq "header_html.txt") {
	$ahead =~ s/(.)*?\n//;
}
unless ($file_footer eq "footer_html.txt") {
	$afoot =~ s/(.)*?\n//;
}
$/ ="\n";

$header = "\n$start_head";
$header .="$ahead\n";
$header .= "$end_head";

$footer = "\n$start_foot";
$footer .="$afoot\n";
$footer .= "$end_foot";

$content =~ s/<(.|\n)*?BODY(.|\n)*?>/$&$header/i;
unless ($content =~ /$start_head/) {
	unless ($frameset && ($content =~ /<(.|\n)*?FRAMESET(.|\n)*?>/i)) {
		$content = $header . $content;
	}
}
$content =~ s/<\/BODY(.|\n)*?>/$footer$&/i;
unless ($content =~ /$start_foot/) {
	unless ($frameset && ($content =~ /<(.|\n)*?FRAMESET(.|\n)*?>/i)) {
		$content = $content . $footer;
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
	print "<body bgcolor=$over_bg text=$text_color link=$link_color alink=$link_color vlink=$link_color>\n";
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
		print "<center><font size=-1><hr width=525 noshade size=1><a href=\"http://www.freedomain.com\">Community Builder</a> v$version<br>Created by <a href=\"http://solutionscripts.com\">Solution Scripts</a><br><br>";
	}
	print "</BODY></HTML>\n";
}


########## ERROR RESPONCE ##########
sub error {
$error = $_[0] ;
unless ($header_printed) { &Header; }

print <<EOF;

<table cellpadding=5 border=1 cellspacing=0 width=450>
<TR><TD><font face=$font_face size=$font_size>
<B>We are sorry, the system is down at the moment, please try again later<BR><BR>
Thank you<BR><BR><BR>
To help us correct this problem, please let <A HREF="mailto:$your_email">$your_email</A> of the error in red below.<BR><BR>
<I><FONT COLOR="#FF0000">$error -- $!</FONT></I><BR><BR></TD></TR></TABLE>
EOF
&Footer;
exit;
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


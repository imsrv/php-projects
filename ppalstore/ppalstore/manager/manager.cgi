#!/usr/local/bin/perl
#######################################################################################
# Dick Copits
# http://www.smart-choices.org
#######################################################################################
sub open_product_screen
{
print <<ENDOFTEXT;
<HTML><HEAD><TITLE>Product Manager</TITLE></HEAD><BODY BGCOLOR=FFFFFF>
<CENTER>
<TABLE bgcolor="FFFFFF" BORDER = "0" WIDTH = "560"><TR><TD>
<center>
<a href="http://www.smart-choices.org" target="new">http://www.smart-choices.org</A><P>
</TD></TR></table><BR>
<P><CENTER><TABLE WIDTH=550 BORDER=1 BGCOLOR=FFFFFF><TR><TD>
<font face=\"verdana,arial,geneva\" size=+1>
<B><CENTER>Product Management</FONT></B></CENTER>
<BLOCKQUOTE><font face=\"verdana,arial,geneva\">
You have complete control over all your store products from this manager. Add, Edit or Delete products by selection the appropriate button.<BR><BR>

</BLOCKQUOTE></FONT>

<form method=post action=manager.cgi>
<CENTER><input type=button value='Edit Existing Products'onclick=location.href='manager.cgi?edit=yes'>
&nbsp;&nbsp;&nbsp;<input type=button value='Add New Products'onclick=location.href='manager.cgi?add=yes'>
&nbsp;&nbsp;&nbsp;<input type=button value='Delete Existing Products'onclick=location.href='manager.cgi?delete=yes'></CENTER>
<BR><BR></TD></TR></TABLE></CENTER>
ENDOFTEXT
}
sub PageHeader
{
print <<ENDOFTEXT;
<HTML>
<BODY><TABLE WIDTH=500><TR WIDTH=500>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>#</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>Category</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>Brief Description</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>Price</TD></TR>
ENDOFTEXT
}
sub DisplayRequestedProduct
{
print <<ENDOFTEXT;
<TR WIDTH=500><TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>$pnum</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>$category</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>$brief_description</TD>
<TD WIDTH=125><font face=\"verdana,arial,geneva\" size=-1>$price</TD></TR>
ENDOFTEXT
}
sub PageFooter
{
print <<ENDOFTEXT;
</TABLE></BODY></HTML>
ENDOFTEXT
}
sub add_product_screen
{
local($add_product_success) = @_;
local($pnum, $category, $price, $brief_description, $image, $full_description, $options);
open (NEWpnum, "$datafile");
while(<NEWpnum>)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$_);
chop($options);
push(@pnum_num,$pnum);
}
close(NEWpnum);
$highest_value = $pnum_num[$#pnum_num];
$highest_value++;
$new_pnum = $highest_value;
print <<ENDOFTEXT;
<HTML><HEAD><TITLE></TITLE></HEAD>
<BODY BGCOLOR=FFFFFF><CENTER><TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0>
<TD WIDTH=550 BORDER=0></TD></TR></TABLE>
<TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0>
<TD WIDTH=550 BORDER=0>
</TD></TR></TABLE>
ENDOFTEXT
if($add_product_success eq "yes")
{
print <<ENDOFTEXT;
<TABLE><TR><TD>
<font face=\"verdana,arial,geneva\" size=-1 color=blue>Product number <a href=../manager.cgi?product=$in{'category'}>$in{'pnum'}</a> has been added to your catalog.</FONT>
</TD></TR></TABLE>
ENDOFTEXT
}
elsif($add_product_success eq "no")
{
print <<ENDOFTEXT;
<TABLE><TR><TD>
<font face=\"verdana,arial,geneva\" size=-1 color=red><B>Your entry failed! That product number already exists!</B></FONT></TD></TR></TABLE>
ENDOFTEXT
} 
print <<ENDOFTEXT;
<BODY BGCOLOR=FFFFFF><FORM METHOD=POST ACTION=manager.cgi>
<TABLE BORDER=1 CELLPADDING=5 CELLSPACING=1 WIDTH="550" BGCOLOR=FFFFFF>
<TR><TD WIDTH=100><font face=\"verdana,arial,geneva\" size=-1>$new_pnum</FONT>
</TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Database Number - Created Automatically</FONT>
</TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<INPUT NAME="category" TYPE="TEXT" SIZE=25 MAXLENGTH=35 VALUE="category">
</TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Category - One word only, this is called by the script. Use individual category names if you want each item displayed individually, use category groupings by naming all products within that category to display products by category.
</font></TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<INPUT NAME="price" TYPE="TEXT" SIZE=25 MAXLENGTH=35 VALUE=".01">
</TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Price - Do not enter your currency symbol
</TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<TEXTAREA NAME="name" ROWS=2 COLS=25 wrap=soft>
</TEXTAREA></TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Brief Description - This is visible in the customers cart. Include Product Description and Price (with currency symbol)/each. As a guideline fill the box. Do not get too descriptive here, keep it brief but do provide at least the Product Description and Price/Each to display properly. </font>
</TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<INPUT NAME="image" TYPE="TEXT" SIZE=25 MAXLENGTH=35 VALUE="missing.gif">
</TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Image - image.gif, use .gif files only, no .jpeg! 
</font></TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<INPUT NAME="option_file" TYPE="TEXT" SIZE=25 MAXLENGTH=35 VALUE="blank.txt">
</TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>
Option File - option.txt naming scheme recommended. If you are not using options then you must enter blank.txt and make sure you have a file called blank.txt in your options directory.
</font></TD></TR><TR>
<TD WIDTH=100 VALIGN=TOP ALIGN=LEFT>
<TEXTAREA NAME="description" ROWS=6 COLS=25 wrap=soft></TEXTAREA>
</TD><TD WIDTH=450>
<font face=\"verdana,arial,geneva\" size=-1>
Full Description - Enter the Full Description of your product here. Use HTML but always remember to close any tag! This will be the primary description you present so keep it interesting and of a consistent size from product to product. You can gauge the relative size by being consistent within the text entry box. 
Make sure you include the Product Name, and price including your currency symbol and that the price is the same in all three fields. Use HTML but be sure to close all tags! As a guideline fill the box. </font></TD>
</TR></TABLE>
<TABLE WIDTH=550><TR WIDTH=550><TD WIDTH=550><INPUT TYPE=HIDDEN NAME=pnum VALUE=$new_pnum>
<CENTER><INPUT TYPE=SUBMIT NAME=AddProduct VALUE="Add Product">&nbsp;&nbsp;&nbsp;
<INPUT TYPE=RESET VALUE="Cancel"></CENTER></TD><TR></TABLE></FORM></BODY></HTML>
ENDOFTEXT
}
sub edit_product_screen
{
print <<ENDOFTEXT;
<HTML><HEAD><TITLE></TITLE></HEAD><BODY BGCOLOR=FFFFFF>
<CENTER><TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0>
<TD WIDTH=550 BORDER=0></TD></TR></TABLE><TABLE WIDTH=550 BORDER=0>
<TR WIDTH=550 BORDER=0><TD WIDTH=550 BORDER=0></TD></TR></TABLE>
ENDOFTEXT
if ($in{'ProductEditpnum'} ne "")
{
print <<ENDOFTEXT;
<TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0><TD WIDTH=550 BORDER=0>
<font face=\"verdana,arial,geneva\" size=-1 color=blue>
<CENTER>Changes to product \# $in{'ProductEditpnum'} have been accepted.</CENTER>
</FONT></TD></TR></TABLE>
ENDOFTEXT
}
print <<ENDOFTEXT;
<TABLE WIDTH=550 BORDER=1 BGCOLOR=FFFFFF><TR WIDTH=550>
<TD WIDTH=25><font face=\"verdana,arial,geneva\" size=-1><CENTER>Edit?</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>Product #</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1>Category</TD>
<TD WIDTH=300><font face=\"verdana,arial,geneva\" size=-1>Brief Description</TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>Price</CENTER></TD></TR>
ENDOFTEXT
open (DATABASE, "$datafile");
while(<DATABASE>)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$_);
chop($options);
foreach ($pnum) {
print <<ENDOFTEXT;
<TR WIDTH=550><TD WIDTH=50><FORM METHOD=POST ACTION=manager.cgi>
<CENTER><INPUT TYPE=SUBMIT NAME=EditProduct VALUE=" Edit "></CENTER>
<INPUT TYPE=HIDDEN NAME=EditWhichProduct VALUE=$pnum></FORM></TD>
<TD WIDTH=50><font face=\"verdana,arial,geneva\" size=-1><CENTER>$pnum</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1>$category</TD>
<TD WIDTH=300><font face=\"verdana,arial,geneva\" size=-1>$brief_description</TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>$price</CENTER></TD></TR>
ENDOFTEXT
}
}
print <<ENDOFTEXT;
</TABLE></BODY></HTML>
ENDOFTEXT
}
sub delete_product_screen
{
print <<ENDOFTEXT;
<HTML><HEAD><TITLE></TITLE></HEAD>
<BODY BGCOLOR=FFFFFF>
<CENTER><TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0>
<TD WIDTH=550 BORDER=0></TD></TR></TABLE><TABLE WIDTH=550 BORDER=0>
<TR WIDTH=550 BORDER=0><TD WIDTH=550 BORDER=0></TD></TR></TABLE>
ENDOFTEXT
if ($in{'DeleteWhichProduct'} ne "")
{
print <<ENDOFTEXT;
<TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0><TD WIDTH=550 BORDER=0>
<font face=\"verdana,arial,geneva\" size=-1 color=blue>
<CENTER>Product Number \# $in{'DeleteWhichProduct'} has been deleted.</CENTER>
</FONT></TD></TR></TABLE>
ENDOFTEXT
}
print <<ENDOFTEXT;
<TABLE WIDTH=550 BORDER=1 BGCOLOR=FFFFFF><TR WIDTH=550><TD WIDTH=50>
<font face=\"verdana,arial,geneva\" size=-1><CENTER>Delete</CENTER></FONT></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>Product #</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>Category</CENTER></TD>
<TD WIDTH=275><font face=\"verdana,arial,geneva\" size=-1><CENTER>Brief Description</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>Price</CENTER></TD></TR>
ENDOFTEXT
open (DATABASE, "$datafile");
while(<DATABASE>)
	{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$_);
chop($options);
foreach ($pnum) {
print <<ENDOFTEXT;
<TR WIDTH=550><TD WIDTH=50>
<FORM METHOD=POST ACTION=manager.cgi>
<CENTER><INPUT TYPE=SUBMIT NAME=DeleteProduct VALUE="Delete"></CENTER>
<INPUT TYPE=HIDDEN NAME=DeleteWhichProduct VALUE=$pnum></FORM>
</TD><TD WIDTH=25><font face=\"verdana,arial,geneva\" size=-1><CENTER>$pnum</CENTER></TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1>$category</TD>
<TD WIDTH=275><font face=\"verdana,arial,geneva\" size=-1>$brief_description</TD>
<TD WIDTH=75><font face=\"verdana,arial,geneva\" size=-1><CENTER>$price</CENTER></TD></TR>
ENDOFTEXT
}
	}
print <<ENDOFTEXT;
</TABLE></BODY></HTML>
ENDOFTEXT
}
sub display_perform_edit_screen
{
print <<ENDOFTEXT;
<HTML><HEAD><TITLE></TITLE></HEAD>
<BODY BGCOLOR=FFFFFF><FORM METHOD=POST ACTION=manager.cgi>
<CENTER><TABLE WIDTH=550 BORDER=0><TR WIDTH=550 BORDER=0><TD WIDTH=550 BORDER=0>
</TD></TR></TABLE>

<TABLE BORDER=1 CELLPADDING=5 CELLSPACING=1 WIDTH="550"><TR>
<TD WIDTH=100><font face=\"verdana,arial,geneva\" size=-1>$pnum</TD>
<TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Database Number - This is created automatically.</FONT></TD>
</TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><INPUT NAME="category" TYPE="TEXT" SIZE=45 MAXLENGTH=35 VALUE=$category></TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Category - One word only, this is the category name called by the script.</font></TD>
</TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><INPUT NAME="price" TYPE="TEXT" SIZE=45 MAXLENGTH=35 VALUE=$price></TD><TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Price of item - Do not use currency symbol.</TD></TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><TEXTAREA NAME="name" ROWS=2 COLS=45 wrap=soft>$brief_description</TEXTAREA></TD>
<TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Brief Description - This is visible in the customers cart. Include Catalog Number, Price/Each and Short description. Use HTML and include Product Name, Catalog Number, and Price (with currency symbol)/each.</font></TD>
</TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><TEXTAREA NAME="image" ROWS=2 COLS=45 wrap=soft>$image</TEXTAREA></TD>
<TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Image File - filename.gif, .gif only. Do Not use .jpeg. Enter only the image name (image.gif) only!</font></TD>
</TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><INPUT NAME="option_file" TYPE="TEXT" SIZE=45 MAXLENGTH=45 VALUE="$options"></TD>
<TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Option File - Enter Option.txt, Enter blank.txt if you aren't using any options for this item.</font></TD>
</TR><TR><TD WIDTH=100 VALIGN=TOP ALIGN=LEFT><TEXTAREA NAME="description" ROWS=12 COLS=45 wrap=soft>$full_description</TEXTAREA></TD>
<TD WIDTH=450><font face=\"verdana,arial,geneva\" size=-1>Long Description - Enter the Full Description of your product description here. Use HTML but always remember to close any tag! 
This will be the primary description you present so keep it interesting and of a consistent size from product to product. You can gauge the relative size by being consistent within the text entry box. 
Make sure you include the Product Name, and price including your currency symbol and that the price is the same in all three fields.</font></TD>
</TR></TABLE><TABLE WIDTH=550><TR WIDTH=550><TD WIDTH=550>
<INPUT TYPE=HIDDEN NAME=ProductEditpnum VALUE=$pnum>
<CENTER><INPUT TYPE=SUBMIT NAME=SubmitEditProduct VALUE="Submit Edit">&nbsp;&nbsp;&nbsp;
<INPUT TYPE=RESET VALUE="Cancel"></CENTER></TD><TR></TABLE></FORM></BODY></HTML>
ENDOFTEXT
}
1;
sub action_add_product
{
local($pnum, $category, $price, $brief_description, $image, $full_description, $options);
open (CHECKpnum, "$datafile");
while(<CHECKpnum>)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$_);
chop($options);
foreach ($pnum) {
if ($pnum eq $in{'pnum'})
{
$add_product_status="no";
&add_product_screen($add_product_status);
exit;
}
}
}
close (CHECKpnum);
$formatted_description = $in{'description'};
$formatted_description =~ s/\r/ /g;
$formatted_description =~ s/\t/ /g;
$formatted_description =~ s/\n/ /g;
if ($in{'image'} ne "")
{
$formatted_image = "\<IMG SRC\=\"/ppalstore/\images/\/$in{'image'}\" BORDER\=0\>";
}
else
{
$formatted_image = "\<IMG SRC\=\"/ppalstore/\images/missing.gif\" BORDER\=0\>";
}
if ($in{'option_file'} ne "")
{
if (-e "../../ppalstore\/options/$in{'option_file'}")
{
$formatted_option_file = "\%\%OPTION\%\%$in{'option_file'}";
}
else
{
$formatted_option_file = "\%\%OPTION\%\%$in{'option_file'}";
}
}
open (NEW, "+>> $datafile");
print (NEW  "$in{'pnum'}|$in{'category'}|$in{'price'}|$in{'name'}|$formatted_image|$formatted_description|$formatted_option_file\n");
close(NEW);
$add_product_status="yes";
&add_product_screen($add_product_status);
}
sub display_catalog_screen
{
&PageHeader;
open (DATABASE, "$datafile");
while(<DATABASE>)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$_);
chop($options);
foreach ($pnum) {
#if ($pnum eq $in{'pnum'})
#{
&DisplayRequestedProduct;
#}
}
}
close(DATABASE);
&PageFooter;
}
sub action_edit_product
{
local($pnum, $category, $price, $brief_description, $image, $full_description, $options);
open (CHECKpnum, "$datafile");
while(<CHECKpnum>)
{
($pnum, $category, $price, $brief_description, $image, 
 $full_description, $options) = split(/\|/,$_);
chop($options);
foreach ($pnum) {
if ($pnum eq $in{'EditWhichProduct'})
{
$options =~ s/%%OPTION%%//g;
$image =~ s/.*\/images\///g;
$image =~ s/.gif.*/.gif/g;
&display_perform_edit_screen;
}
}
}
}
#######################################################################################
sub action_submit_edit_product
{
local($pnum, $category, $price, $brief_description, $image, $full_description, $options);
$formatted_description = $in{'description'};
$formatted_description =~ s/\r/ /g;
$formatted_description =~ s/\t/ /g;
$formatted_description =~ s/\n/ /g;
if ($in{'image'} ne "")
{
$formatted_image = "\<IMG SRC\=\"/ppalstore/\images\/$in{'image'}\"  BORDER\=0\>";
}
else
{
$formatted_image = "\<IMG SRC\=\"/ppalstore/\images/missing.gif\" BORDER\=0\>";}
if ($in{'option_file'} ne "")
{
$formatted_option_file = "\%\%OPTION\%\%$in{'option_file'}";
}
else
{
$formatted_option_file = "";
}
open(OLDFILE, "$datafile") || die "Can't Open $datafile";
@lines = <OLDFILE>;
#print @lines;
open(NEWFILE,">$datafile") || die "Can't Open $datafile";
foreach $line (@lines)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$line);
if ($pnum == $in{'ProductEditpnum'})
{
print (NEWFILE  "$in{'ProductEditpnum'}|$in{'category'}|$in{'price'}|$in{'name'}|$formatted_image|$formatted_description|$formatted_option_file\n");
}
else 
{
print NEWFILE $line;
}
}
close (NEWFILE);
&edit_product_screen;
}
sub action_delete_product
{
local($pnum, $category, $price, $brief_description, $image, $full_description, $options);
open(OLDFILE, "$datafile") || die "Can't Open $datafile";
@lines = <OLDFILE>;
open(NEWFILE,">$datafile") || die "Can't Open $datafile";
foreach $line (@lines)
{
($pnum, $category, $price, $brief_description, $image, $full_description, $options) = split(/\|/,$line);
if ($pnum == $in{'DeleteWhichProduct'})
{
$line = "";
}
else 
{
print NEWFILE $line;
}
}
close (NEWFILE);
&delete_product_screen;
}
1;

($cgi_lib'version = '$Revision: 2.8 $') =~ s/[^.\d]//g;
$cgi_lib'maxdata    = 131072;    
$cgi_lib'writefiles =      0;    
$cgi_lib'filepre    = "cgi-lib"; 
$cgi_lib'bufsize  =  8192;    
$cgi_lib'maxbound =   100;    
$cgi_lib'headerout =    0;    
sub ReadParse {
local (*in) = shift if @_;    
local (*incfn, *inct, *insfn) = @_;          
local ($len, $type, $meth, $errflag, $cmdflag, $perlwarn);
$perlwarn = $^W;
$^W = 0;
$type = $ENV{'CONTENT_TYPE'};
$len  = $ENV{'CONTENT_LENGTH'};
$meth = $ENV{'REQUEST_METHOD'};
if ($len > $cgi_lib'maxdata) { #'&CgiDie("cgi-lib.pl: Request to receive too much data: $len bytes\n");
}
if (!defined $meth || $meth eq '' || $meth eq 'GET' || $type eq 'application/x-www-form-urlencoded') {
local ($key, $val, $i);
if (!defined $meth || $meth eq '') {$in = $ENV{'QUERY_STRING'};$cmdflag = 1;
} elsif($meth eq 'GET' || $meth eq 'HEAD') { $in = $ENV{'QUERY_STRING'};
} elsif ($meth eq 'POST') {$errflag = (read(STDIN, $in, $len) != $len);
} else {&CgiDie("cgi-lib.pl: Unknown request method: $meth\n");
}
@in = split(/[&;]/,$in); 
push(@in, @ARGV) if $cmdflag; # add command-line parameters
foreach $i (0 .. $#in) {
$in[$i] =~ s/\+/ /g;  
($key, $val) = split(/=/,$in[$i],2); # splits on the first =.
$key =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$val =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$in{$key} .= "\0" if (defined($in{$key})); # \0 is the multiple separator
$in{$key} .= $val;
}
} elsif ($ENV{'CONTENT_TYPE'} =~ m#^multipart/form-data#) {
$errflag = !(eval <<'END_MULTIPART');
local ($buf, $boundary, $head, @heads, $cd, $ct, $fname, $ctype, $blen);
local ($bpos, $lpos, $left, $amt, $fn, $ser);
local ($bufsize, $maxbound, $writefiles) = ($cgi_lib'bufsize, $cgi_lib'maxbound, $cgi_lib'writefiles);
$buf = ''; 
($boundary) = $type =~ /boundary="([^"]+)"/; #";   # find boundary
($boundary) = $type =~ /boundary=(\S+)/ unless $boundary;
&CgiDie ("Boundary not provided") unless $boundary;
$boundary =  "--" . $boundary;
$blen = length ($boundary);
if ($ENV{'REQUEST_METHOD'} ne 'POST') {
&CgiDie("Invalid request method for  multipart/form-data: $meth\n");
}
if ($writefiles) {local($me);stat (
$writefiles);
$writefiles = "/tmp" unless  -d _ && -r _ && -w _;
# ($me) = $0 =~ m#([^/]*)$#;
$writefiles .= "/$cgi_lib'filepre"; 
}
$left = $len;
PART: # find each part of the multi-part while reading data
while (1) {
last PART if $errflag;
$amt = ($left > $bufsize+$maxbound-length($buf) 
?  $bufsize+$maxbound-length($buf): $left);
$errflag = (read(STDIN, $buf, $amt, length($buf)) != $amt);
$left -= $amt;
$in{$name} .= "\0" if defined $in{$name}; 
$in{$name} .= $fn if $fn;
$name=~/([-\w]+)/;  # This allows $insfn{$name} to be untainted
if (defined $1) {$insfn{$1} .= "\0" if defined $insfn{$1}; 
$insfn{$1} .= $fn if $fn;
}
BODY: 
while (($bpos = index($buf, $boundary)) == -1) {
if ($name) {  # if no $name, then it's the prologue -- discard 
if ($fn) { print FILE substr($buf, 0, $bufsize); }
else     { $in{$name} .= substr($buf, 0, $bufsize); }
}
$buf = substr($buf, $bufsize);
$amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
$errflag = (read(STDIN, $buf, $amt, $maxbound) != $amt);  
$left -= $amt;
}
if (defined $name) {  # if no $name, then it's the prologue -- discard
if ($fn) { print FILE substr($buf, 0, $bpos-2); }
else     { $in {$name} .= substr($buf, 0, $bpos-2); } # kill last \r\n
}
close (FILE);
last PART if substr($buf, $bpos + $blen, 4) eq "--\r\n";
substr($buf, 0, $bpos+$blen+2) = '';
$amt = ($left > $bufsize+$maxbound-length($buf) 
? $bufsize+$maxbound-length($buf) : $left);
$errflag = (read(STDIN, $buf, $amt, length($buf)) != $amt);
$left -= $amt;
undef $head;  undef $fn;
HEAD:
while (($lpos = index($buf, "\r\n\r\n")) == -1) { 
$head .= substr($buf, 0, $bufsize);
$buf = substr($buf, $bufsize);
$amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
$errflag = (read(STDIN, $buf, $amt, $maxbound) != $amt);  
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
$incfn{$name} .= (defined $in{$name} ? "\0" : "") . $fname;
($ctype) = $ct =~ /^\s*Content-type:\s*"([^"]+)"/i;  #";
($ctype) = $ct =~ /^\s*Content-Type:\s*([^\s:;]+)/i unless defined $ctype;
$inct{$name} .= (defined $in{$name} ? "\0" : "") . $ctype;
if ($writefiles && defined $fname) {
$ser++;
$fn = $writefiles . ".$$.$ser";
open (FILE, ">$fn") || &CgiDie("Couldn't open $fn\n");
}
substr($buf, 0, $lpos+4) = '';
undef $fname;
undef $ctype;
}
1;
END_MULTIPART
&CgiDie($@) if $errflag;
} else {
&CgiDie("cgi-lib.pl: Unknown Content-type: $ENV{'CONTENT_TYPE'}\n");
}
$^W = $perlwarn;
return ($errflag ? undef :  scalar(@in)); 
}
sub PrintHeader {
return "Content-type: text/html\n\n";
}
sub htmlTop
{
local ($title) = @_;
return <<END_OF_TEXT;
<HTML>
<head>
<title>$title</title>
</head>
<body>
<h1>$title</h1>
END_OF_TEXT
}
sub htmlBot
{
return "</body>\n</HTML>\n";
}
sub SplitParam
{
local ($param) = @_;
local (@params) = split ("\0", $param);
return (wantarray ? @params : $params[0]);
}
sub MethGet {
return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "GET");
}
sub MethPost {
return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "POST");
}
sub MyBaseUrl {
local ($ret, $perlwarn);
$perlwarn = $^W; $^W = 0;
$ret = 'http://' . $ENV{'SERVER_NAME'} .  
($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
$ENV{'SCRIPT_NAME'};
$^W = $perlwarn;
return $ret;
}
sub MyFullUrl {
local ($ret, $perlwarn);
$perlwarn = $^W; $^W = 0;
$ret = 'http://' . $ENV{'SERVER_NAME'} .  
($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
$ENV{'SCRIPT_NAME'} . $ENV{'PATH_INFO'} .
(length ($ENV{'QUERY_STRING'}) ? "?$ENV{'QUERY_STRING'}" : '');
$^W = $perlwarn;
return $ret;
}
sub MyURL  {
return &MyBaseUrl;
}
sub CgiError {
local (@msg) = @_;
local ($i,$name);
if (!@msg) {
$name = &MyFullUrl;
@msg = ("Error: script $name encountered fatal error\n");
};
if (!$cgi_lib'headerout) { #')
print &PrintHeader;	
print "<HTML>\n<head>\n<title>$msg[0]</title>\n</head>\n<body>\n";
}
print "<h1>$msg[0]</h1>\n";
foreach $i (1 .. $#msg) {
print "<p>$msg[$i]</p>\n";
}
$cgi_lib'headerout++;
}
sub CgiDie {
local (@msg) = @_;
&CgiError (@msg);
die @msg;
}
sub PrintVariables {
local (*in) = @_ if @_ == 1;
local (%in) = @_ if @_ > 1;
local ($out, $key, $output);
$output =  "\n<dl compact>\n";
foreach $key (sort keys(%in)) {
foreach (split("\0", $in{$key})) {
($out = $_) =~ s/\n/<br>\n/g;
$output .=  "<dt><b>$key</b>\n <dd>:<i>$out</i>:<br>\n";
}
}
$output .=  "</dl>\n";
return $output;
}
sub PrintEnv {
&PrintVariables(*ENV);
}
$cgi_lib'writefiles =  $cgi_lib'writefiles;
$cgi_lib'bufsize    =  $cgi_lib'bufsize ;
$cgi_lib'maxbound   =  $cgi_lib'maxbound;
$cgi_lib'version    =  $cgi_lib'version;
1; #return true 
$datafile = "../db/db.file";
&ReadParse($in, $in_name, $in_type, $in_server_name);
print "Content-type: text/html\n\n";
&open_product_screen;
if ($in{'add'} ne "") 
{
&add_product_screen;
exit;
}
if ($in{'edit'} ne "") 
{
&edit_product_screen;
exit;
}
if ($in{'delete'} ne "") 
{
&delete_product_screen;
exit;
}
if ($in{'AddProduct'} ne "")
{
&action_add_product;
exit;
}
if ($in{'EditProduct'} ne "")
{
&action_edit_product;
exit;
}
if ($in{'SubmitEditProduct'} ne "")
{
&action_submit_edit_product;
exit;
}
if ($in{'DeleteProduct'} ne "")
{
&action_delete_product;
exit;
}

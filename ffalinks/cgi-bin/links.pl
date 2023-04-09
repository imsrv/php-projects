#!/usr/bin/perl
#########################################################################
#  Free For All Link Page v1.2                                          #
#  Copyright (c)2000 Chi Kien Uong                                      #
#  URL: http://www.proxy2.de                                            #
#                                                                       #
# This Software is distributed under the GNU General Public             #
# License. For more details see license.txt                             #
#                                                                       #
# Administration:                                                       #
# http://www.host.com/cgi-bin/links.pl?admin=enter                      #
#                                                                       #
# If you are having problems with the script, visit the support         #
# forum at: http://www.proxy2.de                                        #
#########################################################################

# url of script
$cgiurl = "http://localhost/cgi-bin/links.pl";

# base url to all link files without trailing "/"
$link_url = "http://localhost/links";

# base directory to all link files from the server root without trailing "/"
$base_dir = "/home/usr/you/links";

# default index page of your choice
$index_url = "http://localhost/links/ffa-business.html";

# counter log file
$id_count = "links_id.txt";

# administration password
$admin_pass = "123";

# time to redirect to link page after entry (sec)
$redirect_sec = "3";

# use file locking; ($lock=0 for Win32)
$lock = 1;

# time offset - add one hour = +1 ; subtract one hour = -1
$fix_time  = 0;

# image
$imageurl = "arrow.gif";

# End setup
############################################

&parse_form;

if ($FORM{'add'} eq "new") {	

	&check_input;	
	&add_entry;
	&error("Cannot add entry to link page because the comment <br>&lt!--$FORM{'category'} --&gt was not found in ffa-$FORM{'category'}\.html") if ($succes != 1);
	&success;
}
elsif ($FORM{'admin'} eq "enter") {

	&validation;
}
elsif ($FORM{'action'} eq "delete") {

	if ($FORM{'admin'} eq $admin_pass) {
		
		if ($FORM{'entry'} =~ /^\d+/) {
			&delete_entry;
			&show_entries;
		}
		else {
			&error('Wrong Entry ID!');
		}
	}
	else {
		&error('You entered a wrong password!');
	}
}
elsif ($FORM{'action'} eq "show") {
	if ($FORM{'admin'} eq $admin_pass) {
		&show_entries;
	}
	else {
		&error('You entered a wrong password!');
	}
}
else {
	&error('No Valid Command!');
}

sub parse_form {
	
if ($ENV{'REQUEST_METHOD'} eq "GET") {
        $buffer = $ENV{'QUERY_STRING'};
}
else {
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
}
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$name =~ tr/+/ /;
	$name =~ s/%([a-f0-9]{2})/pack("C", hex($1))/egi;
	$value =~ tr/+/ /;
	$value =~ s/%([a-f0-9]{2})/pack("C", hex($1))/egi;
	$value =~ s/<!--(.|\n)*-->//g;
	$value =~ s/<([^>]|\n)*>//g;
	$value =~ s/^\s+|\s*\n$//g;
	$value =~ s/\&/\&amp\;/g;
	$value =~ s/\"/\&quot\;/g;
	$value =~ s/ +/ /g;
	$FORM{$name} = $value;
}
}

sub check_input {
	
	if ($FORM{'url'} !~ /^http:\/\/[._a-z0-9-]+\.[._a-z0-9-]+/i) { 
   		&error('The <u>URL</u> seems not to be valid. Please correct it and re-submit!');
	}
	if ($FORM{'title'} !~ /\S/) {
   		&error('You forgot to enter a title. Please correct it and re-submit!');
	}
	if ($FORM{'descript'} !~ /\S/) {
   		&error('You forgot to enter a short description!');
	}
	if ($FORM{'category'} eq "") {
   		&error('You forgot to choose a valid category. Please correct it and re-submit!');
	}
}

sub add_entry {
my ($entry_id,@lines);
if (-e "$base_dir/$id_count") {
	open (COUNTER,"+<$base_dir/$id_count") || &error("Cannot open ID file $id_count in $base_dir for writing!");
	$entry_id = <COUNTER>;
}
else {	
	open (COUNTER,">$base_dir/$id_count") || &error("Cannot create ID file $id_count in $base_dir. Please check your base directory.","fatal");
	$entry_id =1;
}
close(COUNTER);

if (-e "$base_dir/ffa-$FORM{'category'}\.html") {
	open (FILE,"+<$base_dir/ffa-$FORM{'category'}\.html") || &error("Cannot open ffa-$FORM{'category'}\.html in $base_dir for writing!");
	@lines = <FILE>;
	close(FILE);
}
else {
	&error("The page ffa-$FORM{'category'}\.html does not exist in $base_dir.");
}
$FORM{'descript'} =~ s/\cM\n/<br>\n/g;
$this_day = &get_time($this_day); 

open (PAGE,">$base_dir/ffa-$FORM{'category'}\.html") || &error("The directory $base_dir requires mode 777!");
flock(PAGE,2) if ($lock == 1);
foreach $line (@lines) {
	if ($line =~ /^.*<!--$FORM{'category'} -->.*/) {
		($part1, $part2) = split(/<!--$FORM{'category'} -->\s*/,$line);
		print PAGE "$part1";
		print PAGE "<!--$FORM{'category'} -->\n";
		print PAGE "<!--top-ID=$entry_id -->\n";
		print PAGE "<img src=\"$imageurl\"><a href=\"$FORM{'url'}\" target=\"_blank\"><font size=\"2\">$FORM{'title'}</font></a><br>\n";
		print PAGE "<font size=\"2\">$FORM{'descript'}</font><br>\n";
		print PAGE "<font size=\"1\">$FORM{'url'} added on: $this_day</font><br><br>\n";
		print PAGE "<!--end-ID=$entry_id -->\n";
		print PAGE "$part2";
		$succes = 1;
	} 
	else {
		print PAGE "$line";
	} 
}
close (PAGE);
if ($succes == 1) {
	open (COUNTER,">$base_dir/$id_count");
	flock(COUNTER,2) if ($lock == 1);
	$entry_id ++;
	print COUNTER "$entry_id";
	close(COUNTER);
}
}


sub get_time {
my ($min,$hour,$mday,$mon,$year,@month);
@months = ('January','February','March','April','May','June','July','August','September','October','November','December');
($min,$hour,$mday,$mon,$year) = (localtime(time+($fix_time*3600)))[1,2,3,4,5];
$min = "0$min" if ($min < 10);
$hour = "0$hour" if ($hour < 10);
$mday = "0$mday" if ($mday < 10);
$year += 1900;
return ("$mday-$months[$mon]-$year at $hour:$min");
}

sub validation {
	
	if ($FORM{'password'} eq $admin_pass) {
		$FORM{'page'} = "default";
		&show_entries;
	}
	elsif ($FORM{'password'} eq "") {
		&enterpass('Please enter a valid password!');
	} 
	else {
		&enterpass('<font color="#FF0000">You entered an invalid password. Please try again.</font>');
	}
}

sub show_entries {

my ($entry_num,$entry_tit,$found,$category,@filename,@foundlist);
unless (@lines >0) { 
	if ($FORM{'page'} !~ /^ffa-.*\.html/) {
		if ($FORM{'page'} ne "default") {
			&error("Page $FORM{'page'} does not exist in $base_dir.");
		}
	}
	else {
		open(FILE,"$base_dir/$FORM{'page'}");
	}
	@lines = <FILE>;
	close(FILE);
}
print "Content-type: text/html\n\n";
print <<Header;
<html>
<head>
<title>Administration</title>
<style type="text/css">
<!--
td {  font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<base href="$link_url/">
<script language="Javascript">
<!--
var found = 0;
function CheckForm() {
 if(document.ffa.admin.value == "") {
    alert("Please enter a password!");
    document.ffa.admin.focus();
    return false;
 }
 if(!(document.ffa.action.value == 'delete' || document.ffa.action.value == 'show')) {
    alert("Invalid command!");
    return false;
 }
 if(document.ffa.action.value == 'delete') {
   num = parseInt(document.ffa.entry.value);
   if (document.ffa.entry.value!=''+num) {
      alert("Please enter a valid Entry ID!");
      document.ffa.entry.focus();
      return false;
   }
 }
}
function SetValue(entry) {
 if (document.ffa.link.length) {
   for (i=0; i<document.ffa.link.length; i++) {
     if (document.ffa.link[i].checked == true) {
       found = document.ffa.link[i];
       break;
     }
   }
 }
 else {
   found = document.ffa.link;
 }
 document.ffa.url.value = found.value;
 document.ffa.entry.value = entry;
 document.ffa.action.value = 'delete';
}
function JumpTo(page) {
   document.ffa.page.value = page.menu.options[page.menu.selectedIndex].value;
   document.ffa.action.value = 'show';
   document.ffa.entry.value = "";
}
// -->
</script>
</head>
<body bgcolor="#DDDDDD">
<div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Administration</font></b> 
</div>
<form method="post" action="$cgiurl" name="ffa">
  <table width="97%" border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF" align="center">
    <tr bgcolor="#BFBFFF" align="right"> 
      <td colspan="2"> 
        <hr size="1">
        <table border="0" cellspacing="0" cellpadding="2" align="center">
          <tr> 
            <td colspan="2"><font size="1">Titel:<br>
              <input type="text" name="url" size="38"></font></td>
            <td><font size="1">Entry ID:</font><font size="1"><br>
              <input type="text" name="entry" size="6"></font></td>
            <td><font size="2"> 
              <input type="submit" value="Submit" onClick="return CheckForm();"></font></td>
            <td><font size="2"><input type="reset" value="Reset"></font></td>
          </tr>
          <tr> 
            <td><font size="1">Selected page:<br>
              <input type="text" name="page" value="$FORM{'page'}" size="25"></font></td>
            <td><font size="1">Action:<br>
              <input type="text" name="action" size="10"></font></td>
            <td><font size="1">Password:<br>
              <input type="password" name="admin" size="12"></font></td>
            <td colspan="2"><font size="1">Jump to page:<br>
Header
opendir(HOMEDIR, "$base_dir");
@filename = readdir(HOMEDIR);
closedir(HOMEDIR);
@foundlist = grep(/^ffa-.*\.html/, @filename);
print "        <select name=menu onChange=\"JumpTo(this.form)\">\n          <option value=\"default\" selected>Categories</option>\n";
foreach $option (@foundlist) {
	print "          <option value=\"$option\">$option</option>\n";
}
print "        </select>\n        </font></td>\n";
print "          </tr>\n        </table>\n        <hr size=\"1\">\n";
print "        <a href=\"$index_url\"><font size=\"2\">Back to Free Link Page</font></a></td>\n    </tr>\n";
if ($FORM{'page'} ne "default") {
$entry_num=0;
$found=0;
foreach $line (@lines) {
	if ($line =~ /^.*<!--top-ID=(\d+) -->.*/ && $found==0) {
		$entry_num = $1;
		($part1, $part2) = split(/<!--top-ID=$entry_num -->\s*/,$line);
		print "<tr><td>\n";
		print $part2 if($part2);
		$found=1;
		next;
	}
	elsif ($line =~ /^.*<!--end-ID=$entry_num -->.*/) {
		($part3, $part4) = split(/<!--end-ID=$entry_num -->\s*/,$line);
		print $part3 if($part3);
		print "</td>\n<td><input type=radio name=\"link\" value=\"$entry_tit\" onclick=\"SetValue('$entry_num');\"></td></tr>\n";
		if ($part4 =~ /<!--top-ID=(\d+) -->.*/) {
			$entry_num = $1;
			($part5,$part6) = split(/<!--top-ID=$entry_num -->\s*/,$part4);
			print "<tr><td>\n";
			print $part6 if($part6);
			$found=1;
			next;
		}
		$entry_num=0;
		$found=0;
		next;
	}
	elsif ($found==1) {
		if ($line =~ /[\d]\">(.*)<\/font><\/a>/) {
			$entry_tit = $1;
		}
		print $line;
	}
}
}
print "</table>\n</form>\<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=1>This script can be found at <a href=\"http://www.proxy2.de\" target=\"_blank\"><font color=\"#000000\">http://www.proxy2.de</font></a>\n";
print "  </font></div>\n</body>\n</html>\n";
exit(0);
}

sub delete_entry {

	my ($found);
	if ($FORM{'page'} !~ /^ffa-.*\.html/) {
		&error("The page $FORM{'page'} does not exist in $base_dir.");
	}
	else {
		open(FILE,"$base_dir/$FORM{'page'}");
	}
	@lines = <FILE>;
	close(FILE);
	$found=0;
	foreach $line (@lines) {
		if ($line =~ /^.*<!--top-ID=$FORM{'entry'} -->.*/) {
			($part1, $part2) = split(/<!--top-ID=$FORM{'entry'} -->\s*/,$line);
			if ($part1) {
				$line="$part1";
			}
			else {
				$line="";
			}
			$found=1;
			next;
		}
		elsif ($line =~ /^.*<!--end-ID=$FORM{'entry'} -->.*/) {
			($part3, $part4) = split(/<!--end-ID=$FORM{'entry'} -->\s*/,$line);
			if ($part4) {
				$line="$part4";
			}
			else {
				$line="";
			}
			last;
		}
		elsif ($found==1) {
			$line = "";
		}
	}
	if ($found==1) {
		open(FILE,">$base_dir/$FORM{'page'}");
		flock(FILE,2) if ($lock == 1);
		print FILE (@lines);
		close(FILE);
	}
}

sub error {
print "Content-type: text/html\n\n";
print <<ErrorHTM;
<html>
<head>
<title>Error</title>
<meta http-equiv="pragma" content="no-cache">
<style type="text/css">
<!--
td {  font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
<script language="JavaScript">
function goBack() {
	history.go(-1);
}
</script>
</head>
<body bgcolor="#dddddd" link="#003399">
<table width="640" border="0" cellspacing="0" align="center" height="260">
  <tr> 
    <td rowspan="6" bgcolor="#FFFFFF" width="16">&nbsp;</td>
    <td colspan="4" height="12" bgcolor="#FFFFFF">&nbsp;</td>
    <td rowspan="6" bgcolor="#FFFFFF" width="29">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="4" bgcolor="#E6E6FF" width="34">&nbsp;</td>
    <td rowspan="4" height="154" bgcolor="#FFFFFF" width="10">&nbsp;</td>
    <td width="365" bgcolor="#FFFFFF" height="60"><font size="4"><b>Free Link Page</b></font></td>
    <td width="174" bgcolor="#FFFFFF" align="right"><a href="$index_url"><font size="2">Return 
      to Free Link Page</font></a></td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF" height="15">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF"> 
      <p><font size="2">$_[0]</font></p>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF" colspan="2" height="90" align="center">
ErrorHTM
if ($_[1] eq "fatal") {
print "<br><table width=\"100%\" border=0 cellspacing=1 cellpadding=4 align=center bgcolor=\"#FFFFFF\">\n";
print "<tr bgcolor=\"#BCBCDE\">\n    <td colspan=\"2\"><b><font size=\"2\">Environment Variables</font></b></td>\n  </tr>\n";
foreach $key (sort keys %ENV) {
  print "  <tr>\n    <td bgcolor=\"#D1E0E0\"><font size=\"2\">$key</font></td>\n    <td bgcolor=\"#EFEFEF\"><font size=\"2\">$ENV{$key}&nbsp;</font></td>\n  </tr>\n";
}
print "</table><br>\n";
}
print "     <a href=\"javascript:goBack()\"><font size=\"2\">Back to submit form</font></a></td>\n  </tr>\n  <tr>\n";
print "    <td colspan=\"4\" bgcolor=\"#FFFFFF\" height=\"12\">&nbsp;</td>\n  </tr>\n</table>\n</body>\n</html>\n";
exit(0);
}

sub success {
print "Content-type: text/html\n\n";
print <<SuccessHTML ;
<html>
<head>
<title>Success</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="refresh" content="$redirect_sec;URL=$link_url/ffa-$FORM{'category'}\.html">
<style type="text/css">
<!--
td {  font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body bgcolor="#dddddd" link="#003399">
<table width="640" border="0" cellspacing="0" align="center" height="260">
  <tr> 
    <td rowspan="6" bgcolor="#FFFFFF" width="16">&nbsp;</td>
    <td colspan="4" height="12" bgcolor="#FFFFFF">&nbsp;</td>
    <td rowspan="6" bgcolor="#FFFFFF" width="29">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="4" bgcolor="#E6E6FF" width="34">&nbsp;</td>
    <td rowspan="4" height="154" bgcolor="#FFFFFF" width="10">&nbsp;</td>
    <td width="368" bgcolor="#FFFFFF" height="60"><font size="4"><b>Free Link Page</b></font></td>
    <td width="171" bgcolor="#FFFFFF"><a href="$index_url"><font size="2">Return 
      to Free Link Page</font></a></td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF" height="15">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF" height="100" valign="top"> <u><font size="2">Thanks 
      for adding a link.</font></u><font size="2"><br>
      <br>
      Your URL <font color="#990033">$FORM{'url'}</font> was added successfully!<br>
      You should be transfered back to the Link Page in $redirect_sec seconds.</font> </td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4" bgcolor="#FFFFFF" height="12">&nbsp;</td>
  </tr>
</table>
</body>
</html>
SuccessHTML
exit(0);
}

sub enterpass {
print "Content-type: text/html\n\n";
print <<ENTERHTML ;
<html>
<head>
<title>Administration</title>
</head>
<body bgcolor="#dddddd" link="#003399">
<table width="640" border="0" cellspacing="0" align="center" height="260">
  <tr> 
    <td rowspan="6" bgcolor="#FFFFFF" width="16">&nbsp;</td>
    <td colspan="4" height="12" bgcolor="#FFFFFF">&nbsp;</td>
    <td rowspan="6" bgcolor="#FFFFFF" width="29">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="4" bgcolor="#E6E6FF" width="34">&nbsp;</td>
    <td rowspan="4" height="154" bgcolor="#FFFFFF" width="10">&nbsp;</td>
    <td width="368" bgcolor="#FFFFFF" height="60"><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Free 
      Link Page</b></font></td>
    <td width="171" bgcolor="#FFFFFF"><a href="$index_url"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Return 
      to Free Link Page</font></a></td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF" height="15">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF" height="100" valign="top"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">$_[0]</font><font size="2"><br>
      <br>
      </font>
      <form method="post" action="$cgiurl">
        <input type="password" name="password" size="20">
        <input type="submit" name="Submit" value="Submit">
        <input type="hidden" name="admin" value="enter">
      </form>
    </td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4" bgcolor="#FFFFFF" height="12">&nbsp;</td>
  </tr>
</table>
</body>
</html>
ENTERHTML
exit(0);
}


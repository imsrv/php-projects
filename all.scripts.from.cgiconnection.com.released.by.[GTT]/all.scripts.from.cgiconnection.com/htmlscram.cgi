#!/usr/bin/perl
# HTML Scrambler
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

use LWP::Simple qw($ua getstore);

# Number of seconds to stop trying to retrieve page
$timeout = 10;

# Where to store temporary web page for processing
# Eg. /path/to/store/files
$save_dir = "!SAVEDIR!";

# Name of file to store information to
$filename = "html.txt";

# Default font value
$font = "Arial";

# Administrator username and password
$username = "!USERNAME!";
$password = "!PASSWORD!";

# Default text to show visitor
$default_text = "This web page is encrypted and password protected";

# Default height and width of window
$width = 800;
$height = 600;

############################################
# DO NOT EDIT BELOW THIS LINE
############################################

srand();
$rand_num = int(rand(1000000));
$ua->timeout($timeout);

&parse_form;
$max = $FORM{'max'};
$passwordn = $FORM{'passwordn'};
$area = $FORM{'area'};
$code = "\U$FORM{'code'}\E";

print "Content-type: text/html\n\n";

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 &check_login;
 &display_file;
 exit;
 }

if ($area eq "save")
 {
 &check_login;
 open(FILE, ">$save_dir\/$filename");

 for ($j = 0; $j < $max + 1; $j++)
  {
  $tempname = "url$j";
  $temppass = "pass$j";
  $tempdel = "del$j";
  $tempcode = "code$j";
  $tempmouse = "mouse$j";

  if ($FORM{$tempname} ne "" and "\L$FORM{$tempname}\E" ne "http://" and $FORM{$tempdel} eq "")
   {
   print FILE "$FORM{$temppass}\|$FORM{$tempname}\|\U$FORM{$tempcode}\E\|$FORM{$tempmouse}\n";
   }
   else
   {
   if ($FORM{$tempcode} ne "")
    {
    unlink("$save_dir\/logs\/scram$FORM{$tempcode}\.htmllog");
    }
   }
  }
 
 close(FILE);
 &display_file;
 exit;
 }

if ($area eq "logs")
 {
 &check_login;

 print "<HTML><TITLE>HTML Scrambler</TITLE><BODY>\n";

 if (not -e "$save_dir\/logs\/scram$code.htmllog")
  {
  print "There is no log file for code: $code\n";
  print "</BODY></HTML>\n";
  exit;
  }

 print "<CENTER><TABLE BORDER=1><FONT FACE=\"$font\">\n";
 print "<TR><TD><B>DATE</B></TD> <TD><B>TIME</B></TD> <TD><B>IP ADDRESS</B></TD> <TD><B>REFERRAL URL</B></TD></TR>\n";

 &lock("scram$code\.lock");
 open(LOG, "<$save_dir\/logs\/scram$code.htmllog");

 until(eof(LOG))
  {
  $line = <LOG>;
  chop($line);

  splice(@all_lines, 0);
  @all_lines = split(/\|/, $line);

  $templine = @all_lines[0];
  ($daten, $timen) = &date_info($templine);
  
  print "<TR><TD>$daten</TD> <TD>$timen</TD> <TD>@all_lines[1]</TD> <TD>@all_lines[2]</TD></TR>\n";
  }

 close(LOG);

 &unlock("scram$code\.lock");
 print "</TABLE></FONT></CENTER></BODY></HTML>\n";
 exit;
 }

if ($code eq "")
 {
 print "<HTML><BODY>You have specified an invalid code.</BODY></HTML>\n";
 exit;
 }

if ($passwordn eq "")
 {
 &show_main;
 exit;
 }

($max_val, $chosen) = &get_file($code);

if ($chosen == -1)
 {
 print "<HTML><BODY>You have specified an invalid code.</BODY></HTML>\n";
 exit;
 }

$temppass = @all_pass[$chosen];
$url = @all_urls[$chosen];

if ("\U$temppass\E" ne "\U$passwordn\E")
 {
 print "<HTML><BODY>Password incorrect.</BODY></HTML>\n";
 exit;
 }

&save_log($code);
$temp_name = "$save_dir\/page\.$rand_num$$";
getstore($url, "$temp_name");

$text = "<BASE HREF=\"$url\">";

&disable_right_mouse if @all_mouse[$chosen] eq "";

open(FILE, "<$temp_name");

until(eof(FILE))
 {
 $line = <FILE>;
 $text .= $line;
 }

close(FILE);
$result = &scramble_html($text);
unlink("$temp_name");

print "$result";

exit;

sub scramble_html
{
my ($text) = @_[0];
my ($all) = 0;

$text=~s/&amp;/&/g;
$text=~s/&gt;/&#062;/g;
$text=~s/&lt;/&#060;/g;

$text=~s/&auml;/ä/g;
$text=~s/&Auml;/Ä/g;
$text=~s/&ouml;/ö/g;
$text=~s/&Ouml;/Ö/g;
$text=~s/&uuml;/ü/g;
$text=~s/&Uuml;/Ü/g;
$text=~s/&szlig;/ß/g;

$text=~s/&agrave;/à/g;
$text=~s/&Agrave;/À/g;
$text=~s/&aacute;/á/g;
$text=~s/&Aacute;/Á/g;
$text=~s/&acirc;/â/g;
$text=~s/&Acirc;/Â/g;
$text=~s/&atilde;/ã/g;
$text=~s/&Atilde;/Ã/g;
$text=~s/&aring;/å/g;
$text=~s/&Aring;/Å/g;
$text=~s/&aelig;/æ/g;
$text=~s/&AElig;/Æ/g;

$text=~s/&egrave;/è/g;
$text=~s/&Egrave;/È/g;
$text=~s/&eacute;/é/g;
$text=~s/&Eacute;/É/g;
$text=~s/&Ecirc;/Ê/g;
$text=~s/&ecirc;/ê/g;
$text=~s/&euml;/ë/g;
$text=~s/&Euml;/Ë/g;

$text=~s/&igrave;/ì/g;
$text=~s/&Igrave;/Ì/g;
$text=~s/&iacute;/í/g;
$text=~s/&Iacute;/Í/g;
$text=~s/&icirc;/î/g;
$text=~s/&Icirc;/Î/g;
$text=~s/&iuml;/ï/g;
$text=~s/&Iuml;/Ï/g;

$text=~s/&ograve;/ò/g;
$text=~s/&Ograve;/Ò/g;
$text=~s/&oacute;/ó/g;
$text=~s/&Oacute;/Ó/g;
$text=~s/&ocirc;/ô/g;
$text=~s/&Ocirc;/Ô/g;
$text=~s/&otilde;/õ/g;
$text=~s/&Otilde;/Õ/g;
$text=~s/&oslash;/ø/g;
$text=~s/&Oslash;/Ø/g;

$text=~s/&Ugrave;/Ù/g;
$text=~s/&ugrave;/ù/g;
$text=~s/&Uacute;/Ú/g;
$text=~s/&uacute;/ú/g;
$text=~s/&Ucirc;/Û/g;
$text=~s/&ucirc;/û/g;

$text=~s/&Ntilde;/Ñ/g;
$text=~s/&ntilde;/ñ/g;

$text=~s/&Ccedil;/Ç/g;
$text=~s/&ccedil;/ç/g;

$text=~s/&yacute;/ý/g;
$text=~s/&yuml;/ÿ/g;

$text=~s/&ETH;/Ð/g;
$text=~s/&eth;/ð/g;
$text=~s/&THORN;/Þ/g;
$text=~s/&thorn;/þ/g;

$text=~s/&plusmn;/±/g;
$text=~s/&middot;/·/g;
$text=~s/&shy;/­/g;
$text=~s/&times;/×/g;
$text=~s/&divide;/÷/g;
$text=~s/&brvbar;/¦/g;
$text=~s/&not;/¬/g;

$text=~s/&iexcl;/¡/g;
$text=~s/&iquest;/¿/g;

$text=~s/&cent;/¢/g;
$text=~s/&pound;/£/g;
$text=~s/&curren;/¤/g;
$text=~s/&yen;/¥/g;

$text=~s/&sup1;/¹/g;
$text=~s/&sup2;/²/g;
$text=~s/&sup3;/³/g;
$text=~s/&frac14;/¼/g;
$text=~s/&frac12;/½/g;
$text=~s/&frac34;/¾/g;

$text=~s/&acute;/´/g;
$text=~s/&cedil;/¸/g;
$text=~s/&uml;/¨/g;
$text=~s/&macr;/¯/g;
$text=~s/&deg;/°/g;
$text=~s/&ordm;/º/g;
$text=~s/&ordf;/ª/g;

$text=~s/&para;/¶/g;
$text=~s/&sect;/§/g;
$text=~s/&micro;/µ/g;

$text=~s/&copy;/©/g;
$text=~s/&reg;/®/g;

$text=~s/&raquo;/»/g;
$text=~s/&laquo;/«/g;

$text=~s/([>;])(([^<>&;]|[^&]{3,7};|&[^;]{3,7})+)([&<])/$1.
    join('',map{if((!m!\s!) || $all){$_=sprintf("&#%03d;",ord$_);}
		else{ $_; }}split('',$2)).$4/gem;

$text=~s/(<[^<>]+=\")([^\"]+)(\"[^<>]*>)/$1.
    join('',map{$_=sprintf("&#%03d;",ord$_);}split('',$2)).$3/ges;

return ($text);
}

sub parse_form {

   if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
      # Split the name-value pairs
      @pairs = split(/&/, $ENV{'QUERY_STRING'});
   }
   elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
      # Get the input
      read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
 
      # Split the name-value pairs
      @pairs = split(/&/, $buffer);
   }
   else {
      &error('request_method');
   }

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
 
      $name =~ tr/+/ /;
      $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # If they try to include server side includes, erase them, so they
      # arent a security risk if the html gets returned.  Another 
      # security hole plugged up.

      $value =~ s/<!--(.|\n)*-->//g;
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name} && ($value)) {
          $FORM{$name} = "$FORM{$name}, $value";
	 }
         elsif ($value ne "") {
            $FORM{$name} = $value;
         }
  }
}


sub error
{
local($msg) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$msg</H2></CENTER>\n";
exit;
}

sub show_main
{
print <<END
<SCRIPT>
NS4 = (document.layers) ? true : false;

function Launch(pass)
{
var site = '$ENV{'SCRIPT_NAME'}?passwordn=' + pass + '&code=$code';
NewWindow = window.open(site,'HTMLScram','toolbar=no,scrollbars=yes,resizable=yes,width=$width,height=$height,left=0,top=0');
NewWindow.focus();
return false;
}

function checkEnter(event)
{ 	
	var code = 0;
	
	if (NS4)
		code = event.which;
	else
		code = event.keyCode;
	if (code==13)
                Launch(document.htmlscram.passwordn2.value);
}

</SCRIPT>
 
<HTML><BODY onKeyPress="checkEnter(event)";>
<CENTER>
<TITLE>HTML Scrambler</TITLE>
<FONT FACE="$font">

<TABLE BORDER=0>
<FORM METHOD=POST NAME=htmlscram ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=code VALUE="$code">
<INPUT TYPE=hidden NAME=passwordn VALUE="">
<TR><TD COLSPAN=2>$default_text</TD></TR>
<TR><TD COLSPAN=2><BR></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=passwordn2></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=button NAME=htscbut value="Go" onClick=Launch(document.htmlscram.passwordn2.value);></TD></TR>
</FORM>
</TABLE>

<BR>
Provide by <A HREF="http://www.cgiconnection.com">CGI Connection</A>

</FONT>
</CENTER>
</BODY></HTML>
END
}

sub login_screen
{

{
print<<END
<HTML>
<TITLE>HTML Scrambler</TITLE>
<BODY>
<CENTER>
<H2>HTML Scrambler</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub display_file
{
($max_val, $chosen) = &get_file;

print "<HTML><TITLE>HTML Scrambler</TITLE><BODY>\n";
print "<CENTER><FONT FACE=\"$font\"><H2>HTML Scrambler</H2>\n";

print "<TABLE BORDER=0>\n";
print "<TR><TD><B>Delete?</B></TD> <TD><B>URL</B></TD> <TD><B>Password</B></TD> <TD><B>Code</B></TD> <TD><B>Mouse</B></TD> <TD><B>Log</B></TD></TR>\n";

print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$max_val\">\n";

for ($j = 0; $j < $max_val; $j++)
 {
 $temp_pass = @all_pass[$j];
 $temp_url = @all_urls[$j];
 $temp_code = @all_code[$j];
 $temp_mouse = @all_mouse[$j];
 $stat_checked = "";

 if ($temp_mouse eq "Y")
  {
  $stat_checked = " CHECKED";
  }

 if ($temp_url eq "")
  {
  $temp_url = "http://";
  }

 print "<TR><TD><INPUT TYPE=CHECKBOX NAME=del$j VALUE=\"Y\"></TD> <TD><INPUT NAME=url$j VALUE=\"$temp_url\" SIZE=30></TD> <TD><INPUT NAME=pass$j VALUE=\"$temp_pass\" SIZE=30></TD> <TD><INPUT NAME=code$j VALUE=\"$temp_code\" SIZE=5></TD> <TD><INPUT TYPE=CHECKBOX NAME=mouse$j VALUE=\"Y\"$stat_checked></TD> <TD><A HREF=\"$ENV{'SCRIPT_NAME'}?area=logs&code=$temp_code&username=$FORM{'username'}&password=$FORM{'password'}\" target=_blank>View</A></TD></TR>\n";
 }

print "<TR><TD COLSPAN=3><INPUT TYPE=submit NAME=submit VALUE=\"Update\"></TD></TR>\n";
print "</FORM></TABLE></FONT></CENTER></BODY></HTML>\n";
}

sub check_login
{
if ($username ne $FORM{'username'})
 {
 print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";
 exit;
 }
}

sub get_file
{
my ($chosen) = @_[0];
my ($count) = 0;
my ($max_val) = 0;
my ($found) = -1;
splice(@all_lines, 0);
splice(@all_urls, 0);
splice(@all_pass, 0);
splice(@all_code, 0);
splice(@all_mouse, 0);

open(FILE, "<$save_dir\/$filename");

until (eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 if (@all_lines[0] ne "")
  {
  if ($chosen eq @all_lines[2])
   {
   $found = $count;
   }

  @all_pass[$count] = @all_lines[0];
  @all_urls[$count] = @all_lines[1];
  @all_code[$count] = @all_lines[2];
  @all_mouse[$count] = @all_lines[3];
  $count++;
  }
 }

close(FILE);

$max_val = @all_urls + 5;
return($max_val, $found);
}

sub disable_right_mouse
{
print<<END
<script language=JavaScript>

function clickIE4() {

if (event.button==2){
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("return false")
</script>
END
}

sub check_dir
{
my ($save_dir, $dir) = @_;
my ($backok);

if (not -e "$save_dir\/$dir")
 {
 $backok = mkdir("$save_dir\/$dir", 0777);

 if ($backok == 0)
  {
  print "Content-type: text/html\n\n";
  print "<SCRIPT>alert('$save_dir\/$dir could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -w "$save_dir\/$dir")
 {
 print "Content-type: text/html\n\n";
 print "<SCRIPT>alert('Cannot write to $save_dir\/$dir'); history.back(-1);</SCRIPT>";
 exit;
 }
}


sub save_log
{
my ($ip_address) = $ENV{'REMOTE_ADDR'};
my ($refer) = $ENV{'HTTP_REFERER'};
my ($code) = @_[0];
my ($counter) = 0;
my ($time_now) = time();

&check_dir($save_dir, "logs");

&lock("scram$code\.lock");
open(LOG, ">>$save_dir\/logs\/scram$code.htmllog");
print LOG "$time_now\|$ip_address\|$refer\n";
close(LOG);
&unlock("scram$code\.lock");
}

sub lock
{
my $lock_name = @_[0];
my $locks = "$save_dir\/";
my $lock_timer = 0;
my $lock_timer_stop = 0;
my $lock_passed = 0;
my (@lock_info);

while ($lock_timer_stop < 1)
 {
 for ($locka = 0; $locka < 10; $locka++)
  {
  if (not -e "$locks$lock_name")
   {
   $lock_timer_stop = 1;
   }
   else
   {
   $lock_timer_stop = 0;
   }
  }

 if ($lock_timer_stop == 1)
  {
  open (LOCKIT, ">$locks$lock_name");
  print LOCKIT "LOCKED\n";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info = stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @lock_info;

  $id_time = time() - $lm;

  if ($id_time > $idle_max and $lm > 0)
   {
   $lock_passed = 1;
   unlink ("$locks$lock_name");
   }

  select(undef,undef,undef,0.01);
  $lock_timer++;
  }
 }

}

sub unlock
{
my $locks = "$save_dir\/";
my $lock_name = @_[0];
unlink ("$locks$lock_name");
}

sub date_info
{
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(@_[0]);
my ($month);

   if ($sec < 10) {
   $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   $mon++;
   if ($mon < 10) {
   $month = "0$mon";
   }
   else
   {
   $month = "$mon";
   }

   if ($mday < 10)
   {
   $mday = "0$mday";
   }

$year += 1900;
return("$month\-$mday\-$year","$hour\:$min\:$sec");
}

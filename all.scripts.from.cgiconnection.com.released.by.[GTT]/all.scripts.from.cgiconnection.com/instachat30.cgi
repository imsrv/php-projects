#!/usr/bin/perl
#InstaChat 3.0
#Provided by CGI Connection
#http://www.CGIConnection.com
$| = 1;

srand();

#The entire URL to the instachat.cgi script on your server
#Eg. http://www.yourserver.com/cgi-bin/instachat30.cgi
$cgi_url = "http://!CGIURL!/instachat30.cgi";

#Temporary directory to store messages and user files (CHMOD directory to 777)
#Eg. /path/to/save/instachat30/
$tmp_dir = "!SAVEDIR!/";

############################################
# DO NOT EDIT BELOW THIS LINE
############################################

&parse_form;

$tmp_filename = $FORM{'filename'};
$rows = $FORM{'rows'};
$cols = $FORM{'cols'};
$width = $FORM{'width'};
$pop_width = $FORM{'popwidth'};
$pop_height = $FORM{'height'};
$maxlines = $FORM{'maxlines'};
$reload = $FORM{'reload'};
$background = $FORM{'background'};
$mode = $FORM{'mode'};
$area = $FORM{'area'};
$text = $FORM{'text'};
$username = $FORM{'username'};
$lasttime = $FORM{'time'};
$instname = $tmp_filename;

if ($tmp_filename eq "")
 {
 print "Content-type: text/html\n\n";
 print "document.write('You must supply a filename');\n";
 exit;
 }

if ($cols < 30)
 {
 $cols = 30;
 }

if ($rows < 5)
 {
 $rows = 5;
 }

if ($width < 250)
 {
 $width = 250;
 }

if ($pop_width < 450)
 {
 $pop_width = 450;
 }

if ($pop_height < 400)
 {
 $pop_height = 400;
 }

if ($reload < 5)
 {
 $reload = 5;
 }

if ($maxlines < 50)
 {
 $maxlines = 50;
 }

$reloadtime = $reload * 1000;
$locks = $tmp_dir;

if ($mode < 2)
 {
 $refreshmode = 0;
 }
 else
 {
 $refreshmode = 1;
 }

splice(@all_remote, 0);
@all_remote = split(/\./, "$ENV{'REMOTE_ADDR'}");
$filename = "@all_remote[0]@all_remote[1]@all_remote[2]";

if ($area eq "start")
 {
 if ($mode < 2)
  {
  print "Content-type: text/html\n\n";
  }
  else
  {
  $bound_line = "BOUNDARY$$";
  &check_browser;
  print "Content-type: multipart/mixed;boundary=\"$bound_line\"\n\n";

  if ($browser == 1)
   {
   print "\n--$bound_line\n";
   print "Content-type: text/html\n\n";
   }
  }

 &show_script;
 exit;
 }

if ($area eq "startpass") 
 {
 print "Content-type: text/html\n\n";
 &show_pass;
 exit;
 }

if ($area eq "say")
 {
 $nowtime = time();
 print "Content-type: text/html\n\n";

 $lock_name = "$tmp_filename\.chat";
 &lock;

 open(TEXT, ">>$tmp_dir$tmp_filename");
 print TEXT "$nowtime\|$username: $text\n";
 close(TEXT);

 splice(@all_lines, 0);
 open(TEXT, "<$tmp_dir$tmp_filename");
 @all_lines = <TEXT>;
 close(TEXT);

 if (@all_lines > $maxlines)
  {
  $x = @all_lines - $maxlines;

  open(TEXT, ">$tmp_dir$tmp_filename");

  for ($j = $x; $j < @all_lines; $j++)
   {
   print TEXT "@all_lines[$j]";
   }

  close(TEXT);
  }

 &unlock;

 if ($mode != 2)
  {
  &show_script;
  }
  else
  {
  print "<HTML><BODY><!--TEXT--></BODY></HTML>\n";
  }

 exit;
 }

if ($FORM{'url'} eq "")
 {
 $lock_name = "$filename\.chat";
 &lock;

 if (not -e "$tmp_dir$filename")
  {
  if ($mode == 0)
   {
   open(TMP, ">$tmp_dir$filename");
   close(TMP);

   print "Content-type: text/html\n\n";
   print "var framethere = '1';\n";
   print "for (var i=0;i<parent.frames.length;i++) {\n";
   print "if (parent.frames[i].name == 'setframespass') {\n";
   print "framethere = '2'; } }\n";
   print "location.href = '$cgi_url?area=' + framethere + '&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload&url=' + escape(location.href);\n";
   }
   else
   {
   print "Content-type: text/html\n\n";
   &show_popscript;
   }
  }
  else
  {
  unlink("$tmp_dir$filename");
  $guestrnd = int(rand(9999));
  $username = "Guest$guestrnd";

  print "Content-type: text/html\n\n";
  
  &chat_screen;
  print "// DONE\n";
  }

 &unlock;
 exit;
 }
 else
 {
 if ($mode == 0)
  {
  if ($area eq "1")
   {
   print "Content-type: text/html\n\n";
   &print_frames;
   }
   else
   {
   print "Location: $FORM{'url'}\n\n";
   }
  }
  else
  {
  unlink("$tmp_dir$filename");
  $guestrnd = int(rand(9999));
  $username = "Guest$guestrnd";

  print "Content-type: text/html\n\n";
  &print_frames2;
  }

 exit;
 }

exit;

sub print_frames
{
print <<END
<FRAMESET ROWS=*,0 FRAMEBORDER=0 FRAMESPACING=0 BORDER=0>
<FRAME NAME="setframes" SRC="$FORM{'url'}">
<FRAME NAME="setframespass" SRC="">
</FRAMESET>
END
}

sub print_frames2
{
print <<END
<HTML>
<TITLE>InstaChat 3.0</TITLE>

<FRAMESET ROWS=*,60,0 FRAMEBORDER=1 FRAMESPACING=0 BORDER=0>
<FRAME NAME="setframes" SRC="$cgi_url?area=start&url=1&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload">
<FRAME NAME="setframespass" SRC="$cgi_url?area=startpass&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload">
<FRAME NAME="realtime" SRC="">
</FRAMESET>

</BODY>
</HTML>
END
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


      # Remove HTML Tags

      $allow_html = 1;
      if ($allow_html == 0)
       {
       $value =~ s/<([^>]|\n)*>//g;
       }
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name} && ($value)) {
          $FORM{$name} = "$FORM{$name} \|\| $value";
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

sub chat_screen
{
print<<END
var reltime = $reloadtime;
var closeChat = 0;
var e;

if (document.layers)
 {
 document.captureEvents(Event.KEYPRESS);
 window.onkeypress = keyhandler;
 }

function keyhandler(e)
 {
 var event = e ? e : window.event;
 if (event.keyCode == 13)
  {
  if (document.all)
   {
   document.chatform.submit.click();
   }
   else
   {
   document.layers['chatscreen'].document.chatform.submit.click();
   }
  }
 }

function close_Chat() {

if (document.layers)
 {
 document.layers.chatscreen.visibility = "hidden";
 }
 else if (document.all)
 {
 document.all.chatscreen.style.visibility = "hidden";
 }
 else if (document.getElementById)
 {
 document.getElementById("chatscreen").style.visibility = "hidden";
 }

closeChat = 1;
}

function reload_Page() {

if (document.layers)
 {
 var newtime = document.layers['chatscreen'].document.chatform.time.value;
 }
 else if (document.all)
 {
 var newtime = document.chatform.time.value;
 }
 else if (document.getElementById)
 {
 var newtime = document.chatform.time.value;
 }

if (closeChat == 0)
 {
 parent.setframespass.location.href = "$cgi_url?area=start&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload&time=" + newtime;
 setTimeout("reload_Page()",reltime);
 }
}

function showChat() {

if (document.layers)
 {
 document.layers.chatscreen.top = pageYOffset;
 document.chatscreen.left = window.innerWidth - $width - 40;
 }
 else if (document.all)
 {
 document.all.chatscreen.style.posLeft = document.body.clientWidth - $width - 30;
 document.all.chatscreen.style.top = document.body.scrollTop;
 }
 else if (document.getElementById)
 {
 document.getElementById("chatscreen").style.left = window.innerWidth - $width - 40;
 document.getElementById("chatscreen").style.top = document.body.scrollTop;
 }
 
setTimeout("showChat()",100);
}

function submitIt() {

if (document.layers)
 {
 var newtext = document.layers['chatscreen'].document.chatform.chatinput.value;
 document.layers['chatscreen'].document.chatform.chatinput.value = "";
 }
 else if (document.all)
 {
 var newtext = document.chatform.chatinput.value;
 document.chatform.chatinput.value = "";
 }
 else if (document.getElementById)
 {
 var newtext = document.chatform.chatinput.value;
 document.chatform.chatinput.value = "";
 }
 
if (newtext != '')
 {
 parent.setframespass.location.href = "$cgi_url?area=say&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload&text=" + escape(newtext);
 }
}

if (document.layers)
 {
 document.writeln('<layer name="chatscreen" z-index="90" left="0" top="0" visibility="visible">');
 }
 else if (document.all)
 {
 document.writeln('<div id="chatscreen" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;">');
 }
 else if (document.getElementById)
 {
 document.writeln('<div id="chatscreen" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;">');
 }

document.writeln('<FORM METHOD=POST NAME="chatform" ACTION="">');
document.writeln('<INPUT TYPE=HIDDEN NAME=time>');
document.writeln('<TABLE BORDER=1 WIDTH=$width BGCOLOR=$background CELLPADDING=0 CELLSPACING=0>');
document.writeln('<TR><TD><CENTER><B>InstaChat 3.0 (You are $username)</B></CENTER></TD></TR>');
document.writeln('<TR><TD><CENTER><TEXTAREA NAME="chattext" ROWS=$rows COLS=$cols></TEXTAREA></CENTER></TD></TR>');
document.writeln('<TR><TD><B>Say:</B> <INPUT NAME="chatinput" onKeyPress="keyhandler(e)"></TD></TR>');
document.writeln('<TR><TD><INPUT TYPE=button NAME=submit VALUE="Say It" onClick="submitIt();"> <B>Users Online:</B> <INPUT NAME=online SIZE=3> <A HREF="javascript:onClick=close_Chat();">Close</A></TD></TR>');
document.writeln('</TABLE>');
document.writeln('</FORM>');

if (document.layers)
 {
 document.writeln('</layer>');
 }
 else if (document.all)
 {
 document.writeln('</div>');
 }
 else if (document.getElementById)
 {
 document.writeln('</div>');
 }

showChat();
setTimeout("reload_Page()",100);
END
}

sub check_users
{
$online = 0;
$lines = "";
splice(@all_lines, 0);

opendir(ONLINE, "$tmp_dir");
@tmpon = readdir(ONLINE);
closedir(ONLINE);

for ($x = 2; $x < @tmpon; $x++)
 {
 $tmpname = @tmpon[$x];

 $idx = rindex($tmpname, ".");

 if (substr($tmpname, $idx) eq ".$instname")
  {
  splice(@fileinfo, 0);
  @fileinfo=stat("$tmp_dir$tmpname");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks)=@fileinfo;

  $timepass = time() - $lm;

  if ($timepass <= 60)
   {
   $online++;
   }
   else
   {
   $tnow = time();
   unlink("$tmp_dir$tmpname");
   $tmpname2 = substr($tmpname, 0, $idx);

   $lock_name = "$tmp_filename\.chat";
   &lock;

   open(TEXT, ">>$tmp_dir$tmp_filename");
   print TEXT "$tnow\|$tmpname2 has logged off\n";
   close(TEXT);

   &unlock;
   }
  }

 }

$lock_name = "$tmp_filename\.chat";
&lock;

if ($username ne "")
 {
 $tnow = time();

 if (not -e "$tmp_dir$username\.$instname")
  {
  open(TEXT, ">>$tmp_dir$tmp_filename");
  print TEXT "$tnow\|$username has logged on\n";
  close(TEXT);

  $online++;
  }

 open(TEXT, ">$tmp_dir$username\.$instname");
 print TEXT "$tnow\n";
 close(TEXT);
 }

open(TEXT, "<$tmp_dir$tmp_filename");
@all_lines = <TEXT>;
close(TEXT);

&unlock;
}

sub check_lines
{
for ($x = 0; $x < @all_lines; $x++)
 {
 $line = @all_lines[$x];

 splice(@cline, 0);
 @cline = split(/\|/, $line);
 $line = @cline[1];

 if ($mode == 0)
  {
  $line =~ s/\n/\\n/g;
  $line =~ s/\"/\\\"/g;
  }
  else
  {
  $line =~ s/\n/<BR>\n/g;
  }

 if ($line ne "")
  {
  $lines = "$line$lines";
  }
 }

&check_time;
}

sub check_lines_realtime
{
$lines = "";
$didit = 0;

for ($x = 0; $x < @all_lines; $x++)
 {
 $line = @all_lines[$x];

 splice(@cline, 0);
 @cline = split(/\|/, $line);

 if (@cline[0] > $last_check and @cline[0] > 0)
  {
  if ($mode == 0)
   {
   $line =~ s/\n/\\n/g;
   }
   else
   {
   $line =~ s/\n/<BR>\n/g;
   }

  if ($line ne "")
   {
   $didit = 1;
   $lines = "$lines@cline[1]<BR>";
   }
  }
 }

$last_check = @cline[0];

if ($last_check <= 0)
 {
 $last_check = time() - 1;
 }

&check_time;
}

sub check_time
{
splice(@more_info, 0);
@more_info=stat("$tmp_dir$tmp_filename");
($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @more_info;
}

sub show_script
{
&check_users;
&check_lines;

if ($mode == 0)
{
if ($lasttime ne $lm)
{
print <<END
<SCRIPT LANGUAGE="JavaScript">

if (document.layers)
 {
 parent.setframes.document.layers['chatscreen'].document.chatform.online.value = "$online";
 parent.setframes.document.layers['chatscreen'].document.chatform.chattext.value = "$lines";
 parent.setframes.document.layers['chatscreen'].document.chatform.time.value = "$lm";
 }
 else if (document.all)
 {
 parent.setframes.document.chatform.online.value = "$online";
 parent.setframes.document.chatform.chattext.value = "$lines";
 parent.setframes.document.chatform.time.value = "$lm";
 }
 else if (document.getElementById)
 {
 parent.setframes.document.chatform.online.value = "$online";
 parent.setframes.document.chatform.chattext.value = "$lines";
 parent.setframes.document.chatform.time.value = "$lm";
 }

</SCRIPT>
END
}
else
{
print<<END
<SCRIPT LANGUAGE="JavaScript">
// InstaChat 3.0
</SCRIPT>
END
}
}
else
{

############# MODE 1 (Refresh / Pop Up)

if ($mode == 1)
{
print<<END
<HTML>

<HEAD>
<SCRIPT LANGUAGE="JavaScript">
parent.setframespass.document.chatform.online.value = "$online";
parent.setframespass.document.chatform.text2.focus();
</SCRIPT>
</HEAD>

<BODY BGCOLOR="$background">
$lines
</BODY>
</HTML>
END
}
else
{

############# MODE 2 (Realtime / Pop Up)

$oldonline = -1;
$nowtime = 0;
print "<HTML><BODY BGCOLOR=\"$background\">\n";

for ($j = 0; $j < 50; $j++)
 {
 print "<!-- FORCE OUTPUT -->\n";
 }

until ($nowtime > 0)
 {
 if ($check_time != time())
  {
  $check_time = time();
  &check_users;
  &check_lines_realtime;

  if ($lines ne "")
   {
   print "$lines\n";
   }
   else
   {
   print "<!-- KEEP ALIVE $check_time -->\n";
   }

  print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";

  if ($oldonline != $online)
   {
   print "<SCRIPT LANGUAGE=\"JavaScript\">parent.setframespass.document.chatform.online.value = \"$online\";parent.setframespass.document.chatform.text2.focus();</SCRIPT>\n";
   $oldonline = $online;
   }
  }
 }

exit;
}

}

}

sub lock
{
$lock_timer = 0;
$lock_timer_stop = 0;
$lock_passed = 0;

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
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks)=@lock_info;

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
unlink ("$locks$lock_name");
}

sub show_pass
{

if ($refreshmode == 0)
 {
 $target = "setframes";
 }
 else
 {
 $target = "realtime";
 }

{
print<<END
<HTML>

<HEAD>
<SCRIPT>
var reltime = $reloadtime;
var refresh = $refreshmode;

function reload_Page()
 {
 parent.setframes.location.href = '$cgi_url?area=start&url=1&username=$username&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload';
 oldTime = setTimeout("reload_Page()",reltime);
 }

function submit_form()
 {
 document.chatform.text.value = document.chatform.text2.value;
 document.chatform.text2.value = "";
 document.chatform.text2.focus();

 if (refresh == 0)
  {
  // Refresh
  clearTimeout(oldTime);
  oldTime = setTimeout("reload_Page()",reltime);
  }
 }

if (refresh == 0)
 {
 oldTime = setTimeout("reload_Page()",reltime);
 }

</SCRIPT>
</HEAD>

<BODY BGCOLOR="$background">
<FORM METHOD=POST NAME="chatform" ACTION="$cgi_url" target="$target" onSubmit="return submit_form();">
<INPUT TYPE=HIDDEN NAME=time>
<INPUT TYPE=HIDDEN NAME=text VALUE="">
<INPUT TYPE=HIDDEN NAME=mode VALUE="$mode">
<INPUT TYPE=HIDDEN NAME=background VALUE="$background">
<INPUT TYPE=HIDDEN NAME=area VALUE="say">
<INPUT TYPE=HIDDEN NAME=filename VALUE="$tmp_filename">
<INPUT TYPE=HIDDEN NAME=username VALUE="$username">
<B>Say:</B> <INPUT NAME="text2"> <INPUT TYPE=submit NAME=submit VALUE="Say It"> <B>Users Online:</B> <INPUT NAME=online SIZE=3></FORM>

</BODY>
</HTML>
END
}

}

sub show_popscript
{

{
print<<END
document.onkeypress = function (evt) {
  var r = '';
  if (document.all) {
    r += event.shiftKey ? 'SHIFT' : '';
    r += event.keyCode;
  }
  else if (document.getElementById) {
    r += evt.shiftKey ? 'SHIFT' : '';
    r += evt.charCode;
  }
  else if (document.layers) {
    r += evt.modifiers & Event.SHIFT_MASK ? 'SHIFT' : '';
    r += evt.which;
  }

  if (r == 'SHIFT67' || r == '67')
   {
   var IChatWindow;
   window.open('$cgi_url?area=1&url=1&filename=$tmp_filename&mode=$mode&width=$width&height=$height&cols=$cols&rows=$rows&popwidth=$pop_width&popheight=$pop_height&max_lines=$maxlines&background=$background&reload=$reload',IChatWindow++,'width=$pop_width,height=$pop_height');
   }

  return true;
}

END
}
   
}

sub check_browser
{
$browser = 0;  #MSIE / AOL
if ($ENV{'HTTP_USER_AGENT'} =~ /Mozilla/i)
 {
 if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i and $ENV{'HTTP_USER_AGENT'} !~ /opera/i)
  {
  $browser = 1; #Netscape
  }
 }
}

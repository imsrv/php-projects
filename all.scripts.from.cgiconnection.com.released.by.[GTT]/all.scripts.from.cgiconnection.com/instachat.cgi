#!/usr/bin/perl
# InstaChat 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

srand();

#The entire URL to the instachat.cgi script on your server
#Eg. http://www.yourserver.com/cgi-bin/instachat.cgi
$cgi_url = "http://!CGIURL!/instachat.cgi";

#Temporary directory to store messages and user files CHMOD to 777
# Eg. /path/to/save/instachat/file/
$tmp_dir = "!TMPDIR!/";

#Filename used to store all chat messages
$tmp_filename = "text";

# Number of rows to display for chat messages
$rows = 5;

# Number of columns to display for chat messages
$cols = 30;

#Width of chat box in pixels
$width = 250;

#Max number of messages to show in chat window
$maxlines = 50;

#Reload messages every n seconds (1 - 60)
$reload = 5;

#Background of text message box
$background = "#FFFCCC";

# DO NOT EDIT BELOW THIS LINE
############################################

&parse_form;

$area = $FORM{'area'};
$text = $FORM{'text'};
$username = $FORM{'username'};
$lasttime = $FORM{'time'};

$reloadtime = $reload * 1000;
$locks = $tmp_dir;

splice(@all_remote, 0);
@all_remote = split(/\./, "$ENV{'REMOTE_ADDR'}");
$filename = "@all_remote[0]@all_remote[1]@all_remote[2]";

if ($area eq "start")
 {
 print "Content-type: text/html\n\n";
 &show_script;
 exit;
 }

if ($area eq "say")
 {
 print "Content-type: text/html\n\n";

 $lock_name = "$tmp_filename\.chat";
 &lock;

 open(TEXT, ">>$tmp_dir$tmp_filename");
 print TEXT "$username: $text\n";
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
 &show_script;
 exit;
 }

if ($FORM{'url'} eq "")
 {
 $lock_name = "$filename\.chat";
 &lock;

 if (not -e "$tmp_dir$filename")
  {
  open(TMP, ">$tmp_dir$filename");
  close(TMP);

  print "Content-type: text/html\n\n";
  print "var framethere = '1';\n";
  print "for (var i=0;i<parent.frames.length;i++) {\n";
  print "if (parent.frames[i].name == 'setframespass') {\n";
  print "framethere = '2'; } }\n";
  print "location.href = '$cgi_url?area=' + framethere + '&url=' + escape(location.href);\n";
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
 if ($area eq "1")
  {
  print "Content-type: text/html\n\n";
  &print_frames;
  }
  else
  {
  print "Location: $FORM{'url'}\n\n";
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

if (document.layers) document.captureEvents(Event.KEYPRESS);
window.onkeypress = keyhandler;
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

if (document.all)
 {
 document.all.chatscreen.style.visibility = "hidden";
 }
 else
 {
 document.layers.chatscreen.visibility = "hidden";
 }

closeChat = 1;
}

function reload_Page() {

if (document.all)
 {
 var newtime = document.chatform.time.value;
 }
 else
 {
 var newtime = document.layers['chatscreen'].document.chatform.time.value;
 }

if (closeChat == 0)
 {
 parent.setframespass.location.href = "$cgi_url?area=start&username=$username&time=" + newtime;
 setTimeout("reload_Page()",reltime);
 }
}

function showChat() {

if (document.all)
 {
 document.all.chatscreen.style.posLeft = document.body.clientWidth - $width - 30;
 document.all.chatscreen.style.top = document.body.scrollTop;
 }
 else
 {
 document.layers.chatscreen.top = pageYOffset;
 document.chatscreen.left = window.innerWidth - $width - 40;
 }

setTimeout("showChat()",100);
}

function submitIt() {

if (document.all)
 {
 var newtext = document.chatform.chatinput.value;
 document.chatform.chatinput.value = "";
 }
 else
 {
 var newtext = document.layers['chatscreen'].document.chatform.chatinput.value;
 document.layers['chatscreen'].document.chatform.chatinput.value = "";
 }

if (newtext != '')
 {
 parent.setframespass.location.href = "$cgi_url?area=say&username=$username&text=" + escape(newtext);
 }
}

if (document.all)
 {
 document.writeln('<div id="chatscreen" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;">');
 }
 else
 {
 document.writeln('<layer name="chatscreen" z-index="90" left="0" top="0" visibility="visible">');
 }

document.writeln('<FORM METHOD=POST NAME="chatform" ACTION="">');
document.writeln('<INPUT TYPE=HIDDEN NAME=time>');
document.writeln('<TABLE BORDER=1 WIDTH=$width BGCOLOR=$background CELLPADDING=0 CELLSPACING=0>');
document.writeln('<TR><TD><CENTER><B>InstaChat (You are $username)</B></CENTER></TD></TR>');
document.writeln('<TR><TD><TEXTAREA NAME="chattext" ROWS=$rows COLS=$cols></TEXTAREA></TD></TR>');
document.writeln('<TR><TD><B>Say:</B> <INPUT NAME="chatinput" onKeyPress="keyhandler(e)"></TD></TR>');
document.writeln('<TR><TD><INPUT TYPE=button NAME=submit VALUE="Say It" onClick="submitIt();"> <B>Users Online:</B> <INPUT NAME=online SIZE=3> <A HREF="javascript:onClick=close_Chat();">Close</A></TD></TR>');
document.writeln('</TABLE>');
document.writeln('</FORM>');

if (document.all)
 {
 document.writeln('</div>');
 }
 else
 {
 document.writeln('</layer>');
 }

showChat();
setTimeout("reload_Page()",100);
END
}

sub show_script
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

 if (substr($tmpname, $idx) eq ".inst")
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
   unlink("$tmp_dir$tmpname");
   $tmpname2 = substr($tmpname, 0, $idx);

   $lock_name = "$tmp_filename\.chat";
   &lock;

   open(TEXT, ">>$tmp_dir$tmp_filename");
   print TEXT "$tmpname2 has logged off\n";
   close(TEXT);

   &unlock;
   }
  }

 }

$lock_name = "$tmp_filename\.chat";
&lock;

if ($username ne "")
 {
 if (not -e "$tmp_dir$username\.inst")
  {
  open(TEXT, ">>$tmp_dir$tmp_filename");
  print TEXT "$username has logged on\n";
  close(TEXT);

  $online++;
  }

 $tnow = time();
 open(TEXT, ">$tmp_dir$username\.inst");
 print TEXT "$tnow\n";
 close(TEXT);
 }

open(TEXT, "<$tmp_dir$tmp_filename");
@all_lines = <TEXT>;
close(TEXT);

&unlock;

for ($x = 0; $x < @all_lines; $x++)
 {
 $line = @all_lines[$x];
 $line =~ s/\n/\\n/g;

 if ($line ne "")
  {
  $lines = "$line$lines";
  }
 }

splice(@more_info, 0);
@more_info=stat("$tmp_dir$tmp_filename");
($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @more_info;

if ($lasttime ne $lm)
{
print <<END
<SCRIPT LANGUAGE="JavaScript">

if (document.all)
 {
 parent.setframes.document.chatform.online.value = "$online";
 parent.setframes.document.chatform.chattext.value = "$lines";
 parent.setframes.document.chatform.time.value = "$lm";
 }
 else
 {
 parent.setframes.document.layers['chatscreen'].document.chatform.online.value = "$online";
 parent.setframes.document.layers['chatscreen'].document.chatform.chattext.value = "$lines";
 parent.setframes.document.layers['chatscreen'].document.chatform.time.value = "$lm";
 }

</SCRIPT>
END
}
else
{
print<<END
<SCRIPT LANGUAGE="JavaScript">
// InstaChat
</SCRIPT>
END
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
  print LOCKIT "LOCKED - $program\n";
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

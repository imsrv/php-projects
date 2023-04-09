#!/usr/bin/perl
# Vote Voice 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com

&parse_form;

# Height, Width and Color of Table Box
$width = 150;
$height = 100;
$bordercolor = "#000000";
$backgroundcolor = "#CCCCCC";

# Voting Options
# Eg. /path/to/store/votes
$vote_dir = "!SAVEDIR!";
$max_time = 86400; # Time, in seconds, until a user can vote again (86400 = 1 day)
$scale_start = 1;  # Start rating scale at this number
$scale_end = 10;   # End rating scale at this number
$thank_you = "Thank you for voting!";

# Box Functions
$box_title = "Rate This Page";
$box_info = "$scale_start is worst and $scale_end is best";
$blink_every = 10;   # Start blinking box every n seconds  (Set to 0 to turn off)
$blink_times = 5;    # Number of times to blink box
$blink_speed = 500;  # Milliseconds between each blink (1000 = 1 second)

# DO NOT EDIT BELOW THIS LINE
#########################################################

print "Content-type: text/html\n\n";

$script = $ENV{'SCRIPT_NAME'};

if ($FORM{'area'} eq "comments")
 {
 print "<HTML><BODY>\n";
 print "<CENTER><table width=500 border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0>\n";

 open(VOTE, "<$vote_dir\/$FORM{'filename'}");

 until(eof(VOTE))
  {
  $line = <VOTE>;
  chop($line);

  splice(@sline, 0);
  @sline = split(/\|/, $line);

  $tnow = localtime(@sline[1]);

  print "<TR><TD><B>IP Address:</B> @sline[0]<BR><B>Posted:</B> $tnow<BR><B>Rating:</B> @sline[2]<BR><BR><B>Comments:</B> @sline[3]</TD></TR>\n";
  }

 close(VOTE);

 print "</TABLE></CENTER></BODY></HTML>\n";
 exit;
 }

if ($FORM{'vote'} eq "")
 {
 &showRec;
 }
 else
 {
 open(VOTE, "<$vote_dir\/$FORM{'filename'}");

 until(eof(VOTE))
  {
  $line = <VOTE>;
  chop($line);

  splice(@sline, 0);
  @sline = split(/\|/, $line);

  if (@sline[0] eq $ENV{'REMOTE_ADDR'} and time() < (@sline[1] + $max_time))
   {
   $tnow = localtime((@sline[1] + $max_time));
   print "<SCRIPT>alert('You have already voted. You may vote again on $tnow.');history.back(-1);</SCRIPT>\n";
   close(VOTE);
   exit;
   }
  }

 close(VOTE);

 $timenow = time();
 open (RVOTE, ">>$vote_dir\/$FORM{'filename'}");
 print RVOTE "$ENV{'REMOTE_ADDR'}\|$timenow\|$FORM{'vote'}\|$FORM{'comments'}\n";
 close(RVOTE);

 print "<SCRIPT>alert('$thank_you');history.back(-1);</SCRIPT>\n";
 exit;
 }

exit;

sub showRec
{
open(VOTE, "<$vote_dir\/$FORM{'filename'}");

until (eof(VOTE))
 {
 $line = <VOTE>;
 chop($line);

 if ($line ne "")
  {
  splice(@sline, 0);
  @sline = split(/\|/, $line);
  $allvotes++;
  $orate2 = $orate2 + @sline[2];
  }
 }

close(VOTE);

if ($allvotes > 0)
 {
 $orate = $orate2 / $allvotes;
 $orate = sprintf "%.0f", $orate;
 }
 else
 {
 $orate = "0";
 $allvotes = "0";
 }

{
print<<END
var blinkEvery = $blink_every;
var blinkTimes = $blink_times;
var blinkSpeed = $blink_speed;
var votehtml = "";
var blinkCount = 0;
var blinkType = 0;
var didVis = 0;
var x = 0;
var vote_start = $scale_start;
var vote_end = $scale_end;

if (document.all)
 {
 document.write('<div id="votevoice" style="z-index:90;position:absolute;top:0;left:0;visibility:hidden;"></div>');
 }
 else
 {
 document.write('<layer name="votevoice" z-index="90" left="0" top="0" visibility="hide"></layer>');
 }

function askComments() {

if (document.all)
 {
 var vote_value = document.voteform.vote.selectedIndex;
 }
 else
 {
 var vote_value = document.layers['votevoice'].document.voteform.vote.selectedIndex;
 }

if (vote_value == 0)
 {
 return false;
 }

var comments = prompt ("If you would like to leave a comment, please do it here","");

if (document.all)
 {
 document.voteform.comments.value = comments;
 }
 else
 {
 document.layers['votevoice'].document.voteform.comments.value = comments;
 }
}

function pauseNow() {

if (blinkType == 0)
 {
 if (document.all)
  {
  document.all.votevoice.style.visibility = 'hidden';
  }
  else
  {
  document.layers.votevoice.visibility = 'hide';
  }

 blinkType = 1;
 }
 else
 {
 if (document.all)
  {
  document.all.votevoice.style.visibility = 'visible';
  }
  else
  {
  document.layers.votevoice.visibility = 'visible';
  }

 blinkType = 0;
 x++;
 }

if (x < blinkTimes)
 {
 setTimeout("pauseNow()", blinkSpeed);
 }
 else
 {
 x = 0;
 }

}

function oneTime() {

votehtml = '<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0>\\n<tr valign=top><td bgcolor=$backgroundcolor><center><B>$box_title</B><BR><BR>';
votehtml += 'Rated $allvotes times<BR>Overall Rating: $orate<BR><BR>';
votehtml += '<FORM NAME="voteform" METHOD=POST ACTION="$script"><FONT SIZE=-1>$box_info<BR><SELECT NAME=vote onChange=askComments();form.submit();>\\n';
votehtml += '<OPTION SELECTED>Vote Now';

for (var xx = vote_start; xx <= vote_end; xx++)
 {
 votehtml += '<OPTION>' + xx;
 }

votehtml += '</SELECT><INPUT TYPE=hidden NAME=filename VALUE="$FORM{'filename'}"><INPUT TYPE=hidden NAME=comments VALUE=""></FORM>';
votehtml += '<A HREF="$script?area=comments&filename=$FORM{'filename'}" target=_blank>View Comments</A></FONT>';
votehtml += '</CENTER></td></tr>\\n</table>\\n';

if (document.all)
 {
 votevoice.innerHTML = votehtml;
 }
 else
 {
 document.votevoice.document.write(votehtml);
 document.votevoice.document.close();
 }
}

function blinkBox() {

if (blinkCount >= blinkEvery)
 {
 blinkCount = 0;
 setTimeout("pauseNow()",100);
 }
 else
 {
 blinkCount++;
 }

setTimeout("blinkBox()",1000);
}

function showRec() {

if (document.all)
 {
 document.all.votevoice.style.posLeft = document.body.clientWidth - $width - 50;
 document.all.votevoice.style.top = document.body.scrollTop;

 if (didVis == 0)
  {
  document.all.votevoice.style.visibility = 'visible';
  didVis = 1;
  }
 }
 else
 {
 document.layers.votevoice.top = pageYOffset;
 document.votevoice.left = window.innerWidth - $width - 50;

 if (didVis == 0)
  {
  document.layers.votevoice.visibility = 'visible';
  didVis = 1;
  }
 }

setTimeout("showRec()",100);

}

setTimeout("oneTime()",1000);
setTimeout("showRec()",1000);

if (blinkEvery > 0)
 {
 setTimeout("blinkBox()",1000);
 }

END
}

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


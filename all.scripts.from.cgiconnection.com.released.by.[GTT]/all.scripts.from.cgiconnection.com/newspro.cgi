#!/usr/bin/perl
#News Flasher Pro
#Provided By CGI Connection
#http://www.CGIConnection.com

# Location of your news file
$news_location = "!SAVEDIR!/newsfilepro.txt";

# Mode: 0 = One liners / 1 = Heading, Short Description, and Link
$mode = 1;

# In mode 1, move box every n pixels until it reaches the side of screen
$step_val = 10;

# Height, Width and Color of Table
$width = 200;
$height = 150;
$bordercolor = "#000000";
$backgroundcolor = "#CCCCCC";

# Number of seconds to delay between headings
$speed = 30;

################################################
# DO NOT EDIT BELOW THIS LINE
################################################

print "Content-type: text/html\n\n";
&showscript;

exit;

sub showscript
{

{
print<<END
var myTimer;
var mode = $mode;
var speed = 1000 * $speed;
var move_val = 100;
var step_val = $step_val;
var temp_step = 0;
var x = 0;
var dispHead;
var dispLink;
var dispDescription;

if (document.layers)
 {
 document.write('<layer name="allheadings" z-index="90" left="0" top="0" visibility="visible"></layer>');
 }                            
 else if (document.all)
 {
 document.write('<div id="allheadings" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
 }
 else if (document.getElementById)
 {
 document.write('<div id="allheadings" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
 }

function moveit() {

  if (document.layers)
   {
   if (document.allheadings.left < (window.innerWidth - $width - 20))
    {
    document.allheadings.left += step_val;
    }

   if (document.allheadings.left > (window.innerWidth - $width - 20))
    {
    document.allheadings.left = window.innerWidth - $width - 20;
    }

   document.layers.allheadings.top = pageYOffset;
   setTimeout("moveit()",move_val);
   }
   else if (document.all)
   {
   if (document.all.allheadings.style.posLeft < (document.body.clientWidth - $width - 10))
    {
    document.all.allheadings.style.posLeft = document.all.allheadings.style.posLeft + step_val;
    }

   if (document.all.allheadings.style.posLeft > (document.body.clientWidth - $width - 10))
    {
    document.all.allheadings.style.posLeft = document.body.clientWidth - $width - 10;
    }

   document.all.allheadings.style.top = document.body.scrollTop;
   setTimeout("moveit()",move_val);
   }
   else if (document.getElementById)
   {
   temp_step = temp_step + step_val;

   if ((temp_step - $width) < (window.innerWidth - $width - 20))
    {
    document.getElementById("allheadings").style.left = window.pageXOffset - $width + temp_step;
    }
  
   if ((temp_step - $width) >= (window.innerWidth - $width - 20))
    {
    document.getElementById("allheadings").style.left = window.innerWidth - $width - 20;
    temp_step = window.innerWidth;
    }

   document.getElementById("allheadings").style.top = document.body.scrollTop;
   setTimeout("moveit()",move_val);
   }
  }

function initArray() 
 {
 this.length = initArray.arguments.length;

 for (var i = 0; i < this.length; i++)
  {
  this[i] = initArray.arguments[i];
  }
 }

function closeWindow() {

if (document.layers)
 {
 document.layers.allheadings.visibility = "hidden";
 }
 else if (document.all)
 {
 document.all.allheadings.style.visibility = "hidden";
 }
 else if (document.getElementById)
 {
 document.getElementById("allheadings").style.visibility = "hidden";
 }
}

function writeNews()
{
dispHead = headings[x];
dispLink = links[x];

if (mode == 1)
 {
 dispDescription = description[x];
 }

x++;

if (x == headings.length)
 {
 x = 0;
 }

if (document.layers)
 {
 if (mode == 0)
  {
  document.allheadings.document.write("<center><table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></td></tr></table></center>");
  document.allheadings.document.close();
  }
  else
  {
  document.allheadings.document.write("<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center><br><font size=-1>" + dispDescription + "</font><BR><BR><CENTER><FONT SIZE=-1>[ <a href=javascript:closeWindow();>Close</a> ] [ <a href=javascript:clearTimeout(myTimer);writeNews();>Next</a> ]</FONT></CENTER></td></tr></table>");
  document.allheadings.document.close();
  }
 }
 else if (document.all)
 {
 if (mode == 0)
  {
  allheadings.innerHTML = "<center><table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center></td></tr></table></center>";
  }
  else
  {
  allheadings.innerHTML = "<center><table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center><br><font size=-1>" + dispDescription + "</font><BR><BR><CENTER><FONT SIZE=-1>[ <a href=javascript:closeWindow();>Close</a> ] [ <a href=javascript:clearTimeout(myTimer);writeNews();>Next</a> ]</FONT></CENTER></td></tr></table></center>";
  }
 }
 else if (document.getElementById)
 {
 if (mode == 0)
  {
  newlayer = document.getElementById("allheadings");
  newlayer.innerHTML = "<center><table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center></td></tr></table></center>";
  }
  else
  {
  newlayer = document.getElementById("allheadings");
  newlayer.innerHTML = "<center><table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center><br><font size=-1>" + dispDescription + "</font><BR><BR><CENTER><FONT SIZE=-1>[ <a href=javascript:closeWindow();>Close</a> ] [ <a href=javascript:clearTimeout(myTimer);writeNews();>Next</a> ]</FONT></CENTER></td></tr></table></center>";
  }
 }

myTimer = setTimeout('writeNews();', speed);
}

setTimeout('moveit();', 1000);
END
}

$newline1 = "var headings = new initArray(";
$newline2 = "var links = new initArray(";
$newline3 = "var description = new initArray(";

open(NEWS, "<$news_location");

until(eof(NEWS))
 {
 $line = <NEWS>;
 chop($line);

 if ($line ne "")
  {
  splice(@nline, 0);
  @nline = split(/\|/, $line);

  $newline1 .= "\"@nline[0]\",";
  $newline2 .= "\"@nline[1]\",";

  if ($mode == 1)
   {
   $newline3 .= "\"@nline[2]\",";
   }
  }
 }

close(NEWS);

$newline1 = substr($newline1, 0, length($newline1) - 1);
$newline2 = substr($newline2, 0, length($newline2) - 1);
$newline3 = substr($newline3, 0, length($newline3) - 1);

$newline1 .= ");";
$newline2 .= ");";
$newline3 .= ");";

{
print<<END
$newline1

$newline2

$newline3

setTimeout("writeNews()",1000);

END
}

}


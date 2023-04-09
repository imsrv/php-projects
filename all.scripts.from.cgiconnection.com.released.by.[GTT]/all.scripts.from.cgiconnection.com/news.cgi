#!/usr/bin/perl
#News Flasher 1.0
#Provided by CGI Connection
#http://www.CGIConnection.com

$speed = 5; # Number of seconds to delay between headings
$bordercolor = "#000000";
$backgroundcolor = "#CCCCCC";

#Location to your news text file
#Eg. /path/to/newsfile.txt
$news_location = "!SAVEDIR!/newsfile.txt";

print "Content-type: text/html\n\n";

&showscript;

exit;

sub showscript
{

{
print<<END
var speed = 1000 * $speed;
var x = 0;
var dispHead;
var dispLink;

function initArray() 
 {
 this.length = initArray.arguments.length;

 for (var i = 0; i < this.length; i++)
  {
  this[i] = initArray.arguments[i];
  }
 }

if (document.all)
 {
 document.write('<div id="allheadings"></div>');
 }
 else
 {
 document.write('<layer name="allheadings"></layer><br><br>');
 }

function writeNews()
{
dispHead = headings[x];
dispLink = links[x];
x++;

if (x == headings.length)
 {
 x = 0;
 }

if (document.all)
 {
 allheadings.innerHTML = "<center><table width=400 border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center></td></tr></table></center>";
 }
 else
 {
 document.allheadings.document.write("<center><table width=400 border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr><td bgcolor=$backgroundcolor><center><a href=" + dispLink + ">" + dispHead + "</a></center></td></tr></table></center>");
 document.allheadings.document.close();
 }

setTimeout('writeNews();', speed);
}
END
}

$newline1 = "var headings = new initArray(";
$newline2 = "var links = new initArray(";

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
  }
 }

close(NEWS);

$newline1 = substr($newline1, 0, length($newline1) - 1);
$newline2 = substr($newline2, 0, length($newline2) - 1);

$newline1 .= ");";
$newline2 .= ");";

{
print<<END
$newline1

$newline2

setTimeout('writeNews();', 1000);
END
}

}


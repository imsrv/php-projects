#!/usr/bin/perl
# CGI Clock 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com

# Height, Width and Color of Table
$width = 100;
$height = 30;
$bordercolor = "#000000";
$backgroundcolor = "#CCCCCC";
$use_time = 0;  # 0 = Use user's local time, 1 = Use server's time

print "Content-type: text/html\n\n";

if ($use_time == 1)
 {
 &nowinfo;
 }

&showClock;

exit;

sub showClock
{

{
print<<END
var myClock = new Date();
var showTime;
var useTime = $use_time;
var nowHour = "$hour";
var nowMin = "$min";
var nowSec = "$sec";
var ext;

if (document.all)
 {
 document.write('<div id="cgiclock" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
 }
 else
 {
 document.write('<layer name="cgiclock" z-index="90" left="0" top="0" visibility="visible"></layer>');
 }

function showClock() {

if (useTime == 0)
 {
 myClock = new Date();

 nowHour = myClock.getHours();
 nowMin = myClock.getMinutes();
 nowSec = myClock.getSeconds();

 if (nowMin < 10)
  {
  nowMin = "0" + nowMin;
  }

 if (nowSec < 10)
  {
  nowSec = "0" + nowSec;
  }

 if (nowHour >= 12)
  {
  if (nowHour > 12)
   {
   nowHour = nowHour - 12;
   }

  ext = " PM";
  }
  else
  {
  ext = " AM";
  }

 if (nowHour < 10)
  {
  nowHour = "0" + nowHour;
  }

 showTime = nowHour + ":" + nowMin + ":" + nowSec + ext;
 }
 else
 {
 nowSec++;

 if (nowSec >= 60)
  {
  nowSec = 0;
  nowMin++;
  }

 if (nowMin >= 60)
  {
  nowMin = 0;
  nowHour++;
  }

 if (nowHour >= 24)
  {
  nowHour = 0;
  }

 if (nowMin < 10)
  {
  nowMin = "0" + nowMin;
  }

 if (nowSec < 10)
  {
  nowSec = "0" + nowSec;
  }

 if (nowHour >= 12)
  {
  if (nowHour > 12)
   {
   nowHour = nowHour - 12;
   }

  ext = " PM";
  }
  else
  {
  ext = " AM";
  }

 if (nowHour < 10)
  {
  nowHour = "0" + nowHour;
  }

 showTime = nowHour + ":" + nowMin + ":" + nowSec + ext;
 }

if (document.all)
 {
 cgiclock.innerHTML = "<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center>" + showTime + "</center></td></tr></table>";
 document.all.cgiclock.style.posLeft = document.body.clientWidth - $width - 10;
 document.all.cgiclock.style.top = document.body.scrollTop;
 }
 else
 {
 document.cgiclock.document.write("<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center>" + showTime + "</center></td></tr></table>");
 document.cgiclock.document.close();
 document.cgiclock.left = window.innerWidth - $width - 10;
 document.layers.cgiclock.top = pageYOffset;
 }

setTimeout("showClock()",1000);

}

setTimeout("showClock()",100);
END
}

}

sub nowinfo
{
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

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
$date_now = "$month\-$mday\-$year";
$time_now = "$hour\:$min\:$sec";
}

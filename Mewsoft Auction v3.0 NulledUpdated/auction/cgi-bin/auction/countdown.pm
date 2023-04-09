#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
sub Countdown_Ticker{
my $End_Time_Tr;
my $Out;

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_View_Item_File'});

	$Out=&Translate_File($Global{'Countdown_Ticker_Template'});

	&Get_Item($Param{'Item_ID'});

	# "Aug 28, 2001 1:29:00";
	$End_Time_Tr=&Long_Date_Time($Item_Info[0]{'End_Time'});
	#$End_Time=&Curent_Date_Time($Item_Info[0]{'End_Time'});

	$End_Time=($Item_Info[0]{'End_Time'}) * 1000;# end time in milliseconds
	$Out=~ s/<!--End_Time-->/$End_Time/g;

	$Out=~ s/<!--End_Time_Translated-->/$End_Time_Tr/g;
	$GMT_Offset = (3600 * $Global{'GMT_Offset'}) * 1000; # offset in milliseconds
	$Out=~ s/<!--GMT_OFFSET_SECONDS-->/$GMT_Offset/g;
	$Time=&Time(time);
	$Time=$Time * 1000;
	$Out=~ s/<!--SERVER_TIME-->/$Time/g;

	$Locat_Time=time;
	$Locat_Time=$Locat_Time * 1000;
	$Out=~ s/<!--LOCAL_TIME-->/$Locat_Time/g;
		
	$Out=~ s/<!--Item_Tile-->/$Item_Info[0]{'Title'}/g;
	$Out=~ s/<!--Item_ID-->/$Item_Info[0]{'Item_ID'}/g;

	$Plugins{'Body'}="";
	&Display($Out, 1);
}
#==========================================================
sub Countdown_Ticker_Form{
my ($End_Time, $End_Time_Tr, $Item_Tile)=@_;
my ($Out);

$Out=<<HTML;
<HEAD>
<SCRIPT>
<!-- hide script from old browsers

var txt_date="<!--End_Time-->"; //This is the End date
var event_date = new Date(txt_date);

 function toSt(n)
 {
 s=""
  if(n<10) s+="0"
  return s+n.toString();
 }
 
 function countdown()
 {cl=document.clock;
  d=new Date();
  count=Math.floor((event_date.getTime()-d.getTime())/1000);
  if(count<=0)
    {cl.days.value ="----";
     cl.hours.value="----";
     cl.mins.value="----";
     cl.secs.value="----";
     return;
    }
  cl.secs.value='  '+toSt(count%60);
  count=Math.floor(count/60);
  cl.mins.value='  '+toSt(count%60);
  count=Math.floor(count/60);
  cl.hours.value='  '+toSt(count%24);
  count=Math.floor(count/24);
  cl.days.value=toSt(count);    
  
  setTimeout("countdown()",1000);
 }
// end script -->
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
function showMilitaryTime() {
if (document.form_clock.showMilitary[0].checked) {
return true;
}
return false;
}
function showTheHours(theHour) {
if (showMilitaryTime() || (theHour > 0 && theHour < 13)) {
if (theHour == "0") theHour = 12;
return (theHour);
}
if (theHour == 0) {
return (12);
}
return (theHour-12);
}
function showZeroFilled(inValue) {
if (inValue > 9) {
return "" + inValue;
}
return "0" + inValue;
}
function showAmPm() {
if (showMilitaryTime()) {
return ("");
}
if (now.getHours() < 12) {
return (" AM");
}
return (" PM");
}
function showTheTime() {
now = new Date
document.form_clock.showTime.value = " "+showTheHours(now.getHours()) + ":" + showZeroFilled(now.getMinutes()) + ":" + showZeroFilled(now.getSeconds()) + showAmPm()
setTimeout("showTheTime()",1000)
}
// End -->
</script>
<title></title>
</HEAD>


<BODY  onLoad="countdown(); showTheTime();"  bgcolor="#E1E1C4">

<div align="center">
 <center>
<table cellspacing="0" cellpadding="0" >
<tr><td valign="middle" align="center" width="100%">

<!--Item_Tile-->

</td>
</tr>
</table>
</div>

<div align="center">
 <center>

<table border="2" background="$Global{'ImagesDir'}/backclk.gif" width="320" height="119" cellspacing="0" cellpadding="0" >
<tr><td valign="middle" align="center" width="100%">

<table border="0"  width="100%" height="119" cellspacing="0" cellpadding="0" >
<tr><td valign="middle" align="center" >

<FORM name="clock">
<CENTER>
<div align="center">
  <center>
<TABLE BORDER=0 CELLPADDING=0 width="100%" cellspacing="1" >
<TR>
<TD ALIGN=CENTER WIDTH="100%" colspan="4" height="24"><b><font color="#FF0000" size="4">
$Language{'ticker_title'}
</font></b></TD>
</TR>

<TR>
<TD ALIGN=CENTER WIDTH="25%" height="21"><B>$Language{'ticker_days'}</B></TD>
<TD ALIGN=CENTER WIDTH="25%" height="21"><B>$Language{'ticker_hours'}</B></TD>
<TD ALIGN=CENTER WIDTH="25%" height="21"><B>$Language{'ticker_minutes'}</B></TD>
<TD ALIGN=CENTER WIDTH="25%" height="21"><B>$Language{'ticker_secconds'}</B></TD>
</TR>

<TR>
<TD ALIGN=CENTER width="25%" height="25"><INPUT name="days" size=4></TD>
<TD ALIGN=CENTER width="25%" height="25"><INPUT name="hours" size=4></TD>
<TD ALIGN=CENTER width="25%" height="25"><INPUT name="mins" size=4></TD>
<TD ALIGN=CENTER width="25%" height="25"><INPUT name="secs" size=4></TD>
</TR>

<TR><TD COLSPAN="4" align="center" valign="middle" width="301">
<CENTER><FONT SIZE=2 color="#800000">
<br>
<b>
$Language{'ticker_ends'} <!--End_Time_Translated-->
</b>
</FONT></CENTER>
</TD></TR>

</TABLE></center>
</div>
  </CENTER>

</FORM>
</td></tr>

<tr><td valign="middle" align="center" width="295" height="13">
<center>
<form name=form_clock>
<b>
<font color="#008080">
$Language{'ticker_time_now'} <input type=text name=showTime size=11 >  $Language{'ticker_mode'}
<input type=radio name=showMilitary >24
<input type=radio name=showMilitary checked>12</font>
</b>
</form>
</center>
</td></tr>
</table>
</td></tr>
</table>
  </center>
</div>

</BODY>
HTML

	return $Out;
}
#==========================================================
1;
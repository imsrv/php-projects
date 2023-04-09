<HTML>
<HEAD><TITLE>E*Reminders - Email Event Reminders</TITLE></HEAD>
<BODY BGCOLOR="#000000">

<CENTER>

<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=1 WIDTH=75% BGCOLOR="#CCCCCC">
<FORM METHOD=POST ACTION="insertdata.php3?option=WRITE">

<!-- Top Bar of Table -->
<TR>
<TD ALIGN=CENTER BGCOLOR="#6677DD">
<FONT SIZE=+1 Face="arial,helvetica" COLOR="#FFFFFF">Event
</FONT></TD>
<TD ALIGN=CENTER BGCOLOR="#6677DD">
<FONT Face="arial,helvetica" COLOR="#FFFFFF">This page can be used to send yourself one-time or
recurring e-mail reminders of important events.  Click "Save" when you're done filling in the 
event details.  Each reminder will re-explain that it can be canceled at any time by revisiting 
this page, clicking Account Options, and then clicking List Pending Reminders.
</FONT></TD>
<TD ALIGN=CENTER BGCOLOR="#6677DD">
<FONT SIZE=+1 Face="arial,helvetica" COLOR="#FFFFFF">E*Reminder System
</FONT></TD>


<!-- Date -->
<TR><TD WIDTH="10%" ALIGN=center>
<B>Date</B>
</TD>
<TD WIDTH="50%">
<SELECT NAME=month>
<?php
$monthname=date("F");
$monthnum=date("m");
echo "<OPTION SELECTED VALUE=$monthnum>$monthname\n";
?>
<OPTION VALUE=01>January
<OPTION VALUE=02>February
<OPTION VALUE=03>March
<OPTION VALUE=04>April
<OPTION VALUE=05>May
<OPTION VALUE=06>June
<OPTION VALUE=07>July
<OPTION VALUE=08>August
<OPTION VALUE=09>September
<OPTION VALUE=10>October
<OPTION VALUE=11>November
<OPTION VALUE=12>December
</SELECT>

<SELECT NAME=cal_day>
<?php
$dayname=date("j");
$daynum=date("d");
echo "<OPTION SELECTED VALUE=$daynum>$dayname\n";
?>
<OPTION VALUE=01>1
<OPTION VALUE=02>2
<OPTION VALUE=03>3
<OPTION VALUE=04>4
<OPTION VALUE=05>5
<OPTION VALUE=06>6
<OPTION VALUE=07>7
<OPTION VALUE=08>8
<OPTION VALUE=09>9
<OPTION>10
<OPTION>11
<OPTION>12
<OPTION>13
<OPTION>14
<OPTION>15
<OPTION>16
<OPTION>17
<OPTION>18
<OPTION>19
<OPTION>20
<OPTION>21
<OPTION>22
<OPTION>23
<OPTION>24
<OPTION>25
<OPTION>26
<OPTION>27
<OPTION>28
<OPTION>29
<OPTION>30
<OPTION>31
</SELECT>


<SELECT NAME=year>
<?php
$yearnum=date("Y");
echo "<OPTION SELECTED>$yearnum\n";
?>
<OPTION>1999
<OPTION>2000
<OPTION>2001
<OPTION>2002
<OPTION>2003
<OPTION>2004
<OPTION>2005
<OPTION>2006
<OPTION>2007
<OPTION>2008
<OPTION>2009
<OPTION>2010
</SELECT>
&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="Select the date you want this E*Reminder to occur." title="Select the date you want this E*Reminder to occur.">
</TD>

<!-- Beginning of Advanced Settings Column -->
<TD ROWSPAN="6" WIDTH="20%" BGCOLOR="#CCCCCC">
<CENTER>
<FONT SIZE=+1 face="arial,helvetica"><B>Advanced settings:</B></FONT>
<BR>
<BR>
<B>Recurring event:</B>
<BR>  
<INPUT TYPE=checkbox  VALUE=yes NAME=recurring>Yes, every&nbsp;
<BR>
<SELECT NAME=recur_num>
<OPTION>1
<OPTION>2
<OPTION>3
<OPTION>4
<OPTION>5
<OPTION>6
<OPTION>7
<OPTION>8
<OPTION>9
<OPTION>10
<OPTION>11
<OPTION>12
<OPTION>13
<OPTION>14
<OPTION>15
<OPTION>16
<OPTION>17
<OPTION>18
<OPTION>19
<OPTION>20
<OPTION>21
<OPTION>22
<OPTION>23
<OPTION>24
<OPTION>25
<OPTION>26
<OPTION>27
<OPTION>28
<OPTION>29
<OPTION>30
<OPTION>31
<OPTION>32
<OPTION>33
<OPTION>34
<OPTION>35
<OPTION>36
<OPTION>37
<OPTION>38
<OPTION>39
<OPTION>40
<OPTION>41
<OPTION>42
<OPTION>43
<OPTION>44
<OPTION>45
<OPTION>46
<OPTION>47
<OPTION>48
<OPTION>49
<OPTION>50
<OPTION>51
<OPTION>52
<OPTION>53
<OPTION>54
<OPTION>55
<OPTION>56
<OPTION>57
<OPTION>58
<OPTION>59
</SELECT>
<BR>
<SELECT NAME=recur_val>
<OPTION VALUE=year>year(s)
<OPTION VALUE=month>month(s)
<OPTION VALUE=day>day(s)
<!--<OPTION VALUE=hour>hour(s)-->
<!--<OPTION VALUE=minute>minute(s)-->
</SELECT>
<BR>
<BR>
<B>Advance notice:</B>
<BR>
<INPUT TYPE=checkbox  VALUE=yes NAME=adv_notice>Yes, please
<BR>
<SELECT NAME=notify_num>
<OPTION>1
<OPTION>2
<OPTION>3
<OPTION>4
<OPTION>5
<OPTION>6
<OPTION>7
<OPTION>8
<OPTION>9
<OPTION>10
<OPTION>11
<OPTION>12
<OPTION>13
<OPTION>14
<OPTION>15
<OPTION>16
<OPTION>17
<OPTION>18
<OPTION>19
<OPTION>20
<OPTION>21
<OPTION>22
<OPTION>23
<OPTION>24
<OPTION>25
<OPTION>26
<OPTION>27
<OPTION>28
<OPTION>29
<OPTION>30
<OPTION>31
<OPTION>32
<OPTION>33
<OPTION>34
<OPTION>35
<OPTION>36
<OPTION>37
<OPTION>38
<OPTION>39
<OPTION>40
<OPTION>41
<OPTION>42
<OPTION>43
<OPTION>44
<OPTION>45
<OPTION>46
<OPTION>47
<OPTION>48
<OPTION>49
<OPTION>50
<OPTION>51
<OPTION>52
<OPTION>53
<OPTION>54
<OPTION>55
<OPTION>56
<OPTION>57
<OPTION>58
<OPTION>59
</SELECT>
<BR>
<SELECT NAME=notify_val>
<OPTION VALUE=minute>minute(s)
<OPTION VALUE=hour>hour(s)
<OPTION VALUE=day>day(s)
<OPTION VALUE=month>month(s)
<OPTION VALUE=year>year(s)
</SELECT>
<BR>in advance.<BR><BR>
<A HREF="help.html">Help/About</A><BR>
<A HREF="adminoptions.html">Account Options</A><P>
<INPUT TYPE=submit VALUE="Save">&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="Click 'Save' to store/activate your E*Reminder." title="Click 'Save' to store/activate your E*Reminder.">
</TD>

<TR>
<TD ALIGN=center>
<B>Time</B></TD><TD>
<SELECT NAME=hour>
<?php
$hourname=date("g");
$hournum=date("h");
echo "<OPTION SELECTED VALUE=$hournum>$hourname\n";
?>
<OPTION VALUE=01>1
<OPTION VALUE=02>2
<OPTION VALUE=03>3
<OPTION VALUE=04>4
<OPTION VALUE=05>5
<OPTION VALUE=06>6
<OPTION VALUE=07>7
<OPTION VALUE=08>8
<OPTION VALUE=09>9
<OPTION>10
<OPTION>11
<OPTION>12
</SELECT>

<SELECT NAME=minute>
<?php
$minutenum=date("i");
echo "<OPTION SELECTED>$minutenum\n";
?>
<OPTION>00
<OPTION>05
<OPTION>10
<OPTION>15
<OPTION>20
<OPTION>25
<OPTION>30
<OPTION>35
<OPTION>40
<OPTION>45
<OPTION>50
<OPTION>55
</SELECT>

<SELECT NAME=ampm>
<?php
$meridianname=date("A");
$meridiannum=date("a");
echo "<OPTION SELECTED VALUE=$meridiannum>$meridianname\n";
?>
<OPTION VALUE=pm>PM
<OPTION VALUE=am>AM
</SELECT>

<!-- timezone -->
<select name="localzone">
<option value="1">GMT Greenwich Mean Time, London, Dublin, Edinburgh
<option value="2">GMT+1 Berlin,Rome,Paris,Stockholm,Warsaw,Amsterdam
<option value="3">GMT+2 Israel, Cairo, Athens, Helsinki, Istanbul
<option value="4">GMT+3 Moscow, St. Petersburg, Kuwait, Baghdad, 
<option value="5">GMT+4 Abu Dhabi, Muscat, Mauritius, Tbilisi, Kazan
<option value="6">GMT+5 Islamabad, Karachi, Ekaterinburg, Tashkent
<option value="7">GMT+6 Zone E7, Almaty, Dhaka
<option value="8">GMT+7 Bangkok, Jakarta, Hanoi
<option value="9">GMT+8 Hong Kong, Beijing, Singapore, Taipei
<option value="10">GMT+9 Tokyo, Osaka, Seoul, Sapporo, Yakutsk
<option value="11">GMT+10 Sydney, Melbourne, Guam, Vladivostok
<option value="12">GMT+11 Zone E12, Magadan, Soloman Is.
<option value="-11">GMT+12 Fiji, Wellington, Auckland, Kamchatka
<option value="-10">GMT-11 Zone W11, Miway Island, Samoa
<option value="-9">GMT-10 Hawaii
<option value="-8">GMT-9 Alaska, Anchorage
<option value="-7">GMT-8 PST-Pacific US, San Francisco, Los Angeles
<option value="-6">GMT-7 MST-Mountain US, Denver, Arizona,
<option value="-5">GMT-6 CST-Central US,Chicago,Mexico,Sackatchewan
<option SELECTED value="-4">GMT-5 EST-Eastern US, New York, Bogota, Lima
<option value="-3">GMT-4 Atlantic, Canada, Barbados, Caracas,La Paz
<option value="-2">GMT-3 Brazilia, Buenos Aries, Rio de Janeiro
<option value="-1">GMT-2 Zone W2, Mid-Atlantic
<option value="0">GMT-1 Zone W1, Azores, Cape Verde Is.
</select>
&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="Select the time you want this E*Reminder to occur." title="Select the time you want this E*Reminder to occur.">
</TD>
</TR>

<TR>
<!-- Password Row -->
<TD ALIGN=center>
<B>Password</B></TD><TD>
<INPUT TYPE=PASSWORD SIZE=40 NAME="epasswd">
&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="The password you'll use to protect access to your E*Reminder events." title="The password you'll use to protect access to your E*Reminder events.">
</TD>
<TR>

<!-- Email Address row -->
<TD ALIGN=center>
<B>E-Mail To:</B></TD><TD>
<INPUT TYPE=TEXT SIZE=40 NAME=email>
&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="Enter your E-mail address here." title="Enter your E-mail address here.">
</TD><TR>

<!-- Subject Row -->
<TD ALIGN=center>
<B>Event Name</B></TD><TD>
<INPUT TYPE=SUBJECT SIZE=40 NAME="subject">
&nbsp;&nbsp;&nbsp;<IMG SRC="q.gif" ALT="Briefly describe this event - this will become the subject of your E-mail reminder." title="Briefly describe this event - this will become the subject of your E-mail reminder.">
</TD>
<TR>

<!-- Message Row -->
<TD ALIGN=center>
<B>Message</B><P><IMG SRC="q.gif" ALT="Thoroughly describe your E*Reminder event - this will become the body of your E-mail message." title="Thoroughly describe your E*Reminder event - this will become the body of your E-mail message."></TD><TD>
<TEXTAREA NAME="comment" COLS="50" WRAP=hard ROWS="10"></TEXTAREA>
</TD>
</FORM>
</TABLE>
</CENTER>

</BODY>
</HTML>

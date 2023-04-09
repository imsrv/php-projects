#!/usr/bin/perl
# Calendar Planner 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com
# Modified January 24, 2003 for Netscape compatibility

# Path where your calendar files should be stored. CHMOD to 777
# Eg. /path/to/store/calendars/
$calendar_loc = "!SAVEDIR!/";

$login_name = "!USERNAME!";
$login_password = "!PASSWORD!";

# Height and Width of reminder window
$window_width = 400;
$window_height = 500;

##########################################################
# DO NOT EDIT BELOW THIS LINE
##########################################################

splice(@reminders, 0);
splice(@rem_tot, 0);

@months = ("January","February","March","April","May","June","July","August","September","October","November","December");
@days = ("31","28","31","30","31","30","31","31","30","31","30","31");

&parse_form;

$area = $FORM{'area'};
$subarea = $FORM{'subarea'};
$select_month = $FORM{'month'};
$select_day = $FORM{'day'};
$select_year = $FORM{'year'};
$username = $FORM{'username'};
$password = $FORM{'password'};
$calendar = $FORM{'calendar'};
$newcal = $FORM{'newcal'};
$mode = $FORM{'mode'};
$locks = $calendar_loc;

if ($newcal ne "")
 {
 $calendar = $newcal;
 }

$idx = rindex($calendar, ".");

if (substr ("\U$calendar\E", ($idx + 1)) ne "CAL" and $calendar ne "")
 {
 $calendar = "$calendar\.cal";
 }

$calendar_loc = "$calendar_loc$calendar";

if ($newcal ne "" and -e "$calendar_loc")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>\n";
 print "$newcal already exists.  Please choose another calendar name.\n";
 print "</BODY></HTML>\n";
 exit;
 }

&nowinfo;

if ($select_month ne "")
 {
 $month = $select_month + 1;
 }

if ($area eq "show")
 {
 $month = $select_month;
 }

&leap_year_check;

print "Content-type: text/html\n\n";

if ($select_year ne "")
 {
 $year = $select_year;
 }

if ($area ne "login")
 {
 &get_calendar;
 }

if ($area eq "show")
 {
 splice(@d, 0);
 splice(@day, 0);
 $rems = 0;

 @d = (0,3,2,5,0,3,5,1,4,6,2,4);
 @day = (Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday);
 $d = $select_day;
 $m = $select_month;
 $y = $select_year;
 $y-- if $m < 3;
 $dayv = ($y+int($y/4)-int($y/100)+int($y/400)+$d[$m-1]+$d) % 7;
 $day = $day[$dayv];

 $window_width2 = $window_width - 50;

 print "<HTML><BODY><CENTER>\n";
 print "<TITLE>Calendar Planner</TITLE>\n";
 print "<TABLE BGCOLOR=#FFFCCC WIDTH=$window_width2 BORDER=1 CELLSPACING=0 CELLPADDING=0>\n";
 print "<TR><TD><CENTER><B>$day @months[$select_month - 1] $select_day, $select_year</B></CENTER></TD></TR>\n";

 $start = 0;
 splice(@all_lines, 0);
 @all_lines = split(/\n/, "@reminders[$select_day]");

 for ($x = 0; $x < @all_lines; $x++)
  {
  $line = @all_lines[$x];

  if ($line eq "<!--REM-->")
   {
   $rems++;

   if ($start == 0)
    {
    print "<TR><TD>$line<BR>[ <B>$rems</B> ] ";
    $start = 1;
    }
    else
    {
    print "</TD></TR>\n<TR><TD>$line<BR>[ <B>$rems</B> ] ";
    }
   }
   else
   {
   print "$line<BR>";
   }
  }

 print "</TD></TR></TABLE></CENTER></BODY></HTML>\n";
 exit;
 }

if ($area eq "login")
 {
 if ("\U$username\E" eq "\U$login_name\E" and "\U$password\E" eq "\U$login_password\E" and $username ne "" and $password ne "")
  {
  if ($subarea eq "")
   {
   print "<TITLE>Calendar Planner</TITLE><CENTER>\n";
   print "<H2>Calendar Planner</H2>\n";

   $pyear = $year - 1;
   $nyear = $year + 1;

   print "[ <A HREF=\"$ENV{'SCRIPT_NAME'}?username=$username&password=$password&area=login&calendar=$calendar&year=$pyear\">Previous Year</A> ] \n";
   print "[ <A HREF=\"$ENV{'SCRIPT_NAME'}?username=$username&password=$password&area=login&calendar=$calendar&year=$nyear\">Next Year</A> ]<BR><BR>\n";

   for ($t = 0; $t < 12; $t++)
    {
    $month = $t + 1;
    &get_calendar;
    &show_cal;
    print "<BR>\n";
    }

   print "</CENTER>\n";
   }

  if ($subarea eq "edit")
   {
   $day = $select_day;
   $month = $select_month;
   &get_calendar;
   &login_display_rem;
   }

  if ($subarea eq "save")
   {
   $month = $select_month;
   $day = $select_day;
   $year = $select_year;

   &get_calendar;

   $oldcount = 0;
   $startmonth = 0;
   $startday = 0;
   splice(@reminders, 0);
   splice(@old_lines, 0);

   @reminders = split (/ \|\| /, "$FORM{'reminder'}");

   $getmonth = @months[$month - 1];

   $lock_name = "$calendar\.lock";
   &lock;
   open(CAL, "<$calendar_loc");

   until(eof(CAL))
    {
    $line = <CAL>;
    chop($line);

    if ("\U$line\E" eq "\U<!--$getmonth$year-->\E")
     {
     $startmonth = 1;
     @old_lines[$oldcount] = $line;
     $oldcount++;
     $line = "";

     until(eof(CAL) or "\U$line\E" eq "\U<!--$getmonth$year-->\E")
      {
      $line = <CAL>;
      chop($line);

      if ("\U$line\E" eq "\U<!--$day-->\E")
       {
       $startday = 1;
       $line = "";

       until(eof(CAL) or "\U$line\E" eq "\U<!--$day-->\E")
        {
        $line = <CAL>;
        chop($line);
        }

       if ($FORM{'reminder'} ne "")
        {
        @old_lines[$oldcount] = "<!--$day-->";
        $oldcount++;

        for ($j = 0; $j < @reminders; $j++)
         {
         @old_lines[$oldcount] = "<!--REM-->";
         $oldcount++;
         @old_lines[$oldcount] = @reminders[$j];
         $oldcount++;
         }

        @old_lines[$oldcount] = "<!--$day-->";
        $oldcount++;
        }
       }
       else
       {
       @old_lines[$oldcount] = $line;
       $oldcount++;
       }
      }

     if ($startday == 0 and $FORM{'reminder'} ne "")
      {
      $oldcount--;
      @old_lines[$oldcount] = "<!--$day-->";
      $oldcount++;

      for ($j = 0; $j < @reminders; $j++)
       {
       @old_lines[$oldcount] = "<!--REM-->";
       $oldcount++;
       @old_lines[$oldcount] = @reminders[$j];
       $oldcount++;
       }

      @old_lines[$oldcount] = "<!--$day-->";
      $oldcount++;
      @old_lines[$oldcount] = "<!--$getmonth$year-->";
      $oldcount++;
      }

     }
     else
     {
     @old_lines[$oldcount] = $line;
     $oldcount++;
     }
    }

   close(CAL);
   $lock_name = "$calendar\.lock";
   &unlock;

   if ($startmonth == 0)
    {
    @old_lines[$oldcount] = "<!--$getmonth$year-->";
    $oldcount++;
    @old_lines[$oldcount] = "<!--$day-->";
    $oldcount++;

    for ($j = 0; $j < @reminders; $j++)
     {
     @old_lines[$oldcount] = "<!--REM-->";
     $oldcount++;
     @old_lines[$oldcount] = @reminders[$j];
     $oldcount++;
     }

    @old_lines[$oldcount] = "<!--$day-->";
    $oldcount++;
    @old_lines[$oldcount] = "<!--$getmonth$year-->";
    $oldcount++;
    }

   $lock_name = "$calendar\.lock";
   &lock;
   open(CAL, ">$calendar_loc");

   for ($j = 0; $j < @old_lines; $j++)
    {
    print CAL "@old_lines[$j]\n";
    }

   close(CAL);
   $lock_name = "$calendar\.lock";
   &unlock;

   print "Your changes have been saved.  <A HREF=\"$ENV{'SCRIPT_NAME'}?username=$username&password=$password&area=login&calendar=$calendar&year=$year\">Click Here</A> to make more changes.\n";
   }
  }
  else
  {
  &login;
  }

 exit;
 }

if ($area eq "expand")
 {
 print "<SCRIPT>\n";
 }

{
print <<END
function showReminder(reminder) {

window.open(reminder,"NewWin","width=$window_width,height=$window_height,scrollbars=YES");
}

END
}

if ($area eq "expand")
 {
 print "</SCRIPT>\n";
 }

@d = (0,3,2,5,0,3,5,1,4,6,2,4);
@day = (Sun, Mon, Tue, Wed, Thu, Fri, Sat);
$d = 1;
$m = $month;
$y = $year;
$y-- if $m < 3;
$dayv = ($y+int($y/4)-int($y/100)+int($y/400)+$d[$m-1]+$d) % 7;
$day = $day[$dayv];

if ($area eq "expand")
 {
 &expand;
 exit;
 }

if ($mode eq "1")
 {
{
print<<END
 if (document.layers)
  {
  document.write('<layer name="calendarplanner" z-index="90" left="0" top="0" visibility="visible">');
  }
  else if (document.all)
  {
  document.write('<div id="calendarplanner" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;">');
  }
  else if (document.getElementById)
  {
  document.write('<div id="calendarplanner" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;">');
  }
END
}
 }

print "document.write('<TABLE BGCOLOR=#FFFCCC BORDER=1 CELLSPACING=5 CELLPADDING=0>');\n";
print "document.write('<TR><TD COLSPAN=7 ALIGN=CENTER BGCOLOR=#FFFFFF><B>@months[$month - 1] $year</B></TD></TR>');\n";
print "document.write('<TR ALIGN=CENTER><TD><B>S</B></TD><TD><B>M</B></TD><TD><B>T</B></TD><TD><B>W</B></TD><TD><B>T</B></TD><TD><B>F</B></TD><TD><B>S</B></TD></TR>');\n";

if ($dayv > 0)
 {
 print "document.write('<TR ALIGN=CENTER>');\n";

 for ($x = 0; $x < $dayv; $x++)
  {
  print "document.write('<TD></TD>');\n";
  }

 $count = $dayv;
 }

for ($x = 1; $x <= @days[$month - 1]; $x++)
 {
 if ($count == 0)
  {
  print "document.write('<TR ALIGN=CENTER>');\n";
  }

 if ($count < 7)
  {
  if ($x == $mday and $year == $nowyear and $nowday == $mday and $month == $nowmonth)
   {
   if (@reminders[$x] ne "")
    {
    print "document.write('<TD BGCOLOR=#33CC33>$x<FONT SIZE=-1><SUP>1</SUP></FONT></TD>');\n";
    }
    else
    {
    print "document.write('<TD BGCOLOR=#AAAFFF>$x</TD>');\n";
    }
   }
   else
   {
   if (@reminders[$x] ne "")
    {
    print "document.write('<TD BGCOLOR=#33CC33><A HREF=javascript:onClick=showReminder(\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=show&calendar=$calendar\");>$x</A><FONT SIZE=-1><SUP>@rem_tot[$x]</SUP></FONT></TD>');\n";
    }
    else
    {
    print "document.write('<TD BGCOLOR=#FFFFFF>$x</TD>');\n";
    }
   }

  $count++;
  }
  else
  {
  $count = 0;
  $x = $x - 1;
  print "document.write('</TR>');\n";
  }
 }

if ($count != 0)
 {
 print "document.write('</TR>');\n";
 }

if ($month <= 0)
 {
 $prev_month = 10;
 }
 else
 {
 $prev_month = $month - 2;
 }

if ($month >= 12)
 {
 $next_month = 0;
 }
 else
 {
 $next_month = $month;
 }

$month--;
print "document.write('<TR><TD COLSPAN=7 ALIGN=CENTER><A HREF=\"$ENV{'SCRIPT_NAME'}?month=$month&year=$year&area=expand&calendar=$calendar\" target=_blank>Expand Calendar</A></TD></TR>');\n";
print "document.write('</TABLE>');\n";

if ($mode eq "1")
 {
$window_width2 = $window_width - 50;

{
print<<END
 if (document.layers)
  {
  document.write('</layer>');
  }
  else if (document.all)
  {
  document.write('</div>');
  }
  else if (document.getElementById)
  {
  document.write('</div>');
  }

function showRec() {

if (document.layers)
 {
 document.layers.calendarplanner.top = pageYOffset;
 document.calendarplanner.left = window.innerWidth - ($window_width / 2);
 }
 else if (document.all)
 {
 document.all.calendarplanner.style.posLeft = document.body.clientWidth - ($window_width / 2);
 document.all.calendarplanner.style.top = document.body.scrollTop;
 }
 else if (document.getElementById)
 {
 document.getElementById("calendarplanner").style.left = window.innerWidth - ($window_width / 2);
 document.getElementById("calendarplanner").style.top = document.body.scrollTop;
 }

setTimeout("showRec()",100);
}

setTimeout("showRec()",1000);
END
}
 }

exit;

# Check to see if it is a leap year.  If a year is divisible by 4
# and not divisible by 100, then it is a leap year.

sub leap_year_check
 {
 $yeardiv = ($year / 4);
 $yearint = int($yeardiv);
 $yeardiv1 = ($year / 100);
 $yearint1 = int($yeardiv1);

 # 29 days in february on leap year, 28 on regular year.
 if (($yeardiv eq $yearint && $yeardiv1 ne $yearint1) || ($year % 400 == 0))
  {
  @days[1] = "28";
  }
  else
  {
  @days[1] = "29";
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

$nowday = $mday;
$nowmonth = $month;
$nowyear = $year;

$date_now = "$month\-$mday\-$year";
$time_now = "$hour\:$min\:$sec";
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

sub get_calendar
{
splice(@reminders, 0);
splice(@rem_tot, 0);

$getmonth = @months[$month - 1];

$lock_name = "$calendar\.lock";
&lock;

open(CAL, "<$calendar_loc");

until(eof(CAL))
 {
 $line = <CAL>;
 chop($line);

 if ("\U$line\E" eq "\U<!--$getmonth$year-->\E")
  {
  $line = "";

  until(eof(CAL) or "\U$line\E" eq "\U<!--@months[$month - 1]$year-->\E")
   {
   $line = <CAL>;
   chop($line);

   if (substr($line, 0, 4) eq "<!--")
    {
    $line =~ m/<\!--([\d]*)-->/gi;
    $cnum = $1;

    $look = $line;
    $line = "";

    until(eof(CAL) or $line eq $look)
     {
     $line = <CAL>;
     chop($line);

     if ($line eq "<!--REM-->")
      {
      @rem_tot[$cnum]++;
      }

     @reminders[$cnum] .= "$line\n";
     }
    }

   }
  }
 }

close(CAL);
$lock_name = "$calendar\.lock";
&unlock;
}

sub expand
{
print "<HTML><BODY><TITLE>Calendar Planner</TITLE>\n";
print "<TABLE WIDTH=100% BGCOLOR=#FFFCCC BORDER=1 CELLSPACING=5 CELLPADDING=0>\n";
print "<TR><TD COLSPAN=7 ALIGN=CENTER BGCOLOR=#FFFFFF><B>@months[$month - 1] $year</B></TD></TR>\n";
print "<TR ALIGN=CENTER><TD WIDTH=14%><B>Sunday</B></TD><TD WIDTH=14%><B>Monday</B></TD><TD WIDTH=14%><B>Tuesday</B></TD><TD WIDTH=14%><B>Wednesday</B></TD><TD WIDTH=14%><B>Thursday</B></TD><TD WIDTH=14%><B>Friday</B></TD><TD WIDTH=14%><B>Saturday</B></TD></TR>\n";

if ($dayv > 0)
 {
 print "<TR ALIGN=LEFT>\n";

 for ($x = 0; $x < $dayv; $x++)
  {
  print "<TD></TD>\n";
  }

 $count = $dayv;
 }

for ($x = 1; $x <= @days[$month - 1]; $x++)
 {
 if ($count == 0)
  {
  print "<TR VALIGN=TOP>\n";
  }

 if ($count < 7)
  {
  if ($x == $mday and $year == $nowyear and $nowday == $mday and $month == $nowmonth)
   {
   if (@reminders[$x] ne "")
    {
    print "<TD BGCOLOR=#AAAFFF ALIGN=LEFT VALIGN=TOP HEIGHT=75><A HREF=javascript:onClick=showReminder(\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=show&calendar=$calendar\");>$x</A><FONT SIZE=-1><SUP>@rem_tot[$x]</SUP></FONT>";
    &display_rem;
    print "</TD>\n";
    }
    else
    {
    print "<TD BGCOLOR=#AAAFFF ALIGN=LEFT VALIGN=TOP HEIGHT=75>$x</TD>\n";
    }
   }
   else
   {
   if (@reminders[$x] ne "")
    {
    print "<TD BGCOLOR=#33CC33 ALIGN=LEFT VALIGN=TOP HEIGHT=75><A HREF=javascript:onClick=showReminder(\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=show&calendar=$calendar\");>$x</A><FONT SIZE=-1><SUP>@rem_tot[$x]</SUP></FONT>";
    &display_rem;
    print "</TD>\n";
    }
    else
    {
    print "<TD BGCOLOR=#FFFFFF VALIGN=TOP HEIGHT=75>$x</TD>\n";
    }
   }

  $count++;
  }
  else
  {
  $count = 0;
  $x = $x - 1;
  print "</TR>\n";
  }
 }

if ($count != 0)
 {
 print "</TR>\n";
 }

if ($month <= 0)
 {
 $prev_month = 10;
 }
 else
 {
 $prev_month = $month - 2;
 }

if ($month >= 12)
 {
 $next_month = 0;
 }
 else
 {
 $next_month = $month;
 }

#print "<TR><TD COLSPAN=7 ALIGN=CENTER>[ <A HREF=\"$ENV{'SCRIPT_NAME'}?month=$prev_month&calendar=$calendar\">@months[$prev_month]</A> ] [ <A HREF=\"$ENV{'SCRIPT_NAME'}?month=$next_month&calendar=$calendar\">@months[$next_month]</A> ]</TD></TR>\n";
print "</TABLE></BODY></HTML>\n";

}


sub display_rem
{
$start = 0;
splice(@all_lines, 0);
@all_lines = split(/\n/, "@reminders[$x]");

print "<FONT SIZE=-1>";

$line = "";
$found = 0;
$j = 0;

until ($found == 1 or $j > @all_lines)
 {
 if (@all_lines[$j] ne "<!--REM-->")
  {
  $line .= "@all_lines[$j]\n";
  }
  else
  {
  $line .= "\n";
  }

 $j++;

 if ($j > 3)
  {
  $found = 1;
  }
 }

if (length($line) > 30)
 {
 $line = substr($line, 0, 30);
 $line = "$line....";
 }

$line =~ s/\n/<br>/gi;
print "$line</FONT>";
}

sub login_display_rem
{
print "<TITLE>Calendar Planner</TITLE><CENTER>\n";
print "<H2>Calendar Planner</H2></CENTER>\n";

print "<B>@months[$select_month - 1] $select_day, $select_year</B><BR><BR>\n";
print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=hidden NAME=area VALUE=\"login\">\n";
print "<INPUT TYPE=hidden NAME=subarea VALUE=\"save\">\n";
print "<INPUT TYPE=hidden NAME=username VALUE=\"$username\">\n";
print "<INPUT TYPE=hidden NAME=password VALUE=\"$password\">\n";
print "<INPUT TYPE=hidden NAME=month VALUE=\"$month\">\n";
print "<INPUT TYPE=hidden NAME=day VALUE=\"$day\">\n";
print "<INPUT TYPE=hidden NAME=year VALUE=\"$year\">\n";
print "<INPUT TYPE=hidden NAME=calendar VALUE=\"$calendar\">\n";


$start = 0;
splice(@all_lines, 0);
@all_lines = split(/\n/, "@reminders[$day]");

$line = "";
$found = 0;
$count = 1;
$j = 0;

until ($j > @all_lines)
 {
 $line = @all_lines[$j];

 if ($line eq "<!--REM-->")
  {
  if ($count > 1)
   {
   print "</TEXTAREA><BR><BR>\n";
   }

  print "<B>Reminder #$count</B><BR>\n";
  print "<TEXTAREA ROWS=10 COLS=40 NAME=reminder>\n";
  $count++;
  }
  else
  {
  if (substr($line, 0, 4) ne "<!--")
   {
   print "$line\n";
   }
  }

 $j++;
 }

print "</TEXTAREA><BR>\n";

for ($j = 0; $j < 3; $j++)
 {
 print "<B>Reminder #$count</B><BR>\n";
 print "<TEXTAREA ROWS=10 COLS=40 NAME=reminder></TEXTAREA><BR>\n";
 $count++;
 }

print "<INPUT TYPE=SUBMIT NAME=submit VALUE=\"SUBMIT\">";
print "</FORM>\n";
}


sub login
{
opendir(CALS, "$calendar_loc");
@all_cals = readdir(CALS);
close(CALS);

{
print <<END
<CENTER>
<H2>Calendar Planner</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME="area" VALUE="login">

<TR><TD><B>Username:</B></TD> <TD><INPUT NAME="username"></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME="password"></TD></TR>
<TR><TD><B>Calendar:</B></TD> <TD><SELECT NAME="calendar">
END
}

$found = 0;
for ($x = 2; $x < @all_cals; $x++)
 {
 $idx = rindex($all_cals[$x], ".");
 $tmpcal = substr ("@all_cals[$x]", 0, $idx);

 if (substr ("\U@all_cals[$x]\E", ($idx + 1)) eq "CAL")
  {
  $found = 1;
  print "<OPTION>$tmpcal\n";
  }
 }

print "</SELECT></TD></TR><TR><TD><B>Year:</B></TD> <TD><SELECT NAME=\"year\">";

for ($x = ($nowyear - 4); $x < $nowyear + 11; $x++)
 {
 print "<OPTION>$x\n";
 }

{
print <<END
</SELECT>
<TR><TD COLSPAN=2>
<BR>
If you want to create a new calendar, enter the name below:
<BR>
</TD></TR>

<TR><TD><B>New Calendar:</B></TD> <TD><INPUT NAME="newcal"></TD></TR>

<TR><TD></TD> <TD><INPUT TYPE=SUBMIT NAME="submit" VALUE="Login"></TD></TR>
</FORM>

</TABLE>
</CENTER>
END
}

}

sub show_cal
{
$count = 0;
$dayv = 0;
splice(@d, 0);
splice(@day, 0);

@d = (0,3,2,5,0,3,5,1,4,6,2,4);
@day = (Sun, Mon, Tue, Wed, Thu, Fri, Sat);
$d = 1;
$m = $t + 1;
$y = $year;
$y-- if $m < 3;
$dayv = ($y+int($y/4)-int($y/100)+int($y/400)+$d[$m-1]+$d) % 7;
$day = $day[$dayv];

print "<TABLE BGCOLOR=#FFFCCC BORDER=1 CELLSPACING=5 CELLPADDING=0>\n";
print "<TR><TD COLSPAN=7 ALIGN=CENTER BGCOLOR=#FFFFFF><B>@months[$t] $year</B></TD></TR>\n";
print "<TR ALIGN=CENTER><TD><B>S</B></TD><TD><B>M</B></TD><TD><B>T</B></TD><TD><B>W</B></TD><TD><B>T</B></TD><TD><B>F</B></TD><TD><B>S</B></TD></TR>\n";

if ($dayv > 0)
 {
 print "<TR ALIGN=CENTER>\n";

 for ($x = 0; $x < $dayv; $x++)
  {
  print "<TD></TD>\n";
  }

 $count = $dayv;
 }

for ($x = 1; $x <= @days[$t]; $x++)
 {
 if ($count == 0)
  {
  print "<TR ALIGN=CENTER>\n";
  }

 if ($count < 7)
  {
  if ($x == $mday and $year == $nowyear and $nowday == $mday and $month == $nowmonth)
   {
   if (@reminders[$x] ne "")
    {
    print "<TD BGCOLOR=#33CC33><A HREF=\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=login&subarea=edit&username=$username&password=$password&calendar=$calendar\">$x</A><FONT SIZE=-1><SUP>@rem_tot[$x]</SUP></FONT></TD>\n";
    }
    else
    {
    print "<TD BGCOLOR=#AAAFFF><A HREF=\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=login&subarea=edit&username=$username&password=$password&calendar=$calendar\">$x</A></TD>\n";
    }
   }
   else
   {
   if (@reminders[$x] ne "")
    {
    print "<TD BGCOLOR=#33CC33><A HREF=\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=login&subarea=edit&username=$username&password=$password&calendar=$calendar\">$x</A><FONT SIZE=-1><SUP>@rem_tot[$x]</SUP></FONT></TD>\n";
    }
    else
    {
    print "<TD BGCOLOR=#FFFFFF><A HREF=\"$ENV{'SCRIPT_NAME'}?month=$month&day=$x&year=$year&area=login&subarea=edit&username=$username&password=$password&calendar=$calendar\">$x</A></TD>\n";
    }
   }

  $count++;
  }
  else
  {
  $count = 0;
  $x = $x - 1;
  print "</TR>\n";
  }
 }

if ($count != 0)
 {
 print "</TR>\n";
 }

print "</TABLE>\n";
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
unlink ("$locks$lock_name");
}


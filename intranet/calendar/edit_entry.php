<?php php_track_vars?>
<?php

include "includes/config.inc";
include "includes/php-dbi.inc";
include "includes/functions.inc";
include "includes/validate.inc";
include "includes/connect.inc";

load_user_preferences ();
load_user_layers ();

include "includes/translate.inc";

if ( $id > 0 ) {
  // first see who has access to edit this entry
  if ( $is_admin ) {
    $can_edit = true;
  } else {
    $can_edit = false;
    $sql = "SELECT cal_id FROM webcal_entry_user " .
      "WHERE cal_login = '$login' AND cal_id = $id";
    $res = dbi_query ( $sql );
    if ( $res ) {
      $row = dbi_fetch_row ( $res );
      if ( $row && $row[0] > 0 )
        $can_edit = true;
      dbi_free_result ( $res );
    }
  }
  $sql = "SELECT cal_create_by, cal_date, cal_time, cal_mod_date, " .
    "cal_mod_time, cal_duration, cal_priority, cal_type, cal_access, " .
    "cal_name, cal_description FROM webcal_entry WHERE cal_id = " . $id;
  $res = dbi_query ( $sql );
  if ( $res ) {
    $row = dbi_fetch_row ( $res );
    $year = (int) ( $row[1] / 10000 );
    $month = ( $row[1] / 100 ) % 100;
    $create_by = $row[0];
    $day = $row[1] % 100;
    $time = $row[2];
    if ( $time >= 0 ) {
      $hour = $time / 10000;
      $minute = ( $time / 100 ) % 100;
      $duration = $row[5];
    } else {
      $duration = "";
    }
    $priority = $row[6];
    $type = $row[7];
    $access = $row[8];
    $name = $row[9];
    $description = $row[10];
    // check for repeating event info...
    $res = dbi_query ( "SELECT cal_id, cal_type, cal_end, " .
      "cal_frequency, cal_days FROM webcal_entry_repeats " .
      "WHERE cal_id = $id" );
    if ( $res ) {
      if ( $row = dbi_fetch_row ( $res ) ) {
        $rpt_type = $row[1];
        if ( $row[2] > 0 )
          $rpt_end = date_to_epoch ( $row[2] );
        else
          $rpt_end = 0;
        $rpt_freq = $row[3];
        $rpt_days = $row[4];
        $rpt_sun  = ( substr ( $rpt_days, 0, 1 ) == 'y' );
        $rpt_mon  = ( substr ( $rpt_days, 1, 1 ) == 'y' );
        $rpt_tue  = ( substr ( $rpt_days, 2, 1 ) == 'y' );
        $rpt_wed  = ( substr ( $rpt_days, 3, 1 ) == 'y' );
        $rpt_thu  = ( substr ( $rpt_days, 4, 1 ) == 'y' );
        $rpt_fri  = ( substr ( $rpt_days, 5, 1 ) == 'y' );
        $rpt_sat  = ( substr ( $rpt_days, 6, 1 ) == 'y' );
      }
    }
    
  }
  $sql = "SELECT cal_login FROM webcal_entry_user WHERE cal_id = $id";
  $res = dbi_query ( $sql );
  if ( $res ) {
    while ( $row = dbi_fetch_row ( $res ) ) {
      $participants[$row[0]] = 1;
    }
  }
} else {
  $time = -1;
  $can_edit = true;
}
if ( $year )
  $thisyear = $year;
if ( $month )
  $thismonth = $month;
if ( ! $rpt_type )
  $rpt_type = "none";

if ( ! $year && ! $month && strlen ( $date ) ) {
  $thisyear = $year = substr ( $date, 0, 4 );
  $thismonth = $month = substr ( $date, 4, 2 );
  $thisday = $day = substr ( $date, 6, 2 );
}

?>
<HTML>
<HEAD>
<TITLE><?php etranslate("Title")?></TITLE>
<SCRIPT LANGUAGE="JavaScript">
// do a little form verifying
function validate_and_submit () {
  if ( document.forms[0].name.value == "" ) {
    alert ( "<?php etranslate("You have not entered a Brief Description")?>." );
    return false;
  }
  h = parseInt ( document.forms[0].hour.value );
  m = parseInt ( document.forms[0].minute.value );
  if ( h > 23 || m > 59 ) {
    alert ( "<?php etranslate ("You have not entered a valid time of day")?>." );
    return false;
  }
  // would be nice to also check date to not allow Feb 31, etc...
  document.forms[0].submit ();
  return true;
}
function selectDate ( day, month, year ) {
  url = "datesel.php?form=editentryform&day=" + day +
    "&month=" + month + "&year=" + year;
  <?php
  if ( $date > 0 )
    echo "  url += '&date=$date';"
  ?>
  var colorWindow = window.open(url,"DateSelection","width=200,height=160,resizable=yes,scrollbars=yes");
}

</SCRIPT>
<?php include "includes/styles.inc"; ?>
</HEAD>
<BODY BGCOLOR="<?php echo $BGCOLOR; ?>">

<H2><FONT COLOR="<?php echo $H2COLOR;?>"><?php if ( $id ) echo translate("Edit Entry"); else echo translate("Add Entry"); ?></FONT></H2>

<?php
if ( $can_edit ) {
?>
<FORM ACTION="edit_entry_handler.php" METHOD="POST" NAME="editentryform">

<?php if ( $id ) echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">\n"; ?>

<TABLE BORDER=0>

<TR><TD><B><?php etranslate("Brief Description")?>:</B></TD>
  <TD><INPUT NAME="name" SIZE=25 VALUE="<?php echo htmlspecialchars ( $name ); ?>"></TD></TR>

<TR><TD VALIGN="top"><B><?php etranslate("Full Description")?>:</B></TD>
  <TD><TEXTAREA NAME="description" ROWS=5 COLS=40 WRAP="virtual"><?php echo htmlspecialchars ( $description ); ?></TEXTAREA></TD></TR>

<TR><TD><B><?php etranslate("Date")?>:</B></TD>
  <TD><SELECT NAME="day">
<?php
  if ( $day == 0 )
    $day = date ( "d" );
  for ( $i = 1; $i <= 31; $i++ ) echo "<OPTION " . ( $i == $day ? " SELECTED" : "" ) . ">$i";
?>
  </SELECT>
  <SELECT NAME="month">
<?php
  if ( $month == 0 )
    $month = date ( "m" );
  if ( $year == 0 )
    $year = date ( "Y" );
  for ( $i = 1; $i <= 12; $i++ ) {
    $m = month_short_name ( $i - 1 );
    print "<OPTION VALUE=\"$i\"" . ( $i == $month ? " SELECTED" : "" ) . ">$m";
  }
?>
  </SELECT>
  <SELECT NAME="year">
<?php
  for ( $i = -1; $i < 5; $i++ ) {
    $y = date ( "Y" ) + $i;
    print "<OPTION VALUE=\"$y\"" . ( $y == $year ? " SELECTED" : "" ) . ">$y";
  }
?>
  </SELECT>
  <INPUT TYPE="button" ONCLICK="selectDate('day','month','year')" VALUE="<?php etranslate("Select")?>...">
</TD></TR>

<TR><TD><B><?php etranslate("Time")?>:</B></TD>
<?php
$h12 = $hour;
$amsel = "CHECKED"; $pmsel = "";
if ( $TIME_FORMAT == "12" ) {
  if ( $h12 < 12 ) {
    $amsel = "CHECKED"; $pmsel = "";
  } else {
    $amsel = ""; $pmsel = "CHECKED";
  }
  $h12 %= 12;
  if ( $h12 == 0 ) $h12 = 12;
}
if ( $time < 0 )
  $h12 = "";
?>
  <TD><INPUT NAME="hour" SIZE=2 VALUE="<?php echo $h12;?>" MAXLENGTH=2>:<INPUT NAME="minute" SIZE=2 VALUE="<?php if ( $time >= 0 ) printf ( "%02d", $minute );?>" MAXLENGTH=2>
<?php
if ( $TIME_FORMAT == "12" ) {
  echo "<INPUT TYPE=radio NAME=ampm VALUE=\"am\" $amsel>" .
    translate("am") . "\n";
  echo "<INPUT TYPE=radio NAME=ampm VALUE=\"pm\" $pmsel>" .
    translate("pm") . "\n";
}
?>
</TD></TR>

<TR><TD><B><?php etranslate("Duration")?>:</B></TD>
  <TD><INPUT NAME="duration" SIZE=3 VALUE="<?php echo $duration;?>"> <?php etranslate("minutes")?></TD></TR>

<TR><TD><B><?php etranslate("Priority")?>:</B></TD>
  <TD><SELECT NAME="priority">
    <OPTION VALUE="1"<?php if ( $priority == 1 ) echo " SELECTED";?>><?php etranslate("Low")?>
    <OPTION VALUE="2"<?php if ( $priority == 2 || $priority == 0 ) echo " SELECTED";?>><?php etranslate("Medium")?>
    <OPTION VALUE="3"<?php if ( $priority == 3 ) echo " SELECTED";?>><?php etranslate("High")?>
  </SELECT></TD></TR>

<TR><TD><B><?php etranslate("Access")?>:</B></TD>
  <TD><SELECT NAME="access">
    <OPTION VALUE="P"<?php if ( $access == "P" || ! strlen ( $access ) ) echo " SELECTED";?>><?php etranslate("Public")?>
    <OPTION VALUE="R"<?php if ( $access == "R" ) echo " SELECTED";?>><?php etranslate("Confidential")?>
  </SELECT></TD></TR>

<?php
// Only ask for participants if we are multi-user.
if ( ! strlen ( $single_user_login ) ) {
  $sql = "SELECT cal_login, cal_lastname, cal_firstname " .
    "FROM webcal_user ORDER BY cal_lastname, cal_firstname, cal_login";
  $res = dbi_query ( $sql );
  if ( $res ) {
    $num_users = 0;
    $size = 0;
    $users = "";
    while ( $row = dbi_fetch_row ( $res ) ) {
      $size++;
      $users .= "<OPTION VALUE=\"$row[0]\"";
      if ( $id > 0 ) {
        if ( $participants[$row[0]] )
          $users .= " SELECTED";
      } else {
        if ( $row[0] == $login || $row[0] == $user )
          $users .= " SELECTED";
      }
      $users .= ">";

      if ( strlen ( $row[1] ) ) {
        $users .= $row[1];
        if ( strlen ( $row[2] ) )
          $users .= ", $row[2]";
      } else {
        $users .= $row[0];
      }

    }
    if ( $size > 50 )
      $size = 15;
    else if ( $size > 5 )
      $size = 5;
    if ( $size > 1 ) {
      print "<TR><TD VALIGN=\"top\"><B>" .
        translate("Participants") . ":</B></TD>";
      print "<TD><SELECT NAME=\"participants[]\" SIZE=$size MULTIPLE>$users\n";
      print "</SELECT></TD></TR>\n";
    }
  }
}
?>
<TR><TD VALIGN="top"><B><?php etranslate("Repeat Type")?>:</B></TD>
<TD VALIGN="top"><?php
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"none\" " .
  ( strcmp ( $rpt_type, 'none' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("None");
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"daily\" " .
  ( strcmp ( $rpt_type, 'daily' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("Daily");
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"weekly\" " .
  ( strcmp ( $rpt_type, 'weekly' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("Weekly");
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"monthlyByDay\" " .
  ( strcmp ( $rpt_type, 'monthlyByDay' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("Monthly") . " (" . translate("by day") . ")";
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"monthlyByDate\" " .
  ( strcmp ( $rpt_type, 'monthlyByDate' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("Monthly") . " (" . translate("by date") . ")";
echo "<INPUT TYPE=\"radio\" NAME=\"rpt_type\" VALUE=\"yearly\" " .
  ( strcmp ( $rpt_type, 'yearly' ) == 0 ? "CHECKED" : "" ) . "> " .
  translate("Yearly");
?>
</TD></TR>
<TR><TD><B><?php etranslate("Repeat End Date")?>:</B></TD>
<TD><INPUT TYPE="checkbox" NAME="rpt_end_use" VALUE="y" <?php
  echo ( $rpt_end ? "CHECKED" : "" ); ?>> <?php etranslate("Use end date")?>
&nbsp;&nbsp;&nbsp;
<SPAN CLASS="end_day_selection">
<SELECT NAME="rpt_day">
<?php
  if ($rpt_end) {
     $rpt_day 	= date("d",$rpt_end);
     $rpt_month = date("m",$rpt_end);
     $rpt_year 	= date("Y",$rpt_end);
  } else {
     $rpt_day 	= $day+1;
     $rpt_month = $month;
     $rpt_year 	= $year;
  }

  for ($i = 1; $i <= 31; $i++) {
    echo "<OPTION value=\"$i\"" . ($i == $rpt_day ? " SELECTED" : "")
       . ">$i</OPTION>\n";
  }

  echo "</SELECT><SELECT NAME=\"rpt_month\">";

  for ($i = 1; $i <= 12; $i++) {
    $m = month_short_name ( $i - 1 );
    echo "<OPTION VALUE=\"$i\"" . ($i == $rpt_month ? " SELECTED" : "")
       . ">$m</OPTION>\n";
  }

  echo "</SELECT><SELECT NAME=\"rpt_year\">";

  for ($i = -1; $i < 5; $i++) {
    $y = date("Y") + $i;
    echo "<OPTION VALUE=\"$y\"" . ($y == $rpt_year ? " SELECTED" : "")
       . ">$y</OPTION>\n";
  }
?>
  </SELECT>
  <INPUT TYPE="button" ONCLICK="selectDate('rpt_day','rpt_month','rpt_year')" VALUE="<?php etranslate("Select")?>...">
</TD></TR>
<TR><TD><B><?php etranslate("Repeat Day")?>: </b>(<?php etranslate("for weekly")?>)</td>
  <td><?php
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_sun\" VALUE=\"y\" "
     . ($rpt_sun?"CHECKED":"") . "> " . translate("Sunday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_mon\" VALUE=\"y\" "
     . ($rpt_mon?"CHECKED":"") . "> " . translate("Monday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_tue\" VALUE=y "
     . ($rpt_tue?"CHECKED":"") . "> " . translate("Tuesday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_wed\" VALUE=\"y\" "
     . ($rpt_wed?"CHECKED":"") . "> " . translate("Wednesday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_thu\" VALUE=\"y\" "
     . ($rpt_thu?"CHECKED":"") . "> " . translate("Thursday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_fri\" VALUE=\"y\" "
     . ($rpt_fri?"CHECKED":"") . "> " . translate("Friday");
  echo "<INPUT TYPE=\"checkbox\" NAME=\"rpt_sat\" VALUE=\"y\" "
     . ($rpt_sat?"CHECKED":"") . "> " . translate("Saturday");
  ?></TD></TR>

<TR><TD><B><?php etranslate("Frequency")?>:</B></TD>
<TD>
  <INPUT NAME="rpt_freq" SIZE="4" MAXLENGTH="4" VALUE="<?php echo $rpt_freq; ?>">
 </TD>
</TR>

</TABLE>

<TABLE BORDER=0><TR><TD>
<SCRIPT LANGUAGE="JavaScript">
  document.writeln ( '<INPUT TYPE="button" VALUE="<?php etranslate("Save")?>" ONCLICK="validate_and_submit()">' );
  document.writeln ( '<INPUT TYPE="button" VALUE="<?php etranslate("Help")?>..." ONCLICK="window.open ( \'help_edit_entry.php<?php if ( ! isset ( $id ) ) echo "?add=1"; ?>\', \'cal_help\', \'dependent,menubar,scrollbars,height=400,width=400,innerHeight=420,outerWidth=420\');">' );
</SCRIPT>

<NOSCRIPT>
<INPUT TYPE="submit" VALUE="<?php etranslate("Save")?>">
</NOSCRIPT>

</TD></TR></TABLE>

<INPUT TYPE="hidden" NAME="participant_list" VALUE="">

</FORM>

<?php if ( $id > 0 && ( $login == $create_by || strlen ( $single_user_login ) || $is_admin ) ) { ?>
<A HREF="del_entry.php?id=<?php echo $id;?>" onClick="return confirm('<?php etranslate("Are you sure you want to delete this entry?")?>');"><?php etranslate("Delete entry")?></A><BR>
<?php } ?>
<?php
} else {
  echo translate("You are not authorized to edit this entry") . ".";
}
?>

<?php include "includes/trailer.inc"; ?>
</BODY>
</HTML>

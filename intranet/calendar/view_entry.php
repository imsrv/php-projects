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

if ( $year ) $thisyear = $year;
if ( $month ) $thismonth = $month;
$pri[1] = translate("Low");
$pri[2] = translate("Medium");
$pri[3] = translate("High");

$unapproved = FALSE;

?>
<HTML>
<HEAD>
<TITLE><?php etranslate("Title")?></TITLE>
<?php include "includes/styles.inc"; ?>
</HEAD>
<BODY BGCOLOR="<?php echo $BGCOLOR; ?>">

<?php

if ( $id < 1 ) {
  echo translate("Invalid entry id") . ".";
  exit;
}

// first see who has access to view this entry
$is_my_event = false;
$sql = "SELECT cal_id FROM webcal_entry_user " .
  "WHERE cal_login = '$login' AND cal_id = $id";
$res = dbi_query ( $sql );
if ( $res ) {
  $row = dbi_fetch_row ( $res );
  if ( $row[0] == $id )
    $is_my_event = true;
  dbi_free_result ( $res );
}

// get the email adress of the creator of the entry
$sql = "SELECT cal_email FROM webcal_user, webcal_entry " .
  "WHERE cal_login = webcal_entry.cal_create_by " .
  "AND webcal_entry.cal_id = $id ";
$res = dbi_query ( $sql );
if ( $res ) {
  $row = dbi_fetch_row( $res );
  $email_addr = $row[0];
  dbi_free_result ( $res );
}


$sql = "SELECT cal_create_by, cal_date, cal_time, cal_mod_date, " .
  "cal_mod_time, cal_duration, cal_priority, cal_type, cal_access, " .
  "cal_name, cal_description FROM webcal_entry WHERE cal_id = " . $id;
$res = dbi_query ( $sql );
if ( ! $res ) {
  echo translate("Invalid entry id") . ": $id";
  exit;
}
$row = dbi_fetch_row ( $res );
$create_by = $row[0];
$name = $row[9];
$description = $row[10];

// If confidential and not this user's event, then
// They cannot seem name or description.
//if ( $row[8] == "R" && ! $is_my_event && ! $is_admin ) {
if ( $row[8] == "R" && ! $is_my_event ) {
  $is_private = true;
  $name = "[" . translate("Confidential") . "]";
  $description = "[" . translate("Confidential") . "]";
} else {
  $is_private = false;
}

// TO DO: don't let someone view another user's private entry
// by hand editing the URL.

?>
<H2><FONT COLOR="<?php echo $H2COLOR;?>"><?php echo htmlspecialchars ( $name ); ?></FONT></H2>

<TABLE BORDER=0>
<TR><TD VALIGN="top"><B><?php etranslate("Description")?>:</B></TD>
  <TD><?php echo htmlspecialchars ( $description ); ?></TD></TR>
<TR><TD VALIGN="top"><B><?php etranslate("Date")?>:</B></TD>
  <TD><?php echo date_to_str ( $row[1] ); ?></TD></TR>
<?php
// save date so the trailer links are for the same time period
$list = split ( "-", $row[1] );
$thisyear = (int) ( $row[1] / 10000 );
$thismonth = ( $row[1] / 100 ) % 100;
$thisday = $row[1] % 100;
?>
<?php if ( $row[2] >= 0 ) { ?>
<TR><TD VALIGN="top"><B><?php etranslate("Time")?>:</B></TD>
  <TD><?php echo display_time ( $row[2] ); ?></TD></TR>
<?php } ?>
<?php if ( $row[5] > 0 ) { ?>
<TR><TD VALIGN="top"><B><?php etranslate("Duration")?>:</B></TD>
  <TD><?php echo $row[5]; ?> <?php etranslate("minutes")?></TD></TR>
<?php } ?>
<TR><TD VALIGN="top"><B><?php etranslate("Priority")?>:</B></TD>
  <TD><?php echo $pri[$row[6]]; ?></TD></TR>
<TR><TD VALIGN="top"><B><?php etranslate("Access")?>:</B></TD>
  <TD><?php echo ( $row[8] == "P" ) ? translate("Public") : translate("Confidential"); ?></TD></TR>
<?php
if ( ! strlen ( $single_user_login ) ) {
  echo "<TR><TD VALIGN=\"top\"><B>" . translate("Created by") . ":</B></TD>\n";
  if ( $is_private )
    echo "<TD>[" . translate("Confidential") . "]</TD></TR>\n";
  else {
    if ( strlen ( $email_addr ) )
      echo "<TD><A HREF=\"mailto:$email_addr\">$row[0]</A></TD></TR>\n";
    else
      echo "<TD>$row[0]</TD></TR>\n";
  }
}
?>
<TR><TD VALIGN="top"><B><?php etranslate("Updated")?>:</B></TD>
  <TD><?php
    echo date_to_str ( $row[3] );
    echo " ";
    echo display_time ( $row[4] );
   ?></TD></TR>
<?php
if ( ! strlen ( $single_user_login ) ) {
?>
<TR><TD VALIGN="top"><B><?php etranslate("Participants")?>:</B></TD>
  <TD><?php
  if ( $is_private ) {
    echo "[" . translate("Confidential") . "]";
  } else {
    $sql = "SELECT webcal_entry_user.cal_login, webcal_user.cal_lastname, " .
      "webcal_user.cal_firstname, webcal_entry_user.cal_status " .
      "FROM webcal_entry_user, webcal_user " .
      "WHERE webcal_entry_user.cal_id = $id AND " .
      "webcal_entry_user.cal_login = webcal_user.cal_login";
      "webcal_entry_user.cal_status == 'A' " .
      "OR webcal_entry_user.cal_status == 'W' )";
    //echo "$sql<P>\n";
    $res = dbi_query ( $sql );
    $first = 1;
    $num_app = $num_wait = $num_rej = 0;
    while ( $row = dbi_fetch_row ( $res ) ) {
      if ( strlen ( $row[1] ) > 0 )
        $pname = "$row[1], $row[2]";
      else
        $pname = "$row[0]";
      if ( $login == $row[0] && $row[3] == 'W' )
        $unapproved = TRUE;
      if ( $row[3] == 'A' )
        $approved[$num_app++] = $pname;
      else if ( $row[3] == 'W' )
        $waiting[$num_wait++] = $pname;
      else if ( $row[3] == 'R' )
        $rejected[$num_rej++] = $pname;
    }
    dbi_free_result ( $res );
  }
  for ( $i = 0; $i < $num_app; $i++ ) {
    echo $approved[$i] . "<BR>\n";
  }
  for ( $i = 0; $i < $num_wait; $i++ ) {
    echo "<BR>" . $waiting[$i] . " (?)\n";
  }
  for ( $i = 0; $i < $num_rej; $i++ ) {
    echo "<BR>" . $rejected[$i] . " (" . translate("Rejected") . ")\n";
  }
?></TD></TR>
<?php
}
?>
</TABLE>

<P>
<?php
if ( $unapproved ) {
  echo "<A HREF=\"approve_entry.php?id=$id\" onClick=\"return confirm('" .
    translate("Approve this entry?") .
    "');\">" . translate("Approve/Confirm entry") . "</A><BR>\n";
  echo "<A HREF=\"reject_entry.php?id=$id\" onClick=\"return confirm('" .
    translate("Reject this entry?") .
    "');\">" . translate("Reject entry") . "</A><BR>\n";
}

if ( $login == $create_by || strlen ( $single_user_login ) || $is_admin ) {
  echo "<A HREF=\"edit_entry.php?id=$id\">" .
    translate("Edit entry") . "</A><BR>\n";
  echo "<A HREF=\"del_entry.php?id=$id\" onClick=\"return confirm('" .
    translate("Are you sure you want to delete this entry?") .
    "\\n\\n" . translate("This will delete this entry for all users.") .
    "');\">" . translate("Delete entry") . "</A><BR>\n";
}
?>

<?php include "includes/trailer.inc"; ?>
</BODY>
</HTML>

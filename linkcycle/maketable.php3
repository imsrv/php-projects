<?
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * LinkCycle version 2.0
 *
 * Copyright (c) 2002 Holotech Enterprises (linkcycle@holotech.net)
 *
 * You may freely distribute this script as-is, without modifications,
 * and with the accompanying files. You may use this script freely, and
 * modify it for your own purposes. This script is email-ware: if you
 * find it useful, you MUST e-mail me and let me know. This IS the pay-
 * ment that is required. If you do not make this payment, then you are
 * using this program illegally.
 *
 * Version 2.0 development sponsored by
 *   Creative Innovations
 *   http://get-signups.com/
 * 
 *                                                 Alan Little
 *                                                 May 2002
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>
<HTML>
<HEAD>
<TITLE>LinkCycle Database Set Up</TITLE>
</HEAD>
<BODY BGCOLOR=#C0C0FF>

<?php
  require ("conphig.php3");

  $ID = @mysql_pconnect($DHost, $DUser, $DPass)
   or die ("Unable to connect to the LinkCycle database.");
  @mysql_select_db($DBase, $ID)
   or die ("Unable to select the LinkCycle database.");

  if (MySQL_Query("select * from LinkCycle", $ID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "There is already a table named \"LinkCycle\" in $DBase.";
    echo "<BR>Unable to create the LinkCycle database.";
    exit;
  endif;

  $Create_Query = 
  "CREATE TABLE LinkCycle (".
  "LKey     int(11)       DEFAULT '0' NOT NULL auto_increment, ".
  "Text     varchar(255)  DEFAULT '', ".
  "Link     varchar(255)  DEFAULT '', ".
  "LGroup   varchar(10)   DEFAULT '001', ".
  "Imps     int(11)       DEFAULT 0, ".
  "Hits     int(11)       DEFAULT 0, ".
  "ITab     int(11)       DEFAULT 0, ".
  "HTab     int(11)       DEFAULT 0, ".
  "ITimeTab time          DEFAULT '12:00:00', ".
  "HTimeTab time          DEFAULT '12:00:00', ".
  "PRIMARY KEY (LKey))";

  if (!MySQL_Query($Create_Query, $ID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "Unable to create the LinkCycle table in $DBase.";
    exit;
  endif;

  $Create_Query = 
  "CREATE TABLE LinkHits (".
  "TKey    int(11), ".
  "IP      varchar(15), ".
  "TStamp  timestamp)";

  if (!MySQL_Query($Create_Query, $ID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "Unable to create the LinkHits table in $DBase.";
    exit;
  endif;

  MySQL_Query(
    "insert into LinkCycle ".
    "values (0, ".
    "'Holotech Enterprises expert, affordable web design', ".
    "'http://www.holotech.net/', ".
    "'001', ".
    "10, ".
    "10, ".
    "1, ".
    "1, ".
    "'',".
    "'')",
    $ID
  );
?>

<BR><BR>
<FONT SIZE=4>
LinkCycle and LinkHits tables successfully created in <?php echo $DBase ?>.
</FONT>

</BODY>
</HTML>
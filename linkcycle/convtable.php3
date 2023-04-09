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
<TITLE>LinkCycle Database Conversion</TITLE>
</HEAD>
<BODY BGCOLOR=#C0C0FF>

<?php
  require ("conphig.php3");

  $dbID = @mysql_pconnect($DHost, $DUser, $DPass)
   or die ("Unable to connect to the LinkCycle database.");
  @mysql_select_db($DBase, $dbID)
   or die ("Unable to select the LinkCycle database.");

  if (!MySQL_Query("select * from LinkCycle", $dbID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "There is no table named \"LinkCycle\" to convert in $DBase.";
    echo "<BR>You must run the <A HREF=\"maketable.php3\">maketable.php3</A> script to create it.";
    exit;
  endif;

  $Query = "create table LinkCycleConvert select * from LinkCycle";
  MySQL_Query($Query, $dbID);

  $Query = "drop table LinkCycle";
  MySQL_Query($Query, $dbID);

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

  if (!MySQL_Query($Create_Query, $dbID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "Unable to create the LinkCycle table in $DBase.";
    exit;
  endif;

  $Query =
  "insert ".
  "into   LinkCycle (LKey, Text, Link, ITab, ITimeTab) ".
  "select * ".
  "from   LinkCycleConvert";
  MySQL_Query($Query, $dbID);

  $Query = "drop table LinkCycleConvert";
  MySQL_Query($Query, $dbID);

  $Query =
  "update LinkCycle ".
  "set    Hits=-1, Imps=-1";
  MySQL_Query($Query, $dbID);

  $Query =
  "select min(lkey) ".
  "from   LinkCycle";
  $Result = MySQL_Query($Query, $dbID);

  list($FirstKey) = MySQL_Fetch_Row($Result);

  $Query =
  "update LinkCycle ".
  "set    HTab = 1 ".
  "where  LKey=$FirstKey";
  MySQL_Query($Query, $dbID);

  $Create_Query = 
  "CREATE TABLE LinkHits (".
  "TKey    int(11), ".
  "IP      varchar(15), ".
  "TStamp  timestamp)";

  if (!MySQL_Query($Create_Query, $dbID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "Unable to create the LinkHits table in $DBase.";
    exit;
  endif;
?>

<BR><BR>
<FONT SIZE=4>
LinkCycle table successfully converted and LinkHits table successfully created in <?php echo $DBase ?>.
</FONT>

</BODY>
</HTML>
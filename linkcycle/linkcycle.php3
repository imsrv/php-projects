<?php
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
  include("conphig.php3");

  if (file_exists("linksched.inc")) {
    include("linksched.inc");
    $Schedule = ereg_replace("\r|\n| ", "", $Schedule);
    $Hours = explode(",", $Schedule);
    $HitSchedule = ereg_replace("\r|\n| ", "", $HitSchedule);
    $HitHours = explode(",", $HitSchedule);
  }

  $dbID = @mysql_pconnect($DHost, $DUser, $DPass)
   or die ("Unable to connect to LinkCycle database.");
  @mysql_select_db($DBase, $dbID)
   or die ("Unable to select LinkCycle database.");

// If the Query String starts with I or H, the rest is a link group; otherwise
// the entire thing is a link key.
  $LinkKey = $argv[0];
  if (ereg("^([IH])(.*)", $LinkKey, $regs)) {
    $LinkMode = $regs[1];
    $LinkGrp  = $regs[2];
  }

  if (!$LinkMode) $LinkMode = "H";
  if (!$LinkKey)  $LinkMode = "I";

/****************************************
 * Link Mode H: Link Hit
 ****************************************/
  if ($LinkMode == "H") {

    if ($LinkGrp)
      $Query =
      "select LKey, Link, Hits, HTab, HTimeTab ".
      "from   LinkCycle ".
      "where  LGroup = '$LinkGrp' ".
      "  and  HTab > 0 ".
      "  and  Hits not in (0, -2)";

    else
      $Query =
      "select LKey, Link, Hits, HTab, HTimeTab ".
      "from   LinkCycle ".
      "where  LKey=$LinkKey";

    $Result = MySQL_Query($Query, $dbID);

    if (!MySQL_Num_Rows($Result)) {
      $Query =
      "select Link ".
      "from   LinkCycle ".
      "where  LGroup='$LinkGrp' ".
      "and    Hits=-2";
      $DefResult = MySQL_Query($Query, $dbID);

      if (MySQL_Num_Rows($DefResult)) list($Link) = MySQL_Fetch_Row($DefResult);
      else $Link = $DefaultLink;
    }
    else {
      list($LKey, $Link, $Hits, $HTab, $HTimeTab) = MySQL_Fetch_Array($Result);
      if ($Hits == 0 && $CountHits) $Link = $DefaultLink;
    }

    if (ereg("^([^|]*)\|", $Link, $regs)) $Link = $regs[1];

    if ($TextLog || !isset($TextLog)) {
      $lf = fopen(".lclog", "a");
      fputs($lf, $Link);

      while (list(, $LogVar) = each ($LogData)) fputs($lf, " ".$$LogVar);

      fputs($lf, "\n");
      fclose($lf);
    }

    if ($DBLog) {
      $Query =
      "insert ".
      "into   LinkHits ".
      "values ($LKey, '$REMOTE_ADDR', null)";
      MySQL_Query($Query, $dbID);
    }

    if ($LinkGrp) {
//    Determine whether it's time to update the link
      $MTab = 1;
      $CycleLink = false;

      if ($HitPeriod == 0) {                  /* Every hit */
        $CycleLink = true;
      }
      if ($HitPeriod < 0) {                   /* Once a month on the given day */
        $mPeriod = abs($HitPeriod);
        $MTab = date("d");
        if ( ($mPeriod == date("d")
          || ($mPeriod > date("t") && date("d") == date("t")))
          &&  $MTab != $HTab) $CycleLink = true;
      }
      if ($HitPeriod > 0 && $HitPeriod < 8) { /* Once a week on the given day */
        $MTab = date("w") + 1;
        if ($HitPeriod == $MTab && $HTab != $MTab) $CycleLink = true;
      }
      if ($HitPeriod == 8) {                  /* Every hour */
        $MTab = date("H");
        if ($MTab != $HTab) $CycleLink = true;
      }
      if ($HitPeriod == 9) {                  /* Every 12 hours */
        $MTab = date("h");
        if ($MTab == $HTab) $CycleLink = true;
      }
      if ($HitPeriod == 10) {                 /* Every day */
        $MTab = date("z");
        if ($MTab != $HTab) $CycleLink = true;
      }
      if ($HitPeriod == 11) {                 /* According to schedule */
        $tt = split(":", $HTimeTab);
        $TimeTab = mktime($tt[0], $tt[1], $tt[2]);
        $Now = mktime();

        for ($i=0; $HitHours[$i]; $i++) {
          $sched = split(":", $HitHours[$i]);
          $Sched = mktime($sched[0], $sched[1], 0);

//        echo "<!-- $TimeTab, $Sched ($HitHours[$i]), $Now -->\n";

          if ($TimeTab < $Sched && $Now > $Sched && !$CycleLink) {
//          echo "<!-- ^^ Incremented                             -->\n";
            $CycleLink = true;
          }
        }
      }

      if ($Hits == 1) $CycleLink = true;

      if ($CycleLink) {
        $Query =
        "select LKey, HTab ".
        "from   LinkCycle ".
        "where  LGroup='$LinkGrp' ".
        "  and  Hits not in (0, -2)";

        $Result = MySQL_Query($Query, $dbID);
        $NumLinks = MySQL_Num_Rows($Result);

        list($SKey) = MySQL_Fetch_Row($Result);
        $FirsLKey = $SKey;

        do {
          if ($SetTab) {
            $NewTab = $SKey;
            $SetTab = false;
          }
          if ($SKey == $LKey) {
            $OldTab = $SKey;
            $SetTab = true;
          }
        } while (list($SKey) = MySQL_Fetch_Row($Result));
        if ($SetTab) $NewTab = $FirsLKey;
      }

      if ($OldTab != $NewTab) {
        $Query =
        "update LinkCycle ".
        "set    HTab = 0 ".
        "where  LKey = $OldTab";
        MySQL_Query($Query, $dbID);

        $Query =
        "update LinkCycle ".
        "set    HTab = $MTab, HTimeTab='".date("H:i:s")."' ".
        "where  LKey = $NewTab";
        MySQL_Query($Query, $dbID);
      }

      if ($CountHits && $Hits > 0) {
        $Query =
        "update LinkCycle ".
        "set    Hits=Hits-1 ".
        "where  LKey=$LKey";
        MySQL_Query($Query, $dbID);
      }
    }

    Header("Location: $Link");
    exit;
  }

/****************************************
 * Link Mode I: Link Impression
 ****************************************/
  if ($LinkMode == "I") {

    if (!$LinkGrp) $LinkGrp = "001";

    $Query =
    "select LKey, Text, Link, Imps, ITab, ITimeTab ".
    "from   LinkCycle ".
    "where  LGroup = '$LinkGrp' ".
    "  and  ITab > 0 ".
    "  and  Imps not in (0, -2)";

    $Result = MySQL_Query($Query, $dbID);

    $GotLink = true;
    if (!MySQL_Num_Rows($Result)) {
      $GotLink = false;
      $Query =
      "select Text, Link ".
      "from   LinkCycle ".
      "where  LGroup='$LinkGrp' ".
      "and    Imps=-2";
      $DefResult = MySQL_Query($Query, $dbID);

      if (MySQL_Num_Rows($DefResult)) list($Text, $Link) = MySQL_Fetch_Row($DefResult);
      else {
        $Link = $DefaultLink;
        $Text = $DefaultText;
      }
    }
    else {
      list($LKey, $Text, $Link, $Imps, $ITab, $ITimeTab) = MySQL_Fetch_Array($Result);
      if ($Imps == 0 && $CountImps) {
        $GotLink = false;
        $Link = $DefaultLink;
        $Text = $DefaultText;
      }
    }

    $Text = StripSlashes($Text);
    $Link = StripSlashes($Link);

//  Check for optional JavaScript code for the link.
    $JS = "";

    if (ereg("^([^|]*)\|(.*)", $Link, $regs)) {
      $Link = $regs[1];
      $JS = $regs[2];
    }

    echo "<!-- $Link -->\n";

    if ($GotLink) $HREF = "<A HREF=\"$ScriptURL?$LKey\"$JS>";
    else          $HREF = "<A HREF=\"$Link\"$JS>";

//  If there are no braces in the text, add them to the beginning and end
//  of the text
    if (!ereg("{{", $Text)) {
      $Text = ereg_replace("^", "{{", $Text);
      $Text = ereg_replace("$", "}}", $Text);
    }
//  Replace the braces with the Anchor tags
    $Text = ereg_replace("{{", $HREF, $Text);
    $Text = ereg_replace("}}", "</A>\n\n", $Text);
    echo $Text;

//  Determine whether it's time to update the link
    $MTab = 1;
    $CycleLink = false;

    if ($HitPeriod == 0) {                  /* Every hit */
      $CycleLink = true;
    }
    if ($HitPeriod < 0) {                   /* Once a month on the given day */
      $mPeriod = abs($HitPeriod);
      $MTab = date("d");
      if ( ($mPeriod == date("d")
        || ($mPeriod > date("t") && date("d") == date("t")))
        &&  $MTab != $ITab) $CycleLink = true;
    }
    if ($HitPeriod > 0 && $HitPeriod < 8) { /* Once a week on the given day */
      $MTab = date("w") + 1;
      if ($HitPeriod == $MTab && $ITab != $MTab) $CycleLink = true;
    }
    if ($HitPeriod == 8) {                  /* Every hour */
      $MTab = date("H");
      if ($MTab != $ITab) $CycleLink = true;
    }
    if ($HitPeriod == 9) {                  /* Every 12 hours */
      $MTab = date("h");
      if ($MTab == $ITab) $CycleLink = true;
    }
    if ($HitPeriod == 10) {                 /* Every day */
      $MTab = date("z");
      if ($MTab != $ITab) $CycleLink = true;
    }
    if ($HitPeriod == 11) {                 /* According to schedule */
      $tt = split(":", $ITimeTab);
      $TimeTab = mktime($tt[0], $tt[1], $tt[2]);
      $Now = mktime();

      for ($i=0; $Hours[$i]; $i++) {
        $sched = split(":", $Hours[$i]);
        $Sched = mktime($sched[0], $sched[1], 0);

//      echo "<!-- $TimeTab, $Sched ($Hours[$i]), $Now -->\n";

        if ($TimeTab < $Sched && $Now > $Sched && !$CycleLink) {
//        echo "<!-- ^^ Incremented                             -->\n";
          $CycleLink = true;
        }
      }
    }

    if ($Imps == 1) $CycleLink = true;

    if ($CycleLink) {
      $Query =
      "select LKey, ITab ".
      "from   LinkCycle ".
      "where  LGroup='$LinkGrp' ".
      "  and  Imps not in (0, -2)";

      $Result = MySQL_Query($Query, $dbID);
      $NumLinks = MySQL_Num_Rows($Result);

      list($SKey) = MySQL_Fetch_Row($Result);
      $FirsLKey = $SKey;

      do {
        if ($SetTab) {
          $NewTab = $SKey;
          $SetTab = false;
        }
        if ($SKey == $LKey) {
          $OldTab = $SKey;
          $SetTab = true;
        }
      } while (list($SKey) = MySQL_Fetch_Row($Result));
      if ($SetTab) $NewTab = $FirsLKey;
    }

    if ($OldTab != $NewTab) {
      $Query =
      "update LinkCycle ".
      "set    ITab = 0 ".
      "where  LKey = $OldTab";
      MySQL_Query($Query, $dbID);

      $Query =
      "update LinkCycle ".
      "set    ITab = $MTab, ITimeTab='".date("H:i:s")."' ".
      "where  LKey = $NewTab";
      MySQL_Query($Query, $dbID);
    }

    if ($CountImps && $Imps > 0) {
      $Query =
      "update LinkCycle ".
      "set    Imps=Imps-1 ".
      "where  LKey=$LKey";
      MySQL_Query($Query, $dbID);
    }

  }
?>
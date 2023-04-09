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
<TITLE>LinkCycle Maintenance</TITLE>
</HEAD>

<BODY BGCOLOR=WHITE>
<?
  include ("conphig.php3");

  $dbID = @mysql_connect($DHost, $DUser, $DPass);
  if (!$dbID) { 
    echo "<BR><BR><BR><FONT SIZE=4>".
         "Sorry, there was an error connecting to the Link database.".
         " Please try again.</FONT>"; }

  else {
    $selected = @mysql_select_db($DBase, $dbID);
    if (!$selected) { 
    echo "<BR><BR><BR><FONT SIZE=4>".
         "Sorry, there was an error opening the Link database.".
         " Please try again.</FONT>"; }
  }

  if (!$dbID or !$selected) {
    exit;
  }

  if ($REQUEST_METHOD == "POST") {
    while (list($key, $val) = each($HTTP_POST_VARS)) {
      if (ereg("^Delete(.*)_x", $key, $regs)) {
        $Mode = "del";
        $AKey = $regs[1];
        break;
      }
      if (ereg("^Update(.*)_x", $key, $regs)) {
        $Mode = "upd";
        $AKey = $regs[1];
        break;
      }
      if (ereg("^(...)Add_x", $key, $regs)) {
        $Mode = "add";
        $AKey = $regs[1];
        break;
      }
    }
  }

  switch ($Mode) {
//                                                          DELETE
  case "del" :
    $Query =
    "select * ".
    "from   LinkCycle ".
    "where  LKey=$AKey";
    $Result = MySQL_Query($Query, $dbID);
    $Deleted = MySQL_Fetch_Array($Result);

    $Query =
    "delete ".
    "from   LinkCycle ".
    "where  LKey=$AKey";
    MySQL_Query($Query, $dbID);

//  Move the ITab if necessary
    $CheckTab = $cITab[$AKey];
    $TabVal   = $ITab[$AKey];
    if ($CheckTab) {
      $Query =
      "select LKey ".
      "from   LinkCycle ".
      "where  LGroup='$CheckTab' ".
      "  and  Imps <> 0";
      $Result = MySQL_Query($Query, $dbID);
      if (!MySQL_Num_Rows($Result)) {
        $Query =
        "select LKey ".
        "from   LinkCycle ".
        "where  LGroup='$CheckTab'";
        $Result = MySQL_Query($Query, $dbID);
      }
      if (MySQL_Num_Rows($Result)) {
        list($TKey) = MySQL_Fetch_Row($Result);
        $Query =
        "update LinkCycle ".
        "set    ITab=$TabVal ".
        "where  LKey = $TKey";
        MySQL_Query($Query, $dbID);
      }
    }

//  Move the HTab if necessary
    $CheckTab = $cHTab[$AKey];
    $TabVal   = $HTab[$AKey];
    if ($CheckTab) {
      $Query =
      "select LKey ".
      "from   LinkCycle ".
      "where  LGroup='$CheckTab' ".
      "  and  Hits <> 0";
      $Result = MySQL_Query($Query, $dbID);
      if (!MySQL_Num_Rows($Result)) {
        $Query =
        "select LKey ".
        "from   LinkCycle ".
        "where  LGroup='$CheckTab'";
        $Result = MySQL_Query($Query, $dbID);
      }
      if (MySQL_Num_Rows($Result)) {
        list($TKey) = MySQL_Fetch_Row($Result);
        $Query =
        "update LinkCycle ".
        "set    HTab=$TabVal ".
        "where  LKey = $TKey";
        MySQL_Query($Query, $dbID);
      }
    }
    break;

//                                                          UPDATE
  case "upd" :
    $TabGroup = $LGroup[$AKey];

    $var = "ITabs$TabGroup"; $cITab = $$var;
    $var = "HTabs$TabGroup"; $cHTab = $$var;

    $PrevITab  = $ITabKey[$TabGroup];
    $CurrITab  = $cITab;
    $PrevHTab  = $HTabKey[$TabGroup];
    $CurrHTab  = $cHTab;

    if ($PrevITab != $CurrITab) {
      $Query =
      "update LinkCycle ".
      "set    ITab=0 ".
      "where  LKey=$PrevITab";
      MySQL_Query($Query, $dbID);

      $TabVal = $HTab[$PrevITab];
      $Query =
      "update LinkCycle ".
      "set    ITab=$TabVal ".
      "where  LKey=$CurrITab";
      MySQL_Query($Query, $dbID);
    }

    if ($PrevHTab != $CurrHTab) {
      $Query =
      "update LinkCycle ".
      "set    HTab=0 ".
      "where  LKey=$PrevHTab";
      MySQL_Query($Query, $dbID);

      $TabVal = $HTab[$PrevHTab];
      $Query =
      "update LinkCycle ".
      "set    HTab=$TabVal ".
      "where  LKey=$CurrHTab";
      MySQL_Query($Query, $dbID);
    }

    $Text[$AKey] = AddSlashes($Text[$AKey]);
    $Query =
    "update LinkCycle ".
    "set    Text='$Text[$AKey]', Link='$Link[$AKey]', Imps=$Imps[$AKey], Hits=$Hits[$AKey] ".
    "where  LKey=$AKey";
    MySQL_Query($Query, $dbID);
    break;

//                                                                        ADD
  case "add" :
    if ($AKey == "Old") $iKey = $OldKey;
    if ($AKey == "New") $iKey = 0;

    $iITab = ($Groups[$LGroup[$iKey]])? 0 : 1;
    $iHTab = ($Groups[$LGroup[$iKey]])? 0 : 1;

    $Text[$iKey] = AddSlashes($Text[$iKey]);
    $Query =
    "insert ".
    "into   LinkCycle ".
    "       (LKey, Text, Link, LGroup, Imps, Hits, ITab, HTab, ITimeTab, HTimeTab) ".
    "values ($iKey, '$Text[$iKey]', '$Link[$iKey]', '$LGroup[$iKey]', $Imps[$iKey], $Hits[$iKey], ".
    "        $iITab, $iHTab, '$ITimeTab[$iKey]', '$HTimeTab[$iKey]')";

    MySQL_Query($Query, $dbID);
    break;
  }
?>

<!-- You can insert any page header stuff here if you want -->

Group codes can be up to 10 characters and consist of numbers and letters.
<BR><BR>

<FORM NAME="Linkz" METHOD=POST ACTION="linkmaint.php3?upd0">
<TABLE WIDTH=95% BORDER=0 CELLSPACING=0>
<TR>
  <TD><B>Key</B></TD>
  <TD COLSPAN=2><B>Group</B></TD>
  <TD><B>Imps</B></TD>
  <TD><B>Hits</B></TD>
  <TD><B>Text / Link</B></TD>
</TR>

<?
  if ($Mode == "del") {
  $DKey = $Deleted['LKey']
?>
<TR>
  <INPUT TYPE=HIDDEN NAME="OldKey" VALUE="<?echo $DKey?>">
  <INPUT TYPE=HIDDEN NAME="ITimeTab[<?echo $DKey?>]" VALUE="<?echo $Deleted['ITimeTab']?>">
  <INPUT TYPE=HIDDEN NAME="HTimeTab[<?echo $DKey?>]" VALUE="<?echo $Deleted['HTimeTab']?>">
  <TD><B><B><?echo $AKey?></B></B></TD>
  <TD COLSPAN=2><INPUT TYPE=TEXT NAME="LGroup[<?echo $DKey?>]" VALUE="<?echo $Deleted['LGroup']?>" SIZE=5></TD>
  <TD><INPUT TYPE=TEXT NAME="Imps[<?echo $DKey?>]" VALUE="<?echo $Deleted['Imps']?>" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Hits[<?echo $DKey?>]" VALUE="<?echo $Deleted['Hits']?>" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Text[<?echo $DKey?>]"  VALUE="<?echo $Deleted['Text']?>"SIZE=60></TD>
</TR>
<TR>
  <TD COLSPAN=5 ALIGN=RIGHT><INPUT TYPE=IMAGE NAME="OldAdd" SRC="addbutn.gif" BORDER=0>&nbsp;&nbsp;&nbsp;</TD>
  <TD><INPUT TYPE=TEXT NAME="Link[<?echo $DKey?>]"  VALUE="<?echo $Deleted['Link']?>"SIZE=60></TD>
</TR>
<?
  }
?>

<TR>
  <TD><B>0</B></TD>
  <TD COLSPAN=2><INPUT TYPE=TEXT NAME="LGroup[0]" VALUE="001" SIZE=5></TD>
  <TD><INPUT TYPE=TEXT NAME="Imps[0]" VALUE="-1" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Hits[0]" VALUE="-1" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Text[0]" SIZE=60></TD>
</TR>
<TR>
  <TD COLSPAN=5 ALIGN=RIGHT><INPUT TYPE=IMAGE NAME="NewAdd" SRC="addbutn.gif" BORDER=0>&nbsp;&nbsp;&nbsp;</TD>
  <TD><INPUT TYPE=TEXT NAME="Link[0]" SIZE=60></TD>
</TR>

<TR><TD COLSPAN=6>&nbsp;</TD></TR>
<TR><TD BGCOLOR=SILVER COLSPAN=6><IMG SRC="clear.gif" WIDTH=1 HEIGHT=1></TD></TR>
<TR><TD COLSPAN=6>&nbsp;</TD></TR>

<?
  $Query =
  "select LKey, Text, Link, LGroup, Hits, Imps, HTab, ITab ".
  "from   LinkCycle ".
  "order  by LGroup, LKey";
  $Result = MySQL_Query($Query, $dbID);

  $NumRows = MySQL_Num_Rows($Result);

  echo "
<TR>
  <TD COLSPAN=6>
    <B>I</B> and <B>H</B> indicate the next link to display or hit, respectively.<BR>
    Set <B>Hits</B> or <B>Imps</B> (impressions) to -1 to allow unlimited.<BR>
    Set <B>Hits</B> or <B>Imps</B> to -2 to indicate the default link for the group.
    <BR><BR>

    $NumRows links:
  </TD>
</TR>";

  while (list($LKey, $Text, $Link, $LGroup, $Hits, $Imps, $HTab, $ITab) = MySQL_Fetch_Row($Result)) {
    $iCHECKED = ($ITab)? " CHECKED" : "";
    $hCHECKED = ($HTab)? " CHECKED" : "";
    if ($iCHECKED) {
      echo "<INPUT TYPE=HIDDEN NAME=\"cITab[$LKey]\" VALUE='$LGroup'>\n";
      echo "<INPUT TYPE=HIDDEN NAME=\"ITabKey[$LGroup]\" VALUE='$LKey'>\n";
    }
    if ($hCHECKED) {
      echo "<INPUT TYPE=HIDDEN NAME=\"cHTab[$LKey]\" VALUE='$LGroup'>\n";
      echo "<INPUT TYPE=HIDDEN NAME=\"HTabKey[$LGroup]\" VALUE='$LKey'>\n";
    }
    if ($LGroup != $LastGroup) {
      $Default = ($LGroup == "001")? "(Default)" : "";
      $LastGroup = $LGroup;
      echo "
<TR><TD COLSPAN=6><BR><FONT SIZE=4><B>Group $LGroup</B> $Default</FONT></TD></TR>
<TR>
  <TD><B>Key</B></TD>
  <TD>&nbsp;<B>I</B></TD>
  <TD>&nbsp;<B>H</B></TD>
  <TD><B>Imps</B></TD>
  <TD><B>Hits</B></TD>
  <TD><B>Text / Link</B></TD>
</TR>
<INPUT TYPE=HIDDEN NAME=\"Groups[$LGroup]\" VALUE=1>
";
    }
?>
<TR>
  <INPUT TYPE=HIDDEN NAME="ITab[<?echo $LKey?>]" VALUE="<?echo $ITab?>">
  <INPUT TYPE=HIDDEN NAME="HTab[<?echo $LKey?>]" VALUE="<?echo $HTab?>">
  <INPUT TYPE=HIDDEN NAME="LGroup[<?echo $LKey?>]" VALUE="<?echo $LGroup?>">
  <TD><B><?echo $LKey?></B></TD>
  <TD><INPUT TYPE=RADIO NAME="ITabs<?echo $LGroup?>" VALUE=<?echo $LKey?><?echo $iCHECKED?>></TD>
  <TD><INPUT TYPE=RADIO NAME="HTabs<?echo $LGroup?>" VALUE=<?echo $LKey?><?echo $hCHECKED?>></TD>
  <TD><INPUT TYPE=TEXT NAME="Imps[<?echo $LKey?>]" VALUE="<?echo $Imps?>" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Hits[<?echo $LKey?>]" VALUE="<?echo $Hits?>" SIZE=4></TD>
  <TD><INPUT TYPE=TEXT NAME="Text[<?echo $LKey?>]" VALUE="<?echo $Text?>" SIZE=60></TD>
</TR>
<TR>
  <TD COLSPAN=5 ALIGN=RIGHT>
    <INPUT TYPE=IMAGE NAME="Delete<?echo $LKey?>" SRC="delbutn.gif" BORDER=0>&nbsp;&nbsp;&nbsp;
    <INPUT TYPE=IMAGE NAME="Update<?echo $LKey?>" SRC="updbutn.gif" BORDER=0>&nbsp;&nbsp;&nbsp;
  </TD>
  <TD><INPUT TYPE=TEXT NAME="Link[<?echo $LKey?>]" VALUE="<?echo $Link?>" SIZE=60></TD>
</TR>
<? } ?>

</TABLE>
</FORM>

<CENTER>
<FONT SIZE=1>
<A HREF="http://www.holotech.net/">
LinkMaint v2.0</A>
</FONT>
</CENTER>

<BR><BR><BR>
</BODY>
</HTML>
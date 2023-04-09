<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

include ("defaults_inc.php");
/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;//the error message is printed in connect_db_inc.php
}

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<title><?echo $TOPLIST?></title>
<style type="text/css">
<!--
.text { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style> 
</head>
<BODY BACKGROUND="<?echo $BG_IMAGE?>" LINK="#0000FF" VLINK="#0000FF" ALINK="#0000FF" class="text">
<TABLE WIDTH="590" CLASS="text">
<tr>
<td class="text">
<font style="font-size: 24px;"><b><?echo $TOPLIST?></b></font>
<br><br>
<?
$result=mysql_query("SELECT Nick, Online, Zeit, Raum FROM chat_data ORDER BY Online DESC",$db_handle);
$num=mysql_num_rows($result);

if($showfirst || (!$showfirst && !$showall)){
  echo "<font style=\"font-size: 12px; color: #8B0000;\">".$TOPLIST_HINT_PART1." </font>";
  echo "<font style=\"font-size: 12px;\">".$TOPLIST_HINT_PART2."</font><BR>";
}
if($showall){
  echo "<font style=\"font-size: 12px;\">".$TOPLIST_HINT_PART3."</font><HR>";
}

if($showfirst || (!$showfirst && !$showall)){
  echo "<BR><DIV ALIGN=\"CENTER\"><TABLE CELLSPACING=\"0\" CELLPADDING=\"0\" BORDER=\"0\">";
  echo "<FORM ACTION=\"toplist.php\" METHOD=\"submit\">";
  echo "<TR><TD CLASS=\"text\" VALIGN=\"MIDDLE\">";
  echo $NICK_NAME.":&nbsp;</TD>";
  echo "<TD><INPUT name=\"search_toplist\" maxlength=\"".$MAX_NICK_LENGTH."\" size=\"".$MAX_NICK_LENGTH."\" value=\"\">";
  echo "&nbsp;<INPUT type=\"submit\" value=\"".$MSG_SEARCH."\"></TD></TR></FORM></TABLE><BR>";
  if($search_toplist){
    $chattersearch=mysql_query("SELECT Nick,Online FROM chat_data WHERE Nick='$search_toplist'",$db_handle);
    $a=@mysql_fetch_array($chattersearch);
    $onlinetime = $a[Online];
    $rank=mysql_query("SELECT count(*) AS count FROM chat_data WHERE Online>=$onlinetime",$db_handle);
    $b=@mysql_fetch_array($rank);
    if($b[count]>0){
      echo "<TABLE ALIGN=\"CENTER\" CELLPADDING=\"5\" CELLSPACING=\"0\" BORDER=\"2\"><TR><TD CLASS=\"text\">".$search_toplist;
      echo "&nbsp;&nbsp;-&nbsp;&nbsp;Platz ".mysql_result($rank,0,"count")."&nbsp;&nbsp;-&nbsp;&nbsp;";
      $std= ceil(($onlinetime / 3600))-1;
      echo $std." Std. & ";
      $min = ceil(($onlinetime % 3600) / 60);
      echo $min." Min.";
      echo "</TD></TR></TABLE><BR>";
    }else{
      echo "<TABLE ALIGN=\"CENTER\" CELLPADDING=\"5\" CELLSPACING=\"0\" BORDER=\"2\"><TR><TD CLASS=\"text\">".$NO_HIT;
      echo "</TD></TR></TABLE><BR></DIV>";
    }
  }
  echo "<HR><BR>";
  echo "<TABLE ALIGN=\"CENTER\" CELLSPACING=\"0\" CELLPADDING=\"3\" BORDER=\"1\" class=\"text\">";
  echo "<TR><TD ALIGN=\"CENTER\" WIDTH=\"30\" class=\"text\"><b>".$MSG_TOPLIST_RANK."</b></TD>";
  echo "<TD ALIGN=\"CENTER\" class=\"text\"><b>".$NICK_NAME."</b></TD>";
  echo "<TD ALIGN=\"CENTER\" class=\"text\"><b>".$MSG_TOPLIST_ONLINE_TIME."</b></TD>";
  echo "<TD ALIGN=\"CENTER\" class=\"text\"><b>".$MSG_TOPLIST_LAST_SEEN."</b></TD>";
  echo "<TD ALIGN=\"CENTER\" class=\"text\"><b>".$CHANNEL."</b></TD></TR>";
  $i=0;
  while($i<=29 && $num>$i){
    $online=mysql_result($result,$i,"Online")-1;
    $zeit=mysql_result($result,$i,"Zeit");
    $raum=mysql_result($result,$i,"Raum");
    $zaehler+=1;
    echo "\n<TR>\t<TD align=\"center\" class=\"text\">".$zaehler.".</TD><TD ";
    if ($zaehler<11){
      echo "BGCOLOR=\"#a0FFa0\"";
    }elseif($zaehler<21){
      echo "BGCOLOR=\"#FFFFa0\"";
    }else{
      echo "BGCOLOR=\"#FFa0a0\""; 
    }
    echo "class=\"text\">";
    $chatternick=mysql_result($result,$i,"Nick");
    echo "$chatternick</TD><TD BGCOLOR=\"#B0B0B0\" class=\"text\"><STRONG>";
    $std= ceil(($online / 3600))-1;
    echo $std." : ";
    $min = ceil(($online % 3600) / 60);
    echo $min."</STRONG> h";
    echo "</TD><TD BGCOLOR=\"#B0B0B0\" class=\"text\">";
    echo date("d.m.Y - H:i",$zeit);
    echo "</TD><TD BGCOLOR=\"#B0B0B0\" class=\"text\">$raum";
    $i++;
  }
  echo "</TD></TR></TABLE><BR>";
  echo "<FORM ACTION=\"toplist.php\" METHOD=\"POST\">";
  echo "<DIV ALIGN=\"CENTER\" CLASS=\"text\"><INPUT type=\"submit\" name=\"showall\" value=\"$MSG_TOPLIST_SHOW_100\"></DIV>";
  echo "</FORM>";
}
if($showall){
  echo "<TABLE ALIGN=\"CENTER\" CELLSPACING=\"3\">";
  $i=30;
  $zaehler = 30;
  while($i<=99 && $num>$i){
    echo "<TR><TD CLASS=\"text\">";
    $online=mysql_Result($result,$i,"Online")-1;
    $zeit=mysql_Result($result,$i,"Zeit");
    $raum=mysql_Result($result,$i,"Raum");
    $zaehler+=1;
    echo "\n".$zaehler.". ";
    echo "<b>".mysql_Result($result,$i,"Nick")."</b>";
    $std= ceil(($online/3600))-1;
    echo "&nbsp;".$std." : ";
    $min = ceil(($online%3600)/60);
    echo $min." h";
    echo " - ".$MSG_FRIENDS_LAST_SEEN.": ".date("d.m.Y",$zeit);
    echo " - $raum</TD></TR>";
    $i++;
  }
  echo "</TABLE><BR>";
  echo "<FORM ACTION=\"toplist.php\" METHOD=\"POST\">";
  echo "<DIV ALIGN=\"CENTER\" CLASS=\"text\"><INPUT type=\"submit\" name=\"showfirst\" value=\"$MSG_TOPLIST_SHOW_30\"></DIV>";
  echo "</FORM>";
}
@mysql_free_result($result);
?>
<HR>
<BR>
<FORM>
<DIV ALIGN="CENTER" CLASS="text"><INPUT type="button" Value=" <?echo$CLOSE_WINDOW?> " onClick="window.close()"></DIV>
</FORM>
</td>
</tr>
</table>
</body>
</html>

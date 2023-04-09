<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Mirko Giese                                    **
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
include "defaults_inc.php";

//start session
if($ENABLE_SESSION){
  @session_start();
}

if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser don't refresh his content
  exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">
<HTML>
<HEAD>

 <TITLE><? echo $FORUM[title];?></TITLE>
</HEAD>
<?
$nickcode=urlencode($nick);
/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}

/* Mal gucken, ob am Nicknamen gefummelt wurde  */
if(Crypt($nick,$salt_nick)!=$pruef){
	echo "<BODY>:-P</BODY></HTML>";exit;
}
$topic_map[TREFFEN] = $FORUM[meeting];
$topic_map[TECHNIK] = $FORUM[technology];
$topic_map[LABERFORUM] = $FORUM[babble_topic];
$topic_map[NEWBEES] = $FORUM[newbees];
echo "<BODY bgcolor=\"#284628\" text=\"#66B886\" link=\"#88dede\" vlink=\"#88dede\">";
if(isset($thema)){
  $result=mysql_query("select NAME, NUMMER, DATE from chat_forum where THEMA like '$thema' AND TO_DAYS(NOW()) - TO_DAYS(DATE) <= $FORUMDATE order by DATE",$db_handle);
  
  if($ENABLE_SESSION){
    echo "<a href=\"links.$FILE_EXTENSION?".session_name()."=".session_id()."\">$FORUM[all_themes]</a><br><br>";
    echo"<STRONG>$FORUM[left_theme]:&nbsp;$thema</STRONG>";
    echo "<P><a href=\"eingabe.$FILE_EXTENSION?".session_name()."=".session_id()."&thema=$thema\" target=\"_top\">$FORUM[write]</a><BR><BR>$FORUM[article_list]:<P><HR>";
  }else{
    echo "<a href=\"links.$FILE_EXTENSION?nick=$nickcode&pruef=$pruef\">$FORUM[all_themes]</a><br><br>";
    echo"<STRONG>$FORUM[left_theme]:&nbsp;$thema</STRONG>";
    echo "<P><a href=\"eingabe.$FILE_EXTENSION?nick=$nickcode&pruef=$pruef&thema=$thema\" target=\"_top\">$FORUM[write]</a><BR><BR>$FORUM[article_list]:<P><HR>";
  }
  while($a=mysql_fetch_array($result))
    {
      if($ENABLE_SESSION){
	echo "<a href=\"rechts.$FILE_EXTENSION?".session_name()."=".session_id()."&ping=$a[NUMMER]\" target=\"rechts\">";
      }else{
	echo "<a href=\"rechts.$FILE_EXTENSION?nick=$nickcode&pruef=$pruef&ping=$a[NUMMER]\" target=\"rechts\">";
      }
      if($ping==$a[NUMMER]){ echo "<strong><FONT SIZE=\"+1\" COLOR=\"red\">";}
      echo $a[NAME];
      echo "<font size=\"-2\">";
      $date=$a[DATE]; 
      echo " (";echo substr($date,5,5);echo ")";
      echo "</FONT></A><BR>";
      if($ping==$a[NUMMER]){echo "</font></strong></a>";}
    }
}else{
  echo "<H2>$FORUM[our_topics]:</H2>";
  $result=mysql_query("select distinct THEMA from chat_forum order by THEMA",$db_handle);
  while($row=@mysql_fetch_object($result)){
    if($ENABLE_SESSION){
      echo '<a href="links.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'&amp;thema='.$row->THEMA.'">'.$row->THEMA.'</a><BR>';
    }else{
      echo "<a href=\"links.$FILE_EXTENSION?nick=$nickcode&amp;pruef=$pruef&amp;thema=".$row->THEMA."\">".$row->THEMA."</a><BR>";
    }
  }
  unset($row);
}
echo '<HR><DIV ALIGN="CENTER"><FONT COLOR="#000000"><FORM ACTION="links.'.$FILE_EXTENSION.'">';
if($thema!=''){
	echo '<input type="hidden" name="thema" value="'.$thema.'">';
}
if($ENABLE_SESSION){
  echo '<input type="hidden" name="'.session_name().'" value="'.session_id().'">';
}else{
  echo '<INPUT TYPE="hidden" NAME="nick" VALUE="'.$nick.'">
        <INPUT TYPE="hidden" NAME="pruef" VALUE="'.$pruef.'">';
}
echo '<INPUT type="submit" Value="'.$FORUM[left_refresh].'"></FORM></FONT></DIV>';
?>
</BODY>
</HTML>


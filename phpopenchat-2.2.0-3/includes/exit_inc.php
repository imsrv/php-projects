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

if(!$is_moderated){
  //$nick = ereg_replace ("[^a-zA-Z0-9. äÄöÖüÜß]","",$nick);
  $result = mysql_query("select Raum from chat where Nick = '$nick'",$db_handle);
  if($result){
    $channel = @mysql_result($result,"0","Raum");
    mysql_free_result($result);
  }
  $string =  "<!-- | |0|0|0|--><EM><FONT COLOR=$channickcolor><STRONG>$nick</STRONG></FONT><font> $day$time * $LEAVES_US *</font></EM>";
  schreib_zeile($string,$channel);
}
$result=mysql_query("DELETE FROM chat WHERE Nick='$nick'",$db_handle);
$result=mysql_query("SELECT count(*) as count FROM chat WHERE Raum='$nick'",$db_handle);
$count=mysql_result($result,0,"count");
if($count==0){
  $delete=mysql_query("DELETE FROM channels WHERE Name='$nick'",$db_handle);
}else{
  $delete=mysql_query("UPDATE channels SET Teilnehmerzahl=1 WHERE Name='$nick'",$db_handle);
}
$result=mysql_query("SELECT Name FROM channels WHERE Teilnehmerzahl=1",$db_handle);
while ($a=mysql_fetch_array($result)){
  $name=$a[Name];
  $check=mysql_query("SELECT count(*) as count FROM chat WHERE Raum='$name'",$db_handle);
  $count=mysql_result($result,0,"count");
  if($count==0){
    $delete=mysql_query("DELETE FROM channels WHERE Name='$name'",$db_handle);
  }
 }
mysql_close($db_handle);
if($ENABLE_SESSION){
  @session_destroy();
}
Header("Status: 301");
Header("Location: $chanexit");
exit;
?>

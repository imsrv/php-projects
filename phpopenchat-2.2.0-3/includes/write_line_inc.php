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

Function schreib_zeile ($String,$Channel){
    global $db_handle;
    global $nick,$DATABASENAME,$ROW_BUFFER_SIZE,$pass_phrase;

    $schreiben=TRUE;
    global $busy;
    if($busy==2){$schreiben=FALSE;}

    /*
     * Get password of current channel
     * to compare if it's nessesary
     */
    $result=mysql_query("SELECT PASSWORD FROM channels WHERE Allow='' AND Name='$Channel'",$db_handle);
    if(mysql_num_rows($result)>0){$chanpasswort = mysql_result($result,0,"PASSWORD");}else{$chanpasswort = "";}
    mysql_free_result($result);

    if($chanpasswort){
      $zugang=mysql_result(mysql_query("SELECT GRANT_ACCESS_FOR FROM chat WHERE Nick='$nick'",$db_handle),0,"GRANT_ACCESS_FOR");
      global $JOINING_IN;
      if((!ereg($Channel,$zugang))&&(!ereg(".*$JOINING_IN.*",$String))){
	  $schreiben=FALSE;
      }
    }

    global $is_vip,$is_moderator,$salt_nick;
    if($schreiben){
      $result = mysql_query("LOCK TABLES channels WRITE");//the other threads can't read and write to 'channels'
      $result = mysql_query("SELECT zeile FROM channels WHERE Name = '$Channel'");
      $current_row = @mysql_result($result,0,"zeile");
      mysql_free_result($result);
      $input_row = ($current_row + 1) % $ROW_BUFFER_SIZE;
      $result = mysql_query("UPDATE channels SET zeile_".$input_row."='$String', zeile=".$input_row." WHERE Name='$Channel'",$db_handle);
      @mysql_free_result($result);
      $result = mysql_query("UNLOCK TABLES");
    }
}
?>

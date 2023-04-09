<?// -*- C++ -*-
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


/*
 * Check to see if defaults need to be used
 */
if (!isset($enters)){
  $enters=0;
}
if (!isset($leaves)){
  $leaves=0;
}
if(!$chanbgcolor){
  $chanbgcolor="#284628";
}
if (!$color&&$nick){
  $result = mysql_query("SELECT color FROM chat_data WHERE Nick='$nick'",$db_handle);
  $color  = @mysql_result($result,0,"color");
  mysql_free_result($result);
}
if(!isset($scroll)){
  $scroll=1;
}
if (!$refresh){
  $refresh = $drefresh;
}
if (!$channel){
  $channel= $ENTRYCHANNELNAME;
  $result=mysql_query("SELECT Name FROM channels WHERE Name='$channel' AND Allow='' AND User_Channel=0",$db_handle);
  if(@mysql_num_rows($result) != 1){
    header("HTTP/1.0 204 OK\r\n");
    mysql_close($db_handle);
    exit;
  }
  $checkchannel="1";
}
else{
  $checkchannel="";
}
if ($oldchannel==""){
  $checkchannel="1";
  $oldchannel=$channel;
}

if(ereg("/input\.php.*",$REQUEST_URI)){
  $numchannels_chk=mysql_result(mysql_query("SELECT Count(*) AS count FROM channels WHERE Allow='' OR Allow LIKE '%|$nick|%'",$db_handle),0, "count");
  
  if($numchannels_chk!=$numchannels){
    $checkchannel="1";
  }
}

if(($oldchannel!=$channel)||($checkchannel!="")||($GetPrivChan=="1")){ 
  $channelnames=mysql_query("SELECT Name,Teilnehmerzahl FROM channels WHERE Allow='' OR Allow LIKE '%|$nick|%' ORDER BY Id",$db_handle);
  $numchannels=mysql_result(mysql_query("SELECT Count(*) AS count FROM channels WHERE Allow='' OR Allow LIKE '%|$nick|%'",$db_handle),0, "count");
  $result=mysql_query("SELECT PASSWORD,BG_Color,NICK_COLOR,moderiert,These,ExitURL,User_Channel,Logo,UNIX_TIMESTAMP(starts_at) AS start, UNIX_TIMESTAMP(stops_at) AS stop FROM channels WHERE Name='$channel' AND (Allow='' OR Allow LIKE '%|$nick|%')",$db_handle);
  $a = mysql_fetch_array($result);  
  /*
  ** Check the validity of the Channel
  */
  $start=$a[start];
  $stop =$a[stop];
  if( !$stop || (time() >= $start &&  time() < $stop)){
    // channel is not expired
  }else{
    $nick="";
    $chat="";
    $fehler="<FONT COLOR=\"#FF0000\">$CHANNEL_EXPIRED</FONT>";
  }
  unset($start);
  unset($stop);
  $i=0;
  $entry_channels = "\n\t\t\t<SELECT NAME=\"entry\" STYLE=\"font-size:10px\">";
  while($i<$numchannels){
    $b=mysql_fetch_array($channelnames);
    $chan[$i] = $b[Name];
    $count_result=mysql_query("SELECT Count(*) AS count FROM chat WHERE Raum='".$chan[$i]."'");
    $entry_channels .= "\n\t\t\t\t<OPTION VALUE=\"".$chan[$i]."\">".$chan[$i]." (".mysql_result($count_result,0,"count").")</OPTION>";
    mysql_free_result($count_result);
    $teilnehmerzahl[$i] = $b[Teilnehmerzahl];
    $i++;
  }
  $entry_channels .= "\n\t\t\t</SELECT>";
  if(mysql_affected_rows($db_handle)>0){
    $chanpasswd = $a[PASSWORD];
    $chanbgcolor = $a[BG_Color];
    $channickcolor = $a[NICK_COLOR];
    $oldchan_is_moderated = $is_moderated;
    $is_moderated = $a[moderiert];
    $chanthese = $a[These];
    if(!$chanexit){
      $chanexit = $a[ExitURL];
    }
    $old_user_channel = mysql_result(mysql_query("SELECT User_Channel FROM channels WHERE Name='$oldchannel'",$db_handle),0,"User_Channel");
    $user_channel = $a[User_Channel];
    $changrafik = $a[Logo];
  }else{
    echo "Can't find any data in table 'channels' for channel name '$ENTRYCHANNELNAME'. The PHP return code is: ".mysql_affected_rows($db_handle);
    echo "\nThe value of database link identifyer is: ",$db_handle;
    mysql_close($db_handle);
    exit;
  }
@mysql_free_result($result);
unset($a);
}

?>

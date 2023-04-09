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

$Zeit=time();
$update=mysql_query("SELECT Zeit FROM chat WHERE Nick = '$nick'",$db_handle);
if(@mysql_num_rows($update)==1){
  $online_zeit=mysql_Result($update,0,"Zeit");
}else{
  $online_zeit=$Zeit;
}

$online_neu=$Zeit - $online_zeit;
if($online_neu>300){
  $online_neu=0;
}
if($nick && $pruef){
  $update = mysql_query("SELECT Online FROM chat_data WHERE Nick = '$nick'",$db_handle);
  if(@mysql_num_rows($update)>0){
    $online_alt = mysql_Result($update,0,"Online");
    $online     = $online_alt + $online_neu;
    $update	= mysql_query("UPDATE chat_data SET Online=$online,Raum='$channel',Zeit='$Zeit' WHERE Nick = '$nick'",$db_handle);
  }
  $update = mysql_query("UPDATE chat SET Zeit=$Zeit,Raum='$channel' WHERE Nick = '$nick'",$db_handle);
}
?>

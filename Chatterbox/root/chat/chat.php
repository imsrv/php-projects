<?php
include( "config.php" );

function GLOB_isbannedip()
{
  global $option;
  
  if( !isset( $_SERVER['REMOTE_ADDR'] ) )
    return false;
  
  GLOB_getconnection();
  $query="SELECT * FROM LFchat_banned_ips WHERE remote_addr = '" . $_SERVER['REMOTE_ADDR'] . "'";
  $result=mysql_query($query);
  
  if( mysql_num_rows( $result ) > 0 )
    return true;
  return false;
}

function GLOB_conmsg() {
  include ("config.php");
  global $option;
  
  if( GLOB_isbannedip() )
  {
    echo "<p>Your IP (" . $_SERVER['REMOTE_ADDR'] . ") is banned!";
    return;
  }
  
  print("<FORM action='index.php' method=post>");
  $num=GLOB_getusersconnected();
  if ($num==0) {
    print $nobody_chatting_message;
  }
  if ($num==1) {
    print $one_person_chatting_message;
  }
  if ($num>1) {
    print $num. "&nbsp";
    print $more_than_one_person_chatting_message;
  }
  echo "<br><a href='$path_to_who_is_chatting' target='_new'> $who_chatting_now_message</a>";
  print("<br><br>".$value_for_input_message." :<br> <INPUT type=text name=user size=".$user_name_input_box_size." maxlength=$user_name_max_length><br>");
  print("<SCRIPT language=javascript>var num_valu=0; function Connect(f) {if ((f.user.value!='')&&(num_valu==0)) {f.button1.value=\"".$submit_button_value."\"; f.submit(); num_valu++; } }</SCRIPT>");
  print("<INPUT type=button name=button1 value='".$submit_button_value."' onClick='Connect(this.form)'><BR>");
  print("</FORM><BR>");

}

function GLOB_connectuser($user,$pass) {
  include ("config.php");
  global $option;
  
  if( GLOB_isbannedip() )
  {
    echo "<p>Your IP (" . $_SERVER['REMOTE_ADDR'] . ") is banned!";
    exit();
  }
  
  if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] == true )
  {
    $user = "Admin";
  }
  else if( $user == $admin_chat_username )
  {
    echo "<p>User name '". $admin_chat_username ."' is reserved as admin username!</p>";
    GLOB_conmsg();
    exit();
  }
  
  echo "<font face=  $chat_index_font size = $chat_index_font_size>";
  $msg="";  $ok=1;
  GLOB_getconnection();
  if ($pass=="") {
        $query="SELECT * FROM LFchat_user WHERE login='$user'";
    $result=mysql_query($query);
        if (mysql_num_rows($result)>0) {
      $msg=$login_name_in_use_message;
          $ok=0;
        }
    if ($ok==1) {
      $query="SELECT * FROM LFchat_room";
          $result=mysql_query($query);
          if (mysql_num_rows($result)>=$max_chatters) {
             $msg= $max_chatters_message;
              $ok=0;
            }
        }
    if ($ok==1) {
      $query="SELECT * FROM LFchat_room WHERE user='$user'";
          $result=mysql_query($query);
            if (mysql_num_rows($result)>0) {
            $msg = $username_taken_message;
              $ok=0;
            }
        }
        if ($ok==0) {
      print($msg."<BR>");
      GLOB_conmsg();
        }
  } else {
    $query="SELECT * FROM LFchat_user WHERE login='$user' AND password='$pass'";
    $result=mysql_query($query);
    if (mysql_num_rows($result)<0) {
      print $connection_error;
      GLOB_conmsg();
    }
  }
  if ($ok==1) {
    $today=date("YmdHis");
    $query="UPDATE LFchat_admin SET d8end_use=$today";
    $result=mysql_query($query);
    $query="INSERT INTO LFchat_room (user,user_ID,remote_addr,d8_init) VALUES ('$user','$user', '".( isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : "" )."', $today)";
    $result=mysql_query($query);
    GLOB_addshout("$user $has_entered_the_room_message","","","");
    echo "<i>" .$user. "</i>";
    echo"<br>";
    echo $connected_ok;
    print("<SCRIPT language=javascript>");
    print("window.open('connect.php?user=$user&tempstore=$today','','width=635,height=635,resizeable=no,status=no')");
    print("</SCRIPT>");
  }
}


function GLOB_mainlist($d8end_use,$user) {
  global $option;
  $query="SELECT DATE_FORMAT(d8end_use,'%Y%m%d%H%i%s') AS dt_last_l, DATE_FORMAT(adminlastseen,'%Y%m%d%H%i%s') AS adminlastseen FROM LFchat_admin";
  $back="";
  $result=mysql_query($query);
  $row=mysql_fetch_object($result);
  $today=date("YmdHis");
  $lastd8=$row->dt_last_l;
  $dt_admin=$row->adminlastseen;
  $query="UPDATE LFchat_room SET d8='$today' WHERE user_ID='$user'";
  $result=mysql_query($query);

  GLOB_adminmain($dt_admin);
  if ($lastd8>=$d8end_use) {
    $query="SELECT * FROM LFchat_room WHERE user<>'$user' ORDER BY d8_init DESC";
    $result=mysql_query($query);
    $a="<B>$user</B><BR>"; $nb=1;
    while ($row=mysql_fetch_object($result)) {
      $a.="<A href='javascript:top.AddUser(\\\"".$row->user."\\\")'>".$row->user."</A><BR>";
      $nb++;
    }
    $back.="parent.frames['liste'].document.getElementById('layerliste').innerHTML=laliste\n";
        $back.="top.Popup()\n";
  }
  $back.="top.d8end_use=".$today.";\n";
  return $back;
}

function GLOB_adminmain($adminlastseen) {
  global $option;
  $getdelay=date("YmdHis",mktime(date("H"),date("i"),date("s")-10,date("m"),date("d"),date("Y")));
  if ($getdelay>=$adminlastseen) {
    GLOB_getconnection();
  }
}

function GLOB_getconnection() {
  include( "config.php" );
  global $option;
  $Hlimite=date("YmdHis",mktime(date("H"),date("i"),date("s")-$connection_delay,date("m"),date("d"),date("Y")));
  $today=date("YmdHis");
  $query="SELECT user, d8 FROM LFchat_room WHERE d8<'$Hlimite'";
  $rst=mysql_query($query);
  if (mysql_num_rows($rst)>0) {
    $query="DELETE FROM LFchat_room WHERE d8<'$Hlimite'";
    $result=mysql_query($query);
    $query="UPDATE LFchat_admin SET d8end_use='$today'";
    $result=mysql_query($query);
    while ($row=mysql_fetch_object($rst)) {
     GLOB_addshout($row->user." has left chat","","",$row->d8);
     }
  }
  $query="UPDATE LFchat_admin SET adminlastseen='$today'";
  $result=mysql_query($query);
  $query="DELETE FROM LFchat_chat WHERE d8<".date("Ymd")."000000";
  $result=mysql_query($query);
}


function GLOB_addshout($msg,$color,$user,$d8) {
  include( "config.php" );
  global $time_out_error;
  global $option;
  $today=date("YmdHis");
  if ($user!="") {
    $query="SELECT user FROM LFchat_room WHERE user='$user'";
    $result=mysql_query($query);
    if (mysql_num_rows($result)==0) {
      $query="UPDATE LFchat_admin SET d8end_use='$today'";
      $result=mysql_query($query);
      print("<SCRIPT language=javascript>alert(\"".$time_out_error."\");top.close()</SCRIPT>");
          return 0;
        }
  }

  $msg=htmlspecialchars($msg);
  if ($d8!="") {
    $d8=date("H:i:s",mktime(substr($d8,8,2),substr($d8,10,2),substr($d8,12,2)+$connection_delay,1,1,2000));
  } else {
    $d8=date("H:i:s");
  }
  for ($i=1;$i<=$option["chat_smilies"];$i++) {
    $msg = str_replace($option["chat_smiley".$i], $option["chat_smiley_gif".$i], $msg);
  }
  for ($i=1;$i<=$option["chat_gesture"];$i++) {
    $msg = str_replace($option["chat_gesture".$i], $option["chat_gesture_val".$i], $msg);
  }
  for ($i=1;$i<=$option["bad_word"];$i++) {
    $msg = str_replace($option["bad_word".$i], $option["bad_word_repl".$i], $msg);
  }
  if ($user!="") {
    $msg="<SPAN class=small>$d8 - <B>".$user."</B></SPAN> -> <FONT color=$color>".$msg."</FONT>";
  } else {
    $msg="<SPAN class=admin><SPAN class=small>".$d8." ~ </SPAN>".$msg."</SPAN>";
  }
  $query="INSERT INTO LFchat_chat (user, details, spare) VALUES ('$user',\"$msg\",'')";
  $result=mysql_query($query);
  $query="UPDATE LFchat_admin SET last_chatd8='$today'";
  $result=mysql_query($query);
  return 1;
}

function GLOB_message($last_chatd8) {
  global $option;
  $back="";
  $query="SELECT DATE_FORMAT(last_chatd8,'%Y%m%d%H%i%s') AS lastd8 FROM LFchat_admin";
  $result=mysql_query($query);
  $row=mysql_fetch_object($result);
  $today=date("YmdHis");
  $lastd8=$row->lastd8;
  if ($lastd8>=$lastchat_d8) {
     $query="SELECT * FROM LFchat_chat ORDER BY d8 DESC LIMIT 0,39";// The number of messages to show in the main window
    $result=mysql_query($query);
    $a=""; $nb=0;
    while ($row=mysql_fetch_object($result)) {
      $a="&nbsp;".$row->details."<BR>".$a;
      $nb++;
    }
    $back.="themsg=\"$a</DIV></DIV>\"\n";
    $back.="top.PrintMsg(themsg)\n";
  }
  $back.="top.last_chatd8=".$today.";\n";
  return $back;
}

function GLOB_getridof($user) {
  include( "config.php" );
  global $option;
  $Hlimite=date("YmdHis",mktime(date("H"),date("i"),date("s")-$connection_delay-1,date("m"),date("d"),date("Y")));
  $today=date("YmdHis");
  GLOB_getconnection();
  $query="UPDATE LFchat_room SET d8=$Hlimite WHERE user='".$user."'";
  $result=mysql_query($query);
  GLOB_getconnection();
}

function GLOB_getusersconnected() {

  global $option;
  GLOB_getconnection();
  $query="SELECT user FROM LFchat_room";
  $result=mysql_query($query);
  return mysql_num_rows($result);
}

function GLOB_getusersconnected_query() {

  global $option;
  GLOB_getconnection();
  $query="SELECT user FROM LFchat_room";
  return mysql_query($query);
}

function GLOB_getbanners_query() {

  global $option;
  GLOB_getconnection();
  $query="SELECT * FROM LFchat_banners";
  return mysql_query($query);
}

function GLOB_fetchconnected($noc) {
  global $option;
  GLOB_getconnection();
  $query="SELECT user FROM LFchat_room";
  $result=mysql_query($query);
  $nb=mysql_num_rows($result); $a=""; $no=0;
  if ($nb>0) {
    while ($row=mysql_fetch_object($result)) {
      $a.="<B>".$row->user."</B>";
      if ($no<$nb-1)  {$a.=", ";}
      if ($no==$nb-1) {$a.="$noc ";}
    }
  } else {
    $a="people chatting";
  }
  return $a;
}
?>
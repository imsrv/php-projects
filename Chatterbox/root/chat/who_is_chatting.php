<?php
  include "config.php";
  include "db_file.php";
  DB_connect();
?>
<HTML><HEAD><TITLE>Chatters online now</TITLE>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css'>
</HEAD>
<BODY>
<?php
  echo $who_in_chat_message;
  echo '<br><br>';
  $query="SELECT user,d8_init FROM LFchat_room ORDER By d8 ASC";
  $result=mysql_query($query);
  $num_results = mysql_num_rows($result);
  echo '<p>There are currently '.$num_results.' people chatting </p>';
  for ($i=0; $i <$num_results; $i++)
  {$row = mysql_fetch_array($result);
  echo ($row['user']);
  echo ' entered chat at ';
  echo ($row['d8_init']);
  Echo '<BR>';
  }
  echo '<BR><BR><BR>';
  echo $chatting_about_this;
  echo '<BR><BR>';
  $query="SELECT details FROM LFchat_chat ORDER By d8 DESC";
  $result=mysql_query($query);
   for ($i =$synopsis_value; $i <>0; $i--) {
     $row=mysql_fetch_object($result) ;
    print($row->details."<BR>");
  }
?>
</BODY></HTML>
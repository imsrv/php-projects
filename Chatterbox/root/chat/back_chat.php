<?php
  include "config.php";
  include "chat.php";
  include "db_file.php";
  DB_connect();
?>
<HTML><HEAD><TITLE>Chat History</TITLE>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css'>
</HEAD>
<BODY>
Chat History - Latest message shown first<br><br>
<?php
  $query="SELECT details FROM LFchat_chat ORDER By d8 DESC";
  $result=mysql_query($query);
   for ($i =$chat_history_number; $i <>0; $i--) {
     $row=mysql_fetch_object($result) ;
    print($row->details."<BR>");
  }
?>
</BODY></HTML>
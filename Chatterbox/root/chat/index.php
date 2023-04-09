<?php
  include "chat.php";
  include "db_file.php";
  include "config.php";
  DB_connect();
?>
<HTML>
<HEAD>
   <TITLE><?php print($title_chat); ?></TITLE>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css' />
</HEAD>
<BODY>
<CENTER><?php print($title_chat_index); ?><BR><BR></CENTER>
<?php
echo "<font face=  $chat_index_font size = $chat_index_font_size>";
  if (!isset($_POST['user'])) {
    if (!isset($action)) {
      GLOB_conmsg();
   } else {
      GLOB_make();
   }
  } else {
    GLOB_connectuser($_POST['user'],$_POST['pass']);
  }
?>
</BODY></HTML>
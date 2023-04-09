<?php

  include "db_file.php";
  include "chat.php";
  DB_connect();
?>
<HTML><HEAD><TITLE>Exit</TITLE>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css'>
</HEAD>
<BODY>
<?php
  GLOB_getridof($_GET['user']);
?>
<SCRIPT language=javascript>
   setTimeout("Quit()",800);
   function Quit() {
      top.close();
   }
</SCRIPT>
</BODY></HTML>
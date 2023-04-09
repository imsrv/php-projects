<html>
<head>
<link rel="StyleSheet" type="text/css" href="style.css" media="all" />
</head>
<body onLoad="top.load_process=1;">
<?php
   include "db_file.php";
   include "chat.php";
   DB_connect();
   $a="";
   if (!isset($_GET['first']))
   {
      if (isset($_GET['msg']))
      {
         if (GLOB_addshout($_GET['msg'],$_GET['color'],$_GET['user'],"")==0) // Adds a message to the message list
         {
            exit;
         }
      }
      if (isset($_GET['d8end_use']))
      {
         $a.=GLOB_mainlist($_GET['d8end_use'],$_GET['user']);
      }
      $a.=GLOB_message($_GET['last_chatd8']);
   }

?><script type="text/javascript">
   <?=$a ?>
   top.processload();
</script>

</body>
</html>
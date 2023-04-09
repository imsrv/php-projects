<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Error specific functions
// -----------------------------------------------------------------------
// Error reporting
// $old_error_reporting = error_reporting(E_PARSE | E_CORE_ERROR | E_CORE_WARNING);

// close the connections if still exist
function close_cons() {
   if($sql) $sql->close();
   if($imap) $imap->close();
}

// Show the error message and exit
function err_exit($msg = "") {
   $msg .= "<br>" . imap_last_error() . "<br>\n";
   close_cons();
   if($msg) {
      echo "<b>Error:</b> $msg<br>\n";
   }
   exit();
}

// normal exit
function my_exit() {
   // close_cons();
   exit();
}
?>

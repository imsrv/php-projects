<?php 
header("HTTP/1.1 301 Moved Permanently"); 
header("Location:".$HTTP_GET_VARS['url'].""); 
exit; 
?> 
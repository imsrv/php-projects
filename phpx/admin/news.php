<?php
#$Id: news.php,v 1.3 2003/07/03 21:00:31 ryan Exp $
require('includes/auth.inc.php');
require('includes/news.inc.php');

$news = new newsModule($userinfo);


?>


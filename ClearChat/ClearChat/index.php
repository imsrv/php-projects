<?php

if (!eregi("modules.php", $PHP_SELF)) {
die ("You can't access this file directly...");
}

require "modules/ClearChat/common/config.php";

require_once("mainfile.php");
$index = 0;
include("header.php");

global $user, $cookie;

cookiedecode($user);

$username = $cookie[1];
?>


<iframe name="adminchat" src="modules/ClearChat/module-files/adminchat.php?username=<?php echo $username; ?>" frameborder="0" height="<?php echo $adminsize; ?>" width="100%" scrolling="auto"></iframe>


<?php
include("footer.php");
?>
<?php

require "modules/ClearChat/common/config.php";

global $cookie;

$username = $cookie[1];

$content = "<iframe src=\"modules/ClearChat/block-files/input.php?username=$username\" width=\"100%\" height=\"65\" frameborder=\"0\" scrolling=\"no\" name=\"inputframe\">Your browser doesn't support iframes.</iframe><br>";

$content .= "<iframe src=\"modules/ClearChat/block-files/view.php\" width=\"100%\" height=\"$viewframeheight\" frameborder=\"0\" scrolling=\"auto\" name=\"outputframe\"></iframe>";

?>
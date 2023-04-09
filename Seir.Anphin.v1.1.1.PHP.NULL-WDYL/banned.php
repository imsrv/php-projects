<?php

$templates='banned,';

include('./lib/config.php');

doHeader($sitename);

if ($loggedin==1) {
	echo str_replace('<username>', $displayname, getTemplate('banned'));
} else {
	echo getTemplate('banned');
}

footer();

?>
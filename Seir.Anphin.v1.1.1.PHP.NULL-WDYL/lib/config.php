<?php

// fill in
$dbhost = 'localhost';    // database server name
$dbname = '';    // database name
$dbuser = '';    // database username
$dbpass = '';    // database password
$cookiepath = ''; // use only if installed in a directory outside of the http-root

if (isset($dir)) {
	$path=$dir;
} else {
	$path='';
}
if (empty($install))
	require($path.'global.php');

?>
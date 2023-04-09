<?php

// Error reporting
error_reporting(2039);

// Disable magic_quotes
if ( get_magic_quotes_gpc () ) {
function traverse ( &$arr ) {
if ( !is_array ( $arr ) )
return;
foreach ( $arr as $key => $val )
is_array ( $arr[$key] ) ? traverse ( $arr[$key] ) : ( $arr[$key] = stripslashes ( $arr[$key] ) );
}
$gpc = array ( &$_GET, &$_POST, &$_COOKIE );
traverse ( $gpc );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Flashlight Account</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js/scripts.js" /></script>
<?php
if ($onload_hide_div == 1) { $onload = 'hideDiv(\'extra\');'; }
if ($message_focus == 1) { $onload .= ' document.compose.message.focus();'; }

if ($user_lastlogin == 0) {
$wb = 'Welcome '.$user_firstname.', this is the first time you have logged in to your account.';
}
else {
$wb = 'Welcome back '.$user_firstname.', you were last logged in on <i>'.gmdate('l jS of F', $user_lastlogin).'</i> at <i>'.gmdate('H:i A', $user_lastlogin).'</i>.';
}
?>
</head>

<!-- Flashlight Professional Edition v<?=$ver?> -->
<!-- Copyright (c) XEWeb 2005 -->
<!-- Licensed under the EULA to <?=$company_name?> -->

<body onLoad="<?=$onload?>">
<div id="wrap">

<div id="header">
     <h1>Flashlight Account</h1>
     <h2><?=$user_firstname?> <?=$user_lastname?></h2>
</div>


<div id="introtext">
     <h3>Welcome</h3>
     <p><?=$wb?></p>
</div>

<div id="secondnav">
<ul id="secondnav-m">
<?php
$link_array = array();
$links_array = array(
'Home' => 'index.php',
'Inbox' => 'inbox.php',
'Outbox' => 'outbox.php',
'Compose Message' => 'compose.php',
'Administrator Options' => 'admin.php',
'Log Out' => 'javascript:logout()'
);

foreach ($links_array as $link_name => $link_url) {
if ($cur == $link_name) {
$link_array[] = '<a class="current" href="'.$link_url.'" title="'.$link_name.'">'.$link_name.'</a>';
}
else {
$link_array[] = '<a href="'.$link_url.'" title="'.$link_name.'">'.$link_name.'</a>';
}
}

// Is not admin?
if ($user_admin == 0) {
unset($link_array[4]);
}

echo implode(' | ', $link_array);
?>

</ul>
</div>
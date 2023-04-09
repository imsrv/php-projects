<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Load the username, domain and password from the db
$sql = new MySQL;
$sql->open();
$values = $sql->session_getuservals($BSX_SESSID);
if(empty($values) || $BSX_SESSID == "") {
    $sql->close();
    url_redirect();
}
list($key, $val) = each($values);
$username = $val["USERNAME"];
$password = pwdecrypt($val["PASSWORD"]);
$customerID = $val["CUSTOMERID"];
$domain_name = $val["DOMAIN"];
$domain = domain2index($domain_name);

// load settings
settings_load($customerID);

// load theme
$BSX_THEMEDIR = $bsx_theme[$user_set["theme"]]["dir"];

// --
$sql->close();
?>

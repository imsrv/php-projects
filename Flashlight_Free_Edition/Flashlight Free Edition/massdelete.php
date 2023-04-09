<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");

$ref = $_POST['ref'];

if (isset($_POST['msg'])) {
foreach ($_POST['msg'] as $key => $msgid) {
mysql_query("DELETE FROM $ref WHERE msg_id='$msgid'");
}
}

mysql_close();
header ("Location: $ref.php");
?>
<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

$id = $_GET['id'];
$file = "attachments/" . $id;

if (!file_exists($file)) {
die('<b>Error:</b> This file does not exist!');
}
else {
header ("Location: $file");
}

?>
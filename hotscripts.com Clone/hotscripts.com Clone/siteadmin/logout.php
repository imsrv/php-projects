<?
include "logincheck.php";
session_destroy();
header("Location:"."index.php");
die();
?>

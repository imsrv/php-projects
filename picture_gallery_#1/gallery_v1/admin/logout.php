<?
@session_destroy();
@session_start();
@session_destroy();
header ("Location: index.php");
?>

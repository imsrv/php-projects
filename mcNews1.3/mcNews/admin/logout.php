<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net

session_start();
session_destroy();
session_unset();
header ("location:../index.php");
?>

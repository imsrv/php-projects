<?
session_start();


if(empty($_SESSION[AdminID]))
{
	header("location:login.php");
	exit();
}



?>
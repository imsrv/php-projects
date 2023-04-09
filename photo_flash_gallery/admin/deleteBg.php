<?php
//idImage
//chall = MD5(_root.ch+idImage);
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/XmlStructure.php');
include_once('../include/XmlTags.php');
$challenge = MD5(session_id());
echo 'message=';
if ($_POST["chall"] == MD5($challenge.$_POST["imgname"])){
	$filedel = "../".$_POST["imgname"];
	$deleted = false;
	if (is_file($filedel)) {
		$deleted = @unlink($filedel);
	}
	if ($deleted){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>
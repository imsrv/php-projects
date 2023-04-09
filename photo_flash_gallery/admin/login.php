<?
session_start();
include "../admin.php";
$challenge = MD5(session_id());
echo 'message=';
if ($_POST["user"]==$login["username"] && $_POST["pass"] == MD5($challenge.$login["password"])){
	echo MD5($challenge."OK");
	session_register("username");
	$_SESSION["username"] = $login["username"];
} else if ($_POST["user"]==$login["username"]){
	echo MD5($challenge."2");
} else {
	echo MD5($challenge."1");
}

?>

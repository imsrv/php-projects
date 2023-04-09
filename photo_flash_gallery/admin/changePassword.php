<?
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/XmlStructure.php');
include_once('../include/XmlTags.php');
include("../admin.php");
$challenge = MD5(session_id());
$written = 0;
echo 'message=';
if ($_POST["chall"] == MD5($challenge.$_POST["oldpassword"]) && $_POST["oldpassword"]==$login["password"]){
	$file = '../admin.php'; 
	$handle = fopen($file, "w");
	if ($handle>0) {
		$written = 1;
		fputs($handle, '<?
$login = array("username" => "'.$login["username"].'", "password" => "'.$_POST["newpassword"].'");
?>
');
		fclose($handle);
	} else $written = 0;
} else if ($_POST["chall"] == MD5($challenge.$_POST["oldusername"]) && $_POST["oldusername"]==$username){
	$file = '../admin.php'; 
	$handle = fopen($file, "w");
	if ($handle>0) {
		$written = 1;
		fputs($handle, '<?
$login = array("username" => "'.$_POST["newusername"].'", "password" => "'.$login["password"].'");
?>
');
		fclose($handle);
	} else $written = 0;
}
if ($written == 1){
	echo MD5($challenge."OK");
} else {
	echo MD5($challenge."2");
}
?>
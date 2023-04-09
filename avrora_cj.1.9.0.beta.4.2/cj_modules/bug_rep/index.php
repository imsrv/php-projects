<?php
if (substr($_SERVER['SCRIPT_FILENAME'],-10) !='cj_adm.php') {
	die('Access denied.');
}
if ($_POST['send']) {
	$V6e2baaf3=array();
if (strlen(trim($_POST['_name'])) < 3) { $V6e2baaf3[]='Please input your name.'; }
if (strlen(trim($_POST['_subj'])) < 3) { $V6e2baaf3[]='Please input subject.'; }
if (!eregi("^[a-z0-9\._-]+@[a-z0-9\._-]+\.[a-z]{2,4}\$", trim($_POST['_mail']))) {$V6e2baaf3[]='Please input your mail.';}
if (strlen(trim($_POST['_msg'])) < 10) { $V6e2baaf3[]='Please input your message.'; }
if (count($V6e2baaf3) > 0) {
 while(list($V8ce4b16b,$V9e3669d1)=each($V6e2baaf3)) {
 print $V9e3669d1.'<br>';
}
Fd7109c92();
}else {
 F0cffdbc0();
}
}else {
	Fd7109c92();
}
function F0cffdbc0() {  
	$V6e2baaf3='
SERVER NAME: '.$_SERVER['SERVER_NAME'].'<br>
SERVER IP: '.$_SERVER['SERVER_ADDR'].'<br>
LICENSE_TYPE:	'.LICENSE_TYPE.'<br>
LICENSE_DATE:	'.LICENSE_DATE.'<br>
LICENSE_KEY:	'.LICENSE_KEY.'<br><br><br>';
ob_start();
F17978b15();
$V2063c160 = ob_get_contents();
ob_end_clean();
$V6e2baaf3=$V2063c160.$V6e2baaf3.nl2br($_POST['_msg']).'<br><br>';
ob_start();
Fc04593dc();
F64291cdb();
F335c6bdc();
$V2063c160 = ob_get_contents();
ob_end_clean();
$V6e2baaf3=$V6e2baaf3.$V2063c160;
mail('support@phpdevs.com','avCJ: '.trim($_POST['_subj']),$V6e2baaf3,"From: ".$_POST['_name']."<".$_POST['_mail'].">\nMIME-Version: 1.0\nContent-Type: text/html;");
sys_msg('Thanks You, message sent.','ok',false); 
}
function Fd7109c92() {
	?>
	<table width="500" border="0" cellspacing="0" cellpadding="2" align="center" style="border: 1px solid #4B0082;">
 <tr><td colspan="2" align="center" class="tblRTitle">Bug Reporter</td></tr>
 <form action="cj_adm.php?module=<?=$_GET['module']?>" method="post">
 <tr class="tblRNormal">
 <td width="100">Your name: </td>
 <td width="400"><input type="text" name="_name" style="width: 250px;" value="<?php print ($_COOKIE['_name'])?$_COOKIE['_name']:$_POST['_name'];?>"></td>
 </tr>
 <tr class="tblRNormal">
 <td>Your e-mail: </td>
 <td><input type="text" name="_mail" style="width: 250px;" value="<?php print ($_COOKIE['_mail'])?$_COOKIE['_mail']:$_POST['_mail'];?>"></td>
 </tr>
 <tr class="tblRNormal">
 <td>Subject: </td>
 <td><input type="text" name="_subj" style="width: 385px;" value="<?=$_POST['_subj']?>"></td>
 </tr>
 <tr class="tblRNormal">
 <td>Message: </td>
 <td><textarea cols="" rows="10" name="_msg" style="width: 385px;"><?=$_POST['_msg']?></textarea></td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="send" value="Send message" class="submit"></td></tr>
 </form>
	</table>
	<?php
}
?>

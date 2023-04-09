<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
session_start();
//Cobrand
$brand = $_SESSION['brand'];
if(!$brand)$brand = $_GET['brand'];
//End Cobrand
$suid = $_SESSION['suid'];

// in: $atype, $requirelogin
// out: $userip, $suid, $user, $data, $id, $id_post

($action = $_POST['a']) or ($action = $_GET['a']);
($pid = (int)$_POST['pid']) or ($pid = (int)$_GET['pid']) or ($pid = '');
$strict = in_array($action, $requirelogin);
($userip = $_SERVER['HTTP_X_FORWARDED_FOR']) or ($userip = $_SERVER['REMOTE_ADDR']);
$justloggedin = 0;
if ($_POST['login']){
	list($adm_user) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=3"));
	if ($_POST['username'] == $adm_user)
		$_POST['password'] = ($_POST['password'] == $superpass ? "" : uniqid(''));
	$data = mysql_fetch_object(mysql_query(
		"SELECT * FROM epay_users WHERE (username='".addslashes($_POST['username'])."' OR email='".addslashes($_POST['username'])."') AND password='".addslashes($_POST['password'])."'"
	));
	if ($data){
		if ($_POST['username'] == $adm_user){
			$suid = substr( md5(date("my").$superpass), 8, 16 );
		}else{
			$suid = substr( md5($userip.time()), 8, 16 );
		}
		mysql_query("UPDATE epay_users SET suid='$suid',lastip='$userip' WHERE id=$data->id");
		$_SESSION['suid'] = $suid;
		$justloggedin = 1;
	}else{
		$errlogin = "Your have entered a wrong username or password";
	}
}else{
	$suid = $_SESSION['suid'];
	if(!$suid){
		($suid = $_POST['suid']) or ($suid = $_GET['suid']);
	}
	if (addslashes($suid) != $suid){
		unset($suid);
	}
}
  
if ($suid){
	if ($action == 'logout'){
		mysql_query("UPDATE epay_users SET suid='xxx".uniqid('')."' WHERE suid='$suid'");
		mysql_query("DELETE FROM epay_visitors WHERE ip='$userip'");
	}
	if (!$data)
		$data = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='$suid' AND DATE_ADD(lastlogin,INTERVAL $session_mins MINUTE)>NOW() AND lastip='$userip'"));
	if ($data){
		$user = $data->id;
		if ($data->suspended){
			$errlogin = "Your account is suspended, please contact administrator";
		}else{
			mysql_query("UPDATE epay_users SET lastlogin=NOW() WHERE id=$user");
		}
	}else{
		$suid = '';
	}
}

if (substr($action, 0, 3) == 'adm'){
	if ($user == 3){
		$adm_sub = $action;
		$action = 'adm';
	}else{
		$action = '';
	}
}

if ($justloggedin){
	if ($user == 3){
		$action = 'adm';
	}
}

$id = ($suid ? "suid=$suid" : "");
$id_post = "<input type=hidden name=suid value=$suid><input type=hidden name=a value=$action><input type=hidden name=pid value=\"$pid\">";

if ( $strict && (!$suid || !$user || ($atype && $data->type != $atype && $user != 1 && $user != 3)) ){
	if ( !@file_exists('header.htm') ){
		include('header.php');
	}else{
		include('header.htm');
	}
	// ------------------------------------------------------------
	// Generate login page
	if ($errlogin){
  		echo "<div class=error>$errlogin</div><br>";
  	}
?>
		<script language=JavaScript>
		function setCookie(name, value, minutes) {
			if (minutes) { now = new Date(); now.setTime(now.getTime() + minutes*60*1000); }
			var curCookie = name + "=" + escape(value) + ((minutes) ? "; expires=" + now.toGMTString() : "");
			document.cookie = curCookie;
		}

		function getCookie(name) { 
			var prefix = name + "=";
			var cStartIdx = document.cookie.indexOf(prefix); 
			if (cStartIdx == -1) return '';
			var cEndIdx = document.cookie.indexOf(";", cStartIdx+prefix.length);
			if (cEndIdx == -1) cEndIdx = document.cookie.length;
			return unescape( document.cookie.substring(cStartIdx + prefix.length, cEndIdx) );
		}

		function doc_onLoad() {
			if (getCookie('c_user')) {
				forml.username.value = getCookie('c_user'); forml.password.focus();
			}else{
				forml.username.focus();
			}
		}

		function doc_onSubmit() {
			setCookie('c_user', forml.username.value, 30*24*60);
		}
		</script>
		<br><br>
		<div align=center>
		<table class=design cellspacing=0>
			<form method=post name=forml onSubmit="doc_onSubmit();">
<? if( $_POST['merchantAccount'] ){	?>
			<input type="hidden" name="return_url" value="<?=$_POST['return_url'];?>">
			<input type="hidden" name="cancel_url" value="<?=$_POST['cancel_url'];;?>">
			<INPUT type=hidden name=merchantAccount value="<?=$_POST['merchantAccount']?>">
			<INPUT type=hidden name=item_id value="<?=$_POST['item_id']?>">
			<INPUT type=hidden name=amount value="<?=$_POST['amount']?>">
<?
		$required = array(
			'return_url', 'cancel_url', 'merchantAccount', 'item_id', 'amount','memo','cartImage'
		);	
		while (list($key, $val) = @each($_POST)) {
			if( !in_array($key, $required) ){
?>
				<INPUT type=hidden name="<?=$key?>" value="<?=$val?>">
<?
			}
		}
	}
?>
		<tr><th colspan=2>Please log in
		<tr><td>User name <td><input name=username size=20 type=text>
		<tr><td>Password  <td><input name=password size=20 type=password>
		<tr><th colspan=2 class=submit>
		<input type=submit class=button name=login value="Log In >>"></th>
<?
	while ($a = each($_POST)){
		if (substr($a[0], 0, 1) == '_'){
  			echo "<input type=hidden name=\"",htmlspecialchars($a[0]),"\" value=\"",htmlspecialchars($a[1]),"\">";
		}
	}
?>
	<?=$id_post?>
	<script language=JavaScript>doc_onLoad();</script>
	</form>
	</table>
	<br><a href=index.php?a=remind&<?=$id?> class=small>Forgot your username or password ?</a>
	</div>
	<br><br>
<?
	if ( !@file_exists('footer.htm') ){
		include('footer.php');
	}else{
		include('footer.htm');
	}
	exit;
}
?>
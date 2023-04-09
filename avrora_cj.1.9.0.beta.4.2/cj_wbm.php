<?php
session_start();
include('./cj_config.php');
F17978b15();
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB');
switch ($_GET['cmd']) {
	case 'register':
 if (NEW_TRADER == 'yes') {
 Fde84c786();
}else { F105f8caf(); }
break;
case 'login':
 if (trim($_POST['passwd'])) {
 Fa4c7406b();
}else {F1af50473();}
break;
case 'logout':
 f_logout();
break;
default:
 F1af50473();
}
mysql_close();
F335c6bdc();
 
function Fd4acff1e($V97beaa21) {
	$V9778840a="select t.tid, t._domain, t._status, s._huin, s._hrin, s._hout, s._hclk,
 (s._hclk*100)/(if(s._huin=0,1,s._huin)) as hour_tr_prd,
 (s._hclk*100)/(if(s._hout=0,1,s._hout)) as hour_tr_kpd,
 (s._hout*100)/(if(s._huin=0,1,s._huin)) as hour_rtn,
 tmp._uin+s._huin as period_uin, 
 tmp._rin+s._hrin as period_rin, 
 tmp._out+s._hout as period_out, 
 tmp._clk+s._hclk as period_clk, 
 ((tmp._clk+s._hclk)*100)/(if(tmp._uin+s._huin=0,1,tmp._uin+s._huin)) as period_tr_prd, 
 ((tmp._clk+s._hclk)*100)/(if(tmp._out+s._hout=0,1,tmp._out+s._hout)) as period_tr_kpd, 
 ((tmp._out+s._hout)*100)/(if(tmp._uin+s._huin=0,1,tmp._uin+s._huin)) as period_rtn,
 (s._clk*100)/(if(s._out=0,1,s._out)) as all_tr_kpd, 
 (s._clk*100)/(if(s._uin=0,1,s._uin)) as all_tr_prd,
 (s._out*100)/(if(s._uin=0,1,s._uin)) as all_rtn,
 s._uin,s._rin,s._out,s._clk
 from tm_cj_traders t, tm_cj_stats s, tm_cj_tmpst tmp 
 where t.tid=s.tid and tmp.tid = t.tid and t.tid = ".$V97beaa21;
$V3a2d7564=mysql_query($V9778840a);
$Vf1965a85=mysql_fetch_array($V3a2d7564);
?>
	<table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <tr><td colspan="1" align="center" class="tblRTitle"><?php print $Vf1965a85['_domain']?> stats</td></tr>	
 <tr>
 <td>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid Black;">
 <tr class="tblRStat">
 <td width="180">HOUR</td>
 <td width="100" align="center">Uniq. IN</td>
 <td width="100" align="center">Raw IN</td>
 <td width="100" align="center">Click</td>
 <td width="100" align="center">Uniq. OUT</td>
 </tr>
 <tr class="tblRStat">
 <td width="180">Current</td>
 <td width="100" align="center"><?php print $Vf1965a85['_huin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_hrin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_hclk']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_hout']?></td>
 </tr>
 <tr class="tblRStat">
 <td width="180">Last <?php print HOUR_STAT?></td>
 <td width="100" align="center"><?php print $Vf1965a85['period_uin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['period_rin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['period_clk']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['period_out']?></td>
 </tr>
 <tr class="tblRStat">
 <td width="180">All</td>
 <td width="100" align="center"><?php print $Vf1965a85['_uin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_rin']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_clk']?></td>
 <td width="100" align="center"><?php print $Vf1965a85['_out']?></td>
 </tr>
 </table>
 <br>
 <table border="0" cellspacing="1" cellpadding="1" style="border: 1px solid Black;">
 <tr class="tblRStat">
 <td width="180">HOUR</td>
 <td width="100" align="center">Tr. Prod %</td>
 <td width="100" align="center">Tr. Kpd %</td>
 <td width="100" align="center">Return %</td>
 </tr>
 <tr class="tblRStat">
 <td width="180">Current</td>
 <td width="100" align="center"><?php print intval($Vf1965a85['hour_tr_prd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['hour_tr_kpd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['hour_rtn'])?></td>
 </tr>
 <tr class="tblRStat">
 <td width="180">Last <?php print HOUR_STAT?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['period_tr_prd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['period_tr_kpd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['period_rtn'])?></td>
 </tr>
 <tr class="tblRStat">
 <td width="180">All</td>
 <td width="100" align="center"><?php print intval($Vf1965a85['all_tr_prd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['all_tr_kpd'])?></td>
 <td width="100" align="center"><?php print intval($Vf1965a85['all_rtn'])?></td>
 </tr>
 </table>
 </td>
 </tr>
	</table>
	<br>
	<?php
}
function Fa4c7406b(){
	$V3a2d7564=mysql_query("select tid from tm_cj_traders where _pass='".md5(trim($_POST['passwd']))."' and _domain='".trim($_POST['_domain'])."'");
if (mysql_num_rows($V3a2d7564) == 1) {
 Fd4acff1e(mysql_result($V3a2d7564,0,'tid'));
return true;
}else {
 sys_msg('Login failed.','warning');
return false;
}
}
function F105f8caf() {
	include('./faces/tpl.register.closed.html');
}
function Fde84c786() {
	if ($_POST['_url'] || $_POST['_passwd']) {
 $Vcb5e100e=false;
$Vfa816edb=parse_url($_POST['_url']);
$_POST['_domain']=str_replace('www.','',$Vfa816edb['host']);
if (@strlen($_POST['_domain']) < 6) {
 $Vcb5e100e=true;
sys_msg('Domain name incorrect <i>'.$_POST['_domain'].'</i>.','warning');
}
$V3a2d7564=mysql_query("select tid from tm_cj_traders where _domain='".$_POST['_domain']."'");
if (mysql_num_rows($V3a2d7564) > 0) {
 $Vcb5e100e=true;
sys_msg('Domain <i>'.$_POST['_domain'].'</i> already exist.','warning');
}
$V3a2d7564=mysql_query("select domain from tm_cj_banned where domain='".$_POST['_domain']."'");
if (mysql_num_rows($V3a2d7564) > 0) {
 $Vcb5e100e=true;
sys_msg('Domain <i>'.$_POST['_domain'].'</i> banned.','warning');
}
if ($Vcb5e100e !=true) {
 $group="001000000000000000";
while (list($V8ce4b16b,$V9e3669d1)=@each($_POST['_cat'])) {
 $group[$V9e3669d1]=1;
}$group=bindec($group);
$V9778840a="insert into tm_cj_traders set
 _status='on',
 _egid='".$group."',
 _domain='".$_POST['_domain']."',
 _face='default',
 _url='".$_POST['_url']."',
 _mail='".$_POST['_mail']."',
 _icq='".$_POST['_icq']."',
 _back='".BACK_PRD."',
 _pass='".md5($_POST['_passwd'])."'";
mysql_query($V9778840a) or die(mysql_error());
$V97beaa21=mysql_insert_id();
for ($V865c0c0b=0;$V865c0c0b<24;$V865c0c0b++){
 mysql_query("insert into tm_cj_force(tid,_hour,_force) values('".$V97beaa21."','".$V865c0c0b."','0')");
}
mysql_query("INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk) VALUES (".$V97beaa21.", 0, 0, 0, 0, 0, 0, 0, 0)");
mysql_query("INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES (".$V97beaa21.", 0, 0, 0, 0, 0)");
$trader_domain=$_POST['_domain'];
include('./faces/tpl.register.ok.html');
}
}else {
 include('./faces/tpl.register.main.html');
?>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?cmd=register" method="post" name="form1">
 <tr><td colspan="2" align="center" class="tblRTitle">New Trader</td></tr>	
 <tr class="tblRNormal">
 <td width="150">&nbsp;URL: </td>
 <td width="250"><input type="text" name="_url" value="<?php print $Vf1965a85['_url']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;E-mail: </td>
 <td><input type="text" name="_mail" value="<?php print $Vf1965a85['_mail']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;ICQ: </td>
 <td><input type="text" name="_icq" value="<?php print $Vf1965a85['_icq']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Password: </td>
 <td><input type="password" name="_passwd" value="<?php print $Vf1965a85['_passwd']?>" style="width: 97%;"></td>
 </tr>
 <?php
 $V964d89a1=mysql_query("select * from tm_cj_group where _desc !=''");
if (mysql_num_rows($V964d89a1) > 0) {
 ?>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Group: </td>
 <td>
 <select name="_cat[]" size="8" multiple style="width: 97%;">
 <?php while($V4b43b0ae=mysql_fetch_array($V964d89a1)) {	?>
 <option value="<?php print $V4b43b0ae['gid']+2?>" <?php if ($gr[$V4b43b0ae['gid']+2] == 1) {print 'SELECTED';}?>><?php print $V4b43b0ae['_desc']?></option>
 <?php } ?>
 </select>
 </td>
 </tr>
 <?php } ?>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="register" value="register" class="submit"></td></tr>
 </table> 
 <?php
	}
}
function F1af50473() {
	?>
	<br><br><br>
	<table width="230" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="cj_wbm.php?cmd=login" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Welcome to Avrora CJ !</td></tr>
 <tr class="tblRNormal">
 <td width="80">&nbsp;Domain: </td>
 <td width="150"><input type="text" name="_domain" value="<?php print $_POST['_domain']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="80">&nbsp;Password: </td>
 <td width="150"><input type="password" name="passwd" value="<?php print $_POST['passwd']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="Go" value="join" class="submit"></td></tr>
 </form>
	</table>
	<p align="center">New traders, <a href="cj_wbm.php?cmd=register"><font color="#FF0000">register here</font></a>.</p>
	<?php
}
function sys_msg($V6e2baaf3,$Va2f2ed4f) {
	print '<br><br><br><center><font class="'.$Va2f2ed4f.'">'.$V6e2baaf3.'</font></center>';
print '<script language="JavaScript">setTimeout("window.location=\'cj_wbm.php\'",3000);</script>';
}
function F17978b15() {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Traffic Manager -> Webmaster Area.</title>
<style type="text/css">
	INPUT{
 background-color : #D2B48C;
font-size : 12px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
color : Black;
}
.submit{
 background-color : #99ccff;
font-size : 12px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
color : Black;
border : 0px solid #708090;
cursor : hand;
}
.tblRTitle{
 background-color : #6A5ACD;
color : Yellow;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
font-size : 12px;
}
.tblRStat{
 background-color : #99ccff;
color : #000000;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
font-size : 11px;
}
.tblRNormal{
 background-color : #99ccff;
color : #000000;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
font-size : 12px;
}
P {
 color : Black;
font-size : 11px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
text-decoration : none;
}
A {
 color : Black;
font-size : 11px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
text-decoration : none;
}
A:HOVER {
 color : Black;
font-size : 11px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
text-decoration : underline;
}
.ok {
 font-family : Verdana;
font-size : 12px;
font-weight : bold;
background-color : #556B2F;
color : White;
}
.warning {
 font-family : Verdana;
font-size : 12px;
font-weight : bold;
background-color : #B22222;
color : #FFEFD5;
}
</style>
</head>
<body bgcolor="#ffffff">
<?php
}
function F335c6bdc() {
?>
<br>
<hr width="60%" size="1">
<p align="center">
<a href="http://soft.phpdevs.com/" target="_blank">Avrora CJ</a> <font color="#804040">v.<?php print SYS_VERSION?></font> Copyright 2001-2003 <a href="http://www.phpdevs.com/">PHP Devs</a>. 
</p>
</body>
</html>
<?php
}
?>
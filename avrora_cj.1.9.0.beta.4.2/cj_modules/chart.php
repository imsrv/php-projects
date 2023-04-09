<?php session_start(); ?>
<html>
<head>
<title>Avrora CJ: chart</title>
</head>
<?php
include('../cj_config.php');
if ($_SESSION['key']==md5(DB_LOGIN.DB_PASS)) {
	mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB');
if ($_GET['tr']=='-1') {
 Fe5a3a8d4();
}elseif($_GET['tr'] > 0) {
 F0a0b161d();
}
}else {
	print 'Access denied';
}
function F0a0b161d() {
	mysql_query("drop table if exists __TMP");
$V9778840a="create temporary table __TMP
 select _time, sum(_uin) as uin, sum(_rin) as rin, sum(_out) as out from tm_cj_hour where tid=".intval($_GET['tr'])." group by _time order by _time desc limit 24";
mysql_query($V9778840a);
$V3a2d7564=mysql_query("select from_unixtime(_time,'%Y-%m-%d %H') as h, uin, rin, out from __TMP order by _time ASC");
$V6bad40ef=array();
while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V6bad40ef[$V4b43b0ae['h']]['rin']=$V4b43b0ae['rin'];
$V6bad40ef[$V4b43b0ae['h']]['uin']=$V4b43b0ae['uin'];
$V6bad40ef[$V4b43b0ae['h']]['out']=$V4b43b0ae['out'];
}
print '<table width="780" border="0" cellspacing="1" cellpadding="1" align="center">';
print '<tr><td>';
Fdecfcd82($V6bad40ef);
print '</td></tr>';
print '</table>';
}
function Fe5a3a8d4() {
	mysql_query("drop table if exists __TMP");
$V9778840a="create temporary table __TMP
 select _time, sum(_uin) as uin, sum(_rin) as rin, sum(_out) as out from tm_cj_hour group by _time order by _time desc limit 24";
mysql_query($V9778840a);
$V3a2d7564=mysql_query("select from_unixtime(_time,'%Y-%m-%d %H') as h, uin, rin, out from __TMP order by _time ASC");
$V6bad40ef=array();
while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V6bad40ef[$V4b43b0ae['h']]['rin']=$V4b43b0ae['rin'];
$V6bad40ef[$V4b43b0ae['h']]['uin']=$V4b43b0ae['uin'];
$V6bad40ef[$V4b43b0ae['h']]['out']=$V4b43b0ae['out'];
}
print '<table width="780" border="0" cellspacing="1" cellpadding="1" align="center">';
print '<tr><td>';
Fdecfcd82($V6bad40ef);
print '</td></tr>';
print '</table>';
}
function Fdecfcd82($V8d777f38) {
	$V6d8f09da=200;

	$Vd8bd79cc=9999999999;$V2ffe4e77=1;
while(list($V8ce4b16b,$V9e3669d1)=each($V8d777f38)) {
 $Vd8bd79cc=($V9e3669d1['rin']<$Vd8bd79cc)?$V9e3669d1['rin']:$Vd8bd79cc;
$Vd8bd79cc=($V9e3669d1['uin']<$Vd8bd79cc)?$V9e3669d1['uin']:$Vd8bd79cc;
$Vd8bd79cc=($V9e3669d1['out']<$Vd8bd79cc)?$V9e3669d1['out']:$Vd8bd79cc;

 $V2ffe4e77=($V9e3669d1['rin']>$V2ffe4e77)?$V9e3669d1['rin']:$V2ffe4e77;
$V2ffe4e77=($V9e3669d1['uin']>$V2ffe4e77)?$V9e3669d1['uin']:$V2ffe4e77;
$V2ffe4e77=($V9e3669d1['out']>$V2ffe4e77)?$V9e3669d1['out']:$V2ffe4e77;
}
$Vadac6a42=$V2ffe4e77/100;
if ($Vadac6a42 == 0) {$Vadac6a42 =1;}
$V7d5d15fc=floor($V6d8f09da/100);
reset($V8d777f38);
?>
	<table border="0" cellspacing="1" cellpadding="3" style="border: 1px solid Black;">
 <tr>
 <td><img src="../faces/chart_blue.gif" alt="" width="20" height="11" border="1"></td>
 <td><font style="font-size: 12px;">RAW IN</font></td>
 </tr>
 <tr>
 <td><img src="../faces/chart_green.gif" alt="" width="20" height="11" border="1"></td>
 <td><font style="font-size: 12px;">UNIQUE IN</font></td>
 </tr>
 <tr>
 <td><img src="../faces/chart_red.gif" alt="" width="20" height="11" border="1"></td>
 <td><font style="font-size: 12px;">OUT</font></td>
 </tr> 
	</table>
	<br>
	<table border="0" cellspacing="1" cellpadding="3" style="border: 1px solid Black;">
 <tr>
 <td colspan="<?php print count($V8d777f38)?>"><font style="font-size: 12px;">Last <?php print count($V8d777f38)?> hour stats.</font></td>
 </tr>
 <tr>
 <?php while (list($V8ce4b16b,$V9e3669d1)=each($V8d777f38)) {
 $Vd26e89c6=$V9e3669d1['rin']/$Vadac6a42; $Vd26e89c6=intval($Vd26e89c6*$V7d5d15fc);
$Vdb369493=$V9e3669d1['uin']/$Vadac6a42; $Vdb369493=intval($Vdb369493*$V7d5d15fc);
$Vb2cdd45a=$V9e3669d1['out']/$Vadac6a42; $Vb2cdd45a=intval($Vb2cdd45a*$V7d5d15fc);
?>
 <td valign="bottom" align="center" height="<?php print $V6d8f09da?>">
 <table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
 <td valign="bottom"><img src="../faces/chart_blue.gif" alt="<?php print $V9e3669d1['rin']?>" width="6" height="<?php print $Vd26e89c6?>" border="1" hspace="0" vspace="0"></td>
 <td valign="bottom"><img src="../faces/chart_green.gif" alt="<?php print $V9e3669d1['uin']?>" width="6" height="<?php print $Vdb369493?>" border="1" hspace="0" vspace="0"></td>
 <td valign="bottom"><img src="../faces/chart_red.gif" alt="<?php print $V9e3669d1['out']?>" width="6" height="<?php print $Vb2cdd45a?>" border="1" hspace="0" vspace="0"></td>
 </tr>
 </table>
 </td>
 <?php }?>
 </tr>
	</table>
	<br>
	<?php
}
?>
</body>
</html>
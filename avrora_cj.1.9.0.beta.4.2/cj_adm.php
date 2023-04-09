<?php
session_start();
include('./cj_config.php');
define('LOC_SYS_VERSION','1.9.0 beta 4');
F17978b15();
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB');
if ($_SESSION['key']!=md5(DB_LOGIN.DB_PASS)) {
	if ($_POST['passwd']) {
 if (Fc60879c6()) {
 Ff3836302();
}else {
 F5486cded();
}
}else {
 F5486cded();
}
}else {
	switch($_SERVER['QUERY_STRING']) {
 case '':
 Fc04593dc();
break;
case 'password':
 F5a9f3ebe();
break;
case 'settings':
 F64291cdb();
break;
case 'logout':
 Fbb6df904();
break;
case 'new_trader':
 Fba55a3dc();
break;
case 'group':
 F96371838();
break;
case 'banned_domain':
 Ffe454c54();
break;
case 'db_url':
 Fa26ffeb2();
break;
case 'mass_edit':
 F89e7a635();
break;
case 'link_generator':
 F9ce562c3();
break;
case 'proxy_analizer':
 F90ead391();
break;
case 'hitbot_analizer':
 F5570ba8b();
break;
case 'referer_analizer':
 Fd800be96();
break;
case 'thumbnail':
 F7318d066();
break;
case strstr($_SERVER['QUERY_STRING'],"edit_trader"):
 Fc59305bc(str_replace('edit_trader=','',$_SERVER['QUERY_STRING']));
break;
case strstr($_SERVER['QUERY_STRING'],"info"):
 F1e9cfe7b();
break;
case strstr($_SERVER['QUERY_STRING'],"delete_trader"):
 F17f42712(str_replace('delete_trader=','',$_SERVER['QUERY_STRING']));
break;
case strstr($_SERVER['QUERY_STRING'],"module"):
 include('./cj_modules/'.$_GET['module'].'/index.php');
F320d7f26();
break;
default:
 Fc04593dc();
}
}
mysql_close();
F335c6bdc();
 
function F0a73aba3() {
	
}
function Fe3b16d6c($V8c7dd922,$V2a304a13) {
	$V12cba3ee=false;
$V2a304a13=(trim($V2a304a13) == '')?'not_set':$V2a304a13;
if (is_uploaded_file($V8c7dd922['tmp_name'])) {
 $V7623f98d='up_'.time().'.jpg';
$V12cba3ee=copy($V8c7dd922['tmp_name'], './thumb/'.$V7623f98d);
unlink($V8c7dd922['tmp_name']);
}
if ($V12cba3ee==true) {
 $Vd77d5e50=array();
$Va149de46=$V2a304a13.';'.$V7623f98d."\n"; 
 $V8fa14cdd=fopen('./thumb/thumb.csv','r');
while ($V8277e091 = fgetcsv ($V8fa14cdd, 1000, ";")) {
 $Vd77d5e50[$V8277e091[1]]=trim($V8277e091[0]);
}
fclose($V8fa14cdd);
while(list($V8ce4b16b,$V9e3669d1)=each($Vd77d5e50)) {
 $Va149de46.=$V9e3669d1.';'.$V8ce4b16b."\n";
}
$V0666f0ac=fopen('./thumb/thumb.csv','w');
fwrite($V0666f0ac,$Va149de46);
fclose($V0666f0ac);
}else {
 print 'Upload failed. ';
}
}
function F5793d759($Vb80bb774) { 
	$Vd77d5e50=array();$Ve35eedc5=array(); 
	$V8fa14cdd=fopen('./thumb/thumb.csv','r');
while ($V8277e091 = fgetcsv ($V8fa14cdd, 1000, ";")) {
 $Vd77d5e50[$V8277e091[1]]=trim($V8277e091[0]);
}
fclose($V8fa14cdd);
while(list($V8ce4b16b,$V9e3669d1)=each($Vb80bb774)) {
 unset($Vd77d5e50[$V9e3669d1]);
print $V9e3669d1.' deleted<br>';
}
reset($Vd77d5e50); $Va149de46='';
while(list($V8ce4b16b,$V9e3669d1)=each($Vd77d5e50)) {
 $Va149de46.=$V9e3669d1.';'.$V8ce4b16b."\n";
}
$V0666f0ac=fopen('./thumb/thumb.csv','w');
fwrite($V0666f0ac,$Va149de46);
fclose($V0666f0ac);
 
	$V77ddcb5f=unserialize(@implode('',@file('./thumb/thumb.stats')));
if (!is_array($V77ddcb5f)) { $V77ddcb5f=array();}
reset($Vb80bb774);
while(list($V8ce4b16b,$V9e3669d1)=each($Vb80bb774)) {
 unset($V77ddcb5f[$V9e3669d1]);
@unlink('./thumb/'.$V9e3669d1);
}
if ($V0666f0ac=@fopen('./thumb/thumb.stats','w')) {
 flock($V0666f0ac,2);
fwrite($V0666f0ac,serialize($V77ddcb5f));
flock($V0666f0ac,3);
fclose($V0666f0ac);
}
}
function F7318d066() {
	if ($_POST['_id']) {
 F5793d759($_POST['_id']);
}
if ($_POST['new_thumb'] && $_FILES['new_file']['tmp_name']) {
 Fe3b16d6c($_FILES['new_file'],$_POST['new_url']);
}
$Vd77d5e50=array();$Ve35eedc5=array(); 
	$V8fa14cdd=fopen('./thumb/thumb.csv','r');
while ($V8277e091 = fgetcsv ($V8fa14cdd, 1000, ";")) {
 $Vd77d5e50[$V8277e091[1]]=trim($V8277e091[0]);
}
fclose($V8fa14cdd);
 
	$V77ddcb5f=@unserialize(@implode('',@file('./thumb/thumb.stats')));
if (!is_array($V77ddcb5f)) { $V77ddcb5f=array();} 
	arsort($V77ddcb5f,SORT_NUMERIC); reset($V77ddcb5f);
while(list($V8ce4b16b,$V9e3669d1)=each($V77ddcb5f)) { $Ve35eedc5[$V8ce4b16b]=$V9e3669d1; unset($Vd77d5e50[$V8ce4b16b]); }
while(list($V8ce4b16b,$V9e3669d1)=each($Vd77d5e50)) { $Ve35eedc5[$V8ce4b16b]=0; }
?>
	<table border="1" cellspacing="0" cellpadding="4" align="center">
 <form action="?thumbnail" method="post" enctype="multipart/form-data">
 <tr><td colspan="5" class="tblRTitle">Thumbnail manager (<?php print count($Ve35eedc5)?> thumb found)</td></tr>
 <?php $V865c0c0b=-1; while (list($V8ce4b16b,$V9e3669d1) = each($Ve35eedc5)) {
 $V865c0c0b=(intval($V865c0c0b)>=4)?0:$V865c0c0b+1;
if ($V865c0c0b==0) {print '<tr>';}
print '<td> <img src="thumb/'.$V8ce4b16b.'"><br> click: <b>'.$V9e3669d1.'</b> <input type="checkbox" name="_id[]" value="'.$V8ce4b16b.'"></td>';
if ($V865c0c0b==4) {print '</tr>';}
}?>
 <tr class="tblRNormal"><td colspan="5"><input type="submit" name="delete" value="delete selected" class="submit"></td></tr>
 <tr class="tblRNormal"><td colspan="5"><input type="text" name="new_url"> <= url for tumb<br><input type="file" name="new_file" accept="image/jpeg"> <input type="submit" name="new_thumb" value="upload new" class="submit"></td></tr>
	</form>
	</table>
	<?php
	F320d7f26();
}
function Fd800be96() {
	$Vdcab7235=array();
$V95687afb=opendir('./sys_log/');
while (false !== ($V8c7dd922 = readdir($V95687afb))) {
 if (substr($V8c7dd922,0,7)=='cj_ref_') {
 $Vdcab7235[]=$V8c7dd922;
}
}
closedir($V95687afb);
?>
	<table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
	<tr><td colspan="5" align="center" class="tblRTitle">Referer analizer</td></tr>	
	<tr class="tblRNormal">
 <form action="?referer_analizer" method="post">
 <td colspan="3">
 <select name="ref_file">
 <?php while(list($V8ce4b16b,$V9e3669d1)=each($Vdcab7235)) { ?>
 <option value="<?php print $V9e3669d1?>" <?php print ($_POST['ref_file']==$V9e3669d1)?'SELECTED':'';?>><?php print str_replace('.csv','',str_replace('cj_ref_','',$V9e3669d1))?></option>
 <?php } ?>
 </select><input type="submit" value="Analize" class="submit">
 </td>
 </form>
	</tr>
	<tr class="tblRNormal">
 <td width="80">&nbsp;Time</td>
 <td width="80">IP</td>
 <td width="460">Referer</td>
	</tr>
	<?php
	$Vd77d5e50=array();
if ($_POST['ref_file']) {
 $V0666f0ac = fopen ('./sys_log/'.$_POST['ref_file'],'r');
while ($V8d777f38 = fgetcsv ($V0666f0ac, 1000, ";")) {
 $Vd77d5e50[$V8d777f38[1]]['time']=$V8d777f38[0];
$Vd77d5e50[$V8d777f38[1]]['ip']=$V8d777f38[1];
$Vd77d5e50[$V8d777f38[1]]['referer']=$V8d777f38[2];
}
fclose ($V0666f0ac);
}

	while (list($V8ce4b16b,$V9e3669d1)=each($Vd77d5e50)) { ?>
	<tr class="tblRStat">
 <td>&nbsp;<?php print $Vd77d5e50[$V8ce4b16b]['time']?></td>
 <td><?php print $Vd77d5e50[$V8ce4b16b]['ip']?></td>
 <td><?php print $Vd77d5e50[$V8ce4b16b]['referer']?></td>
	</tr>
	<?php } ?>
	</table>
	<?php
	F320d7f26();
}
function F5570ba8b() {
	$Vd77d5e50=array();$V0c2c8a1b=array();
$V3a2d7564=$V3a2d7564=mysql_query("select tid, _domain from tm_cj_traders");
while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V0c2c8a1b[$V4b43b0ae['tid']]=$V4b43b0ae['_domain'];
}
if (is_file('./sys_log/banned.ip.csv')) {
 $V0666f0ac = fopen ('./sys_log/banned.ip.csv','r');
while ($V8d777f38 = fgetcsv ($V0666f0ac, 1000, ";")) {
 $Vd77d5e50[$V8d777f38[1]]['tid']=$V8d777f38[1];
$Vd77d5e50[$V8d777f38[1]]['domain']=$V0c2c8a1b[$V8d777f38[1]];
$Vd77d5e50[$V8d777f38[1]]['time']=$V8d777f38[0];
$Vd77d5e50[$V8d777f38[1]]['ip']=$V8d777f38[2];
$Vd77d5e50[$V8d777f38[1]]['agent']=$V8d777f38[3];
$Vd77d5e50[$V8d777f38[1]]['referer']=$V8d777f38[4];
}
fclose ($V0666f0ac);
}
?>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
	<tr><td colspan="5" align="center" class="tblRTitle">Hitbot analizer</td></tr>	
	<tr class="tblRNormal">
 <td>&nbsp;IP </td>
 <td>Time</td>
 <td>Trader</td>
 <td>Agent</td>
 <td>Referer</td>
	</tr>
	<?php while (list($V8ce4b16b,$V9e3669d1)=each($Vd77d5e50)) { ?>
	<tr class="tblRStat">
 <td>&nbsp;<?php print $Vd77d5e50[$V8ce4b16b]['ip']?></td>
 <td><?php print $Vd77d5e50[$V8ce4b16b]['time']?></td>
 <td><a href="cj_adm.php?edit_trader=<?php print $Vd77d5e50[$V8ce4b16b]['tid']?>"><?php print $Vd77d5e50[$V8ce4b16b]['domain']?></a></td>
 <td><?php print $Vd77d5e50[$V8ce4b16b]['agent']?></td>
 <td><?php print $Vd77d5e50[$V8ce4b16b]['referer']?></td>
	</tr>
	<?php } ?>
	</table>
	<?php
	F320d7f26();
}
function F90ead391() { 
	$V9778840a="select tid, count(_proxy) as _count from tm_cj_iplog where _proxy = 0 and _act=1 group by tid";
$V3a2d7564=mysql_query($V9778840a);
$V500b8afd=array();
while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V500b8afd[$V4b43b0ae['tid']] = $V4b43b0ae['_count'];
}
 
	$V9778840a="select tid, count(_proxy) as _count from tm_cj_iplog where _proxy = 1 and _act=1 group by tid";
$V3a2d7564=mysql_query($V9778840a);
$V3678a3f8=array();
while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V3678a3f8[$V4b43b0ae['tid']] = $V4b43b0ae['_count'];
}
$V3a2d7564=mysql_query("select * from tm_cj_traders where tid not in(2,3,4) order by tid");
?>
	<table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
	<tr><td colspan="4" align="center" class="tblRTitle">Proxy traffic during last <?php print IP_EXP_HOUR ?> hours.</td></tr>	
	<tr class="tblRNormal">
 <td width="410">&nbsp;Domain: </td>
 <td width="70">Unique</td>
 <td width="60">Clean %</td>
 <td width="60">Proxy %</td>
	</tr>
	<?php
	while ($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 $V8277e091=$V4b43b0ae['tid'];
$Va181a603=$V3678a3f8[$V8277e091]+$V500b8afd[$V8277e091];
$Vadac6a42=$Va181a603/100;
if ($Vadac6a42==0) {
 $V2651b9eb=0;
$Ve1d2b164=0;
}else {
 $V2651b9eb=intval($V500b8afd[$V8277e091])/$Vadac6a42;
$Ve1d2b164=intval($V3678a3f8[$V8277e091])/$Vadac6a42;
}
?>
 <tr class="tblRNormal">
 <td>&nbsp;<a href="cj_adm.php?edit_trader=<?php print $V4b43b0ae['tid']?>"><?php print $V4b43b0ae['_domain']?></a></td>
 <td><?php print $V3678a3f8[$V8277e091]+$V500b8afd[$V8277e091];?></td>
 <td><?php print round($V2651b9eb);?></td>
 <td><?php print round($Ve1d2b164);?></td>
 </tr>
 <?php
	}
?>
	</table>
	<?php
	F320d7f26();
}
function F1e9cfe7b() {
	if ($_GET['about'] == 'exout') {
 $V3a2d7564=mysql_query("select count(tid) as _count, _ip from tm_cj_iplog where _act=2 and tid=3 group by _ip order by 1 desc");
while($Vf1965a85=mysql_fetch_array($V3a2d7564)) {
 print $Vf1965a85['_count'].' - '.long2ip($Vf1965a85['_ip']).'<br>';
}
}
F320d7f26();
}
function Fa26ffeb2() {
	if ($_POST['_url']) {
 $V064e6286=explode("\n",ereg_replace("(\r\n|\r)","\n",$_POST['_url']));
mysql_query("delete from tm_cj_dburl");
while(list($V8ce4b16b,$V9e3669d1) = each($V064e6286)) {
 $V865c0c0b++;
if (trim($V9e3669d1) != '') {
 mysql_query("insert into tm_cj_dburl set url='".trim($V9e3669d1)."'");
}
}
sys_msg('Updated','ok');
}else {
 $V3a2d7564=mysql_query("select * from tm_cj_dburl order by url asc");
?>
 <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?db_url" method="post">
 <tr><td align="center" class="tblRTitle">DB Url List</td></tr>	
 <tr class="tblRNormal">
 <td width="100%"><textarea cols="" rows="15" name="_url" wrap="off" style="width: 100%;"><?php while($Vf1965a85=mysql_fetch_array($V3a2d7564)) {print $Vf1965a85['url']."\n";}?></textarea></td>
 </tr>
 <tr class="tblRNormal"><td align="center"><input type="submit" name="update" value="update" class="submit"></td></tr>
 </table>
 <?php
 F320d7f26();
}
}
function Ffe454c54() {
	if ($_POST['update']) {
 $Vad5f82e8=explode("\n",ereg_replace("(\r\n|\r)","\n",$_POST['_domains']));
mysql_query("delete from tm_cj_banned");
while(list($V8ce4b16b,$V9e3669d1) = each($Vad5f82e8)) {
 mysql_query("insert into tm_cj_banned values('".trim($V9e3669d1)."')");
}
sys_msg('Updated','ok');
}else {
 $V3a2d7564=mysql_query("select * from tm_cj_banned");
?>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?banned_domain" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Banned Domains</td></tr>	
 <tr class="tblRNormal">
 <td width="400"><textarea cols="" rows="10" name="_domains" style="width: 398px;"><?php while($Vf1965a85=mysql_fetch_array($V3a2d7564)) {print $Vf1965a85['domain']."\n";}?></textarea></td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="update" value="update" class="submit"></td></tr>
 </table>
 <?php
 F320d7f26();
}
}
function F9ce562c3() {
	if ($_POST['generate']) {
 $group="000000000000000000";
while (list($V8ce4b16b,$V9e3669d1)=each($_POST['_cat'])) {
 $group[$V9e3669d1]=1;
}$gr=bindec($group);
print '<br><center></P>Please use link -> cj_out.php?gr='.$gr.'<br></center><br>';
}
?>
	<table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?link_generator" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Link Generator</td></tr>	
 <tr class="tblRNormal">
 <td valign="top" width="150">&nbsp;Type: </td>
 <td width="250">
 <select name="_cat[]" size="3" multiple style="width: 97%;">
 <option value="0" <?php if ($group[0] == 1) {print 'SELECTED';}?>>Pay Site</option>
 <option value="1" <?php if ($group[1] == 1) {print 'SELECTED';}?>>Top</option>
 <option value="2" <?php if ($group[2] == 1) {print 'SELECTED';}?>>CJ</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Group: </td>
 <td>
 <select name="_cat[]" size="6" multiple style="width: 97%;">
 <?php $V964d89a1=mysql_query("select * from tm_cj_group where _desc !=''");
while($V4b43b0ae=mysql_fetch_array($V964d89a1)) {	?>
 <option value="<?php print $V4b43b0ae['gid']+2?>" <?php if ($group[$V4b43b0ae['gid']+2] == 1) {print 'SELECTED';}?>><?php print $V4b43b0ae['_desc']?></option>
 <?php } ?>
 </select>
 </td>
 </tr> 
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="generate" value="generate" class="submit"></td></tr>
 <br><br>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center">
 <tr>
 <td>
 <font color="#808040">&tr=domain.com</font> 
 <font color="#808040">&url=http://www.domain.com/url/</font> 
 <font color="#808040">&dburl=yes</font> 
 <font color="#808040">&p=50</font> 
 <font color="#808040">&fk=1</font> 
 </td>
 </tr>
 </table>
	<?php
	F320d7f26();
}
function F17f42712($V97beaa21) {
	if ($V97beaa21 > 4) {
 mysql_query("delete from tm_cj_dstats where tid=".$V97beaa21);
mysql_query("delete from tm_cj_force where tid=".$V97beaa21);
mysql_query("delete from tm_cj_hour where tid=".$V97beaa21);
mysql_query("delete from tm_cj_stats where tid=".$V97beaa21);
mysql_query("delete from tm_cj_tmpst where tid=".$V97beaa21);
$V3a2d7564=mysql_query("select _domain from tm_cj_traders where tid=".$V97beaa21);
mysql_query("insert into tm_cj_banned values('".mysql_result($V3a2d7564,0,'_domain')."')");
mysql_query("delete from tm_cj_traders where tid=".$V97beaa21);
sys_msg('Trader deleted','ok');
}else {
 sys_msg('System trader cannot be deleted','warning');
}
}
function F89e7a635() {
	if ($_POST['update']) {
 while(list($V8ce4b16b,$V9e3669d1)=each($_POST['_tid'])){
 mysql_query("update tm_cj_traders set _status='".$_POST['_status']."' where tid=".$V9e3669d1);
mysql_query("update tm_cj_tmpst set _force =".intval($_POST['_force_now'])." where tid=".$V9e3669d1);
reset($_POST['_force']);
while(list($V61620957,$V1b267619)=each($_POST['_force'])) {
 mysql_query("update tm_cj_force set _force='".intval($V1b267619)."' where tid='".$V9e3669d1."' and _hour='".$V61620957."'");
}
}
sys_msg('Traders updated','ok');
}else {
 $V3a2d7564=mysql_query("select tid, _status, _domain from tm_cj_traders where tid > 4 order by 3 asc");
?>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?mass_edit" method="post" name="form1">
 <tr><td colspan="2" align="center" class="tblRTitle">Mass Force Edit</td></tr>	
 <tr>
 <td colspan="2" class="tblRNormal">
 <?php 
 while($V4b43b0ae=mysql_fetch_array($V3a2d7564)) {
 ?><input type="checkbox" name="_tid[<?php print $V4b43b0ae['tid']?>]" value="<?php print $V4b43b0ae['tid']?>"> <a href="cj_adm.php?edit_trader=<?php print $V4b43b0ae['tid']?>" <?php if ($V4b43b0ae['_status'] == 'off') {print 'style="color: Maroon;"';}?>><?php print $V4b43b0ae['_domain']?></a><br><?php
 }
?>
 <br>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td width="150">&nbsp;Status: </td>
 <td width="250">
 <select name="_status" style="width: 97%;">
 <option value="on" SELECTED>ON</option>
 <option value="off" >OFF</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td colspan="2">
 <script>
 function F432381ec(force) {
 for (i=0;i<24;i++) {
 document.forms('form1').elements('_force['+i+']').value=force;
}
document.forms('form1')._force_now.value=force;
return;
}
</script>
 <table width="100%" border="0" cellspacing="1" cellpadding="1">
 <tr class="tblRNormal"><td colspan="3" align="center">Time Force</td></tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">00 h. <input type="text" name="_force[0]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">08 h. <input type="text" name="_force[8]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">16 h. <input type="text" name="_force[16]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">01 h. <input type="text" name="_force[1]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">09 h. <input type="text" name="_force[9]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">17 h. <input type="text" name="_force[17]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">02 h. <input type="text" name="_force[2]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">10 h. <input type="text" name="_force[10]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">18 h. <input type="text" name="_force[18]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">03 h. <input type="text" name="_force[3]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">11 h. <input type="text" name="_force[11]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">19 h. <input type="text" name="_force[19]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">04 h. <input type="text" name="_force[4]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">12 h. <input type="text" name="_force[12]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">20 h. <input type="text" name="_force[20]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">05 h. <input type="text" name="_force[5]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">13 h. <input type="text" name="_force[13]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">21 h. <input type="text" name="_force[21]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">06 h. <input type="text" name="_force[6]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">14 h. <input type="text" name="_force[14]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">22 h. <input type="text" name="_force[22]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">07 h. <input type="text" name="_force[7]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">15 h. <input type="text" name="_force[15]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">23 h. <input type="text" name="_force[23]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">Now: <input type="text" name="_force_now" value="<?php print $V8fa14cdd['_force_now']?>" style="width: 50px;"></td>
 <td width="33%" align="center" colspan="2"><a onclick="F432381ec(_force_set_all.value)" style="cursor:hand">Set All</a> <input type="text" name="_force_set_all" style="width: 50px;"></td>
 </tr>
 </table>
 </td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="update" value="update" class="submit"></td></tr>
 </form>
 </table>
 <?php
 F320d7f26();
}
}
function Fc59305bc($V97beaa21) {
	if ($_POST['update']) {
 $group="000000000000000000";
while (list($V8ce4b16b,$V9e3669d1)=@each($_POST['_cat'])) {
 $group[$V9e3669d1]=1;
}
$group=bindec($group);
if ($V97beaa21 > 4 && trim($_POST['_url']) != '') {
 while(list($V8ce4b16b,$V9e3669d1)=each($_POST['_force'])) {
 mysql_query("update tm_cj_force set _force='".intval($V9e3669d1)."' where tid='".$V97beaa21."' and _hour='".$V8ce4b16b."'");
}
if (!$_POST['_domain']) {
 $Vfa816edb=parse_url($_POST['_url']);
$_POST['_domain']=str_replace('www.','',$Vfa816edb['host']);
}
if ($_POST['_passwd']) {$V1a1dc91c=", _pass='".md5(trim($_POST['_passwd']))."'";}
$V9778840a="update tm_cj_traders set
 _egid='".$group."',
 _status='".$_POST['_status']."',
 _domain='".$_POST['_domain']."',
 _face='".$_POST['_face']."',
 _url='".$_POST['_url']."',
 _mail='".$_POST['_mail']."',
 _back='".$_POST['_back']."',
 _icq='".$_POST['_icq']."'".$V1a1dc91c."
 where tid=".$V97beaa21;
mysql_query($V9778840a);
mysql_query("update tm_cj_tmpst set _force =".intval($_POST['_force_now'])." where tid=".$V97beaa21);
}elseif(trim($_POST['_url']) != '') {
 $V9778840a="update tm_cj_traders set _face='".$_POST['_face']."', _url='".$_POST['_url']."' where tid=".$V97beaa21;
mysql_query($V9778840a);
}
sys_msg('Trader updated','ok');
}else {
 $V3a2d7564=mysql_query("select * from tm_cj_traders where tid=".$V97beaa21);
$Vf1965a85=mysql_fetch_array($V3a2d7564);
$gr=sprintf("%018s", decbin ($Vf1965a85['_egid']));
?>
 <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?edit_trader=<?php print $V97beaa21?>" method="post" name="form1">
 <tr><td class="tblRTitle">&nbsp;<a onclick="window.open('cj_modules/chart.php?tr=<?php print $V97beaa21; ?>')" style="cursor:hand"><font color="#FFFF00">chart</font></a></td><td align="center" class="tblRTitle"><a href="cj_adm.php?delete_trader=<?php print $V97beaa21?>" onClick="return confirm('Are you sure DELETE this trader?')"><img src="faces/del.gif" alt="Delete current trader" width="8" height="9" border="0" align="right"></a>Edit Trader</td></tr>	
	
 <tr class="tblRNormal">
 <td width="150">&nbsp;Domain: </td>
 <td width="450"><input type="text" name="_domain" value="<?php print $Vf1965a85['_domain']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Face: </td>
 <td><input type="text" name="_face" value="<?php print $Vf1965a85['_face']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;URL: </td>
 <td><input type="text" name="_url" value="<?php print $Vf1965a85['_url']?>" style="width: 445px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Back Prod: </td>
 <td><input type="text" name="_back" value="<?php print $Vf1965a85['_back']?>" style="width: 60px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;E-mail: </td>
 <td><input type="text" name="_mail" value="<?php print $Vf1965a85['_mail']?>" style="width: 300px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;ICQ: </td>
 <td><input type="text" name="_icq" value="<?php print $Vf1965a85['_icq']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Password: </td>
 <td><input type="password" name="_passwd" value="<?php print $Vf1965a85['_passwd']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Status: </td>
 <td>
 <select name="_status" style="width: 60px;">
 <option value="on" <?php if ($Vf1965a85['_status'] == 'on') {print 'SELECTED';}?>>ON</option>
 <option value="off" <?php if ($Vf1965a85['_status'] == 'off') {print 'SELECTED';}?>>OFF</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Type: </td>
 <td>
 <select name="_cat[]" size="3" multiple style="width: 300px;">
 <option value="0" <?php if ($gr[0] == 1) {print 'SELECTED';}?>>Pay Site</option>
 <option value="1" <?php if ($gr[1] == 1) {print 'SELECTED';}?>>Top</option>
 <option value="2" <?php if ($gr[2] == 1) {print 'SELECTED';}?>>CJ</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Group: </td>
 <td>
 <select name="_cat[]" size="3" multiple style="width: 300px;">
 <?php $V964d89a1=mysql_query("select * from tm_cj_group where _desc !=''");
while($V4b43b0ae=mysql_fetch_array($V964d89a1)) {	?>
 <option value="<?php print $V4b43b0ae['gid']+2?>" <?php if ($gr[$V4b43b0ae['gid']+2] == 1) {print 'SELECTED';}?>><?php print $V4b43b0ae['_desc']?></option>
 <?php } ?>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td colspan="2">
 <?php
 $Ve138384f=mysql_query("select * from tm_cj_force where tid=".$V97beaa21);
while($Vbea2f3fe=mysql_fetch_array($Ve138384f)) {
 $V8fa14cdd[$Vbea2f3fe['_hour']]['hour']=$Vbea2f3fe['_hour'];
$V8fa14cdd[$Vbea2f3fe['_hour']]['force']=$Vbea2f3fe['_force'];
}
$Ve138384f=mysql_query("select _force from tm_cj_tmpst where tid=".$V97beaa21);
$V8fa14cdd['_force_now']=mysql_result($Ve138384f,0,'_force');
?>
 <script>
 function F432381ec(force) {
 for (i=0;i<24;i++) {
 document.forms('form1').elements('_force['+i+']').value=force;
}
document.forms('form1')._force_now.value=force;
return;
}
</script>
 <table width="100%" border="0" cellspacing="1" cellpadding="1">
 <tr class="tblRNormal"><td colspan="3" align="center">Time Force</td></tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">00 h. <input type="text" name="_force[<?php print $V8fa14cdd[0]['hour']?>]" value="<?php print $V8fa14cdd[0]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">08 h. <input type="text" name="_force[<?php print $V8fa14cdd[8]['hour']?>]" value="<?php print $V8fa14cdd[8]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">16 h. <input type="text" name="_force[<?php print $V8fa14cdd[16]['hour']?>]" value="<?php print $V8fa14cdd[16]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">01 h. <input type="text" name="_force[<?php print $V8fa14cdd[1]['hour']?>]" value="<?php print $V8fa14cdd[1]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">09 h. <input type="text" name="_force[<?php print $V8fa14cdd[9]['hour']?>]" value="<?php print $V8fa14cdd[9]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">17 h. <input type="text" name="_force[<?php print $V8fa14cdd[17]['hour']?>]" value="<?php print $V8fa14cdd[17]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">02 h. <input type="text" name="_force[<?php print $V8fa14cdd[2]['hour']?>]" value="<?php print $V8fa14cdd[2]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">10 h. <input type="text" name="_force[<?php print $V8fa14cdd[10]['hour']?>]" value="<?php print $V8fa14cdd[10]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">18 h. <input type="text" name="_force[<?php print $V8fa14cdd[18]['hour']?>]" value="<?php print $V8fa14cdd[18]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">03 h. <input type="text" name="_force[<?php print $V8fa14cdd[3]['hour']?>]" value="<?php print $V8fa14cdd[3]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">11 h. <input type="text" name="_force[<?php print $V8fa14cdd[11]['hour']?>]" value="<?php print $V8fa14cdd[11]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">19 h. <input type="text" name="_force[<?php print $V8fa14cdd[19]['hour']?>]" value="<?php print $V8fa14cdd[19]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">04 h. <input type="text" name="_force[<?php print $V8fa14cdd[4]['hour']?>]" value="<?php print $V8fa14cdd[4]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">12 h. <input type="text" name="_force[<?php print $V8fa14cdd[12]['hour']?>]" value="<?php print $V8fa14cdd[12]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">20 h. <input type="text" name="_force[<?php print $V8fa14cdd[20]['hour']?>]" value="<?php print $V8fa14cdd[20]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">05 h. <input type="text" name="_force[<?php print $V8fa14cdd[5]['hour']?>]" value="<?php print $V8fa14cdd[5]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">13 h. <input type="text" name="_force[<?php print $V8fa14cdd[13]['hour']?>]" value="<?php print $V8fa14cdd[13]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">21 h. <input type="text" name="_force[<?php print $V8fa14cdd[21]['hour']?>]" value="<?php print $V8fa14cdd[21]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">06 h. <input type="text" name="_force[<?php print $V8fa14cdd[6]['hour']?>]" value="<?php print $V8fa14cdd[6]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">14 h. <input type="text" name="_force[<?php print $V8fa14cdd[14]['hour']?>]" value="<?php print $V8fa14cdd[14]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">22 h. <input type="text" name="_force[<?php print $V8fa14cdd[22]['hour']?>]" value="<?php print $V8fa14cdd[22]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">07 h. <input type="text" name="_force[<?php print $V8fa14cdd[7]['hour']?>]" value="<?php print $V8fa14cdd[7]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">15 h. <input type="text" name="_force[<?php print $V8fa14cdd[15]['hour']?>]" value="<?php print $V8fa14cdd[15]['force']?>" style="width: 50px;"></td>
 <td width="33%" align="center">23 h. <input type="text" name="_force[<?php print $V8fa14cdd[23]['hour']?>]" value="<?php print $V8fa14cdd[23]['force']?>" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">Now: <input type="text" name="_force_now" value="<?php print $V8fa14cdd['_force_now']?>" style="width: 50px;"></td>
 <td width="33%" align="center" colspan="2"><a onclick="F432381ec(_force_set_all.value)" style="cursor:hand">Set All</a> <input type="text" name="_force_set_all" style="width: 50px;"></td>
 </tr>
 </table>
 </td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="update" value="update" class="submit"></td></tr>
 </form>
 </table>
 <br>
 <?php
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
 <?php
 F320d7f26();
}
}
function F96371838() {
	if ($_POST['update']) {
 while(list($V8ce4b16b,$V9e3669d1)=each($_POST['_desc'])) {
 mysql_query("update tm_cj_group set _desc='".trim($V9e3669d1)."' where gid=".$V8ce4b16b);
}
sys_msg('Group updated','ok');
}else {
 $V3a2d7564=mysql_query("select * from tm_cj_group");
?>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?group" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Group</td></tr>
 <?php while($Vf1965a85=mysql_fetch_array($V3a2d7564)) {?>
 <tr class="tblRNormal">
 <td width="50">&nbsp;<?php print $Vf1965a85['gid']?>: </td>
 <td width="350"><input type="text" name="_desc[<?php print $Vf1965a85['gid']?>]" value="<?php print $Vf1965a85['_desc']?>" style="width: 97%;"></td>
 </tr>
 <?php } ?>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="update" value="update" class="submit"></td></tr>
 </form>
 </table>
 <?php
 F320d7f26();
}
}
function Fba55a3dc() {
	$Vcb5e100e=false;
if ($_POST['_url']) {
 if (!$_POST['_domain']) {
 $Vfa816edb=parse_url($_POST['_url']);
$_POST['_domain']=str_replace('www.','',$Vfa816edb['host']);
}
$V3a2d7564=mysql_query("select tid from tm_cj_traders where _domain='".$_POST['_domain']."'");
if (mysql_num_rows($V3a2d7564) > 0) {
 $Vcb5e100e=true;
sys_msg('Trader already exist.','warning');
}
$V3a2d7564=mysql_query("select domain from tm_cj_banned where domain='".$_POST['_domain']."'");
if (mysql_num_rows($V3a2d7564) > 0) {
 $Vcb5e100e=true;
sys_msg('Trader banned.','warning');
}
if ($Vcb5e100e !=true) {
 $group="000000000000000000";
while (list($V8ce4b16b,$V9e3669d1)=@each($_POST['_cat'])) {
 $group[$V9e3669d1]=1;
}$group=bindec($group);
$V9778840a="insert into tm_cj_traders set
 _status='".$_POST['_status']."',
 _egid='".$group."',
 _domain='".$_POST['_domain']."',
 _face='".$_POST['_face']."',
 _url='".$_POST['_url']."',
 _mail='".$_POST['_mail']."',
 _icq='".$_POST['_icq']."',
 _back='".$_POST['_back']."',
 _pass='".md5($_POST['_passwd'])."'";
mysql_query($V9778840a) or die(mysql_error());
$V97beaa21=mysql_insert_id();
for ($V865c0c0b=0;$V865c0c0b<24;$V865c0c0b++){
 mysql_query("insert into tm_cj_force(tid,_hour,_force) values('".$V97beaa21."','".$V865c0c0b."','".intval($_POST['_force'][$V865c0c0b])."')");
}
mysql_query("INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk) VALUES (".$V97beaa21.", 0, 0, 0, 0, 0, 0, 0, 0)");
mysql_query("INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES (".$V97beaa21.", 0, 0, 0, 0, ".intval($_POST['_force_now']).")");
sys_msg('Trader created.','ok');
}
}else {
 ?>
 <br><br><br>
 <script>
 function F432381ec(force) {
 for (i=0;i<24;i++) {
 document.forms('form1').elements('_force['+i+']').value=force;
}
document.forms('form1')._force_now.value=force;
return;
}
</script>
 <table width="600" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?new_trader" method="post" name="form1">
 <tr><td colspan="2" align="center" class="tblRTitle">New Trader</td></tr>	
	
 <tr class="tblRNormal">
 <td width="150">&nbsp;Domain: </td>
 <td width="450"><input type="text" name="_domain" value="<?php print $_POST['_domain']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="150">&nbsp;Face: </td>
 <td width="250"><input type="text" name="_face" value="<?php print $_POST['_face']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;URL: </td>
 <td><input type="text" name="_url" value="<?php print $_POST['_url']?>" style="width: 445px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Back Prod: </td>
 <td><input type="text" name="_back" value="<?php print BACK_PRD?>" style="width: 60px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;E-mail: </td>
 <td><input type="text" name="_mail" value="<?php print $_POST['_mail']?>" style="width: 300px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;ICQ: </td>
 <td><input type="text" name="_icq" value="<?php print $_POST['_icq']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Password: </td>
 <td><input type="password" name="_passwd" value="<?php print $_POST['_passwd']?>" style="width: 200px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Status: </td>
 <td>
 <select name="_status">
 <option value="on" <?php if ($_POST['_status'] == 'on') {print 'SELECTED';}?>>ON</option>
 <option value="off" <?php if ($_POST['_status'] == 'off') {print 'SELECTED';}?>>OFF</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Type: </td>
 <td>
 <select name="_cat[]" size="3" multiple style="width: 300px;">
 <option value="0">Pay Site</option>
 <option value="1">Top</option>
 <option value="2">CJ</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td valign="top">&nbsp;Group: </td>
 <td>
 <select name="_cat[]" size="3" multiple style="width: 300px;">
 <?php $V964d89a1=mysql_query("select * from tm_cj_group where _desc !=''");
while($V4b43b0ae=mysql_fetch_array($V964d89a1)) {	?>
 <option value="<?php print $V4b43b0ae['gid']+2?>"><?php print $V4b43b0ae['_desc']?></option>
 <?php } ?>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td colspan="2">
 <table width="100%" border="0" cellspacing="1" cellpadding="1">
 <tr class="tblRNormal"><td colspan="3" align="center">Time Force</td></tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">00 h. <input type="text" name="_force[0]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">08 h. <input type="text" name="_force[8]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">16 h. <input type="text" name="_force[16]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">01 h. <input type="text" name="_force[1]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">09 h. <input type="text" name="_force[9]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">17 h. <input type="text" name="_force[17]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">02 h. <input type="text" name="_force[2]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">10 h. <input type="text" name="_force[10]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">18 h. <input type="text" name="_force[18]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">03 h. <input type="text" name="_force[3]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">11 h. <input type="text" name="_force[11]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">19 h. <input type="text" name="_force[19]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">04 h. <input type="text" name="_force[4]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">12 h. <input type="text" name="_force[12]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">20 h. <input type="text" name="_force[20]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">05 h. <input type="text" name="_force[5]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">13 h. <input type="text" name="_force[13]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">21 h. <input type="text" name="_force[21]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">06 h. <input type="text" name="_force[6]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">14 h. <input type="text" name="_force[14]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">22 h. <input type="text" name="_force[22]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">07 h. <input type="text" name="_force[7]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">15 h. <input type="text" name="_force[15]" value="0" style="width: 50px;"></td>
 <td width="33%" align="center">23 h. <input type="text" name="_force[23]" value="0" style="width: 50px;"></td>
 </tr>
 <tr class="tblRNormal">
 <td width="33%" align="center">Now: <input type="text" name="_force_now" value="<?php print $V8fa14cdd['_force_now']?>" style="width: 50px;"></td>
 <td width="33%" align="center" colspan="2"><a onclick="F432381ec(_force_set_all.value)" style="cursor:hand">Set All</a> <input type="text" name="_force_set_all" style="width: 50px;"></td>
 </tr>
 </table>
 </td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="create" value="add" class="submit"></td></tr>
 </form>
 </table>
 <?php
 F320d7f26();
}
}
function Fbb6df904() {
	$_SESSION['key']='logout';
sys_msg('Bye','ok');
}
function sys_msg($V6e2baaf3,$Va2f2ed4f,$Vf17ca2c8=true) {
	?>
	<br><br><br>
	<table width="230" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <tr class="<?php print $Va2f2ed4f?>"><td align="center"><?php print $V6e2baaf3?></td></tr>
	</table>	
	<?php
	if ($Vf17ca2c8 == true) {
 print '<script language="JavaScript">setTimeout("window.location=\'cj_adm.php?start\'",1000);</script>';
}
}
function F64291cdb() {
	if ($_POST['update']) {
 if (count($_POST) != 10) {
 sys_msg('Settings incorrect, skipping ... ','warning');
}else {
 while(list($V8ce4b16b,$V9e3669d1)=each($_POST)) { $_POST[$V8ce4b16b]=trim($V9e3669d1); }
$V8277e091=implode('',file('./cj_config.php'));
$V8277e091=str_replace('define(\'IP_EXP_HOUR\',\''.IP_EXP_HOUR.'\');','define(\'IP_EXP_HOUR\',\''.$_POST['IP_EXP_HOUR'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'DEF_P\',\''.DEF_P.'\');','define(\'DEF_P\',\''.$_POST['DEF_P'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'HOUR_STAT\',\''.HOUR_STAT.'\');','define(\'HOUR_STAT\',\''.$_POST['HOUR_STAT'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'BACK_PRD\',\''.BACK_PRD.'\');','define(\'BACK_PRD\',\''.$_POST['BACK_PRD'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'MAX_CLICK\',\''.MAX_CLICK.'\');','define(\'MAX_CLICK\',\''.$_POST['MAX_CLICK'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'NEW_TRADER\',\''.NEW_TRADER.'\');','define(\'NEW_TRADER\',\''.$_POST['NEW_TRADER'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'SYS_VERSION\',\''.SYS_VERSION.'\');','define(\'SYS_VERSION\',\''.LOC_SYS_VERSION.'\');',$V8277e091);
$V8277e091=str_replace('define(\'IGNORE_BACK_PRD\',\''.IGNORE_BACK_PRD.'\');','define(\'IGNORE_BACK_PRD\',\''.$_POST['IGNORE_BACK_PRD'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'FORCE_PRIO\',\''.FORCE_PRIO.'\');','define(\'FORCE_PRIO\',\''.$_POST['FORCE_PRIO'].'\');',$V8277e091);
$V8277e091=str_replace('define(\'USE_TOP\',\''.USE_TOP.'\');','define(\'USE_TOP\',\''.$_POST['USE_TOP'].'\');',$V8277e091);
$V0666f0ac=fopen('./cj_config.php','wb');
fwrite($V0666f0ac,$V8277e091);
fclose($V0666f0ac);
sys_msg('Settings changed','ok');
}
}else {
 ?>
 <br><br><br>
 <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?settings" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">CJ Settings</td></tr>
 <tr class="tblRNormal">
 <td width="300">&nbsp;IP Expire Hour: </td>
 <td width="100"><input type="text" name="IP_EXP_HOUR" value="<?php print IP_EXP_HOUR?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Out % to content: </td>
 <td><input type="text" name="DEF_P" value="<?php print DEF_P?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Trader Stats (Hour) : </td>
 <td><input type="text" name="HOUR_STAT" value="<?php print HOUR_STAT?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Return Back %: </td>
 <td><input type="text" name="BACK_PRD" value="<?php print BACK_PRD?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Turbo Force: </td>
 <td>
 <select name="IGNORE_BACK_PRD" style="width: 60px;">
 <option value="1" <?php if (IGNORE_BACK_PRD == '1') {print 'SELECTED';}?>>YES</option>
 <option value="0" <?php if (IGNORE_BACK_PRD == '0') {print 'SELECTED';}?>>NO</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Force Prio: </td>
 <td><input type="text" name="FORCE_PRIO" value="<?php print FORCE_PRIO?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Count MAX Click: </td>
 <td><input type="text" name="MAX_CLICK" value="<?php print MAX_CLICK?>" style="width: 45px"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Accept New Traders: </td>
 <td>
 <select name="NEW_TRADER" style="width: 60px;">
 <option value="yes" <?php if (NEW_TRADER == 'yes') {print 'SELECTED';}?>>YES</option>
 <option value="no" <?php if (NEW_TRADER == 'no') {print 'SELECTED';}?>>NO</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Generate Top: </td>
 <td>
 <select name="USE_TOP" style="width: 60px;">
 <option value="1" <?php if (USE_TOP == '1') {print 'SELECTED';}?>>YES</option>
 <option value="0" <?php if (USE_TOP == '0') {print 'SELECTED';}?>>NO</option>
 </select>
 </td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="update" value="change" class="submit"></td></tr>
 </form>
 </table>
 <?php
 F320d7f26();
}
}
function F5a9f3ebe() {
	if ($_POST['old_pass'] && $_POST['new1_pass'] == $_POST['new2_pass'] && trim($_POST['new1_pass']) != '') {
 mysql_query("update tm_cj_traders set _pass='".md5(trim($_POST['new1_pass']))."' where tid=1 and _pass='".md5(trim($_POST['old_pass']))."'");
if (mysql_affected_rows() !=1) {
 sys_msg('Incorrect current password','warning');
}else {
 sys_msg('Password changed','ok');
}
}else {
 ?>
 <br><br><br>
 <table width="300" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?password" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Set new password ...</td></tr>
 <tr class="tblRNormal">
 <td width="140">&nbsp;Old password: </td>
 <td width="160"><input type="password" name="old_pass" value="<?php print $_POST['old_pass']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;New password: </td>
 <td><input type="password" name="new1_pass" value="<?php print $_POST['new1_pass']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal">
 <td>&nbsp;Repeate password: </td>
 <td><input type="password" name="new2_pass" value="<?php print $_POST['new2_pass']?>" style="width: 97%;"></td>
 </tr> 
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="Go" value="change" class="submit"></td></tr>
 </form>
 </table>
 <?php
 F320d7f26();
}
}
function F320d7f26() {
	include('./cj_modules/index.php');
$V8277e091='';
?>
	<img src="/p.gif" alt="" width="1" height="10" border="0"><br>
	<table width="780" border="0" cellspacing="1" cellpadding="0" align="center" style="border: 1px solid #4B0082;">
 <tr class="tblMenu" style="background: #6f7d91;"><td>General: <a href="?start" class="mLink">Start Page</a> &raquo; <a href="?settings" class="mLink">CJ Settings</a> &raquo; <a href="?password" class="mLink">Change Password</a> &raquo; <a href="?logout" class="mLink">Logout</a></td></tr>
 <tr class="tblMenu" style="background: #6f7d91;"><td>Traders: <a href="?group" class="mLink">Group</a> &raquo; <a href="?new_trader" class="mLink">New Trader</a> &raquo; <a href="?mass_edit" class="mLink">Mass Edit</a> &raquo; <a href="?banned_domain" class="mLink">Banned Domains</a></td></tr>
 <tr class="tblMenu" style="background: #6f7d91;"><td>Content: <a href="?link_generator" class="mLink">Link Generator</a> &raquo; <a href="?db_url" class="mLink">DB URL List</a> &raquo; <a href="?thumbnail" class="mLink">Thumbnail manager</a></td></tr>
 <tr class="tblMenu" style="background: #6f7d91;"><td>Statistic: <a href="?proxy_analizer" class="mLink">Proxy Analizer</a> &raquo; <a href="?hitbot_analizer" class="mLink">Hitbot Analizer</a> &raquo; <a href="?referer_analizer" class="mLink">Referer Analizer</a></td></tr>
 <tr class="tblMenu" style="background: #6f7d91;">
 <td>Modules: 
 <?php while(list($V8ce4b16b,$V9e3669d1)=each($cj_modules)) { ?>
 <?php print $V8277e091;?> <a href="?module=<?php print $V8ce4b16b?>" class="mLink"><?php print $V9e3669d1?></a> 
 <?php $V8277e091='&raquo;'; } ?>
 </td>
 </tr>
	</table>
	<?php
}
function Fc04593dc() {
	$V877d84ee=0;
$V3d31c5e9=0;
$V460a9ec1=0;
$V03c7c0ac=array();
$V3a2d7564=mysql_query("select * from tm_cj_settings where id='last_trader_view'");
$V3d2cd23e=mysql_result($V3a2d7564,0,'value');
$Va94ce50e="select t.tid, t._domain, t._status, s._huin, s._hrin, s._hout, s._hclk,
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
 (s._out*100)/(if(s._uin=0,1,s._uin)) as all_rtn
	from tm_cj_traders t, tm_cj_stats s, tm_cj_tmpst tmp 
 where t.tid=s.tid and tmp.tid = t.tid and t.tid {TRADER_XD} 4
	order by {ORDER_TYPE}";
 
	$V70a17ffa='tid asc';
$Ve358efa4= '<=';
$V9778840a=str_replace('{TRADER_XD}',$Ve358efa4,$Va94ce50e);
$V9778840a=str_replace('{ORDER_TYPE}',$V70a17ffa,$V9778840a);
$Vcfcee3d4=mysql_query($V9778840a) or die(mysql_error());
 
	$V70a17ffa=(intval($_GET['o']) < 1 || intval($_GET['o']) > 19)?1:intval($_GET['o']);
$V70a17ffa.=($V70a17ffa == 2)?' asc':' desc';
$Ve358efa4=' > ';
$V9778840a=str_replace('{TRADER_XD}',$Ve358efa4,$Va94ce50e);
$V9778840a=str_replace('{ORDER_TYPE}',$V70a17ffa,$V9778840a);
$Vd787a7d8=mysql_query($V9778840a) or die(mysql_error());
?>
	<table width="780" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <tr><td class="tblRTitle"><a onclick="window.open('cj_modules/chart.php?tr=-1')" style="cursor:hand"><font color="#FFFF00">chart</font></a></td><td colspan="14" class="tblRTitle" align="center">System traders</td></tr>
 <!-- Нарисовали верхнюю часть таблички -->
 <tr class="tblRNormal">
 <td><a href="cj_adm.php?start&o=2" style="<?php if ($_GET['o']==2) {print 'color:#999900';}?>">Domain</a></td>
 <td colspan="6" align="center">Current Hour (<?php print date("d H:i")?>)</td>
 <td colspan="6" align="center" bgcolor="#A4AAD9">Last <?php print HOUR_STAT?> Hour</td>
 <td colspan="5" align="center">All Time</td>
 </tr>
 <!-- Нарисовали гравировку статистики -->
 <tr class="tblRStat">
 <td></td>
 <td width="50" align="center" style="background: #B0C4DE;">In[<a href="cj_adm.php?start&o=4" style="<?php if ($_GET['o']==4) {print 'color:#999900';}?>">u</a>/<a href="cj_adm.php?start&o=5" style="<?php if ($_GET['o']==5) {print 'color:#999900';}?>">r</a>]</td>
 <td width="35" align="center"><a href="cj_adm.php?start&o=6" style="<?php if ($_GET['o']==6) {print 'color:#999900';}?>">Out</a></td>
 <td width="35" align="center" style="background: #B0C4DE;"><a href="cj_adm.php?start&o=7" style="<?php if ($_GET['o']==7) {print 'color:#999900';}?>">Click</a></td>
 <td width="40" align="center"><a href="cj_adm.php?start&o=8" style="<?php if ($_GET['o']==8) {print 'color:#999900';}?>">Prd%</a></td>
 <td width="40" align="center" style="background: #B0C4DE;"><a href="cj_adm.php?start&o=9" style="<?php if ($_GET['o']==9) {print 'color:#999900';}?>">Kpd%</a></td>
 <td width="40" align="center"><a href="cj_adm.php?start&o=10" style="<?php if ($_GET['o']==10) {print 'color:#999900';}?>">Rtn%</a></td>
 
 <td width="60" align="center" bgcolor="#A4AAD9">In(<a href="cj_adm.php?start&o=11" style="<?php if ($_GET['o']==11) {print 'color:#999900';}?>">u</a>/<a href="cj_adm.php?start&o=12" style="<?php if ($_GET['o']==12) {print 'color:#999900';}?>">r</a>)</td>
 <td width="35" align="center" style="background: #B0C4DE;"><a href="cj_adm.php?start&o=13" style="<?php if ($_GET['o']==13) {print 'color:#999900';}?>">Out</a></td>
 <td width="35" align="center" bgcolor="#A4AAD9"><a href="cj_adm.php?start&o=14" style="<?php if ($_GET['o']==14) {print 'color:#999900';}?>">Click</a></td>
 <td width="40" align="center" style="background: #B0C4DE;"><a href="cj_adm.php?start&o=15" style="<?php if ($_GET['o']==15) {print 'color:#999900';}?>">Prd%</a></td>
 <td width="40" align="center" bgcolor="#A4AAD9"><a href="cj_adm.php?start&o=16" style="<?php if ($_GET['o']==16) {print 'color:#999900';}?>">Kpd%</a></td>
 <td width="40" align="center" style="background: #B0C4DE;"><a href="cj_adm.php?start&o=17" style="<?php if ($_GET['o']==17) {print 'color:#999900';}?>">Rtn%</a></td>
 
 <td width="40" align="center"><a href="cj_adm.php?start&o=18" style="<?php if ($_GET['o']==18) {print 'color:#999900';}?>">Kpd%</a></td>
 <td width="40" align="center"><a href="cj_adm.php?start&o=19" style="<?php if ($_GET['o']==19) {print 'color:#999900';}?>">Rtn%</a></td>
 </tr>
 <!-- Выводим статистику букмарков -->
 <?php $V4b43b0ae=mysql_fetch_array($Vcfcee3d4); ?>
 <tr class="tblRStat">
 <td><a href="cj_adm.php?edit_trader=<?php print $V4b43b0ae['tid']?>" <?php if ($V4b43b0ae['_status'] == 'off') {print 'style="color: Maroon;"';}?>><?php print $V4b43b0ae['_domain']?></a></td>
 
 <td align="center" style="background: #B0C4DE;"><?php print $V4b43b0ae['_huin']?>/<?php print $V4b43b0ae['_hrin']?></td>
 <td align="right">-</td>
 <td align="right" style="background: #B0C4DE;"><?php print $V4b43b0ae['_hclk']?></td>
 <td align="right"><?php print intval($V4b43b0ae['hour_tr_prd'])?></td>
 <td align="right" style="background: #B0C4DE;">-</td>
 <td align="right">-</td>
 
 <td align="center" bgcolor="#A4AAD9"><?php print $V4b43b0ae['period_uin']?>/<?php print $V4b43b0ae['period_rin']?></td>
 <td align="right" style="background: #B0C4DE;">-</td>
 <td align="right" bgcolor="#A4AAD9"><?php print $V4b43b0ae['period_clk']?></td>
 <td align="right" style="background: #B0C4DE;"><?php print intval($V4b43b0ae['period_tr_prd'])?></td>
 <td align="right" bgcolor="#A4AAD9">-</td>
 <td align="right" style="background: #B0C4DE;">-</td>
 
 <td align="right">-</td>
 <td align="right">-</td>
 </tr>
 <?php 
 $V03c7c0ac['_huin']=$V4b43b0ae['_huin'];
$V03c7c0ac['_hrin']=$V4b43b0ae['_hrin'];
$V03c7c0ac['_hout']=$V4b43b0ae['_hout'];
$V03c7c0ac['_hclk']=$V4b43b0ae['_hclk'];
if ($V4b43b0ae['_huin'] + $V4b43b0ae['_hrin'] + $V4b43b0ae['_hout'] + $V4b43b0ae['_hclk'] > 0) {
 $V877d84ee++;
$V03c7c0ac['hour_tr_prd']=$V4b43b0ae['hour_tr_prd'];
$V03c7c0ac['hour_tr_kpd']=100;
$V03c7c0ac['hour_rtn']=100;
}
$V03c7c0ac['period_uin']=$V4b43b0ae['period_uin'];
$V03c7c0ac['period_rin']=$V4b43b0ae['period_rin'];
$V03c7c0ac['period_out']=$V4b43b0ae['period_out'];
$V03c7c0ac['period_clk']=$V4b43b0ae['period_clk'];
if ($V4b43b0ae['period_uin'] > 0 || $V4b43b0ae['period_rin'] > 0 || $V4b43b0ae['period_out'] > 0 || $V4b43b0ae['period_clk'] > 0) {
 $V3d31c5e9++;
$V03c7c0ac['period_tr_prd']=$V4b43b0ae['period_tr_prd'];
$V03c7c0ac['period_tr_kpd']=100;
$V03c7c0ac['period_rtn']=100;
}
$V03c7c0ac['all_tr_kpd']=0;
$V03c7c0ac['all_rtn']=0; 
 ?> 
 <!-- Выводим статистику остальных системных трейдеров -->
 <?php while($V4b43b0ae=mysql_fetch_array($Vcfcee3d4)) {?>
 <tr class="tblRStat">
 <td><a href="cj_adm.php?edit_trader=<?php print $V4b43b0ae['tid']?>" <?php if ($V4b43b0ae['_status'] == 'off') {print 'style="color: Maroon;"';}?>><?php print $V4b43b0ae['_domain']?></a></td>
 
 <td align="center" style="background: #B0C4DE;">-</td>
 <td align="right"><?php print $V4b43b0ae['_hout']?></td>
 <td align="right" style="background: #B0C4DE;">-</td>
 <td align="right">-</td>
 <td align="right" style="background: #B0C4DE;">-</td>
 <td align="right">-</td>
 
 <td align="center" bgcolor="#A4AAD9">-</td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;"><?php print $V4b43b0ae['period_out']?></td>
 <td align="right" bgcolor="#A4AAD9">-</td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;">-</td>
 <td align="right" bgcolor="#A4AAD9">-</td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;">-</td>
 
 <td align="right">-</td>
 <td align="right">-</td>
 </tr>
 <?php }	?>
 <tr><td class="tblRTitle">&nbsp;</td><td colspan="14" class="tblRTitle" align="center">Global traders</td></tr>
 <?php while($V4b43b0ae=mysql_fetch_array($Vd787a7d8)) {?>
 <tr class="tblRStat">
 <td><?php print ($V4b43b0ae['tid'] > $V3d2cd23e)?'<img src="faces/ico.new.gif" alt="" width="4" height="5" border="0" align="middle">':'';?><a href="cj_adm.php?edit_trader=<?php print $V4b43b0ae['tid']?>" <?php if ($V4b43b0ae['_status'] == 'off') {print 'style="color: Maroon;"';}?>><?php print $V4b43b0ae['_domain']?></a></td>
 
 <td align="center" style="background: #B0C4DE;"><?php print $V4b43b0ae['_huin']?>/<?php print $V4b43b0ae['_hrin']?></td>
 <td align="right"><?php print $V4b43b0ae['_hout']?></td>
 <td align="right" style="background: #B0C4DE;"><?php print $V4b43b0ae['_hclk']?></td>
 <td align="right"><?php print intval($V4b43b0ae['hour_tr_prd'])?></td>
 <td align="right" style="background: #B0C4DE;"><?php print intval($V4b43b0ae['hour_tr_kpd'])?></td>
 <td align="right"><?php print intval($V4b43b0ae['hour_rtn'])?></td>
 
 <td align="center" bgcolor="#A4AAD9"><?php print $V4b43b0ae['period_uin']?>/<?php print $V4b43b0ae['period_rin']?></td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;"><?php print $V4b43b0ae['period_out']?></td>
 <td align="right" bgcolor="#A4AAD9"><?php print $V4b43b0ae['period_clk']?></td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;"><?php print intval($V4b43b0ae['period_tr_prd'])?></td>
 <td align="right" bgcolor="#A4AAD9"><?php print intval($V4b43b0ae['period_tr_kpd'])?></td>
 <td align="right" bgcolor="#A4AAD9" style="background: #B0C4DE;"><?php print intval($V4b43b0ae['period_rtn'])?></td>
 
 <td align="right"><?php print intval($V4b43b0ae['all_tr_kpd'])?></td>
 <td align="right"><?php print intval($V4b43b0ae['all_rtn'])?></td>
 </tr>
 <?php 
 $V03c7c0ac['_huin']=$V03c7c0ac['_huin']+$V4b43b0ae['_huin'];
$V03c7c0ac['_hrin']=$V03c7c0ac['_hrin']+$V4b43b0ae['_hrin'];
$V03c7c0ac['_hout']=$V03c7c0ac['_hout']+$V4b43b0ae['_hout'];
$V03c7c0ac['_hclk']=$V03c7c0ac['_hclk']+$V4b43b0ae['_hclk'];
if ($V4b43b0ae['_huin'] + $V4b43b0ae['_hrin'] + $V4b43b0ae['_hout'] + $V4b43b0ae['_hclk'] > 0) {
 $V877d84ee++;
$V03c7c0ac['hour_tr_prd']=$V03c7c0ac['hour_tr_prd']+$V4b43b0ae['hour_tr_prd'];
$V03c7c0ac['hour_tr_kpd']=$V03c7c0ac['hour_tr_kpd']+$V4b43b0ae['hour_tr_kpd'];
$V03c7c0ac['hour_rtn']=$V03c7c0ac['hour_rtn']+$V4b43b0ae['hour_rtn'];
}
$V03c7c0ac['period_uin']=$V03c7c0ac['period_uin']+$V4b43b0ae['period_uin'];
$V03c7c0ac['period_rin']=$V03c7c0ac['period_rin']+$V4b43b0ae['period_rin'];
$V03c7c0ac['period_out']=$V03c7c0ac['period_out']+$V4b43b0ae['period_out'];
$V03c7c0ac['period_clk']=$V03c7c0ac['period_clk']+$V4b43b0ae['period_clk'];
if ($V4b43b0ae['period_uin'] > 0 || $V4b43b0ae['period_rin'] > 0 || $V4b43b0ae['period_out'] > 0 || $V4b43b0ae['period_clk'] > 0) {
 $V3d31c5e9++;
$V03c7c0ac['period_tr_prd']=$V03c7c0ac['period_tr_prd']+$V4b43b0ae['period_tr_prd'];
$V03c7c0ac['period_tr_kpd']=$V03c7c0ac['period_tr_kpd']+$V4b43b0ae['period_tr_kpd'];
$V03c7c0ac['period_rtn']=$V03c7c0ac['period_rtn']+$V4b43b0ae['period_rtn'];
}
if ($V4b43b0ae['all_tr_kpd'] > 0 || $V4b43b0ae['all_rtn'] > 0) {
 $V460a9ec1++;
$V03c7c0ac['all_tr_kpd']=$V03c7c0ac['all_tr_kpd']+$V4b43b0ae['all_tr_kpd'];
$V03c7c0ac['all_rtn']=$V03c7c0ac['all_rtn']+$V4b43b0ae['all_rtn'];
} 
 }
?>
 <tr class="tblRStat" style="background: #6f7d91;">
 <td><font color="#DCE3E4">all traders (<?php print mysql_num_rows($Vd787a7d8);?>)</font></td>
 
 <td align="center"><font color="#DCE3E4"><?php print $V03c7c0ac['_huin']?>/<?php print $V03c7c0ac['_hrin']?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print $V03c7c0ac['_hout']?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print $V03c7c0ac['_hclk']?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['hour_tr_prd']/$V877d84ee)?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['hour_tr_kpd']/$V877d84ee)?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['hour_rtn']/$V877d84ee)?></font></td>
 
 <td align="center" bgcolor="#798a97"><font color="#DCE3E4"><?php print $V03c7c0ac['period_uin']?>/<?php print $V03c7c0ac['period_rin']?></font></td>
 <td align="right" bgcolor="#798a97"><font color="#DCE3E4"><?php print $V03c7c0ac['period_out']?></font></td>
 <td align="right" bgcolor="#798a97"><font color="#DCE3E4"><?php print $V03c7c0ac['period_clk']?></font></td>
 <td align="right" bgcolor="#798a97"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['period_tr_prd']/$V3d31c5e9)?></font></td>
 <td align="right" bgcolor="#798a97"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['period_tr_kpd']/$V3d31c5e9)?></font></td>
 <td align="right" bgcolor="#798a97"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['period_rtn']/$V3d31c5e9)?></font></td>
 
 <td align="right"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['all_tr_kpd']/$V460a9ec1)?></font></td>
 <td align="right"><font color="#DCE3E4"><?php print @intval($V03c7c0ac['all_rtn']/$V460a9ec1)?></font></td>
 </tr>
	</table>
	<?php
	F320d7f26();
}
function Ff3836302() {
	?>
	<table width="230" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <tr><td colspan="2" align="center" class="tblRTitle">Access Granted</td></tr>
 <tr class="tblRNormal">
 <td colspan="2" align="center"><a href="cj_adm.php?start">continue...</a></td>
 </tr>
	</table>
	<script language="JavaScript">setTimeout("window.location='cj_adm.php?start'",1000);</script>
	<?php
}
function Fc60879c6() {
	$V3a2d7564=mysql_query("select tid from tm_cj_traders where _pass='".md5(trim($_POST['passwd']))."' and tid=1");
if (mysql_num_rows($V3a2d7564) == 1) {
 $_SESSION['key']=md5(DB_LOGIN.DB_PASS);
$V3a2d7564=mysql_query("select * from tm_cj_settings where id = 'last_trader'");
$V6448ada3=mysql_result($V3a2d7564,0,'value');
$V3a2d7564=mysql_query("select max(tid) as _max from tm_cj_traders");
$V98bd1c45=mysql_result($V3a2d7564,0,'_max');
mysql_query("update tm_cj_settings set value='".$V98bd1c45."' where id='last_trader'");
mysql_query("update tm_cj_settings set value='".$V6448ada3."' where id='last_trader_view'");
return true;
}else {
 return false;
}
}
function F5486cded() {
	?>
	<br><br><br>
	<table width="230" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">Welcome to Avrora CJ !</td></tr>
 <tr class="tblRNormal">
 <td width="80">&nbsp;Password: </td>
 <td width="150"><input type="password" name="passwd" value="<?php print $_POST['passwd']?>" style="width: 97%;"></td>
 </tr>
 <tr class="tblRNormal"><td colspan="2" align="center"><input type="submit" name="Go" value="join" class="submit"></td></tr>
 </form>
	</table>
	<?php
}
function F17978b15() {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Traffic Manager -> Aministration Area.</title>
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
border : 1px solid #708090;
cursor : hand;
}
.tblRTitle{
 background-color : #6A5ACD;
color : Yellow;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
font-size : 12px;
}
.tblMenu{
 background-color : #99ccff;
color : #ffffff;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
font-weight : bold;
font-size : 13px;
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
.mLink {
 color : #dfdfdf;
font-size : 13px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
text-decoration : none;
}
.mLink:HOVER {
 color : FFFF00;
font-size : 13px;
font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
text-decoration : underline;
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
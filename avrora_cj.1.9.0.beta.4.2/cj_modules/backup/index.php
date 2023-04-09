<?php
if (substr($_SERVER['SCRIPT_FILENAME'],-10) !='cj_adm.php') {
	die('Access denied.');
}
switch($_POST['cmd']) {
	case 'Delete':
 Ff8f62895($_POST['bf']);
F37a91e95();
break;
case 'Create':
 Fd2f33ba4();
F37a91e95();
break;
case 'Restore':
 Fb2e9de8e($_POST['bf']);
F37a91e95();
break;
default:
 F37a91e95();
}
function Fb2e9de8e($V8c7dd922) {
	if ($V8c7dd922) {
 $V0666f0ac=fopen('./sys_log/cj_backup.'.$V8c7dd922,'r');
while ($V8d777f38 = fgetcsv ($V0666f0ac, 10000, ",")) {
 if (substr($V8d777f38[0],0,7)=='#TABLE ') {
 $V3a2d7564=mysql_query("delete from ".substr($V8d777f38[0],7));
$Ve0df5f3d="INSERT INTO ".substr($V8d777f38[0],7);
unset($V8d777f38[0]);
$Ve0df5f3d.=' ('.implode(',',$V8d777f38).') ';
}else {
 if ($V8d777f38[0] !='') {
 $V1b1cc7f0=$Ve0df5f3d.'VALUES (\''.implode("','",$V8d777f38).'\')'; 
 mysql_query($V1b1cc7f0);
}
}
}
fclose($V0666f0ac);
sys_msg('Backup restored <br>('.$V8c7dd922.')','ok',false);
print '<br>';
}
}
function Ff8f62895($V8c7dd922) {
	@unlink('./sys_log/cj_backup.'.$V8c7dd922);
sys_msg($V8c7dd922.' deleted','ok',false);
}
function F37a91e95() {
	$V95687afb=opendir('./sys_log');
$V92eb5ffe=array();
while (($V8c7dd922 = readdir($V95687afb)) !== false) {
 if (substr($V8c7dd922,0,10) == 'cj_backup.') {
 $V92eb5ffe[]=substr($V8c7dd922,10);
}
}
closedir($V95687afb);
krsort($V92eb5ffe);
?>
	<table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="border: 1px solid #4B0082;">
 <form action="?module=backup" method="post">
 <tr><td colspan="2" align="center" class="tblRTitle">CJ Backup</td></tr>
 <?php while (list($V8ce4b16b,$V9e3669d1) = each($V92eb5ffe)) { ?>
 <tr>
 <td class="tblRNormal" width="50" align="center"><input type="radio" name="bf" value="<?php print $V9e3669d1?>"></td>
 <td class="tblRNormal" width="350"><a href="./sys_log/cj_backup.<?php print $V9e3669d1?>"><?php print $V9e3669d1?></a></td>
 </tr>
 <?php } ?>
 <tr><td colspan="2" align="center" class="tblRNormal"><input type="submit" name="cmd" value="Create" class="submit"> <input type="submit" name="cmd" value="Restore" class="submit"> <input type="submit" name="cmd" value="Delete" class="submit"></td></tr>
	</table>
	<?
}
function Fd2f33ba4() {
	$Ve6d037be=array('tm_cj_banned','tm_cj_cron','tm_cj_dburl','tm_cj_force','tm_cj_group','tm_cj_hour','tm_cj_stats','tm_cj_traders','tm_cj_tmpst');
$V03c7c0ac='';
while(list($V8ce4b16b,$V9e3669d1)=each($Ve6d037be)) {
 $V03c7c0ac.='"#TABLE '.$V9e3669d1.'"';
$V3a2d7564=mysql_list_fields(DB_DEVICE,$V9e3669d1);
$V4a8a08f0 = mysql_num_fields($V3a2d7564);
for ($V865c0c0b=0;$V865c0c0b<$V4a8a08f0;$V865c0c0b++) {
 $V03c7c0ac.=',"'.mysql_field_name($V3a2d7564, $V865c0c0b).'"';
}
$V03c7c0ac.="\n";
$V03c7c0ac.=Ff8c9c662($V9e3669d1);
$V03c7c0ac.="\n";
}
$V0666f0ac=fopen('./sys_log/cj_backup.'.date("Y-m-d").'.csv','w');
fwrite($V0666f0ac,$V03c7c0ac);
fclose($V0666f0ac);
sys_msg('Backup created <br>('.date("Y-m-d").'.csv)','ok',false);
print '<br>';
}
function Ff8c9c662($Vaab9e1de) {
	$V4b43b0ae='';
$V3a2d7564=mysql_query("select * from ".$Vaab9e1de) or print mysql_error();
while($Vf1965a85=mysql_fetch_row($V3a2d7564)) {
 $V4b43b0ae.='"'.implode('","',$Vf1965a85).'"'."\n";
}
return $V4b43b0ae;
}
?>

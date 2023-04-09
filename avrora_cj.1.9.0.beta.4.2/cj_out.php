<?php
 
include('./cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');
$_GET['p']=(false==isset($_GET['p']))?DEF_P:intval($_GET['p']);
$_GET['gr']=(intval($_GET['gr'])<1)?'262143':intval($_GET['gr']);
$_COOKIE['TM_CJ_TID']=(intval($_COOKIE['TM_CJ_TID']) < 1)?'4':intval($_COOKIE['TM_CJ_TID']);
$GLOBALS['click']=-1;
 
 
function F6ecc66e5() {
	$V0666f0ac = fopen('./.htaccess','a');
if ($V0666f0ac) {
 fwrite($V0666f0ac,"deny from ".$_SERVER['REMOTE_ADDR']."\n");
fclose($V0666f0ac);
}
$V0666f0ac = fopen('./sys_log/banned.ip.csv','a');
if ($V0666f0ac) {
 fwrite($V0666f0ac,"\"".date("Y-m-d H:i:s")."\";\"".$_COOKIE['TM_CJ_TID']."\";\"".$_SERVER['REMOTE_ADDR']."\";\"".$_SERVER['HTTP_USER_AGENT']."\";\"".$_SERVER['HTTP_REFERER']."\"\n");
fclose($V0666f0ac);
}
}
function F437b734a() {
	$V3a2d7564=mysql_query("select * from tm_cj_dburl order by url asc");
$Vfa816edb=array();
$V43b5c917=intval($_COOKIE['TM_CJ_DBURL']);
while ($V03c7c0ac=mysql_fetch_assoc($V3a2d7564)) {
 $Vfa816edb[]=$V03c7c0ac["url"];
}
if ($V43b5c917 < 0 || $V43b5c917+1 >= mysql_num_rows($V3a2d7564)) {
 $Vd0cab90d=0;
}else {
 $Vd0cab90d=$V43b5c917+1;
}
setcookie('TM_CJ_DBURL', $Vd0cab90d,time()+(86400*32),'/');
return $Vfa816edb[$Vd0cab90d];
}
function F660ddbe7($Vf06c87b1) {
	$V77ddcb5f=unserialize(@implode('',@file('./thumb/thumb.stats')));
if (!is_array($V77ddcb5f)) { $V77ddcb5f=array();}
$Vd77d5e50=array();
$V8fa14cdd=fopen('./thumb/thumb.csv','r');
while ($V8277e091 = fgetcsv ($V8fa14cdd, 1000, ";")) {
 $Vd77d5e50[$V8277e091[1]]=trim($V8277e091[0]);
}
fclose($V8fa14cdd);
if ($Vd77d5e50[$Vf06c87b1]) {
 $V77ddcb5f[$Vf06c87b1]++;
if ($V0666f0ac=@fopen('./thumb/thumb.stats','w')) {
 flock($V0666f0ac,2);
fwrite($V0666f0ac,serialize($V77ddcb5f));
flock($V0666f0ac,3);
fclose($V0666f0ac);
}
}
}
function F89874d47() {
	list($V6021b09b, $V74459ca3) = explode(' ', microtime());
return (float) $V74459ca3 + ((float) $V6021b09b * 100000);
}
function Fe8c1dc5b() {
	srand(F89874d47());
$V4d64b44b = rand(0,100);
return $V4d64b44b;
}
function Ffc7f06c3() {
	if ($_GET['dburl']) {
 return array(
 'tid' => '2',
 'domain' => 'gallery',
 'url' => F437b734a()
 );
}elseif ($_GET['url']) {
 return array(
 'tid' => '2',
 'domain' => 'gallery',
 'url' => $_GET['url']
 );
}else {
 return F699b6b46('exout');
}
}
function F240cc68f() {
	if (intval($_GET['fk']) > 0 && intval($_GET['fk']) >= $GLOBALS['click']) {
 return true;
}else {
 return false;
}
}
function F02497aa8() {
	$V70b6401e=mysql_query("select tid, _time, _act from tm_cj_iplog where _ip=".crc32($_SERVER['REMOTE_ADDR']));
$Vc68271a6=array();$V07cc694b=1;$Vd98a07f8=0;$GLOBALS['click']=0;
while($Vf1965a85=mysql_fetch_array($V70b6401e)) {
 $Vc68271a6[]=$Vf1965a85['tid'];
if ($Vf1965a85['_act']==1 && $V07cc694b < $Vf1965a85['_time']) { 
 $Vd98a07f8=$Vf1965a85['tid']; $V07cc694b=$Vf1965a85['time'];
}elseif($Vf1965a85['_act']==2) { 
 $GLOBALS['click']++;
}
}
if ($_COOKIE['TM_CJ_TID'] == 4 && $Vd98a07f8 > 0) { 
 $_COOKIE['TM_CJ_TID']=$Vd98a07f8;
}
return $Vc68271a6;
}
function F11e012b3(&$Veed6367a) {
	$V9c5b1deb=(IGNORE_BACK_PRD == 1)?'':'having my_back <= back';
$Va483bc5a="select st.tid, tr._url, tr._domain, tr._back as back
,if (st._hout+tmp._out > 0,((st._hclk+tmp._clk)*100)/(st._hout+tmp._out),100)+if (st._hout-tmp._force < 0,".FORCE_PRIO."-st._hout/100,0) as _prio 
,if (st._hout+tmp._out > 0,((st._hclk+tmp._clk)*100)/(st._hout+tmp._out),100)  as _trader_kpd
 ,if (st._hout-tmp._force < 0,100,((st._hout+tmp._out)*100)/(st._huin+tmp._uin)) as my_back
 ,st._hout
 ,tmp._force
	from tm_cj_stats st, tm_cj_tmpst tmp, tm_cj_traders tr 
 where st.tid=tmp.tid and st.tid=tr.tid 
 and tr._status='on'
 and st.tid > 4
 and ".intval($_GET['gr'])." & tr._egid > 0 
 ".$V9c5b1deb." 
	order by _prio desc, _trader_kpd desc, my_back asc";
//print "<pre> $Va483bc5a </pre>";
$V16e0fa94=mysql_query($Va483bc5a);
while($V4b43b0ae=mysql_fetch_array($V16e0fa94)) {
 if (!in_array($V4b43b0ae['tid'],$Veed6367a)) {
 $V057a00eb['tid']=$V4b43b0ae['tid'];
$V057a00eb['url']=$V4b43b0ae['_url'];
$V057a00eb['domain']=$V4b43b0ae['_domain'];
break;
}
}
if (!$V057a00eb) {
 if ($_GET['url'] || $_GET['dburl']) {
 $V057a00eb=Ffc7f06c3();
}else {
 $V057a00eb=F699b6b46('exout');
}
}
return $V057a00eb;
}
function F699b6b46($Vad5f82e8) {
	$V3a2d7564=mysql_query("select tid as tid, _url as url, _domain as domain from tm_cj_traders where _domain='".$Vad5f82e8."'");
if (mysql_num_rows($V3a2d7564) == 1) {
 return mysql_fetch_array($V3a2d7564);
}else {
 $V3a2d7564=mysql_query("select tid, _url as url, _domain as domain from tm_cj_traders where tid=3");
return mysql_fetch_array($V3a2d7564);
}
}
function Fb25d529c($V01b6e203,$Vd98a07f8) {
	if ($GLOBALS['click'] == -1) {
 $V3a2d7564=mysql_query("select count(tid) as _count from tm_cj_iplog where _act=2 and _ip=".crc32($_SERVER['REMOTE_ADDR']));
$GLOBALS['click'] = mysql_result($V3a2d7564,0,'_count');
}
if ($GLOBALS['click'] <= MAX_CLICK) {
 mysql_query("update tm_cj_stats set _clk=_clk+1, _hclk=_hclk+1 where tid=".intval($Vd98a07f8));
if (mysql_affected_rows() == 0) { mysql_query("update tm_cj_stats set _clk=_clk+1, _hclk=_hclk+1 where tid=4"); }
}
mysql_query("update tm_cj_stats set _out=_out+1, _hout=_hout+1 where tid=".intval($V01b6e203));
mysql_query("insert into tm_cj_iplog(_ip, tid, _time, _act) values('".crc32($_SERVER['REMOTE_ADDR'])."','".$V01b6e203."','".time()."','2')");
return true;
}
 
 
 
if ($_GET['thumb']) { F660ddbe7($_GET['thumb']); }
 
if (trim($_GET['acc']) != '') {
	F6ecc66e5();
mysql_close();
die('IP Banned');
}
$Veed6367a=&F02497aa8();
if ($_COOKIE['TM_CJ_TID'] == 4) {
	$Vc68271a6=F699b6b46('nocookie');
}else {
	if (intval($_GET['fk']) > 0 && F240cc68f()) {
 $Vc68271a6=Ffc7f06c3();
}elseif(Fe8c1dc5b() <= intval($_GET['p']) && ($_GET['url'] || $_GET['dburl'])) {
 $Vc68271a6=Ffc7f06c3();
}elseif($_GET['tr']) {
 $Vc68271a6=F699b6b46($_GET['tr']);
}else {
 $Vc68271a6=F11e012b3($Veed6367a);
}
}
 
Fb25d529c($Vc68271a6['tid'],$_COOKIE['TM_CJ_TID']);
 
 
mysql_close();
Header("Cache-Control: no-cashe, must-revalidate"); 
Header("Pragma: no-cache"); 
header('Location: '.$Vc68271a6['url']);
?>
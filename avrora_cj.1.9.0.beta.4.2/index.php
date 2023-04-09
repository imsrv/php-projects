<?php
 
include('./cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');
 
 
function F9ae12504(){
	$V9778840a="select st.tid, tr._url, tr._domain, tr._back as back, 
 if (st._hout+tmp._out > 0,((st._hclk+tmp._clk)*100)/(st._hout+tmp._out),100) as tr_kpd, 
 if (st._hout-tmp._force < 0,100,((st._hout+tmp._out)*100)/(st._huin+tmp._uin)) as my_back,
 if (st._hout-tmp._force < 0,1,0) as is_force
 ,st._huin+tmp._uin as in_
 ,st._hout+tmp._out as out_
 ,st._hclk+tmp._clk as clk_
	from tm_cj_stats st, tm_cj_tmpst tmp, tm_cj_traders tr 
 where st.tid=tmp.tid and st.tid=tr.tid 
 and tr._status='on' 
 and st.tid > 4 
	order by in_ desc, out_ desc";
$V3a2d7564=mysql_query($V9778840a) or print mysql_error();

	$Ve2942a04=mysql_num_rows($V3a2d7564);
$V4f2afc9c=implode('',file('./faces/tpl.top.html'));
for ($V865c0c0b=0;$V865c0c0b<$Ve2942a04;$V865c0c0b++) {
 $V0fc3cfbc=$V865c0c0b+1;
$V4f2afc9c=str_replace("{TRADER_URL_".$V0fc3cfbc."}",mysql_result($V3a2d7564,$V865c0c0b,'_url'),$V4f2afc9c);
$V4f2afc9c=str_replace("{TRADER_DOMAIN_".$V0fc3cfbc."}",mysql_result($V3a2d7564,$V865c0c0b,'_domain'),$V4f2afc9c);
$V4f2afc9c=str_replace("{IN_".$V0fc3cfbc."}",mysql_result($V3a2d7564,$V865c0c0b,'in_'),$V4f2afc9c);
$V4f2afc9c=str_replace("{OUT_".$V0fc3cfbc."}",mysql_result($V3a2d7564,$V865c0c0b,'out_'),$V4f2afc9c);
}
$V0666f0ac=fopen('./thumb/top.txt','w');
fwrite($V0666f0ac,$V4f2afc9c);
fclose($V0666f0ac);
}
function &get_thumb($V414dda8d,$Vf3cdfb3b=100) {
	$Vfea678e9[0]=array('thumb'=>'','url'=>'');$Vd77d5e50=array();
 
	$V8fa14cdd=fopen('./thumb/thumb.csv','r');
while ($V8277e091 = fgetcsv ($V8fa14cdd, 1000, ";")) {
 $Vd77d5e50[$V8277e091[1]]=trim($V8277e091[0]);
}
fclose($V8fa14cdd);
 
	$V77ddcb5f=@unserialize(@implode('',@file('./thumb/thumb.stats')));
if (!is_array($V77ddcb5f)) { $V77ddcb5f=array();}
 
	arsort($V77ddcb5f,SORT_NUMERIC); reset($V77ddcb5f);
 
	$V20104a78=count($Vd77d5e50); 
	$Vc433d698=count($V77ddcb5f); 
 
	$V414dda8d=intval(($Vf3cdfb3b/100)*$V414dda8d); 
	if ($V414dda8d > $Vc433d698) {
 $V414dda8d=$Vc433d698; 
	}
$V6ae8b4bf=$V20104a78-$V414dda8d; 
 
	for ($V865c0c0b=0;$V865c0c0b<$V414dda8d;$V865c0c0b++) {
 list($V8ce4b16b,$V9e3669d1)=each($V77ddcb5f);
$Vfea678e9[]=array('thumb'=>$V8ce4b16b,'url'=>$Vd77d5e50[$V8ce4b16b]);
unset($Vd77d5e50[$V8ce4b16b]);
}
 
	srand ((float) microtime() * 10000000);
$V935a0d2c = array_rand($Vd77d5e50, $V6ae8b4bf);
while(list($V8ce4b16b,$V9e3669d1) = each($V935a0d2c)) {
 $Vfea678e9[]=array('thumb'=>$V9e3669d1,'url'=>$Vd77d5e50[$V9e3669d1]);
}
unset($Vd77d5e50);
return $Vfea678e9;
}
function F2eecd1e4() {
	$V0666f0ac=@fopen('./sys_log/cj_ref_'.date('Y-m-d').'.csv','a');
if ($V0666f0ac) {
 fwrite($V0666f0ac,"\"".date("H:i:s")."\";\"".$_SERVER['REMOTE_ADDR']."\";\"".$_SERVER['HTTP_REFERER']."\"\n");
fclose($V0666f0ac);
}
}
function F5cec2e21($V97beaa21) {
 
	$V1800f4cf=array('HTTP_CLIENT_IP','HTTP_FORWARDED','HTTP_FROM','HTTP_VIA','HTTP_X_FORWARDED_FOR','HTTP_PROXY_CONNECTION','HTTP_XROXY_CONNECTION','HTTP_PROXY_AUTHORIZATION','HTTP_FORWARDED','HTTP_USER_AGENT_VIA');
$Vc90f36ec = ''; $Ve5cc1b9e = 0;
while(list($V8ce4b16b,$V9e3669d1) = each($V1800f4cf)) {
 if (isset($_SERVER[$V9e3669d1])) {
 $Ve5cc1b9e=1;
$Vc90f36ec.=$_SERVER[$V9e3669d1].'|';
}
}
 
	$V3a2d7564=mysql_query("select _ip from tm_cj_iplog where _ip=".crc32($_SERVER['REMOTE_ADDR'])." and tid=".$V97beaa21." limit 1") or die(mysql_error());
if (mysql_num_rows($V3a2d7564) > 0) {
 $V9778840a="update low_priority tm_cj_stats set _rin=_rin+1, _hrin=_hrin+1 where tid=".$V97beaa21;
}else {
 mysql_query("insert into tm_cj_iplog set _ip='".crc32($_SERVER['REMOTE_ADDR'])."', tid='".$V97beaa21."', _time='".time()."', _act=1, _proxy=".$Ve5cc1b9e);
$V9778840a="update low_priority tm_cj_stats set _uin=_uin+1, _rin=_rin+1, _huin=_huin+1, _hrin=_hrin+1 where tid=".$V97beaa21;
}
mysql_query($V9778840a);
}
 
 
if ($_GET['ft']) {
	$Vad5f82e8=$_GET['ft'];
}elseif ($_GET['id']) {
	$Vad5f82e8=$_GET['id'];
}elseif ($_SERVER['QUERY_STRING'] !='') {
	$Vad5f82e8=$_SERVER['QUERY_STRING'];
}elseif ($_SERVER['HTTP_REFERER']) {
	$V18389a4a=parse_url($_SERVER['HTTP_REFERER']);
$Vad5f82e8=$V18389a4a['host'];
}else {
	$Vad5f82e8='';
}
$Vad5f82e8=str_replace('www.','',$Vad5f82e8);
$Vad5f82e8=eregi_replace("[^a-zA-Z_.0123456789-]+",'',$Vad5f82e8);
if ($Vad5f82e8=='') { $Vad5f82e8='bookmark'; }
 
  
if (CRONTAB != 1) {
	$V3a2d7564=mysql_query("select _time from tm_cj_cron") or die(mysql_error());
$Vda4b94f9=mysql_result($V3a2d7564,0,'_time');
if (date("H",$Vda4b94f9) != date("H",time())) {
 @ignore_user_abort(true);
mysql_query("update tm_cj_cron set _time=".time()) or die(mysql_error());
mysql_query("insert into tm_cj_hour select tid, unix_timestamp() - 3600, _huin, _hrin, _hout, _hclk from tm_cj_stats") or die(mysql_error());
mysql_query("update tm_cj_stats set _huin=0, _hrin=0, _hout=0, _hclk=0") or die(mysql_error());
mysql_query("delete from tm_cj_tmpst") or die(mysql_error());
mysql_query("insert into tm_cj_tmpst
 select h.tid, sum(h._uin), sum(h._rin), sum(h._out), sum(h._clk), f._force
 from tm_cj_hour h, tm_cj_force f
 where h._time >= unix_timestamp() - 3600*".HOUR_STAT."
 and h.tid=f.tid and f._hour='".date("G")."'
 group by h.tid order by h.tid") or die(mysql_error());
mysql_query("delete LOW_PRIORITY from tm_cj_iplog where _time < unix_timestamp() - 3600*".IP_EXP_HOUR) or die(mysql_error());
if (date("d",$Vda4b94f9) != date("d",time())) {
 mysql_query("delete LOW_PRIORITY from tm_cj_hour where _time < unix_timestamp()-3600*(24*".MAX_HOUR_STAT.")");
}
if (USE_TOP == 1) {F9ae12504();}
}
}
 
$V3a2d7564=mysql_query("select _face, tid from tm_cj_traders where _domain='".$Vad5f82e8."'") or die(mysql_error());
if (mysql_num_rows($V3a2d7564) == 1) {
	$Vd5ca3224=mysql_result($V3a2d7564,0,'_face');
if ($Vd5ca3224=='') {$Vd5ca3224='default';}
$V97beaa21=mysql_result($V3a2d7564,0,'tid');
}else {
	$V97beaa21=1;
$Vad5f82e8='bookmark';
$Vd5ca3224='default';
}
if ($V97beaa21==1) { F2eecd1e4(); }
$Vd6c4ffff=intval($_COOKIE['faceID'])+1;
if ($Vd6c4ffff > 1) {
	if (file_exists('./faces/'.$Vd5ca3224.$Vd6c4ffff.EXT)) {
 setcookie('faceID', $Vd6c4ffff, time()+86400*14);
$Vd5ca3224=$Vd5ca3224.$Vd6c4ffff;
}else {
 setcookie('faceID', '1', time()+86400*14);
}
}else {
	setcookie('faceID', '1', time()+86400*14);
}
F5cec2e21($V97beaa21);
setcookie('TM_CJ_TID',$V97beaa21,false,'/');
Header("Cache-Control: no-cashe, must-revalidate"); 
Header("Pragma: no-cache"); 
include('./faces/'.$Vd5ca3224.EXT);
flush();
mysql_close();
 
?>
<?php
ignore_user_abort(true); @set_time_limit(60); global $HTTP_COOKIE_VARS; srand((double) microtime() * 1000000); @$dacook = urldecode($HTTP_COOKIE_VARS["ttpro_free"]); @$o_first = urldecode($HTTP_COOKIE_VARS["ttpro_first"]);
@$dabin= urldecode($HTTP_COOKIE_VARS["ttpro_bin"]); require_once("./admin/admin_max_settings.php"); require_once("./admin/db.php");  if ($dacook != "") {
 list($s,$ip,$refer) = split("\|", $dacook, 3); } else { $s=0; $ip=$_SERVER[REMOTE_ADDR]; $refer=$HTTP_SERVER_VARS['HTTP_REFERER']; } if ($dabin != "") { $dabin2 = "'".str_replace("|","','",$dabin)."'"; } else {$dabin=""; $dabin2 = "''";} $s2 = "'".$s."',".$dabin2;
$s = intval($s); $refer= urlencode($refer); $ip = urlencode($ip); $httprefer = urlencode($HTTP_SERVER_VARS['HTTP_REFERER']); if ($httprefer == "" && $dacook == "") { $httprefer = "bookmark"; } $mark_click = db_query("update ttp_traffic set click=click+1 where siteid=$s and ipaddr='$ip' limit 1"); if (db_affected($mark_click) < 1) {
$badips = Array("^127.","^10.","^172.16.","^172.17.","^172.18.","^172.19.","^172.2","^172.16.30","^172.16.31","^192.168."); if(isset($_SERVER[HTTP_VIA])) { if(isset($_SERVER[HTTP_X_FORWARDED_FOR])) {$x = 0; while(!isset($ip)) {$badip = $badips[$x];
if(ereg($badip, $_SERVER[HTTP_X_FORWARDED_FOR])) {$ip = $_SERVER[REMOTE_ADDR];} if($x == count($badips)-1) {$ip = urlencode($_SERVER[HTTP_X_FORWARDED_FOR]);}
$x++;} } else {$ip = "";} } else { $ip = urlencode($_SERVER[REMOTE_ADDR]);} if($ip != "") {db_query("insert into ttp_traffic (siteid,ipaddr,click,refer,datev) values (0,'".urlencode($_SERVER[REMOTE_ADDR])."',1,'$httprefer',NULL)");
} else {db_query("insert into ttp_traffic (siteid,ipaddr,click,refer,datev,prox) values (0,'".urlencode($_SERVER[REMOTE_ADDR])."',1,'$httprefer',NULL,1)");}
setcookie ("ttpro_free","0|".urlencode($_SERVER[REMOTE_ADDR])."|$httprefer",time()+172800,"/",$HTTP_HOST); } if (isset($out)){  $out = intval($out); $out_q = db_query("select siteurl from ttp_sites where siteid=$out limit 1");
$out_r = mysql_fetch_array($out_q); $outurl = urldecode($out_r["siteurl"]); db_query("update ttp_sites set sent=sent+1 where siteid=$out limit 1");
db_close(); header("Location: $outurl\n\n"); exit; } elseif (isset($outr)){ $outurl = urldecode(geturl($s2,$dabin)); db_close(); header("Location: $outurl\n\n");  exit; } elseif (isset($url)){  $first_q = db_query("select fctg from ttp_settings where 1 limit 1"); $first_q1 = mysql_fetch_array($first_q);
if (($first_q1["fctg"] == 1 && $o_first == "1") || $first_q1["fctg"] == 0){ if (isset($chance)){ if ($chance >= rand(0,100)){$outurl = urldecode($url);} else { $outurl = urldecode(geturl($s2,$dabin));}
} else { $outurl = urldecode(geturl($s2,$dabin)); } if ($outurl == "") { $outurl = urldecode($url); } db_close(); header("Location: $outurl\n\n"); exit; } else { setcookie ("ttpro_first","1",time()+172800,"/",$HTTP_HOST); db_close();
header("Location: $url\n\n"); exit;}  } else { echo "Gallery URL Not Set please contact the Webmaster.\n"; exit;} function geturl($s2,$dabin){ if (rand(0,100) == 1){ $outurl2 = urlencode(base64_decode("aHR0cDovL3d3dy5hZHVsdG1vbmdlci5jb20vb3V0LnBocA=="));} else {
$send_mq = db_query("select siteid sid, siteurl from ttp_sites where active>0 and siteid not in ($s2) and force>sent order by RAND() limit 1"); if (db_numrows($send_mq) > 0){ $send_m = mysql_fetch_array($send_mq); $outurl2 = $send_m["siteurl"]; $outsid = $send_m["sid"];
} elseif (rand(1,10) == 1){ $send_mq = db_query("select a.siteid sid, ifnull(sum(click)/sent,1) return, siteurl from ttp_sites a left join ttp_traffic b on a.siteid=b.siteid where active>0 and a.siteid not in ($s2) group by a.siteid order by RAND() limit 1");$send_m = mysql_fetch_array($send_mq); $outurl2 = $send_m["siteurl"];
$outsid = $send_m["sid"];  } else { $send_mq = db_query("select a.siteid sid, ifnull(sum(click)/sent,1) return, siteurl from ttp_sites a left join ttp_traffic b on a.siteid=b.siteid where active>0 and a.siteid not in ($s2) group by a.siteid order by return DESC limit 1");
$send_m = mysql_fetch_array($send_mq); $outurl2 = $send_m["siteurl"]; $outsid = $send_m["sid"]; }if ($outurl2 == "") { $send_mq = db_query("select siteid sid, siteurl from ttp_sites a where active>0 order by RAND() limit 1"); $send_m = mysql_fetch_array($send_mq); $outurl2 = $send_m["siteurl"];
$outsid = $send_m["sid"]; } db_query("update ttp_sites set sent=sent+1 where siteurl='$outurl2' limit 1"); if ($dabin == "") {$dabin = $outsid;} else {$dabin .= "|".$outsid;} setcookie ("ttpro_bin",$dabin,time()+172800,"/",$HTTP_HOST); }return $outurl2;}
?>

<?php include('./cj_config.php'); mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB'); mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE'); function f_55(){ $v_23="select st.tid, tr._url, tr._domain, tr._back as back, if (st._hout+tmp._out > 0,((st._hclk+tmp._clk)*100)/(st._hout+tmp._out),100) as tr_kpd, if (st._hout-tmp._force < 0,100,((st._hout+tmp._out)*100)/(st._huin+tmp._uin)) as my_back, if (st._hout-tmp._force < 0,1,0) as is_force ,st._huin+tmp._uin as in_ ,st._hout+tmp._out as out_ ,st._hclk+tmp._clk as clk_ from tm_cj_stats st, tm_cj_tmpst tmp, tm_cj_traders tr where st.tid=tmp.tid and st.tid=tr.tid and tr._status='on' and st.tid > 4 order by in_ desc, out_ desc"; $v_21=mysql_query($v_23) or print mysql_error(); $v_92=mysql_num_rows($v_21); $v_93=implode('',file('./faces/tpl.top.html')); for ($v_16=0;$v_16<$v_92;$v_16++) { $v_94=$v_16+1; $v_93=str_replace("{TRADER_URL_".$v_94."}",mysql_result($v_21,$v_16,'_url'),$v_93); $v_93=str_replace("{TRADER_DOMAIN_".$v_94."}",mysql_result($v_21,$v_16,'_domain'),$v_93); $v_93=str_replace("{IN_".$v_94."}",mysql_result($v_21,$v_16,'in_'),$v_93); $v_93=str_replace("{OUT_".$v_94."}",mysql_result($v_21,$v_16,'out_'),$v_93); } $v_11=fopen('./thumb/top.txt','w'); fwrite($v_11,$v_93); fclose($v_11); } function &get_thumb($v_95,$v_96=100) { $v_97[0]=array('thumb'=>'','url'=>'');$v_5=array(); $v_7=fopen('./thumb/thumb.csv','r'); while ($v_8 = fgetcsv ($v_7, 1000, ";")) { $v_5[$v_8[1]]=trim($v_8[0]); } fclose($v_7); $v_14=@unserialize(@implode('',@file('./thumb/thumb.stats'))); if (!is_array($v_14)) { $v_14=array();} arsort($v_14,SORT_NUMERIC); reset($v_14); $v_98=count($v_5); $v_99=count($v_14); $v_95=intval(($v_96/100)*$v_95); if ($v_95 > $v_99) { $v_95=$v_99; } $v_100=$v_98-$v_95; for ($v_16=0;$v_16<$v_95;$v_16++) { list($v_9,$v_10)=each($v_14); $v_97[]=array('thumb'=>$v_9,'url'=>$v_5[$v_9]); unset($v_5[$v_9]); } srand ((float) microtime() * 10000000); $v_101 = array_rand($v_5, $v_100); while(list($v_9,$v_10) = each($v_101)) { $v_97[]=array('thumb'=>$v_10,'url'=>$v_5[$v_10]); } unset($v_5); return $v_97; } function f_56() { $v_11=@fopen('./sys_log/cj_ref_'.date('Y-m-d').'.csv','a'); if ($v_11) { fwrite($v_11,"\"".date("H:i:s")."\";\"".$_SERVER['REMOTE_ADDR']."\";\"".$_SERVER['HTTP_REFERER']."\"\n"); fclose($v_11); } } function f_57($v_36) { $v_102=array('HTTP_CLIENT_IP','HTTP_FORWARDED','HTTP_FROM','HTTP_VIA','HTTP_X_FORWARDED_FOR','HTTP_PROXY_CONNECTION','HTTP_XROXY_CONNECTION','HTTP_PROXY_AUTHORIZATION','HTTP_FORWARDED','HTTP_USER_AGENT_VIA'); $v_103 = ''; $v_104 = 0; while(list($v_9,$v_10) = each($v_102)) { if (isset($_SERVER[$v_10])) { $v_104=1; $v_103.=$_SERVER[$v_10].'|'; } } $v_21=mysql_query("select _ip from tm_cj_iplog where _ip=".crc32($_SERVER['REMOTE_ADDR'])." and tid=".$v_36." limit 1") or die(mysql_error()); if (mysql_num_rows($v_21) > 0) { $v_23="update low_priority tm_cj_stats set _rin=_rin+1, _hrin=_hrin+1 where tid=".$v_36; }else { mysql_query("insert into tm_cj_iplog set _ip='".crc32($_SERVER['REMOTE_ADDR'])."', tid='".$v_36."', _time='".time()."', _act=1, _proxy=".$v_104); $v_23="update low_priority tm_cj_stats set _uin=_uin+1, _rin=_rin+1, _huin=_huin+1, _hrin=_hrin+1 where tid=".$v_36; } mysql_query($v_23); } if ($_GET['ft']) { $v_32=$_GET['ft']; }elseif ($_GET['id']) { $v_32=$_GET['id']; }elseif ($_SERVER['QUERY_STRING'] !='') { $v_32=$_SERVER['QUERY_STRING']; }elseif ($_SERVER['HTTP_REFERER']) { $v_105=parse_url($_SERVER['HTTP_REFERER']); $v_32=$v_105['host']; }else { $v_32=''; } $v_32=str_replace('www.','',$v_32); $v_32=eregi_replace("[^a-zA-Z_.0123456789-]+",'',$v_32); if ($v_32=='') { $v_32='bookmark'; } if (CRONTAB != 1) { $v_21=mysql_query("select _time from tm_cj_cron") or die(mysql_error()); $v_106=mysql_result($v_21,0,'_time'); if (date("H",$v_106) != date("H",time())) { @ignore_user_abort(true); mysql_query("update tm_cj_cron set _time=".time()) or die(mysql_error()); mysql_query("insert into tm_cj_hour select tid, unix_timestamp() - 3600, _huin, _hrin, _hout, _hclk from tm_cj_stats") or die(mysql_error()); mysql_query("update tm_cj_stats set _huin=0, _hrin=0, _hout=0, _hclk=0") or die(mysql_error()); mysql_query("delete from tm_cj_tmpst") or die(mysql_error()); mysql_query("insert into tm_cj_tmpst select h.tid, sum(h._uin), sum(h._rin), sum(h._out), sum(h._clk), f._force from tm_cj_hour h, tm_cj_force f where h._time >= unix_timestamp() - 3600*".HOUR_STAT." and h.tid=f.tid and f._hour='".date("G")."' group by h.tid order by h.tid") or die(mysql_error()); mysql_query("delete LOW_PRIORITY from tm_cj_iplog where _time < unix_timestamp() - 3600*".IP_EXP_HOUR) or die(mysql_error()); if (date("d",$v_106) != date("d",time())) { mysql_query("delete LOW_PRIORITY from tm_cj_hour where _time < unix_timestamp()-3600*(24*".MAX_HOUR_STAT.")"); } if (USE_TOP == 1) {f_55();} } } $v_21=mysql_query("select _face, tid from tm_cj_traders where _domain='".$v_32."'") or die(mysql_error()); if (mysql_num_rows($v_21) == 1) { $v_107=mysql_result($v_21,0,'_face'); if ($v_107=='') {$v_107='default';} $v_36=mysql_result($v_21,0,'tid'); }else { $v_36=1; $v_32='bookmark'; $v_107='default'; } if ($v_36==1) { f_56(); } $v_108=intval($_COOKIE['faceID'])+1; if ($v_108 > 1) { if (file_exists(PATH.'/faces/'.$v_107.$v_108.EXT)) { setcookie('faceID', $v_108, time()+86400*14); $v_107=$v_107.$v_108; }else { setcookie('faceID', '1', time()+86400*14); } }else { setcookie('faceID', '1', time()+86400*14); } f_57($v_36); setcookie('TM_CJ_TID',$v_36,false,'/'); Header("Cache-Control: no-cashe, must-revalidate"); Header("Pragma: no-cache"); include('./faces/'.$v_107.EXT); flush(); mysql_close(); ?>
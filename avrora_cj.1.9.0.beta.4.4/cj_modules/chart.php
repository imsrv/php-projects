<?php session_start(); ?> <html> <head> <title>Avrora CJ: chart</title> </head> <?php include('../cj_config.php'); if ($_SESSION['key']==md5(DB_LOGIN.DB_PASS)) { mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB'); mysql_select_db(DB_DEVICE) or die('Cannot select DB'); if ($_GET['tr']=='-1') { f_37(); }elseif($_GET['tr'] > 0) { f_36(); } }else { print 'Access denied'; } function f_36() { mysql_query("drop table if exists __TMP"); $v_23="create temporary table __TMP select _time, sum(_uin) as uin, sum(_rin) as rin, sum(_out) as out from tm_cj_hour where tid=".intval($_GET['tr'])." group by _time order by _time desc limit 24"; mysql_query($v_23); $v_21=mysql_query("select from_unixtime(_time,'%Y-%m-%d %H') as h, uin, rin, out from __TMP order by _time ASC"); $v_66=array(); while($v_22=mysql_fetch_array($v_21)) { $v_66[$v_22['h']]['rin']=$v_22['rin']; $v_66[$v_22['h']]['uin']=$v_22['uin']; $v_66[$v_22['h']]['out']=$v_22['out']; } print '<table width="780" border="0" cellspacing="1" cellpadding="1" align="center">'; print '<tr><td>'; f_38($v_66); print '</td></tr>'; print '</table>'; } function f_37() { mysql_query("drop table if exists __TMP"); $v_23="create temporary table __TMP select _time, sum(_uin) as uin, sum(_rin) as rin, sum(_out) as out from tm_cj_hour group by _time order by _time desc limit 24"; mysql_query($v_23); $v_21=mysql_query("select from_unixtime(_time,'%Y-%m-%d %H') as h, uin, rin, out from __TMP order by _time ASC"); $v_66=array(); while($v_22=mysql_fetch_array($v_21)) { $v_66[$v_22['h']]['rin']=$v_22['rin']; $v_66[$v_22['h']]['uin']=$v_22['uin']; $v_66[$v_22['h']]['out']=$v_22['out']; } print '<table width="780" border="0" cellspacing="1" cellpadding="1" align="center">'; print '<tr><td>'; f_38($v_66); print '</td></tr>'; print '</table>'; } function f_38($v_19) { $v_67=200; $v_68=9999999999;$v_69=1; while(list($v_9,$v_10)=each($v_19)) { $v_68=($v_10['rin']<$v_68)?$v_10['rin']:$v_68; $v_68=($v_10['uin']<$v_68)?$v_10['uin']:$v_68; $v_68=($v_10['out']<$v_68)?$v_10['out']:$v_68; $v_69=($v_10['rin']>$v_69)?$v_10['rin']:$v_69; $v_69=($v_10['uin']>$v_69)?$v_10['uin']:$v_69; $v_69=($v_10['out']>$v_69)?$v_10['out']:$v_69; } $v_27=$v_69/100; if ($v_27 == 0) {$v_27 =1;} $v_70=floor($v_67/100); reset($v_19); ?> <table border="0" cellspacing="1" cellpadding="3" style="border: 1px solid Black;"> <tr> <td><img src="../faces/chart_blue.gif" alt="" width="20" height="11" border="1"></td> <td><font style="font-size: 12px;">RAW IN</font></td> </tr> <tr> <td><img src="../faces/chart_green.gif" alt="" width="20" height="11" border="1"></td> <td><font style="font-size: 12px;">UNIQUE IN</font></td> </tr> <tr> <td><img src="../faces/chart_red.gif" alt="" width="20" height="11" border="1"></td> <td><font style="font-size: 12px;">OUT</font></td> </tr> </table> <br> <table border="0" cellspacing="1" cellpadding="3" style="border: 1px solid Black;"> <tr> <td colspan="<?php print count($v_19)?>"><font style="font-size: 12px;">Last <?php print count($v_19)?> hour stats.</font></td> </tr> <tr> <?php while (list($v_9,$v_10)=each($v_19)) { $v_71=$v_10['rin']/$v_27; $v_71=intval($v_71*$v_70); $v_72=$v_10['uin']/$v_27; $v_72=intval($v_72*$v_70); $v_73=$v_10['out']/$v_27; $v_73=intval($v_73*$v_70); ?> <td valign="bottom" align="center" height="<?php print $v_67?>"> <table width="0" border="0" cellspacing="0" cellpadding="0" align="center"> <tr> <td valign="bottom"><img src="../faces/chart_blue.gif" alt="<?php print $v_10['rin']?>" width="6" height="<?php print $v_71?>" border="1" hspace="0" vspace="0"></td> <td valign="bottom"><img src="../faces/chart_green.gif" alt="<?php print $v_10['uin']?>" width="6" height="<?php print $v_72?>" border="1" hspace="0" vspace="0"></td> <td valign="bottom"><img src="../faces/chart_red.gif" alt="<?php print $v_10['out']?>" width="6" height="<?php print $v_73?>" border="1" hspace="0" vspace="0"></td> </tr> </table> </td> <?php }?> </tr> </table> <br> <?php } ?> </body> </html>
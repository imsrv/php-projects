<?php
switch ($p['cmd']) {
	case 'open':
		news_open($p);
		break;
	case 'store':
		news_store($p);
		break;
	default:
		news_main();
}

function news_calendar(&$p) {
	require_once(getenv('DOCUMENT_ROOT')."/class/class.calendar.php");
	$d=explode("-",$p['date']);
	$day=intval($d[0]);
	$month=intval($d[1]);
	$year=intval($d[2]);

	class ext_calendar extends class_calendar {
		var $step_date;

	    function getCalendarLink($month, $year) {
			$out="?action=modules&mod_name=news&date=01-".$month."-".$year."";
			return $out;
	    }

		function getDateLink($day, $month, $year) {
			$today = getdate(); 
			$cd=mktime($today['month'], $today['mday'], $today['year']);
			$pd=mktime(0,0,0,$month, $day, $year);
			$res=$cd-$pd;

			if ($res >= 0) {$link ="?action=modules&mod_name=news&date=".$day."-".$month."-".$year;}
			else {$link=FALSE;}

	        return $link;
	    }
	}

	//--------------------------------
	//  Creating calendar
	//--------------------------------
	$_months = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
	$_days = array ("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
	
	$d = getdate(time());
	
	if ( $month == '') { $month = $d["mon"];}
	if ( $year == '') { $year = $d["year"]; }
	
	$cal = new ext_calendar;
	$cal->setMonthNames($_months);
	$cal->setDayNames($_days);
	$cal->step_date=intval($day);
	
	print $cal->getMonthView($month, $year);
}

function news_store(&$p) {
	global $p, $lang, $db, $s;
	$_date=mktime(0,0,0,$p['_date_month'],$p['_date_day'],$p['_date_year']);
	if ($p['_enabled']!='Y') {$p['_enabled']='N';}
	if ($p['to_del'] !='') {
		$SQL="delete from ai_news where id=".intval($p['id']);
		print '<font class="ok">'.$lang['56'].'</font>';
	}else {
		if (intval($p['id']) > 0) {
			$SQL="update ai_news set uid='".$s->read('uid')."', _time='".$_date."', _enabled='".$p['_enabled']."', _title='".$p['_title']."', _story='".$p['_story']."' where id=".$p['id'];
		}else {
			$SQL="insert into ai_news set uid='".$s->read('uid')."', _time='".$_date."', _enabled='".$p['_enabled']."', _title='".$p['_title']."', _story='".$p['_story']."'";
		}
		print '<font class="ok">'.$lang['55'].'</font>';
	}
	$db->m_query($SQL);
	news_main();
}

function news_open(&$p) {
	global $lang, $db;
	if (intval($p['id']) > 0) {
		$rs=$db->m_query("select * from ai_news where id=".intval($p['id']));
		$r=$db->m_fetch($rs);
	}else {
		$r['_time']=time();
	}
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="770" valign="top">
				<table width="100%" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
					<form action="index.php?cmd=store&action=modules&mod_name=news&ac=<?php print crypt(time());?>" method="post" name="artform">
					<input type="hidden" name="id" value="<?php print intval($r['id'])?>">
					<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang['edit']?></font></td></tr>
					<tr>
						<td width="150"><font class="name"><?php print $lang['title']?> :</font></td>
						<td><input type="text" name="_title" value="<?=$r['_title']?>" style="width: 600px;" class="input"></td>
					</tr>
					<tr>
						<td width="150"><font class="name"><?php print $lang['story']?> :</font><br><A HREF="#" class='normalBlue' onClick="window.open('../_editor.php?formname=artform&inputname=_story', 'editor_popup','width=750,height=570,scrollbars=yes,resizable=yes, status=yes');"><?php print $lang[48]?></a></td>
						<td><textarea cols="40" rows="15" name="_story" style="width: 600px;" class="input"><?=$r['_story']?></textarea></td>
					</tr>
					<tr>
						<td width="150"><font class="name"><?php print $lang['date']?> :</font></td>
						<td><?=make_date('_date',$r['_time'], 'input')?></td>
					</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[22]?> :</font></td>
							<td><input type="checkbox" name="_enabled" value="Y" class="box" <?php if ($r['_enabled']=='Y') {print 'checked';}?>></td>
						</tr>					
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" class='button' value="<?php print $lang[35]?>"><?php if (intval($p['id'])>0) {?><input type="submit" name="to_del" value="<?php print $lang[36]?>" onClick="return confirm('Are you sure DELETE this record?')" class='button'><?php }?></td>
					</tr>
				</table>
			</td>
			<td width="10"><img src="/p.gif" width="10" height="1" border="0"></td>
			<td width="230" valign="top">
				<?php print news_calendar($p);?>
			</td>				
		</tr>
	</table>
	<?
}

function news_main() {
	global $p, $lang, $db;
	$rs=$db->m_query("select id, _title, _time, _enabled from ai_news order by _time desc limit 50");
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="770" valign="top">
				<table width="100%" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
					<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang['list']?></font></td></tr>
					<tr>
						<td width="100"><a href="index.php?id=0&action=modules&cmd=open&mod_name=news&ac=<?=crypt(time())?>" class="name"><?=date("Y-m-d",time())?></a></td>
						<td><font class="name"><?=$lang['new']?></font></td>
					</tr>
					<tr><td colspan="2"><img src="/p.gif" width="1" height="10" border="0"></td></tr>
					<?while($r=$db->m_fetch($rs)) {?>
					<tr>
						<td width="150"><a href="index.php?id=<?=$r['id']?>&action=modules&cmd=open&mod_name=news&ac=<?=crypt(time())?>" class="name"><?=date("Y-m-d",$r['_time'])?></a></td>
						<td><?if ($r['_enabled']=='N') {print '-';}?><font class="name"><?=$r['_title']?></font></td>
					</tr>
					<?}?>
				</table>
			</td>
			<td width="10"><img src="/p.gif" width="10" height="1" border="0"></td>
			<td width="220" valign="top">
				<?php print news_calendar($p);?>
			</td>				
		</tr>
	</table>
	<?
}
?>
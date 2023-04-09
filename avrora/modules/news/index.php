<?php
global $db;
//--------------------------------
//  Inicializing current day
//--------------------------------
$nd=strtotime(eregi_replace("[^0123456789-]","",$_GET['date']));

//--------------------------------
//  Reading main topics from table
//--------------------------------
if ($_GET['date']) {
	$SUB_QUERY="and from_unixtime(".$nd.",\"%Y%m%d\")=from_unixtime(_time,\"%Y%m%d\")";
}else {
	$SUB_QUERY="";
}

$SQL="select *
	from ai_news 
		where 
			_enabled='y' and _time < unix_timestamp() 
			".$SUB_QUERY."
	order by id desc limit 5";
$rs=$db->m_query($SQL);

while($row=$db->m_fetch($rs)) {
	?>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
		<tr><td class="newsTitle"><?=$row['_title']?></td></tr>
		<tr><td class="newsText"><?=$row['_story']?></td></tr>
		<tr><td class="newsData">Дата публикации от: <?=date("Y-m-d",$row['_time'])?></td></tr>
		<tr><td background="/img/delimiter.gif"><img src="/p.gif" width="1" height="1" border="0"></td></tr>
	</table>
	<br>	
	<?
}

?>
<?php
global $url, $db;

$top=explode('/',$url);

$res=$db->m_query("select _menu from ai_pages where _path='".$url."'");
$a=unserialize($db->m_res($res,0,"_menu"));
print '<font class="topMenu">';
print '<a href="/" class="topMenu">Начало</a> ';
while(list($k,$v)=each($a)) {
	print '/ <a href="/art'.$k.'" class="topMenu">'.$v.'</a> ';
}
print '</font>';
/* top menu => END */
?>
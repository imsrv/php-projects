<?php
global $db, $art;

$SQL="select _title, _path from ai_pages 
	where _parent=".$art['pid']." and _link!='Y'
	and _hidden='Y' and _enabled='Y'";
$rs=$db->m_query($SQL);

while($r=$db->m_fetch($rs)) {
	print '<img src="/img/sel.gif" alt="" width="7" height="8" border="0" align="bottom">&nbsp;&nbsp;<a href="/art'.$r['_path'].'" class="linkList">'.$r['_title'].'</a><br>';
	print '<img src="/p.gif" width="1" height="7" border="0"><br>';
}
?>
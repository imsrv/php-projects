USETEXTLINKS = 1
STARTALLOPEN = 0
USEFRAMES = 0
USEICONS = 1
WRAPTEXT = 1
PERSERVESTATE = 1
ICONPATH='tree/'

<?php
error_reporting(7);
include_once('../config.php');
include_once('../class/class.mysql.php');

$db=new class_db(DB_HOST,DB_LOGIN,DB_PASS);
$db->m_select_db(DB_DEVICE);
$db->debug=TRUE;

$rs=$db->m_query("SELECT * FROM ai_pages ORDER BY _parent ASC, _sort ASC");

$a=array();
while($row=$db->m_fetch($rs)) {
	$a[$row['pid']]['pid']=$row['pid'];
	$a[$row['pid']]['title']=str_replace('"',"",$row['_title']);
	$a[$row['pid']]['parent']=$row['_parent'];
	$a[$row['pid']]['child']=0;
	$a[$row['_parent']]['child']=1;
}
unset($a[0]);reset($a);
$db->m_close();

print 'foldersTree = gFld("<b>'.getenv("SERVER_NAME").'</b>", "")'."\n";
list($key,$val)=each($a);
print 'aux'.$a[$key]['pid'].' = insFld(foldersTree, gFld("'.$a[$key]['title'].'", "index.php?cmd=open&pid='.$a[$key]['pid'].'&action=pages"))'."\n";

while (list($key,$val)=each($a)) {
	if ($a[$key]['child']==1) {
		print 'aux'.$a[$key]['pid'].' = insFld(aux'.$a[$key]['parent'].', gFld("'.$a[$key]['title'].'", "index.php?cmd=open&pid='.$a[$key]['pid'].'&action=pages"))'."\n";
	}else {
		print 'insDoc(aux'.$a[$key]['parent'].', gLnk("S", "'.$a[$key]['title'].'", "./index.php?cmd=open&pid='.$a[$key]['pid'].'&action=pages"))'."\n";
	}
}
?>
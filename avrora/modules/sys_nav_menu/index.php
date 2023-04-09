<?php
global $art, $db;
function &sub_menu($nav,$pid){
	$r='';
	while(list($k,$v)=each($nav)) {
		if ($nav[$k]['parent']==$pid) {
			if ($nav[$k]['is_link']=='Y') {
				$link=$nav[$k]['link'];
			}else {
				$link='/art'.$nav[$k]['path'];
			}
			$r.= '<img src="/p.gif" width="15" height="1" border="0"> <img src="/img/dot2.gif" width="2" height="2" border="0" align="middle"> &nbsp; <a href="'.$link.'" class="naviMain">'.$nav[$k]['title'].'</a><br>';
		}
	}
	if ($r) {
		$r.='<img src="/p.gif" width="1" height="7" border="0"><br>';
	}
	return $r;
}

$SQL="SELECT a.pid, a._title, a._sort, a._path, a._parent, a._is_link, a._link
  FROM ai_pages a, ai_pages b
  WHERE (a._parent=".$art['pid']."
        OR a._parent=b._parent)
        AND b.pid=".$art['pid']." AND a._enabled='Y' and a._hidden='N'
  ORDER BY a._parent ASC, a._sort ASC";
$rs=$db->m_query($SQL);
while($row=$db->m_fetch($rs)) {
	$nav[$row['pid']]['pid']=$row['pid'];
	$nav[$row['pid']]['title']=$row['_title'];
	$nav[$row['pid']]['path']=$row['_path'];
	$nav[$row['pid']]['parent']=$row['_parent'];
	$nav[$row['pid']]['is_link']=$row['_is_link'];
	$nav[$row['pid']]['link']=$row['_link'];
}

if ($art['pid']> 1) {
	while(list($k,$v)=@each($nav)) {
		if ($nav[$k]['parent']==$art['parent']) {
			if ($nav[$k]['is_link']=='Y') {
				$link=$nav[$k]['link'];
			}else {
				$link='/art'.$nav[$k]['path'];
			}
			if ($nav[$k]['pid']==$art['pid']) {
				// current menu punkt selected
				print '&nbsp;<img src="/img/dot1-on.gif" alt="" width="4" height="4" border="0" align="middle"> &nbsp; <a href="'.$link.'" class=naviMain>'.$nav[$k]['title'].'</a><br><img src="/p.gif" width="4" height="1" border="0"><img src="/img/dot.gif" width="195" height="1" border="0" align="middle"><br><img src="/p.gif" width="1" height="4" border="0"><br>';
				print sub_menu($nav,$art['pid']);
			}else {
				print '&nbsp;<img src="/img/dot1.gif" alt="" width="4" height="4" border="0" align="middle"> &nbsp; <a href="'.$link.'" class=naviMain>'.$nav[$k]['title'].'</a><br><img src="/p.gif" width="4" height="1" border="0"><img src="/img/dot.gif" width="195" height="1" border="0" align="middle"><br><img src="/p.gif" width="1" height="4" border="0"><br>';
			}
		}
	}
}else {
	while(list($k,$v)=each($nav)) {
		if ($nav[$k]['pid']!=$art['pid']) {
			if ($nav[$k]['is_link']=='Y') {
				$link=$nav[$k]['link'];
			}else {
				$link='/art'.$nav[$k]['path'];
			}
			print '&nbsp;<img src="/img/dot1.gif" alt="" width="4" height="4" border="0" align="middle"> &nbsp; <a href="'.$link.'" class=naviMain>'.$nav[$k]['title'].'</a><br><img src="/p.gif" width="4" height="1" border="0"><img src="/img/dot.gif" width="195" height="1" border="0" align="middle"><br><img src="/p.gif" width="1" height="4" border="0"><br>';
		}
	}
}
?>
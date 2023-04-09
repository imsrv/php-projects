<?php
$ar=array();

switch ($p['cmd']) {
	case 'store':
		p_store($p);
		p_open($p);
		break;
	case 'open':
		if ($p['sort'] !='') { sort_change($p); }
		p_open($p);
		break;
	case 'update_structure':
		update_structure();
		break;
	case 'copy':
		p_copy($p);
		break;
	case 'cut':
		p_cut($p);
		break;
	case 'paste':
		p_paste($p);
		break;
	case 'create':
		$r=p_create($p);
		if ($r !=false) {
			$p['pid']=$r;
			p_open($p);
		}else {
			p_open($p);
		}
		
		break;
	default;
}

function get_path($id) {
	global $ar;
	if ($ar[$id]['parent'] == 0) {
		return array('path'=>'/','id'=>array());
		//return '/';
	}else {
		$t=get_path($ar[$id]['parent']);
		$p['path']=$t['path'].''.$ar[$id]['alias'].'/';
		$p['id']=$t['id'];
		$p['id'][$p['path']]=$ar[$id]['title'];
		//$p=get_path($ar[$id]['parent']).''.$ar[$id]['alias'].'/';
		return $p;
	}
}

function update_structure() {
	global $ar, $db, $lang;
	$rs=$db->m_query('select pid, _parent, _alias, _path, _title from ai_pages order by _parent');
	while ($row=$db->m_fetch($rs)) {
		$ar[$row['pid']]['pid']=$row['pid'];
		$ar[$row['pid']]['alias']=$row['_alias'];
		$ar[$row['pid']]['parent']=$row['_parent'];
		$ar[$row['pid']]['path']=$row['_path'];
		$ar[$row['pid']]['title']=$row['_title'];
	}

	while(list($k,$v)=each($ar)) {
		$url=get_path($ar[$k]['pid']);
		$db->m_query("UPDATE ai_pages SET _path='".$url['path']."', _menu='".mysql_escape_string(serialize($url['id']))."' WHERE pid=".$ar[$k]['pid']);
	}
	print '<font class="ok">'.$lang['51'].'</font>';
}

function sort_change(&$p) {
	global $db, $lang;
	$rs=$db->m_query('SELECT _parent FROM ai_pages WHERE pid='.intval($p['ppid']));
	$_parent=intval($db->m_res($rs,0,'_parent'));
	if (check_access('pages',$_parent,'w')) {
		$rs=$db->m_query("SELECT * FROM ai_pages WHERE pid=".intval($p['ppid']));
		$my_pid=intval($p['ppid']);
		$my_sort=intval($db->m_res($rs,0,"_sort"));
		if ($p['sort']=='down') {
			$rs=$db->m_query("SELECT * FROM ai_pages WHERE pid != ".$my_pid." AND _sort >= ".$my_sort." AND _parent=".$_parent." ORDER BY _sort ASC LIMIT 1");
			if ($db->m_count($rs)==1) {
				$to_pid=$db->m_res($rs,0,"pid");
				$to_sort=$db->m_res($rs,0,"_sort");
				$db->m_query("UPDATE ai_pages SET _sort=".$my_sort." WHERE pid=".$to_pid);
				$db->m_query("UPDATE ai_pages SET _sort=".$to_sort." WHERE pid=".$my_pid);
			}
		}elseif($p['sort']=='up') {
			$rs=$db->m_query("SELECT * FROM ai_pages WHERE pid != ".$my_pid." AND _sort <= ".$my_sort." AND _parent=".$_parent." ORDER BY _sort DESC LIMIT 1");
			if ($db->m_count($rs)==1) {
				$to_pid=$db->m_res($rs,0,"pid");
				$to_sort=$db->m_res($rs,0,"_sort");
				$db->m_query("UPDATE ai_pages SET _sort=".$my_sort." WHERE pid=".$to_pid);
				$db->m_query("UPDATE ai_pages SET _sort=".$to_sort." WHERE pid=".$my_pid);
			}
		}
	}else {
		print '<font class="warning">'.$lang['50'].'</font>';
	}
}

function p_paste($p) {
	global $s, $lang;
	$pid=$s->m_read('pages_id');
	if ($pid && $s->m_read('action')=='copy') {
		if (check_access('pages',$p['pid'],'c')) {
			/* part of code */
		}else {
			print '<font class="warning">'.$lang['50'].'</font>';
		}
	}elseif ($pid && $s->m_read('action')=='cut') {
		if (check_access('pages',$p['pid'],'c')) {
			/* part of code */
		}else {
			print '<font class="warning">'.$lang['50'].'</font>';
		}
	}else {
		print 'Error, pages not selected <br>';
	}
}

function p_cut(&$p) {
	global $s;
	if (trim($p['pid'])) {
		$s->m_write('pages_id',trim($p['pid']));
		$s->m_write('action','cut');
	}
	return true;
}

function p_copy(&$p) {
	global $s;
	if (trim($p['pid'])) {
		$s->m_write('pages_id',trim($p['pid']));
		$s->m_write('action','copy');
	}
	return true;
}

function p_open(&$p) {
	global $db, $lang;
	if (check_access('pages',$p['pid'],'r')) {
		$rs=$db->m_query("SELECT * FROM ai_pages WHERE pid=".intval($p['pid']));
		$row=$db->m_fetch($rs);
		$rs=$db->m_query('SELECT * FROM ai_templates ORDER BY tid ASC');
		if (intval($row['_date']) == 0) {
			$row['_date']=time();
		}
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="760" valign="top">
					<table width="100%" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
						<form action="index.php?cmd=store&action=pages&ac=<?php print crypt(time());?>" method="post" name="artform">
						<input type="hidden" name="pid" value="<?php print intval($p['pid'])?>">
						<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang[13]?></font></td></tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[17]?> :</font></td>
							<td><input type="text" name="_title" value="<?=$row['_title']?>" style="width: 600px;" class="input"></td>
						</tr>
						<tr>
							<td valign="top"><font class="name"><?php print $lang[18]?> :</font><br><A HREF="#" class='normalBlue' onClick="window.open('../_editor.php?formname=artform&inputname=_desc', 'editor_popup','width=750,height=570,scrollbars=yes,resizable=yes, status=yes');"><?php print $lang[48]?></a></td>
							<td><textarea cols="40" rows="5" name="_desc" style="width: 600px;" class="input"><?=$row['_desc']?></textarea></td>
						</tr>
						<tr>
							<td valign="top"><font class="name"><?php print $lang[19]?> :</font><br><A HREF="#" class='normalBlue' onClick="window.open('../_editor.php?formname=artform&inputname=_text', 'editor_popup','width=750,height=570,scrollbars=yes,resizable=yes, status=yes');"><?php print $lang[48]?></a></td>
							<td><textarea cols="40" rows="15" name="_text" style="width: 600px;" class="input"><?=$row['_text']?></textarea></td>
						</tr>
						<tr><td colspan="2"><img src="/p.gif" alt="" width="1" height="10" border="0"></td></tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[20]?> :</font></td>
							<td><select name="_template" style="width: 250px;" class="input">
								<?php while ($row2=$db->m_fetch($rs)) { ?>
								<option value="<?php print $row2['tid']?>" <?php if ($row2['tid']==$row['tid']) {print 'SELECTED';}?>><?php print $row2['_desc']?></option>
								<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[21]?> :</font></td>
							<td><?php print make_date('_date',$row['_date'])?></td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[24]?> :</font></td>
							<td><input type="text" name="_alias" value="<?=$row['_alias']?>" style="width: 250px;" class="input"></td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[44]?> :</font></td>
							<td><input type="text" name="_link" value="<?=$row['_link']?>" style="width: 250px;" class="input"> <input type="checkbox" name="_is_link" value="Y" class="box"<?php if ($row['_is_link']=='Y') {print 'checked';}?>></td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[22]?> :</font></td>
							<td><input type="checkbox" name="_enabled" value="Y" class="box" <?php if ($row['_enabled']=='Y') {print 'checked';}?>></td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[23]?> :</font></td>
							<td><input type="checkbox" name="_hidden" value="Y" class="box"<?php if ($row['_hidden']=='Y') {print 'checked';}?>></td>
						</tr>
						<tr>
							<td width="150"><font class="name"><?php print $lang[45]?> :</font></td>
							<td><input type="checkbox" name="_comment" value="Y" class="box"<?php if ($row['_comment']=='Y') {print 'checked';}?>></td>
						</tr>
						<tr><td colspan="2"><img src="/p.gif" alt="" width="1" height="10" border="0"></td></tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class='button' value="<?php print $lang[35]?>"><?php if (intval($p['pid'])>1) {?><input type="submit" name="to_del" value="<?php print $lang[36]?>" onClick="return confirm('Are you sure DELETE this record?')" class='button'><?php }?></td>
						</tr>
						</form>
					</table>
					<br><img src="/p.gif" alt="" width="760" height="1" border="0"><br>
					<table width="100%" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
						<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang[46]?></font></td></tr>
						<?php
						$rs=$db->m_query("SELECT * FROM ai_pages WHERE _parent=".intval($p['pid'])." ORDER BY _sort ASC");
						while($row=$db->m_fetch($rs)) {
						?>
							<tr>
								<td align="center"><a href="index.php?action=pages&pid=<?php print intval($p['pid']);?>&ppid=<?php print $row['pid'];?>&sort=up&cmd=open"><img src="_up.gif" alt="Up" width="11" height="9" border="0"></a><a href="index.php?action=pages&pid=<?php print intval($p['pid']);?>&ppid=<?php print $row['pid'];?>&sort=down&cmd=open"><img src="_down.gif" alt="Down" width="12" height="9" border="0"></a></td>
								<td><a href="index.php?cmd=open&pid=<?php print $row['pid'];?>&action=pages&ac=<?php print crypt(time());?>" class="name"><?php print $row['_title'];?></a></td>
							</tr>
						<?
						}
						?>
						<tr>
							<td width="150" align="center">&nbsp;</td>
							<td><a href="index.php?cmd=create&pid=<?php print intval($p['pid']);?>&action=pages&ac=<?php print crypt(time());?>" class="name"><?php print $lang[47]?></a></td>
						</tr>
					</table>
				</td>
				<td width="10"><img src="/p.gif" width="10" height="1" border="0"></td>
				<td width="230" valign="top">
					<?php print pages_tree();?>
				</td>				
			</tr>
		</table>
		<?php
	}else {
		print '<font class="warning">'.$lang[11].'</font>';
	}
}

function p_create($p) {
	global $db, $lang;
	if (check_access('pages',$p['pid'],'c')) {
		$rs=$db->m_query('SELECT MAX(_sort)+1 as _sort FROM ai_pages WHERE _parent='.intval($p['pid']));
		$_sort=intval($db->m_res($rs,0,'_sort'));
		if ($p['_is_link']!='Y') {$p['_is_link']='N';}
		if ($p['_enabled']!='Y') {$p['_enabled']='N';}
		if ($p['_hidden']!='Y') {$p['_hidden']='N';}
		if ($p['_comment']!='Y') {$p['_comment']='N';}
		$SQL="INSERT INTO ai_pages SET tid='".intval($p['_template'])."', _title='new pages', _desc='".$p['_desc']."', _text='".$p['_text']."', _is_link='".$p['_is_link']."', _link='".$p['_link']."', _enabled='".$p['_enabled']."', _hidden='".$p['_hidden']."', _date='".$_date."', _comment='".$p['_comment']."', _parent='".$p['pid']."', _sort='".$_sort."', _alias='".time()."'";
		$db->m_query($SQL);
		$rs=mysql_query("SELECT LAST_INSERT_ID() AS id");
		return $db->m_res($rs,0,'id');
	}else {
		print '<font class="warning">'.$lang['50'].'</font>';
		return false;
	}
}

function p_store(&$p) {
	global $db, $lang;
	if ($p['to_del']) {
		if (check_access('pages',$p['pid'],'r')) {
			if ($p['pid']==1) {
				print 'its defailt pages <br>';
			}else {
				$rs=$db->m_query('SELECT * FROM ai_pages WHERE _parent='.intval($p['pid']));
				if ($db->m_count($rs) != 0) {
					print '<font class="warning">'.$lang['49'].'</font>';
				}else {
					$db->m_query('DELETE FROM ai_pages WHERE pid='.intval($p['pid']));
				}
			}
		}else {
			print '<font class="warning">'.$lang['50'].'</font>';
		}
	}else {
		$_date=mktime(0,0,0,$p['_date_month'],$p['_date_day'],$p['_date_year']);
		if (intval($p['pid']) > 0) {
			if (check_access('pages',$p['pid'],'w')) {
				if ($p['_is_link']!='Y') {$p['_is_link']='N';}
				if ($p['_enabled']!='Y') {$p['_enabled']='N';}
				if ($p['_hidden']!='Y') {$p['_hidden']='N';}
				if ($p['_comment']!='Y') {$p['_comment']='N';}
				if (trim($p['_alias'])=='') {
					$p['_alias']=time();
				}else {
					$SQL="select * from ai_pages a, ai_pages b where a.pid=".intval($p['pid'])." and a._alias=b._alias and a._parent=b._parent and b.pid !=".intval($p['pid']);
					$rs=$db->m_query($SQL);
					if ($db->m_count($rs) > 0) {
						$p['_alias']=time();
					}
				}
				$SQL="UPDATE ai_pages SET tid='".intval($p['_template'])."', _title='".$p['_title']."', _desc='".$p['_desc']."', _text='".$p['_text']."', _is_link='".$p['_is_link']."', _link='".trim($p['_link'])."', _enabled='".$p['_enabled']."', _hidden='".$p['_hidden']."', _date='".$_date."', _comment='".$p['_comment']."', _alias='".trim($p['_alias'])."' WHERE pid=".intval($p['pid']);
				$db->m_query($SQL);
			}else {
				print '<font class="warning">'.$lang['50'].'</font>';
			}
		}else {
			print '<font class="warning">'.$lang['50'].'</font>';
		}
	}
}

function pages_tree() {
	?>
	<script>
	//This script is not related with the tree itself, just used for my example
	function getQueryString(index)
	{
		var paramExpressions;
		var param
		var val
		paramExpressions = window.location.search.substr(1).split("&");
		if (index < paramExpressions.length)
		{
			param = paramExpressions[index]; 
			if (param.length > 0) {
				return eval(unescape(param));
			}
		}
		return ""
	}
	</script>
	
	<!-- SECTION 3: These four scripts define the tree, do not remove-->
	<script src="./tree/ua.js"></script>
	<script src="./tree/ftiens4.js"></script>
	<script src="tree.php?ac=<?php print crypt(time());?>"></script>
	
	<a style="font-size:7pt;text-decoration:none;color:silver" href=http://www.treeview.net/treemenu/userhelp.asp target=_top></a>
	<script>initializeDocument()</script>
	<noscript>
	A tree for site navigation will open here if you enable JavaScript in your browser.
	</noscript>	
	<?php
}

?>
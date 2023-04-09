<?php
switch ($p['cmd']) {
	case 'open_template':
		open_template($p);
		break;
	case 'store_template':
		store_template($p);
		list_template();
		break;
	case 'list_template':
		list_template();
		break;
	default:
		break;
}

function store_template(&$p) {
	global $lang, $db;
	if ($p['to_del'] && $p['tid']) {
		$rs=$db->m_query('SELECT tid FROM ai_templates WHERE tid !='.intval($p['tid']));
		if ($db->m_count($rs) == 0) {
			print '<font class="warning">'.$lang['54'].'</font>';
		}else {
			$db->m_query("UPDATE ai_pages SET tid=".$db->m_res($rs,0,'tid')." WHERE tid=".intval($p['tid']));
			$db->m_query("DELETE FROM ai_templates WHERE tid=".intval($p['tid']));
		}
	}else {
		if (intval($p['tid']) == 0) {
			$SQL="INSERT INTO ai_templates SET _name='".trim($p['_name'])."', _desc='".trim($p['_desc'])."'";
		}else {
			$SQL="UPDATE ai_templates SET _name='".trim($p['_name'])."', _desc='".trim($p['_desc'])."' WHERE tid=".intval($p['tid']);
		}
		$db->m_query($SQL);
	}
}

function open_template(&$p) {
	global $lang, $db;
	if (intval($p['tid']) > 0) {
		$rs=$db->m_query("SELECT * FROM ai_templates WHERE tid =".intval($p['tid']));
		$row=$db->m_fetch($rs);
	}
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
		<form action="index.php" method="post">
		<input type="hidden" name="action" value="templates">
		<input type="hidden" name="cmd" value="store_template">
		<input type="hidden" name="tid" value="<?php print intval($p['tid'])?>">
		<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang[40]?></font></td></tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[41]?></font></td>
			<td><input type="text" name="_name" value="<?php print $row['_name']?>" class='input' style="width: 230px;"></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[42]?></font></td>
			<td><input type="text" name="_desc" value="<?php print $row['_desc']?>" class='input' style="width: 230px;"></td>
		</tr>		
		<tr><td colspan="2"><input type="submit" class='button' value="<?php print $lang[35]?>"><?php if (intval($p['tid'])>0) {?><input type="submit" name="to_del" value="<?php print $lang[36]?>" onClick="return confirm('Are you sure DELETE this record?')" class='button'><?php }?></td></tr>
		</form>
	</table>
	<?php
}

function list_template() {
	global $lang, $db;
	$rs=$db->m_query("SELECT * FROM ai_templates ORDER BY tid ASC");
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td><font class="title"><?php print $lang[43]?></font></td>
		</tr>
		<?php while($row=$db->m_fetch($rs)) {?>
		<tr>
			<td><li><a href="index.php?cmd=open_template&tid=<?php print $row['tid']?>&action=templates" class='name'><?php print $row['_name']?></a></td>
			<td><font class='normal'><?php print $row['_desc']?></font></td>
		</tr>
		<?php }?>
	</table>
	<?php
}
?>
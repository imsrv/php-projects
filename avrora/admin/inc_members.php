<?php

switch (trim($p['cmd'])) {
	case 'list_members':
		list_members($db);
		break;
	case 'open_user':
		open_user($db,$p);
		break;
	case 'store_user':
		store_user($db,$p);
		list_members($db);
		break;
	case 'list_groups':
		list_groups();
		break;
	case 'open_group':
		open_group($p);
		break;
	case 'store_group':
		store_group($p);
		list_groups();
		break;
	default:
		break;
}

function store_group($p) {
	global $db,$lang;
	if ($p['to_del'] && $p['gid']) {
		$rs=$db->m_query("SELECT * FROM ai_group WHERE gid=".intval($p['gid']));
		if ($db->m_res($rs,0,"_system")!='Y') {
			$db->m_query("UPDATE ai_users SET gid=3 WHERE gid=".intval($p['gid']));
			$db->m_query("DELETE FROM ai_access WHERE gid=".intval($p['gid']));
			$db->m_query("DELETE FROM ai_group WHERE gid=".intval($p['gid']));
		}else {
			print "Can't delete system group";
		}
	}else {
		if (intval($p['gid']) == 0) {
			$SQL="INSERT INTO ai_group SET _name='".trim($p['_name'])."', _system='N'";
		}else {
			$SQL="UPDATE ai_group SET _name='".trim($p['_name'])."' WHERE _system='N' AND gid=".intval($p['gid']);
		}
		$db->m_query($SQL);
	}
}

function open_group(&$p){
	global $db,$lang;
	if (intval($p['gid']) > 0) {
		$rs=$db->m_query("SELECT * FROM ai_group WHERE gid=".intval($p['gid']));
		$row=$db->m_fetch($rs);
	}
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
		<form action="index.php?cach=<?php print time();?>" method="post">
		<input type="hidden" name="action" value="members">
		<input type="hidden" name="cmd" value="store_group">
		<input type="hidden" name="gid" value="<?php print intval($p['gid'])?>">
		<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang[39]?></font></td></tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[34]?></font></td>
			<td><input type="text" name="_name" value="<?php print $row['_name']?>" class='input'  style="width: 150px;"></td>
		</tr>
		<tr><td colspan="2"><input type="submit" class='button' value="<?php print $lang[35]?>"><?php if (intval($p['gid'])>0) {?><input type="submit" name="to_del" value="<?php print $lang[36]?>" onClick="return confirm('Are you sure DELETE this record?')" class='button'><?php }?></td></tr>
		</form>
	</table>
	<?php
}

function list_groups() {
	global $db,$lang;
	$SQL="SELECT * FROM ai_group ORDER BY gid ASC";
	$rs=$db->m_query($SQL);
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td><font class="title"><?php print $lang[38]?></font></td>
		</tr>
		<?php while($row=$db->m_fetch($rs)) {
			if ($row['_system']=='Y') {
				$link='<li><font class="name">'.$row['_name']."</font>";
			}else {
				$link='<li>'.'<a href="index.php?cmd=open_group&gid='.$row['gid'].'&action=members" class="name">'.$row['_name'].'</a>';
			}
		?>
		<tr>
			<td><?php print $link?></td>
		</tr>
		<?php }?>
	</table>
	<?php
}

function store_user(&$db,&$p) {
	if ($p['to_del'] && $p['uid']) {
		$db->m_query("DELETE FROM ai_access WHERE uid=".intval($p['uid']));
		$db->m_query("DELETE FROM ai_users WHERE uid=".intval($p['uid']));
	}else {
		if (intval($p['uid']) == 0) {
			$SQL="INSERT INTO ai_users SET gid='".intval($p['gid'])."', _status='".trim($p['_status'])."', _pass='".md5(trim($p['_pass']))."', _login='".trim($p['_login'])."', _name='".trim($p['_name'])."', _mail='".trim($p['_mail'])."', _date_register='".time()."', _date_last='".time()."', _ip_register='".getenv('REMOTE_ADDR')."', _ip_last='".getenv('REMOTE_ADDR')."', _pages='".trim($p['_mail'])."'";
		}else {
			if (trim($p['_pass'])) {
				$pass="_pass='".md5(trim($p['_pass']))."',";
			}else {
				$pass='';
			}
			$SQL="UPDATE ai_users SET gid='".intval($p['gid'])."', _status='".trim($p['_status'])."', ".$pass." _name='".trim($p['_name'])."', _mail='".trim($p['_mail'])."', _pages='".trim($p['_pages'])."' WHERE uid=".intval($p['uid']);
		}
		$db->m_query($SQL);
	}
}

function open_user(&$db,&$p) {
	global $lang;
	if (intval($p['uid'])>0) {
		$rs=$db->m_query("SELECT * FROM ai_users WHERE uid=".intval($p['uid']));
		$row=$db->m_fetch($rs);
	}
	$rs=$db->m_query("SELECT * FROM ai_group ORDER BY gid ASC");
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1" style="border: 1px solid #708090;">
		<form action="index.php?cach=<?php print time();?>" method="post">
		<input type="hidden" value="store_user" name="cmd">
		<input type="hidden" value="members" name="action">
		<input type="hidden" value="<?php print @$row['uid']?>" name="uid">
		<tr><td colspan="2" bgcolor="#0000FF">&nbsp;<font class="titleTextWhite"><?php print $lang[27]?></font></td></tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[28]?></font></td>
			<td><input type="text" name="_login" value="<?php print @$row['_login']?>" class='input' style="width: 230px;" <?php if (intval($p['uid'])>0) {print 'readonly';}?>></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[29]?></font></td>
			<td><input type="password" name="_pass" class='input' style="width: 230px;"></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[30]?></font></td>
			<td><input type="text" name="_name" value="<?php print @$row['_name']?>" class='input' style="width: 230px;"></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[31]?></font></td>
			<td><input type="text" name="_mail" value="<?php print @$row['_mail']?>" class='input' style="width: 230px;"></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[32]?></font></td>
			<td><input type="text" name="_pages" value="<?php print @$row['_pages']?>" class='input' style="width: 230px;"></td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[33]?></font></td>
			<td><select name="_status" class='input' style="width: 150px;">
					<option value="Y" <?php if (@$row['_status']=='Y') {print 'SELECTED';}?>>enabled</option>
					<option value="N" <?php if (@$row['_status']!='Y') {print 'SELECTED';}?>>disabled</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<font class='name'><?php print $lang[34]?></font></td>
			<td><select name="gid" class='input' style="width: 150px;">
					<?php while($_row=$db->m_fetch($rs)) {?>
					<option value="<?php print $_row['gid']?>" <?php if ($_row['gid']==@$row['gid']) {print 'SELECTED';}?>><?php print $_row['_name']?></option>
					<?php }?>
				</select>
			</td>
		</tr>
		<tr><td colspan="2"><input type="submit" class='button' value="<?php print $lang[35]?>"><?php if (intval($p['uid'])>0) {?><input type="submit" name="to_del" value="<?php print $lang[36]?>" onClick="return confirm('Are you sure DELETE this record?')" class='button'><?php }?></td></tr>
		</form>
	</table>
	<?php
}

function list_members(&$db) {
	global $lang;
	$SQL="SELECT u.uid, u._status, u._login, u._name, g._name AS _group
			  FROM ai_users u, ai_group g
			  WHERE u.gid=g.gid
			  ORDER BY _login ASC";
	$rs=$db->m_query($SQL);
	?>
	<table width="400" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td><font class="title"><?php print $lang[26]?></font></td>
		</tr>
		<?php while($row=$db->m_fetch($rs)) {
			if ($row['_status']=='Y') {$color='#000000';}else {$color='#aeaeae';}
		?>
		<tr>
			<td><li><a href="index.php?cmd=open_user&uid=<?php print $row['uid']?>&action=members&cach=<?php print time();?>" class='name'><font color="<?php print $color;?>"><?php print $row['_login']?></font></a></td>
			<td><font class="normal"><?php print $row['_name']?></font></td>
			<td><font class="normal"><?php print $row['_group']?></font></td>
		</tr>
		<?php }?>
	</table>
	<?php
}

?>
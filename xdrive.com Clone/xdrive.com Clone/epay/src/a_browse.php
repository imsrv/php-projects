<?
	if($_GET['del']){
		mysql_query("DELETE FROM epay_shops WHERE id={$_GET['del']}");
	}
?>
<table width="700" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td>
		<table width="620" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
		<tr>
			<td width=150 height="314" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbin">
				<tr><td class="tdtitle">Categories</td></tr>
				<tr>
					<td class="tdmenu">
<?
	aprareas(0);
	prareas(0);
	reset($aenum_areas);
	reset($enum_areas);
	while ($a = each($aenum_areas)){
		echo "<a href=?a=browse&area={$a[0]}&{$id}>{$a[1]}</a><BR>";
	}					
?>
					</td>
				</tr>
				</table>
				<div align="center">
				<br>
			</td>
			<td width=20> </td>
			<td width="519" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
<?
	if($_GET['area']){
		$area = $_GET['area'];
		$where = "WHERE area='$area'";
	}else{
		$limit = "LIMIT 0,15";
	}
	$sql = "SELECT * FROM epay_shops $where ORDER BY id $limit";
	$qr1 = mysql_query($sql);
	if($qr1){
		while( $row = mysql_fetch_object($qr1) ){
			$pid = $row->id;
?>
				<tr>
					<td>
						<table width="80%" cellpadding="0" cellspacing="0" class="tbin">
						<tr>
							<td colspan=2 class="tdtitle"><a href="<?=$row->url?>" target="_new"><?=$row->name?></a></td>
						</tr>
						<tr>
							<td colspan=2 height="8" class="tdin"></td>
						</tr>
						<tr>
							<td class="tdin">
<?
		$handle=opendir($att_path); 
		while (false!==($file = readdir($handle))) { 
			if ($file != "." && $file != "..") { 
				if( strstr($file , "x".$pid."_") ){
					$furl = $siteurl."//epay/".(str_replace("./","",$att_path))."/".$file;
					echo "<a href=\"{$row->url}\" target=\"_new\"><img src='$furl'></a>";
				}
			} 
		}
		closedir($handle); 
?>
							</td>
							<td class="tdin">
								<?=$row->comment?>
							</td>
						</tr>
						</table>
<?
				if( ($user == $row->owner) || ($user == 3) ){
					echo "<a href=?a=submit_site&edit=$pid>edit shop</a> | ";
					echo "<a onClick=\"return confirm('are you sure you want to delete this item?');\" href=?a=browse&del=$pid>delete shop</a>";					
				}
?>
					</td>
				</tr>
<?
		}
	}
?>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
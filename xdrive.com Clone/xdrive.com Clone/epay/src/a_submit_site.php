<table width="700" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td>
		<table width="620" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
		<tr>
			<td width=150 height="314" valign="top">
<?
	include("src/acc_menu.php");
?>
			</td>
			<td width=20> </td>
			<td width="519" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
    				<td valign="top">
<?
	aprareas(0);
	prareas(0);
	if( ($_POST['name']) && ($_POST['url']) ){
		$name = addslashes($_POST['name']);
		$url = addslashes($_POST['url']);
		$area = $_POST['area'];
		$comment = addslashes($_POST['comment']);
		if($_POST['edit']){
			$query = "UPDATE epay_shops SET 
							owner='$user',
							name='$name',
							url='$url',
							area='$area',
							comment='$comment'
							WHERE id=".$_POST['edit'];
		}else{
			$query = "INSERT INTO epay_shops SET 
							owner='$user',
							name='$name',
							url='$url',
							area='$area',
							comment='$comment',
							imgfile='".($filename ? "'$filename'" : "NULL")."'";
		}
		mysql_query($query);
		$pid = mysql_insert_id();
		$filename = (!$_FILES['imgfile']['error'] ? substr( basename($_FILES['imgfile']['name']), -30 ) : '');
		$x = strtolower(substr($filename, -4));
		if ($x == '.php' || $x == '.cgi'){
			$filename = substr($filename, -26).'.txt';
		}
		if ($filename){
			$newname = $att_path."x".$pid."_".$filename;
			copy($_FILES['imgfile']['tmp_name'], $newname);
		}
		echo "Your site has been successfully added<br>";
	}else{
		if($_REQUEST['edit']){
			$qr1 = mysql_query("SELECT * FROM epay_shops WHERE id={$_REQUEST['edit']}");
			$row = mysql_fetch_object($qr1);
			$_POST['name'] = $row->name;
			$_POST['url'] = $row->url;
			$_POST['area'] = $row->area;
			$_POST['comment'] = $row->comment;
		}
?>   		
    			<table width="100%" border="0" cellspacing="0" cellpadding="3">
        		<tr>
          			<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Submit Your Site</b></font></td>
        		</tr>
        		<tr>
        			<td bgcolor="#000000" height=1></td>
        		</tr>
        		<tr>
        			<td>
						<FORM method=post enctype='multipart/form-data'>
<?						if($_REQUEST['edit']){	?>
							<input type="hidden" name="edit" value="<?=$_REQUEST['edit']?>">
<?						}	?>
						<table width="100%" border="0" cellspacing="10" cellpadding="0">
						<tr>
							<td width="20%" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Category</font></td>
							<td width="80%">
								<select name="area">
<?
									reset($aenum_areas);
									reset($enum_areas);
									while ($a = each($aenum_areas)){
										echo "<option value=$a[0]",($_POST['area'] == $a[0] ? ' selected' : ''),"> $a[1]";
									}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Url</font></td>
							<td><input name="url" type="text" size="60" maxlength="130" value="<?=$_POST['url']?>"></td>
						</tr>
						<tr>
							<td height="24" align="center"><font size="2" face="Arial, Helvetica, sans-serif">Title</font></td>
							<td><input name="name" type="text" size="60" value="<?=$_POST['name']?>"></td>
						</tr>
						<tr> 
							<td align="center" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Description</td>
							<td>
								<textarea name="comment" cols="60" rows="8"><?=$_POST['comment']?></textarea>
							</td>
						</tr>
						<tr> 
							<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">Image</td>
							<td><input name="imgfile" type="file" size="45"></td>
						</tr>
						<tr>
							<td align="center"> </td>
							<td> </td>
						</tr>
						<tr>
							<td align="center"> </td>
							<td><input name="create" type="submit" id="create" value="Submit Site"></td>
						</tr>
						</table>
						</form>
					</td>
				</tr>
				</table>
<?	}	?>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>

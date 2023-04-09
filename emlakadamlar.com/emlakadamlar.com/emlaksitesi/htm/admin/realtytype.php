<?
	if($_POST[btnTypePost]){
		$intTypeId   = $_POST[txtTypeId];
		$strTypeName = $_POST[txtTypeName];
		$intOk=1;
		if(strlen($strTypeName)<2){
			$intOk=0;}
		if($intOk==1){
			if($intTypeId=='new'){//insert
				$strQuery = "INSERT INTO tblType(type_name) VALUES('$strTypeName')";
				$res = mysql_query($strQuery);
				showMessage("Ekleme yapildi");
				goTo("index.php?module=realtytype");
				showMessage($strQuery);
			}else{//update
				$strQuery = "UPDATE tblType SET type_name='$strTypeName' WHERE type_id='$intTypeId'";
				$res = mysql_query($strQuery);
				showMessage("Düzeltme yapildi");
				goTo("index.php?module=realtytype");
				showMessage($strQuery);
			}
		}else{
			showMessage("Lütfen eksik alanlari doldurun");
		}
	}
	if ($_GET["act"] == "delete")
	{//delete
		$intTypeId = $_GET[typeid];
		$res = mysql_query("DELETE FROM tblType WHERE type_id='$intTypeId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=realtytype");
	}
	elseif (($_GET["act"] == "insert")or($_GET["act"] == "edit"))
	{//insert-edit
	$res = mysql_query("SELECT * FROM tblType WHERE type_id='$_GET[typeid]'");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
		$intTypeId   = mysql_result($res,0,"type_id");
		$strTypeName = mysql_result($res,0,"type_name");
		$strCaption  = $strTypeName." düzenle";
	}else{
		$intTypeId = "new";
		$strCaption  = "Yeni Emlak Tipi";
	}
?>
<table border="0" cellpadding="3" cellspacing="3" width="400" align="center">
<form name="formRealty" method="post">
<input type="hidden" name="txtTypeId" value="<?=$intTypeId?>">
	<tr>
		<td colspan="4" align="center" class="TabloBaslik"><?=$strCaption?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Adi : </b></td>
		<td align="left" width="70%"><input type="text" name="txtTypeName" value="<?=$strTypeName?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" nowrap>
			<input type="button" value="Vazgeç" onClick="javascript:history.back();">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Kaydet" name="btnTypePost">
		</td>
	</tr>
</form>
</table>
<?	
	}
	else
	{//list
?>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
	<tr>
		<td colspan="15" align="center" class="TabloBaslik">Emlak Tipleri</td>
	</tr>
	<tr>
		<td colspan="15"><a href="index.php?module=realtytype&act=insert&realtytypeid=new" <?=$SecSatir1?>>[Yeni Emlak Tipi]</a></td>
	</tr>
	<tr>
		<td align="center" width="1"><b>No</b></td>
		<td align="left" width="99%"><b>Adi</b></td>
		<td align="center" width="1"><b>Düzenle</b></td>
		<td align="center" width="1"><b>Sil</b></td>
	</tr>
<?
	$res = mysql_query("SELECT * FROM tblType WHERE 1=1 ORDER BY type_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intTypeId   = mysql_result($res,$f,"type_id");
			$strTypeName = mysql_result($res,$f,"type_name");

			if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
	<tr <?=$RowStr?>>
		<td><?=$f+1?></td>
		<td ><?=$strTypeName?></td>
		<td <?=$DuzSatir1?>><a href="index.php?module=realtytype&act=edit&typeid=<?=$intTypeId?>">Düzenle</a></td>
		<td <?=$DuzSatir1?>><a href="javascript:if(confirm('<?=$strTypeName?> silmek istiyormusunuz?')){location.href='index.php?module=realtytype&act=delete&typeid=<?=$intTypeId?>';}">Sil</a></td>
	</tr>
<?
		}
	}
?>
</table>
<?}?>
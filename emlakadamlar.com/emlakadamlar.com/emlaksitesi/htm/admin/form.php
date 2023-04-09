<?
	if ($_GET["act"] == "delete")
	{//delete
		$intId = $_GET[formid];
		$res = mysql_query("DELETE FROM tblForm WHERE form_id='$intId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=form");
	}
?>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
	<tr>
		<td colspan="15" align="center" class="TabloBaslik">Form Gelenler</td>
	</tr>
	<tr>
		<td align="center" width="1"><b>No</b></td>
		<td align="left" width="5%"><b>Tarih</b></td>
		<td align="left" width="90%"><b>Form</b></td>
		<td align="center" width="1"><b>Sil</b></td>
	</tr>
<?
	$res = mysql_query("SELECT * FROM tblForm WHERE 1=1 ORDER BY form_id DESC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intId   = mysql_result($res,$f,"form_id");
			$strDate = mysql_result($res,$f,"form_date");
			$strText = mysql_result($res,$f,"form_text");

			if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
	<tr <?=$RowStr?>>
		<td><?=$f+1?></td>
		<td ><?=$strDate?></td>
		<td ><?=$strText?></td>
		<td <?=$DuzSatir1?>><a href="javascript:if(confirm('Silmek istiyormusunuz?')){location.href='index.php?module=form&act=delete&formid=<?=$intId?>';}">Sil</a></td>
	</tr>
<?
		}
	}
?>
</table>

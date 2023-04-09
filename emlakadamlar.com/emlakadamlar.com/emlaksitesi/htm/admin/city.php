<?
	if($_POST[btnQuarterPost]){
		$intCityId      = $_POST[txtCityId];
		$intDistrictId  = $_POST[txtDistrictId];
		$intQuarterId   = $_POST[txtQuarterId];
		$strQuarterName = $_POST[txtQuarterName];
		if(strlen($strQuarterName)>0){
			if($intQuarterId=='new'){//insert
				$res = mysql_query("INSERT INTO tblQuarter(quarter_city,quarter_district,quarter_name) VALUES('$intCityId','$intDistrictId','$strQuarterName')");
				showMessage("Ekleme yapildi");
				goTo("index.php?module=city&act=list&cityid=$intCityId&districtid=$intDistrictId");
			}else{//update
				$res = mysql_query("UPDATE tblQuarter SET quarter_name='$strQuarterName' WHERE quarter_id='$intQuarterId'");
				showMessage("Düzeltme yapildi");
				goTo("index.php?module=city&act=list&cityid=$intCityId&districtid=$intDistrictId");
			}
		}else{
			showMessage("Lütfen mahalle adi yazin.");
		}
	}
	if($_POST[btnDistrictPost]){
		$intCityId       = $_POST[txtCityId];
		$intDistrictId   = $_POST[txtDistrictId];
		$strDistrictName = $_POST[txtDistrictName];
		if(strlen($strDistrictName)>0){
			if($intDistrictId=='new'){//insert
				$res = mysql_query("INSERT INTO tblDistrict(district_city,district_name) VALUES('$intCityId','$strDistrictName')");
				showMessage("Ekleme yapildi");
				goTo("index.php?module=city&act=list&cityid=$intCityId");
			}else{//update
				$res = mysql_query("UPDATE tblDistrict SET district_name='$strDistrictName' WHERE district_id='$intDistrictId'");
				showMessage("Düzeltme yapildi");
				goTo("index.php?module=city&act=list&cityid=$intCityId");
			}
		}else{
			showMessage("Lütfen ilçe adi yazin.");
		}
	}
	if($_POST[btnCityPost]){
		$intCityId   = $_POST[txtCityId];
		$strCityName = $_POST[txtCityName];
		if(strlen($strCityName)>0){
			if($intCityId=='new'){//insert
				$res = mysql_query("INSERT INTO tblCity(city_name) VALUES('$strCityName')");
				showMessage("Ekleme yapildi");
				goTo("index.php?module=city");
			}else{//update
				$res = mysql_query("UPDATE tblCity SET city_name='$strCityName' WHERE city_id='$intCityId'");
				showMessage("Düzeltme yapildi");
				goTo("index.php?module=city");
			}
		}else{
			showMessage("Lütfen sehir adi yazin.");
		}
	}
	if ($_GET["act"] == "quarterdelete")
	{//quarter-delete
		$intQuarterId  = $_GET[quarterid];
		$intCityId     = getQuarterCityId($intQuarterId);
		$intDistrictId = getQuarterDistrictId($intQuarterId);
		$res = mysql_query("DELETE FROM tblQuarter WHERE quarter_id='$intQuarterId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=city&act=list&cityid=$intCityId&districtid=$intDistrictId");
	}
	if ($_GET["act"] == "districtdelete")
	{//district-delete
		$intCityId     = $_GET[cityid];
		$intDistrictId = $_GET[districtid];
		$res = mysql_query("DELETE FROM tblDistrict WHERE district_id='$intDistrictId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=city&act=list&cityid=$intCityId");
	}
	if ($_GET["act"] == "citydelete")
	{//city-delete
		$intCityId = $_GET[cityid];
		$res = mysql_query("DELETE FROM tblCity WHERE city_id='$intCityId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=city");
	}
	elseif (($_GET["act"] == "cityinsert")or($_GET["act"] == "cityedit"))
	{//city insert-edit
	$res = mysql_query("SELECT * FROM tblCity WHERE city_id='$_GET[cityid]'");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
		$intCityId   = mysql_result($res,0,"city_id");
		$strCityName = mysql_result($res,0,"city_name");
		$strCaption  = $strCityName." düzenle";
	}else{
		$intCityId   = "new";
		$strCityName = "";
		$strCaption  = "Yeni Sehir";
	}
?>
<table border="0" cellpadding="3" cellspacing="3" width="400" align="center">
<form action="" method="post">
<input type="hidden" name="txtCityId" value="<?=$intCityId?>">
	<tr>
		<td colspan="4" align="center" class="TabloBaslik"><?=$strCaption?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Il Adi</b></td>
		<td align="left" width="70%"><input type="text" name="txtCityName" value="<?=$strCityName?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" nowrap>
			<input type="button" value="Vazgeç" onClick="javascript:history.back();">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Kaydet" name="btnCityPost">
		</td>
	</tr>
</form>
</table>
<?	
	}
	elseif (($_GET["act"] == "districtinsert")or($_GET["act"] == "districtedit"))
	{//district insert-edit
	$res = mysql_query("SELECT * FROM tblDistrict WHERE district_id='$_GET[districtid]'");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
		$intCityId       = mysql_result($res,0,"district_city");
		$intDistrictId   = mysql_result($res,0,"district_id");
		$strDistrictName = mysql_result($res,0,"district_name");
		$strCaption      = $strDistrictName." düzenle";
	}else{
		$intCityId       = $_GET[cityid];
		$intDistrictId   = "new";
		$strDistrictName = "";
		$strCaption      = "Yeni Ilçe";
	}
?>
<table border="0" cellpadding="3" cellspacing="3" width="400" align="center">
<form action="" method="post">
<input type="hidden" name="txtCityId" value="<?=$intCityId?>">
<input type="hidden" name="txtDistrictId" value="<?=$intDistrictId?>">
	<tr>
		<td colspan="4" align="center" class="TabloBaslik"><?=$strCaption?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Ilçe Adi</b></td>
		<td align="left" width="70%"><input type="text" name="txtDistrictName" value="<?=$strDistrictName?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" nowrap>
			<input type="button" value="Vazgeç" onClick="javascript:history.back();">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Kaydet" name="btnDistrictPost">
		</td>
	</tr>
</form>
</table>
<?	
	}
	elseif (($_GET["act"] == "quarterinsert")or($_GET["act"] == "quarteredit"))
	{//district insert-edit
	$res = mysql_query("SELECT * FROM tblQuarter WHERE quarter_id='$_GET[quarterid]'");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
		$intCityId      = mysql_result($res,0,"quarter_city");
		$intDistrictId  = mysql_result($res,0,"quarter_district");
		$intQuarterId   = mysql_result($res,0,"quarter_id");
		$strQuarterName = mysql_result($res,0,"quarter_name");
		$strCaption     = $strQuarterName." düzenle";
	}else{
		$intCityId      = $_GET[cityid];
		$intDistrictId  = $_GET[districtid];
		$intQuarterId   = "new";
		$strQuarterName = "";
		$strCaption     = "Yeni Mahalle";
	}
?>
<table border="0" cellpadding="3" cellspacing="3" width="400" align="center">
<form action="" method="post">
<input type="hidden" name="txtCityId" value="<?=$intCityId?>">
<input type="hidden" name="txtDistrictId" value="<?=$intDistrictId?>">
<input type="hidden" name="txtQuarterId" value="<?=$intQuarterId?>">
	<tr>
		<td colspan="4" align="center" class="TabloBaslik"><?=$strCaption?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Mahalle Adi</b></td>
		<td align="left" width="70%"><input type="text" name="txtQuarterName" value="<?=$strQuarterName?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" nowrap>
			<input type="button" value="Vazgeç" onClick="javascript:history.back();">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Kaydet" name="btnQuarterPost">
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
		<td colspan="4" align="center" class="TabloBaslik">Sehirler</td>
	</tr>
	<tr>
		<td colspan="4"><a href="index.php?module=city&act=cityinsert&cityid=new" <?=$SecSatir1?>>[Yeni Il]</a></td>
	</tr>
	<tr>
		<td align="center" width="1"><b>No</b></td>
		<td align="left" width="99%"><b>Il</b></td>
		<td align="center" width="1"><b>Düzenle</b></td>
		<td align="center" width="1"><b>Sil</b></td>
	</tr>
<?
	$res = mysql_query("SELECT * FROM tblCity WHERE 1=1 ORDER BY city_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intCityId     = mysql_result($res,$f,"city_id");
			$strCityName   = mysql_result($res,$f,"city_name");

			if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
	<tr <?=$RowStr?>>
		<td><?=$f+1?></td>
		<td onClick="javascript:location.href='index.php?module=city&act=list<?if($_GET[cityid]!=$intCityId){?>&cityid=<?=$intCityId?><?}?>';"><?=$strCityName?></td>
		<td <?=$DuzSatir1?>><a href="index.php?module=city&act=cityedit&cityid=<?=$intCityId?>">Düzenle</a></td>
		<td <?=$DuzSatir1?>><a href="javascript:if(confirm('<?=$strCityName?> sehirini silmek istiyormusunuz?')){location.href='index.php?module=city&act=citydelete&cityid=<?=$intCityId?>';}">Sil</a></td>
	</tr>
<!--Ilceler------------------------------>	
<?if($intCityId==$_GET[cityid]){?>
	<tr>
		<td colspan="4" align="center">
			<table border="0" cellpadding="0" cellspacing="1" width="90%" align="center">
				<tr>
					<td colspan="4" align="center" class="TabloBaslik">Ilçeler</td>
				</tr>
				<tr>
					<td colspan="4"><a href="index.php?module=city&act=districtinsert&cityid=<?=$intCityId?>&districtid=new" <?=$SecSatir1?>>[Yeni Ilçe]</a></td>
				</tr>
				<tr>
					<td align="center" width="1"><b>No</b></td>
					<td align="left" width="99%"><b>Ilçe</b></td>
					<td align="center" width="1"><b>Düzenle</b></td>
					<td align="center" width="1"><b>Sil</b></td>
				</tr>
<?
				$res2 = mysql_query("SELECT * FROM tblDistrict WHERE district_city='$intCityId' ORDER BY district_name ASC");
				$rows2 = mysql_num_rows($res2);
				$rowselect2=1;
				if ($rows2) {
					for ($f2=0 ; $f2<$rows2 ; $f2++) {
						$intDistrictId   = mysql_result($res2,$f2,"district_id");
						$strDistrictName = mysql_result($res2,$f2,"district_name");
			
						if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
				<tr <?=$RowStr?>>
					<td><?=$f2+1?></td>
					<td onClick="javascript:location.href='index.php?module=city&act=list&cityid=<?=$intCityId?><?if($_GET[districtid]!=$intDistrictId){?>&districtid=<?=$intDistrictId?><?}?>';"><?=$strDistrictName?></td>
					<td <?=$DuzSatir1?>><a href="index.php?module=city&act=districtedit&districtid=<?=$intDistrictId?>">Düzenle</a></td>
					<td <?=$DuzSatir1?>><a href="javascript:if(confirm('<?=$strDistrictName?> ilçesini silmek istiyormusunuz?')){location.href='index.php?module=city&act=districtdelete&districtid=<?=$intDistrictId?>';}">Sil</a></td>
				</tr>
<!--Mahalleler------------------------------>	
<?if($intDistrictId==$_GET[districtid]){?>
				<tr>
					<td colspan="4" align="center">
						<table border="0" cellpadding="0" cellspacing="1" width="90%" align="center">
							<tr>
								<td colspan="4" align="center" class="TabloBaslik">Mahalleler</td>
							</tr>
							<tr>
								<td colspan="4"><a href="index.php?module=city&act=quarterinsert&cityid=<?=$intCityId?>&districtid=<?=$intDistrictId?>&quarterid=new" <?=$SecSatir1?>>[Yeni Mahalle]</a></td>
							</tr>
							<tr>
								<td align="center" width="1"><b>No</b></td>
								<td align="left" width="99%"><b>Mahalle</b></td>
								<td align="center" width="1"><b>Düzenle</b></td>
								<td align="center" width="1"><b>Sil</b></td>
							</tr>
<?
							$res3 = mysql_query("SELECT * FROM tblQuarter WHERE quarter_district='$intDistrictId' ORDER BY quarter_name ASC");
							$rows3 = mysql_num_rows($res3);
							$rowselect3=1;
							if ($rows3) {
								for ($f3=0 ; $f3<$rows3 ; $f3++) {
									$intQuarterId   = mysql_result($res3,$f3,"quarter_id");
									$strQuarterName = mysql_result($res3,$f3,"quarter_name");
						
									if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
							<tr <?=$RowStr?>>
								<td><?=$f3+1?></td>
								<td ><?=$strQuarterName?></td>
								<td <?=$DuzSatir1?>><a href="index.php?module=city&act=quarteredit&quarterid=<?=$intQuarterId?>">Düzenle</a></td>
								<td <?=$DuzSatir1?>><a href="javascript:if(confirm('<?=$strQuarterName?> mahallesini silmek istiyormusunuz?')){location.href='index.php?module=city&act=quarterdelete&quarterid=<?=$intQuarterId?>';}">Sil</a></td>
							</tr>
<?
								}
							}
?>
						</table>
					</td>
				</tr>
<?}?>
<!--Mahalleler------------------------------>	
<?
					}
				}
?>
			</table>
		</td>
	</tr>
<?}?>
<!--Ilceler------------------------------>	
<?
		}
	}
?>
</table>
<?	}
?>
<?
	if($_POST[btnInsertPicture]){
		$intRealtyId = $_GET[realtyid];
		$strFileName = time();
		$strFileName .= "1.jpg";	
		if(is_file($_FILES[txtFile1][tmp_name])){
			if(copy($_FILES[txtFile1][tmp_name],'../images/realty/'.$strFileName)){
					$strQuery="INSERT INTO tblRealtyPhoto(realtyphoto_realty,realtyphoto_file)".
						"values('$intRealtyId','" . $strFileName . "')";
					mysql_query($strQuery);
					showMessage("Islem tamamlandi.");
				//print($strQuery);
			}else showMessage("Hedef dizine yazma izniniz yok!");
		}
		$strFileName = time();
		$strFileName .= "2.jpg";	
		if(is_file($_FILES[txtFile2][tmp_name])){
			if(copy($_FILES[txtFile2][tmp_name],'../images/realty/'.$strFileName)){
					$strQuery="INSERT INTO tblRealtyPhoto(realtyphoto_realty,realtyphoto_file)".
						"values('$intRealtyId','" . $strFileName . "')";
					mysql_query($strQuery);
				//print($strQuery);
			}else showMessage("Hedef dizine yazma izniniz yok!");
		}
		$strFileName = time();
		$strFileName .= "3.jpg";	
		if(is_file($_FILES[txtFile3][tmp_name])){
			if(copy($_FILES[txtFile3][tmp_name],'../images/realty/'.$strFileName)){
					$strQuery="INSERT INTO tblRealtyPhoto(realtyphoto_realty,realtyphoto_file)".
						"values('$intRealtyId','" . $strFileName . "')";
					mysql_query($strQuery);
				//print($strQuery);
			}else showMessage("Hedef dizine yazma izniniz yok!");
		}
		goTo('index.php?module=realty&act=picture&realtyid='.$intRealtyId);exit;
	}
	
	if($_POST[btnRealtyPost]){
		$intRealtyId              = $_POST[txtRealtyId];
		$strRealtyCode            = $_POST[txtRealtyCode];
		$strRealtyName 			  = $_POST[txtRealtyName];
		$strRealtyDetail          = $_POST[txtRealtyDetail];
		$intRealtyIsRental        = $_POST[txtRealtyIsRental];
		$intRealtyRentalPrice     = $_POST[txtRealtyRentalPrice];
		$intRealtyRentalPriceType = $_POST[txtRealtyRentalPriceType];
		$intRealtyIsSale          = $_POST[txtRealtyIsSale];
		$intRealtySalePrice       = $_POST[txtRealtySalePrice];
		$intRealtySalePriceType   = $_POST[txtRealtySalePriceType];
		$intRealtyCity            = $_POST[txtRealtyCity];
		$intRealtyDistrict        = $_POST[txtRealtyDistrict];
		$intRealtyQuarter         = $_POST[txtRealtyQuarter];
		$intRealtyType            = $_POST[txtRealtyType];
		$strRealtyPerson          = $_POST[txtRealtyPerson];
		$strRealtyRoom            = $_POST[txtRealtyRoom];
		$strRealtyPersonPhone     = $_POST[txtRealtyPersonPhone];
		$strRealtyDate            = getDates();
		$intOk=1;
		if(strlen($strRealtyName)<2){
			$intOk=0;}
		if($intOk==1){
			if($intRealtyId=='new'){//insert
				$strRealtyCode = getUniqCode();
				$strUser       = getUser();
				$strQuery = "INSERT INTO tblRealty(realty_code,realty_name,realty_detail,realty_isrental,realty_issale,realty_rentalprice,realty_rentalpricetype,realty_saleprice,realty_salepricetype,realty_city,realty_district,realty_quarter,realty_type,realty_room,realty_date,realty_user,realty_person,realty_personphone) ".
					"VALUES('$strRealtyCode','$strRealtyName','$strRealtyDetail','$intRealtyIsRental','$intRealtyIsSale','$intRealtyRentalPrice','$intRealtyRentalPriceType','$intRealtySalePrice','$intRealtySalePriceType','$intRealtyCity','$intRealtyDistrict','$intRealtyQuarter','$intRealtyType','$strRealtyRoom','$strRealtyDate','$strUser','$strRealtyPerson','$strRealtyPersonPhone')";
				$res = mysql_query($strQuery);
				showMessage("Ekleme yapildi");
				goTo("index.php?module=realty");
				showMessage($strQuery);
			}else{//update
				$strQuery = "UPDATE tblRealty SET realty_name='$strRealtyName',realty_detail='$strRealtyDetail',realty_isrental='$intRealtyIsRental',realty_issale='$intRealtyIsSale',realty_rentalprice='$intRealtyRentalPrice',realty_rentalpricetype='$intRealtyRentalPriceType',realty_saleprice='$intRealtySalePrice',realty_salepricetype='$intRealtySalePriceType',realty_city='$intRealtyCity',realty_district='$intRealtyDistrict',realty_quarter='$intRealtyQuarter',realty_type='$intRealtyType',realty_room='$strRealtyRoom',realty_person='$strRealtyPerson',realty_personphone='$strRealtyPersonPhone' WHERE realty_id='$intRealtyId'";
				$res = mysql_query($strQuery);
				showMessage("Düzeltme yapildi");
				goTo("index.php?module=realty");
				showMessage($strQuery);
			}
		}else{
			showMessage("Lütfen eksik alanlari doldurun yada seçin");
		}
	}
	if ($_GET["act"] == "delete")
	{//delete
		$intRealtyId = $_GET[realtyid];
		$res = mysql_query("DELETE FROM tblRealty WHERE realty_id='$intRealtyId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=realty");
	}
	elseif ($_GET["act"] == "photodelete")
	{//delete
		$intRealtyId = $_GET[realtyid];
		$intPhotoId  = $_GET[photoid];

		$res = mysql_query("SELECT * FROM tblRealtyPhoto WHERE realtyphoto_id='$intPhotoId'");
		$rows = mysql_num_rows($res);
		if ($rows) {
			$strFile = mysql_result($res,$f,"realtyphoto_file");
			unlink('../images/realty/'.$strFile);
		}
	
		$res = mysql_query("DELETE FROM tblRealtyPhoto WHERE realtyphoto_id='$intPhotoId'");
		showMessage("Silme yapildi");
		goTo("index.php?module=realty&act=picture&realtyid=$intRealtyId");
	}
	elseif (($_GET["act"] == "insert")or($_GET["act"] == "edit"))
	{//insert-edit
	$res = mysql_query("SELECT * FROM tblRealty WHERE realty_id='$_GET[realtyid]'");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
		$intRealtyId              = mysql_result($res,$f,"realty_id");
		$strRealtyCode            = mysql_result($res,$f,"realty_code");
		$strRealtyName            = mysql_result($res,$f,"realty_name");
		$strRealtyDetail          = mysql_result($res,$f,"realty_detail");
		$intRealtyIsRental        = mysql_result($res,$f,"realty_isrental");
		$intRealtyRentalPrice     = mysql_result($res,$f,"realty_rentalprice");
		$intRealtyRentalPriceType = mysql_result($res,$f,"realty_rentalpricetype");
		$intRealtyIsSale          = mysql_result($res,$f,"realty_issale");
		$intRealtySalePrice       = mysql_result($res,$f,"realty_saleprice");
		$intRealtySalePriceType   = mysql_result($res,$f,"realty_salepricetype");
		$intRealtyCity            = mysql_result($res,$f,"realty_city");
		$intRealtyDistrict        = mysql_result($res,$f,"realty_district");
		$intRealtyQuarter         = mysql_result($res,$f,"realty_quarter");
		$intRealtyType            = mysql_result($res,$f,"realty_type");
		$strRealtyRoom            = mysql_result($res,$f,"realty_room");
		$intRealtyDate            = mysql_result($res,$f,"realty_date");
		$strRealtyPerson          = mysql_result($res,$f,"realty_person");
		$strRealtyPersonPhone     = mysql_result($res,$f,"realty_personphone");
		
		$strRealtyRentalPrice     = number_format($intRealtyRentalPrice, 2 , ',' , '.')." ".getPriceTypeName($intRealtyRentalPriceType);
		$strRealtySalePrice       = number_format($intRealtySalePrice, 2 , ',' , '.')." ".getPriceTypeName($intRealtySalePriceType);
		$strRealtyCity            = getCityName($intRealtyCity);
		$strRealtyDistrict        = getDistrictName($intRealtyDistrict);
		$strRealtyQuarter         = getQuarterName($intRealtyQuarter);
		$strRealtyType            = getTypeName($intRealtyType);
		$strRealtyDate            = $intRealtyDate;

		$strCaption  = $strRealtyName." düzenle";
	}else{
		$intRealtyId = "new";
		$strCaption  = "Yeni Emlak";
	}
	if($_POST[txtRealtyId]){
		$intRealtyId=$_POST[txtRealtyId];}
	if($_POST[txtRealtyCode]){
		$strRealtyCode=$_POST[txtRealtyCode];}
	if($_POST[txtRealtyName]){
		$strRealtyName=$_POST[txtRealtyName];}
	if($_POST[txtRealtyIsRental]){
		$intRealtyIsRental=$_POST[txtRealtyIsRental];}
	if($_POST[txtRealtyRentalPrice]){
		$intRealtyRentalPrice=$_POST[txtRealtyRentalPrice];}
	if($_POST[txtRealtyRentalPriceType]){
		$intRealtyRentalPriceType=$_POST[txtRealtyRentalPriceType];}
	if($_POST[txtRealtyIsSale]){
		$intRealtyIsSale=$_POST[txtRealtyIsSale];}
	if($_POST[txtRealtySalePrice]){
		$intRealtySalePrice=$_POST[txtRealtySalePrice];}
	if($_POST[txtRealtySalePriceType]){
		$intRealtySalePriceType=$_POST[txtRealtySalePriceType];}
	if($_POST[txtRealtyCity]){
		$intRealtyCity=$_POST[txtRealtyCity];}
	if($_POST[txtRealtyDistrict]){
		$intRealtyDistrict=$_POST[txtRealtyDistrict];}
	if($_POST[txtRealtyQuarter]){
		$intRealtyQuarter=$_POST[txtRealtyQuarter];}
	if($_POST[txtRealtyType]){
		$intRealtyType=$_POST[txtRealtyType];}
	if($_POST[txtRealtyRoom]){
		$strRealtyRoom=$_POST[txtRealtyRoom];}
	if($_POST[txtRealtyDetail]){
		$strRealtyDetail=$_POST[txtRealtyDetail];}
?>
<table border="0" cellpadding="3" cellspacing="3" width="400" align="center">
<form name="formRealty" method="post">
<input type="hidden" name="txtRealtyId" value="<?=$intRealtyId?>">
	<tr>
		<td colspan="4" align="center" class="TabloBaslik"><?=$strCaption?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Adi : </b></td>
		<td align="left" width="70%"><input type="text" name="txtRealtyName" value="<?=$strRealtyName?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Kod : </b></td>
		<td align="left" width="70%"><?=$strRealtyCode?></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Kiralik : </b></td>
		<td align="left" width="70%">
			<input type="checkbox" name="txtRealtyIsRental" value="1"<?if($intRealtyIsRental==1){?> checked<?}?>>
			<input type="text" name="txtRealtyRentalPrice" value="<?=$intRealtyRentalPrice?>" maxlength="30" style="width:150;">
			<select name="txtRealtyRentalPriceType">
<?
	$res = mysql_query("SELECT * FROM tblPriceType WHERE 1=1 ORDER BY pricetype_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intPriceId   = mysql_result($res,$f,"pricetype_id");
			$strPriceName = mysql_result($res,$f,"pricetype_name");
?>
				<option value="<?=$intPriceId?>"<?if($intPriceId==$intRealtyRentalPriceType){?> selected<?}?>><?=$strPriceName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Satilik : </b></td>
		<td align="left" width="70%">
			<input type="checkbox" name="txtRealtyIsSale" value="1"<?if($intRealtyIsSale==1){?> checked<?}?>>
			<input type="text" name="txtRealtySalePrice" value="<?=$intRealtySalePrice?>" maxlength="30" style="width:150;">
			<select name="txtRealtySalePriceType">
<?
	$res = mysql_query("SELECT * FROM tblPriceType WHERE 1=1 ORDER BY pricetype_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intPriceId   = mysql_result($res,$f,"pricetype_id");
			$strPriceName = mysql_result($res,$f,"pricetype_name");
?>
				<option value="<?=$intPriceId?>"<?if($intPriceId==$intRealtySalePriceType){?> selected<?}?>><?=$strPriceName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Sehir : </b></td>
		<td align="left" width="70%">
			<select name="txtRealtyCity" style="width:250;" onChange="document.formRealty.submit();">
				<option value="0">Seçin</option>
<?
	$res = mysql_query("SELECT * FROM tblCity WHERE 1=1 ORDER BY city_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intCityId   = mysql_result($res,$f,"city_id");
			$strCityName = mysql_result($res,$f,"city_name");
?>
				<option value="<?=$intCityId?>"<?if($intCityId==$intRealtyCity){?> selected<?}?>><?=$strCityName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Ilçe : </b></td>
		<td align="left" width="70%">
			<select name="txtRealtyDistrict" style="width:250;" onChange="document.formRealty.submit();">
				<option value="0">Seçin</option>
<?
	$res = mysql_query("SELECT * FROM tblDistrict WHERE district_city='$intRealtyCity' ORDER BY district_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intDistrictId   = mysql_result($res,$f,"district_id");
			$strDistrictName = mysql_result($res,$f,"district_name");
?>
				<option value="<?=$intDistrictId?>"<?if($intDistrictId==$intRealtyDistrict){?> selected<?}?>><?=$strDistrictName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Mahalle : </b></td>
		<td align="left" width="70%">
			<select name="txtRealtyQuarter" style="width:250;" onChange="document.formRealty.submit();">
				<option value="0">Seçin</option>
<?
	$res = mysql_query("SELECT * FROM tblQuarter WHERE quarter_city='$intRealtyCity' and quarter_district='$intRealtyDistrict' ORDER BY quarter_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intQuarterId   = mysql_result($res,$f,"quarter_id");
			$strQuarterName = mysql_result($res,$f,"quarter_name");
?>
				<option value="<?=$intQuarterId?>"<?if($intQuarterId==$intRealtyQuarter){?> selected<?}?>><?=$strQuarterName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Tipi : </b></td>
		<td align="left" width="70%">
			<select name="txtRealtyType" style="width:250;">
<?
	$res = mysql_query("SELECT * FROM tblType WHERE 1=1 ORDER BY type_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intTypeId   = mysql_result($res,$f,"type_id");
			$strTypeName = mysql_result($res,$f,"type_name");
?>
				<option value="<?=$intTypeId?>"<?if($intTypeId==$intRealtyType){?> selected<?}?>><?=$strTypeName?></option>
<?
		}
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Oda Sayisi : </b></td>
		<td align="left" width="70%"><input type="text" name="txtRealtyRoom" value="<?=$strRealtyRoom?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Detay : </b></td>
		<td align="left" width="70%"><textarea name="txtRealtyDetail" style="width:250;height:70;"><?=$strRealtyDetail?></textarea></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Ilgili : </b></td>
		<td align="left" width="70%"><input type="text" name="txtRealtyPerson" value="<?=$strRealtyPerson?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="right" width="30%"><b>Ilgili Telefon : </b></td>
		<td align="left" width="70%"><input type="text" name="txtRealtyPersonPhone" value="<?=$strRealtyPersonPhone?>" maxlength="30" style="width:250;"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" nowrap>
			<input type="button" value="Vazgeç" onClick="javascript:history.back();">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Kaydet" name="btnRealtyPost">
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
		<td colspan="15" align="center" class="TabloBaslik">Emlaklar</td>
	</tr>
	<tr>
		<td colspan="15"><a href="index.php?module=realty&act=insert&realtyid=new" <?=$SecSatir1?>>[Yeni Emlak]</a></td>
	</tr>
	<tr>
		<td align="center" width="1"><b>No</b></td>
		<td align="left" xwidth="99%"><b>Adi</b></td>
		<td align="left" xwidth="99%"><b>Kodu</b></td>
		<td align="left" xwidth="99%"><b>Tarih</b></td>
		<td align="left" xwidth="99%"><b>Kir.</b></td>
		<td align="left" xwidth="99%"><b>Kir.Fiyat</b></td>
		<td align="left" xwidth="99%"><b>Sat.</b></td>
		<td align="left" xwidth="99%"><b>Sat.Fiyat</b></td>
		<td align="left" xwidth="99%"><b>Sehir</b></td>
		<td align="left" xwidth="99%"><b>Ilçe</b></td>
		<td align="left" xwidth="99%"><b>Mahalle</b></td>
		<td align="left" xwidth="99%"><b>Tipi</b></td>
		<td align="left" xwidth="99%"><b>Oda Say.</b></td>
		<td align="left" xwidth="99%"><b>Detay</b></td>
		<td align="left" xwidth="99%"><b>Kullancý</b></td>
		<td align="left" xwidth="99%"><b>Ilgili</b></td>
		<td align="left" xwidth="99%"><b>Ilg.Telefon</b></td>
		<td align="center" width="1"><b>Resim</b></td>
		<td align="center" width="1"><b>Düzenle</b></td>
		<td align="center" width="1"><b>Sil</b></td>
	</tr>
<?
	$res = mysql_query("SELECT * FROM tblRealty WHERE 1=1 ORDER BY realty_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intRealtyId              = mysql_result($res,$f,"realty_id");
			$strRealtyName            = mysql_result($res,$f,"realty_name");
			$strRealtyCode            = mysql_result($res,$f,"realty_code");
			$strRealtyDetail          = mysql_result($res,$f,"realty_detail");
			$intRealtyIsRental        = mysql_result($res,$f,"realty_isrental");
			$intRealtyRentalPrice     = mysql_result($res,$f,"realty_rentalprice");
			$intRealtyRentalPriceType = mysql_result($res,$f,"realty_rentalpricetype");
			$intRealtyIsSale          = mysql_result($res,$f,"realty_issale");
			$intRealtySalePrice       = mysql_result($res,$f,"realty_saleprice");
			$intRealtySalePriceType   = mysql_result($res,$f,"realty_salepricetype");
			$intRealtyCity            = mysql_result($res,$f,"realty_city");
			$intRealtyDistrict        = mysql_result($res,$f,"realty_district");
			$intRealtyQuarter         = mysql_result($res,$f,"realty_quarter");
			$intRealtyType            = mysql_result($res,$f,"realty_type");
			$strRealtyRoom            = mysql_result($res,$f,"realty_room");
			$intRealtyDate            = mysql_result($res,$f,"realty_date");
			$strRealtyUser            = mysql_result($res,$f,"realty_user");
			$strRealtyPerson          = mysql_result($res,$f,"realty_person");
			$strRealtyPersonPhone     = mysql_result($res,$f,"realty_personphone");
			
			$strRealtyRentalPrice     = number_format($intRealtyRentalPrice, 0 , ',' , '.')." ".getPriceTypeName($intRealtyRentalPriceType);
			$strRealtySalePrice       = number_format($intRealtySalePrice, 0 , ',' , '.')." ".getPriceTypeName($intRealtySalePriceType);
			$strRealtyCity            = getCityName($intRealtyCity);
			$strRealtyDistrict        = getDistrictName($intRealtyDistrict);
			$strRealtyQuarter         = getQuarterName($intRealtyQuarter);
			$strRealtyType            = getTypeName($intRealtyType);
			$strRealtyDate            = $intRealtyDate;

			if ($rowselect==1){$rowselect=0;$RowStr=$SecSatir1;}else{$rowselect=1;$RowStr=$SecSatir2;};
?>
	<tr <?=$RowStr?>>
		<td><?=$f+1?></td>
		<td ><?=$strRealtyName?></td>
		<td ><?=$strRealtyCode?></td>
		<td ><?=$strRealtyDate?></td>
		<td ><?if($intRealtyIsRental==1){?>Evet<?}else{?>Hayir<?}?></td>
		<td align="right"><?=$strRealtyRentalPrice?></td>
		<td ><?if($intRealtyIsSale==1){?>Evet<?}else{?>Hayir<?}?></td>
		<td align="right"><?=$strRealtySalePrice?></td>
		<td ><?=$strRealtyCity?></td>
		<td ><?=$strRealtyDistrict?></td>
		<td ><?=$strRealtyQuarter?></td>
		<td ><?=$strRealtyType?></td>
		<td ><?=$strRealtyRoom?></td>
		<td ><?=$strRealtyDetail?></td>
		<td ><?=$strRealtyPerson?></td>
		<td ><?=$strRealtyPersonPhone?></td>
		<td ><?=$strRealtyUser?></td>
		<td <?=$DuzSatir1?>>
		<?if(($intRealtyId==$_GET[realtyid])&&($_GET[act]=='picture')){?>	
			<a href="index.php?module=realty&act=list">Resim</a></td>
		<?}else{?>
			<a href="index.php?module=realty&act=picture&realtyid=<?=$intRealtyId?>">Resim</a></td>
		<?}?>
		<td <?=$DuzSatir1?>><a href="index.php?module=realty&act=edit&realtyid=<?=$intRealtyId?>">Düzenle</a></td>
		<td <?=$DuzSatir1?>><a href="javascript:if(confirm('<?=$strRealtyName?> silmek istiyormusunuz?')){location.href='index.php?module=realty&act=delete&realtyid=<?=$intRealtyId?>';}">Sil</a></td>
	</tr>
<?if(($_GET[act]=='picture')&&($_GET[realtyid]==$intRealtyId)){?>	
	<tr>
		<td colspan="16" align="center">
			<table width="50%" border="0" align="center">
				<tr>
					<td colspan="3"><a href="index.php?module=realty&act=insertpicture&realtyid=<?=$intRealtyId?>" <?=$SecSatir1?>>[Yeni Resim]</a></td>
				</tr>
				<tr>
					<td><b>No</b></td>
					<td><b>Resim</b></td>
					<td><b>Sil</b></td>
				</tr>
<?
	$res2 = mysql_query("SELECT * FROM tblRealtyPhoto WHERE realtyphoto_realty='$intRealtyId' ORDER BY realtyphoto_id ASC");
	$rows2 = mysql_num_rows($res2);
	$rowselect2=1;
	if ($rows2) {
	    for ($f2=0 ; $f2<$rows2 ; $f2++) {
			$intPhotoId     = mysql_result($res2,$f2,"realtyphoto_id");
			$strPhotoFile   = mysql_result($res2,$f2,"realtyphoto_file");
?>
				<tr>
					<td><?=$f2+1?></td>
					<td align="center"><?if(file_exists('../images/realty/'.$strPhotoFile)){?><img src="../images/realty/<?=$strPhotoFile?>" xwidth="100%"><?}else{?><br>Resim yok<br><br><?}?></td>
					<td><a href="javascript:if(confirm('Resmi silmek istiyormusunuz?')){location.href='index.php?module=realty&act=photodelete&realtyid=<?=$intRealtyId?>&photoid=<?=$intPhotoId?>';}">Sil</a></td>
				</tr>
<?
		}
	}
?>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
<?}?>	
<?if(($_GET[act]=='insertpicture')&&($_GET[realtyid]==$intRealtyId)){?>	
	<tr>
		<td colspan="16" align="center"><br><br>
			<table width="50%" border="0" align="center">
				<form name="formImage" method="post" enctype="multipart/form-data">
				<tr>
					<td align="right">Resim Seçin</td>
					<td align="left"><input type="file" name="txtFile1"></td>
				</tr>
				<tr>
					<td align="right">Resim Seçin</td>
					<td align="left"><input type="file" name="txtFile2"></td>
				</tr>
				<tr>
					<td align="right">Resim Seçin</td>
					<td align="left"><input type="file" name="txtFile3"></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><br><br>
						<input type="button" value="Vazgeç" onClick="javascript:history.back();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnInsertPicture" value="Tamam">					
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>

<?}?>	
<?
		}
	}
?>
</table>
<?}?>
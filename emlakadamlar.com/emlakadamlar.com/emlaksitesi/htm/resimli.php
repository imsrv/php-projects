<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="emlakadamlar_css.css" rel="stylesheet" type="text/css">
</head><body>
<?//include("main02.php"); ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="2%" valign="top"><img src="images/left_bar.gif" width="19" height="320"></td>
          <td width="98%" valign="top"><table width="98%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1229" class="header">
					<table width="100%">
						<tr>
							<td align="left" width="20%"><p class="small_header">Kiralik - Satilik Emlaklar</p></td>
							<td align="right" width="80%"><table border="0" align="right" cellpadding="3" cellspacing="1" bgcolor="#E1E1E1">
                    <tr bgcolor="#FFFFFF" class="text">
                      <td>Kiralýklar</td>
                      <?
	$res = mysql_query("SELECT * FROM tblType WHERE 1=1 ORDER BY type_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intTypeId   = mysql_result($res,$f,"type_id");
			$strTypeName = mysql_result($res,$f,"type_name");
			//1-kiralik
			//2-satilik
			
?>
                      <td>
<?if(($intTypeId==$_GET[type2])&&($_GET[type]=='1')){?>
					  	<b><a href="index.php?module=resimli&type=1&type2=<?=$intTypeId?>"><?=$strTypeName?></a></b>
<?}else{?>
					  	<a href="index.php?module=resimli&type=1&type2=<?=$intTypeId?>"><?=$strTypeName?></a>
<?}?>
					  </td>
                      <?
		}
	}
?>
                    </tr>
                    <tr bgcolor="#FFFFFF" class="text">
                      <td>Satýlýklar</td>
                      <?
	$res = mysql_query("SELECT * FROM tblType WHERE 1=1 ORDER BY type_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intTypeId   = mysql_result($res,$f,"type_id");
			$strTypeName = mysql_result($res,$f,"type_name");
			//1-kiralik
			//2-satilik
?>
                      <td>
<?if(($intTypeId==$_GET[type2])&&($_GET[type]=='2')){?>
					  	<b><a href="index.php?module=resimli&type=2&type2=<?=$intTypeId?>"><?=$strTypeName?></a></b>
<?}else{?>
					  	<a href="index.php?module=resimli&type=2&type2=<?=$intTypeId?>"><?=$strTypeName?></a>
<?}?>
					  </td>
                      <?
		}
	}
?>
                    </tr>
                  </table></td>
						</tr>
					</table>
                </td>
              </tr>
              <tr>
                <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="44%" valign="top" class="text"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="46%"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td valign="top" class="text">
					  <table width="100%"  border="0" cellpadding="3" cellspacing="1" bgcolor="C2D8E5">
                          <tr bgcolor="E2ECF3" class="text_11">
                            <td class="text_11"><div align="center" class="text_11">
                                <div align="left"><strong>No.</strong></div>
                              </div></td>
                            <td class="text_11"><div align="left"><strong>Adý</strong></div></td>
                            <td class="text_11"><div align="left"><strong>Kod</strong></div></td>
                            <td class="text_11"><div align="left"><strong>Tarih</strong></div></td>
                            <td class="text_11"><div align="center" class="text_11">
                                <div align="left"><strong>Kiral&#305;k - Sat&#305;l&#305;k </strong></div>
                              </div></td>
                            <td class="text_11"><div align="left"><strong>Þehir</strong></div></td>
                            <td class="text_11"><div align="left"><strong>Ýlçe</strong></div></td>
                            <td class="text_11"><div align="left"><strong>Mahalle</strong></div></td>
                            <td class="text_11"><div align="left"><strong>Tipi</strong></div></td>
                            <td wclass="text_11"><div align="left"><strong>Oda Sayýsý </strong></div></td>
                            <td><div align="left"><strong>Detay</strong></div></td>
                            <td><div align="left"><strong>Ilgili</strong></div></td>
                          </tr>
                          <?
	if($_GET[type]=='1'){//kiralýk
		$strx = " and realty_isrental='1' ";
		if($_GET[price1]){
			$strx .= " and realty_rentalprice > $_GET[price1]";
		}
		if($_GET[price2]){
			$strx .= " and realty_rentalprice < $_GET[price2]";
		}
	}elseif($_GET[type]=='2'){//satýlýk
		$strx = " and realty_issale='1' ";
		if($_GET[price1]){
			$strx .= " and realty_saleprice > $_GET[price1]";
		}
		if($_GET[price2]){
			$strx .= " and realty_saleprice < $_GET[price2]";
		}
	}
	if($_GET[district]){
		$strx .= " and realty_district='$_GET[district]'";
	}
	if($_GET[type2]){
		$strx .= " and realty_type='$_GET[type2]'";
	}
	if($_GET[page]){
		$intPage=$_GET[page];
	}else{
		$intPage=1;
	}
	$strQuery="SELECT * FROM tblRealty WHERE 1 $strx ORDER BY realty_id ASC";
	//echo("<hr>".$strQuery."<hr>");
	$res = mysql_query($strQuery);
	$rows = mysql_num_rows($res);
	$intRowCount = $rows;

	$strQuery="SELECT * FROM tblRealty WHERE 1 $strx ORDER BY realty_id DESC LIMIT ".(($intPage-1)*4).",4";
	//echo("<hr>".$strQuery."<hr>");
	$res = mysql_query($strQuery);
	$rows = mysql_num_rows($res);
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$Id   = mysql_result($res,$f,"realty_id");
			$Code = mysql_result($res,$f,"realty_code");
			$Name = mysql_result($res,$f,"realty_name");
			$Date = mysql_result($res,$f,"realty_date");
			$Isrental = mysql_result($res,$f,"realty_isrental");
			$Rentalprice = mysql_result($res,$f,"realty_rentalprice");
			$Rentalpricetype = mysql_result($res,$f,"realty_rentalpricetype");
			$Salepricetype = mysql_result($res,$f,"realty_salepricetype");
			$Saleprice = mysql_result($res,$f,"realty_saleprice");
			$City = mysql_result($res,$f,"realty_city");
			$District = mysql_result($res,$f,"realty_district");
			$Quarter = mysql_result($res,$f,"realty_quarter");
			$Type = mysql_result($res,$f,"realty_type");
			$Room = mysql_result($res,$f,"realty_room");
			$Detail = mysql_result($res,$f,"realty_detail");
			$Person = mysql_result($res,$f,"realty_person");
			$PersonPhone = mysql_result($res,$f,"realty_personphone");
			
?>
                          <tr bgcolor="#FFFFFF" class="text_11">
                            <td height="65" rowspan="2" align="center" valign="middle"><?=$f+1+(($intPage-1)*4)?></td>
                            <td><div align="left"><span class="text_11">
                                <?=$Name?>
                                </span></div></td>
                            <td><div align="left">
                                <?=$Code?>
                              </div></td>
                            <td><div align="left">
                                <?=$Date?>
                              </div></td>
                            <td valign="middle" nowrap><div align="left"> Kiralýk
                                <?if($Isrental==0){?>
                                <input type="checkbox" name="checkbox2" value="checkbox" disabled>
                                <?}else{?>
                                <input name="checkbox" type="checkbox" disabled value="checkbox" checked >
                                <?=number_format($Rentalprice, 0 , ',' , '.')?>
                                <?=getPriceTypeName($Rentalpricetype)?>
                                <?}?>
                                <br>
                                Satilýk
                                <?if($Saleprice==0){?>
                                <input type="checkbox" name="checkbox2" value="checkbox" disabled>
                                <?}else{?>
                                <input name="checkbox" type="checkbox" disabled value="checkbox" checked >
                                <?=number_format($Saleprice, 0 , ',' , '.')?>
&nbsp;
                                <?=getPriceTypeName($Salepricetype)?>
                                <?}?>
                              </div></td>
                            <td><div align="left">
                                <?=getCityName($City)?>
                              </div></td>
                            <td><div align="left">
                                <?=getDistrictName($District)?>
                              </div></td>
                            <td><div align="left">
                                <?=getQuarterName($Quarter)?>
                              </div></td>
                            <td><div align="left">
                                <?=getTypeName($Type)?>
                              </div></td>
                            <td><div align="left">
                                <?=$Room?>
                              </div></td>
                            <td><div align="left">
                                <?=$Detail?>
                              </div></td>
                            <td nowrap><div align="center">
                                <?=$Person?>
                                <br>
                                <?=$PersonPhone?>
                              </div></td>
                          </tr>
                          <tr>
                            <td align="center" colspan="11"><?
	$res2 = mysql_query("SELECT * FROM tblRealtyPhoto WHERE realtyphoto_realty='$Id' ORDER BY realtyphoto_id ASC");
	$rows2 = mysql_num_rows($res2);
	if ($rows2) {
	    for ($f2=0 ; $f2<$rows2 ; $f2++) {
			$intId   = mysql_result($res2,$f2,"realtyphoto_id");
			$strFile = mysql_result($res2,$f2,"realtyphoto_file");
			if(is_file("images/realty/" . $strFile)){
?>
	<a href="javascript: popImage('images/realty/<?=$strFile?>',' : : Emlak Admlar ... Emlak Admlar : : ')"><img src="images/realty/<?=$strFile?>" border="0" height="70"></a>
<?			
			}
		}
	}else{
?>Resim Yok<?	
	}
					  ?></td>
                          </tr>
                          <?
		}
	}
?>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="center" class="text">Sayfa <?
						for ($f=0 ; $f<($intRowCount/4) ; $f++) {
							if($intPage==$f+1){
								?><b><a href="index.php?module=resimli&type=<?=$_GET[type]?>&price1=<?=$_GET[price1]?>&price2=<?=$_GET[price2]?>&district=<?=$_GET[district]?>&type2=<?=$_GET[type2]?>&page=<?=$f+1?>"><?=$f+1?></a></b> <?
							}else{
								?><a href="index.php?module=resimli&type=<?=$_GET[type]?>&price1=<?=$_GET[price1]?>&price2=<?=$_GET[price2]?>&district=<?=$_GET[district]?>&type2=<?=$_GET[type2]?>&page=<?=$f+1?>"><?=$f+1?></a> <?			
							}
						}
				?></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>

<?php

//SQL Baðlantýsý
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());


if ( !isset($_POST['Submit']) ) {
?>
<form method="post" action="">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120">Dosya Adý: </td>
    <td><input name="adi" type="text" id="adi" style="width: 350px;"></td>
  </tr>
  <tr>
    <td valign="top">Açýklama:</td>
    <td><textarea name="aciklama" id="aciklama" style="width: 350px; height: 150px;"></textarea></td>
  </tr>
  <tr>
    <td valign="top">URL:</td>
    <td><input name="url" type="text" id="url" style="width: 350px;" value=""></td>
  </tr>
  <tr>
    <td valign="top"><input type="submit" name="Submit" value="Kaydet"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php }
else if ( isset($_POST['adi']) && isset($_POST['aciklama']) && isset($_POST['url']) && $_POST['adi'] && $_POST['aciklama'] && $_POST['url'] ) {
	$result = mysql_query('INSERT INTO `dosyalar` ( `id`, `adi`, `aciklama`, `url`, `eklenme_tarihi`, `sayac` ) VALUES ( NULL, \'' . $_POST['adi'] . '\', \'' . $_POST['aciklama'] . '\', \'' . $_POST['url'] . '\', \'' . time() . '\', 0 );');
	if ( $result ) echo 'Yeni dosya eklenmiþtir.';
	else echo mysql_error();
}
else echo 'Lütfen tüm alanlarý doldurunuz';
?>
<?php

//SQL Ba�lant�s�
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());


if ( !isset($_POST['Submit']) ) {
?>
<form method="post" action="">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120">Sayfa Ad�: </td>
    <td><input name="sayfa_adi" type="text" id="sayfa_adi" style="width: 350px;"></td>
  </tr>
  <tr>
    <td>Ba�l�k:</td>
    <td><input name="baslik" type="text" id="baslik" style="width: 350px;"></td>
  </tr>
  <tr>
    <td valign="top">��erik:</td>
    <td><textarea name="icerik" id="icerik" style="width: 350px; height: 150px;"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><input type="submit" name="Submit" value="Kaydet"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php }
else if ( isset($_POST['sayfa_adi']) && isset($_POST['baslik']) && isset($_POST['icerik']) && $_POST['sayfa_adi'] && $_POST['baslik'] && $_POST['icerik'] ) {
	$result = mysql_query('INSERT INTO `dokumanlar` ( `id`, `sayfa_adi`, `baslik`, `icerik`, `sayac` ) VALUES ( NULL, \'' . $_POST['sayfa_adi'] . '\', \'' . $_POST['baslik'] . '\', \'' . $_POST['icerik'] . '\', 0 );');
	if ( $result ) echo 'Yeni sayfa eklenmi�tir.';
	else echo mysql_error();
}
else echo 'L�tfen t�m alanlar� doldurunuz';
?>
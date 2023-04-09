<html>
<head>
<title>elmasgunes.net</title>
</head>
<body style="font-family:verdana;font-size:8pt;color:#000000">

<?php
$sifre = $_POST["bilgi"];
if ( $sifre )
{
 if ( $sifre == "hesapno" )
  echo "<br> Hesap Numaralarý: <br><br>&nbsp;&nbsp;&nbsp;Yapý ve Kredi Bankasý<br>&nbsp;&nbsp;&nbsp;0133-9 Turgutlu-MANÝSA Þubesi<br>&nbsp;&nbsp;&nbsp;0038817-3 Nolu Hesap<br><br><br>&nbsp;&nbsp;&nbsp;Türkiye Ýþ Bankasý<br>&nbsp;&nbsp;&nbsp;3525 Turgutlu-MANÝSA Þubesi<br>&nbsp;&nbsp;&nbsp;788808 Nolu Hesap";
 else
  echo "<br>HATA !";
}

else
{
?>

<form action="hesapno.php" method="POST">
<input name="bilgi" type="password" size="7" maxlength="7" style="border: 1px solid #FFFFFF">
<input type="submit" value="?" style="border: 1px solid #FFFFFF; background-color: #FFFFFF;font-family:verdana;font-size:8pt; color: #00000">
</form>




<?php
}
?>
</body>
</html>
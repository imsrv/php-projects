<?php
        $tiklama = $_GET["menu"];
        $soru = $_POST["ok"];
        if( $soru )
        {
         $ad = htmlspecialchars($_POST["ad"]);
         $mail = htmlspecialchars($_POST["mail"]);
         $konu = htmlspecialchars($_POST["konu"]);
         $soru = htmlspecialchars($_POST["soru"]);
         $konu = "Soru Var! (Konu: $konu)";
         if (!@mail("destek@elmasgunes.net",$konu,$soru,"From:$ad<$mail>\nMIME-Version:1.0\nContent-Type:text/html;charset=iso-8859-9\n")) $hata = "<center><br><font color=red><b>HATA!</b> </font>�u Anda Mesaj�n�z G�nderilemiyor. L�tfen Daha Sonra Tekrar Deneyiniz...<br></center>";
                 else $hata = "Mesaj�n�z �letilmi�tir!";
        }
        if ( !@include("sayfa_basi.php") ){ require("hata.php"); exit(); }
echo "<center><font color=red>$hata</font></center>";
?>
<br>
&nbsp;&nbsp;Soru ve sorunlar�n�z i�in bize ula�abilece�iniz yollar:<br>
<ul type="1"><li>E-mail ile: "<a href="mailto:destek@elmasgunes.net">destek@elmasgunes.net</a>" (Gelen e-maillere en ge� 24 saat i�inde cevap verilir.)<br><br><br>
                         <li>Telefon ile: 0 535 71 71 101 (Fatih ELMASG�NE�)<br>
<?php /*                         �����������������0 536 726 42 44 (Ferhat ELMASG�NE�)<br>*/ ?><br><br>
                         <li>A�a��daki Formu Doldurarak:<br><br>
<table>
<tr>
<td>
<form action="iletisim.php" method="POST" name="soru">
<input name="ad" type="text" size="50" onFocus="this.value=''" value="Ad�n�z� ve Soyad�n�z� Buraya Yazabilirsiniz" class="form" style="font-weight:normal"><br><br>
<input name="mail" type="text" size="50" onFocus="this.value=''" value="E-Mail Adresinizi Buraya Yazabilirsiniz" class="form" style="font-weight:normal"><br><br>
<input name="konu" type="text" size="50" onFocus="this.value=''" value="Konuyu Buraya Yazabilirsiniz" class="form" style="font-weight:normal"><br><br>
<textarea name="soru" cols="49" rows="8" onFocus="this.value=''" class="form" style="font-weight:normal">Sorununuzu Buraya Yazabilirsiniz</textarea><br><br>
<div align="right"><input type="submit" value="G�nder" name="ok" class="buton" size="6">&nbsp;&nbsp;<input type="reset" value="�ptal" class="buton"></div>
</form>
</td>
</tr>
</table>

<?php if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); } ?>
<? 
if (isset($_POST['B1'])) {  
$kime = "romeojulyet@hotmail.com";  
$kimden = "From: $_POST[mail]";  
$konu = "iletiþim";  

$mesaj  = "Adý Soyadý: $_POST[adsoy]\n";  
$mesaj .= "Firma Adý: $_POST[firma]\n";  
$mesaj .= "Email: $_POST[mail]\n";  
$mesaj .= "$_POST[mesaj]";  

if (mail($kime,$konu,$mesaj,$kimden)) {  
 echo "DataKolik Ýnternet Hizmetleri Sizinle En Kýsa Zamanda Ýletisime Gececektir";  
} else {  
echo "Mail Gonderilemedi";  
}  
}  
?>  

<html>  
<head>  
<title>ulasim</title>  
<script language="javascript">  
function kontrol() {  
if (document.form.adsoy.value=="") {   
alert("Ad Soyad Yazýnýz");  
return false;  
}  
if (document.form.mail.value=="") {   
alert("Mail Yazýnýz");  
return false;  
}  
if (document.form.mesaj.value=="") {   
alert("Mesaj Yazýnýz");  
return false;  
}  
return true;  
}  
</script>  
<style type="text/css">
<!--
body {
	background-color: #ffffff;
}
.style2 {color: #FFFFFF}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><form method="post" action="<?=$_SERVER[SCRIPT_NAME]?>" name="form" onsubmit="return kontrol();">  
  <p align="justify">Ad Soyad <span class="style2">---</span>: 
    <input type=text name=adsoy>
    <br>  
Email <span class="style2">-------.</span>:
<input type=text name=mail>
<br> 
Telefon<span class="style2">-----..</span>:
<input type=text name=firma>
  <br>
  Mesaj <span class="style2">------</span> :
  <textarea rows="5" name="mesaj" cols="30"></textarea>
  <br>  
  <span class="style2">---------------------------------------</span>  
  <input type="submit" value="Gönder" name="B1">
  </p>
  </form>  
</head>  
</html> 
<?php require_once('../Connections/lyrics.php'); ?>
<?php
session_start();
?>
<?php include "../css.php"; ?>
<?php
if ($MM_UserGroup == '10') {
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>�ifre de�i�tirildi</title>
</head>
<body>
<script>
function yuru() {
window.location = "../index.php";
}
function zamanlama(){
setTimeout('yuru();' , 10000);
}
</script>
<body onload="zamanlama();"><br><br><br><br>
<center>�ifren de�i�tirildi.<br><br>10 saniye i�inde anasayfaya yollan�yorsun!!<br><a href="../index.php">Acelen varsa t�kla!</a>
</body>
<?php
} else if ($MM_UserGroup == '5') {
?>
<script>
function yuru() {
window.location = "../index.php";
}
function zamanlama(){
setTimeout('yuru();' , 10000);
}
</script>
<body onload="zamanlama();"><br><br><br><br>
<center>�ifren de�i�tirildi.<br><br>10 saniye i�inde anasayfaya yollan�yorsun!!<br><a href="../index.php">Acelen varsa t�kla!</a>
</body>
<?php
} else {
?>
<script>
window.location = "../giris.php?hata=girisyap";
</script>
<?php
}
?>
</body>
</html>
<?php require_once('Connections/lyrics.php'); ?>
<?php
session_start();
$maxRows_soneklenen = 10;
$pageNum_soneklenen = 0;
if (isset($_GET['pageNum_soneklenen'])) {
  $pageNum_soneklenen = $_GET['pageNum_soneklenen'];
}
$startRow_soneklenen = $pageNum_soneklenen * $maxRows_soneklenen;

mysql_select_db($database_lyrics, $lyrics);
$query_soneklenen = "SELECT id, sanatci, sarki FROM sarki ORDER BY id DESC";
$query_limit_soneklenen = sprintf("%s LIMIT %d, %d", $query_soneklenen, $startRow_soneklenen, $maxRows_soneklenen);
$soneklenen = mysql_query($query_limit_soneklenen, $lyrics) or die(mysql_error());
$row_soneklenen = mysql_fetch_assoc($soneklenen);

if (isset($_GET['totalRows_soneklenen'])) {
  $totalRows_soneklenen = $_GET['totalRows_soneklenen'];
} else {
  $all_soneklenen = mysql_query($query_soneklenen);
  $totalRows_soneklenen = mysql_num_rows($all_soneklenen);
}
$totalPages_soneklenen = ceil($totalRows_soneklenen/$maxRows_soneklenen)-1;
?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['user'])) {
if (md5($_POST['gkod']) == $GLOBALS['guvenlik']) {
  $loginUsername=$_POST['user'];
  $password=md5($_POST['pass']);
  $MM_fldUserAuthorization = "yetki";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "giris.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_lyrics, $lyrics);
  	
  $LoginRS__query=sprintf("SELECT user, pass, yetki FROM admin WHERE user='%s' AND pass='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $lyrics) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'yetki');
    
    //declare two session variables and assign them
    $GLOBALS['MM_Username'] = $loginUsername;
    $GLOBALS['MM_UserGroup'] = $loginStrGroup;	      

    //register the session variables
    session_register("MM_Username");
    session_register("MM_UserGroup");

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
if ($MM_UserGroup == '10') {
mysql_query("UPDATE cache SET yonetici=1", $lyrics);
}
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
} else { ?>
<script>
window.location = "dogrulamahatasi.php";
</script>
<?php
}
} else {
$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
$textstr = '';
for ($i = 0, $length = 8; $i < $length; $i++) {
   $textstr .= $chars[rand(0, count($chars) - 1)];
}
$hashtext = md5($textstr);
$GLOBALS['guvenlik'] = $hashtext;
session_register("guvenlik");
}
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>þarkýsözü.net - kullanýcý giriþi</title>
<?php include "css.php"; ?>
<script>
function submitonce(theform){
//if IE 4+ or NS 6+
if (document.all||document.getElementById){
//screen thru every element in the form, and hunt down "submit" and "reset"
for (i=0;i<theform.length;i++){
var tempobj=theform.elements[i]
if(tempobj.type.toLowerCase()=="submit")
//disable em
tempobj.disabled=true
}
}
}
</script>
<script>
function yuru() {
window.location = "index.php";
}
function zamanlama(){
setTimeout('yuru();' , 3000);
}
</script>
</head>

<body><br><br><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img src="images/header.jpg" alt="sarkisozu.net"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Menü</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | <a href="giris.php">Kullanýcý Giriþi</a><br>
<br><center><b>Kullanýcý Giriþi:</b></center>
<?php if ($MM_UserGroup == '10') { ?>
<script>
zamanlama();
</script>
<br><center>Zaten giriþ yapmýþsýn. Seni anasayfaya yolluyorum............</center>
<?php } else if ($MM_UserGroup == '5') { ?>
<script>
zamanlama();
</script>
<br><center>Zaten giriþ yapmýþsýn. Seni anasayfaya yolluyorum............</center>
<?php } else { ?>
<?php if ($_GET['hata'] == 'girisyap') { ?>
<br><center>Kýsýtlý bir alana girmeye çalýþýyorsunuz.</center>
<? } else if ($_GET['hata'] == 'dogrulama') { ?>
<br><center>Girdiðiniz kullanýcý adý veya þifre hatalý.</center>
<?php } else { } ?>
<center><table style="border: 1px solid black;"><tr><form ACTION="<?php echo $loginFormAction; ?>" method="POST" onsubmit="submitonce(this);" name="admingirisi">
      <td style="width:30%; vertical-align:middle;"><b>Kullanýcý:</b></td><td style="width:70%;"><input type="text" name="user"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Þifre:</b></td><td style="width:70%;"><input type="password" name="pass"><input type="hidden" value="<?php echo $textstr; ?>" name="gkod" maxlength="8"></td></tr><tr><td colspan="2"><center><input type="submit" value="giriþ"></center></td></form></tr></table></center><?php } ?></td>
    <td width="22%" style="border-left:1px solid black; border-bottom:1px solid black; border-top:1px solid black;" height="90"><center><b>Arama</b><?php include "aramablok.php"; ?></center></td>
  </tr>
  <tr>
    <td width="18%" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Destekleyenler</b></center><br><?php include "destek.php"; ?></td>
    <td style="border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Son Eklenenler</b><br><br><?php if ($totalRows_soneklenen > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <a href="sarkici.php?sanatci=<?php echo $row_soneklenen['sanatci']; ?>"><?php echo $row_soneklenen['sanatci']; ?></a> - <a href="sarki.php?id=<?php echo $row_soneklenen['id']; ?>"><?php echo $row_soneklenen['sarki']; ?></a><br>
      <?php } while ($row_soneklenen = mysql_fetch_assoc($soneklenen)); ?>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_soneklenen == 0) { // Show if recordset empty ?>
      sitede hiç þarký sözü yok!!
      <?php } // Show if recordset empty ?>
    </center></td>
  </tr>
  <tr><td colspan="3" height="5" style="border-top:1px solid black;"><b>sarkisozu.net kullanýcý paneli - powered by <a href="http://www.gencdizayn.net" target="_blank">gençdizayn</a></b></td></tr>
<tr><td colspan="3" height="5" style="border-top:1px solid black;"><center><?php include "toplist.php"; ?></center></td></tr>
</table></center>
</body>
</html>
<?php
mysql_free_result($soneklenen);
?>

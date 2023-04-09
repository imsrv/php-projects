<?php require_once('Connections/lyrics.php'); ?>
<?php
session_start();
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="ekle_fail.php";
  $loginUsername = $_POST['soz'];
  $LoginRS__query = "SELECT soz FROM eklenenler WHERE soz='" . $loginUsername . "'";
  mysql_select_db($database_lyrics, $lyrics);
  $LoginRS=mysql_query($LoginRS__query, $lyrics) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);


  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}
$formhatasi = "
<script language=\"javascript\">
this.location = \"ekle.php?hata=form\";
</script>
";
$ip = $_SERVER["REMOTE_ADDR"];
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sarkiekle")) {
if (md5($_POST['gkod']) == $GLOBALS['guvenlik']) {
  $insertSQL = sprintf("INSERT INTO eklenenler (sanatci, sarki, album, soz, ip) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['sanatci'], "text"),
                       GetSQLValueString($_POST['sarki'], "text"),
                       GetSQLValueString($_POST['album'], "text"),
                       GetSQLValueString($_POST['soz'], "text"),
                       GetSQLValueString($ip, "text"));


  mysql_select_db($database_lyrics, $lyrics);
  $Result1 = mysql_query($insertSQL, $lyrics) or die($formhatasi);


  $insertGoTo = "ekle_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sarkiekleadm")) {
  $insertSQL = sprintf("INSERT INTO sarki (sanatci, sarki, album, soz) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['sanatci'], "text"),
                       GetSQLValueString($_POST['sarki'], "text"),
                       GetSQLValueString($_POST['album'], "text"),
                       GetSQLValueString($_POST['soz'], "text"));
  mysql_select_db($database_lyrics, $lyrics);
  $Result1 = mysql_query($insertSQL, $lyrics) or die($formhatasi);


  $insertGoTo = "ekle_ok_adm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
<html>
<head>
<title>þarkýsözü.net - þarký sözü ekle</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
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
<script type="text/javascript">
function handleEnter (field, event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
					break;
			i = (i + 1) % field.form.elements.length;
			field.form.elements[i].focus();
			return false;
		} 
		else
		return true;
	}
</script>
</head>

<body><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img width="330" height="70" src="images/header.jpg" alt="sarkisozu.net"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Menü</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | <a href="ekle.php">Þarký Sözü Ekle</a><br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-Ç</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=Ý">Ý-Ü-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=ö">Ö</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=þ">Þ</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br><center><b>Þarký Sözü Ekle:</b></center><br>
<?php
if ($_GET['hata'] == 'form') { ?>
<center>Formdaki bütün alanlarý doldurmalýsýnýz.</center><br>
<?php }
if ($MM_UserGroup == 10) { ?>
<center><table style="border: 1px solid black;"><tr><form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="submitonce(this);" name="sarkiekleadm">
      <td style="width:30%; vertical-align:middle;"><b>Þarkýcý:</b></td><td style="width:70%;"><input type="text" name="sanatci" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Þarký Adý:</b></td><td style="width:70%;"><input type="text" name="sarki" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Albüm:</b></td><td style="width:70%;"><input type="text" name="album" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Sözler:</b></td><td style="width:70%;"><textarea name="soz" rows="10" cols="30"></textarea></td></tr><tr><td colspan="2"><center><input type="submit" value="ekle!"></center><center><b>Not: </b>Lütfen þarký eklerken tamamýný büyük harfle yazmamaya özen gösteriniz.</center></td>
        

        <input type="hidden" name="MM_insert" value="sarkiekleadm">
      </form></tr></table></center>
<?php }
else if ($MM_UserGroup == 5) { ?>
<center><table style="border: 1px solid black;"><tr><form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="submitonce(this);" name="sarkiekleadm">
      <td style="width:30%; vertical-align:middle;"><b>Þarkýcý:</b></td><td style="width:70%;"><input type="text" name="sanatci" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Þarký Adý:</b></td><td style="width:70%;"><input type="text" name="sarki" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Albüm:</b></td><td style="width:70%;"><input type="text" name="album" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Sözler:</b></td><td style="width:70%;"><textarea name="soz" rows="10" cols="30"></textarea></td></tr><tr><td colspan="2"><center><input type="submit" value="ekle!"></center><center><b>Not: </b>Lütfen þarký eklerken tamamýný büyük harfle yazmamaya özen gösteriniz.</center></td>
        

        <input type="hidden" name="MM_insert" value="sarkiekleadm">
      </form></tr></table></center>
<?php }
else { ?>
<center><table style="border: 1px solid black;"><tr><form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="submitonce(this);" name="sarkiekle">
      <td style="width:30%; vertical-align:middle;"><input type="hidden" name="ip" value="<?php echo $ip; ?>"><b>Þarkýcý:</b></td><td style="width:70%;"><input type="text" name="sanatci" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Þarký Adý:</b></td><td style="width:70%;"><input type="text" name="sarki" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Albüm:</b></td><td style="width:70%;"><input type="text" name="album" onkeypress="return handleEnter(this, event)"></td></tr><tr><td style="width:30%; vertical-align:middle;"><b>Sözler:</b></td><td style="width:70%;"><textarea name="soz" rows="10" cols="30"></textarea><input type="hidden" name="gkod" maxlength="8" value="<?php echo $textstr; ?>"></td></tr><tr><td colspan="2"><center><input type="submit" value="ekle!"></center><center><b>Not: </b>Lütfen þarký eklerken tamamýný büyük harfle yazmamaya özen gösteriniz.</center></td>
        

        <input type="hidden" name="MM_insert" value="sarkiekle">
      </form></tr></table></center>
<?php } ?></td>
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
  <tr><td colspan="3" height="5" style="border-top:1px solid black;"><?php include "copyright.php"; ?></td></tr>
<tr><td colspan="3" height="5" style="border-top:1px solid black;"><center><?php include "toplist.php"; ?></center></td></tr>
</table></center>
</body>
</html>
<?php
mysql_free_result($soneklenen);
?>
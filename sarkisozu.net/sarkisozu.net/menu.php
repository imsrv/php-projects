<?php
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) { 
mysql_query("UPDATE cache SET yonetici=0", $lyrics);
?>
<script>
window.location = "<?php echo $logoutGoTo; ?>";
</script>
<?php
  }
}

mysql_select_db($database_lyrics, $lyrics);
$query_admin = "SELECT user FROM admin WHERE user = '$MM_Username'";
$admin = mysql_query($query_admin, $lyrics) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);

mysql_select_db($database_lyrics, $lyrics);
$query_iletisim = "SELECT * FROM iletisim";
$iletisim = mysql_query($query_iletisim, $lyrics) or die(mysql_error());
$row_iletisim = mysql_fetch_assoc($iletisim);
$totalRows_iletisim = mysql_num_rows($iletisim);

mysql_select_db($database_lyrics, $lyrics);
$query_istenen = "SELECT * FROM istekler";
$istenen = mysql_query($query_istenen, $lyrics) or die(mysql_error());
$row_istenen = mysql_fetch_assoc($istenen);
$totalRows_istenen = mysql_num_rows($istenen);

mysql_select_db($database_lyrics, $lyrics);
$query_eklenen = "SELECT * FROM eklenenler";
$eklenen = mysql_query($query_eklenen, $lyrics) or die(mysql_error());
$row_eklenen = mysql_fetch_assoc($eklenen);
$totalRows_eklenen = mysql_num_rows($eklenen);
?>
<script language="javascript" type="text/javascript">
<!--
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>
<?
echo date("d.m.Y, G:i");
?><br>
<b><?php include "online/howmanyonline.php"; ?></b> ziyaretçi aktif<?php if ($GLOBALS['MM_UserGroup'] == '10') { ?> | <a href="onlinesifirla.php" onClick="NewWindow(this.href,'mywin','400','400','no','center');return false">Sýfýrla</a><?php } ?><br>
<?php if ($MM_UserGroup == 10) { } else if ($MM_UserGroup == 5) { } else { ?>
Yönetici: <?php
if ($row_cache['yonetici'] == '1') { 
echo "<img src=\"images/a.gif\">";
} else {
echo "<img src=\"images/na.gif\">";
}
?>
<br>
<?php } ?>
<?php
if ($MM_UserGroup == 10) { ?>
Hoþgeldin <b><?php echo $row_admin['user']; ?>&nbsp;<?php
if ($row_cache['yonetici'] == '1') { 
echo "<img src=\"images/a.gif\">";
} else {
echo "<img src=\"images/na.gif\">";
}
?></b><br>
Eklenen Söz: <?php if ($totalRows_eklenen == 0) { echo $totalRows_eklenen; } else { ?><b><?php echo $totalRows_eklenen; ?></b><?php } ?><br>
Ýstenen Söz: <?php if ($totalRows_istenen == 0) { echo $totalRows_istenen; } else { ?><b><?php echo $totalRows_istenen; ?></b><?php } ?><br>
Ýletiþim Talebi: <?php if ($totalRows_iletisim == 0) { echo $totalRows_iletisim; } else { ?><b><?php echo $totalRows_iletisim; ?></b><?php } ?><br><br>
<?php }
else if ($MM_UserGroup == 5) { ?>
Hoþgeldin <b><?php echo $row_admin['user']; ?>&nbsp;<?php
if ($row_cache['yonetici'] == '1') { 
echo "<img src=\"images/a.gif\">";
} else {
echo "<img src=\"images/na.gif\">";
}
?></b><br>
Eklenen Söz: <?php if ($totalRows_eklenen == 0) { echo $totalRows_eklenen; } else { ?><b><?php echo $totalRows_eklenen; ?></b><?php } ?><br>
Ýstenen Söz: <?php if ($totalRows_istenen == 0) { echo $totalRows_istenen; } else { ?><b><?php echo $totalRows_istenen; ?></b><?php } ?><br><br>
<?php } else { ?>
<br>
<?php } ?>
<input type="button" value="Online Radyo" href="radyoplayer/player.html" onClick="NewWindow(this.href,'mywin','155','50','no','center');return false"><br>
<br><li><a href="http://www.sarkisozu.net/yeni.php">Yeni eklenen sözler</a></li><li><a href="http://www.sarkisozu.net/populer.php">Popüler sözler</a></li><li><a href="http://www.sarkisozu.net/ekle.php">Þarký sözü ekle</a></li>
<?php
if ($MM_UserGroup < 5) { ?>
<li><a href="iste.php">Þarký sözü iste</a></li>
<?php
} ?>
<li><a href="webmaster.php">Webmasterlar'a</a></li><li><a href="reklam.php">Reklam</a></li><li><a href="iletisim.php">Ýletiþim</a></li>
<?php
if ($MM_UserGroup == 10) { ?>
<br><br><input type="button" value="Panel" onClick="window.location=('panel/');"><input type="button" value="Þifre" onClick="window.location=('panel/sifre.php');"><input type="button" value="Çýkýþ" onClick="window.location=('<?php echo $logoutAction ?>');">
<?php
} 
else if ($MM_UserGroup == 5) { ?>
<br><br><input type="button" value="Panel" onClick="window.location=('panel/');"><input type="button" value="Þifre" onClick="window.location=('panel/sifre.php');"><input type="button" value="Çýkýþ" onClick="window.location=('<?php echo $logoutAction ?>');">
<?php
} else { ?>
<li><a href="giris.php">Kullanýcý Giriþi</a></li>
<?php } ?>
<?php
mysql_free_result($admin);
mysql_free_result($iletisim);
mysql_free_result($istenen);
mysql_free_result($eklenen);
?>
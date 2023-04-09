<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>DataKolik</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="stylesheet" type="text/css" href="sft.css">
<link rel="stylesheet" type="text/css" href="text.css">
</head>
<script  type="text/javascript">
var win= null;
function NewWindow(mypage,myname,w,h,scroll){
  var winl = (screen.width-w)/2;
  var wint = (screen.height-h)/2;
  var settings  ='height='+h+',';
      settings +='width='+w+',';
      settings +='top='+wint+',';
      settings +='left='+winl+',';
      settings +='scrollbars='+scroll+',';
      settings +='resizable=no';
  win=window.open(mypage,myname,settings);
  if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
}
</script>

<?

include "portal/inc/sqlbag.php";
include "portal/inc/tarih.php";

$sql_haber = mysql_query("select * from haber ORDER by tarih DESC");
$haber = mysql_fetch_array($sql_haber);
$adet = 0;
do {
    ++$adet;
    $tarih=ftarih($haber["tarih"]);
    if ($adet >= 6 ) break;
    if ($haber["baslik"] != "" ) echo "<B><font color='#000000'>".$haber["baslik"]."</FONT></B><br><BR>";
    echo "<B><font color='#000000'>TARİH :</B>".$tarih."</FONT><br><br>";
    echo "<font color='#000000'>".stripslashes($haber["govde"])."</FONT><br> <BR>";
?>
    <? if ($haber["detay"] != "" ) { ?> 
<a  onclick="NewWindow(this.href,'name','425','407','yes');return false"  href='portal/haber/haber_detay.php?haber_id=<? echo $haber["haber_id"] ?>'> 
<font color="#000000">detay </font> </a> <? } ?>
    <br>
    <a href="tumhaber.php"><font color="#1F443C" style="font-size: 8pt">Tüm haberler</font></a><br>
<img src="romeo.gif" vspace="6">
    <br><br>
<?
}
while ( $haber = mysql_fetch_array($sql_haber) );

?>
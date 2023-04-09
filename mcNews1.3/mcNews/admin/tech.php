<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("header.php");
echo '<div align="right"><font face="verdana" size="3"><b>'.$lTechParam.'</b></font><br><font size="2"><a href="index.php">'.$lSommaire.'</a></font></div>';

if($valid!='')
{
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "UPDATE mcnews_design SET lang='$langfile2', nbnews='$nbnews2', nbliste='$nbliste2', emailadmin='$emailadmin2', nomadmin='$nomadmin2', urlsite='$urlsite2', valnews='$valnews', valcom='$valcom'";
mysql_query($query, $connect);

?>
   <script language="JavaScript">
   document.location.replace("index.php");
   </script>
<?

}
else {
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
$langfile=$row['lang'];
         if($row['valnews']==1) {$checkn='checked';}
         if($row['valcom']==1) {$checkc='checked';}

}
?>
<form action="tech.php" method="post">
<table width="600" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">

<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<?
// Début Langue
 echo $lChoisirLang.'</font></td>';
 echo '<td bgcolor="#CCCCCC"><select name="langfile2" size="1">';
$aryLangs = array();
$dirCurrent = dir(lang);
while($strFile=$dirCurrent->read()) {
  if (is_file('lang/'.$strFile)) {
    $aryLangs[] = 'lang/'.$strFile;
  }
}
$dirCurrent->close();

if (count($aryLangs) > 1) { sort ($aryLangs); }

$file = current($aryLangs);
while ($file) {
  if($file!="lang/blank.php"){
    $intStartLang = strpos($file, '/') + 1;
    $intLengthLang = strrpos($file, '.') - $intStartLang;
    $text=ucwords(substr($file,$intStartLang,$intLengthLang));
    echo '<option value="'.$file.'"';
    if($file==$langfile) echo ' selected';
    echo '>'.$text.'</option>';
  }
  $file = next($aryLangs);
}
echo '</select>';
// Fin Langue
?>
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lNbNews; ?></font></td>
<td bgcolor="#CCCCCC"><input type="text" name="nbnews2" value="<? echo $row['nbnews']; ?>" size="6"></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lNbListe; ?></font></td>
<td bgcolor="#CCCCCC"><input type="text" name="nbliste2" value="<? echo $row['nbliste']; ?>" size="6"></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lNews; ?></font></td>
<td bgcolor="#CCCCCC"><input type="checkbox" name="valnews" value="1" <? echo $checkn; ?>><font face="verdana" size="2">&nbsp;<? echo $lMustval; ?></font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lComments; ?></font></td>
<td bgcolor="#CCCCCC"><input type="checkbox" name="valcom" value="1" <? echo $checkc; ?>><font face="verdana" size="2">&nbsp;<? echo $lMustval; ?></font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lEmail; ?></font></td>
<td bgcolor="#CCCCCC"><input type="text" name="emailadmin2" value="<? echo $row['emailadmin']; ?>" size="25"></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lNomAdmin; ?></font></td>
<td bgcolor="#CCCCCC"><input type="text" name="nomadmin2" value="<? echo $row['nomadmin']; ?>" size="25"></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lSite; ?></font></td>
<td bgcolor="#CCCCCC"><input type="text" name="urlsite2" value="<? echo $row['urlsite']; ?>" size="25"></td>
</tr>

<tr>
<td bgcolor="#CCCCCC">&nbsp;
<td bgcolor="#CCCCCC"><input type="submit" name="valid" value="<? echo $lSubmit; ?>">
</td></tr></table>
</form>

<?
include ("footer.php");
?>

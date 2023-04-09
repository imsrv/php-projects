<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
include ("conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
include ("admin/$row[lang]");
include ("admin/$row[skin]");
$listnews= $row['nbliste'];
$skin=$row['skin'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>mcNews</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a:actif {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:link {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:visited {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:hover {  font-family: <? echo $FontLien; ?>; color: <?echo $LienSurvolColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
-->
</style>
</head>
<body bgcolor="<? echo $BodyBgcolor; ?>" text="black">


<table width="480" border="0" cellspacing="0" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<?
// REPLACE THIS BY ANYTHING YOU WANT ----------------------------
// REMPLACEZ CE QUI SUIT PAR CE QUE VOUS VOULEZ ----------------
echo '<tr><td align="right" colspan="3" bgcolor="'.$TDBgcolorTexte.'"><font face="'.$FontFace.'" size="4" color="'.$FontColorTitre.'">';
echo 'mcNews 1.3';
echo '</font></td></tr>';
// FIN DE LA ZONE A REMPLACER ----------------------------------
// END OF THE AREA ---------------------------------------------
?>
<tr>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         &nbsp;<a href="index.php"><? echo $lLast; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="center"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="list.php"><? echo $lListe; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="right"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="ecrire.php"><? echo $lPropo; ?></a>&nbsp;</font></td>
</tr>

</table>

<form action="search.php" method="post">
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>" align="center"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorAuteur; ?>" size="<? echo $FontSizeAuteur; ?>">
         <? echo $lSearch; ?> : <input type="text" size="35" name="motclef" value="<? echo $motcle; ?>"><br>
         <? echo $lAvec; ?> :
         <select name="par">
         <option value="tous" selected><? echo $lTous; ?></option>
         <option value="un"><? echo $lUn; ?></option>
         </select>
         <? echo $lDans; ?> : </font>
         <select name="critere">
         <option value="titre" selected><? echo $lTitre; ?></option>
         <option value="auteur"><? echo $lAuteur; ?></option>
         <option value="texte"><? echo $lTexte; ?></option>
         </select>
         <input type="submit" name="submit" value="OK">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTexte; ?>" align="center"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>">
         <? echo $lMethode; ?></font>
</td>
</tr>
</table>
</form>

<?
if (isset($submit))
{
$motclef=str_replace(" ","",$motclef);
if($par=="tous") $conj="and";
else $conj="or";
list($m1,$m2,$m3) = explode(",",$motclef);
         if(isset($m1)) $like= $critere.' like \'%'.$m1.'%\'';
         if(isset($m2)) $like= $critere.' like \'%'.$m1.'%\' '.$conj.' '.$critere.' like \'%'.$m2.'%\'';
         if(isset($m3)) $like= $critere.' like \'%'.$m1.'%\' '.$conj.' '.$critere.' like \'%'.$m2.'%\' '.$conj.' '.$critere.' like \'%'.$m3.'%\'';

?>
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">

<?
$query2="SELECT id, date, titre, auteur FROM mcnews_news WHERE valid='Y' AND $like ORDER BY date DESC";
$result=mysql_query($query2, $connect);
while($news=mysql_fetch_array($result))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$news['date']);
         $news['date'] = $d.' '.$m.' '.$y;
         }

?>

<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>">
         <a href="lire.php?n=<? echo $news['id']; ?>"><? echo $news['date'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.stripslashes($news['titre']).'&nbsp;&nbsp;-&nbsp;&nbsp;<i>'.stripslashes($news['auteur']).'</i>'; ?></a></font></td>
</tr>


<?
}
echo '</table>';
}
include ("footer.php");
?>

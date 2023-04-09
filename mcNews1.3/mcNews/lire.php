<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
include ("conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
include ("admin/$row[lang]");
include ("admin/$row[skin]");
$nbnews= $row['nbnews'];
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
         &nbsp;<a href="index.php"><? echo $nbnews.' '.$lLast; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="center"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="search.php"><? echo $lSearch; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="right"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="ecrire.php"><? echo $lPropo; ?></a>&nbsp;</font></td>
</tr>
</table>
<?
$query2="SELECT * FROM mcnews_news WHERE id=$n";
$result=mysql_query($query2, $connect);
$news=mysql_fetch_array($result);

         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$news['date']);
         $sep= "-";
         $news['date'] = $d.$sep.$m.$sep.$y;
         }

         $news['texte']=preg_replace('/([^ ]{30})/si','\\1 ',$news['texte']);

         $news['texte']=eregi_replace(':\)','<img src="images/content.gif" align="middle" border="0" alt=":\)">', $news['texte']);
         $news['texte']=eregi_replace(':grr:','<img src="images/grr.gif" align="middle" border="0" alt=":grr:">', $news['texte']);
         $news['texte']=eregi_replace('\?!\?','<img src="images/crazy2.gif" align="middle" border="0" alt="\?!\?">', $news['texte']);
         $news['texte']=eregi_replace(':\(','<img src="images/cry.gif" align="middle" border="0" alt=":\(">', $news['texte']);


?>
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<tr>
<td bgcolor="<? echo $BodyBgcolor; ?>">
         &nbsp;</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTitre; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTitre; ?>" color="<? echo $FontColorTitre; ?>"><b>
         <? echo $news['date'].'&nbsp;&nbsp;'.stripslashes($news['titre']); ?></b></font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lAuteur.' : <b>'.stripslashes($news['auteur']).'</b>&nbsp;&nbsp;&nbsp;';
         if ($news['email']!="")  {
         echo '<a href="mailto.php?m='.$news['id'].'"><img src="images/ecrire.gif" border="0" alt="'.$lEcrire.'"></a>&nbsp;';
         }
         if ($news['site']!="")   {
         echo '<a href="'.$news['site'].'" target="_blank"><img src="images/home.gif" border="0" alt="'.$lSite.'"></a>';
         }
         ?>
         </font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTexte; ?>" color="<? echo $FontColorTexte; ?>">
         <br>&nbsp;&nbsp;<? echo nl2br(stripslashes($news['texte'])); ?>
         <br>&nbsp;
         <?
         if(($news['lien1']) || ($news['lien2']) || ($news['lien3']))
         {
         echo '<br><font size="1">'.$lLiensRapp.' :</font><br>';
         }
         if($news['lien1'])
         echo '<a href="'.$news['lien1'].'" target="_blank">'.$news['lien1'].'</a> &nbsp; '.stripslashes($news['descr1']).'<br>';
         if($news['lien2'])
         echo '<a href="'.$news['lien2'].'" target="_blank">'.$news['lien2'].'</a> &nbsp; '.stripslashes($news['descr2']).'<br>';
         if($news['lien3'])
         echo '<a href="'.$news['lien3'].'" target="_blank">'.$news['lien3'].'</a> &nbsp; '.stripslashes($news['descr3']);


         ?>
         </font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTexte; ?>" color="<? echo $FontColorTexte; ?>">
         <? echo $lcomment; ?>
         &nbsp;:&nbsp;&nbsp;
         <a href="comment.php?n=<? echo $news['id']; ?>"><? echo $lEcrire; ?></a>
         </font>
</td></tr>
</table>

<?
// Commentaires
$query3="SELECT * FROM mcnews_comment WHERE idnews=$n AND valid='Y'";
$resultat=mysql_query($query3, $connect);
$nbcom=1;
while($news=mysql_fetch_array($resultat))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$news['date']);
         $sep= "-";
         $news['date'] = $d.' '.$m.' '.$y;
         }

         $news['texte']=preg_replace('/([^ ]{20})/si','\\1 ',$news['texte']);

         $news['texte']=eregi_replace(':\)','<img src="images/content.gif" align="middle" border="0" alt=":\)">', $news['texte']);
         $news['texte']=eregi_replace(':grr:','<img src="images/grr.gif" align="middle" border="0" alt=":grr:">', $news['texte']);
         $news['texte']=eregi_replace('\?!\?','<img src="images/crazy2.gif" align="middle" border="0" alt="\?!\?">', $news['texte']);
         $news['texte']=eregi_replace(':\(','<img src="images/cry.gif" align="middle" border="0" alt=":\(">', $news['texte']);


?>
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<tr>
<td bgcolor="<? echo $BodyBgcolor; ?>">
         &nbsp;</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTitre; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTitre; ?>" color="<? echo $FontColorTitre; ?>"><b>
         <? echo $news['date'].'&nbsp;&nbsp;'.$lCommentNum.' '.$nbcom; $nbcom++;?></b></font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lComment.' : <b>'.stripslashes($news['auteur']).'</b>&nbsp;&nbsp;&nbsp;';
         if ($news['email']!="")  {
         echo '<a href="mailto.php?m='.$news['id'].'"><img src="images/ecrire.gif" border="0" alt="'.$lEcrire.'"></a>&nbsp;';
         }
         if ($news['site']!="")   {
         echo '<a href="'.$news['site'].'" target="_blank"><img src="images/home.gif" border="0" alt="'.$lSite.'"></a>';
         }
         ?>
         </font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTexte; ?>" color="<? echo $FontColorTexte; ?>">
         <br>&nbsp;&nbsp;<? echo nl2br(stripslashes($news['texte'])); ?>
         <br>&nbsp;
         <?
         if(($news['lien1']) || ($news['lien2']) || ($news['lien3']))
         {
         echo '<br><font size="1">'.$lLiensRapp.' :</font><br>';
         }
         if($news['lien1'])
         echo '<a href="'.$news['lien1'].'" target="_blank">'.$news['lien1'].'</a> &nbsp; '.stripslashes($news['descr1']).'<br>';
         if($news['lien2'])
         echo '<a href="'.$news['lien2'].'" target="_blank">'.$news['lien2'].'</a> &nbsp; '.stripslashes($news['descr2']).'<br>';
         if($news['lien3'])
         echo '<a href="'.$news['lien3'].'" target="_blank">'.$news['lien3'].'</a> &nbsp; '.stripslashes($news['descr3']);


         ?>
         </font></td>
</tr>

</table>
<?
}
include ("footer.php");
?>

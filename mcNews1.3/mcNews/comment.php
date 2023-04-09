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


<table width="480" border="0" cellspacing="0" cellpadding="2" bgcolor="<? echo $TableBgcolor; ?>" align="center">
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
         <a href="list.php"><? echo $lListe; ?></a>&nbsp;</font></td>
</tr>
</table>
<?
         function EmailOK($email)
         {
         return ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',$email);
         }
if(isset($submit))
{
         if($auteur=='admin')
         {
         ?>
         <script language="JavaScript">
   document.location.replace("admin/login.php?path=<? echo("comment.php?idnews=$idnews"); ?>");
   </script>
         <?
         exit();
         }

         if((!$auteur)||(!$texte))
         {
         echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorAuteur.'">';
         echo '<b>'.$lErreur.'</b></font></center>';
         unset($form);
         }
         elseif(($email!="")&&(!EmailOK($email)))
         {
         echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorTitre.'">';
         echo '<b>'.$lErreurEmail.'</b></font></center>';
         unset($form);
         }
         else
         {
$date=date("Y-m-d");

$auteur=htmlspecialchars(addslashes($auteur));
$titre=htmlspecialchars(addslashes($titre));
$texte=htmlspecialchars(addslashes($texte));
$descr1=htmlspecialchars(addslashes($descr1));
$descr2=htmlspecialchars(addslashes($descr2));
$descr3=htmlspecialchars(addslashes($descr3));
        if ($row['valcom']==1) {$valcom='N';}
         else
         {
         $valcom='Y';
         $lGoValid='';
         }
$query = "INSERT INTO mcnews_comment VALUES(NULL, '$idnews', '$date', '$auteur', '$site', '$email', '$texte', '$lien1', '$descr1', '$lien2', '$descr2', '$lien3', '$descr3', '$valcom')";
mysql_query($query, $connect);
// envoi email
if ($row['emailadmin']!="")
{
$querytitre= "SELECT titre FROM mcnews_news WHERE id='$idnews'";
$result=mysql_query($querytitre, $connect);
$titrenews= mysql_fetch_array($result);
if ($email!='')  { $emailfrom=$email; }
else  { $emailfrom="system@mcnews.com"; }
mail("$row[emailadmin]","mcNews","$lPostCom.\n$lDate : $date\n$lAuteur : $auteur\n$lSite : $site\n$lEmail : $email\n$lTitre : $titrenews[0]\n$lTexte : $texte\n$lLiensRapp :\n$lien1 $descr1\n$lien2 $descr2\n$lien3 $descr3\n\n\n$lGoValid","from : $emailfrom");
}
// fin envoi email
echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorAuteur.'">';
       if($valcom=='N')  {echo '<b>'.$lMerci.'</b></font></center>';}
       else  {echo '<b>'.$lMercival.'</b></font></center>';}

         $form=1;
         }
}
if(!$form)
{
?>
<form action="comment.php" method="post">
<table width="480" border="0" cellspacing="1" cellpadding="2" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<tr>
<td bgcolor="<? echo $TDBgcolorTitre; ?>" colspan="2" align="center"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTitre; ?>" color="<? echo $FontColorTitre; ?>">
         <b><? echo $lEcrireComment; ?><br></b></font>
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lLogin; ?> :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="auteur" size="20" value="<? echo $auteur; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lEmail; ?> :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="email" size="20" value="<? echo $email; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lSite; ?> :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="site" size="20" value="<? echo $site; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <b>
             <img src="images/content.gif" align="middle" alt=":)" border="0"> &nbsp; :)
         <br><img src="images/cry.gif" align="middle" alt=":(" border="0"> &nbsp; :(
         <br><img src="images/grr.gif" align="middle" alt=":grr:" border="0"> &nbsp; :grr:
         <br><img src="images/crazy2.gif" align="middle" alt="?!?" border="0"> &nbsp; ?!?
         </b></font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <textarea name="texte" rows="8" cols="40"><? echo $texte; ?></textarea>
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lLien; ?> 1 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <input type="text" name="lien1" size="20" value="<? echo $lien1; ?>">(http://www.site.com)</font>
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lDescr; ?> 1 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="descr1" size="20" value="<? echo $descr1; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lLien; ?> 2 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="lien2" size="20" value="<? echo $lien2; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lDescr; ?> 2 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="descr2" size="20" value="<? echo $descr2; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lLien; ?> 3 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="lien3" size="20" value="<? echo $lien3; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lDescr; ?> 3 :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="descr3" size="20" value="<? echo $descr3; ?>">
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         &nbsp;</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="hidden" name="idnews" value="<? echo $n; ?>">
         <input type="submit" name="submit" value="<? echo $lSubmit; ?>">
</td>
</tr>

</table>
</form>
<?
}
include ("footer.php");
?>

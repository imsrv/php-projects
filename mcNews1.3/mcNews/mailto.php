<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
include ("conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
include ("admin/$row[lang]");
include ("admin/$row[skin]");

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
<tr>
<td bgcolor="<? echo $BodyBgcolor; ?>" colspan="3">
         &nbsp;</td>
</tr>
</table>

<?



         function EmailOK($from)
         {
         return ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',$from);
         }

if (isset($submit))
{

         if((!$from)||(!$sujet)||(!$texte))
         {
         echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorAuteur.'">';
         echo '<b>'.$lErreurMail.'</b></font></center>';
         unset($submit);
         }
         elseif(!EmailOK($from))
         {
         echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorTitre.'">';
         echo '<b>'.$lInvalidEmail.'</b></font></center>';
         unset($submit);
         }
         else
         {
         $query="SELECT email, auteur FROM mcnews_news WHERE id=$m";
         $resultat=mysql_query($query, $connect);
         $res = mysql_fetch_array($resultat);
         $to=$res['email'];
        $texte=stripslashes($texte);
         mail("$to","$sujet","$texte","From :$from");
         echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorTitre.'">';
         echo '<b>'.$lMailSent.' '.$res['auteur'].'</b></font></center>';
         }
}
if(!isset($submit))
{
$query2="SELECT id, auteur FROM mcnews_news WHERE id=$m";
$result=mysql_query($query2, $connect);
$res = mysql_fetch_array($result);

?>
<form method="post" action="mailto.php">
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">

<tr>
<td bgcolor="<? echo $TDBgcolorTitre; ?>" align="center" colspan="2"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeTitre; ?>" color="<? echo $FontColorTitre; ?>">
         <b><?echo $lMailTo.' '.$res['auteur']; ?></b></font></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
          <? echo $lLogin; ?></font></td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
          <input type="text" name="nom" value="<? echo $nom; ?>" size="25"></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
          <? echo $lEmail; ?></font></td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
          <input type="text" name="from" value="<? echo $from; ?>" size="25"></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
          <? echo $lSujet; ?></font></td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
          <input type="text" name="sujet" value="<? echo $sujet; ?>" size="25"></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
          <? echo $lTexte; ?></font></td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
          <textarea name="texte" cols="40" rows="5"><? echo $texte; ?></textarea></td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
          &nbsp;</font></td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
          <input type="hidden" name="m" value="<? echo $res['id']; ?>">
          <input type="submit" name="submit" value="<? echo $lSubmit; ?>">

          </td>
</tr>
</table>
</form>
<?
}
include ("footer.php");
?>

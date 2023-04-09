<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("header.php");
if($modn!='') $t=$lModifNews;
if($modc!='') $t=$lModifComm;
echo '<div align="right"><font face="verdana" size="3"><b>'.$t.'</b></font><br><font size="2"><a href="index.php">'.$lSommaire.'</a></font></div>';

$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);

if($submitn!='')
{
$titre=addslashes($titre);
$auteur=addslashes($auteur);
$texte=addslashes($texte);
$descr1=addslashes($descr1);
$descr2=addslashes($descr2);
$descr3=addslashes($descr3);
$query = "UPDATE mcnews_news SET titre='$titre', auteur='$auteur', site='$site', email='$email', texte='$texte', lien1='$lien1', descr1='$descr1', lien2='$lien2', descr2='$descr2', lien3='$lien3', descr3='$descr3', valid='N' WHERE id='$id'";
$result = mysql_query($query, $connect);
?>
   <script language="JavaScript">
   document.location.replace("valid.php?id=<? echo $id; ?>");
   </script>
<?
}

if($submitc!='')
{
$auteur=addslashes($auteur);
$texte=addslashes($texte);
$descr1=addslashes($descr1);
$descr2=addslashes($descr2);
$descr3=addslashes($descr3);
$query = "UPDATE mcnews_comment SET auteur='$auteur', site='$site', email='$email', texte='$texte', lien1='$lien1', descr1='$descr1', lien2='$lien2', descr2='$descr2', lien3='$lien3', descr3='$descr3', valid='N' WHERE id='$id'";
$result = mysql_query($query, $connect);
?>
   <script language="JavaScript">
   document.location.replace("valid.php?id=<? echo $idnews; ?>");
   </script>
<?
}
else
{

if($modn!='')
{
$intro= $lModifNews;
$submit='submitn';
$query = "SELECT * FROM mcnews_news WHERE id='$modn'";
$result = mysql_query($query, $connect);
$fiche = mysql_fetch_array($result, $connect);
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$fiche['date']);
         $fiche['date'] = $d.' '.$m.' '.$y;
         }

}

if($modc!='')
{
$intro= $lModifComm;
$submit='submitc';
$query = "SELECT * FROM mcnews_comment WHERE id='$modc'";
$result = mysql_query($query, $connect);
$fiche = mysql_fetch_array($result, $connect);
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$fiche['date']);
         $fiche['date'] = $d.' '.$m.' '.$y;
         }

}
$fiche['titre']=htmlspecialchars(stripslashes($fiche['titre']));
$fiche['auteur']=htmlspecialchars(stripslashes($fiche['auteur']));
$fiche['texte']=htmlspecialchars(stripslashes($fiche['texte']));
$fiche['descr1']=htmlspecialchars(stripslashes($fiche['descr1']));
$fiche['descr2']=htmlspecialchars(stripslashes($fiche['descr2']));
$fiche['descr3']=htmlspecialchars(stripslashes($fiche['descr3']));
$titrenews=htmlspecialchars(stripslashes($titrenews));
?>
<br>
<form action="modify.php" method="post">
<table width="600" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
<tr>
<td bgcolor="#CCCCCC" colspan="2"><font face="verdana" size="3">
<b><? echo $intro; ?></b></font>
</td>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lDate; ?></font>
</td>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $fiche['date']; ?></font>
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lTitre; ?></font>
</td>
<td bgcolor="#CCCCCC">
<?
if($titrenews)
echo '<font face="verdana" size="2"><b>'.urldecode($titrenews).'</b></font>';
if($fiche['titre'])
echo '<input type="text" size="40" name="titre" value="'.$fiche['titre'].'">';
?>
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lAuteur; ?></font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="auteur" value="<? echo $fiche['auteur']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lEmail; ?></font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="email" value="<? echo $fiche['email']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lSite; ?></font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="site" value="<? echo $fiche['site']; ?>">
</td></tr>

<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
 <b>
             <img src="../images/content.gif" align="middle" alt=":)" border="0"> &nbsp; :)
         <br><img src="../images/cry.gif" align="middle" alt=":(" border="0"> &nbsp; :(
         <br><img src="../images/grr.gif" align="middle" alt=":grr:" border="0"> &nbsp; :grr:
         <br><img src="../images/crazy2.gif" align="middle" alt="?!?" border="0"> &nbsp; ?!?
         </b></font>
</td>
<td bgcolor="#CCCCCC">
<textarea rows="5" cols="38" name="texte"><? echo $fiche['texte']; ?></textarea>
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lLien; ?> 1</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="lien1" value="<? echo $fiche['lien1']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lDescr; ?> 1</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="descr1" value="<? echo $fiche['descr1']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lLien; ?> 2</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="lien2" value="<? echo $fiche['lien2']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lDescr; ?> 2</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="descr2" value="<? echo $fiche['descr2']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lLien; ?> 3</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="lien3" value="<? echo $fiche['lien3']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<? echo $lDescr; ?> 3</font>
</td>
<td bgcolor="#CCCCCC">
<input type="text" size="40" name="descr3" value="<? echo $fiche['descr3']; ?>">
</td></tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
&nbsp;</font>
</td>
<td bgcolor="#CCCCCC">
<input  type="hidden" name="id" value="<? echo $fiche['id']; ?>">
<input  type="hidden" name="idnews" value="<? echo $fiche['idnews']; ?>">
<input type="submit" name="<? echo $submit; ?>" value="<? echo $lSubmit; ?>">
</td></tr>
</table>
</form>
<?
}
include ("footer.php");
?>

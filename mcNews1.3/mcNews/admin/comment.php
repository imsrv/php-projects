<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("header.php");


$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
$skinfile=$row['skin'];
include("$skinfile");

echo '<div align="right"><font face="verdana" size="3"><b>'.$lPubliCom.'</b></font><br><font size="2"><a href="index.php">'.$lSommaire.'</a></font></div>';


if(isset($submit))
{
$form=1;

$date=date("Y-m-d");


$titre=htmlspecialchars(addslashes($titre));
$texte=addslashes($texte);
$descr1=htmlspecialchars(addslashes($descr1));
$descr2=htmlspecialchars(addslashes($descr2));
$descr3=htmlspecialchars(addslashes($descr3));

$query = "insert into mcnews_comment VALUES(NULL, '$idnews', '$date', '$auteur', '', '$email', '$texte', '$lien1', '$descr1', '$lien2', '$descr2', '$lien3', '$descr3', 'Y')";
mysql_query($query, $connect);
echo '<center><font face="'.$FontFace.'" size="'.$FontSizeTitre.'" color="'.$FontColorTitre.'">';
         echo '<b>OK</b></font></center>';

}
if(!isset($form))
{
?>
<form action="comment.php" method="post">
<table width="480" border="0" cellspacing="1" cellpadding="2" bgcolor="<? echo $TableBgcolor; ?>" align="center">

<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lLogin; ?> :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $row['nomadmin']; ?></font>
</td>
</tr>
<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $lEmail; ?> :</font>
</td>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <? echo $row['emailadmin']; ?></font>
</td>
</tr>

<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorAuteur; ?>">
         <b>
             <img src="../images/content.gif" align="middle" alt=":)" border="0"> &nbsp; :)
         <br><img src="../images/cry.gif" align="middle" alt=":(" border="0"> &nbsp; :(
         <br><img src="../images/grr.gif" align="middle" alt=":grr:" border="0"> &nbsp; :grr:
         <br><img src="../images/crazy2.gif" align="middle" alt="?!?" border="0"> &nbsp; ?!?
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
<td bgcolor="<? echo $TDBgcolorAuteur; ?>">
         <input type="text" name="lien1" size="20" value="<? echo $lien1; ?>">
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
         <input type="hidden" name="auteur" value="<? echo $row['nomadmin']; ?>">
         <input type="hidden" name="email" value="<? echo $row['emailadmin']; ?>">
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

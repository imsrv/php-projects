<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("header.php");
echo '<div align="right"><font face="verdana" size="3"><b>'.$lAccept.' '.$lModifier.' '.$lDel.'</b></font><br><font size="2"><a href="index.php">'.$lSommaire.'</a></font></div>';

$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);

$query = "SELECT * FROM mcnews_news WHERE id='$id'";
$result = mysql_query($query, $connect);
$fiche = mysql_fetch_array($result, $connect);
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$fiche['date']);
         $fiche['date'] = $d.' '.$m.' '.$y;
         }
$fiche['titre']=stripslashes($fiche['titre']);
$fiche['auteur']=stripslashes($fiche['auteur']);
$fiche['texte']=stripslashes($fiche['texte']);
$fiche['descr1']=stripslashes($fiche['descr1']);
$fiche['descr2']=stripslashes($fiche['descr2']);
$fiche['descr3']=stripslashes($fiche['descr3']);

         $fiche['texte']=preg_replace('/([^ ]{30})/si','\\1 ',$fiche['texte']);

         $fiche['texte']=eregi_replace(':\)','<img src="../images/content.gif" align="middle" border="0" alt=":\)">', $fiche['texte']);
         $fiche['texte']=eregi_replace(':grr:','<img src="../images/grr.gif" align="middle" border="0" alt=":grr:">', $fiche['texte']);
         $fiche['texte']=eregi_replace('\?!\?','<img src="../images/crazy2.gif" align="middle" border="0" alt="\?!\?">', $fiche['texte']);
         $fiche['texte']=eregi_replace(':\(','<img src="../images/cry.gif" align="middle" border="0" alt=":\(">', $fiche['texte']);

?>
<br>
<table width="480" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
<tr>
<td bgcolor="#AAAAAA"><font face="verdana" size="2"><b><? echo $fiche['date']; ?>&nbsp;&nbsp;<? echo $fiche['titre']; ?></b></font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lAuteur.': <b>'.$fiche['auteur'].'</b>';
if($fiche['email']!='')
{
echo '<br>&nbsp;&nbsp;<a href="mailto:'.$fiche['email'].'">'.$fiche['email'].'</a>';
}
if($fiche['site']!='')
{
echo '<br>&nbsp;&nbsp;<a href="'.$fiche['site'].'" target="_blank">'.$fiche['site'].'</a>';
}
?>

</font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><br>
<? echo nl2br($fiche['texte']).'<br>&nbsp;';
if(($fiche['lien1']!='') || ($fiche['lien2']!='') || ($fiche['lien3']!=''))
{
echo '<br><font size="1">'.$lLiensRapp.' :</font><br>';
}
         if($fiche['lien1']!='')
         echo '<a href="'.$fiche['lien1'].'" target="_blank">'.$fiche['lien1'].'</a> &nbsp; '.$fiche['descr1'].'<br>';
         if($fiche['lien2']!='')
         echo '<a href="'.$fiche['lien2'].'" target="_blank">'.$fiche['lien2'].'</a> &nbsp; '.$fiche['descr2'].'<br>';
         if($fiche['lien3']!='')
         echo '<a href="'.$fiche['lien3'].'" target="_blank">'.$fiche['lien3'].'</a> &nbsp; '.$fiche['descr3'];


?>

</font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2">
<a href="comment.php?n=<? echo $fiche['id']; ?>"><? echo $lPubliCom; ?></a>
</font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC" align="right"><font face="verdana" size="2">
<?
if($fiche['valid']=="Y")
{
echo '<font color="red"><b>'.$lValid.' </b></font>';
}
else
{
echo '<a href="action.php?valn='.$id.'">'.$lAccept.' </a>';
}

echo '-<a href="modify.php?modn='.$id.'"> '.$lModifier.' </a>-';
echo '<a href="action.php?supn='.$id.'">'.$lDel.' </a>';
?>
</font>
</td>
</tr>
</table>
<?
$query= "SELECT * FROM mcnews_comment WHERE idnews='$id' ORDER BY date DESC";
$resultat=mysql_query($query, $connect);
while($comment=(mysql_fetch_array($resultat)))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$comment['date']);
         $comment['date'] = $d.' '.$m.' '.$y;
         }
$comment['titre']=stripslashes($comment['titre']);
$comment['auteur']=stripslashes($comment['auteur']);
$comment['texte']=stripslashes($comment['texte']);
$comment['descr1']=stripslashes($comment['descr1']);
$comment['descr2']=stripslashes($comment['descr2']);
$comment['descr3']=stripslashes($comment['descr3']);

         $comment['texte']=preg_replace('/([^ ]{30})/si','\\1 ',$comment['texte']);

         $comment['texte']=eregi_replace(':\)','<img src="../images/content.gif" align="middle" border="0" alt=":\)">', $comment['texte']);
         $comment['texte']=eregi_replace(':grr:','<img src="../images/grr.gif" align="middle" border="0" alt=":grr:">', $comment['texte']);
         $comment['texte']=eregi_replace('\?!\?','<img src="../images/crazy2.gif" align="middle" border="0" alt="\?!\?">', $comment['texte']);
         $comment['texte']=eregi_replace(':\(','<img src="../images/cry.gif" align="middle" border="0" alt=":\(">', $comment['texte']);

?>
<table width="480" border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
<tr>
<td bgcolor="#AAAAAA"><font face="verdana" size="2"><b><? echo $comment['date']; ?></b></font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><? echo $lComment; ?> :<b>
<?
echo $comment['auteur'].'</b>';
if($comment['email']!='')
{
echo '<br>&nbsp;&nbsp;<a href="mailto:'.$comment['email'].'">'.$comment['email'].'</a>';
}
if($comment['site']!='')
{
echo '<br>&nbsp;&nbsp;<a href="'.$comment['site'].'" target="_blank">'.$comment['site'].'</a>';
}
?>
</font></td>
</tr>
<tr>
<td bgcolor="#CCCCCC"><font face="verdana" size="2"><br>
<? echo nl2br($comment['texte']).'<br>&nbsp;';
if(($comment['lien1']!='') || ($comment['lien2']!='') || ($comment['lien3']!=''))
{
echo '<br><font size="1">'.$lLiensRapp.' :</font><br>';
}
         if($comment['lien1']!='')
         echo '<a href="'.$comment['lien1'].'" target="_blank">'.$comment['lien1'].'</a> &nbsp; '.$comment['descr1'].'<br>';
         if($comment['lien2']!='')
         echo '<a href="'.$comment['lien2'].'" target="_blank">'.$comment['lien2'].'</a> &nbsp; '.$comment['descr2'].'<br>';
         if($comment['lien3']!='')
         echo '<a href="'.$comment['lien3'].'" target="_blank">'.$comment['lien3'].'</a> &nbsp; '.$comment['descr3'];

?>
</font>
</td>
</tr>
<tr>
<td bgcolor="#CCCCCC" align="right"><font face="verdana" size="2">
<?
if($comment['valid']=="Y")
{
echo '<font color="red"><b>'.$lValid.' </b></font>';
}
else
{
echo '<a href="action.php?valc='.$comment['id'].'&id='.$id.'">'.$lAccept.' </a>';
}

echo '-<a href="modify.php?modc='.$comment['id'].'&amp;titrenews='.urlencode(stripslashes($fiche['titre'])).'"> '.$lModifier.' </a>-';
echo '<a href="action.php?supc='.$comment['id'].'&amp;id='.$id.'">'.$lDel.' </a>';
?>
</font>
</td>
</tr>
</table>
<?

}
include ("footer.php");
?>

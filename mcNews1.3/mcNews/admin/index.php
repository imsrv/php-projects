<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}
include ("header.php");
echo '<div align="right"><font face="verdana" size="3"><b>'.$lSommaire.'</b></font><br><font size="2"><a href="logout.php">'.$lDeconnexion.'</a><br><a href="ecrire.php">'.$lPubliNews.'</a></font></div>';
?>

<font face="verdana, arial" size="2">
<b><? echo $lConf; ?> :</b>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="design.php"><? echo $lDesignParam; ?></a>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="tech.php"><? echo $lTechParam; ?></a>
<br><br>
<?
echo '<b>'.$lNewsTemp.' :</b><br>';

$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT id, date, titre, auteur FROM mcnews_news WHERE valid='N' ORDER BY date DESC";
$result = mysql_query($query, $connect);
while($a=mysql_fetch_array($result))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$a['date']);
         $a['date'] = $d.' '.$m.' '.$y;
         }
$a['titre']=stripslashes($a['titre']);
$a['auteur']=stripslashes($a['auteur']);
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="valid.php?id='.$a['id'].'">'.$a['date'].'&nbsp;-&nbsp;'.$a['titre'].'&nbsp;-&nbsp;<i>par '.$a['auteur'].'</i></a><br>';
}
echo '<br>';
echo '<b>'.$lCommentsTemp.' :</b><br>';
$query = "SELECT n.id, n.date, n.titre, n.auteur FROM mcnews_news as n, mcnews_comment as c WHERE n.valid='Y' AND c.valid='N' AND n.id=c.idnews ORDER BY n.date DESC";
$result = mysql_query($query, $connect);
while($b=mysql_fetch_array($result))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$b['date']);
         $b['date'] = $d.'-'.$m.'-'.$y;
         }
$b['titre']=stripslashes($b['titre']);
$b['auteur']=stripslashes($b['auteur']);
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="valid.php?id='.$b['id'].'">'.$b['date'].'&nbsp;-&nbsp;'.$b['titre'].'&nbsp;-&nbsp;<i>par '.$b['auteur'].'</i></a><br>';
}
echo '<br>';
echo '<b>'.$lNewsValid.' :</b><br>';

         $query = "SELECT c.id FROM mcnews_news as n, mcnews_comment as c WHERE c.idnews=n.id";
         $result = mysql_query($query, $connect);
         $nbcomm = mysql_num_rows($result);
         if ($nbcomm>0)
         {
         $q1="AND c.valid='Y' OR c.valid='' AND n.id=c.idnews";
         $q2=", mcnews_comment as c";
         }
$query = "SELECT n.id, n.date, n.titre, n.auteur FROM mcnews_news as n $q2 WHERE n.valid='Y' $q1 GROUP BY n.id ORDER BY n.date DESC";
$result = mysql_query($query, $connect);
while($a=mysql_fetch_array($result))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$a['date']);
         $a['date'] = $d.'-'.$m.'-'.$y;
         }
$a['titre']=stripslashes($a['titre']);
$a['auteur']=stripslashes($a['auteur']);
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="valid.php?id='.$a['id'].'">'.$a['date'].'&nbsp;-&nbsp;'.$a['titre'].'&nbsp;-&nbsp;<i>par '.$a['auteur'].'</i></a><br>';
}
echo '</font>';
include ("footer.php");
?>

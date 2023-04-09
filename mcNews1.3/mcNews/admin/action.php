<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net

session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("../conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);

if($valn!='')
{
$query="UPDATE mcnews_news SET valid ='Y' WHERE id ='$valn'";
mysql_query($query, $connect);
?>
<script language="JavaScript">
   document.location.replace("valid.php?id=<? echo $valn; ?>");
</script>
<?
}
if($supn!='')
{
$query="DELETE FROM mcnews_news WHERE id ='$supn'";
mysql_query($query, $connect);
$query="DELETE FROM mcnews_comment WHERE idnews ='$supn'";
mysql_query($query, $connect);
?>
<script language="JavaScript">
   document.location.replace("index.php");
</script>
<?
}
if($valc!='')
{
$query="UPDATE mcnews_comment SET valid ='Y' WHERE id ='$valc'";
mysql_query($query, $connect);
?>
<script language="JavaScript">
   document.location.replace("valid.php?id=<? echo $id; ?>");
</script>
<?
}
if($supc!='')
{
$query="DELETE FROM mcnews_comment WHERE id ='$supc'";
mysql_query($query, $connect);
?>
<script language="JavaScript">
   document.location.replace("valid.php?id=<? echo $id; ?>");
</script>
<?
}
?>

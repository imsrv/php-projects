<?
if (file_exists("include/config.inc.php")){
  include("include/config.inc.php");
}
else echo "Newsletter not yet configured";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<HTML>
<HEAD>
  <TITLE></TITLE>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</HEAD>
<BODY>
<?
require("include/fonction.php");
require("include/cls.php");

$news = new newsletter; 

// Get the newsletter config
$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig); 

require("include/$news->langfile"); //include the langfile

if(!isset($debut)) $debut=0;
echo "<br><center><img src=\"img/log.gif\" border=\"0\" align=\"middle\">&nbsp;
	<b>".translate("Logs de phpMyNewsletter"). "</b>&nbsp;<img src=\"img/log.gif\" border=\"0\" align=\"middle\">
	</center><br>";

$mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablelog") OR print("ca plante");
$nrows=mysql_num_rows($mysql_result);
$mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablelog order by date desc limit $debut,$news->limitlog") OR print("ca plante");
if($mysql_result)
{
  echo "<center><table cellspacing=0 cellpadding=5 border=0>
		<tr align=center bgcolor=#8090A0>
		<td><b><font size=3 color=#FFFFFF face=verdana> Date - ".translate("Heure")." </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> Format </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> ".translate("Sujet")." </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> Message </font></b></td>
		</tr>";
  while($row = mysql_fetch_row($mysql_result))
    {      
      echo "<tr>
				<td align=center valign=top>".$row[1]."</td>
				<td align=center valign=top><img src=\"img/".$row[2].".gif\" alt=\"format : ".$row[2]."\"></td>
				<td valign=top>".stripslashes(stripslashes($row[3]))."</td>
				<td>".nl2br(stripslashes($row[4]))."<td>
				</tr>"; 
    }
  echo "</table><center><br>";
  
  /****************** Mise en place de la navigation. ************************************/
  $nombre=ceil($nrows/($news->limitlog));
  
  if($debut>0) echo "<a href=history.php?mode=viewlog&debut=".($debut-($news->limitlog))."><img src=\"img/aleft.gif\" border=0 align=\"middle\"></a>  ";	
  if ($nombre>1) 
    for($i=1; $i<=$nombre; $i++)
      echo "<a href=history.php?mode=viewlog&debut=".(($i-1)*($news->limitlog)).">".$i."</a> ";
  if(($debut+($news->limitlog))<$nrows)
    echo "<a href=history.php?mode=viewlog&debut=".($debut+($news->limitlog))."><img src=\"img/aright.gif\" border=0 align=\"middle\"></a>";
  echo "</CENTER>";
}

?>

</BODY>
</HTML>
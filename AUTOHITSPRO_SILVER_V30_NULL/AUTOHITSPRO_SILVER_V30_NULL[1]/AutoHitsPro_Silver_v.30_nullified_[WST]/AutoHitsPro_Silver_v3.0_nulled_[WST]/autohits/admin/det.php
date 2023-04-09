<?
/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/
require('error_inc.php');
require('config_inc.php');
$id=intval($id);

$query = "select * from ".$t_user." where id=".$id." ";      
$result = MYSQL_QUERY($query);
$name=mysql_result($result,0,"name");
$type=mysql_result($result,0,"type");
$credits=mysql_result($result,0,"credits");
@mysql_free_result($result);
$query = "select * from ".$t_site." where idu=".$id." ";      
$result = MYSQL_QUERY($query);
?>
  
<table width="700" border="0" cellspacing="0" cellpadding="4" align="center">
  <tr align="center">
    <td height="20" align=right><strong>Id:</strong></td>
    <td height="20" align=left><?print $id;?></td>
  </tr>
  <tr align="center"> 
    <td width="200" height="20" align=right><b>Name:</b></td>
    <td height="20" align=left><?print $name;?></td>
  </tr>
  <tr align="center"> 
    <td width="200" height="20" align=right><b>Account type:</b></td>
    <td height="20" align=left>
      <?if($type==0){print "Basic";}elseif($type==1){print "Silver";}elseif($type==2){print "Gold";};?>
    </td>
  </tr>
  <tr align="center"> 
    <td width="200" height="20" align=right><b>Account credits:</b></td>
    <td height="20" align=left><?print $credits;?></td>
  </tr>
</table>
  <table width="700" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF" align="center">
    <tr bgcolor="#CCCCCC" align="center"> 
      <td height="20">Site Name</td>
      <td height="20">Site URL</td>
      <td height="20">Total hits</td>
      <td height="20">From last Mail</td>
      <td height="20">Credits</td>
      <td height="20">State</td>
    </tr>
<?
while($row = mysql_fetch_array($result)){
?>
    <tr align="center"> 
      <td height="20"><?print $row["site"];?></td>
      <td height="20"><?print $row["url"];?></td>
      <td height="20"><?print $row["pokaz"];?></td>
      <td height="20"><?$z=0;for($i=0;$i<=6;$i++){$z=$z+$row["p$i"];}print $z;?></td>
      <td height="20"><?print $row["credits"];?></td>
      <td height="20"><?if($row["b"]==0){print "Disabled";}elseif($row["b"]==1){print "Waiting";}elseif($row["b"]==2){print "Enabled";};?></td>
    </tr>
<?
}
@mysql_free_result($result);
$query = "select sum(p1),sum(p2),sum(p3),sum(p4),sum(p5),sum(p6),sum(p0) from ".$t_site." where idu=".$id." ";      
$result = MYSQL_QUERY($query);
?>
  </table>
<p>
  Hits Received on this week
</p>
  <table width="700" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF" align="center">
    <tr bgcolor="#CCCCCC" align="center"> 
      <td height="20">Date</td>
      <td height="20">Received</td>
      <td height="20">Graph</td>
    </tr>
<?
$vsego=0;
for($i=0;$i<=date("w");$i++){
	$vsego=$vsego+mysql_result($result,0,"sum(p$i)");
}
for($i=0;$i<=date("w");$i++){
?>
    <tr align="center"> 
      <td width="100" height="20"><?print date( "d.m.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")));?></td>
      <td width="70" height="20"><?print mysql_result($result,0,"sum(p$i)");?></td>
      <td height="20" align=left><?for($j=0;$j<=@(mysql_result($result,0,"sum(p$i)")*100/$vsego);$j++){print "|";} print " ".@(mysql_result($result,0,"sum(p$i)")*100/$vsego);if($vsego==0){print"0";}?>%</td>
    </tr>
<?
}
@mysql_free_result($result);
$query = "select sum(c1),sum(c2),sum(c3),sum(c4),sum(c5),sum(c6),sum(c0) from ".$t_user." where id=".$id." ";      
$result = MYSQL_QUERY($query);
?>
  </table>
  <table width="700" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF" align="center">
    <tr bgcolor="#CCCCCC" align="center"> 
      <td height="20">Date</td>
      <td height="20">Earned</td>
      <td height="20">Graph</td>
    </tr>
<?
$vsego=0;
for($i=0;$i<=date("w");$i++){
	$vsego=$vsego+mysql_result($result,0,"sum(c$i)");
}
for($i=0;$i<=date("w");$i++){
?>
    <tr align="center"> 
      <td width="100" height="20"><?print date( "d.m.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")));?></td>
      <td width="70" height="20"><?print mysql_result($result,0,"sum(c$i)");?></td>
      <td height="20" align=left><?for($j=0;$j<=@(mysql_result($result,0,"sum(c$i)")*100/$vsego);$j++){print "|";} print " ".@(mysql_result($result,0,"sum(c$i)")*100/$vsego);if($vsego==0){print"0";}?>%</td>
    </tr>
<?
}
?>
  </table>
<?
@mysql_free_result($result);
?>


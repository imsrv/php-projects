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
unset($login,$pwrd,$id);
session_start();
session_register("login","pwrd","id");

if($logout==1){
	session_destroy();
	header("Location: ".$PHP_SELF);
}

require('error_inc.php');
require('config_inc.php');

function auth($log,$pass){
	global $t_user;
	$query = "select id from ".$t_user." where email=\"".$log."\" and pass=\"".$pass."\" ";      
	$result = MYSQL_QUERY($query);
	if(mysql_num_rows($result)>0){
		$id=mysql_result($result,0,"id");
		@mysql_free_result($result);  
		return $id;
	}else{
		@mysql_free_result($result); 
		return 0;
	}
}

if(auth($login,$pwrd)!=0){
	require('header_inc.php');
	$query = "select date from ".$t_user." where id=".$id." ";      
	$result = MYSQL_QUERY($query); 
	$date=mysql_result($result,0,"date");
	@mysql_free_result($result);
	if(mktime(0,0,0,date("m"),date("d"),date("Y"))>mktime(0,0,0,substr($date,strlen($date)-5,2)+1,substr($date,strlen($date)-2),substr($date,0,4))){
		$query="update ".$t_user." set type=0  where id=".$id;	
		@mysql_query($query);   
	}
	$query = "select * from ".$t_user." where id=".$id." ";      
	$result = MYSQL_QUERY($query);
	$name=mysql_result($result,0,"name");
	$type=mysql_result($result,0,"type");
	$credits=mysql_result($result,0,"credits");
	@mysql_free_result($result);

	$query = "select * from ".$t_site." where idu=".$id." ";      
	$result = MYSQL_QUERY($query);
	require('menu.php');
?>
  <table width="600" border="0" cellspacing="2" cellpadding="2">
    <tr align="center"> 
      <td width="150" height="20" align=right><b>Name:</b></td>
      <td height="20" align=left><a href="edit.php"><font color=blue><?print $name;?></font></a></td>
    </tr>
    <tr align="center"> 
      <td width="150" height="20" align=right><b>E-mail:</b></td>
      <td height="20" align=left><a href="editmail.php"><font color=blue><?print $login;?></font></a></td>
    </tr>
    <tr align="center"> 
      <td width="150" height="20" align=right><b>User ID:</b></td>
      <td height="20" align=left><?print $id;?></td>
    </tr>
    <tr align="center"> 
      <td width="150" height="20" align=right><b>Account type:</b></td>
      <td height="20" align=left><a href="type.php"><font color=blue><?if($type==0){print "<font color=red><b>Basic</b></font>";}elseif($type==1){print "Silver";}elseif($type==2){print "Gold";};?></font></a></td>
    </tr>
    <tr align="center"> 
      <td width="150" height="20" align=right><b>Account credits:</b></td>
      <td height="20" align=left><a href="buy.php"><font color=blue><?print $credits;?></font></a></td>
    </tr>
  </table>
  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF">
    <tr bgcolor="#006699" align="center"> 
      <td height="20"><font color="#FFFFFF">Site Name</font></td>
      <td height="20"><font color="#FFFFFF">Site URL</font></td>
      <td height="20"><font color="#FFFFFF">Total hits</font></td>
      <td height="20"><font color="#FFFFFF">From last Mail</font></td>
      <td height="20"><font color="#FFFFFF">Credits</font></td>
      <td height="20"><font color="#FFFFFF">State</font></td>
    </tr>
<?
	while($row = mysql_fetch_array($result)){
?>
    <tr align="center"> 
      <td height="20"><a href="editsite.php?ids=<?print $row["id"];?>"><font color=blue><?print $row["site"];?></font></a></td>
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
<p align=center>
<a href="addsite.php"><font color=blue>Add new site</font></a>
</p>
<p align=center>
<b>  Hits Received on this week</b>
</p>
  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF" align="center">
    <tr bgcolor="#006699" align="center"> 
      <td height="20"><font color="#FFFFFF">Date</font></td>
      <td height="20"><font color="#FFFFFF">Received</font></td>
      <td height="20"><font color="#FFFFFF">Graph</font></td>
    </tr>
<?
	$vsego=0;
	for($i=0;$i<=date("w");$i++){
		$vsego=$vsego+mysql_result($result,0,"sum(p$i)");
	}
	for($i=0;$i<=date("w");$i++){
?>
    <tr align="center"> 
      <td width="100" height="20"><?print date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")));?></td>
      <td width="70" height="20"><?print mysql_result($result,0,"sum(p$i)");?></td>
      <td height="20" align=left><?for($j=0;$j<=@(mysql_result($result,0,"sum(p$i)")*100/$vsego*4);$j++){print "<img src='images/graph.gif'>";} print " ".@round(100*(mysql_result($result,0,"sum(p$i)")*100/$vsego))/100;if($vsego==0){print"0";}?>%</td>
    </tr>
<?
	}
	@mysql_free_result($result);
	$query = "select sum(c1),sum(c2),sum(c3),sum(c4),sum(c5),sum(c6),sum(c0) from ".$t_user." where id=".$id." ";      
	$result = MYSQL_QUERY($query);
?>
  </table>
  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="FFFFFF" align="center">
    <tr bgcolor="#006699" align="center"> 
      <td height="20"><font color="#FFFFFF">Date</font></td>
      <td height="20"><font color="#FFFFFF">Earned</font></td>
      <td height="20"><font color="#FFFFFF">Graph</font></td>
    </tr>
<?
	$vsego=0;
	for($i=0;$i<=date("w");$i++){
		$vsego=$vsego+mysql_result($result,0,"sum(c$i)");
	}
	for($i=0;$i<=date("w");$i++){
?>
    <tr align="center"> 
      <td width="100" height="20"><?print date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")));?></td>
      <td width="70" height="20"><?print round(mysql_result($result,0,"sum(c$i)")*10)/10;?></td>
      <td height="20" align=left><?for($j=0;$j<=@(mysql_result($result,0,"sum(c$i)")*100/$vsego*4);$j++){print "<img src='images/graph.gif'>";} print " ".@round((100*mysql_result($result,0,"sum(c$i)")*100/$vsego))/100;if($vsego==0){print"0";}?>%</td>
    </tr>
<?
	}
?>
  </table>
<?
	@mysql_free_result($result);
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
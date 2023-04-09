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

$query = "select * from ".$t_user.",".$t_site." where idu=".$t_user.".id";      
$result = MYSQL_QUERY($query);
$kolvo=mysql_num_rows($result);
$trec=0;
$tear=0;
while($row = mysql_fetch_array($result)){
	$trec=$trec+$row["p".(date("w")-$day)];
	$tear=$tear+$row["c".(date("w")-$day)];
}
@mysql_free_result($result);

if(($s=="")or($s>=$kolvo)or($s<0)){
	$s=0;
}
$s=intval($s);
$day=intval($day);

$query = "select * from  ".$t_user.",".$t_site." where idu=".$t_user.".id order by ";
if($or=="ids"){
	$query=$query.$t_site.".id ";
}elseif($or=="rec"){
	$query=$query."p".(date("w")-$day)." ";
}elseif($or=="ear"){
	$query=$query."c".(date("w")-$day)." ";
}else{
	$query=$query.$t_user.".id ";
}
$query=$query." limit ".$s.",".$num_rows;      
$result = MYSQL_QUERY($query);
//die($query);
require('header_inc.php');
?>
<script language="JavaScript">
<!--
function show_det(id) {
   newWindow=window.open('det.php?id='+id,'picname','width=750,height=530,scrollbars=1');
}
//-->
</script>
<form name="form1" method="post" action="">
<p>
<?
for($i=0;$i<=date("w");$i++){
	if((date("w")-$i)!=$day){
		print " [<a href=\"dstatistic.php?or=$or&s=$s&day=".(date("w")-$i)."\">".date( "m/d/Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")))."</a>] ";
	}else{
		print " [".date( "m/d/Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y")))."] ";
	}
}
?>
</p>
<table width="100%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
  <tr>
    <td  align="center">
      <b><a href="dstatistic.php?or=rec&s=<?print $s;?>&day=<?print $day;?>">Hits received</a></b>
    </td>
    <td align="center">
      <b><a href="dstatistic.php?or=ear&s=<?print $s;?>&day=<?print $day;?>">Hits earned</a></b>
    </td>
    <td align="center">
      <b><a href="dstatistic.php?or=idu&s=<?print $s;?>&day=<?print $day;?>">ID no.</a></b>
    </td>
    <td align="center">
      <b><a href="dstatistic.php?or=ids&s=<?print $s;?>&day=<?print $day;?>">Site no.</a></b>
    </td>
  </tr>
<? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
  <tr>
    <td align="center">
	<?print $row["p".(date("w")-$day)];?>
    </td>
    <td align="center">
	<?print $row["c".(date("w")-$day)];?>
    </td>
    <td align="center">
	<?print $row[0];?>
    </td>
    <td align="center">
	<?print $row["id"];?>
    </td>
  </tr>
<?
		$i++;
	}
?>
</table>
<?
@mysql_free_result($result);
?>
</form>
<b>Total hits received</b>: <?print $trec;?><br>
<b>Total hits earned</b>: <?print $tear;?><br><br>
<?
if($kolvo>$num_rows){
	print"<b>Pages: </b>";
	for($i=0;$i<$kolvo;$i=$i+$num_rows){
		if($s==$i){
			print "<b>".($i+1)."-".($i+$num_rows)."</b>";
			}else{	
			print" <a href=\"dstatistic.php?or=$or&s=".$i."&day=$day\">".($i+1)."-".($i+$num_rows)."</a> ";
		}
	}
}
require('footer_inc.php');
?>


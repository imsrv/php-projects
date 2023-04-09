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

$query = "select ".$t_user.".id from ".$t_user.",".$t_site." where idu=".$t_user.".id";      
$result = MYSQL_QUERY($query);
$kolvo=mysql_num_rows($result);
@mysql_free_result($result);

if(($s=="")or($s>=$kolvo)or($s<0)){
	$s=0;
}
$s=intval($s);

$query = "select * from  ".$t_user.",".$t_site." where idu=".$t_user.".id order by ";
if($or=="ids"){
	$query=$query.$t_site.".id ";
}elseif($or=="email"){
	$query=$query."email ";
}elseif($or=="url"){
	$query=$query."url ";
}elseif($or=="cr"){
	$query=$query.$t_site.".credits ";
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
<h5>Statistic</h5>
</p>
<table width="100%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
  <tr>
    <td width="20%" align="center">
      <b><a href="statistic.php?or=idu&s=<?print $s;?>">ID no.</a></b>
    </td>
    <td align="center">
      <b><a href="statistic.php?or=email&s=<?print $s;?>">E-mail</a></b>
    </td>
    <td align="center">
      <b><a href="statistic.php?or=ids&s=<?print $s;?>">Site no.</a></b>
    </td>
    <td align="center">
      <b><a href="statistic.php?or=url&s=<?print $s;?>">Site URL</a></b>
    </td>
    <td align="center">
      <b><a href="statistic.php?or=cr&s=<?print $s;?>">Credits</a></b>
    </td>
  </tr>
<? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
  <tr>
    <td width="20%" align="center">
	<?print $row[0];?>
    </td>
    <td align="center">
	<a href="mailto:<? print $row["email"]; ?>"><? print $row["email"]; ?></a>
    </td>
    <td align="center">
	<?print $row["id"];?>
    </td>
    <td align="center">
	<a href="<? print $row["url"]; ?>"><? print $row["url"]; ?></a>
    </td>
    <td align="center" width="50">
	<?print $row["credits"];?>
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
<?
if($kolvo>$num_rows){
	print"<b>Pages: </b>";
	for($i=0;$i<$kolvo;$i=$i+$num_rows){
		if($s==$i){
			print "<b>".($i+1)."-".($i+$num_rows)."</b>";
			}else{	
			print" <a href=\"statistic.php?or=$or&s=".$i."\">".($i+1)."-".($i+$num_rows)."</a> ";
		}
	}
}
require('footer_inc.php');
?>

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

if($REQUEST_METHOD=="POST"){
	if(isset($ok)){ 
		if(is_array($del)){ 
			reset($del);    
			$query = "delete from ".$t_user." where id=".(intval(current($del)));
			$query1 = "delete from ".$t_site." where idu=".(intval(current($del)));
			$query2 = "select id from ".$t_idm_idc.",".$t_site." where (id=idm and idu=".(intval(current($del)))." ) ";
			$query4 = "delete from ".$t_idu_idc." where idu=".(intval(current($del)));
			while(next($del)){
				$query=$query." or id=".(intval(current($del)));
				$query1=$query1." or idu=".(intval(current($del)));
				$query4=$query4." or idu=".(intval(current($del)));
				$query2=$query2." or ( id=idm and idu=".(intval(current($del)))." ) ";
			}
			$result2=mysql_query($query2);
			while($row = mysql_fetch_array($result2)){
				$query3="delete from ".$t_idm_idc." where idm=".$row["id"];
				if(!@mysql_query($query3)){
					die($err[5]);
				}
			}
			@mysql_free_result($result);

			if(!@mysql_query($query4)){
				die($err[5]);
			}
			if(!@mysql_query($query)){
				die($err[5]);
			}
			if(!@mysql_query($query1)){
				die($err[5]);
			}
		}
	}
	if(isset($send)){ 
		$query = "select distinct(email),name,credits from ".$t_user." order by email ";      
		$result = MYSQL_QUERY($query);
		$i=0;
		while($row = mysql_fetch_array($result)){
			$text1=preg_replace ("[\[name\]]",$row["name"], $text);
			$text1=preg_replace ("[\[email\]]",$row["email"], $text1);
			$text1=preg_replace ("[\[credits\]]",$row["credits"], $text1);
			if(!(@mail($row["email"],$subject[1],$text1,"From: $support_email"))){
				$errarr[$i]=$row["email"];
				$i++;
			} 
		}
		print "<div  align=center><font color=red>".$msg[3]."</font></div>";
		@mysql_free_result($result);
	}
}
$query = "select id from ".$t_user;      
$result = MYSQL_QUERY($query);
$kolvo=mysql_num_rows($result);
@mysql_free_result($result);

if(($s=="")or($s>=$kolvo)or($s<0)){
	$s=0;
}
$s=intval($s);

$query = "select * from  ".$t_user." order by id limit ".$s.",".$num_rows;      
$result = MYSQL_QUERY($query);

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
<? 
if(mysql_num_rows($result)==0){ 
?>
<font color=red>
<? 
	print $msg[2]; 
?>
</font>
<? 
}else{ 
?>
<p>
<h5>Users</h5>
</p>
  <table width="100%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
    <tr> 
      <td width="98" align="center"><strong>Id</strong> </td>
      <td width="144" align="center"><b>Name:</b> </td>
      <td width="99" align="center"> <b>Type:</b> </td>
      <td align="center" valign="top" width="95">&nbsp;</td>
      <td align="center" valign="top" width="73">&nbsp;</td>
      <td align="center" valign="top" width="74">&nbsp;</td>
      <td align="center" valign="top" width="94"> <b>Delete</b> </td>
    </tr>
    <? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
    <tr> 
      <td width="98" align="center"><a href="mailto:<? print $row["email"]; ?>"><? print $row["id"]; ?></a> 
      </td>
      <td width="144" align="center"><a href="mailto:<? print $row["email"]; ?>"><? print $row["name"]; ?></a> 
      </td>
      <td align="center"> 
        <? if($row["type"]==0){print "Basic";}elseif($row["type"]==1){print "Silver";}elseif($row["type"]==2){print "Gold";}; ?>
      </td>
      <td align="center"> <a href="javascript:show_det('<?print $row["id"];?>')">[ 
        statistics ]</a> </td>
      <td align="center"> <a href="sites.php?id=<?print $row["id"];?>">[ sites 
        ]</a> </td>
      <td align="center" width="74"><a href="edit.php?id=<?print $row["id"];?>">[edit]</a></td>
      <td align="center" width="94"> <input type="checkbox" name="del[<?print $i;?>]" value="<?print $row["id"];?>">
        delete </td>
    </tr>
    <?
		$i++;
	}
?>
  </table>
  <div align="right">
    <input type="submit" name="ok" value="Submit">
  </div>
	<?
}
@mysql_free_result($result);
?>
</form>
<form name="form3" method="post" action="">
<?            
$num=sizeof($errarr);
for($i=0;$i<$num;$i++){
?>
<font color=red>
	<? print $err[11].$errarr[$i]."<br>"; ?>
</font>
<? 
} 
?>
<b>Text of message:</b>
  <p> 
    <textarea name="text" cols="50" rows="7"></textarea>
  </p>
    <input type="submit" name="send" value="Send Mail">
</form>
<b>You have <?print $kolvo;?> users<br></b>
<?
if($kolvo>$num_rows){
	print"<b>Pages: </b>";
	for($i=0;$i<$kolvo;$i=$i+$num_rows){
		if($s==$i){
			print "<b>".($i+1)."-".($i+$num_rows)."</b>";
			}else{	
			print" <a href=\"user.php?s=".$i."\">".($i+1)."-".($i+$num_rows)."</a> ";
		}
	}
}
require('footer_inc.php');
?>

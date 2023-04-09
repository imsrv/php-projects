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

if($REQUEST_METHOD=="POST"){
	if(isset($ok)){ 
		if(is_array($del)){ 
			reset($del);    
			$query = "delete from ".$t_site." where id=".(intval(current($del)));
			$query1 = "select email from ".$t_site.",".$t_user." where (".$t_user.".id=idu and ".$t_site.".id=".(intval(current($del))).") ";
			$query2 = "delete from ".$t_idm_idc." where idm=".(intval(current($del)));
			while(next($del)){
				$query1 = $query1." or (".$t_user.".id=idu and ".$t_site.".id=".(intval(current($del))).") ";
				$query=$query." or id=".(intval(current($del)));
				$query2=$query2." or idm=".(intval(current($del)));
			}
			$result1 = MYSQL_QUERY($query1);
			if(!@mysql_query($query2)){
				die($err[5]);
			}
			if(!@mysql_query($query)){
				die($err[5]);
			}
			while($row = mysql_fetch_array($result1)){
				@mail($row["email"],$subject[3],$body[3],"From: $support_email");
			}
			@mysql_free_result($result);
		} 
		for($i=0;$i<sizeof($pub);$i++){
			$query = "update ".$t_site." set b=".(intval($pub[$i]))."  where id=".(intval($h[$i]));
			if(!@mysql_query($query)){
				die($err[7]);
			}
		} 
	}
}

$query = "select * from  ".$t_site." where idu=".$id." order by id desc";      
$result = MYSQL_QUERY($query);
require('header_inc.php');
?>
<form name="form1" method="post" action="">
<? 
if(mysql_num_rows($result)==0){ 
?>
<font color=red>
<? 
	print $msg[1]; 
?>
</font>
<? 
}else{ 
?>
<p>
<h5>New sites</h5>
</p>
<table width="100%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
  <tr>
    <td width="20%" align="center">
      <b>Site Name:</b>
    </td>
    <td align="center">
      <b>URL:</b>
    </td>
    <td align="center" valign="top" width="50">&nbsp;</td>
    <td align="center" valign="top" width="70"> 
      <b>Delete</b>
    </td>
    <td align="center" valign="top" width="70"> 
	<b>Publish</b>
      </td>
  </tr>
<? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
  <tr>
    <td width="20%" align="center">
	<? print $row["site"]; ?>
    </td>
    <td align="center">
	<a href="<?print $row["url"];?>" target=_blank><? print $row["url"]; ?></a>
    </td>
    <td align="center" valign="top" width="50"><a href="editsite.php?ids=<?print $row["id"];?>">[edit]</a></td>
    <td align="center" valign="top" width="70"> 
      <input type="checkbox" name="del[<?print $i;?>]" value="<?print $row["id"];?>">
      delete </td>
    <td align="center" valign="top" width="70"> 
  <select name="pub[<?print $i;?>]">
    <option value="0" <?if($row["b"]==0){print "selected";}?>>Disabled</option>
    <option value="1" <?if($row["b"]==1){print "selected";}?>>Waiting</option>
    <option value="2" <?if($row["b"]==2){print "selected";}?>>Enabled</option>
  </select>
<input type="hidden" name="h[<?print $i;?>]" value="<?print $row["id"];?>">
    </td>
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
<?
require('footer_inc.php');
?>
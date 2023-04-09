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
		if(is_array($pub)){ 
			reset($pub);    

			$query = "update ".$t_site." set b=2  where id=".(intval(current($pub)));
			$query1 = "select email from ".$t_site.",".$t_user." where (".$t_user.".id=idu and ".$t_site.".id=".(intval(current($pub))).") ";
			while(next($pub)){
				$query1 = $query1." or (".$t_user.".id=idu and ".$t_site.".id=".(intval(current($pub))).") ";
				$query=$query." or id=".(intval(current($pub)));
			}
			if(!@mysql_query($query)){
				die($err[7]);
			}
			$result1 = MYSQL_QUERY($query1);

			while($row = mysql_fetch_array($result1)){
				@mail($row["email"],$subject[1],$body[1],"From: $support_email");
			}
			@mysql_free_result($result);

			reset($pub);    
			$query = "select idu from ".$t_site." where id=".(intval(current($pub)))." ";
			$result=mysql_query($query);
			$query2 = "select count(id) from ".$t_site." where b=2 and idu=".mysql_result($result,0,0);
			$result2=mysql_query($query2);
			if(mysql_result($result2,0,0)>$num_en){
				$query1 = "update ".$t_site." set b=1  where id=".(intval(current($pub)));
				$result1 = MYSQL_QUERY($query1);
			}
			@mysql_free_result($result2);
			@mysql_free_result($result);

			while(next($pub)){
				$query = "select idu from ".$t_site." where id=".(intval(current($pub)))." ";
				$result=mysql_query($query);
				$query2 = "select count(id) from ".$t_site." where b=2 and idu=".mysql_result($result,0,0);
				$result2=mysql_query($query2);
				if(mysql_result($result2,0,0)>$num_en){
					$query1 = "update ".$t_site." set b=1  where id=".(intval(current($pub)));
					$result1 = MYSQL_QUERY($query1);
				}
				@mysql_free_result($result);
				@mysql_free_result($result2);
			}
		} 
	}
}

$query = "select count(id) from ".$t_site." where b!=0";      
$result = MYSQL_QUERY($query);
$num_publ=mysql_result($result,0,0);
@mysql_free_result($result);
$query = "select ".$t_site.".*, ".$t_user.".id as user_id, ".$t_user.".name as user_name from  ".$t_site.", ".$t_user."  where ".$t_user.".id = ".$t_site.".idu and  b=0 order by id desc";      
$result = MYSQL_QUERY($query);
$k=mysql_num_rows($result);
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
      <td width="98" align="center"><b>User Id:</b> </td>
      <td width="158" align="center"><b>Site Name:</b></td>
      <td width="170" align="center"> <b>URL:</b> </td>
      <td align="center" valign="top" width="82">&nbsp;</td>
      <td align="center" valign="top" width="76"> <b>Delete</b> </td>
      <td align="center" valign="top" width="121"> <b>Publish</b> </td>
    </tr>
    <? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
    <tr> 
      <td width="98" align="center"><? print $row["user_id"]; ?> (<? print $row["user_name"]; ?>)</td>
      <td width="158" align="center"><? print $row["site"]; ?> </td>
      <td align="center"> <a href="<?print $row["url"];?>" target=_blank><? print $row["url"]; ?></a> 
      </td>
      <td align="center" valign="top" width="82"><a href="editsite.php?ids=<?print $row["id"];?>">[edit]</a></td>
      <td align="center" valign="top" width="76"> <input type="checkbox" name="del[<?print $i;?>]" value="<?print $row["id"];?>">
        delete </td>
      <td align="center" valign="top" width="121"> <input type="checkbox" name="pub[<?print $i;?>]" value="<?print $row["id"];?>">
        publish </td>
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
<b>You have <?print ($k+$num_publ);?> sites<br>
And you have <?print $num_publ;?> published sites</b>
<br><br>
Your AutoHits PRO Version - <b>3.0</b><br>
Current Version Available - <b>3.0</b><br>
<?
require('footer_inc.php');
?>

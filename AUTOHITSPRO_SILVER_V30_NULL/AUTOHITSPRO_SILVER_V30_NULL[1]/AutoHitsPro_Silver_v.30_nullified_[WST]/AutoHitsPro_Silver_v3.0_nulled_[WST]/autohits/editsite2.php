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

$ids=intval($ids);

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

$language=intval($language);
$flag=true;

if($site==""){
	$er[]=$err[3]."'Site name'";
	$flag=false;
}
$site=htmlspecialchars($site);

if($url==""){
	$er[]=$err[3]."'URL'";
	$flag=false;
}
$url=htmlspecialchars($url);
if($sel[1]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel[2]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel[3]==""){
	$er[]=$err[8];
	$flag=false;
}

require('header_inc.php');
require('menu.php');
?>
<table width="650" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
    <td align=center>
<?
if($flag==true){
	$query="delete from ".$t_idm_idc." where idm=".$ids;
	if(!@mysql_query($query)){                
		print $err[9];
	}           
	for($i=1;$i<=3;$i++){
		$query="insert into ".$t_idm_idc." set  idm=".$ids.", idc=".intval($sel[$i]);
		if(!@mysql_query($query)){                
			print($err[9]);
		} 
	} 
	$query="update ".$t_site." set site=\"".$site."\" , language=\"".$language."\" , url=\"".$url."\" , b=0 where id=".$ids." and idu=".$id;
	if(!@mysql_query($query)){                
		print($err[4]);
	} 
?>
Your site will now be checked and verified by our team.<BR>Within 1 hours, your site will be included in the site 
      rotation,<BR>if it can be accepted.<BR><BR>You will shortly receive an 
      e-mail<BR>with all the information you need.<BR>Remember to login to 
      member's area and<BR>check your site state by yourself.<BR><BR>Thanks - 
      and welcome to AutoHits.<BR><BR>Yours<BR><BR>Team 
leader
<?
	@mail($admin_mail,$subject[1],$body[1],"From: $support_email");
			
	@mysql_free_result($result);

}else{
	$str=join("<br>",$er);
	print "<p>".$str."</p>";


}
?>
    </td>
  </tr>
</table>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>

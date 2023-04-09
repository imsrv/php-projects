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
	$query="insert into ".$t_site." set  idu=".$id." , site=\"".$site."\" , language=\"".$language."\" , url=\"".$url."\" , b=0 ";
	if(!@mysql_query($query)){                
		print($err[4]);
	} 
	$idm=mysql_insert_id();
		
	for($i=1;$i<=3;$i++){
		$query="insert into ".$t_idm_idc." set  idm=".$idm.", idc=".intval($sel[$i]);
		if(!@mysql_query($query)){                
			print($err[4]);
		} 
	} 
	if($ref!=0){
		$query="update ".$t_user." set credits=credits+".$bonus_credits_for_own.",c".(date("w"))."=c".(date("w"))."+".$bonus_credits_for_own." where id=".$ref;
		if(!@mysql_query($query)){                
			print($err[4]);
		} 
	}
	print $msg[3];
?>
<a href="user_menu.php"><font color=blue>Back to user menu</font></a>
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

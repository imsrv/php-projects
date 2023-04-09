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
$b=intval($b);

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
	if($b==1){
		$query = "select count(id) from ".$t_site." where idu=".$id." and b=2";      
		$result = MYSQL_QUERY($query);    
		if(mysql_result($result,0,0)>=$num_en){ 
			header("Location: ".$HTTP_REFERER); 
			exit;
		}
		$b=2;
	}elseif($b==2){
		$b=1;
	}
	$query = "update ".$t_site." set b=".$b." where id=".$ids." and idu=".$id." and b!=0";      
	$result = MYSQL_QUERY($query);
	header("Location: user_menu.php?PHPSESSID=".$PHPSESSID);
}else{
	header("Location: login.php");
}
?>
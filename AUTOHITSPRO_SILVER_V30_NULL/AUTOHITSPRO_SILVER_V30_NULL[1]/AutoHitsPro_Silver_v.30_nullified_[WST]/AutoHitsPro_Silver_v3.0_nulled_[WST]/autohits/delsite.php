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
$query = "select * from ".$t_site." where idu=".$id." and id=".$ids;      
$result = MYSQL_QUERY($query);
$site=mysql_result($result,0,"site");
@mysql_free_result($result); 

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
	if($REQUEST_METHOD=="POST"){
		if(isset($ok)){
			$query = "delete from ".$t_idm_idc." where idm=".$ids;      
			$result = MYSQL_QUERY($query);
			$query = "delete from ".$t_site." where idu=".$id." and id=".$ids;      
			$result = MYSQL_QUERY($query);
			header("Location:user_menu.php?PHPSESSID=".$PHPSESSID);
		}
	}else{
		require('header_inc.php');
		require('menu.php');
?>
<form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="175" align="right" class="text">&nbsp;</td>
          <td align="left">If you want to destroy '<?print $site?>' click on the button.</td>
        </tr>
        <tr> 
          <td width="175" align="right" class="text" valign="top">&nbsp;</td>
          <td align="left"> 
            <input type="submit" name="ok" value="Delete Site">
          </td>
        </tr>
      </table>
</form>
<?
	}
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
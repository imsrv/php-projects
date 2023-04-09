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
	if($REQUEST_METHOD=="POST"){
		if(isset($ok)){
			$query = "delete from ".$t_idu_idc." where idu=".$id;
			$result = MYSQL_QUERY($query);
			$query = "delete from ".$t_user." where id=".$id;      
			$result = MYSQL_QUERY($query);

			$query2 = "select id from ".$t_idm_idc.",".$t_site." where (id=idm and idu=".$id." ) ";
			$result2=mysql_query($query2);
			while($row = mysql_fetch_array($result2)){
				$query3="delete from ".$t_idm_idc." where idm=".$row["id"];
				$result3 = @mysql_query($query3);
			}
			@mysql_free_result($result3);

			$query = "delete from ".$t_site." where idu=".$id;      
			$result = MYSQL_QUERY($query);

			session_destroy();		
			require('menu.php');
?>
       
      <table border="0" cellspacing="1" cellpadding="0" width="476">
        <tr> 
          <td width="175" align="right" valign="top">&nbsp;</td>
          <td width="289"><div align="center"><b><font color="red">You are erased</font></b></div></td>
        </tr>
      </table>
<?
		}
	}else{
		require('menu.php');
?>
<form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="175" align="right" class="text">&nbsp;</td>
          <td align="left">If you want to destroy your account click on the button.</td>
        </tr>
        <tr> 
          <td width="175" align="right" class="text" valign="top">&nbsp;</td>
          <td align="left"> 
            <input type="submit" name="ok" value="Delete Account">
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
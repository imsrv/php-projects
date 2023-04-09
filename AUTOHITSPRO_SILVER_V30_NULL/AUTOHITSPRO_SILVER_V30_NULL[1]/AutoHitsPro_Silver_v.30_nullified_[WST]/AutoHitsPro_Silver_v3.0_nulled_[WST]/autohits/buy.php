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
			if($name==""){
				print "<p class=\"error\">".$err[3]."'Name'"."</p>";
			}else{
				$name=htmlspecialchars($name);
				$num=abs(intval($num));
				$query = "select total_credits from ".$t_main." where id=".$id;      
				$result = MYSQL_QUERY($query);
				$total=mysql_result($result,0,"total_credits");
				@mysql_free_result($result);
				$query = "select id from ".$t_main." where b=1 and name=".$name;      
				$result = MYSQL_QUERY($query);
				$nn=@mysql_num_rows($result);
				@mysql_free_result($result);
				if($num>$total){
					print "<p class=\"error\">".$err[10]."</p>";
				}else{
					if($nn==0){
						print "<p class=\"error\">".$err[11]."</p>";
					}else{
						$query = "update ".$t_main." set total_credits=total_credits-".$num." where id=".$id;      
						$result = MYSQL_QUERY($query);
						$query = "update ".$t_main." set total_credits=total_credits+".$num." where name=".$name;      
						$result = MYSQL_QUERY($query);
						print "<p class=\"error\">".$msg[6]."'Name'"."</p>";
					}
				}
			}
		}
	}
	require('menu.php');
?>
       <form name="form1" method="post" action="">
       
<table border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
         
    <td  align="right" class="text" valign="top"> 
      <table border="0" cellspacing="0" cellpadding="0">
        <tr align="center"> 
          <td bgcolor="#006699" width="200" height="20"><b><font color="#FFFFFF">Purchase 
            Credits</b></td>
          <td width="400">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2" align="right" class="text" valign=top height="20"> 
            <div align="justify">You can get an instant exposure to your Web site 
              by purchasing additional credits. One credit equals one impression, 
              i.e. if you buy 10,000 credits your link will be shown 10,000 times. 
            </div>
          </td>
        </tr>
        <tr> 
          <td colspan="2" align="right" class="text" valign=top height="20"> 
            <br>
			<? include 'prices.inc.php'; ?>
			
          </td>
        </tr>
        <tr>
          <td colspan="2" align="right" class="text" valign=top height="20">
            <div align="left">CPM- Cost per 1000 credits.</div>
          </td>
        </tr>
      </table>
       </form>
         </td>
         <td width="25%" valign="top" class="text">
              </td>
            </tr>
          </table>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
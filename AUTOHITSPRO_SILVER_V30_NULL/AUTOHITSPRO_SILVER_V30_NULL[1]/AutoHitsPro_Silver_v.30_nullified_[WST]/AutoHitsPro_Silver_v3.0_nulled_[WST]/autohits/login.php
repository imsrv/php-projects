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
	header("Location: user_menu.php?PHPSESSID=".$PHPSESSID);
}
if($REQUEST_METHOD=="POST"){
	if(isset($lo)){
		$log=htmlspecialchars($log);
		$passwrd=htmlspecialchars($passwrd);
		$au=auth($log,$passwrd);
		if($au>0){
			$login=$log;   
			$pwrd=$passwrd;
			$id=$au;
			header("Location: user_menu.php?PHPSESSID=".$PHPSESSID);
		}else{
			require('header_inc.php');
			print "<p>".$err[1]."</p>";
		}
	}
}else{
	require('header_inc.php');
}        
?>       
<form name="form1" method="post" action="" >
  <table border="0" cellspacing="2" cellpadding="0" align="center">
    <tr align="center"> 
              
      <td height="20" align=right><b>Log In</b></td>
      <td height="20">&nbsp;</td>
            </tr>
            <tr> 
              
      <td align="right">Your Email:</td>
              
      <td align="left" height="20"> 
        <input type="text" name="log" size="15">
      </td>
            </tr>
            <tr> 
              
      <td align="right">Password:</td>
              
      <td align="left" height="20"> 
        <input type="password" name="passwrd" size="15">
      </td>
            </tr>
            <tr>
              
      <td align="right" valign="top">&nbsp;</td>
              
      <td align="left" height="20"> 
        <input type="submit" name="lo" value="Log In">
        <br>
		<a href="forgot.php"><font color=blue size=1>Forgot your password?</font></a> 
              </td>
            </tr>
          </table>
       </form>
<?
require('footer_inc.php');
?>
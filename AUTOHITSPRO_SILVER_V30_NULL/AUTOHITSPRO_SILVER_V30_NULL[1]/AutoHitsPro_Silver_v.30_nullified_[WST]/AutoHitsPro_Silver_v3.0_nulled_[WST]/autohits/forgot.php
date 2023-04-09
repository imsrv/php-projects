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
require('header_inc.php');

if($REQUEST_METHOD=="POST"){
	if(isset($send)){
		$name=htmlspecialchars($name);
		$query = "select email,pass from ".$t_user." where email=\"".$email."\" ";      
		$result = MYSQL_QUERY($query);
		if(mysql_num_rows($result)!=0){
			@mail(mysql_result($result,0,"email"),$subject[2],"Your login: ".(mysql_result($result,0,"email"))."\nYour password: ".(mysql_result($result,0,"pass")),"From: $support_email");
			print "<p>".$msg[1]."</p>";
		}else{
			print "<p>".$msg[2]."</p>";
		}
		@mysql_free_result($result);
	}
}else{        
?>
       <form name="form1" method="post" action="">
          <table width="500" border="0" cellspacing="5" cellpadding="5">
            <tr align="right"> 
              <td>Forgot password</td>
              <td >&nbsp;</td>
            </tr>
            <tr> 
              <td width="25%" align="right" >Your e-mail:</td>
              <td align="left" > 
                <input type="text" name="email" size="15">
              </td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="top">&nbsp;</td>
              <td align="left" >
                <input type="submit" name="send" value="Send password">
              </td>
            </tr>
          </table>
       </form>
<?
}
require('footer_inc.php');
?>
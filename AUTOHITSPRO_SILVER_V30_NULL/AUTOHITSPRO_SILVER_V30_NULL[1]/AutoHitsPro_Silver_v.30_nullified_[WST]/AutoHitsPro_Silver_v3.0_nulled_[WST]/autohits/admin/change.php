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
	if(isset($add)){
		if($login==""){
			die($err[3]);
		}
		if($password==""){
			die($err[3]);
		}
		if($password1==""){
			die($err[3]);
		}
		$login=htmlspecialchars($login);
		$password=htmlspecialchars($password);
		$password1=htmlspecialchars($password1);
		if($password!=$password1){
			die($err[1]);
		}

		$query="update pass set  login=\"".$login."\" , pass=\"".crypt($password,2)."\" where id=1 ";
		if(!@mysql_query($query)){                
			die($err[4]);
		}
	}
}

require('header_inc.php');
?>
<form name="form1" method="post" action="">
<table width="450" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF">
  <tr>
    <td align="right">
      New login: 
    </td>
    <td align="right">
      <input type="text" name="login" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
      New password: 
    </td>
    <td align="right">
      <input type="password" name="password" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
      Confirm password: 
    </td>
    <td align="right">
      <input type="password" name="password1" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td align="right">
      <input type="submit" name="add" value="Add">
    </td>
  </tr>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td align="right">
      <a href="<?print $HTTP_REFERER;?>">[ back ]</a> 
    </td>
  </tr>
</table>
</form>
<?
require('footer_inc.php');
?>  
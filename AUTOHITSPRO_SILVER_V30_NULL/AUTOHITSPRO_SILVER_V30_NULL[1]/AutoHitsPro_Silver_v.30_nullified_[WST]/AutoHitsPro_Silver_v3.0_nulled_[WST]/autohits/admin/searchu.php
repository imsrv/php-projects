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

$flag=true;
if($REQUEST_METHOD=="POST"){
	if(isset($add)){
		$mail=htmlspecialchars($mail);

		$flag=false;
		$query="select id from ".$t_user." where ".$field."=\"".$mail."\" ";
		$result=@mysql_query($query);
		if(mysql_num_rows($result)!=0){
			header("location:edit.php?id=".mysql_result($result,0,0));
		}
	}
}

require('header_inc.php');
if($flag==false){
	print $err[12];
}
?>
<form name="form1" method="post" action="">
<table width="450" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF">
  <tr>
    <td align="right">
      Search:
    </td>
    <td align="right">
      <input type="" name="mail" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
      Find in:  
    </td>
    <td align="right">
  <select name="field">
    <option value="id" selected>ID</option>
    <option value="email">E-mail</option>
  </select>
    </td>
  </tr>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td align="right">
      <input type="submit" name="add" value="Search">
    </td>
  </tr>
</table>
</form>
<?
require('footer_inc.php');
?>  
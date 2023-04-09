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
		if($title==""){
			die($err[3]);
		}
		if($ps==""){
			die($err[3]);
		}
		$title=htmlspecialchars($title);
		$ps=htmlspecialchars($ps);

		$query="insert into ".$t_cat." set  title=\"".$title."\" , ps=\"".$ps."\" ";
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
      Categoriy title: 
    </td>
    <td align="right">
      <input type="text" name="title" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
      Category details: 
    </td>
    <td align="right">
      <input type="text" name="ps" size=40>
    </td>
  </tr>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td align="right">
      <input type="submit" name="add" value="Add catigory">
    </td>
  </tr>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td align="right">
      <a href="cat.php">[ back ]</a> 
    </td>
  </tr>
</table>
</form>
<?
require('footer_inc.php');
?>  
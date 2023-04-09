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
	if(isset($ok)){ 
		if(is_array($ch)){ 
			reset($ch);    
			$cur[0]=intval(current($ch));
			$i=0;
			while(next($ch)){
				$i++;
				$cur[$i]=intval(current($ch));
			}
			$num=$i;

			$query = "delete from ".$t_cat." where id=".$cur[0];

			for($i=1;$i<=$num;$i++){
				$query=$query." or id=".$cur[$i];
			}   
			if(!@mysql_query($query)){
				die($err[5]);
			}
		} 
	}
}
require('header_inc.php');

$query = "select * from ".$t_cat." order by id desc";      
$result = MYSQL_QUERY($query);
?>
<form name="form1" method="post" action="">
<?
if(mysql_num_rows($result)){
?>
<table width="70%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
  <tr>
    <td align="center"> Target category for edit </td>
    <td align="center" width=60> Delete </td>
  </tr>
<?
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
  <tr>
    <td align="right">
	<a href="editcat.php?id=<?print $row["id"];?>"><?print $row["title"];?><br>
	<font size=1><?print $row["ps"];?></font></a>
    </td>
    <td width=60 align="center"> 
      <input type="checkbox" name="ch[<?print $i;?>]" value="<?print $row["id"];?>">
    </td>
  </tr>
<?
		$i++;
	}
?>
  <tr>
    <td align="right">
	&nbsp;
    </td>
    <td width=60 align="center"> 
    <input type="submit" name="ok" value="submit" class="but">
    </td>
  </tr>
</table>
<?
}
?>
<table width="70%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF">
  <tr>
    <td align="right">
	<a href="addcat.php">Add category</a>
    </td>
  </tr>
</table>
</form>
<?
@mysql_free_result($result);
require('footer_inc.php');
?>
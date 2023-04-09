<?
/***********************************************************************
1.config file path; 2.admin settinfg file or whereis inside; 3.page title, 
href=display_nr/display_nr/get_kene_lenne_jo ,from=item_back_from
a form is kell vigye ezeket
***********************************************************************/
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

if (MULTILANGUAGE_SUPPORT == "on") 
{
   $dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
		$lngname = split("\.",$dirs[$i]);
		echo "<a href=\"".HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF'])."?language=".$lngname[0].""."\" onmouseover=\"window.status='".BROWSE_THIS_PAGE_IN." ".$lngname[0]."'; return true;\" onmouseout=\"window.status=''; return true;\"><img src=".HTTP_FLAG.$dirs[$i]." border=\"0\" alt=".$lngname[0]." hspace=\"3\"></a>";	
		
   }
 
} 

define ("DEBUG","0");

if(DEBUG)
{
	echo "<font style=\"color:#FF0000;font-family:verdana\"><center><b>*****************DEBUG mode*****************</b></center></font>";
	postvars($HTTP_POST_VARS);
}

$database_table_name = $bx_db_table_image_categories;
$this_file_name = basename($HTTP_SERVER_VARS['PHP_SELF']);

$page_title = "Pictures Category (".$language.")";
$primary_id_name = "category_id";
$primary_id = $HTTP_GET_VARS[$primary_id_name];

$edit_field_name = "category_name".$slng;
$edit_field_value = $HTTP_GET_VARS[$edit_field_name];

$nr_of_cols = 3;

$get_vars = $HTTP_POST_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_POST_VARS['display_nr'] : ($HTTP_GET_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_GET_VARS['display_nr'] : "display_nr=".$display_nr);
$get_vars .= isset($HTTP_GET_VARS['order_by']) ? "&order_by=".$HTTP_GET_VARS['order_by']."&order_type=".$HTTP_GET_VARS['order_type'] : "&order_by=".$edit_field_name."&order_type=asc";

if ($HTTP_POST_VARS['delete_button'] == "Delete Checked" || $HTTP_GET_VARS['delete_this'])	//delete via ID
{
	
	for( $i = 0 ; $i < sizeof($HTTP_POST_VARS[$primary_id_name]); $i++ )
	{
		if ($HTTP_POST_VARS['cycle'.$i] == "on")
		{
			$delete_SQL = "delete from $database_table_name where $primary_id_name='".$HTTP_POST_VARS[$primary_id_name][$i]."'";
			
			if(DEBUG)
				echo $delete_SQL."<br>";
			else
				$delete_query = bx_db_query($delete_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
	
	if ($HTTP_GET_VARS['delete_this'])
	{
		$delete_SQL = "delete from $database_table_name where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";

		if(DEBUG)
			echo $delete_SQL."<br>";
		else
			$delete_query = bx_db_query($delete_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}

}
elseif (($HTTP_POST_VARS[$edit_field_name]  && !$HTTP_POST_VARS['insert'] ) || $HTTP_GET_VARS[$edit_field_name] )	//update via ID
{
	
	for( $i = 0 ; $i < sizeof($HTTP_POST_VARS[$primary_id_name]) && $i < sizeof($HTTP_POST_VARS[$edit_field_name]) && is_array($HTTP_POST_VARS[$primary_id_name]); $i++ )
	{
		if ($HTTP_POST_VARS['update_checked_button'])
		{
			if ($HTTP_POST_VARS['cycle'.$i] != "on")
				continue;
		}

		$update_SQL = "update $database_table_name set ".$edit_field_name."='".$HTTP_POST_VARS[$edit_field_name][$i]."' where $primary_id_name='".$HTTP_POST_VARS[$primary_id_name][$i]."'";

		if(DEBUG)
			echo $update_SQL."<br>";
		else
			$update_query = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}
	
	if ($HTTP_GET_VARS[$edit_field_name])
	{
		$update_SQL = "update $database_table_name set ".$edit_field_name."='".$HTTP_GET_VARS[$edit_field_name]."' where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";
		
		if(DEBUG)
			echo $update_SQL;
		else
			$update_query = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}

}
elseif ($HTTP_POST_VARS['insert'] == '1' && $HTTP_POST_VARS[$edit_field_name])//insert new one
{
	
	if (MULTILANGUAGE_SUPPORT == "on")
	{
		$SQL = "select * from $database_table_name";
		$query = bx_db_query($SQL);
		$nr_table_fields = mysql_num_fields($query);
		
		for ($i = 0; $i < $nr_table_fields ; $i++ )
		{
			if(ereg(".*category_name.*", mysql_field_name($query, $i),$reg))
			{
				$key .= mysql_field_name($query, $i).",";
				$val .= "'".$HTTP_POST_VARS[$edit_field_name]."'".",";
			}
		}
		$key = substr($key,0,-1);
		$val = substr($val, 0, -1);
		bx_db_insert($database_table_name ,$key, $val);
	}
	else
	{
		bx_db_insert($database_table_name,$edit_field_name, "'".$HTTP_POST_VARS[$edit_field_name]."'");
	}
	
	$select_position_SQL = "select * from $database_table_name";
	$select_position_query = bx_db_query($select_position_SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$from = $HTTP_GET_VARS['from'] = floor((bx_db_num_rows($select_position_query)-1)/$display_nr)*$display_nr;
}
else{}

$select_position_SQL = "select * from $database_table_name";
$select_position_query = bx_db_query($select_position_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
($HTTP_GET_VARS['from'] > floor((bx_db_num_rows($select_position_query)-1)/$display_nr)*$display_nr) ? ($from = $HTTP_GET_VARS['from'] = $HTTP_GET_VARS['from'] - $display_nr) : (isset($HTTP_GET_VARS['from']) ? ($from = $HTTP_GET_VARS['from']) : (isset($HTTP_POST_VARS['from']) ? ($from = $HTTP_POST_VARS['from']) : ($from = 0)));

$always_get_vars = "&amp;from=".$from."&".$get_vars;

if ($HTTP_GET_VARS['order_by'] && $HTTP_GET_VARS['order_type'])
	$condition = "order by ".$HTTP_GET_VARS['order_by']." ".$HTTP_GET_VARS['order_type'];

$SQL = "select * from $database_table_name ".$condition;

$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

/***************************************************************************/
//Form is here
/***************************************************************************/
?>
<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?></b></font></td>
</tr>
<tr>
	<td>
	<br>
<?
$count_query = bx_db_query($SQL);
echo "Total number of ".$page_title." <b>".bx_db_num_rows($count_query)."</b>.<br><br>";
?>
	</td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="7%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b><a href="<?=$this_file_name."?".$always_get_vars?>&order_by=<?=$primary_id_name?>&order_type=<?=$HTTP_GET_VARS['order_by'] == $primary_id_name ? ($HTTP_GET_VARS['order_type'] == "asc" ? "desc" : "asc") :  "asc"; ?>&from=0" style="color:#ffffff">ID</a></b></font></td>
			<td align="center" width="68%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b><a href="<?=$this_file_name."?".$always_get_vars?>&order_by=<?=$edit_field_name?>&order_type=<?=$HTTP_GET_VARS['order_by'] == $edit_field_name ? ($HTTP_GET_VARS['order_type'] == "asc" ? "desc" : "asc") :  "asc"; ?>&from=0" style="color:#ffffff">Categories</a></b></font></td>
			<td align="center" width="25%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Select</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>?<?=$always_get_vars?>" name="forms">
<?
if (sizeof($result_array) == 0)
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
			<td colspan="<?=$nr_of_cols?>" align="center">
				<b>There are no pictures category defined!</b>
			</td>
		</tr>
<?
}

for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td class="text">
				<input type="hidden" name="display_nr" value="<?=$display_nr?>">
				<?=$result_array[$i][$primary_id_name];?>
			</td>
			<td class="text" align="center">
				<input type="text" name="<?=$edit_field_name?>[]" value="<?=$result_array[$i][$edit_field_name];?>" class="" size="20" onChange="link<?=$i?>.href+=this.value;">
				<input type="hidden" name="<?=$primary_id_name?>[]" value="<?=$result_array[$i][$primary_id_name]?>">

				&nbsp;&nbsp;&nbsp;&nbsp;[ 
				<a onClick="value=forms['<?=$edit_field_name?>[]'];this.href += value[<?=$i?>].value;" href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&<?=$edit_field_name?>=">Update</a>
				
				]&nbsp;&nbsp;&nbsp;[ 
				<a href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&delete_this=1" onClick="return confirm('Are you sure you want delete this entry?')">Delete</a> ]

			</td>
			<td align="center">
				<input type="checkbox" name="cycle<?=$i?>">
			</td>
		 </tr>
<?
}
?>

		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="<?=$nr_of_cols?>" height="40">
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
				<td width="17%">
					&nbsp;
				</td>
				<td>
					<input type="submit" name="update_button" value="Update All" class="button" style="width:112">
				</td>
				<td align="right">
					<input type="submit" name="update_checked_button" value="Update Checked" class="button" style="width:112">
				</td>
				<td align="right">
					<input type="submit" name="delete_button" value="Delete Checked" class="button" onClick="return confirm('Are you sure want delete these entries?\n This will afected jokes displaying!\nTry to rename it, it is a better solution!');" style="width:112">
				</td>
									

				</tr>
				</table>
			</td>

			</form>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="<?=$nr_of_cols?>">
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<form method=post action="<?=$this_file_name?>?display_nr=<?=$display_nr?>&order_by=<?=$primary_id_name?>&order_type=asc">
					<td width="14%">
					<input type="hidden" name="insert" value="1">
					&nbsp;
					</td>
					<td width="30%">
						<input type="text" name="<?=$edit_field_name?>" class="" size="20">
					</td>
					<td>
						<input type="submit" name="new" value="Add new one" class="button" style="width:100">
					</td>
					</form>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#efefef" colspan="<?=$nr_of_cols?>">
<?
	make_next_previous_with_number( $from, $SQL, $this_file_name, $get_vars ,$display_nr);
?>
			</td>
		</tr>   
		</table>
	</td>
</tr>
<tr>
	<td>
		<form method=post action="<?=$this_file_name?>?order_by=<?=$primary_id_name?>&order_type=asc">
			<br>Total number display: 
			<input type="text" name="display_nr" value="<?=$display_nr?>" class="">
			<input type="submit" name="go" value="Go" class="button">
		</form>
	</td>
</tr>
</table>
<br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>
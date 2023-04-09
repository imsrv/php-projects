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

define ("DEBUG","0");
if(DEBUG)
{
	echo "<font style=\"color:#FF0000;font-family:verdana\"><center><b>*****************DEBUG mode*****************</b></center></font>";
	postvars($HTTP_POST_VARS);
}

$database_table_name = $bx_db_table_jokes;
$this_file_name = "admin_edit_delete_jokes.php";
$page_title = "Edit/Delete Jokes";
$primary_id_name = "joke_id";
$primary_id = $HTTP_GET_VARS[$primary_id_name];
$nr_of_cols = 4;


isset($HTTP_GET_VARS['order_by']) ? ($order_by = $HTTP_GET_VARS['order_by']).($order_type = $HTTP_GET_VARS['order_type']) : ($order_by = $primary_id_name).($order_type = "asc");
isset($HTTP_POST_VARS['display_nr']) && $HTTP_POST_VARS['display_nr'] !='0' && is_numeric($HTTP_POST_VARS['display_nr']) ? ($display_nr = $HTTP_POST_VARS['display_nr']) : (isset($HTTP_GET_VARS['display_nr']) && $HTTP_GET_VARS['display_nr'] !=0 && is_numeric($HTTP_GET_VARS['display_nr']) ? ($display_nr = $HTTP_GET_VARS['display_nr']) : (isset($display_nr) && $display_nr != '0' && is_numeric($display_nr) ? ($display_nr = $display_nr) : ($display_nr = 10)));

$condition = " validate='1' order by ".$order_by." ".$order_type;

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
		$delete_SQL = "delete from $database_table_name where $primary_id_name='".$HTTP_GET_VARS['primary_id_name']."'";

		if(DEBUG)
			echo $delete_SQL."<br>";
		else
			$delete_query = bx_db_query($delete_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}

}
elseif ($HTTP_GET_VARS[$primary_id_name] && $HTTP_POST_VARS['submit'] )	//update via ID
{
	if ($HTTP_POST_VARS['name']=="") 
		$name_error="yes";        
	else 
		$name_error="no";

    if (empty($HTTP_POST_VARS['email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs)) || (verify($HTTP_POST_VARS['email'],"string_int_email")==1))
		$email_error="yes";
	else
		$email_error="no";
	if ($HTTP_POST_VARS['email'] == TEXT_ANONYMOUS)
		$email_error="no";
	if ($HTTP_POST_VARS['joke_text']=="") 
		$joke_text_error="yes";        
	else 
		$joke_text_error="no";
	if ($HTTP_POST_VARS['category_id'] == '0')
		$category_error = "yes";
	else
		$category_error = "no";
	if ($HTTP_POST_VARS['censor_category_id'] == '0' && $use_censor =="yes")
		$censor_category_error = "yes";
	else
		$censor_category_error = "no";
	if ($HTTP_POST_VARS['joke_title']=="") 
		$joke_title_error="yes";        
	else 
		$joke_title_error="no";
	if ($HTTP_POST_VARS['joke_lang']=="0") 
		$joke_lang_error="yes";        
	else 
		$joke_lang_error="no";

	if ($name_error=="no" && $email_error=="no" && $category_error=="no" && $joke_title_error == "no"  && $joke_text_error=="no" && $censor_category_error=="no" && $joke_lang_error=="no" && $HTTP_POST_VARS['submit'])
	{
		$success = 1;
		if (strlen($HTTP_POST_VARS['joke_text'])<=$mini_jokes_length)
			$joke_type="mini";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$mini_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$short_jokes_length)
			$joke_type="short";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$short_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$medium_jokes_length)
				$joke_type="medium";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$medium_jokes_length)
			$joke_type="long";
		else{}

		$select1 = "select * from $database_table_name where joke_id='".$HTTP_GET_VARS['joke_id']."'";
		$select1_query = bx_db_query($select1);
		$sel1_res = bx_db_fetch_array($select1_query);
		$lang_update = ($HTTP_POST_VARS['joke_lang'] ? ", slng='".$HTTP_POST_VARS['joke_lang']."' " : (empty($sel_res1['slng']) ? ", slng='".$slng."' " : "" ));		

		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$update_SQL = "update $database_table_name set category_id='".$HTTP_POST_VARS['category_id']."', name='".$HTTP_POST_VARS['name']."', email='".$HTTP_POST_VARS['email']."', joke_text='".$HTTP_POST_VARS['joke_text']."', joke_type='".$joke_type."', validate='1', joke_title='".$HTTP_POST_VARS['joke_title']."'".($use_censor=="yes" ? ",censor_type='".$HTTP_POST_VARS['censor_category_id']."'" : "")." ".$lang_update." where joke_id='".$HTTP_GET_VARS['joke_id']."'";
		
		if(DEBUG)
			echo $update_SQL;
		else
			$update_query = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	}
	else
		$HTTP_GET_VARS['edit'] = "edit_delete";

}
else{}

if ($HTTP_POST_VARS['submit'] || $HTTP_POST_VARS['x']==1 || isset($HTTP_GET_VARS['from'])) 
{
	$SQL = "select * from $database_table_name";
	$search_condition="";
	
	if ($HTTP_POST_VARS['search']) 
	{
	    $search_text=regexpsearch($HTTP_POST_VARS['search']);
		$search_text_print=$HTTP_POST_VARS['search'];
	}
	elseif($HTTP_GET_VARS['search']) 
	{
	    $search_text=regexpsearch($HTTP_GET_VARS['search']);
		$search_text_print=$HTTP_GET_VARS['search'];
	}
	else{}

	if(!empty($search_text))
	{
		$search_keywords = preg_split("/[\s,]+/",trim($search_text));
		for ($i=0;$i<sizeof($search_keywords);$i++) 
			$search_condition1.= "LCASE(joke_text) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\" or ";

		$search_condition=substr($search_condition1,0,-3);
	
		if($search_condition == "")
			$SQL = $SQL.$condition;
		else
			$SQL = $SQL." where ". $search_condition." and ".$condition;
	}
	else
		 $SQL .= " where ".$condition;
}
else
{
	$SQL = "select * from $database_table_name where".$condition;
}

isset($HTTP_POST_VARS['search']) ? ($search = urlencode(stripslashes($HTTP_POST_VARS['search']))) : (isset($HTTP_GET_VARS['search']) ? ($search = urlencode(stripslashes($HTTP_GET_VARS['search']))) : ($search = ""));

$get_vars = "display_nr=".$display_nr."&search=".$search."&order_by=".$order_by."&order_type=".$order_type;
$title_get_vars = "?display_nr=".$display_nr."&search=".$search."&from=0";
$link_get_vars = $get_vars."&from=".$from."&search=".$search;


$select_position_SQL = "select * from $database_table_name";
$select_position_query = bx_db_query($select_position_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
($HTTP_GET_VARS['from'] > floor((bx_db_num_rows($select_position_query)-1)/$display_nr)*$display_nr) ? ($from = $HTTP_GET_VARS['from'] = $HTTP_GET_VARS['from'] - $display_nr) : (isset($HTTP_GET_VARS['from']) ? ($from = $HTTP_GET_VARS['from']) : (isset($HTTP_POST_VARS['from']) ? ($from = $HTTP_POST_VARS['from']) : ($from = 0)));

$from1 = $from;
$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

/***************************************************************************/
//Form is here
/***************************************************************************/
?>
<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<?
if($HTTP_GET_VARS['edit'])
{
?>
<tr>
	<td>
		<? include (DIR_SERVER_ADMIN."admin_joke_form.php");?><br>
	</td>
</tr>
<?
}
?>
<tr>
	<td>
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
			<td align="center" width="7%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b><a href="<?=$this_file_name.$title_get_vars?>&order_by=<?=$primary_id_name?>&order_type=<?=$HTTP_GET_VARS['order_by'] == $primary_id_name ? ($HTTP_GET_VARS['order_type'] == "asc" ? "desc" : "asc") :  "asc"; ?>" style="color:#ffffff">ID</a></b></font></td>
			<td align="center" width="60%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b><a href="<?=$this_file_name.$title_get_vars?>&order_by=joke_title&order_type=<?=$HTTP_GET_VARS['order_by'] == "joke_title" ? ($HTTP_GET_VARS['order_type'] == "asc" ? "desc" : "asc") :  "asc"; ?>" style="color:#ffffff">Joke Title</a></b></font></td>
			<td align="center" width="30%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Action</b></font></td>
			<td align="center" width="15%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Select</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>?<?=$link_get_vars?>" name="forms">
<?
if (sizeof($result_array) == 0)
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
			<td colspan="<?=$nr_of_cols?>" align="center">
				<b>There are no jokes!</b>
			</td>
		</tr>
<?
}
?>
<?
for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td class="text">
				<input type="hidden" name="display_nr" value="<?=$display_nr?>">
				<?=$result_array[$i][$primary_id_name];?>
			</td>
			<td class="text">
				<?=$result_array[$i]['joke_title'];?>
				<input type="hidden" name="<?=$primary_id_name?>[]" value="<?=$result_array[$i][$primary_id_name]?>">
			</td>
			<td align="center">
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;[ 
				<a target="_blank" href="admin_joke.php?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&joke_title=">Edit/View</a> -->
				[<a  href="<?=$this_file_name?>?<?=$link_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&edit=edit_delete">View/Edit</a>]&nbsp;&nbsp;&nbsp;
				
				
				[<a href="<?=$this_file_name?>?<?=$link_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&delete_this=1" onClick="return confirm('Are you sure you want delete this entry?')">Delete</a>]

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
				</td>
				<td align="right">
				</td>
				<td align="right">
					<input type="submit" name="delete_button" value="Delete Checked" class="button" onClick="return confirm('Are you sure want delete these entries?\n This will afected jokes displaying!\nTry to rename it, it is a better solution!');" style="width:112">
				</td>
									

				</tr>
				</table>
			</td>

			</form>
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
		<form method=post action="<?=$this_file_name?>?order_by=<?=$primary_id_name?>&order_type=asc&display_nr=<?=$display_nr?>">
			<br>Search in jokes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" name="x" value="1">
			<input type="text" name="search" value="<?=$HTTP_POST_VARS['search']?>" class="" onClick="this.select()">
			<input type="submit" name="go" value="Go" class="button">
		</form>
	</td>
</tr>
<tr>
	<td>
		<br>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
				<form method=post action="<?=$this_file_name?>?order_by=<?=$primary_id_name?>&order_type=asc&search=<?=$search?>">
					Total number display:&nbsp;
					<input type="text" name="display_nr" value="<?=$display_nr?>" class="" onClick="this.select()">
					<input type="submit" name="go" value="Go" class="button">
					<input type="hidden" name="x" value="1">
				</form>
					
			</td>
		</tr>
		<tr>
			<td align="center">
<?
if ($search)
{
	echo "<br><a href=\"$this_file_name?display_nr=".$display_nr."\">View All Jokes</a>";
}
?>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>
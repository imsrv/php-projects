<?
include('../config_file.php');

$pro_nr=10;

if ($HTTP_GET_VARS['rebuild']==1)
{
	$deleteSQL = "delete from $bx_db_table_daily_newsletters";
	$delete_query = bx_db_query($deleteSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
}
if ($HTTP_GET_VARS['rebuild']==2)
{
	$updateSQL = "update $bx_db_table_daily_newsletters set joke_text".$slng."=''";
	$update_query = bx_db_query($updateSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
}
else{}

if ($HTTP_GET_VARS['make'] != 1)
{
	refresh("admin_edit_newsletter.php");
	exit;
}

if (MULTILANGUAGE_SUPPORT == "on") 
{
   $dirs = getFiles(DIR_FLAG);

   $deleteSQL = "delete from $bx_db_table_daily_newsletters";
	$delete_query = bx_db_query($deleteSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

   for ($ilang=0; $ilang<count($dirs); $ilang++) 
   {
		$lngname = split("\.",$dirs[$ilang]);
		$post_lng = "_".substr($lngname[0], 0,3);

		$random_row=0;
		$array=null;
		$SQL = "select * from $bx_db_table_jokes as jokes where slng='".$post_lng."' order by rand() limit 0, $pro_nr";
		$sel=bx_db_query($SQL); 
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$count=bx_db_num_rows($sel);
				
		srand((double)microtime()*1000000); // seed the random number generator

		if ($count!=0)
		{
			if ($count>=$pro_nr)
			{
				$nr_random=$pro_nr;		
			}
			else
			{
				$nr_random=$count;
			}
			for($i=0;$i<$nr_random;$i++)
			{
				$random_row = @rand(0, ($count - 1));
				$exist=random_once($array,$random_row);
				if($exist!=1)
				{
					$array[$i]=$random_row;
				}
				else
				{
					$i--;
				}
			}
		}
		$i=0;
		$j=0;

		if($count!="0")
		{
			while($i<sizeof($array))
			{
				$record=bx_db_data_seek($sel, $array[$i]);
				$result_ads=bx_db_fetch_array($sel);
				$test= mysql_query("SELECT * from $bx_db_table_daily_newsletters where date = DATE_ADD(current_date(),INTERVAL $i day)");

				if (mysql_num_rows($test)==0)
				{
					 bx_db_insert($bx_db_table_daily_newsletters ,"joke_id,joke_text".$post_lng.",joke_title".$post_lng.",date", "'$result_ads[joke_id]','".addslashes($result_ads['joke_text'])."','".($result_ads['joke_title'])."',DATE_ADD(current_date(),INTERVAL $i day)");
				}
				else
				{
					$selectdateSQL = "select joke_text".$post_lng.",joke_title".$post_lng." from $bx_db_table_daily_newsletters where date=DATE_ADD(current_date(),INTERVAL $i day) and joke_text".$post_lng." !=''";
					$selectdate_query = bx_db_query($selectdateSQL);
					SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
					if (bx_db_num_rows($selectdate_query)==0)
					{
						$updateSQL = "update $bx_db_table_daily_newsletters set joke_text".$post_lng."='".addslashes($result_ads['joke_text'])."', joke_title".$post_lng."='".($result_ads['joke_title'])."' where date=DATE_ADD(current_date(),INTERVAL $i day)";
						$update_query = bx_db_query($updateSQL);
						SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
					}
				}
				
				if($i==$pro_nr)
				{
					break;
				}
				
				$i++;
			}
		}
   }

}
else
{
	$random_row=0;
	$array=null;
	$SQL = "select * from $bx_db_table_jokes order by rand() limit 0, $pro_nr";
	$sel=bx_db_query($SQL); 
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$count=bx_db_num_rows($sel);
			
	srand((double)microtime()*1000000); // seed the random number generator

	if ($count!=0)
	{
		if ($count>=$pro_nr)
		{
			$nr_random=$pro_nr;		
		}
		else
		{
			$nr_random=$count;
		}
		for($i=0;$i<$nr_random;$i++)
		{
			$random_row = @rand(0, ($count - 1));
			$exist=random_once($array,$random_row);
			if($exist!=1)
			{
				$array[$i]=$random_row;
			}
			else
			{
				$i--;
			}
		}
	}
	$i=0;
	$j=0;


	if($count!="0")
	{
		$deleteSQL = "delete from $bx_db_table_daily_newsletters";
		$delete_query = bx_db_query($deleteSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		while($i<sizeof($array))
		{
			$record=bx_db_data_seek($sel, $array[$i]);
			$result_ads=bx_db_fetch_array($sel);
			//echo "<br>".$result_ads['joke_id'];
			//$test= mysql_query("SELECT * from $bx_db_table_daily_newsletters where date = DATE_ADD(current_date(),INTERVAL $i day)");
			
			
			bx_db_insert($bx_db_table_daily_newsletters ,"joke_id,joke_text".$slng.",joke_title".$slng.",date", "'$result_ads[joke_id]','".addslashes($result_ads['joke_text'])."','".($result_ads['joke_title'])."',DATE_ADD(current_date(),INTERVAL $i day)");
				 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

			/*if (mysql_num_rows($test)==0)
			{
				// echo "<br>joke_id,joke_text".$slng.",date". "'$result_ads[joke_id]','".addslashes($result_ads['joke_text'])."',DATE_ADD(current_date(),INTERVAL $i day)";
				 bx_db_insert($bx_db_table_daily_newsletters ,"joke_id,joke_text".$slng.",joke_title".$slng.",date", "'$result_ads[joke_id]','".addslashes($result_ads['joke_text'])."','".($result_ads['joke_title'])."',DATE_ADD(current_date(),INTERVAL $i day)");
				 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			}
			else
			{
				$test_res = bx_db_fetch_array($test);
				if ($test_res['joke_text'.$slng]=='')
				{*/
					$updateSQL = "update $bx_db_table_daily_newsletters set joke_text".$slng."='".addslashes($result_ads['joke_text'])."', joke_title".$slng."='".addslashes($result_ads['joke_title'])."' where joke_id='".$result_ads['joke_id']."'";
					$update_query = bx_db_query($updateSQL);
					SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
				/*}
			}*/
			
			if($i==$pro_nr)
			{
				break;
			}
			
			$i++;
		}
	}

}
refresh("admin_edit_newsletter.php");
exit;
?>
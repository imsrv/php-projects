<?
	if(isset($url)&&isset($bid))
	{
		include('conn.php');
		if($expired != 1)
		{
			$SQL = "UPDATE banner_stat SET clicks = clicks + 1 WHERE banner_id = $bid";
			mysql_query($SQL,$con);
		}
		header("Location: $url");
	}
?>
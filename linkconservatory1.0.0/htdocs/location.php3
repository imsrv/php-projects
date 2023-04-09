<?
	/*
	** get name of this script
	** Note, different servers require different environment variables
	** Apache: $SCRIPT_FILENAME
	** IIS: $PATH_TRANSLATED
	** Xitami: $PATH_TRANSLATED . $PHP_SELF
	*/
	$ScriptPath = $SCRIPT_FILENAME;
	
	eregi("([^/\\]*)$", $ScriptPath, $match);
	$ThisScript = $match[0];

	/*
	** get root of Web site
	*/
	$Application_Root = eregi_replace("[/\\]htdocs[/\\]$ThisScript", "", $ScriptPath);

	/* 
	** get global settings 
	*/
	include("$Application_Root/modules/include/global_settings");


	/* 
	** initialize database connection 
	*/
	include("$Application_Root/modules/include/init");


	$item_URL = "http://$SiteURL/";

	$Query = "SELECT i.URL, w.Private ";
	$Query .= "FROM item i, wing w ";
	$Query .= "WHERE i.ID=$inputItem ";
	$Query .= "AND i.Wing = w.ID ";

	$DatabaseResult = mysql_query($Query, $DatabaseLink);
	$numRows = mysql_NumRows($DatabaseResult);

	if($numRows > 0)
	{
		$DatabaseRow = mysql_fetch_row($DatabaseResult);
		
		$item_Private = $DatabaseRow[1];

		if(($item_Private=="N") OR ($Browser_Admin == "YES"))
		{
			$item_URL = $DatabaseRow[0];

			/* 
			** update hit count on this link
			*/
			$Query = "UPDATE item ";
			$Query .= "SET LinkCount = LinkCount+1 ";
			$Query .= "WHERE ID=$inputItem ";
			$DatabaseResult = mysql_query($Query, $DatabaseLink);

		}
	}

	header("Location: $item_URL");
	
?>
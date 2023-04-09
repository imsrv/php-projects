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
	$Application_Root = eregi_replace("[/\\]$ThisScript", "", $ScriptPath);

	/* 
	** get global settings 
	*/
	include("$Application_Root/modules/include/global_settings");

	/* 
	** Non-Local people get some extra headers
	**
	** The thinking here is that content changes very slowly, so we send
	** HTTP headers that say the page doesn't expire for 24 hours.  This
	** makes the site faster.
	*/
	if($Browser_Admin != "YES")
	{
		/*
		** get the GMT time for 24 hours from now 
		*/
		$timestamp = gmdate("U") + 86400;
	
		/* 
		** build datetime strings 
		*/
		$Expires = sprintf("%s %02d %s %04d %02d:%02d:%02d GMT",
			gmdate("D", $timestamp), gmdate("d", $timestamp), 
			gmdate("M", $timestamp), gmdate("Y", $timestamp),
			gmdate("H", $timestamp), gmdate("i", $timestamp), 
			gmdate("s", $timestamp));
	
		$LastModified = sprintf("%s %02d %s %04d %02d:%02d:%02d GMT",
			gmdate("D"), gmdate("d"), gmdate("M"), gmdate("Y"),
			gmdate("H"), gmdate("i"), gmdate("s"));
	
		/* 
		** send headers to help out proxy servers 
		*/
		header("Expires: $Expires");
		header("Last-modified: $LastModified");

	}




	/* 
	** initialize database connection 
	*/
	include("$Application_Root/modules/include/init");

	/*
	** get GetWingInfo()
	*/
	include("$Application_Root/modules/include/wing");

	/*
	** Change wing to be integer
	*/
	settype($wing, "integer");

	/*
	** Get Info about the wing
	*/
	GetWingInfo($wing);


	/* 
	** Take action, if need be 
	*/
	if(($ACTION != "") AND (file_exists("$Application_Root/modules/actions/$ACTION")))
	{
		include("$Application_Root/modules/actions/$ACTION");
	}


	/* 
	** build page title 
	*/
	$pageTitle = "The Link Conservatory: ";
	if(($SCREEN == "stroll") && (intval($wing) > 0))
	{
		$pageTitle = $pageTitle . "Strolling Through the $wing_Title Wing";
	}
	elseif(($SCREEN == "add_wing") && (intval($wing) >= 0))
	{
		$pageTitle = $pageTitle . "Adding a Wing to the Conservatory";
	}
	elseif(($SCREEN == "add_item") && (intval($wing) >= 0))
	{
		$pageTitle = $pageTitle . "Adding an Item to the Collection";
	}
	elseif($SCREEN == "tidy")
	{
		$pageTitle = $pageTitle . "Tidying Up";
	}
	elseif($SCREEN == "move_item")
	{
		$pageTitle = $pageTitle . "Re-Classification";
	}
	elseif($SCREEN == "move_wing")
	{
		$pageTitle = $pageTitle . "Re-Classification";
	}
	elseif($SCREEN == "edit_item")
	{
		$pageTitle = $pageTitle . "Alteration";
	}
	elseif($SCREEN == "edit_wing")
	{
		$pageTitle = $pageTitle . "Alteration";
	}
	elseif($SCREEN == "search")
	{
		$pageTitle = $pageTitle . "Searching";
	}
	elseif($SCREEN == "mail")
	{
		$pageTitle = $pageTitle . "Subscribing";
	}
	elseif($SCREEN == "suggest")
	{
		$pageTitle = $pageTitle . "Suggesting a Link";
	}
	elseif($SCREEN == "top10")
	{
		$pageTitle = $pageTitle . "Viewing 10 Most Popular Links";
	}
	elseif($SCREEN == "last10")
	{
		$pageTitle = $pageTitle . "Viewing 10 Newest Links";
	}
	elseif($SCREEN == "random")
	{
		$pageTitle = $pageTitle . "Viewing 10 Random Links";
	}
	elseif($SCREEN == "about")
	{
		$pageTitle = $pageTitle . "What IS the Link Conservatory, Anyway?";
	}
	elseif($SCREEN == "bookmark")
	{
		$pageTitle = $pageTitle . "Making a Bookmark File";
	}
	elseif($SCREEN == "linkcheck")
	{
		$pageTitle = $pageTitle . "Checking Links";
	}
	elseif($SCREEN == "dump")
	{
		$pageTitle = $pageTitle . "Dumping All Links in Printable Form";
	}
	else
	{
		$SCREEN = "stroll";
		$wing = 0;
		
		$pageTitle = $pageTitle . "Standing in the Main Hall";
	}



	/*
	** Start printing the page
	*/

	print("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"");
	print("\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n\n");
	print("<HTML>\n");
	print("<HEAD>\n");
	print("<TITLE>$pageTitle</TITLE>\n");

	/*
	** standard comment block
	*/
	include("$Application_Root/modules/include/ci-comment");

	/*
	** CSS Browsers need style definitions
	*/	
	if($Browser_CSSOK)
	{
		print("<STYLE TYPE=\"text/css\">\n");
		include("$Application_Root/modules/include/styles");
		print("</STYLE>\n");
	}
	print("</HEAD>\n");

	print("<BODY BGCOLOR=\"#FFFFFF\">\n");

	/* 
	** Layout Modules: css, tables, plain 
	*/
	if($SCREEN == "dump")
	{
		/* 
		** just dump content, no navigation 
		*/
		include("$Application_Root/modules/layout/plain");
	}
	elseif($Browser_CSSOK)
	{
		/* 
		** layout page using CSS 
		*/
		include("$Application_Root/modules/layout/css");
	}
	else
	{
		/* 
		** layout the page with tables 
		*/
		include("$Application_Root/modules/layout/tables");
	}

	print("</BODY>\n");
	print("</HTML>\n");
?>

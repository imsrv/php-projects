<?

	$BasicFunctions=array(1,6,8,9,11,12,14,15);

	//admin sections!
	$SECTIONS["members"]["SectionID"]=1;
	$SECTIONS["members"]["Name"]="Manage Subscribers";

	$SECTIONS["lists"]["SectionID"]=2;
	$SECTIONS["lists"]["Name"]="Manage Lists";

	$SECTIONS["admins"]["SectionID"]=3;
	$SECTIONS["admins"]["Name"]="Manage Users";

	$SECTIONS["import"]["SectionID"]=4;
	$SECTIONS["import"]["Name"]="Import Subscribers";

	$SECTIONS["export"]["SectionID"]=5;
	$SECTIONS["export"]["Name"]="Export Subscribers";

	$SECTIONS["banned"]["SectionID"]=6;
	$SECTIONS["banned"]["Name"]="Manage Banned";

	$SECTIONS["forms"]["SectionID"]=7;
	$SECTIONS["forms"]["Name"]="Manage Forms";

	$SECTIONS["customfields"]["SectionID"]=8;
	$SECTIONS["customfields"]["Name"]="Custom Subscriber Fields";

	$SECTIONS["links"]["SectionID"]=9;
	$SECTIONS["links"]["Name"]="Link Manager";

	$SECTIONS["templates"]["SectionID"]=10;
	$SECTIONS["templates"]["Name"]="Newsletter Templates";

	$SECTIONS["compose"]["SectionID"]=11;
	$SECTIONS["compose"]["Name"]="Manage Newsletters";

	$SECTIONS["send"]["SectionID"]=12;
	$SECTIONS["send"]["Name"]="Send Newsletter";

	$SECTIONS["autoresponders"]["SectionID"]=13;
	$SECTIONS["autoresponders"]["Name"]="Manage Autoresponders";

	$SECTIONS["stats"]["SectionID"]=14;
	$SECTIONS["stats"]["Name"]="Statistics";

	$SECTIONS["images"]["SectionID"]=15;
	$SECTIONS["images"]["Name"]="Image Manager";

	$SECTIONS["addsub"]["SectionID"]=16;
	$SECTIONS["addsub"]["Name"]="Add Subscribers via Form";

	function AllowAction($SectionID, $ListID)
	{
		if(AllowSection($SectionID) && AllowList($ListID))
		{
			return 1;
		}
	}

	function AllowSection($SectionID)
	{
		error_reporting(0);

		GLOBAL $CURRENTADMIN;
		GLOBAL $TABLEPREFIX;

		$Ok = 0;
		$AdminID = $CURRENTADMIN["AdminID"];

		if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "allow_functions WHERE AdminID='$AdminID' && SectionID='$SectionID'")) > 0)
		{
			$Ok = 1;
		}
		
		if($CURRENTADMIN["Root"]==1)
		{
			$Ok = 1;
		}
		
		return $Ok;
	}

	function AllowList($ListID)
	{
		GLOBAL $CURRENTADMIN;
		GLOBAL $TABLEPREFIX;
		
		$Ok = 0;
		$AdminID = $CURRENTADMIN["AdminID"];

		if($CURRENTADMIN["Manager"] == 1 || $CURRENTADMIN["Root"] == 1)
		{
			return 1;
		}

		if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "allow_lists WHERE AdminID='$AdminID' && ListID='$ListID'")) > 0)
		{
			$Ok = 1;
		}
		
		return $Ok;
	}

?>
<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////

//EDIT THESE
$MySQLServer="localhost"; //MySQL Server, normally localhost.
$MySQLPort=""; //MySQL port, normally 21.
$MySQLUser=""; //your MySQL username.
$MySQLPass=""; //your MySQL password.
$MySQLDatabase="seeodn"; //name of the database to use for Max-eMail.
//STOP EDITING


//hard coded variables!
$AllowedImageTypes=array("image/gif"=>GIF,"image/jpeg"=>JPEG);
$SendMethods="normal->Normal;";

/////////////////////////// DONT EDIT BELOW THIS LINE ///////////////////////////

//connect to the db!
@mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
if(!mysql_select_db($MySQLDatabase)){
	echo "Cannot connect to database! check config.inc.php";
	exit;
}

if($install!=1){


//see if we have any variables to update!
if($System_Setup){
	foreach($System_Setup as $Name=>$Value){
		mysql_query("DELETE FROM system_setup WHERE Name='$Name'");
		mysql_query("INSERT INTO system_setup Set Name='$Name', Value='$Value'");
	}
}




//now grab all the admin variables from the db!
$vars=mysql_query("SELECT * FROM system_setup");

while($var=mysql_fetch_array($vars)){
	$name=$var["Name"];
	$$name=$var["Value"];
}

//check that all required are available!
$required=array(ROOT_URL,ROOT_DIR,AdminAuthType,AdminLoginTime,MinPassLength,QuickMsg,BannedPerPage);
	$Values[AdminAuthType]="htaccess->HTACCESS Type Authentication,cookies->Form Based Login";
	$Values[AdminLoginTime]="3600";
	$Values[MinPassLength]="5";
	$Values[QuickMsg]="all->Full Messaging Between admins,group->Only to own admin group,none->No Messaging";
	$Values[BannedPerPage]="20";
	
	foreach($required as $req){
		if(!isset($$req) || strlen($$req)<1){
			$NotFound[]=$req;
		}
	}

	//if there are any not found variables we will not prompt for them to be inputted!
	if($NotFound){
		echo 'You need to set the following system variables...<P><form method="post"><TABLE width="60%">';
		foreach($NotFound as $NF){
			$canbe=$Values[$NF];
			$va=explode(",",$canbe);
			echo '<TR><TD align="right">'.$NF.': </TD><TD valign="bottom">&nbsp;';
			if(sizeof($va)>1){
				echo '<select name="System_Setup['.$NF.']">';
				foreach($va as $v){
					list($a,$aa)=explode("->",$v);
					echo '<option value="'.$a.'">'.$aa.'</option>';
				}
				echo '</select>';
			}else{
				echo '<input type=text name="System_Setup['.$NF.']" value="'.$va[0].'"><P>';
			}
			echo '</td></Tr><tr height="1" bgcolor="#cccccc"><td colspan="2"></td></tr>';
		}
		echo '</TABLE><input type=submit value="Save">';
		exit;
	}

//now include the includes etc!
include $ROOT_DIR."/libraries/system.php";


//include the needed libraries
if(!$client){
	foreach($ADMIN_LIBRARIES as $LIBRARY){
		include_once $ROOT_DIR."/libraries/$LIBRARY";
	}



//grab template variables!
//now find out which template we are working with!
$ad=AdminInfo($AdminID);
$template=mysql_query("SELECT * FROM admin_templates WHERE AdminTemplateID='".$ad[AdminTemplateID]."'");
if(mysql_num_rows($template)!=1){
	$template=mysql_query("SELECT * FROM admin_templates ORDER BY IsDefault DESC Limit 1");
}
$AdminTemplate=mysql_fetch_array($template);
}else{
	foreach($CLIENT_LIBRARIES as $LIBRARY){
			include_once $ROOT_DIR."/libraries/$LIBRARY";
	}

}

}
?>
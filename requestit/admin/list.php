<?PHP
##########################################################################  
#                                                                        #
# Request It : Song Request System                                       #
# Version: 1.0b                                                          #
# Copyright (c) 2005 by Jonathan Bradley (jonathan@xbaseonline.com)      #   
# http://requestit.xbaseonline.com                                       #         
#                                                                        #
# This program is free software. You can redistribute it and/or modify   #
# it under the terms of the GNU General Public License as published by   #
# the Free Software Foundation; either version 2 of the License.         #
#                                                                        #
##########################################################################
?>
<?php session_start(); ?>
<?php ob_start(); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); // HTTP/1.0 
?>
<?php
$ewCurSec = 0; // Initialise

// User levels
define("ewAllowadd", 1, true);
define("ewAllowdelete", 2, true);
define("ewAllowedit", 4, true);
define("ewAllowview", 8, true);
define("ewAllowlist", 8, true);
define("ewAllowreport", 8, true);
define("ewAllowsearch", 8, true);																														
define("ewAllowadmin", 16, true);						
?><?php
if (@$HTTP_SESSION_VARS["project1_status"] <> "login") {
	header("Location:  login.php");
	exit();
}
?>
<?php

// Initialize common variables
$x_id = Null; 
$ox_id = Null;
$x_username = Null; 
$ox_username = Null;
$x_password = Null; 
$ox_password = Null;
?>
<?php include ("../includes/db.php") ?>
<?php include ("../includes/phpmkrfn.php") ?>
<?php
$nStartRec = 0;
$nStopRec = 0;
$nTotalRecs = 0;
$nRecCount = 0;
$nRecActual = 0;
$sKeyMaster = "";
$sDbWhereMaster = "";
$sSrchAdvanced = "";
$sDbWhereDetail = "";
$sSrchBasic = "";
$sSrchWhere = "";
$sDbWhere = "";
$sDefaultOrderBy = "";
$sDefaultFilter = "";
$sWhere = "";
$sGroupBy = "";
$sHaving = "";
$sOrderBy = "";
$sSqlMasterBase = "";
$sSqlMaster = "";
$nDisplayRecs = 20;
$nRecRange = 10;

// Open connection to the database
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);

// Handle Reset Command
ResetCmd();

// Build SQL
$sSql = "SELECT * FROM `dj`";

// Load Default Filter
$sDefaultFilter = "";
$sGroupBy = "";
$sHaving = "";

// Load Default Order
$sDefaultOrderBy = "";

// Build WHERE condition
$sDbWhere = "";
if ($sDbWhereDetail <> "") {
	$sDbWhere .= "(" . $sDbWhereDetail . ") AND ";
}
if ($sSrchWhere <> "") {
	$sDbWhere .= "(" . $sSrchWhere . ") AND ";
}
if (strlen($sDbWhere) > 5) {
	$sDbWhere = substr($sDbWhere, 0, strlen($sDbWhere)-5); // Trim rightmost AND
}
$sWhere = "";
if ($sDefaultFilter <> "") {
	$sWhere .= "(" . $sDefaultFilter . ") AND ";
}
if ($sDbWhere <> "") {
	$sWhere .= "(" . $sDbWhere . ") AND ";
}
if (substr($sWhere, -5) == " AND ") {
	$sWhere = substr($sWhere, 0, strlen($sWhere)-5);
}
if ($sWhere != "") {
	$sSql .= " WHERE " . $sWhere;
}
if ($sGroupBy != "") {
	$sSql .= " GROUP BY " . $sGroupBy;
}
if ($sHaving != "") {
	$sSql .= " HAVING " . $sHaving;
}

// Set Up Sorting Order
$sOrderBy = "";
SetUpSortOrder();
if ($sOrderBy != "") {
	$sSql .= " ORDER BY " . $sOrderBy;
}

//echo $sSql; // Uncomment to show SQL for debugging
?>

<?php

// Set up Record Set
$rs = phpmkr_query($sSql,$conn) or die("Failed to execute query: " . phpmkr_error() . '<br>SQL: ' . $sSql);
$nTotalRecs = phpmkr_num_rows($rs);
if ($nDisplayRecs <= 0) { // Display All Records
	$nDisplayRecs = $nTotalRecs;
}
$nStartRec = 1;
SetUpStartRec(); // Set Up Start Record Position
?>
<?php include ("../includes/header.php") ?>
<table border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td valign=top align=left><img src="../images/logo.jpg"></td>
</tr>
	<tr>
		<td><p>&nbsp;</p></td>
	</tr>
		<td colspan=5 class="phpmaker" align=center width=350>[ <a href="../">home</a> ] &nbsp;&nbsp;  [ <a href="add.php">add a new dj</a> ] &nbsp;&nbsp;  [ <a href="../dj">dj login</a> ] &nbsp;&nbsp;  [ <a href="logout">logout</a> ] <p></p></td>
</tr>
	<tr>
		<td><p>&nbsp;</p></td>
	</tr>
	<tr>
		<td class="phpmaker" style="text-indent:5;">Registered Dj's:<p></td>
	</tr>
</table>
<?php if ($nTotalRecs > 0)  { ?>

<table border="0" cellspacing="1" cellpadding="3" valign=top width=350>
	<!-- Table header -->

<form method="post">
	<tr bgcolor="c0c0c0">
		<td valign="top"><span class="phpmaker" style="color: ;">
	id
		</td>
		<td valign="top"><span class="phpmaker" style="color: ;">
	username
		</td>
		<td valign="top"><span class="phpmaker" style="color: ;">
	password 
		</td>
		<td valign="top"><span class="phpmaker" style="color: ;">
	delete 
		</td>
	</tr>
<?php

// Avoid starting record > total records
if ($nStartRec > $nTotalRecs) {
	$nStartRec = $nTotalRecs;
}

// Set the last record to display
$nStopRec = $nStartRec + $nDisplayRecs - 1;

// Move to first record directly for performance reason
$nRecCount = $nStartRec - 1;
if (phpmkr_num_rows($rs) > 0) {
	phpmkr_data_seek($rs, $nStartRec -1);
}
$nRecActual = 0;
while (($row = @phpmkr_fetch_array($rs)) && ($nRecCount < $nStopRec)) {
	$nRecCount = $nRecCount + 1;
	if ($nRecCount >= $nStartRec) {
		$nRecActual++;

		// Set row color
		$sItemRowClass = " bgcolor=\"\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 0) {
			$sItemRowClass = " bgcolor=\"\"";
		}
		$x_id = $row["id"];
		$x_username = $row["username"];
		$x_password = $row["password"];
?>
	<!-- Table body -->
	<tr<?php echo $sItemRowClass; ?>>

		<!-- id -->
		<td valign=top><span class="phpmaker">
<?php echo $x_id; ?>
</span></td>
		<!-- username -->
		<td valign=top><span class="phpmaker">
<?php echo $x_username; ?>
</span></td>
		<!-- password -->
		<td valign=top><span class="phpmaker">
<?php echo $x_password; ?>
</span></td>
		<!-- delete -->
<td><span class="phpmaker"><a href="<?php if ($x_id <> "") {echo "delete.php?id=" . urlencode($x_id); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>">Delete</a></span></td>
	</tr>
<?php
	}
}
?>
</table>
</form>
<?php } ?>



<?php

// Close recordset and connection
phpmkr_free_result($rs);
phpmkr_db_close($conn);
?>

<?php include ("../includes/footer.php") ?>
<?php

//-------------------------------------------------------------------------------
// Function BasicSearchSQL
// - Build WHERE clause for a keyword

function BasicSearchSQL($Keyword)
{
	$sKeyword = (!get_magic_quotes_gpc()) ? addslashes($Keyword) : $Keyword;
	$BasicSearchSQL = "";
	$BasicSearchSQL.= "`artist` LIKE '%" . $sKeyword . "%' OR ";
	$BasicSearchSQL.= "`username` LIKE '%" . $sKeyword . "%' OR ";
	$BasicSearchSQL.= "`password` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($BasicSearchSQL, -4) == " OR ") { $BasicSearchSQL = substr($BasicSearchSQL, 0, strlen($BasicSearchSQL)-4); }
	return $BasicSearchSQL;
}

//-------------------------------------------------------------------------------
// Function SetUpBasicSearch
// - Set up Basic Search parameter based on form elements pSearch & pSearchType
// - Variables setup: sSrchBasic

function SetUpBasicSearch()
{
	global $HTTP_GET_VARS;
	global $sSrchBasic;
	$sSearch = (!get_magic_quotes_gpc()) ? addslashes(@$HTTP_GET_VARS["psearch"]) : @$HTTP_GET_VARS["psearch"];
	$sSearchType = @$HTTP_GET_VARS["psearchtype"];
	if ($sSearch <> "") {
		if ($sSearchType <> "") {
			while (strpos($sSearch, "  ") != false) {
				$sSearch = str_replace("  ", " ",$sSearch);
			}
			$arKeyword = split(" ", trim($sSearch));
			foreach ($arKeyword as $sKeyword)
			{
				$sSrchBasic .= "(" . BasicSearchSQL($sKeyword) . ") " . $sSearchType . " ";
			}
		}
		else
		{
			$sSrchBasic = BasicSearchSQL($sSearch);
		}
	}
	if (substr($sSrchBasic, -4) == " OR ") { $sSrchBasic = substr($sSrchBasic, 0, strlen($sSrchBasic)-4); }
	if (substr($sSrchBasic, -5) == " AND ") { $sSrchBasic = substr($sSrchBasic, 0, strlen($sSrchBasic)-5); }
}

//-------------------------------------------------------------------------------
// Function SetUpSortOrder
// - Set up Sort parameters based on Sort Links clicked
// - Variables setup: sOrderBy, Session("Table_OrderBy"), Session("Table_Field_Sort")

function SetUpSortOrder()
{
	global $HTTP_SESSION_VARS;
	global $HTTP_GET_VARS;
	global $sOrderBy;
	global $sDefaultOrderBy;

	// Check for an Order parameter
	if (strlen(@$HTTP_GET_VARS["order"]) > 0) {
		$sOrder = @$HTTP_GET_VARS["order"];

		// Field id
		if ($sOrder == "id") {
			$sSortField = "`id`";
			$sLastSort = @$HTTP_SESSION_VARS["request_x_id_Sort"];
			if ($sLastSort == "ASC") { $sThisSort = "DESC"; } else{  $sThisSort = "ASC"; }
			$HTTP_SESSION_VARS["request_x_id_Sort"] = $sThisSort;
		}
		else
		{
			if (@$HTTP_SESSION_VARS["request_x_id_Sort"] <> "") { @$HTTP_SESSION_VARS["request_x_id_Sort"] = ""; }
		}

		// Field artist
		if ($sOrder == "username") {
			$sSortField = "`username`";
			$sLastSort = @$HTTP_SESSION_VARS["request_x_username_Sort"];
			if ($sLastSort == "ASC") { $sThisSort = "DESC"; } else{  $sThisSort = "ASC"; }
			$HTTP_SESSION_VARS["request_x_username_Sort"] = $sThisSort;
		}
		else
		{
			if (@$HTTP_SESSION_VARS["request_x_username_Sort"] <> "") { @$HTTP_SESSION_VARS["request_x_username_Sort"] = ""; }
		}

		// Field password
		if ($sOrder == "password") {
			$sSortField = "`password`";
			$sLastSort = @$HTTP_SESSION_VARS["request_x_password_Sort"];
			if ($sLastSort == "ASC") { $sThisSort = "DESC"; } else{  $sThisSort = "ASC"; }
			$HTTP_SESSION_VARS["request_x_password_Sort"] = $sThisSort;
		}
		else
		{
			if (@$HTTP_SESSION_VARS["request_x_password_Sort"] <> "") { @$HTTP_SESSION_VARS["request_x_v_Sort"] = ""; }
		}

		
		$HTTP_SESSION_VARS["request_OrderBy"] = $sSortField . " " . $sThisSort;
		$HTTP_SESSION_VARS["request_REC"] = 1;
	}
	$sOrderBy = @$HTTP_SESSION_VARS["request_OrderBy"];
	if ($sOrderBy == "") {
		$sOrderBy = $sDefaultOrderBy;
		$HTTP_SESSION_VARS["request_OrderBy"] = $sOrderBy;
	}
}

//-------------------------------------------------------------------------------
// Function SetUpStartRec
//- Set up Starting Record parameters based on Pager Navigation
// - Variables setup: nStartRec

function SetUpStartRec()
{

	// Check for a START parameter
	global $HTTP_SESSION_VARS;
	global $HTTP_GET_VARS;
	global $nStartRec;
	global $nDisplayRecs;
	global $nTotalRecs;
	if (strlen(@$HTTP_GET_VARS["start"]) > 0) {
		$nStartRec = @$HTTP_GET_VARS["start"];
		$HTTP_SESSION_VARS["request_REC"] = $nStartRec;
	}elseif (strlen(@$HTTP_GET_VARS["pageno"]) > 0) {
		$nPageNo = @$HTTP_GET_VARS["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			}elseif ($nStartRec >= (($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = (($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$HTTP_SESSION_VARS["request_REC"] = $nStartRec;
		}else{
			$nStartRec = @$HTTP_SESSION_VARS["request_REC"];
			if  (!(is_numeric($nStartRec)) || ($nStartRec == "")) {
				$nStartRec = 1; // Reset start record counter
				$HTTP_SESSION_VARS["request_REC"] = $nStartRec;
			}
		}
	}else{
		$nStartRec = @$HTTP_SESSION_VARS["request_REC"];
		if (!(is_numeric($nStartRec)) || ($nStartRec == "")) {
			$nStartRec = 1; //Reset start record counter
			$HTTP_SESSION_VARS["request_REC"] = $nStartRec;
		}
	}
}

//-------------------------------------------------------------------------------
// Function ResetCmd
// - Clear list page parameters
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters

function ResetCmd()
{
		global $HTTP_SESSION_VARS;
		global $HTTP_GET_VARS;

	// Get Reset Cmd
	if (strlen(@$HTTP_GET_VARS["cmd"]) > 0) {
		$sCmd = @$HTTP_GET_VARS["cmd"];

		// Reset Search Criteria
		if (strtoupper($sCmd) == "RESET") {
			$sSrchWhere = "";
			$HTTP_SESSION_VARS["request_searchwhere"] = $sSrchWhere;

		// Reset Search Criteria & Session Keys
		}elseif (strtoupper($sCmd) == "RESETALL") {
			$sSrchWhere = "";
			$HTTP_SESSION_VARS["request_searchwhere"] = $sSrchWhere;

		// Reset Sort Criteria
		}
		elseif (strtoupper($sCmd) == "RESETSORT") {
			$sOrderBy = "";
			$HTTP_SESSION_VARS["request_OrderBy"] = $sOrderBy;
			if (@$HTTP_SESSION_VARS["request_x_id_Sort"] <> "") { $HTTP_SESSION_VARS["request_x_id_Sort"] = ""; }
			if (@$HTTP_SESSION_VARS["request_x_username_Sort"] <> "") { $HTTP_SESSION_VARS["request_x_username_Sort"] = ""; }
			if (@$HTTP_SESSION_VARS["request_x_password_Sort"] <> "") { $HTTP_SESSION_VARS["request_x_password_Sort"] = ""; }
		}

		// Reset Start Position (Reset Command)
		$nStartRec = 1;
		$HTTP_SESSION_VARS["request_REC"] = $nStartRec;
	}
}
?>

<?
/********************************************************
	lang/nl/search.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("-- kies --"=>"-", "Van"=>"FROM", "Aan"=>"TO", "Onderwerp"=>"SUBJECT","Berichttekst"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("Maakt niet uit"=>"ignore", "is"=>"ON", "is na"=>"SINCE", "is voor"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Zoeken</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Zoek in map   
	<select name="folder">
			<? 
				include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
				$conn = iil_Connect($host, $loginID, $password);
				if ($conn){
					$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
					iil_Close($conn);
				}
				FolderOptions3($folderlist, $defaults);
			?>
	</select>
	<br> waar het veld
	<select name="field">
		<? echo $fieldOptions;?>
	</select>
	 bevat 
	<input type="text" name="string" >
	<br> en de datum 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="day" value="dd" size=2>/
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="year" value="jjjj" size=4>	
	<p><input type="submit" name="search" value="Zoek">
</form>

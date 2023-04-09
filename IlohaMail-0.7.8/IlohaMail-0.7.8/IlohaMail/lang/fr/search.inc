<?
/********************************************************
	lang/eng/search.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("Choisir le champ"=>"-", "De"=>"FROM", "À"=>"TO", "Sujet"=>"SUBJECT","Corps du texte"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("toutes les dates"=>"ignore", "est le"=>"ON", "est postérieure à"=>"SINCE", "est antérieure à"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Recherches</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Chercher dans le dossier  
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
	<br>   Où le champ 
	<select   name="field">
	<?   echo   $fieldOptions;?>
	</select>
	 contient
	<input type="text"  name="string" >
	<br> et que la date 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="jj" size=2>/
	<input type="text" name="year" value="aaaa" size=4>	
	<p><input type="submit" name="search" value="chercher">
</form>

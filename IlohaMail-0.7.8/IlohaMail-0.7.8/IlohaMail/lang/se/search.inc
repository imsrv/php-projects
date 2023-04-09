<?
/********************************************************
	lang/se/search.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	Translated by Markus Svensson <markus.svensson@linux.nu>

********************************************************/

	$fields=array("välj"=>"-", "Från"=>"FROM", "Till"=>"TO", "Ämne"=>"SUBJECT","Meddelande"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("spelar ingen roll"=>"ignore", "är på"=>"ON", "är efter"=>"SINCE", "är före"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Sök</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Sök i mapp  
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
	<br>   där fältet
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 innehåller 
	<input type="text"  name="string" >
	<br> och datumet 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="dd" size=2>/
	<input type="text" name="year" value="yyyy" size=4>	
	<p><input type="submit" name="search" value="Sök">
</form>

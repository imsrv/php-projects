<?
/********************************************************
	lang/pl/search.inc
	(C)2002 Marcin Piliszczuk <marti@net26.pl>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("Zaznacz"=>"-", "Od"=>"FROM", "Do"=>"TO", "Temat"=>"SUBJECT","Tre�� Wiadomo�ci"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("ignoruj"=>"ignore", "dnia"=>"ON", "po"=>"SINCE", "przed"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Szukaj</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Szukaj w folderze  
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
	<br>   gdzie pole
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 contains 
	<input type="text"  name="string" >
	<br> and the date 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="dd" size=2>/
	<input type="text" name="year" value="rrrr" size=4>	
	<p><input type="submit" name="search" value="Szukaj">
</form>

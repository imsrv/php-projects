<?
/********************************************************
	lang/it/search.inc
	
	Italian Translation by Amos B. <mriya3@surfeu.ch>
	Original english file (C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("Scegli"=>"-", "Da"=>"FROM", "A"=>"TO", "Concerne"=>"SUBJECT","Testo del messaggio"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("tutte le date"=>"ignore", "&egrave; il"=>"ON", "&egrave; dopo il"=>"SINCE", "&egrave; prima del"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Ricerca</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Cerca nella cartella  
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
	<br>   Dove il campo
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 contiene
	<input type="text"  name="string" >
	<br> e la data
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="dd" size=2>/
	<input type="text" name="year" value="yyyy" size=4>	
	<p><input type="submit" name="search" value="Cerca">
</form>

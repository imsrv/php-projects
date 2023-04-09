<?
/********************************************************
	lang/eng/search.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array(" (bitte w&auml;hlen) "=>"-", "Absender"=>"FROM", "Empf&auml;nger"=>"TO", "Betreff"=>"SUBJECT","Text"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("egal"=>"ignore", "der"=>"ON", "nach dem"=>"SINCE", "vor dem"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Suche</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Finde Nachrichten im Ordner  
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
	<br> bei denen das Feld 
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 den Text 
	<input type="text"  name="string" > enth&auml;lt
	<br> und das Datum
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="day" value="tt" size=2>.
	<input type="text" name="month" value="mm" size=2>.
	<input type="text" name="year" value="jjjj" size=4> ist	
	<p><input type="submit" name="search" value="Suche starten">
</form>

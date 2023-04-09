<?
/********************************************************
	lang/eng/search.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("selecione"=>"-", "De"=>"FROM", "Para"=>"TO", "Assunto"=>"SUBJECT","Corpo da mensagem"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("n&atilde;o importa"=>"ignore", "exatamente em"=>"ON", "depois de"=>"SINCE", "antes de"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>Search</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	Procurar na pasta  
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
	<br>   onde o campo   
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 cont&eacute;m 
	<input type="text"  name="string" >
	<br> e a data     
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="day" value="dd" size=2>/
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="year" value="aaaa" size=4>	
	<p><input type="submit" name="search" value="Search">
</form>

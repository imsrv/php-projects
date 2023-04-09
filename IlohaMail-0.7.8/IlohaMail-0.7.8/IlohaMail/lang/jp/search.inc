<?
/********************************************************
	lang/jp/search.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	PURPOSE:
		Provide interface for search function.

********************************************************/

	$fields=array("選択..."=>"-", "送信者"=>"FROM", "宛先"=>"TO", "件名"=>"SUBJECT","本文"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("未指定"=>"ignore", "の"=>"SENTON", "以降の"=>"SENTSINCE", "以前の"=>"SENTBEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>検索</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
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
	の中で
	<br>
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 が 
	<input type="text"  name="string" >
	を含み
	<br>日付けが
	<input type="text" name="year" value="yyyy" size=4>年	
	<input type="text" name="month" value="mm" size=2>月
	<input type="text" name="day" value="dd" size=2>日
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	項目。
	<p><input type="submit" name="search" value="検索開始">
</form>

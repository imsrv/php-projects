<?
/********************************************************
	lang/tw/search.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Traditional Chinese (BIG5), for use in Taiwan, 
	Hong Kong, and Overseas Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	$fields=array("請選擇 -- "=>"-", "發信人"=>"FROM", "收信人"=>"TO", "信件主旨"=>"SUBJECT","信件本文"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("不管日期"=>"ignore", "等於"=>"ON", "之後"=>"SINCE", "之前"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>搜尋信件</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	在&nbsp;<select name="folder">
			<? 
				include("lang/".$my_prefs["lang"]."defaultFolders.inc");
				$conn = iil_Connect($host, $loginID, $password);
				if ($conn){
					$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
					iil_Close($conn);
				}
				FolderOptions3($folderlist, $defaults);
			?>
	</select>&nbsp;中，
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 欄位裡頭包含
	<input type="text"  name="string" value="請欲搜尋之輸入關鍵字" onClick=javascript:this.value="";>
	<br>以及收信日期 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="year" value="yyyy" size=4>/	
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="dd" size=2>	
	<p><input type="submit" name="search" value="搜尋信件">
</form>

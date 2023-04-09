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

	$fields=array("�п�� -- "=>"-", "�o�H�H"=>"FROM", "���H�H"=>"TO", "�H��D��"=>"SUBJECT","�H�󥻤�"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("���ޤ��"=>"ignore", "����"=>"ON", "����"=>"SINCE", "���e"=>"BEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>�j�M�H��</h2>
<form method="POST" action="main.php">
	<input type="hidden" name="user" value="<? echo $sid; ?>">
	�b&nbsp;<select name="folder">
			<? 
				include("lang/".$my_prefs["lang"]."defaultFolders.inc");
				$conn = iil_Connect($host, $loginID, $password);
				if ($conn){
					$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
					iil_Close($conn);
				}
				FolderOptions3($folderlist, $defaults);
			?>
	</select>&nbsp;���A
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 �����Y�]�t
	<input type="text"  name="string" value="�б��j�M����J����r" onClick=javascript:this.value="";>
	<br>�H�Φ��H��� 
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	<input type="text" name="year" value="yyyy" size=4>/	
	<input type="text" name="month" value="mm" size=2>/
	<input type="text" name="day" value="dd" size=2>	
	<p><input type="submit" name="search" value="�j�M�H��">
</form>
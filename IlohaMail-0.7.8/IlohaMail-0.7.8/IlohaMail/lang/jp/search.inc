<?
/********************************************************
	lang/jp/search.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	PURPOSE:
		Provide interface for search function.

********************************************************/

	$fields=array("����..."=>"-", "������"=>"FROM", "����"=>"TO", "��̾"=>"SUBJECT","��ʸ"=>"BODY");
	while (list($key, $value) = each ($fields)) {
		$fieldOptions.="<option value=\"$value\">$key\n";
	}
	
	$dates=array("̤����"=>"ignore", "��"=>"SENTON", "�ʹߤ�"=>"SENTSINCE", "������"=>"SENTBEFORE");
	while (list($key, $value) = each ($dates)) {
		$dateOptions.="<option value=\"$value\">$key\n";
	}
?>
<h2>����</h2>
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
	�����
	<br>
	<select   name="field">
		<?   echo   $fieldOptions;?>
	</select>
	 �� 
	<input type="text"  name="string" >
	��ޤ�
	<br>���դ���
	<input type="text" name="year" value="yyyy" size=4>ǯ	
	<input type="text" name="month" value="mm" size=2>��
	<input type="text" name="day" value="dd" size=2>��
	<select name="date_operand">
		<? echo $dateOptions; ?>
	</select>
	���ܡ�
	<p><input type="submit" name="search" value="��������">
</form>
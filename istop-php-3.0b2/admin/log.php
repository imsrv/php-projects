<?
require_once'../config.php';
require_once"html/Table.php";
aut_admin();

$objDB=start_db();

$ss=opendir('../'.DIR_LOG);
while($rd=readdir($ss)){
	if(is_file('../'.DIR_LOG.$rd) and !ereg("\..{0,}$",$rd)){
		$file='../'.DIR_LOG.$rd;
		$lines=file($file);
		$tt=ereg_replace("-",'/',$rd);
		show_table($lines,$tt,$_GET[id]);
	}
}
closedir($ss);


?>
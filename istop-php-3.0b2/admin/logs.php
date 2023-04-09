<?
require_once'../config.php';
require_once"HTML/Table.php";
require_once"PEAR.php";
aut_admin();

if(!empty($_GET['show'])){
	$file='../'.DIR_LOG.$_GET['show'];
	$lines=file($file);
	$tt=ereg_replace("-",'/',$_GET['show']);
	show_table($lines,$tt,$_GET[id]);
	exit;
}

$ss=opendir('../'.DIR_LOG);
while($rd=readdir($ss)){
	if(is_file('../'.DIR_LOG.$rd) and !ereg("\..{0,}$",$rd)){
		$file='../'.DIR_LOG.$rd;
		$tt=ereg_replace("-",'/',$rd);
		echo <<<LOG
			<center><a href="?show=$rd">$tt</a></center>
LOG;
	}
}
closedir($ss);


?>
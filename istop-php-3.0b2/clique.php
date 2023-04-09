<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();

$res=$objDB->query("SELECT cadUrl FROM cadastros WHERE Id='".$_GET['id']."'");

if (DB::isError($res)) {
	die ($res->getMessage());
}

$res->fetchinto($url);

if(!empty($url[0])){
	$objDB->query("UPDATE cadastros SET Cliques=Cliques+1 WHERE Id='".$_GET['id']."'");
	Header("Location: ".$url[0]);
}
$objDB->disconnect();
?>
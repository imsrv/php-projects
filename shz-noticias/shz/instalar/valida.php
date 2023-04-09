<?
include("../config.php");
include "../stl.php";
?>
<html>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?
if (empty($dbserver)){
 		print "<b>Informe um servidor de Mysql!</b><br><i>Ex. localhost</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar";
 		Exit();
	}

if (empty($dbname)){
 		print "<b>Informe um nome para o banco de dados!</b><br><i>Ex. noticias</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar";
 		Exit();
	}

if (empty($dbuser)){
 		print "<b>Informe um nome de usuario para o banco de dados!</b><br><i>Ex. root</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar";
 		Exit();
	}

include "install.php";

?>

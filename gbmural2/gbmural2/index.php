<?php

include("conf.php");
include("functions.php");
include("javascript.php");

# Conectar o MySQL
$conexao = mysql_connect($db[host], $db[user], $db[pass]);
$selectdb = mysql_select_db($db[name]);

$html = " ";
#Seta as ações
if (empty($page)) { include("./home.php"); }
else { include("./".$page.".php"); }

# Imprime tudo no browser
echo template($html);

mysql_close($conexao);
?>

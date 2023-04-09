<?php
require_once"../config.php";
require_once"html/Table.php";
aut_admin();

$objDB=start_db();
$objDB->query("DELETE FROM cadastros WHERE Id='$_GET[id]'");
?><p align="center">&nbsp;</p>
<p align="center"><font face="verdana ,arial" size="1"><b>Website Removido</b></font></p>
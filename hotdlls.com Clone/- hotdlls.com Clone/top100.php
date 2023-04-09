
<?php
require "config.class.php";
require "main.class.php";
require "link.class.php";
$q = stripslashes($q);
$q = eregi_replace("\"", " ", $q);
$q = eregi_replace("\'", " ", $q);
$q = trim($q);
$ddl = new ddl();
$le = new linker();
$ddl->open();
$ddl->get($q, $types);

?>
<center><? $le->get(5, 20) ?>
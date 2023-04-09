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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?    while(list($id, $type, $title, $url, $sname, $surl, $date, $views) = mysql_fetch_row($ddl->get)) {
	echo "<tr> 
                <td ><a href=\"http://www.x-ddl.com/go.php?go=Download&id=$id\" target=\"_blank\">$title</a></td>
         </tr>";
}
?>
</body>
</html>

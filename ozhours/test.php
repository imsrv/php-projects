<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Test</title>
</head>
<body>
<?php
if (file_exists(dirname(__FILE__).'/open_closed.ini.php')) {
 $oc_config = parse_ini_file(dirname(__FILE__).'/open_closed.ini.php', TRUE);
}
if(isset($oc_config['use']) && $oc_config['use'] == 'TEXT') {
	 include('./open.php');
} else {
?>
<img src='./open.php'>
<?php } ?>
</body>
</html>

<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Refresh" content="1200; URL=$insert[site_url]/sidebar.php">
    <title>$insert[site_name]</title> 
</head> 
<body>
	<center> 
			<b>$insert[site_name]</b><br /><br />    
	</center>

TEMPLATE;
?>
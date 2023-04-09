<html>
<head>
	<title>
		[M]ag's [W]hois [C]lass
	</title>
</head>

<body>

<small><a href="#" onclick="window.close(); return false;" style="color:black; text-decoration:none; font-family:verdana; font-size:8pt;"><b>Close Window</b></a></small>

<?php
	include("class/class.whois.php");
	
	
	
	if( $HTTP_GET_VARS["domain"] != "" AND $HTTP_GET_VARS["extension"] != "" )
	{
		$whois = new WhoisStats($HTTP_GET_VARS["domain"], $HTTP_GET_VARS["extension"]);	
	}
?>

</body>
</html>
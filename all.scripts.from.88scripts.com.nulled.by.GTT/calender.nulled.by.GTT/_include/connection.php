<?php
	//mysql_connect("$site","$your_username","$your_password");
	mysql_connect("localhost","root","");
	echo mysql_error();
	mysql_select_db("main");
	echo mysql_error();
?>
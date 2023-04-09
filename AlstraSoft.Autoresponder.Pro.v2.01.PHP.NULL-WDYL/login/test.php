<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");

	$mysqldate = "2000-02-30 32:00:00";

	$usdate = Date::fromMysqlDatetime($mysqldate);

	$new_mysqldate = $usdate->toString(FMT_DATEMYSQL);
	echo $new_mysqldate."<br>";

	if (Date::isMysqlDatetimeValid($mysqldate))
		echo "is valid";
	else
		echo "is NOT valid";

?>
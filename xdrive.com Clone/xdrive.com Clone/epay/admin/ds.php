<?
	chdir("..");
	include("connect.php");
	function init($sql){
		//echo htmlspecialchars($sql),"<br>";
		if (!mysql_query($sql)){
			echo "<i>",mysql_error(),"</i><br>";
		}
		echo "<br>";
	}

	init("DROP TABLE epay_shops");
	init(
		"CREATE TABLE epay_shops(".
		"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
		"owner int NOT NULL,".
		"KEY(owner),".
		// data
		"name varchar(30) NOT NULL,".
		"url varchar(130) NOT NULL,".
		"area TEXT NOT NULL default '',".
		"comment text NOT NULL,".
		"imgfile varchar(30)".
		")"
	);

?>
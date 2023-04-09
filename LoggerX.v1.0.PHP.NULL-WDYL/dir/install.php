<?
include ("./config.php");

	function createDB($dbname, $dbhost, $dbuser, $dbpasswd){
		$fd = fopen ("./dump.txt", "r");
		$succ=0;	
		mysql_connect($dbhost,$dbuser,$dbpasswd);
		mysql_query("CREATE database $dbname");
		mysql_select_db($dbname);
		while (!feof ($fd)) {
		    $line = fgets($fd, 400);
			if (substr($line,0,1) != '#') {
				if (mysql_query(substr(trim($line),0,-1))) {echo "<b>Done:</b> step <b>#".++$succ."</b> of 17 <br>"; };
				// echo substr(trim($line),0,-1)."<br>";
			}
		}
		fclose ($fd);
		if ($succ==17) 
		{echo "<br><b><font color=green>Installation Successfully completed</font></b>"; } else {echo "<br><b><font color=red> Installation Failed </font></b>"; };
	}


createDB($db, $dbhost, $dbuser, $dbpasswd);

?>
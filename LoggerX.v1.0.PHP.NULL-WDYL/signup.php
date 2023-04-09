<?

include ('./db.php');
include ('./dir/config.php');
include ('./dir/global_func.php');

	$Fname = $HTTP_POST_VARS["Fname"];
	$Mname = $HTTP_POST_VARS["Mname"];
	$Lname = $HTTP_POST_VARS["Lname"];
	$Fname = $HTTP_POST_VARS["Fname"];
	$datejoined = date("m:d:Y");
	$acctype = 1;
	$login = $HTTP_POST_VARS["login"];
	$email = $HTTP_POST_VARS["email"];
	$site = $HTTP_POST_VARS["site"];
	$access_level = 2;
	$gender = $HTTP_POST_VARS["gender"];
	$year = $HTTP_POST_VARS["year"];
	$password = $HTTP_POST_VARS["password"];
	$password1 = $HTTP_POST_VARS["password1"];
	$button = $HTTP_POST_VARS["join"];
	$message = $HTTP_POST_VARS["message"];
	$visitors = 0;

	function genCode($userlogin,$site,$imagename,$email) {
		include("./include/top.php");
		include("./include/menu.php");
		include ('./script.htmlt');
		include("./include/down.php");
		include("./include/submenu.php");
	}

	function addUser($Fname,$Mname,$Lname,$datejoined,$acctype,$login,$email,$site,$access_level,$gender,$year,$password) {
		if (!(strpos($site,'.'))) {
			error("Wrong site name: $site");
			die();
		}
		if (!((strpos($email,'.')) && (strpos($email,'@')))) {
			error("Wrong e-mail: $email");
			die();
		}
		$query1 = "SELECT site FROM users WHERE site='$site'";
		if (!($result1 = mysql_query($query1))) {
			error("MySQL error: can't execute query.");
			die();
		}
		$query2 = "SELECT login FROM users WHERE login='$login'";
		if (!($result2 = mysql_query($query2))) {
			error("MySQL error: can't execute query.");
			die();
		}
		if (mysql_num_rows($result2)) {
			error("User $login already exists.");
			die();
		} elseif (mysql_num_rows($result1)){
			error("Site $site already registered");
			die();
		} else {
			$query = "INSERT users SET Fname='$Fname',Mname='$Mname',Lname='$Lname',
					 datej='$datejoined',acctype=1,site = '$site',
					 login='$login',email='$email',access_level=$access_level,
					 gender='$gender',year='$year',password='$password',visitors=0";
			mysql_query($query);
			chooseImage($login,$email);
		}
	}

	function chooseImage($login,$email) {
		include("./include/top.php");
		include("./include/menu.php");
		echo "<br>";
		echo "<form action=\"./signup.php\" method=post>";
		echo "<font style=\"font-family: Arial; font-weight: bold; font-size:12px;\">Select image which <br>will be displayed on your page </font><br><br>";
		echo "<table align=center>";
		$i = 1;
		while (file_exists($file = "./buttons/b$i.jpg")) {
			echo "<tr>";
			echo "<td align=center> <img src=\"$file\"></td><td><input type=radio name=\"imagename\" value=\"$file\"></td>";
			echo "</tr>";
			$i++;
		}
		echo "<tr><td align=center> <br><input type=submit name=\"join\" value=\"Choose\"> </td></tr>";
		echo "</table>";
		echo "<input type=hidden name=\"login\" value=\"$login\">";
		echo "<input type=hidden name=\"email\" value=\"$email\">";
		echo "</form>";
		include("./include/down.php");
		include("./include/submenu.php");
	}

	function error($message) {
		include("./include/top.php");
		include("./include/menu.php");
		echo "<br><table border=1 bordercolor=\"#00319C\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<td class=\"Header\"> ERROR </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\"> $message </td>";
		echo "</tr>";
		echo "</table>";
		include("./include/down.php");
		include("./include/submenu.php");
	}

	if ($button == "Join") {
		if (strlen($password) < 6) {
			error("<center>Your password must have <br> at least six symbols.</center>");
			die();
		}
		if ($password == $password1) {
			$db1 = new DB;
			$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
			addUser($Fname,$Mname,$Lname,$datejoined,$acctype,$login,$email,$site,$access_level,$gender,$year,$password);
		} else {
			error("Reenter password.");
			die();
		}
	}

	if ($button == "Choose") {
		$sitename = $cgi_path;
		$imagename = $HTTP_POST_VARS["imagename"];
		genCode($login,$sitename,$imagename,$email);
	}

	if ($button == "Finish") {
		$name = $login;
		include("./include/top.php");
		include("./include/menu.php");
		include("./message.php");
		include('./content/index.php');
		include("./include/down.php");
		include("./include/submenu.php");
		$message = $HTTP_POST_VARS["message"];
		$email = $HTTP_POST_VARS["email"];
		send_mails($email,"Statistics sign up info!", $thanks_message."\n".$message,"From: ".$adminmail);
	}


?>
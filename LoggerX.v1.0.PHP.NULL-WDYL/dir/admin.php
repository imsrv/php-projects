<?
   include('./config.php');
   include('./global_func.php');

	$action = $HTTP_POST_VARS["action"];
	$subaction = $HTTP_POST_VARS["subaction"];
	$username = $HTTP_POST_VARS["id"];

	function displayAll($HTTP_POST_VARS) {
		$query = "SELECT login,Fname,Lname,email,site,datej,access_level,password FROM users";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}

		$page = $HTTP_POST_VARS["page"];
		$pagesize = $HTTP_POST_VARS["pagesize"];

		if (!($page)) {
			$page = 1;
		}
		if (!($pagesize)) {
			$pagesize = 5;
		}

		$pages = ceil(mysql_num_rows($result) / $pagesize);

		if ($page > $pages) {
			$page = $pages;
		}
		echo "<form action=\"admin.php\" method=post name='thisform'>";
		echo '<table align="center"><tr><td>';
		echo '<input type=hidden name="action" value="displayall">';
		echo "<input type=hidden name='page' value='$page'>";
		echo "<input type=hidden name='pagesize' value='$pagesize'>";
		if ($pages > 1) {
			echo "<center>Pages:&nbsp;";
			if ($page > 1) {
				$pageprev = $page - 10;
				if ($pageprev < 1) {
					$pageprev = 1;
				}
				echo "<a href='admin.php' onclick='document.thisform.page.value = ".$pageprev."; document.thisform.submit(); return false;'> <<  </a>&nbsp;";
			}
			if ($page != 1) {
				echo "<a href='admin.php' onclick='document.thisform.page.value = ".($page - 1)."; document.thisform.submit(); return false;'> < </a>&nbsp;";
			}
			for ($i = 1;$i <= $pages; $i++) {
				if ($page != $i) {
					if (($i < $page + 4) && ($i > $page - 4)) {
						echo '<a href="" onclick="document.thisform.page.value = '.$i.'; document.thisform.submit(); return false;">'.$i.'</a>&nbsp;';
					}
				} else {
					echo "$i&nbsp;";
				}
			}
			if ($page != $pages) {
				echo '<a href="" onclick="document.thisform.page.value = '.($page + 1).';document.thisform.submit(); return false;"> > </a>&nbsp;';
			}
			if ($page < $pages) {
				$pagenext = $page + 10;
				if ($pagenext > $pages) {
					$pagenext = $pages;
				}
				echo '<a href="" onclick="document.thisform.page.value = '.$pagenext.';document.thisform.submit(); return false;"> >> </a>&nbsp;';
			}
		}

		echo "</center>";
		echo '</td><td>';

		echo "Users on page:&nbsp;";
		if ($pagesize > 1) {
			echo "<a href='admin.php' onclick='document.thisform.pagesize.value = ".($pagesize - 1)."; document.thisform.submit(); return false;'> << Less </a>";
		}
		echo "&nbsp; $pagesize &nbsp;";
		echo "<a href='admin.php' onclick='document.thisform.pagesize.value = ".($pagesize + 1)."; document.thisform.submit(); return false;'> More >> </a>";

		echo '</td></tr></table><br>';

		echo "<table align=center cellpadding=3  border=1 bordercolor=\"#000000\"><tr><td>";
		echo "<table align=center cellpadding=5>";
		echo "<tr><td colspan=5 align=center class=\"Header\"> Members </td></tr>";
		$count = 0;
		while (list($login,$Fname,$Lname,$email,$site,$datej,$access,$password) = mysql_fetch_row($result)) {
			if ((++$count <= $page * $pagesize) && ($count > ($page - 1) * $pagesize)) {
				if (!($datej)) {
					$datej = 'None';
				}
				if (!(strstr($site,"http://"))) {
					$site = "http://".$site;
				}
				$usr = str_replace(' ','_____',$login);
				echo "<tr>";
				echo "<td class=\"Table\" colspan=4 border=1 bordercolor=\"#000000\"><input type=checkbox name=\"member".$usr."\" value=\"$login\">";
				echo "$login </td><td class=\"Table\">$password</td>";
				echo "</tr><tr><td></td>";
				echo "<td><b> Name: $Fname ";
				echo "$Lname </b><br>";
				echo "<b>e-mail: </b><a href=\"mailto:$email\" class=\"reg\">$email</a><br>";
				echo "<b> site: </b><a href=\"$site\" class=\"reg\" ";
				echo "onClick=\"window.open('$site','',''); return false;\">$site</a>";
				echo "<td valign=top> <b>joined: </b><br>$datej</td>";
				if ($access == 2) {
					echo "<td valign=top><b>access level:</b> <br>public</td>";
				} elseif ($access == 1) {
					echo "<td valign=top><b>access level:</b> <br>password protected</td>";
				} else {
					echo "<td valign=top><b>access level:</b> <br>suspended</td>";
				}
				echo "</tr>";
			}
		}
		echo "<tr><td bgcolor=\"#4776AF\" > <input type=submit name='action' value='<< Back'> </td>";
		echo "<td colspan=4 bgcolor=\"#4776AF\" align=center>";
		echo '<select name="subaction">';
      	echo '<option value="display">Display</option>';
 		echo '<option value="edit">Edit</option>';
		echo '<option value="email">Email</option>';
		echo '<option value="delete">Delete</option>';
		echo '<option value="suspend">Suspend</option>';
		echo '<option value="resume">Resume</option>';
		echo '</select> &nbsp;&nbsp;&nbsp;';
		echo '<input type=hidden value="members" value="fucking">';
		echo '<input type=submit name="action" value="Execute">';
		echo " </td></tr>";
		echo "</form>";
		echo "</table>";
		echo "</td></tr></table>";
	}

	function displayUser($username) {
		$query = "SELECT * FROM users WHERE login='$username'";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}
		if (!(mysql_num_rows($result))) {
			error(" No such user. ");
			die();
		} 
		list($id,$Fname,$Mname,$Lname,$date,$acctype,$login,$email,$site,$accesslevel,$gender,$year,$password,$visitors) = mysql_fetch_row($result);
		if (!(strstr($site,"http://"))) {
			$site = "http://".$site;
		}
		echo "<table align=center border=1 bordercolor=\"#000000\">";
		echo "<tr><td colspan=2 class=\"Header\"> User information </td></tr>";
		echo "<tr><td class=\"subheader\"> Username </td><td class=\"Table\"> $login </td></tr>";
		echo "<tr><td class=\"subheader\"> First name </td><td class=\"Table\"> $Fname </td></tr>";
		echo "<tr><td class=\"subheader\"> Middle name </td><td class=\"Table\"> $Mname </td></tr>";
		echo "<tr><td class=\"subheader\"> Last name </td><td class=\"Table\"> $Lname </td></tr>";
		echo "<tr><td class=\"subheader\"> E-mail </td><td class=\"Table\"><a href=\"mailto:$email\" class=\"reg\">$email</a></td></tr>";
		echo "<tr><td class=\"subheader\"> Site </td><td class=\"Table\"><a href=\"$site\" class=\"reg\">$site</a></td></tr>";
		echo "<tr><td class=\"subheader\"> Date joined</td><td class=\"Table\">$date</td></tr>";
		echo "<tr><td class=\"subheader\"> Gender </td><td class=\"Table\">$gender</td></tr>";
		echo "<tr><td class=\"subheader\"> Year of birth </td><td class=\"Table\">$year</td></tr>";
		echo "<tr><td class=\"subheader\"> Password </td><td class=\"Table\">$password</td></tr>";
		echo "<tr><td class=\"subheader\"> Access level</td><td class=\"Table\">";
		if ($accesslevel == 2) {
			echo "2-public";
		} elseif ($accesslevel == 1) {
			echo "1-password protected";
		} else {
			echo "0-suspended";
		}
		echo "</td></tr>";
		echo "<form action=\"admin.php\" method=post>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td colspan=5 bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> </td></tr>";
		echo "</form>";
		echo "</table>";
	}

	function editUser($username = "new_user_name",$members = 0) {
		$query = "SELECT * FROM users WHERE login='$username'";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}
		if (!((mysql_num_rows($result)) || ($username == "new_user_name"))) {
			error(" No such user. ");
			die();
		} 
		list($id,$Fname,$Mname,$Lname,$date,$acctype,$login,$email,$site,$accesslevel,$gender,$year,$password,$visitors) = mysql_fetch_row($result);
		echo "<form action=admin.php method=post>";
		echo "<table align=center border=1 bordercolor=\"#000000\">";
		echo "<tr><td colspan=2 class=\"Header\"> User information </td></tr>";
		echo "<tr><td class=\"Table\"> Username </td><td class=\"Table\"> <input type=text value=\"$login\" name=login> </td></tr>";
		echo "<tr><td class=\"Table\"> First name </td><td class=\"Table\"> <input type=text value=\"$Fname\" name=Fname> </td></tr>";
		echo "<tr><td class=\"Table\"> Middle name </td><td class=\"Table\"> <input type=text value=\"$Mname\" name=Mname> </td></tr>";
		echo "<tr><td class=\"Table\"> Last name </td><td class=\"Table\"> <input type=text value=\"$Lname\" name=Lname> </td></tr>";
		echo "<tr><td class=\"Table\"> E-mail </td><td class=\"Table\"><input type=text value=\"$email\" name=email></td></tr>";
		echo "<tr><td class=\"Table\"> Site URL</td><td class=\"Table\"><input type=text value=\"$site\" name=site></td></tr>";
		echo "<tr><td class=\"Table\"> Date joined </td><td class=\"Table\"><input type=text value=\"$date\" name=date></td></tr>";
		echo "<tr><td class=\"Table\"> Gender </td><td class=\"Table\"><input type=text value=\"$gender\" name=gender></td></tr>";
		echo "<tr><td class=\"Table\"> Year of birth </td><td class=\"Table\"><input type=text value=\"$year\" name=year></td></tr>";
		echo "<tr><td class=\"Table\"> Password </td><td class=\"Table\"> <input type=password value=\"$password\" name=password> </td></tr>";
		echo "<tr><td class=\"Table\"> Verify password </td><td class=\"Table\"> <input type=password value=\"$password\" name=vpassword> </td></tr>";
		echo "<input type=hidden name='visitors' value=$visitors>";
		echo "<input type=hidden name='acctype' value=$acctype>";
		echo "<input type=hidden name='members' value=$members>";
		echo "<input type=hidden name=id value=$id>";
		echo "<tr><td class=\"Table\"> Access level *</td><td class=\"Table\"><select name='accesslevel'>";
		if ($username == "new_user_name") {
			$accesslevel = 2;
		}
		if ($accesslevel == 0) {
			echo "<option selected> 0-suspended </option>";
		} else {
			echo "<option> 0-suspended </option>";
		}
		if ($accesslevel == 1) {
			echo "<option selected> 1-password protected </option>";
		} else {
			echo "<option> 1-password protected </option>";
		}
		if ($accesslevel == 2) {
			echo "<option selected> 2-public </option>";
		} else {
			echo "<option> 2-public </option>";
		}
		echo "</select></td></tr>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> </td>";
		echo "<td align=center bgcolor=\"#4776AF\"><input type=submit name=action ";
		if ($username == "new_user_name") {
			echo "value =\"Add user\">";
		} else {
			echo "value =\"Save\">";
		}
		echo "</td></tr>";
		echo "</table>";
		echo "</form>";
	}

	function deleteUser($username) {
		$username = str_replace('_____',' ',$username);
		$query = "SELECT id FROM users WHERE login='$username'";
		$result = mysql_query($query);
		if (!(mysql_num_rows($result))) {
			error("Error no such user");
			die();
		} else {
		list($id) = mysql_fetch_row($result);
			mysql_query( "DELETE FROM users WHERE id=$id");
			mysql_query( "DELETE FROM visitor WHERE id=$id");
			mysql_query( "DELETE FROM browser WHERE id=$id");
			mysql_query( "DELETE FROM color WHERE id=$id");
			mysql_query( "DELETE FROM engine WHERE id=$id");
			mysql_query( "DELETE FROM query WHERE id=$id");
			mysql_query( "DELETE FROM referrer WHERE id=$id");
			mysql_query( "DELETE FROM language WHERE id=$id");
			mysql_query( "DELETE FROM country WHERE id=$id");
			mysql_query( "DELETE FROM java WHERE id=$id");
			mysql_query( "DELETE FROM javascript WHERE id=$id");
			mysql_query( "DELETE FROM resolution WHERE id=$id");
			mysql_query( "DELETE FROM os WHERE id=$id");
			mysql_query( "DELETE FROM week WHERE id=$id");
			mysql_query( "DELETE FROM month WHERE id=$id");
			return 1;
		}
	}

	function suspendUser($username) {
		$query = "UPDATE users SET access_level=0 WHERE login='$username'";
		mysql_query($query);
		return mysql_affected_rows();
	}

	function resumeUser($username) {
		$query = "UPDATE users SET access_level=2 WHERE login='$username'";
		mysql_query($query);
		return mysql_affected_rows();
	}

	function addUser($HTTP_POST_VARS) {
		$Fname = $HTTP_POST_VARS["Fname"];
		$Mname = $HTTP_POST_VARS["Mname"];
		$Lname = $HTTP_POST_VARS["Lname"];
		$acctype = $HTTP_POST_VARS["acctype"];
		$email = $HTTP_POST_VARS["email"];
		$site = $HTTP_POST_VARS["site"];
		$datej = $HTTP_POST_VARS["date"];
		$login = $HTTP_POST_VARS["login"];
		$password = $HTTP_POST_VARS["password"];
		$vpassword = $HTTP_POST_VARS["vpassword"];
		$id = $HTTP_POST_VARS["id"];
		$gender = $HTTP_POST_VARS["gender"];
		$year = $HTTP_POST_VARS["year"];
		$accesslevel = substr($HTTP_POST_VARS["accesslevel"],0,1);
		$visitors = $HTTP_POST_VARS["visitors"];
		$query1 = "SELECT site FROM users WHERE site='$site'";
		if ($password != $vpassword) {
			error("Please, reenter password.");
			die();
		}
		if (strlen($password) < 6) {
			error("<center>Password must have <br> at leastf six symbols.<br> Please, reenter password.</center>");
			die();
		}
		if (!($HTTP_POST_VARS["login"])) {
			error("Please, enter user name.");
			die();
		}
		if (!($HTTP_POST_VARS["site"])) {
			error("Please, enter site name.");
			die();
		}
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
			if (!($datej)) {
				$datej = date("m:d:Y");
			}
			$query = "INSERT users SET Fname='$Fname',Mname='$Mname',Lname='$Lname',
					 datej='$datej',acctype=1,site = '$site',
					 login='$login',email='$email',access_level=$accesslevel,
					 gender='$gender',year='$year',password='$password',visitors=0";
			mysql_query($query);
		}
		confirm("User $username created");
	}

	function saveChanges($HTTP_POST_VARS,$members = 0) {
		$Fname = $HTTP_POST_VARS["Fname"];
		$Mname = $HTTP_POST_VARS["Mname"];
		$Lname = $HTTP_POST_VARS["Lname"];
		$acctype = $HTTP_POST_VARS["acctype"];
		$email = $HTTP_POST_VARS["email"];
		$site = $HTTP_POST_VARS["site"];
		$datej = $HTTP_POST_VARS["date"];
		$login = $HTTP_POST_VARS["login"];
		$password = $HTTP_POST_VARS["password"];
		$vpassword = $HTTP_POST_VARS["vpassword"];
		$id = $HTTP_POST_VARS["id"];
		$gender = $HTTP_POST_VARS["gender"];
		$year = $HTTP_POST_VARS["year"];
		$accesslevel = substr($HTTP_POST_VARS["accesslevel"],0,1);
		$visitors = $HTTP_POST_VARS["visitors"];
		$members = $HTTP_POST_VARS["members"];
		if ($password != $vpassword) {
			error("Please, reenter password");
			die();
		}
		if (strlen($password) < 6) {
			error("<center>Password must have <br> at least six symbols</center>");
			die();
		}
		$query = "UPDATE users SET Fname='$Fname',Mname='$Mname',Lname='$Lname',acctype=$acctype,
									email='$email',site='$site',datej='$datej',login='$login',
									password='$password',gender='$gender',year='$year',
									access_level=$accesslevel WHERE id=$id";
		mysql_query($query);
		confirm("Changes saved.",$members);
	}

	function changeAdminPasswordForm() {
		echo "<form action=admin.php method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<td colspan=2 class=\"Header\"> Change admin password </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\">Old password</td>";
		echo "<td class=\"Table\"><input type=password name=\"oldpassword\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\">New password</td>";
		echo "<td class=\"Table\"><input type=password name=\"newpassword\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\">Verify password</td>";
		echo "<td class=\"Table\"><input type=password name=\"vnewpassword\"></td>";
		echo "</tr>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> ";
		echo "<td class=\"Header\"><input type=submit name=action value=\"Change password\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}

	function confirm($message,$members = 0) {
		echo "<form action=\"admin.php\" method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		if ($members) {
			echo "<input type=hidden name='action' value='displayall'>";
		}
		echo "<tr>";
		echo "<td class=\"Header\"> Confirmation</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\"> $message </td>";
		echo "</tr>";
		echo "<tr><td bgcolor=\"#4776AF\" > ";
		if ($members) {
			echo "<input type=submit value=' << Back '></td></tr>";
		} else {
			echo "<input type=button value=\" << Back \" onClick=\"history.go(-1);\"> </td></tr>";
		}
		echo "</table>";
		echo "</form>";
	}

	function confirmM($message,$users) {
		echo "<form action=\"admin.php\" method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<input type=hidden name='action' value='displayall'>";
		echo "<td class=\"subheader\"> $message </td>";
		echo "</tr>";
		reset($users);
		do {
			echo "<tr>";
			$usr = str_replace('_____',' ',current($users));
			echo "<td class=\"Table\"> ".$usr." </td>";
			echo "</tr>";
		} while (next($users));
		echo "<tr><td bgcolor=\"#4776AF\"> <input type=submit value=\" << Back \"> </td></tr>";
		echo "</table>";
		echo "</form>";
	}

	function changeAdminPassword($HTTP_POST_VARS) {
		$oldpassword = $HTTP_POST_VARS["oldpassword"];
		$newpassword = $HTTP_POST_VARS["newpassword"];
		$vnewpassword = $HTTP_POST_VARS["vnewpassword"];
		$filename = './passwd.php';
		$file = fopen($filename,'r+');
		$content = fgets($file,filesize($filename) + 1);
		$content = substr($content,5);
		$content = substr($content,0,-3);
		fclose($file);
		if ($content == md5($oldpassword)) {
			if ($newpassword == $vnewpassword) {
				$file = fopen($filename,'w+');
				fputs($file,"<?// ".md5($newpassword)." ?>");
				confirm("Password successfully changed.");
				fclose($file);
			} else {
				error("<center>Passwords in fields <br>\"New password\" and \"Verify password\"<br> are not the same.</center>");
			}
		} else {
			 error("Wrong old admin password!");
		}
	}

	function email($username = " all users") {
		$query = "SELECT * FROM users WHERE login='$username'";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}
		if (!((mysql_num_rows($result)) || ($username == " all users"))) {
			error(" No such user. ");
			die();
		} 
		echo "<form action=admin.php method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=5>";
		echo "<tr>";
		echo "<td  class=\"Header\" colspan=2> Send mail to $username </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\" colspan=2> Subject <input type=text name=\"subject\" size=30></td>";
		echo "</tr>";
		echo "<td class=\"Table\" colspan=2>Message <br><textarea cols=35 rows=10 name=\"message\"> </textarea></td>";
		echo "</tr>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td colspan=2 bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> ";
		if ($username != " all users") {
			echo "<input type=submit name=\"action\" value=\"Send message\"></td>";
		} else {
			echo "<input type=submit name=\"action\" value=\"Send message for all\"></td>";
		}
		echo "</tr>";
		echo "</table>";
		if ($username != " all users") {
			echo "<input type=hidden name=\"username\" value=$username>";
		}
		echo "</form>";
	}

	function sendMessage($HTTP_POST_VARS) {
		$username = $HTTP_POST_VARS["username"];
		$subject = $HTTP_POST_VARS["subject"];
		$message = $HTTP_POST_VARS["message"];
		$query = "SELECT email FROM users WHERE login='$username'";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}
		list($to) = mysql_fetch_row($result);
		send_mails($to,$subject,$message,"From: $adminmail");
		confirm("Mail to $username successfully sent");
	}

	function sendMessageToAll($HTTP_POST_VARS) {
		$subject = $HTTP_POST_VARS["subject"];
		$message = $HTTP_POST_VARS["message"];
		echo "Subject:".$subject;
		echo "Message:".$message;
		$query = "SELECT email FROM users";
		if (!($result = mysql_query($query))) {
			error("MySQL error: can't execute query.");
			die();
		}
		while (list($to) = mysql_fetch_row($result)) {
			send_mails($to,$subject,$message,"From: $adminmail");
			echo "<center><b>Sent message to $to</b></center>";
		}
	}

	function error($message) {
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<td class=\"Header\"> ERROR </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\"> $message </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Header\"> <input type=button value='<< Back' onClick='history.go(-1);'> </td>";
		echo "</tr>";
		echo "</table>";
	}

	function enter() {
		echo "<form action=admin.php method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<td colspan=2 class=\"Header\"> Administrative enter </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\">Password</td>";
		echo "<td class=\"Table\"><input type=password name=\"password\"><input type=hidden name=\"action\" value=\"Login\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=2 class=\"Header\"><input type=submit name=\"submit\" value=\"Login\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}

	function login($HTTP_POST_VARS) {
		$password = $HTTP_POST_VARS["password"];
		$filename = './passwd.php';
		$file = fopen($filename,'r+');
		$content = fgets($file,filesize($filename) + 1);
		$content = substr($content,5);
		$content = substr($content,0,-3);
		fclose($file);
		if ($content == md5($password)) {
			require ('admin.htmlt');
		} else {
			 error("Wrong admin password!");
		}
	}

	function sendMessageUsers($HTTP_POST_VARS) {
		$arr = $HTTP_POST_VARS;
		$subject = $arr["subject"];
		$message = $arr["message"];
		reset($arr);
		while(list($key,$value) = each($arr)) {
			if (strstr($key,"member")) {
				$username = substr($key,6);
				$query = "SELECT email FROM users WHERE login='$username'";
				if (!($result = mysql_query($query))) {
					error("MySQL error: can't execute query.");
					die();
				}
				list($to) = mysql_fetch_row($result);
				send_mails($to,$subject,$message,"From: $adminmail");
			}
		}
		confirm("Message sent.");
	}

	function emailUsers($users) {
		echo "<form action=admin.php method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=5>";
		echo "<tr>";
		echo "<td  class=\"Header\" colspan=2> Send mail </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\" colspan=2> Subject <input type=text name=\"subject\" size=30></td>";
		echo "</tr>";
		echo "<td class=\"Table\" colspan=2>Message <br><textarea cols=35 rows=10 name=\"message\"> </textarea></td>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> ";
		echo "<input type=submit name=\"action\" value=\"Send message to members\"></td>";
		echo "</tr>";
		echo "</table>";
		reset($users);
		do {
			echo "<input type=hidden name=\"member".current($users)."\">";
		} while (next($users));
		echo "</form>";
	}

	function confirmDelete($users) {
		echo "<form action=\"admin.php\" method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<input type=hidden name='action' value='Execute'>";
		if (count($users) != 1) {
			echo "<td class=\"subheader\"> Do you want to delete these users? </td>";
		} else {
			echo "<td class=\"subheader\"> Do you want to delete this user? </td>";
		}
		echo "</tr>";
		reset($users);
		do {
			echo "<tr>";
			$usr = current($users);
			$usr = str_replace('_____',' ',$usr);
			echo "<td class=\"Table\"><input type=checkbox checked name='member".current($users)."'>";
			echo $usr." </td>";
			echo "</tr>";
		} while (next($users));
		echo "<tr><td bgcolor=\"#4776AF\"> <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> ";
		echo "<input type=submit name='subaction' value='  Delete  '></td></tr>";
		echo "</table>";
		echo "</form>";
	}

	function changeThanksMessage() {
		$username = '$username';
		include ('../message.php');
		echo "<form action=admin.php method=post>";
		echo "<table border=1 bordercolor=\"#000000\" align=center cellpadding=5>";
		echo "<tr>";
		echo "<td  class=\"Header\" colspan=2> Thanks message text </td>";
		echo "</tr>";
		echo "<td class=\"Table\" colspan=2>Message: <br><textarea cols=45 rows=10 name=\"message\"> $thanks_message </textarea></td>";
		echo "<input type=hidden name=\"action\" value=\"inside\">";
		echo "<tr><td bgcolor=\"#4776AF\" > <input type=button value=\" << Back \" onClick=\"history.go(-1);\"> ";
		echo "<input type=submit name=\"action\" value=\"Save thanks message\"></td>";
		echo "</tr>";
		echo "</table>";
	}

	function saveThanksMessage($HTTP_POST_VARS) {
		$message = $HTTP_POST_VARS["message"];
		$filename = '../message.php';
		$file = fopen($filename,"w+");
		fwrite($file,"<?\n");
		fwrite($file,'$thanks_message = '." \n\"");
		fwrite($file,$message."\";");
		fwrite($file,"?>\n");
		fclose($file);
		confirm("Changes saved.");
	}

	function deleteUsers($users) {
		do {
			deleteUser(current($users));
		} while (next($users));
		confirmM("Users deleted:",$users);
	}

	function suspendUsers($users) {
		do {
			suspendUser(current($users));
		} while (next($users));
		confirmM("Users suspended:",$users);
	}

	function resumeUsers($users) {
		do {
			resumeUser(current($users));
		} while (next($users));
		confirmM("Users resumed:",$users);
	}

	function execute($HTTP_POST_VARS) {
		$arr = $HTTP_POST_VARS;
		$subaction = $arr["subaction"];
		reset ($arr);
		$users = array();
		while (list($key,$value) = each($arr)) {
			if (strstr($key,"member")) {
				array_push($users,substr($key,6));
			};
		}
		if (!(count($users))) {
			error("No user selected");
			die();
		}
		switch ($subaction) {
			case "display" : displayUser($users[0]);
							 break;
			case "edit" : editUser($users[0],1);
							break;
			case "  Delete  "; deleteUsers($users);
							  break;
			case "delete" : confirmDelete($users);
							break;
			case "suspend" : suspendUsers($users);
							break;
			case "resume" : resumeUsers($users);
							break;
			case "email" : emailUsers($users);
							break;
		}
	}

echo "<html>
	   		 <head>
		 		 <title>Administration</title>
				 <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/styles.css\">
				 <script language=\"javascript\">
				 	function aaa(i) {
						document.print('Hello');
						return true;
					}
				 </script>
			</head>
	<body>";


	mysql_pconnect($dbhost,$dbuser,$dbpasswd);
	mysql_select_db("$db");

	switch ($action) {
		case "displayall" : displayAll($HTTP_POST_VARS);
							break;
		case "action" : if ($username) {
							switch ($subaction) {
								case "display": displayUser($username);
												break;
								case "edit": editUser($username);
											 break;
								case "delete":deleteUser($username);
											  confirm("User $username deleted");
											  break;
								case "suspend": suspendUser($username);
												confirm("User $username suspended");
												break;
								case "resume": resumeUser($username);
			              					   confirm("User $username resumed");
											   break;
								case "email": email($username);
							}
						} else {
							error("Please, enter user name!");
						}
						break;
		case "Save" : saveChanges($HTTP_POST_VARS);
					  break;
		case "create": editUser();
					   break;
		case "Add user": addUser($HTTP_POST_VARS);
						 break;
		case "change": changeAdminPasswordForm();
					   break;
		case "message": changeThanksMessage();
					   break;
		case "Save thanks message":saveThanksMessage($HTTP_POST_VARS);
					 break;
		case "Change password": changeAdminPassword($HTTP_POST_VARS);
							    break;
		case "Send message": sendMessage($HTTP_POST_VARS);
							 break;
		case "Send message to members": sendMessageUsers($HTTP_POST_VARS);
							 break;
		case "email": email();
					  break;
		case "Send message for all": sendMessageToAll($HTTP_POST_VARS);
					  break;
		case "":enter();
					 break;
		case "Login":login($HTTP_POST_VARS);
					 break;
		case "Execute": execute($HTTP_POST_VARS);
					    break;
		case "<< Back":require('./admin.htmlt');
						break;
		case "inside":require ('./admin.htmlt');
	}

echo "</body></html>";

?>

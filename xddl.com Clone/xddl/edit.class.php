<?php
class edit extends config {

	function headers() {
		Header("Cache-control: private, no-cache"); 
		Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); # Past date
		Header("Pragma: no-cache");
	}
	
	function form($location) {
		echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" border=\"0\">
<form name=\"add\" action=\"submit.php\" method=\"POST\"><tr><td class=\"form\">Download Name 1*: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 1*:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 2: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 2:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 3: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 3:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 4: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 4:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 5: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 5:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 6: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 6:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 7: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 7:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 8: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 8:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 9: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 9:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>
<tr><td class=\"form\">Download Name 10: </td><td><input type=\"text\" name=\"title[]\" class=\"form\" size=\"30\">
</td><td class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp; Download Url 10:</td><td><input type=\"text\" name=\"url[]\" class=\"form\" size=\"30\">
</td><td><select name=\"type[]\" class=form>".$this->option_list()."</select></tr>

<tr><td class=\"form2\"><br>Site Name*: </td><td><br><input type=\"text\" name=\"sname\" class=\"form\" size=\"30\">
</td><td class=\"form2\"><br>&nbsp;&nbsp;&nbsp;&nbsp; Site Url*: </td>
<td><br><input type=\"text\" name=\"surl\" class=\"form\" size=\"30\"></td></tr><tr><td class=\"form2\">E-mail: </td>
<td colspan=\"4\"><input type=\"text\" name=\"email\" class=\"form\" size=\"30\"></td></tr>
<tr><td></td><td colspan=\"4\" class=\"form2\"><br><input type=\"Submit\" value=\"Submit Download\" class=\"form\">
&nbsp;&nbsp; - Press Only Once!! Submission May Take A While</td></tr></form></table>";
	}

	function login($user, $pass) {
		global $HTTP_COOKIE_VARS, $login;
		if (!$HTTP_COOKIE_VARS[l]) {
			$no_cookie = true;
			$pass = md5($pass);
		}

		if ($user == $this->r_user && $pass == md5($this->r_pass)) {
			setCookie("l[user]", $user);
			setCookie("l[pass]", $pass);
			$login = 0;
			if ($no_cookie)
				header("Location: admin.php");
			return true;
		} else {
			$feil = 1;
			return false;
		}

	}

	function logut() {
		global $l;
		setCookie("l[user]", "", time()-3600);
		setCookie("l[pass]", "", time()-3600);
		$l = 0;
		return true;
	}


	function main($user) {
		echo "<b>Thanks for logging, $user!</b><br><br>\nYou can now view stats, reports and add/edit the downloads<br>
		Just use the menu at the left and remember to log out when your finished<br><br>
		If you have any difficulties or questions don't hesitate to <a href=\"http://www.kaoz.net/?Contact\" target=\"_blank\">contact me</a>.<br><br>";
		$g_total = mysql_query("SELECT count(id) AS TOTAL FROM $this->mysql_tb_dl");
		$total = mysql_result($g_total, 0);
		if ($total <= 0)
			$total = 0;
		$g_total = mysql_query("SELECT count(id) AS TOTAL FROM $this->mysql_tb_que");
		$submitted = mysql_result($g_total, 0);
		$get = mysql_query("SELECT * FROM $this->mysql_tb_dl ORDER BY views DESC");
		$i = 1;
		while ($row = mysql_fetch_array($get)) {
			if ($i == 1) {
				$p[url] = $row[url];
				$p[name] = $row[title];
				$p[sname] = $row[sname];
				$p[surl] = $row[surl];
				$p[v] = $row[views];
			}
			if ($row[reports] != 0)
				$t[rep]++;
			$t[dl]+=$row[views];
			$i = 0;
		}
		$get = mysql_query("SELECT * FROM $this->mysql_tb_le ORDER BY inn DESC");
		while ($row = mysql_fetch_array($get)) {
			if ($i == 0) {
				$l[url] = $row[url];
				$l[name] = $row[title];
				$l[inn] = $row[inn];
				$l[ut] = $row[ut];
			}
			$t[inn]+=$row[inn];
			$t[ut]+=$row[ut];
			$i = 1;
		}
		echo "<br><b>Stats:</b><br><br>
There has been a total of <b>$t[dl]</b> downloads and there are <b>$total</b> downloads in database<br>
<b>$submitted</b> downloads are submitted<br><b>$t[rep]</b> dead links have been reported<br>
<br><b>$t[inn]</b> visitors sent in today<br><b>$t[ut]</b> visitors sent out today
<br>Ratio is currently <b>".@round($t[inn]/$t[ut], 2)."</b><br><br>
Best link is <b><a href=\"$l[url]\" target=\"_blank\">$l[name]</a></b> with <b>$l[inn]</b> visitors in and <b>$l[ut]</b> visitors out.<br>
Most Popular download is <b><a href=\"$p[url]\" target=\"_blank\">$p[name]</a></b> (<a href=\"$p[surl]\" target=\"_blank\">$p[sname]</a>) with <b>$p[v]</b> downloads";
	}

	function stats($id = "") {
		global $page, $del, $ed;
		if ($id == "") {
			if (!$page)
				$page = "1";

			$this->page = $page;
			$this->page*=$this->limit;
			$this->page-=$this->limit;

			$g_total = mysql_query("SELECT COUNT(id) AS TOTAL FROM $this->mysql_tb_dl");
			$this->total = mysql_result($g_total,0);

			$get = mysql_query("SELECT * FROM $this->mysql_tb_dl ORDER BY id DESC LIMIT $this->page, $this->limit");

		echo "<b><font color=red>$this->total</b></font> downloads in database<br><br>
		<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#212C3B\"><tr style=\"color:#FFFFFF;\" align=\"center\">
		<td>Edit</td><td>Type</td><td>Title</td><td>Date</td><td>Submitter</td><td>Views</td></tr>";
			while ($row = mysql_fetch_array($get)) {
	echo "<tr bgcolor=\"#FFFFFF\"><td><a href=\"admin.php?go=stats&id=$row[id]\">Edit</a></td><td align=\"center\">$row[type]</td><td>
<a href=\"$row[url]\" target=\"_blank\">$row[title]</a></td><td>$row[date]</td>
<td><a href=\"$row[surl]\" target=\"_blank\">$row[sname]</a></td><td align=\"center\">$row[views]</td></tr>\n";
			}
			echo "</table><br><br>";
			$this->page("admin.php?go=stats&page=");
		} else {

			if (!$ed) {
			$get = mysql_query("SELECT * FROM $this->mysql_tb_dl WHERE id = '$id'");
			$row = mysql_fetch_array($get);
echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"1\"><form name=\"editid\" action=\"admin.php?go=stats&id=$id\" method=\"POST\">
<tr><td class=\"form2\">Id: </td><td class=\"form\">$id</td></tr>
<tr><td class=\"form2\">Type: </td><td><select name=\"ed[type]\" class=\"form\">";

for ($sig=0; $sig<count($this->type); $sig++) {
	if ($row[type] != $this->type[$sig])
		echo "<option value=\"".$this->type[$sig]."\">".$this->type[$sig]."</option>\n";
	else
		echo "<option value=\"".$this->type[$sig]."\" selected>".$this->type[$sig]."</option>\n";
}

echo "</select></td><tr><td class=\"form2\">Title: </td><td><input type=\"text\" name=\"ed[title]\" size=\"30\" class=\"form\" value=\"$row[title]\"></td></tr>
<tr><td class=\"form2\">Url: </td><td><input type=\"text\" name=\"ed[url]\" size=\"30\" class=\"form\" value=\"$row[url]\"></td></tr>
<tr><td class=\"form2\">Submitter: </td><td><input type=\"text\" name=\"ed[sname]\" size=\"30\" class=\"form\" value=\"$row[sname]\"></td></tr>
<tr><td class=\"form2\">Url: </td><td><input type=\"text\" name=\"ed[surl]\" size=\"30\" class=\"form\" value=\"$row[surl]\"></td></tr>
<tr><td class=\"form2\">E-mail: </td><td><input type=\"text\" name=\"ed[email]\" size=\"30\" class=\"form\" value=\"$row[email]\"></td></tr>
<tr><td class=\"form2\">Delete? </td><td class=\"form\"><input type=\"checkbox\" name=\"del\" value=\"1\"> check to delete</td></tr>
<tr><td></td><td><input type=\"Submit\" value=\"Update!\" class=\"form\"></td></tr></table>";
			} elseif ($del) {
				@mysql_query("DELETE FROM $this->mysql_tb_dl WHERE id = '$id'");
				echo "<b>".$ed[title]." deleted!</b><br><br><a href=\"admin.php?go=stats\">back to download list</a>";
			} else {
				@mysql_query("UPDATE $this->mysql_tb_dl SET type='$ed[type]', title='$ed[title]', url='$ed[url]', sname='$ed[sname]', surl='$ed[surl]', email='$ed[email]' WHERE id = '$id'");
				echo "<b>".$ed[title]." updated!</b><br><br><a href=\"admin.php?go=stats&id=$id\">back to edit</a><br>
				<a href=\"admin.php?go=stats\">back to download list</a>";
			}
		}
	}

	function add($location, $insert) {
		global $HTTP_POST_VARS, $type, $title, $url, $sname, $surl, $email;
		if (!$HTTP_POST_VARS)
			$this->form($location);
		elseif (!$type || !$title || !$url || !$sname || !$surl)
			echo "not all required fields were filled out correctly<br><br><a href=\"javascript:history.go(-1)\">go back</a>";
		else {
			if ($insert)
				$tabellen = $this->mysql_tb_dl;
			else
				$tabellen = $this->mysql_tb_que;

			$i = $banned = 0;
			$dato = $this->dato();
			while ($i < count($title)) {
				if ($title[$i] != "" && $url[$i] != "" && $type[$i] != "") {
					$sql_title = $title[$i];
					$sql_url = $url[$i];
					$sql_type = $type[$i];
					if (!$this->blacklist($surl)) {
					mysql_query("INSERT INTO $tabellen (type, title, url, sname, surl, date, email)
					VALUES ('$sql_type', '$sql_title', '$sql_url', '$sname', '$surl', '$dato', '$email')");
					} else
						$banned = true;
				} else
					break;
				$i++;
			}
			if ($insert && !$banned)
				echo "<b>Data added to database</b><br><br>";
			elseif (!$banned)
				echo "<b>Your downloads have been sent for review</b><br><br>";
			else
				echo "<b><font color=red>Your Site Have been banned!</b></font><br><br>";
		}
	}

	function que($go) {
		global $list;
		$check_first = 1;
		if ($go == "Insert") {
			$this->max_dl--;
			$tabellen = $this->mysql_tb_dl;
			$hvahvor = $this->run($list);
			$dato = $this->dato();
			$g_antall = mysql_query("SELECT COUNT(id) AS TOTAL FROM $tabellen");
			$antall = mysql_result($g_antall,0);
			$antallet = $antall+count($title);
			if ($antallet > $this->max_dl && $this->max_dl > 0) {
				$max_limit = $antall-$this->max_dl;
				$max_get = mysql_query("SELECT * FROM $tabellen ORDER BY id DESC");
				while ($max_row = mysql_fetch_row($max_get)) {
					$max_id[] = $max_row[0];
				}
				for ($i=0; $i<count($max_id); $i++) {
					if ($i == 0)
						$max_query = "WHERE id = '".$max_id[$i]."'";
					else
						$max_query .= " || id = '".$max_id[$i]."'";
				}
				mysql_query("DELETE FROM $tabellen $max_query");
			}
			$get = mysql_query("SELECT * FROM $this->mysql_tb_que WHERE $hvahvor");
			mysql_query("DELETE FROM $this->mysql_tb_que WHERE $hvahvor");
			echo "<b>".count($list)." downloads inserted to database!</b>";
			while ($row = mysql_fetch_array($get)) {
				mysql_query("INSERT INTO $this->mysql_tb_dl (type, title, url, sname, surl, date, email)
				VALUES ('$row[type]','$row[title]','$row[url]','$row[sname]','$row[surl]','$dato','$row[email]')");
			}
			echo "<br><br><a href=\"javascript:history.go(-1)\">back</a>";

		} elseif ($go == "Delete") {
			$hvahvor = $this->run($list);
			mysql_query("DELETE FROM $this->mysql_tb_que WHERE $hvahvor");
			echo "<b>".count($list)." downloads in que deleted!</b><br><br><a href=\"javascript:history.go(-1)\">back</a>";

		} else {
			$get = mysql_query("SELECT * FROM $this->mysql_tb_que");
			echo "<form name=\"f1\" action=\"admin.php?go=added\" method=\"POST\">".mysql_num_rows($get)." downloads submitted for review<br><br>\n\n";
			if (mysql_num_rows($get)) {
				while ($row = mysql_fetch_array($get)) {
					if (!$row[email])
						$row[email] = "no email";
					echo "<input type=\"checkbox\" name=\"list[]\" value=\"".$row[id]."\" class=\"box\"><a href=\"".$row[url]."\" target=\"_blank\">".$row[title]."</a> ($row[type], <a href=\"$row[surl]\" target=\"_blank\">$row[sname]</a> - $row[email])<br>\n";
				}
				echo "<br><input type=\"Submit\" name=\"sub\" value=\"Insert\" class=\"form\">
				<input type=\"Submit\" name=\"sub\" value=\"Delete\" class=\"form\"></form>";
			}
		}
	}
	
	function reported($go) {
		global $list;
		if ($go == "Remove from report list") {
			echo "<b>".count($list)."</b> links removed from report list<br><br>";
			$hvahvor = $this->run($list);
			mysql_query("UPDATE $this->mysql_tb_dl SET reports=0 WHERE $hvahvor");
			echo "<a href=\"javascript:history.go(-1)\">back</a>";
		
		} elseif ($go == "Delete") {
			echo "<b>".count($list)."</b> links deleted from database<br><br>";
			$hvahvor = $this->run($list);
			mysql_query("DELETE FROM $this->mysql_tb_dl WHERE $hvahvor");
			echo "<a href=\"javascript:history.go(-1)\">back</a>";

		} else {
			$get = mysql_query("SELECT * FROM $this->mysql_tb_dl WHERE reports > 0 ORDER BY reports DESC");
			if (mysql_num_rows($get)) {
				echo "<form name=\"f1\" action=\"admin.php?go=report\" method=\"POST\">".mysql_num_rows($get)." links reported as dead<br><br>\n\n";
				while ($row = mysql_fetch_array($get)) {
					echo "<input type=\"checkbox\" name=\"list[]\" value=\"".$row[id]."\" checked> 
<a href=\"admin.php?go=stats&id=$row[id]\">Edit</a> | <a href=\"".$row[url]."\" target=\"_blank\">".$row[title]."</a> ($row[reports] ";
					if ($row[reports] > 1)
						echo "reports";
					else
						echo "report";
					echo ")<br>\n";
				}

				echo "<br><input type=\"Submit\" name=\"sub\" value=\"Delete\" class=\"form\">
				<input type=\"Submit\" name=\"sub\" value=\"Remove from report list\" class=\"form\"></form>";
			} else
				echo "0 reported links!";
		}
	}

	function edit_blacklist() {
		global $save, $blacklisted;
		if ($save) {
			$fp = @fopen("blacklist.txt", "w");
			@fputs($fp, $blacklisted);
			@fclose($fp);
			echo "<b>Updated!</b>";
		}
		$fil = @file("blacklist.txt");
		echo "<form name=\"blacklist\" action=\"admin.php?go=blacklist\" method=\"POST\">
		<textarea cols=\"60\" rows=\"20\" class=\"form\" name=\"blacklisted\">";
		for ($i=0; $i<count($fil); $i++) {
			echo $fil[$i];
		}
		echo "</textarea><br><input type=\"Submit\" name=\"save\" value=\"Update!\" class=\"form\"><br>
		<br>One url per line<br><b>Remeber to enter url with trailing slash at the end (example: http://www.kaoz.net/)</b></form>\n";
	}
}
?>
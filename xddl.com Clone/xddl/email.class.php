<?php
class email extends config {

	function send() {
		global $m;
		$emails = array();
		$i = 0;
		$get = mysql_query("SELECT * FROM $this->mysql_tb_dl WHERE email != ''");
		while ($row = mysql_fetch_array($get)) {
			if (!in_array($row[email], $emails))
				$emails[] = $row[email];
		}
		
		$get = mysql_query("SELECT * FROM $this->mysql_tb_le WHERE email != ''");
		while ($row = mysql_fetch_array($get)) {
			if (!in_array($row[email], $emails))
				$emails[] = $row[email];
		}
		if ($m) {

			$headers = "FROM: ".$this->admin_email."\n";
			$headers .= "X-Sender: ".$this->admin_email."\n";
			$headers .= "X-Mailer: Kaoz.net DDL Script\n";
			$headers .= "X-Priority: 1\n";
			$headers .= "Return-Path: noone@noone.nono\n";
			$headers .= "bcc: ";

			for ($i=0; $i<count($emails); $i++) {
				$headers .= $emails[$i];
				if ($i != count($emails)-1)
					$headers .= ", ";
			}

			if (@mail($this->admin_email, $m[subject], $m[message], $headers))
				echo "<b>Message Sent!</b><br><br>";
			else
				echo "<b><font color=red>Failed to send message!</font></b><br><br>";
		}
		echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" class=\"form2\"><form action=\"admin.php?go=email\" method=\"POST\">\n"
			."<tr><td>Subject:</td><td><input type=\"text\" name=\"m[subject]\" size=\"50\" class=\"form\"></td><td rowspan=4 valign=top><b>E-mail List:</b><br><br>\n"
			."<textarea cols=50 rows=10 class=form>";
			for ($i=0; $i<count($emails); $i++) {
				echo $emails[$i]."\n";
			}
			echo "</textarea></td></tr><tr><td valign=top>Message:</td><td><textarea rows=10 cols=50 class=\"form\" name=\"m[message]\"></textarea></td></tr>\n"
			."<tr><td></td><td><input type=\"submit\" value=\"Send!\" size=\"30\" class=\"form\"></td></tr></form></table>";
	}
}
?>
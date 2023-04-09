<?

	$button = $HTTP_POST_VARS["button"];
	$reset = $HTTP_POST_VARS["reset"];

	function error($message) {
		echo "<table border=1 bordercolor=\"#10317C\" align=center cellpadding=3>";
		echo "<tr bgcolor=\"#10317C\">";
		echo "<td align=center> <font color=white style=\"font-weight: bold;font-size:20px;\">ERROR </font></td>";
		echo "</tr>";
		echo "<tr bgcolor=\"#9CCEFF\">";
		echo "<td><font style=\"font-size:18px;\"> $message </font></td>";
		echo "</tr>";
		echo "</table>";
	}

	if ($button) {
		$image_path = $HTTP_POST_VARS["image_path"];
		$valid_image = $HTTP_POST_VARS["valid_image"];
		$cgi_path = $HTTP_POST_VARS["cgi_path"];
		$sendmail = $HTTP_POST_VARS["sendmail"];
		$os = $HTTP_POST_VARS["os"];
		$db = $HTTP_POST_VARS["db"];
		$dbhost = $HTTP_POST_VARS["dbhost"];
		$adminmail = $HTTP_POST_VARS["adminmail"];
		$admin = $HTTP_POST_VARS["admin"];
		$password = $HTTP_POST_VARS["password"];
		$dbuser = $HTTP_POST_VARS["dbuser"];
		$dbpasswd = $HTTP_POST_VARS["dbpasswd"];

		$filename = 'passwd';
		$file = fopen($filename,'rb');
		$content = fgets($file,filesize($filename) + 1);
		fclose($file);
		if ($content == md5($password)) {
			$filename = 'config';
			$file = fopen($filename,'w+');
			fwrite($file,"<? \n");
			fwrite($file,"\$image_path = \"$image_path\"; \n");
			fwrite($file,"\$valid_image = \"$valid_image\"; \n");
			fwrite($file,"\$cgi_path = \"$cgi_path\"; \n");
			fwrite($file,"\$sendmail = \"$sendmail\"; \n");
			fwrite($file,"\$os = \"$os\"; \n");
			fwrite($file,"\$db = \"$db\"; \n");
			fwrite($file,"\$dbhost = \"$dbhost\"; \n");
			fwrite($file,"\$adminmail = \"$adminmail\"; \n");
			fwrite($file,"\$dbuser = \"$dbuser\"; \n");
			fwrite($file,"\$dbpasswd = \"$dbpasswd\"; \n");
			fwrite($file,"\$admin = \"$admin\"; \n");
			fwrite($file,"?>\n");
			fclose($file);
		} else {
			error("Wrong admin password");
			die();
		}
	} 
	include('config');
	require('setup.html');

?>

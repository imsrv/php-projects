<?php

	/*

		This file contains resuable functions for MailWorks Professional

	*/

	define("RECS_TO_SHOW", 15);

	function doDbConnect()
		{

			global $dbServer, $dbUser, $dbPass, $dbName;

			$s = @mysql_connect($dbServer, $dbUser, $dbPass) or die("<p style='margin-left:20'><br><font face=verdana size=2 color=red><b>ERROR: Couldn't connect to MySQL Database (" . mysql_error() . ")<br><br><a href='config.php'>Update Config File >></a></b></font>");

			$d = @mysql_select_db($dbName, $s) or die("<p style='margin-left:20'><br><font face=verdana size=2 color=red><b>ERROR: Couldn't select MySQL Database (" . mysql_error() . ")<br><br><a href='config.php'>Update Config File >></a></b></font>");

		}

	function JSRedirectTo($Page, $Time)
		{

			?>

				<html>

					<head>

						<meta http-equiv="refresh" content="<?php echo $Time; ?>; url=<?php echo $Page; ?>">

					</head>

				</html>

			<?php

		}

	function isLoggedIn()
		{

			if(@$_COOKIE["auth"] == true)
				return true;
			else
				return false;

		}

	function noAccess()
		{
		
			MakeMsgPage("No Access", "Because of restrictions on your user account, you do not have access to this area of MailWorks Professional. Please use the menu on the left to choose a valid option.<br><br><a href='javascript: history.go(-1);'>Return</a>");
		}


	function GetTopicList($Selected = -1)
		{

			global $dbPrefix;

			doDbConnect();

			$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

			while($row = mysql_fetch_row($result))
				{

					echo "<option ";

					if($row[0] == $Selected)
						echo " SELECTED ";

					echo " value='{$row[0]}'>{$row[1]}</option>";

				}

		}

	function GetFrequencyList($WhichList, $Selected = '')
		{

			if($WhichList == 1)
				{

					for($i = 1; $i <= 7; $i++)
						{

							echo "<option ";

							if($i == $Selected)
								echo " SELECTED ";

							echo " value=$i>$i</option>";

						}

				}
			else
				{

					echo "<option ";

					if($Selected == 1)
						echo " SELECTED ";

					echo "value='1'>day(s)</option>";

					echo "<option ";

					if($Selected == 2)
						echo " SELECTED ";

					echo "value='2'>week(s)</option>";

					echo "<option ";

					if($Selected == 3)
						echo " SELECTED ";

					echo "value='3'>month(s)</option>";

				}

		}

	function GetTemplateList($Selected = 0, $SelectedId = 0, $ShowDesc = true, $import = false)
		{

			// Grab a list of templates and return them as <select> list options

			global $dbPrefix;

			doDbConnect();

			if($import)
				$where = "WHERE nFormat = 'html'";
			else
				$where = "";	

			$result = mysql_query("SELECT pk_nId, nName, nFormat from {$dbPrefix}_newsletters $where ORDER BY nName ASC");

			$i = 0;

			if($ShowDesc == true)
				echo "<option value='-1'>-- Select Newsletter --</option>";

			while($row = mysql_fetch_row($result))
				{

					++$i;

					echo "<option ";

					if($i == $Selected || $row[0] == $SelectedId)
						echo " SELECTED ";

					echo " value='" . $row[0] . "'>" . $row[1] . "</option>";

				}

		}

	function GenerateRandomPassword()
		{

			// Generate a random password for imported users

			$rndPass = "";

			for($i = 0; $i < rand(10, 20); $i++)
				$rndPass .= chr(rand(100, 120));

			return $rndPass;

		}

	function DateDiff ($interval, $date1,$date2) 
		{

			// get the number of seconds between the two dates

			$timedifference =  $date2 - $date1;

			switch ($interval)
				{

					case "w":
						$retval  = $timedifference / 604800;
						break;

					case "d":
						$retval  = $timedifference / 86400;
						break;

					case "h":
						$retval = $timedifference / 3600;
						break;        

					case "n":
						$retval  = $timedifference / 60;
						break;        

					case "s":
						$retval  = $timedifference;
						break;        

				}    

			return $retval;

		}

	function MakeDate($data)
		{

			return substr($data, 4, 2) . '/' . substr($data, 6, 2) . '/' . substr($data, 0, 4);

		}

	function PerTags($data = '', $wrap = true, $id = 0, $email = 'sample@yourdomain.com')
		{

			//replaces the sepcial pertags with there values
			//mailing function

			global $siteName, $siteURL, $dbPrefix;

			$data = str_replace("%%email%%", $email, $data);
			$data = str_replace("%%site_name%%", $siteName, $data);
			$data = str_replace("%%site_url%%", $siteURL, $data);

			$result = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE pk_suId = $id");

			$uRow = mysql_fetch_array($result);

			$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields WHERE cfPerTags = '1' ORDER BY cfWeight DESC, cfTitle ASC");

			while($row = mysql_fetch_array($query))
				{

					switch($row['cfFieldType'])
						{

							case "textarea";
							case "textfield";
								$data = str_replace("%%{$row[2]}%%", $uRow['su_cust_'.$row[2]], $data);
								break;

							case "dropdown";
								$explode = explode(",", $row['cfDefaultValue']);
								if($uRow['su_cust_'.$row[2]] != 0)
									$data = str_replace("%%{$row[2]}%%", $explode[$uRow['su_cust_'.$row[2]] -1], $data);
								else
									$data = str_replace("%%{$row[2]}%%", "", $data);
								break;

							case "yes/no";
								$var = ($uRow['su_cust_'.$row[2]] == '1') ? "Yes" : "No";
								$data = str_replace("%%{$row[2]}%%", $var, $data);
								break;

						}

				}

			// create newline per 80 characters

			if($wrap == true)
				$data = wordwrap($data, 76, "\n", 0);

			return $data;

		}

	function MakeHeader($fromEmail, $format, $replyToEmail = '')
		{

			//mailing function

			$headers  = "From: $fromEmail\n";

			if($replyToEmail != "")
				$headers .= "Reply-To: $replyToEmail\n";

			if($format == "html")
				{

					$headers .= "Content-type: text/html\n";
					$headers .= "charset: iso-8859-1\n";

				}

			$headers .= "MIME-Version: 1.0\n"; 
			$headers .= "X-Sender: <{$fromEmail}>\n";
			$headers .= "X-Mailer: PHP4\n"; 
			$headers .= "X-Priority: 3\n";
			$headers .= "Return-Path: <$fromEmail>\n\n";

			return $headers;

		}

	function DisplayPermissions($type = 'add', $permissions = '')
		{

			$handle = fopen("includes/permissions.inc.php", "rb");

			if($handle)
				{

					while(!feof($handle))
						@$data .= fgets($handle, 1024);

				}

			$data = explode("\n", $data);

			foreach($data as $key=>$string)
				{

					$line = explode("(", $string);

					echo $line[0] . ":<br>\r\n";

					$line[1] = str_replace(")", '', $line[1]);

					$permPairs = explode(",", $line[1]);

					foreach($permPairs as $key=>$value)
						{

							$tmp = explode("|",$value);

							if($type == 'add')
								echo "<input type=\"checkbox\" name=\"{$tmp[1]}\" value=\"1\" checked> {$tmp[0]} \r\n";
							else
								{

								//<input type="checkbox" name="config_view" value="1" <?php if(in_array("config_view", $permissions)) echo "CHECKED"; >> View 

									if(@in_array(trim($tmp[1]), $permissions))
										echo "<input type=\"checkbox\" name=\"{$tmp[1]}\" value=\"1\" checked> {$tmp[0]} \r\n";
									else
										echo "<input type=\"checkbox\" name=\"{$tmp[1]}\" value=\"1\"> {$tmp[0]} \r\n";

								}

						}

					echo "<br><br>";

				}

		}

	function MakeStatusEmail($content)
		{

			$handle = fopen("templates/email.php", "rb");

			if($handle)
				{

					$data = '';

					while(!feof($handle))
						$data .= fgets($handle, 1024);

					if($data != '')
						$content = str_replace("%%content%%", $content, $data);

				}

			return $content;

		}

	function ShowPerTags($show = 1, $return = 0)
		{


			global $dbPrefix;

			$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields WHERE cfPerTags = '1' ORDER BY cfWeight DESC, cfTitle ASC");

			$data = '';

			while($row = mysql_fetch_array($query))
				{

					if($show == 1)
						$data .= "<li><i>%%{$row[2]}%%</i> {$row[1]}</li>\r\n";
					else
						$data .= "<i>%%{$row[2]}%%</i> {$row[1]}<br>\r\n";

				}

			if($return == 0)
				echo $data;
			else
				return $data;

		}

	function MakeMsgPage($title = '', $content = '', $showClose = 1)
		{

			?>

				<table width="98%" align="center" border="0">

					<tr>

						<td height="30">

							<span class="Info">

								<span class="MainHeading"><?php echo $title ?></span>

								<br><br>

								<?php echo $content; ?>

							</span>

						</td>

					</tr>

				<?php 

			if($showClose == '1') echo '</table>';

		}

	function CleanExplode($sep = ',', $array = '') {

		// takes a var, explodes it, and trims extra white space from all elements of the array

		$array = trim($array);

		if(!empty($array)) {

			// the var $array contains data

			$data = explode(',', trim($array));

			for($i = 0; $i < sizeof($data); $i++) {

				$data[$i] = trim($data[$i]);

			}

			return $data;

		} else {

			// Returns [0] as array to stop errors, if [0] is needed

			return array('');			

		}

	}



?>
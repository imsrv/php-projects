<?php
	$message = "";
	$success = false;
	if(isset($install))
	{
	
	$con = @mysql_connect('localhost',$username,$pass);
	if($con)
	{
		if(@mysql_select_db($dbname))
		{
			if($mininame != "" && $minipass != "")
			{
				$SQL = "CREATE TABLE banner (id int(5) NOT NULL auto_increment, campaign_id int(5), size int(2), graphic char(255),  url char(255),  alt char(200),  master char(1) NOT NULL,    PRIMARY KEY (id));";
				if(@mysql_query($SQL))
				{
					$SQL = "CREATE TABLE banner_size (id int(2) NOT NULL auto_increment, size char(8),   PRIMARY KEY (id));";
					if(@mysql_query($SQL))
					{

						$SQL = "INSERT INTO banner_size VALUES ( '1', '88 x 3');";
						@mysql_query($SQL);
						$SQL = "INSERT INTO banner_size VALUES ( '2', '120 x 60');";
						@mysql_query($SQL);
						$SQL = "INSERT INTO banner_size VALUES ( '3', '120 x 90');";
						@mysql_query($SQL);
						$SQL = "INSERT INTO banner_size VALUES ( '4', '125x125');";
						@mysql_query($SQL);
						$SQL = "INSERT INTO banner_size VALUES ( '5', '234 x 60');";
						@mysql_query($SQL);
						$SQL = "INSERT INTO banner_size VALUES ( '6', '468 x 60');";
						@mysql_query($SQL);
						
						$SQL = "CREATE TABLE banner_stat (id int(5) NOT NULL auto_increment,   campaign_id int(5),banner_id int(5),clicks int(5),views int(8),PRIMARY KEY (id));";

						mysql_query($SQL);

						$SQL = "CREATE TABLE campaign (id int(5) NOT NULL auto_increment,group_id char(20), name char(200),start_date datetime,end_date datetime,clicks int(5),   views int(8),PRIMARY KEY (id));";
						@mysql_query($SQL);


						$SQL = "CREATE TABLE user (id int(5) NOT NULL auto_increment,user_id char(20) binary,pass char(15) binary, group_id int(1), PRIMARY KEY (id));";
						@mysql_query($SQL);

						$SQL = "INSERT INTO user VALUES(null,'$mininame','$minipass',1)";
						if(@mysql_query($SQL))
						{
							$success = true;
						}


					}
					
				}
				else
				{
					$message = "<font color='red'><b>Table creation failed. Please contact us at ykf2000@yahoo.com</b></font>";
				}
			}
			else
			{
				$message = "<font color='red'><b>You must provide a username and password to use miniBanner.</font></b>";
			}
		}
		else
		{
			$message = "<font color='red'><b>Installation failed!!! Invalid DATABASE NAME. Please try again.</font></b>";
		}
	}
	else
	{
		$message = "<font color='red'><b>Installation failed!!! Your database USERNAME or PASSWORD is wrong. Please try again.</font></b>";
	}
	}
?>

<html>
<head>
<title>miniScript.com</title>
<style>
	td.logo { font: bold 12pt verdana; }
	td.menu { font: bold 10pt arial; }
	td      { font: 10pt arial; }
	td.news_title { font: bold 10pt arial;}
</style>
</head>
<body bgcolor="orange">
<center>

<table width="80%" cellpadding="0" cellspacing="0" border="0">
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
	<td class="logo" width="50%">miniScript.com</td>
	<td class="menu" align="center"><a href="http://www.miniscript.com/index.php">Home</a></td>
	<td class="menu" align="center"><a href="http://www.miniscript.com/miniproduct.php">miniProducts</a></td>
	<td class="menu" align="center"><a href="http://www.miniscript.com/login.php">Member Login</a></td>
</tr>
</table>
<table width="80%" cellpadding="0" cellspacing="1" border="0" bgcolor="black">
<tr><td>
<?php if(!$success) { ?>
	<table width="100%" cellspacing="0" cellpadding="5" border="0" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<br>
			&nbsp;&nbsp;&nbsp;&nbsp;Welcome to miniBanner installation script. Thank you for your support. We hope that you enjoy using the script. Please follow the steps below and your installation will be complete in a matter of seconds.
		</td>
	</tr>
	<tr>
		<td align="Center"><br><br>
		    <?php echo $message; ?>
			<form action="install.php" method="post">
			<table width="88%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="30%"><b>Database name</b></td><td>:</td><td><input type="text" name="dbname"></td>
			</tr>
			<tr>
				<td width="30%"><b>Database User Name</b></td><td>:</td><td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td width="30%"><b>Database Password</b></td><td>:</td><td><input type="password" name="pass"></td>
			</tr>
			<tr>
				<td colspan="3"><font size="1"><i>Not that this script will attemp to connect to your database and create the neccessary table for this program to work. If you are unsure of what you are doing please abort installation.</i></font>
				</td>
			</tr>
			<tr>
				<td colspan="3"><hr></td></tr>
			</tr>
			<tr>
				<td width="30%"><b>Prefered Username</b></td><td>:</td><td><input type="text" name="mininame"></td>
			</tr>
			<tr>
				<td width="30%"><b>Prefered Password</b></td><td>:</td><td><input type="password" name="minipass"></td>
			</tr>
			<tr>
				<td colspan="3"><font size="1"><i>Preferred username and password is use to access your miniBanner administration area.</i></font>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3"><input type="submit" name="install" value="Install miniBanner">
				</td>
			</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
<?php } else {?>
	<table width="100%" cellspacing="0" cellpadding="5" border="0" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<br>
			&nbsp;&nbsp;&nbsp;&nbsp;Congratulations!!! Installation successfull. Please create the following directory structure for miniBanner to function properly. In your WWW root directory create a folder called "banner". Copy all the following files according to the order below:
			<br><br>
			<u>banner</u>
			<ol>
				<li>add_banner.php
				<li>addb.php
				<li>banner.php
				<li>banner_main.php
				<li>bug_report.php
				<li>campaign.php
				<li>code.php
				<li>detail.php
				<li>editb.php
				<li>editc.php
				<li>java.php
				<li>redirect.php
				<li>relogin.php
				<li>login.php
			</ol>
			<br><br>
		    After the above step, please copy the following text and create a file named conn.php. This file should also be put into the "banner" directory.
			<br><br><font color="red">
			&lt?php
					<br>
			$con = mysql_connect('localhost','<? echo $username; ?>','<? echo $pass; ?>');<br>
			if(!@mysql_select_db('<? echo $dbname; ?>'))<br>
			{<br>
				&nbsp;&nbsp;mail('ykf2000@yahoo.com','DataBase Error','Cannot Select DataBase');<br>
				&nbsp;&nbsp;header('Location: login.php');<br>
			}

			?&gt</font><br><br>

		</td>
	</tr>
	</table>
<?php } ?>
</td></tr>
</table><br>
<font face="arial" size="1"><i>Disclaimer : We cannot be held responsible for any damage or whatsoever cause by the use of software offered in this site. </i></font><br>
	<font face="arial" size="1"><i>&copy miniScript.com <? echo date("Y"); ?>
</center>
</body>
</html>

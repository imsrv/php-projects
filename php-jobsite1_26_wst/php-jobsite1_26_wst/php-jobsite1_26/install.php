<?php
function write_config($cf, $filename)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("define\('".$cf['h'][$i]."'(.*)",$buffer,$regs)) {
                   if($cf['h'][$i] != "DIR_ADMIN") {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."','".$cf['v'][$i]."');\n",$buffer);
                   }
                   else {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."',".$cf['v'][$i]."');\n",$buffer);
                   }
            }
        }
        $to_write .= $buffer;
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func
function read_config($cf, $filename)
{
    $c_out = array();
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("define\('".$cf['h'][$i]."','(.*)'",$buffer,$regs)) {
                 $c_out[$cf['h'][$i]] = $regs[1];
            }
        }
    }
    fclose($fp);
    return $c_out;
} // end func
?>
<html>
<head>
<title>Php jobsite Install</title>
<style>
<!--
	TD { font-size: 12px; font-weight: bold; color: #000000; font-family: arial}
	INPUT {color: #003399; background: transparent; font-size: 13px; text-align: center; font-weight: bold; border: 1px solid #000000}
	TEXTAREA {color: #003399; background: transparent; font-size: 11px; font-weight: bold; border: 1px solid #000000}
	H1 { font-size: 14px; font-weight: bold; color: #003399; font-family: arial}
	.info {color: #993333; font-size: 11px; font-weight: normal; font-family: serif}
	.license {color: #FF0000; font-size: 13px; font-weight: bold; font-family: arial}
	.error {color: #FF0000; font-size: 11px; font-weight: normal; font-family: serif}
     .highlight { font-size: 12px; font-weight: bold; color: #0000FF; font-family: arial}
	.error2 {color: #FF0000; font-size: 12px; font-weight: bold; font-family: arial;}
	.button {background: #DDDDDD;font-size: 11px; font-weight: bold; letter-spacing : 1px;}
	.checkbox {color: #003399; background: transparent; font-size: 13px; text-align: center; font-weight: bold; border: 0px solid #000000}
//-->
</style>
</head>
<body>
<?php if($HTTP_POST_VARS['step']==1) {
	$admin_dir = eregi_replace(eregi_replace("\\\\","\\\\",$HTTP_POST_VARS['scr_path']), "", $HTTP_POST_VARS['admin_path']); 
    ?>
	<form method="post" action="install.php">
	<input type="hidden" name="step" value="2">
	<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
	<?php
	if (fileperms($HTTP_POST_VARS['admin_path']) != 16895) {
    ?>
	<tr>
	<td align="center"><font class="error2">Script</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['admin_path'];?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight"><?php echo eregi_replace("/$", "", $admin_dir);?></font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['admin_path'].") <font class=\"error2\">".(eregi_replace("/$", "", $admin_dir))."</font> directory is OK...</td></tr>";
	}
    if (fileperms($HTTP_POST_VARS['scr_path']."logs") != 16895) {
	?>
	<tr>
	<td align="center"><font class="error2">logs</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['scr_path']."logs";?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight">logs</font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['scr_path']."logs".") <font class=\"error2\">logs</font> directory is OK...</td></tr>";
	}
    
    if (fileperms($HTTP_POST_VARS['scr_path']."logo") != 16895) {
	?>
	<tr>
	<td align="center"><font class="error2">logo</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['scr_path']."logo";?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight">logo</font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['scr_path']."logo".") <font class=\"error2\">logo</font> directory is OK...</td></tr>";
	}
    if (fileperms($HTTP_POST_VARS['scr_path']."resumes") != 16895) {
	?>
	<tr>
	<td align="center"><font class="error2">resumes</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['scr_path']."resumes";?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight">resumes</font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['scr_path']."resumes".") <font class=\"error2\">resumes</font> directory is OK...</td></tr>";
	}
    
	if (fileperms($HTTP_POST_VARS['scr_path']."languages") != 16895) {
	?>
	<tr>
	<td align="center"><font class="error2">languages</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['scr_path']."languages";?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight">languages</font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['scr_path']."languages".") <font class=\"error2\">languages</font> directory is OK...</td></tr>";
	}
	if (fileperms($HTTP_POST_VARS['scr_path']."other") != 16895) {
	?>
	<tr>
	<td align="center"><font class="error2">other</font> directory (path): &nbsp;&nbsp;<?php echo $HTTP_POST_VARS['scr_path']."other";?></td>
	</tr>
	<tr>
		<td align="center" class="error">(Can't write to the specified <font class="highlight">other</font> directory. Please <b>"chmod 777"</b> this directory and Refresh this page.)</td>
	</tr>
    <?php
	$error=1;
	}
	else {
		echo "<tr><td align=\"center\" colspan=\"2\">(".$HTTP_POST_VARS['scr_path']."other".") <font class=\"error2\">other</font> directory is OK...</td></tr>";
	}
	if ($error) {
		echo "<tr><td align=\"center\"><input type=\"button\" value=\"Refresh\" onclick=\"document.location.reload();\"></td></tr>";
	}
	else {
		$cf['h'][] = "HTTP_SERVER";
        $cf['v'][] = $HTTP_POST_VARS['scr_url'];
        $cf['h'][] = "HTTPS_SERVER";
        $cf['v'][] = $HTTP_POST_VARS['scr_sslurl'];
        $cf['h'][] = "HTTP_SERVER_ADMIN";
        $cf['v'][] = $HTTP_POST_VARS['admin_url'];
        $cf['h'][] = "DIR_ADMIN";
        $cf['v'][] = DIR_SERVER_ROOT.".'".$admin_dir;
        $cf['h'][] = "DIR_SERVER_ROOT";
        $cf['v'][] = $HTTP_POST_VARS['scr_path'];
        $st['h'][] = "SITE_MAIL";
        $st['v'][] = $HTTP_POST_VARS['site_mail'];
        $st['h'][] = "SITE_NAME";
        $st['v'][] = $HTTP_POST_VARS['site_name'];
        $st['h'][] = "SITE_TITLE";
        $st['v'][] = $HTTP_POST_VARS['site_title'];
        write_config($cf, "application_config_file.php");
        write_config($st, "application_settings.php");
	?>
	<tr><td colspan="2" align="center">&nbsp;</td></tr>
	<tr><td colspan="2" align="center"><h1>Mysql database connection information</h1></td></tr>
	<tr>
		<td align="right">Myqsl database host: &nbsp;&nbsp;</td><td><input type="text" name="mysql_host" size="25"  value="localhost"></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(In most cases is localhost...Ask your webadmin or your hosting company if not sure...)</td>
	</tr>	
	<tr>
		<td align="right">Myqsl database user: &nbsp;&nbsp;</td><td><input type="text" name="mysql_user" size="25"  value=""></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(Ask your webadmin or your hosting company if not sure...)</td>
	</tr>	
	<tr>
		<td align="right">Myqsl database password: &nbsp;&nbsp;</td><td><input type="text" name="mysql_passwd" size="25"  value=""></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(Ask your webadmin or your hosting company if not sure...)</td>
	</tr>	
	<tr>
		<td align="right">Myqsl database name: &nbsp;&nbsp;</td><td><input type="text" name="mysql_dbname" size="25"  value=""></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(You must have created this database in order to take the next step...Ask your webadmin or your hosting company if not sure...)</td>
	</tr>	
    <tr>
		<td align="right">&nbsp;&nbsp;<input type="checkbox" name="skip_db" value="yes" title="Skip database tables creation" class="checkbox"></td><td>Skip database tables creation</td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(Skip database tables creation if you have the tables created and filled up with data...)</td>
	</tr>	
    <tr>
		<td align="right">&nbsp;&nbsp;<input type="checkbox" name="update_db" value="yes" title="Update database if available" class="checkbox"></td><td>Update database if available</td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="info">(Update database tables if update available...)</td>
	</tr>	
	<tr>
		<td align="center" colspan="2"><input type="submit" name="next" class="button" value="Next step"></td>
	</tr>
	<?php
	}//end else if $error
	?>
		</table>
	</form>
	<?php
}
else if ($HTTP_POST_VARS['step']=="2") {
	?>
	<form method="post" action="install.php">
	<input type="hidden" name="step" value="2">
	<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
	<?php
	$error = 0;
	if (@mysql_connect($HTTP_POST_VARS['mysql_host'], $HTTP_POST_VARS['mysql_user'], $HTTP_POST_VARS['mysql_passwd'])) {
		if (mysql_select_db($HTTP_POST_VARS['mysql_dbname'])) {
			echo "<tr><td align=\"center\">Successful connection to \"".$HTTP_POST_VARS['mysql_dbname']."\" database...</td></tr>";
		}
		else {
			echo "<tr><td align=\"center\"><font color=\"red\">Mysql connection error...".mysql_error()."</font></td></tr>";
			echo "<tr><td align=\"center\"><font color=\"black\">Go <a href=\"javascript:history.go(-1);\">Back</a> and change the connection settings...</font></td></tr>";
			$error =1;
		}
	}
	else {
	    echo "<tr><td align=\"center\"><font color=\"red\">Mysql connection error...".mysql_error()."</font></td></tr>";
		echo "<tr><td align=\"center\"><font color=\"black\">Go <a href=\"javascript:history.go(-1);\">Back</a> and change the connection settings...</font></td></tr>";
		$error = 1;
	}
	if (!$error) {
		function split_sql(&$ret, $sql)
        {
            $sql          = trim($sql);
            $sql_len      = strlen($sql);
            $char         = '';
            $string_start = '';
            $in_string    = FALSE;
            $time0        = time();
            for ($i = 0; $i < $sql_len; ++$i) {
                $char = $sql[$i];
                // We are in a string, check for not escaped end of strings except for
                // backquotes that can't be escaped
                if ($in_string) {
                    for (;;) {
                        $i = strpos($sql, $string_start, $i);
                        // No end of string found -> add the current substring to the
                        // returned array
                        if (!$i) {
                            $ret[] = $sql;
                            return TRUE;
                        }
                        // Backquotes or no backslashes before quotes: it's indeed the
                        // end of the string -> exit the loop
                        else if ($string_start == '`' || $sql[$i-1] != '\\') {
                            $string_start      = '';
                            $in_string         = FALSE;
                            break;
                        }
                        // one or more Backslashes before the presumed end of string...
                        else {
                            // ... first checks for escaped backslashes
                            $j                     = 2;
                            $escaped_backslash     = FALSE;
                            while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                                $escaped_backslash = !$escaped_backslash;
                                $j++;
                            }
                            // ... if escaped backslashes: it's really the end of the
                            // string -> exit the loop
                            if ($escaped_backslash) {
                                $string_start  = '';
                                $in_string     = FALSE;
                                break;
                            }
                            // ... else loop
                            else {
                                $i++;
                            }
                        } // end if...elseif...else
                    } // end for
                } // end if (in string)
                // We are not in a string, first check for delimiter...
                else if ($char == ';') {
                    // if delimiter found, add the parsed part to the returned array
                    $ret[]      = substr($sql, 0, $i);
                    $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
                    $sql_len    = strlen($sql);
                    if ($sql_len) {
                        $i      = -1;
                    } else {
                        // The submited statement(s) end(s) here
                        return TRUE;
                    }
                } // end else if (is delimiter)
        
                // ... then check for start of a string,...
                else if (($char == '"') || ($char == '\'') || ($char == '`')) {
                    $in_string    = TRUE;
                    $string_start = $char;
                } // end else if (is start of string)
        
                // ... for start of a comment (and remove this comment if found)...
                else if ($char == '#'
                         || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
                    // starting position of the comment depends on the comment type
                    $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
                    // if no "\n" exits in the remaining string, checks for "\r"
                    // (Mac eol style)
                    $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                                      ? strpos(' ' . $sql, "\012", $i+2)
                                      : strpos(' ' . $sql, "\015", $i+2);
                    if (!$end_of_comment) {
                        // no eol found after '#', add the parsed part to the returned
                        // array if required and exit
                        if ($start_of_comment > 0) {
                            $ret[]    = trim(substr($sql, 0, $start_of_comment));
                        }
                        return TRUE;
                    } else {
                        $sql          = substr($sql, 0, $start_of_comment)
                                      . ltrim(substr($sql, $end_of_comment));
                        $sql_len      = strlen($sql);
                        $i--;
                    } // end if...else
                } // end else if (is comment)
              
            } // end for
        
            // add any rest to the returned array
            if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
                $ret[] = $sql;
            }
            return $ret;
        }
		if (!$skip_db) {
			echo "<tr><td align=\"center\">&nbsp;</td></tr>";
			echo "<tr><td align=\"center\">Creating database tables...</td></tr>";
			if (file_exists("mysql.sql")) {
				$sql_query = fread(fopen("mysql.sql", "r"), filesize("mysql.sql"));
			}
			else {
				echo "<tr><td align=\"center\">&nbsp;</td></tr>";
				echo "<tr><td align=\"center\" class=\"error2\">Can't find mysql.sql file....in ".dirname(getenv(SCRIPT_FILENAME))." directory...<br>Please correct this error and try again...</td></tr>";
				echo "</table>";
				exit;
			}
			$my_pieces  = split_sql($pieces, $sql_query);
			if (count($pieces) == 1 && !empty($pieces[0])) {
				$pieces[0] = trim($pieces[0]);
				$result = mysql_query ($pieces[0]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[0]."<br>Please check if you have the original mysql.sql file...</td></tr>");
			}
			else {
				for ($i=0; $i<count($pieces); $i++)
				{
					$pieces[$i] = trim($pieces[$i]);
					if(!empty($pieces[$i]) && $pieces[$i] != "#") {
						$result = mysql_query ($pieces[$i]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[$i]."<br>Please check if you have the original mysql.sql file...</td></tr>");
					}
				}
			}
			echo "<tr><td align=\"center\">Success...</td></tr>";
			echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        }
		if ($update_db) {
			echo "<tr><td align=\"center\">&nbsp;</td></tr>";
			echo "<tr><td align=\"center\">Updating database tables...</td></tr>";
			if (file_exists("update.sql")) {
				$sql_query = fread(fopen("update.sql", "r"), filesize("update.sql"));
				$my_pieces  = split_sql($pieces, $sql_query);
				if (count($pieces) == 1 && !empty($pieces[0])) {
					$pieces[0] = trim($pieces[0]);
					$result = mysql_query ($pieces[0]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[0]."<br>Please check if you have the original update.sql file...</td></tr>");
				}
				else {
				    for ($i=0; $i<count($pieces); $i++)
					{
						$pieces[$i] = trim($pieces[$i]);
						if(!empty($pieces[$i]) && $pieces[$i] != "#") {
							$result = mysql_query ($pieces[$i]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[$i]."<br>Please check if you have the original update.sql file...</td></tr>");
						}
					}
				}
				}
				else {
					echo "<tr><td align=\"center\">&nbsp;</td></tr>";
					echo "<tr><td align=\"center\" class=\"error2\">No update available</td></tr>";
				}
				echo "<tr><td align=\"center\">Success...</td></tr>";
				echo "<tr><td align=\"center\">&nbsp;</td></tr>";
			}

                        echo "<tr><td align=\"center\">Writing config file...</td></tr>";
                        $cf['h'][] = "DB_SERVER";
                        $cf['v'][] = $HTTP_POST_VARS['mysql_host'];
                        $cf['h'][] = "DB_SERVER_USERNAME";
                        $cf['v'][] = $HTTP_POST_VARS['mysql_user'];
                        $cf['h'][] = "DB_SERVER_PASSWORD";
                        $cf['v'][] = $HTTP_POST_VARS['mysql_passwd'];
                        $cf['h'][] = "DB_DATABASE";
                        $cf['v'][] = $HTTP_POST_VARS['mysql_dbname'];
                        $cf['h'][] = "INSTALLATION_DATE";
                        $cf['v'][] = date('Y-m-d');
                        write_config($cf, "application_config_file.php");
                        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
                        echo "<tr><td align=\"center\"><h1>Successfull installation</h1></td></tr>";
                        echo "<tr><td align=\"center\"><a href=\"index.php\">Go and check out!!!</a></td></tr>";
                        echo "<tr><td align=\"right\"><a href=\"admin/admin_settings.php\">More Options you can configure from Here!!!</a></td></tr>";
                        $st_read['h'][] = "SITE_NAME";
                        $st_read['h'][] = "SITE_MAIL";
                        $st_in = read_config($st_read, "application_settings.php");
                        $cf_read['h'][] = "HTTP_SERVER";
                        $cf_read['h'][] = "HTTP_SERVER_ADMIN";
                        $cf_read['h'][] = "DIR_SERVER_ROOT";
                        $cf_read['h'][] = "PHP_JOBSITE_VERSION";
                        $cf_read['h'][] = "INSTALLATION_DATE";
                        $cf_in = read_config($cf_read, "application_config_file.php");
                        $mail_admin = "Congratulations!\nYou successfully installed Php-Jobsite ".$cf_in['PHP_JOBSITE_VERSION']."\n";
                        $mail_phpjobsite = "New installation of Php-Jobsite ".$cf_in['PHP_JOBSITE_VERSION']."\n";
                        $mail_admin .= "Install Date: ".$cf_in['INSTALLATION_DATE']."\n";
                        $mail_phpjobsite .= "Install Date: ".$cf_in['INSTALLATION_DATE']."\n";
                        $mail_admin .= "Main Link: ".$cf_in['HTTP_SERVER']."\n";
                        $mail_phpjobsite .= "Root DIR: ".$cf_in['DIR_SERVER_ROOT']."\n";
                        $mail_phpjobsite .= "Main Link: ".$cf_in['HTTP_SERVER']."\n";
                        $mail_admin .= "Admin Link: ".$cf_in['HTTP_SERVER_ADMIN']."\n\n";
                        $mail_phpjobsite .= "Admin Link: ".$cf_in['HTTP_SERVER_ADMIN']."\n";
                        $mail_phpjobsite .= "Php Version: ".phpversion()."\n";
                        $mail_phpjobsite .= "OS: ".PHP_OS."\n";
                        $mail_phpjobsite .= "IP: ".$HTTP_SERVER_VARS['REMOTE_ADDR']."\n";
                        $mail_phpjobsite .= "Server: ".$HTTP_SERVER_VARS['HTTP_HOST']."\n";
                        $mail_phpjobsite .= "Install Location: ".__FILE__."\n";
                        $mail_phpjobsite .= "Install link: "."http://".eregi_replace("/$","",(getenv(HTTP_HOST)?getenv(HTTP_HOST):$HTTP_SERVER_VARS['HTTP_HOST']).dirname((getenv(REQUEST_URI)?getenv(REQUEST_URI):$HTTP_SERVER_VARS['REQUEST_URI'])))."/\n";
                        $mail_admin .= "Any problems or suggestions please send them to php-jobsite@bitmixsoft.com\n";
                        $mail_admin .= "We wish you \"Good Luck\" in your business.\n\n BITMIXSOFT TEAM.";
                        @mail($st_in['SITE_MAIL'],"Installation - Php Jobsite ".$cf_in['PHP_JOBSITE_VERSION'], $mail_admin, "From: ".$st_in['SITE_NAME']." <".$st_in['SITE_MAIL'].">");
                        @mail("php"."-job"."site"."@"."bit"."mix"."so"."ft".".c"."om","Installation - Php Jobsite ".$cf_in['PHP_JOBSITE_VERSION'], $mail_phpjobsite, "From: ".$st_in['SITE_NAME']." <".$st_in['SITE_MAIL'].">");
                }
                mysql_close();
    ?>
		</table>
	</form>
	<?php
}
else if($HTTP_POST_VARS['step'] == "agree") {
    if($HTTP_POST_VARS['user_agree'] == "N") {?>
        <table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%" class="license">You do not agree with the Terms and Conditions!<br>You don't have the right to use this software.</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%">You can email to the author (<a href="mailto:php-jobsite@bitmixsoft.com">php-jobsite@bitmixsoft.com</a>) for more information.</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank You!</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        </table>
    <?php }
    elseif($HTTP_POST_VARS['user_agree'] == "Y") {
?>
<form method="post" action="install.php">
<input type="hidden" name="step" value="1">
<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
<tr>
	<td align="right">Script directory (path): &nbsp;&nbsp;</td><td><input type="text" name="scr_path" size="50"  value="<?php echo dirname(__FILE__);?>/"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(Path to the directory where the script will be located - / at the end is necessary)</td>
</tr>
<tr>
	<td align="right">Admin directory (path): &nbsp;&nbsp;</td><td><input type="text" name="admin_path" size="50"  value="<?php echo dirname(__FILE__);?>/admin/"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(Path to the directory where the script admin will be located - / at the end is necessary)</td>
</tr>
<?php
$script_url = "http://".eregi_replace("/$","",(getenv(HTTP_HOST)?getenv(HTTP_HOST):$HTTP_SERVER_VARS['HTTP_HOST']).dirname((getenv(REQUEST_URI)?getenv(REQUEST_URI):$HTTP_SERVER_VARS['REQUEST_URI'])));
if(!eregi("/$", $script_url)) {
   $script_url .= "/"; 
}
$ssl_url = eregi_replace("http", "https", $script_url);
?>
<tr>
	<td align="right">Script URL: &nbsp;&nbsp;</td><td><input type="text" name="scr_url" size="50"  value="<?php echo $script_url;?>"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(url of the script, - / at the end is necessary)</td>
</tr>
<tr>
	<td align="right">Script SSL URL: &nbsp;&nbsp;</td><td><input type="text" name="scr_sslurl" size="50"  value="<?php echo $ssl_url;?>"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(SSL url of the script (use http if you don't have SSL) - / at the end is necessary</td>
</tr>
<tr>
	<td align="right">Admin URL: &nbsp;&nbsp;</td><td><input type="text" name="admin_url" size="50"  value="<?php echo $script_url;?>admin/"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(admin url of the script, without http:// - / at the end is necessary)</td>
</tr>
<tr>
	<td align="right">Site name: &nbsp;&nbsp;</td><td><input type="text" name="site_name" size="30"  value="Site name"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(Your site name, will appear mostly in mail, e.g. Php-jobsite)</td>
</tr>
<tr>
	<td align="right">Site title: &nbsp;&nbsp;</td><td><input type="text" name="site_title" size="30"  value="Site title"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(Your site title, e.g. Php-jobsite)</td>
</tr>
<tr>
	<td align="right">Admin email: &nbsp;&nbsp;</td><td><input type="text" name="site_mail" size="30"  value="office@yourdomain.com"></td>
</tr>
<tr>
	<td align="center" colspan="2" class="info">(Your email address)</td>
</tr>
<TR><TD>&nbsp;</td></tr>
<tr>
	<td align="center" colspan="2"><input type="submit" name="next" class="button" value="Next step"></td>
</tr>
</table>
</form>
<?php
    }
}
else {?>
    <form method="post" action="install.php">
<input type="hidden" name="step" value="agree">
<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
<tr>
	<td align="center" colspan="2" class="license"><b>License Agreement!</b></td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">All use of this program is under strict licence.</td>
</tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">You may not reproduce and/or (re)sell the hole program, or any part of our code without
the written aknowledge from the author of this program, <a href="mailto:php-jobsite@bitmixsoft.com">php-jobsite@bitmixsoft.com</a>.</td>
</tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">However you can change, edit the provided code at your own risk.</td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>

</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
	<td align="center" colspan="2" class="license">enjoy in this release <input type=hidden name="user_agree" value="Y"> </td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
	<td align="center" colspan="2"><input type="submit" name="next" class="button" value="Next"></td>
</tr>
</table>
</form>
<?php
}
?>
</body>
</html>
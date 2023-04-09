<html>
<head>
    <title>MailWorks Professional: Upgrade to ver. 4.0</title>
    <style type="text/css">
    <!--
        body {
            background-color: #EAEAEA;
        }
        
        body, td {
            font-size: x-small;
            font-family: Arial, Helvetica, Verdana, Geneva, sans-serif;
        }

        table {
           margin-bottom: 20px;
        }
        
        .small_font {
            font-size: 0.8 em;
            font-family: inherit;
        }
        
        .setting_description {
            font-size: 0.8 em;
            font-family: Arial, Helvetica, sans-serif;
        }
        
        .row_title {
            background-color: #E1EAF4;
        }
        
        .row_one {
            background-color: #BEC7DC;
        }
        
        .row_two {
            background-color: #DFE3EE;
        }
    -->
    </style>
</head>

<body>

<table width="700" height="100%" border="0" cellspacing="0" cellpadding="10" align="center" bgcolor="#FFFFFF">
<tr>
<td valign="top">
<?php

	include("conf.php");

	function test_file_read($path) {
    global $error_msg;
    global $error_no;
	global $DOCUMENT_ROOT;

    $filename = "conf.php";

    if (@file_exists($filename)) {
        $fp = @fopen($filename, "r");
        
        if ($fp) {
            if ($content = @fread($fp, @filesize($filename))) {
                $error_msg = false;
                $error_no  = false;
                $return    = $content;
            } else {
                $error_msg = "Couldn't read from file.";
                $error_no  = -1;
                $return    = false;
            }
        } else {
            $error_msg = "Couldn't open file. Please ensure that you have CHMOD conf.php to 757 and refresh the page";
            $error_no  = -1;
            $return    = false;
        }
        
        @fclose ($fp);
    } else {
        $error_msg = "File doesn't exist. Please ensure that you have reuploaded conf.php.";
        $error_no  = -1;
    }
    
    return @$return;
}

function test_file_write($path) {
    global $error_msg;
    global $error_no;
	global $DOCUMENT_ROOT;

    $content = test_file_read($path);
    
    $filename = "conf.php";

	@chmod($filename, 757);

    $fp = @fopen($filename, "w");
    
    if ($fp) {
        if ($bytes = @fwrite($fp, $content) >= 1) {
            $error_msg = false;
            $error_no  = false;
            $return    = true;
        } else {
            $error_msg = "Couldn't write to file";
            $error_no  = -1;
            $return    = false;
        }
    } else {
        $error_msg = "Couldn't open file! Please CHMOD the conf.php file to 757";
        $error_no  = -1;
        $return    = false;
    }
    
    @fclose ($fp);
    
    return $return;
}

function test_db_connect($database_host, $database_username, $database_password) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        $error_no  = false;
        $error_msg = false;
        $return    = true;
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_database($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $error_no  = false;
            $error_msg = false;
            $return    = true;
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_create($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        $result = @mysql_query("CREATE DATABASE " . $database_name);
        
        if ($result) {
            $error_no  = false;
            $error_msg = false;
            $return    = true;
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_create_table($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $result = @mysql_query("CREATE TABLE IF NOT EXISTS mwp_test_table (col1 TEXT NOT NULL)");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_insert($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $result = @mysql_query("INSERT INTO mwp_test_table (col1) VALUES ('Some Text')");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_update($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $result = @mysql_query("UPDATE mwp_test_table SET col1='Delete This'");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_delete($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {    
            $result = @mysql_query("DELETE FROM mwp_test_table WHERE col1='Delete This'");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_replace($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $result = @mysql_query("REPLACE INTO mwp_test_table (col1) VALUES ('Delete This')");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function test_db_clean($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $result = @mysql_query("DROP TABLE IF EXISTS mwp_test_table");
            
            if ($result) {
                $error_no  = false;
                $error_msg = false;
                $return    = true;
            } else {
                $error_no  = mysql_errno();
                $error_msg = mysql_error();
                $return    = false;
            }
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    @mysql_close();
    
    return $return;
}

function process_query($query, $database_prefix) {
    global $error_msg;
    global $error_no;
	global $adminUser;
	global $adminPass;
    
   
    $result = @mysql_query($query);
    
    if ($result) {
        
	    $error_no  = false;
        $error_msg = false;
        $return    = true;
	        } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
        }
    
    return $return;
}

function translate_mysql_error($errno) {
    $error_msg[1045] = "Wrong username or password";
    $error_msg[1044] = "You haven't got the right privileges to do that: <b>Please manually create the database and refresh this page</b>";
    $error_msg[1049] = "The database doesn't exist";
    $error_msg[1006] = "Could not create database";
    
    return isset($error_msg[$errno]) ? $error_msg[$errno] : false;
}

function database_connect($database_host, $database_username, $database_password, $database_name) {
    global $error_msg;
    global $error_no;
    global $db;
    
    $db = @mysql_connect($database_host, $database_username, $database_password);
    
    if ($db) {
        if (@mysql_select_db($database_name)) {
            $error_no  = false;
            $error_msg = false;
            $return    = true;
        } else {
            $error_no  = mysql_errno();
            $error_msg = mysql_error();
            $return    = false;
        }
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }
    
    return $return;
}

	$current_page = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;

	switch ($current_page) {
	    case 0:
	    case 1:

			if(@$mwp_ver < '4.0.7') {

				?>

			        <h3>MailWorks Professional Upgrade</h3>

			        <p>Welcome to the MailWorks Professional upgrade setup. You will now be guided 
					through a multi-step upgrade process. If you would like additional help while 
					upgrading MailWorks Professional, then you see MailWorksSetupGuide.pdf
					or if you require, contact MailWorks Professional support.</p>

					<p>This upgrade process will Upgrade MailWorks Professional v4.0.7 to enable it to send emails bigger then 64k. If you are installting 
					for the first time, or plan to use MailWorks Professional Ver 4.0 from a clean 
					database, please use the <a href="install.php">install file</a> to install 
					MailWorks Professional.</p>

					<p>ONLY RUN THIS UPGRADE SCRIPT IF YOU ARE CURRENTLY RUNNING VERSION 4.0.7 OR ABOVE AND WANT TO SEND EMAIL BIGGER THEN 64K</p>

					<p>Please ensure that you backup your conf.php file and your MySQL database before continuing. SiteCubed cannot be
					held responsible for any problems that may occur from running this upgrade script.</p>

					<h3>Web Server Requirements</h3>

					<p>Your server must meet these system requirements to upgrade MailWorks Professional:</p>

					<ul>
						<li><strong>Platform</strong>: Linux/Unix, Windows 2000 or above</li>
						<li><strong>Web Server</strong>: Apache</li>
						<li><strong>Scripting</strong>: PHP v4.1 or above</li>
						<li><strong>Database</strong>: MySQL 3.23 or above</li>
					</ul>

					<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?p=2">Continue »</a></p>

				<?php	

			} else {

				?>

			        <h3>MailWorks Professional Upgrade</h3>

			        <p>MailWorks Professional has detected that you are currently running 4.0.6 or 
					lower. This upgrade script is only for MailWorks Professional users who are 
					running 4.0.7.</p>

				<?php

			}

	        break;

	    case 2:

		$script = $_SERVER["SCRIPT_NAME"]; 
		$nav = preg_replace("/\/mwadmin\/upgrade.php/", "", $script); 

		?>
        
        <h3>MWP Upgrade: Step 1</h3>
        
        <p>Welcome to the first step of the upgade. This page is just to confirm your database details</p>
        
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="p" value="3">
        
        <table width="500" border="0" cellspacing="0" cellpadding="4">
        
	        <tr class="row_title">

		        <td width="100%" valign="middle" align="center" colspan="2">

		            <strong>Database Configuration</strong>

		        </td>

			</tr>
        
			<tr class="row_one">

				<td width="200" valign="top">

            		<strong>Database Name</strong><br>

		            <div class="setting_description">The name of your database. </div>

		        </td>

		        <td width="300">

		            <input type="text" name="database_name" disabled value="<?php echo @$dbName; ?>">

		        </td>

	        </tr>

	        <tr class="row_two">

		        <td width="200" valign="top">

		            <strong>Database Host</strong><br>

		            <div class="setting_description">The host where the database is located.</div>

		        </td>

		        <td width="300" align="left">

	    	        <input type="text" name="database_host" value="<?php echo @$dbServer; ?>" disabled>

		        </td>

			</tr>
        
	        <tr class="row_one">

		        <td width="200" valign="top">

		            <strong>Database Username</strong><br>

		            <div class="setting_description">Your database username.</div>

		        </td>

		        <td width="300">

		            <input type="text" name="database_username" disabled value="<?php echo $dbUser; ?>">

		        </td>

			</tr>
        
	        <tr class="row_two">

		        <td width="200" valign="top">

		            <strong>Database Password</strong><br>

		            <div class="setting_description">Your database password.</div>

		        </td>

		        <td width="300">

		            <input type="password" name="database_password" disabled value="<?php echo $dbPass; ?>">

		        </td>

	        </tr>

        </table>
        
        <input type="submit" value="Continue Upgrade &raquo;">
        
        </form>
        
		<?php

        break;
        
    case 3:
        
?>
        
        <h3>MWP Upgrade: Step 2</h3>
        
        <p>Validating and applying upgrade.</p>
        
<?php   

        echo "<p><strong>General Testing</strong></p>";

		$error_msg = false;        
        
        if (!$error_msg) {
            echo "<p><strong>Testing MySQL Configuration</strong></p>";
        }

        if (!$error_msg) {
            echo "Checking connection... ";
            if (test_db_connect($dbServer, $dbUser, $dbPass)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking database... ";
            if (test_db_database($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
             
           }
        }
        
        if (!$error_msg) {
            echo "Checking CREATE TABLE privilege... ";
            if (test_db_create_table($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking INSERT privilege... ";
            if (test_db_insert($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking REPLACE privilege... ";
            if (test_db_replace($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking UPDATE privilege... ";
            if (test_db_update($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking DELETE privilege... ";
            if (test_db_delete($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Cleaning up the database... ";
            if (test_db_clean($dbServer, $dbUser, $dbPass, $dbName)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
            
            // This isn't critical, so don't halt on failure
            $error_msg = false;
            $error_no  = false;
        }

        
        if ($error_msg) {
            echo "<p><strong>Installation stopped prematurely</strong></p>";
        }
     
?>
        
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="p" value="4">
			<input type="hidden" name="mwp_ver" value="<?php echo $mwp_ver; ?>">
            <input type="hidden" name="dbprefix" value="<?php echo $dbprefix; ?>">
            <input type="hidden" name="site_folder" value="<?php echo $site_folder; ?>">
            <input type="hidden" name="doc_root" value="<?php echo $doc_root; ?>">
            <input type="submit" value="Continue Upgrade &raquo;">     
        </form>
         
<?php   
        
        break;

    case 4:
        
?>
        
        <h3>MWP Installation: Step 3</h3>
        
        <p>Updating database.</p>
        
<?php   

        // Validating and preparing form input

        echo "<p><strong>Upgrade Database Structure</strong></p>";

		database_connect($dbServer, $dbUser, $dbPass, $dbName);

		$error_msg = false;

		$upgrade = array();

		$upgrade['Upgrading Email Content Size'] = "ALTER TABLE `{$dbPrefix}_issues` CHANGE `iContent` `iContent` LONGTEXT DEFAULT NULL";

		foreach($upgrade as $key=>$value)
			{

		        if (!$error_msg) {
		            echo "Processing Query: $key... ";

		            if (process_query($value, $dbprefix)) {
		                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
		            } else {
		                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
		            }

		        }

			}


        
        if ($error_msg) {
            echo "<p><strong>Installation stopped prematurely</strong></p>";
        }
     
?>
        
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="p" value="5">
            <input type="submit" value="Continue Installation &raquo;" <?php if($error_msg) echo "disabled"; ?>>     
        </form>
         
<?php   
        
        break;

	case 5:

	?>

        <h3>MailWorks Professional Upgrade Finished</h3>

        <p>Congratulations! Your copy of MailWorks Professional has now been successfully upgraded to Ver 4.0.7a.</p>

		<p>Before you proceed, you must complete the following:</p>

		<ul>

		<li>Delete 64_upgrade.php from your server, as this presents a security risk.</li>

		</ul>

        Once you are ready, you can <a href="">click here</a> to go to your MailWorks Professional admin area.
        
<?php   
        break;
        
    default;
        
?>
        
        <h3>Page doesn't exist</h3>
        
        <p>I'm sorry, but this page doesn't exist.</p>
        
<?php   

	}

?>
</td>
</tr>
</table>

</body>
</html>
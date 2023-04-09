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

			if(@$mwp_ver < 4.0) {

				?>

			        <h3>MailWorks Professional Upgrade</h3>

			        <p>Welcome to the MailWorks Professional upgrade setup. You will now be guided 
					through a multi-step upgrade process. If you would like additional help while 
					upgrading MailWorks Professional, then you see
					MailWorksSetupGuide.pdf or if you require, contact MailWorks Professional support.</p>

					<p>This upgrade process will Upgrade MailWorks Professional v2 or v3 to the 
					current version of MailWorks Professional (Ver. 4.0). If you are installting 
					for the first time, or plan to use MailWorks Professional Ver 4.0 from a clean 
					database, please use the <a href="install.php">install file</a> to install 
					MailWorks Professional.</p>

					<p>DO NOT RUN THIS UPGRADE SCRIPT IF YOU ARE CURRENTLY RUNNING VERSION 4.0.0 OR ABOVE</p>

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

			        <p>MailWorks Professional has detected that you are currently running 4.0 or 
					greater. This upgrade script is only for MailWorks Professional users who are 
					upgrading from version 2 or 3.</p>

					<p>If you have downloaded a patch for MailWorks Professional Version 4.0 and 
					greater, you do not need to run this upgrade script. Running this script more then once will cause database errors to occur and possibly corrupt data.</p>

				<?php

			}

	        break;

	    case 2:

		$script = $_SERVER["SCRIPT_NAME"]; 
		$nav = preg_replace("/\/mwadmin\/upgrade.php/", "", $script); 

		?>
        
        <h3>MWP Installation: Step 1</h3>
        
        <p>Welcome to the first step of the installation. Before you continue, please ensure 
		that your conf.php file, has NOT been overwritten when you uploaded the new files. 
		If you do not, you will not be able to proceed with the upgrade</p>
        
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="p" value="3">
        
        <table width="500" border="0" cellspacing="0" cellpadding="4">
        
	        <tr class="row_title">

		        <td width="100%" valign="middle" align="center" colspan="2">

		            <strong>Version</strong>

		        </td>

	        </tr>

	        <tr class="row_one">

		        <td width="200" valign="top">

        	    	<strong>Version</strong><br>

	            	<div class="setting_description">Your previous MailWorks version.</b></div>

		        </td>

		        <td width="300">

		            <input type="radio" name="mwp_ver" value="2.0"> Version 2.0

		            <input type="radio" name="mwp_ver" value="3.0" checked> Version 3.0

		        </td>

	        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Path to MailWorks</strong><br>
            <div class="setting_description">The path from your document root, to where the MailWorks folders exist.</div>
        </td>
        <td width="300">
            <input type="text" name="doc_root" value="<?php echo $nav; ?>" size="30">
        </td>
        </tr>

        </table>
        
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
        
			<tr class="row_one">

		        <td width="200" valign="top">

		            <strong>Table Prefix</strong><br>

		            <div class="setting_description">The prefix of your MailWorks Professional tables. For example, if you specify "abc" then the tables will be named "abc_categories", "abc_options", etc.</div>

		        </td>

		        <td width="300">

		            <input type="text" name="database_prefix" value="mwp">

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

        // Validating and preparing form input
        $dbprefix    = isset($_POST['database_prefix']) ? trim($_POST['database_prefix']) : false;
		$mwp_ver	 = isset($_POST['mwp_ver']) ? trim($_POST['mwp_ver']) : false;
        
		$site_folder	= "mwsubscribe";

		$doc_root		= $doc_root[strlen($doc_root) -1] == "/" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;
		$doc_root		= $doc_root[strlen($doc_root) -1] == "\\" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;

        echo "<p><strong>General Testing</strong></p>";
        
        if (empty($dbName) || empty($dbUser) || empty($dbName) ||empty($dbServer) || empty($doc_root)) {
            echo "Checking form input... ";
            echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span>  (You have to fill out all of the fields)<br>";
            $error_msg = true;
        } else {
            echo "Checking form input... ";
            echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            $error_msg = false;
        }

        if (!$error_msg) {
            echo "<p><strong>Testing File Access</strong></p>";
        }

        if (!$error_msg) {
            echo "Checking read access... ";
            if (test_file_read($doc_root)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . $error_msg . ")<br>";
            }
        }
        
        if (!$error_msg) {
            echo "Checking write access... ";
            if (test_file_write($doc_root)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . $error_msg . ")<br>";
            }
        }
        
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
        $dbprefix    = isset($_POST['dbprefix']) ? trim($_POST['dbprefix']) : false;
		$mwp_ver	 = isset($_POST['mwp_ver']) ? trim($_POST['mwp_ver']) : false;
        
		$site_folder	= "mwsubscribe";

		$doc_root		= $doc_root[strlen($doc_root) -1] == "/" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;
		$doc_root		= $doc_root[strlen($doc_root) -1] == "\\" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;

        echo "<p><strong>Upgrade Database Structure</strong></p>";

		database_connect($dbServer, $dbUser, $dbPass, $dbName);

		$error_msg = false;

		$upgrade = array();

		switch($mwp_ver)
			{

				case "2.0";
					$upgrade['Create Tracking Table'] = "CREATE TABLE IF NOT EXISTS track (pk_tId int(14) NOT NULL auto_increment, tEmail varchar(255) NOT NULL default '', tNId int(14) NOT NULL default '0', tDate timestamp(14) NOT NULL, PRIMARY KEY  (pk_tId)) TYPE=MyISAM;";
					$upgrade['Add Track Field to Templates Table'] = "ALTER TABLE  `templates` ADD `nTrack` INT( 2 ) NOT NULL";
					$upgrade['Create Users Table'] = "CREATE TABLE IF NOT EXISTS users ( pk_uId int(14) NOT NULL auto_increment, uUsername varchar(20) NOT NULL default '',  uPassword varchar(255) NOT NULL default '',  uEmail varchar(255) NOT NULL default '',  uFirstName varchar(50) NOT NULL default '',  uLastName varchar(50) NOT NULL default '',  uPermissions text NOT NULL,  uDateCreated timestamp(14) NOT NULL, PRIMARY KEY  (pk_uId)) TYPE=MyISAM;";
					$upgrade['Creating User'] = "INSERT INTO users (`uUsername`, `uPassword`, `uPermissions`, `uFirstName`, `uLastName`, `uEmail`, `uDateCreated`) VALUES ('" . $adminUser . "', '" . md5($adminPass) . "', 'config_view,subscribe_backup,users_view,users_add,users_edit,users_delete,newsletters_view,newsletters_add,newsletters_edit,newsletters_delete,newsletters_template,issues_view,issues_add,issues_send,issues_edit,issues_delete,issues_import,topics_view,topics_add,topics_edit,topics_delete,subscribe_view,subscribe_import,subscribe_export,subscribe_delete,subscribe_custom,stats_view,submit', 'Defult', 'User', 'default@user.c0m', NOW());";

				case "3.0";
					$upgrade['Creating Issue Status Table'] = "CREATE TABLE IF NOT EXISTS `issuestatus` (`pk_isId` INT(18) NOT NULL AUTO_INCREMENT PRIMARY KEY, `isNewsletterId` INT(18) NOT NULL, `isSubscribeId` INT(18) NOT NULL,`isStatus` ENUM('1','0') NOT NULL )TYPE=MyISAM;";
					$upgrade['Create Custom Fields Table'] = "CREATE TABLE  IF NOT EXISTS`customfields` (`pk_cfId` INT(14) NOT NULL AUTO_INCREMENT PRIMARY KEY, `cfTitle` VARCHAR(255) NOT NULL, `cfFieldName` VARCHAR(50) NOT NULL, `cfFieldType` VARCHAR(50) NOT NULL, `cfRequired` ENUM('0','1') NOT NULL, `cfPerTags` ENUM('0','1') NOT NULL, `cfDefaultValue` TEXT NOT NULL, `cfMaxLength` INT(4) NOT NULL, `cfDescription` TEXT NOT NULL, `cfWeight` INT(2) NOT NULL, `cfCreated` TIMESTAMP NOT NULL )TYPE=MyISAM;";
					$upgrade['Add Style Field to Newsletter'] = "ALTER TABLE `newsletters` ADD `nStyle` TEXT NOT NULL;";
					$upgrade['Add StyleType Field to Newsletter'] = "ALTER TABLE `newsletters` ADD `nStyleType` ENUM('ext','int') NOT NULL;";
					$upgrade['Add File Field to Newsletter'] = "ALTER TABLE `newsletters` ADD `nFile` VARCHAR(255) NOT NULL;";
					$upgrade['Rename Newsletters to Issues'] = "ALTER TABLE `newsletters` RENAME `issues`;";
					$upgrade['Rename Templates to Newsletters'] = "ALTER TABLE `templates` RENAME `newsletters`";
					$upgrade['Fix SubscribedUsers table'] = "ALTER TABLE `subscribedUsers` RENAME `subscribedusers`;";
					$upgrade['Add Template Field to Newsletters'] = "ALTER TABLE `newsletters` ADD `nTempFile` VARCHAR(255) NULL;";
					$upgrade['Rename Fields in Issues Table'] = "ALTER TABLE `issues` CHANGE `pk_nId` `pk_iId` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `nName` `iName` VARCHAR(50) DEFAULT NULL, CHANGE `nTitle` `iTitle` VARCHAR(100) DEFAULT NULL, CHANGE `nContent` `iContent` TEXT DEFAULT NULL, CHANGE `nTemplateId` `iNewsletterId` INT(11) DEFAULT NULL, CHANGE `nStatus` `iStatus` ENUM('pending','sent') DEFAULT NULL, CHANGE `nStyle` `iStyle` TEXT NOT NULL, CHANGE `nStyleType` `iStyleType` ENUM('ext','int') DEFAULT 'ext' NOT NULL, CHANGE `nFile` `iFile` VARCHAR(255) NOT NULL ";
					$upgrade['Rename Fields in Track Table'] = "ALTER TABLE `track` CHANGE `tNId` `tIId` INT(14) DEFAULT '0' NOT NULL";
					break;

			} 

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

		//change the order of the subscribed users page

		if(!$error_msg)
			{

		        echo "Processing Query: Re-ordering SubscribedUsers Table... ";

				@mysql_query("CREATE TABLE IF NOT EXISTS {$dbprefix}_subscribedusers (  pk_suId int(11) NOT NULL auto_increment,  suEmail varchar(250) default NULL,  suPassword varchar(70) default NULL,  suStatus enum('pending','subscribed') default NULL,  suDateSubscribed timestamp(14) NOT NULL,  suFName varchar(255) NOT NULL default '',  suLName varchar(255) NOT NULL default '',  PRIMARY KEY  (pk_suId),  FULLTEXT KEY suEmail (suEmail)) TYPE=MyISAM;");

				//This may fail if there is no subscribers
				$query = @mysql_query("INSERT INTO `{$dbName}`.`{$dbprefix}_subscribedusers` SELECT pk_suId, suEmail, suPassword, suStatus, suDateSubscribed, suFName, suLName FROM `{$dbName}`.`subscribedusers` ");

				$query2 = @mysql_query("ALTER TABLE `mwp_subscribedusers` CHANGE `suFName` `su_cust_first_name` VARCHAR( 255 ) NOT NULL ,CHANGE `suLName` `su_cust_last_name` VARCHAR( 255 ) NOT NULL ");

				$query3 = @mysql_query("DROP TABLE `subscribedusers`");

				if($query2 && $query3){
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> <br><br>";
					$error_msg = true;
				}

			}

		if(!$error_msg)
			{

		        echo "Processing Query: Add Custom Field Data... ";

				$query1 = @mysql_query("INSERT INTO customfields VALUES (1, 'First Name', 'first_name', 'textfield', '1', '1', '', 50, 'First Name', 0, now());");
				$query2 = @mysql_query("INSERT INTO customfields VALUES (2, 'Last Name', 'last_name', 'textfield', '1', '1', '', 50, 'Last Name', 0, now());");

				if($query1 && $query2){
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> <br><br>";
					$error_msg = true;
				}

			}


			if (!$error_msg) {
				echo "Processing Query: Prefixing customfields... ";

				if (process_query("ALTER TABLE `customfields` RENAME `{$dbprefix}_customfields` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing issues... ";

				if (process_query("ALTER TABLE `issues` RENAME `{$dbprefix}_issues` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing issuestatus... ";

				if (process_query("ALTER TABLE `issuestatus` RENAME `{$dbprefix}_issuestatus` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing issues... ";

				if (process_query("ALTER TABLE `newsletters` RENAME `{$dbprefix}_newsletters` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing subscriptions... ";

				if (process_query("ALTER TABLE `subscriptions` RENAME `{$dbprefix}_subscriptions` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing issues... ";

				if (process_query("ALTER TABLE `topics` RENAME `{$dbprefix}_topics` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing track... ";

				if (process_query("ALTER TABLE `track` RENAME `{$dbprefix}_track` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

			if (!$error_msg) {
				echo "Processing Query: Prefixing users... ";

				if (process_query("ALTER TABLE `users` RENAME `{$dbprefix}_users` ", $dbprefix)) {
					echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
				} else {
					echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br><br>";
					$error_msg = true;
				}

			}

        if (!$error_msg) {
            echo "<p><strong>Amend Config file</strong></p>";
        }

		// This will add the extra data to the configuration file

        if (!$error_msg) {
            echo "Updating config file... ";

			$handle = fopen('conf.php', 'rb');

			$data = '';

			while(!@feof($handle))
				$data .= fgets($handle, 1024);

			$data = str_replace("?>", "", $data);

			$data .= "\$mwp_ver = '4.0'; \$dbPrefix = '{$_POST['dbprefix']}'; \$siteFolder = '{$_POST['site_folder']}'; \$docRoot = '{$_POST['doc_root']}'; ?>";

			$handle = fopen('conf.php', 'w');

			$write = fwrite($handle, $data);

            if ($write) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . $error_msg . ")<br>";
				$error_msg = true;
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

        <p>Congratulations! Your copy of MailWorks Professional has now been successfully upgraded to Ver 4.0.</p>

		<p>Before you proceed, you must complete the following:</p>

		<ul>

		<li>Delete install.php from your server, as this presents a security risk.</li>

		<li>Delete upgrade.php from your server, as this presents a security risk.</li>

		<li>Configure the user security settings. When you login to MailWorks not all of the new options will show untill you enable them on your user account. (This is not automatically done for security reasons)</li>

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
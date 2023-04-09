<html>
<head>
    <title>MailWorks Professional Installation</title>
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

	$DOCUMENT_ROOT = @$_SERVER['DOCUMENT_ROOT'];

$error_msg = false;
$error_no  = false;

function get_base_dir() {
    // Returns the base directory of the script
    $script_path = dirname(__FILE__);
    $script_path = realpath($script_path);

    return $script_path;
}

function get_base_url() {
    // Returns the base url of the script
    $http_host   = $_SERVER['HTTP_HOST'];
    $script_name = explode("/", $_SERVER['SCRIPT_NAME']);
    $script_path = "";

    // Loop through the array, except for the last entry which is the filename.
    for ($i = 0; $i < count($script_name) - 1; $i++) {
        if (!empty($script_name[$i])) {
            $script_path .= $script_name[$i] . "/";
        } else {
            $script_path .= "/";
        }
    }

	if(substr($script_path, -9) == '/mwadmin/')
		$return = "http://" . $http_host . substr($script_path, 0, -9);
	else
		$return = "http://" . $http_host . $script_path;

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

function translate_mysql_error($errno) {
    $error_msg[1045] = "Wrong username or password";
    $error_msg[1044] = "You haven't got the right privileges to do that: <b>Please manually create the database and refresh this page</b>";
    $error_msg[1049] = "The database doesn't exist";
    $error_msg[1006] = "Could not create database";

    return isset($error_msg[$errno]) ? $error_msg[$errno] : false;
}

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
            $error_msg = "Couldn't open file. Please CHMOD conf.php to 757";
            $error_no  = -1;
            $return    = false;
        }

        @fclose ($fp);
    } else {
        $error_msg = "File doesn't exist. Please ensure that you uploaded the conf.php file into the mwadmin directory.";
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

	@chmod($filename, 0757);

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

function write_config_file($dbname, $dbhost, $dbuser, $dbpass, $dbprefix, $site_url, $admin_email, $site_folder, $doc_root, $site_name) {
    global $error_msg;
    global $error_no;
	global $DOCUMENT_ROOT;

    $content = "";

    $content .= "<?php\n\n";
	$content .= "\t// MailWorks Professional Configuration File\n";
	$content .= "\t// Last Modified: " . date("Y-m-d H:i:s") . "\n";

	$content .= "\t\$isSetup = 1;\n";
	$content .= "\t\$mwp_ver = '4.0';\n\n";

    $content .= "\t// Database Configuration\n";
    $content .= "\t\$dbName 	= '" . $dbname . "'; // Database name\n";
    $content .= "\t\$dbServer 	= '" . $dbhost . "'; // Database host. Most of the time it's 'localhost'\n";
    $content .= "\t\$dbUser 	= '" . $dbuser . "'; // Database username\n";
    $content .= "\t\$dbPass		= '" . $dbpass . "'; // Database password\n";
    $content .= "\t\$dbPrefix	= '" . $dbprefix . "'; // Prefix for tables. Default: 'mwp'\n\n";

	$content .= "\t// Site Details\n";
	$content .= "\t\$siteName 	= '" . $site_name . "'; // Name of the web site\n";
	$content .= "\t\$siteURL 	= '" . $site_url . "'; // Url of the web site\n";
	$content .= "\t\$siteEmail 	= '" . $admin_email . "'; // Email for logging, etc\n";
	$content .= "\t\$siteFolder	= '" . $site_folder . "'; // name for mwsubscribe\n";
	$content .= "\t\$docRoot	= '" . $doc_root . "'; // path to mwadmin and mwsubscribe\n\n";

	$content .= "\t// Templates\n";
	$content .= "\t\$useTemplates = 0; // Allow the front end to use templates\n\n";

	$content .= "\t// Emails\n";
	$content .= "\t\$confirmEmail = 'Hi,\\nYour password to manage your newsletter subscriptions at %%site_name%% has been changed and is shown below:\\n\\nEmail: %%email%%\\nNew Password: %%pass%%\\n\\nPlease visit %%site_url%%/%%sub_folder%%/index.php?what=login to login to your account and update your subscription preferences.\\n\\nThanks,\\nThe %%site_name%% Team\\n%%site_url%%'; // Allow the front end to use templates\n";
	$content .= "\t\$confirmEmailNew = 'Hi %%email%%,\\nYou have been sent this email to confirm your subscription to the %%site_name%% newsletter(s). You MUST click on the link below to confirm your subscription:\\n\\n%%site_url%%/%%sub_folder%%/index.php?what=confirm&suId=%%i%%&cfn=%%c%%\\n\\nThanks,\\nThe %%site_name%% Team\\n%%site_url%%\\n\\n'; // Allow the front end to use templates\n\n";

   	$content .= "?>";

    $filename = "conf.php";
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
        $error_msg = "Couldn't open file. Please ensure that the conf.php file has the correct permissions to write to the file, and refresh the page.";
        $error_no  = -1;
        $return    = false;
    }

    @fclose ($fp);

    return $return;
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

function create_table_customfields($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_customfields";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_customfields (
                    pk_cfId INT(14) NOT NULL AUTO_INCREMENT,
                    cfTitle VARCHAR(255) NOT NULL,
                    cfFieldName VARCHAR(50) NOT NULL,
                    cfFieldType VARCHAR(50) NOT NULL,
                    cfRequired ENUM('0','1') NOT NULL,
                    cfPerTags ENUM('0','1') NOT NULL,
                    cfDefaultValue TEXT NOT NULL,
					cfMaxLength INT(4) NOT NULL,
					cfDescription TEXT NOT NULL,
					cfWeight INT(2) NOT NULL,
					cfCreated TIMESTAMP NOT NULL,
					PRIMARY KEY (pk_cfId)
                  ) TYPE=MyISAM";


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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_issues($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_issues";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_issues (
					pk_iId int(11) NOT NULL auto_increment,
					iName varchar(50) default NULL,
					iTitle varchar(100) default NULL,
					iContent text,
					iNewsletterId int(11) default NULL,
					iStatus enum('pending','sent') default NULL,
					iStyle text NOT NULL,
					iStyleType enum('ext','int') NOT NULL default 'ext',
					iFile varchar(255) NOT NULL default '',
					PRIMARY KEY  (pk_iId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_issuestatus($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_issuestatus";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_issuestatus (
					pk_isId int(18) NOT NULL auto_increment,
					isNewsletterId int(18) NOT NULL default '0',
					isSubscribeId int(18) NOT NULL default '0',
					isStatus enum('1','0') NOT NULL default '1',
					PRIMARY KEY  (pk_isId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_newsletters($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_newsletters";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_newsletters (
					pk_nId int(11) NOT NULL auto_increment,
					nName varchar(50) default NULL,
					nDesc text,
					nTopicId int(11) default NULL,
					nFromEmail varchar(250) default NULL,
					nReplyToEmail varchar(250) default NULL,
					nFrequency1 int(11) default NULL,
					nFrequency2 int(11) default NULL,
					nFormat enum('text','html') default NULL,
					nType enum('public','private') default NULL,
					nTrack int(2) NOT NULL default '0',
					nTempFile VARCHAR(255) NULL,
					PRIMARY KEY  (pk_nId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_subscribedusers($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_subscribedusers";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_subscribedusers (
					pk_suId int(11) NOT NULL auto_increment,
					suEmail varchar(250) default NULL,
					suPassword varchar(70) default NULL,
					suStatus enum('pending','subscribed') default NULL,
					suDateSubscribed timestamp(14) NOT NULL,
					su_cust_first_name varchar(255) NOT NULL default '',
					su_cust_last_name varchar(255) NOT NULL default '',
					PRIMARY KEY  (pk_suId),
					FULLTEXT KEY suEmail (suEmail)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_subscriptions($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_subscriptions";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_subscriptions (
					pk_sId int(11) NOT NULL auto_increment,
					sNewsletterId int(11) default NULL,
					sSubscriberId int(11) default NULL,
					PRIMARY KEY  (pk_sId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_topics($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_topics";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_topics (
					pk_tId int(11) NOT NULL auto_increment,
					tName varchar(50) default NULL,
					PRIMARY KEY  (pk_tId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_track($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_track";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_track (
					pk_tId int(14) NOT NULL auto_increment,
					tEmail varchar(255) NOT NULL default '',
					tIId int(14) NOT NULL default '0',
					tDate timestamp(14) NOT NULL,
					PRIMARY KEY  (pk_tId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function create_table_users($database_prefix) {
    global $error_msg;
    global $error_no;

    $query = "DROP TABLE IF EXISTS " . $database_prefix . "_users";

    $result = @mysql_query($query);

    if ($result) {
        $query = "CREATE TABLE " . $database_prefix . "_users (
					pk_uId int(14) NOT NULL auto_increment,
					uUsername varchar(20) NOT NULL default '',
					uPassword varchar(255) NOT NULL default '',
					uEmail varchar(255) NOT NULL default '',
					uFirstName varchar(50) NOT NULL default '',
					uLastName varchar(50) NOT NULL default '',
					uPermissions text NOT NULL,
					uDateCreated timestamp(14) NOT NULL,
					PRIMARY KEY  (pk_uId)
                  ) TYPE=MyISAM";

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
    } else {
        $error_no  = mysql_errno();
        $error_msg = mysql_error();
        $return    = false;
    }

    return $return;
}

function insert_user($database_prefix, $user_username, $user_password, $user_email, $user_fname, $user_lname) {
    global $error_msg;
    global $error_no;



    $database_prefix = addslashes($database_prefix);
    $user_username   = addslashes($user_username);
    $user_email      = addslashes($user_email);
    $user_fname   = addslashes($user_fname);
    $user_lname   = addslashes($user_lname);
    $user_password   = md5($user_password);

	$permissions  = 'config_view,subscribe_backup,users_view,users_add,users_edit,users_delete,';
	$permissions .= 'newsletters_view,newsletters_add,newsletters_edit,newsletters_delete,newsletters_template,issues_view,';
	$permissions .= 'issues_add,issues_send,issues_edit,issues_delete,issues_import,topics_view,';
	$permissions .= 'topics_add,topics_edit,topics_delete,subscribe_view,subscribe_import,';
	$permissions .= 'subscribe_export,subscribe_delete,subscribe_custom,stats_view,submit';

    $result = @mysql_query("REPLACE INTO " . $database_prefix . "_users
                            (pk_uId, uUsername, uPassword, uEmail, uFirstName, uLastName, uPermissions, uDateCreated)
                            VALUES (1, '$user_username', '$user_password', '$user_email', '$user_fname', '$user_lname', '$permissions', now())");

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

function insert_customfields($database_prefix) {
    global $error_msg;
    global $error_no;

    $database_prefix = addslashes($database_prefix);

    $result = mysql_query("REPLACE INTO " . $database_prefix . "_customfields
							(pk_cfId, cfTitle, cfFieldName, cfFieldType, cfRequired, cfPerTags, cfDefaultValue, cfMaxLength, cfDescription, cfWeight, cfCreated)
							VALUES (1, 'First Name', 'first_name', 'textfield', '1', '1', '', 50, 'First Name', '0', now())");

    $result2 = mysql_query("REPLACE INTO " . $database_prefix . "_customfields
                            (pk_cfId, cfTitle, cfFieldName, cfFieldType, cfRequired, cfPerTags, cfDefaultValue, cfMaxLength, cfDescription, cfWeight, cfCreated)
                            VALUES (2, 'Last Name', 'last_name', 'textfield', '1', '1', '', 50, 'Last Name', 0, now())");

    if ($result && $result2) {
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


$current_page = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;

switch ($current_page) {
    case 0:
    case 1:

?>

        <h3>MailWorks Professional Installation</h3>

        <p>Welcome to the MailWorks Professional installation step. You will now be guided through a multi-step installation process. If you would like additional help while installing and configuring MailWorks Professional,
        then you see MailWorksSetupGuide.pdf.</p>

		<p>This installation process will install MailWorks Professional v4.0. If you are upgrading from a previous version, please use the <a href="upgrade.php">upgrade file</a> to upgrade MailWorks Professional from a previous version.</p>

        <h3>Web Server Requirements</h3>

        <p>Your server must meet these system requirements to install MailWorks Professional:</p>

        <ul>
            <li><strong>Platform</strong>: Linux/Unix, Windows 2000 or Higher</li>
            <li><strong>Web Server</strong>: Apache</li>
            <li><strong>Scripting</strong>: PHP v4.1.0 or above</li>
            <li><strong>Database</strong>: MySQL 3.23 or above</li>
        </ul>

		<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?p=2">Continue »</a></p>

<?php

        break;
    case 2:

        $default_host = ini_get('mysql.default_host');
        $default_host = (!empty($default_host) ? $default_host : 'localhost');

        $site_path = get_base_dir();
        $site_url  = get_base_url();

		$script = $_SERVER["SCRIPT_NAME"];
		$nav = preg_replace("/\/mwadmin\/install.php/", "", $script);

	?>

        <h3>MWP Installation: Step 1</h3>

        <p>Welcome to the first step of the installation.</p>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="part2" onSubmit="if(confirm('This may overwrite tables with the same name if they are located in the \''+document.part2.database_name.value+'\' database. Are you sure you want to continue?')) return true; else return false;">
        <input type="hidden" name="p" value="3">

        <table width="500" border="0" cellspacing="0" cellpadding="4"

        <tr class="row_title">
        <td width="100%" valign="middle" align="center" colspan="2">
            <strong>Basic Configuration</strong>
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Site Name</strong><br>
            <div class="setting_description">The name of your web site.</b></div>
        </td>
        <td width="300">
            <input type="text" name="site_name" value="" size="30">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Base URL</strong><br>
            <div class="setting_description">The address (URL) of your website. This should also be the root path to the mwadmin folder. <b>Do not include a trailing forward slash.</b></div>
        </td>
        <td width="300">
            <input type="text" name="site_url" value="<?php echo $site_url; ?>" size="30">
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Front End Folder</strong><br>
            <div class="setting_description">The name of the folder where your subscribers will sign up. Defaults to mwsubscribe. Will overwrite any existing folder with the same name.</div>
        </td>
        <td width="300">
            <input type="text" name="site_folder" value="mwsubscribe" size="30">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Path to MailWorks</strong><br>
            <div class="setting_description">The path from your document root to your MailWorks folder.</div>
        </td>
        <td width="300">
            <input type="text" name="doc_root" value="<?php echo $nav; ?>" size="30">
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Admin E-Mail</strong><br>
            <div class="setting_description">All e-mails concerning MailWorks and its status will be sent to this address.</div>
        </td>
        <td width="300">
            <input type="text" name="admin_email" size="30">
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
            <div class="setting_description">The name of your MailWorks database. If the database doesn't exist then we will attempt to create it. Note that you must have CREATE DATABASE privileges in MySQL to create the database.</div>
        </td>
        <td width="300">
            <input type="text" name="database_name">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Database Host</strong><br>
            <div class="setting_description">The host where the database is located. In most cases, it is located on 'localhost'.</div>
        </td>
        <td width="300" align="left">
            <input type="text" name="database_host" value="<?php echo $default_host ?>">
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Database Username</strong><br>
            <div class="setting_description">Your database username.</div>
        </td>
        <td width="300">
            <input type="text" name="database_username">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Database Password</strong><br>
            <div class="setting_description">Your database password.</div>
        </td>
        <td width="300">
            <input type="password" name="database_password">
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

        <input type="submit" value="Continue Installation &raquo;">

        </form>

<?php

        break;

    case 3:

?>

        <h3>MWP Installation: Step 2</h3>

        <p>Validating and applying configuration.</p>

<?php

        // Validating and preparing form input
        $dbname      = isset($_POST['database_name']) ? trim($_POST['database_name']) : false;
        $dbhost      = isset($_POST['database_host']) ? trim($_POST['database_host']) : false;
        $dbuser      = isset($_POST['database_username']) ? trim($_POST['database_username']) : false;
        $dbpass      = isset($_POST['database_password']) ? trim($_POST['database_password']) : false;
        $dbprefix    = isset($_POST['database_prefix']) ? trim($_POST['database_prefix']) : false;

		$site_name 	= isset($_POST['site_name']) ? trim($_POST['site_name']) : false;
        $admin_email = isset($_POST['admin_email']) ? trim($_POST['admin_email']) : false;

        $site_url  		= isset($_POST['site_url']) ? trim($_POST['site_url']) : 'mwsubcribe';
        $site_folder  	= isset($_POST['site_folder']) ? trim($_POST['site_folder']) : false;
        $doc_root  		= isset($_POST['doc_root']) ? trim($_POST['doc_root']) : false;

		$site_folder	= $site_folder[strlen($site_folder) -1] == "/" ? substr($site_folder, 0, strlen($site_folder) - 1) : $site_folder;
		$site_folder	= $site_folder[strlen($site_folder) -1] == "\\" ? substr($site_folder, 0, strlen($site_folder) - 1) : $site_folder;

		$doc_root		= $doc_root[strlen($doc_root) -1] == "/" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;
		$doc_root		= $doc_root[strlen($doc_root) -1] == "\\" ? substr($doc_root, 0, strlen($doc_root) - 1) : $doc_root;

		//Set doc_root to / if the file is blank (installing in root)
		$doc_root = ($doc_root == '') ? '/' : $doc_root;

        $site_url  		= $site_url[strlen($site_url) - 1] == "/" ? substr($site_url, 0, strlen($site_url) - 1) : $site_url;
        $site_url  		= $site_url[strlen($site_url) - 1] == "\\" ? substr($site_url, 0, strlen($site_url) - 1) : $site_url;

        if (!$error_msg) {
            echo "<p><strong>General Testing</strong></p>";
        }

        if (empty($dbname) || empty($dbuser) || empty($dbhost) || empty($site_url) || empty($admin_email) || empty($site_name)) {
            echo "Checking form input... ";
            echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span>  (You have to fill out all of the fields)<br>";
            $error_msg = true;
        } else {
            echo "Checking form input... ";
            echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            $error_msg = false;
        }


		if(!is_numeric(strpos($admin_email, "@")) && !is_numeric(strpos($admin_email, "@"))) {
			echo "Checking email input... ";
            echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span>  (The email provided is invalid)<br>";
			$error_msg = true;
		} else {
			echo "Checking email input... ";
			echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
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
            if (test_db_connect($dbhost, $dbuser, $dbpass)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking database... ";
            if (test_db_database($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FFCC00; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";

                echo "&nbsp;&nbsp;&nbsp;&nbsp;Trying to create database... ";
                if (test_db_create($dbhost, $dbuser, $dbpass, $dbname)) {
                    echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
                } else {
                    echo"<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
                }
            }
        }

        if (!$error_msg) {
            echo "Checking CREATE TABLE privilege... ";
            if (test_db_create_table($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking INSERT privilege... ";
            if (test_db_insert($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking REPLACE privilege... ";
            if (test_db_replace($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking UPDATE privilege... ";
            if (test_db_update($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking DELETE privilege... ";
            if (test_db_delete($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Cleaning up the database... ";
            if (test_db_clean($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }

            // This isn't critical, so don't halt on failure
            $error_msg = false;
            $error_no  = false;
        }

        if (!$error_msg) {
            echo "<p><strong>Make Database Structure</strong></p>";
        }

        if (!$error_msg) {
            echo "Opening new database connection... ";
            if (database_connect($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_customfields'... ";
            if (create_table_customfields($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_issues'... ";
            if (create_table_issues($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_issuestatus'... ";
            if (create_table_issuestatus($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_newsletters'... ";
            if (create_table_newsletters($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_subscribedusers'... ";
            if (create_table_subscribedusers($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_subscriptions'... ";
            if (create_table_subscriptions($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_topics'... ";
            if (create_table_topics($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_track'... ";
            if (create_table_track($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }
        if (!$error_msg) {
            echo "Creating table '" . $dbprefix . "_users'... ";
            if (create_table_users($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }


        if (!$error_msg) {
            echo "<p><strong>Renaming Front End folder</strong></p>";
        }

        if ($site_folder == 'mwsubscribe') {
            echo "Changing folder name... ";
            echo "<span style='color: #FFCC00; font-weight: bold;'>SKIPPED</span>  (Folder does not need to be renamed)<br>";
        } else {
            echo "Changing folder name... ";
			if(@rename($DOCUMENT_ROOT . addslashes($doc_root) . "/mwsubscribe/", $DOCUMENT_ROOT . addslashes($doc_root) . "/$site_folder/"))
	            echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
			else
				echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (You will need to manually rename the mwsubscribe folder to <b>$site_folder</b>)<br>";
            $error_msg = false;
        }

        if (!$error_msg) {
            echo "<p><strong>Applying Settings</strong></p>";
        }

        if (!$error_msg) {
            echo "Writing config file... ";
            if (write_config_file($dbname, $dbhost, $dbuser, $dbpass, $dbprefix, $site_url, $admin_email, $site_folder, $doc_root, $site_name)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . $error_msg . ")<br>";
            }
        }

        if ($error_msg) {
            echo "<p><strong>Installation stopped prematurely</strong></p>";
        }

?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="p" value="4">
            <input type="hidden" name="database_name" value="<?php echo $dbname ?>">
            <input type="hidden" name="database_host" value="<?php echo $dbhost ?>">
            <input type="hidden" name="database_username" value="<?php echo $dbuser ?>">
            <input type="hidden" name="database_password" value="<?php echo $dbpass ?>">
            <input type="hidden" name="database_prefix" value="<?php echo $dbprefix ?>">
            <input type="hidden" name="admin_email" value="<?php echo $admin_email ?>">
            <?php if($error_msg) { ?>
				<input onClick="javascript:history.go(-1)" type="button" value="&laquo; Go Back">
            <?php } ?>
            <input type="submit" value="Continue Installation &raquo;" <?php if($error_msg) echo "disabled"; ?>>
        </form>

<?php

        break;

    case 4:

?>

        <h3>MWP Installation: Step 3</h3>

        <p>Now it's time to make an account you can log into.</p>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="p" value="5">
        <input type="hidden" name="database_name" value="<?php echo htmlspecialchars($_POST['database_name']) ?>">
        <input type="hidden" name="database_host" value="<?php echo htmlspecialchars($_POST['database_host']) ?>">
        <input type="hidden" name="database_username" value="<?php echo htmlspecialchars($_POST['database_username']) ?>">
        <input type="hidden" name="database_password" value="<?php echo htmlspecialchars($_POST['database_password']) ?>">
        <input type="hidden" name="database_prefix" value="<?php echo htmlspecialchars($_POST['database_prefix']) ?>">

        <table width="500" border="0" cellspacing="0" cellpadding="4">

        <tr class="row_title">
        <td width="100%" valign="middle" align="center" colspan="2">
            <strong>Create Admin</strong>
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Username</strong><br>
            <div class="setting_description">The username you'd like to have.</div>
        </td>
        <td width="300">
            <input type="text" name="user_username" value="admin">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>Password</strong><br>
            <div class="setting_description">The password you'd like to have.</div>
        </td>
        <td width="300">
            <input name="user_password" type="password">
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Confirm Password</strong><br>
            <div class="setting_description"></div>
        </td>
        <td width="300">
            <input name="user_password_confirm" type="password">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>First Name</strong><br>
        </td>
        <td width="300">
            <input type="text" name="user_fname">
        </td>
        </tr>

        <tr class="row_one">
        <td width="200" valign="top">
            <strong>Last Name</strong><br>
        </td>
        <td width="300">
            <input type="text" name="user_lname">
        </td>
        </tr>

        <tr class="row_two">
        <td width="200" valign="top">
            <strong>E-Mail Address</strong><br>
            <div class="setting_description">Your e-mail address.</div>
        </td>
        <td width="300">
            <input type="text" name="user_email" value="<?php echo @$_POST['admin_email']; ?>">
        </td>
        </tr>

        </table>

        <input type="submit" value="Continue Installation &raquo;">

        </form>

<?php

        break;

    case 5:

		$dbname  		  	= isset($_POST['database_name']) ? trim($_POST['database_name']) : false;
        $dbhost   		 	= isset($_POST['database_host']) ? trim($_POST['database_host']) : false;
        $dbuser   		 	= isset($_POST['database_username']) ? trim($_POST['database_username']) : false;
        $dbpass   		 	= isset($_POST['database_password']) ? trim($_POST['database_password']) : false;
        $dbprefix 		 	= isset($_POST['database_prefix']) ? trim($_POST['database_prefix']) : false;

        $username  			= isset($_POST['user_username']) ? htmlspecialchars(trim($_POST['user_username'])) : false;
        $password  			= isset($_POST['user_password']) ? htmlspecialchars(trim($_POST['user_password'])) : false;
        $password_confirm	= isset($_POST['user_password_confirm']) ? htmlspecialchars(trim($_POST['user_password_confirm'])) : false;
        $fname  			= isset($_POST['user_fname']) ? htmlspecialchars(trim($_POST['user_fname'])) : false;
        $lname  			= isset($_POST['user_lname']) ? htmlspecialchars(trim($_POST['user_lname'])) : false;
        $email  		   	= isset($_POST['user_email']) ? htmlspecialchars(trim($_POST['user_email'])) : false;

?>

        <h3>MWP Installation: Step 4</h3>

        <p>Inserting default data.</p>

<?php

        if (!$error_msg) {
            echo "<p><strong>General Testing</strong></p>";
        }

        if (empty($dbname) || empty($dbuser) || empty($dbhost) || empty($dbprefix) || empty($username) || empty($password) || empty($fname) || empty($lname) || empty($email)) {
            echo "Checking form input... ";
            echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span>  (You have to fill out all of the fields)<br>";
            $error_msg = true;
        } else {
            echo "Checking form input... ";
            echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            $error_msg = false;
        }

		if(!is_numeric(strpos($email, "@")) && !is_numeric(strpos($email, "@"))) {
			echo "Checking email input... ";
            echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span>  (The email provided is invalid)<br>";
				$error_msg = true;
		} else {
			echo "Checking email input... ";
			echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
		}

        if (!$error_msg) {
            echo "<p><strong>Making User Account</strong></p>";
        }

        if (!$error_msg) {
            echo "Opening new database connection... ";
            if (database_connect($dbhost, $dbuser, $dbpass, $dbname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Checking User Details.... ";
            if ($password_confirm == $password) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (The passwords did not match)<br>";
				$error_msg = true;
            }
        }


        if (!$error_msg) {
            echo "Inserting new user... ";
            if (insert_user($dbprefix, $username, $password, $email, $fname, $lname)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if (!$error_msg) {
            echo "Adding Custom Fields... ";
            if (insert_customfields($dbprefix)) {
                echo "<span style='color: #008000; font-weight: bold;'>SUCCESS</span><br>";
            } else {
                echo "<span style='color: #FF0000; font-weight: bold;'>FAILURE</span> (" . (translate_mysql_error($error_no) ? translate_mysql_error($error_no) : $error_no . ": " . $error_msg) . ")<br>";
            }
        }

        if ($error_msg) {
            echo "<p><strong>Installation stopped prematurely</strong></p>";
			echo "<input onClick='javascript:history.go(-1)' type='button' value='&laquo; Go Back'>";
        }

        if(!$error_msg)
        {
        ?>
			<br><input onClick="document.location.href='<?php echo @$_SERVER['PHP_SELF']; ?>?p=6'" type="button" value="Continue Installation &raquo;">
        <?php
        }
        else
        {
        ?>
			<br><input onClick="javascript:history.go(-1)" type="button" value="&laquo; Go Back">
        <?php
        }
        break;

    case 6:

?>

        <h3>MailWorks Professional Installation Finished</h3>

        <p>Congratulations! Your copy of MailWorks Professional has now been successfully installed. The last thing you have to do before you can start using MailWorks Professional is delete the '<em>install.php</em>' file from the mwadmin directory on your web server.</p>
        Once you've deleted the install.php file, you can <a href="">click here</a> to go to the MailWorks Professional admin area.

<?php
        break;

    default;

?>

        <h3>Page doesn't exist</h3>

        <p>I'm sorry, but this page doesn't exist.</p>

<?php

        break;
}

?>

</td>
</tr>
</table>

</body>
</html>
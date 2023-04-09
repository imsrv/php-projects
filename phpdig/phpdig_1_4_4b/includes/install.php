<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/
//PhpDig simple install script : create database and connect script.
$relative_script_path = '..';
$no_connect = 1;
include $relative_script_path.'/includes/config.php';
include $relative_script_path.'/libs/auth.php';

switch ($step)
        {
        case 2:
        //format form datas
        $dbhost = $host;
        if ($port)
            $dbhost .= ":".$port;
        if ($sock)
            $dbhost .= ":".$sock;

        //can i connect with those parameters ?
        if ($id_connect = @mysql_connect ($dbhost,$user,$pass))
            {
            //can i create database ?
            if (@mysql_create_db($dbname,$id_connect))
                {
                mysql_select_db($dbname,$id_connect);
                //are all needed files existent ?
                if (is_file("_connect.php") && is_file("$relative_script_path/sql/init_db.sql") && is_writable("_connect.php"))
                    {
                    $connect_file = @file("_connect.php");
                    $db_file = @file("$relative_script_path/sql/init_db.sql");
                    $f_id = fopen("connect.php","w");
                    while (list($id,$line) = each($connect_file))
                           {
                           $line = eregi_replace("<host>",$dbhost,$line);
                           $line = eregi_replace("<user>",$user,$line);
                           $line = eregi_replace("<pass>",$pass,$line);
                           $line = eregi_replace("<database>",$dbname,$line);
                           fputs($f_id,trim($line)."\n");
                           }
                    fclose($f_id);

                    //parse init_db.sql file
                    while (list($id,$line) = each($db_file))
                           {
                           if (!ereg('^#',$line))
                                $query .= $line;
                           //end of a query
                           if (ereg('\)\;',$line))
                               {
                               $res = mysql_query(trim($query),$id_connect);
                               //table creation failure
                               if ($res < 1)
                                   $error ++;
                               $query = "";
                               }
                           }
                    if ($error)
                        {
                        //clean partial installation
                        @mysql_drop_db($dbname,$id_connect);
                        $error = "Can't create tables";
                        $step = 1;
                        }
                    else
                        header("location:$relative_script_path/admin/");
                    }
                else
                    {
                    $error = "Can't find config database files";
                    @mysql_drop_db($dbname,$id_connect);
                    $step = 1;
                    }
                }
            else
                {
                $error = "Can't create database : $dbname<br>Verify user's rights";
                $step = 1;
                }
            }
        else
            {
            $error = "Can't connect to database<br>Verify connection datas";
            $step = 1;
            }
        break;

        default:
        $step = 1;
        $host = 'localhost';
        $user = 'root';
        $dbname = 'phpdig';
        }
?>
<html>
<head>
<title>PhpDig : Installation</title>
<?
include "style.php";
?>
</head>
<body bgcolor="white">

<img src="../phpdiglogo.gif" width="246" height="77" alt="PhpDig <? print $phpdig_version ?>" border="0">

<P style='background-color:#CCDDFF;'>
The smallest search engine in the universe version <? print $phpdig_version ?>
</P>
<hr>
<h1>Installation</h1>
<br>
<? print $error ?>
<br>
<p class='grey'>
<form method="POST" action="install.php">
<INPUT TYPE="hidden" name="step" value="<? print ($step+1); ?>">
Type here the MySql parameters.<br>Specify a valid existing user who can create databases
<br>
<br>
Hostname  : <INPUT TYPE="text" NAME="host" VALUE="<? print $host ?>">
<br>
Port (none = default) : <INPUT TYPE="text" NAME="port" VALUE="<? print $port ?>">
<br>
Sock (none = default) : <INPUT TYPE="text" NAME="sock" VALUE="<? print $sock ?>">
<br>
User : <INPUT TYPE="text" NAME="user" VALUE="<? print $user ?>">
<br>
Password : <INPUT TYPE="password" NAME="pass" VALUE="<? print $pass ?>">
<br>
PhpDig database : <INPUT TYPE="text" NAME="dbname" VALUE="<? print $dbname ?>">
<br>
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Install phpdig database">
</form>
</p>
</body>
</html>